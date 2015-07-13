<?php
    $conf = new conf;
    $msg='';
    if($this->input->post('email')!==FALSE)
    {
        $this->load->helper('email');
        if (valid_email($this->input->post('email')))
        {
            $msg='<div class="alert alert-success" >ایمیل با موفقیت ارسال شد</div>';
            $u = new user_class;
            $u->loadByEmail($this->input->post('email'));
            if(isset($u->id) && $u->id > 0)
            {

                $this->email->from($conf->sender, $conf->sender_name);
                $this->email->to(trim($this->input->post('email'))); 


                $this->email->subject($conf->changepass_subject);
                $newpass = $u->randomPassword();
                $this->email->message(str_replace("#pass#",$newpass, $conf->changepass_body));	

                $this->email->send();
            }
            else 
            {
                $msg='<div class="alert alert-danger">
                        ایمیل را به صحت وارد کنید
                      </div>';
            }

        }
        else {
            $msg='<div class="alert alert-danger">
                    ایمیل را به صحت وارد کنید
                  </div>';
        }
    }    
?>
<div class="row" >
    <div class="col-sm-4 col-sm-offset-4 hs-border hs-margin-up-down" >
        <div class="hs-border hs-default hs-padding hs-margin-up-down" style="padding-right: -15px;" >
            رمز عبور خود را فراموش کرده ام
        </div>
        <div class="hs-margin-up-down" > 
            <?php
                echo $msg;
            ?>
            <form method="post" >
                <input type="text" name="email" placeholder="نشانی ایمیل" class="form-control hs-margin-up-down" value="<?php echo ($this->input->post('email')!==FALSE)?$this->input->post('email'):'';  ?>"  >
                <button class="btn btn-default form-control"  >ارسال رمز عبور جدید</button>
            </form>
        </div>
    </div>
</div>
