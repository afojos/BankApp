<?php
session_start();
include '../includes/db.php';
include '../includes/user_auth.php';
include '../includes/user_info.php';

if(isset($_POST['pay'])){
	 $error = array();
	
if(empty($_POST['account_number']))	{
	
	$error['account_number']="Enter Account Number";
	}elseif(!is_numeric($_POST['account_number'])){
		$error['account_number']="Please Enter a Numeric Value";
		
		}
if(empty($_POST['amount']))	{
	
	$error['amount']="Enter Specific Amount";
	}elseif(!is_numeric($_POST['amount'])){
		$error['amount']="Please Enter a Numeric Value";
		
		}
if(empty($error)){
	if($_POST['amount'] > $current_data['account_balance']){
		
		header("location:transfer.php?error=Insfficient Funds");
		exit();
		}
	$beneficiary=$conn->prepare("SELECT * FROM customer WHERE account_number=:acn");  
	$beneficiary->bindParam(":acn",$_POST['account_number']);
	$beneficiary->execute();
	
if($beneficiary->rowCount() < 1){
	header("location:transfer.php?error=Account Number doesn't exist");
	exit();
	}
	
	$beneficiary_record=$beneficiary->fetch(PDO::FETCH_BOTH);
	
	if($current_data['account_number'] == $beneficiary_record['account_number']){
		
		header("location:transfer.php?error=You Can't Send Funds To Yourself");
		exit();
		}
		
		//debit Transaction	
	$sender_opening_balance = $current_data['account_balance'];
	$sender_closing_balance =              $sender_opening_balance - $_POST['amount'];
	
		$debit = $conn->prepare("UPDATE customer SET account_balance=:acb WHERE account_number=:cau");
	$debit->bindParam(":acb",$sender_closing_balance);
	$debit->bindParam(":cau",$current_data['account_number']);
	$debit->execute();
	
	$debit_transfer=$conn->prepare("INSERT INTO transaction VALUES (NULL,:sa,:ra,:ta,:pb,:fb,:tt,:cst,NOW(),NOW()) ");
	$data=array(
	":sa"=>$current_data['account_number'],
	":ra"=>$beneficiary_record['account_number'],
	":ta"=>$_POST['amount'],
	":pb"=>$current_data['account_balance'],
	":fb"=>$sender_closing_balance,
	":tt"=>"debit",
	":cst"=>$current_data['customer_id']
	);
	$debit_transfer->execute($data);
	
	
	//credit Transaction
	
	
	$beneficiary_opening_balance = $beneficiary_record['account_balance'];
	$beneficiary_closing_balance =             $beneficiary_opening_balance + $_POST['amount'];
	
	$credit=$conn->prepare("UPDATE customer SET account_balance=:acb WHERE account_number=:ban ");
	$credit->bindParam(":acb",$beneficiary_closing_balance);
	$credit->bindParam(":ban",$beneficiary_record['account_number']);
	
	$credit->execute();
	
	header("location:transfer.php");
	
	 
	
	// Log a Transaction
	
	try{
	$credit_transfer=$conn->prepare("INSERT INTO transaction VALUES (NULL,:sa,:ra,:ta,:pb,:fb,:tt,:cst,NOW(),NOW()) ");
	$credit_data=array(
	":sa"=>$current_data['account_number'],
	":ra"=>$beneficiary_record['account_number'],
	":ta"=>$_POST['amount'],
	":pb"=>$beneficiary_opening_balance,
	":fb"=>$beneficiary_closing_balance,
	":tt"=>"credit",
	":cst"=>$beneficiary_record['customer_id'],
	);
	$credit_transfer->execute($credit_data);
		
		
		}catch(PDOException $e){
			
			$e->getMessage();
			
			}
		
		
		
		
	header("location:transfer.php?success=Transaction Successful");
	
	
	
	
	
	
	}	
	}

?>








<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Transfer</title>
</head>

<body>
<?php include '../includes/user_header.php' ;
        ?>
 <?php        
if(isset ($_GET ['error'])){
	echo "<p style='color:red'>".$_GET['error']."<p/>";
	}
	if(isset ($_GET ['success'])){
	echo "<p style='color:green'>".$_GET['success']."<p/>";
	}

?>

<form action="" method="post">
<?php
if(isset($error['account_number'])){

echo "<p style='color:red'>".$error['account_number']."</p>"	;
	
	}

?>
<p>Account Number: <input type="text" name="account_number"/></p>
<?php
if(isset($error['amount'])){

echo "<p style='color:red'>".$error['amount']."</p>"	;
	
	}

?>
<p>Transaction Amount: <input type="text" name="amount"/></p>
<input type="submit" name="pay" value="Transfer"/>








</form>

















</body>
</html>