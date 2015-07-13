<?php
    function dotarafeGen($selected=0)
    {
        $selected = (int)$selected;
        $out = '<option '.(($selected==0)?'selected':'').' value="0">یکطرفه</option>';
        $out .= '<option '.(($selected==1)?'selected':'').' value="1">دوطرفه</option>';
        return($out);
    }
    function smallValidateSelect($p,$name,$zero_ok=FALSE)
    {
        $mmsg = '';
        $min = ($zero_ok)?-1:0;
        foreach($p as $mabda)
        {
            if((int)$mabda<=$min)
            {
                $mmsg = '<div class="alert alert-danger">فیلد '.$name.' می بایست انتخاب شود</div>';
            }
        }
        return($mmsg);
    }
    function loadSel($txt,$selected=0)
    {
        $selected = (int)$selected;
        $out = '<option value="0" '.(($selected==0)?'selected':'').'>'.$txt.' ندارد</option>';
        $out .= '<option value="1" '.(($selected==1)?'selected':'').'>'.$txt.' دارد</option>';
        return($out);
    }
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $red_url = 'profile?factor_id='.$p1;
    $refer = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:'';
    if(strpos($refer,'profile')!==FALSE)
    {
        $red_url = 'khadamat_2/'.$p1;
    }
    factor_class::marhale((int)$p1,'khadamat_1');
    $next_marhale = FALSE;
    $otherError = FALSE;
    $p1=(int)$p1;
    $factor_id = $p1;
    if(trim($p2)=='rmpar')
    {
        $my = new mysql_class;
        $my->ex_sqlx("delete from parvaz where id = ".$_REQUEST['pid']);
        die('ok');
    }
    else if(trim($p2)=='rmhot')
    {
        $my = new mysql_class;
        $my->ex_sqlx("delete from hotel_room where hotel_id = ".$_REQUEST['hid']);
        $my->ex_sqlx("delete from hotel where id = ".$_REQUEST['hid']);
        die('ok');
    }
    else if(trim($p2)=='rmhoo')
    {
        $my = new mysql_class;
        $my->ex_sqlx("delete from hotel_room where id = ".$_REQUEST['oid']);
        die('ok');
    }
    $msg = '';
    $include_types = factor_class::loadTypes($p1);
    if( !in_array('1', $include_types) && !in_array('2', $include_types) && !in_array('3', $include_types))
    {
        redirect($red_url);
    } 
    $this->profile_model->loadUser($user_id);
    $men = $this->profile_model->loadMenu();
    $menu_links = '';
    foreach($men as $title=>$href)
    {
        $tmp = explode('/', $href);
        $active = ($tmp[2]==$page_addr);
        $active2 = TRUE;
        if(isset($tmp[3]) && trim($p1)!='' && $tmp[3]!=$p1)
            $active2 = FALSE;
        $active = ($active & $active2);
        $menu_links .= "<li role='presentation'".(($active)?" class='active'":"")."><a href='$href'>$title</a></li>";
    }
    
    //-------------------------------------------PARVAZ------------------------------------
    $parvaz_header = <<<PHED
        <div class="row hs-border hs-margin-up-down" id="parvaz_header">
            <div class="col-sm-12 hs-btn-default hs-padding hs-border">
                اطلاعات مسیر پروازی
                &nbsp;&nbsp;&nbsp;
                <a class="btn btn-default" href="#" onclick="addPar();"><span class="glyphicon glyphicon-plus" style="color:#000000;font-size: 12px;"></span></a>
                <a class="btn btn-default" href="#" onclick="loadSearch();"><span class="glyphicon glyphicon-search" style="color:#000000;font-size: 12px;"></span></a>
            </div>
        </div>
PHED;
    $parvaz_temp = <<<PTMP
            <div class="hs-border hs-padding row hs-margin-up-down parva_box">
                <div>
                    <span class="glyphicon glyphicon-minus pointer" onclick="removePar(this);"></span>
                    <input type="hidden" name="parvaz[parvaz_id][]" value="#parvaz_id#">
                </div>
                <div class="row">
                    <div class="col-sm-2 hs-padding">
                        <select name="parvaz[mabda_id][]"><option value="-1">مبدا</option>#mabda_id#</select>
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="parvaz[maghsad_id][]"><option value="-1">مقصد</option>#maghsad_id#</select>
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="parvaz[dotarafe][]" style="width:100px;" onchange="dotarafeChange(this);">#dotarafe#</select>
                    </div>                
                    <div class="col-sm-2 hs-padding">
                        <select name="parvaz[adl][]" style="width:100px;"><option value="-1">بزرگسال</option>#adl#</select>
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="parvaz[chd][]" style="width:100px;"><option value="-1">کودک</option>#chd#</select>
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="parvaz[inf][]" style="width:100px;"><option value="-1">نوزاد</option>#inf#</select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-2 hs-padding">
                        <input type="text" name="parvaz[tarikh][]" class="form-control dateValue2" value="#tarikh#" placeholder="تاریخ" />
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="parvaz[airline][]" class="form-control"><option value="-1">ایرلاین</option>#airline#</select>
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <input type="text" name="parvaz[class][]" class="form-control" value="#class#"  placeholder="کلاس پروازی" />
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <input type="text" name="parvaz[flight_number][]" class="form-control" value="#flight_number#"  placeholder="شماره پرواز" />
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <input type="text" name="parvaz[havapeima][]" class="form-control" value="#havapeima#"  placeholder="هواپیما" />
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-1 hs-padding">
                        خروج : 
                    </div>
                    <div class="col-sm-1 hs-padding" style="text-align:left;">
                        <select name="parvaz[khorooj_daghighe][]" >#khorooj_daghighe#</select>
                    </div>
                    <div class="col-sm-1 hs-padding" style="width:2px;">
                        :
                    </div>
                    <div class="col-sm-1 hs-padding">
                        <select name="parvaz[khorooj_saat][]">#khorooj_saat#</select>
                    </div>                

                    <div class="col-sm-1 hs-padding">
                        ورود :‌
                    </div>
                    <div class="col-sm-1 hs-padding" style="text-align:left;">
                        <select name="parvaz[vorood_daghighe][]" >#vorood_daghighe#</select>
                    </div>
                    <div class="col-sm-1 hs-padding" style="width:2px;">
                        :
                    </div>
                    <div class="col-sm-1 hs-padding">
                        <select name="parvaz[vorood_saat][]">#vorood_saat#</select>
                    </div>                

                </div>
            </div>
