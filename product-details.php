<!DOCTYPE html>
<?php
    session_start();
    if($_SESSION['userid']=="")
    {
        header('location: index.php');
    }
    $prod_id = $_GET['id'];
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
        header('location: product-details.php'."?".$id);
    }
    if(array_key_exists('addreview', $_POST))
    {
        $rev_text=$_POST['review'];
        $p_id_rev=$_SESSION['viewid'];
        $c_id_rev=$_SESSION['userid'];
        $title = $_POST['title'];
        if($rev_text!="" && $title!="")
        {
            $date = date('Y/m/d');
            $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
            $query = "insert into reviews (customer_id, product_id, title, review_text, rating, image, published_date) values ('$c_id_rev','$p_id_rev','$title', '$rev_text', 'null', 'null', '$date') ";
            $res = mysqli_query($con, $query);
            echo '<script>alert("Review Added Successfully!!")</script>';
        }
        else
        {
            echo '<script>alert("All Feilds Are Required To Be Filled!!")</script>';
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
    <title>Your Memories | Product Details</title>

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
        
        <!-- <<<<<<<<<<<<<<<<<<<< Single Product Details Area Start >>>>>>>>>>>>>>>>>>>>>>>>> -->
        <section class="single_product_details_area section_padding_0_100" style="margin-top: 20px">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="single_product_thumb">
                            <div id="product_details_slider" class="carousel slide" data-ride="carousel">
                            <?php
                                $prod_id=$_SESSION['viewid'];
                                $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
                                $res=mysqli_query($con,"select * from products where id='$prod_id'");
                                echo '<ol class="carousel-indicators">';
                                while($row=mysqli_fetch_array($res))
                                {
                                    $image1= "data:image/jpeg;base64,".base64_encode($row['image1']);
                                    $image2= "data:image/jpeg;base64,".base64_encode($row['image2']);
                                    $image3= "data:image/jpeg;base64,".base64_encode($row['image3']);
                                    
                                    $name = $row['name'];
                                    $price = $row['price'];
                                    $description = $row['description'];
                                    $quantity=$row['quantity'];

                                    echo "<li class='active' data-target='#product_details_slider' data-slide-to='0' style='background-image: url($image1)'>";
                                    echo '</li>';
                                    echo "<li data-target='#product_details_slider' data-slide-to='1' style='background-image: url($image2)'>";
                                    echo '</li>';
                                    echo "<li data-target='#product_details_slider' data-slide-to='2' style='background-image: url($image3)'>";
                                    echo '</li>';
                                }
                                echo '</ol>';
                                echo '<div class="carousel-inner">';
                                echo '<div class="carousel-item active">';
                                echo "<a class='gallery_img' href='$image1'>";
                                echo "<img class='d-block w-100' src='$image1' alt='First slide'>";
                                echo '</a>';
                                echo '</div>';
                                echo '<div class="carousel-item">';
                                echo "<a class='gallery_img' href='$image2'>";
                                echo "<img class='d-block w-100' src='$image2' alt='Second slide'>";
                                echo '</a>';
                                echo '</div>';
                                echo '<div class="carousel-item">';
                                echo "<a class='gallery_img' href='$image3'>";
                                echo "<img class='d-block w-100' src='$image3' alt='Third slide'>";
                                echo '</a>';
                                echo '</div>';
                                echo '</div>';  
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '<div class="col-12 col-md-6">';
                                echo '<div class="single_product_desc">';
                                echo "<h1>$name</h1>";
                                echo "<h4 class='price'>Price: $price</h4>";
                                echo "<p class='available'>Available: <span class='text-muted'>$quantity</span></p>";
                                echo '<form class="cart clearfix mb-50 d-flex" method="post">';
                                echo '<div class="quantity">';
                                echo "<input type='hidden' name='pid' value='$prod_id'>";
                                echo "<input type='hidden' name='name' value='$name'>";
                                echo "<input type='hidden' name='price' value='$price'>";
                                echo '<span class="qty-minus" onclick="var effect = document.getElementById(\'qty\'); var qty = effect.value; if( !isNaN( qty ) &amp;&amp; qty &gt; 1 ) effect.value--;return false;"><i class="fa fa-minus" aria-hidden="true"></i></span>';
                                echo '<input type="number" class="qty-text" id="qty" step="1" min="1" max="12" name="quantity" value="1">';
                                echo '<span class="qty-plus" onclick="var effect = document.getElementById(\'qty\'); var qty = effect.value; if( !isNaN( qty )) effect.value++;return false;"><i class="fa fa-plus" aria-hidden="true"></i></span>';
                                echo '</div>';
                                echo '<button type="submit" name="addtocart" value="5" style="color: black;" class="btn cart-submit d-block">Add to cart</button>';
                                echo '</form>';
                                echo '<div id="accordion" role="tablist">';
                                echo '<div class="card">';
                                echo '<div class="card-header" role="tab" id="headingOne">';
                                echo '<h6 class="mb-0">';
                                echo '<a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">Information</a>';
                                echo '</h6>';
                                echo '</div>';
                                echo '<div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">';
                                echo '<div class="card-body">';
                                echo "<p style='color: black'>$description</p>";
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- <<<<<<<<<<<<<<<<<<<< Single Product Details Area End >>>>>>>>>>>>>>>>>>>>>>>>> -->

        <section class="you_may_like_area clearfix">
            <div class="container">
                <div class="row" style="background-color: cyan; padding-top: 30px; padding-bottom: -30px; margin-bottom: 30px;">
                    <div class="col-12">
                        <div class="section_heading text-center">
                            <h2>Related Products</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="you_make_like_slider owl-carousel">
                            <?php
                                $prod_id=$_SESSION['viewid'];
                                $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
                                $res=mysqli_query($con,"select * from products where id='$prod_id'");
                                while($row=mysqli_fetch_array($res))
                                {   $type=$row['type'];    }
                                $res2=mysqli_query($con,"select * from products where type='$type'");
                                while($row=mysqli_fetch_array($res2))
                                {   
                                    if($row['id']!=$prod_id)
                                    {
                                        $t_id=$row['id'];
                                        $imagepro= "data:image/jpeg;base64,".base64_encode($row['image1']);
                                        $namepro = $row['name'];
                                        $pricepro = $row['price'];
                                        echo'<div class="single_gallery_item">';
                                        echo '<div class="product-img">';
                                        echo "<img src='$imagepro' alt=''>";
                                        echo '</div>';
                                        echo '<div class="product-description">';
                                        echo "<h4 class'product-price'>$price Rs</h4>";
                                        echo "<p>$namepro</p>";
                                        echo '<form method="post">';
                                        echo "<input type='hidden' value='$t_id' name='pid'/>";
                                        echo '<input style="background-color: white; color: black; padding: 8px; margin: 10%; border-radius: 5px; class="add-to-cart-btn" type="submit" name="viewproduct" value="View Product" />';
                                        echo '</form>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section style="padding: 3% 10% 1% 10%; background-color: black; color: white">
            <form method="post">
                <h1 style="color: white; text-align: center">Want To Give A Review?</h1>
                <textarea placeholder="Title" rows="1" cols="50" style="margin-bottom: 5px; margin-left:auto; margin-right:auto; display:block; padding: 5px;" type="text" name="title"></textarea>
                <textarea placeholder="Your review" rows="3" cols="100" style="margin-left:auto; margin-right:auto; display:block; padding: 5px;" type="text" name="review"></textarea>
                <input style="margin-top: 12px; margin-left:auto; margin-right:auto; display:block; padding: 4px 15px 4px 15px; background-color: white; color: black" type="submit" name="addreview" value="Submit" >
            </form>
        </section>
         
        
        <!-- ****** Popular Brands Area Start ****** -->
         <section class="karl-testimonials-area section_padding_100" >
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="section_heading text-center">
                            <h2>Product reviews</h2>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    <div class="col-12 col-md-8">
                        <div class="karl-testimonials-slides owl-carousel">
                            <?php
                                    $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
                                    $res=mysqli_query($con,"select * from reviews where product_id='$prod_id'");
                                    while($row=mysqli_fetch_array($res))
                                    {   $review=$row['review_text']; 
                                        $title=$row['title'];
                                        $date=$row['published_date'];

                                        $cid=$row['customer_id'];  
                                        $res2=mysqli_query($con,"select * from customers where id='$cid'");
                                        while($row=mysqli_fetch_array($res2))
                                        {   $cname=$row['name']; } 
                                        echo '<div class="single-testimonial-area text-center">';
                                        echo '<span class="quote">"</span>';
                                        echo "<h4>$title</h4>";
                                        echo "<h6>$review</h6>";
                                        echo '<div class="testimonial-info d-flex align-items-center justify-content-center">';
                                        echo '<div class="testi-data">';
                                        echo "<h5>$cname</h5>";
                                        echo "<p>Published Date: $date</p>";
                                        echo '</div>';
                                        echo '</div>';
                                        echo '</div>';
                                    }
                                ?>
                            <div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>


        <!-- ****** Popular Brands Area End ****** -->


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