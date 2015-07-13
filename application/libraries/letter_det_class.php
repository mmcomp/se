<?php
    class letter_det_class
    {
        public $id = -1;
        public $letter_id = -1;
        public $user_creator_id = -1;
        public $tarikh = "0000-00-00 00:00:00";
        public $matn = '';
        public $emza = 0;
        public $is_pishnevis = 0;
        public function __construct($id=-1)
        {
            if((int)$id > 0)
            {
                $mysql = new mysql_class;
                $mysql->ex_sql("select * from `paper_letter_det` where `id` = $id",$q);
                if(isset($q[0]))
                {
                    $r = $q[0];
                    foreach($r as $k=>$v)
                        $this->$k = $v;
                }
            }
        }
        public function loadByUser($letter_id,$user_id,$att=FALSE)
        {
            if((int)$user_id > 0 && (int)$letter_id > 0)
            {
                $mysql = new mysql_class;
                $mysql->ex_sql("select * from `paper_letter_det` where `user_creator_id` = $user_id and `letter_id` = $letter_id",$q);
                if(isset($q[0]))
                {
                    $r = $q[0];
                    $this->attachment = letter_det_class::loadAttachment($r['id']);
                    foreach($r as $k=>$v)
                        $this->$k = $v;
                }
            }
        }
        public static function add($letter_id, $user_creator_id, $tarikh, $matn, $emza, $is_pishnevis)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select `id` from `paper_letter_det` where `letter_id` = $letter_id and `user_creator_id` = $user_creator_id and `is_pishnevis` = 1",$q);
            if(isset($q[0]))
            {
                $id = (int)$q[0]['id'];
                $mysql->ex_sqlx("update `paper_letter_det` set `tarikh` = '$tarikh' , `matn` = '$matn' , `emza` = $emza , `is_pishnevis` = $is_pishnevis  where id =$id");
            }
            else
            {
                $ln = $mysql->ex_sqlx("insert into `paper_letter_det` (`letter_id`, `user_creator_id`, `tarikh`, `matn`, `emza`, `is_pishnevis`) values ($letter_id, $user_creator_id, '$tarikh', '$matn', $emza, $is_pishnevis)",FALSE);
                $id = $mysql->insert_id($ln);
                $mysql->close($ln);
            }
            return($id);
        }
        public static function update($letter_id, $matn, $emza, $is_pishnevis,$user_id)
        {
            $mysql = new mysql_class;
            $mysql->ex_sqlx("update `paper_letter_det` set `matn` = '$matn' , `emza` = $emza , `is_pishnevis` = $is_pishnevis where letter_id = $letter_id and user_id = $user_id limit 1");
        }
        public static function loadCartable($user_id,$type_id,$vaziat)
        {
            $mysql = new mysql_class;
            $wer = $type_id==-1?'':(' and type_id='.$type_id);
            $wer .= $vaziat==-1?' and vaziat<>4':(' and vaziat='.$vaziat);
            $mysql->ex_sql("select paper_history.tarikh,mozoo,shomare,is_roonevesht,user.fname,user.lname,vaziat,paper_type.name tname,paper_letter.id from paper_history left join paper_letter on (paper_history.letter_id=paper_letter.id) left join user on (user_sender_id=user.id) left join paper_type on (paper_type.id=type_id) where in_cartable=1 and user_id=$user_id $wer order by id desc",$q);
            for($i=0;$i<count($q);$i++)
            {
                $q[$i]['tarikh'] = jdate("d / m / Y",  strtotime($q[$i]['tarikh']));
                //$q[$i]['vaziat'] = letter_det_class::loadVaziat($q[$i]['vaziat']);
            }    
            return($q);
        }
        public static function loadVaziat($inp)
        {
            $out='';
            switch ($inp) {
                case 1:
                    $out='خوانده نشده';
                    break;
                case 2:
                    $out='خوانده شده';
                    break;
                case 3:
                    $out='ارجاع شده';
                    break;
            }
            return ($out);
        }      
        public static function loadAttachment($letter_det_id)
        {
            $q= array();
            $my = new mysql_class;
            $my->ex_sql("select `paper_attach_type`.`name` type_name,`addr`,`toz`,paper_letter_det_attach.id from paper_letter_det_attach left join paper_attach_type on (paper_attach_type.id=attach_type_id) where `letter_det_id`= $letter_det_id", $q);
            return($q);
        }       
        public static function loadAllText($letter_id)
        {
            $my = new mysql_class;
            $my->ex_sql("select `tarikh`,`matn`,`emza`,fname,lname,paper_letter_det.id from paper_letter_det left join `user` on (user.id=user_creator_id) where `letter_id`=$letter_id order by tarikh desc,id desc",$q);
            for($i=0;$i<count($q);$i++)
            {
                $q[$i]['tarikh'] = jdate("d / m / Y",  strtotime($q[$i]['tarikh']));
                $q[$i]['attachment'] = letter_det_class::loadAttachment($q[$i]['id']);
            }    
            return($q);       
        }
        public static function seen($letter_id,$user_id)
        {
            $my = new mysql_class;
            $my->ex_sqlx("update paper_history set vaziat=2 where letter_id=$letter_id and user_id=$user_id");
            return(TRUE);
        }
        public static function sent($user_id,$type_id)
        {
            $my = new mysql_class;
            $wer = $type_id==-1?'':(' and type_id='.$type_id);
            $my->ex_sql("select paper_letter_det.tarikh,mozoo,shomare,is_roonevesht,user.fname,user.lname,vaziat,paper_type.name tname,paper_letter.id from paper_letter_det left join `user` on (`user`.id=user_creator_id) left join paper_letter on (letter_id=paper_letter.id) left join paper_type on (paper_type.id=paper_letter.type_id) left join paper_history on (`paper_history`.`letter_id`=paper_letter.id) where paper_letter_det.user_creator_id=$user_id and is_pishnevis=0 $wer group by paper_letter_det.letter_id ",$q);
            for($i=0;$i<count($q);$i++)
            {
                $my->ex_sql("select fname,lname from paper_history left join `user` on (`user`.id=user_id) where user_sender_id=$user_id and letter_id=".$q[$i]['id']." group by user_id",$qq);
                $q[$i]['daryaft'] = $qq;
                $q[$i]['tarikh'] = jdate("d / m / Y",  strtotime($q[$i]['tarikh']));
            }
            return($q);
        }
        public static function loadPishnevis($user_id,$type_id)
        {
            $my = new mysql_class;
            $wer = $type_id==-1?'':(' and type_id='.$type_id);
            $my->ex_sql("select paper_letter_det.tarikh,mozoo,shomare,is_roonevesht,user.fname,user.lname,paper_type.name tname,paper_letter.id from paper_letter_det left join `user` on (`user`.id=user_creator_id) left join paper_letter on (letter_id=paper_letter.id) left join paper_type on (paper_type.id=paper_letter.type_id) left join paper_history on (`paper_history`.`letter_id`=paper_letter.id) where paper_letter_det.user_creator_id=$user_id and is_pishnevis=1 $wer",$q);
            for($i=0;$i<count($q);$i++)
            {
                $q[$i]['tarikh'] = jdate("d / m / Y",  strtotime($q[$i]['tarikh']));
            }
            return($q);
        }
    }
