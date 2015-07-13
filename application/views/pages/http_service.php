<?php
    if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    function repareDate($inp)
    {
        $out = str_replace("/", "-", $inp);
        $tmp = explode("-", $out);
        $y = ((int)$tmp[0]>(int)$tmp[2])?(int)$tmp[0]:(int)$tmp[2];
        $d = ((int)$tmp[0]>(int)$tmp[2])?(int)$tmp[2]:(int)$tmp[0];
        $m = (int)$tmp[1];
        if($y<100)
        {
            $y+=1300;
        }
        $out = $y.'-'.(($m<10)?'0':'').$m.'-'.(($d<10)?'0':'').$d;
        return($out);
    }
    $tmp_val = <<<TT
            <div class="row hs-margin-up-down hs-padding hs-border ps-box" style="margin-right: 2px;margin-left: 2px;" onclick="selectParvaz(#i#);">
                <div class="col-sm-2">
                    #mabda#
                </div>
                <div class="col-sm-2">
                    #maghsad#
                </div>
                <div class="col-sm-2">
                    #tarikh#
                </div>
                <div class="col-sm-2">
                    #saat#
                </div>
                <div class="col-sm-2">
                    #airline#
                </div>
                <div class="col-sm-2">
                    #fnumber#
                </div>
            </div>
TT;
    //var_dump($_REQUEST);
    if(!isset($_REQUEST['aztarikh']) || !isset($_REQUEST['tatarikh']) || !isset($_REQUEST['mabda_id']) || !isset($_REQUEST['maghsad_id']))
    {
        die('اطلاعات را کامل انتخاب کنید');
    }
    $aztarikh = repareDate($_REQUEST['aztarikh']);
    $tatarikh = repareDate($_REQUEST['tatarikh']);
    $mabda_id = $_REQUEST['mabda_id'];
    $maghsad_id = $_REQUEST['maghsad_id'];
    
    
    $URL = 'http://85.17.22.14/se/SEWB.php';

    $client = new SoapClient(null, array(
        'location' => $URL,
        'uri'      => "http://85.17.22.14/se/",
        'trace'    => 1,
    ));
    $arguments = array(
        "aztarikh" => $aztarikh, //از تاریخ که اجباری نمی باشد درصورت خالی فرستادن از آن صرف نظر خواهد شد
        "tatarikh" => $tatarikh, //تا تاریخ که اجباری نمی باشد درصورت خالی فرستادن از آن صرف نظر خواهد شد
        "from_city" => $mabda_id,       //کد یاتا شهر مبدا  ورود آن اجباری است
        "to_city" => $maghsad_id,         //کد یاتا شهر مقصد ورود آن اجباری است
        "extra" => "extra"          //در صورت ارسال این پارامتر  کلیه اطلاعات جانبی پرواز نیز ارسال می گردد که حجم داده را افزایش می دهد  در صورت خالی فرستادن از آن صرف نظر خواهد شد
    );
    $response = $client->__soapCall("search", $arguments);
    $result = json_decode($response);
    $err = $result->err;
    $out = '';
    $output = array();
    if($err->code==0)
    {
        $data = $result->data;     //داده های بازگشتی در صورت نبود خطا
	//var_dump($data);
        foreach($data as $i=>$flight)
        {
            $tflight = str_replace("#mabda#", $flight->from_city, $tmp_val);
            $tflight = str_replace("#maghsad#", $flight->to_city, $tflight);
            $tflight = str_replace("#tarikh#", $flight->fdate, $tflight);
            $tflight = str_replace("#saat#", $flight->ftime, $tflight);
            $tflight = str_replace("#airline#", $flight->airline, $tflight);
            $tflight = str_replace("#fnumber#", $flight->flight_number, $tflight);
            $tflight = str_replace("#i#", $i, $tflight);
            $out .= $tflight;
        }
        $output['obj'] = $data;
    }
    else
    {
        $out =  "Error ".$err->code." Happend with Message = '".$err->msg."'";
                                   //خطایی رخ داده و نمایش در خروجی
    }
    $output['html'] = $out;
    $output['err'] = $err;
    die(json_encode($output));