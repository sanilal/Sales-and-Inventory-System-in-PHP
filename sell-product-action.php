<?php $active="products"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>

<?php include_once('includes/header.php'); ?>


 <!-- Left side column. contains the sidebar -->
 <?php include_once('includes/side_bar.php'); ?>

<?php  

$pr_res=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."products` WHERE `product_id`=".$_GET['product_id']));



$sql="select * from `".TB_pre."products`  ORDER BY p_order ASC, product_id DESC ";
$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));

?>  

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Sell Product
            <small></small>
          </h1>
          
          <ol class="breadcrumb">
            <li><a href="add-product.php" class="btn btn-block"><i class="fa fa-plus"></i> Add new Product</a></li>
          </ol>
          
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Sell Product</h3> 
              <?php if(isset($msg)){ ?>
              	<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> <?php echo $msg; ?></h4>
               	</div>
               <?php } ?> 
            </div>
            
            <div class="box-body">
				  
				<form id="product-selling">
                  <table class="table table-bordered table-hover">
                    <thead>
                      <tr>
                      <th>Sl. No</th>
                        <th>Product</th>
						<th>Category</th>
						<th>Available Stock</th>
						 <th>Required Quantity</th>
                        <th>Unit Price</th>
						<th>Supplier</th>
                        <!--<th>Action</th>-->
                      </tr>
                    </thead>
                    <tbody class="selltable">
                    <?php 
					$i = 1;
					 ?>
                      <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $pr_res->product_name; ?></td>
						 <td><?php //echo $pr_res->category; 
							 $res_cat=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE cat_id=".$pr_res->category));
						echo $res_cat->cat_name; 
							 ?>
						  </td>
                        
                      <td>
							<strong style="font-size: 20px; color: #16bb02;"><?php echo $pr_res->stocks; ?></strong>
						  </td>
                        <td>
							 <input type="number" placeholder="Enter quantity" name="stock" />
							<!--<input type="number" name="quantity" id="quantity" value="<?php //secho $pr_res->stocks; ?>">-->
                        <?php 
						/*$res_cat=mysqli_fetch_object(mysqli_query($url,"SELECT brand_id, brand_name FROM `".TB_pre."brands` WHERE brand_id=".$res['manufacture']));
						echo $res_cat->brand_name; */
						//echo $pr_res->stocks;
						?>
                        </td>
						<td>
                        <?php 
						//$res_cat=mysqli_fetch_object(mysqli_query($url,"SELECT brand_id, brand_name FROM `".TB_pre."brands` WHERE brand_id=".$res['manufacture']));
						//echo $res_cat->brand_name; 
						echo $pr_res->unit_price;
						?>
                        </td>
						 <td>
                        <?php 
						$res_manufacture=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."brands` WHERE brand_id=".$pr_res->manufacture));
						echo $res_manufacture->brand_name; 
						//echo $pr_res->manufacture;
						?>
							 <input type="hidden" value="<?php echo $pr_res->product_id; ?>" name="pr_id" id="pr_id" />
                        </td>
                   
                        <!--<td>
                        	<?php if($res['status']=="0"){?> <a href="products.php?p_id=<?php echo $res['product_id']; ?>&status=1" class="btn btn-danger">Unpublished &nbsp; </a>&nbsp;<?php } else{ ?> <a href="products.php?p_id=<?php echo $res['product_id']; ?>&status=0" class="btn btn-success">Published </a> &nbsp; <?php }?>
                        </td>-->
                        <!--<td><a href="sell-product.php?product_id=<?php //echo $res['product_id']; ?>" class="btn btn-primary" title="">Sell Now</a>&nbsp;
						
						</td>-->
                      </tr>
                      <?php ?>
                    </tbody>
                  
                  </table>
					<input type="submit" name="submit" value="Sell Now" class="btn btn-primary" />
				</form>
					<div class="col-md-12"><div class="btn btn-primary sellmore">Sell more products <i class="fa fa-plus-circle"></i></div></div>
					<div id="moreproductsWraper">
						<div class="col-md-12 m-t-50">
							<div class="panel panel-default">
								<div class="bs-example">
									<input type="text" name="search_text" id="search_text" placeholder="Search by product name" class="form-control" />
								</div>
							</div>
					  </div>
						<div class="col-md-12">
							<div id="result"></div>
						</div>
					</div>
			
				<!--<div class=".col-md-6">
					<div class="panel panel-default">
					<div class="bs-example">
						<input type="text" name="search_text" id="search_text" placeholder="Search by product name" class="form-control" />
 
					</div>
				  </div>
				  </div>
		  <div id="result"></div>-->
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
	<script type="text/javascript">
	$(document).ready(function(){
		$('.sellmore').click(function(){
			if(!$('#moreproductsWraper').hasClass('show')) {
				$('#moreproductsWraper').addClass('show');
				$('.sellmore').addClass('hide');
			}
			//$('.addProduct').click(function(){
			$(document).on("click", '.addProduct', function(event) {
				var pr_id = $('#pr_id').val();
				var currentId = $(this).attr("data-product");
				var tdele = $(this).closest('tr').html();
				var trelestart = '<tr>';
				var treleend = '</tr>';
				var trele = trelestart+tdele+treleend;
				if(pr_id!=currentId){
					$('.selltable').append(trele);
				$(this).closest('tr').remove();
				} else {
					alert("Product is already in the list");
					$(this).closest('tr').remove();
				}
				
				//alert(trele);
			})
		})
		
		 load_data();
		 function load_data(query)
		 {
		 //var pr_id = $('#pr_id').val();
		  $.ajax({
			  
		   url:"ajax-sell-products.php",
		   method:"POST",
		   data:{query:query},
		   success:function(data)
		   {
			$('#result').html(data);
		   }
		  });
		 }
		 $('#search_text').keyup(function(){
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
		/*$('.addProduct').click(function(){
			alert();
		var html_code = '<tr><td><?php echo $i++; ?></td><td><?php echo $pr_res->product_name; ?></td></tr>';
		var selector = 'section#prcontainer table'; 
		//change selector with where you want to append your html code into..
		$('#result').click(function(){
			alert();
			$(selector).append(html_code);
		});*/
		
		/*$(document).on("click", '.addProduct', function(event) { 
			
			$(selector).append(html_code);
			//$('.selectcheck').prop('checked', $(this).prop('checked'));
		});
		})*/
		
	})
</script>
  
    
    <!-- AdminLTE for demo purposes -->

  </body>
</html>
<?php ob_end_flush(); ?>