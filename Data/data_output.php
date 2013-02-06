<?php
    $host = '';
    $user = '';
    $pass = '';
    $db = $user;

    $r = mysql_connect($host, $user, $pass) OR die(mysql_error());
    $r2 = mysql_select_db($db);

    $query = sprintf("SELECT portal, issuer, goal, currently_raised, latitude, longitude FROM issues WHERE latitude != ''");
    $result = mysql_query($query);

    $output = array('type' => 'FeatureCollection', 'features' => array());

    if (!$result) {
        $message  = 'Invalid query: ' . mysql_error() . "\n";
        $message .= 'Whole query: ' . $query;
        die($message);
    }
    
    while ($row = mysql_fetch_assoc($result)) {
        $row_array = array('type' => 'Feature',
                           'geometry' => array('type' => 'Point',
                                               'coordinates' => array($row['latitude'], $row['longitude'])),
                           'properties' => array('portal' => $row['portal'],
                                                 'issuer' => $row['issuer'],
                                                 'goal' => $row['goal'],
                                                 'currently_raised' => $row['currently_raised'],
                                                 'date' => '2013-01-10'
                                                )
                          );
        array_push($output['features'], $row_array);
    }
	
    echo 'cfi_callback(' . json_encode($output) . ');';
?>