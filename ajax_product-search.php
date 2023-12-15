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
  WHERE product_name LIKE '%".$search."%'
  OR product_code LIKE '%".$search."%' 
  OR p_desc LIKE '%".$search."%'
 ";

}
/*else
{
 $query = "
  SELECT * FROM `".TB_pre."products` ORDER BY product_id
 ";
}*/
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
 ';
	$counter = 0;
 while($row = mysqli_fetch_array($result))
 {
	 $i=$i++;
	 $pr_id=$row["product_id"];
	 $supplierid=$row['manufacture'];
	 $catid=$row['category'];
	$supplier_query="
  SELECT * FROM `".TB_pre."brands` WHERE `brand_id`=$supplierid
 ";
	$cat_query="
  SELECT * FROM `".TB_pre."pcategories` WHERE `cat_id`=$catid
 ";
	$brandresult = mysqli_query($url, $supplier_query);
	$supplier = mysqli_fetch_array($brandresult);
	$catresult = mysqli_query($url, $cat_query);
	$category = mysqli_fetch_array($catresult);
  $output .= '
   <tr>
     <td data-id="'.$row["product_code"].'"><span class="productname">'.$row["product_name"].'</span>('.$row["product_code"].')<div class="btn btn-primary addthisProduct" data-product="'.$row["product_id"].'" data-prname="'.$row["product_name"].'">Add this</div></td>
   
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
/*else
{
 echo 'Data Not Found';
}*/

?>