<?php $active="products"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  

 if(isset($_REQUEST['btnedit'])){
	$procatname	= $_POST['productmenu'];
	$parent=$_POST['parent'];
	$old_img=$_POST['old_img'];
	
	if($procatname!=""){
		$cat_id=$_POST['cat_id'];
		$msg=""; $error="";
		//
		include_once("classes/class.upload.php");
		//
		if(file_exists($_FILES['productimg']['tmp_name']) || is_uploaded_file($_FILES['productimg']['tmp_name'])) {
			unlink( "uploads/".$old_img);
		}
		$p_image=image_upload($_FILES['productimg'],$product."main_img",900);
		if($p_image==""){
			$p_image=$old_img;
		}
		//
		$g_images="";
		for($i=1; $i<=$_POST['img_count']; $i++) {
			$old_gimg=$_POST['old_cat_imgs-'.$i];
			if($_FILES['cat_imgs-'.$i]['tmp_name']!="" ) {
				unlink( "uploads/".$old_gimg);
			}
			$u_image=image_upload($_FILES['cat_imgs-'.$i],$procatname."cat_img".$i);
			if($u_image!=""){
				$g_images.=",".$u_image;
			}
			else if($old_gimg!=""){
				$g_images.=",".$old_gimg;
			}
		}
		$g_images=ltrim($g_images,",");
		//
		$cat_videos=implode(',', array_filter($_POST['cat_video']));
		//
	  $num=mysqli_num_rows(mysqli_query($url,"SELECT `cat_name` FROM `".TB_pre."pcategories` WHERE `cat_name`='$procatname' && `parent_cat`='$parent' && cat_id!=".$cat_id));
	  //var_dump($num); exit;
	  if($num < 1){
		  $query = "UPDATE `".TB_pre."pcategories` SET `cat_name`='$procatname',`parent_cat`='$parent', cat_desc='".$_POST['cat_desc']."', cat_imgs='$g_images', cat_videos='$cat_videos',  cat_banner='$p_image' WHERE `cat_id`=".$cat_id;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Category Successfully Updated";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  }
	  else{
			$error.= "Failed: Category already exist";
		}
	}
}

///////////

$res_cat=mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE `cat_id`=".$_GET['cat_id']);
$row=mysqli_fetch_object($res_cat);


?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit Product Category
          </h1>
          
         <!-- <ol class="breadcrumb">
            <li><a href="categories.php" class="btn btn-block"><i class="fa fa-eye"></i>View Categories</a></li>
          </ol> -->
        
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
                      <input type="text" class="form-control" placeholder="Product Category" name="productmenu" id="productmenu" value="<?php echo $row->cat_name; ?>" />
                    </div>
                    
                      <div class="form-group">
                      <label>Parent Category</label>
                      <select class="form-control" name="parent" id="parnt">
                      <option value="0">Default</option>
                      <?php
					  $r_p=mysqli_query($url,"select * from `".TB_pre."pcategories` WHERE parent_cat=0 && cat_id!=".$_GET['cat_id']);
					  while($prnt=mysqli_fetch_object($r_p)){ ?>
					  	<option value="<?php echo $prnt->cat_id; ?>" <?php if($prnt->cat_id==$row->parent_cat){ echo 'selected="selected"';} ?> ><?php echo $prnt->cat_name; ?></option>
					 <?php
                      }
					  ?>
                      </select>
                    </div>
                        <div class="form-group">
                      <label>Category Description</label>
                      <textarea class="form-control" placeholder="Product Category" name="cat_desc" id="catdesc"><?php echo $row->cat_desc; ?></textarea>
                    </div>
                    
                   <div class="form-group">
                      <label>Category Images</label>
                      <?php
					  $k=1;
					  $cat_imgs=explode(",",$row->cat_imgs);
					  foreach($cat_imgs as $cat_img){
					?>
                    <input type="file" class="form-control" placeholder="Image" name="cat_imgs-<?php echo $k; ?>"  />
                    <img src="uploads/<?php echo $cat_img; ?>" width="200" />
                    <input type="hidden" name="old_cat_imgs-<?php echo $k; ?>" value="<?php echo $cat_img; ?>" />
                    <br/>
					<?php		 
						$k++;
						}
						if($k==1){
					  ?>
                      <input type="file" class="form-control" placeholder="Image" name="cat_imgs-1" id="cattimg" /> 
                       <input type="hidden" name="old_cat_imgs-<?php echo $k; ?>" value="<?php echo $cat_imgs[0]; ?>" />
                      <br/>
                      <?php } ?>
                      <button type="button" onClick="add_img(this);">+ Add Image</button>
                    </div>
                    
                     <div class="form-group">
                      <label>Category Videos</label>
                       <?php
					  $v=1;
					  $cat_vids=explode(",",$row->cat_videos);
					  foreach($cat_vids as $cat_vid){
					?>
                    <input type="text" class="form-control" placeholder="Video Link" name="cat_video[]" id="vidnu" value="<?php echo $cat_vid; ?>" /> 
                    <br/>
                    <?php $v++; }  if($v==1){ ?>
                      <input type="text" class="form-control" placeholder="Video Link" name="cat_video[]" id="vidnu" value="<?php echo $cat_vids[0]; ?>"   /> <br/>
                    <?php } ?>
                      <button type="button" onClick="add_video(this);">+ Add Video</button>
                    </div>
                    <div class="form-group">
                      <label>Banner Image</label>
                      <?php if($row->cat_banner!=""){ ?>
                      <img src="uploads/<?php echo $row->cat_banner; ?>" width="200" />
                      <?php } ?>
                      <input type="file" class="form-control" placeholder="Banner Image" name="productimg" id="productimg" />
                      <input type="hidden" name="old_img" value="<?php echo $row->cat_banner; ?>" />
                    </div>
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  <input type="hidden" name="img_count" value="<?php echo $k; ?>" id="img_count" />
                    <button type="submit" class="btn btn-primary" name="btnedit">Update Category</button>
                    <input type="hidden" name="cat_id" value="<?php echo $_GET['cat_id']; ?>" />
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
  //
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