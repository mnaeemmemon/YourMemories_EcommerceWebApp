<!DOCTYPE html>
<?php

	session_start();

	if($_POST) {
	
		$username = $_POST['username'];
		$password = $_POST['password'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $address = $_POST['address'];

        //validation process start

        function generate_string($input, $strength = 16) {
            $input_length = strlen($input);
            $random_string = '';
            for($i = 0; $i < $strength; $i++) {
                $random_character = $input[mt_rand(0, $input_length - 1)];
                $random_string .= $random_character;
            }
            return $random_string;
        }
        function Aes_Encryption($param){
            $permitted_chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
			//Define cipher 
			$cipher = "aes-256-cbc"; 

			//Generate a 256-bit encryption key 
			$encryption_key = generate_string($permitted_chars, 32); 

			// Generate an initialization vector 
			$iv_size = openssl_cipher_iv_length($cipher); 
			$iv = generate_string($permitted_chars, 16);

			//Data to encrypt 
			$data = $param; 
			$encrypted_data = openssl_encrypt($data, $cipher, $encryption_key, 0, $iv); 

			return $encrypted_data.$encryption_key.$iv;
	    }
		
        $username = Aes_Encryption($username);
        $password = Aes_Encryption($password);

        echo "<script>alert($username)</script>";
        echo "<script>alert($password)</script>";

		//validation process ends

		$dbservername = "localhost";
		$dbusername = "root";
		$dbpassword = "";
		$dbname = "yourmemories";

		$conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);
		
		$case1 = "select * from customers where name = '$username'";
		$case2 = "select * from customers where email = '$email'";
		
		$result1 = mysqli_query($conn, $case1);
		$result2 = mysqli_query($conn, $case2);
		
		$num1 = mysqli_num_rows($result1);
		$num2 = mysqli_num_rows($result2);
		
		if($username != "" && $password != "" && $email != "" && $contact != "" && $address != "")
		{
			if($num1 > 0 && $num2 > 0)
			{
				echo '<script>alert("User Already Exists")</script>'; 
			}
			else if($num1 > 0)
			{
				echo '<script>alert("Username Already Taken")</script>'; 
				
			}
			else if($num2 > 0)
			{
				echo '<script>alert("You Account is Already Exists")</script>';
				
			}
			else
			{
				$reg = "insert into customers (name, password, email, contact, address) values ('$username','$password','$email', '$contact', '$address') ";
				mysqli_query($conn, $reg);
				header('location: index.php');	
			}
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
    <title>Sign Up Page</title>
    <link rel="icon" href="img/core-img/favicon.ico">
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">
	<script type="text/javascript">
        history.pushState(null, null, location.href);
        history.back();
        history.forward();
        window.onpopstate = function () { history.go(1); };
    </script>
    <link rel="stylesheet" href="css/style2.css">
</head>
<body style="background-image: url(img/bg-img/bg-3.jpeg)" >

    <div class="main">

        <section class="signup">
            <div class="container">
                <div class="signup-content">
                    <form method="POST" id="signup-form" class="signup-form">
                        <h2 class="form-title">Create account</h2>
                        <div class="form-group">
                            <input type="text" class="form-input" name="username" id="name" placeholder="Name"/>
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-input" name="email" id="email" placeholder="Email"/>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" name="password" id="password" placeholder="Password"/>
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" name="re_password" id="re_password" placeholder="Repeat your password"/>
                        </div>
                        <div class="form-group">
                            <input type="number" class="form-input" name="contact" id="contact" placeholder="Contact"/>
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" name="address" id="address" placeholder="Address"/>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="Submit" id="submit" class="form-submit" value="Sign up"/>
                        </div>
                    </form>
                    <p class="loginhere" style="margin-top: 40px; color: black; margin-bottom: 0px">
                        Already have an account ? <a href="index.php" class="loginhere-link" style=" background-color: black; padding: 8px; border-radius: 5px; color: white">Login Here</a>
                    </p>
                </div>
            </div>
        </section>

    </div>
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="js/main.js"></script>
</body>
</html>