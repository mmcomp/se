<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $msg = '';
    $user_id1 = -1;
    if(trim($p1)!='')
        $user_id1 = (int)$p1;
    else if(isset($_REQUEST['user_id']))
        $user_id1 = (int)$_REQUEST['user_id'];
 
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
        <div class="row hs-border hs-padding hs-margin-up-down hs-gray">
            چاپ فرم
        </div>
    </div>    
</div>
