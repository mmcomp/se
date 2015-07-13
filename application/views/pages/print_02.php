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
    function replaceHashWithInput($hash,$body1,$data)
    {
        //var_dump($data);
        $vis_pos = -1;
        $array_vars = array();
        while($vis_pos!==FALSE)
        {
            $vis_pos = strpos($body1,"#".$hash."_",$vis_pos+1);
            if($vis_pos!==FALSE)
            {
                $vis_end = strpos($body1,"#",$vis_pos+2);
                $vis = substr($body1,$vis_pos+1,$vis_end-$vis_pos-1);
                $vis2 = str_replace("[", '', $vis);
                $vis2 = str_replace("]", '', $vis2);
                $val = ((isset($data[$vis2]))?$data[$vis2]:'');
                //echo "<br/>$vis2=><br/>";
                //var_dump($val);
                if(strpos($vis,'[]')!==FALSE)
                {
                    if(!isset($array_vars[$vis]))
                    {
                        $array_vars[$vis] = array(
                            "index"=>0,
                            "values"=>$val
                        );
                    }
                    if(isset($array_vars[$vis]["values"][$array_vars[$vis]["index"]]))
                    {
                        $val = $array_vars[$vis]["values"][$array_vars[$vis]["index"]];
                        $array_vars[$vis]["index"]++;
                    }
                    else
                    {
                        $val = '';
                    }
                }
                $body1 = substr($body1, 0, $vis_pos-1).'<input class="visa_input"  name="'.$vis.'" value="'.$val.'"/>'.substr($body1, $vis_end+1);
            }
        }
        //var_dump($array_vars);
        return($body1);
    }
    $factor_id = -1;
    if(trim($p1)!='')
        $factor_id = (int)$p1;
    $form_id = 2;
    if(trim($p2)!='')
        $form_id = (int)$p2;
    $body='';

    $ham_tmp = '';
    $data = array();
    $my = new mysql_class;
    if(isset($_REQUEST['save_form']))
    {
        $data = array();
        foreach($_REQUEST as $key=>$value)
        {
            if(strpos($key, "gasht_")!==FALSE)
            {
                $data[$key]=$value;
            }
        }
        //$data = $_REQUEST;
        $form_id = (int)$_REQUEST['save_form'];
        $tarikh = date("Y-m-d H:i:s");
        $my->ex_sqlx("insert into print_factor (`print_theme_id`, `factor_id`, `tarikh`, `user_id`,`data`) values ($form_id,$factor_id,'$tarikh',$user_id,'". json_encode($data, JSON_UNESCAPED_UNICODE)."')");
        //echo "insert into print_factor (`print_theme_id`, `factor_id`, `tarikh`, `user_id`,`data`) values ($form_id,$factor_id,'$tarikh',$user_id,'". json_encode($data, JSON_UNESCAPED_UNICODE)."')";
    }
    $my->ex_sql("select matn,matn2 from print_theme where id=$form_id order by id desc limit 1", $q);
    if(isset($q[0]))
    {
        $body = $q[0]['matn'];
        $ham_tmp = $q[0]['matn2'];
        $my->ex_sql("select data from print_factor where factor_id = $factor_id and print_theme_id = $form_id order by tarikh desc",$qq);
        if(isset($qq[0]))
        {
            $data1 = ((trim($qq[0]['data'])!='')?json_decode($qq[0]['data']):array());
            $data =(array)$data1;
        }
    }
    $hamrahan = '';
    /*
    $ham_tmp = <<<HAM
    <tr valign="top">
        <td width="25" height="2">
        <p align="center"><strong>#index#</strong></p>
        </td>
        <td width="124">
        <p align="center">#name#</p>
        </td>
        <td width="69">
        <p align="center">#pedar#</p>
        </td>
        <td width="88">
        <p dir="ltr" align="center">#passport#</p>
        </td>
        <td width="210">
        <p align="center"> #visa_hazine_mosafer[]# </p>
        </td>
    </tr>
HAM;
    */
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
            $ham_tmp1 = str_replace("#code_melli#", $mo['code_melli'], $ham_tmp1);
            $ham_tmp1 = str_replace("#tarikh_tavalod#",  jdate("d / m / Y",strtotime($mo['tarikh_tavalod'])), $ham_tmp1);
            $ham_out .= $ham_tmp1;
        }
        $u = new user_class($f->user_id);
        $fname1 = $u->fname;
        $lname1 = $u->lname;
        $user_creator = new user_class($f->user_creator);
        $body1 = str_replace("#fname1#", $fname1, $body);
        $body1 = str_replace("#user_sabti#", $user_creator->fname.' '.$user_creator->lname, $body1);
        //$body1 = str_replace("#hamrahan#", $ham_out, $body1);
        $body1 = str_replace("#hamrahan#", $ham_out, $body1);
        $body1 = str_replace("#lname1#", $lname1, $body1);
        $body1 = str_replace("#pedar_name#", $u->pedar_name,$body1);
        $body1 = str_replace("#pedar_name#", $u->pedar_name,$body1);
        $body1 = str_replace("#tarikh_tavalod#", jdate("d / m / Y", $u->tarikh_tavalod) ,$body1);
        $body1 = str_replace("#address#", $u->address,$body1);
        $body1 = str_replace("#tell#", $u->tell,$body1);
        $body1 = str_replace("#mob#", $u->mob,$body1);
        $body1 = $this->form_model->replaceHashWithInput("gasht",$body1,$data);

    }
?>
<style>
    .gasht_input{
        border : none;
    }
    .gasht_textarea{
        width: 100%;
        height: 100px;
    }
    .list_table input{
        width: 100%;
    }
    .gasht_input:hover{
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
    <div class="col-sm-10" >
        <div class="row">
            <div class="hs-float-left" >
                <button class="btn hs-btn-default btn-lg" >ثبت</button>
            </div>
            <div class="hs-float-left" >
                <a class="btn hs-btn-default btn-lg hs-margin-left-right" onclick="prin()" >چاپ</a>
            </div>
        </div>
        <div id="ifr" >
        <?php echo $body1; ?>
        </div>
        <input type="hidden" name="save_form" value="<?php echo $form_id; ?>"/>
    </div>
    </form>


</div>
<script>
    function prin()
    { 
        var b = $(".visa_input").css("border");
        $(".gasht_input").css("border","none");
        $(".gasht_textarea").css("border","none");
        $(".list_table input").css("width","100%");
        $(".gasht_textarea").css("width","100%");
        $(".gasht_textarea").css("height","50px");
        var pageNo = 'چاپ';
        var headElements =  '<meta charset="utf-8" >,<meta http-equiv="X-UA-Compatible" content="IE=edge" >' ;
        var options = { mode : 'popup', popClose :true, extraCss : '', retainAttr : ["class", "id", "style", "on"], extraHead : headElements ,popHt: 500,popWd: 700,popTitle:pageNo};
        //$("#ifr").css("width","21cm");
        $("#ifr").printArea(options);
        $(".gasht_input").css("border",b);
        $(".gasht_textarea").css("border",b);
    }
</script>