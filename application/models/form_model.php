<?php
class Form_model extends CI_Model {
    function replaceHashWithInput($hash,$body1,$data)
    {
        $vis_pos = -1;
        $array_vars = array();
        while($vis_pos!==FALSE)
        {
            $vis_pos1 = strpos($body1,"#".$hash."_",$vis_pos+1);
            $vis_pos2 = strpos($body1,"#".$hash."__",$vis_pos+1);
            $vis_pos = $vis_pos1;
            $textArea = ($vis_pos1==$vis_pos2);
            if($vis_pos!==FALSE)
            {
                $vis_end = strpos($body1,"#",$vis_pos+2);
                $vis = substr($body1,$vis_pos+1,$vis_end-$vis_pos-1);
                $vis2 = str_replace("[", '', $vis);
                $vis2 = str_replace("]", '', $vis2);
                $val = ((isset($data[$vis2]))?$data[$vis2]:'');
                if(strpos($vis,'[]')!==FALSE)
                {
                    if(!isset($array_vars[$vis]))
                    {
                        $array_vars[$vis] = array(
                            "index"=>0,
                            "values"=>$val
                        );
                    }
                    if(isset($array_vars[$vis]["values"][$array_vars[$vis]["index"]]))
                    {
                        $val = $array_vars[$vis]["values"][$array_vars[$vis]["index"]];
                        $array_vars[$vis]["index"]++;
                    }
                    else
                    {
                        $val = '';
                    }
                }
                $element = '<input class="'.$hash.'_input"  name="'.$vis.'" value="'.$val.'"/>';
                if($textArea===TRUE)
                {
                    $element = "<textarea class=\"$hash"."_textarea\" name=\"$vis\">$val</textarea>";
                }
                $body1 = substr($body1, 0, $vis_pos-1).$element.substr($body1, $vis_end+1);
            }
        }
        return($body1);
    }
} 