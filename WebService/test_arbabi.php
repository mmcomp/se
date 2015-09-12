<?php

$client = new SoapClient("http://elitsafar.ir/liaisonServices.asmx?wsdl");
$params->user = 'gohar';
$params->password = '123456';
$params->from = 'زاهدان';
$params->to = 'مشهد';
$params->ShamsiDate = '1394/06/05';
$result = $client->requestAV($params);

var_dump($result);