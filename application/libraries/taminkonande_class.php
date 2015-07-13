<?php
class taminkonande_class extends CI_Model {
    public function __construct($id=-1)
    {
        if((int)$id > 0)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `taminkonande` where `id` = $id",$q);
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
        $out='';
        $my = new mysql_class;
        //$wer = $country_id==0?'':" where country_id=$country_id";
        $my->ex_sql("select id,name from taminkonande order by ordering,name", $q);
        foreach($q as $r)
        {
            $out.='<option '.($selected==$r['id']?'selected="selected"':'').' value="'.$r['id'].'" >'.$r['name'].'</option>';
        }
        return ($out);
    }
    public static function loadView($factor_id)
    {
        $out = '<div><div class="col-sm-2 hs-padding" >\
                    <span class="glyphicon glyphicon-minus-sign" onclick="$(this).parent().parent().remove()" ></span>\
                    <span>\
                        <select onchange="loadKhadamat_tamin(this)" style="width: 80%;" name="khadamat_id[]" >\
                            <option value="-1" >\
                                خدمات انتخاب شده\
                            </option>\
                            '.khadamat_factor_class::loadByfactor($factor_id).'\
                        </select>\
                    </span>\
                    <input type="hidden"  value="" >\
                </div>\
                <div class="col-sm-2 hs-padding" >\
                    <span>\
                        <select name="khadamat_tamin_id[]" style="width: 100%;" >\
                            <option>\
                                خدمات گرفته شده\
                            </option>\
                        </select>\
                    </span>\
                </div>\
                <div class="col-sm-2 hs-padding" >\
                    <select class="sel_2" style="width: 100%;" name="taminkonande_id[]" >\
                        <option value="-1" >انتخاب تأمین کننده</option>\
                        '.taminkonande_class::loadAll().'\
                    </select>\
                </div>\
                <div class="col-sm-4 hs-padding" >\
                    <input value="" class="form-control" type="text" name="mablagh[]" placeholder="قیمت خرید"  >\
                </div>\
                <div class="col-sm-2 hs-padding" >\
                    <span>\
                        <select class="sel_2" style="width: 100%;" name="vahed_mablagh_id[]">\
                            <option>واحد</option>  \
                            '.(vahed_mablagh_class::loadAll()).'\
                        </select>\
                    </span>\
                </div>\
                <div class="col-sm-12 hs-padding" >\
                    <input type="text" placeholder="توضیحات" name="toz[]" class="form-control" value="" >\
                    <input type="hidden" name="tamin_khadamat_id[]" value="-1" >\
                </div></div>';
        return($out);
    }
    public static function add($factor_id,$params)
    {
        $my = new mysql_class;
        $my->ex_sqlx("update tamin_khadamat set en=0 where factor_id=$factor_id");
        //echo "update tamin_khadamat set en=0 where factor_id=$factor_id <br>";
        for($i=0;$i<count($params['khadamat_id']);$i++)
        {
            if((int)$params['tamin_khadamat_id'][$i]==-1)
            {    
                $sql = "insert into tamin_khadamat (factor_id,taminkonande_id,mablagh,vahed_mablagh_id,khadamat_tamin_id,khadamat_id,toz,en) values ('".$factor_id."','".$params['taminkonande_id'][$i]."','".$params['mablagh'][$i]."','".$params['vahed_mablagh_id'][$i]."','".$params['khadamat_tamin_id'][$i]."','".$params['khadamat_id'][$i]."','".$params['toz'][$i]."',1)";
            }
            else
            {
                $sql = "update tamin_khadamat set en=1,taminkonande_id='".$params['taminkonande_id'][$i]."',mablagh='".$params['mablagh'][$i]."',vahed_mablagh_id='".$params['vahed_mablagh_id'][$i]."',khadamat_tamin_id='".$params['khadamat_tamin_id'][$i]."',khadamat_id='".$params['khadamat_id'][$i]."',toz='".$params['toz'][$i]."' where id=".$params['tamin_khadamat_id'][$i];
            }
            $my->ex_sqlx($sql);
        }
        $my->ex_sqlx("delete from tamin_khadamat where en=0 and factor_id=$factor_id");
        return TRUE;
    }
    public static function loadLast($factor_id)
    {
        $my = new mysql_class;
        $my->ex_sql("select * from tamin_khadamat where factor_id=$factor_id", $q);
        $out='';
        foreach($q as $r)
        {
        $out .= '<div><div class="col-sm-2 hs-padding" >
                    <span class="glyphicon glyphicon-minus-sign" onclick="$(this).parent().parent().remove()" ></span>
                    <span>
                        <select onchange="loadKhadamat_tamin(this)" style="width: 80%;" name="khadamat_id[]" >
                            <option value="-1" >
                                خدمات انتخاب شده
                            </option>
                            '.khadamat_factor_class::loadByfactor($factor_id,$r['khadamat_id']).'
                        </select>
                    </span>
                    <input type="hidden"  value="" >
                </div>
                <div class="col-sm-2 hs-padding" >
                    <span>
                        <select name="khadamat_tamin_id[]" style="width: 100%;" >
                            <option>
                                خدمات گرفته شده
                            </option>
                            '.khadamat_tamin_class::loadByKhadamat($r['khadamat_id'], $r['khadamat_tamin_id']).'
                        </select>
                    </span>
                </div>
                <div class="col-sm-2 hs-padding" >
                    <select class="sel_2" style="width: 100%;" name="taminkonande_id[]" >
                        <option value="-1" >انتخاب تأمین کننده</option>
                        '.taminkonande_class::loadAll($r['taminkonande_id']).'
                    </select>
                </div>
                <div class="col-sm-4 hs-padding" >
                    <input value="'.$r['mablagh'].'" class="form-control" type="text" name="mablagh[]" placeholder="قیمت خرید"  >
                </div>
                <div class="col-sm-2 hs-padding" >
                    <span>
                        <select class="sel_2" style="width: 100%;" name="vahed_mablagh_id[]">
                            <option>واحد</option>
                            '.(vahed_mablagh_class::loadAll($r['vahed_mablagh_id'])).'
                        </select>
                    </span>
                </div>
                <div class="col-sm-12 hs-padding" >
                    <input type="text" placeholder="توضیحات" name="toz[]" class="form-control" value="'.$r['toz'].'" >
                    <input type="hidden" name="tamin_khadamat_id[]" value="'.$r['id'].'" > 
                </div></div>';
        }
        return($out);
    }
}

