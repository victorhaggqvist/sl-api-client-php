#!/usr/bin/env php
<?php

use Snilius\SL\Client;

require_once __DIR__.'/../vendor/autoload.php';

/**
 * Just FYI, this is not at "test" test but rather a usage sample and to test that things somewhat works.
 */

$platsuppslsg = 'cd332479cb44488cbe33c5d464b70291';
$reseplanerare2 = '896a1fc2cf8a401c81f3688586a0fa42';

$client = new Client(null, $reseplanerare2, $platsuppslsg);
echo "Querying site 1\n";
//$result = $client->slPlatsuppslag('Slussen');
$result = $client->slPlatsuppslag('Kista');

$siteFrom = $result[0]['SiteId'];

echo "Querying site 2\n";
//$result = $client->slPlatsuppslag('Gamlastan');
$result = $client->slPlatsuppslag('Slussen');
$siteTo = $result[0]['SiteId'];
echo "Querying trip\n";
$trip = $client->slReseplanerare2Trip($siteFrom, $siteTo);

$trips = $trip['TripList']['Trip'];

foreach ($trips as $t) {
    $list = $t['LegList'];
    echo "\n----------------------------------------------------------\n";
    $leg = $list['Leg'];

    if (array_key_exists('dir', $leg)) {
        printLeg($leg);
    } else {
        foreach ($leg as $l) {
            printLeg($l);
            echo "\n";
        }
    }
}

function printLeg($leg) {
    echo $leg['Origin']['time'].' '.$leg['Origin']['name']."\n";
    echo '- '.$leg['type'].' '.$leg['name'].' '.(array_key_exists('dir', $leg) ? $leg['dir']:'')."\n";
    echo $leg['Destination']['time'].' '.$leg['Destination']['name']."\n";
}

/*

This will output something along the lines of this.
All kinds weird responses are probably not covered in this sample, but it is something.

$ php test.php
Querying site 1
Querying site 2
Querying trip

----------------------------------------------------------
21:45 Kista
- METRO tunnelbanans blå linje 11 Kungsträdgården
22:02 T-Centralen

22:03 T-Centralen
- WALK Gå
22:06 T-Centralen

22:06 T-Centralen
- METRO tunnelbanans gröna linje 17 Skarpnäck
22:09 Slussen


----------------------------------------------------------
22:00 Kista
- METRO tunnelbanans blå linje 11 Kungsträdgården
22:16 T-Centralen

22:17 T-Centralen
- WALK Gå
22:20 T-Centralen

22:20 T-Centralen
- METRO tunnelbanans gröna linje 18 Farsta strand
22:23 Slussen


 */
