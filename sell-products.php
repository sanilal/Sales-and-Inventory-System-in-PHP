<?php $active="purchases"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>


 <!-- Left side column. contains the sidebar -->
 <?php include_once('includes/side_bar.php'); ?>

<?php  

$brand_id=$_GET['brand_id'];
$pr_res=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."products` WHERE `product_id`=".$_GET['product_id']));



$sql="select * from `".TB_pre."products`  ORDER BY p_order ASC, product_id DESC ";
$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));

?>  

      <!-- =============================================== -->

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Material Out
            <small></small>
          </h1>
          
         <!-- <ol class="breadcrumb">
            <li><a href="add-product.php" class="btn btn-block"><i class="fa fa-plus"></i> Add new Product</a></li>
          </ol>-->
          
        </section>
		  
		 <!-- <section id="prcontainer">
		  	<table>
			  
			  </table>
		  </section>-->

        <!-- Main content -->
        <section class="content">
		
          <!-- Default box -->
          <div class="box" id="sales-wraper">
            <div class="box-header with-border">
              <!--<h3 class="box-title">Sell - Products</h3> -->
              <?php if(isset($msg)){ ?>
              	<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-check"></i> <?php echo $msg; ?></h4>
               	</div>
               <?php } ?> 
            </div>
            
            <div class="box-body">
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12"><h3>Customer : <?php
					$br_res=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."brands` WHERE `brand_id`=".$brand_id));
					echo($br_res->brand_name);
					?></h3>
				<div class="">
					<div class="panel panel-default">
					<div class="bs-example">
						<input type="text" name="search_text" id="search_text" placeholder="Search by product name" class="form-control" />
 
					</div>
				  </div>
				  </div>
				
		  <div id="result"></div>
					
				
				</div>
				<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
					<h3>Selected items</h3>
					<div class="alert alert-error no-items">No Items Selected</div>
					<div class="table-responsive">
					<div class="result-container">
						<form id="sales-form" name="sales-form">
							<table id="slecteddata" class="center-table">
								<tr>
									<!--<th>No.</th>-->
									<th>Code</th>
									<th>Name</th>
									<th>Available Stock</th>
									<th>Required Quantity</th>
									<th>Unit Price</th>
									<th>Remove</th>
								</tr>
							</table>
							<input type="submit" value="SUBMIT" class="btn btn-success" id="salesbutton" >
							</form>
						</div>
					</div>
				</div>
				<div id="details-purchase">
						
					</div>
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

    <script type="text/javascript">
	
		
		
	$(document).ready(function(){
		 load_data();
		 function load_data(query)
		 {
		  $.ajax({
		   url:"search-product.php",
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
	
	
		
		$(document).on("click", '.details-btn', function(event) { 
			var product_id=$(this).data("id");
	
		  $.ajax({
		   url:"ajax-fetch-products.php",
		   method:"POST",
		   data:{query:product_id},
		   success:function(data)
		   {
			$('#details-purchase').html(data);
			$('#details-purchase').addClass('show');
			$('.result-container').addClass('show');
		   }
		  });
		  
			
			// var rowid ="row"+product_id;
			// var rowcontent=$("#"+rowid).clone();
			// rowcontent.appendTo('#slecteddata');
		})
		$(document).on("click", '.purClose', function(event) { 
			$('#details-purchase').removeClass('show');
		})

		$(document).on("click", '.sellthis-btn', function(event) { 
			var product_id=$(this).data("id");
			var rowid = "row"+product_id;
			//alert (rowid);
			$('#slecteddata tr#'+rowid).addClass('ghh');
			if($('#slecteddata tr#'+rowid).hasClass('ghh')) {
				alert("Item already added");
				exit();
			};
			
			var customer_id='<?php echo $brand_id; ?>';
		  $.ajax({
		   url:"ajax-fetch-sell-products.php",
		   method:"POST",
		   data:{query:product_id, customer:customer_id},
		   success:function(data)
		   {
			$('.no-items').addClass('hide');
			$('#slecteddata').addClass('show');
			$('#slecteddata').append(data);
			 /* var count = $('tr.result-row:last-child td.counter').text();
			   alert(count++);*/
			//$('#slecteddata').html(data);
		   }
		  });
		  			
		})

		$(document).on("click", '.delete-btn', function(event) { 
			var prId = $(this).data("id");
			//$('#'.prId).remove();
			$(this).closest("tr").remove();
		})
function stockCheck(){
	//var cid=$(this).
}
$('#sales-form').on('submit', function(event){
  event.preventDefault();
  var salesno = $(".salesNo").val();
  var count_data = 0;
  $('.product_name').each(function(){
   count_data = count_data + 1;
  });
  if(count_data > 0)
  {
   var form_data = $(this).serialize();
   $.ajax({
    url:"ajax-sales-insert.php",
    method:"POST",
    data:form_data,
    success:function(newdata)
    {
     
     //$('#action_alert').html('<p>Data Inserted Successfully</p>');
    // $('#action_alert').dialog('open');
	// $('#sales-wraper').addClass('hide-now');
	 //$('#purcahse_success').removeClass('hide-now');
	 window.location.href = "sales_report.php?sno="+salesno;
    }
   })
  }
  else
  {
   $('#action_alert').html('<p>Please Add atleast one data</p>');
   $('#action_alert').dialog('open');
  }
 });
		
	});
    function removeItem(id){
		var c= confirm("Do you want to remove this?");
		if(c){
			location = "products.php?remove_pr="+id;
		}
	}
	
    </script>
  </body>
</html>
<?php ob_end_flush(); ?>