<?php
    class city_class{
        public static function loadByIata($iata)
        {
            $out = "";
            $my = new mysql_class;
            $my->ex_sql("select name from city where iata = '$iata'", $q);
            if(isset($q[0]))
            {
                $out = $q[0]['name'];
            }
            return($out);
        }
        public static function loadAll($iata='')
        {
            $iata = strtoupper(trim($iata));
            $out = "";
            $my = new mysql_class;
            $my->ex_sql("select iata,name,en_name from city where iata <> '' order by name", $q);
            foreach($q as $r)
            {
                $out .= "<option value='".$r['iata']."'".(($iata==$r['iata'])?' selected':'').">".$r['name'].'/'.$r['en_name'].'/'.$r['iata']."</option>";
            }
            return($out);
        }
    }

