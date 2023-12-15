<?php $active="schemes"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  
 if(isset($_REQUEST['btnadd'])){	
 
 	$s_title=$_POST['s_title'];	
	$s_desc=$_POST['s_desc'];
	
	if(file_exists($_FILES['slider_img']['tmp_name']) || is_uploaded_file($_FILES['slider_img']['tmp_name'])) {
		$time=date("Y-m-d-H-i-s");
		//
		include_once("classes/class.upload.php");
		
		$s_image=image_upload($_FILES['slider_img'],$time."slide_img",1600);
		//var_dump($p_image); exit;
		//
		$msg=""; $error="";
		  //var_dump($num); exit;
		  $query = "INSERT INTO `".TB_pre."slider` (`slider_img`,slider_title,slider_desc) VALUES('$s_image','$s_title','$s_desc')";
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Slider Successfully Added";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	}
	else {
			  $error.= "Error: Add an image";
		  }
}
?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add new Slider
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
                      <input type="text" class="form-control" placeholder="Title" name="s_title" id="product" />
                    </div>
                    <div class="form-group">
                      <label>Sider Description</label>
                      <textarea class="form-control" placeholder="Description" name="s_desc" id="scheme_desc" ></textarea>
                    </div>
                    <div class="form-group">
                      <label>Slider Image</label>
                      <input type="file" class="form-control" placeholder="Slider Image" name="slider_img" id="sliderimg" />
                    </div>
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnadd">Add Image</button>
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