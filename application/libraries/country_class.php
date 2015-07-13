<?php
class country_class
{
    public function __construct($id=-1)
    {
        if((int)$id > 0)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `country` where `id` = $id",$q);
            if(isset($q[0]))
            {
                $r = $q[0];
                foreach($r as $k=>$v)
                    $this->$k = $v;
            }
        }
    }
    public static function loadAll($selected)
    {
        $out='';
        $my = new mysql_class;
        $my->ex_sql("select id,name from country order by name", $q);
        foreach($q as $r)
        {
            $out.='<option '.($r['id']==$selected ?'selected="selected"':'').' value="'.$r['id'].'" >'.$r['name'].'</option>';
        }
        return ($out);
    }        
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

