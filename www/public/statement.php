<?php
session_start();
include '../includes/db.php';
include '../includes/user_auth.php';
include '../includes/user_info.php';

$statement=$conn->prepare("SELECT * FROM transaction WHERE customer=:cid ");
$statement->bindParam(":cid",$current_data['customer_id']);
$statement->execute();
$statement_record=array();
while($statement_row=$statement->fetch(PDO::FETCH_BOTH)){
	$statement_record[]=$statement_row;
	
	}
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Account Statement</title>
</head>

<body>
<p><?php include '../includes/user_header.php' ;
?></p>

<table border="3">
<tr>
<th >Senders Account</th>
<th>Receivers Account</th>
<th>Previous Balance</th>
<th>Final Balance</th>
<th>Transaction Type</th>
<th>Date</th>
<th>Time</th>
</tr>

<?php foreach($statement_record as $value): ?>
<tr>
   <td><?=$value['senders_account']?></td>
    <td><?=$value['receivers_account']?></td>
     <td><?=$value['previous_balance']?></td>
      <td><?=$value['final_balance']?></td>
       <td><?=strtoupper($value['transaction_type'])?></td>
        <td><?=$value['date_created']?></td>
        <td><?=$value['time_created']?></td>
</tr>

<?php endforeach;?>








</table>









</body>
</html>