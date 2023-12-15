 <!-- Left side column. contains the sidebar -->

<?php  
ob_start();
include("includes/conn.php"); 
//
$salesno=$_GET['sno'];

$sql="select * from `".TB_pre."sales`  WHERE `sales_no`= $salesno";
$r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));


$quantity_sum = "select sum(quantity) from `".TB_pre."sales` WHERE `sales_no`= $salesno";
$sum_quantity = mysqli_query($url, $quantity_sum);
$total_quantity = mysqli_fetch_array($sum_quantity);

?>
  

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->


        <!-- Main content -->
        <section class="content">

          <!-- Default box -->
          <div class="box">

            
         <center>
 <div id="DivIdToPrint">  <div class="box-body">
				<?php 
					$res_pur=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."sales` WHERE `sales_no`=$salesno" ));
					$res_sup=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."brands` WHERE `brand_id`=$res_pur->customer"));
				?>
 <table style="font-family: Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif';" width="790" cellpadding="5">
	 <tr><td></td></tr>
<tr><td><table width="750" align="center">
	<tr>
	<td align="center">
		<img src="dist/img/dosita-middle-east.jpg" class="img-responsive" >
		<!--<h1 style="text-align: center;">AL SADARA</h1>-->
		
		</td>
</tr>
 </table>
<table style="font-family: Cambria, 'Hoefler Text', 'Liberation Serif', Times, 'Times New Roman', 'serif'" width="750" align="center">
	
<tr><td><table width="50%">
	<tr>
		<th style="text-align: left;">Sales No:</th>
		<td style="text-align: left;"><?php echo $res_pur->sales_no; ?></td>
	</tr>
	<tr>
		<th style="text-align: left;">Customer:</th>
		<td style="text-align: left;"><?php echo $res_sup->brand_name; ?></td>
	</tr>
	<tr>
		<th style="text-align: left;">Invoice date:</th>
		<td style="text-align: left;"><?php echo $res_pur->sale_date; ?></td>
	</tr>
</table>
	</td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
</table>
	
              <table width="750" align="center" style="border: 1px solid #000000; border-collapse: collapse;" cellpadding="5" border="1" bordercolorlight="#7C7C7C">
	<thead>
	<tr style="background: #fff; color: #000; font-weight: bold; text-align: left;">
		<th>SI No.</th>
		<th>Product code</th>
		<th>Product Name</th>
		<th>Unit Price (AED)</th>
		<th>Quantity</th>
		<th>Total (AED)</th>
	</tr>
	</thead>
	<tbody>
		<?php 
			$i = 1;
			while($res = mysqli_fetch_object($r1)){ 
			$product_id=$res->product_id;			
			$res_product=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."products` WHERE `product_id`=$product_id"));
			$unit_price=round($res->unit_price, 2);
			//$unit_price=$res_pur->quantity*$res_pur->unit_price;
		?>
	<tr>
		<td><?php echo $i++; ?></td>
		<td><?php echo $res_product->product_code; ?></td>
		<td><?php echo $res_product->product_name; ?></td>
		<td><?php echo $unit_price; ?></td>
		<td><?php echo $res->quantity; ?></td>
		<td class="total"><?php echo round(($unit_price*$res->quantity), 2); ?></td>
	</tr>
<?php } ?>
		<tr>
		<th colspan="4"> <strong style="font-size: 18px;"><div id="sumwords"></div></strong></th>
		<th><strong style="font-size: 18px;">Total</strong></th>
		<td ><div id="sum" style="font-size: 22px; font-weight: bold;"></div></td>
	</tr>

	</tbody>
</table>
	<br>
<br>

<!--	<table width="750" align="center" style="border: 1px solid #000000; border-collapse: collapse;" cellpadding="5" border="1" bordercolorlight="#7C7C7C">
	<tbody>
		
	<tr>
		<th colspan="4">Total</th>
		<td ><div id="sum"></div></td>
	</tr>

	</tbody>
</table>-->
	
	</td></tr>
	 <tr><td></td></tr>
</table>
	 
	 </div>
