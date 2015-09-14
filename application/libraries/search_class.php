<?php

require_once "lib/nusoap.php";

//class SoapHeaderUsernameToken {
//
//    public $Password;
//    public $Username;
//
//    public function __construct($l, $p) {
//        $this->Password = $p;
//        $this->Username = $l;
//    }
//
//}

class search_class {

//    public static function fixDate($inp) {
//        return($inp);
//    }

    public static function loadLowFare($dat, $count = 8) {
        $out = array();
        $client = new nusoap_client("http://thtcenter.ir/se/server.php?wsdl", true);
        $arguments = array(
            "user" => "arad",
            "pass" => "123456",
            "dat" => (int) $dat,
            "count" => (int) $count
        );
        $result = $client->call("loadLowFare", $arguments);

        if ($client->fault) {
            
        } else {
            $error = $client->getError();
            if ($error) {
                
            } else {
                $out = json_decode($result, TRUE);
            }
        }
        return($out);

//        $wsu = 'http://schemas.xmlsoap.org/ws/2002/07/utility';
//        $usernameToken = new SoapHeaderUsernameToken('arad', '123456');
//        $soapHeaders[] = new SoapHeader($wsu, 'UsernameToken', $usernameToken);
//        $URL = 'http://thtcenter.ir/se/SEWB.php';
//
//        $client = new SoapClient(null, array(
//            'location' => $URL,
//            'uri' => "http://thtcenter.ir/se/",
//            'trace' => 1,
//        ));
//        $arguments = array(
//            "dat" => $dat,
//            "count" => $count
//        );
//        $client->__setSoapHeaders($soapHeaders);
//        $response = $client->__soapCall("loadLowFare", $arguments);
//        $out = json_decode($response, TRUE);
//        return($out);
    }

    public static function search($aztarikh, $tatarikh, $from_city, $to_city, $extra, $airlines, $sort, $way) {
        $airlines = (count($airlines) > 0) ? implode(",", $airlines) : '';
        $out = array();
        $client = new nusoap_client("http://thtcenter.ir/se/server.php?wsdl", true);
        $arguments = array(
            "user" => "arad",
            "pass" => "123456",
            "aztarikh" => $aztarikh,
            "tatarikh" => $tatarikh,
            "from_city" => $from_city,
            "to_city" => $to_city,
            "extra" => $extra,
            "airlines" => $airlines,
            "sort" => $sort,
            "way" => $way
        );
        $result = $client->call("search2", $arguments);

        if ($client->fault) {
            
        } else {
            $error = $client->getError();
            if ($error) {
                
            } else {
                $out = json_decode($result, TRUE);
            }
        }
        return($out);
//        $wsu = 'http://schemas.xmlsoap.org/ws/2002/07/utility';
//        $usernameToken = new SoapHeaderUsernameToken('arad', '123456');
//        $soapHeaders[] = new SoapHeader($wsu, 'UsernameToken', $usernameToken);
//        $URL = 'http://thtcenter.ir/se/SEWB.php';
//
//        $client = new SoapClient(null, array(
//            'location' => $URL,
//            'uri' => "http://thtcenter.ir/se/",
//            'trace' => 1,
//        ));
//        $arguments = array(
//            "aztarikh" => $aztarikh,
//            "tatarikh" => $tatarikh,
//            "from_city" => $from_city,
//            "to_city" => $to_city,
//            "extra" => $extra,
//            "airlines" => $airlines,
//            "sort" => $sort,
//            "way" => $way
//        );
//        $client->__setSoapHeaders($soapHeaders);
//        $response = $client->__soapCall("search2", $arguments);
//        $out = json_decode($response, TRUE);
//        //var_dump($out['query']);
//        return($out);
    }

}
