<?php
$aed_price=1000;
$shipping_chargespercentage=5;

$shipping_charges=$aed_price*($shipping_chargespercentage/100);
echo($shipping_charges);