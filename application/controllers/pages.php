<?php

class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->model('inc_model');
        $this->load->model('profile_model');

        $this->load->library('conf');
        $this->load->library('mysql_class');
        $this->load->library('user_class');
        $this->load->library('group_class');
        $this->load->library('flight_class', array(TRUE));
        $this->load->library('search_class');
        $this->load->library('city_class');
        $this->load->library('reserve_class');
        $this->load->library('rookeshi_class');

        $this->load->library('xgrid');
        $this->load->view('include/jdf');
        $this->load->view('include/simplejson');


        $this->load->library('user_agent');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->library('javascript');
        $this->load->library('email');
    }

    public function view($page = 'home', $p1 = '', $p2 = '') {
        $conf = new conf;
        $meta = array(
            array('name' => 'robots', 'content' => 'no-cache'),
            array('name' => 'description', 'content' => 'TicketYab'),
            array('name' => 'keywords', 'content' => ''),
            array('name' => 'robots', 'content' => 'no-cache'),
            array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
        );
        $data['meta'] = $meta;
        $data['title'] = 'TicketYab';
        $data['page_addr'] = $page;
        $data['is_logged'] = isset($_SESSION[$conf->app . '_user_id']);
        $data['p1'] = $p1;
        $data['p2'] = $p2;
        $ckeditor_pages = array('admin');
        $data['has_ckeditor'] = in_array($page, $ckeditor_pages);
        if ($page != 'ticket') {
            $this->load->view('templates/header', $data);
            $this->load->view('pages/' . $page, $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->load->view('pages/' . $page, $data);
        }
    }

    public function setVisitor($inp) {
        $page_name = $inp;
        $ip_addr = $this->input->ip_address();
        $referrer = $this->agent->is_referral() ? $this->agent->referrer() : '';
        $browser = $this->agent->browser();
        $version = $this->agent->version();
        $mobile = $this->agent->is_mobile() ? $this->agent->mobile() : '';
        $robot = $this->agent->is_robot() ? $this->agent->robot() : '';
        $platform = $this->agent->platform();
        $tarikh = date("Y-m-d H:i:s");
        //$this->db->query("insert into visitors (`page_name`, `ip_addr`, `referrer`, `browser`, `version`, `mobile`, `robot`, `platform`, `tarikh`) values ('$page_name', '$ip_addr', '$referrer', '$browser', '$version', '$mobile', '$robot', '$platform', '$tarikh')");
    }

    public function login() {
        $data['title'] = 'login';
        $meta = array(
            array('name' => 'robots', 'content' => 'no-cache'),
            array('name' => 'description', 'content' => 'TicketYab'),
            array('name' => 'keywords', 'content' => ''),
            array('name' => 'robots', 'content' => 'no-cache'),
            array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
        );
        $conf = new conf;
        $data['meta'] = $meta;
        $data['is_logged'] = isset($_SESSION[$conf->app . '_user_id']);
        $this->load->library('form_validation');
        $this->load->view('templates/header', $data);
        $this->load->view('pages/login');
        $this->load->view('templates/footer');
    }

}
