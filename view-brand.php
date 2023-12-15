<?php $active="brands"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  

 if(isset($_REQUEST['btnedit'])){
	 
  $brand=$_POST['brand'];	
  $trn=$_POST['trn'];	
  $company_address=$_POST['company-address'];	
	$b_url=$_POST['brand_url'];
	$old_img=$_POST['old_img'];
	$contact_number=$_POST['contact-number'];
	$fax=$_POST['fax'];
	$email=$_POST['email'];
  $contact_person=$_POST['contact-person'];
  $position=$_POST['position'];
	//
	$msg=""; $error="";
	//
	if($brand!="" ){
		//
		$id=$_POST['brand_id'];
		include_once("classes/class.upload.php");
		//
		if(file_exists($_FILES['brand_img']['tmp_name']) || is_uploaded_file($_FILES['brand_img']['tmp_name'])) {
			unlink( "uploads/".$old_img);
		}
		//
		$b_image=image_upload($_FILES['brand_img'],$brand."logo_img",500);
		//var_dump($p_image); exit;
		if($b_image==""){
			$b_image=$old_img;
		}
		//
		
		  //var_dump($num); exit;
		  $query = "UPDATE `".TB_pre."brands` SET `brand_name`='$brand',`trn`='$trn',`contact_number`='$contact_number',`fax`='$fax',`email`='$email',`address`='$company_address',`contact_person`='$contact_person',`position`='$position',`brand_url`='$b_url',`brand_logo`='$b_image' WHERE brand_id=".$id;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Scheme Successfully updated";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	}
	else {
			  $error.= "Failed: Fill all the required fields";
		  }
}
$s_res=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."brands` WHERE brand_id=".$_GET['brand_id']));
?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Contact Details
          </h1>
          
          <!--<ol class="breadcrumb">
            <li><a href="brands.php" class="btn btn-block"><i class="fa fa-eye"></i>View Contacts</a></li>
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
                  
                  	<div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>Company Name</label>
                      <input disabled type="text" class="form-control" placeholder="Company Name" name="brand" id="product" value="<?php echo $s_res->brand_name;  ?>" />
                    </div>
                    <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>TRN</label>
                      <input disabled type="text" class="form-control" placeholder="TRN" name="trn" id="trn" value="<?php echo $s_res->trn;  ?>" />
                    </div>
					  <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>Company Address</label>
                      <input disabled type="text" class="form-control" placeholder="Company Address" name="company-address" id="company-address" value="<?php echo $s_res->address;  ?>" />
                    </div>
                    <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>Telephone Number</label>
                      <input disabled type="tel" class="form-control" placeholder="Contact Number" name="contact-number" id="contact-number" value="<?php echo $s_res->contact_number;  ?>" />
                    </div>
					<div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>Fax</label>
                      <input disabled type="tel" class="form-control" placeholder="Fax" name="fax" id="fax" value="<?php echo $s_res->fax;  ?>" />
                    </div>
					<div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>Email</label>
                      <input disabled type="email" class="form-control" placeholder="Email" name="email" id="email" value="<?php echo $s_res->email;  ?>" />
                    </div>
					  <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>Website</label>
                      <input disabled type="text" class="form-control" placeholder="Brand URL" name="brand_url" id="url" value="<?php echo $s_res->brand_url; ?>" />
                    </div>
					  <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>Work category</label>
                      <input disabled type="text" class="form-control" placeholder="Brand URL" name="brand_url" id="url" value="<?php echo $s_res->brand_category; ?>" />
                    </div>
                   
					 <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>Contact Person</label>
                      <input disabled type="text" class="form-control" placeholder="Contact person" name="contact-person" id="contact-person" value="<?php echo $s_res->contact_person;  ?>" />
                    </div>
					 <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>Mobile Number</label>
                      <input disabled type="text" class="form-control" placeholder="Mobile Number" name="mobile-number" id="mobile-number" value="<?php echo $s_res->contact_mobile;  ?>" />
                    </div>
					 <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>Direct Phone</label>
                      <input disabled type="text" class="form-control" placeholder="Direct Phone" name="direct-phone" id="direct-phone" value="<?php echo $s_res->direct_phone;  ?>" />
                    </div>
					  <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>Email Address</label>
                      <input disabled type="text" class="form-control" placeholder="Email" name="contact-email" id="contact-email" value="<?php echo $s_res->contact_email;  ?>" />
                    </div>
                    <div class="form-group col-lg-3 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>Position</label>
                      <input disabled type="text" class="form-control" placeholder="Position" name="position" id="position" value="<?php echo $s_res->position;  ?>" />
                    </div>
					
                    <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 m-r-0">
                      <label>Supplier logo / image</label>
                      <?php if($s_res->brand_logo!=""){ ?>
                      <img src="uploads/<?php echo $s_res->brand_logo; ?>" width="100" />
                      <?php } ?>
                      <!--<input type="file" class="form-control" placeholder="Brand Image" name="brand_img" id="bimg" />
                      <input type="hidden" name="old_img" value="<?php //echo $s_res->brand_logo; ?>" />-->
                    </div>
					<div class="col-md-12">
						<div id="purchaselist">
							<h3>Purchases From <?php echo $s_res->brand_name;  ?></h3>
							<table id="example2" class="table table-bordered table-hover center-table">
						<thead>
						  <tr>
						  <th>No.</th>
						  <!--<th>product Code</th>-->
							<!--<th>Description</th>
							<th>Category</th>-->
							<!--<th>Stock</th>-->
							<!--<th>Unit Price</th>-->
							<!--<th>Supplier</th>-->
							<!--<th>Quantity</th>-->
							<th>Date</th>
							<th>Purchase Reference</th>
							<th>Details</th>
						  </tr>
						</thead>
						<tbody>
						<?php 
							$brandd=$_GET['brand_id'];
						//$purchase_master=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."purchase_master` WHERE supplier_id=".$_GET['brand_id']));
						$purchase_master=mysqli_query($url,"select * from `".TB_pre."purchase_master` WHERE supplier_id=".$_GET['brand_id']);
							
						//$sql="select * from `".TB_pre."purchase`  WHERE purchase_no=(select `purchase_no` from `".TB_pre."purchase_master` WHERE supplier_id=$brandd)";
							//print_r($sql);
						//$sql="select * from `".TB_pre."purchase`  WHERE purchase_no in (select `purchase_no` from `".TB_pre."purchase_master` WHERE supplier_id=$brandd)";
						/*foreach ($purchase_master->purchase_no as $value) {
							$sql="select * from `".TB_pre."purchase`  WHERE purchase_no=$value";
						}*/
							
						//$sql="select * from `".TB_pre."purchase`  WHERE purchase_no=$purchase_master->purchase_no ";
						//$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));
						
						$i = 1;
						while($res = mysqli_fetch_array($purchase_master)){ ?>
						  <tr>
							<td><?php echo $i++; ?></td>
							<!--<td><?php //$product=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."products` WHERE product_id=".$res['product_id']));
										//echo $product->product_code;  ?></td>-->

							<!--<td><?php //echo $product->product_name; ?></td>-->

							<!--<td><?php 
							//$res_cat=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE cat_id=".$product->category));
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
								<?php //if($res['status']=="0"){?> <a href="products.php?p_id=<?php //echo $res['product_id']; ?>&status=1" class="btn btn-danger">Unpublished &nbsp; </a>&nbsp;<?php //} //else{ ?> <a href="products.php?p_id=<?php //echo $res['product_id']; ?>&status=0" class="btn btn-success">Published </a> &nbsp; <?php //}?>
							</td>-->
							<td><?php 
									/*$res_pum=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE cat_id=".$product->category));
									echo $res_cat->cat_name; 
									echo $res['product_id'];*/ 
									//$puno=  $res['purchase_no'];
									//$purchase_date=mysqli_fetch_array(mysqli_query($url,"
								// SELECT `purchase_date` FROM `".TB_pre."purchase_master` WHERE `purchase_no`= $puno
								//"));
															  echo $res['purchase_date'];  ?> </td>
							  <td><?php echo  $res['purchase_no']; ?>  </td>
							  <td><a class="dt-button" href="purchase_report.php?pno=<?php echo $res['purchase_no']; ?>" target="_blank">View Details</a> </td>
						  </tr>
						  <?php }?>
						</tbody>

                  </table></div> 
						
						<div id="saleslist">
					<h3>Sales to <?php echo $s_res->brand_name;  ?> </h3>
					<table id="example3" class="table table-bordered table-hover center-table">
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
							<th>Sales Reference</th>
							<th>Details</th>
						  </tr>
						</thead>
						<tbody>
						<?php 
						
						/*$sales_first_sql="select * from `".TB_pre."sales`  WHERE customer=".$_GET['brand_id'];
						$sales_first_res = mysqli_fetch_array(mysqli_query($url,$sales_first_sql));
						$sales_no=$sales_first_res['sales_no'];*/
						
						$brandid=$_GET['brand_id'];
						$sales_sql="select * from `".TB_pre."sales`  WHERE customer=$brandid GROUP BY sales_no" ;
						$sr1=mysqli_query($url,$sales_sql) or die("Failed".mysqli_error($url));
						
						$i = 1;
						while($sales_res = mysqli_fetch_array($sr1)){ ?>
						  <tr>
							<td><?php echo $i++; ?></td>
							<!--<td><?php $sale_product=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."products` WHERE product_id=".$sales_res['product_id']));
										//echo $sale_product->product_code;  ?></td>-->

							<!--<td><?php //echo $sale_product->product_name; ?></td>-->

							<!--<td><?php 
							$res_cat=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE cat_id=".$sale_product->category));
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
						  <!-- <td>

							  <?php 
							  //echo $sales_res['quantity'];
							 // echo $purchase_quantity;

									//$res_supplier=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."brands` WHERE brand_id=".$res['manufacture']));
								//	echo $res_supplier->brand_name; 
							   ?>
							</td>-->
							
							<!--<td>
								<?php if($sales_res['status']=="0"){?> <a href="products.php?p_id=<?php echo $sales_res['product_id']; ?>&status=1" class="btn btn-danger">Unpublished &nbsp; </a>&nbsp;<?php } else{ ?> <a href="products.php?p_id=<?php echo $sales_res['product_id']; ?>&status=0" class="btn btn-success">Published </a> &nbsp; <?php }?>
							</td>-->
							<td>
								<?php echo $sales_res['sale_date']; ?>
							  </td>
							  <td>
								<?php echo $sales_res['sales_no']; ?>
							  </td>
							  <td>
								<a class="dt-button" href="sales_report.php?sno=<?php echo $sales_res['sales_no']; ?>" target="_blank">View Details</a>
							  </td>
						  </tr>
						  <?php }?>
						</tbody>
                    <tfoot>
                    </tfoot>
                  </table>
</div>
					</div>
                    
                    
                    
                   
                  </div><!-- /.box-body -->

                  <!--<div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnedit">Update Brand</button>
                    <input type="hidden" name="brand_id" value="<?php //echo $_GET['brand_id']; ?>" />
                  </div>-->
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
    CKEDITOR.replace('scheme_desc');
  });
	
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
	
	$('#example3').DataTable( {
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
})
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>