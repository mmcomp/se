<?php
class Pages extends CI_Controller {

    public function __construct() {
        parent::__construct();
        session_start();
        $this->load->model('inc_model');
        $this->load->model('profile_model');
        $this->load->model('letter_model');
        $this->load->model('cartable_model');
        $this->load->model('parvaz_model');
        $this->load->model('form_model');
        
        $this->load->library('conf');
        $this->load->library('mysql_class');
        $this->load->library('access_class');
        $this->load->library('access_det_class');
        $this->load->library('security_class');
        $this->load->library('user_class');
        $this->load->library('shoghl_class');
        $this->load->library('tahsilat_class');
        $this->load->library('grooh_khooni_class');
        $this->load->library('letter_class');
        $this->load->library('letter_det_class');
        $this->load->library('letter_det_attach_class');
        $this->load->library('history_class');
        $this->load->library('type_class');
        $this->load->library('attach_type_class');
        $this->load->library('khadamat_class');
        $this->load->library('parvaz_class');
        $this->load->library('airline_class');
        $this->load->library('hotel_class');
        $this->load->library('hotel_room_class');
        $this->load->library('city_class');
        $this->load->library('factor_class');
        $this->load->library('mosafer_class');
        $this->load->library('khadamat_factor_class');
        $this->load->library('country_class');
        $this->load->library('taminkonande_class');
        $this->load->library('vahed_mablagh_class');
        $this->load->library('khadamat_tamin_class');
        $this->load->library('group_class');
        
        $this->load->library('xgrid');
        $this->load->view('modir/libs/jdf');
        $this->load->view('modir/libs/simplejson');
        
        
        $this->load->library('user_agent');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');                    
        $this->load->library('javascript');
        $this->load->library('email');
        
        //$this->load->model('types_model');
    }
    public function view($page='home',$p1='',$p2='')
    {
        $conf = new conf;
        if(!isset($_SESSION[$conf->app.'_user_id']))
        {
            if($page=='forgetpass' || $page=='register')
            {
                $meta = array(
                    array('name' => 'robots', 'content' => 'no-cache'),
                    array('name' => 'description', 'content' => 'سامانه ارتباط به مشتریان شرگت گوهر'),
                    array('name' => 'keywords', 'content' => ''),
                    array('name' => 'robots', 'content' => 'no-cache'),
                    array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
                );
                $data['meta'] = $meta;
                $data['title'] = 'سامانه ارتباط با مشتریان';
                $data['page_addr'] = $page;
                $data['is_logged'] =isset($_SESSION[$conf->app.'_user_id']);
                $this->load->view('templates/header', $data);
                $this->load->view('pages/'.$page, $data);
                $this->load->view('templates/footer', $data);
            }
            else
            {
                 $this->login();
            }
        }
        else
        {    
            if ( ! file_exists(APPPATH.'/views/pages/'.$page.'.php'))
            {
                    // Whoops, we don't have a page for that!
                    show_404();
            }

            $this->setVisitor($page);
            $meta = array(
                array('name' => 'robots', 'content' => 'no-cache'),
                array('name' => 'description', 'content' => 'سامانه ارتباط به مشتریان شرگت گوهر'),
                array('name' => 'keywords', 'content' => ''),
                array('name' => 'robots', 'content' => 'no-cache'),
                array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
            );
            $data['meta'] = $meta;
            $data['title'] = 'سامانه ارتباط با مشتریان';
            $data['page_addr'] = $page;
            $data['is_logged'] =isset($_SESSION[$conf->app.'_user_id']);
            $data['user_id'] =(int)$_SESSION[$conf->app.'_user_id'];
            $data['p1'] = $p1;
            $data['p2'] = $p2;
            $ckeditor_pages=array('paper_new','paper_view');
            $data['has_ckeditor'] = in_array($page,$ckeditor_pages);

            $this->load->view('templates/header', $data);
            $this->load->view('pages/'.$page, $data);
            $this->load->view('templates/footer', $data);
        }
    }
    public function setVisitor($inp)
    {
        $page_name=$inp;
        $ip_addr = $this->input->ip_address();
        $referrer = $this->agent->is_referral()?$this->agent->referrer():'';
        $browser = $this->agent->browser();
        $version = $this->agent->version();
        $mobile = $this->agent->is_mobile()?$this->agent->mobile():'';
        $robot = $this->agent->is_robot()?$this->agent->robot():'';
        $platform = $this->agent->platform();
        $tarikh = date("Y-m-d H:i:s");
        //$this->db->query("insert into visitors (`page_name`, `ip_addr`, `referrer`, `browser`, `version`, `mobile`, `robot`, `platform`, `tarikh`) values ('$page_name', '$ip_addr', '$referrer', '$browser', '$version', '$mobile', '$robot', '$platform', '$tarikh')");
    }
    public function login()
    {
        $data['title']='login';
        $meta = array(
            array('name' => 'robots', 'content' => 'no-cache'),
            array('name' => 'description', 'content' => 'سامانه ارتباط به مشتریان شرگت گوهر'),
            array('name' => 'keywords', 'content' => ''),
            array('name' => 'robots', 'content' => 'no-cache'),
            array('name' => 'Content-type', 'content' => 'text/html; charset=utf-8', 'type' => 'equiv')
        );
        $conf = new conf;
        $data['meta'] = $meta;
        $data['is_logged'] =isset($_SESSION[$conf->app.'_user_id']);
        $this->load->library('form_validation');
        $this->load->view('templates/header', $data);
        $this->load->view('pages/login');
        $this->load->view('templates/footer');
    }
}

