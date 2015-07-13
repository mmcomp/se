<?php
class group_class
{
    public function __construct($id=-1)
    {
        if((int)$id > 0)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `grop` where `id` = $id",$q);
            if(isset($q[0]))
            {
                $r = $q[0];
                foreach($r as $k=>$v)
                    $this->$k = $v;
            }
        }
    }
    public static function loadAll($selected=0)
    {
        $out=array();
        $my = new mysql_class;
        //$wer = $country_id==0?'':" where country_id=$country_id";
        $my->ex_sql("select id,name from grop order by name", $q);
        foreach($q as $r)
        {
            $out[$r['id']] = $r['name'];
        }
        //var_dump($out);
        return ($out);
    }   
}