PTMP;
    $parvaz_det = array(
        "parvaz_id" => -1,
        "mabda_id" => -1,
        "maghsad_id" => -1,
        "tarikh" => '',
        "adl" => -1,
        "chd" => -1,
        "inf" => -1,
        "dotarafe" => 0,
        "airline" => -1,
        "class" => '',
        "flight_number" => '',
        "havapeima" => '',
        "khorooj_saat" => '00',
        "khorooj_daghighe" => '00',
        "vorood_saat" => '00',
        "vorood_daghighe" => '00'
    );
    $parvaz = array();
    if(isset($_REQUEST['parvaz']))
    {
        $next_marhale = TRUE;
        $p = $_REQUEST['parvaz'];
        for($i = 0;$i < count($p['mabda_id']);$i++)
        {
            $parvaz[] = $parvaz_det;
        }

        foreach($p as $key => $vals)
        {
            for($i = 0;$i < count($vals);$i++)
            {
                $parvaz[$i][$key] = $vals[$i];
            }
        }
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('parvaz[tarikh][]','تاریخ','required|min_length[8]|max_length[10]');
        $this->form_validation->set_rules('parvaz[flight_number][]','شماره پرواز','required|min_length[3]');
        $this->form_validation->set_rules('parvaz[class][]','کلاس پرواز','required|min_length[1]');
        $this->form_validation->set_rules('parvaz[havapeima][]','هواپیما','required|min_length[3]');
        $msg .= smallValidateSelect($p['mabda_id'],'مبدا');
        $msg .= smallValidateSelect($p['maghsad_id'],'مقصد');
        $msg .= smallValidateSelect($p['airline'],'ایرلاین');
        $msg .= smallValidateSelect($p['adl'],'بزرگسال ');
        $msg .= smallValidateSelect($p['chd'],'کودک ',TRUE);
        $msg .= smallValidateSelect($p['inf'],'نوزاد ',TRUE);
        $otherError = (trim($msg)!=='');
        if($this->form_validation->run()==FALSE || $otherError)
        {
            $next_marhale = FALSE;
        }
        else
        {
            $my = new mysql_class;
            $my->ex_sql("select khadamat_factor.id from khadamat_factor left join khadamat on (khadamat_id=khadamat.id) where factor_id = $factor_id and (typ = 1 or typ = 3)", $q);
            if(isset($q[0]))
            {
                //$parvaz_db = $parvaz_det;
                foreach($parvaz as $p_index=>$parvaz_db)
                {
                    $parvaz_db['tarikh'] = $this->inc_model->jalaliToMiladi($parvaz_db['tarikh']);
                    $parvaz_db['saat'] = $parvaz_db['khorooj_saat'].':'.$parvaz_db['khorooj_daghighe'];
                    $parvaz_db['saat_vorood'] = $parvaz_db['vorood_saat'].':'.$parvaz_db['vorood_daghighe'];
                    unset($parvaz_db['khorooj_saat']);
                    unset($parvaz_db['khorooj_daghighe']);
                    unset($parvaz_db['vorood_saat']);
                    unset($parvaz_db['vorood_daghighe']);
                    $parvaz_db['is_bargasht'] = ($parvaz_db['dotarafe']==TRUE)?1:0;
                    unset($parvaz_db['dotarafe']);
                    $parvaz_db['class_parvaz'] = $parvaz_db['class'];
                    unset($parvaz_db['class']);
                    $parvaz_db['airplain'] = $parvaz_db['havapeima'];
                    unset($parvaz_db['havapeima']);
                    $parvaz_db['shomare'] = $parvaz_db['flight_number'];
                    unset($parvaz_db['flight_number']);
                    $parvaz_db['factor_id'] = $factor_id;
                    $parvaz_db['khadamat_factor_id'] = $q[0]['id'];
                    $par_id = parvaz_class::add($parvaz_db);
                    if((int)$parvaz_db['parvaz_id']<=0)
                    {
                        $parvaz[$p_index]['parvaz_id'] = (int)$par_id;
                    }
                }
            }
        }
    }
    else
    {
        if(in_array('1', $include_types) || in_array('3', $include_types))
        {
            //$parvaz = array($parvaz_det);
            $par_tmp = parvaz_class::loadByFactor_id($factor_id);
            foreach($par_tmp as $p_tmp)
            {
                $parpar = $parvaz_det;
                $parpar['parvaz_id'] = (int)$p_tmp['id'];
                $parpar['mabda_id'] = (int)$p_tmp['mabda_id'];
                $parpar['maghsad_id'] = (int)$p_tmp['maghsad_id'];
                $parpar['tarikh'] = $this->inc_model->perToEnNums(jdate("d/m/Y",strtotime($p_tmp['tarikh'])));
                $parpar['adl'] = (int)$p_tmp['adl'];
                $parpar['chd'] = (int)$p_tmp['chd'];
                $parpar['inf'] = (int)$p_tmp['inf'];
                $parpar['dotarafe'] = ((int)$p_tmp['is_bargasht']==1);
                $parpar['airline'] = (int)$p_tmp['airline'];
                $parpar['class'] = $p_tmp['class_parvaz'];
                $parpar['flight_number'] = $p_tmp['shomare'];
                $parpar['havapeima'] = $p_tmp['airplain'];
                $parpar['khorooj_saat'] = date("H",strtotime($p_tmp['saat']));
                $parpar['khorooj_daghighe'] = date("i",strtotime($p_tmp['saat']));
                $parpar['vorood_saat'] = date("H",strtotime($p_tmp['saat_vorood']));
                $parpar['vorood_daghighe'] = date("i",strtotime($p_tmp['saat_vorood']));
                $parvaz[] = $parpar;
            }
            if(count($parvaz)==0)
            {
                $parvaz = array($parvaz_det);
            }
        }
    }
    $parvazs = '';
    $parvaz_tmp1 = '';
    if(in_array('1', $include_types) || in_array('3', $include_types))
    {
        $parvazs = $parvaz_header;
        $parvaz_tmp1 = str_replace("#mabda_id#",city_class::loadAll(),$parvaz_temp);
        $parvaz_tmp1 = str_replace("#parvaz_id#","-1",$parvaz_tmp1);
        $parvaz_tmp1 = str_replace("#maghsad_id#",city_class::loadAll(),$parvaz_tmp1);
        $parvaz_tmp1 = str_replace("#tarikh#",'',$parvaz_tmp1);
        $parvaz_tmp1 = str_replace("#adl#",$this->inc_model->generateOption(9,1,1),$parvaz_tmp1);
        $parvaz_tmp1 = str_replace("#chd#",$this->inc_model->generateOption(9,0,1),$parvaz_tmp1);
        $parvaz_tmp1 = str_replace("#inf#",$this->inc_model->generateOption(9,0,1),$parvaz_tmp1);
        $parvaz_tmp1 = str_replace("#dotarafe#",dotarafeGen(),$parvaz_tmp1);
        $parvaz_tmp1 = str_replace("#airline#",airline_class::loadAll(),$parvaz_tmp1);
        $parvaz_tmp1 = str_replace("#class#",'',$parvaz_tmp1);
        $parvaz_tmp1 = str_replace("#flight_number#",'',$parvaz_tmp1);
        $parvaz_tmp1 = str_replace("#havapeima#",'',$parvaz_tmp1);
        $parvaz_tmp1 = str_replace("#khorooj_saat#",$this->inc_model->generateOption(23,0,1),$parvaz_tmp1);
        $parvaz_tmp1 = str_replace("#khorooj_daghighe#",$this->inc_model->generateOption(59,0,1),$parvaz_tmp1);
        $parvaz_tmp1 = str_replace("#vorood_saat#",$this->inc_model->generateOption(23,0,1),$parvaz_tmp1);
        $parvaz_tmp1 = str_replace("#vorood_daghighe#",$this->inc_model->generateOption(23,0,1),$parvaz_tmp1);
        /*
        $parvaz_tmp2 = str_replace("#airline#",airline_class::loadAll(),$parvaz_temp);
        $parvaz_tmp2 = str_replace("#class#",'',$parvaz_tmp2);
        $parvaz_tmp2 = str_replace("#flight_number#",'',$parvaz_tmp2);
        $parvaz_tmp2 = str_replace("#havapeima#",'',$parvaz_tmp2);
        $parvaz_tmp2 = str_replace("#khorooj_saat#",$this->inc_model->generateOption(23,0,1),$parvaz_tmp2);
        $parvaz_tmp2 = str_replace("#khorooj_daghighe#",$this->inc_model->generateOption(59,0,1),$parvaz_tmp2);
        $parvaz_tmp2 = str_replace("#vorood_saat#",$this->inc_model->generateOption(23,0,1),$parvaz_tmp2);
        $parvaz_tmp2 = str_replace("#vorood_daghighe#",$this->inc_model->generateOption(23,0,1),$parvaz_tmp2);
         * 
         */
        for($i = 0;$i < count($parvaz);$i++)
        {
            $parvazak = str_replace("#mabda_id#",city_class::loadAll($parvaz[$i]['mabda_id']),$parvaz_temp);
            $parvazak = str_replace("#parvaz_id#",$parvaz[$i]['parvaz_id'],$parvazak);
            $parvazak = str_replace("#maghsad_id#",city_class::loadAll($parvaz[$i]['maghsad_id']),$parvazak);
            $parvazak = str_replace("#tarikh#",$parvaz[$i]['tarikh'],$parvazak);
            $parvazak = str_replace("#adl#",$this->inc_model->generateOption(9,1,1,$parvaz[$i]['adl']),$parvazak);
            $parvazak = str_replace("#chd#",$this->inc_model->generateOption(9,0,1,$parvaz[$i]['chd']),$parvazak);
            $parvazak = str_replace("#inf#",$this->inc_model->generateOption(9,0,1,$parvaz[$i]['inf']),$parvazak);
            $parvazak = str_replace("#dotarafe#",dotarafeGen($parvaz[$i]['dotarafe']),$parvazak);
            $parvazak = str_replace("#airline#",airline_class::loadAll($parvaz[$i]['airline']),$parvazak);
            $parvazak = str_replace("#class#",$parvaz[$i]['class'],$parvazak);
            $parvazak = str_replace("#flight_number#",$parvaz[$i]['flight_number'],$parvazak);
            $parvazak = str_replace("#havapeima#",$parvaz[$i]['havapeima'],$parvazak);
            $parvazak = str_replace("#khorooj_saat#",$this->inc_model->generateOption(23,0,1,$parvaz[$i]['khorooj_saat']),$parvazak);
            $parvazak = str_replace("#khorooj_daghighe#",$this->inc_model->generateOption(59,0,1,$parvaz[$i]['khorooj_daghighe']),$parvazak);
            $parvazak = str_replace("#vorood_saat#",$this->inc_model->generateOption(23,0,1,$parvaz[$i]['vorood_saat']),$parvazak);
            $parvazak = str_replace("#vorood_daghighe#",$this->inc_model->generateOption(23,0,1,$parvaz[$i]['vorood_daghighe']),$parvazak);
            $parvazs .= $parvazak;
        }
    }
    //--------------------------------------------------------------------------------------------------
    $hotel_header = <<<HOTHED
        <div class="row hs-border hs-margin-up-down" id="hotel_header">
            <div class="col-sm-12 hs-btn-default hs-padding hs-border">
                اطلاعات هتل
                &nbsp;&nbsp;&nbsp;
                <a class="btn btn-default" href="#" onclick="addHot();"><span class="glyphicon glyphicon-plus" style="color:#000000;font-size: 12px;"></span></a>
            </div>
        </div>
