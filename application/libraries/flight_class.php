<?php

class flight_class {

    public $my;
    public $connected = FALSE;
    public $data = array();

    public function __construct($load, $param = array()) {
        $conf = new conf();
        $this->my = new mysqli($conf->local_host, $conf->local_user, $conf->local_pass, $conf->local_db);
        if ($this->my->connect_errno !== FALSE) {
            $this->my->set_charset("utf8");
            $this->connected = TRUE;
            if ($load === TRUE) {
                $werc = array();
                foreach ($param as $key => $value) {
                    if ($key != 'aztarikh' && $key != 'tatarikh' && $key != 'extra' && $key !='airline' && $key != 'sort' && $key != 'way' && $key != 'from_city' && $key != 'to_city') {
                        $werc[] = " `$key` = '$value' ";
                    } 
                    else if ($key == 'aztarikh') {
                        $werc[] = " `fdate` >= '$value' ";
                    } 
                    else if ($key == 'tatarikh') {
                        $werc[] = " `fdate` <= '$value' ";
                    }
                    else if ($key == 'airline')
                    {
                        $werc[] = " `airline` in ('".  implode("','", $value)."') ";
                    }
                    else if($key == 'way')
                    {
                        if($param['way'] == 'one')
                        {
                            $werc[] = " `from_city` = '".$param['from_city']."' and `to_city` = '".$param['to_city']."' and `typ` <> 2 ";
                        }
                        else if($param['way'] == 'two' && $param['to_city']!='' && $param['from_city']!='')
                        {
                            $werc[] = "(( `from_city` = '".$param['to_city']."' and `to_city` = '".$param['from_city']."') or (`from_city` = '".$param['from_city']."' and `to_city` = '".$param['to_city']."'))";
                        }
                    }
                }
                $sort = '';
                if($param['sort']!='all')
                {
                    $sort = ' order by '.$param['sort'];
                }
                $query = "select * from flight " . ((count($werc) > 0) ? " where " . implode(" and ", $werc) : "").$sort;
                if (isset($param['extra'])) {
                    $fields = "`agency_id`, `from_city`, `to_city`, `flight_number`, `flight_id`, `fdate`, `ftime`, `typ` , `capacity`, `class_ghimat`, `class`";
                    $fields_extra = "`airline`, `airplane`, `description`, `extra`, `excurrency`, `extrad`, `price`, `currency`, `public`, `poursant`, `day`, `add_price`, `tax`, `taxd`, `no_public`, `open_price`, `open_price_currency`, `open_price`,`agency_site`,`bfid`,`target_capa`";
                    $query = "select `flight`.`id`,$fields,$fields_extra,`logo_url` from `flight` left join `flight_extra` on (`flight`.`id`=`flight_extra`.`id`) left join `airline` on (`airline`.`name` = `flight_extra`.`airline`) " . ((count($werc) > 0) ? " where " . implode(" and ", $werc) : "").$sort;
                }
                //echo $query;
                $res = $this->my->query($query);
                while ($r = $res->fetch_assoc()) {
                    $r['price'] = (int)((int)$r['price']/10);
                    $this->data[] = $r;
                }
            }
        }
    }

