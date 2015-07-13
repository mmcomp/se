<?php
class Profile_model extends CI_Model {
    public $user;
    public function loadUser($user_id)
    {
        $this->user = new user_class($user_id);
        return($this->user);
    }
    public function auth($user,$pass)
    {
        $this->user = new user_class;
        $this->user->auth($user, $pass);
    }
    public function add($data)
    {
        $out = -1;
        $my = new mysql_class;
        $tarikh_p = $data['sal'].'/'.$data['mah'].'/'.$data['rooz'];
        $tarikh = $this->inc_model->jalaliToMiladi($tarikh_p);
        $data["tarikh_tavalod"] = $tarikh;
        unset($data["sal"]);
        unset($data["mah"]);
        unset($data["rooz"]);
        unset($data["pass2"]);
        $data['user'] = $data['code_melli'];
        $q = '';
        $f = '';
        $v = '';
        $my->ex_sql("select user,code_melli from user where user='".$data['user']."' or code_melli='".$data['code_melli']."'",$qq);
        if(isset($qq[0]))
        {
            $tuser = $qq[0]['user'];
            $tcode = $qq[0]['code_melli'];
            if($tuser == $data['user'])
                $out += -10;
            if($tcode == $data['code_melli'])
                $out += -100;
        }
        else
        {
            foreach($data as $key=>$value)
            {
                $f .= (($f=='')?'':',')."`$key`";
                $v .= (($v=='')?'':',')."'$value'";
            }
            if($f!='')
            {
                $q = "insert into `user` ($f) values ($v)";
                $ln = $my->ex_sqlx($q,FALSE);
                $out = $my->insert_id($ln);
                $my->close($ln);
            }
        }
        return($out);
    }
    public function edit($user_id,$data,$files)
    {
        
        
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'pdf|jpg|png|doc|docx|xls|xlsx';
        $config['max_size']	= '10000';
        $config['file_name'] = "profile_".date("Y-m-d-H-i-s");
        $this->load->library('upload', $config);
       
        if($this->upload->do_upload('pic'))
        {
            $udata = $this->upload->data();
            $data['pic'] = $udata['file_name'];
        }
        
        $my = new mysql_class;
        $update_qu='';
        foreach($data as $key=>$value)
        {
            if(!($key=='code_melli' || $key=='rooz' || $key=='mah'  || $key=='sal' || $key=='pass2' || $key=='pass_emza2' ))
            {    
                if($key=='pass')
                {    
                    if($value!='')
                    {    
                        $update_qu.= ($update_qu==''?'':',')."`$key`='$value'";
                    }    
                }
                else if($key=='pass_emza')
                {    
                    if($value!='')
                    {    
                        $update_qu.= ($update_qu==''?'':',')."`$key`='$value'";
                    }    
                }
                else
                {
                    $update_qu.= ($update_qu==''?'':',')."`$key`='$value'";
                }    
            } 
        }
        $tarikh_p = $data['sal'].'/'.$data['mah'].'/'.$data['rooz'];
        $tarikh = $this->inc_model->jalaliToMiladi($tarikh_p);
        if($update_qu!='')
        {
            $q = "update `user` set $update_qu,tarikh_tavalod='$tarikh' where id=$user_id";
            //echo $q;
            $my->ex_sqlx($q);
        }
    }
    public function loadMenu()
    {
        /*
         * یک  = ارشد
         * دو = کانتر
         *  سه = مشتری
         *  چهار = حسابدار
         */
        $menu_and_paper = array(
            1 => array(
                "صفحه اصلی" => site_url()."home",
                "ثبت مشتری جدید" => site_url()."register",
                "کارتابل" => site_url()."paper_cartable/normal",
                "ثبت نامه جدید" => site_url()."paper_new",
                "نامه های ارسالی" => site_url()."paper_cartable/sent",
                "بایگانی" => site_url()."paper_cartable/archive",
                "پیشنویس ها" => site_url()."paper_cartable/pishnevis",
                "پروفایل" => site_url()."profile",
                "گزارش فروش" => site_url()."sale_report",
                "چاپ فرم" => site_url()."print_form",
                "مدیریت کاربران"=> site_url()."user_edit",
                "مدیریت خدمات"=> site_url()."khadamat"
            ),
            2 => array(
                "صفحه اصلی" => site_url()."home",
                "ثبت مشتری جدید" => site_url()."register",
                "چاپ فرم" => site_url()."print_form",
                "کارتابل" => site_url()."paper_cartable/normal",
                "ثبت نامه جدید" => site_url()."paper_new",
                "نامه های ارسالی" => site_url()."paper_cartable/sent",
                "بایگانی" => site_url()."paper_cartable/archive",
                "پیشنویس ها" => site_url()."paper_cartable/pishnevis",
                "پروفایل" => site_url()."profile"        
            ),
            3 => array(
                "صفحه اصلی" => site_url()."home",
                "کارتابل" => site_url()."paper_cartable/normal",
                "ثبت نامه جدید" => site_url()."paper_new",
                "نامه های ارسالی" => site_url()."paper_cartable/sent",
                "بایگانی" => site_url()."paper_cartable/archive",
                "پیشنویس ها" => site_url()."paper_cartable/pishnevis",
                "پروفایل" => site_url()."profile"        
            ),
            4 => array(
                "صفحه اصلی" => site_url()."home",
                "تایید پیش‌فاکتور" => site_url()."hesab_factor",
                "کارتابل" => site_url()."paper_cartable/normal",
                "ثبت نامه جدید" => site_url()."paper_new",
                "نامه های ارسالی" => site_url()."paper_cartable/sent",
                "بایگانی" => site_url()."paper_cartable/archive",
                "پیشنویس ها" => site_url()."paper_cartable/pishnevis",
                "پروفایل" => site_url()."profile"        
            ),
            5 => array(
                "صفحه اصلی" => site_url()."home",
                "تایید پیش‌فاکتور" => site_url()."hesab_factor",
                "کارتابل" => site_url()."paper_cartable/normal",
                "ثبت نامه جدید" => site_url()."paper_new",
                "نامه های ارسالی" => site_url()."paper_cartable/sent",
                "بایگانی" => site_url()."paper_cartable/archive",
                "پیشنویس ها" => site_url()."paper_cartable/pishnevis",
                "پروفایل" => site_url()."profile"        
            )
        );
        $menu_no_paper = array(
            1 => array(
                "صفحه اصلی" => site_url()."home",
                "ثبت مشتری جدید" => site_url()."register",
                "پروفایل" => site_url()."profile",
                "گزارش فروش" => "sale_report",
                "چاپ فرم" => site_url()."print_form",
                "مدیریت کاربران"=> site_url()."user_edit",
                "مدیریت خدمات"=> site_url()."khadamat"
            ),
            2 => array(
                "صفحه اصلی" => site_url()."home",
                "ثبت مشتری جدید" => site_url()."register",
                "چاپ فرم" => site_url()."print_form",
                "پروفایل" => site_url()."profile"        
            ),
            3 => array(
                "صفحه اصلی" => site_url()."home",
                "پروفایل" => site_url()."profile"        
            ),
            4 => array(
                "صفحه اصلی" => site_url()."home",
                "تایید پیش‌فاکتور" => site_url()."hesab_factor",
                "پروفایل" => site_url()."profile"        
            ),
            5 => array(
                "صفحه اصلی" => site_url()."home",
                "تایید پیش‌فاکتور" => site_url()."hesab_factor",
                "پروفایل" => site_url()."profile"        
            )
        );
        $conf = new conf();
        if($conf->hasPaper===TRUE)
            $m = $menu_and_paper[$this->user->group_id];
        else
            $m = $menu_no_paper[$this->user->group_id];
        return($m);
    }
} 