HOTHED;
    $hotel_det = <<<HOTDET
        <div class="hs-border hs-padding row hs-margin-up-down hotel_box index_#i#">
            <div>
                <span class="glyphicon glyphicon-minus pointer" onclick="removeHot(this);"></span>
                <input type="hidden" name="hotel[hotel_id][]" value="#hotel_id#" />
            </div>
            <div class="row">
                <div class="col-sm-2 hs-padding">
                    <input type="text" name="hotel[aztarikh][]" class="form-control dateValue2" value="#aztarikh#" placeholder="از تاریخ" />
                </div>
                <div class="col-sm-2 hs-padding">
                    <input type="text" name="hotel[tatarikh][]" class="form-control dateValue2" value="#tatarikh#" placeholder="تا تاریخ" />
                </div>
                <div class="col-sm-3 hs-padding">
                    <select name="hotel[maghsad_id][]" style="width:200px;"><option value="-1">مقصد</option>#maghsad_id#</select>
                </div>
                <div class="col-sm-3 hs-padding">
                    <input type="text" name="hotel[name][]" class="form-control" value="#name#" placeholder="نام هتل" />
                </div>
                <div class="col-sm-2 hs-padding">
                    <select name="hotel[star][]"><option value="-1">ستاره</option>#star#</select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-2 hs-padding">
                    <select name="hotel[adl][]" style="width:100px;"><option value="-1">بزرگسال</option>#adl#</select>
                </div>
                <div class="col-sm-2 hs-padding">
                    <select name="hotel[chd][]" style="width:100px;"><option value="-1">کودک</option>#chd#</select>
                </div>
                <div class="col-sm-2 hs-padding">
                    <select name="hotel[inf][]" style="width:100px;"><option value="-1">نوزاد</option>#inf#</select>
                </div>
            </div>
            <div>
                <span class="glyphicon glyphicon-plus pointer" onclick="addHotRoom(this);"></span>
            </div>
            <div class="row otaghs">
                <div class="row1">
                    <div class="col-sm-4 hs-padding">
                        <input type="text" name="hotel[otagh][#i#][name][]" class="form-control" value="#otagh_name#" placeholder="نام اتاق" />
                        <input type="hidden" name="hotel[otagh][#i#][hotel_room_id][]" value="#hotel_room_id#"/>
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="hotel[otagh][#i#][zarfiat][]" style="width:80px;"><option value="-1">ظرفیت</option>#otagh_zarfiat#</select>
                    </div>
                    <div class="col-sm-3 hs-padding">
                        <select name="hotel[otagh][#i#][service_adl][]" style="width:180px;"><option value="-1">سرویس بزرگسالان</option>#otagh_serviecadl#</select>
                    </div>
                    <div class="col-sm-3 hs-padding">
                        <select name="hotel[otagh][#i#][service_chd][]" style="width:180px;"><option value="-1">سرویس کودکان</option>#otagh_serviecchd#</select>
                    </div>
                </div>
                <div class="row1">
                    <div class="col-sm-2 hs-padding">
                        گشت و ترانسفر و پذیرایی
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="hotel[otagh][#i#][gasht][]"><option value="-1">گشت</option>#otagh_gasht#</select>
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="hotel[otagh][#i#][traft][]"><option value="-1">ت.رفت</option>#otagh_traft#</select>
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="hotel[otagh][#i#][tmiani][]"><option value="-1">ت.میانی</option>#otagh_tmiani#</select>
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="hotel[otagh][#i#][tbargasht][]"><option value="-1">ت.برگشت</option>#otagh_tbargasht#</select>
                    </div>
                    <div class="col-sm-2 hs-padding">
                        <select name="hotel[otagh][#i#][paziraee][]"><option value="-1">پذیرایی</option>#otagh_paziraee#</select>
                    </div>
                </div>
            </div>
        
