<?php $active="offers"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  

 if(isset($_REQUEST['btnedit'])){
	 
	$offer=$_POST['offer'];	
	$offer_desc=$_POST['offer_desc'];
	$offer_price=$_POST['offer_price'];
	$old_img=$_POST['old_img'];
	$of_id=$_POST['offer_id'];
	
	if($offer!="" && $offer_desc!="" && $offer_price!=""){
		//
		include_once("classes/class.upload.php");
		
		$o_image=image_upload($_FILES['offer_img'],$offer."main_img");
		//var_dump($p_image); exit;
		if($o_image==""){
			$o_image=$old_img;
		}
		else{
			unlink( "uploads/".$old_img);
		}
		//
		$msg=""; $error="";
		  //var_dump($num); exit;
		  $query = "UPDATE `".TB_pre."offers` SET `offer_title`='$offer',`offer_desc`='$offer_desc',`offer_img`='$o_image',`offer_price`='$offer_price' WHERE offer_id=".$of_id;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Offer Successfully updated";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	}
	else {
			  $error.= "Failed: Fill all the required fields";
		  }
}

$of_res=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."offers` WHERE offer_id=".$_GET['offer_id']));

?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Update Offer
          </h1>
          
          <ol class="breadcrumb">
            <li><a href="offers.php" class="btn btn-block"><i class="fa fa-eye"></i>View Offers</a></li>
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
                      <label>Offer Title</label>
                      <input type="text" class="form-control" placeholder="Offer Name" name="offer" id="offer" value="<?php echo $of_res->offer_title; ?>" />
                    </div>
                    
                    <div class="form-group">
                      <label>Offer Price</label>
                      <input type="text" class="form-control" placeholder="Offer Price" name="offer_price" id="price" value="<?php echo $of_res->offer_price; ?>" />
                    </div>
                    
                    <div class="form-group">
                      <label>Offer Description</label>
                      <textarea class="form-control" placeholder="Offer Description" name="offer_desc" id="offer_desc"> <?php echo $of_res->offer_desc; ?> </textarea>
                    </div>
                    
                    <div class="form-group">
                      <label>Offer Image</label>
                      <?php if($of_res->offer_img!=""){ ?>
                      <img src="uploads/<?php echo $of_res->offer_img; ?>" width="200" />
                      <?php } ?>
                      <input type="file" class="form-control" placeholder="Offer Image" name="offer_img" id="offerimg" />
                      <input type="hidden" name="old_img" value="<?php echo $of_res->offer_img; ?>" />
                    </div>
                   
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnedit">Update Offer</button>
                    <input type="hidden" name="offer_id" value="<?php echo $_GET['offer_id']; ?>" />
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
    CKEDITOR.replace('offer_desc');
  });
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>