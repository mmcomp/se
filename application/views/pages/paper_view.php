<?php
    function loadAtt($attach)
    {
        $att = '';
        if(isset($attach) && count($attach)>0)
        {
            for($i = 0;$i < count($attach);$i++)
            {
                if($attach[$i]['type_name'] === 'pic')
                    $icon = '<span class="glyphicon glyphicon-picture"></span>';
                else
                    $icon = '<img width="15px" src="'.  site_url().'assets/img/'.$attach[$i]['type_name'].'-icon.png" />';
                $icon .= '<span class="glyphicon glyphicon-minus" style="cursor:pointer;" onclick="delAtt('.$attach[$i]['id'].');"></span><img id="khoon_'.$attach[$i]['id'].'" src="'.  asset_url().'img/stat.gif" style="width: 15px;display:none;"/>';
                $att .= '<div class="col-sm-3 hs-border  hs-padding"><div class="col-sm-9" ><span><a target="_blank" data-trigger="hover" data-container="body" data-toggle="popover" data-placement="bottom" data-content="'.$attach[$i]['toz'].'" data-original-title="" title="" href="'.  site_url().'upload/'.$attach[$i]['addr'].'">'.$attach[$i]['addr'].'</a></span></div><div class="col-sm-3" >'.$icon.'</div></div>';
            }
        }
        return($att);
    }
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    if(isset($_REQUEST['att_del_id']))
    {
        $o = 'OK';
        letter_det_attach_class::delete((int)$_REQUEST['att_del_id']);
        die($o);
    }
    if($this->input->get('pass_emza')!==FALSE && $this->input->get('user_iid')!==FALSE)
    {    
        $ou = user_class::auth2($this->input->get('user_iid'),$this->input->get('pass_emza'));
        die("$ou");
    }
    $this->profile_model->loadUser($user_id);
    $men = $this->profile_model->loadMenu();
    $msg = '';
    $menu_links = '';
    //$letter_id= $this->input->get_post('letter_id')!==FALSE?(int)$this->input->get_post('letter_id'):-1;
    $letter_id= (int)$p1;
    $lett = new letter_class($letter_id);
    $lett_det = new letter_det_class;
    $erjas = $lett_det->loadAllText($letter_id);
    if($p2=='normal')
        $lett_det->seen($letter_id,$user_id);
    $sender_id = $lett->user_creator_id;
    $matns = '';
    foreach($erjas as $i=>$erja)
    {
        $emza1 = ((int)$erja['emza']===1)?'greentick.png':'redcross.png';
        if($p2 != 'pishnevis')
        {
            $matns .='<div class="col-sm-12 hs-border hs-padding hs-margin-up-down" ><div class="col-sm-12 hs-default hs-padding hs-border "><div class="col-sm-10" ><div class="hs-cursor" onclick="toggleMatn('.$i.');">'.$erja['fname'].' '.$erja['lname'].' ['.$erja['tarikh'].']:</div></div><div class="col-sm-2 text-left" >';
            if((int)$erja['emza']===1)
            {
                $matns.='<small>'
                .'امضا دیجیتال'
                . '</small><img style="width:15px;" src="/paper/assets/img/'.$emza1.'">';
            }
            $matns .='</div></div>';
            $matns .= '<div id="matn_'.$i.'" class="col-sm-12 hs-border hs-margin-up-down hs-padding matn" ><div >'.$erja['matn'].'</div></div>';
            $matns .= loadAtt($erja['attachment']);
            $matns .='</div>';
        }
        else {
            $matns .= loadAtt($erja['attachment']);
        }
    }
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
    $type_i = new type_class($lett->type_id);
    $recs = array();
    if($this->input->post('matn')!==FALSE)
    {
        echo "1<br/>";
        $is_erja = $this->input->get_post("is_erja");
        /*
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        if($p2!='pishnevis')
            $this->form_validation->set_rules('matn', 'متن', 'required|min_length[3]');
        $this->form_validation->set_rules('receivers', 'دریافت کننده', 'required|greater_than[0]');
        */
        $ou=1;
        if($this->input->post('emza')!==FALSE)
        {                
            if((int)$lett_det->emza<=0)
            {    
                $ou = user_class::auth2($user_id,$this->input->post('pass_emza'));
            }    
        }
/*        
        if($this->form_validation->run()===FALSE && (int)$is_erja===1)
        {
        }
        else */
        $recs = isset($_REQUEST['receivers'])?$_REQUEST['receivers']:array();
        $recs_ro = isset($_REQUEST['receivers_ronevesht'])?$_REQUEST['receivers_ronevesht']:array();
        if(count($recs)<1){
            $msg.='<div class="alert alert-danger" >
                دریافت کننده ای انتخاب نشده
                 </div>';
        }
        else if(trim($_REQUEST['matn'])==''){
            $msg.='<div class="alert alert-danger" >
                ورود متن الزامی است
                 </div>';
         }
        else if((int)$ou<0)
        {
            $msg.='<div class="alert alert-danger" >
                رمز دوم اشتباه وارد شده است
                <br>
                لطفا سعی در ورود غیر مجاز نفرمایید، مراتب به مدیر اطلاع داده شد
                 </div>';
        }
        else if($letter_id<=0 && letter_class::shomareExists($this->input->post('shomare')))
        {
            $msg.='<div class="alert alert-danger" >
                شماره نامه تکراری وارد شده است
                 </div>';
        }    
        else 
        {
            if((int)$is_erja===1)
            {
                $le = $this->letter_model->erja($_REQUEST,$user_id,$_FILES);
            }
            else
            {
                $le = $this->letter_model->archive($user_id,$letter_id);
            }
            $letter_id = (int)$le["letter_id"];
            $letter_det_id = (int)$le["letter_det_id"];
            $lett = null;
            $lett_det = null;
            $lett = new letter_class($letter_id);
            $lett_det = new letter_det_class;
            $lett_det->loadByUser($letter_id,$user_id);
            redirect("paper_cartable/normal");
        }
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
        <div  class="hs-margin-up-down hs-gray hs-padding hs-border mm-negative-margin" >
            نمایش نامه
        </div>
        <?php echo $msg.validation_errors(); ?>
        <form method="post" enctype="multipart/form-data" id="form1">
        <div class="row hs-margin-up-down" >
            <div class="col-sm-3" >
                <span>موضوع:</span>
                <span class="form-control" ><?php echo $lett->mozoo; ?>  </span>
            </div>
            <div class="col-sm-3" >
                <span>تاریخ:</span>
                <span class="form-control" ><?php echo jdate("Y/m/d",strtotime($lett_det->tarikh)); ?> </span>
            </div>
            <div class="col-sm-3" >
                <span>شماره:</span>
                <span class="form-control"><?php echo $lett->shomare; ?> </span>
            </div>
            <div class="col-sm-3" >
                <span>نوع:</span>
                <span class="form-control"><?php echo $type_i->name; ?></span>
            </div>
            <div class="col-sm-12 hs-margin-up-down" >
                <?php echo $matns; ?>
            </div>
            <div class="col-sm-12 hs-margin-up-down norm" >
                <?php echo form_error('body_content'); ?>
                <span>
                متن ارجاع : 
                </span>
                <textarea style="margin:10px;" id="matn" name="matn" ><?php echo ($p2=='pishnevis')?$erja['matn']:''; ?></textarea>
                <a class="btn btn-default btn-sm hs-margin-up-down" onclick="addAtt();" >
                    افزودن
                </a>
            </div>
            <div class="col-sm-12 hs-margin-up-down norm" id="att_div" >
                <div class="col-sm-4" >
                    <span>
                    فایل : 
                    </span>
                    <input type="file" name="att[]" class="form-control" >
                </div>
                <div class="col-sm-4" >
                    <span>
                    توضیحات: 
                    </span>
                    <input name="toz[]" class="form-control" >
                </div>
                <div class="col-sm-4" >
                    <span>
                    نوع : 
                    </span>
                    <select name="attach_type_id[]" class="form-control" >
                        <?php
                            echo attach_type_class::loadAll();
                        ?>
                    </select>
                </div>
            </div>
            <div class="col-sm-9 hs-margin-up-down norm" >
                <input type="hidden" id="is_erja" name="is_erja" value="1"/>
                <?php
                if($p2 != 'pishnevis')
                {
                ?>
                <a class="btn hs-btn-default" onclick="reply();" >
                   پاسخ(Reply)
                </a>
                <?php
                }
                ?>
                <a class="btn hs-btn-default" onclick="erja();" >
                   ارجاع(Forward)
                </a>
                <a class="btn hs-btn-default arch" onclick="archive();" >
                   آرشیو
                </a>
                <a class="btn hs-btn-default" href="<?php echo site_url(); ?>paper_cartable/<?php echo $p2; ?>" >
                   بازگشت
                </a>
            </div>
            <div class="col-sm-3 hs-margin-up-down norm" >
                امضا دیجیتال: 
                <input type="checkbox" name="emza" id="emza" <?php echo ($lett_det->emza>0)?'checked="checked"':''; ?> onchange="check_emza();"  >
                <span id="khoon" ></span>
                <input type="password" id="pass_emza" name="pass_emza" placeholder="رمز دوم" class="form-inline form-control <?php echo ($lett_det->emza>0)?'hs-hide':''; ?>" >
            </div>
            <div class="col-sm-5 norm" >
                انتخاب دریافت کننده:
                <select name="receivers[]" class="form-control" multiple="multiple" id="receivers"  >
                    <?php
                        echo user_class::loadAll(TRUE,-1,$user_id,$recs);
                    ?>
                </select>
            </div>
            <div class="col-sm-5 norm" >
                انتخاب دریافت کننده به صورت رونوشت:
                <select name="receivers_ronevesht[]" class="form-control" multiple="multiple" >
                    <?php
                        echo user_class::loadAll(TRUE,-1,$user_id,$recs_ro);
                    ?>
                </select>
                <input type="hidden" name="letter_id" value="<?php echo $letter_id; ?>" >
            </div>
        </div>
        <input type="hidden" name="letter_id" value="<?php echo $letter_id; ?>" >
        </form>
    </div>
</div>

<script>
var cur_url = "<?php echo base_url(); ?>";
var p2 = '<?php echo $p2; ?>';
$(document).ready(function(){
    CKEDITOR.replace('matn',{
        language: 'fa',
        contentsCss: cur_url+'assets/css/editor.css',
        height: '350'
    });
    //if(p2 !== 'normal' && p2 !=='pishnevis')
        //$(".norm").hide();
    //if(p2 === 'pishnevis')
        //$(".arch").hide();
});
function reply()
{
    $("#receivers").select2('val', <?php echo $sender_id; ?>);
    erja();
}
function erja()
{
    $("#is_erja").val("1");
    $("#form1").submit();
    
}
function archive()
{
    $("#is_erja").val("2");
    $("#form1").submit();
    
}
function check_emza()
{
    if($("#emza").prop("checked"))
    {
        if($("#pass_emza").val()==='')
        {
            alert("لطفا رمز دوم خود را وارد نمایید");
            $("#emza").prop("checked",false);
            return false;
        }    
        $("#khoon").html("<img src='<?php echo asset_url().'img/stat.gif'; ?>' >");
        ob={
          "user_iid":<?php echo $user_id?>,
          "pass_emza": $("#pass_emza").val()
        };
        $.get("<?php site_url().$page_addr ?>",ob,function(result){
            if(result==="1")
            {
                $("#khoon").html("<img style='width:25px;' src='<?php echo asset_url().'img/greentick.png'; ?>' >");
                $("#pass_emza").hide();
            }
            else if(result==="-1")
            {
                $("#khoon").html("<img style='width:25px;' src='<?php echo asset_url().'img/redcross.png'; ?>' >");
                $("#emza").prop("checked",false);
            }
        });
    }   
    else
    {
        $("#pass_emza").show();
        $("#pass_emza").val("");
        $("#khoon").html("");
    }    
}
function addAtt()
{
    var ou = '<div class="col-sm-4" ><span>فایل : </span><input type="file" name="att[]" class="form-control" ></div><div class="col-sm-4" ><span>توضیحات: </span><input name="toz[]" class="form-control" ></div><div class="col-sm-4" ><span>نوع : </span><select name="attach_type_id[]" class="form-control" >';
    ou +='<?php  echo attach_type_class::loadAll(); ?>';
    ou += '</select></div>';
    $("#att_div").append(ou);
}
function toggleMatn(i)
{
    $("#matn_"+i).toggle('slow');
}
function delAtt(at_id)
{
    if(confirm("آیا حذف انجام شود؟"))
    {
        $("#khoon_"+at_id).show();
        $.get("paper_view.php",{"att_del_id":at_id},function(res){
            console.log(res);
            if(res=='OK')
                window.location = window.location;
        }).fail(function(){
            $("#khoon_"+at_id).hide();            
            alert('در حذف فایل خطایی رخ داد');
        });
    }
}
</script>