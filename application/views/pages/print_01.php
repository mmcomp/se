<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');

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
    $factor_id = -1;
    if(trim($p1)!='')
        $factor_id = (int)$p1;
    $form_id = 1;
    if(trim($p2)!='')
        $form_id = (int)$p2;
    $my = new mysql_class;
    if(isset($_REQUEST['save_form']))
    {
        $data = array();
        foreach($_REQUEST as $key=>$value)
        {
            if(strpos($key, "visa_")!==FALSE)
            {
                $data[$key]=$value;
            }
        }
        $form_id = (int)$_REQUEST['save_form'];
        $tarikh = date("Y-m-d H:i:s");
        $my->ex_sqlx("insert into print_factor (`print_theme_id`, `factor_id`, `tarikh`, `user_id`,`data`) values ($form_id,$factor_id,'$tarikh',$user_id,'". json_encode($data,JSON_UNESCAPED_UNICODE)."')");
    }
    $body='';
    $logo = asset_url()."img/donya_logo.jpg";
    $ham_tmp = '';
    $data = array();
    $print_title =" ویزای انفرادی شینگن";
    $my->ex_sql("select matn,matn2,name from print_theme where id=$form_id", $q);
    if(isset($q[0]))
    {
        $body = $q[0]['matn'];
        $ham_tmp = $q[0]['matn2'];
        $print_title = $q[0]['name'];
        $my->ex_sql("select data from print_factor where factor_id = $factor_id and print_theme_id = $form_id order by tarikh desc",$qq);
        if(isset($qq[0]))
        {
            $data1 = ((trim($qq[0]['data'])!='')?json_decode($qq[0]['data']):array());
            $data =(array)$data1;
        }
    }
    $hamrahan = '';
    $f = new factor_class($factor_id);
    $body1 = 'اطلاعاتی موجود نیست';
    if(isset($f->id))
    {
        $mos = mosafer_class::loadByFactor($factor_id);
        $ham_out = '';
        foreach($mos as $i=>$mo)
        {
            $ham_tmp1 = str_replace("#index#", ($i+1), $ham_tmp);
            $ham_tmp1 = str_replace("#name#", $mo['fname'].' '.$mo['lname'], $ham_tmp1);
            $ham_tmp1 = str_replace("#pedar#", '', $ham_tmp1);
            $ham_tmp1 = str_replace("#passport#", $mo['passport'], $ham_tmp1);
            $ham_out .= $ham_tmp1;
        }
        $u = new user_class($f->user_id);
        $fname1 = $u->fname;
        $lname1 = $u->lname;
        $body1 = str_replace("#fname1#", $fname1, $body);
        $body1 = str_replace("#hamrahan#", $ham_out, $body1);
        $body1 = str_replace("#lname1#", $lname1, $body1);
        $body1 = str_replace("#logo#", $logo, $body1);
        $body1 = str_replace("#address#", $u->address, $body1);
        $body1 = str_replace("#tel#", $u->tell, $body1);
        $body1 = $this->form_model->replaceHashWithInput("visa",$body1,$data);

    }
?>
<style>
    .visa_input,.visa_textarea{
        border : none;
    }
    .visa_input:hover,.visa_textarea:hover{
        border : red 1px dashed;
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
    <form method="post">
        <div class="hs-float-left hs-margin-up-down text-center row">
            <div class="col-sm-12">
                <a href="#" class="btn hs-btn-default btn-lg" onclick="prin();">چاپ</a> <button class="btn hs-btn-default btn-lg">ثبت</button>
            </div>
        </div>
        <div class="col-sm-10">
        <div id="ifr">
            <?php echo $body1; ?>
        </div>
        <input type="hidden" name="save_form" value="<?php echo $form_id; ?>"/>

    </div>
    </form>
</div>
<script>
    var saved = true;
    $(document).ready(function(){
        $("input,textarea").keypress(function(){
            saved = false;
        });
    });
    function prin()
    {
        if(saved)
        {
            var b = $(".visa_input").css("border");
            var c = $(".visa_textarea").css("border");
            $(".visa_input").css("border","none");
            $(".visa_textarea").css("border","none");
            var pageNo = '<?php echo $print_title; ?>';
            var headElements =  '<meta charset="utf-8" >,<meta http-equiv="X-UA-Compatible" content="IE=edge" >' ;
            var options = { mode : 'popup', popClose :true, extraCss : '', retainAttr : ["class", "id", "style", "on"], extraHead : headElements ,popHt: 500,popWd: 700,popTitle:pageNo};
            $("#ifr").printArea(options);
            $(".visa_input").css("border",b);
            $(".visa_textarea").css("border",c);
        }
        else
        {
            alert('ابتدا فرم را ذخیره کنید');
        }
    }
</script>