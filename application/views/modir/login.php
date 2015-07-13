<?php
	
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $user = $this->input->get_post('user');
    $logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in']==TRUE;
    if($logged_in)
    {    
            redirect(base_url ().'modir');
            die();
    }
    if($user!==FALSE)
    {
        $this->form_validation->set_error_delimiters('<div class="uk-alert uk-alert-danger">', '</div>');
        $this->form_validation->set_rules('user', 'نام کاربری', 'required|min_length[5]|max_length[50]');
        $this->form_validation->set_rules('pass', 'گذرواژه', 'required|min_length[1]|max_length[50]');
        if ($this->form_validation->run() == FALSE) 
        {
           //
        }
        else 
        {
            $data = array(
                'user' => $this->input->post('user'),
                'pass' => $this->input->post('pass')
            );
            $this->se_model->authenticate($data);
            $logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in']==TRUE;
            if($logged_in)
                redirect(base_url ().'modir');
        }
    }
    else
    {    
        $_SESSION['user_id'] = -1;
        $_SESSION['logged_in']=FALSE;
    }
    $this->load->helper('form');
?>
<div class="uk-vertical-align uk-text-center">
	<div class="uk-vertical-align-middle er-login-form">
	    <?php 
	    echo form_open('modir/login',array('id'=>'form', 'class' => 'uk-form'));
	    echo form_fieldset('ورود به بخش مدیریت');
	    ?>
	    <div class="uk-form-row">
	    	<div class="uk-form-icon er-form-icon">
		    	<i class="uk-icon-user"></i>
			    <?php echo form_input(array('id' => 'user', 'name' => 'user', 'class' => 'uk-width-1-1 uk-form-large', 'placeholder' => 'نام کاربری')); ?>
		    </div>
	    </div>
	    <?php echo form_error('user'); ?>
	    
	    <div class="uk-form-row">
	    	<div class="uk-form-icon er-form-icon">
		    	<i class="uk-icon-lock"></i>
			    <?php echo form_input(array('id' => 'pass', 'name' => 'pass','type'=>'password', 'class' => 'uk-width-1-1 uk-form-large', 'placeholder' => 'گذرواژه')); ?>
		    </div>
	    </div>
	    <?php echo form_error('pass'); ?>
	    
	    <div class="uk-form-row">
	    	<?php echo form_button(array('name' => 'submit', 'type' => 'submit', 'id' => 'submit', 'value' => 'true', 'content' => 'ورود', 'class' => 'uk-width-1-1 uk-button uk-button-primary uk-button-large er-button')); ?>
	    </div>
	    <?php 
	    echo form_close(); 
	    echo form_fieldset_close();
	    ?>
	</div>
</div>