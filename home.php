<?php
 $host = "localhost";
  $db_name = "dblogin";
    $username = "root";
$password = "";
            $conn = new PDO("mysql:host=" . $host . ";dbname=" . "dblogin", $username, $password);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
	$uname = strip_tags($_GET ['txt_uname']);
	$umail = strip_tags($_GET['txt_uname_email']);
	$upass = strip_tags($_GET['txt_password']);
	$stmt = $conn->prepare("SELECT * FROM users WHERE user_name=:uname AND user_email=:umail ");         
	$stmt->bindParam(':uname',$uname, PDO::PARAM_STR);
	$stmt->bindParam(':umail',$umail, PDO::PARAM_STR);	
            $stmt->execute();
            $userRow=$stmt->fetch(PDO::FETCH_ASSOC);
            if($stmt->rowCount() == 1)
            {
                if(password_verify($upass, $userRow['user_pass']))
                {
 $conn2 = new PDO("mysql:host=" . $host . ";dbname=" . "picturedb", $username, $password);
			$conn2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
	$userid=strip_tags($_GET['txt_uname']);
	$stmt2 = $conn2->prepare("SELECT location FROM listopics where creator = '".$userid."'");
	$stmt2->execute();
	while ($userRow=$stmt2->fetch(PDO::FETCH_ASSOC))
	{
		echo $userRow['location'].";";
	}
return $conn2=NULL;
                }
            }
                else
                {           
echo "failure";
}
return $conn=NULL;
?>
