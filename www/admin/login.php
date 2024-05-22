<?php
session_start();

include '../includes/db.php';
include '../includes/admin_function.php';


if(isset($_POST['submit']))
{
	 
	validationFetch($conn, $_POST); 
	    
	
}
	
	
?>











<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Login</title>
</head>

<body>

<?php

if(isset($_GET['message']))
{
    echo $_GET['message'];
}

if(isset($_GET['error']))
{
    echo $_GET['error'];
	
}
?>
<h1>Login Here</h1>

<form action="" method="post">


<p>Email: <input type="email" name="email"/></p>

<p>Password: <input type="password" name="hash"/></p>
<p><input type="submit" name="submit" value="submit"/></p>



</form>
</body>
</html>