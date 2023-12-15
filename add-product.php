<?php $active="products"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  

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
		  $query = "INSERT INTO `".TB_pre."products` (`product_name`,`category`,`product_img`,`product_code`) VALUES('$product','$procatname','$p_image','$code')";
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
            Add New Product
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
              <form role="form" method="post"  class="form-horizontal" action="" enctype="multipart/form-data">
                  <div class="box-body">
                  
                  	<div class="row">
						<div class="form-group col-md-12 m-r-0">
                      		<label>Product Description</label>
                      		<input type="text" class="form-control" placeholder="Product Description" name="product" id="product" />
                    	</div>
					</div>
					  <!--<div id="searchresult"></div>-->
                      <div class="row">
						  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0">
                      <label>Product Code</label>
                      <input type="text" class="form-control" placeholder="Product Code" name="product_code" id="product_code" />
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0" style="margin-left: 0;">
                      <label>Product Category</label>
                      <select class="form-control" name="productmenu" id="productmenu" required >
                      	<option value="">Select</option>
                        <?php 
						$res_cat=mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE `parent_cat`=0 ");
						while($row=mysqli_fetch_object($res_cat)){
						?>
                        <option value="<?php echo $row->cat_id; ?>"><?php echo $row->cat_name; ?></option>
                        <?php 
						$ch_q=mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE `parent_cat`=".$row->cat_id);
						while($ch_row=mysqli_fetch_object($ch_q)){ ?>
                        <option value="<?php echo $ch_row->cat_id; ?>" >-- <?php echo $ch_row->cat_name; ?></option>
						<?php } ?>
                       
                      	<?php } ?>
                      </select>
                    </div>
					  </div>
					  <div class="row">
						<div class="form-group col-md-12 m-r-0">
						  <label>Product Image</label>
						  <input type="file" class="form-control" placeholder="Product Image" name="productimg" id="productimg" />
						</div>
				  	</div>
					 <div class="row">
					  <div class="box-footer col-md-12 m-r-0" style="padding: 10px 0;">
                    	<button type="submit" class="btn btn-primary" name="btnadd">Add Product</button>
                  	  </div>
				  </div>
					</div>
					  
                    
                    
                  <!--  <div class="form-group" >
                      <label>Order</label>
                      <input type="number" class="form-control" placeholder="Order" name="order" />
                    </div>-->
                  </div><!-- /.box-body -->

                  
                </form>
            </div><!-- /.box-body -->
            
            <!--<div class="box-footer">
            
            </div>--><!-- /.box-footer-->
          </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<?php include_once('includes/footer.php'); ?>
    <!-- jQuery 2.1.4 -->
<?php include_once('includes/footer-scripts.php'); ?>     
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
<script>
$(function () {
    // Replace the <textarea id="editor1"> with a CKEditor
    // instance, using default configuration.
    CKEDITOR.replace('productdesc');
	CKEDITOR.replace('productattr');
  });
	$(document).ready(function(){
		$('#currency').on('change', function(){
			var originalPrice = $('#original_price').val();
			var origincurrency = $('#currency').val();
			if(originalPrice){
				$.ajax({
					type: 'POST',
					url: 'ajax_currency_conversion.php',
					data:  {oprice : originalPrice, currencyorigin : origincurrency},//'oprice='+originalPrice,
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
	});
	
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>