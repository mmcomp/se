<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    function loadGrp()
    {
        return(group_class::loadAll());
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
    $tarikh='';
    if($this->input->get('tarikh_se')!==FALSE)
    {
        $tarikh = $this->input->get('tarikh_se');
    } 
    /*
    $my = new mysql_class;
    $ss = $my->fetch_field('user');
    var_dump($ss);
    * 
     */
    $gname1 = "gname_user";
    $input =array($gname1=>array('table'=>'user','div'=>'div_user'));
    $xgrid1 = new xgrid($input,site_url().'user_edit?');
    $xgrid1->pageRows[$gname1]=30;

    //$xgrid1->whereClause[$gname1] = " (browser<>'Mozilla' and platform<>'Unknown Platform' and robot='') order by tarikh desc";
    $xgrid1->column[$gname1][0]['name']= '';
    for($i=1;$i< count($xgrid1->column[$gname1]);$i++)
    {
        $xgrid1->column[$gname1][$i]['name']='';
    }
    $xgrid1->column[$gname1][1]['name'] = 'نام';
    $xgrid1->column[$gname1][2]['name'] = 'نام خانوادگی';
    $xgrid1->column[$gname1][3]['name'] = 'کد ملی';
    $xgrid1->column[$gname1][11]['name'] = 'نام کاربری';
    $xgrid1->column[$gname1][15]['name'] = 'گروه کاربری';
    $xgrid1->column[$gname1][15]['clist'] = loadGrp();
    //$xgrid1->column[$gname1][12]['name'] = 'رمز عبور';
    //$xgrid1->column[$gname1][3]['cfunction'] = array('urldecode'); 

    $xgrid1->canEdit[$gname1]=TRUE;
    $xgrid1->canAdd[$gname1]=TRUE;
    $xgrid1->canDelete[$gname1]=TRUE;
    $out =$xgrid1->getOut($_REQUEST);
    if($xgrid1->done)
            die($out);
?>
<script>
    var ggname_project ='<?php echo $gname1; ?>';
    $(document).ready(function(){
        var args=<?php echo $xgrid1->arg; ?>;
        args[ggname_project]['afterLoad']=function(){
            $("select").css("width","100%");
            $("#pageNumber-gname_user").css("width","50px");
            $("select").select2({
                dir:'rtl'
            });
            $($(".ajaxgrid_bottomTable td")[0]).append('<button class="btn hs-btn-default" id="deleteRow-gname_user" onclick="editProfile();">ویرایش</button>');
        };
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
            مدیریت کاربران
            </div>






                <div id="div_user" ></div>



        </div>
    </div>
</div>