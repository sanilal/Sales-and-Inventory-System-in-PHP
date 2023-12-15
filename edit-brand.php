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
	$workcategory	= $_POST['workcategory'];
	$contact_person=$_POST['contact-person'];
	$mobile=$_POST['mobile-number'];
	$direct_phone=$_POST['direct-phone'];
	$contact_email=$_POST['contact-email'];
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
		  $query = "UPDATE `".TB_pre."brands` SET `brand_name`='$brand',`trn`='$trn',`contact_number`='$contact_number',`fax`='$fax',`email`='$email',`address`='$company_address',`contact_person`='$contact_person',`contact_mobile`='$mobile',`direct_phone`='$direct_phone',`contact_email`='$contact_email',`position`='$position',`brand_url`='$b_url',`brand_logo`='$b_image' WHERE brand_id=".$id;
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
            Edit Contact
          </h1>
          
          <!--<ol class="breadcrumb">
            <li><a href="brands.php" class="btn btn-block"><i class="fa fa-eye"></i>View Brands</a></li>
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
                  
                  	<div class="form-group">
                      <label>Company Name</label>
                      <input type="text" class="form-control" placeholder="Company Name" name="brand" id="product" value="<?php echo $s_res->brand_name;  ?>" />
                    </div>
                    <div class="form-group">
                      <label>TRN</label>
                      <input type="text" class="form-control" placeholder="TRN" name="trn" id="trn" value="<?php echo $s_res->trn;  ?>" />
                    </div>
					 <div class="form-group">
                      <label>Company Address</label>
                      <input type="text" class="form-control" placeholder="Company Address" name="company-address" id="company-address" value="<?php echo $s_res->address;  ?>" />
                    </div>
                    <div class="form-group">
                      <label>Telephone Number</label>
                      <input type="tel" class="form-control" placeholder="Contact Number" name="contact-number" id="contact-number" value="<?php echo $s_res->contact_number;  ?>" />
                    </div>
					<div class="form-group">
                      <label>Fax</label>
                      <input type="tel" class="form-control" placeholder="Fax" name="fax" id="fax" value="<?php echo $s_res->fax;  ?>" />
                    </div>
					<div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" placeholder="Email" name="email" id="email" value="<?php echo $s_res->email;  ?>" />
                    </div>
					<div class="form-group">
                      <label>Website</label>
                      <input type="text" class="form-control" placeholder="Brand URL" name="brand_url" id="url" value="<?php echo $s_res->brand_url; ?>" />
                    </div>
					<div class="form-group">
                      <label>Work Category</label>
                      <select class="form-control" name="workcategory" id="workcategory" required >
                      	<option value="">Select</option>
                        <?php 
						$res_cat=mysqli_query($url,"SELECT * FROM `".TB_pre."brand_categories` WHERE `parent_cat`=0 ");
						while($row=mysqli_fetch_object($res_cat)){
						?>
                        <option value="<?php echo $row->cat_id; ?>" <?php if($s_res->brand_category==$row->cat_id){ echo 'selected="selected"';} ?> > <?php echo $row->cat_name; ?></option>
                        <?php 
						$ch_q=mysqli_query($url,"SELECT * FROM `".TB_pre."brand_categories` WHERE `parent_cat`=".$row->cat_id);
						while($ch_row=mysqli_fetch_object($ch_q)){ ?>
                        <option value="<?php echo $ch_row->cat_id; ?>"<?php if($s_res->brand_category==$ch_row->cat_id){ echo 'selected="selected"';} ?> >-- <?php echo $ch_row->cat_name; ?></option>
                      	<?php } ?>
                      	<?php } ?>
                      </select>
                    </div>
                    
					 <div class="form-group">
                      <label>Contact Person</label>
                      <input type="text" class="form-control" placeholder="Contact person" name="contact-person" id="contact-person" value="<?php echo $s_res->contact_person;  ?>" />
                    </div>
					 <div class="form-group">
                      <label>Mobile Number</label>
                      <input type="text" class="form-control" placeholder="Contact person" name="mobile-number" id="mobile-number" value="<?php echo $s_res->contact_mobile;  ?>" />
                    </div>
					 <div class="form-group">
                      <label>Direct Phone</label>
                      <input type="text" class="form-control" placeholder="Contact person" name="direct-phone" id="direct-phone" value="<?php echo $s_res->direct_phone;  ?>" />
                    </div>
					 <div class="form-group">
                      <label>Email Address</label>
                      <input type="text" class="form-control" placeholder="Contact person" name="contact-email" id="contact-email" value="<?php echo $s_res->contact_email;  ?>" />
                    </div>
                    <div class="form-group">
                      <label>Position</label>
                      <input type="text" class="form-control" placeholder="Position" name="position" id="position" value="<?php echo $s_res->position;  ?>" />
                    </div>
                    <div class="form-group">
                      <label>Supplier logo / image</label>
                      <?php if($s_res->brand_logo!=""){ ?>
                      <img src="uploads/<?php echo $s_res->brand_logo; ?>" width="200" />
                      <?php } ?>
                      <input type="file" class="form-control" placeholder="Brand Image" name="brand_img" id="bimg" />
                      <input type="hidden" name="old_img" value="<?php echo $s_res->brand_logo; ?>" />
                    </div>
                    
                    
                    
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnedit">Update Contact</button>
                    <input type="hidden" name="brand_id" value="<?php echo $_GET['brand_id']; ?>" />
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