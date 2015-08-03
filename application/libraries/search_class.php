<?php
    class search_class
    {
        public static function fixDate($inp)
        {
            return($inp);
        }
        public static function search($aztarikh,$tatarikh,$from_city,$to_city,$extra)
        {   
            $out = array("err"=>array("code"=>"1","msg"=>"Unknown ERROR"),"data"=>array());
            $param = array();
            $aztarikh = trim($aztarikh);
            $tatarikh = trim($tatarikh);
            $extra = trim($extra);
            $from_city = trim($from_city);
            $to_city = trim($to_city);
            if($aztarikh!='')
            {
                $param['aztarikh'] = search_class::fixDate($aztarikh);
            }
            if($tatarikh!='')
            {
                $param['tatarikh'] = search_class::fixDate($tatarikh);
            }
            if($extra!='')
            {
                $param['extra'] = $extra;
            }
            if(strlen($from_city)==3 && strlen($to_city)==3)
            {
                $param['from_city'] = $from_city;
                $param['to_city'] = $to_city;
            }
            /*
            else
            {
                $out['err']['code'] = 2;
                $out['err']['msg'] = 'From or To CITY IATA code is not right.';
            }
             * 
             */
            $flight = new flight_class(TRUE,$param);
            $out['data'] = $flight->data;
            $out['err']['code'] = 0;
            $out['err']['msg'] = '';
            return($out);
        }
        function test()
        {
            $query = "select * from city";
            $my = new mysql_class;
            $my->ex_sql($query, $q);
            return($q);
        }
    }