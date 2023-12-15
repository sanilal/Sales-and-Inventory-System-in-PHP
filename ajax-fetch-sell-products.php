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

$output = '';
if(isset($_POST["query"]))
{
 $search = mysqli_real_escape_string($url, $_POST["query"]);
 $query = "
  SELECT * FROM `".TB_pre."purchase` 
  WHERE id = $search";
}
else
{
echo "No Purchases";
}
$result = mysqli_query($url, $query);
if(mysqli_num_rows($result) > 0)
{
/*$product = mysqli_fetch_array($result);
	$brand_id = $product['manufacture'];
$cat_query = "
SELECT * FROM `".TB_pre."brands`
WHERE brand_id = $brand_id
";
$cat_result = mysqli_query($url, $cat_query);*/
 $counter = 0;
 while($row = mysqli_fetch_array($result))
 {
    $r_id=$row["id"];
    $pr_id=$row["product_id"];
     $purchase_id=$row["id"];
     $purchase_no=$row["purchase_no"];
   $product_query="
   SELECT * FROM `".TB_pre."products` WHERE `product_id`=$pr_id
  ";
  $productresult = mysqli_query($url, $product_query);
   $product = mysqli_fetch_array($productresult);
   $supplierid=$product['manufacture'];

	$supplier_query="
  SELECT * FROM `".TB_pre."brands` WHERE `brand_id`=$supplierid
 ";
	$brandresult = mysqli_query($url, $supplier_query);
   $supplier = mysqli_fetch_array($brandresult);
   $purchase_no=$row['purchase_no'];
   $pmaster_query="
  SELECT * FROM `".TB_pre."purchase_master` WHERE `purchase_no`=$purchase_no LIMIT 1
 ";
	$pmasterresult = mysqli_query($url, $pmaster_query);
	 $pmasterresult = mysqli_fetch_array($pmasterresult);
  $converted_price=round($pmasterresult["conversion_ratio"]*$row["purchased_price"], 2);
  $conversion_ratio=$pmasterresult['conversion_ratio'];
  //$shipping=$pmasterresult['shipping'];
  $shipping=round((($converted_price*$row['quantity']*$pmasterresult['shipping'])/100)/$row['quantity'], 2);
  $customs=round((($converted_price*$row['quantity']*$pmasterresult['customs'])/100)/$row['quantity'], 2);
  $handling=round((($converted_price*$row['quantity']*$pmasterresult['handling'])/100)/$row['quantity'], 2);
  //$customs=$pmasterresult['customs'];
 // $handling=$pmasterresult['handling'];
  //$unit_price=($shipping/($row['quantity']))+($customs/($row['quantity']))+($handling/($row['quantity']))+$converted_price;
  $unit_price=round($shipping+$customs+$handling+$converted_price, 2);
  $en_date=date("Y-m-d");
  $res_sales=mysqli_query($url,"SELECT * FROM `".TB_pre."sales` ORDER BY `sales_no` DESC LIMIT 1");
  $row_sales=mysqli_fetch_object($res_sales);
  $last_sales=$row_sales->sales_no;
  $customerId=$_POST["customer"];
  $purchase_quantity=$row['quantity'];
  $sales_quantity=mysqli_query($url,"SELECT sum(quantity) FROM `".TB_pre."sales` WHERE `purchase_id`=$search");
  $row_sales_quantity=mysqli_fetch_array($sales_quantity);
  $salesquantity=$row_sales_quantity['sum(quantity)'];
  $available_quantity=$purchase_quantity-$salesquantity;

  if(isset($last_sales)) {
    $salesNo=$last_sales+1;
  } else {
    $salesNo=1;
  }
  $output .= '
 
   <tr id="row'.$r_id.'" class="result-row row'.$r_id.'">
   <!--<td class="counter">'.++$counter.'</td>-->
   <td>'.$product['product_code'].'<input type="hidden" name="product_code[]" value="'.$product['product_code'].'" id="product_code'.$r_id.'" ><input type="hidden" class="salesNo" name="sales_no[]" id="sales_no'.$r_id.'" value="'.$salesNo.'"></td>
    <td>'.$product["product_name"].'<input type="hidden" class="product_name" name="product_id[]" id="product_id'.$r_id.'" value="'.$pr_id.'" ><input type="hidden" name="purchase_id[]" id="purchase_id'.$r_id.'" value="'.$r_id.'" ><input type="hidden" name="customer_id[]" id="customer_id'.$r_id.'" value="'.$customerId.'" ></td>
    <td>'.$available_quantity.'<input type="hidden" name="available[]" id="available'.$r_id.'" value="'.$available_quantity.'" ><input type="hidden" name="entry_date[]" value="'.$en_date.'" id="entry_date'.$r_id.'" ></td>
    <td><input type="number" id="quantity[]" class="quantity" name="quantity[]" onchange="stockCheck()" min="1" max="'.$available_quantity.'" required ></td>
	<td>'.$unit_price.'<input type="hidden" name="unit_price[]" id="unit_price'.$r_id.'" value="'.$unit_price.'" ></td>
	<!-- <td><button class="btn btn-primary sellthis-btn" data-id="'.$purchase_id.'" data-name="'.$row["product_name"].'" data-quantity="1" >Select</button></td>-->
	<td><button class="btn btn-danger delete-btn" data-id="'.$r_id.'" >Remove</button></td>
   </tr>
  ';
 }
	$output .= '
 <!--  <tr>
   <td></td><td></td><td></td><td></td><td></td><td><input type="checkbox" class="selectAll" /> &nbsp; &nbsp; Select All</td>
   <td class="addProduct"><input type="submit" value="Sell Selected" class="btn btn-primary addProduct"/></td>
   </tr>-->
   ';
 echo $output;
}
else
{
 echo 'Data Not Found';
}

?>