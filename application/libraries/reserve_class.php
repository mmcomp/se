<?php

require_once ('lib/nusoap.php');

class reserve_class {

    public $client;

    public function __construct() {
        
    }

    public function preReserve($source_id, $flight_id, $ncap, $class_ghimat, $adl, $chd, $inf, $ip, $agency_id) {
        $out['err']['code'] = 8;
        $out['err']['msg'] = 'UNKNOWN ERROR';
        $client = new nusoap_client("http://thtcenter.ir/se/server.php?wsdl", true);
        $arguments = array(
            "user" => "arad",
            "pass" => "123456",
            "source_id" => $source_id,
            "flight_id" => $flight_id,
            "ncap" => $ncap,
            "class_ghimat" => $class_ghimat,
            "adl" => $adl,
            "chd" => $chd,
            "inf" => $inf,
            "ip" => $ip,
            "agency_id" => $agency_id
        );
        $result = $client->call("reserve_start", $arguments);
        if ($client->fault) {
            $out['err']['code'] = 8;
            $out['err']['msg'] = $client->fault;
        } else {
            $error = $client->getError();
            if ($error) {
                $out['err']['code'] = 8;
                $out['err']['msg'] = $error;
            } else {
                $out = json_decode($result, TRUE);
            }
        }
        return($out);
    }

    public function passengers($refID, $passengers, $mobile, $email, $address) {
        $out['err']['code'] = 8;
        $out['err']['msg'] = 'UNKNOWN ERROR';
        $client = new nusoap_client("http://thtcenter.ir/se/server.php?wsdl", true);
        $arguments = array(
            "user" => "arad",
            "pass" => "123456",
            "refrence_id" => $refID,
            "jpassengers" => json_encode($passengers),
            "mobile" => $mobile,
            "email" => $email,
            "address" => $address
        );
        $result = $client->call("reserve_passengers", $arguments);
        if ($client->fault) {
            $out['err']['code'] = 8;
            $out['err']['msg'] = $client->fault;
        } else {
            $error = $client->getError();
            if ($error) {
                $out['err']['code'] = 8;
                $out['err']['msg'] = $error;
            } else {
                $out = json_decode($result, TRUE);
            }
        }
        return($out);
    }

}
