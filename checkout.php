<!DOCTYPE html>
<?php
    session_start();
    require 'PHPMailer/PHPMailerAutoload.php';

    if($_SESSION['userid']=="")
    {
        header('location: index.php');
    }

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
    
    if(array_key_exists('place', $_POST))
    {
        $name=$_POST['name'];
        $name = str_replace( array( '-', '|', '&','\'', '"',',' , ';', '<', '=', '>' ), ' ', $name);
        $address=$_POST['address'];
        $address = str_replace( array( '-', '|', '&','\'', '"',',' , ';', '<', '=', '>' ), ' ', $address);
        $phone=$_POST['contact'];
        $phone = str_replace( array( '-', '|', '&','\'', '"',',' , ';', '<', '=', '>' ), ' ', $phone);
        $email=$_POST['mail'];
        $email = str_replace( array( '-', '|', '&','\'', '"',',' , ';', '<', '=', '>' ), ' ', $email);
        $dcity=$_POST['dcity'];
        $dcity = str_replace( array( '-', '|', '&','\'', '"',',' , ';', '<', '=', '>' ), ' ', $dcity);
        $note=$_POST['note'];
        $note = str_replace( array( '-', '|', '&','\'', '"',',' , ';', '<', '=', '>' ), ' ', $note);
        $dtype=$_POST['check'];
        $dtype = str_replace( array( '-', '|', '&','\'', '"',',' , ';', '<', '=', '>' ), ' ', $dtype);
        $uid=$_SESSION['userid'];
        $uid = str_replace( array( '-', '|', '&','\'', '"',',' , ';', '<', '=', '>' ), ' ', $uid);
        $st=$_SESSION['subtotal'];
        $date = date('Y/m/d');
        $ddate= date('Y-m-d', strtotime(' + 5 days'));
        $details=$_SESSION['details'];
        $details = str_replace( array( '-', '|', '&','\'', '"',',' , ';', '<', '=', '>' ), ' ', $details);
        $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');

        if($name!="" && $address!="" && $phone!="" && $email!="" && $dcity!="" && $dtype!="")
        {
            if($dtype="COD")
            {
                $query2 = "insert into orders (customer_id, bill, time_stamp, delivery_date, order_details, note, paid, payment_opt, delivery_city, status) value ('$uid' ,'$st', '$date', '$ddate', '$details', '$note', 'No','Cash On Delievry', '$dcity', 'Placed')";
                mysqli_query($con, $query2);
                $query = "TRUNCATE cart";
                mysqli_query($con, $query);
            }
            else
            {
                $query2 = "insert into orders (customer_id, bill, time_stamp, delivery_date, order_details, note, paid, payment_opt, delivery_city, status) value ('$uid' ,'$st', '$date', '$details', '$note', 'Yes','CreditCard', '$dcity', 'Placed')";
                mysqli_query($con, $query2);
                $query = "TRUNCATE cart";
                mysqli_query($con, $query);
            }

            header('location: thanks.html');
        }
        else
        {
            echo '<script>alert("All fields are required to be filled!")</script>';
        }
    }
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Your Memories | Checkout</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">
    <script>
        function showcc(element)
        {
            var check2 = document.getElementById("customCheck2");
            var check1 = document.getElementById("customCheck1");
            var ex_div = document.getElementById("ccdetails");
            if(element=="customCheck1")
            {
                ex_div.style.display="none";
                check2.checked=false;
            }
            else if(element=="customCheck2")
            {
                ex_div.style.display="block";
                check1.checked=false;
            } 
        }
    </script>

    <!-- Responsive CSS -->
    <link href="css/responsive.css" rel="stylesheet">

</head>

<body>
    
