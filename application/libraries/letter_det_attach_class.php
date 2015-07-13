<?php
    class letter_det_attach_class
    {
        public function __construct($id=-1)
        {
            if((int)$id > 0)
            {
                $mysql = new mysql_class;
                $mysql->ex_sql("select * from `paper_letter_det_attach` where `id` = $id",$q);
                if(isset($q[0]))
                {
                    $r = $q[0];
                    foreach($r as $k=>$v)
                    {    
                        $this->$k = $v;
                    }    
                }
            }
        }
        public static function add($letter_det_id, $attach_type_id, $addr, $toz)
        {
            $mysql = new mysql_class;
            $ln = $mysql->ex_sqlx("insert into `paper_letter_det_attach` (`letter_det_id`, `attach_type_id`, `addr`, `toz`) values ($letter_det_id, $attach_type_id, '$addr', '$toz')",FALSE);
            $id = $mysql->insert_id($ln);
            $mysql->close($ln);
            return($id);
        }
        
        public static function loadByLetter_det($letter_det_id)
        {
            $mysql = new mysql_class;
            $mysql->ex_sql("select * from `paper_letter_det_attach` where `letter_det_id` = $letter_det_id",$q);
            return($q);
        }
        public static function delete($id)
        {
            $mysql = new mysql_class;
            $tmp = new letter_det_attach_class($id);
            $mysql->ex_sqlx("delete from `paper_letter_det_attach` where `id` = $id");
            if(isset($tmp->addr))
            {    
                unlink(FCPATH.'upload/'.$tmp->addr);
            }
            return(TRUE);
        }        
    }
