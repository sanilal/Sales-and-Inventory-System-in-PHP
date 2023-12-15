<?php $active="purchases"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  

$purchaseno=$_GET['pno'];

$sql="select * from `".TB_pre."purchase`  WHERE `purchase_no`= $purchaseno";
$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));
$unit_price_sum = "select sum(purchased_price) from `".TB_pre."purchase` WHERE `purchase_no`= $purchaseno";
$sum_purchasedprice = mysqli_query($url, $unit_price_sum);
$total_purchasedprice = mysqli_fetch_array($sum_purchasedprice);

$quantity_sum = "select sum(quantity) from `".TB_pre."purchase` WHERE `purchase_no`= $purchaseno";
$sum_quantity = mysqli_query($url, $quantity_sum);
$total_quantity = mysqli_fetch_array($sum_quantity);

?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Purchase No. : <?php echo $purchaseno; ?>
          </h1>
          
          <!--<ol class="breadcrumb">
            <li><a href="products.php" class="btn btn-block"><i class="fa fa-eye"></i>View Products</a></li>
          </ol>-->
        
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">

            <div class="box-header with-border">
              <?php if(isset($msg)){ if($msg!=""){ ?>
              	<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> <?php echo $msg; ?></h4>
                    
               	</div>
               <?php }} ?> 
               <?php if(isset($error)){ if($error!=""){ ?>
              	<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> <?php echo $error; ?></h4>
                    
               	</div>
               <?php } } ?> 
            </div>
            
            <div class="box-body">
				<?php 
					$res_pur=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."purchase_master` WHERE `purchase_no`=$purchaseno LIMIT 1" ));
					$res_sup=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."brands` WHERE `brand_id`=$res_pur->supplier_id"));
				?>
				<!--<div class="purchaseInfoLeft">
					<p>Purchase No: <?php //echo $res_pur->purchase_no; ?></p>
					<p>Supplier: <?php //echo $res_sup->brand_name; ?></p>
					<p>Invoice date: <?php //echo $res_pur->purchase_date; ?></p>
				</div>
				<div class="purchaseInforight">
					<p>Shipping: <?php //echo $res_pur->shipping; ?></p>
					<p>Customs: <?php //echo $res_pur->customs; ?></p>
					<p>Handling: <?php //echo $res_pur->handling; ?></p>
				</div>-->
				<table id="tableheader" class="center-table" style="max-width: 600px;">
	
	<tr>
		<td style="text-align: left;">Purchase No :  <?php echo '&nbsp;&nbsp;'. $res_pur->purchase_no; ?></td>
		<td style="text-align: left;">Supplier : <?php echo '&nbsp;&nbsp;'. $res_sup->brand_name; ?></td>
		<td style="text-align: left;">Invoice date : <?php echo '&nbsp;&nbsp;'. $res_pur->purchase_date; ?></td>
	</tr>
	<tr>
		<td style="text-align: left;">Shipping : <?php echo '&nbsp;&nbsp;'. $res_pur->shipping; ?>%</td>
		<td style="text-align: left;">Customs : <?php echo '&nbsp;&nbsp;'. $res_pur->customs; ?>%</td>
		<td style="text-align: left;">Handling :<?php echo '&nbsp;&nbsp;'. $res_pur->handling; ?>%</td>
	</tr>
	
	<!--<table width="50%">
	<tr>
		<th style="text-align: left;">Purchase No:</th>
		<td style="text-align: left;"><?php echo $res_pur->purchase_no; ?></td>
	</tr>
	<tr>
		<th style="text-align: left;">Supplier:</th>
		<td style="text-align: left;"><?php echo $res_sup->brand_name; ?></td>
	</tr>
	<tr>
		<th style="text-align: left;">Invoice date:</th>
		<td style="text-align: left;"><?php echo $res_pur->purchase_date; ?></td>
	</tr>
</table>-->
			  

</table>
	
<!--<table width="50%">
	<tbody align="right">
<tr>
		<th style="text-align: left;">Shipping: </th>
		<td style="text-align: left;"><?php echo $res_pur->shipping; ?>%</td>
	</tr>
	<tr>
		<th style="text-align: left;">Customs: </th>
		<td style="text-align: left;"><?php echo $res_pur->customs; ?>%</td>
	</tr>
	<tr>
		<th style="text-align: left;">Handling: </th>
		<td style="text-align: left;"><?php echo $res_pur->handling; ?>%</td>
	</tr>
