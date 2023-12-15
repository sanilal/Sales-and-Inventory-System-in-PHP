<?php

//$response = file_get_contents('https://currencydatafeed.com/api/data.php?token=eux779vrdpe5t19jwdwf&currency=EUR/USD');
//$response = json_decode($response);

// Fetching JSON
$currencyorigin = "INR";
$req_url = 'https://api.exchangerate-api.com/v4/latest/'.$currencyorigin.'';
echo($req_url);
$response_json = file_get_contents($req_url);

// Continuing if we got a result
if(false !== $response_json) {

   // Try/catch for json_decode operation
    try {

	// Decoding
	$response_object = json_decode($response_json);

	// YOUR APPLICATION CODE HERE, e.g.
	$base_price = 1; // Your price in USD
	$AED_price = round(($base_price * $response_object->rates->AED), 2);

    }
    catch(Exception $e) {
        // Handle JSON parse error...
    }
	echo $AED_price;
}

/*$api_url = 'https://currencydatafeed.com/api/data.php?token=eux779vrdpe5t19jwdwf&currency=EUR/USD';

// Read JSON file
$json_data = file_get_contents($api_url);

echo $json_data ;

// Decode JSON data into PHP array

$user_data = json_decode($json_data, true);
//print_r($user_data);
echo("<br/>");*/

//echo $user_data["currency"][];

// Cut long data into small & select only first 10 records
/*$$user_data = array_slice($array, 1, 3);*/

/*// Print data if need to debug
//print_r($user_data);*/

// Traverse array and display user data
/*foreach ($array as $user) {
	echo "name: ".$user[1];
	echo "<br />";
	echo "name: ".$user[2];
	echo "<br /> <br />";
}*/



?>