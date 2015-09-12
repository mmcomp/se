<?php

class SoapHeaderUsernameToken {

    public $Password;
    public $Username;

    public function __construct($l, $p) {
        $this->Password = $p;
        $this->Username = $l;
    }

}

class search_class {

    public static function fixDate($inp) {
        return($inp);
    }

    public static function loadLowFare($dat, $count = 8) {
        $wsu = 'http://schemas.xmlsoap.org/ws/2002/07/utility';
        $usernameToken = new SoapHeaderUsernameToken('arad', '123456');
        $soapHeaders[] = new SoapHeader($wsu, 'UsernameToken', $usernameToken);
        $URL = 'http://thtcenter.ir/se/SEWB.php';

        $client = new SoapClient(null, array(
            'location' => $URL,
            'uri' => "http://thtcenter.ir/se/",
            'trace' => 1,
        ));
        $arguments = array(
            "dat" => $dat,
            "count" => $count
        );
        $client->__setSoapHeaders($soapHeaders);
        $response = $client->__soapCall("loadLowFare", $arguments);
        $out = json_decode($response, TRUE);
        return($out);
    }

    public static function search($aztarikh, $tatarikh, $from_city, $to_city, $extra, $airlines, $sort, $way) {
        $wsu = 'http://schemas.xmlsoap.org/ws/2002/07/utility';
        $usernameToken = new SoapHeaderUsernameToken('arad', '123456');
        $soapHeaders[] = new SoapHeader($wsu, 'UsernameToken', $usernameToken);
        $URL = 'http://thtcenter.ir/se/SEWB.php';

        $client = new SoapClient(null, array(
            'location' => $URL,
            'uri' => "http://thtcenter.ir/se/",
            'trace' => 1,
        ));
        $arguments = array(
            "aztarikh" => $aztarikh,
            "tatarikh" => $tatarikh,
            "from_city" => $from_city,
            "to_city" => $to_city,
            "extra" => $extra,
            "airlines" => $airlines,
            "sort" => $sort,
            "way" => $way
        );
        $client->__setSoapHeaders($soapHeaders);
        $response = $client->__soapCall("search2", $arguments);
        $out = json_decode($response, TRUE);
        //var_dump($out['query']);
        return($out);
    }
}
