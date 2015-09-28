<?php
    class rookeshi_class{
        public static function get($source_id)
        {
            $out = 0;
            $my = new mysql_class;
            $my->ex_sql("select rookeshi from rookeshi where source_id=$source_id",$q);
            if(isset($q[0]))
            {
                $out = (int)$q[0]['rookeshi'];
            }
            return($out);
        }
    }