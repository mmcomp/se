<?php
class attach_type_class{
    public function loadAll($option=TRUE,$inp=-1)
    {
        $out='';
        $my = new mysql_class;
        $my->ex_sql("select * from paper_attach_type order by name", $q);
        if($option)
        {    
            foreach($q as $r)
            {
                $out.='<option '.($inp==(int)$r['id']?'selected="selected"':'' ).' value="'.$r['id'].'" >'.$r['name'].'</option>';
            }
        }
        else
        {
            $out = $q;
        }
        return($out);
    }        
}

