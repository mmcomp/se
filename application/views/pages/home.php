<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    if(isset($_REQUEST['s_code_melli']) && trim($_REQUEST['s_factor_id'])=='')
    {
        $user_obj = new user_class;
        $user_obj->loadByCodeMelli(trim($_REQUEST['s_code_melli']));
        if(!isset($user_obj->id))
        {
            $msg = '<div class="alert alert-danger">'."کاربر مورد نظر پیدا نشد".'</div>';
        }
        else
        {
            $u = new user_class($user_id);
            if((int)$u->group_id==4)
            {
                redirect("hesab_factor/".$user_obj->id);
            }
            else
            {
                redirect("profile?s_user_id=".$user_obj->id);
            }
        }
    }
    else if(isset($_REQUEST['s_factor_id']) && trim($_REQUEST['s_code_melli'])=='')
    {
        $f = new factor_class((int)$_REQUEST['s_factor_id']);
        if(isset($f->marhale))
        {
            redirect($f->marhale."/".(int)$_REQUEST['s_factor_id']);
        }
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

    $conf = new conf();
    if($conf->home_page!='home' and trim($conf->home_page)!='')
        redirect($conf->home_page);
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
    <div class="col-sm-8" >
        <div class="hs-margin-up-down" >
       <?php
            //echo $this->contents_model->loadHome();
            echo $msg;
        ?>
        </div>
    </div>
</div>