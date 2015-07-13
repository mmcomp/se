<?php
    class letter_class
    {
        public $id = -1;
        public $mozoo = '';
        public $shomare = '';
        public $user_creator_id = -1;
        public $type_id = -1;

        public function __construct($id=-1)
        {
            if((int)$id > 0)
            {
                $mysql = new mysql_class;
                $mysql->ex_sql("select * from `paper_letter` where `id` = $id",$q);
                if(isset($q[0]))
                {
                    $r = $q[0];
                    foreach($r as $k=>$v)
                        $this->$k = $v;
                }
            }
        }

        public static function shomareExists($shomare)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select `id` from `paper_letter` where `shomare` = '$shomare'",$q);
            return(isset($q[0]));
        }
        public static function add($mozoo,$shomare,$user_creator_id,$type_id)
        {
            $mysql = new mysql_class;
            $ln = $mysql->ex_sqlx("insert into `paper_letter` (mozoo,shomare,user_creator_id,type_id) values ('$mozoo','$shomare',$user_creator_id,$type_id)",FALSE);
            $id = $mysql->insert_id($ln);
            $mysql->close($ln);
            return($id);
        }
        public static function update($mozoo,$shomare,$type_id,$letter_id)
        {
            $mysql = new mysql_class;
            $mysql->ex_sqlx("update `paper_letter` set mozoo = '$mozoo' , shomare = '$shomare' , type_id = $type_id where id = $letter_id");
        }
        public static function addLetter($letter_id,$mozoo,$shomare,$user_creator_id,$type_id,$tarikh, $matn, $emza, $is_pishnevis,$attachs,$user_rec_id=array())
        {
            if((int)$letter_id <= 0)
            {    
                $letter_id = letter_class::add($mozoo, $shomare, $user_creator_id, $type_id);
            }    
            else
            {    
                letter_class::update($mozoo,$shomare,$type_id,$letter_id);
            }    
            $letter_det_id = letter_det_class::add($letter_id, $user_creator_id, $tarikh, $matn, $emza, $is_pishnevis);
            for($i = 0;$i < count($attachs);$i++)
                letter_det_attach_class::add($letter_det_id, $attachs[$i]['attach_type_id'], $attachs[$i]['addr'], $attachs[$i]['toz']);
            if($letter_id <= 0)
                history_class::add($letter_id, $user_creator_id,$user_creator_id,$tarikh, 1, (count($user_rec_id)>0)?3:2, 0);
            foreach($user_rec_id as $user)
                history_class::add($letter_id, $user['id'],$user_creator_id, $tarikh, 1, 1, $user['is_roonevesht']);

            return(array('letter_id'=>$letter_id,'letter_det_id'=>$letter_det_id));
        }
        public static function erjaLetter($letter_id,$mozoo,$shomare,$user_creator_id,$type_id,$tarikh, $matn, $emza, $is_pishnevis,$attachs,$user_rec_id=array())
        {
            $letter_det_id = letter_det_class::add($letter_id, $user_creator_id, $tarikh, $matn, $emza, $is_pishnevis);
            for($i = 0;$i < count($attachs);$i++)
                letter_det_attach_class::add($letter_det_id, $attachs[$i]['attach_type_id'], $attachs[$i]['addr'], $attachs[$i]['toz']);
            foreach($user_rec_id as $user)
                history_class::add($letter_id, $user['id'],$user_creator_id, $tarikh, 1, 1, $user['is_roonevesht']);
            history_class::out_cartable($user_creator_id, $letter_id);
            history_class::set_erja($user_creator_id, $letter_id);
            return(array('letter_id'=>$letter_id,'letter_det_id'=>$letter_det_id));
        }
        public static function updateLetter($letter_id,$mozoo,$shomare,$type_id,$matn,$emza,$user_id)
        {
            letter_class::update($mozoo,$shomare,$type_id,$letter_id);
            letter_det_class::update($letter_id, $matn, $emza, $is_pishnevis, $user_id);
        }
    }
