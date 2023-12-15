<?php $active="purchases"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  

 if(isset($_REQUEST['btnadd'])){
	 
	$brand=$_POST['brand'];	
	$b_url=$_POST['brand_url'];
	$contact_number=$_POST[''];
	$fax=$_POST[''];
	$email=$_POST[''];
	$contact_person=$_POST[''];
	 
	$msg=""; $error="";
	if($brand!=""){
		//
		include_once("classes/class.upload.php");
		
		$b_image=image_upload($_FILES['brand_img'],$brand."logo_img",500);
		//var_dump($p_image); exit;
		//
		
		  //var_dump($num); exit;
		  $query = "INSERT INTO `".TB_pre."brands` (`brand_name`,`contact_number`,`fax`,`email`,`contact_person`,`brand_url`,`brand_logo`) VALUES('$brand','$contact_number','$fax','$email','$contact_person','$b_url','$b_image')";
		  //var_dump($query); exit;
		  $r = mysqli_query($url, $query) or die(mysqli_error($url));
		  if($r){
			  $msg.= "Brand Successfully Added";
		  }
		  else {
			  $error.= "Failed: Error occured";
		  }
	  
	}
	else {
			  $error.= "Failed: Fill all the required fields";
		  }
}
?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Material Out
          </h1>
          
         <!-- <ol class="breadcrumb">
            <li><a href="brands.php" class="btn btn-block"><i class="fa fa-eye"></i>View Suppliers</a></li>
          </ol>-->
        
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
              <div class="row">
				  <div class="col-lg-7 col-md-8 colsm-12 col-xs-12">
				  	<div class="panel panel-default">
					<div class="bs-example">
						<input type="text" name="search_text" id="search_text" placeholder="Search by customer name" class="form-control" />
 
					</div>
				  </div>
				 <div id="result"></div>
				  </div>
					  
				</div>
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
    CKEDITOR.replace('scheme_desc');
  });
	
	$(document).ready(function(){
		 load_data();
		 function load_data(query)
		 {
		  $.ajax({
		   url:"search-customer.php",
		   method:"POST",
		   data:{query:query},
		   success:function(data)
		   {
			$('#result').html(data);
		   }
		  });
		 }
		 $('#search_text').keyup(function(){
		  var search = $(this).val();
		  if(search != '')
		  {
		   load_data(search);
		  }
		  else
		  {
		   load_data();
		  }
		 });
		
		 
		 var html_code = '<tr><td><?php echo $i++; ?></td><td><?php echo $pr_res->product_name; ?></td></tr>';
		var selector = 'section#prcontainer table'; 
		//change selector with where you want to append your html code into..
	/*	$('#result').click(function(){
			alert();
			$(selector).append(html_code);
		});*/
		
		$(document).on("click", '.addProduct', function(event) { 
			
			$(selector).append(html_code);
			//$('.selectcheck').prop('checked', $(this).prop('checked'));
		});
	});
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>