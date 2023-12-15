<?php  
error_reporting(0);
ob_start();
session_start();
include("includes/conn.php"); 
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
  SELECT * FROM `".TB_pre."products` 
  WHERE product_name LIKE '%".$search."%'
  OR product_code LIKE '%".$search."%' 
  OR p_desc LIKE '%".$search."%'
 ";

}
else
{
 $query = "
  SELECT * FROM `".TB_pre."products` ORDER BY product_id
 ";
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

   <table class="table table bordered center-table">
    <tr>
	<th>No.</th>
	 <th>Product Code</th>
     <th>Product</th>
     <th>Available Stock</th>
     <!--<th>Unit Price</th>-->
     <!--<th>Supplier</th>-->
	 <!--<th>Select</th>-->
	 <th>Action</th>
    </tr>
 ';
	 $counter = 0;
 while($row = mysqli_fetch_array($result))
 {
	 $pr_id=$row["product_id"];
	 
	 $purchaset_query="
	  SELECT * FROM `".TB_pre."purchase` WHERE `product_id`=$pr_id
	 ";
	$purchasetresult = mysqli_query($url, $purchaset_query);
	$purchasetrr = mysqli_fetch_array($purchasetresult);
	$purchasetno = $purchasetrr['purchase_no'];

	$purchasemastert_query="
	  SELECT * FROM `".TB_pre."purchase_master` WHERE `purchase_no`=$purchasetno LIMIT 1
	 ";
	$purchasemastertresult = mysqli_query($url, $purchasemastert_query);
	$purchasemastertr = mysqli_fetch_array($purchasemastertresult);
	$supplierid=$purchasemastertr['supplier_id'];
	 
	 
	 //$supplierid=$row['manufacture'];
	$supplier_query="
  SELECT * FROM `".TB_pre."brands` WHERE `brand_id`=$supplierid
 ";
	$brandresult = mysqli_query($url, $supplier_query);
	 $supplier = mysqli_fetch_array($brandresult);
	 $purchase_q="
  SELECT sum(quantity) FROM `".TB_pre."purchase` WHERE `product_id`=$pr_id
 ";
	 $purchaseresult = mysqli_query($url, $purchase_q);
   $purchasestock = mysqli_fetch_array($purchaseresult);
   $tot_purchasestock = $purchasestock['sum(quantity)'];
   $sales_quantity_q="
  SELECT sum(quantity) FROM `".TB_pre."sales` WHERE `product_id`=$pr_id
 ";
	 $sales_quantity_result = mysqli_query($url, $sales_quantity_q);
   $salesstock = mysqli_fetch_array($sales_quantity_result);
   $tot_salestock = $salesstock['sum(quantity)'];
   $totalstock = $tot_purchasestock-$tot_salestock;
   
  $output .= '
  <tr id="row'.$pr_id.'">
   	<td>'.++$counter.'</td>
	<td>'.$row["product_code"].'</td>
	<td>'.$row["product_name"].'</td>
    <td>'.$totalstock.'</td>
    <!--<td>'.$row["unit_price"].'</td>-->
    <!--<td>'.$supplier["brand_name"].'</td>-->
	<!--<td><input type="checkbox" class="selectcheck" value="'.$pr_id.'" /></td>-->
	<td><button class="btn btn-primary details-btn" data-id="'.$pr_id.'" data-name="product '.$pr_id.'" data-name="'.$row["product_name"].'" data-quantity="1" >Add Item</button></td>
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

   </div>
   ';
 echo $output;
}
else
{
 echo 'Data Not Found';
}

?>