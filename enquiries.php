<?php $active="enquiries"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>


 <!-- Left side column. contains the sidebar -->
 <?php include_once('includes/side_bar.php'); ?>

<?php  

if(isset($_GET['remove_eq'])){
	$id = $_GET['remove_eq'];
	
	$query = "DELETE FROM `".TB_pre."product_enq` WHERE `enq_id`='$id'";
	$r = mysqli_query($url, $query) or die(mysqli_error($url));
	if($r){
		$msg = "The Enquiry deleted successfully.";
	}
}
$sql="select * from `".TB_pre."product_enq` ORDER BY enq_id DESC";
$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));

?>  

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            View Enquiries
            <small></small>
          </h1>
          
          
          
        </section>

        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">List - Enquiries</h3> 
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
                      	<th>Name</th>
                        <th>Product</th>
                        <th>Subject</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th >Action</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php 
					$i = 1;
					while($res = mysqli_fetch_array($r1)){ ?>
                      <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $res["name"]; ?></td>
                        <?php
						$pr_name=mysqli_fetch_object(mysqli_query($url,"select product_name from `".TB_pre."products` WHERE product_id=".$res['product_id']));
						?>
                        <td><a href="../product.php?pr_id=<?php echo $res['product_id']; ?>" target="_blank" ><?php echo $pr_name->product_name; ?></a></td>
                        <td><?php echo $res["subject"]; ?></td>
                        <td><?php echo $res["email"]; ?></td>
                        <td><?php echo $res["mobile"]; ?></td>
                        <td><?php echo $res["message"]; ?></td>
                        <td><a href="javascript:removeItem(<?php echo $res['enq_id']; ?>);" class="btn btn-danger">Remove</a></td>
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
			location = "enquiries.php?remove_eq="+id;
		}
	}
	
    </script>
  </body>
</html>
<?php ob_end_flush(); ?>