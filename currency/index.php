<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Untitled Document</title>
</head>

<body>
	
	
	<?php 
		$fromCurrency = "AED";//urlencode($fromCurrency);
$toCurrency = "INR";//urlencode($toCurrency);
$url = "https://www.google.com/search?q=".$fromCurrency."+to+".$toCurrency;
$get = file_get_contents($url);
$data = preg_split('/\D\s(.*?)\s=\s/',$get);
$exhangeRate = (float) substr($data[1],0,7);
	print_r($exhangeRate);
/*$convertedAmount = $amount*$exhangeRate;
	echo $convertedAmount;*/
	?>

</body>
</html>