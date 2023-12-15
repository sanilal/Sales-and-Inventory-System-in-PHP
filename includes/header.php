<?php
error_reporting(0);
ob_start();
session_start();

if(!isset($_SESSION['user_id'])){
	header("Location: logout.php");
	echo "<script type='text/javascript'>window.top.location='logout.php';</script>";
	exit;
}
else if($_SESSION['user_id']=="" || $_SESSION['user_id']==NULL){
    
	header("Location: logout.php");
	echo "<script type='text/javascript'>window.top.location='logout.php';</script>";
	exit;
}

//var_dump($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Dosita Havuz | Admin panel </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
	<!-- Selectize style -->
    <link rel="stylesheet" href="dist/css/selectize.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="dist/css/sweetalert2.css">
	 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.dataTables.min.css">
   <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js"></script>

	  
	  <style type="text/css">
.bs-example{
	font-family: sans-serif;
	position: relative;
	margin: 50px;
}
.typeahead, .tt-query, .tt-hint {
	border: 2px solid #CCCCCC;
	border-radius: 8px;
	font-size: 24px;
	height: 30px;
	line-height: 30px;
	outline: medium none;
	padding: 8px 12px;
	width: 396px;
}
.typeahead {
	background-color: #FFFFFF;
}
.typeahead:focus {
	border: 2px solid #0097CF;
}
.tt-query {
	box-shadow: 0 1px 1px rgba(0, 0, 0, 0.075) inset;
}
.tt-hint {
	color: #999999;
}
.tt-dropdown-menu {
	background-color: #FFFFFF;
	border: 1px solid rgba(0, 0, 0, 0.2);
	border-radius: 8px;
	box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
	margin-top: 12px;
	padding: 8px 0;
	width: 422px;
}
.tt-suggestion {
	font-size: 24px;
	line-height: 24px;
	padding: 3px 20px;
}
.tt-suggestion.tt-is-under-cursor {
	background-color: #0097CF;
	color: #FFFFFF;
}
.tt-suggestion p {
	margin: 0;
}
#moreproductsWraper, #product-selling .addProduct, .ajaxhide, .result-container  {
	display: none;
	opacity: 0;
	visibility: hidden;
}
#moreproductsWraper.show, #product-selling .ajaxhide, .result-container.show {
	display: block;
	opacity: 1;
	visibility: visible;
}
#product-selling input {
  padding-left: 10px;
}
#product-selling input[type="submit"] {
	float: right;
    margin-right: 100px;
}
.btn.btn-primary.sellmore {
	float: none;
	margin: auto;
	width: 152px;
	display: block;
}
input.available-stock {
    background: #fff;
    border: none;
    outline: none;
    font-size: 20px;
    font-weight: 700;
    max-width: 100px;
	color: #247200;
}
 .purchase-head {
	 /*background: #3c8dbc;*/
	 padding: 15px;
 }
.purchase-head span {
	margin-right: 20px;
	color: #000;
	font-size: 18px;
}
.purchase-head span:last-child {
	margin-right: 0;
}
div#priceDisplay {
    width: max-content;
    position: fixed;
    bottom: 40px;
    right: 0;
	padding: 15px;
	background: #222d32;
}
div#priceDisplay th {
	font-size: 18px;
    /* max-width: 250px; */
}
div#priceDisplay td {
	font-size: 25px;
	font-weight: 700;
}
div#priceDisplay table {
	border-collapse: collapse;
}
div#priceDisplay table, div#priceDisplay th, div#priceDisplay td {
	border: 1px solid rgb(150, 158, 162);
    padding: 5px;
    color: #fff;
}
.btn.btn-primary.newrow, .btn.btn-primary.remove {
    margin-top: 25px;
}
.btn.btn-primary.remove {
  background: #C80508;
  border-color: #C80508;
}
.btn.btn-primary.newrow i {
  margin-right: 8px;
}
table#user_data th {
    background: #3c8dbc;
    color: #fff;
}
table#user_data tr:nth-of-type(odd) { 
  background: #eee; 
}
button.ui-dialog-titlebar-close::after {
    content: X;
    content: "X";
    margin-top: -3px;
    display: block;
    color: #b3adad;
}
table#user_data {
  border-collapse: collapse;
}

