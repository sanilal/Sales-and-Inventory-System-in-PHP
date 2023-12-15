<?php $active="pages"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  

 if(isset($_REQUEST['btnedit'])){
	 
	$head=$_POST['heading'];	
	$page_cont=$_POST['page_content'];
	$old_img=$_POST['old_img'];
		//
		$id=$_POST['page_id'];
		if(file_exists($_FILES['page_img']['tmp_name']) || is_uploaded_file($_FILES['page_img']['tmp_name'])) {
			unlink( "uploads/".$old_img);
		}
		include_once("classes/class.upload.php");
		$time=date("Y-m-d-H-i-s");
		$p_image=image_upload($_FILES['page_img'],$id."page".$time);
		//var_dump($p_image); exit;
		if($p_image==""){
			$p_image=$old_img;
		}
		//
		$msg=""; $error="";
		  //var_dump($num); exit;
		  $query = "UPDATE `".TB_pre."pages` SET `heading`='$head',`page_content`='$page_cont',`page_img`='$p_image' WHERE page_id=".$id;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Page content Successfully updated";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	
}
$s_res=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."pages` WHERE page_id=".$_GET['page_id']));
?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Edit Page - <?php echo $s_res->page_name; ?>
          </h1>
         
        
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
                      <label>Page</label>
                    <input type="text" class="form-control" placeholder="Page Name" name="page" id="page" value="<?php echo $s_res->page_name;  ?>" readonly />
                    </div>
                    
                    <div class="form-group">
                      <label>Main Heading</label>
                    <input type="text" class="form-control" placeholder="Heading" name="heading" id="heading" value="<?php echo $s_res->heading;  ?>" />
                    </div>
                    
                    <div class="form-group">
                      <label>Page Content</label>
                      <textarea class="form-control" placeholder="Scheme Description" name="page_content" id="page_cont"> <?php echo $s_res->page_content; ?> </textarea>
                    </div>
                    
                    <div class="form-group">
                      <label>Page Image</label>
                      <?php if($s_res->page_img!=""){ ?>
                      <img src="uploads/<?php echo $s_res->page_img; ?>" width="200" />
                      <?php } ?>
                      <input type="file" class="form-control" placeholder="Image" name="page_img" id="productimg" />
                      <input type="hidden" name="old_img" value="<?php echo $s_res->page_img; ?>" />
                    </div>
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnedit">Submit</button>
                    <input type="hidden" name="page_id" value="<?php echo $_GET['page_id']; ?>" />
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
		selector: "textarea#page_cont",
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