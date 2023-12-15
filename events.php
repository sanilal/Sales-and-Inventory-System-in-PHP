<?php $active="events"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>


 <!-- Left side column. contains the sidebar -->
 <?php include_once('includes/side_bar.php'); ?>

<?php  
if(isset($_GET['remove_cat'])){
	$id = $_GET['remove_cat'];
	$query = "DELETE FROM `".TB_pre."events` WHERE `event_id`='$id'";
	$r = mysqli_query($url, $query) or die(mysqli_error($url));
	//unlink( "path_to_your_upload_directory/".$staff_id.".jpg" );
	if($r){
		mysqli_query($url, "DELETE FROM `".TB_pre."event_datas` WHERE `event`='$id'");
		$msg = "The selected event successfully.";
	}
}
$sql="select * from `".TB_pre."events` ORDER BY event_type ASC";
$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));

?>  

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Events
            <small></small>
          </h1>
          
          <ol class="breadcrumb">
            <li><a href="add-event.php" class="btn btn-block"><i class="fa fa-plus"></i> Add new Event</a></li>
          </ol>
          
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List - Events</h3> 
              <?php if(isset($msg)){ ?>
              	<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> <?php echo $msg; ?></h4>
               	</div>
               <?php } ?> 
            </div>
            
            <div class="box-body">
                  <table id="example2" class="table table-bordered table-hover">
                    <thead>
                      <tr>
                      <th>Sl. No</th>
                        <th>Event</th>
                        <th>Image</th>
                        <th colspan="2">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					$i = 1;
					while($res = mysqli_fetch_array($r1)){ ?>
                      <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $res['event_name']; ?></td>
                        <td>
                        <?php if($res['event_img']!=""){ ?>
                        <img src="uploads/<?php echo $res['event_img'] ?>" width="200" />
						<?php } else{ echo "No-image"; }?>
                        
                        </td>
                        
                        <td><a href="edit-event.php?event_id=<?php echo $res['event_id']; ?>" class="btn btn-primary" title="">Edit</a></td>
                        <td><a href="javascript:removeItem(<?php echo $res['event_id']; ?>);" class="btn btn-danger">Remove</a></td>
                      </tr>
                      <?php }?>
                    </tbody>
                    <tfoot>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
            <div class="box-footer">
            
            </div><!-- /.box-footer-->
          </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

     
      <!-- Control Sidebar -->


	<?php include_once('includes/footer.php'); ?>
    <!-- jQuery 2.1.4 -->
   <?php include_once('includes/footer-scripts.php'); ?>
    
    
    <!-- AdminLTE for demo purposes -->
     <script>
      $(function () {
        $('#example2').DataTable({
          "paging": true,
          "lengthChange": false,
          "searching": false,
          "ordering": true,
          "info": true,
          "autoWidth": false
        });
      });
    </script>
    <script type="text/javascript">
    function removeItem(id){
		var c= confirm("Do you want to remove this item?");
		if(c){
			location = "events.php?remove_cat="+id;
		}
	}
	
    </script>
  </body>
</html>
<?php ob_end_flush(); ?>