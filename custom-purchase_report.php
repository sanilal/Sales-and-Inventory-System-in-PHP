<?php $active="products"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>


 <!-- Left side column. contains the sidebar -->
 <?php include_once('includes/side_bar.php'); ?>

<?php  
if(isset($_GET['p_id']) && isset($_GET['status']) ){
	$id = $_GET['p_id'];
	$status = $_GET['status'];
	$query = "UPDATE `".TB_pre."products` set status='$status' WHERE `product_id`='$id'";
	$r = mysqli_query($url, $query) or die(mysqli_error($url));
	if($r){
		$msg = "Status updated Successfully.";
	}
}

if(isset($_GET['remove_pr'])){
	$id = $_GET['remove_pr'];
	$pr_img_res=mysqli_fetch_object(mysqli_query($url,"select product_img,gallery_imgs from `".TB_pre."products` WHERE `product_id`='$id'"));
	$query = "DELETE FROM `".TB_pre."products` WHERE `product_id`='$id'";
	$r = mysqli_query($url, $query) or die(mysqli_error($url));
	unlink( "uploads/".$pr_img_res->product_img);
	$g_imgs=explode(",",$pr_img_res->gallery_imgs);
	foreach($g_imgs as $g_img){
		unlink( "uploads/".$g_img->product_img);
	}
	if($r){
		$msg = "The selected product deleted successfully.";
	}
}
$sql="select * from `".TB_pre."products`  ORDER BY p_order ASC, product_id DESC ";
$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));

?>  

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Products</h3> 
              <?php if(isset($msg)){ ?>
              	<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> <?php echo $msg; ?></h4>
               	</div>
               <?php } ?> 
            </div>
            
            <div class="box-body">
				
				<div class="report-search">
					<div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12 m-r-0">
						  <label>Supplier</label>
						  <select class="form-control" name="brand" id="product_brand" required>
							<option value="">Select</option>
							<?php 
					
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
					
					<div class="form-group col-lg-3 col-md-6 col-sm-6 col-xs-12 m-r-0">
						  <label>Product</label>
						  <select class="form-control" name="product" id="product_name" required>
							<option value="">Select</option>
							<?php 
					
							  $res_pr=mysqli_query($url,"SELECT * FROM `".TB_pre."products`");
								 while($row_pr=mysqli_fetch_object($res_pr)){
									$product_name=$row_pr->product_name;
								$prod_id=$row_pr->product_id;
							
							?>
							<option value="<?php echo $prod_id; ?>"><?php echo $product_name; ?></option>
							<?php    
							}
							?>
							</select>
						</div>
					<div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12 m-r-0">
						  <label>Start Date</label>
						  <input class="form-control" name="startdate" id="startdate" type="date" />
						</div>
					<div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12 m-r-0">
						  <label>End Date</label>
						  <input class="form-control" name="enddate" id="enddate" type="date" />
						</div>
					<div class="form-group col-lg-2 col-md-6 col-sm-6 col-xs-12 m-r-0">
						 <label>&nbsp;</label>
						  <input class="form-control" name="submit" id="submit" type="submit" value="Search" />
						</div>
				</div>
				
                  <table id="custom-report" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                      <th>No.</th>
                      <th>Code</th>
                        <th>Description</th>
                        <th>Category</th>
						<!--<th>Stock</th>-->
                        <!--<th>Unit Price</th>-->
                        <!--<th>Supplier</th>-->
                        <th>Quantity</th>
                        <th>Image</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					$i = 1;
					while($res = mysqli_fetch_array($r1)){ ?>
                      <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $res['product_code'];  ?></td>
                        
                        <td><?php echo $res['product_name']; ?></td>
                        
                        <td><?php 
						$res_cat=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE cat_id=".$res['category']));
						echo $res_cat->cat_name; 
						
						?></td>
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
                       <td>
						   
                          <?php 
                          $pr_id=$res['product_id'];
                          	 $purchase_q="
                             SELECT sum(quantity) FROM `".TB_pre."purchase` WHERE `product_id`=$pr_id
                            ";
                              $purchaseresult = mysqli_query($url, $purchase_q);
                              $purchasestock = mysqli_fetch_array($purchaseresult);
                              $tot_purchasestock = $purchasestock['sum(quantity)'];
                              
                              $sales_quantity_q="
                             SELECT sum(quantity) FROM `".TB_pre."sales` WHERE `product_id`=$pr_id
                            ";
                              $sales_quantity_result = mysqli_query($url, $sales_quantity_q);
                              $salesstock = mysqli_fetch_array($sales_quantity_result);
                              $tot_salestock = $salesstock['sum(quantity)'];
                              $totalstock = $tot_purchasestock-$tot_salestock;
                              echo $totalstock;
                         // echo $purchase_quantity;

								//$res_supplier=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."brands` WHERE brand_id=".$res['manufacture']));
							//	echo $res_supplier->brand_name; 
						   ?>
                        </td>
                        <td><?php if($res["product_img"]!=""){ ?>
                      <img src="uploads/<?php echo $res["product_img"]; ?>" width="75" />
                      <?php } else{ echo "No-image";} ?></td>
                        <!--<td>
                        	<?php if($res['status']=="0"){?> <a href="products.php?p_id=<?php echo $res['product_id']; ?>&status=1" class="btn btn-danger">Unpublished &nbsp; </a>&nbsp;<?php } else{ ?> <a href="products.php?p_id=<?php echo $res['product_id']; ?>&status=0" class="btn btn-success">Published </a> &nbsp; <?php }?>
                        </td>-->
                        <td><!--<a href="sell-product.php?product_id=<?php //echo $res['product_id']; ?>" class="btn btn-primary" title="">Details</a>&nbsp;-->
							<a href="edit-product.php?product_id=<?php echo $res['product_id']; ?>" class="btn btn-primary" title="" style="width:100px;">Edit</a>&nbsp;
              <a href="product-details.php?product_id=<?php echo $res['product_id']; ?>" class="btn btn-warning" title="" style="width:100px;">Details</a>
                        <!--<a href="javascript:removeItem(<?php // echo $res['product_id']; ?>);" class="btn btn-danger">Remove</a>--></td>
                      </tr>
                      <?php }?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
            <div class="box-footer">
            
            </div><!-- /.box-footer-->
          </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

     
      <!-- Control Sidebar -->


	<?php include_once('includes/footer.php'); ?>
    <!-- jQuery 2.1.4 -->
   <?php include_once('includes/footer-scripts.php'); ?>
    
    
    <!-- AdminLTE for demo purposes -->

     <script>
		 
		 	$(document).on("click", '#submit', function(event) { 
			var supplier=$('#product_brand').val();
			var product =$('#product_name').val();
			var startdate = $('#startdate').attr('value');
			$('#enddate').val(startdate);
	
		  $.ajax({
		   url:"ajax-fetch-products.php",
		   method:"POST",
		   data:{query:product_id},
		   success:function(data)
		   {
			$('#details-purchase').html(data);
			$('#details-purchase').addClass('show');
			$('.result-container').addClass('show');
		   }
		  });
		  
			
			// var rowid ="row"+product_id;
			// var rowcontent=$("#"+rowid).clone();
			// rowcontent.appendTo('#slecteddata');
		})
		 
      $(function () {
        $('#custom-report').DataTable({
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
		  });
      });
    </script>
    <script type="text/javascript">
    function removeItem(id){
		var c= confirm("Do you want to remove this?");
		if(c){
			location = "products.php?remove_pr="+id;
		}
	}
	
    </script>
  </body>
</html>
<?php ob_end_flush(); ?>