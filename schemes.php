<?php $active="schemes"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>


 <!-- Left side column. contains the sidebar -->
 <?php include_once('includes/side_bar.php'); ?>

<?php  

if(isset($_GET['remove_sc'])){
	$id = $_GET['remove_sc'];
	$s_img_res=mysqli_fetch_object(mysqli_query($url,"select scheme_img from `".TB_pre."schems` WHERE `scheme_id`='$id'"));
	$query = "DELETE FROM `".TB_pre."schems` WHERE `scheme_id`='$id'";
	$r = mysqli_query($url, $query) or die(mysqli_error($url));
	unlink( "uploads/".$s_img_res->scheme_img);
	if($r){
		$msg = "The selected scheme deleted successfully.";
	}
}
$sql="select * from `".TB_pre."schems` ";
$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));

?>  

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Schemes
            <small></small>
          </h1>
          
          <ol class="breadcrumb">
            <li><a href="add-scheme.php" class="btn btn-block"><i class="fa fa-plus"></i> Add new Scheme</a></li>
          </ol>
          
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List - Schemes</h3> 
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
                      	<th>Image</th>
                        <th>Scheme</th>
                        <th colspan="2">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					$i = 1;
					while($res = mysqli_fetch_array($r1)){ ?>
                      <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php
						 if($res['scheme_img']!=""){ ?>
                      <img src="uploads/<?php echo $res['scheme_img']; ?>" width="200" />
                      <?php } else{ echo "No-image";} ?>
						 </td>
                        <td><?php echo $res['scheme_title']; ?></td>
                        <td><a href="edit-scheme.php?scheme_id=<?php echo $res['scheme_id']; ?>" class="btn btn-primary" title="">Edit</a></td>
                        <td><a href="javascript:removeItem(<?php echo $res['scheme_id']; ?>);" class="btn btn-danger">Remove</a></td>
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
			location = "schemes.php?remove_sc="+id;
		}
	}
	
    </script>
    
  </body>
</html>
<?php ob_end_flush(); ?>