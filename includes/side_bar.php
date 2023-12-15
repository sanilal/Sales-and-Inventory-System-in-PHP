   <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          
           <div class="user-panel">
            <div class="pull-left image">
              <img src="dist/img/profile-dummy.jpg" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
              <p><a href="profile.php" >Administartor</p>
              <!-- Status -->
              <a href="#"><i class="fa fa-circle text-green"></i> Online</a>
              
            </div>
            
          </div>
          
          
          <ul class="sidebar-menu">
          	
            <li class="header"> <a href="logout.php" ><i class="fa fa-power-off"></i> &nbsp;Sign out</a></li>
            
            <li class="header">MAIN NAVIGATION</li>
            
     <!--        <li class="treeview <?php if($active=="slider"){ echo "active";} ?>">
              <a href="slider.php">
                <i class="fa fa-picture-o"></i>
                <span>Slider</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
               	<ul class="treeview-menu">
                    <li><a href="slider.php"><i class="fa fa-folder-open"></i> View Slider</a></li>
                    <li><a href="add-slider.php"><i class="fa fa-plus-circle"></i> Add Slider image</a></li>
				</ul>
             </li>-->
            <!-- <li class="treeview <?php if($active=="pages"){ echo "active";} ?>">
              <a href="#">
                <i class="fa fa-newspaper-o"></i>
                <span>Pages</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
               	<ul class="treeview-menu">
                    <li><a href="edit-page.php?page_id=1"><i class="fa fa-plus-circle"></i> About Page</a></li>
                    <li><a href="edit-page.php?page_id=2"><i class="fa fa-plus-circle"></i> Contact Page</a></li>
				</ul>
             </li>-->
        <?php /*?>     <li class="treeview <?php if($active=="sections"){ echo "active";} ?>">
              <a href="#">
                <i class="fa fa-newspaper-o"></i>
                <span>Sections</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
                  <li>
                        <a href="edit-section.php?section_id=1">
                            <i class="fa fa-braille"></i>
                            <span>Home Section</span>
                        </a>
                  </li>
                  <li>
                      <a href="edit-section.php?section_id=2">
                        <i class="fa fa-braille"></i>
                        <span>About Section</span>
                      </a>
                   </li>
                 </ul>
           
             </li><?php */?>
             <li class="treeview <?php if($active=="products"){ echo "active";} ?>">
              <a href="products.php">
                <i class="fa fa-shopping-bag"></i>
                <span>Store</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              	<li><a href="products.php"><i class="fa fa-folder-open"></i> View Products</a></li>
                <li><a href="add-product.php"><i class="fa fa-plus-circle"></i> Add New Product</a></li>
                <li><a href="categories.php"><i class="fa fa-folder-open"></i>View Product Categories</a></li>
                <li><a href="add-category.php"><i class="fa fa-plus-circle"></i>Add Product Category</a></li>
              </ul>
            </li>
           <!-- <li class="treeview <?php if($active=="enquiries"){ echo "active";} ?>">
              <a href="enquiries.php">
                <i class="fa fa-paper-plane"></i>
                <span>Product Enquiries</span>
              </a>
             </li>-->
             <li class="treeview <?php if($active=="brands"){ echo "active";} ?>">
              <a href="products.php">
                <i class="fa fa-shopping-bag"></i>
                <span>Contacts</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              	<li><a href="brands.php"><i class="fa fa-folder-open"></i> View Contacts</a></li>
                <li><a href="add-brand.php"><i class="fa fa-plus-circle"></i> Add Contact</a></li>
				 <li><a href="work-categories.php"><i class="fa fa-folder-open"></i>View Work Categories</a></li>
                <li><a href="add-work-category.php"><i class="fa fa-plus-circle"></i>Add Work Category</a></li>
              <?php /*?> 	<li><a href="models.php"><i class="fa fa-folder-open"></i> View Models</a></li>
                <li><a href="m_series.php"><i class="fa fa-folder-open"></i> View Model Series</a></li><?php */?>
              </ul>
			
            </li>
			 <li class="treeview <?php if($active=="purchases"){ echo "active";} ?>">
              <a href="#">
                <i class="fa fa-shopping-bag"></i>
                <span>Transactions</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
        
				 <ul class="treeview-menu">
              	<!--<li><a href="add-purchase.php"><i class="fa fa-folder-open"></i> New Purchase</a></li>-->
                <li><a href="add-purchase.php" class="new_purchase"><i class="fa fa-plus-circle"></i> New Purchase</a></li>
				<li><a href="select-customer.php"><i class="fa fa-plus-circle"></i> Sell Products</a></li>
              <?php /*?> 	<li><a href="models.php"><i class="fa fa-folder-open"></i> View Models</a></li>
                <li><a href="m_series.php"><i class="fa fa-folder-open"></i> View Model Series</a></li><?php */?>
              </ul>
      </li>
      <!--<li class="treeview <?php if($active=="reprt"){ echo "active";} ?>">
              <a href="#">
                <i class="fa fa-shopping-bag"></i>
                <span>Reports</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
        
				 <ul class="treeview-menu">
              	<li><a href="add-purchase.php"><i class="fa fa-folder-open"></i> New Purchase</a></li>
                <li><a href="custom-purchase_report.php" class="new_purchase"><i class="fa fa-plus-circle"></i> Purchase Report</a></li>
				<li><a href="custom-sales_report.php"><i class="fa fa-plus-circle"></i> Sales Report</a></li>
              <?php /*?> 	<li><a href="models.php"><i class="fa fa-folder-open"></i> View Models</a></li>
                <li><a href="m_series.php"><i class="fa fa-folder-open"></i> View Model Series</a></li><?php */?>
              </ul>
      </li>-->
        <!--    <li class="treeview <?php if($active=="events"){ echo "active";} ?>">
              <a href="events.php">
                <i class="fa fa-file-text"></i>
                <span>Events</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu">
              	<li><a href="events.php"><i class="fa fa-folder-open"></i>View Events</a></li>
                <li><a href="add-event.php"><i class="fa fa-plus-circle"></i>Add Event</a></li>
              </ul>
            </li>-->
       		
          </ul>
        </section>
        <!-- /.sidebar -->
   </aside>