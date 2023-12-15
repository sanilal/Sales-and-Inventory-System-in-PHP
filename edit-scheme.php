<?php $active="schemes"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  

 if(isset($_REQUEST['btnedit'])){
	 
	$scheme=$_POST['scheme'];	
	$scheme_desc=$_POST['scheme_desc'];
	$old_img=$_POST['old_img'];
	$s_id=$_POST['scheme_id'];
	if($scheme!="" && $scheme_desc!=""){
		//
		$id=$_POST['scheme_id'];
		include_once("classes/class.upload.php");
		
		$s_image=image_upload($_FILES['scheme_img'],$scheme."main_img");
		//var_dump($p_image); exit;
		if($s_image==""){
			$s_image=$old_img;
		}
		else{
			unlink( "uploads/".$old_img);
		}
		//
		$msg=""; $error="";
		  //var_dump($num); exit;
		  $query = "UPDATE `".TB_pre."schems` SET `scheme_title`='$scheme',`scheme_desc`='$scheme_desc',`scheme_img`='$s_image' WHERE scheme_id=".$s_id;
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
$s_res=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."schems` WHERE scheme_id=".$_GET['scheme_id']));
?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Update Scheme
          </h1>
          
          <ol class="breadcrumb">
            <li><a href="schemes.php" class="btn btn-block"><i class="fa fa-eye"></i>View Schemes</a></li>
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
                      <label>Scheme Title</label>
                      <input type="text" class="form-control" placeholder="Scheme Name" name="scheme" id="product" value="<?php echo $s_res->scheme_title;  ?>" />
                    </div>
                    
                    
                    
                    <div class="form-group">
                      <label>Scheme Description</label>
                      <textarea class="form-control" placeholder="Scheme Description" name="scheme_desc" id="scheme_desc"> <?php echo $s_res->scheme_desc; ?> </textarea>
                    </div>
                    
                    <div class="form-group">
                      <label>Scheme Image</label>
                      <?php if($s_res->scheme_img!=""){ ?>
                      <img src="uploads/<?php echo $s_res->scheme_img; ?>" width="200" />
                      <?php } ?>
                      <input type="file" class="form-control" placeholder="Scheme Image" name="scheme_img" id="productimg" />
                      <input type="hidden" name="old_img" value="<?php echo $s_res->scheme_img; ?>" />
                    </div>
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnedit">Update Scheme</button>
                    <input type="hidden" name="scheme_id" value="<?php echo $_GET['scheme_id']; ?>" />
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