<?php
    class search_class
    {
        public static function fixDate($inp)
        {
            return($inp);
        }
        public static function loadLowFare($dat,$count=8)
        {
            function perToEnNums($inNum) {
                $outp = $inNum;
                $outp = str_replace('۰', '0', $outp);
                $outp = str_replace('۱', '1', $outp);
                $outp = str_replace('۲', '2', $outp);
                $outp = str_replace('۳', '3', $outp);
                $outp = str_replace('۴', '4', $outp);
                $outp = str_replace('۵', '5', $outp);
                $outp = str_replace('۶', '6', $outp);
                $outp = str_replace('۷', '7', $outp);
                $outp = str_replace('۸', '8', $outp);
                $outp = str_replace('۹', '9', $outp);
                return($outp);
            }
            $sign = ($dat < 0)?' - ': ' + ';
            $dat = abs($dat);
            $param['aztarikh'] = perToEnNums(jdate("Y-m-d",strtotime(date("Y-m-d").$sign.$dat.' day')));
            $param['tatarikh'] = perToEnNums(jdate("Y-m-d",strtotime(date("Y-m-d").$sign.$dat.' day')));
            $param['extra'] = '';
            $param['sort'] = 'price';
            $param['limit'] = $count;
            $flight = new flight_class(TRUE,$param);
            $out['data'] = $flight->data;
            $out['err']['code'] = 0;
            $out['err']['msg'] = '';
            return($out);
        }
        public static function search($aztarikh,$tatarikh,$from_city,$to_city,$extra,$airlines,$sort,$way)
        {   
            $out = array("err"=>array("code"=>"1","msg"=>"Unknown ERROR"),"data"=>array());
            $param = array();
            $aztarikh = trim($aztarikh);
            $tatarikh = trim($tatarikh);
            $extra = trim($extra);
            $from_city = trim($from_city);
            $to_city = trim($to_city);
            if($aztarikh!='')
            {
                $param['aztarikh'] = search_class::fixDate($aztarikh);
            }
            if($tatarikh!='')
            {
                $param['tatarikh'] = search_class::fixDate($tatarikh);
            }
            if($extra!='')
            {
                $param['extra'] = $extra;
            }
            if(strlen($from_city)==3 && strlen($to_city)==3)
            {
                $param['from_city'] = $from_city;
                $param['to_city'] = $to_city;
            }
            if(count($airlines)>0)
            {
                $param['extra'] = 'extra';
                $airs = array();
                foreach ($airlines as $airline)
                {
                    $tmp = explode("|", $airline);
                    foreach($tmp as $tt)
                    {
                        $airs[] = $tt;
                    }
                }
                $param['airline'] = $airs;
            }
            $param['sort'] = $sort;
            $param['way'] = $way;
            /*
            else
            {
                $out['err']['code'] = 2;
                $out['err']['msg'] = 'From or To CITY IATA code is not right.';
            }
             * 
             */
            $flight = new flight_class(TRUE,$param);
            $out['data'] = $flight->data;
            $out['err']['code'] = 0;
            $out['err']['msg'] = '';
            return($out);
        }
    }