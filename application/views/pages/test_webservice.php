<?php

$airlines = 'تابان,آسمان'; //Airline list Cama seperated and if empty All airlines is searched
$aztarikh = '1394-07-05';  //Start date 
$tatarikh = '1394-07-10';  //End date
$from_city = '';        //From city in IATA format if empty all availabe cities is considered
$to_city = '';          //To city in IATA format if empty all availabe cities is considered
$extra = 'extra';          //This parameter should be 'extra' to return all flight details as price and etc.
$sort = 'all';             //This parameter defines what field should be results sorted by, if it is 'all' no sort is applied
$way = 'one';              //This parameter defines that search is one way or 'two' way



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
    var_dump($result);
} else {
    $error = $client->getError();
    if ($error) {
        var_dump($error);
    } else {
        $out = json_decode($result, TRUE);
        var_dump($out);
    }
}

echo '<hr/>';
echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
echo '<hr/>';
echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
echo '<hr/>';
echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';