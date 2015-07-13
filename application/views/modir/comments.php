<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $GLOBALS['ci'] = $this;
    function loadContent($inp)
    {
        $cont = $GLOBALS['ci']->contents_model->getContentsById($inp);
        return(isset($cont->id)?$cont->name:'');
    }
    function tarikh($inp)
    {
        return($GLOBALS['ci']->contents_model->tarikh($inp));
    }
    function loadEn($inp)
    {
        if((int)$inp==1)
        {    
            $src='greentick.png';
        }
        else
        {
            $src='redcross.png';
        }
        $out = '<img style=\'width:30px;\' src=\''.asset_url().'/img/'.$src.'\' >';
        return($out);
    }
    if($this->input->get('ids')!==FALSE)
    {
        $ids = $this->input->get('ids');
        $en =(int) $this->input->get('en');
        $this->comments_model->setEn($ids,$en);
        die('ok');
    }    
    $gname1 = "gname_tabaghe";
    $input =array($gname1=>array('table'=>'comments','div'=>'div_comments'));
    $xgrid1 = new xgrid($input,site_url().'modir/comments?');
    $xgrid1->whereClause[$gname1] = ' 1=1 order by tarikh desc,en';
    $xgrid1->column[$gname1][0]['name']= '';
    $xgrid1->column[$gname1][1]['name'] = 'نام صفحه';
    $xgrid1->column[$gname1][1]['cfunction'] =array('loadContent');
    
    $xgrid1->column[$gname1][2]['name'] = 'وضعیت';
    $xgrid1->column[$gname1][2]['cfunction'] =array('loadEn');
    $xgrid1->column[$gname1][2]['access']='q';
    
    $xgrid1->column[$gname1][6]['name'] = 'تاریخ';
    $xgrid1->column[$gname1][6]['cfunction'] =array('tarikh');
    $xgrid1->column[$gname1][6]['access']='q';
    //$xgrid1->column[$gname1][2]['name'] = 'نشانی آی پی';
    $xgrid1->canEdit[$gname1]=TRUE;
    //$xgrid1->canAdd[$gname1]=TRUE;
    $xgrid1->canDelete[$gname1]=TRUE;
    $out =$xgrid1->getOut($_REQUEST);
    if($xgrid1->done)
            die($out);
?>
<script>
    var ggname_project ="<?php echo $gname1; ?>";
    var args=<?php echo $xgrid1->arg; ?>;
    $(document).ready(function(){
        args[ggname_project]['afterLoad']=function(){
            addEn();
            getIds();
        };
        intialGrid(args);
    });
    function addEn()
    {
        tmp = '<button class="uk-button-primary" onclick="setEn(1);" >انتشار</button>';
        tmp += '<button class="uk-button-primary" onclick="setEn(0);" >عدم انتشار</button>';
        tmp += '<span id="khoon" ></span>';
        $("#deleteRow-gname_tabaghe").parent().append(tmp);
    }
    function getRowId(rowNum,gname)
    {
            return(trim($("#"+gname+"-span-id-"+rowNum).html()));
    }
    function getIds()
    {
        var ids = '';
        var rowNums = [];
        $.each($(".ajaxgrid_checkSelect"),function(id,field){
                var tmp = field.id.split('-');
                if(tmp[1] == ggname_project && field.checked)
                {
                        rowNums[rowNums.length] = tmp[2];
                        var realId = getRowId(tmp[2],ggname_project);
                        ids += ((ids != '')?',':'')+realId;
                }
        });
        return (ids);
    }
    function setEn(en)
    {
        if(confirm("آیا عملیات انجام شود؟"))
        {    
            $("#khoon").html('<img src="<?php echo asset_url() ?>img/stat.gif" >');
            obj = {"ids":getIds(),"en":en};
            $.get("<?php echo site_url(); ?>modir/comments",obj,function(res){
                $("#khoon").html('');
                intialGrid(args);
            });
        }
    }
</script>
<div id="div_comments" style="margin-bottom: 10px;font-family: tahoma;" ></div>