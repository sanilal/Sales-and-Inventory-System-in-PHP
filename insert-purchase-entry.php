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

if(isset($_POST["product_name"]))
{
 $purchaseno = $_POST["purchaseno"];
 $currency = $_POST["currency_name"];
 $product_name = $_POST["product_name"];
 $quantity = $_POST["quantity"];
 $unit_price = $_POST["unit_price"];
 $query = '';
 for($count = 0; $count<count($product_name); $count++)
 {
  $item_name_clean = mysqli_real_escape_string($url, $product_name[$count]);
  $item_code_clean = mysqli_real_escape_string($url, $quantity[$count]);
  $item_price_clean = mysqli_real_escape_string($url, $unit_price[$count]);
  if($item_name_clean != '' && $item_code_clean != '' && $item_price_clean != '')
  {
   $query .= '
   INSERT INTO md_purchase (purchase_no, product_id, quantity, purchased_price, currency) 
   VALUES("'.$purchaseno.'", "'.$item_name_clean.'", "'.$item_code_clean.'", "'.$item_price_clean.'", "'.$currency.'"); 
   ';
  }
 }
 if($query != '')
 {
  if(mysqli_multi_query($url, $query))
  {
	  
	  printf("Error message: %s\n", mysqli_error($url));
   echo 'Item Data Inserted';
	  
  }
  else
  {
	   printf("Error message: %s\n", mysqli_error($url));
   echo 'Error';
  }
 }
 else
 {
	 var_dump($query);
	// printf("Error message: %s\n", mysqli_error($query));
  echo 'All Fields are Required';
 }
}
?>
