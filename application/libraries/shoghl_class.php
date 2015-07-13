<?php
    class shoghl_class
    {
        public function __construct($id=-1)
        {
            if((int)$id > 0)
            {
                $mysql = new mysql_class;
                $mysql->ex_sql("select * from `shoghl` where `id` = $id",$q);
                if(isset($q[0]))
                {
                    $r = $q[0];
                    foreach($r as $k=>$v)
                        $this->$k = $v;
                }
            }
        }
        public function loadAll($option=TRUE,$selected = -1)
        {
            $out = array();
            $selected = (int)$selected;
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `shoghl` order by `name` ",$q);
            foreach($q as $r)
            {
                if($option===FALSE)
                {
                    $tmp = new shoghl_class();
                    foreach($r as $k=>$v)
                        $tmp->$k = $v;                
                    $out[] = $tmp;
                }
                else
                    $out[] = "<option value='".$r['id']."'".(($selected===(int)$r['id'])?" selected":"").">".$r['name']."</option>";
            }
            $output = $out;
            if($option!==FALSE)
            {
                $output = '';
                if(count($out)>0)
                    $output = implode('',$out);
            }
            return($output);
        }
    }
?>
