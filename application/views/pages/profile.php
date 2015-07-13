<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $factor_id = isset($_REQUEST['factor_id'])?(int)$_REQUEST['factor_id']:-1;
    $khadamat_back = khadamat_factor_class::loadKhadamats($factor_id);
    if(isset($_REQUEST['user_id1']))
    {
        $m = new mysql_class;
        if($factor_id<=0)
        {
            $f = new factor_class();
            $tarikh = date("Y-m-d H:i:s");
            $id = $f->add($_REQUEST['user_id1'], $user_id, $tarikh);
        }
        else
        {
            $id = $factor_id;
        }
        //$m->ex_sqlx("update `factor` set `marhale` = 'khadamat_1' where `id` = $id");
        if(isset($_REQUEST['khadamat']))
        {
            foreach($_REQUEST['khadamat'] as $kh)
            {
                if(!in_array($kh, $khadamat_back))
                {
                    $m->ex_sqlx("insert into `khadamat_factor` (`factor_id`,`khadamat_id`) values ($id,$kh)");
                }
            }
            $m->ex_sqlx("delete from `khadamat_factor` where `factor_id` = $factor_id and not `khadamat_id` in (".implode(',',$_REQUEST['khadamat']).")");
            redirect('khadamat_1/'.$id);
        }
        else
        {
            $m->ex_sqlx("delete from `khadamat_factor` where `factor_id` = $factor_id");
        }
    }
    $msg = '';
    if($factor_id>0)
    {
        $f = new factor_class($factor_id);
        $user_id1 = $f->user_id;
    }
    else {
        $user_id1 = $user_id;
    }
    if(trim($p1)!='')
        $user_id1 = (int)$p1;
    if(isset($_REQUEST['s_user_id']))
    {
        $user_id1 = (int)$_REQUEST['s_user_id'];
    }
    if($this->input->post('fname')!==FALSE)
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('fname', 'نام ', 'required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('lname', 'نام خانوادگی ', 'required|min_length[3]|max_length[200]');
        $this->form_validation->set_rules('email', 'نشانی ایمیل', 'required|valid_email');
        $this->form_validation->set_rules('mob', 'تلفن همراه', 'required|is_natural');
        $this->form_validation->set_rules('tell', 'تلفن ثابت', 'required|is_natural');
        if($this->form_validation->run()!==FALSE)
        {
            $this->profile_model->edit($user_id1,$_REQUEST,$_FILES);
            $msg="<div class='alert alert-success' >
                ذخیره سازی با موفقیت انجام شد
                  </div>";
        }
    } 
    $this->profile_model->loadUser($user_id);
    $men = $this->profile_model->loadMenu();
    $this->profile_model->loadUser($user_id1);
    $user_obj = $this->profile_model->user;
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
    //$khadamat_back = isset($_REQUEST['khadamat_back'])?explode(",", $_REQUEST['khadamat_back']):array();
    $khadamats = khadamat_class::loadAll($khadamat_back);
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
<!--</div>
<div class="row" >-->
    <!--
    <div class="col-sm-8 col-sm-offset-2  hs-border hs-default hs-padding hs-margin-up-down" >
        فرم ثبت نام
    </div>
    -->
    <div class="col-sm-10" >
        <?php
            echo $this->inc_model->loadProgress(0,$factor_id);
        ?>
        <div class="hs-margin-up-down">
            <form id="kh_frm_1" method="post">
                انتخاب خدمات : 
                <select name="khadamat[]" id="khadamat123" multiple="multiple" style="width:70%;" >
                    <?php echo $khadamats; ?>
                </select>
                <input type="hidden" name="user_id1" value="<?php echo $user_id1; ?>" />
                <input type="hidden" name="factor_id" value="<?php echo $factor_id; ?>" />
                <a class="btn btn-lg hs-btn-default" href="#" onclick="$('#kh_frm_1').submit();">
                ادامه
                <span class="glyphicon glyphicon-chevron-left"></span>
                </a>
            </form>
        </div>
    <?php echo form_open_multipart('',array('id'=>'frm_profile'))  ?>

        <div  class="hs-margin-up-down hs-gray hs-padding hs-border mm-negative-margin pointer" onclick="toggle_profile();" >
            کاربر: 
            <?php echo $user_obj->fname.' '.$user_obj->lname; ?>
            شماره ملی:
            <?php echo $user_obj->code_melli; ?>
            <div class="hs-float-left" id="arrow_div" >
                <span class="glyphicon glyphicon-chevron-down" ></span>
            </div>
        </div>
        <div id="profile_div" style="display: none;" >
            <?php echo $msg.validation_errors(); ?>
            <div class="col-sm-6  hs-margin-up-down" >
                نام:
                <input class="form-control" name="fname" id="fname" placeholder="نام" value="<?php echo $user_obj->fname; ?>" >
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
                نام خانوادگی:
                <input class="form-control" name="lname" id="lname" placeholder="نام خانوادگی" value="<?php echo $user_obj->lname; ?>" >
            </div>

            <div class="col-sm-6  hs-margin-up-down" >
                کد ملی (نام کاربری):
                <input readonly="readonly" class="form-control" name="code_melli" id="code_melli" placeholder="کد ملی (نام کاربری)" value="<?php echo $user_obj->code_melli; ?>" >
            </div>
            <div class="col-sm-6  hs-margin-up-down datetime" >
                <div>
                    تاریخ تولد:
                </div>
                <select class="form-inline hs-little-select" name="rooz" id="rooz"  >
                    <option value="0" >
                        روز
                    </option>
                    <?php
                        echo $this->inc_model->genOption(1,31,$user_obj->rooz);
                    ?>
                </select>
                /
                <select class="form-inline hs-little-select" name="mah" id="mah" >
                    <option value="0" >
                        ماه
                    </option>
                    <?php
                        echo $this->inc_model->genOption(1,12,$user_obj->mah);
                    ?>
                </select>
                /
                <select class="form-inline hs-little-select" name="sal" id="sal" style="width:62px">
                    <option value="0" >
                        سال
                    </option>
                    <?php
                        echo $this->inc_model->genOption(1300,95,$user_obj->sal);
                    ?>
                </select>
            </div>
            <div class="hs-margin-up-down" style="margin-right:15px;" >
                درصورت خالی گذاشتن ، رمز عبور بدون تغییر باقی خواهد ماند
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
                رمز عبور:
                <input type="password" class="form-control" name="pass" id="pass" placeholder="رمز عبور" >
            </div>
            <div class="col-sm-6  hs-margin-up-down" >
                تکرار رمز عبور:
                <input type="password" class="form-control" name="pass2" id="pass2" placeholder="تکرار رمز عبور" >
            </div>
            <div class="hs-margin-up-down" style="margin-right:15px;" >
                درصورت خالی گذاشتن ، رمز امضای دیجیتال بدون تغییر باقی خواهد ماند
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
                رمز امضا دیجیتال :
                <input type="password" class="form-control" name="pass_emza" id="pass" placeholder="رمز امضا دیجیتال" >
            </div>
            <div class="col-sm-6  hs-margin-up-down" >
                تکرار رمز امضا دیجیتال :
                <input type="password" class="form-control" name="pass_emza2" id="pass2" placeholder="تکرار رمز امضا دیجیتال" >
            </div>
            <div class="col-sm-6  hs-margin-up-down" >
                شغل:
                <select class="form-control" name="shoghl_id" id="shoghl_id" >
                    <option value="0" >
                        انتخاب شغل
                    </option>
                    <?php
                        echo shoghl_class::loadAll(TRUE,$user_obj->shoghl_id);
                    ?>
                </select>
            </div>
            <div class="col-sm-6  hs-margin-up-down datetime" >
                تحصیلات:
                <select class="form-control" name="tahsilat_id" id="tahsilat_id" >
                    <option value="0" >
                        انتخاب تحصیلات
                    </option>
                    <?php
                        echo tahsilat_class::loadAll(TRUE,$user_obj->tahsilat_id);
                    ?>
                </select>    
            </div>
            <div class="col-sm-6  hs-margin-up-down" >
                گروه خونی:
                <select class="form-control" name="grooh_khooni_id" id="grooh_khooni_id"  >
                    <option value="0" >
                        گروه خونی
                    </option>
                    <?php
                        echo grooh_khooni_class::loadAll(TRUE,$user_obj->grooh_khooni_id);
                    ?>
                </select>
            </div>
            <div class="col-sm-6  hs-margin-up-down" >
                تلفن ثابت:
                <input type="number" class="form-control" name="tell" id="tell" placeholder="تلفن ثابت" value="<?php echo $user_obj->tell; ?>">
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
                تلفن همراه:
                <input type="number" class="form-control" name="mob" id="mob" placeholder="تلفن همراه" value="<?php echo $user_obj->mob; ?>">
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
                نشانی ایمیل:
                <input class="form-control" name="email" id="email" placeholder="نشانی ایمیل" value="<?php echo $user_obj->email; ?>">
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
              شماره پاسپورت  :
                <input type="text" class="form-control" name="passport" id="passport" placeholder="پاسپورت" value="<?php echo $user_obj->passport; ?>">
            </div>
            <div class="col-sm-6 hs-margin-up-down pointer" onclick="editPic(<?php echo $user_obj->id; ?>);">
                <span class="glyphicon glyphicon-pencil"></span>
                <?php echo ((trim($user_obj->pic)!=''))?"<img width='100px' src='".  site_url()."upload/".$user_obj->pic."' />":''; ?>
            </div>
            <div class="col-sm-12 pic_upload">
                <input id="input-1" type="file" class="file" name="pic">
            </div>
            <div class="col-sm-6 hs-margin-up-down" >
               کد حساب :
                <input type="text" class="form-control" name="code_hesab" id="code_hesab" placeholder="کد حساب" value="<?php echo $user_obj->code_hesab; ?>">
            </div>            <div class="col-sm-6 hs-margin-up-down" >
               نام پدر :
                <input type="text" class="form-control" name="pedar_name" id="pedar_name" placeholder="نام پدر" value="<?php echo $user_obj->pedar_name; ?>">
            </div>
            <div class="col-sm-12 hs-margin-up-down" >
                نشانی:
                <textarea class="form-control" rows="5" name="address" id="address" placeholder="نشانی" ><?php echo $user_obj->address; ?></textarea>
            </div>
            <div class="col-sm-6  hs-margin-up-down" >
                <button class="btn hs-btn-default" >ذخیره</button>
            </div>
        </div>        
    </div>
    <?php echo form_close(); ?>
</div>
<script>
    function editPic(uid)
    {
        $(".pic_upload").toggle();
    }
    function toggle_profile()
    {
        var is_visible = ($("#profile_div:visible").length>0);
        if(is_visible!==false)
            $("#arrow_div").html('<span class="glyphicon glyphicon-chevron-down" ></span>');
        else
            $("#arrow_div").html('<span class="glyphicon glyphicon-chevron-up" ></span>');
        $("#profile_div").toggle('fast');
    }
    $(document).ready(function(){
        $(".pic_upload").hide();
        setTimeout(function(){
            $("#khadamat123").select2({
                placeholder:" انتخاب خدمات",
                dir : 'rtl'
            });
        },100);
    });
</script>