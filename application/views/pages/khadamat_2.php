<?php
    function perToEnNums($inNum)
    {
        $outp = $inNum;
        $outp = str_replace('۰', '0', $outp);
        $outp = str_replace('۱', '1', $outp);
        $outp = str_replace('۲', '2', $outp);
        $outp = str_replace('۳', '3', $outp);
        $outp = str_replace('۴', '4', $outp);
        $outp = str_replace('۵', '5', $outp);
        $outp = str_replace('۶', '6', $outp);
        $outp = str_replace('۷', '7', $outp);
        $outp = str_replace('۸', '8', $outp);
        $outp = str_replace('۹', '9', $outp);
        return($outp);
    }
    function generateOption($inp,$start,$order,$selected=-1)
    {
        $ou='';
	if($order == 1)
	{
		for($i=$start;$i<=$inp;$i++)
		{
		    $ou.='<option '.($i==$selected?'selected="selected"':'').' value="'.$i.'">'.$i.'</option>';
		}
	}
	else
	{
		for($i=$inp;$i>$start;$i--)
		{
		    $ou.='<option '.($i==$selected?'selected="selected"':'').' value="'.$i.'">'.$i.'</option>';
		}
	} 
        return($ou);
    }
    function createFakeMosafer($adl,$chd,$inf,&$out)
    {
        for($i = 0;$i < $adl;$i++)
        {
            $out[] = array(
                'gender' => 1,
                'age' => 'adl',
                'fname' => '',
                'lname' => '',
                'code_melli' => '',
                'tarikh_tavalod' => '0000-00-00 00:00:00',
                'id' => -1,
                'khadamat_name' => '',
                'passport' => '',
                'ticket_number' => ''
            );
        }
        for($i = 0;$i < $chd;$i++)
        {
            $out[] = array(
                'gender' => 1,
                'age' => 'chd',
                'fname' => '',
                'lname' => '',
                'code_melli' => '',
                'tarikh_tavalod' => '0000-00-00 00:00:00',
                'id' => -1,
                'khadamat_name' => '',
                'passport' => '',
                'ticket_number' => ''
            );
        }
        for($i = 0;$i < $inf;$i++)
        {
            $out[] = array(
                'gender' => 1,
                'age' => 'inf',
                'fname' => '',
                'lname' => '',
                'code_melli' => '',
                'tarikh_tavalod' => '0000-00-00 00:00:00',
                'id' => -1,
                'khadamat_name' => '',
                'passport' => '',
                'ticket_number' => ''
            );
        }
    }
    function generateInputBlock($startStr,$endStr,$midStr,$inp,$factor,$cur_sh_sal,$extra_obj=NULL)
    {
        //echo "inp<br/>\n";
        //var_dump($inp);
        $mob = $factor->mob;
        $email = $factor->email;
        $pdet = '';
        $pindex = 1;
        $cadl=0;
        $cchd = 0;
        $cinf = 0;
        foreach($inp as $ind=>$mo)
        {
            if($mo['age']=='adl' || $mo['age']==NULL)
            {
                $cadl++;
                $inp[$ind]['age'] = 'adl';
            }
            if($mo['age']=='chd')
                $cchd++;
            if($mo['age']=='inf')
                $cinf++;
        }
        if(isset($extra_obj->adl))
            createFakeMosafer((int)$extra_obj->adl-$cadl, (int)$extra_obj->chd-$cchd, (int)$extra_obj->inf-$cinf, $inp);
        //var_dump($inp);
        $khadamat_name = '';
        foreach($inp as $ind=>$mo)
        {
            //var_dump($mo);
            $age = trim($mo['age']);
            $gender_0 = ((int)trim($mo['gender'])==0)?' selected':'';
            $gender_1 = ((int)trim($mo['gender'])==1)?' selected':'';
            $age_adl = '';
            $age_chd = '';
            $age_inf = '';
            if($age=='adl')
            {
                $age_adl = ' selected';
                $age_chd = '';
                $age_inf = '';
            }
            else if($age=='chd')
            {    
                $age_adl = '';
                $age_inf = '';
                $age_chd = ' selected';
            }
            else if($age=='inf')
            {
                $age_adl = '';
                $age_chd = '';
                $age_inf = ' selected';
            }
            $fname = $mo['fname'];
            $lname = $mo['lname'];
            $code_melli = $mo['code_melli'];
            $ptav_rooz = perToEnNums(jdate("d",strtotime($mo['tarikh_tavalod'])));
            $ptav_mah = perToEnNums(jdate("m",strtotime($mo['tarikh_tavalod'])));
            $ptav_sal = perToEnNums(jdate("Y",strtotime($mo['tarikh_tavalod'])));
            $tav_rooz = generateOption(31, 1, 1,$ptav_rooz);
            $tav_mah = generateOption(12, 1, 1,$ptav_mah);
            $tav_sal = generateOption($cur_sh_sal, 1300, -1,$ptav_sal);
            $id = $mo['id'];
            if(trim($khadamat_name)=='' && trim($mo['khadamat_name'])!='')
                $khadamat_name = $mo['khadamat_name'];
            $passport = $mo['passport'];
            $midStr1 = str_replace('#pindex#', $pindex, $midStr);
            $midStr1 = str_replace('#age_adl#', $age_adl, $midStr1);
            $midStr1 = str_replace('#age_chd#', $age_chd, $midStr1);
            $midStr1 = str_replace('#age_inf#', $age_inf, $midStr1);
            $midStr1 = str_replace('#gender_0#', $gender_0, $midStr1);
            $midStr1 = str_replace('#gender_1#', $gender_1, $midStr1);
            $midStr1 = str_replace('#id#', $id, $midStr1);
            $midStr1 = str_replace('#fname#', $fname, $midStr1);
            $midStr1 = str_replace('#lname#', $lname, $midStr1);
            $midStr1 = str_replace('#code_melli#', $code_melli, $midStr1);
            $midStr1 = str_replace('#passport#', $passport, $midStr1);
            $midStr1 = str_replace('#tav_rooz#', $tav_rooz, $midStr1);
            $midStr1 = str_replace('#tav_mah#', $tav_mah, $midStr1);
            $midStr1 = str_replace('#tav_sal#', $tav_sal, $midStr1);
            $midStr1 = str_replace('#ticket_number#', $mo['ticket_number'], $midStr1);
            $pdet .= $midStr1;
            $pindex++;
        }
        $endStr = str_replace('#mob#', $mob, $endStr);
        $endStr = str_replace('#email#', $email, $endStr);
        $startStr = str_replace('#khadamat_name#', $khadamat_name, $startStr);
        $out = $startStr.$pdet.$endStr;
        return($out);

    }
    function dateDif($date1,$date2)
    {
        $dif = strtotime($date1)-strtotime($date2);
        return((int)abs($dif/(24*60*60)));
    }
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    
    //$o = $this->parvaz_model->loadAll("mhd","thr","1394-01-01","1395-01-01",array(724,800));
    //var_dump($o);
    
    $factor_id = -1;
    if(trim($p1)!='')
        $factor_id = (int)$p1;
    factor_class::marhale($factor_id, "khadamat_2");
