<?php
    class type_class
    {
        public $name = '';
        public function __construct($id=-1)
        {
            if((int)$id > 0)
            {
                $mysql = new mysql_class;
                $mysql->ex_sql("select * from `paper_type` where `id` = $id",$q);
                if(isset($q[0]))
                {
                    $r = $q[0];
                    foreach($r as $k=>$v)
                        $this->$k = $v;
                }
            }
        }
        public static function loadAll($option=TRUE,$id=-1)
        {
            $out = array();
            $id=(int)$id;
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `paper_type`  order by `name`",$q);
            if($option===TRUE)
            {
                $tmp = ''; 
                foreach($q as $u)
                {    
                    $tmp .= "<option value='".$u['id']."'".(($id==$u['id'])?"selected='selected'":"").">".$u['name']."</option>";
                }    
                $out = $tmp;
            }
            else
            {
                foreach($q as $r)
                {    
                    $out[] = array("id"=>(int)$r['id'],"name"=>$r["name"]);
                }    
            }
            return($out);
        }
    }
