<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    $_SESSION['user_id'] = -1;
    $_SESSION['logged_in']=FALSE;
    redirect(base_url().'modir/login');
?>