table#user_data, table#user_data th, table#user_data td {
  border: 1px solid #dddddd;
}
.add-row-button {
	/* width: 100px; */
	margin-top: 30px;
	margin-right: 30px;
}
 button#add {
    padding: 5px 15px;
    font-size: 18px;
}
button#add i {
    font-size: 15px;
    padding-left: 5px;
}
table.crudtable { 
  width: 100%; 
  border-collapse: collapse; 
}
/* Zebra striping */
table.crudtable tr:nth-of-type(odd) { 
  background: #eee; 
}
table.crudtable th { 
  background: #333; 
  color: white; 
  font-weight: bold; 
}
table.crudtable td, table.crudtable th { 
  padding: 6px; 
  border: 1px solid #ccc; 
  text-align: left; 
}	
.hide-now {
  display: none !important;
  visibility: hidden !important;
  opacity: 0 !important;
}
 table { 
  width: 100%; 
  border-collapse: collapse; 
}
/* Zebra striping */
tr:nth-of-type(odd) { 
  background: #eee; 
}
th { 
  background: #333; 
  color: white; 
  font-weight: bold; 
}
td, th { 
  padding: 6px; 
  border: 1px solid #ccc; 
  text-align: left; 
}
.alert a {
  text-decoration: none;
}
table#tableheader th { 
  background: #eee; 
color: #000;
}
#details-purchase.show, #slecteddata.show {
	display: block;
	visibility: visible;
	opacity: 1;
}
#slecteddata.show {
	display: inline-table !important;
}
div#details-purchase {
    position: absolute;
    top: 0;
    background: #fff;
    padding: 15px;
    border: 1px solid #9a9a9a;
    max-height: 300px;
    overflow: scroll;
    display: none;
  	visibility: hidden;
  	opacity: 0;
    width: 800px;
    max-width:90%;
}
.purClose {
    position: absolute;
    top: 16px;
    right: 15px;
    /* width: 20px; */
    /* height: 20px; */
    background: #fb1111;
    color: #fff;
    padding: 6px 11px;
    /* border-radius: 50%; */
    letter-spacing: normal;
    font-weight: bold;
    font-size: 15px;
    cursor: pointer;
}
div#details-purchase table {
    width: 720px;
    max-width: calc(90% - 30px);
}
.no-items.hide, #slecteddata  {
  display: none;
  visibility: hidden;
  opacity: 0;
}
#sales-form input[type="submit"] {
  float: right;
  margin-top: 20px;
}
#sales-form input.quantity {
  width: 100px;
}
form#custom-report-form.form-horizontal .form-group {
  margin-right: 0;
}
form#custom-report-form input#search {
  width: 100px;
  margin: 0 auto 39px;
  padding: 0;
  line-height: 20px;
  font-size: 20px;
}
div#example2_wrapper button.dt-button, div.dt-button, a.dt-button, div#example3_wrapper button.dt-button {
    border: none;
    background: #3c8dbc;
    color: #fff;
}
.center-table th, .center-table td {
  text-align: center;
}
span.outofstock {
    color: #f00;
    padding: 10px 37px;
    font-size: 19px;
    font-weight: bold;
}
span.instock {
	color: green;
    padding: 10px 37px;
    font-size: 19px;
    font-weight: bold;
}
 .totalvalue {
    display: none;
}
  .totstorervalue {
		background: #07ad04;
		width: max-content;
		padding: 15px 25px;
		margin-bottom: 25px;
		color: #fff;
	}
.p-r-0 {
    padding-right: 0;
}
div#purchaselist, div#saleslist {
    max-width: 100%;
	width: 500px;
	margin-right: 80px;
    float: left;
}
  div#purchaselist a.dt-button:hover,  div#saleslist a.dt-button:hover, a.dt-button:hover {
	  color: #000 !important;
  }
</style>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <!-- Site wrapper -->
    <div class="wrapper">

      <header class="main-header">
        <!-- Logo -->
        <a href="home.php" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>Dosita Havuz</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>Dosita Havuz Admin</b></span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">1</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">Last login time</li>
                  <li style="padding-left:20px; padding-bottom:10px">
                    Last logined on &nbsp;<b><?php echo ($_SESSION['last_login']); ?></b>
                  </li>
                </ul>
              </li>
              
              <!-- Control Sidebar Toggle Button -->
              <!--<li>
                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
              </li>-->
            </ul>
          </div>
        </nav>
      </header>