HOTDET;
    $otagh_det = <<<OTGHD
        <div class="row otaghs">
            <div class="row1">
                <div class="col-sm-1 hs-padding">
                    <span class="glyphicon glyphicon-minus pointer" onclick="removeHotOtagh(this);"></span>
                    <input type="hidden" name="hotel[otagh][#i#][hotel_room_id][]" value="#hotel_room_id#"/>
                </div>
                <div class="col-sm-3 hs-padding">
                    <input type="text" name="hotel[otagh][#i#][name][]" class="form-control" value="#otagh_name#" placeholder="نام اتاق" />
                </div>
                <div class="col-sm-2 hs-padding">
                    <select name="hotel[otagh][#i#][zarfiat][]" style="width:80px;"><option value="-1">ظرفیت</option>#otagh_zarfiat#</select>
                </div>
                <div class="col-sm-3 hs-padding">
                    <select name="hotel[otagh][#i#][service_adl][]" style="width:180px;"><option value="-1">سرویس بزرگسالان</option>#otagh_serviecadl#</select>
                </div>
                <div class="col-sm-3 hs-padding">
                    <select name="hotel[otagh][#i#][service_chd][]" style="width:180px;"><option value="-1">سرویس کودکان</option>#otagh_serviecchd#</select>
                </div>
            </div>
            <div class="row1">
                <div class="col-sm-2 hs-padding">
                    گشت و ترانسفر و پذیرایی
                </div>
                <div class="col-sm-2 hs-padding">
                    <select name="hotel[otagh][#i#][gasht][]"><option value="-1">گشت</option>#otagh_gasht#</select>
                </div>
                <div class="col-sm-2 hs-padding">
                    <select name="hotel[otagh][#i#][traft][]"><option value="-1">ت.رفت</option>#otagh_traft#</select>
                </div>
                <div class="col-sm-2 hs-padding">
                    <select name="hotel[otagh][#i#][tmiani][]"><option value="-1">ت.میانی</option>#otagh_tmiani#</select>
                </div>
                <div class="col-sm-2 hs-padding">
                    <select name="hotel[otagh][#i#][tbargasht][]"><option value="-1">ت.برگشت</option>#otagh_tbargasht#</select>
                </div>
                <div class="col-sm-2 hs-padding">
                    <select name="hotel[otagh][#i#][paziraee][]"><option value="-1">پذیرایی</option>#otagh_paziraee#</select>
                </div>
            </div>
        </div>
