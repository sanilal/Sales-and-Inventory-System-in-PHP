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
	
	$procatname	= $_POST['productmenu'];
	$parent=$_POST['parent'];
	
	if($procatname!=""){
		$msg=""; $error="";
		//
		include_once("classes/class.upload.php");
		//
		$p_image=image_upload($_FILES['productimg'],$procatname."banner_img",900);
		
	  $num=mysqli_num_rows(mysqli_query($url,"SELECT `cat_name` FROM `".TB_pre."brand_categories` WHERE `cat_name`='$procatname' && `parent_cat`='$parent' "));
	  //var_dump($num); exit;
	  if($num < 1){
		  $g_images="";
		for($i=1; $i<=$_POST['img_count']; $i++) {
			$u_image=image_upload($_FILES['cat_imgs-'.$i],$procatname."cat_img".$i);
			//var_dump($_FILES['productimg'.$i]);
			if($u_image!=""){
				$g_images.=",".$u_image;
			}
		}
		$g_images=ltrim($g_images,",");
		$cat_videos=implode(',', array_filter($_POST['cat_video']));
		//var_dump($cat_videos);
		//var_dump($g_images); exit;
		  
		  $query = "INSERT INTO `".TB_pre."brand_categories` (`cat_name`,`parent_cat`,`cat_banner`, cat_desc, cat_imgs, cat_videos) VALUES('$procatname','$parent','$p_image','".$_POST['cat_desc']."', '".$g_images."', '".$cat_videos."')";
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Work Category Successfully Added";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  }
	  else{
			$error.= "Failed: Category already exist";
		}
	}
	else{
			$error.= "Failed: Please add name";
		}
}
?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Work Category
          </h1>
          
         <!--  <ol class="breadcrumb">
            <li><a href="categories.php" class="btn btn-block"><i class="fa fa-eye"></i>View Product Categories</a></li>
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
                      <label>Category Name</label>
                      <input type="text" class="form-control" placeholder="Work Category" name="productmenu" id="productmenu">
                    </div>
                    
                     <div class="form-group">
                      <label>Parent Category</label>
                      <select class="form-control" name="parent" id="parnt">
                      <option value="0">Default</option>
                      <?php
					  $r_p=mysqli_query($url,"select * from `".TB_pre."brand_categories` WHERE parent_cat=0");
					  while($prnt=mysqli_fetch_object($r_p)){
					  	echo '<option value="'.$prnt->cat_id.'">'.$prnt->cat_name.'</option>';
					  }
					  ?>
                      </select>
                    </div>
                  
                    <div class="form-group">
                      <label>Category Description</label>
                      <textarea class="form-control" placeholder="Work Category" name="cat_desc" id="catdesc"></textarea>
                    </div>
                    
                   <div class="form-group">
                      <label>Category Images</label>
                      <input type="file" class="form-control" placeholder="Image" name="cat_imgs-1" id="cattimg" /> <br/>
                      <button type="button" onClick="add_img(this);">+ Add Image</button>
                    </div>
                    
                     <div class="form-group">
                      <label>Category Videos</label>
                      <input type="text" class="form-control" placeholder="Video Link" name="cat_video[]" id="vidnu" /> <br/>
                      <button type="button" onClick="add_video(this);">+ Add Video</button>
                    </div>
                      <div class="form-group">
                      <label>Banner Image</label>
                      <input type="file" class="form-control" placeholder="Banner Image" name="productimg" id="productimg" />
                    </div>
                  </div><!-- /.box-body -->
                  
                  <div class="box-footer">
                  	<input type="hidden" name="img_count" value="1" id="img_count" />
                    <button type="submit" class="btn btn-primary" name="btnadd">Add Category</button>
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
    CKEDITOR.replace('catdesc');
  });
  
  function add_img(val){
	  var img_name=$(val).prev().prev().attr("name");
	  var new_val=parseInt(img_name.substr(img_name.indexOf("-") + 1))+1;
	  $("#img_count").val(new_val);
	  //alert(new_val);
	  $('<input type="file" class="form-control" placeholder="Image" name="cat_imgs-'+new_val+'" /> <br/>').insertBefore($(val));
}
 function add_video(val){
	$('<input type="text" class="form-control" placeholder="Video Link" name="cat_video[]" /> <br/>').insertBefore($(val));
 }
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>