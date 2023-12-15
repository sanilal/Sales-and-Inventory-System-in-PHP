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
  SELECT * FROM `".TB_pre."products` 
  WHERE product_name='.$search.'
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

   <table class="table table bordered">
    <tr>
     <th>Product</th>
     <th>Available Stock</th>
     <th>Unit Price</th>
     <th>Supplier</th>
	 <!--<th>Select</th>-->
	 <th>Action</th>
    </tr>
 ';
 while($row = mysqli_fetch_array($result))
 {
	 $pr_id=$row["product_id"];
	 $supplierid=$row['manufacture'];
	$supplier_query="
  SELECT * FROM `".TB_pre."brands` WHERE `brand_id`=$supplierid
 ";
	$brandresult = mysqli_query($url, $supplier_query);
	 $supplier = mysqli_fetch_array($brandresult);
  $output .= '
   <tr>
    <td>'.$row["product_name"].'</td>
    <td>'.$row["stocks"].'</td>
    <td>'.$row["unit_price"].'</td>
    <td>'.$supplier["brand_name"].'</td>
	<!--<td><input type="checkbox" class="selectcheck" value="'.$pr_id.'" /></td>-->
	<td class="addProduct"><div class="btn btn-primary addProduct sellthisbutton" id="product_id'.$pr_id.'">Sell this</div></td>
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