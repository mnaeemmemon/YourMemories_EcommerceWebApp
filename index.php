<!DOCTYPE html>
<?php
	error_reporting(0);
	session_start();
	if($_SESSION['userid']!="")
	{
		$_SESSION['userid']="";
	}
	if($_POST) 
	{
		$_SESSION['user'] = $_POST['username'];
		$username = $_POST['username'];
		$password = $_POST['password'];

		//validation process start

		function Aes_Decryption($att){
			//Define cipher 
			$cipher = "aes-256-cbc"; 
			
			//Generate a 256-bit encryption key
			$iv = substr($att, -16);
			$att = substr($att, 0, -16);
			
			$encryption_key = substr($att, -32);
			$att = substr($att, 0, -32);
		 
			$data = $att;
		
			// Generate an initialization vector 
			$iv_size = openssl_cipher_iv_length($cipher); 
			
			//Decrypt data 
			$decrypted_data = openssl_decrypt($att, $cipher, $encryption_key, 0, $iv); 
			
			return $decrypted_data;
		}
		//validation process end
		
		$dbservername = "localhost";
		$dbusername = "root";
		$dbpassword = "";
		$dbname = "yourmemories";

		$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

		if($conn->connect_error){
				die("Connection failed: " . $conn->connect_error);
		}
		else if ($username != "" && $password != "")
		{
			$que1 = "select * from customers";
			$res1 = mysqli_query($conn, $que1);
			while($row = mysqli_fetch_assoc($res1)) {
				if($username == Aes_Decryption($row['name']) && $password == Aes_Decryption($row['password']))
				{
					$_SESSION['userid'] = $row['id'];
					echo "<script>localStorage.setItem('userExist', true); </script>";
					header('location: home.php');
				}
			}
			echo '<script>alert("Invalid Username or Password")</script>';
		}
		else
		{	echo '<script>alert("All fields are required to be filled!")</script>';	}
			
		$conn->close();
	}
	
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Page</title>
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
	<script type="text/javascript">
        history.pushState(null, null, location.href);
        history.back();
        history.forward();
        window.onpopstate = function () { history.go(1); };
	</script>
	 <link rel="icon" href="img/core-img/favicon.ico">
    <link rel="stylesheet" href="css/style2.css">
</head>
<body style="background-image: url(img/bg-img/bg-2.jpeg)" >

    <div class="main">

        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <form method="POST" id="signup-form" class="signup-form">
                        <h2 class="form-title">Log in</h2>
                        <div class="form-group">
                            <input type="text" class="form-input" name="username" id="name" placeholder="Your Name"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" name="password" id="password" placeholder="Password"/>
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="Submit" id="submit" class="form-submit" value="Log in"/>
						</div>
                    </form>
					<a class="button_style" href="index_admin.php" >Want To Login As Admin?</a>
					<p class="loginhere" style="margin-top: 40px; color: black; margin-bottom: 0px">
                        Not have an account ? <a href="signup.php" class="loginhere-link" style=" background-color: black; padding: 8px; border-radius: 5px; color: white">Register Here</a>
                    </p>
                </div>
            </div>
        </section>

    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>