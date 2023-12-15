<?php $active="products"; ?>
<?php
ob_start();
include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  

$pr_res=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."products` WHERE `product_id`=".$_GET['pr_id']));

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
            
            <div class="box-body">
              <form role="form" method="post"  class="form-horizontal" action="" enctype="multipart/form-data">
                  <div class="box-body">
                  
                  	<div class="form-group">
                      <label>Product Name</label>
                      <input type="text" class="form-control" placeholder="Product Name" name="product" id="product" value="<?php echo $pr_res->product_name; ?>" disabled />
                    </div>
                      <div class="row">
						  <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0">
                      <label>Product Code</label>
                      <input type="text" class="form-control" placeholder="Cat No" name="product_code" id="product_code"value="<?php echo $pr_res->product_code; ?>" disabled />
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0">
                      <label>Product Category</label>
                      <select class="form-control" name="productmenu" id="productmenu" required disabled >
                      	<option value="">Select</option>
                        <?php 
						$res_cat=mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE `parent_cat`=0 ");
						while($row=mysqli_fetch_object($res_cat)){
						?>
                        <option value="<?php echo $row->cat_id; ?>" <?php if($pr_res->category==$row->cat_id){ echo 'selected="selected"';} ?> > <?php echo $row->cat_name; ?></option>
                        <?php 
						$ch_q=mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE `parent_cat`=".$row->cat_id);
						while($ch_row=mysqli_fetch_object($ch_q)){ ?>
                        <option value="<?php echo $ch_row->cat_id; ?>"<?php if($pr_res->category==$ch_row->cat_id){ echo 'selected="selected"';} ?> >-- <?php echo $ch_row->cat_name; ?></option>
                      	<?php } ?>
                      	<?php } ?>
                      </select>
                    </div>
					  </div>
                  	<div class="row">
						<div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0">
						  <label>Supplier</label>
						  <select class="form-control" name="brand" id="product_brand" >
                      	<option value="">Select</option>
                        <?php 
						$res_br=mysqli_query($url,"SELECT * FROM `".TB_pre."brands`");
						while($row_br=mysqli_fetch_object($res_br)){
						?>
                        <option value="<?php echo $row_br->brand_id; ?>" <?php if($pr_res->manufacture==$row_br->brand_id){ echo 'selected="selected"';} ?>><?php echo $row_br->brand_name; ?></option>
                        <?php    
						}
						?>
                        </select>
						</div>
					   <?php /*?> <div class="form-group">
						  <label>Model Series</label>
						 <select class="form-control" placeholder="Model Series" name="series" id="series_id" required >
							<option value="">Select</option>
							<?php
							$r_p=mysqli_query($url,"select * from `".TB_pre."brands` ");
							  while($prnt=mysqli_fetch_object($r_p)){
								echo '<optgroup value="'.$prnt->brand_id.'" label="'.$prnt->brand_name.'">';
								$r_m=mysqli_query($url,"select * from `".TB_pre."brand_models` WHERE brand_id=".$prnt->brand_id);
								while($mdl=mysqli_fetch_object($r_m)){
										echo '<optgroup value="'.$mdl->model_id.'" label="-'.$mdl->model_name.'">';
										$r_s=mysqli_query($url,"select * from `".TB_pre."brand_model_series` WHERE model_id=".$mdl->model_id);
										while($mds=mysqli_fetch_object($r_s)){
											echo '<option value="'.$mds->series_id.'">'.$mds->series_name.'</option>';
										}
										echo '</optgroup>';

								}
								echo '</optgroup>';
							  }
						  ?>

						  </select>
                    	</div><?php */?>
						<div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0" >
						  <label>Quantity</label>
						  <input type="number" class="form-control" placeholder="Stocks" name="product_stock" id="product_stock" />
						</div>
						<div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0" >
						  <label>Shipping / Other Charges(AED)</label>
						  <input type="number" class="form-control" placeholder="Shipping / Other Charges" min="1" step="any" name="shipping_charges" id="shipping_charges" />
						</div>
					</div>
					  
                    <div class="row price-section">
						<div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0" >
						  <label>Price</label>
						  <input type="text" class="form-control" placeholder="Price" name="original_price" id="original_price" value="" />
						</div>
						  <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0" >
						  <label>Currency</label>
							  <select class="form-control" name="currency" id="currency" required >
							<option value="AED">United Arab Emirates Dirham</option>
							<?php 
							$res_currency=mysqli_query($url,"SELECT * FROM `".TB_pre."currency` ORDER BY `currency` ASC");
							while($row=mysqli_fetch_object($res_currency)){
							?>
							<option value="<?php echo $row->code; ?>"><?php echo $row->currency; ?></option>
							<?php 
							$ch_q=mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE `parent_cat`=".$row->cat_id);
							while($ch_row=mysqli_fetch_object($ch_q)){ ?>
							<option value="<?php echo $ch_row->cat_id; ?>" >-- <?php echo $ch_row->cat_name; ?></option>
							<?php } ?>

							<?php } ?>
						  </select>
						</div>
						  <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0" >
						  <label>Converted Value (AED)</label>
						  <input type="text" class="form-control" placeholder="converted Price" name="convertedPrice" id="convertedPrice" value="" />
						</div>
					  </div>
                    <!--<div class="form-group col-sm-4">
                      <label>Featured product</label>
                      <input type="checkbox" name="featured" value="1" /> yes
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Special product</label>
                      <input type="checkbox" name="special" value="1" /> yes
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Special-Offer</label>
                      <input type="checkbox" name="spl_offer" value="1" /> yes
                    </div>-->
                     <div class="form-group" style="display:none">
                      <label>Product attributes</label>
                      <textarea class="form-control" placeholder="Product Attributes" name="productattr" id="productattr"> </textarea>
                    </div>
                    <div class="form-group">
                      <label>Product Description</label>
                      <textarea class="form-control" placeholder="Product Description" name="productdesc" id="productdesc"> <?php echo $pr_res->p_desc; ?></textarea>
                    </div>
                    
                    <div class="form-group">
                      <label>Product Image</label>
                      <input type="file" class="form-control" placeholder="Product Image" name="productimg" id="productimg" />
                    </div>
                    <div style="display:none">
                    <div class="form-group col-sm-4">
                      <label>Product Image1(optional)</label>
                      <input type="file" class="form-control" placeholder="Product Image1" name="productimg1" id="productimg1" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image2(optional)</label>
                      <input type="file" class="form-control" placeholder="Product Image2" name="productimg2" id="productimg2" />
                    </div>
                    
                    <div class="form-group col-sm-4">
                      <label>Product Image3(optional)</label>
                      <input type="file" class="form-control" placeholder="Product Image3" name="productimg3" id="productimg3" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image4(optional)</label>
                      <input type="file" class="form-control" placeholder="Product Image4" name="productimg4" id="productimg4" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image5(optional)</label>
                      <input type="file" class="form-control" placeholder="Product Image5" name="productimg5" id="productimg5" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image6(optional)</label>
                      <input type="file" class="form-control" placeholder="Product Image6" name="productimg6" id="productimg6" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image7(optional)</label>
                      <input type="file" class="form-control" placeholder="Product Image7" name="productimg7" id="productimg7" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image8(optional)</label>
                      <input type="file" class="form-control" placeholder="Product Image8" name="productimg8" id="productimg8" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image9(optional)</label>
                      <input type="file" class="form-control" placeholder="Product Image9" name="productimg9" id="productimg9" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image10(optional)</label>
                      <input type="file" class="form-control" placeholder="Product Image10" name="productimg10" id="productimg10" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image11(optional)</label>
                      <input type="file" class="form-control" placeholder="Product Image11" name="productimg11" id="productimg11" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image12(optional)</label>
                      <input type="file" class="form-control" placeholder="Product Image12" name="productimg12" id="productimg12" />
                    </div>
                     
                    </div>
                  <!--  <div class="form-group" >
                      <label>Order</label>
                      <input type="number" class="form-control" placeholder="Order" name="order" />
                    </div>-->
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnadd">Add Product</button>
                  </div>
                </form>
            </div><!-- /.box-body -->
            
            <div class="box-footer">
            
            </div><!-- /.box-footer-->
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
/*		
	});
	
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>