<?php
define("DBNAME","bank_app");
define("DBLOGIN","root");
define("DBPASS","");

try{
$conn = new PDO("mysql:host=localhost;dbname=".DBNAME,DBLOGIN,DBPASS);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);	
	}catch(PDOException $e){
		echo $e->getMessage();
		}



?>