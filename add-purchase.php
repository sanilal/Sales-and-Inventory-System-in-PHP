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
	$purchase_date=$_POST['purchase_date'];
	$entry_date=$_POST['entry_date'];
	$code=$_POST['product_code'];
	$currency=$_POST['product_stock'];
	$convertedPrice=$_POST['brand'];
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
            New Purchase
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
              <form role="form" method="post"  class="form-horizontal" action="add-purchase-entry.php" enctype="multipart/form-data">
                  <div class="box-body">
                  	<div class="row">
						<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 m-r-0" >
							<?php 
							
							$res_purchase=mysqli_query($url,"SELECT * FROM `".TB_pre."purchase_master` ORDER BY `purchase_no` DESC LIMIT 1");
							$row_purchase=mysqli_fetch_object($res_purchase);
							$last_purchase=$row_purchase->purchase_no;
							if(isset($last_purchase)) {
								$purchaseNo=$last_purchase+1;
							} else {
								$purchaseNo=1;
							}
							
							?>
						  <label>Purchase No.</label>
						  <input type="number" class="form-control" name="purchase_no" id="purchase_no" value="<?php echo $purchaseNo; ?>" readonly />
						</div>
						<div class="form-group col-md-12 m-r-0">
						  <label>Supplier</label>
						  <select class="form-control" name="brand" id="product_brand" required>
							<option value="">Select</option>
							<?php 
							 /* if(isset($_REQUEST['enterproducts'])){ 
								 $res_br=mysqli_query($url,"SELECT * FROM `".TB_pre."brands` WHERE brand_id=$supplier");
								  $supplier_name=$row_br->brand_name;
								  $supplier=$row_br->brand_id;
							  } else {
								  $res_br=mysqli_query($url,"SELECT * FROM `".TB_pre."brands`");
								 while($row_br=mysqli_fetch_object($res_br)){
									$supplier_name=$row_br->brand_name;
								$supplier=$row_br->brand_id;
							  }*/
							  $res_br=mysqli_query($url,"SELECT * FROM `".TB_pre."brands`");
								 while($row_br=mysqli_fetch_object($res_br)){
									$supplier_name=$row_br->brand_name;
								$supplier=$row_br->brand_id;
							
							?>
							<option value="<?php echo $supplier; ?>"><?php echo $supplier_name; ?></option>
							<?php    
							}
							?>
							</select>
						</div>
						<div class="form-group col-md-12 m-r-0" >
						  <label>Purchased Date</label>
						  <input type="date" class="form-control" placeholder="Purchased Date" name="purchase_date" id="purchase_date" />
						</div>
						<div class="form-group col-md-12 m-r-0" >
						  <label>Entry Date</label>
						  <input type="date" class="form-control" placeholder="Entry Date" name="entry_date" id="entry_date" />
						</div>
						<div class="form-group col-md-12 m-r-0" >
						  <label>Currency</label>
							  <select class="form-control" name="origin_currency" id="origin_currency" required >
							<option value="">Select Currency</option>
							<?php 
							while($row=mysqli_fetch_object($res_currency)){
							?>
							<option value="<?php echo $row->id; ?>"><?php echo $row->currency; ?></option>
							<?php } ?>
						  </select>
							<input type="hidden" class="form-control" placeholder="converted Price" name="convertedPrice" id="convertedPrice" value="" />
						</div>
					<div class="form-group col-md-12 m-r-0">
					<label>Shipping (%)</label>
					<input type="number" class="form-control" placeholder="Shipping Charges" min="0" step="any" name="shipping_charges" id="shipping_charges" required />
					<span id="error_shipping_charges" class="text-danger"></span>
				   </div>
				   <div class="form-group col-md-12 m-r-0">
					<label>Customs (%)</label>
					<input type="number" class="form-control" placeholder="Customs" min="0" step="any" name="customs" id="customs" required />
					<span id="error_customs" class="text-danger"></span>
				   </div>
				   <div class="form-group col-md-12 m-r-0">
					<label>Handling (%)</label>
					<input type="number" class="form-control" placeholder="handling" min="0" step="any" name="handling" id="handling" required />
					<span id="error_handling" class="text-danger"></span>
				   </div>
					<div class="form-group col-md-12 m-r-0" >
					<button type="submit" class="btn btn-primary" name="enterproducts">Add New Purchase</button>
					</div>
						<div class="recent-purchase" style="width: 500px; max-width: 100%;">
							<h3>Recent Purchases</h3>
							<table id="example2" class="table table-bordered table-hover center-table">
						<thead>
						  <tr>
						  <th>No.</th>
						  <!--<th>product Code</th>
							<th>Description</th>
							<th>Category</th>-->
							<!--<th>Stock</th>-->
							<!--<th>Unit Price</th>-->
							<!--<th>Supplier</th>-->
							<!--<th>Quantity</th>-->
							<th>Date</th>
							<th>Details</th>
						  </tr>
						</thead>
						<tbody>
						<?php 
							$brandd=$_GET['brand_id'];
							
						//$sql="select * from `".TB_pre."purchase`  WHERE purchase_no=(select `purchase_no` from `".TB_pre."purchase_master` WHERE supplier_id=$brandd)";
							print_r($sql);
						$sql="select * from(select * from `".TB_pre."purchase` GROUP BY purchase_no ORDER BY id DESC  LIMIT 10 ) sub
