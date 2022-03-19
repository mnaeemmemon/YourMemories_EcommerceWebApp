<!DOCTYPE html>
<?php
    session_start();
    if($_SESSION['userid']=="")
    {
        header('location: index.php');
    }
    if(array_key_exists('logout', $_POST))
    {
        $_SESSION['userid']="";
        header('location: index.php');
    }
    if(array_key_exists('addtocart', $_POST))
    {
        $p_id=$_POST['pid'];
        $p_price = $_POST['price'];
        $p_name = $_POST['name'];
        $p_quantity= $_POST['quantity'];
        
        $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
        $query = "select * from cart where product_id='$p_id'";
        $res = mysqli_query($con, $query);
        $num=mysqli_num_rows($res);
        $total=$p_quantity;

        $querynext = "select * from products where id='$p_id'";
        $resnext = mysqli_query($con, $querynext);
        while($row=mysqli_fetch_array($resnext))
        {  $t1=$row['quantity']; }

        if($p_quantity>0 && $t1>0 && ($p_quantity<=$t1))
        {
            if($num==0)
            {
                $total = $total * (int)$p_price;
                $uid=$_SESSION['userid'];
                $query2 = "insert into cart (product_id, customer_id, product_quantity, Item_price, product_total) value ('$p_id', '$uid' ,'$p_quantity','$p_price', '$total')";
                if(mysqli_query($con, $query2))
                {
                    $q1 = "select quantity from products where id='$p_id'";
                    $quant = mysqli_query($con, $q1);
                    while($row=mysqli_fetch_array($quant))
                    {  $temp=$row['quantity']; }
                    $final_quant = (int)$temp - $p_quantity;
                    $query3 = "update products set quantity='$final_quant' where id='$p_id'";
                    mysqli_query($con, $query3);
                    echo '<script>alert("Item Added Successfully!!")</script>';
                }
                else
                {
                    echo '<script>alert("Item Not Added!!")</script>';
                }
            }
            else
            {
                while($row=mysqli_fetch_array($res))
                {  $temp=$row['product_quantity']; }
                $first_quan=$p_quantity;
                $p_quantity = $p_quantity + (int)$temp;
                $total = $p_quantity * (int)$p_price;
                $query3 = "update cart set product_quantity='$p_quantity', product_total='$total' where product_id='$p_id'";
                if(mysqli_query($con, $query3))
                {
                    $q1 = "select quantity from products where id='$p_id'";
                    $quant = mysqli_query($con, $q1);
                    while($row=mysqli_fetch_array($quant))
                    {  $temp=$row['quantity']; }
                    $final_quant = (int)$temp - $first_quan;
                    $query3 = "update products set quantity='$final_quant' where id='$p_id'";
                    mysqli_query($con, $query3);
                    echo '<script>alert("Item Added Successfully!!")</script>';
                }
                else
                {
                    echo '<script>alert("Item Not Added!!")</script>';
                }
            }
        }
        else if($p_quantity<=0)
        {
            echo '<script>alert("Please Enter Quantity!!")</script>';
        }
        else if($t1<=0)
        {
            echo '<script>alert("This Item is not availabel in Stock Right Now!!")</script>';
        }
        else
        {
            echo '<script>alert("The Quantity You Enetered Is not Availabel in Stock!!")</script>';
        }
    }
    if(array_key_exists('viewproduct', $_POST))
    {
        $id=$_POST['pid'];
        $_SESSION['viewid']=$id;
        header('location: product-details.php'."?id=".$id);
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
    <title>Your Memories | Home</title>
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

        <!-- ****** Top Discount Area Start ****** -->
        <section class="top-discount-area d-md-flex align-items-center">
            <!-- Single Discount Area -->
            <div class="single-discount-area" style="background-color: black">
                <h5>Free Shipping &amp; Reasonable Prices</h5>
            </div>
            <!-- Single Discount Area -->
            <div class="single-discount-area" style="background-color: cyan; color: black">
                <h5 style="color:black;" >20% Discount for Students | Code : "Stud20" </h5>
            </div>
            <!-- Single Discount Area -->
            <div class="single-discount-area" style="background-color: black">
                <h5>Ever New Collection</h5>
            </div>
        </section>
        <!-- ****** Top Discount Area End ****** -->

        <!-- ****** Welcome Slides Area Start ****** -->
        <section class="welcome_area">
            <div class="welcome_slides owl-carousel">
                <!-- Single Slide Start -->
                <div class="single_slide height-800 bg-img background-overlay" style="background-image: url(img/bg-img/bg-1.jpeg);">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-12">
                                <div class="welcome_slide_text" style="background-color: black; padding: 20px">
                                    <h2 data-animation="fadeInUp" data-delay="500ms" data-duration="500ms">Polaroids</h2>
                                    <a href="#shopping" class="btn karl-btn" data-animation="fadeInUp" data-delay="1s" data-duration="500ms">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Single Slide Start -->
                <div class="single_slide height-800 bg-img background-overlay" style="background-image: url(img/bg-img/bg-4.jpeg);">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-12">
                                <div class="welcome_slide_text" style="background-color: black; padding: 20px">
                                    <h2 data-animation="fadeInUp" data-delay="500ms" data-duration="500ms">Fairy Lights</h2>
                                    <a href="#shopping" class="btn karl-btn" data-animation="fadeInLeftBig" data-delay="1s" data-duration="500ms">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Single Slide Start -->
                <div class="single_slide height-800 bg-img background-overlay" style="background-image: url(img/bg-img/bg-2.jpeg);">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-12">
                                <div class="welcome_slide_text" style="background-color: black; padding: 20px">
                                    <h2 data-animation="bounceInDown" data-delay="500ms" data-duration="500ms">Iron Grid</h2>
                                    <a href="#shopping" class="btn karl-btn" data-animation="fadeInRightBig" data-delay="1s" data-duration="500ms">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Single Slide Start -->
                <div class="single_slide height-800 bg-img background-overlay" style="background-image: url(img/bg-img/bg-3.jpeg);">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-12">
                                <div class="welcome_slide_text" style="background-color: black; padding: 20px">
                                    <h2 data-animation="bounceInDown" data-delay="500ms" data-duration="500ms">Mirrors</h2>
                                    <a href="#shopping" class="btn karl-btn" data-animation="fadeInRightBig" data-delay="1s" data-duration="500ms">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Single Slide Start -->
                <div class="single_slide height-800 bg-img background-overlay" style="background-image: url(img/bg-img/bg-5.jpeg);">
                    <div class="container h-100">
                        <div class="row h-100 align-items-center">
                            <div class="col-12">
                                <div class="welcome_slide_text" style="background-color: black; padding: 20px">
                                    <h2 data-animation="bounceInDown" data-delay="500ms" data-duration="500ms">Frames</h2>
                                    <a href="#shopping" class="btn karl-btn" data-animation="fadeInRightBig" data-delay="1s" data-duration="500ms">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- ****** Welcome Slides Area End ****** -->

        <!-- ****** Top Catagory Area Start ****** -->
        <section class="top_catagory_area d-md-flex clearfix">
            <!-- Single Catagory -->
            <div class="single_catagory_area d-flex align-items-center bg-img" style="background-image: url(img/bg-img/bg-2.jpeg);">
                <div class="catagory-content" style="background-color: white; padding: 20px" >
                    <h5 style="color: black">On Mirrors</h5>
                    <h2 style="color: black">Sale 30%</h2>
                    <h5 style="color: black">Use Code: "Mir30"</h5>
                </div>
            </div>
            <!-- Single Catagory -->
            <div class="single_catagory_area d-flex align-items-center bg-img" style="background-image: url(img/bg-img/bg-4.jpeg);">
                <div class="catagory-content" style="background-color: white; padding: 20px">
                    <h5 style="color: black">On Lights</h5>
                    <h2 style="color: black">Sale 20%</h2>
                    <h5 style="color: black">Use Code: "Lig20"</h5>
                </div>
            </div>
        </section>
        <!-- ****** Top Catagory Area End ****** -->

        <!-- ****** New Arrivals Area Start ****** -->
        <section class="new_arrivals_area section_padding_100_0 clearfix" id="shopping" style="background-color: black;">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section_heading text-center">
                            <h2 style="color: white">New Arrivals</h2>
                        </div>
                    </div>
                </div>  
            </div>

            <div class="karl-projects-menu mb-100">
                <div class="text-center portfolio-menu">
                    <button style="background-color: cyan" class="btn active" data-filter="*">All</button>
                    <?php
                    $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
                    $res=mysqli_query($con,"select * from category");

                        while($row=mysqli_fetch_array($res))
                        {
                            $name=$row['name'];
                            $d_id = str_replace(' ', '', $name);
                            echo "<button style='background-color: cyan; margin: 5px' class='btn' data-filter='.$d_id'>$name</button>";
                        } 
                    ?>
                </div>
            </div>

            <div class="container">
                <div class="row karl-new-arrivals">
                    <?php
                        $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
                        $res=mysqli_query($con,"select * from products");

                        while($row=mysqli_fetch_array($res))
                        {
                            $pid=$row['id'];
                            $name=$row['name'];
                            $price = $row['price'];
                            $type=$row['type'];
                            $f_id = str_replace(' ', '', $type);

                            echo "<div class='col-12 col-sm-6 col-md-4 single_gallery_item $f_id wow fadeInUpBig' data-wow-delay='0.2s'>";
                            echo '<div class="product-img">';
                            echo '<img src="data:image/jpeg;base64,'.base64_encode($row['image1']).'"/>';
                            echo '</div>';
                            echo '<div class="product-description">';
                            echo '<form method="post">';
                            echo "<input type='hidden' value='$price Rs' name='price' />";
                            echo "<input type='hidden' value='$name' name='name'/>";
                            echo "<input type='hidden' value='$pid' name='pid'/>";
                            echo "<h4 class='product-price' >$price Rs</h4>";
                            echo "<p style='color: white' >$name</p>";
                            echo "<p style='color: white; margin-top: 5px'> Quantity: <input type='number' step='1' min='1' max='12' value='1' name='quantity'/></p>";
                            echo '<input style="background-color: white; color: black; padding: 8px; margin-left: 10%; margin: 10%px; border-radius: 5px; class="add-to-cart-btn" type="submit" name="addtocart" value="Add to Cart" />';
                            echo '<input style="background-color: white; color: black; padding: 8px; margin: 10%; border-radius: 5px; class="add-to-cart-btn" type="submit" name="viewproduct" value="View Product" />';
                            echo '</form>';
                            echo '</div>';
                            echo '</div>';
                        } 
                    ?>
                </div>
            </div>
        </section>

        <!-- ****  New Arrivals Area End  **** -->
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