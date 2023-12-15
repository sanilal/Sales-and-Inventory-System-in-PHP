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
	$purchase_date=$_POST['purchase_date'];
	$entry_date=$_POST['entry_date'];
	$code=$_POST['product_code'];
	$ocurrency=$_POST['origin_currency'];
	$rs_currency=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."currency` WHERE `code`='$ocurrency'")); 
	$currency_name= $rs_currency->currency;
	$convertedPrice=$_POST['convertedPrice'];
}
 if(isset($_REQUEST['btnadd'])){
	 
	$product=$_POST['product'];	
	$procatname	= $_POST['productmenu'];
	$desc=$_POST['productdesc'];
	$attr=$_POST['productattr'];
	$code=$_POST['product_code'];
	$stock=$_POST['product_stock'];
	$brand=$_POST['brand'];
	$shipping_charges=$_POST['shipping_charges'];
	$originalprice=$_POST['original_price'];
	$currency=$_POST['currency'];
	$convertedPrice=$_POST['convertedPrice'];
	$unit_price=($convertedPrice+$shipping_charges)/$stock;
	$t_onimg=$_POST['text_on_image'];
	$series=0;
	$order=$_POST['order'];
	if($order==""){
		$order=0;
	}
	$featured=0; $special=0; $spl_offer=0;
	if(isset($_POST['featured'])){
		$featured=$_POST['featured'];
	}
	if(isset($_POST['special'])){
		$special=$_POST['special'];
	}
	if(isset($_POST['spl_offer'])){
		$spl_offer=$_POST['spl_offer'];
	}
	if($procatname!="" && $product!="" ){
		//
		include_once("classes/class.upload.php");
		
		$p_image=image_upload($_FILES['productimg'],$product."main_img");
		$g_image="";
		for($i=1;$i<=12;$i++){
			$u_image=image_upload($_FILES['productimg'.$i],$product."g_img".$i);
			//var_dump($_FILES['productimg'.$i]);
			if($u_image!=""){
				$g_image.=",".$u_image;
			}
		}
		$g_image=ltrim($g_image,",");
		
		//var_dump($p_image); exit;
		//
		$msg=""; $error="";
		  //var_dump($num); exit;
		  $query = "INSERT INTO `".TB_pre."products` (`product_name`,`category`,`manufacture`,model_series,`p_desc`,`p_attr`, `product_img`,`product_code`,`stocks`,`gallery_imgs`,`featured`,`special`,`spl_offer`,`p_img_text`, `p_order`, `shipping_charges`, `purchased_price`, `currency`, `converted_price`, `unit_price`) VALUES('$product','$procatname','$brand','$series','$desc','$attr','$p_image','$code','$stock','$g_image',$featured,$special,'$spl_offer','$t_onimg', $order, $shipping_charges, $originalprice, '$currency', $convertedPrice, $unit_price )";
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
				</div>

				<?php 
					if(isset($_REQUEST['enterproducts'])){
				?>
			  <div id="action_alert"></div>
				<form role="form" method="post"  class="form-horizontal" action="" enctype="multipart/form-data" id="purchase-entry">
                  <div class="box-body">
                  	<div id="formcontainer">
						<div class="row form-items">
						<div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 m-r-0">
						<input type="hidden" value=" <?php echo $purchaseno; ?>" name="purchaseno" />
							<input type="hidden" value=" <?php echo $supplier; ?>" name="supplier_name" />
							<input type="hidden" value=" <?php echo $purchase_date; ?>" name="purchase_date" />
							<input type="hidden" value=" <?php echo $entry_date; ?>" name="entry_date" />
							<input type="hidden" value=" <?php echo $rs_currency->id; ?>" name="currency_name" />
						  <label>Product Name</label>
							<select class="form-control product_name" name="product[]" id="product1" required>
							<option value="">Select</option>
							<?php 
							
							while($row_pr=mysqli_fetch_object($res_pr)){
							?>
							<option value="<?php echo $row_pr->product_id; ?>"><?php echo $row_pr->product_name; ?></option>
							<?php    
							}
							?>
							</select>
						 <!-- <input type="text" class="form-control" placeholder="Product Name" name="product" id="product" />
							<div id="searchresult"></div>-->
						</div>
						<div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 m-r-0" >
						  <label>Quantity</label>
						  <input type="number" class="form-control" placeholder="Stocks" name="product_stock[]" id="product_stock1" required />
						</div>
						<div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 m-r-0" >
						  <label>Price</label>
						  <input type="text" class="form-control original_price" placeholder="Price" name="original_price1" id="original_price1" value="" />
						  <input type="hidden" class="form-control" name="conversion_ratio" id="conversion_ratio" value="<?php echo $convertedPrice; ?>" />
						</div>
						  
						 <div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 m-r-0" >
						  <label>Converted Price (AED)</label>
						  <input type="text" class="form-control convertedPriceitem" placeholder="converted Price" name="convertedPriceitem[]" id="convertedPriceitem1" value="" readonly />
						</div>
						<div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 m-r-0" >
						  <label>Shipping (%)</label>
						  <input type="number" class="form-control" placeholder="Shipping Charges" min="1" step="any" name="shipping_charges[]" id="shipping_charges1" />
						</div>
						<div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 m-r-0" >
						  <label>Customs(%)</label>
						  <input type="number" class="form-control" placeholder="Customs" min="1" step="any" name="customs[]" id="customs1" />
						</div>
						<div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 m-r-0" >
						  <label>Handling (%)</label>
						  <input type="number" class="form-control" placeholder="handling" min="1" step="any" name="handling[]" id="handling1" />
						</div>
						<div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12 m-r-0" >
							<div class="btn btn-primary newrow"><i class="fa fa-plus-circle"></i>Add another item</div>
						</div>
							 
					</div>
					  </div>
					  
                   

                  <div class="box-footer">
					
                    <button type="submit" class="btn btn-primary" name="btnadd">Submit</button>
                  </div>
					  
					  
				</div><!-- /.box-body -->

                </form>
				<?php } ?>
            </div><!-- /.box-body -->
            
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
		
		$('#currency').on('change', function(){
			//ar originalPrice = $('#original_price').val();
			var origincurrency = $('#currency').val();
			if(origincurrency){
				$.ajax({
					type: 'POST',
					url: 'ajax_currency_conversion.php',
					data:  {currencyorigin : origincurrency},//'oprice='+originalPrice,
					success:function(html){
						$("#convertedPrice").val(html)
						//$('#convertedPrice').html(html)
					}
				});
			}else{
				$('#convertedPrice')('<input value"No" />');
				
			}
		})
/*		$('#product').on("keyup input", function(){
			var product = $('#product').val();
			if(product){
				$.ajax({
					type: 'POST',
					url: 'ajax_product-search.php',
					data:  {product : product},
					success:function(output){
						$("#searchresult").val(output)
						//$('#convertedPrice').html(html)
					}
				});
			}else{
				$('#searchresult')('<input value"No" />');
				
			}
		})*/
		
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
		
		$(document).on("change", 'input.original_price', function(event) {
		//$('input.original_price').change(function(){
			var oprice = $(this).val();
			var ratio = $('#conversion_ratio').val();
			var aedprice = oprice*ratio;
			//var targetId = $(this).nextAll('.convertedPriceitem:first');
			//$(targetId).val(aedprice);
			//targetId.val(aedprice);
			$('.convertedPriceitem').val(aedprice);
			
			//alert(oprice);
		})
		 var next = $('.form-items').length+1;
		
		$(document).on("click", '.btn.btn-primary.newrow', function(event) {
		//$('.btn.btn-primary.newrow').click(function(){
			if($(this).hasClass('newrow')){
				//var next = next + 1;
				
			var addfields = '<div class="row form-items"><div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 m-r-0"><label>Product Name</label><select class="form-control product_name" name="product[]" id="product' + next + '" required><option value="">Select</option><?php $res_pr=mysqli_query($url,"SELECT * FROM `".TB_pre."products`"); while($row_pr=mysqli_fetch_object($res_pr)){ ?> <option value="<?php echo $row_pr->product_id; ?>"><?php echo $row_pr->product_name; ?></option> <?php } ?></select></div><div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 m-r-0" ><label>Quantity</label><input type="number" class="form-control" placeholder="Stocks" name="product_stock[]" id="product_stock' + next + '" required /></div><div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 m-r-0" ><label>Price</label><input type="text" class="form-control original_price" placeholder="Price" name="original_price[]" id="original_price' + next + '" value="" /></div><div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 m-r-0" ><label>Converted Price (AED)</label><input type="text" class="form-control convertedPriceitem" placeholder="converted Price" name="convertedPriceitem[]" id="convertedPriceitem' + next + '" value="" readonly /></div><div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 m-r-0" ><label>Shipping (%)</label><input type="number" class="form-control" placeholder="Shipping Charges" min="1" step="any" name="shipping_charges[]" id="shipping_charges' + next + '" /></div><div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 m-r-0" ><label>Customs(%)</label><input type="number" class="form-control" placeholder="Customs" min="1" step="any" name="customs[]" id="customs' + next + '" /></div><div class="form-group col-lg-3 col-md-3 col-sm-6 col-xs-12 m-r-0" ><label>Handling (%)</label><input type="number" class="form-control" placeholder="handling" min="1" step="any" name="handling[]" id="handling' + next + '" /></div><div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12 m-r-0" ><div class="btn btn-primary newrow"><i class="fa fa-plus-circle"></i>Add another item</div></div></div>';
			$('#formcontainer').append(addfields);
			$(this).removeClass('newrow');
			$(this).html('<i class="fa fa-plus-circle"></i> Remove');
			$(this).find('i').removeClass('fa-plus-circle');
			$(this).find('i').addClass('fa-minus-circle');
			$(this).addClass('remove');
			} else {
				$(this).closest('.form-items').remove();
			}
		})
		$(document).on("click", '.btn.btn-primary.remove', function(event) {
		//$('.btn.btn-primary.remove').click(function(){
			$(this).closest('.form-items').remove();
		})
		
		$('#purchase-entry').on('submit', function(event){
			 event.preventDefault();
			 var count_data = 0;
			 $('.product_name').each(function(){
			   count_data = count_data + 1;
			  });
			 if(count_data > 0)
  			{	
			   var form_data = $(this).serialize();
			   $.ajax({
				url:"insert.php",
				method:"POST",
				data:form_data,
				success:function(data) {
					$('#action_alert').html('<p>Data Inserted Successfully</p>');
					}
				})
			
			}
		})

	/*	$(document).on("click", '.addthisProduct', function(event) {
			var pr_id = $(this).attr("data-product");
			var pr_name = $(this).attr("data-prname");
			$(this).closest(input).val(pr_name);
		})*/
		
												   
	});
	
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>