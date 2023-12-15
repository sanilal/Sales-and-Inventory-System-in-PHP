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
	$desc=$_POST['model_desc'];
	$date= date("DMdYG:i");
	$msg=""; $error="";
	if($brand!="" && $_POST['model']!=""){
		//
		include_once("classes/class.upload.php");
		//
		if(file_exists($_FILES['brand_img']['tmp_name']) || is_uploaded_file($_FILES['brand_img']['tmp_name'])) {
			unlink( "uploads/".$_POST['old_img']);
		}
		//
		$b_image=image_upload($_FILES['brand_img'],$_POST['model']."logo_img".$date,500);
		if($b_image==""){
			$b_image=$_POST['old_img'];
		}
		//var_dump($p_image); exit;
		//
		
		  //var_dump($num); exit;
		  $query = "UPDATE `".TB_pre."brand_model_series` SET `series_name`='".$_POST['model']."', `model_id`='$brand', `series_desc`='$desc' , `series_img`='$b_image' WHERE series_id=".$_POST['series_id'];
		  //var_dump($query); exit;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Series Successfully Updated";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	}
	else {
			  $error.= "Failed: Fill all the required fields";
		  }
}

//
$res_model=mysqli_query($url,"SELECT * FROM `".TB_pre."brand_model_series` WHERE `series_id`=".$_GET['series_id']);
$row=mysqli_fetch_object($res_model);

?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Update Series
          </h1>
          
          <ol class="breadcrumb">
            <li><a href="m_series.php" class="btn btn-block"><i class="fa fa-eye"></i>View Series</a></li>
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
                      <label>Series Name</label>
                      <input type="text" class="form-control" placeholder="Series Name" name="model" id="brand-model" value="<?php echo $row->series_name; ?>" />
                    </div>
                    
                  	<div class="form-group">
                      <label>Model</label>
                      <select class="form-control" placeholder="Model Name" name="brand" id="brand_id" required >
                      	<option value="">Select</option>
                        <?php
                        $r_p=mysqli_query($url,"select * from `".TB_pre."brands` ");
						  while($prnt=mysqli_fetch_object($r_p)){
							echo '<optgroup value="'.$prnt->brand_id.'" label="'.$prnt->brand_name.'">';
							$r_m=mysqli_query($url,"select * from `".TB_pre."brand_models` WHERE brand_id=".$prnt->brand_id);
							while($mdl=mysqli_fetch_object($r_m)){
								if($row->model_id==$mdl->model_id){
									echo '<option value="'.$mdl->model_id.'" selected="selected">'.$mdl->model_name.'</option>';
								}
								else{
									echo '<option value="'.$mdl->model_id.'">'.$mdl->model_name.'</option>';
								}
							}
							echo '</optgroup>';
						  }
                      ?>
                      
                      </select>
                    </div>
                    
                    <div class="form-group">
                      <label>Series Image</label>
                      <input type="file" class="form-control" placeholder="Image" name="brand_img" id="brimg" />
                      <?php if($row->series_img!=""){ ?>
                      <img src="uploads/<?php echo $row->series_img; ?>" width="200" />
                      <?php } ?>
                      <input type="hidden" name="old_img" value="<?php echo $row->series_img; ?>" />
                    </div>
                    
                    
                    <div class="form-group">
                      <label>Series Description</label>
                      <textarea class="form-control" placeholder="Description" name="model_desc" id="url"><?php echo $row->series_desc; ?> </textarea>
                    </div>
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnedit">Update Series</button>
                    <input type="hidden" name="series_id" value="<?php echo $_GET['series_id']; ?>" />
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