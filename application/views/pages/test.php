<?php

class SoapHeaderUsernameToken {

    public $Password;
    public $Username;
    public function __construct($l, $p) {
        $this->Password = $p;
        $this->Username = $l;
    }

}
$wsu = 'http://schemas.xmlsoap.org/ws/2002/07/utility';
$usernameToken = new SoapHeaderUsernameToken('arad', '123456');
$soapHeaders[] = new SoapHeader($wsu, 'UsernameToken', $usernameToken);

$URL = 'http://thtcenter.ir/se/SEWB.php';

$client = new SoapClient(null, array(
    'location' => $URL,
    'uri' => "http://thtcenter.ir/se/",
    'trace' => 1,
    'user' => 'aaa',
    'pass' => 'bbb'
        ));
$arguments = array(
    "dat" => 1,
    "count" => 8
);
$client->__setSoapHeaders( $soapHeaders );
$response = $client->__soapCall("loadLowFare", $arguments);
$out = json_decode($response, TRUE);
var_dump($out);
