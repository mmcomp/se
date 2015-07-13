<?php
class modir extends CI_Controller
{
    public function __construct()
    {
            parent::__construct();
            session_start();
            $this->load->view('modir/libs/jdf');
            $this->load->view('modir/libs/simplejson');
            $this->load->library('conf');
            $this->load->library('mysql_class');
            $this->load->library('xgrid');
            $this->load->model('se_model');
            $this->load->model('contents_model');
            $this->load->model('types_model');
            $this->load->model('labels_model');
            $this->load->model('users_model');
            $this->load->model('inc_model');
            $this->load->model('footer_type_model');
            $this->load->model('comments_model');
            $this->load->model('visitor_model');
            $this->load->model('project_extra_model');
    }
    public function index()
    {
        //$this->load->library('session');
        $logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in']==TRUE;
        $data['title']=($logged_in?'index':'login');
        $data['logged_in'] = $logged_in;
        $page = ($logged_in?'index':'login');
        $this->load->view('templates/modir/header', $data);
        $this->load->view('modir/'.$page, $data);
        $this->load->view('templates/modir/footer');
    }
    public function login()
    {
        $data['title']='login';
        $data['logged_in'] = FALSE;
        $this->load->library('form_validation');
        $this->load->view('templates/modir/header', $data);
        $this->load->view('modir/login');
        $this->load->view('templates/modir/footer');
    }
    public function view($page)
    {
        $logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in']==TRUE;
        $data['logged_in'] = $logged_in;
        toJSON(array("aaa"=>'111'));
        if($logged_in)
        {    
            $data['title'] = $page;
            $this->load->library('session');
            switch ($page) {
                case 'login':
                        $this->load->library('form_validation');
                    break;
                case 'edit_content':
                        $data['has_ckeditor']=TRUE;
                        $this->load->library('form_validation');
                        $this->form_validation->set_error_delimiters('<div class="uk-alert uk-alert-danger">', '</div>');
                        $this->form_validation->set_rules('type_id','بخش','required|is_natural_no_zero');
                        $this->form_validation->set_rules('name','عنوان','required|min_length[3]|max_length[120]');
                        $this->form_validation->set_rules('body_content','محتوا','required');
                        $this->form_validation->set_rules('alias','نام مستعار','required|min_length[3]|callback_alias_check['.$this->input->post('content_id').']');
                    break;
                default:
                    break;
            }
            $this->load->view('templates/modir/header', $data);
            $this->load->view('modir/'.$page, $data);
            $this->load->view('templates/modir/footer');
        }
        else
        {
            $this->login();
        }    
    }
    public function alias_check($id,$inp)
    {
        $tmp = $this->contents_model->alias_check($inp,$id);
        if($tmp===FALSE)
            $this->form_validation->set_message('alias_check','نام مستعار قبلا ثبت شده است');
        return($tmp);
    }
}
?>
