<?php
    $conf = new conf;
    $msg ='';
    if($this->input->post('user')!==FALSE)
    {    
        $user = $this->input->post('user');
        $pass = $this->input->post('pass');
        $this->profile_model->auth($user,$pass);
        if($this->profile_model->user->id>0)
        {
            $_SESSION[$conf->app.'_user_id'] = $this->profile_model->user->id;
            $_SESSION[$conf->app.'_user'] = $this->profile_model->user;
            redirect('/');
        }
        else
        {
            $msg ='<div class="alert alert-danger" >'. 'نام کاربری یا رمز عبور اشتباه است'.'</div>';
        }    
    }   
    else if(isset($_SESSION[$conf->app.'_user_id']) && $this->input->get('logout')===FALSE)
    {
        redirect('/');
    }
    else if($this->input->get('logout')!==FALSE)
    {
        session_destroy();
        session_start();
        redirect('/');
        //$msg ='<div class="alert alert-success" >'. 'خروج با موفقیت انجام شد'.'</div>';
    }
     
?>
<div class="row" >
    <div class="col-sm-4 col-sm-offset-4 hs-border hs-margin-up-down" >
        <div class="hs-border hs-default hs-padding hs-margin-up-down" style="padding-right: -15px;" >ورود کاربر</div>
        <div class="hs-margin-up-down" >
            
            <?php
                echo $msg;
            ?>
            <form method="post" >
                <input type="text" name="user" placeholder="نام کاربری" class="form-control hs-margin-up-down"  >
                <input type="password" name="pass" placeholder="رمز عبور" class="form-control hs-margin-up-down" >
                <button class="btn btn-default" >ورود</button>
            </form>
            <div class="hs-padding" >
                <a href="<?php echo site_url(); ?>forgetpass">
                رمز خود را فراموش کرده ام
                </a>
            </div>
            <div class="hs-padding" >
                <a href="<?php echo site_url(); ?>register" >
                 ثبت نام در باشگاه مشتریان 
                </a>
            </div>
        </div>
    </div>
</div>
