<?php
$statement=$conn->prepare("SELECT * FROM customer WHERE customer_id=:cid");

$statement->bindParam(":cid",$_SESSION['id']);
$statement->execute();
//to check if account exist or not
if($statement->rowCount() < 1){
	header("location:login.php?error=This record doesnt exist on our system");
	exit();
	
	}



$current_data=$statement->fetch(PDO::FETCH_BOTH);

?>