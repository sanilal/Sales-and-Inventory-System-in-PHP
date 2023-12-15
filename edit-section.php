<?php $active="sections"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  
 if(isset($_REQUEST['btnedit'])){
	 
	$name=$_POST['sec_name'];	
	$sec_desc=$_POST['sec_desc'];
	$img_desc=$_POST['img_desc'];
	$old_img=$_POST['old_img'];
	$old_img2=$_POST['old_img2'];
	$old_img3=$_POST['old_img3'];
	$old_img4=$_POST['old_img4'];
		//
		$id=$_POST['sec_id'];
		if(file_exists($_FILES['section_img']['tmp_name']) || is_uploaded_file($_FILES['section_img']['tmp_name'])) {
			unlink( "uploads/".$old_img);
		}
		if(file_exists($_FILES['section_img2']['tmp_name']) || is_uploaded_file($_FILES['section_img2']['tmp_name'])) {
			unlink( "uploads/".$old_img2);
		}
		if(file_exists($_FILES['section_img3']['tmp_name']) || is_uploaded_file($_FILES['section_img3']['tmp_name'])) {
			unlink( "uploads/".$old_img3);
		}
		if(file_exists($_FILES['section_img4']['tmp_name']) || is_uploaded_file($_FILES['section_img4']['tmp_name'])) {
			unlink( "uploads/".$old_img4);
		}
		include_once("classes/class.upload.php");
		$time=date("Y-m-d-H-i-s");
		$p_image=image_upload($_FILES['section_img'],$id."page".$time,600);
		$p_image2=image_upload($_FILES['section_img2'],$id."page2".$time,600);
		$p_image3=image_upload($_FILES['section_img3'],$id."page3".$time,600);
		$p_image4=image_upload($_FILES['section_img4'],$id."page4".$time,600);
		//var_dump($p_image); exit;
		if($p_image==""){
			$p_image=$old_img;
		}
		if($p_image2==""){
			$p_image2=$old_img2;
		}
		if($p_image3==""){
			$p_image3=$old_img3;
		}
		if($p_image4==""){
			$p_image4=$old_img4;
		}
		//
		$msg=""; $error="";
		  //var_dump($num); exit;
		  $query = "UPDATE `".TB_pre."sections` SET `section_name`='$name',`section_desc`='$sec_desc',`img_desc`='$img_desc',`section_img`='$p_image', `section_img2`='$p_image2', `section_img3`='$p_image3', `section_img4`='$p_image4' WHERE section_id=".$id;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Section Successfully updated";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	
}
$s_res=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."sections` WHERE section_id=".$_GET['section_id']));
?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit Section
          </h1>
         <ol class="breadcrumb">
            <li><a href="sections.php" class="btn btn-block"><i class="fa fa-eye"></i>View Sections</a></li>
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
                      <label>Section Name</label>
                    <input type="text" class="form-control" placeholder="Name" name="sec_name" id="page" value="<?php echo $s_res->section_name;  ?>" readonly  />
                    </div>
                    
                    <div class="form-group">
                      <label>Image</label>
                      <?php if($s_res->section_img!=""){ ?>
                      <img src="uploads/<?php echo $s_res->section_img; ?>" width="200" />
                      <?php } ?>
                      <input type="file" class="form-control" placeholder="Image" name="section_img" id="productimg" />
                      <input type="hidden" name="old_img" value="<?php echo $s_res->section_img; ?>" />
                    </div>
                    <div class="form-group">
                      <label>Image 2</label>
                      <?php if($s_res->section_img2!=""){ ?>
                      <img src="uploads/<?php echo $s_res->section_img2; ?>" width="200" />
                      <?php } ?>
                      <input type="file" class="form-control" placeholder="Image" name="section_img2" id="productimg2" />
                      <input type="hidden" name="old_img2" value="<?php echo $s_res->section_img2; ?>" />
                    </div>
                    <div class="form-group">
                      <label>Image 3</label>
                      <?php if($s_res->section_img3!=""){ ?>
                      <img src="uploads/<?php echo $s_res->section_img3; ?>" width="200" />
                      <?php } ?>
                      <input type="file" class="form-control" placeholder="Image" name="section_img3" id="productimg3" />
                      <input type="hidden" name="old_img3" value="<?php echo $s_res->section_img3; ?>" />
                    </div>
                    <div class="form-group">
                      <label>Image 4</label>
                      <?php if($s_res->section_img4!=""){ ?>
                      <img src="uploads/<?php echo $s_res->section_img4; ?>" width="200" />
                      <?php } ?>
                      <input type="file" class="form-control" placeholder="Image" name="section_img4" id="productimg4" />
                      <input type="hidden" name="old_img4" value="<?php echo $s_res->section_img4; ?>" />
                    </div>
                    
                      <div class="form-group" style="display:none">
                      <label>Image Text</label>
                    <textarea class="form-control" placeholder="Image Text" name="img_desc" id="heading" ><?php echo $s_res->img_desc;  ?> </textarea>
                    </div>
                    
                    <div class="form-group">
                      <label>Section Content</label>
                      <textarea class="form-control" placeholder="Content Part" name="sec_desc" id="page_cont"> <?php echo $s_res->section_desc; ?> </textarea>
                    </div>
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnedit">Submit</button>
                    <input type="hidden" name="sec_id" value="<?php echo $_GET['section_id']; ?>" />
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
<script src="tinymce/tinymce.dev.js"></script>
<script>
	tinymce.init({
		selector: "textarea",
		theme: "modern",
		plugins: [
			"advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
			"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
			"save table contextmenu directionality emoticons template paste textcolor importcss"
		],
		

		style_formats: [
			{title: 'Bold text', format: 'h1'},
			{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
			{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
			{title: 'Example 1', inline: 'span', classes: 'example1'},
			{title: 'Example 2', inline: 'span', classes: 'example2'},
			{title: 'Table styles'},
			{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		]

		
	});
</script>
<style>
*:focus {
	outline: 1px solid red !important;
}
</style>
    
  </body>
</html>
<?php ob_end_flush(); ?>