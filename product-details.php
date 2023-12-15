<?php $active="products"; ?>
<?php
	ob_start();
	include("includes/conn.php"); 
?>
<?php include_once('includes/header.php'); ?>

      <!-- Left side column. contains the sidebar -->
<?php include_once('includes/side_bar.php'); ?>

<?php  

$pr_res=mysqli_fetch_object(mysqli_query($url,"select * from `".TB_pre."products` WHERE `product_id`=".$_GET['product_id']));
?>
  
  <style type="text/css">
  	.grey-img{ opacity:0.4;}
  </style>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Product Details
          </h1>
          
          <ol class="breadcrumb">
            <li><a href="products.php" class="btn btn-block"><i class="fa fa-eye"></i>View Products</a></li>
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
              <form role="form" method="post"  class="form-horizontal" action="" enctype="multipart/form-data" id="product_form">
                  <div class="box-body">
                  
                  	
					<div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 m-r-0">
                      <label>Product Description</label>
                      <input type="text" readonly class="form-control" placeholder="Product Name" name="product" id="product" value="<?php echo $pr_res->product_name; ?>" />
                    </div>
					 <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0">
                      <label>Product Code</label>
                      <input type="text" readonly class="form-control" placeholder="Cat No" name="product_code" id="product_code" value="<?php echo $pr_res->product_code; ?>" />
                    </div>
                    <div class="form-group col-lg-6 col-md-6 col-sm-6 col-xs-12 m-r-0" style="padding-right: 0;">
                      <label>Product Category</label>
                      <select class="form-control" name="productmenu" id="productmenu" required disabled >
                      	<option value="">Select</option>
                        <?php 
						$res_cat=mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE `parent_cat`=0 ");
						while($row=mysqli_fetch_object($res_cat)){
						?>
                        <option value="<?php echo $row->cat_id; ?>" <?php if($pr_res->category==$row->cat_id){ echo 'selected="selected"';} ?> > <?php echo $row->cat_name; ?></option>
                        <?php 
						$ch_q=mysqli_query($url,"SELECT * FROM `".TB_pre."pcategories` WHERE `parent_cat`=".$row->cat_id);
						while($ch_row=mysqli_fetch_object($ch_q)){ ?>
                        <option value="<?php echo $ch_row->cat_id; ?>"<?php if($pr_res->category==$ch_row->cat_id){ echo 'selected="selected"';} ?> >-- <?php echo $ch_row->cat_name; ?></option>
                      	<?php } ?>
                      	<?php } ?>
                      </select>
                    </div>
					 <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12 m-r-0">
                      <label>Product Image</label>
                      <?php if($pr_res->product_img!=""){ ?>
                      <img src="uploads/<?php echo $pr_res->product_img; ?>" width="200" />
                      <?php } ?>
                      <!--<input type="file" class="form-control" placeholder="Product Image" name="productimg" id="productimg" />
                      <input type="hidden" name="old_img" value="<?php // echo $pr_res->product_img; ?>" />-->
                    </div>
                    
                    <div class="row">
					<!-- <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>Supplier</label>
                      <select class="form-control" name="brand" id="product_brand" >
                      	<option value="">Select</option>
                        <?php 
						$res_br=mysqli_query($url,"SELECT * FROM `".TB_pre."brands`");
						while($row_br=mysqli_fetch_object($res_br)){
						?>
                        <option value="<?php echo $row_br->brand_id; ?>" <?php if($pr_res->manufacture==$row_br->brand_id){ echo 'selected="selected"';} ?>><?php echo $row_br->brand_name; ?></option>
                        <?php    
						}
						?>
                        </select>
                    </div>-->
                  
                    
                   <!-- <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>Quantity</label>
                      <input type="number" class="form-control" placeholder="Stocks" name="product_stock" id="product_stock" value="<?php //echo $pr_res->stocks; ?>" />
                    </div>-->
					<!--<div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0">
                      <label>Shipping / Other Charges(AED)</label>
                      <input type="number" class="form-control" placeholder="Shipping / Other Charges" min="1" step="any" name="shipping_charges" id="shipping_charges" value="<?php //echo $pr_res->shipping_charges; ?>" />
                    </div>-->
					</div>
					  
                    <!--<div class="row price-section">
                    <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0" >
                      <label>Price</label>
                      <input type="text" class="form-control" placeholder="Price" name="original_price" id="original_price" value="<?php echo $pr_res->purchased_price; ?>" />
                    </div>
					 
					  <div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0" >
                        </select>
						  
						  
						  <label>Currency</label>
							  <select class="form-control" name="currency" id="currency" required >
							<option value="">Select</option>
							<?php 
							//$res_currency=mysqli_query($url,"SELECT * FROM `".TB_pre."currency` ORDER BY `currency` ASC");
							//while($row=mysqli_fetch_object($res_currency)){
							?>
							<option value="<?php //echo $row->code; ?>"<?php  //if($pr_res->currency==$row->code){echo 'selected="selected"';}?>><?php //echo $row->currency; ?></option>
						

							<?php //} ?>
						  </select>
						</div>
				  		<div class="form-group col-lg-4 col-md-4 col-sm-6 col-xs-12 m-r-0" >
                        </select>
						  
						  
						  <label>Converted Value (AED)</label>
				  			 <input type="text" class="form-control" placeholder="converted Price" name="convertedPrice" id="convertedPrice" value="<?php //echo $pr_res->converted_price; ?>" />
							 
						</div>
			  </div>-->
                    
                    <!--<div class="form-group col-sm-4">
                      <label>Featured product</label>
                      <input type="checkbox" name="featured" value="1" <?php //if($pr_res->featured==1){ echo "checked='checked'";} ?> /> yes
                    </div>-->
                   <!-- <div class="form-group col-sm-4">
                      <label>Special product</label>
                      <input type="checkbox" name="special" value="1" <?php //if($pr_res->special==1){ echo "checked='checked'";} ?> /> yes
                    </div>-->
                     <!--<div class="form-group col-sm-4">
                      <label>Special-Offer</label>
                      <input type="checkbox" name="spl_offer" value="1" <?php //if($pr_res->spl_offer==1){ echo "checked='checked'";} ?> /> yes
                    </div>-->
                     <!--<div class="form-group" style="display:none">
                      <label>Product attributes</label>
                      <textarea class="form-control" placeholder="Product Attributes" name="productattr" id="productattr"> <?php // echo $pr_res->p_attr; ?></textarea>
                    </div>
                    <div class="form-group">
                      <label>Product Description</label>
                      <textarea class="form-control" placeholder="Product Description" name="productdesc" id="productdesc"> <?php echo $pr_res->p_desc; ?></textarea>
                    </div>-->
                    
                    
                    <div class="col-md-12" style="padding-left: 0; padding-right: 30px;"><table class="center-table">
                        <tr>
                            <th style="width: 80px !important;">No.</th>
                            <th>Order No</th>
							<th>Supplier</th>
                            <th>Price(AED)</th>
                            <th>Quantity</th>
                        </tr>
                        <?php 
                        $prId=$pr_res->product_id;
                       
                
                        $sql="select * from `".TB_pre."purchase`  WHERE product_id=$prId";
                        $r1=mysqli_query($url,$sql) or die("Failed".mysqli_error($url));
						
						/*
						$pmr1=mysqli_query($url,$purchase_master_sql) or die("Failed".mysqli_error($url));
						$pmres = mysqli_fetch_array($pmr1);
						*/
						
					$i = 1;
					while($res = mysqli_fetch_array($r1)){ ?>
                      <tr>
                        <td style="width: 80px !important;"><?php echo $i++; ?></td>
						 <td ><?php echo $res['purchase_no']; ?></td>
                        <td><?php 
								$purchaseno=$res['purchase_no']; 
								$purchase_master_sql=mysqli_query($url,"select * from `".TB_pre."purchase_master`  WHERE purchase_no=$purchaseno");
								$p_master=mysqli_fetch_object($purchase_master_sql);
								$manufacturer=$p_master->supplier_id;
								$conversion_ratio = $p_master->conversion_ratio;
								$unit_price=round($res['purchased_price']*$conversion_ratio, 2);
								$shippingcP=$p_master->shipping;
								$shippingc= round((($unit_price*$res['quantity'])*($shippingcP/100))/$res['quantity'], 2);
								$customscP=$p_master->customs;
								$customsc= round((($unit_price*$res['quantity'])*($customscP/100))/$res['quantity'], 2); 
								$handlingcP=$p_master->handling;
								$handlingc= round((($unit_price*$res['quantity'])*($handlingcP/100))/$res['quantity'], 2); 
								$netunitprice=$unit_price+$shippingc+$customsc+$handlingc;
								$res_cat=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."brands` WHERE brand_id=$manufacturer"));
								echo $res_cat->brand_name;  ?></td>
                        
                        <td><?php 
                        echo  round($netunitprice,2); 
                        
                        ?></td>
                        
                        <td><?php 
						  // $purchase_q="
              //             SELECT sum(quantity) FROM `".TB_pre."purchase` WHERE `product_id`=$prId
              //            ";
              //              $purchaseresult = mysqli_query($url, $purchase_q);
              //              $purchasestock = mysqli_fetch_array($purchaseresult);
              //              $tot_purchasestock = $purchasestock['sum(quantity)'];
                           
              //              $sales_quantity_q="
              //             SELECT sum(quantity) FROM `".TB_pre."sales` WHERE `product_id`=$prId
              //            ";
              //              $sales_quantity_result = mysqli_query($url, $sales_quantity_q);
              //              $salesstock = mysqli_fetch_array($sales_quantity_result);
              //              $tot_salestock = $salesstock['sum(quantity)'];
              //              $totalstock = $tot_purchasestock-$tot_salestock;
              //              echo $totalstock;
              $purchaseid=$res['id'];
                        $sales_q=mysqli_fetch_object(mysqli_query($url,"SELECT * FROM `".TB_pre."sales` WHERE purchase_id=$purchaseid"));
                        //echo $sales_q->quantity;
                            //print_r("SELECT * FROM `".TB_pre."sales` WHERE purchase_id=$purchaseid");
                          $available=$res['quantity']-$sales_q->quantity;
                           echo $available;
					
						?></td>
                      </tr>
                      <?php }?>
                  </table></div>

                    <div style="display:none">
                    <?php 
						$g_imgs=explode(",",$pr_res->gallery_imgs); 
						//var_dump($g_imgs);
						$pr_name=str_replace(' ', '_', $pr_res->product_name);
					?>
                    
                    <div class="form-group col-sm-4">
                      <label>Product Image1(optional)</label>
                      <?php if(in_array($pr_name."g_img1.jpg",$g_imgs)){ ?>
                      <img src="uploads/<?php echo $pr_name."g_img1.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl1" value="<?php echo $pr_name."g_img1.jpg"; ?>" />
                      <button type="button" onClick="hideImg(this)">Hide</button>
					  <?php } elseif(in_array("HIDE".$pr_name."g_img1.jpg",$g_imgs)) { ?>
                      <img class="grey-img" src="uploads/<?php echo $pr_name."g_img1.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl1" value="<?php echo "HIDE".$pr_name."g_img1.jpg"; ?>" />
                      <button type="button" onClick="showImg(this)">Show</button>
                      <?php } ?>
                      <input type="file" class="form-control" placeholder="Product Image1" name="productimg1" id="productimg1" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image2(optional)</label>
                      <?php if(in_array($pr_name."g_img2.jpg",$g_imgs)){ ?>
                      <img src="uploads/<?php echo $pr_name."g_img2.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl2" value="<?php echo $pr_name."g_img2.jpg"; ?>" />
                      <button type="button" onClick="hideImg(this)">Hide</button>
					  <?php } elseif(in_array("HIDE".$pr_name."g_img2.jpg",$g_imgs)) { ?>
                      <img class="grey-img" src="uploads/<?php echo $pr_name."g_img2.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl2" value="<?php echo "HIDE".$pr_name."g_img2.jpg"; ?>" />
                      <button type="button" onClick="showImg(this)">Show</button>
                      <?php } ?>
                      <input type="file" class="form-control" placeholder="Product Image2" name="productimg2" id="productimg2" />
                    </div>
                    
                    <div class="form-group col-sm-4">
                      <label>Product Image3(optional)</label>
                      <?php if(in_array($pr_name."g_img3.jpg",$g_imgs)){ ?>
                      <img src="uploads/<?php echo $pr_name."g_img3.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl3" value="<?php echo $pr_name."g_img3.jpg"; ?>" />
                      <button type="button" onClick="hideImg(this)">Hide</button>
					  <?php } else if(in_array("HIDE".$pr_name."g_img3.jpg",$g_imgs)){ ?>
                      <img class="grey-img" src="uploads/<?php echo $pr_name."g_img3.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl3" value="<?php echo "HIDE".$pr_name."g_img3.jpg"; ?>" />
				      <button type="button" onClick="showImg(this)">Show</button>
                      <?php } ?>
                      <input type="file" class="form-control" placeholder="Product Image3" name="productimg3" id="productimg3" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image4(optional)</label>
                      <?php if(in_array($pr_name."g_img4.jpg",$g_imgs)){ ?>
                      <img src="uploads/<?php echo $pr_name."g_img4.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl4" value="<?php echo $pr_name."g_img4.jpg"; ?>" />
                      <button type="button" onClick="hideImg(this)">Hide</button>
					  <?php } else if(in_array("HIDE".$pr_name."g_img4.jpg",$g_imgs)){ ?>
                      <img class="grey-img" src="uploads/<?php echo $pr_name."g_img4.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl4" value="<?php echo "HIDE".$pr_name."g_img4.jpg"; ?>" />
                      <button type="button" onClick="showImg(this)">Show</button>
					  <?php } ?>
                      <input type="file" class="form-control" placeholder="Product Image4" name="productimg4" id="productimg4" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image5(optional)</label>
                      <?php if(in_array($pr_name."g_img5.jpg",$g_imgs)){ ?>
                      <img src="uploads/<?php echo $pr_name."g_img5.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl5" value="<?php echo $pr_name."g_img5.jpg"; ?>" />
                      <button type="button" onClick="hideImg(this)">Hide</button>
					  <?php } else if(in_array("HIDE".$pr_name."g_img5.jpg",$g_imgs)){ ?>
                      <img class="grey-img" src="uploads/<?php echo $pr_name."g_img5.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl5" value="<?php echo "HIDE".$pr_name."g_img5.jpg"; ?>" />
                      <button type="button" onClick="showImg(this)">Show</button>
					  <?php } ?>
                      <input type="file" class="form-control" placeholder="Product Image5" name="productimg5" id="productimg5" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image6(optional)</label>
                      <?php if(in_array($pr_name."g_img6.jpg",$g_imgs)){ ?>
                      <img src="uploads/<?php echo $pr_name."g_img6.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl6" value="<?php echo $pr_name."g_img6.jpg"; ?>" />
                      <button type="button" onClick="hideImg(this)">Hide</button>
					  <?php } else if(in_array("HIDE".$pr_name."g_img6.jpg",$g_imgs)){ ?>
                      <img class="grey-img" src="uploads/<?php echo $pr_name."g_img6.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl6" value="<?php echo "HIDE".$pr_name."g_img6.jpg"; ?>" />
                      <button type="button" onClick="showImg(this)">Show</button>
					  <?php } ?>
                      <input type="file" class="form-control" placeholder="Product Image6" name="productimg6" id="productimg6" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image7(optional)</label>
                     <?php if(in_array($pr_name."g_img7.jpg",$g_imgs)){ ?>
                      <img src="uploads/<?php echo $pr_name."g_img7.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl7" value="<?php echo $pr_name."g_img7.jpg"; ?>" />
                      <button type="button" onClick="hideImg(this)">Hide</button>
					  <?php } else if(in_array("HIDE".$pr_name."g_img7.jpg",$g_imgs)){ ?>
                      <img class="grey-img" src="uploads/<?php echo $pr_name."g_img7.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl7" value="<?php echo "HIDE".$pr_name."g_img7.jpg"; ?>" />
                      <button type="button" onClick="showImg(this)">Show</button>
					  <?php } ?>
                      <input type="file" class="form-control" placeholder="Product Image7" name="productimg7" id="productimg7" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image8(optional)</label>
                      <?php if(in_array($pr_name."g_img8.jpg",$g_imgs)){ ?>
                      <img src="uploads/<?php echo $pr_name."g_img8.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl8" value="<?php echo $pr_name."g_img8.jpg"; ?>" />
                      <button type="button" onClick="hideImg(this)">Hide</button>
					  <?php } else if(in_array("HIDE".$pr_name."g_img8.jpg",$g_imgs)){ ?>
                      <img class="grey-img" src="uploads/<?php echo $pr_name."g_img8.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl8" value="<?php echo "HIDE".$pr_name."g_img8.jpg"; ?>" />
                      <button type="button" onClick="showImg(this)">Show</button>
					  <?php } ?>
                      <input type="file" class="form-control" placeholder="Product Image8" name="productimg8" id="productimg8" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image9(optional)</label>
                     <?php if(in_array($pr_name."g_img9.jpg",$g_imgs)){ ?>
                      <img src="uploads/<?php echo $pr_name."g_img9.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl9" value="<?php echo $pr_name."g_img9.jpg"; ?>" />
                      <button type="button" onClick="hideImg(this)">Hide</button>
					  <?php } else if(in_array("HIDE".$pr_name."g_img9.jpg",$g_imgs)){ ?>
                      <img class="grey-img" src="uploads/<?php echo $pr_name."g_img9.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl9" value="<?php echo "HIDE".$pr_name."g_img9.jpg"; ?>" />
                      <button type="button" onClick="showImg(this)">Show</button>
					  <?php } ?>
                      <input type="file" class="form-control" placeholder="Product Image9" name="productimg9" id="productimg9" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image10(optional)</label>
                      <?php if(in_array($pr_name."g_img10.jpg",$g_imgs)){ ?>
                      <img src="uploads/<?php echo $pr_name."g_img10.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl10" value="<?php echo $pr_name."g_img10.jpg"; ?>" />
                      <button type="button" onClick="hideImg(this)">Hide</button>
					  <?php } else if(in_array("HIDE".$pr_name."g_img10.jpg",$g_imgs)){ ?>
                      <img class="grey-img" src="uploads/<?php echo $pr_name."g_img10.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl10" value="<?php echo "HIDE".$pr_name."g_img10.jpg"; ?>" />
                      <button type="button" onClick="showImg(this)">Show</button>
					  <?php } ?>
                      <input type="file" class="form-control" placeholder="Product Image10" name="productimg10" id="productimg10" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image11(optional)</label>
                      <?php if(in_array($pr_name."g_img11.jpg",$g_imgs)){ ?>
                      <img src="uploads/<?php echo $pr_name."g_img11.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl11" value="<?php echo $pr_name."g_img11.jpg"; ?>" />
                      <button type="button" onClick="hideImg(this)">Hide</button>
					  <?php } else if(in_array("HIDE".$pr_name."g_img11.jpg",$g_imgs)){ ?>
                      <img class="grey-img" src="uploads/<?php echo $pr_name."g_img11.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl11" value="<?php echo "HIDE".$pr_name."g_img11.jpg"; ?>" />
                      <button type="button" onClick="showImg(this)">Show</button>
					  <?php } ?>
                      <input type="file" class="form-control" placeholder="Product Image11" name="productimg11" id="productimg11" />
                    </div>
                    <div class="form-group col-sm-4">
                      <label>Product Image12(optional)</label>
                      <?php if(in_array($pr_name."g_img12.jpg",$g_imgs)){ ?>
                      <img src="uploads/<?php echo $pr_name."g_img12.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl12" value="<?php echo $pr_name."g_img12.jpg"; ?>" />
                      <button type="button" onClick="hideImg(this)">Hide</button>
					  <?php } else if(in_array("HIDE".$pr_name."g_img12.jpg",$g_imgs)){ ?>
                      <img class="grey-img" src="uploads/<?php echo $pr_name."g_img12.jpg"; ?>" width="200" />
                      <input type="hidden" name="olg_gl12" value="<?php echo "HIDE".$pr_name."g_img12.jpg"; ?>" />
                      <button type="button" onClick="showImg(this)">Show</button>
					  <?php } ?>
                      <input type="file" class="form-control" placeholder="Product Image12" name="productimg12" id="productimg12" />
                    </div>
                    </div>
                   <!-- <div class="form-group" >
                      <label>Order</label>
                      <input type="number" class="form-control" placeholder="Order" name="order" value="<?php echo $pr_res->p_order; ?>" />
                    </div>-->
                  </div><!-- /.box-body -->

                 <!-- <div class="box-footer">
                     <button type="submit" class="btn btn-primary" name="btnedit" id="submit_button">Update Product</button>
                    <input type="hidden" name="product_id" value="<?php echo $_GET['product_id']; ?>" />
                  </div>-->
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
    CKEDITOR.replace('productdesc');
	CKEDITOR.replace('productattr');

  });
	$(document).ready(function(){
		$('#currency').on('change', function(){
			//alert();
			var originalPrice = $('#original_price').val();
			var origincurrency = $('#currency').val();
			if(originalPrice){
				$.ajax({
					type: 'POST',
					url: 'ajax_currency_conversion.php',
					data:  {oprice : originalPrice, currencyorigin : origincurrency},//'oprice='+originalPrice,
					success:function(html){
						$("#convertedPrice").val(html)
						//$('#convertedPrice').html(html)
					}
				});
			}else{
				$('#convertedPrice')('<input value"No" />');
				
			}
		})
	});
  function hideImg(obj){
		var old_val=$(obj).prev().val();
		$(obj).prev().val("HIDE"+old_val);
		$("#submit_button").trigger("click");
		//$("#product_form").submit();
	}
	function showImg(obj){
		var old_val=$(obj).prev().val();
		$(obj).prev().val(old_val.slice(4));
		$("#submit_button").trigger("click");
		//$("#product_form").submit();
	}
</script>
    
  </body>
</html>
<?php ob_end_flush(); ?>