<div class="catagories-side-menu">
        <!-- Close Icon -->
        <div id="sideMenuClose">
            <i class="ti-close"></i>
        </div>
        <!--  Side Nav  -->
        <div class="nav-side-menu">
            <div class="menu-list">
                <h6>Menu</h6>
                <ul id="menu-content" class="menu-content collapse out">
                    <!-- Single Item -->
                    <li data-toggle="collapse" data-target="#footwear" class="collapsed">
                        <a href="home.php">Home</a>
                    </li>
                    <li data-toggle="collapse" data-target="#footwear" class="collapsed">
                        <a href="about.php">Why "Your memories"?</a>
                    </li>
                    <li data-toggle="collapse" data-target="#footwear" class="collapsed">
                        <a href="history.php">Order History</a>
                    </li>
                    <li data-toggle="collapse" data-target="#footwear" class="collapsed">
                        <a href="cart.php">Cart</a>
                    </li>
                    <li data-toggle="collapse" data-target="#footwear" class="collapsed">
                        <a href="contact.php">Contact</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div id="wrapper">
        
        <!-- ****** Header Area Start ****** -->
        <header class="header_area bg-img" style="background-color: black">
            <!-- Top Header Area Start -->
            <div class="top_header_area">
                <div class="container h-100">
                    <div class="row h-100 align-items-center justify-content-end" >
                        <div class="col-11" style="background-color: cyan; padding: 10px; border-radius: 10px">
                            <div class="top_single_area d-flex align-items-center">
                                <!-- Logo Area -->
                                <div class="top_logo" >
                                    <a href="home.php"><img src="img/core-img/favicon.ico" style="height: 70px; border-radius:10px; width: 15%; float: left" ><h3 style="width: 84%; float: right;font-family: Arial, Helvetica, sans-serif; margin-top: 20px">Your Memories</h3></a>
                                </div>
                                <!-- Cart & Menu Area -->
                                <div class="header-cart-menu d-flex align-items-center ml-auto">
                                    <!-- Cart Area -->
                                    <div class="cart">
                                    <?php
                                        $id=$_SESSION['userid'];
                                        $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
                                        $query="select * from cart where customer_id='$id'";
                                        $check = mysqli_query($con, $query);
                                        $num = mysqli_num_rows($check); 
                                        $total=$num;
                                        $total=$total*0;
                                        while($row=mysqli_fetch_array($check))
							            {
                                            $total=$total+$row['product_total'];
                                        }
                                        echo "<a href='cart.php' id='header-cart-btn'><span class='cart_quantity'>$num</span> <i class='ti-bag'></i> Your Cart: $total Rs</a>";
                                    ?>
                                    </div>
                                    <div class="header-right-side-menu ml-15">
                                        <a href="#" id="sideMenuBtn"><i class="ti-menu" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                        <form class="col-1" method="post">
                            <input style="padding: 10px; border: 5px white solid; border-radius: 5px; background-color: cyan; color: black" type="submit" value="Logout" name="logout">
                        </form>
                    </div>
                </div>
            </div>
        </header>
        <!-- ****** Header Area End ****** -->
        
        <!-- ****** Checkout Area Start ****** -->
        <div class="checkout_area section_padding_100">
            <div class="container">
                <div class="row">

                    <div class="col-12 col-md-6">
                        <div class="checkout_details_area mt-50 clearfix">
                            <div class="cart-page-heading">
                                <h5>Address Details</h5>
                            </div>

                            <form method="post">
                                <div class="row">
                                <?php
                                    $id=$_SESSION['userid'];
                                    $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
                                    $res=mysqli_query($con,"select * from customers where id='$id'");

                                    while($row=mysqli_fetch_array($res))
                                    {                      
                                        $name=$row['name'];
                                        $name = Aes_Decryption($name);
                                        $email=$row['email'];
                                        $num=$row['contact'];
                                        $address=$row['address'];
                                    }
                                    echo '<div class="col-md-12 mb-3">';
                                    echo '<label >Name </label>';
                                    echo  "<input type='text' class='form-control' name='name' value='$name'>";
                                    echo '</div>';
                                    echo '<div class="col-12 mb-3">';
                                    echo '<label >Address</label>';
                                    echo  "<input type='text' class='form-control' name='address' value='$address'>";
                                    echo '</div>';
                                    echo '<div class="col-12 mb-3">';
                                    echo '<label >Phone Number</label>';
                                    echo  "<input type='text' class='form-control' name='contact' value='$num'>";
                                    echo '</div>';
                                    echo '<div class="col-12 mb-4">';
                                    echo '<label >Email Address</label>';
                                    echo  "<input type='text' class='form-control' name='mail' value='$email'>";
                                    echo '</div>';
                                    echo '<div class="col-12 mb-4">';
                                    echo '<label >Delievery City</label>';
                                    echo  "<input type='text' class='form-control' name='dcity'>";
                                    echo '</div>';
                                    echo '<div class="col-12 mb-4">';
                                    echo '<label >Note (If Any)</label>';
                                    echo  "<input type='text' class='form-control' name='note'>";
                                    echo '</div>';
                                    ?>
                                    <div class="col-6">
                                        <div  class="custom-control custom-checkbox d-block mb-1">
                                            <input type="checkbox" class="custom-control-input" onchange="showcc(id)" id="customCheck1" name="check" value="COD">
                                            <label class="custom-control-label" for="customCheck1">Cash On Delivery</label>
                                        </div>
                                        <div  class="custom-control custom-checkbox d-block mb-1">
                                            <input type="checkbox" class="custom-control-input" onchange="showcc(id)" id="customCheck2" name="check" value="CC">
                                            <label class="custom-control-label" for="customCheck2">Credit Card</label>
                                        </div>
                                    </div>
                                    <div class="col-12" id="ccdetails" style="display: none; background-color: cyan; padding: 10px">
                                        <label >Card Number</label>
                                        <input type='text' class='form-control' name='cardno'>
                                        <label >Name on Card</label>
                                        <input type='text' class='form-control' name='noc'>
                                        <label >3 digits Cvv Number</label>
                                        <input type='number' class='form-control' name='cvv'>
                                        <label >Expiry Date</label>
                                        <input type='date' class='form-control' name='exdate' min=
                                                    <?php
                                                        echo date('Y-m-d');
                                                    ?>
                                        >
                                    </div>
                                </div>
                                <input style="margin-top:20px; display: block;" class="btn karl-checkout-btn" type="submit" name="place" value="Place Order">
                            </form>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">
                        <div class="order-details-confirmation">

                            <div class="cart-page-heading">
                                <h5>Order Details</h5>
                            </div>

                            <ul class="order-details-form mb-4">
                                <?php
                                    $sub_total=$_SESSION['subtotal'];
                                    $total=$_SESSION['total'];
                                    $count=$_SESSION['procount'];
                                    echo "<li><span>Products Count : </span> <span>$count</span></li>";
                                    echo "<li><span>Total : </span> <span>$total</span></li>";
                                    echo "<li><span>Shipping : </span> <span>100</span></li>";
                                    echo "<li><span>Sub Total : </span> <span>$sub_total</span></li>";
                                ?>
                            </ul>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- ****** Checkout Area End ****** -->

        <!-- ****    Footer Area Start    **** -->

        <footer class="footer_area" style="background-color: cyan">
            <div class="container">
                <div class="row">
                    <!-- Single Footer Area Start -->
                    <div class="col-12 align-items-center">
                        <div class="single_footer_area">
                            <div class="footer-logo" style="padding-left: 42%">
                                <img src="img/core-img/logo.jpg" alt="">
                            </div>
                            <div class="copywrite_text d-flex align-items-center" style="padding-left: 30%; color:  black" >
                                <p style="color: black;"> <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Your Memories</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="line" style="background-color: black;"></div>

                <!-- Footer Bottom Area Start -->
                <div class="footer_bottom_area">
                    <div class="row">
                        <div class="col-12">
                            <div class="footer_social_area text-center">
                                <a href="https://www.instagram.com/yourmemories.pk/"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                                <a href="https://www.facebook.com/YourMemoriespk-109887907502323"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                                <a href="yourmemories.pk@gmail.com"><i class="fa fa-envelope" aria-hidden="true"></i></a>
                                <a href="http://www.yourmemories.com/"><i class="fa fa-globe" aria-hidden="true"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- ****** Footer Area End ****** -->
    </div>
    <!-- /.wrapper end -->

    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="js/plugins.js"></script>
    <!-- Active js -->
    <script src="js/active.js"></script>

</body>

</html>