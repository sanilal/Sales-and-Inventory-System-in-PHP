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

?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add new Product
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
            
				<div class="purchase-head">
					<span>Purchase No. :<strong> <?php echo $purchaseno; ?></strong></span>
					<span>Supplier : <strong><?php echo $supplier_name; ?></strong></span>
					<span>Purchased Date : <strong><?php echo $purchase_date; ?></strong></span>
					<span>Entry Date : <strong><?php echo $entry_date; ?></strong></span>
					<span>Currency : <strong><?php echo $currency_name;	?> </strong></span>
					<span>Shipping : <strong>AED. <?php echo $shipping_charges;	?> </strong></span>
					<span>Cstoms : <strong>AED. <?php echo $customs_charges;	?> </strong></span>
					<span>Handling : <strong>AED. <?php echo $handling_charges;	?> </strong></span>
				</div>

				<?php 
					if(isset($_REQUEST['enterproducts'])){
				?>
			  
			  <div class="table-responsive">
				<table class="crudtable" id="crud_table">
				<thead>
				<tr>
					<th>Product Name</th>
					<th>Quantity</th>
					<th>Unit price</th>
					<th>Remove</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					 <td contenteditable="true" class="product_name"><select class="form-control product-name" name="product_name" id="prid" required>
							<option value="">Select</option>
							<?php 
							
							while($row_pr=mysqli_fetch_object($res_pr)){
							?>
							<option value="<?php echo $row_pr->product_id; ?>"><?php echo $row_pr->product_name; ?></option>
							<?php    
							}
							?>
							</select>
						 	<div class="prid"></div>
					
					</td>
					<!--<td contenteditable="true" class="product_name"></td>-->
					 <td contenteditable="true" class="quantity"></td>
					 <td contenteditable="true" class="unit_price"></td>
					<td></td>
				</tr>

				</tbody>
			</table>
				  
				<div align="right">
				 <button type="button" name="add" id="add" class="btn btn-success btn-xs">Add Product<i class="fa fa-plus-circle"></i></button>
				</div>
				<div align="center">
				 <button type="button" name="save" id="save" class="btn btn-info">Save</button>
				</div>
				<br />
				<div id="inserted_item_data"></div>
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

	var count = 1;	
	$('#add').click(function(){
	  count = count + 1;
	  var html_code = "<tr id='row"+count+"'>";
	   html_code += "<td contenteditable='true' class='product_name'><select class='form-control product-name' name='product_name' required id='prid"+count+"'><option value=''>Select</option><?php $res_pr=mysqli_query($url,"SELECT * FROM `".TB_pre."products`"); while($row_pr=mysqli_fetch_object($res_pr)){?><option value='<?php echo $row_pr->product_id; ?>'><?php echo $row_pr->product_name; ?></option><?php }?></select><div class='prid"+count+"'></div></td>";
	   html_code += "<td contenteditable='true' class='quantity'></td>";
	   html_code += "<td contenteditable='true' class='unit_price'></td>";
	   html_code += "<td><button type='button' name='remove' data-row='row"+count+"' class='btn btn-danger btn-xs remove'>Remove Product<i class='fa fa-minus-circle'></i></button></td>";   
	   html_code += "</tr>";  
	   $('#crud_table').append(html_code);
	 });
		
	 $(document).on('click', '.remove', function(){
	  var delete_row = $(this).data("row");
	  $('#' + delete_row).remove();
	 });
		
	 //$("select.product-name").change(function(){
		 $('select.product-name').on('change', function() {
			 alert();
			/* var pr_id=$(this).attr('id');
			 alert(pr_id);
			 $('hiddenfield').text($(this).val());*/
		//product_name.push$(this).children("option:selected").val();
		//product_name.push($(this).val());

	});
		
	 $('#save').click(function(){
	  var product_name = [];
	  var quantity = [];
	  var unit_price = [];
	  var purchaseno = $('#purchaseno').val();
	  var currency_name = $('#currency_name').val();
	 /* $('.product_name').each(function(){
	   product_name.push($(this).text());
	  });*/
	
	   $('.product_name').each(function(){
	   product_name.push(selectedproduct);
	  });
	  $('.quantity').each(function(){
	   quantity.push($(this).text());
	  });
	  $('.unit_price').each(function(){
	   unit_price.push($(this).text());
	  });

	  $.ajax({
	   url:"insert-purchase-entry.php",
	   method:"POST",
	   data:{product_name:product_name, quantity:quantity, unit_price:unit_price, purchaseno:purchaseno, currency_name:currency_name},
	   success:function(data){
		alert(data);
		$("td[contentEditable='true']").text("");
		for(var i=2; i<= count; i++)
		{
		 $('tr#'+i+'').remove();
		}
		fetch_item_data();
	   }
	  });
	 });



 });





	
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>