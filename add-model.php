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
	$desc=$_POST['model_desc'];
	
	$msg=""; $error="";
	if($brand!="" && $_POST['model']!=""){
		//
		include_once("classes/class.upload.php");
		
		$b_image=image_upload($_FILES['brand_img'],$_POST['model']."logo_img",500);
		//var_dump($p_image); exit;
		//
		
		  //var_dump($num); exit;
		  $query = "INSERT INTO `".TB_pre."brand_models` (`model_name`, `brand_id`, `model_desc`,`model_img`) VALUES('".$_POST['model']."', '$brand', '$desc', '$b_image' )";
		  //var_dump($query); exit;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Model Successfully Added";
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
            Add new Model
          </h1>
          
          <ol class="breadcrumb">
            <li><a href="models.php" class="btn btn-block"><i class="fa fa-eye"></i>View Models</a></li>
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
                      <label>Model Name</label>
                      <input type="text" class="form-control" placeholder="Model Name" name="model" id="brand-model" />
                    </div>
                    
                  	<div class="form-group">
                      <label>Manufacture/Made</label>
                      <select class="form-control" placeholder="Brand Name" name="brand" id="brand_id" required >
                      	<option value="">Select</option>
                        <?php
                        $r_p=mysqli_query($url,"select * from `".TB_pre."brands` ");
						  while($prnt=mysqli_fetch_object($r_p)){
							echo '<option value="'.$prnt->brand_id.'">'.$prnt->brand_name.'</option>';
						  }
                      ?>
                      
                      </select>
                    </div>
                    
                    <div class="form-group">
                      <label>Model Image</label>
                      <input type="file" class="form-control" placeholder="Image" name="brand_img" id="brimg" />
                    </div>
                    
                    
                    <div class="form-group">
                      <label>Model Description</label>
                      <textarea class="form-control" placeholder="Description" name="model_desc" id="url"> </textarea>
                    </div>
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnadd">Add Model</button>
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