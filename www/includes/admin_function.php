<?php

function validationInsert($dbconn,$post){
	$error =array();
	
if	(empty($post['name'])){
	$error['name'] = "Please Enter Name";
	echo $error['name'];
	echo "<br>";
	}
if	(empty($post['email'])){
	$error['email'] = "Please Enter Email";
		echo $error['email'];
	echo "<br>";
	}else{
		
		$statement=$dbconn->prepare("SELECT * FROM admin WHERE email=:em");
        $statement->bindParam(":em",$post['email']);
		$statement->execute();
		
		if($statement->rowCount() > 0){
			
			$error['email'] = "Email Already Exits";
			echo $error['email'];
	echo "<br>";
			
		}
		
		if	(empty($post['hash'])){	
	$error['hash'] = "Please Enter password";
		echo $error['hash'];
	    echo "<br>";
	
	}if	(empty($post['confirm'])){
	$error['confirm'] = "Please Confirm Password";
		echo $error['confirm'];
	    echo "<br>";
	
	}elseif($post['confirm']!==$post['hash']){
		$error['confirm'] = "Password Mismatch";
		
			echo $error['confirm'];
	        echo "<br>";
	}
}

  if (empty($error)){
	  
	  $hash= password_hash($post['hash'],PASSWORD_BCRYPT);
	$state=$dbconn->prepare("INSERT INTO admin VALUES(NULL,:nm,:em,:hsh,NOW(),NOW())");
		$data=array(
		      ":nm"=>$post['name'],
			  ":em"=>$post['email'],
			  ":hsh"=>$hash
		
		);
		
		$state->execute($data);
		header("location:login.php?message=Dear ". $post['name'].", your have successfully registered and a confirmation mail would be sent to ".$post['email']."");	
	  }
}




function  validationFetch($dbconn, $post){
 
 $error = array();
	
	if(empty($post['email'])){
		$error['email'] = "Enter Email"; 
		echo $error['email'];
		echo "<br>";
		}
		if(empty($post['hash'])){
		$error['hash'] = "Enter Password"; 
		echo $error['hash'];
		echo "<br>";
		}
	if(empty($error)){
		$statement=$dbconn->prepare("SELECT * FROM admin WHERE email=:em");
		$data=array(
		":em"=>$post['email']
		);
		
		$statement->execute($data);
	$row=$statement->fetch(PDO::FETCH_BOTH);	
	if($statement->rowcount() > 0 && password_verify($_POST['hash'], $row['hash']))	{
		$_SESSION['admin_id'] = $row['admin_id'];
				$_SESSION['admin_name'] = $row['name'];
		 
		 header("location:dashboard.php");
		 exit();
		}else{
			 header("location:login.php?error=Either Email or Password Incorrect");
		 exit();
			}	
	    }
}


function validationCreate($dbconn, $post){
	$error = array();
	
	if(empty($post['account_name'])){
		$error['account_name'] = "Enter Account Name";
		echo $error['account_name'];
		echo "<br>";
		}
		if(empty($post['account_balance'])){
		$error['account_balance'] = "Enter Account Balance";
		echo $error['account_balance'];
		echo "<br>";
		}
		if(empty($post['account_type'])){
		$error['account_type'] = "Enter Account Type";
		echo $error['account_type'];
		echo "<br>";
		}
	if(!is_numeric($post['account_balance'])){
		$error['account_balance'] = "Enter Numric Value";
		echo $error['account_balance'];
		echo "<br>";
		
		}
	
	if(empty($error)){
		
		$account ="309".rand(1000000,9999999); 
		$stmt=$dbconn->prepare("INSERT INTO customer VALUES(NULL,:anm,:anu,:act,:acb,NOW(),NOW())");
		$data = array(
		":anm"=>$post['account_name'],
		":anu"=>$account,
		":act"=>$post['account_type'],
		":acb"=>$post['account_balance']	
		);
		
		$stmt->execute($data);
		
		header("location:view_accounts.php");
		}
	
	}
	
	
	
function userValidationfetch($dbconn,$post)
{
	
	$error = array();
	
	if(empty($post['account_number']))
	{
		$error['account_number']="Please Enter Account Number";
		echo "<p style='color:red'>".$error['account_number']."</p>";
	echo "<br>";
		
	}
	else
	{
			if(!is_numeric($post['account_number']))
			{
		$error['account_number']="Please Enter a Numeric Value";
		echo $error['account_name'];
		echo "<br>";
		
		    }	
	}

	if(empty($error))
	{
		
		$statement=$dbconn->prepare("SELECT * FROM customer WHERE account_number=:acn");
		$statement->bindParam(":acn",$post['account_number']);
		$statement->execute(); 
		if($statement->rowCount() > 0){
			$row=$statement->fetch(PDO::FETCH_BOTH);
			$_SESSION['id']=$row['customer_id'];
		header("location:dashboard.php");
			exit();
			}
			else
			{
		header("location:login.php?message=Wrong Account Number");
			exit();
				
			}		
		
	}
		
}

?>


