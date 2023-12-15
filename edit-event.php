<?php $active="events"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  

 if(isset($_REQUEST['btnedit'])){
	
	$eventname	=  mysqli_real_escape_string($url, $_POST['event_name']);
	$event_type=$_POST['event_type'];
	$event_desc=mysqli_real_escape_string($url,$_POST['event_desc']);
	$date=mysqli_real_escape_string($url,$_POST['event_date']);
	$tag=mysqli_real_escape_string($url,$_POST['event_tag']);
	$old_img=$_POST['old_img'];

	
	if($eventname!="" && $event_type!=""){
		$id=$_POST['event_id'];
		$msg=""; $error="";
		//
		include_once("classes/class.upload.php");
		//
		if(file_exists($_FILES['productimg']['tmp_name']) || is_uploaded_file($_FILES['productimg']['tmp_name'])) {
			unlink( "uploads/".$old_img);
		}
		//
		$p_image=image_upload($_FILES['productimg'],$eventname."main_img",900);
		if($p_image==""){
			$p_image=$old_img;
		}
		//
		//
		if($event_type=="Image"){
			$d_source=image_upload($_FILES['d_source'],$eventname."source".time(),1200);
			if($d_source=="" || $d_source==NULL){
				  $d_source=$_POST['old_source'];
			  }
		}
		else{
			$d_source=$_POST['d_source'];
		}
		//
	  $num=mysqli_num_rows(mysqli_query($url,"SELECT `event_name` FROM `".TB_pre."events` WHERE `event_name`='$eventname' && `event_type`='$event_type' && event_id!=".$id));
	  //var_dump($num); exit;
	  if($num < 1){
		  $query = "UPDATE `".TB_pre."events` SET `event_name`='$eventname', `event_type`='$event_type',`event_desc`='$event_desc', `event_img`='$p_image',event_date='$date', event_tag='$tag', data_source='$d_source' WHERE event_id=".$id;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  
			  $msg.= "Event Successfully Updated";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  }
	  else{
			$error.= "Failed: Event already exist";
		}
	}
	else{
		$error.= "Failed: Please fill required fields";
	}
}
?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Add Event
          </h1>
          
          <ol class="breadcrumb">
            <li><a href="events.php" class="btn btn-block"><i class="fa fa-eye"></i>View Events</a></li>
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
            <?php
			$res_cat=mysqli_query($url,"SELECT * FROM `".TB_pre."events` WHERE `event_id`=".$_GET['event_id']);
			$row=mysqli_fetch_object($res_cat);
			?>
            <div class="box-body">
              <form role="form" method="post"  class="form-horizontal" action="" enctype="multipart/form-data">
                  <div class="box-body">
                  
                  <div class="form-group">
                      <label>Event Title</label>
                      <input type="text" class="form-control" placeholder="Event Name" name="event_name" id="productmenu" value="<?php echo $row->event_name; ?>">
                    </div>
                    <div class="form-group">
                      <label>Event Keyword</label>
                      <input type="text" class="form-control" placeholder="Event Keyword" name="event_tag" id="event_tag" value="<?php echo $row->event_tag; ?>" />
                    </div>
                     
                    <div class="form-group">
                      <label>Event Description</label>
                      <textarea class="form-control" placeholder="Event Description" name="event_desc" id="event_desc"><?php echo $row->event_desc ?> </textarea>
                    </div>
                    <div class="form-group">
                      <label>Event Date</label>
                       <input type="text" placeholder="Event Date"  class="form-control d_source" name="event_date" value="<?php echo $row->event_date; ?> "  />
                    </div>
                     <div class="form-group">
                      <label>Thumbnail Image</label>
                      <?php if($row->event_img!=""){ ?>
                      <img src="uploads/<?php echo $row->event_img; ?>" width="200" />
                      <?php } ?>
                      <input type="file" class="form-control" placeholder=" Image" name="productimg" id="productimg" />
                      <input type="hidden" name="old_img" value="<?php echo $row->event_img; ?>" />
                    </div>
                    <div class="form-group">
                      <label>Data Type</label>
                      <select class="form-control" name="event_type" id="parnt" onChange="select_type(this)">
                      <option value="">Select</option>
                      <option <?php if($row->event_type=="Image"){ echo 'selected="selected"';} ?>>Image</option>
                      <option <?php if($row->event_type=="Video"){ echo 'selected="selected"';} ?>>Video</option>
                      </select>
                    </div>
                     <div class="form-group">
                      <label>Data Source</label>
                     <input <?php if($row->event_type=="Image"){echo'type="file"'; } else{ echo'type="text"'; }?> class="form-control d_source" name="d_source" value="<?php echo $row->data_source; ?>"  />
                     <?php if($row->event_type=="Image"){
							  	echo '<img src="uploads/'.$row->data_source.'" width="100" /> <input type="hidden" name="old_source" value="'.$row->data_source.'" />';
							  }
								  ?>
                    </div>
                   
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                  <input type="hidden" name="event_id" value="<?php echo $_GET['event_id']; ?>" />
                    <button type="submit" class="btn btn-primary" name="btnedit">Update Event</button>
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
<script>

		function select_type(obj){
			if($(obj).val()=="image"){
				var s_name=$(obj).parent().next().find( ".d_source" ).attr('name');
				$(obj).parent().next().find( ".d_source" ).replaceWith( '<input type="file" class="form-control d_source" name="d_source" />' );
			}
			else{
				var s_name=$(obj).parent().next().find( ".d_source" ).attr('name');
				$(obj).parent().next().find( ".d_source" ).replaceWith( '<input type="text" class="form-control d_source" name="d_source" />' );
			}
		}
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>