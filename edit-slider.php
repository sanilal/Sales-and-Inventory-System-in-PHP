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
	$s_title=$_POST['s_title'];	
	$s_desc=$_POST['s_desc'];
	$old_img=$_POST['old_img'];
		//
		$id=$_POST['slider_id'];
		$time=date("Y-m-d-H-i-s");
		if(file_exists($_FILES['slider_img']['tmp_name']) || is_uploaded_file($_FILES['slider_img']['tmp_name'])) {
			unlink( "uploads/".$old_img);
		}
		include_once("classes/class.upload.php");
		$s_image=image_upload($_FILES['slider_img'],$time."slide_img",1600);
		//var_dump($p_image); exit;
		if($s_image==""){
			$s_image=$old_img;
		}
		//
		$msg=""; $error="";
		  //var_dump($num); exit;
		  $query = "UPDATE `".TB_pre."slider` SET `slider_img`='$s_image', slider_title='$s_title', slider_desc='$s_desc' WHERE slider_id=".$id;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Scheme Successfully updated";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	
}
$s_res=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."slider` WHERE slider_id=".$_GET['slider_id']));
?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Update Slider
          </h1>
          
          <ol class="breadcrumb">
            <li><a href="slider.php" class="btn btn-block"><i class="fa fa-eye"></i>View Slider images</a></li>
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
                      <label>Slider Title</label>
                      <input type="text" class="form-control" placeholder="Title" name="s_title" id="product" value="<?php echo $s_res->slider_title;?>" />
                    </div>
                    <div class="form-group">
                      <label>Sider Description</label>
                      <textarea class="form-control" placeholder="Description" name="s_desc" id="scheme_desc" ><?php echo $s_res->slider_desc;?></textarea>
                    </div>
                  
                    
                    <div class="form-group">
                      <label>Slider Image</label>
                      <?php if($s_res->slider_img!=""){ ?>
                      <img src="uploads/<?php echo $s_res->slider_img; ?>" width="200" />
                      <?php } ?>
                      <input type="file" class="form-control" placeholder="Scheme Image" name="slider_img" id="sliderimg" />
                      <input type="hidden" name="old_img" value="<?php echo $s_res->slider_img; ?>" />
                    </div>
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnedit">Update Slider</button>
                    <input type="hidden" name="slider_id" value="<?php echo $_GET['slider_id']; ?>" />
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