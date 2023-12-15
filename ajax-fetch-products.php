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
  WHERE product_id = $search";
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
 $output .= '
  <div class="table-responsive">

   <table class="table table bordered">
    <tr>
    <th>No.</th>
     <th>Product</th>
     <th>Available Stock</th>
     <th>Unit Price</th>
     <th>Supplier</th>
	 <!--<th>Select</th>-->
	 <th>Action</th>
    </tr>
 ';
 $counter = 0;
 while($row = mysqli_fetch_array($result))
 {
  // $purchase_stock_query = "
  // SELECT * FROM `".TB_pre."purchase` 
  // WHERE product_id = $search" AND purchase_no=$row['purchase_no'];
  // $purchase_stock_result = mysqli_query($url, $purchase_stock_query);
  // $purchase_stock = mysqli_fetch_array($purchase_stock_result);
  // $pur_stock=$purchase_stock['quantity'];

	 $pr_id=$row["id"];
   $product_query="
   SELECT * FROM `".TB_pre."products` WHERE `product_id`=$search
  ";
  $productresult = mysqli_query($url, $product_query);
  $product = mysqli_fetch_array($productresult);
	 
	
	 $purchaset_query="
	  SELECT * FROM `".TB_pre."purchase` WHERE `product_id`=$search
	 ";
	$purchasetresult = mysqli_query($url, $purchaset_query);
	 
	$brandresult = mysqli_query($url, $supplier_query);
   $supplier = mysqli_fetch_array($brandresult);
   $purchase_no=$row['purchase_no'];
   $pmaster_query="
  SELECT * FROM `".TB_pre."purchase_master` WHERE `purchase_no`=$purchase_no LIMIT 1
 ";
	$pmaster_result = mysqli_query($url, $pmaster_query);
	$pmasterresult = mysqli_fetch_array($pmaster_result);
  $converted_price=round($pmasterresult["conversion_ratio"]*$row["purchased_price"], 2);
  
  $shipping=round((($converted_price*$row['quantity']*$pmasterresult['shipping'])/100)/$row['quantity'], 2);
  $customs=round((($converted_price*$row['quantity']*$pmasterresult['customs'])/100)/$row['quantity'], 2);
  $handling=round((($converted_price*$row['quantity']*$pmasterresult['handling'])/100)/$row['quantity'], 2);
	 
  //$unit_price=round(($shipping/($row['quantity']))+($customs/($row['quantity']))+($handling/($row['quantity']))+$converted_price, 2);
	$unit_price=round($shipping+$customs+$handling+$converted_price, 2);
  $purchaserowId=$row["id"];
  $sales_query="
  SELECT sum(quantity) FROM `".TB_pre."sales` WHERE `purchase_id`=$pr_id
 ";
 $sales_result = mysqli_query($url, $sales_query);
 $salesresult = mysqli_fetch_array($sales_result);
 $sales_quantity=$salesresult["sum(quantity)"];
 $purchase_quantity=$row["quantity"];
 $available_stock=$purchase_quantity-$sales_quantity;
  $output .= '
   <tr id="row'.$pr_id.'">
   <td>'.++$counter.'</td>
    <td>'.$product["product_name"].'</td>
    <td>'.$available_stock.'</td>
    <td>'.$unit_price.'</td>';
	 $sid=$row["supplier_id"];
	$supQ="SELECT * FROM `".TB_pre."brands` WHERE `brand_id`=$sid";
	$brdresult = mysqli_query($url, $supQ);
   $suplier = mysqli_fetch_array($brdresult);
	 $output .= '
    <td>'.$suplier["brand_name"].'</td>
	<!--<td><input type="checkbox" class="selectcheck" value="'.$pr_id.'" /></td>-->
	<td><button class="btn btn-primary sellthis-btn" data-id="'.$pr_id.'" data-prid="'.$purchaserowId.'"  data-name="product '.$pr_id.'" data-name="'.$row["product_name"].'" data-quantity="1" >Select</button></td>
	<!--<td class="addProduct"><div class="btn btn-primary addProduct sellthisbutton" id="product_id'.$pr_id.'">Sell this</div></td>-->
   </tr>
  ';
		  
 }
	$output .= '
 <!--  <tr>
   <td></td><td></td><td></td><td></td><td></td><td><input type="checkbox" class="selectAll" /> &nbsp; &nbsp; Select All</td>
   <td class="addProduct"><input type="submit" value="Sell Selected" class="btn btn-primary addProduct"/></td>
   </tr>-->
   </table>

   </div><div class="purClose">X</div>
   ';
 echo $output;
}
else
{
 echo 'Data Not Found';
}

?>