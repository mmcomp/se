<?php
class Parvaz_model extends CI_Model {
    public function loadAll($from,$to,$from_date,$to_date,$agency,$outl='')
    {
        $user = 'ali';
        $pass = md5('1234');
        $data = json_encode(array(
            "from"     => $from,
            "to"       => $to,
            "from_date"=> $from_date,
            "to_date"  => $to_date,
            "agency"   => $agency
        ));
        if(trim($outl)!='')
        {
            $url = $outl;
        }
        $url = "http://192.168.2.110/gohar2/server/server.php"."?user=$user&pass=$pass&cmd=getFlightList&data=$data";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL,$url);
        /*
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,
                    "user=$user&pass=$pass&cmd=getFlightList&data=$data");
        */
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
        $out = json_decode(trim(curl_exec ($ch)));
        curl_close ($ch);
        return($out);
    }
}

