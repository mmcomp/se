<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    function addfn($gname,$table,$fields,$col)
    {
        $khadamat_id = (int)$_REQUEST['khadamat_id'];
        $name = $fields['name'];
        $toz = $fields['toz'];
        $my = new mysql_class;
        $my->ex_sqlx("insert into `khadamat_tamin` (`khadamat_id`,`name`,`toz`) values ($khadamat_id,'$name','$toz')");
        return(TRUE);
    }
    $this->profile_model->loadUser($user_id);
    $men = $this->profile_model->loadMenu();
    $msg = '';
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
    $msg = '';
    $khadamat_id=0;
    if($this->input->get('khadamat_id')!==FALSE)
    {
        $khadamat_id = (int)$this->input->get('khadamat_id');
    }
    $khadamat = null;
    if($khadamat_id<=0)
    {
        $msg = '<div class="alert alert-danger">خدماتی انتخاب نشده</div>';
    }
    else
    {
        $khadamat = new khadamat_class($khadamat_id);
        if(!isset($khadamat->name))
        {
            $msg = '<div class="alert alert-danger">خدماتی پیدا نشده</div>';
        }
    }
    /*
    $my = new mysql_class;
    $ss = $my->fetch_field('user');
    var_dump($ss);
    * 
     */
    $gname1 = "gname_khadamattamin";
    $input =array($gname1=>array('table'=>'khadamat_tamin','div'=>'div_khadamattamin'));
    $xgrid1 = new xgrid($input,site_url().'khadamat_tamin?');
    $xgrid1->pageRows[$gname1]=30;
    $xgrid1->whereClause[$gname1] = " khadamat_id = $khadamat_id";
    $xgrid1->eRequest[$gname1] = array(
        "khadamat_id"=>$khadamat_id
    );
    $xgrid1->column[$gname1][0]['name']= '';
    $xgrid1->column[$gname1][1]['name'] = 'نام';
    $xgrid1->column[$gname1][2]['name'] = 'توضیحات';
    $xgrid1->column[$gname1][3]['name'] = '';
/*
    $xgrid1->column[$gname1][0]['name']= '';
    $xgrid1->column[$gname1][1]['name'] = 'نام';
    $xgrid1->column[$gname1][2]['name'] = 'توضیحات';
    $xgrid1->column[$gname1][3]['name'] = 'نوع';
    $xgrid1->column[$gname1][3]['clist'] = array(
        "نوع خدمات","پرواز","هتل","تور","ویزایی با شماره ملی","ویزایی با شماره پاسپورت"
    );
    $xgrid1->column[$gname1][4]['name'] = '';
    $xgrid1->column[$gname1][5]['name'] = 'قیمت';
    //$xgrid1->whereClause[$gname1] = " (browser<>'Mozilla' and platform<>'Unknown Platform' and robot='') order by tarikh desc";
    for($i=1;$i< count($xgrid1->column[$gname1]);$i++)
    {
        $xgrid1->column[$gname1][$i]['name']='';
    }
    $xgrid1->column[$gname1][11]['name'] = 'نام کاربری';
    $xgrid1->column[$gname1][15]['name'] = 'گروه کاربری';
    $xgrid1->column[$gname1][15]['clist'] = loadGrp();
    //$xgrid1->column[$gname1][12]['name'] = 'رمز عبور';
    //$xgrid1->column[$gname1][3]['cfunction'] = array('urldecode'); 
*/
    $xgrid1->addFunction[$gname1] = 'addfn';
    if(isset($khadamat->name))
    {
        $xgrid1->canEdit[$gname1]=TRUE;
        $xgrid1->canAdd[$gname1]=TRUE;
        $xgrid1->canDelete[$gname1]=TRUE;
    }
    $out =$xgrid1->getOut($_REQUEST);
    if($xgrid1->done)
            die($out);
?>
<script>
    var ggname_project ='<?php echo $gname1; ?>';
    $(document).ready(function(){
        var args=<?php echo $xgrid1->arg; ?>;
        /*
        args[ggname_project]['afterLoad']=function(){
            $("select").css("width","100%");
            $("#pageNumber-gname_user").css("width","50px");
            $("select").select2({
                dir:'rtl'
            });
            $($(".ajaxgrid_bottomTable td")[0]).append('<button class="btn hs-btn-default" id="deleteRow-gname_user" onclick="editProfile();">ویرایش</button>');
        };
        */
        intialGrid(args);
    });
    function editProfile(){
        var selected_user_id = -1;
        if($(".ajaxgrid_checkSelect:checked").length===1)
        {
            $(".ajaxgrid_checkSelect:checked").each(function (id, field){
                var row_num = $(field).prop('id').split('-')[2];
                selected_user_id = $("#gname_user-span-id-"+row_num).html().trim();
                window.open("profile/"+selected_user_id);
            });
        }
        else
            alert("حتما یک کاربر می بایست انتخاب شود");
    }
</script>
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
        <div class="col-sm-12">
            <div  class="hs-margin-up-down hs-gray hs-padding hs-border mm-negative-margin" >
                مدیریت خدمات تامین کنندگان <?php echo (isset($khadamat->name)?$khadamat->name:''); ?> <a href="<?php echo site_url()?>khadamat"> بازگشت </a>
            </div>
                <?php echo $msg; ?>





                <div id="div_khadamattamin" ></div>



        </div>
    </div>
</div>