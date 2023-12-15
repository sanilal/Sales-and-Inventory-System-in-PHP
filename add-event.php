<?php $active="events"; ?>
<?php
ob_start();
include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  
 if(isset($_REQUEST['btnadd'])){
	
	$eventname	=  mysqli_real_escape_string($url, $_POST['event_name']);
	$event_type=$_POST['event_type'];
	$event_desc=mysqli_real_escape_string($url,$_POST['event_desc']);
	$date=mysqli_real_escape_string($url,$_POST['event_date']);
	$tag=mysqli_real_escape_string($url,$_POST['event_tag']);
	if($eventname!="" && $event_type!=""){
		$msg=""; $error="";
		//
		include_once("classes/class.upload.php");
		//
		$p_image=image_upload($_FILES['productimg'],$eventname."main_img",900);
		//
		if($event_type=="Image"){
			$d_source=image_upload($_FILES['d_source'],$eventname."source".time(),1200);
		}
		else{
			$d_source=$_POST['d_source'];
		}
		//
		
	  $num=mysqli_num_rows(mysqli_query($url,"SELECT `event_name` FROM `".TB_pre."events` WHERE `event_name`='$eventname' && `event_type`='$event_type' "));
	  //var_dump($num); exit;
	  if($num < 1){
		  $query = "INSERT INTO `".TB_pre."events` (`event_name`,`event_type`,`event_desc`, `event_img`, event_date, event_tag, data_source ) VALUES('$eventname','$event_type','$event_desc', '$p_image', '$date', '$tag', '$d_source')";
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			 
			  $msg.= "Event Successfully Added";
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
            
            <div class="box-body">
              <form role="form" method="post"  class="form-horizontal" action="" enctype="multipart/form-data">
                  <div class="box-body">
                  
                  <div class="form-group">
                      <label>Event Title</label>
                      <input type="text" class="form-control" placeholder="Event Name" name="event_name" id="productmenu">
                    </div>
                    <div class="form-group">
                      <label>Event Keyword</label>
                      <input type="text" class="form-control" placeholder="Event Keyword" name="event_tag" id="event_tag">
                    </div>
                    
                    <div class="form-group">
                      <label>Event Description</label>
                      <textarea class="form-control" placeholder="Event Description" name="event_desc" id="event_desc"> </textarea>
                    </div>
                    <div class="form-group">
                      <label>Event Date</label>
                       <input type="text" placeholder="Event Date"  class="form-control d_source" name="event_date"  />
                    </div>
                     <div class="form-group">
                      <label>Thumbnail Image</label>
                      <input type="file" class="form-control" placeholder=" Image" name="productimg" id="productimg" />
                    </div>
                     
                     <div class="form-group">
                      <label>Data Type</label>
                      <select class="form-control" name="event_type" id="parnt" onChange="select_type(this)">
                      <option value="">Select</option>
                      <option>Image</option>
                      <option>Video</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label>Data Source</label>
                       <input type="file" class="form-control d_source" name="d_source"  />
                    </div>
                        
                   
                    
                  </div><!-- /.box-body -->

                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary" name="btnadd">Add Event</button>
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

		//
		function select_type(obj){
			if($(obj).val()=="Image"){
				$(obj).parent().next().find( ".d_source" ).replaceWith( '<input type="file" class="form-control d_source" name="d_source" />' );
			}
			else{
				$(obj).parent().next().find( ".d_source" ).replaceWith( '<input type="text" class="form-control d_source" name="d_source" />' );
			}
		}
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>