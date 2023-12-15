<?php  
error_reporting(0);
ob_start();
include("includes/conn.php"); 
session_start();
if(!isset($_SESSION['user_id'])){
	header("Location: logout.php");
	echo "<script type='text/javascript'>window.top.location='logout.php';</script>";
	exit;
}
else if($_SESSION['user_id']=="" || $_SESSION['user_id']==NULL){
	header("Location: logout.php");
	echo "<script type='text/javascript'>window.top.location='logout.php';</script>";
	exit;
}


if(!empty($_POST['currencyorigin'])) {
	$oprice = 1;
	$currencyorigin = $_POST['currencyorigin'];
	$res_currency=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."currency` WHERE `id`=$currencyorigin"));
	$currency_code=$res_currency->code;
	// Fetching JSON
$req_url = 'https://api.exchangerate-api.com/v4/latest/'.$currency_code.'';
$response_json = file_get_contents($req_url);

// Continuing if we got a result
if(false !== $response_json) {

   // Try/catch for json_decode operation
    try {

	// Decoding
	$response_object = json_decode($response_json);

	// YOUR APPLICATION CODE HERE, e.g.
	$base_price = 1; // Your price in USD
	$AED_price = round(($base_price * $response_object->rates->AED), 4);
	$converted_price = $oprice * $AED_price;
    }
    catch(Exception $e) {
        // Handle JSON parse error...
    }
	echo $converted_price;
}
	
	/*$cargoType_q=mysqli_query($url,"SELECT * FROM `".TB_pre."cargo_type` ");
	if($cargoType_q->num_rows > 0){
		
		echo('<option value="">Select Import/Export</option>');
		  while($cargoType=mysqli_fetch_object($cargoType_q)){
			  echo("<option value='$cargoType->id'> $cargoType->ctype</option>");
		  }
	} else {
			echo '<option value="">Cargo Type not available</option>';
			}*/ //Parcel / Document
} else {
			echo $oprice;
			}

?>
