<!DOCTYPE html>
<html lang="en">
<?php
	session_start();
	if($_SESSION['admin']=="")
    {
        header('location: ../index_admin.php');
    }
	if(array_key_exists('change', $_POST))
	{
		$id=$_POST['id'];
		$con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
		$query=mysqli_query($con, "update orders set status='Delivered' where id='$id'");
	}
?>
<!-- Mirrored from educhamp.themetrades.com/demo/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Feb 2019 13:08:15 GMT -->
<head>

	<!-- META ============================================= -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	
	<!-- DESCRIPTION -->
	<meta name="description" content="EduChamp : Education HTML Template" />
	
	<!-- OG -->
	<meta property="og:title" content="EduChamp : Education HTML Template" />
	<meta property="og:description" content="EduChamp : Education HTML Template" />
	<meta property="og:image" content="" />
	<meta name="format-detection" content="telephone=no">
	
	<!-- FAVICONS ICON ============================================= -->
	<link rel="icon" href="../img/core-img/favicon.ico">
	
	<!-- PAGE TITLE HERE ============================================= -->
	<title>Your Memories | Admin Portal</title>
	
	<!-- MOBILE SPECIFIC ============================================= -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	
	<!--[if lt IE 9]>
	<script src="assets/js/html5shiv.min.js"></script>
	<script src="assets/js/respond.min.js"></script>
	<![endif]-->
	
	<!-- All PLUGINS CSS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/assets.css">
	<link rel="stylesheet" type="text/css" href="assets/vendors/calendar/fullcalendar.css">
	
	<!-- TYPOGRAPHY ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/typography.css">
	
	<!-- SHORTCODES ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/shortcodes/shortcodes.css">
	
	<!-- STYLESHEETS ============================================= -->
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="assets/css/dashboard.css">
	<link class="skin" rel="stylesheet" type="text/css" href="assets/css/color/color-1.css">
	
