<?php
    function loadUser($id)
    {
        $u = new user_class((int)$id);
        $out = '----';
        if(isset($u->fname))
        {
            $out = $u->fname."‌".$u->lname;
        }
        return($out);
    }
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $msg = '';
    $user_id1 = -1;
    if(trim($p1)!='')
        $user_id1 = (int)$p1;
    else if(isset($_REQUEST['user_id']))
        $user_id1 = (int)$_REQUEST['user_id'];
    $all = (trim($p2)=='all');
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
    
    $this->profile_model->loadUser($user_id1);
    $user_obj = $this->profile_model->user;
    $user_data = "کاربری انتخاب نشده است از قسمت جستجو ، بر اساس شماره ملی ، کاربر مورد نظر را پیدا کنید";
    if(isset($user_obj->fname))
    {
        $user_data = <<< TTT
            کاربر: 
            $user_obj->fname $user_obj->lname
            شماره ملی:
            $user_obj->code_melli
TTT;
    }
    if(isset($_REQUEST['factor_id']))
    {
        factor_class::tasfie((int)$_REQUEST['factor_id']);
    }
    $fs = factor_class::loadByUser($user_id1,$all);
    //var_dump($fs);
    $facs = '';
    foreach($fs as $i=>$f)
    {
        $tmp = <<< TMP
        <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down#pointer#" #click#">
            <div class="col-sm-1">
                #i##tick#
            </div>
            <div class="col-sm-1">
                #factor_id#
            </div>
            <div class="col-sm-1">
                #tarikh#
            </div>
            <div class="col-sm-1">
                #user_creator#
            </div>
            <div class="col-sm-3"  data-trigger="hover" data-container="body" data-toggle="popover" data-placement="bottom" data-content="#khadamat2#">
                #khadamat#
            </div>
            <div class="col-sm-1">
                #mablagh#
            </div>
            <div class="col-sm-1">
                #commision#
            </div>
            <div class="col-sm-1">
                #takhfif#
            </div>
            <div class="col-sm-1">
                #jaieze#
            </div>
            <div class="col-sm-1">
                #ghimat#
            </div>
        </div> 
TMP;
        $khadamat = '';
        $parsd = parvaz_class::loadByFactor($f['id']);
        if(count($parsd)>0)
            $khadamat.="پرواز:";
        foreach($parsd as $pars)
        {
            $khadamat.=$pars['mab']." ".$pars['mag']." ".$this->inc_model->perToEnNums(jdate("Y/m/d",  strtotime($pars['tarikh'])))."-";
        }
        $hotsd = hotel_class::loadByFactor($f['id']);
        if(count($hotsd)>0)
            $khadamat.="هتل:";
        foreach($hotsd as $hots)
        {
            $khadamat.=$hots['name']." ".$this->inc_model->perToEnNums(jdate("Y/m/d",  strtotime($hots['az_tarikh'])))." ".$this->inc_model->perToEnNums(jdate("Y/m/d",  strtotime($hots['ta_tarikh'])))."-";
        }
        $ghimat = (int)$f['mablagh']-((int)$f['commision']+(int)$f['takhfif']);
        $tmp2 = str_replace("#i#", $i+1, $tmp);
        $tmp2 = str_replace("#tarikh#", $this->inc_model->perToEnNums(jdate("Y/m/d",  strtotime($f['tarikh']))), $tmp2);
        $tmp2 = str_replace("#user_creator#", loadUser($f['user_creator']), $tmp2);
        $tmp2 = str_replace("#khadamat#", $this->inc_model->substrH($khadamat,10), $tmp2);
        $tmp2 = str_replace("#khadamat2#", $khadamat, $tmp2);
        $tmp2 = str_replace("#mablagh#", $this->inc_model->monize($f['mablagh']), $tmp2);
        $tmp2 = str_replace("#commision#", $this->inc_model->monize($f['commision']), $tmp2);
        $tmp2 = str_replace("#takhfif#", $this->inc_model->monize($f['takhfif']), $tmp2);
        $tmp2 = str_replace("#jaieze#", $this->inc_model->monize($f['jaieze']), $tmp2);
        $tmp2 = str_replace("#ghimat#", $this->inc_model->monize($ghimat), $tmp2);
        if($all)
        {
            $tmp2 = str_replace("#click#",'', $tmp2);
            $tmp2 = str_replace("#pointer#", '', $tmp2);
            if((int)$f['is_tasfieh']==1)
                $tick='<span id="hotel_div_gly" class="glyphicon glyphicon-check"></span>';
            else
                $tick="";
            $tmp2 = str_replace("#tick#", $tick, $tmp2);
        }
        else
        {
            $tmp2 = str_replace("#tick#", '', $tmp2);
            $tmp2 = str_replace("#pointer#", ' pointer', $tmp2);
            $tmp2 = str_replace("#click#",'onclick="tasfieh(#factor_id#);', $tmp2);
        }
        $tmp2 = str_replace("#factor_id#", $f['id'], $tmp2);
        $facs .= $tmp2;
    }
    if($all)
        $tit = "فاکتورها"." <a href='".  site_url()."hesab_factor/$user_id1'>پرداخت نشده ها</a>";
    else
        $tit = "پرداخت نشده ها"." <a href='".  site_url()."hesab_factor/$user_id1/all'>مشاهده همه</a>";
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
    <div class="col-sm-10" >
        <div class="row hs-margin-up-down hs-gray hs-padding hs-border">
           <?php echo $tit; ?>
        </div>
        <div  class="hs-margin-up-down hs-gray hs-padding hs-border mm-negative-margin" >
            <?php echo $user_data; ?>
        </div>
        <div class="row hs-border hs-padding mm-letter-vaziat-0 hs-margin-up-down">
            <div class="col-sm-1">
                ردیف
            </div>
            <div class="col-sm-1">
                شماره
            </div>
            <div class="col-sm-1">
                تاریخ
            </div>
            <div class="col-sm-1">
                کانتر
            </div>
            <div class="col-sm-3">
                خدمات
            </div>
            <div class="col-sm-1">
                مبلغ
            </div>
            <div class="col-sm-1">
                کمیسیون
            </div>
            <div class="col-sm-1">
                تخفیف
            </div>
            <div class="col-sm-1">
                جایزه
            </div>
            <div class="col-sm-1">
                کل
            </div>
        </div>
        <?php echo $facs; ?>
        <form method="post" id="frm_factor">
            <input type="hidden" name="factor_id" id="factor_id"/>
        </form>
    </div>    
</div>
<script>
    function tasfieh(factor_id)
    {
        if(confirm('آیا فاکتور شماره '+factor_id+' تسفیه شود؟'))
        {
            $("#factor_id").val(factor_id);
            $("#frm_factor").submit();
        }
    }
</script>