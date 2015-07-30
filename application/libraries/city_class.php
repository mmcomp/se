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
        public static function loadAll()
        {
            $out = "";
            $my = new mysql_class;
            $my->ex_sql("select iata,name from city order by name", $q);
            foreach($q as $r)
            {
                $out .= "<option value='".$r['iata']."'>".$r['name']."</option>";
            }
            return($out);
        }
    }

