<?php
    $permitted_chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()_+=-?:;|\}{[}><,";
    
    function generate_string($input, $strength = 16) {
        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }
    
        return $random_string;
    }

    function Aes_Decryption($param){
        //Define cipher 
        $cipher = "aes-256-cbc"; 
        
        //Generate a 256-bit encryption key
        $iv = substr($param, -16);
        $param = substr($param, 0, -16);
        
        $encryption_key = substr($param, -32);
        $param = substr($param, 0, -32);
     
        $data = $param;
    
        // Generate an initialization vector 
        $iv_size = openssl_cipher_iv_length($cipher); 
        
        //Decrypt data 
        $decrypted_data = openssl_decrypt($data, $cipher, $encryption_key, 0, $iv); 

        echo "<br>";
        echo "Encryption Data: ".$data;
        echo "<br>";
        echo "Encryption Key: ".$encryption_key;
        echo "<br>";
        echo "IV Size: ".$iv_size;
        echo "<br>";
        echo "IV: ".$iv;
        echo "<br>";

        return $decrypted_data;
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

            echo "<br>";
            echo "Encryption Data: ".$encrypted_data;
            echo "<br>";
            echo "Encryption Key: ".$encryption_key;
            echo "<br>";
            echo "IV Size: ".$iv_size;
            echo "<br>";
            echo "IV: ".$iv;
            echo "<br>";

			return $encrypted_data.$encryption_key.$iv;
	}
    
    $username = "admin";
    $password = "admin123";

    echo "Before Encryption : ".$username." | ".$password."<br>";
    $username = Aes_Encryption($username);
    $password = Aes_Encryption($password);

    echo "<br>After Encryption And Before Decryption : ".$username." | ".$password."<br>";

    $dbservername = "localhost";
    $dbusername = "root";
    $dbpassword = "";
    $dbname = "yourmemories";

    $conn = mysqli_connect($dbservername, $dbusername, $dbpassword, $dbname);

    $qu = "insert into testtable(username, password) values('$username','$password')";
    $res = mysqli_query($conn, $qu);

    $que = "select * from testtable";
    $resu = mysqli_query($conn, $que);

    while($row= mysqli_fetch_assoc($resu)){
        $username = $row['username'];
        $password = $row['password'];
    }

    $username = Aes_Decryption($username);
    $password = Aes_Decryption($password);
    echo "<br>After Decryption : ".$username." | ".$password."<br>";


?>