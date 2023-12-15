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
  SELECT * FROM `".TB_pre."brands` 
  WHERE brand_name LIKE '%".$search."%'
 ";

}
else
{
 $query = " SELECT * FROM `".TB_pre."brands` ";
}
$result = mysqli_query($url, $query);
if(mysqli_num_rows($result) > 0)
{
 $output .= '
  <div class="table-responsive">

   <table class="table table bordered center-table">
    <tr>
     <th>No.</th>
	 <th>Customer Name</th>
	 <th>Action</th>
    </tr>
 ';
	$count=1;
 while($row = mysqli_fetch_array($result))
 {
	 $pr_id=$row["brand_id"];
  $output .= '
   <tr id="row-'.$count++.'">
   	<td>'.+$count.'</td>
    <td>'.$row["brand_name"].'</td>
	<!--<td><input type="checkbox" class="selectcheck" value="'.$pr_id.'" /></td>-->
	<td class="addProduct"><a href="sell-products.php?brand_id='.$pr_id.'"><div class="btn btn-primary addProduct">Select</div></a></td>
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