//----------UPDATING Start--------
    //var_dump($_REQUEST);
    $valid = TRUE;
    if(isset($_REQUEST['parvaz_mosafer_id']))
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('parvaz_fname[]','پرواز : ' . 'نام ', 'required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('parvaz_lname[]', 'پرواز : ' . 'نام خانوادگی ', 'required|min_length[3]|max_length[500]');
        $this->form_validation->set_rules('parvaz_code_melli[]','پرواز : ' .  'کد ملی ', 'required|min_length[10]|max_length[20]');
        $gender = $_REQUEST['parvaz_gender'];
        $sex = $_REQUEST['parvaz_sex'];
        $mosafer_id = $_REQUEST['parvaz_mosafer_id'];
        $fname = $_REQUEST['parvaz_fname'];
        $lname = $_REQUEST['parvaz_lname'];
        $code_melli = $_REQUEST['parvaz_code_melli'];
        $khadamat_factor_id = $_REQUEST['khadamat_factor_id-1'];
        $ticket_number = isset($_REQUEST['ticket_number'])?$_REQUEST['ticket_number']:array();
        if($this->form_validation->run()==FALSE)
        {
            $valid = FALSE;
        }
        else
        {
            if(count($ticket_number)==0)
            {
                for($i = 0;$i < count($mosafer_id);$i++)
                {
                    $ticket_number[] = '';
                }
            }
            foreach ($mosafer_id as $i=>$mosafer_id0)
            {
                $tarikh_tavalod = $this->inc_model->jalaliToMiladi($_REQUEST['parvaz_tarikh_tavalod-sal'][$i].'/'.$_REQUEST['parvaz_tarikh_tavalod-mah'][$i].'/'.$_REQUEST['parvaz_tarikh_tavalod-rooz'][$i]);
                mosafer_class::add($fname[$i], $lname[$i], $code_melli[$i], '', '', $sex[$i], $gender[$i], $tarikh_tavalod, $khadamat_factor_id,$mosafer_id0,$ticket_number[$i]);

            }
        }
    }
    if(isset($_REQUEST['tour_mosafer_id']))
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('tour_fname[]','تور : ' . 'نام ', 'required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('tour_lname[]', 'تور : ' . 'نام خانوادگی ', 'required|min_length[3]|max_length[500]');
        $this->form_validation->set_rules('tour_code_melli[]','تور : ' .  'کد ملی ', 'required|min_length[10]|max_length[20]');
        $gender = $_REQUEST['tour_gender'];
        $sex = $_REQUEST['tour_sex'];
        $mosafer_id = $_REQUEST['tour_mosafer_id'];
        $fname = $_REQUEST['tour_fname'];
        $lname = $_REQUEST['tour_lname'];
        $code_melli = $_REQUEST['tour_code_melli'];
        $khadamat_factor_id = $_REQUEST['khadamat_factor_id-3'];
        $ticket_number = isset($_REQUEST['ticket_number'])?$_REQUEST['ticket_number']:'';
        if($this->form_validation->run()==FALSE)
        {
            $valid = FALSE;
        }
        else
        {
            foreach ($mosafer_id as $i=>$mosafer_id0)
            {
                $tarikh_tavalod = $this->inc_model->jalaliToMiladi($_REQUEST['tour_tarikh_tavalod-sal'][$i].'/'.$_REQUEST['tour_tarikh_tavalod-mah'][$i].'/'.$_REQUEST['tour_tarikh_tavalod-rooz'][$i]);
                mosafer_class::add($fname[$i], $lname[$i], $code_melli[$i], '', '', $sex[$i], $gender[$i], $tarikh_tavalod, $khadamat_factor_id,$mosafer_id0,$ticket_number[$i]);

            }
        }
    }
    if(isset($_REQUEST['hotel_mosafer_id']))
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('hotel_fname[]','هتل : ' . 'نام ', 'required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('hotel_lname[]', 'هتل : ' . 'نام خانوادگی ', 'required|min_length[3]|max_length[500]');
        $this->form_validation->set_rules('hotel_code_melli[]','هتل : ' .  'کد ملی ', 'required|min_length[10]|max_length[20]');
        $gender = $_REQUEST['hotel_gender'];
        $sex = $_REQUEST['hotel_sex'];
        $mosafer_id = $_REQUEST['hotel_mosafer_id'];
        $fname = $_REQUEST['hotel_fname'];
        $lname = $_REQUEST['hotel_lname'];
        $code_melli = $_REQUEST['hotel_code_melli'];
        $khadamat_factor_id = $_REQUEST['khadamat_factor_id-2'];
        if($this->form_validation->run()==FALSE)
        {
            $valid = FALSE;
        }
        else
        {
            foreach ($mosafer_id as $i=>$mosafer_id0)
            {
                mosafer_class::add($fname[$i], $lname[$i], $code_melli[$i], '', '', $sex[$i], $gender[$i], '', $khadamat_factor_id,$mosafer_id0,'');
            }
        }
        
    }
    if(isset($_REQUEST['visamelli_mosafer_id']))
    {
        var_dump($_REQUEST);
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('visamelli_fname[]','ویزا : ' . 'نام ', 'required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('visamelli_lname[]', 'ویزا : ' . 'نام خانوادگی ', 'required|min_length[3]|max_length[500]');
        $this->form_validation->set_rules('visamelli_code_melli[]','ویزا : ' .  'کد ملی ', 'required|min_length[10]|max_length[20]');
        $gender = '';//$_REQUEST['visamelli_gender'];
        $sex = $_REQUEST['visamelli_sex'];
        $mosafer_id = $_REQUEST['visamelli_mosafer_id'];
        $fname = $_REQUEST['visamelli_fname'];
        $lname = $_REQUEST['visamelli_lname'];
        $code_melli = $_REQUEST['visamelli_code_melli'];
        $khadamat_factor_id = $_REQUEST['khadamat_factor_id-4'];
        if($this->form_validation->run()==FALSE)
        {
            $valid = FALSE;
        }
        else
        {
            foreach ($mosafer_id as $i=>$mosafer_id0)
            {
                mosafer_class::add($fname[$i], $lname[$i], $code_melli[$i], '', '', $sex[$i], $gender[$i], '', $khadamat_factor_id,$mosafer_id0,'');
            }
        }
        
    }
    if(isset($_REQUEST['visapass_mosafer_id']))
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('visapass_fname[]','ویزا : ' . 'نام ', 'required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('visapass_lname[]', 'ویزا : ' . 'نام خانوادگی ', 'required|min_length[3]|max_length[500]');
        $this->form_validation->set_rules('visapass_passport[]','ویزا : ' .  'پاسپورت', 'required|min_length[10]|max_length[30]');
        $gender = '';//$_REQUEST['visapass_gender'];
        $sex = $_REQUEST['visapass_sex'];
        $mosafer_id = $_REQUEST['visapass_mosafer_id'];
        $fname = $_REQUEST['visapass_fname'];
        $lname = $_REQUEST['visapass_lname'];
        $passport = $_REQUEST['visapass_passport'];
        $khadamat_factor_id = $_REQUEST['khadamat_factor_id-5'];
        if($this->form_validation->run()==FALSE)
        {
            $valid = FALSE;
        }
        else
        {
            foreach ($mosafer_id as $i=>$mosafer_id0)
            {
                mosafer_class::add($fname[$i], $lname[$i], '', $passport[$i], '', $sex[$i], $gender[$i], '', $khadamat_factor_id,$mosafer_id0,'');
            }
        }
        
    }
    if(isset($_REQUEST['hotel_room_id']))
    {
        $my = new mysql_class;
        $hotel_room_id = $_REQUEST['hotel_room_id'];
        $qq = array();
        foreach ($hotel_room_id as $idx=>$hid)
                $qq[$idx] = '';
        if(isset($_REQUEST['hotel_trans_raft_city']))
        {
            $raft_city = $_REQUEST['hotel_trans_raft_city'];
            $raft_airline = $_REQUEST['hotel_trans_raft_airline'];
            $raft_shomare = $_REQUEST['hotel_trans_raft_shomare'];
            $raft_vorood = $_REQUEST['hotel_trans_raft_saat_vorood'];
            $raft_khorooj = $_REQUEST['hotel_trans_raft_saat_khorooj'];
            foreach($raft_city as $idx=>$rc)
                $qq[$idx] = " `raft_city` = ".(int)$rc." , `raft_airline` = ".(int)$raft_airline[$idx]." , `raft_shomare` = '".$raft_shomare[$idx]."' , `raft_saat_vorood` = '".$raft_vorood[$idx]."', `raft_saat_khorooj` = '".$raft_khorooj[$idx]."'";
        }
        if(isset($_REQUEST['hotel_trans_bargasht_city']))
        {
            $bargasht_city = $_REQUEST['hotel_trans_bargasht_city'];
            $bargasht_airline = $_REQUEST['hotel_trans_bargasht_airline'];
            $bargasht_shomare = $_REQUEST['hotel_trans_bargasht_shomare'];
            $bargasht_vorood = $_REQUEST['hotel_trans_bargasht_saat_vorood'];
            $bargasht_khorooj = $_REQUEST['hotel_trans_bargasht_saat_khorooj'];
            foreach($bargasht_city as $idx=>$rc)
                $qq[$idx] .=(($qq[$idx]!='')?',':'') . " `bargasht_city` = ".(int)$rc." , `bargasht_airline` = ".(int)$bargasht_airline[$idx]." , `bargasht_shomare` = '".$bargasht_shomare[$idx]."' , `bargasht_saat_vorood` = '".$bargasht_vorood[$idx]."', `bargasht_saat_khorooj` = '".$bargasht_khorooj[$idx]."'";
        }
        if(isset($_REQUEST['hotel_trans_vasat_city']))
        {
            $vasat_city = $_REQUEST['hotel_trans_vasat_city'];
            $vasat_airline = $_REQUEST['hotel_trans_vasat_airline'];
            $vasat_shomare = $_REQUEST['hotel_trans_vasat_shomare'];
            $vasat_vorood = $_REQUEST['hotel_trans_vasat_saat_vorood'];
            $vasat_khorooj = $_REQUEST['hotel_trans_vasat_saat_khorooj'];
            foreach($vasat_city as $idx=>$rc)
                $qq[$idx] .=(($qq[$idx]!='')?',':'') . " `vasat_city` = ".(int)$rc." , `vasat_airline` = ".(int)$vasat_airline[$idx]." , `vasat_shomare` = '".$vasat_shomare[$idx]."' , `vasat_saat_vorood` = '".$vasat_vorood[$idx]."', `vasat_saat_khorooj` = '".$vasat_khorooj[$idx]."'";
        }
        foreach($hotel_room_id as $indx=>$hrid)
        {
            $my->ex_sqlx("update `hotel_room` set ".$qq[$indx]." where `id` = $hrid");
        }
    }
    if(isset($_REQUEST['mob']))
    {
        /*
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('hotel_fname[]', 'تلفن همراه ', 'required|min_length[10]|max_length[15]');
        $this->form_validation->set_rules('hotel_lname[]', 'ایمیل', 'required|valid_email');
        if($this->form_validation->run()==FALSE)
        {
            $valid = FALSE;
        }
        else 
        {
         * /
         */
            $m = new mysql_class;
            $m->ex_sqlx("update `factor` set `mob` = '".$_REQUEST['mob']."' , `email` = '".$_REQUEST['email']."' where id = $factor_id");
        //}
        if($valid)
        {
            redirect('khadamat_3/'.$factor_id);
        }
    }
//----------UPDATING End----------    
    $msg = '';
    $user_id1 = $user_id;
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
//----------DRAWING Start---------
    $my = new mysql_class;
    $mosafer_to_delete = array();
    $my->ex_sql("select mosafer.id from mosafer left join khadamat_factor on (khadamat_factor.id=khadamat_factor_id) where khadamat_factor.id is null",$q);
    foreach($q as $r)
        $mosafer_to_delete[] = (int)$r['id'];
    if(count($mosafer_to_delete)>0)
        $my->ex_sqlx("delete from `mosafer` where `id` in (".implode (",", $mosafer_to_delete).")");
    $cur_sh_sal = $this->inc_model->perToEnNums(jdate("Y"));
    $f = new factor_class($factor_id);
    $mos = mosafer_class::loadByFactor($factor_id);
    //var_dump($mos);
    $typs = array();
    foreach($mos as $mo)
    {
        if(!isset($typs[$mo['khadamat_type']]))
        {
            $typs[$mo['khadamat_type']] = array();
        }
        $typs[$mo['khadamat_type']][] = $mo;
    }
    $parvaz = '';
    //var_dump($typs);
    if(isset($typs[1]))
    {
        $khadamat_factor_id = $typs[1][0]['khadamat_factor_id'];
        $par_obj = new parvaz_class();
        $par_obj->loadByKhadamatFactor($typs[1][0]['khadamat_factor_id']);
        $mabda = '';
        $maghsad = '';
        $tit = '';
        if(isset($par_obj->mabda_id))
        {
            $tmp = new city_class($par_obj->mabda_id);
            $mabda = (isset($tmp->name))?$tmp->name:'----';
            $tmp = new city_class($par_obj->maghsad_id);
            $maghsad = (isset($tmp->name))?$tmp->name:'----';
            $tit = '<div class="col-sm-2 hs-padding">'.$mabda.'...'.$maghsad.'</div>';
            $tit .= '<div class="col-sm-2 hs-padding">شماره:'.$par_obj->shomare.'</div>';
            $tit .= '<div class="col-sm-2 hs-padding">تاریخ:'.jdate("d-m-Y",strtotime($par_obj->tarikh)).'</div>';
            $tit .= '<div class="col-sm-2 hs-padding">ساعت:'.jdate("H:i",strtotime($par_obj->saat)).'</div>';
        }
        $par_det = <<<PARDET
        <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
            <div class="col-sm-1">
                #pindex#
            </div>
            <div class="col-sm-1">
                <select name="parvaz_gender[]" style="width:80px;">
                    <option>سن</option>
                    <option value="adl"#age_adl#>Adult</option>
                    <option value="chd"#age_chd#>Child</option>
                    <option value="inf"#age_inf#>Infant</option>
                </select>
            </div>
            <div class="col-sm-1">
                <select name="parvaz_sex[]" style="width:80px;">
                    <option>جنسیت</option>
                    <option value="0"#gender_0#>مونث</option>
                    <option value="1"#gender_1#>مذکر</option>
                </select>
            </div>
            <div class="col-sm-1">
                <input type="hidden" name="parvaz_mosafer_id[]" value="#id#" />
                <input name="parvaz_fname[]" class="form-control same same_fname#pindex# same_master" placeholder="نام *" value="#fname#">
            </div>
            <div class="col-sm-2">
                <input name="parvaz_lname[]" class="form-control same same_lname#pindex# same_master" placeholder="نام خانوادگی *" value="#lname#">
            </div>
            <div class="col-sm-2">
                <input name="parvaz_code_melli[]" class="form-control same same_codemelli#pindex# same_master" placeholder="کد ملی *" value="#code_melli#">
            </div>
            <div class="col-sm-3">
                <select name="parvaz_tarikh_tavalod-rooz[]" style="width:50px;">
                    <option>روز</option>
                    #tav_rooz#
                </select>
                <select name="parvaz_tarikh_tavalod-mah[]" style="width:50px;">
                    <option>ماه</option>
                    #tav_mah#
                </select>
                <select name="parvaz_tarikh_tavalod-sal[]" style="width:70px;">
                    <option>سال</option>
                    #tav_sal#
                </select>
            </div>
            <div class="col-sm-1">
                <input name="parvaz_ticket_number[]" class="form-control" placeholder="شماره بلیت" value="#ticket_number#" >
            </div>
        </div>

PARDET;
        $parvaz1 = <<<PAR
        <div class="row hs-border hs-padding hs-margin-up-down hs-gray pointer" onclick="divTog('flight_div');">
            <div class="col-sm-2 hs-padding">
                #khadamat_name#
            </div>
            $tit <input type="hidden" name="khadamat_factor_id-1" value="$khadamat_factor_id" /><div class="hs-float-left hs-margin-up-down"><span id="flight_div_gly" class="glyphicon glyphicon-chevron-up"></span></div>
        </div>
        <div id="flight_div">
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                <div class="col-sm-1">
                    ردیف
                </div>
                <div class="col-sm-1">
                    سن
                </div>
                <div class="col-sm-1">
                    جنسیت
                </div>
                <div class="col-sm-2">
                    نام 
                    <span class="mm-font-red">*</span>
                </div>
                <div class="col-sm-2">
                    نام خانوادگی
                    <span class="mm-font-red">*</span>
                </div>
                <div class="col-sm-2">
                    کد ملی
                    <span class="mm-font-red">*</span>
                </div>
                <div class="col-sm-2">
                    تاریخ تولد
                    <span class="mm-font-red">*</span>
                </div>
                <div class="col-sm-1">
                    شماره تیکت
                </div>
            </div>

PAR;
        $parvaz2 = <<< PAR2
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                <div class="col-sm-2">
                    تلفن همراه : 
                </div>
                <div class="col-sm-4">
                    <input name="mob" class="form-control same same_mob same_master" placeholder="تلفن همراه" value="#mob#">
                </div>
                <div class="col-sm-1">
                    ایمیل :
                </div>
                <div class="col-sm-5">
                    <input name="email" class="form-control same same_email same_master" placeholder="ایمیل" value="#email#">
                </div>
            </div>
        </div>
PAR2;
        $dts = $typs[1];
        if(isset($_REQUEST['khadamat_factor_id-1']))
        {
            $dts = array();
            $dtmp = array(
                        "khadamat_type"=>1,
                        "khadamat_name"=>$typs[1][0]['khadamat_name'],
                        "id"=>-1,
                        "fname"=>'',
                        "lname"=>'',
                        "code_melli"=>'',
                        "passport"=>'',
                        "passport_engheza"=>'',
                        "gender"=>1,
                        "age"=>"adl",
                        "tarikh_tavalod" => '0000-00-00 00:00:00',
                        "khadamat_factor_id" => (int)$_REQUEST['khadamat_factor_id-1'],
                        "ticket_number" => ''
                    );
            for($i = 0;$i < count($_REQUEST['parvaz_gender']);$i++)
            {
                $dts[] = $dtmp;
            }
            foreach($_REQUEST as $key=>$value)
            {
                if($key == 'parvaz_gender')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["age"] = $val;
                    }
                }
                if($key == 'parvaz_sex')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["gender"] = $val;
                    }
                }
                if($key == 'parvaz_mosafer_id')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["id"] = $val;
                    }
                }
                if($key == 'parvaz_fname')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["fname"] = $val;
                    }
                }
                if($key == 'parvaz_lname')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["lname"] = $val;
                    }
                }
                if($key == 'parvaz_code_melli')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["code_melli"] = $val;
                    }
                }
                if($key == 'parvaz_ticket_number')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["ticket_number"] = $val;
                    }
                }
                if($key == 'parvaz_tarikh_tavalod-rooz')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["parvaz_tarikh_tavalod-rooz"] = $val;
                    }
                }
                if($key == 'parvaz_tarikh_tavalod-mah')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["parvaz_tarikh_tavalod-mah"] = $val;
                    }
                }
                if($key == 'parvaz_tarikh_tavalod-sal')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["parvaz_tarikh_tavalod-sal"] = $val;
                    }
                }
            }
            for($i = 0;$i < count($dts);$i++)
            {
                $tarikh_tav = $this->inc_model->jalaliToMiladi($dts[$i]['parvaz_tarikh_tavalod-sal'].'/'.$dts[$i]['parvaz_tarikh_tavalod-mah'].'/'.$dts[$i]['parvaz_tarikh_tavalod-rooz']);
                $dts[$i]['tarikh_tavalod'] = $tarikh_tav;
                unset($dts[$i]['parvaz_tarikh_tavalod-sal']);
                unset($dts[$i]['parvaz_tarikh_tavalod-mah']);
                unset($dts[$i]['parvaz_tarikh_tavalod-rooz']);
            }
        }
        $parvaz = generateInputBlock($parvaz1, $parvaz2, $par_det, $dts, $f,$cur_sh_sal,$par_obj);
    }
    $hotel = '';
    if(isset($typs[2]))
    {
        $hot_obj = new hotel_class();
        $khadamat_factor_id = $typs[2][0]['khadamat_factor_id'];
        $hot_obj->loadByKhadamatFactor($typs[2][0]['khadamat_factor_id']);
        $hot_obj->shab = dateDif($hot_obj->ta_tarikh, $hot_obj->az_tarikh);
        $tmp = new city_class($hot_obj->maghsad_id);
        $maghsad = (isset($tmp->name))?$tmp->name:'---';
        $hr = hotel_room_class::loadByFactorId($factor_id);
        $extra = 0;
        $extra_chd = 0;
        foreach($hr as $h)
        {
            $extra+=(int)$h['extra_service'];
            $extra_chd+=(int)$h['extra_service_chd'];
        }
        $extr = '';
        if($extra+$extra_chd>0)
        {
            $extr = 'سرویس اضافه : ';
            if($extra>0)
                $extr .= $extra.' بزرگسال';
            if($extra_chd>0)
                $extr .= (($extra>0)?' و ':''). $extra_chd.' کودک';
        }
        $tit = '<div class="col-sm-1 hs-padding">'.$maghsad.'</div>';
        $tit .='<div class="col-sm-1 hs-padding">'.$hot_obj->name.'</div>';
        $tit .='<div class="col-sm-1 hs-padding">'.$hot_obj->shab.'شب'.'</div>';
        $tit .= '<div class="col-sm-2 hs-padding">'.'تاریخ:'.jdate("d-m-Y",strtotime($hot_obj->az_tarikh)).'</div>';
        $tit .= '<div class="col-sm-4 hs-padding">'.$extr.'</div>';
        $ho_det = <<<HODET
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                <div class="col-sm-1">
                    #pindex#
                </div>
                <div class="col-sm-1">
                    <select name="hotel_gender[]" style="width:80px;">
                        <option>سن</option>
                        <option value="adl"#age_adl#>Adult</option>
                        <option value="chd"#age_chd#>Child</option>
                        <option value="inf"#age_inf#>Infant</option>
                    </select>
                </div>
                <div class="col-sm-1">
                    <select name="hotel_sex[]" style="width: 80px;">
                        <option>جنسیت</option>
                        <option value="0"#gender_0#>مونث</option>
                        <option value="1"#gender_1#>مذکر</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="hidden" name="hotel_mosafer_id[]" value="#id#" />
                    <input name="hotel_fname[]" class="form-control same same_fname#pindex#" placeholder="نام *" value="#fname#">
                </div>
                <div class="col-sm-4">
                    <input name="hotel_lname[]" class="form-control same same_lname#pindex#" placeholder="نام خانوادگی *" value="#lname#">
                </div>
                <div class="col-sm-2">
                    <input name="hotel_code_melli[]" class="form-control same same_codemelli#pindex#" placeholder="کد ملی *" value="#code_melli#">
                </div>
            </div>
HODET;
        $hotel1 = <<<HOT1
            <div class="row hs-border hs-padding hs-margin-up-down hs-gray pointer" onclick="divTog('hotel_div');">
                <div class="col-sm-2 hs-padding">#khadamat_name#</div>$tit <input type="hidden" name="khadamat_factor_id-2" value="$khadamat_factor_id" />
                <div class="hs-float-left hs-margin-up-down"><span id="hotel_div_gly" class="glyphicon glyphicon-chevron-up"></span></div>
            </div>
            <div id="hotel_div">
                <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                    <div class="col-sm-1">
                        ردیف
                    </div>
                    <div class="col-sm-1">
                        جنسیت
                    </div>
                    <div class="col-sm-3">
                        نام 
                        <span class="mm-font-red">*</span>
                    </div>
                    <div class="col-sm-5">
                        نام خانوادگی
                        <span class="mm-font-red">*</span>
                    </div>
                    <div class="col-sm-2">
                        کد ملی
                        <span class="mm-font-red">*</span>
                    </div>
                </div>
HOT1;
        $hotel2 = <<<HOT2
                <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                    <div class="col-sm-2">
                        تلفن همراه : 
                    </div>
                    <div class="col-sm-4">
                        <input name="hotel_mob" class="form-control same same_mob same_master" placeholder="تلفن همراه" value="#mob#">
                    </div>
                    <div class="col-sm-1">
                        ایمیل :
                    </div>
                    <div class="col-sm-5">
                        <input name="hotel_email" class="form-control same same_email same_master" placeholder="ایمیل" value="#email#">
                    </div>
                </div>
            </div>

HOT2;

        $tra1 = <<<TR1
        <div class="row hs-border hs-padding hs-margin-up-down hs-gray pointer" onclick="divTog('hotelroom_div');">
           <div class="col-sm-9" style="line-height:50px;"> ترانسفر فرودگاهی</div><div class="hs-float-left hs-margin-up-down"><span id="hotelroom_div_gly" class="glyphicon glyphicon-chevron-up"></span></div>
        </div>
        <div id="hotelroom_div">
                #hoty#
        </div>
TR1;
        $tra3_raft = <<<RAFT
                    <div class="row hs-padding">
                        <div class="col-sm-2">
                            رفت
                        </div>
                        <div class="col-sm-2">
                            <select name="hotel_trans_raft_city[#indx#]" style="width: 80px;"> 
                                <option>شهر</option>
                                #city#
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <select name="hotel_trans_raft_airline[#indx#]" style="width: 80px;"> 
                                <option>ایرلاین</option>
                                #airline#
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input name="hotel_trans_raft_shomare[#indx#]" placeholder="شماره پرواز" class="form-control" value="#shomare#"/>
                        </div>
                        <div class="col-sm-2">
                            <input name="hotel_trans_raft_saat_vorood[#indx#]" placeholder="ساعت ورود" class="form-control" value="#saat_vorood#"/>
                        </div>
                        <div class="col-sm-2">
                            <input name="hotel_trans_raft_saat_khorooj[#indx#]" placeholder="ساعت خروج" class="form-control" value="#saat_khorooj#"/>
                        </div>
                    </div>

RAFT;
        $tra3_vasat = <<<RAFT
                    <div class="row hs-padding">
                        <div class="col-sm-2">
                            وسط
                        </div>
                        <div class="col-sm-2">
                            <select name="hotel_trans_vasat_city[#indx#]" style="width: 80px;"> 
                                <option>شهر</option>
                                #city#
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <select name="hotel_trans_vasat_airline[#indx#]" style="width: 80px;"> 
                                <option>ایرلاین</option>
                                #airline#
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input name="hotel_trans_vasat_shomare[#indx#]" placeholder="شماره پرواز" class="form-control" value="#shomare#"/>
                        </div>
                        <div class="col-sm-2">
                            <input name="hotel_trans_vasat_saat_vorood[#indx#]" placeholder="ساعت ورود" class="form-control" value="#saat_vorood#"/>
                        </div>
                        <div class="col-sm-2">
                            <input name="hotel_trans_vasat_saat_khorooj[#indx#]" placeholder="ساعت خروج" class="form-control" value="#saat_khorooj#"/>
                        </div>
                    </div>

RAFT;
        $tra3_bargasht = <<<BRG
                    <div class="row hs-padding">
                        <div class="col-sm-2">
                            برگشت
                        </div>
                        <div class="col-sm-2">
                            <select name="hotel_trans_bargasht_city[#indx#]" style="width: 80px;"> 
                                <option>شهر</option>
                                #city#
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <select name="hotel_trans_bargasht_airline[#indx#]" style="width: 80px;"> 
                                <option>ایرلاین</option>
                                #airline#
                            </select>
                        </div>
                        <div class="col-sm-2">
                            <input name="hotel_trans_bargasht_shomare[#indx#]" placeholder="شماره پرواز" class="form-control" value="#shomare#"/>
                        </div>
                        <div class="col-sm-2">
                            <input name="hotel_trans_bargasht_saat_vorood[#indx#]" placeholder="ساعت ورود" class="form-control" value="#saat_vorood#"/>
                        </div>
                        <div class="col-sm-2">
                            <input name="hotel_trans_bargasht_saat_khorooj[#indx#]" placeholder="ساعت خروج" class="form-control" value="#saat_khorooj#"/>
                        </div>
                    </div>
BRG;
        $tra2 = <<<TR2
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                <div class="col-sm-1">
                    اتاق  #indx#
                </div>
                <div class="col-sm-2">
                    رفت/برگشت
                </div>
                <div class="col-sm-2">
                    شهر 
                </div>
                <div class="col-sm-1">
                    ایرلاین
                </div>
                <div class="col-sm-2">
                    شماره پرواز
                </div>
                <div class="col-sm-2">
                    ساعت ورود
                </div>
                <div class="col-sm-2">
                    ساعت خروج
                </div>
            </div>
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                <div class="col-sm-1" style="line-height: #hei#px;">
                    #name#<input type="hidden" name="hotel_room_id[#indx#]" value="#hrid#" />
                </div>
                <div class="col-sm-11">
                    #raft#
                    #vasat#
                    #bargasht#
                </div>
            </div>
TR2;
        $tra = '';
        foreach($hr as $i=>$hrr)
        {
            $tr2_tmp = $tra2;
            $hei = 100;
            $r=(int)$hrr['transfer_raft']+(int)$hrr['transfer_vasat']+(int)$hrr['transfer_bargasht'];
            if($r-3>0)
                $hei = $hei*($r-1);
            if((int)$hrr['transfer_raft']==1)
            {
                $tra3_raft1 = str_replace("#city#", city_class::loadAllSel($hrr['raft_city']), $tra3_raft);
                $tra3_raft1 = str_replace("#airline#", airline_class::loadAll($hrr['raft_airline']), $tra3_raft1);
                $tra3_raft1 = str_replace("#shomare#", $hrr['raft_shomare'], $tra3_raft1);
                $tra3_raft1 = str_replace("#saat_vorood#", $hrr['raft_saat_vorood'], $tra3_raft1);
                $tra3_raft1 = str_replace("#saat_khorooj#", $hrr['raft_saat_khorooj'], $tra3_raft1);
                $tr2_tmp = str_replace("#raft#", $tra3_raft1, $tr2_tmp);
            }
            else
                $tr2_tmp = str_replace("#raft#", '', $tr2_tmp);
            if((int)$hrr['transfer_vasat']==1)
            {
                $tra3_raft1 = str_replace("#city#", city_class::loadAllSel($hrr['vasat_city']), $tra3_vasat);
                $tra3_raft1 = str_replace("#airline#", airline_class::loadAll($hrr['vasat_airline']), $tra3_raft1);
                $tra3_raft1 = str_replace("#shomare#", $hrr['vasat_shomare'], $tra3_raft1);
                $tra3_raft1 = str_replace("#saat_vorood#", $hrr['vasat_saat_vorood'], $tra3_raft1);
                $tra3_raft1 = str_replace("#saat_khorooj#", $hrr['vasat_saat_khorooj'], $tra3_raft1);
                $tr2_tmp = str_replace("#vasat#", $tra3_raft1, $tr2_tmp);
            }
            else
                $tr2_tmp = str_replace("#vasat#", '', $tr2_tmp);
            if((int)$hrr['transfer_bargasht']==1)
            {
                $tra3_raft1 = str_replace("#city#", city_class::loadAllSel($hrr['bargasht_city']), $tra3_bargasht);
                $tra3_raft1 = str_replace("#airline#", airline_class::loadAll($hrr['bargasht_airline']), $tra3_raft1);
                $tra3_raft1 = str_replace("#shomare#", $hrr['bargasht_shomare'], $tra3_raft1);
                $tra3_raft1 = str_replace("#saat_vorood#", $hrr['bargasht_saat_vorood'], $tra3_raft1);
                $tra3_raft1 = str_replace("#saat_khorooj#", $hrr['bargasht_saat_khorooj'], $tra3_raft1);
                $tr2_tmp = str_replace("#bargasht#", $tra3_raft1, $tr2_tmp);
            }
            else
                $tr2_tmp = str_replace("#bargasht#", '', $tr2_tmp);
            $tr2_tmp = str_replace("#indx#", $i+1, $tr2_tmp);
            $tr2_tmp = str_replace("#hrid#", $hrr['id'], $tr2_tmp);
            $tr2_tmp = str_replace("#name#", $hrr['name'], $tr2_tmp);
            $tr2_tmp = str_replace("#hei#", $hei, $tr2_tmp);
            $tra .= $tr2_tmp;
        }
        if(count($hr)>0)
            $tra1 = str_replace("#hoty#", $tra, $tra1);
        else
            $tra1 = '';
        $dts = $typs[2];
        if(isset($_REQUEST['khadamat_factor_id-2']))
        {
            $dts = array();
            $dtmp = array(
                        "khadamat_type"=>2,
                        "khadamat_name"=>$typs[2][0]['khadamat_name'],
                        "id"=>-1,
                        "fname"=>'',
                        "lname"=>'',
                        "code_melli"=>'',
                        "passport"=>'',
                        "passport_engheza"=>'',
                        "gender"=>1,
                        "age"=>"adl",
                        "tarikh_tavalod" => '0000-00-00 00:00:00',
                        "khadamat_factor_id" => (int)$_REQUEST['khadamat_factor_id-2'],
                        "ticket_number" => ''
                    );
            for($i = 0;$i < count($_REQUEST['hotel_gender']);$i++)
            {
                $dts[] = $dtmp;
            }
            foreach($_REQUEST as $key=>$value)
            {
                if($key == 'hotel_gender')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["age"] = $val;
                    }
                }
                if($key == 'hotel_sex')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["gender"] = $val;
                    }
                }
                if($key == 'hotel_mosafer_id')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["id"] = $val;
                    }
                }
                if($key == 'hotel_fname')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["fname"] = $val;
                    }
                }
                if($key == 'hotel_lname')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["lname"] = $val;
                    }
                }
                if($key == 'hotel_code_melli')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["code_melli"] = $val;
                    }
                }
            }
        }
        
        $hotel = generateInputBlock($hotel1, $hotel2,$ho_det, $dts, $f, $cur_sh_sal,$hot_obj).$tra1;
    }
    $tour = '';
    if(isset($typs[3]))
    {
        $par_obj = new parvaz_class();
        $khadamat_factor_id = $typs[3][0]['khadamat_factor_id'];        
        $par_obj->loadByKhadamatFactor($typs[3][0]['khadamat_factor_id']);
        $tmp = new city_class($par_obj->mabda_id);
        $mabda = (isset($tmp->name))?$tmp->name:'----';
        $tmp = new city_class($par_obj->maghsad_id);
        $maghsad = (isset($tmp->name))?$tmp->name:'----';
        $hot_obj = new hotel_class();
        $hot_obj->loadByKhadamatFactor($typs[3][0]['khadamat_factor_id']);
        //var_dump($hot_obj);
        $hot_obj->shab = dateDif($hot_obj->ta_tarikh, $hot_obj->az_tarikh);
        $tit = '<div class="col-sm-2 hs-padding">'.$mabda.'...'.$maghsad.'</div>';
        $tit .= '<div class="col-sm-2 hs-padding">شماره:'.$par_obj->shomare.'</div>';
        $tit .= '<div class="col-sm-2 hs-padding">تاریخ:'.jdate("d-m-Y",strtotime($par_obj->tarikh)).'</div>';
        $tit .= '<div class="col-sm-2 hs-padding">ساعت:'.jdate("H:i",strtotime($par_obj->saat)).'</div>';
        $tit .= '<div class="col-sm-2 hs-padding">هتل:'.$hot_obj->name.'('.$hot_obj->shab.'شب)'.'</div>';
        $par_det = <<<PARDET
        <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
            <div class="col-sm-1">
                #pindex#
            </div>
            <div class="col-sm-1">
                <select name="tour_gender[]" style="width:80px;">
                    <option>سن</option>
                    <option value="adl"#age_adl#>Adult</option>
                    <option value="chd"#age_chd#>Child</option>
                    <option value="inf"#age_inf#>Infant</option>
                </select>
            </div>
            <div class="col-sm-1">
                <select name="tour_sex[]" style="width:80px;">
                    <option>جنسیت</option>
                    <option value="0"#gender_0#>مونث</option>
                    <option value="1"#gender_1#>مذکر</option>
                </select>
            </div>
            <div class="col-sm-1">
                <input type="hidden" name="tour_mosafer_id[]" value="#id#" />
                <input name="tour_fname[]" class="form-control same same_fname#pindex#" placeholder="نام *" value="#fname#">
            </div>
            <div class="col-sm-2">
                <input name="tour_lname[]" class="form-control same same_lname#pindex#" placeholder="نام خانوادگی *" value="#lname#">
            </div>
            <div class="col-sm-2">
                <input name="tour_code_melli[]" class="form-control same same_codemelli#pindex#" placeholder="کد ملی *" value="#code_melli#">
            </div>
            <div class="col-sm-3">
                <select name="tour_tarikh_tavalod-rooz[]" style="width:50px;">
                    <option>روز</option>
                    #tav_rooz#
                </select>
                <select name="tour_tarikh_tavalod-mah[]" style="width:50px;">
                    <option>ماه</option>
                    #tav_mah#
                </select>
                <select name="tour_tarikh_tavalod-sal[]" style="width:70px;">
                    <option>سال</option>
                    #tav_sal#
                </select>
            </div>
            <div class="col-sm-1">
                <input name="tour_ticket_number[]" class="form-control" placeholder="شماره بلیت" value="#ticket_number#" >
            </div>
        </div>

PARDET;
        $parvaz1 = <<<PAR
        <div class="row hs-border hs-padding hs-margin-up-down hs-gray pointer" onclick="divTog('flight_div');">
            <div class="col-sm-2 hs-padding">#khadamat_name#</div>$tit <input type="hidden" name="khadamat_factor_id-3" value="$khadamat_factor_id" /><div class="hs-float-left hs-margin-up-down"><span id="flight_div_gly" class="glyphicon glyphicon-chevron-up"></span></div>
        </div>
        <div id="flight_div">
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                <div class="col-sm-1">
                    ردیف
                </div>
                <div class="col-sm-1">
                    سن
                </div>
                <div class="col-sm-1">
                    جنسیت
                </div>
                <div class="col-sm-2">
                    نام 
                    <span class="mm-font-red">*</span>
                </div>
                <div class="col-sm-2">
                    نام خانوادگی
                    <span class="mm-font-red">*</span>
                </div>
                <div class="col-sm-2">
                    کد ملی
                    <span class="mm-font-red">*</span>
                </div>
                <div class="col-sm-2">
                    تاریخ تولد
                    <span class="mm-font-red">*</span>
                </div>
                <div class="col-sm-1">
                    شماره تیکت
                </div>
            </div>

PAR;
        $parvaz2 = <<< PAR2
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                <div class="col-sm-2">
                    تلفن همراه : 
                </div>
                <div class="col-sm-4">
                    <input name="mob" class="form-control same same_mob same_master" placeholder="تلفن همراه" value="#mob#">
                </div>
                <div class="col-sm-1">
                    ایمیل :
                </div>
                <div class="col-sm-5">
                    <input name="email" class="form-control same same_email same_master" placeholder="ایمیل" value="#email#">
                </div>
            </div>
        </div>
PAR2;
        $dts = $typs[3];
        if(isset($_REQUEST['khadamat_factor_id-3']))
        {
            $dts = array();
            $dtmp = array(
                        "khadamat_type"=>3,
                        "khadamat_name"=>$typs[3][0]['khadamat_name'],
                        "id"=>-1,
                        "fname"=>'',
                        "lname"=>'',
                        "code_melli"=>'',
                        "passport"=>'',
                        "passport_engheza"=>'',
                        "gender"=>1,
                        "age"=>"adl",
                        "tarikh_tavalod" => '0000-00-00 00:00:00',
                        "khadamat_factor_id" => (int)$_REQUEST['khadamat_factor_id-3'],
                        "ticket_number" => ''
                    );
            for($i = 0;$i < count($_REQUEST['tour_gender']);$i++)
            {
                $dts[] = $dtmp;
            }
            foreach($_REQUEST as $key=>$value)
            {
                if($key == 'tour_gender')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["age"] = $val;
                    }
                }
                if($key == 'tour_sex')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["gender"] = $val;
                    }
                }
                if($key == 'tour_mosafer_id')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["id"] = $val;
                    }
                }
                if($key == 'tour_fname')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["fname"] = $val;
                    }
                }
                if($key == 'tour_lname')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["lname"] = $val;
                    }
                }
                if($key == 'tour_code_melli')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["code_melli"] = $val;
                    }
                }
                if($key == 'tour_ticket_number')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["ticket_number"] = $val;
                    }
                }
                if($key == 'tour_tarikh_tavalod-rooz')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["tour_tarikh_tavalod-rooz"] = $val;
                    }
                }
                if($key == 'tour_tarikh_tavalod-mah')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["tour_tarikh_tavalod-mah"] = $val;
                    }
                }
                if($key == 'tour_tarikh_tavalod-sal')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["tour_tarikh_tavalod-sal"] = $val;
                    }
                }
            }
            for($i = 0;$i < count($dts);$i++)
            {
                $tarikh_tav = $this->inc_model->jalaliToMiladi($dts[$i]['tour_tarikh_tavalod-sal'].'/'.$dts[$i]['tour_tarikh_tavalod-mah'].'/'.$dts[$i]['tour_tarikh_tavalod-rooz']);
                $dts[$i]['tarikh_tavalod'] = $tarikh_tav;
                unset($dts[$i]['tour_tarikh_tavalod-sal']);
                unset($dts[$i]['tour_tarikh_tavalod-mah']);
                unset($dts[$i]['tour_tarikh_tavalod-rooz']);
            }
        }
        $tour = generateInputBlock($parvaz1, $parvaz2, $par_det, $dts, $f,$cur_sh_sal,$par_obj);
    }
    $visa_melli = '';
    if(isset($typs[4]))
    {
        $khadamat_factor_id = $typs[4][0]['khadamat_factor_id'];
        $ho_det = <<<HODET
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                <div class="col-sm-1 visam_index">
                    #pindex#
                </div>
                <div class="col-sm-1">
                    <select name="visamelli_sex[]" style="width: 80px;">
                        <option>جنسیت</option>
                        <option value="0"#gender_0#>مونث</option>
                        <option value="1"#gender_1#>مذکر</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="hidden" name="visamelli_mosafer_id[]" value="#id#" />
                    <input name="visamelli_fname[]" class="form-control same same_fname#pindex#" placeholder="نام *" value="#fname#">
                </div>
                <div class="col-sm-5">
                    <input name="visamelli_lname[]" class="form-control same same_lname#pindex#" placeholder="نام خانوادگی *" value="#lname#">
                </div>
                <div class="col-sm-2">
                    <input name="visamelli_code_melli[]" class="form-control same same_codemelli#pindex#" placeholder="کد ملی *" value="#code_melli#">
                </div>
            </div>
HODET;
        $hotel1 = <<<HOT1
            <div class="row hs-border hs-padding hs-margin-up-down hs-gray pointer" onclick="divTog('visam_div');">
                #khadamat_name#<input type="hidden" name="khadamat_factor_id-4" value="$khadamat_factor_id" /><div class="hs-float-left hs-margin-up-down"><span id="visam_div_gly" class="glyphicon glyphicon-chevron-up"></span></div>
            </div>
            <div id="visam_div">
                <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-plus-sign pointer" onclick="addVisam()"></span>
                        ردیف
                        <span class="glyphicon glyphicon-minus pointer" onclick="removeVisam()"></span>
                    </div>
                    <div class="col-sm-1">
                        جنسیت
                    </div>
                    <div class="col-sm-3">
                        نام 
                        <span class="mm-font-red">*</span>
                    </div>
                    <div class="col-sm-5">
                        نام خانوادگی
                        <span class="mm-font-red">*</span>
                    </div>
                    <div class="col-sm-2">
                        کد ملی
                        <span class="mm-font-red">*</span>
                    </div>
                </div>
HOT1;
        $hotel2 = <<<HOT2
                <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down" id="visam_last">
                    <div class="col-sm-2">
                        تلفن همراه : 
                    </div>
                    <div class="col-sm-4">
                        <input name="hotel_mob" class="form-control same same_mob same_master" placeholder="تلفن همراه" value="#mob#">
                    </div>
                    <div class="col-sm-1">
                        ایمیل :
                    </div>
                    <div class="col-sm-5">
                        <input name="hotel_email" class="form-control same same_email same_master" placeholder="ایمیل" value="#email#">
                    </div>
                </div>
            </div>

HOT2;

        $dts = $typs[4];
        if(isset($_REQUEST['khadamat_factor_id-4']))
        {
            $dts = array();
            $dtmp = array(
                        "khadamat_type"=>4,
                        "khadamat_name"=>$typs[4][0]['khadamat_name'],
                        "id"=>-1,
                        "fname"=>'',
                        "lname"=>'',
                        "code_melli"=>'',
                        "passport"=>'',
                        "passport_engheza"=>'',
                        "gender"=>1,
                        "age"=>"adl",
                        "tarikh_tavalod" => '0000-00-00 00:00:00',
                        "khadamat_factor_id" => (int)$_REQUEST['khadamat_factor_id-4'],
                        "ticket_number" => ''
                    );
            for($i = 0;$i < count($_REQUEST['visamelli_sex']);$i++)
            {
                $dts[] = $dtmp;
            }
            foreach($_REQUEST as $key=>$value)
            {
                if($key == 'visamelli_gender')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["age"] = $val;
                    }
                }
                if($key == 'visamelli_sex')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["gender"] = $val;
                    }
                }
                if($key == 'visamelli_mosafer_id')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["id"] = $val;
                    }
                }
                if($key == 'visamelli_fname')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["fname"] = $val;
                    }
                }
                if($key == 'visamelli_lname')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["lname"] = $val;
                    }
                }
                if($key == 'visamelli_code_melli')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["code_melli"] = $val;
                    }
                }
            }
        }
        
        $visa_melli = generateInputBlock($hotel1, $hotel2,$ho_det, $dts, $f, $cur_sh_sal);
    }
    $visa_pass = '';
    if(isset($typs[5]))
    {
        $khadamat_factor_id = $typs[5][0]['khadamat_factor_id'];
        $ho_det = <<<HODET
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                <div class="col-sm-1 visap_index">
                    #pindex#
                </div>
                <div class="col-sm-1">
                    <select name="visapass_sex[]" style="width: 80px;">
                        <option>جنسیت</option>
                        <option value="0"#gender_0#>مونث</option>
                        <option value="1"#gender_1#>مذکر</option>
                    </select>
                </div>
                <div class="col-sm-3">
                    <input type="hidden" name="visapass_mosafer_id[]" value="#id#" />
                    <input name="visapass_fname[]" class="form-control same same_fname#pindex#" placeholder="نام *" value="#fname#">
                </div>
                <div class="col-sm-5">
                    <input name="visapass_lname[]" class="form-control same same_lname#pindex#" placeholder="نام خانوادگی *" value="#lname#">
                </div>
                <div class="col-sm-2">
                    <input name="visapass_passport[]" class="form-control same same_passport#pindex#" placeholder="شماره پاسپورت*" value="#passport#">
                </div>
            </div>
HODET;
        $hotel1 = <<<HOT1
            <div class="row hs-border hs-padding hs-margin-up-down hs-gray pointer" onclick="divTog('visap_div');">
                #khadamat_name#<input type="hidden" name="khadamat_factor_id-5" value="$khadamat_factor_id" /><div class="hs-float-left hs-margin-up-down"><span id="visap_div_gly" class="glyphicon glyphicon-chevron-up"></span></div>
            </div>
            <div id="visap_div">
                <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
                    <div class="col-sm-1">
                        <span class="glyphicon glyphicon-plus-sign pointer" onclick="addVisap()"></span>
                        ردیف
                        <span class="glyphicon glyphicon-minus pointer" onclick="removeVisap()"></span>
                    </div>
                    <div class="col-sm-1">
                        جنسیت
                    </div>
                    <div class="col-sm-3">
                        نام 
                        <span class="mm-font-red">*</span>
                    </div>
                    <div class="col-sm-5">
                        نام خانوادگی
                        <span class="mm-font-red">*</span>
                    </div>
                    <div class="col-sm-2">
                        پاسپورت
                        <span class="mm-font-red">*</span>
                    </div>
                </div>
HOT1;
        $hotel2 = <<<HOT2
                <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down"  id="visap_last">
                    <div class="col-sm-2">
                        تلفن همراه : 
                    </div>
                    <div class="col-sm-4">
                        <input name="hotel_mob" class="form-control same same_mob same_master" placeholder="تلفن همراه" value="#mob#">
                    </div>
                    <div class="col-sm-1">
                        ایمیل :
                    </div>
                    <div class="col-sm-5">
                        <input name="hotel_email" class="form-control same same_email same_master" placeholder="ایمیل" value="#email#">
                    </div>
                </div>
            </div>

HOT2;
        $dts = $typs[5];
        if(isset($_REQUEST['khadamat_factor_id-5']))
        {
            $dts = array();
            $dtmp = array(
                        "khadamat_type"=>5,
                        "khadamat_name"=>$typs[5][0]['khadamat_name'],
                        "id"=>-1,
                        "fname"=>'',
                        "lname"=>'',
                        "code_melli"=>'',
                        "passport"=>'',
                        "passport_engheza"=>'',
                        "gender"=>1,
                        "age"=>"adl",
                        "tarikh_tavalod" => '0000-00-00 00:00:00',
                        "khadamat_factor_id" => (int)$_REQUEST['khadamat_factor_id-5'],
                        "ticket_number" => ''
                    );
            for($i = 0;$i < count($_REQUEST['visapass_sex']);$i++)
            {
                $dts[] = $dtmp;
            }
            foreach($_REQUEST as $key=>$value)
            {
                if($key == 'visapass_gender')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["age"] = $val;
                    }
                }
                if($key == 'visapass_sex')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["gender"] = $val;
                    }
                }
                if($key == 'visapass_mosafer_id')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["id"] = $val;
                    }
                }
                if($key == 'visapass_fname')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["fname"] = $val;
                    }
                }
                if($key == 'visapass_lname')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["lname"] = $val;
                    }
                }
                if($key == 'visapass_code_melli')
                {
                    foreach($value as $i=>$val)
                    {
                        $dts[$i]["code_melli"] = $val;
                    }
                }
            }
        }
        $visa_pass = generateInputBlock($hotel1, $hotel2,$ho_det, $dts, $f, $cur_sh_sal);
    }
    //var_dump($typs);
