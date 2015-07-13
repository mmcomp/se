<?php
    class history_class
    {
        public function __construct($id=-1)
        {
            if((int)$id > 0)
            {
                $mysql = new mysql_class;
                $mysql->ex_sql("select * from `paper_history` where `id` = $id",$q);
                if(isset($q[0]))
                {
                    $r = $q[0];
                    foreach($r as $k=>$v)
                        $this->$k = $v;
                }
            }
        }
        public static function add($letter_id, $user_id,$user_sender_id, $tarikh, $in_cartable, $vaziat, $is_roonevesht)
        {
            $mysql = new mysql_class;
            $ln = $mysql->ex_sqlx("insert into `paper_history` (`letter_id`, `user_id`,`user_sender_id`, `tarikh`, `in_cartable`, `vaziat`, `is_roonevesht`) values ($letter_id, $user_id,$user_sender_id,'$tarikh', $in_cartable, $vaziat, $is_roonevesht)",FALSE);
            $id = $mysql->insert_id($ln);
            $mysql->close($ln);
            return($id);
        }
        public static function out_cartable($user_id,$letter_id)
        {
            $my = new mysql_class;
            $my->ex_sqlx("update paper_history set in_cartable=0 where user_id=$user_id and letter_id=$letter_id");
            return(TRUE);
        }
        public static function set_erja($user_id,$letter_id)
        {
            $my = new mysql_class;
            $my->ex_sqlx("update paper_history set vaziat=3 where user_id=$user_id and letter_id=$letter_id");
            return(TRUE);
        }
        public static function setArchive($user_id,$letter_id)
        {
            $my = new mysql_class;
            $my->ex_sqlx("update paper_history set vaziat=4 where user_id=$user_id and letter_id=$letter_id");
            return(TRUE);
        }        
    }
