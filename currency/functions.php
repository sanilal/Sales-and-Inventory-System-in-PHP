<?php
function currencyConverter($fromCurrency,$toCurrency,$amount) {
$fromCurrency = "AED";//urlencode($fromCurrency);
$toCurrency = "INR";//urlencode($toCurrency);
$url = "https://www.google.com/search?q=".$fromCurrency."+to+".$toCurrency;
$get = file_get_contents($url);
$data = preg_split('/\D\s(.*?)\s=\s/',$get);
$exhangeRate = (float) substr($data[1],0,7);
$convertedAmount = $amount*$exhangeRate;
$data = array( 'exhangeRate' => $exhangeRate, 'convertedAmount' =>$convertedAmount, 'fromCurrency' => strtoupper($fromCurrency), 'toCurrency' => strtoupper($toCurrency));
echo json_encode( $data );
}
?>