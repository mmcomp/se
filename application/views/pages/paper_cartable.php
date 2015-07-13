<?php
    $header = array(
        "normal" => 'کارتابل',
        "archive"=>'بایگانی',
        "sent"=>'نامه های ارسالی',
        "pishnevis"=>'پیشنویس ها'
    );
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
    $out = '';
    $type_id = ((isset($_REQUEST['type_id']))?(int)$_REQUEST['type_id']:$p2);
    if((int)$type_id==0)
        $type_id = -1;
    if(trim($p1)=='')
        redirect ("paper_cartable/normal");
    if($p1=='archive')
    {
        $data = $this->cartable_model->loadAll($user_id,$type_id,4);
    }
    else if($p1=='normal')
    {
        $data = $this->cartable_model->loadAll($user_id,$type_id,-1);
    }
    else if($p1 == 'sent')
    {
        $data = $this->cartable_model->loadSent($user_id,$type_id);
    }
    else if($p1 == 'pishnevis')
    {
        $data = $this->cartable_model->loadPishnevis($user_id,$type_id);
    }
    //var_dump($data);
    foreach($data as $let)
    {
        if($p1 == 'pishnevis')
            $let['vaziat'] = 0;
        $roonevesht = ((int)$let['is_roonevesht']===1)?'<span data-trigger="hover" data-container="body" data-toggle="popover" data-placement="bottom" data-content="رونوشت می باشد" class="glyphicon glyphicon-tags"></span>':'';
        $stat = (((int)$let['vaziat']===1)?'envelope':'check');
        $read = '<span class="glyphicon glyphicon-'.$stat.'"></span>';
        $dar = $let['fname'].' '.$let['lname'];
        $dart = '';
        if($p1 == 'sent')
        {
            $dar = '';
            foreach($let['daryaft'] as $di=>$nam)
            {
                $dar .= (($dar=='')?'':',').$nam['fname'].' '.$nam['lname'];
                $dart .= (($dart=='')?'':',').$nam['fname'].' '.$nam['lname'];
            }
        }
        $out .= '<div class="row hs-border hs-padding hs-margin-up-down mm-letter-vaziat-'.$let['vaziat'].'"><div class="col-sm-1">'.$read.'&nbsp;&nbsp;'.$roonevesht.'</div><div class="col-sm-4"><a href="'.  site_url().'paper_view/'.$let['id'].'/'.$p1.'">'.$let['mozoo'].'</a></div><div class="col-sm-1">'.$let['shomare'].'</div><div class="col-sm-3" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="bottom" data-content="'.$dart.'">'.$this->inc_model->substrH($dar,20).'</div><div class="col-sm-1">'.$let['tname'].'</div><div class="col-sm-2">'.$let['tarikh'].'</div></div>';
    }
    $types = type_class::loadAll(FALSE);
    $typ_txt = '<li'.(($type_id==-1)?' class="active"':'').' role="presentation"><a href="'.  site_url().'paper_cartable/'.$p1.'/">همه</a></li>';
    foreach($types as $tt)
    {
        $id = $tt['id'];
        $t  = $tt['name'];
        $typ_txt .= '<li'.(($id==$type_id)?' class="active"':'').' role="presentation"><a href="'.  site_url().'paper_cartable/'.$p1.'/'.$id.'">'.$t.'</a></li>';
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
        <div class="col-sm-12">
            <div  class="hs-margin-up-down hs-gray hs-padding hs-border mm-negative-margin" >
            <?php echo isset($header[$p1])?$header[$p1]:''; ?>
            </div>
            <div class="hs-margin-up-down" >
                <ul class="nav nav-tabs">
                    <?php
                        echo $typ_txt;
                    ?>
                </ul>
            </div>
            <div class="row hs-border hs-padding hs-margin-up-down mm-letter-vaziat-0"><div class="col-sm-1"></div><div class="col-sm-4">موضوع</div><div class="col-sm-1">شماره</div><div class="col-sm-3"><?php echo ($p1 == 'sent')?'گیرنده':'فرستنده'; ?></div><div class="col-sm-1">نوع</div><div class="col-sm-2">تاریخ</div></div>
            <?php echo $out; ?>
        </div>
    </div>
</div>