//----------DRAWING End------------
    //var_dump($_REQUEST);
?>

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
    <form method="post">
    <div class="col-sm-10" >
        <?php
            echo $this->inc_model->loadProgress(2,$factor_id);
        ?>
        <?php 
            echo validation_errors();
            echo "<div class='text-center hs-margin-up-down' ><div class='label label-danger' style='font-size:100%' >شماره فاکتور: $p1</div></div>"; 
        ?>
        <?php echo $parvaz; ?>
        <?php echo $hotel.$tour.$visa_melli.$visa_pass; ?>
        <div class="hs-float-left hs-margin-up-down">
            <button href="" class="btn hs-btn-default btn-lg" >
                ادامه
                <span class="glyphicon glyphicon-chevron-left"></span>
            </button>
        </div>
        <div class="hs-float-right hs-margin-up-down">
            <a href="<?php echo site_url().'khadamat_1/'.$factor_id; ?>" class="btn hs-btn-default btn-lg" >
                <span class="glyphicon glyphicon-chevron-right"></span>
                مرحله قبلی
            </a>
        </div>
    </div>
    </form>


</div>
<script>
    var tttm = '\
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">\
                <div class="col-sm-1 visam_index">\
                    #pindex#\
                </div>\
                <div class="col-sm-1">\
                    <select name="visamelli_sex[]" style="width: 80px;">\
                        <option>جنسیت</option>\
                        <option value="0">مونث</option>\
                        <option value="1">مذکر</option>\
                    </select>\
                </div>\
                <div class="col-sm-3">\
                    <input type="hidden" name="visamelli_mosafer_id[]" value="" />\
                    <input name="visamelli_fname[]" class="form-control same same_fname#pindex#" placeholder="نام *" value="">\
                </div>\
                <div class="col-sm-5">\
                    <input name="visamelli_name[]" class="form-control same same_lname#pindex#" placeholder="نام خانوادگی *" value="">\
                </div>\
                <div class="col-sm-2">\
                    <input name="visamelli_code_melli[]" class="form-control same same_codemelli#pindex#" placeholder="کد ملی *" value="">\
                </div>\
            </div>';
    function addVisam()
    {
        var last_index = 1;
        if($(".visam_index:last").length>0)
            last_index=parseInt($(".visam_index:last").text().trim(),10)+1;
        $("#visam_last").before(tttm.replace(/#pindex#/g,last_index));
        $('select').select2({
            dir: "rtl"
        });
    }
    function removeVisam()
    {
        $(".visam_index:last").parent().remove();
    }
    var tttp = '\
            <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">\
                <div class="col-sm-1 visap_index">\
                    #pindex#\
                </div>\
                <div class="col-sm-1">\
                    <select name="visapass_sex[]" style="width: 80px;">\
                        <option>جنسیت</option>\
                        <option value="0">مونث</option>\
                        <option value="1">مذکر</option>\
                    </select>\
                </div>\
                <div class="col-sm-3">\
                    <input type="hidden" name="visapass_mosafer_id[]" value="" />\
                    <input name="visapass_fname[]" class="form-control same same_fname#pindex#" placeholder="نام *" value="">\
                </div>\
                <div class="col-sm-5">\
                    <input name="visapass_name[]" class="form-control same same_lname#pindex#" placeholder="نام خانوادگی *" value="">\
                </div>\
                <div class="col-sm-2">\
                    <input name="visapass_code_passport[]" class="form-control same same_passport#pindex#" placeholder="شماره پاسپورت *" value="">\
                </div>\
            </div>';
    function addVisap()
    {
        var last_index = 1;
        if($(".visap_index:last").length>0)
            last_index=parseInt($(".visap_index:last").text().trim(),10)+1;
        $("#visap_last").before(tttp.replace(/#pindex#/g,last_index));
        $('select').select2({
            dir: "rtl"
        });
    }
    function removeVisap()
    {
        $(".visap_index:last").parent().remove();
    }
    function toggle_profile()
    {
        var is_visible = ($("#profile_div:visible").length>0);
        if(is_visible!==false)
            $("#arrow_div").html('<span class="glyphicon glyphicon-chevron-down" ></span>');
        else
            $("#arrow_div").html('<span class="glyphicon glyphicon-chevron-up" ></span>');
        $("#profile_div").toggle('fast');
    }
    function divTog(inp)
    {
        if($("#"+inp).is(":visible")===true)
        {
            $("#"+inp+"_gly").removeClass("glyphicon-chevron-up").addClass("glyphicon-chevron-down");
            $("#"+inp).slideUp();
        }
        else
        {
            $("#"+inp+"_gly").removeClass("glyphicon-chevron-down").addClass("glyphicon-chevron-up");
            $("#"+inp).slideDown();
        }
    }
</script>