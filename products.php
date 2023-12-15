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
        <section class="content-header">
          <h1>
            View Products
          </h1>
          
          <ol class="breadcrumb">
            <li><a href="add-product.php" class="btn btn-block"><i class="fa fa-plus"></i> Add New Product</a></li>
          </ol>
          
        </section>

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
				<div class="totstorervalue"><span style="font-size: 22px; font-weight: bold;"> Total Store Value : </span>
				<span id="sum" style="font-size: 22px; font-weight: bold;"></span></div>
                  <table id="example2" class="table table-bordered table-hover center-table">
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
                        
                        <td style="text-align: left;"><?php echo $res['product_name']; ?></td>
                        
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
														  
							 $purchase_query="
                             SELECT * FROM `".TB_pre."purchase` WHERE `product_id`=$pr_id
                            ";
							$purchasequeryresult = mysqli_fetch_array(mysqli_query($url, $purchase_query));
							$purchase_no=$purchasequeryresult['purchase_no'];
							$purchase_master_sql=mysqli_query($url,"select * from `".TB_pre."purchase_master`  WHERE purchase_no=$purchase_no");
								$p_master=mysqli_fetch_object($purchase_master_sql);
														  $conversion_ratio = $p_master->conversion_ratio;
								$unit_price=$purchasequeryresult['purchased_price']*$conversion_ratio;
								$shippingcP=$p_master->shipping;
								$shippingc= (($unit_price*$totalstock)*($shippingcP/100))/$totalstock;
								$customscP=$p_master->customs;
								$shippingc= (($unit_price*$totalstock)*($customscP/100))/$totalstock; 
								$handlingcP=$p_master->handling;
								$shippingc= (($unit_price*$totalstock)*($handlingcP/100))/$totalstock;
								$netunitprice=$unit_price+$shippingc+$shippingc+$shippingc;
				
                              
                         // echo $purchase_quantity;

								//$res_supplier=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."brands` WHERE brand_id=".$res['manufacture']));
							//	echo $res_supplier->brand_name; 
						   ?>
						   <span class="<?php if($totalstock<150){ echo('outofstock');} if($totalstock>500){ echo('instock'); } ?>">
						   		<?php echo $totalstock; ?>&nbsp;
							   <span class="totalvalue"><?php if($totalstock>0) {echo round($totalstock*$netunitprice, 2); } else {echo 0;}  ?></span>

						   </span>
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
		 $(document).ready(function() {
			 var sum = 0;
  $(".totalvalue").each(function(){
    sum += parseFloat($(this).text());
  });
  $('#sum').text(sum.toFixed(2));
			 
    $('#example2').DataTable( {
        dom: 'Bfrtip',
        /*buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ]*/
		buttons: [
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
        ]
    } );
} );
		 
		 


     /* $(function () {
        $('#example2').DataTable({
		
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": false
		  });
      });*/
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