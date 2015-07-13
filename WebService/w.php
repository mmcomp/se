<?php
    class addParvaz{
        public $m;
        public function __construct() {
            $this->m = new mysqli('localhost','root','3068145','mahan');
        }
        public function add($flight){
            $ok = FALSE;
            if($this->m->connect_errno!==FALSE)
            {
                $ok = $this->m->query("insert into `parvaz` (`FlightNumber`, `ArrivalDateTime`, `DepartureDateTime`, `JourneyDuration`, `RPH`, `DestinationLocation_text`, `DestinationLocation_iata`, `OriginLocation_text`, `OriginLocation_iata`, `zarfiat`) values ('".$flight['FlightNumber']."', '".$flight['ArrivalDateTime']."', '".$flight['DepartureDateTime']."', '".$flight['JourneyDuration']."', '".$flight['RPH']."', '".$flight['DestinationLocation']['text']."', '".$flight['DestinationLocation']['iata']."', '".$flight['OriginLocation']['text']."', '".$flight['OriginLocation']['iata']."', 9)");
            }
            return($ok);
        }
    }
    class MyClass{
        function getFactors($aztarikh,$tatarikh) { 
            $tark = '';
            $aztarikh = trim($aztarikh);
            $tatarikh = trim($tatarikh);
            if(strlen($aztarikh)==8)
            {
                $aztarikh = substr($aztarikh, 0,4).'-'.substr($aztarikh, 4,2).'-'.substr($aztarikh, 6,2);
                $tark = " and tarikh >= '$aztarikh'";
            }
            if(strlen($tatarikh)==8)
            {
                $tatarikh = substr($tatarikh, 0,4).'-'.substr($tatarikh, 4,2).'-'.substr($tatarikh, 6,2);
                $tark .= " and tarikh <= '$tatarikh'";
            }
            $out = array();
            $m = new mysqli('localhost','root','3068145','crm');
            if($this->m->connect_errno!==FALSE)
            {
                $takhfif_hesab = '65456456';
                $maliat_hesab = '879797';
                $system_code = "45";
                $afzoode = "0.9";
                $dt = $m->query("SELECT tarikh IssueDate,'هتل' ServiceType,'رزور هتل' ServiceDetails,date_format(az_tarikh,'%Y%m%d') `Time 1st`,date_format(ta_tarikh,'%Y%m%d') `Time 2nd`,factor.id `Contract Number`, '$takhfif_hesab' `Discount Accounting ID`,takhfif `Discount Amount`,'$maliat_hesab' `VAT Accounting ID`,mablagh*$afzoode `VAT Amount`, 'گوهر' `Datasource System Code Type`,'$system_code' `Datesource System Code`, mablagh `Factor Amount` FROM `hotel` left join `factor` on (factor_id=factor.id) WHERE is_tasfieh = 1 $tark");
                while($obj = $dt->fetch_object()){ 
                    $out[] = $obj;
                }
            }
            //   return "Length of the string " . $string . "is : ".strlen($string);
            return(json_encode($out));
        }
        function hello($string)
        {
            return "Hello `$string`.";
        }
    }
    $server = new SoapServer(null, 
                array('uri' => "urn://www.mirsamie.com")); 
    $server->setClass("MyClass");
    $server->handle(); 
