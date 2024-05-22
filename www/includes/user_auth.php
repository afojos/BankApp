<?php
if(!isset($_SESSION['id'])){
	header("location:login.php?error=This Page Requires a Login");
	exit();
	}
?>