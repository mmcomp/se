<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
        $tarikh='';
        if($this->input->get('tarikh_se')!==FALSE)
        {
            $tarikh = $this->input->get('tarikh_se');
        }     
        $gname1 = "gname_tabaghe";
	$input =array($gname1=>array('table'=>'visitors','div'=>'div_ghimat_tabaghe'));
        $xgrid1 = new xgrid($input,site_url().'modir/amar?');
        $xgrid1->pageRows[$gname1]=30;
        $xgrid1->whereClause[$gname1] = " (browser<>'Mozilla' and platform<>'Unknown Platform' and robot='') order by tarikh desc";
        $xgrid1->column[$gname1][0]['name']= '';
        $xgrid1->column[$gname1][1]['name'] = 'نام صفحه';
        $xgrid1->column[$gname1][2]['name'] = 'نشانی آی پی';
        $xgrid1->column[$gname1][3]['cfunction'] = array('urldecode'); 
        //$xgrid1->canEdit[$gname1]=TRUE;
        //$xgrid1->canAdd[$gname1]=TRUE;
        //$xgrid1->canDelete[$gname1]=TRUE;
        $out =$xgrid1->getOut($_REQUEST);
        if($xgrid1->done)
                die($out);
       
        $today =  $this->visitor_model->oneDay($tarikh);
?>
<script>
    var ggname_project ='<?php echo $gname1; ?>';
    $(document).ready(function(){
        var args=<?php echo $xgrid1->arg; ?>;
        //args[ggname_project]['afterLoad']=after_grid;
        intialGrid(args);
    });
</script>
<form>
<div style="height: 50px;margin-top: 20px;" >
        <span class="uk-alert" >
        بازدید :
        <?php echo $today['today_visit']-$today['robot_visit']; ?>
        </span>
        <span class="uk-alert uk-alert-success" >
        تعداد تلفن همراه:
        <?php echo $today['mobile_visit']; ?>
        </span>
        <span class="uk-alert uk-alert-danger" >
        تعداد  روبوتها:
        <?php echo $today['robot_visit']; ?>
        </span>
        <span class="uk-alert uk-alert-warning" >
        تعداد  ارجاع ها:
        <?php echo $today['refer_visit']; ?>
        </span>
        <span>
                تاریخ:
                <input style="direction: ltr;" type="date" name="tarikh_se" value="<?php echo $tarikh==''?date("Y-m-d"):$tarikh; ?>">     
                <button class="uk-button uk-button-primary" >ارسال</button>
        </span>
</div>
</form>

<div id="div_ghimat_tabaghe" style="margin-bottom: 10px;font-family: tahoma;" ></div>