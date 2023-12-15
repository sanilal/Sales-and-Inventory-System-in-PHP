<?php $active="purchases"; ?>
<?php
  ob_start();
  include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  
$res_pr=mysqli_query($url,"SELECT * FROM `".TB_pre."products`");
$res_currency=mysqli_query($url,"SELECT * FROM `".TB_pre."currency` ORDER BY `currency` ASC");
//
if(isset($_REQUEST['enterproducts'])){
	$purchaseno=$_POST['purchase_no'];	
	$supplier	= $_POST['brand'];
	$res_br=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."brands` WHERE `brand_id`=$supplier")); 
	$supplier_name= $res_br->brand_name;
	if(empty($_POST['purchase_date'])) {
		$purchase_date= date("Y-m-d");
	}
	else {
		$purchase_date=$_POST['purchase_date'];
		
	}
	if(empty($_POST['entry_date'])) {
		$entry_date= date("Y-m-d");
	}
	else {
		$entry_date=$_POST['entry_date'];
		
	}
	$shipping_charges=$_POST['shipping_charges'];
	$customs_charges=$_POST['customs'];
	$handling_charges=$_POST['handling'];
	$code=$_POST['product_code'];
	$ocurrency=$_POST['origin_currency'];
	$rs_currency=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."currency` WHERE `id`='$ocurrency'")); 
	$currency_name= $rs_currency->currency;
	$convertedPrice=$_POST['convertedPrice'];
}
 if(isset($_REQUEST['btnadd'])){
	$purchaseno=$_POST['purchaseno'];
	$supplier_name=$_POST['supplier_name']; 
	$purchase_date=$_POST['purchase_date'];
	$entry_date=$_POST['entry_date'];
	$product=$_POST['product'];	
	$product_stock	= $_POST['product_stock'];
	$pur_currency=$_POST['currency_name'];
	$original_price=$_POST['original_price'];
	$conversion_ratio=$_POST['conversion_ratio'];
	$aed_price=$conversion_ratio*$original_price;
	$shipping_chargespercentage=$_POST['shipping_charges'];
	$shipping_charges=$aed_price*($shipping_chargespercentage/100);
	$customs_percentage=$_POST['customs'];
	$customs=$aed_price*($customs_percentage/100);
	$handling_percentage=$_POST['handling'];
	$handling=$aed_price*($handling_percentage/100);
	$unit_price=($convertedPrice+$shipping_charges+$customs+$handling)/$stock;

	if($product!="" && $purchaseno!="" ){
		//
		 $master_query = "INSERT INTO `".TB_pre."purchase_master` (`purchase_no`,`supplier_id`,`purchase_date`,entry_date,`purchase_currency`) VALUES('$purchaseno','$supplier_name','$purchase_date','$entry_date','$currency_name')";
		  $master_r = mysqli_query($url, $master_query) or die(mysqli_error($url));
		
		  $query = "INSERT INTO `".TB_pre."purchase` (`purchase_no`,`product_code`,`quantity`,purchased_price,`currency`,`converted_price`, `shipping`,`customs`,`handling`,`unit_price`) VALUES('$purchaseno','$product','$product_stock',$original_price,'$pur_currency','$aed_price','$shipping_charges','$customs','$handling','$unit_price' )";
		  //echo $query; exit;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Product Successfully Added";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	}
	else {
			  $error.= "Failed: Fill all the required fields";
		  }
}
?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            New Purchase
          </h1>
          
         <!-- <ol class="breadcrumb">
            <li><a href="products.php" class="btn btn-block"><i class="fa fa-eye"></i>View Products</a></li>
          </ol>-->
        
        </section>

        <!-- Main content -->
        <section class="content">
			<div id="purcahse_success" class="hide-now">
				<div class="alert alert-success">
				Purchase uploaded succesfully
				</div>
				<button type="button" class="alert alert-info"><a href="purchase_report.php?pno=<?php echo $purchaseno; ?>" >Print Details</a></button>
				 <button type="button" class="alert alert-info"><a href="add-purchase.php" >Add Another Invoice</a></button>
			</div>
          <!-- Default box -->
          <div class="box" id="itemcontainer">

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
            
				<div class="purchase-head">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<table class="center-table">
								<tr>
									<td><span>Purchase No. :<strong> <?php echo $purchaseno; ?></strong></span></td>
									<td><span>Supplier : <strong><?php echo $supplier_name; ?></strong></span></td>
									<td><span>Purchased Date : <strong><?php echo $purchase_date; ?></strong></span></td>
									<td><span>Entry Date : <strong><?php echo $entry_date; ?></strong></span></td>
									<td><span>Currency : <strong><?php echo $currency_name;	?> </strong></span></td>
								</tr>
								<tr>
									
									<td><span>Conversion Ratio : <?php echo $convertedPrice; ?></span></td>
									<td><span>Shipping : <strong><?php echo $shipping_charges;	?> %</strong></span></td>
									
									<td><span>Customs : <strong><?php echo $customs_charges;	?>% </strong></span></td>
									<td><span>Handling : <strong><?php echo $handling_charges;	?>% </strong></span></td>
								</tr>
								
							</table>
						</div>
					</div>
					
				</div>

				<?php 
					if(isset($_REQUEST['enterproducts'])){
				?>
			   <div align="right" class="add-row-button">
				<button type="button" name="add" id="add" class="btn btn-success btn-xs">Add Product<i class="fa fa-plus-circle"></i></button>
			   </div>
			  <form id="purchasemasterform" method="post" action="" >
			  				<input type="hidden" value=" <?php echo $purchaseno; ?>" name="purchaseno" id="purchaseno" />
							<input type="hidden" value=" <?php echo $supplier; ?>" name="supplier_name" id="supplier_name" />
							<input type="hidden" value=" <?php echo $purchase_date; ?>" name="purchase_date" id="purchase_date" />
							<input type="hidden" value=" <?php echo $entry_date; ?>" name="entry_date" id="entry_date" />
							<input type="hidden" value=" <?php echo $rs_currency->id; ?>" name="currency_name" id="currency_name" />
							<input type="hidden" name="conversion_ratio" id="conversion_ratio" value="<?php echo $convertedPrice; ?>" />
					   		<input type="hidden" value="<?php echo $shipping_charges; ?>" name="shipping_charge" id="shipping_charge" />
					   		<input type="hidden" value="<?php echo $customs_charges; ?>" name="customs_charges" id="customs_charges" />
					   		<input type="hidden" value="<?php echo $handling_charges; ?>" name="handling_charges" id="handling_charges" />
			  </form>
				<form role="form" method="post"  class="form-horizontal" action="" enctype="multipart/form-data" id="purchase_entry">
                  <div class="box-body">
					  <div class="table-responsive">
					 <table class="table table-striped table-bordered center-table" id="user_data">
					  <tr>
					   <th>Product Name</th>
					   <th>Quantity</th>
					   <th>Unit price</th>
					 <!--  <th>Shipping (%)</th>
					   <th>Customs(%)</th>
					   <th>Handling (%)</th>-->
					    <th>Edit</th>
      					<th>Remove</th>
					  </tr>
					 </table>
					</div>
				</div><!-- /.box-body -->
					    <div align="center">
							 <input type="submit" name="insert" id="insert" class="btn btn-primary" value="Submit"  />
						</div>

                </form>
			   <div id="user_dialog" title="Add Data">
				   <div class="form-group">
					<label>Product Name</label>
					  <select class="form-control" name="product_name" id="product_name" required>
							<option value="">Select</option>
							<?php 
							
							while($row_pr=mysqli_fetch_object($res_pr)){
							?>
							<option value="<?php echo $row_pr->product_id; ?>"><?php echo $row_pr->product_name; ?></option>
							<?php    
							}
							?>
							</select>
					<span id="error_product_name" class="text-danger"></span>
					   		<input type="hidden" value=" <?php echo $purchaseno; ?>" name="purchaseno" id="purchaseno" />
							<input type="hidden" value=" <?php echo $supplier; ?>" name="supplier_name" id="supplier_name" />
							<input type="hidden" value=" <?php echo $purchase_date; ?>" name="purchase_date" id="purchase_date" />
							<input type="hidden" value=" <?php echo $entry_date; ?>" name="entry_date" id="entry_date" />
							<input type="hidden" value=" <?php echo $rs_currency->id; ?>" name="currency_name" id="currency_name" />
							<input type="hidden" name="conversion_ratio" id="conversion_ratio" value="<?php echo $convertedPrice; ?>" />
					   		<input type="hidden" value="<?php echo $shipping_charges; ?>" name="shipping_charge" id="shipping_charge" />
					   		<input type="hidden" value="<?php echo $customs_charges; ?>" name="customs_charges" id="customs_charges" />
					   		<input type="hidden" value="<?php echo $handling_charges; ?>" name="handling_charges" id="handling_charges" />
				   </div>
				   <div class="form-group">
					<label>Quantity</label>
					<input type="number" name="product_stock" id="product_stock" class="form-control" min="1" step="any" />
					<span id="error_product_stock" class="text-danger"></span>
				   </div>
				   <div class="form-group">
					<label>Unit price</label>
					<input type="number" class="form-control original_price" placeholder="Price" name="original_price" id="original_price" />
					<span id="error_original_price" class="text-danger"></span>
				   </div>

				   <div class="form-group" align="center">
					<input type="hidden" name="row_id" id="hidden_row_id" />
					<button type="button" name="save" id="save" class="btn btn-info">Save</button>
				   </div>
			  </div>
          
				<?php } ?>
            </div><!-- /.box-body -->
			 <div id="action_alert" title="Action">

 			 </div>
			   
  <!--   <div id="priceDisplay">
			<table>
		 	<tr>
				<th>Price :</th>	
				<td>100</td>
			</tr>
			<tr>
				<th>Shipping :</th>	
				<td>23</td>
			</tr>
			<tr>
				<th>Customs :</th>	
				<td>60</td>
			</tr>
			<tr>
				<th>Handling :</th>	
				<td>35</td>
			</tr>
			<tr>
				<th><strong>Total :</strong></th>	
				<td>520</td>
			</tr>
		 </table>
			</div>-->
          </div><!-- /.box -->
		
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->


<?php include_once('includes/footer.php'); ?>
    <!-- jQuery 2.1.4 -->
<?php include_once('includes/footer-scripts.php'); ?>     
<!--<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>-->
<script>
/*$(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('productdesc');
	CKEDITOR.replace('productattr');
  });*/
	$(document).ready(function(){
		
		
		 load_data();
		 function load_data(query)
		 {
		 //var pr_id = $('#pr_id').val();
		  $.ajax({
		   url:"ajax_product-search.php",
		   method:"POST",
		   data:{query:query},
		   success:function(data)
		   {
			$('#searchresult').html(data);
		   }
		  });
		 }
		 $('#product').keyup(function(){
		  var search = $(this).val();
		  if(search != '')
		  {
		   load_data(search);
		  }
		  else
		  {
		   load_data();
		  }
		 });

		
		var count = 0;

 $('#user_dialog').dialog({
  autoOpen:false,
  width:400
 });
/*$('#product_name').selectize({
   create: true,
	sortField: {
		field: 'text',
		direction: 'asc'
	},
	dropdownParent: 'body'
});*/

 $('#add').click(function(){
  $('#user_dialog').dialog('option', 'title', 'Add Data');
  $('#product_name').val('');
  $('#purchaseno').val();
  $('#supplier_name').val();
  $('#purchase_date').val();
  $('#entry_date').val();
  $('#currency_name').val();
  $('#conversion_ratio').val();
  $('#shipping_charge').val();
  $('#customs_charges').val();
  $('#handling_charges').val();
  $('#product_stock').val('');
  $('#original_price').val('');
/*  $('#shipping_charges').val('');
  $('#customs').val('');
  $('#handling').val('');*/
  $('#error_product_name').text('');
  $('#error_product_stock').text('');
  $('#error_original_price').text('');
/*  $('#error_shipping_charges').text('');
  $('#error_customs').text('');
  $('#error_handling').text('');*/
  $('#product_name').css('border-color', '');
  $('#product_stock').css('border-color', '');
  $('#original_price').css('border-color', '');
/*  $('#shipping_charges').css('border-color', '');
  $('#customs').css('border-color', '');
  $('#handling').css('border-color', '');*/
  $('#save').text('Save');
  $('#user_dialog').dialog('open');
 });

 $('#save').click(function(){
  var error_product_name = '';
  var error_product_stock = '';
  var error_original_price = '';
/*  var error_shipping_charges = '';
  var error_customs = '';
  var error_handling = '';*/
  var product_name = '';
  var productName = '';
  var purchaseno = '';
  var supplier_name ='';
  var purchase_date ='';
  var entry_date ='';
  var currency_name ='';
  var conversion_ratio ='';
  var shipping_charge ='';
  var customs_charges ='';
  var handling_charges ='';
  var product_stock = '';
  var original_price = '';
/*  var shipping_charges = '';
  var customs = '';
  var handling = '';*/
  if($('#product_name').val() == '')
  {
   error_product_name = 'Product Name is required';
   $('#error_product_name').text(error_product_name);
   $('#product_name').css('border-color', '#cc0000');
   product_name = '';
   productName = '';
   purchaseno = '';
  }
  else
  {
   error_product_name = '';
   $('#error_product_name').text(error_product_name);
   $('#product_name').css('border-color', '');
   product_name = $('#product_name').val();
	 var rowid="row_"+product_name;
	  if ($("#user_data tr").hasClass(rowid)) {
		  alert("Item already added");
		  exit;
	  }
   productName = $("#product_name option:selected").html();
   purchaseno = $('#purchaseno').val();
   supplier_name =$('#supplier_name').val();
   purchase_date = $('#purchase_date').val();
   entry_date = $('#entry_date').val();
   currency_name =$('#currency_name').val();
   conversion_ratio = $('#conversion_ratio').val();
   shipping_charge =$('#shipping_charge').val();
   customs_charges =$('#customs_charges').val();
   handling_charges =$('#handling_charges').val();

  } 
  if($('#product_stock').val() == '')
  {
   error_product_stock = 'Quantity required';
   $('#error_product_stock').text(error_product_stock);
   $('#product_stock').css('border-color', '#cc0000');
   product_stock = '';
  }
  else
  {
   error_product_stock = '';
   $('#error_product_stock').text(error_product_stock);
   $('#product_stock').css('border-color', '');
   product_stock = $('#product_stock').val();
  }
  if($('#original_price').val() == '')
  {
   error_original_price = 'Price is required';
   $('#error_original_price').text(error_original_price);
   $('#original_price').css('border-color', '#cc0000');
   original_price = '';
  }
  else
  {
   error_original_price = '';
   $('#error_original_price').text(error_original_price);
   $('#original_price').css('border-color', '');
   original_price = $('#original_price').val();
  } 
 /* if($('#shipping_charges').val() == '')
  {
   error_shipping_charges = 'Shipping charge is required';
   $('#error_shipping_charges').text(error_shipping_charges);
   $('#shipping_charges').css('border-color', '#cc0000');
   shipping_charges = '';
  }
  else
  {
   error_shipping_charges = '';
   $('#error_shipping_charges').text(error_shipping_charges);
   $('#shipping_charges').css('border-color', '');
   shipping_charges = $('#shipping_charges').val();
  } 
  if($('#customs').val() == '')
  {
   customs = 'Customs required';
   $('#error_customs').text(error_customs);
   $('#customs').css('border-color', '#cc0000');
   customs = '';
  }
  else
  {
   error_customs = '';
   $('#error_customs').text(error_customs);
   $('#customs').css('border-color', '');
   customs = $('#customs').val();
  } 
  if($('#handling').val() == '')
  {
   handling = 'Handling required';
   $('#error_handling').text(error_handling);
   $('#handling').css('border-color', '#cc0000');
   handling = '';
  }
  else
  {
   error_handling = '';
   $('#error_handling').text(error_handling);
   $('#handling').css('border-color', '');
   handling = $('#handling').val();
  } */
	 
 if(error_product_name != '' || error_product_stock != '' || error_original_price != '')
	 //  if(error_product_name != '' || error_product_stock != '' || error_original_price != '' || error_shipping_charges != '' || error_customs != '' || error_handling != '')
  {
   return false;
  }
  else
  {
   if($('#save').text() == 'Save')
   {
    count = count + 1;
    output = '<tr id="row_'+count+'" class="row_'+product_name+'">';
    output += '<td>'+productName+' <input type="hidden" name="hidden_product_name[]" id="product_name'+count+'" class="product_name" value="'+product_name+'" /><input type="hidden" name="hidden_purchaseno[]" id="purchaseno'+count+'" value="'+purchaseno+'" /><input type="hidden" name="hidden_supplier_name[]" id="supplier_name'+count+'" value="'+supplier_name+'" /><input type="hidden" name="hidden_purchase_date[]" id="purchase_date'+count+'" value="'+purchase_date+'" /><input type="hidden" name="hidden_entry_date[]" id="entry_date'+count+'" value="'+entry_date+'" /><input type="hidden" name="hidden_currency_name[]" id="currency_name'+count+'" value="'+currency_name+'" /><input type="hidden" name="hidden_conversion_ratio[]" id="conversion_ratio'+count+'" value="'+conversion_ratio+'" /><input type="hidden" name="hidden_shipping_charge[]" id="shipping_charge'+count+'" value="'+shipping_charge+'" /><input type="hidden" name="hidden_customs_charges[]" id="customs_charges'+count+'" value="'+customs_charges+'" /><input type="hidden" name="hidden_handling_charges[]" id="handling_charges'+count+'" value="'+handling_charges+'" /></td>';
    output += '<td>'+product_stock+' <input type="hidden" name="hidden_product_stock[]" id="product_stock'+count+'" value="'+product_stock+'" /></td>';
	output += '<td>'+original_price+' <input type="hidden" name="hidden_original_price[]" id="original_price'+count+'" value="'+original_price+'" /></td>';
	/*output += '<td>'+shipping_charges+' <input type="hidden" name="hidden_shipping_charges[]" id="shipping_charges'+count+'" value="'+shipping_charges+'" /></td>';
	output += '<td>'+customs+' <input type="hidden" name="hidden_customs[]" id="customs'+count+'" value="'+customs+'" /></td>';
	output += '<td>'+handling+' <input type="hidden" name="hidden_handling[]" id="handling'+count+'" value="'+handling+'" /></td>';*/
    output += '<td><button type="button" name="view_details" class="btn btn-warning btn-xs view_details" id="'+count+'">Edit</button></td>';
    output += '<td><button type="button" name="remove_details" class="btn btn-danger btn-xs remove_details" id="'+count+'">Remove</button></td>';
    output += '</tr>';
    $('#user_data').append(output);
   }
   else
   {
    var row_id = $('#hidden_row_id').val();
    output = '<td>'+productName+' <input type="hidden" name="hidden_product_name[]" id="product_name'+row_id+'" class="product_name" value="'+product_name+'" /><input type="hidden" name="hidden_purchaseno[]" id="purchaseno'+row_id+'" value="'+purchaseno+'" /><input type="hidden" name="hidden_supplier_name[]" id="supplier_name'+row_id+'" value="'+supplier_name+'" /><input type="hidden" name="hidden_purchase_date[]" id="purchase_date'+row_id+'" value="'+purchase_date+'" /><input type="hidden" name="hidden_entry_date[]" id="entry_date'+row_id+'" value="'+entry_date+'" /><input type="hidden" name="hidden_currency_name[]" id="currency_name'+row_id+'" value="'+currency_name+'" /><input type="hidden" name="hidden_conversion_ratio[]" id="conversion_ratio'+row_id+'" value="'+conversion_ratio+'" /><input type="hidden" name="hidden_shipping_charge[]" id="shipping_charge'+row_id+'" value="'+shipping_charge+'" /><input type="hidden" name="hidden_customs_charges[]" id="customs_charges'+row_id+'" value="'+customs_charges+'" /><input type="hidden" name="hidden_handling_charges[]" id="handling_charges'+row_id+'" value="'+handling_charges+'" /></td>';
    output += '<td>'+product_stock+' <input type="hidden" name="hidden_product_stock[]" id="product_stock'+row_id+'" value="'+product_stock+'" /></td>';
	output += '<td>'+original_price+' <input type="hidden" name="hidden_original_price[]" id="original_price'+row_id+'" value="'+original_price+'" /></td>';
	/*output += '<td>'+shipping_charges+' <input type="hidden" name="hidden_shipping_charges[]" id="shipping_charges'+row_id+'" value="'+shipping_charges+'" /></td>';
	output += '<td>'+customs+' <input type="hidden" name="hidden_customs[]" id="customs'+row_id+'" value="'+customs+'" /></td>';
	output += '<td>'+handling+' <input type="hidden" name="hidden_handling[]" id="handling'+row_id+'" value="'+handling+'" /></td>';*/
    output += '<td><button type="button" name="view_details" class="btn btn-warning btn-xs view_details" id="'+row_id+'">Edit</button></td>';
    output += '<td><button type="button" name="remove_details" class="btn btn-danger btn-xs remove_details" id="'+row_id+'">Remove</button></td>';
    $('#row_'+row_id+'').html(output);
   }

   $('#user_dialog').dialog('close');
  }
 });

 $(document).on('click', '.view_details', function(){
  var row_id = $(this).attr("id");
  var product_name = $('#product_name'+row_id+'').val();
  var product_stock = $('#product_stock'+row_id+'').val();
  var original_price = $('#original_price'+row_id+'').val();
  var shipping_charges = $('#shipping_charges'+row_id+'').val();
  var customs = $('#customs'+row_id+'').val();
  var handling = $('#handling'+row_id+'').val();
  $('#product_name').val(product_name);
  $('#product_stock').val(product_stock);
  $('#original_price').val(original_price);
  $('#shipping_charges').val(shipping_charges);
  $('#customs').val(customs);
  $('#handling').val(handling);
  $('#save').text('Edit');
  $('#hidden_row_id').val(row_id);
  $('#user_dialog').dialog('option', 'title', 'Edit Data');
  $('#user_dialog').dialog('open');
 });

 $(document).on('click', '.remove_details', function(){
  var row_id = $(this).attr("id");
  if(confirm("Are you sure you want to remove this row data?"))
  {
   $('#row_'+row_id+'').remove();
  }
  else
  {
   return false;
  }
 });

 $('#action_alert').dialog({
  autoOpen:false
 });

 $('#purchase_entry').on('submit', function(event){
  event.preventDefault();
  var count_data = 0;
  $('.product_name').each(function(){
   count_data = count_data + 1;
  });
  if(count_data > 0)
  {
   var form_data = $(this).serialize();
   $.ajax({
    url:"ajax-purchase-insert.php",
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
  }
  else
  {
   $('#action_alert').html('<p>Please Add atleast one data</p>');
   $('#action_alert').dialog('open');
  }
 });
		

		
												   
	});
	
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>