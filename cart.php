<!DOCTYPE html>
<?php
    session_start();
    if($_SESSION['userid']=="")
    {
        header('location: index.php');
    }
    if(array_key_exists('delete', $_POST))
    {
        $prod_id=$_POST['prodid'];

        $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
        $query = "delete from cart where product_id='$prod_id'";
        if(mysqli_query($con, $query))
        {
            echo '<script>alert("Deleted Successfully!!")</script>';
        }
        else
        {
            echo '<script>alert("Item Not Deleted!!")</script>';
        }
    }
    if(array_key_exists('apply', $_POST))
    {
        $cpn=$_POST['coupon'];
        $cpn = str_replace( array( '-', '|', '&','\'', '"',',' , ';', '<', '=', '>' ), ' ', $cpn);

        $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
        if($cpn=="Stud20")
        {
            $query = "select * from cart";
            $check = mysqli_query($con, $query);
            while($row=mysqli_fetch_array($check))
            {
                $total=$row['product_total'];
                $p_id=$row['product_id'];
                $total2=($total*0.20);
                $total=$total-$total2;
                $query3 = "update cart set product_total='$total' where product_id='$p_id'";
                mysqli_query($con, $query3);
            }
        }
        elseif($cpn=="Lig20")
        {
            $query = "select * from cart";
            $check = mysqli_query($con, $query);
            while($row=mysqli_fetch_array($check))
            {
                $total=$row['product_total'];
                $p_id=$row['product_id'];
                $query2 = "select * from products where id='$p_id'";
                $check2 = mysqli_query($con, $query2);
                while($row2=mysqli_fetch_array($check2))
                {  $type=$row2['type']; }

                if($type="Lights")
                {
                    $total2=($total*0.20);
                    $total=$total-$total2;
                    $query3 = "update cart set product_total='$total' where product_id='$p_id'";
                    mysqli_query($con, $query3);
                }
            }
        }
        elseif($cpn=="Mir30")
        {
            $query = "select * from cart";
            $check = mysqli_query($con, $query);
            while($row=mysqli_fetch_array($check))
            {
                $total=$row['product_total'];
                $p_id=$row['product_id'];
                $query2 = "select * from products where id='$p_id'";
                $check2 = mysqli_query($con, $query2);
                while($row2=mysqli_fetch_array($check2))
                {  $type=$row2['type']; }

                if($type="Mirrors")
                {
                    $total2=($total*0.20);
                    $total=$total-$total2;
                    $query3 = "update cart set product_total='$total' where product_id='$p_id'";
                    mysqli_query($con, $query3);
                }
            }
        }
        else
        {
            echo '<script>alert("Coupon Not Valid!!")</script>';
        }
    }
    if(array_key_exists('deleteall', $_POST))
    {
        $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
        $query = "TRUNCATE cart";
        if(mysqli_query($con, $query))
        {
            echo '<script>alert("Cart Cleared Successfully!!")</script>';
        }
        else
        {
            echo '<script>alert("Cart Not Cleared!!")</script>';
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
    <title>Your Memories | Cart</title>

    <!-- Favicon  -->
    <link rel="icon" href="img/core-img/favicon.ico">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">

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

        <!-- ****** Cart Area Start ****** -->
        <div class="cart_area section_padding_100 clearfix">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="cart-table clearfix">
                            <table class="table table-responsive col-12">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $uid=$_SESSION['userid'];
                                    $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
                                    $res=mysqli_query($con,"select * from cart where customer_id='$uid'");
                                    $details="";
                                    while($row=mysqli_fetch_array($res))
                                    {
                                        $quantity=$row['product_quantity'];
                                        $price = $row['Item_price'];
                                        $total=$row['product_total'];
                                        $pid=$row['product_id'];

                                        $res2=mysqli_query($con,"select * from products where id='$pid'");
                                        while($row2=mysqli_fetch_array($res2))
                                        {  
                                            $image="data:image/jpeg;base64,".base64_encode($row2['image1']);
                                            $name=$row2['name'];
                                        }

                                        echo '<tr>';
                                        echo '<td class="cart_product_img d-flex align-items-center">';
                                        echo "<a href='#'><img src='$image'/></a>";
                                        echo "<h6>$name</h6>";
                                        echo '</td>';
                                        echo "<td class='price'><span>$price</span></td>";
                                        echo '<td class="qty">';
                                        echo '<div class="quantity">';
                                        echo "<span>  $quantity</span>";
                                        echo '</div>';
                                        echo '</td>';
                                        echo "<td class='total_price'><span>$total</span></td>";
                                        echo '<td>';
                                        echo '<form method="post">';
                                        echo "<input type='hidden' name='prodid' value='$pid'>";
                                        echo '<input type="submit" name="delete" value="Delete" style="background-color: black; color: white; padding: 5px; border-radius: 5px"/>';
                                        echo '</form>';
                                        echo '<td>';
                                        echo '</tr>';
                                        $details = (string)$details."Product Name: ".(string)$name." | Quantity: ".(string)$quantity." | Price: ".(string)$price.' | <br>';
                                    }
                                    $_SESSION['details']=$details;
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="cart-footer d-flex mt-30">
                            <div class="back-to-shop w-50">
                                <a href="home.php">Continue Shopping</a>
                            </div>
                            <div class="update-checkout w-50 text-right">
                                <form method="post">
                                <input  type="submit" style="background-color: black; color: white; padding: 5px; border-radius: 5px" name="deleteall" value="Clear Cart"/>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="row">
                    <div class="col-12 col-md-6 col-lg-6">
                        <div class="coupon-code-area mt-70">
                            <div class="cart-page-heading">
                                <h5>Coupon code</h5>
                                <p>Enter your coupon code</p>
                            </div>
                            <form method="post">
                                <input type="text" name="coupon" placeholder="Ex: Stud20">
                                <button type="submit" name="apply">Apply</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="col-12 col-lg-6">
                        <div class="cart-total-area mt-70">
                            <div class="cart-page-heading">
                                <h5>Cart total</h5>
                            </div>

                            <ul class="cart-total-chart">
                                <?php
                                    $uid=$_SESSION['userid'];
                                    $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
                                    $res=mysqli_query($con,"select * from cart where customer_id='$uid'");
                                    $total=0;
                                    $sub_total=0;
                                    $count=0;
                                    while($row=mysqli_fetch_array($res))
                                    {
                                        $total=$total+$row['product_total'];
                                        $count++;
                                    }
                                    if($total>0)
                                    {   $sub_total=$total+100;  }
                                    $_SESSION['subtotal']=$sub_total;
                                    $_SESSION['total']=$total;
                                    $_SESSION['procount']=$count;
                                    echo "<li><span>Subtotal</span> <span>$total Rs</span></li>";
                                    echo '<li><span>Shipping</span> <span>100 Rs</span></li>';
                                    echo "<li><span><strong>Total</strong></span> <span><strong>$sub_total Rs</strong></span></li>";
                                    $det=$_SESSION['details'];
                                    $det=$det."<br>Your Total: ".$sub_total."<br>";
                                    $_SESSION['details']=$det;
                                ?>    
                            </ul>
                            <a href="checkout.php" class="btn karl-checkout-btn">Proceed to checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- ****** Cart Area End ****** -->

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