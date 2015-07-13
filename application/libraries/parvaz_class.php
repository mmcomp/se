<?php
class parvaz_class
{
    public function __construct($id=-1)
    {
        if((int)$id > 0)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `parvaz` where `id` = $id",$q);
            if(isset($q[0]))
            {
                $r = $q[0];
                foreach($r as $k=>$v)
                    $this->$k = $v;
            }
        }
    }    
    public function loadByFactor($id)
    {
        $q = array();
        if((int)$id > 0)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("SELECT mabda.name mab ,maghsad.name mag,tarikh FROM `parvaz` left join city mabda on (mabda.id=mabda_id) left join city maghsad on (maghsad.id=maghsad_id) where `factor_id` = $id",$q);
        }
        return($q);
    }
    public function loadByKhadamatFactor($kfid)
    {
        if((int)$kfid > 0)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `parvaz` where `khadamat_factor_id` = $kfid",$q);
            //echo "select * from `parvaz` where `khadamat_factor_id` = $kfid";
            if(isset($q[0]))
            {
                $r = $q[0];
                foreach($r as $k=>$v)
                    $this->$k = $v;
            }
        }
    }
    public static function add($parvaz)
    {
        $my = new mysql_class;
        $field='';
        $values = '';
        if($parvaz['parvaz_id']<=0)
        {    
            foreach($parvaz as $fi=>$val)
            {
                if($fi!='parvaz_id')
                {    
                    $field.= ($field==''?'':',')."`$fi`";
                    $values.= ($values==''?'':',')."'$val'";
                }
            }
            $qu = "insert into parvaz ($field) values ($values)";
            //echo $qu;
            $ln = $my->ex_sqlx($qu,FALSE);
            $out = $my->insert_id($ln);
            $my->close($ln);
        }
        else
        {
            foreach($parvaz as $fi=>$val)
            {
                if($fi!='parvaz_id')
                {    
                    $field.= ($field==''?'':',')."`$fi`='$val'";
                }
            }
            $qu = "update parvaz set $field where id=".$parvaz['parvaz_id'];
            //echo $qu;
            $out = $my->ex_sqlx($qu);
        }
        //$out='';
        return($out);
    }
    public static function loadKhadamat_factor_id($factor_id)
    {
        $my = new mysql_class;
        $my->ex_sql("select khadamat_factor.id from khadamat_factor left join khadamat on (khadamat.id=khadamat_id)  where factor_id=$factor_id and typ in (1,3)",$q);
        return(count($q)>0?$q[0]['id']:-1);
    }        
    public function loadByFactor_id($factor_id)
    {
        $my = new mysql_class;
        $my->ex_sql("select * from parvaz where factor_id=$factor_id", $q);
        /*
        $out=array();
        foreach($q as $r)
        {
            $tmp = new parvaz_class;
            if((int)$r['is_bargasht']==0)
            {    
                foreach($r as $k=>$v)
                {    
                    $tmp->$k = $v;
                }
                $out['raft'] = $tmp;
            }
            else
            {
                foreach($r as $k=>$v)
                {    
                    $tmp->$k = $v;
                }
                $out['bargasht'] = $tmp;
            }
        }
        return($out);
         * 
         */
        return($q);
    }       
    public static function has_bargasht($factor_id,$khadamat_id)
    {
        $my = new mysql_class;
        $my->ex_sql("select count(parvaz.id) cid from parvaz left join khadamat_factor on (khadamat_factor.id=khadamat_factor_id) where parvaz.factor_id=$factor_id and khadamat_id=$khadamat_id", $q);
        return ((int)$q[0]['cid']==2);
    }        
} 

