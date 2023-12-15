<?php  
error_reporting(0);
ob_start();
include("includes/conn.php"); 
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


$query1 = "INSERT INTO ".TB_pre."sales (`sales_no`,`customer`,`product_id`,`quantity`,`unit_price`,`purchase_id`,`sale_date`) VALUES(?,?,?,?,?,?,?);";
/* Prevent auto commit so that we can finish the transation and commit at the end */
$url->autocommit(FALSE);

    /* Purchase Master Table Insert */
    $statementMaster = $url->prepare($query1);
    /* https://www.php.net/manual/en/mysqli-stmt.bind-param.php */
    $statementMaster->bind_param('iiiidis', $data[':sales_no'], $data[':customer_id'], $data[':product_id'], $data[':quantity'], $data[':unit_price'], $data[':purchase_id'], $data[':sale_date']);
    $statementMaster->execute();

for($count = 0; $count<count($_POST['product_id']); $count++)
{
    $data = array(
    ':product_id' => $_POST['product_id'][$count],
    ':product_code' => $_POST['product_code'][$count],
    ':customer_id' => $_POST['customer_id'][$count],
    ':sales_no' => $_POST['sales_no'][$count],
    ':available' => $_POST['available'][$count],
    ':quantity' => $_POST['quantity'][$count],
    ':unit_price' => $_POST['unit_price'][$count],
    ':purchase_id' => $_POST['purchase_id'][$count],
    ':sale_date' => $_POST['entry_date'][$count]
    );

    /* Purchase Master Table Insert */
    $statementMaster = $url->prepare($query1);
    /* https://www.php.net/manual/en/mysqli-stmt.bind-param.php */
    $statementMaster->bind_param('iiiidis', $data[':sales_no'], $data[':customer_id'], $data[':product_id'], $data[':quantity'], $data[':unit_price'], $data[':purchase_id'], $data[':sale_date']);
    $statementMaster->execute();
    
   
}

/* commit transaction */
if (!$url->commit()) {
    print("Transaction commit failed\n");
    exit();
} 