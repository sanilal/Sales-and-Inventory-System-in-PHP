<?php $active="brands"; ?>
<?php
ob_start();
include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  
 if(isset($_REQUEST['btnadd'])){
	 
  $brand=$_POST['brand'];	
  $trn=$_POST['trn'];	
	$b_url=$_POST['brand_url'];
	$contact_number=$_POST['contact-number'];
	$fax=$_POST['fax'];
  $email=$_POST['email'];
  $workcategory	= $_POST['workcategory'];
  $company_address=$_POST['company-address'];
  $contact_person=$_POST['contact-person'];
  $mobile=$_POST['mobile-number'];
  $direct_phone=$_POST['direct-phone'];
  $contact_email=$_POST['contact-email'];
  $position=$_POST['position'];
	 
	$msg=""; $error="";
	if($brand!=""){
		//
		include_once("classes/class.upload.php");
		
		$b_image=image_upload($_FILES['brand_img'],$brand."logo_img",500);
		//var_dump($p_image); exit;
		//
		
		  //var_dump($num); exit;
		  $query = "INSERT INTO `".TB_pre."brands` (`brand_name`,`trn`,`contact_number`,`fax`,`email`,`address`,`contact_person`,`contact_mobile`,`direct_phone`,`contact_email`,`position`,`brand_url`,`brand_category`,`brand_logo`) VALUES('$brand','$trn','$contact_number','$fax','$email','$company_address','$contact_person','$mobile','$direct_phone','$contact_email','$position','$b_url','$workcategory','$b_image')";
		  //var_dump($query); exit;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Brand Successfully Added";
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
            Add Contact
          </h1>
          
          <ol class="breadcrumb">
            <li><a href="brands.php" class="btn btn-block"><i class="fa fa-eye"></i>View Contacts</a></li>
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
                      <label>Company Name</label>
                      <input type="text" class="form-control" placeholder="Company Name" name="brand" id="brand" />
                    </div>
                    <div class="form-group">
                      <label>TRN</label>
                      <input type="text" class="form-control" placeholder="TRN" name="trn" id="trn" />
                    </div>
                    <div class="form-group">
                      <label>Company Address</label>
                      <input type="text" class="form-control" placeholder="Company Address" name="company-address" id="company-address" />
                    </div>
					  
					 <div class="form-group">
                      <label>Telephone Number</label>
                      <input type="tel" class="form-control" placeholder="Contact number" name="contact-number" id="contact-number" />
                    </div>
					<div class="form-group">
                      <label>Fax Number</label>
                      <input type="tel" class="form-control" placeholder="Fax" name="fax" id="fax" />
                    </div>
					 <div class="form-group">
                      <label>Email Address</label>
                      <input type="email" class="form-control" placeholder="Email" name="email" id="email" />
                    </div>
					  
					<div class="form-group">
                      <label>Website</label>
                      <input type="text" class="form-control" placeholder="Brand URL" name="brand_url" id="url" />
                    </div>
					<div class="form-group">
                      <label>Work category</label>
                      <select class="form-control" name="workcategory" id="workcategory" required >
                      	<option value="">Select</option>
                        <?php 
						$res_cat=mysqli_query($url,"SELECT * FROM `".TB_pre."brand_categories` WHERE `parent_cat`=0 ");
						while($row=mysqli_fetch_object($res_cat)){
						?>
                        <option value="<?php echo $row->cat_id; ?>"><?php echo $row->cat_name; ?></option>
                        <?php 
						$ch_q=mysqli_query($url,"SELECT * FROM `".TB_pre."brand_categories` WHERE `parent_cat`=".$row->cat_id);
						while($ch_row=mysqli_fetch_object($ch_q)){ ?>
                        <option value="<?php echo $ch_row->cat_id; ?>" >-- <?php echo $ch_row->cat_name; ?></option>
						<?php } ?>
                       
                      	<?php } ?>
                      </select>
                    </div>
					  
					  
                    
                    <div class="form-group">
                      <label>Contact Person</label>
                      <input type="text" class="form-control" placeholder="Contact person" name="contact-person" id="contact-person" />
                    </div>
					 <div class="form-group">
                      <label>Mobile Number</label>
                      <input type="tel" class="form-control" placeholder="Mobile number" name="mobile-number" id="mobile-number" />
                    </div>
					 <div class="form-group">
                      <label>Direct Phone</label>
                      <input type="tel" class="form-control" placeholder="Direct phone" name="direct-phone" id="direct-phone" />
                    </div>
					<div class="form-group">
                      <label>Email Address</label>
                      <input type="email" class="form-control" placeholder="Email" name="contact-email" id="contact-email" />
                    </div>
                    <div class="form-group">
                      <label>Position</label>
                      <input type="text" class="form-control" placeholder="Position" name="position" id="position" />
                    </div>
                    <div class="form-group">
                      <label>Supplier logo / image</label>
                      <input type="file" class="form-control" placeholder="Image" name="brand_img" id="brimg" />
                    </div>
                    
                    
                    
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnadd">Add Contact</button>
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
    CKEDITOR.replace('scheme_desc');
  });
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>