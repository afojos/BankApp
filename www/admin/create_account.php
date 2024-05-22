<?php
session_start();
include '../includes/db.php';
include '../includes/admin_authetication.php';
include '../includes/admin_function.php';


if(isset($_POST['submit']))
{
	
	validationCreate($conn, $_POST)	;
	
}




?>







<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php 
include ('../includes/admin_header.php');
?>
<form action="" method="post">
<p>Account Name: <input type="text" name="account_name"/></p>
<p>Account Balance: <input type="text" name="account_balance"/></p>

<select name="account_type">
<option disabled selected>--select Account type--</option>
<option value="Savings">Savings</option>
<option value="Current">Current</option>
</select>
<br/>
<br/>
<input type="submit" name="submit" value="submit"/>



</form>
</body>
</html>