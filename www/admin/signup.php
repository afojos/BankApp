<?php
include '../includes/db.php';
include '../includes/admin_function.php';

if(isset ($_POST['submit']))
{

	 validationInsert($conn,$_POST);
	
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Signup</title>
</head>

<body>
<?php
if(isset($_GET['message'])){
	echo $_GET['message'];
	}

	?>
<form action="" method="post">

<p>Name: <input type="text" name="name"/></p>

<p>Email: <input type="email" name="email"/></p>

<p>Password: <input type="password" name="hash"/></p>

<p>Confirm pasword: <input type="password" name="confirm"/></p>

<p><input type="submit" value="submit" name="submit"/></p>

</form>
</body>
</html>