</tbody>-->
</table>	
</td></tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>
              <table class="center-table">
	<thead>
	<tr>
		<th>No.</th>
		<th>Product Code</th>
		<th>Product Name</th>
		<th>Product Category</th>
		<th>Quantity</th>
		<th>Unit Price (AED)</th>
		<th>Shipping (AED)</th>
		<th>Customs (AED)</th>
		<th>Handling (AED)</th>
		<th>Adjusted Price (AED)</th>
		<th>Total (AED)</th>
	</tr>
	</thead>
	<tbody>
		<?php 
			$i = 1;
			while($res = mysqli_fetch_object($r1)){ 
			$product_id=$res->product_id;			
			$res_product=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."products` WHERE `product_id`=$product_id"));
		 	$res_prcat=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE `cat_id`=$res_product->category"));
			$res_purmast=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."purchase_master` WHERE `purchase_no`=$purchaseno"));
			$unit_price=round(($res_purmast->conversion_ratio*$res->purchased_price), 2);
			$total_item_price = $total_purchasedprice[0]*$res_purmast->conversion_ratio;
			$roundedshipping = round((($unit_price*$res->quantity)*($res_pur->shipping/100))/$res->quantity, 2);
			$roundedcustoms = round((($unit_price*$res->quantity)*($res_pur->customs/100))/$res->quantity, 2);
			$roundedhandling = round((($unit_price*$res->quantity)*($res_pur->handling/100))/$res->quantity, 2);
			$adjustedprice = round($unit_price+$roundedshipping+$roundedcustoms+$roundedhandling, 2);
		?>
	<tr>
		<td><?php echo $i++; ?></td>
		<td><?php echo $res_product->product_code; ?></td>
		<td><?php echo $res_product->product_name; ?></td>
		<td><?php echo $res_prcat->cat_name; ?></td>
		<td><?php echo $res->quantity; ?></td>
		<td><?php echo $unit_price; ?></td>
		<!--<td><?php //echo round((($res_pur->shipping)/$total_quantity[0])*$res->quantity, 2); ?></td>-->
		<td><?php echo $roundedshipping; ?></td>
		<!--<td><?php //echo round((($res_pur->customs)/$total_quantity[0])*$res->quantity, 2); ?></td>-->
		<td><?php echo $roundedcustoms; ?></td>
		<!--<td><?php //echo round((($res_pur->handling)/$total_quantity[0])*$res->quantity, 2); ?></td>-->
		<td><?php echo $roundedhandling; ?></td>
		<td><?php echo $adjustedprice; ?></td>
		<td class="total"><?php echo $adjustedprice*$res->quantity; ?></td>
		<!--<td class="total"><?php //echo round((($unit_price+((($unit_price*$res->quantity)*($res_pur->shipping/100))/$res->quantity+(($unit_price*$res->quantity)*($res_pur->customs/100))/$res->quantity+(($unit_price*$res->quantity)*($res_pur->handling/100))/$res->quantity))*$res->quantity), 2); ?></td>-->
		<!--<td class="total"><?php echo (($unit_price+(round((($unit_price*$res->quantity)*($res_pur->shipping/100))/$res->quantity, 2)+round((($unit_price*$res->quantity)*($res_pur->customs/100))/$res->quantity, 2)+round((($unit_price*$res->quantity)*($res_pur->handling/100))/$res->quantity, 2)))*$res->quantity); ?></td>-->
	</tr>
<?php } ?>
		<tr>
		<td colspan="10"><h4 style="text-align: center"><strong>Total</strong></h4></td>
		<td><div id="sum" style="font-size: 22px; font-weight: bold;"></div></td>
	</tr>
	</tbody>
</table>
				
				<center style="margin-top:25px">
<button class="alert alert-success"><a href="purchase_report-print.php?pno=<?php echo($purchaseno); ?>">Print Report</a></div>
				
            </button>
</center><!-- /.box-body -->
            
     
          </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php include_once('includes/footer.php'); ?>
    <!-- jQuery 2.1.4 -->
<?php include_once('includes/footer-scripts.php'); ?>     
<!--<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>-->
<script>

	$(document).ready(function(){
		
  var sum = 0;
  $(".total").each(function(){
    sum += parseFloat($(this).text());
  });
  $('#sum').text(sum.toFixed(2));
		
		



		
												   
	});
	
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>