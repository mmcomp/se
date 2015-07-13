<?php
class khadamat_tamin_class
{
    public function __construct($id=-1)
    {
        if((int)$id > 0)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `khadamat_tamin` where `id` = $id",$q);
            if(isset($q[0]))
            {
                $r = $q[0];
                foreach($r as $k=>$v)
                    $this->$k = $v;
            }
        }
    }
    public static function loadByKhadamat($inp,$selected=-1)
    {
        $out='';
        $my = new mysql_class;
        $inp = (int)$inp;
        $my->ex_sql("select id,name from khadamat_tamin where khadamat_id=$inp order by name desc", $q);
        foreach($q as $r)
        {
            $out.='<option '.(((int)$selected==(int)$r['id'])?'selected="selected"':'').'  value="'.$r['id'].'" >'.$r['name'].'</option>';
        }
        return ($out);
    }
}

