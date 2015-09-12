<?php

require_once ('lib/nusoap.php');

class reserve_class {

    public $client;

    public function __construct() {
    }

    public function preReserve($customer_id, $agency_id, $flight_id, $ncap, $bflight_id, $bncap, $adult, $child, $inf) {
        if (!$this->client) {
            $this->client = new nusoap_client('http://164.138.22.33/AAA/server.php?wsdl', true);
        }
        $ip = getenv("REMOTE_ADDR");
        if (!$ip) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        if (!$ip) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }
        if (!$ip) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
        $params = array(
            'customer_id' => $customer_id,
            'agency_id' => $agency_id,
            'flight_id' => $flight_id,
            'ncap' => $ncap,
            'bflight_id' => $bflight_id,
            'bncap' => $bncap,
            'adult' => $adult,
            'child' => $child,
            'inf' => $inf,
            'ip' => $ip
        );
        $result = $this->client->call('Reserve', array('param' => json_encode($params)));
        return(json_decode($result));
    }

}
