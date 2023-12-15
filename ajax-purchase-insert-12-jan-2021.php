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
include("includes/conn.php"); 

$query1 = "INSERT INTO ".TB_pre."purchase_master (`purchase_no`,`supplier_id`,`purchase_date`,`entry_date`,`purchase_currency`,`conversion_ratio`,`shipping`,`customs`,`handling`) VALUES(?,?,?,?,?,?,?,?,?);";
$query2 = "INSERT INTO ".TB_pre."purchase (`purchase_no`,`product_id`,`quantity`,`purchased_price`,`currency`) VALUES(?,?,?,?,?);";

/* Prevent auto commit so that we can finish the transation and commit at the end */
$url->autocommit(FALSE);

    /* Purchase Master Table Insert */
    $statementMaster = $url->prepare($query1);
    /* https://www.php.net/manual/en/mysqli-stmt.bind-param.php */
    $statementMaster->bind_param('iissidddd', $data[':purchaseno'], $data[':supplier_name'], $data[':purchase_date'], $data[':entry_date'], $data[':currency_name'], $data[':conversion_ratio'], $data[':shipping_charge'], $data[':customs_charges'], $data[':handling_charges']);
    $statementMaster->execute();

for($count = 0; $count<count($_POST['hidden_product_name']); $count++)
{
    $data = array(
    ':product_name' => $_POST['hidden_product_name'][$count],
    ':purchaseno' => $_POST['hidden_purchaseno'][$count],
    ':supplier_name' => $_POST['hidden_supplier_name'][$count],
    ':purchase_date' => $_POST['hidden_purchase_date'][$count],
    ':entry_date' => $_POST['hidden_entry_date'][$count],
    ':currency_name' => $_POST['hidden_currency_name'][$count],
    ':conversion_ratio' => $_POST['hidden_conversion_ratio'][$count],
    ':shipping_charge' => $_POST['hidden_shipping_charge'][$count],
    ':customs_charges' => $_POST['hidden_customs_charges'][$count],
    ':handling_charges' => $_POST['hidden_handling_charges'][$count],
    ':product_stock' => $_POST['hidden_product_stock'][$count],
    ':original_price' => $_POST['hidden_original_price'][$count]
    );

    /* Purchase Master Table Insert */
    $statementMaster = $url->prepare($query1);
    /* https://www.php.net/manual/en/mysqli-stmt.bind-param.php */
    $statementMaster->bind_param('iissidddd', $data[':purchaseno'], $data[':supplier_name'], $data[':purchase_date'], $data[':entry_date'], $data[':currency_name'], $data[':conversion_ratio'], $data[':shipping_charge'], $data[':customs_charges'], $data[':handling_charges']);
    $statementMaster->execute();
    

    /* Purchase  Table Insert */
    $statement = $url->prepare($query2);
    /* https://www.php.net/manual/en/mysqli-stmt.bind-param.php */
    $statement->bind_param('isddi', $data[':purchaseno'], $data[':product_name'], $data[':product_stock'], $data[':original_price'], $data[':currency_name']);
    $statement->execute();
    
}

/* commit transaction */
if (!$url->commit()) {
    print("Transaction commit failed\n");
    exit();
}