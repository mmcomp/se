<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $factor_id = -1;
    if(trim($p1)!='')
        $factor_id = (int)$p1;
    factor_class::marhale((int)$factor_id,'khadamat_5'); 
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
    $my = new mysql_class;
    $jam_khadamat = 0;
    $jam_commision = 0;
    $jam_jayeze = 0;
    $my->ex_sql("select sum(mablagh) as mab,sum(comission) comm,sum(jayeze)  `jayz` from `khadamat_factor` where factor_id=$factor_id", $q);
    if(isset($q[0]))
    {
        $jam_khadamat = (int)$q[0]['mab'];
        $jam_commision = (int)$q[0]['comm'];
        $jam_jayeze = (int)$q[0]['jayz'];
    }
    $jam_pardakht = $jam_khadamat - ($jam_commision+$jam_jayeze);
  
    $forms = '';
    $my->ex_sql("select * from  print_theme order by name", $q);
    foreach($q as $r)
    {
        $id = (((int)$r['id']<10)?'0':'').$r['id'];
        $sid = (int)$r['id'];
        $forms .= "<div class=\"col-sm-6 col-xs-12 col-md-3 hs-border hs-padding hs-margin-up-down text-center mm-hover pointer\"  onclick=\"window.location='".  site_url()."print_$id/$factor_id/$sid';\"><span>".$r['name']."</span></div>";
    }
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
        <?php
            echo $this->inc_model->loadProgress(5,$p1);
            echo "<div class='text-center hs-margin-up-down' ><div class='label label-danger' style='font-size:100%' >شماره فاکتور: $p1</div></div>"; 

        ?>
        <div class="row hs-margin-up-down hs-gray hs-padding hs-border">
            قابل پرداخت
        </div>
        <div class="row" >
            <div class="col-sm-2">جمع خدمات</div>
            <div class="col-sm-2"><?php echo $this->inc_model->monize($jam_khadamat); ?></div>
            <div class="col-sm-2">جمع کمیسیون/تخفیف</div>
            <div class="col-sm-2"><?php echo $this->inc_model->monize($jam_commision); ?></div>
            <div class="col-sm-2">جمع جایزه ها</div>
            <div class="col-sm-2"><?php echo $this->inc_model->monize($jam_jayeze); ?></div>
        </div>
        <div class="row" >         
            <div class="col-sm-2 col-sm-offset-8"> قابل پرداخت</div>
            <div class="col-sm-2"><?php echo $this->inc_model->monize($jam_pardakht); ?></div>
        </div>
        <div class="row hs-margin-up-down hs-gray hs-padding hs-border">
            فرم ها
        </div>
        <div class="row" >
            <?php echo $forms; ?>
        </div>
    </div>    
</div>