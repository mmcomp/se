<?php
    error_reporting(E_ALL);ini_set('display_errors', 1);
    $URL = 'http://thtcenter.ir/se/SEWB.php';

    $client = new SoapClient(null, array(
        'location' => $URL,
        'uri'      => "http://thtcenter.ir/se/",
        'trace'    => 1,
    ));
    $arguments = array(
        "aztarikh" => "1394-06-15", //از تاریخ که اجباری نمی باشد درصورت خالی فرستادن از آن صرف نظر خواهد شد
        "tatarikh" => "1394-06-16", //تا تاریخ که اجباری نمی باشد درصورت خالی فرستادن از آن صرف نظر خواهد شد
        "from_city" => "MHD",       //کد یاتا شهر مبدا  ورود آن اجباری است
        "to_city" => "THR",         //کد یاتا شهر مقصد ورود آن اجباری است
        "extra" => "extra"          //در صورت ارسال این پارامتر  کلیه اطلاعات جانبی پرواز نیز ارسال می گردد که حجم داده را افزایش می دهد  در صورت خالی فرستادن از آن صرف نظر خواهد شد
    );
    $response = $client->__soapCall("search", $arguments);

    //echo $response;
    $result = json_decode($response);
    $err = $result->err;
    if($err->code==0)
    {
        $data = $result->data;     //داده های بازگشتی در صورت نبود خطا
	var_dump($data);
    }
    else
    {
        echo "Error ".$err->code." Happend with Message = '".$err->msg."'";
                                   //خطایی رخ داده و نمایش در خروجی
    }