<input type='button' id='btn' value='Print' onclick='printDiv();'>	
	 
	 <div class="backbutton">
	<button style="margin-top: 50px;"><a style="text-decoration: none; color: #828282;" href="sales_report.php?sno=<?php  echo $salesno; ?>">Go Back</a></button>
</div>
</center>

            </div><!-- /.box-body -->
            
     
          </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

    
  </body>
</html>
<?php include_once('includes/footer-scripts.php'); ?>     
<!--<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>-->
<script>

	$(document).ready(function(){
		
  var sum = 0;
  $(".total").each(function(){
    sum += parseFloat($(this).text());
  });
  $('#sum').text(sum.toFixed(2));


		
												   
	});
	
</script>

<script>
	function convertNumberToWords(amount) {
    var words = new Array();
    words[0] = '';
    words[1] = 'One';
    words[2] = 'Two';
    words[3] = 'Three';
    words[4] = 'Four';
    words[5] = 'Five';
    words[6] = 'Six';
    words[7] = 'Seven';
    words[8] = 'Eight';
    words[9] = 'Nine';
    words[10] = 'Ten';
    words[11] = 'Eleven';
    words[12] = 'Twelve';
    words[13] = 'Thirteen';
    words[14] = 'Fourteen';
    words[15] = 'Fifteen';
    words[16] = 'Sixteen';
    words[17] = 'Seventeen';
    words[18] = 'Eighteen';
    words[19] = 'Nineteen';
    words[20] = 'Twenty';
    words[30] = 'Thirty';
    words[40] = 'Forty';
    words[50] = 'Fifty';
    words[60] = 'Sixty';
    words[70] = 'Seventy';
    words[80] = 'Eighty';
    words[90] = 'Ninety';
    amount = amount.toString();
    var atemp = amount.split(".");
    var number = atemp[0].split(",").join("");
    var n_length = number.length;
    var words_string = "";
    if (n_length <= 9) {
        var n_array = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0);
        var received_n_array = new Array();
        for (var i = 0; i < n_length; i++) {
            received_n_array[i] = number.substr(i, 1);
        }
        for (var i = 9 - n_length, j = 0; i < 9; i++, j++) {
            n_array[i] = received_n_array[j];
        }
        for (var i = 0, j = 1; i < 9; i++, j++) {
            if (i == 0 || i == 2 || i == 4 || i == 7) {
                if (n_array[i] == 1) {
                    n_array[j] = 10 + parseInt(n_array[j]);
                    n_array[i] = 0;
                }
            }
        }
        value = "";
        for (var i = 0; i < 9; i++) {
            if (i == 0 || i == 2 || i == 4 || i == 7) {
                value = n_array[i] * 10;
            } else {
                value = n_array[i];
            }
            if (value != 0) {
                words_string += words[value] + " ";
            }
            if ((i == 1 && value != 0) || (i == 0 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Crores ";
            }
            if ((i == 3 && value != 0) || (i == 2 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Hundred ";
            }
            if ((i == 5 && value != 0) || (i == 4 && value != 0 && n_array[i + 1] == 0)) {
                words_string += "Thousand ";
            }
            if (i == 6 && value != 0 && (n_array[i + 1] != 0 && n_array[i + 2] != 0)) {
                words_string += "Hundred ";
            } else if (i == 6 && value != 0) {
                words_string += "Hundred ";
            }
        }
        words_string = words_string.split("  ").join(" ");
    }
    return words_string;
}

	function withDecimal(n) {
    var nums = n.toString().split('.')
    var whole = convertNumberToWords(nums[0])
    if (nums.length == 2) {
        var fraction = convertNumberToWords(nums[1])
        return whole + 'and ' + fraction;
    } else {
        return whole;
    }
}
	

	$(document).ready(function(){
		
  var sum = 0;
  $(".total").each(function(){
    sum += parseFloat($(this).text());
  });
  $('#sum').text(sum.toFixed(2));
 $('#sumwords').text(withDecimal(sum.toFixed(2)));


		
												   
	});
	
</script>

<script>
function printDiv() 
{

  var divToPrint=document.getElementById('DivIdToPrint');

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}
	$(document).ready(function(){
		


		
												   
	});
	
</script>