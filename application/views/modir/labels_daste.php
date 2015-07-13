<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
        $gname1 = "gname_tabaghe";
	$input =array($gname1=>array('table'=>'labels_daste','div'=>'div_label_daste'));
        $xgrid1 = new xgrid($input,site_url().'modir/labels_daste?');
        $xgrid1->column[$gname1][0]['name']= '';
        $xgrid1->column[$gname1][1]['name'] = 'نام دسته';
        //$xgrid1->column[$gname1][2]['name'] = 'نشانی آی پی';
        $xgrid1->canEdit[$gname1]=TRUE;
        $xgrid1->canAdd[$gname1]=TRUE;
        //$xgrid1->canDelete[$gname1]=TRUE;
        $out =$xgrid1->getOut($_REQUEST);
        if($xgrid1->done)
                die($out);
?>
<script>
    var ggname_project ="<?php echo $gname1; ?>";
    $(document).ready(function(){
        var args=<?php echo $xgrid1->arg; ?>;
        //args[ggname_project]['afterLoad']=after_grid;
        intialGrid(args);
    });
</script>
<div id="div_label_daste" class="hs-margin-up-down" style="font-family: tahoma;" ></div>