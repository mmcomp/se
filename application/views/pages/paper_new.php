<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    if($this->input->get('pass_emza')!==FALSE && $this->input->get('user_iid')!==FALSE)
    {    
        $ou = user_class::auth2($this->input->get('user_iid'),$this->input->get('pass_emza'));
        die("$ou");
    }
    $this->profile_model->loadUser($user_id);
    $men = $this->profile_model->loadMenu();
    $group_id = $this->profile_model->user->group_id;
    $ShomarePrefix = array(
        1 => "M",
        2 => "S",
        4 => "F"
    );
    $ShomareNew = 0;
    $SPre = isset($ShomarePrefix[$group_id])?$ShomarePrefix[$group_id]:'U';
    $my = new mysql_class;
    $my->ex_sql("SELECT MAX(shomare) lastshomare FROM `paper_letter` where shomare like '".$SPre."%'", $q);
    if(isset($q[0]))
    {
        $ShomareNew = (int)  str_replace($SPre, '', $q[0]['lastshomare']);
    }
    $ShomareNew++;
    $ShomareName = $SPre.$ShomareNew;
    $msg = '';
    $menu_links = '';
    $letter_id= $this->input->post('letter_id')!==FALSE?(int)$this->input->post('letter_id'):-1;
    $lett = new letter_class($letter_id);
    $lett_det = new letter_det_class;
    $lett_det->loadByUser($letter_id,$user_id);
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
    if($this->input->post('mozoo')!==FALSE)
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('mozoo', 'موضوع ', 'required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('shomare', 'شماره ', 'required|min_length[4]|max_length[20]');
        $this->form_validation->set_rules('type_id', 'نوع', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('matn', 'متن', 'required|min_length[3]');
        //$this->form_validation->set_rules('receivers', 'دریافت کننده', 'required|greater_than[0]');
        $ou=1;
        if($this->input->post('emza')!==FALSE)
        {
            if((int)$lett_det->emza<=0)
            {    
                $ou = user_class::auth2($user_id,$this->input->post('pass_emza'));
            }    
        }    
        $recs = isset($_REQUEST['receivers'])?$_REQUEST['receivers']:array();
        $recs_ro = isset($_REQUEST['receivers_ronevesht'])?$_REQUEST['receivers_ronevesht']:array();
        $rec_error = FALSE;
        if(count($recs)<1 && (int)$_REQUEST['is_pishnevis']!=1){
            $msg.='<div class="alert alert-danger" >
                دریافت کننده ای انتخاب نشده
                 </div>';
            $rec_error = TRUE;
        }        //var_dump($recs);
        if($this->form_validation->run()==FALSE || $rec_error)
        {
            
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
            $lett->mozoo = $this->input->post('mozoo');
            $lett->type_id = $this->input->post('type_id');
            $lett->shomare = $this->input->post('shomare');
            $lett_det->tarikh = $this->input->post('tarikh');
            $lett_det->matn = $this->input->post('matn');
        }    
        else {
            $le = $this->letter_model->add($_REQUEST,$user_id,$_FILES);
            $letter_id = (int)$le["letter_id"];
            $letter_det_id = (int)$le["letter_det_id"];
            $lett = null;
            $lett_det = null;
            $lett = new letter_class($letter_id);
            $lett_det = new letter_det_class;
            $lett_det->loadByUser($letter_id,$user_id);
            if((int)$_REQUEST['is_pishnevis']==1)
                redirect ("paper_cartable/pishnevis");
            else
                redirect ("paper_cartable/normal");
            /*
            $msg="<div class='alert alert-success' >
                ذخیره سازی با موفقیت انجام شد
                  </div>";
             * 
             */
        }
    }
    if((int)$lett_det->is_pishnevis==1 || $letter_id==-1)
    {    
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
            نامه جدید
        </div>
        <?php echo $msg . validation_errors(); ?>
        <div class="row hs-margin-up-down" >
            <?php //echo form_open('paper_new',array('id'=>'form1', 'class' => '','entype'=>'multipart/form-data')); ?>
            <form method="post" enctype="multipart/form-data" id="form1">
            <div class="col-sm-3" >
                <span>موضوع:</span>
                <input type="text" name="mozoo" class="form-control" value="<?php echo isset($_REQUEST['mozoo'])?$_REQUEST['mozoo']:$lett->mozoo; ?>" >
            </div>
            <div class="col-sm-3" >
                <span>تاریخ:</span>
                <input readonly="readonly" type="text" name="tarikh" class="form-control" value="<?php echo jdate("Y/m/d",strtotime(isset($_REQUEST['tarikh'])?$_REQUEST['tarikh']:$lett_det->tarikh)); ?>" >
            </div>
            <div class="col-sm-3" >
                <span>شماره:</span>
                <input type="text" name="shomare" class="form-control" value="<?php echo $ShomareName; ?>" readonly="readonly">
                <!--<input type="text" name="shomare" class="form-control" value="<?php //echo isset($_REQUEST['shomare'])?$_REQUEST['shomare']:$lett->shomare; ?>" >-->
            </div>
            <div class="col-sm-3" >
                <span>نوع:</span>
                <select name="type_id" class="form-control" >
                    <?php echo type_class::loadAll(TRUE,isset($_REQUEST['type_id'])?$_REQUEST['type_id']:$lett->type_id); ?>
                </select>
            </div>
            <div class="col-sm-12 hs-margin-up-down" >
                <?php echo form_error('body_content'); ?>
                <textarea style="margin:10px;" id="matn" name="matn" ><?php echo isset($_REQUEST['matn'])?$_REQUEST['matn']:$lett_det->matn; ?></textarea>
            </div>
            <a class="btn btn-default btn-sm hs-margin-up-down" onclick="addAtt();" >
                افزودن
            </a>
            <div class="col-sm-12 hs-margin-up-down" id="att_div" >
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
            <div class="col-sm-9 hs-margin-up-down" >
                <a class="btn hs-btn-default" onclick="setPishnevis();" >
                    ذخیره به عنوان پیش نویس
                </a>
                <input type="hidden" name="is_pishnevis" id="is_pishnevis" >
            </div>
            <div class="col-sm-3 hs-margin-up-down" >
                امضا دیجیتال: 
                <input type="checkbox" name="emza" id="emza" <?php echo ($lett_det->emza>0)?'checked="checked"':''; ?> onchange="check_emza();"  >
                <span id="khoon" ></span>
                <input type="password" id="pass_emza" name="pass_emza" placeholder="رمز دوم" class="form-inline form-control <?php echo ($lett_det->emza>0)?'hs-hide':''; ?>" >
            </div>
            <div class="col-sm-5" >
                انتخاب دریافت کننده:
                <select name="receivers[]" class="form-control" multiple="multiple"  >
                    <?php
                        echo user_class::loadAll(TRUE,-1,$user_id,$recs);
                    ?>
                </select>
            </div>
            <div class="col-sm-5" >
                انتخاب دریافت کننده به صورت رونوشت:
                <select name="receivers_ronevesht[]" class="form-control" multiple="multiple" >
                    <?php
                        echo user_class::loadAll(TRUE,-1,$user_id,$recs_ro);
                    ?>
                </select>
                <input type="hidden" name="letter_id" value="<?php echo $letter_id; ?>" >
            </div>
            <div class="col-sm-4 hs-margin-up-down" >
                <a class="btn btn-default" onclick="send_frm();"  >
                    ذخیره و ارسال
                </a>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
<?php
    }
    else
    {
        echo '<div class="alert alert-success" >
            عملیات ثبت و ارسال نامه با موفقیت انجام گرفت
        </div>';
    }    
?>
<script>
var cur_url = "<?php echo base_url(); ?>";
$(document).ready(function(){
    CKEDITOR.replace('matn',{
        language: 'fa',
        contentsCss: cur_url+'assets/css/editor.css',
        height: '350'
    });
});
function setPishnevis()
{
    $("#is_pishnevis").val('1');
    $("#form1").submit();
}
function send_frm()
{
    $("#is_pishnevis").val('0');
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
</script>