    public function add($agency_id, $in_data, $exec = TRUE) {
        $final_query = '';
        $query = array();
        $query_extra = array();
        $fields = "(`agency_id`, `from_city`, `to_city`, `flight_number`, `flight_id`, `fdate`, `ftime`, `typ` , `capacity`, `class_ghimat`, `class`)";
        $fields_extra = "(`airline`, `airplane`, `description`, `extra`, `excurrency`, `extrad`, `price`, `currency`, `public`, `poursant`, `day`, `add_price`, `tax`, `taxd`, `no_public`, `open_price`, `open_price_currency`)";
        if ($this->connected) {
            //var_dump($in_data);
            for ($i = 0; $i < count($in_data); $i++) {
                $dat = $in_data[$i];
                //echo $dat['flight_number'].' '.$dat['fdate'].' '.$dat['capacity3']."<br/>";
                if ((int) $dat['capacity1'] > 0) {
                    $query[] = "($agency_id,'" . $dat['from_city'] . "','" . $dat['to_city'] . "','" . $dat['flight_number'] . "','" . $dat['flight_id'] . "','" . $dat['fdate'] . "','" . $dat['ftime'] . "','" . $dat['type'] . "','" . $dat['capacity1'] . "','" . $dat['class1'] . "','1')";
                    $query_extra[] = "('" . $dat['airline'] . "','" . $dat['airplane'] . "','" . $dat['description'] . "','" . $dat['extra'] . "','" . $dat['excurrency'] . "','" . $dat['extrad'] . "','" . $dat['price'] . "','" . $dat['currency'] . "','" . $dat['public'] . "','" . $dat['poursant1'] . "','" . $dat['day1'] . "','" . $dat['add_price1'] . "'"
                            . ",'" . $dat['tax1'] . "','" . $dat['taxd1'] . "','" . max(array($dat['best'], $dat['good'], $dat['weak'], $dat['bad'])) . "','" . $dat['open_price'] . "','" . $dat['open_currency'] . "')";
                }
                if ((int) $dat['capacity2'] > 0) {
                    $query[] = "($agency_id,'" . $dat['from_city'] . "','" . $dat['to_city'] . "','" . $dat['flight_number'] . "','" . $dat['flight_id'] . "','" . $dat['fdate'] . "','" . $dat['ftime'] . "','" . $dat['type'] . "','" . $dat['capacity2'] . "','" . $dat['class2'] . "','2')";
                    $query_extra[] = "('" . $dat['airline'] . "','" . $dat['airplane'] . "','" . $dat['description'] . "','" . $dat['extra2'] . "','" . $dat['excurrency2'] . "','" . $dat['extrad'] . "','" . $dat['price2'] . "','" . $dat['currency2'] . "','" . $dat['public2'] . "','" . $dat['poursant2'] . "','" . $dat['day2'] . "','" . $dat['add_price2'] . "'"
                            . ",'" . $dat['tax2'] . "','" . $dat['taxd2'] . "','" . max(array($dat['best2'], $dat['good2'], $dat['weak2'], $dat['bad2'])) . "','" . $dat['open_price2'] . "','" . $dat['open_currency2'] . "')";
                }
                if ((int) $dat['capacity3'] > 0) {
                    $query[] = "($agency_id,'" . $dat['from_city'] . "','" . $dat['to_city'] . "','" . $dat['flight_number'] . "','" . $dat['flight_id'] . "','" . $dat['fdate'] . "','" . $dat['ftime'] . "','" . $dat['type'] . "','" . $dat['capacity3'] . "','" . $dat['class3'] . "','3')";
                    $query_extra[] = "('" . $dat['airline'] . "','" . $dat['airplane'] . "','" . $dat['description'] . "','" . $dat['extra3'] . "','" . $dat['excurrency3'] . "','" . $dat['extrad'] . "','" . $dat['price3'] . "','" . $dat['currency3'] . "','" . $dat['public3'] . "','" . $dat['poursant3'] . "','" . $dat['day3'] . "','" . $dat['add_price3'] . "'"
                            . ",'" . $dat['tax3'] . "','" . $dat['taxd3'] . "','" . max(array($dat['best3'], $dat['good3'], $dat['weak3'], $dat['bad3'])) . "','0','0')";
                }
                if ((int) $dat['capacity5'] > 0) {
                    $query[] = "($agency_id,'" . $dat['from_city'] . "','" . $dat['to_city'] . "','" . $dat['flight_number'] . "','" . $dat['flight_id'] . "','" . $dat['fdate'] . "','" . $dat['ftime'] . "','" . $dat['type'] . "','" . $dat['capacity5'] . "','" . $dat['class5'] . "','5')";
                    $query_extra[] = "('" . $dat['airline'] . "','" . $dat['airplane'] . "','" . $dat['description'] . "','0','0','" . $dat['extrad'] . "','" . $dat['price5'] . "','" . $dat['currency5'] . "','" . $dat['public5'] . "','" . $dat['poursant5'] . "','" . $dat['day5'] . "','" . $dat['add_price5'] . "'"
                            . ",'0','0','" . max(array($dat['best5'], $dat['good5'], $dat['weak5'], $dat['bad5'])) . "','0','0')";
                }
            }
        }
        $final_query = '';
        $final_extra_query = '';
        if (count($query) > 0) {
            if ($exec) {
                $qtmp = array();
                $qetmp = array();
                for ($i = 0; $i < count($query); $i++) {
                    $qtmp[] = $query[$i];
                    $qetmp[] = $query_extra[$i];
                    if (count($qtmp) == 10 || $i == count($query) - 1) {
                        $final_query = 'insert into `flight` ' . $fields . ' values ' . implode(" , ", $qtmp);
                        $final_extra_query = 'insert into `flight_extra` ' . $fields_extra . ' values ' . implode(" , ", $qetmp);
                        $this->my->query($final_query);
                        $this->my->query($final_extra_query);
                    }
                }
            }
            $final_query = 'insert into `flight` ' . $fields . ' values ' . implode(" , ", $query);
            $final_extra_query = 'insert into `flight_extra` ' . $fields_extra . ' values ' . implode(" , ", $query_extra);
            //echo $final_query."<br/>\n";
            //echo $final_extra_query."<br/>\n";
        }
        return(array($final_query, $final_extra_query));
    }

}
