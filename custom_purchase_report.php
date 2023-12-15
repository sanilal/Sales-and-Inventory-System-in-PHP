<?php $active="purchases"; ?>
<?php  
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>


  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Purchase Report
          </h1>
          
          <ol class="breadcrumb">
            <li><a href="products.php" class="btn btn-block"><i class="fa fa-eye"></i>View Products</a></li>
          </ol>
        
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
				
				<form role="form" method="post"  class="form-horizontal" action="" enctype="multipart/form-data" id="custom-report-form" name="custom-report-form">
					<div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<label>Select Supplier</label>
						<select class="form-control" name="suppliername" id="suppliername" >
						<option value="">Select</option>
						<?php 
						$res_supplier=mysqli_query($url,"SELECT * FROM `".TB_pre."brands`");
						while($sup_row=mysqli_fetch_object($res_supplier)){
						?>
						<option value="<?php echo $sup_row->brand_id; ?>"><?php echo $sup_row->brand_name; ?></option>
					
					
						<?php } ?>
						</select>
					</div>
					<div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<label>Select Product</label>
						<select class="form-control" name="productname" id="productname" >
						<option value="">Select</option>
						<?php 
						$res_pro=mysqli_query($url,"SELECT * FROM `".TB_pre."products`");
						while($row=mysqli_fetch_object($res_pro)){
						?>
						<option value="<?php echo $row->product_id; ?>"><?php echo $row->product_name; ?></option>

						<?php } ?>
						</select>
					</div>
					<div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<label>Start Date</label>
						<input type="text" class="form-control" placeholder="Start date" name="from" id="from" />
					</div>
					<div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12">
						<label>End Date</label>
						<input type="text" class="form-control" placeholder="End Name" name="to" id="to" />
					</div>
					<input type="submit" class="form-control alert alert-success" value="Search" id="search" />

				</form>
				
	
				<table id="tableheader">
	

<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>
              <table>
	<thead>
	<tr>
		<th>SI No.</th>
		<th>Product code</th>
		<th>Product Name</th>
		<th>Product Category</th>
		<th>Unit Price</th>
		<th>Quantity</th>
		<th>Shipping</th>
		<th>Customs</th>
		<th>Handling</th>
		<th>Total</th>
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
		?>
	<tr>
		<td><?php echo $i++; ?></td>
		<td><?php echo $res_product->product_code; ?></td>
		<td><?php echo $res_product->product_name; ?></td>
		<td><?php echo $res_prcat->cat_name; ?></td>
		<td><?php echo $unit_price; ?></td>
		<td><?php echo $res->quantity; ?></td>
		<!--<td><?php //echo round((($res_pur->shipping)/$total_quantity[0])*$res->quantity, 2); ?></td>-->
		<td><?php echo round(($unit_price*$res->quantity)*($res_pur->shipping/100), 2); ?></td>
		<!--<td><?php //echo round((($res_pur->customs)/$total_quantity[0])*$res->quantity, 2); ?></td>-->
		<td><?php echo round(($unit_price*$res->quantity)*($res_pur->customs/100), 2); ?></td>
		<!--<td><?php //echo round((($res_pur->handling)/$total_quantity[0])*$res->quantity, 2); ?></td>-->
		<td><?php echo round(($unit_price*$res->quantity)*($res_pur->handling/100), 2); ?></td>
		
		<td class="total"><?php echo (round(($unit_price*$res->quantity)))+(round(($unit_price*$res->quantity)*($res_pur->shipping/100), 2))+(round(($unit_price*$res->quantity)*($res_pur->customs/100), 2))+(round(($unit_price*$res->quantity)*($res_pur->handling/100), 2)); ?></td>
	</tr>
<?php } ?>
		<tr>
		<td colspan="9"><h4 style="text-align: center"><strong>Total</strong></h4></td>
		<td><div id="sum" style="font-size: 22px; font-weight: bold;"></div></td>
	</tr>
	</tbody>
</table>
				
				<center style="margin-top:25px">
<button class="alert alert-success"><a href="purchase_report-print.php?pno=<?php echo($purchaseno); ?>">Print receipt</a></div>
				
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
	$( function() {
    var dateFormat = "mm/dd/yy",
      from = $( "#from" )
        .datepicker({
          defaultDate: "+1w",
          changeMonth: true,
          numberOfMonths: 1
        })
        .on( "change", function() {
          to.datepicker( "option", "minDate", getDate( this ) );
        }),
      to = $( "#to" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 1
      })
      .on( "change", function() {
        from.datepicker( "option", "maxDate", getDate( this ) );
      });
 
    function getDate( element ) {
      var date;
      try {
        date = $.datepicker.parseDate( dateFormat, element.value );
      } catch( error ) {
        date = null;
      }
 
      return date;
    }
  } );
	$('#custom-report-form').on('submit', function(event){
	event.preventDefault();
		var form_data = $(this).serialize();
		alert(startdate);
		$.ajax({
			url:"ajax-purchase-report.php",
			method:"POST",
			data:form_data,
			success:function(newdata)
			{
			$('#user_data').find("tr:gt(0)").remove();
			//$('#action_alert').html('<p>Data Inserted Successfully</p>');
			// $('#action_alert').dialog('open');
			$('#itemcontainer').addClass('hide-now');
			$('#purcahse_success').removeClass('hide-now');
			//window.location.href = "purchase_report.php?pno=<?php //echo $purchaseno; ?>";
			}
		})
	});
		
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