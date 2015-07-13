<?php
class Letter_model extends CI_Model {
    public function add($data, $user_creator_id,$files)
    {
        $out=array();
        $user_creator_id = (int)$user_creator_id;
        $mozoo = $data['mozoo'];
        $shomare = $data['shomare'];
        $type_id = $data['type_id'];
        $letter_id = $data['letter_id'];
        $tarikh = $this->inc_model->jalaliToMiladi($data['tarikh']);
        $matn = $data['matn'];
        $emza = isset($data['emza'])?1:0;
        $is_pishnevis = $data['is_pishnevis'];
        $attachs = array();
        $user_rec_id = array();
        if((int)trim($is_pishnevis)===0)
        {
            if(isset($data['receivers']))
                foreach($data['receivers'] as $rec)
                    if($user_creator_id!=(int)trim($rec))
                        $user_rec_id[] = array("id"=>(int)trim($rec),"is_roonevesht"=>0);
            if(isset($data['receivers_ronevesht']))
                foreach($data['receivers_ronevesht'] as $rec)
                    if($user_creator_id!=(int)trim($rec))
                        $user_rec_id[] = array("id"=>(int)trim($rec),"is_roonevesht"=>1);
        }
        $out = letter_class::addLetter($letter_id,$mozoo, $shomare, $user_creator_id, $type_id, $tarikh, $matn, $emza, $is_pishnevis, $attachs, $user_rec_id);
        $this->letter_model->upload($out['letter_det_id'],$data,$files);
        return($out);
    }
    public function upload($letter_det_id,$re,$files)
    {
        $config['upload_path'] = './upload/';
        $config['allowed_types'] = 'pdf|jpg|png|doc|docx|xls|xlsx';
        $config['max_size']	= '10000';
        //$config['max_width'] = '10024';
        //$config['max_height'] = '7680';
        $config['file_name'] = date("Y-m-d-H-i-s");
        $this->load->library('upload', $config);
        
        $tmp = $files;
        $file_count    = count($files['att']['name']);
        for($i = 0; $i < $file_count; $i++)
        {
            // Overwrite the default $_FILES array with a single file's data
            // to make the $_FILES array consumable by the upload library
            $_FILES['att']['name']        = $tmp['att']['name'][$i];
            $_FILES['att']['type']        = $tmp['att']['type'][$i];
            $_FILES['att']['tmp_name']    = $tmp['att']['tmp_name'][$i];
            $_FILES['att']['error']       = $tmp['att']['error'][$i];
            $_FILES['att']['size']        = $tmp['att']['size'][$i];

            if($this->upload->do_upload('att'))
            {
                $data = array('upload_data' => $this->upload->data());
                //echo $re['toz'][$i].'<br/>';
                //echo $re['attach_type_id'][$i].'<br/>';
                //echo $data['upload_data']['file_name'].'<br/>';
                letter_det_attach_class::add($letter_det_id,$re['attach_type_id'][$i], $data['upload_data']['file_name'], $re['toz'][$i]);
            }
            /*
            else
            {
                echo ($this->upload->display_errors());
            }
             * 
             */
        }
        /*
        foreach($files as $fi=>$val)
        {    
            var_dump($fi);
            var_dump($val);
            if($this->upload->do_upload($fi))
            {
                $data = array('upload_data' => $this->upload->data());
                var_dump($data);
            }
            else
            {
                //$error = array('error' => );
                echo ($this->upload->display_errors());
            }
        }
            
         * 
         */
        //var_dump($re);
        //var_dump($files);
        //letter_det_attach_class::getUploadFiles($data);
    }
    public function erja($data,$user_creator_id,$files)
    {
        $out=array();
        $user_creator_id = (int)$user_creator_id;
        $mozoo = 'xxz';
        $shomare = '111';
        $type_id = '222';
        $letter_id = $data['letter_id'];
        $tarikh = date("Y-m-d");
        $matn = $data['matn'];
        $emza = isset($data['emza'])?1:0;
        $is_pishnevis = 0;
        $attachs = array();
        $user_rec_id = array();
        if((int)trim($is_pishnevis)===0)
        {
            if(isset($data['receivers']))
                foreach($data['receivers'] as $rec)
                    if($user_creator_id!=(int)trim($rec))
                        $user_rec_id[] = array("id"=>(int)trim($rec),"is_roonevesht"=>0);
            if(isset($data['receivers_ronevesht']))
                foreach($data['receivers_ronevesht'] as $rec)
                    if($user_creator_id!=(int)trim($rec))
                        $user_rec_id[] = array("id"=>(int)trim($rec),"is_roonevesht"=>1);
        }
        //echo "$letter_id,$mozoo, $shomare, $user_creator_id, $type_id, $tarikh, $matn, $emza, $is_pishnevis)";
        $out = letter_class::erjaLetter($letter_id,$mozoo, $shomare, $user_creator_id, $type_id, $tarikh, $matn, $emza, $is_pishnevis, $attachs, $user_rec_id);
        $this->letter_model->upload($out['letter_det_id'],$data,$files);
        return($out);
    }
    public function archive($user_id,$letter_id)
    {
        history_class::setArchive($user_id,$letter_id);
    }        
}