OTGHD;
    $hotels = '';
    $otagh_det1 = '';
    $hotel_temp1 = '';
    //var_dump($_REQUEST);
    if(in_array('2', $include_types) || in_array('3', $include_types))
    {
        $rhotel = isset($_REQUEST['hotel'])?$_REQUEST['hotel']:array();
        if(isset($_REQUEST['hotel']))
        {
            if(!isset($_REQUEST['parvaz']))
            {
                $next_marhale = TRUE;
            }
            $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
            $this->form_validation->set_rules('hotel[aztarikh][]','از تاریخ','required|min_length[8]|max_length[10]');
            $this->form_validation->set_rules('hotel[tatarikh][]','تا تاریخ','required|min_length[8]|max_length[10]');
            $this->form_validation->set_rules('hotel[name][]','نام هتل','required|min_length[3]|max_length[50]');
            for($i = 0;$i < count($rhotel['aztarikh']);$i++)
            {
                $this->form_validation->set_rules('hotel[otagh]['.$i.'][name][]','نام اتاق در هتل '.($i+1).' ام','required|min_length[3]|max_length[50]');
                $msg .= smallValidateSelect($rhotel['otagh'][$i]['zarfiat'],'ظرفیت در هتل '.($i+1).' ام');
                $msg .= smallValidateSelect($rhotel['otagh'][$i]['service_adl'],'سرویس بزرگسال در هتل '.($i+1).' ام',TRUE);
                $msg .= smallValidateSelect($rhotel['otagh'][$i]['service_chd'],'سرویس کودکان در هتل '.($i+1).' ام',TRUE);
                $msg .= smallValidateSelect($rhotel['otagh'][$i]['gasht'],'گشت در هتل '.($i+1).' ام',TRUE);
                $msg .= smallValidateSelect($rhotel['otagh'][$i]['traft'],'ت.رفت در هتل '.($i+1).' ام',TRUE);
                $msg .= smallValidateSelect($rhotel['otagh'][$i]['tmiani'],'ت.میانی در هتل '.($i+1).' ام',TRUE);
                $msg .= smallValidateSelect($rhotel['otagh'][$i]['tbargasht'],'ت.برگشت در هتل '.($i+1).' ام',TRUE);
                $msg .= smallValidateSelect($rhotel['otagh'][$i]['paziraee'],'پذیرایی در هتل '.($i+1).' ام',TRUE);
            }
            $msg .= smallValidateSelect($rhotel['maghsad_id'],'مقصد');
            $msg .= smallValidateSelect($rhotel['adl'],'بزرگسال');
            $msg .= smallValidateSelect($rhotel['chd'],'کودک',TRUE);
            $msg .= smallValidateSelect($rhotel['inf'],'نوزاد',TRUE);
            $msg .= smallValidateSelect($rhotel['star'],'ستاره هتل');
            $otherError = (trim($msg)!=='');
            if($this->form_validation->run()==FALSE || $otherError)
            {
                $next_marhale = FALSE;
            }
            else
            {
                $my = new mysql_class;
                $my->ex_sql("select khadamat_factor.id from khadamat_factor left join khadamat on (khadamat_id=khadamat.id) where factor_id = $factor_id and (typ = 2 or typ=3)", $q);
                if(isset($q[0]))
                {
                    //var_dump($rhotel);
                    for($i = 0;$i < count($rhotel['aztarikh']);$i++)
                    {
                        $hotel_obj =array(
                            "hotel_id" => $rhotel['hotel_id'][$i],
                            "az_tarikh" => $this->inc_model->jalaliToMiladi($rhotel['aztarikh'][$i]),
                            "ta_tarikh" => $this->inc_model->jalaliToMiladi($rhotel['tatarikh'][$i]),
                            "maghsad_id" => $rhotel['maghsad_id'][$i],
                            "khadamat_factor_id" => $q[0]['id'],
                            "adl" => $rhotel['adl'][$i],
                            "chd" => $rhotel['chd'][$i],
                            "inf" => $rhotel['inf'][$i],
                            "factor_id" => $factor_id,
                            "name" => $rhotel['name'][$i],
                            "star" => $rhotel['star'][$i],
                            "room_count" => count($rhotel['otagh'][$i]['name'])

                        );
                        $hotel_room = array();
                        $hroom = $rhotel['otagh'][$i];
                        $hotel_id = (int)$hotel_obj['hotel_id'];
                        for($j = 0;$j < count($hroom['name']);$j++)
                        {
                            $hotel_room[] = array(
                                "hotel_khadamat_id" => $hroom['hotel_room_id'][$j],
                                "name" => $hroom['name'][$j],
                                "extra_service" => $hroom['service_adl'][$j],
                                "extra_service_chd" => $hroom['service_chd'][$j],
                                "gasht" => $hroom['gasht'][$j],
                                "transfer_raft" => $hroom['traft'][$j],
                                "transfer_vasat" => $hroom['tmiani'][$j],
                                "transfer_bargasht" => $hroom['tbargasht'][$j],
                                "paziraii" => $hroom['paziraee'][$j],
                                "zarfiat" => $hroom['zarfiat'][$j],
                                "factor_id" => $factor_id,
                                "khadamat_factor_id" => $q[0]['id'],
                                "hotel_id" => $rhotel['hotel_id'][$i]
                            );
                        }
                        //var_dump($hotel_obj);
                        //var_dump($hotel_room);
                        
                        $ho_out = hotel_class::add($hotel_obj, $hotel_room);
                        //var_dump($ho_out);
                        $ho_id = (int)$ho_out['hotel_id'];
                        $ho_rooms = $ho_out['hotel_room_ids'];
                        foreach($ho_rooms as $ands => $ho_room)
                        {
                            $rhotel['otagh'][$i]['hotel_room_id'][$ands] = $ho_room;
                        }
                        if($hotel_id<=0)
                        {
                            $rhotel['hotel_id'][$i] = (int)$ho_id;
                        }
                    }
                }

            }
        }
        else
        {
            $rhotel = array();
            $hotel_dbs = hotel_class::loadByFactor_id($factor_id);
            //var_dump($hotel_dbs);
            foreach($hotel_dbs as $andis=>$hotel_db)
            {
                $rhotel['aztarikh'][] = $this->inc_model->perToEnNums(jdate("d/m/Y",strtotime($hotel_db['hotel']['az_tarikh'])));
                $rhotel['tatarikh'][] = $this->inc_model->perToEnNums(jdate("d/m/Y",strtotime($hotel_db['hotel']['ta_tarikh'])));
                $rhotel['hotel_id'][] = $hotel_db['hotel']['id'];
                $rhotel['maghsad_id'][] = $hotel_db['hotel']['maghsad_id'];
                $rhotel['name'][] = $hotel_db['hotel']['name'];
                $rhotel['star'][] = $hotel_db['hotel']['star'];
                $rhotel['adl'][] = $hotel_db['hotel']['adl'];
                $rhotel['chd'][] = $hotel_db['hotel']['chd'];
                $rhotel['inf'][] = $hotel_db['hotel']['inf'];
                foreach ($hotel_db['hotel_room'] as $hotel_db_room)
                {
                    $rhotel['otagh'][$andis]['name'][] = $hotel_db_room['name'];
                    $rhotel['otagh'][$andis]['hotel_room_id'][] = $hotel_db_room['id'];
                    $rhotel['otagh'][$andis]['zarfiat'][] = $hotel_db_room['zarfiat'];
                    $rhotel['otagh'][$andis]['service_adl'][] = $hotel_db_room['extra_service'];
                    $rhotel['otagh'][$andis]['service_chd'][] = $hotel_db_room['extra_service_chd'];
                    $rhotel['otagh'][$andis]['gasht'][] = $hotel_db_room['gasht'];
                    $rhotel['otagh'][$andis]['traft'][] = $hotel_db_room['transfer_raft'];
                    $rhotel['otagh'][$andis]['tmiani'][] = $hotel_db_room['transfer_vasat'];
                    $rhotel['otagh'][$andis]['tbargasht'][] = $hotel_db_room['transfer_bargasht'];
                    $rhotel['otagh'][$andis]['paziraee'][] = $hotel_db_room['paziraii'];

                }
            }
        }
        $hotels .= $hotel_header;
        $hotel_temp = str_replace("#i#", "0", $hotel_det);
        $hotel_temp = str_replace("#aztarikh#", ((isset($rhotel['aztarikh']))?$rhotel['aztarikh'][0]:''), $hotel_temp);
        $hotel_temp = str_replace("#hotel_id#", ((isset($rhotel['hotel_id']))?$rhotel['hotel_id'][0]:-1), $hotel_temp);
        $hotel_temp = str_replace("#tatarikh#", ((isset($rhotel['tatarikh']))?$rhotel['tatarikh'][0]:''), $hotel_temp);
        $hotel_temp = str_replace("#maghsad_id#", city_class::loadAll(((isset($rhotel['maghsad_id']))?(int)$rhotel['maghsad_id'][0]:-1)), $hotel_temp);
        $hotel_temp = str_replace("#name#", ((isset($rhotel['name']))?$rhotel['name'][0]:''), $hotel_temp);
        $hotel_temp = str_replace("#star#", $this->inc_model->generateOption(5,0,1,((isset($rhotel['star']))?(int)$rhotel['star'][0]:-1)), $hotel_temp);
        $hotel_temp = str_replace("#adl#",$this->inc_model->generateOption(9,1,1,((isset($rhotel['adl']))?(int)$rhotel['adl'][0]:-1)),$hotel_temp);
        $hotel_temp = str_replace("#chd#",$this->inc_model->generateOption(9,0,1,((isset($rhotel['chd']))?(int)$rhotel['chd'][0]:-1)),$hotel_temp);
        $hotel_temp = str_replace("#inf#",$this->inc_model->generateOption(9,0,1,((isset($rhotel['inf']))?(int)$rhotel['inf'][0]:-1)),$hotel_temp);
        $hotel_temp = str_replace("#otagh_name#", ((isset($rhotel['otagh']))?$rhotel['otagh'][0]['name'][0]:''), $hotel_temp);
        $hotel_temp = str_replace("#hotel_room_id#", ((isset($rhotel['otagh']))?$rhotel['otagh'][0]['hotel_room_id'][0]:-1), $hotel_temp);
        $hotel_temp = str_replace("#otagh_zarfiat#", $this->inc_model->generateOption(5,0,1,((isset($rhotel['otagh']))?(int)$rhotel['otagh'][0]['zarfiat'][0]:-1)), $hotel_temp);
        $hotel_temp = str_replace("#otagh_serviecadl#", $this->inc_model->generateOption(5,0,1,((isset($rhotel['otagh']))?(int)$rhotel['otagh'][0]['service_adl'][0]:-1)), $hotel_temp);
        $hotel_temp = str_replace("#otagh_serviecchd#", $this->inc_model->generateOption(5,0,1,((isset($rhotel['otagh']))?(int)$rhotel['otagh'][0]['service_chd'][0]:-1)), $hotel_temp);
        $hotel_temp = str_replace("#otagh_gasht#", loadSel('گشت',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][0]['gasht'][0]:-1)), $hotel_temp);
        $hotel_temp = str_replace("#otagh_traft#", loadSel('ت.رفت',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][0]['traft'][0]:-1)), $hotel_temp);
        $hotel_temp = str_replace("#otagh_tmiani#", loadSel('ت.میانی',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][0]['tmiani'][0]:-1)), $hotel_temp);
        $hotel_temp = str_replace("#otagh_tbargasht#", loadSel('ت.برگشت',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][0]['tbargasht'][0]:-1)), $hotel_temp);
        $hotel_temp = str_replace("#otagh_paziraee#", loadSel('پذیرایی',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][0]['paziraee'][0]:-1)), $hotel_temp);
        $otagh_det1 = str_replace("#otagh_name#", '', $otagh_det);
        $otagh_det1 = str_replace("#hotel_room_id#", -1, $otagh_det1);
        $otagh_det1 = str_replace("#otagh_zarfiat#", $this->inc_model->generateOption(5,0,1), $otagh_det1);
        $otagh_det1 = str_replace("#otagh_serviecadl#", $this->inc_model->generateOption(5,0,1), $otagh_det1);
        $otagh_det1 = str_replace("#otagh_serviecchd#", $this->inc_model->generateOption(5,0,1), $otagh_det1);
        $otagh_det1 = str_replace("#otagh_gasht#", loadSel('گشت',-1), $otagh_det1);
        $otagh_det1 = str_replace("#otagh_traft#", loadSel('ت.رفت',-1), $otagh_det1);
        $otagh_det1 = str_replace("#otagh_tmiani#", loadSel('ت.میانی',-1), $otagh_det1);
        $otagh_det1 = str_replace("#otagh_tbargasht#", loadSel('ت.برگشت',-1), $otagh_det1);
        $otagh_det1 = str_replace("#otagh_paziraee#", loadSel('پذیرایی',-1), $otagh_det1);

        
        $hotel_temp1 = str_replace("#aztarikh#", '', $hotel_det);
        $hotel_temp1 = str_replace("#tatarikh#", '', $hotel_temp1);
        $hotel_temp1 = str_replace("#hotel_id#", -1, $hotel_temp1);
        $hotel_temp1 = str_replace("#maghsad_id#", city_class::loadAll(), $hotel_temp1);
        $hotel_temp1 = str_replace("#name#", '', $hotel_temp1);
        $hotel_temp1 = str_replace("#star#", $this->inc_model->generateOption(5,0,1), $hotel_temp1);
        $hotel_temp1 = str_replace("#adl#",$this->inc_model->generateOption(9,1,1),$hotel_temp1);
        $hotel_temp1 = str_replace("#chd#",$this->inc_model->generateOption(9,0,1),$hotel_temp1);
        $hotel_temp1 = str_replace("#inf#",$this->inc_model->generateOption(9,0,1),$hotel_temp1);
        $hotel_temp1 = str_replace("#otagh_name#", '', $hotel_temp1);
        $hotel_temp1 = str_replace("#hotel_room_id#", -1, $hotel_temp1);
        $hotel_temp1 = str_replace("#otagh_zarfiat#", $this->inc_model->generateOption(5,0,1), $hotel_temp1);
        $hotel_temp1 = str_replace("#otagh_serviecadl#", $this->inc_model->generateOption(5,0,1), $hotel_temp1);
        $hotel_temp1 = str_replace("#otagh_serviecchd#", $this->inc_model->generateOption(5,0,1), $hotel_temp1);
        $hotel_temp1 = str_replace("#otagh_gasht#", loadSel('گشت',-1), $hotel_temp1);
        $hotel_temp1 = str_replace("#otagh_traft#", loadSel('ت.رفت',-1), $hotel_temp1);
        $hotel_temp1 = str_replace("#otagh_tmiani#", loadSel('ت.میانی',-1), $hotel_temp1);
        $hotel_temp1 = str_replace("#otagh_tbargasht#", loadSel('ت.برگشت',-1), $hotel_temp1);
        $hotel_temp1 = str_replace("#otagh_paziraee#", loadSel('پذیرایی',-1), $hotel_temp1);
        $hotels .= $hotel_temp;
        if(isset($rhotel['otagh']))
        {
            $i = 0;
            for($j = 1;$j < count($rhotel['otagh'][$i]['name']);$j++)
            {
                $hotel_temp = str_replace("#otagh_name#", ((isset($rhotel['otagh']))?$rhotel['otagh'][$i]['name'][$j]:''), $otagh_det);
                $hotel_temp = str_replace("#i#", "0", $hotel_temp);
                $hotel_temp = str_replace("#hotel_room_id#", ((isset($rhotel['otagh']))?$rhotel['otagh'][$i]['hotel_room_id'][$j]:-1), $hotel_temp);
                $hotel_temp = str_replace("#otagh_zarfiat#", $this->inc_model->generateOption(5,0,1,((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['zarfiat'][$j]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#otagh_serviecadl#", $this->inc_model->generateOption(5,0,1,((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['service_adl'][$j]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#otagh_serviecchd#", $this->inc_model->generateOption(5,0,1,((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['service_chd'][$j]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#otagh_gasht#", loadSel('گشت',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['gasht'][$j]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#otagh_traft#", loadSel('ت.رفت',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['traft'][$j]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#otagh_tmiani#", loadSel('ت.میانی',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['tmiani'][$j]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#otagh_tbargasht#", loadSel('ت.برگشت',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['tbargasht'][$j]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#otagh_paziraee#", loadSel('پذیرایی',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['paziraee'][$j]:-1)), $hotel_temp);
                $hotels .= $hotel_temp;
            }
        }
        $hotels .= '</div>';
        if(isset($rhotel['aztarikh']))
        {
            for($i = 1;$i < count($rhotel['aztarikh']);$i++)
            {
                $hotel_temp = str_replace("#i#", "$i", $hotel_det);
                $hotel_temp = str_replace("#aztarikh#", ((isset($rhotel['aztarikh']))?$rhotel['aztarikh'][$i]:''), $hotel_temp);
                $hotel_temp = str_replace("#hotel_id#", ((isset($rhotel['hotel_id']))?$rhotel['hotel_id'][$i]:-1), $hotel_temp);
                $hotel_temp = str_replace("#tatarikh#", ((isset($rhotel['tatarikh']))?$rhotel['tatarikh'][$i]:''), $hotel_temp);
                $hotel_temp = str_replace("#maghsad_id#", city_class::loadAll(((isset($rhotel['maghsad_id']))?(int)$rhotel['maghsad_id'][$i]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#name#", ((isset($rhotel['name']))?$rhotel['name'][$i]:''), $hotel_temp);
                $hotel_temp = str_replace("#star#", $this->inc_model->generateOption(5,0,1,((isset($rhotel['star']))?(int)$rhotel['star'][$i]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#adl#",$this->inc_model->generateOption(9,1,1,((isset($rhotel['adl']))?(int)$rhotel['adl'][$i]:-1)),$hotel_temp);
                $hotel_temp = str_replace("#chd#",$this->inc_model->generateOption(9,0,1,((isset($rhotel['chd']))?(int)$rhotel['chd'][$i]:-1)),$hotel_temp);
                $hotel_temp = str_replace("#inf#",$this->inc_model->generateOption(9,0,1,((isset($rhotel['inf']))?(int)$rhotel['inf'][$i]:-1)),$hotel_temp);
                $hotel_temp = str_replace("#otagh_name#", ((isset($rhotel['otagh']))?$rhotel['otagh'][$i]['name'][0]:''), $hotel_temp);
                $hotel_temp = str_replace("#hotel_room_id#", ((isset($rhotel['otagh']))?$rhotel['otagh'][$i]['hotel_room_id'][0]:-1), $hotel_temp);
                $hotel_temp = str_replace("#otagh_zarfiat#", $this->inc_model->generateOption(5,0,1,((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['zarfiat'][0]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#otagh_serviecadl#", $this->inc_model->generateOption(5,0,1,((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['service_adl'][0]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#otagh_serviecchd#", $this->inc_model->generateOption(5,0,1,((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['service_chd'][0]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#otagh_gasht#", loadSel('گشت',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['gasht'][0]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#otagh_traft#", loadSel('ت.رفت',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['traft'][0]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#otagh_tmiani#", loadSel('ت.میانی',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['tmiani'][0]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#otagh_tbargasht#", loadSel('ت.برگشت',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['tbargasht'][0]:-1)), $hotel_temp);
                $hotel_temp = str_replace("#otagh_paziraee#", loadSel('پذیرایی',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['paziraee'][0]:-1)), $hotel_temp);
                $hotels .= $hotel_temp;
                for($j = 1;$j < count($rhotel['otagh'][$i]['name']);$j++)
                {
                    $hotel_temp = str_replace("#otagh_name#", ((isset($rhotel['otagh']))?$rhotel['otagh'][$i]['name'][$j]:''), $otagh_det);
                    $hotel_temp = str_replace("#i#", "$i", $hotel_temp);
                    $hotel_temp = str_replace("#hotel_room_id#", ((isset($rhotel['otagh']))?$rhotel['otagh'][$i]['hotel_room_id'][$j]:-1), $hotel_temp);
                    $hotel_temp = str_replace("#otagh_zarfiat#", $this->inc_model->generateOption(5,0,1,((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['zarfiat'][$j]:-1)), $hotel_temp);
                    $hotel_temp = str_replace("#otagh_serviecadl#", $this->inc_model->generateOption(5,0,1,((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['service_adl'][$j]:-1)), $hotel_temp);
                    $hotel_temp = str_replace("#otagh_serviecchd#", $this->inc_model->generateOption(5,0,1,((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['service_chd'][$j]:-1)), $hotel_temp);
                    $hotel_temp = str_replace("#otagh_gasht#", loadSel('گشت',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['gasht'][$j]:-1)), $hotel_temp);
                    $hotel_temp = str_replace("#otagh_traft#", loadSel('ت.رفت',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['traft'][$j]:-1)), $hotel_temp);
                    $hotel_temp = str_replace("#otagh_tmiani#", loadSel('ت.میانی',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['tmiani'][$j]:-1)), $hotel_temp);
                    $hotel_temp = str_replace("#otagh_tbargasht#", loadSel('ت.برگشت',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['tbargasht'][$j]:-1)), $hotel_temp);
                    $hotel_temp = str_replace("#otagh_paziraee#", loadSel('پذیرایی',((isset($rhotel['otagh']))?(int)$rhotel['otagh'][$i]['paziraee'][$j]:-1)), $hotel_temp);
                    $hotels .= $hotel_temp;
                }
                $hotels .= '</div>';
            }
        }
        
    }
    if($next_marhale)
    {
        redirect('khadamat_2/'.$factor_id);
        //echo "GOGO";
    }
?>
<style>
    .parva_box:nth-child(odd){
        background: #cccccc;
    }
    .hotel_box:nth-child(odd){
        background: #cccccc;
    }
</style>

<div class="row" >
    <div class="col-sm-2" >
        <div class="hs-margin-up-down hs-gray hs-padding hs-border" >
              امکانات
        </div>
        <div class="hs-margin-up-down hs-padding hs-border" >
            <ul class="nav nav-pills nav-stacked">
            <?php
                echo $menu_links;
            ?>
            </ul>
        </div>
    </div>
    <div class="col-sm-10" > 
    <?php
    echo $this->inc_model->loadProgress(1,$p1);
    ?>
    </div>
    <div class="col-sm-10" >
        <?php
            echo validation_errors().$msg;
            echo "<div class='text-center hs-margin-up-down' ><div class='label label-danger' style='font-size:100%' >شماره فاکتور: $p1</div></div>"; 
        ?>
        <form id="frm1_khadamat_1" action="<?php echo site_url().'khadamat_1/'.$p1;  ?>" method="POST">
            <?php echo $parvazs.$hotels; ?>
        </form>
    </div>
        <div class="hs-float-left hs-margin-up-down">
            <a class="btn hs-btn-default btn-lg" onclick="contin()" >
                ادامه
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
        </div>
    <form action="<?php echo site_url(); ?>profile" method="POST" >
        <input type="hidden" name="factor_id" value="<?php echo $p1;  ?>" />
        <div class="hs-float-right hs-margin-up-down">
            <button href="" class="btn hs-btn-default btn-lg" >
                <span class="glyphicon glyphicon-chevron-right"></span>
                مرحله قبل
            </button>
        </div>
    </form>
    </div>
</div>
<script>
    var parvaz_temp = '<?php echo str_replace("\n", "\\\n", $parvaz_tmp1); ?>';
    var hot_room_tmp = '<?php echo str_replace("\n", "\\\n", $otagh_det1); ?>';
    var hot_tmp = '<?php echo str_replace("\n", "\\\n", $hotel_temp1); ?>';
    function contin()
    {
        $("#frm1_khadamat_1").submit();
    }
    function addPar()
    {
        var ptmp = parvaz_temp;
        if($("#hotel_header").length===0)
        {
            $("#frm1_khadamat_1").append(ptmp);
        }
        else
        {
            $("#hotel_header").before(ptmp);
        }
        $('select').select2({
            dir: "rtl"
        });
        $(".dateValue2").datepicker({
            numberOfMonths: 2,
            showButtonPanel: true
        });
    }
    function addHot()
    {
        var sharp_i = $(".hotel_box").length;
        var ptmp = hot_tmp.replace(/#i#/g,sharp_i);;
        $("#frm1_khadamat_1").append(ptmp);
        $('select').select2({
            dir: "rtl"
        });
        $(".dateValue2").datepicker({
            numberOfMonths: 2,
            showButtonPanel: true
        });
    }
    function addHotRoom(dobj)
    {
        var hotbox = $(dobj).parent().parent();
        var cname = hotbox.prop('className');
        var cnames = cname.split(' ');
        console.log(cnames);
        var sharp_i = 0;
        for(var i = 0;i < cnames.length;i++)
        {
            if($.trim(cnames[i]).indexOf('index_')===0)
            {
                sharp_i = parseInt($.trim(cnames[i]).split('_')[1],10);
                console.log('sharp found',sharp_i);
            }
        }
        var hot_room_tmp1 = hot_room_tmp.replace(/#i#/g,sharp_i);
        $(dobj).parent().parent().append(hot_room_tmp1);
        $('select').select2({
            dir: "rtl"
        });
    }
    function removePar(dobj)
    {
        if(confirm('آیا خط پروازی حذف شود؟'))
        {
            var parvaz_id = $(dobj).next().val();
            $(dobj).parent().parent().remove();
            $.get("<?php echo site_url().'khadamat_1/'.$factor_id.'/rmpar/?pid=';?>"+parvaz_id,function(result){
            });
        }
    }
    function removeHotOtagh(dobj)
    {
        if(confirm('آیا اتاق  حذف شود؟'))
        {
            var hotel_room_id = $(dobj).next().val();
            $(dobj).parent().parent().parent().remove();
            $.get("<?php echo site_url().'khadamat_1/'.$factor_id.'/rmhoo/?oid=';?>"+hotel_room_id,function(result){
            });
        }
    }
    function removeHot(dobj)
    {
        if(confirm('آیا هتل  حذف شود؟'))
        {
            var hotel_id = $(dobj).next().val();
            $(dobj).parent().parent().remove();
            $.get("<?php echo site_url().'khadamat_1/'.$factor_id.'/rmhot/?hid=';?>"+hotel_id,function(result){
            });
        }
    }
    var dis_dot = true;
    function dotarafeChange(dobj)
    {
        var obj = $(dobj);
        if(obj.val()==='1' && dis_dot === true)
        {
            var ptmp = parvaz_temp;
            
            //$("#frm1_khadamat_1").append(ptmp);
            var mabda = $(obj.parent().parent().find("select")[0]);
            var maghsad = $(obj.parent().parent().find("select")[1]);
            var dotara = $(obj.parent().parent().find("select")[2]);
            var adl = $(obj.parent().parent().find("select")[3]);
            var chd = $(obj.parent().parent().find("select")[4]);
            var inf = $(obj.parent().parent().find("select")[5]);
            if(!isNaN(parseInt(mabda.val(),10)) && parseInt(mabda.val(),10)>0 && !isNaN(parseInt(maghsad.val(),10)) && parseInt(maghsad.val(),10)>0 && !isNaN(parseInt(adl.val(),10)) && parseInt(adl.val(),10)>0 && !isNaN(parseInt(chd.val(),10)) && parseInt(chd.val(),10)>=0 && !isNaN(parseInt(inf.val(),10)) && parseInt(inf.val(),10)>=0)
            {
                obj.parent().parent().parent().after(ptmp);
                newobj = obj.parent().parent().parent().next();
                $('select').select2({
                    dir: "rtl"
                });
                $(".dateValue2").datepicker({
                    numberOfMonths: 2,
                    showButtonPanel: true
                });
                $(newobj.find("div.row select")[0]).select2("val",maghsad.val());
                $(newobj.find("div.row select")[1]).select2("val",mabda.val());
                dis_dot = false;
                $(newobj.find("div.row select")[2]).select2("val",dotara.val());
                dis_dot = true;
                $(newobj.find("div.row select")[3]).select2("val",adl.val());
                $(newobj.find("div.row select")[4]).select2("val",chd.val());
                $(newobj.find("div.row select")[5]).select2("val",inf.val());
            }
            else
            {
                dotara.select2('val',0);
                alert('لطفا اطلاعات سطر اول را برای ایجاد پرواز برگشت کامل کنید');
            }
        }
    }
    function loadSearch()
    {
        openDialog('جستجوی پرواز',null,'انتخاب','انصراف',function(){});
    }
</script>