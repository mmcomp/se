<?php
class Cartable_model extends CI_Model {
    public function loadAll($user_id,$type_id=-1,$vaziat=-1)
    {
        return(letter_det_class::loadCartable($user_id,$type_id,$vaziat));
    }
    public function loadSent($user_id,$type_id=-1)
    {
        return(letter_det_class::sent($user_id,$type_id));
    }
    public function loadPishnevis($user_id,$type_id=-1)
    {
        return(letter_det_class::loadPishnevis($user_id,$type_id));
    }
}