ORDER BY id DESC";
						/*foreach ($purchase_master->purchase_no as $value) {
							$sql="select * from `".TB_pre."purchase`  WHERE purchase_no=$value";
						}*/
							
						//$sql="select * from `".TB_pre."purchase`  WHERE purchase_no=$purchase_master->purchase_no ";
						$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));
						
						$i = 1;
						while($res = mysqli_fetch_array($r1)){ ?>
						  <tr>
							<td><?php echo $i++; ?></td>
							<!--<td><?php $product=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."products` WHERE product_id=".$res['product_id']));
										//echo $product->product_code;  ?></td>-->

							<!--<td><?php //echo $product->product_name; ?></td>-->

							<!--<td><?php 
							$res_cat=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE cat_id=".$product->category));
							//echo $res_cat->cat_name; 

							?></td>-->
						   <!-- <td>
							<?php 
							//$res_cat=mysqli_fetch_object(mysqli_query($url,"SELECT brand_id, brand_name FROM `".TB_pre."brands` WHERE brand_id=".$res['manufacture']));
							//echo $res_cat->brand_name; 
						//	echo $res['stocks'];
							?>
							</td>-->
							<!--<td>
							<?php 
							//$res_cat=mysqli_fetch_object(mysqli_query($url,"SELECT brand_id, brand_name FROM `".TB_pre."brands` WHERE brand_id=".$res['manufacture']));
							//echo $res_cat->brand_name; 
							//echo $res['unit_price'];
							?>
							</td>-->
						   <!--<td>

							  <?php 
							 
								  //echo $res['quantity'];
							 // echo $purchase_quantity;

									//$res_supplier=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."brands` WHERE brand_id=".$res['manufacture']));
								//	echo $res_supplier->brand_name; 
							   ?>
							</td>-->
						
							<!--<td>
								<?php if($res['status']=="0"){?> <a href="products.php?p_id=<?php echo $res['product_id']; ?>&status=1" class="btn btn-danger">Unpublished &nbsp; </a>&nbsp;<?php } else{ ?> <a href="products.php?p_id=<?php echo $res['product_id']; ?>&status=0" class="btn btn-success">Published </a> &nbsp; <?php }?>
							</td>-->
							<td><?php 
									/*$res_pum=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE cat_id=".$product->category));
									echo $res_cat->cat_name; 
									echo $res['product_id'];*/ 
															  $puno=  $res['purchase_no'];
															  $purchase_date=mysqli_fetch_array(mysqli_query($url,"
								 SELECT `purchase_date` FROM `".TB_pre."purchase_master` WHERE `purchase_no`= $puno
								"));
															  echo $purchase_date['purchase_date'];  ?> </td>
								<td><a class="dt-button" href="purchase_report.php?pno=<?php echo $puno; ?>" target="_blank">View Details</a></td>
						  </tr>
						  <?php }?>
						</tbody>
                    <tfoot>
                    </tfoot>
                  </table>
						</div> 
					</div>
				  </div>
				</form>
            </div><!-- /.box-body -->
            
     
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
		
		$('#example2').DataTable( {
        //dom: 'Bfrtip',
        /*buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]*/
		/*buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            },
			{
                extend: 'print',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ]
                }
            },
            'colvis'
        ]*/
    } );
		
		$('#origin_currency').on('change', function(){
			//ar originalPrice = $('#original_price').val();
			var origincurrency = $('#origin_currency').val();
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
		
		var proname = '<div class="row"><div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0"><label>Product Name</label><select class="form-control" name="product" id="product" ><option value="">Select</option><?php $res_pr=mysqli_query($url,"SELECT * FROM `".TB_pre."products`"); while($row_pr=mysqli_fetch_object($res_pr)){ ?> <option value="<?php echo $row_pr->product_id; ?>"><?php echo $row_pr->product_name; ?></option> <?php } ?> </select></div>';
		
		var shippingrow ='<div class="row"><div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0" > <label>Shipping Charges(%)</label> <input type="number" class="form-control" placeholder="Shipping Charges" min="1" step="any" name="shipping_charges" id="shipping_charges"/></div><div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0" > <label>Customs(%)</label> <input type="number" class="form-control" placeholder="Customs" min="1" step="any" name="customs" id="customs"/></div><div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0" > <label>Handling Charges (%)</label> <input type="number" class="form-control" placeholder="handling" min="1" step="any" name="handling" id="handling"/></div></div>';
		
		var stockandprice = '<div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12 m-r-0" ><label>Quantity</label><input type="number" class="form-control" placeholder="Stocks" name="product_stock" id="product_stock" /></div><div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12 m-r-0" ><label>Price</label><input type="text" class="form-control" placeholder="Price" name="original_price" id="original_price" value="" /></div>';
		
		var currencyr = '<div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12 m-r-0" ><label>Currency</label> <select class="form-control" name="currency" id="currency" required ><option value="AED">United Arab Emirates Dirham</option><?php $res_pr=mysqli_query($url,"SELECT * FROM `".TB_pre."currency`"); while($row_pr=mysqli_fetch_object($res_pr)){ ?> <option value="<?php echo $row_pr->code; ?>"><?php echo $row_pr->code; ?></option> <?php } ?>  </select></div>';
		
		var convertedvalue = '<div class="form-group col-lg-2 col-md-2 col-sm-6 col-xs-12 m-r-0" > <label>Converted Value (AED)</label> <input type="text" class="form-control" placeholder="converted Price" name="convertedPrice" id="convertedPrice" value=""/></div></div>';
		
		var formelement = proname+shippingrow+stockandprice+currencyr+convertedvalue;
					 $('.newrow').click(function(){
						
						$('#formcontainer').append(formelement);
					  	//alert(formelement);
					 });
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