</head>
<body class="ttr-opened-sidebar ttr-pinned-sidebar">
	
	<!-- header start -->
	<header class="ttr-header">
		<div class="ttr-header-wrapper">
			<!--sidebar menu toggler start -->
			<div class="ttr-toggle-sidebar ttr-material-button">
				<i class="ti-close ttr-open-icon"></i>
				<i class="ti-menu ttr-close-icon"></i>
			</div>
			<!--sidebar menu toggler end -->
			<!--logo start -->
			<div class="ttr-logo-box">
				<div>
					<a href="index.php" class="ttr-logo"><h3 style="padding:10px; margin-top: 18px; background-color: white">Admin Portal</h3></a>
				</div>
			</div>
			<div class="ttr-header-right ttr-with-seperator">
				<!-- header right menu start -->
				<ul class="ttr-header-navigation">
					<li>
						<a href="../index.php" class="button_style">LOGOUT</a>
					</li>
				</ul>
				<!-- header right menu end -->
			</div>
		</div>
	</header>
	<!-- header end -->
	<!-- Left sidebar menu start -->
	<div class="ttr-sidebar">
		<div class="ttr-sidebar-wrapper content-scroll">
			<!-- side menu logo start -->
			<div class="ttr-sidebar-logo">
				<a href="index.php"><h4>Admin Portal</h4></a>
				<div class="ttr-sidebar-toggle-button">
					<i class="ti-arrow-left"></i>
				</div>
			</div>
			<!-- side menu logo end -->
			<!-- sidebar menu start -->
			<nav class="ttr-sidebar-navi">
				<ul>
					<li>
						<a href="index.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-home"></i></span>
		                	<span class="ttr-label">Dashborad</span>
		                </a>
		            </li>
					<li>
						<a href="categories.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-view-list-alt"></i></span>
		                	<span class="ttr-label">Cateories</span>
		                </a>
		            </li>
					<li>
						<a href="products.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-bookmark-alt"></i></span>
		                	<span class="ttr-label">Products</span>
		                </a>
		            </li>
					<li class="ttr-seperate"></li>
					<li>
						<a href="add-category.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-pencil-alt"></i></span>
		                	<span class="ttr-label">Add Category</span>
		                </a>
					</li>
					<li>
						<a href="delete-category.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-close"></i></span>
		                	<span class="ttr-label">Delete Category</span>
		                </a>
					</li>
					<li>
						<a href="add-product.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-pencil-alt"></i></span>
		                	<span class="ttr-label">Add Product</span>
		                </a>
					</li>
					<li>
						<a href="delete-product.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-close"></i></span>
		                	<span class="ttr-label">Delete Product</span>
		                </a>
					</li>
					<li>
						<a href="update-product.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-pencil-alt"></i></span>
		                	<span class="ttr-label">Update Product</span>
		                </a>
					</li>
					<li>
						<a href="update-category.php" class="ttr-material-button">
							<span class="ttr-icon"><i class="ti-close"></i></span>
		                	<span class="ttr-label">Update Category</span>
		                </a>
					</li>
		            <li class="ttr-seperate"></li>
				</ul>
				<!-- sidebar menu end -->
			</nav>
			<!-- sidebar menu end -->
		</div>
	</div>
	<!-- Left sidebar menu end -->

	<!--Main container start -->
	<main class="ttr-wrapper">
		<div class="container-fluid">
			<div class="db-breadcrumb">
				<h4 class="breadcrumb-title">Dashboard</h4>
				<ul class="db-breadcrumb-list">
					<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
					<li>Dashboard</li>
				</ul>
			</div>	
			<!-- Card -->
			<div class="row">
				<div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
					<div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title" style="margin-top: 8px;" >
								Total Users
							</h4>
							<?php
								$con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
								$res=mysqli_query($con,"select * from customers");
								$num=mysqli_num_rows($res);
								echo "<span class='wc-stats' > $num </span>";
							?>	
						</div>				      
					</div>
				</div>
				<div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
					<div class="widget-card widget-bg3">					 
						<div class="wc-item">
							<h4 class="wc-title" style="margin-top: 8px;" >
								Total Categories
							</h4>
							<?php
								$con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
								$res=mysqli_query($con,"select * from category");
								$num=mysqli_num_rows($res);
								echo "<span class='wc-stats ' > $num </span>";
							?>
						</div>				      
					</div>
				</div>
				<div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
					<div class="widget-card widget-bg4">					 
						<div class="wc-item">
							<h4 class="wc-title" style="margin-top: 8px;" >
								Total Products
							</h4>
							<?php
								$con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
								$res=mysqli_query($con,"select * from products");
								$num=mysqli_num_rows($res);
								echo "<span class='wc-stats' > $num </span>";
							?>	
						</div>				      
					</div>
				</div>
				<div class="col-md-6 col-lg-3 col-xl-3 col-sm-6 col-12">
					<div class="widget-card widget-bg2">					 
						<div class="wc-item">
							<h4 class="wc-title" style="margin-top: 8px;" >
								Total Reviews
							</h4>
							<?php
								$con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
								$res=mysqli_query($con,"select * from reviews");
								$num=mysqli_num_rows($res);
								echo "<span class='wc-stats' > $num </span>";
							?>	
						</div>				      
					</div>
				</div>
			</div>
			<!-- Card END -->
			<div class="row">
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
							<h3>Orders</h3>
						</div>
						<div class="widget-inner">
						<div class="orders-list">
						<ul>
						<?php
						$con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
						$res=mysqli_query($con,"select * from orders");

							while($row=mysqli_fetch_array($res))
							{
								$oid = $row['id'];
								$date= $row['delivery_date'];
								$status= $row['status'];
								$cid = $row['customer_id'];
								$name=" ";

								$res1=mysqli_query($con,"select * from customers where id='$cid'");
								while($row2=mysqli_fetch_array($res1))
								{
									$name=$row2['name'];
								}
								
								echo '<li style="margin-bottom: 20px;">';
								echo '<span class="orders-title">';
								echo "<a class='orders-title-name'>$name</a>";
								echo "<span class='orders-info'>Order: $oid | Date: $date</span>";
								echo '</span>';
								echo '<span class="orders-btn">';
								echo '<form method="post">';
								echo "<input name='id' type='hidden' value='$oid'>";
								echo "<input class='btn button-sm red' name='change' type='submit' value='$status'>";
								echo '</form>';
								echo '</span>';
								echo '</li>';
							} 
						?>
						
						</ul>
						</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12 m-b30">	
					<div class="widget-box">
						<div class="wc-title">
							<h3>Products</h3>
						</div>
						<div class="widget-inner">
							<div class="orders-list">
								<ul>
								<?php
									$con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
									$res=mysqli_query($con,"select * from products");

									while($row=mysqli_fetch_array($res))
									{
										$pro_name = $row['name'];
										$pro_price = $row['price'];
										$pro_quan = $row['quantity'];

										echo '<li>';
										echo '<span class="orders-title">';
										echo "<a class='orders-title-name'>$pro_name</a>";
										echo "<p class='orders-info'>Price: $pro_price | Quantity: $pro_quan </p>";
										echo '</span>';
										echo '</li>';
									} 
								?>
								</ul>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-12 m-b30">	
					<div class="widget-box">
						<div class="wc-title">
							<h3>Categories</h3>
						</div>
						<div class="widget-inner">
							<div class="orders-list">
								<ul>
								<?php
									$con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');
									$res=mysqli_query($con,"select * from category");

									while($row=mysqli_fetch_array($res))
									{
										$cat_name = $row['name'];

										echo '<li>';
										echo '<span class="orders-title">';
										echo "<a class='orders-title-name'>$cat_name</a>";
										echo '</span>';
										echo '</li>';
									} 
								?>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<div class="ttr-overlay"></div>

<!-- External JavaScripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/vendors/bootstrap/js/popper.min.js"></script>
<script src="assets/vendors/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/vendors/bootstrap-select/bootstrap-select.min.js"></script>
<script src="assets/vendors/bootstrap-touchspin/jquery.bootstrap-touchspin.js"></script>
<script src="assets/vendors/magnific-popup/magnific-popup.js"></script>
<script src="assets/vendors/counter/waypoints-min.js"></script>
<script src="assets/vendors/counter/counterup.min.js"></script>
<script src="assets/vendors/imagesloaded/imagesloaded.js"></script>
<script src="assets/vendors/masonry/masonry.js"></script>
<script src="assets/vendors/masonry/filter.js"></script>
<script src="assets/vendors/owl-carousel/owl.carousel.js"></script>
<script src='assets/vendors/scroll/scrollbar.min.js'></script>
<script src="assets/js/functions.js"></script>
<script src="assets/vendors/chart/chart.min.js"></script>
<script src="assets/js/admin.js"></script>
<script src='assets/vendors/calendar/moment.min.js'></script>
<script src='assets/vendors/calendar/fullcalendar.js'></script>
<script src='assets/vendors/switcher/switcher.js'></script>
</body>

<!-- Mirrored from educhamp.themetrades.com/demo/admin/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Feb 2019 13:09:05 GMT -->
</html>