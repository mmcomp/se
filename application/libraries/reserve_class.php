<?php

require_once ('lib/nusoap.php');

class reserve_class {

    public $client;

    public function __construct() {
        
    }

    public static function status($refrence_id) {
        $conf = new conf();
        $out['err']['code'] = 8;
        $out['err']['msg'] = 'UNKNOWN ERROR';
        $client = new nusoap_client("http://thtcenter.ir/se/server.php?wsdl", true);
        $arguments = array(
            "user" => $conf->wuser,
            "pass" => $conf->wpass,
            "refrence_id" => $refrence_id
        );
        $result = $client->call("reserve_status", $arguments);
        if ($client->fault) {
            $out['err']['code'] = 8;
            $out['err']['msg'] = $client->fault;
            echo '<hr/>';
            echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
            echo '<hr/>';
            echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
            echo '<hr/>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
        } else {
            $error = $client->getError();
            if ($error) {
                $out['err']['code'] = 8;
                $out['err']['msg'] = $error;
                echo '<hr/>';
                echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
                echo '<hr/>';
                echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
                echo '<hr/>';
                echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            } else {
                $out = json_decode($result, TRUE);
            }
        }
        return($out);
    }
    
    public static function tickets($refrence_id) {
        $conf = new conf();
        $out['err']['code'] = 8;
        $out['err']['msg'] = 'UNKNOWN ERROR';
        $client = new nusoap_client("http://thtcenter.ir/se/server.php?wsdl", true);
        $arguments = array(
            "user" => $conf->wuser,
            "pass" => $conf->wpass,
            "refrence_id" => $refrence_id
        );
        $result = $client->call("reserve_tickets", $arguments);
        if ($client->fault) {
            $out['err']['code'] = 8;
            $out['err']['msg'] = $client->fault;
            echo '<hr/>';
            echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
            echo '<hr/>';
            echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
            echo '<hr/>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
        } else {
            $error = $client->getError();
            if ($error) {
                $out['err']['code'] = 8;
                $out['err']['msg'] = $error;
                echo '<hr/>';
                echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
                echo '<hr/>';
                echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
                echo '<hr/>';
                echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            } else {
                $out = json_decode($result, TRUE);
            }
        }
        return($out);
    }

    public static function confirm($refrence_id) {
        $conf = new conf();
        $out['err']['code'] = 8;
        $out['err']['msg'] = 'UNKNOWN ERROR';
        $client = new nusoap_client("http://thtcenter.ir/se/server.php?wsdl", true);
        $arguments = array(
            "user" => $conf->wuser,
            "pass" => $conf->wpass,
            "refrence_id" => $refrence_id
        );
        $result = $client->call("reserve_confirm", $arguments);
        if ($client->fault) {
            $out['err']['code'] = 8;
            $out['err']['msg'] = $client->fault;
            echo '<hr/>';
            echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
            echo '<hr/>';
            echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
            echo '<hr/>';
            echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
        } else {
            $error = $client->getError();
            if ($error) {
                $out['err']['code'] = 8;
                $out['err']['msg'] = $error;
                echo '<hr/>';
                echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
                echo '<hr/>';
                echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
                echo '<hr/>';
                echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            } else {
                $out = json_decode($result, TRUE);
            }
        }
        return($out);
    }

    public static function preReserve($source_id, $flight_id, $ncap, $class_ghimat, $adl, $chd, $inf, $ip, $agency_id) {
        $conf = new conf();
        $out['err']['code'] = 8;
        $out['err']['msg'] = 'UNKNOWN ERROR';
        $client = new nusoap_client("http://thtcenter.ir/se/server.php?wsdl", true);
        $arguments = array(
            "user" => $conf->wuser,
            "pass" => $conf->wpass,
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
//        echo "ticketyab -> SE<br/>";
//        var_dump($arguments);
        $result = $client->call("reserve_start", $arguments);
        if ($client->fault) {
            $out['err']['code'] = 8;
            $out['err']['msg'] = $client->fault;
        } else {
            $error = $client->getError();
            if ($error) {
                $out['err']['code'] = 8;
                $out['err']['msg'] = $error;
                echo '<hr/>';
                echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
                echo '<hr/>';
                echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
                echo '<hr/>';
                echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            } else {
                $out = json_decode($result, TRUE);
            }
        }
        return($out);
    }

    public static function passengers($refID, $passengers, $mobile, $email, $address, $description) {
        $conf = new conf();
        $out['err']['code'] = 8;
        $out['err']['msg'] = 'UNKNOWN ERROR';
        $client = new nusoap_client("http://thtcenter.ir/se/server.php?wsdl", true);
        $arguments = array(
            "user" => $conf->wuser,
            "pass" => $conf->wpass,
            "refrence_id" => $refID,
            "jpassengers" => json_encode($passengers),
            "mobile" => $mobile,
            "email" => $email,
            "address" => $address,
            "description" => $description
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
                echo '<hr/>';
                echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
                echo '<hr/>';
                echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
                echo '<hr/>';
                echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
            } else {
                $out = json_decode($result, TRUE);
            }
        }
        return($out);
    }

}
