<?php $active="brands"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>


 <!-- Left side column. contains the sidebar -->
 <?php include_once('includes/side_bar.php'); ?>

<?php  

if(isset($_GET['remove_ms'])){
	$id = $_GET['remove_ms'];
	$s_img_res=mysqli_fetch_object(mysqli_query($url,"select series_img from `".TB_pre."brand_model_series` WHERE `series_id`='$id'"));
	unlink( "uploads/".$s_img_res->brand_logo);
	$query = "DELETE FROM `".TB_pre."brand_model_series` WHERE `series_id`='$id'";
	$r = mysqli_query($url, $query) or die(mysqli_error($url));
	
	if($r){
		$msg = "The selected Model Series deleted successfully.";
	}
}
$sql="select * from `".TB_pre."brand_model_series` ";
$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));

?>  

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Model Series
            <small></small>
          </h1>
          
          <ol class="breadcrumb">
            <li><a href="add-series.php" class="btn btn-block"><i class="fa fa-plus"></i> Add new Series</a></li>
          </ol>
          
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List - Series</h3> 
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
                      	<th>Series</th>
                        <th>Brand-> Model</th>
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
                         <td><?php echo $res['series_name']; ?></td>
                          <td><?php 
						  $model=mysqli_fetch_object(mysqli_query($url,"SELECT model_name,brand_id FROM `".TB_pre."brand_models` WHERE model_id=".$res['model_id']));
						 echo mysqli_fetch_object(mysqli_query($url,"SELECT brand_name FROM `".TB_pre."brands` WHERE brand_id=".$model->brand_id))->brand_name;
						 echo "-> ";
						  echo $model->model_name; 
						  ?></td>
                        <td><?php
						 if($res['series_img']!=""){ ?>
                      <img src="uploads/<?php echo $res['series_img']; ?>" width="200" />
                      <?php } else{ echo "No-image";} ?>
						 </td>
                        <td><a href="edit-series.php?series_id=<?php echo $res['series_id']; ?>" class="btn btn-primary" title="">Edit</a></td>
                        <td><a href="javascript:removeItem(<?php echo $res['series_id']; ?>);" class="btn btn-danger">Remove</a></td>
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
          "searching": true,
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
			location = "models.php?remove_ms="+id;
		}
	}
	
    </script>
    
  </body>
</html>
<?php ob_end_flush(); ?>