<?php
session_start();
include '../includes/db.php';
include '../includes/admin_function.php';

if(array_key_exists("submit",$_POST))
{
	
	userValidationfetch($conn,$_POST);   
	
}


?>













<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Bank Login</title>
</head>

<body>
<h1>Swap Bank</h1>
<?php
if(isset($_GET['message'])){
	echo $_GET['message'];
	echo "<br>";
	}

if(isset($_GET['error'])){
	echo $_GET['error'];
	echo "<br>";
	}


if(isset($error['account_number'])){
	echo "<p style='color:red'>".$error['account_number']."</p>";
	echo "<br>";
	}

?>
<hr/>
<form action="" method="post">
<p>Account Number:<input type="text" name="account_number"/></p>
<input type="submit" name="submit" value="Login"/>





</form>
 




</body>
</html>