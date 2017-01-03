<?php
//connection details
$host = "localhost";
$db_name = "dblogin";
$username = "root";
$password = "";

//connect to user database through PDO, this will verify username and password match 
$conn = new PDO("mysql:host=" . $host . ";dbname=" . "dblogin", $username, $password);
//sets parameters for PDO connection
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
//PDO linking parameters to $_GET strings
$uname = strip_tags($_GET ['txt_uname']);
$umail = strip_tags($_GET['txt_uname_email']);
$upass = strip_tags($_GET['txt_password']);
//Prepares PDO query
$stmt = $conn->prepare("SELECT * FROM users WHERE user_name=:uname AND user_email=:umail ");         
//Bind Parameters for PDO query
$stmt->bindParam(':uname',$uname, PDO::PARAM_STR);
$stmt->bindParam(':umail',$umail, PDO::PARAM_STR);	
//execute PDO query with bind params
$stmt->execute();
//get all results from PDo query
$userRow=$stmt->fetch(PDO::FETCH_ASSOC);
//if username found, verify password
if($stmt->rowCount() == 1)
	//begins username found loop
	{
	if(password_verify($upass, $userRow['user_pass']))
	//begins pass verify loop
	{
//connects to pictures database
$conn2 = new PDO("mysql:host=" . $host . ";dbname=" . "picturedb", $username, $password);
//sets parameters for PDO connection
$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
//PDO linking parameters to $_GET strings
$userid=strip_tags($_GET['txt_uname']);
//Query database selects all pictures from username submitted		
$stmt2 = $conn2->prepare("SELECT location FROM listopics where creator = '".$userid."'");
//execute PDO query
$stmt2->execute();
//get all results and list all results separated by a semicolon
while ($userRow=$stmt2->fetch(PDO::FETCH_ASSOC))
	{
	echo $userRow['location'].";";
	}
//close connection to picture database
return $conn2=NULL;
	//ends pass verify loop
	}
	//insert code here to handle if username found but pass not verified//
	//ends username found loop
	}
//if username not found echo failure
else
	{           
	echo "failure";
	}
//close connection to user database
return $conn=NULL;
?>
