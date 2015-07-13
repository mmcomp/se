<?php
    $URL = 'http://192.168.2.80/crm/WebService/w.php';

    $client = new SoapClient(null, array(
        'location' => $URL,
        'uri'      => "http://192.168.2.80/crm/WebService/",
        'trace'    => 1,
    ));
    $response = $client->__soapCall("getFactors", array(
        "aztarikh" => "20140101",
        "tatarikh" => "20160101"
    ));
    $result = json_decode($response);
    var_dump($result);