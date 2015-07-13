<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $conf = new conf;
    $msg='';
    if($this->input->post('fname')!==FALSE)
    {
        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');
        $this->form_validation->set_rules('fname', 'نام ', 'required|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('lname', 'نام خانوادگی', 'required|min_length[4]|max_length[30]');
        $this->form_validation->set_rules('code_melli', 'کدملی', 'required|min_length[10]');
        $this->form_validation->set_rules('rooz', 'روز', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('mah', 'ماه', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('sal', 'سال', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('pass', 'رمزعبور ', 'required|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('pass2', 'تکراررمز عبور ', 'required|min_length[3]|max_length[30]');
        $this->form_validation->set_rules('shoghl_id', 'شغل', 'required|is_natural_no_zero');
        $this->form_validation->set_rules('tahsilat_id', 'تحصیلات', 'required|is_natural_no_zero');
        if($this->form_validation->run()==FALSE)
        {
            //
        }
        else
        {
            $_REQUEST['group_id'] = 3;
            $ou = $this->profile_model->add($_REQUEST);
            if($ou==-1)
            {
                $msg='<div class="alert alert-danger" >
                    خطا در ثبت اطلاعات
                     </div>';
            }
            else if($ou==-11 || $ou==-111 )
            {
                $msg='<div class="alert alert-danger" >
                       کد ملی تکراری است
                     </div>';
            }
            else if($ou>0)
            {
                $msg='<script>alert("ثبت نام با موفقیت صورت گرفت");window.location="login";</script>';
            }    
        }
    }

    $col = 12;
    if($is_logged)
    {
        $col = 10;
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
    }
    
?>
<div class="row">
    <?php
        if($is_logged)
        {
    ?>
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
    <?php
        }
    ?>
    <div  class="col-sm-<?php echo $col; ?>">
    <?php echo $msg.validation_errors(); ?>
    <?php 
        echo form_open('register',array('id'=>'form'));
        echo form_fieldset('فرم ثبت نام');
    ?>
        <!--
        <div class="col-sm-8 col-sm-offset-2  hs-border hs-default hs-padding hs-margin-up-down" >
            فرم ثبت نام
        </div>
        -->
        <div class="col-sm-4 col-sm-offset-2 hs-margin-up-down" >
            <input class="form-control" name="fname" id="fname" placeholder="نام ضروری" value="<?php echo ($this->input->post('fname')!==FALSE?$this->input->post('fname'):''); ?>" >
            <?php //echo form_error('fname'); ?>
        </div>
        <div class="col-sm-4 hs-margin-up-down" >
            <input class="form-control" name="lname" id="lname" placeholder="نام خانوادگی ضروری" value="<?php echo ($this->input->post('lname')!==FALSE?$this->input->post('lname'):''); ?>" >
        </div>

        <div class="col-sm-4 col-sm-offset-2 hs-margin-up-down" >
            <input class="form-control" name="code_melli" id="code_melli" placeholder="کد ملی (نام کاربری) ضروری" value="<?php echo ($this->input->post('code_melli')!==FALSE?$this->input->post('code_melli'):''); ?>" >
        </div>
        <div class="col-sm-4  hs-margin-up-down datetime" >
            تاریخ تولد:
            <select class="form-inline hs-little-select" name="rooz" id="rooz"  >
                <option value="0" >
                    روز
                </option>
                <?php
                    echo $this->inc_model->genOption(1,31,$this->input->post('rooz')!==FALSE?$this->input->post('rooz'):-1);
                ?>
            </select>
            /
            <select class="form-inline hs-little-select" name="mah" id="mah" >
                <option value="0" >
                    ماه
                </option>
                <?php
                    echo $this->inc_model->genOption(1,12,($this->input->post('mah')!==FALSE?$this->input->post('mah'):-1));
                ?>
            </select>
            /
            <select class="form-inline hs-little-select" name="sal" id="sal" >
                <option value="0" >
                    سال
                </option>
                <?php
                    echo $this->inc_model->genOption(1300,95,($this->input->post('sal')!==FALSE?$this->input->post('sal'):-1));
                ?>
            </select>
        </div>
        <div class="col-sm-4 col-sm-offset-2 hs-margin-up-down" >
            <input type="password" class="form-control" name="pass" id="pass" placeholder="رمز عبور" >
        </div>
        <div class="col-sm-4  hs-margin-up-down" >
            <input type="password" class="form-control" name="pass2" id="pass2" placeholder="تکرار رمز عبور" >
        </div>
        <div class="col-sm-4 col-sm-offset-2 hs-margin-up-down" >
            <select class="form-control" name="shoghl_id" id="shoghl_id" >
                <option value="0" >
                    انتخاب شغل
                </option>
                <?php
                    echo shoghl_class::loadAll(TRUE,($this->input->post('shoghl_id') !== FALSE ? $this->input->post('shoghl_id') : -1));
                ?>
            </select>
        </div>
        <div class="col-sm-4  hs-margin-up-down datetime" >
            <select class="form-control" name="tahsilat_id" id="tahsilat_id" >
                <option value="0" >
                    انتخاب تحصیلات
                </option>
                <?php
                    echo tahsilat_class::loadAll(TRUE,($this->input->post('tahsilat_id')!==FALSE?$this->input->post('tahsilat_id'):-1));
                ?>
            </select>    
        </div>
        <div class="col-sm-4 col-sm-offset-2 hs-margin-up-down" >
            <select class="form-control" name="grooh_khooni_id" id="grooh_khooni_id"  >
                <option value="0" >
                    گروه خونی
                </option>
                <?php
                    echo grooh_khooni_class::loadAll(TRUE,($this->input->post('grooh_khooni_id')!==FALSE?$this->input->post('grooh_khooni_id'):-1));
                ?>
            </select>
        </div>
        <div class="col-sm-4  hs-margin-up-down datetime" >
            <input type="number" class="form-control" name="tell" id="tell" placeholder="تلفن ثابت" value="<?php echo $this->input->post('tell') !== FALSE ?$this->input->post('tell'):''; ?>" >
        </div>
        <div class="col-sm-4 col-sm-offset-2 hs-margin-up-down" >
            <input type="number" class="form-control" name="mob" id="mob" placeholder="تلفن همراه" value="<?php echo $this->input->post('mob') !== FALSE ?$this->input->post('mob'):''; ?>" >
        </div>
        <div class="col-sm-4 hs-margin-up-down" >
            <input class="form-control" name="email" id="email" placeholder="نشانی ایمیل" value="<?php echo $this->input->post('email') !== FALSE ?$this->input->post('email'):''; ?>" >
        </div>
        <div class="col-sm-4 col-sm-offset-2 hs-margin-up-down" >
            <input type="text" class="form-control" name="passport" id="passport" placeholder="شماره پاسپورت" value="<?php echo $this->input->post('passport') !== FALSE ?$this->input->post('passport'):''; ?>" >
        </div>
        <div class="col-sm-4 hs-margin-up-down" >
            <input class="form-control" name="pedar_name" id="pedar_name" placeholder="نام پدر" value="<?php echo $this->input->post('pedar_name') !== FALSE ?$this->input->post('pedar_name'):''; ?>" >
        </div>
        <div class="col-sm-8 col-sm-offset-2 hs-margin-up-down" >
            <textarea class="form-control" rows="5"  name="address" id="address" placeholder="نشانی" ><?php echo $this->input->post('address') !== FALSE ?$this->input->post('address'):''; ?></textarea>
        </div>
        <div class="col-sm-4 col-sm-offset-2 hs-margin-up-down" >
            <button class="btn hs-btn-default" >ثبت نام</button>
        </div>
    <?php 
        echo form_close(); 
        echo form_fieldset_close();
    ?>   
    </div>
</div>
