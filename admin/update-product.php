<!DOCTYPE html>
<?php
	session_start();
	if($_SESSION['admin']=="")
    {
        header('location: ../index_admin.php');
    }
if($_POST)
{
	$name = $_POST['name'];
	$name = str_replace( array( '-', '|', '&','\'', '"',',' , ';', '<', '=', '>' ), ' ', $name);
	$price = $_POST['price'];
	$price = str_replace( array( '-', '|', '&','\'', '"',',' , ';', '<', '=', '>' ), ' ', $price);
	$description = $_POST['description'];
	$description = str_replace( array( '-', '|', '&','\'', '"',',' , ';', '<', '=', '>' ), ' ', $description);
	$type = $_POST['type'];
	$type = str_replace( array( '-', '|', '&','\'', '"',',' , ';', '<', '=', '>' ), ' ', $type);
	$quantity = $_POST['quantity'];
	$quantity = str_replace( array( '-', '|', '&','\'', '"',',' , ';', '<', '=', '>' ), ' ', $quantity);

	$image1 = addslashes(file_get_contents($_FILES['image1']['tmp_name']));
	$image2 = addslashes(file_get_contents($_FILES['image2']['tmp_name']));
	$image3 = addslashes(file_get_contents($_FILES['image3']['tmp_name']));

    $con = mysqli_connect('localhost','root','','yourmemories') or die('Unable To connect');

	if($name!="" && $price!="" && $description!="" && $type!="" && $quantity!="" && $image1!="" && $image2!="" && $image3!="")
	{
		$query= "select * from products where name='$name'";
		$check = mysqli_query($con, $query);
		$num = mysqli_num_rows($check);

		if($num==1)
		{
			$query2= "select * from category where name='$type'";
			$check2 = mysqli_query($con, $query2);
			$num2 = mysqli_num_rows($check2);

			if($num2!=0)
			{
				$sql = "update products set price='$price', description='$description', quantity='$quantity' where name='$name'";
	
				if(mysqli_query($con, $sql)){
					echo '<script>alert("Product Added Successfully")</script>';
				}else{
					echo '<script>alert("Product is not Added")</script>';
				}
			}
			else
			{
				echo '<script>alert("Category Not Found")</script>'; 
			}
		}
		else
		{
			echo '<script>alert("Product Not Found")</script>'; 
		}
	}
	else
	{
		echo '<script>alert("All Field Are Required To Be Filled")</script>'; 
	}
	mysqli_close($con);
}
?>


<html lang="en">

<!-- Mirrored from educhamp.themetrades.com/demo/admin/add-listing.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Feb 2019 13:09:05 GMT -->
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
	<title>Update Product | Admin Portal</title>
	
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
				<h4 class="breadcrumb-title">Update Product</h4>
				<ul class="db-breadcrumb-list">
					<li><a href="#"><i class="fa fa-home"></i>Home</a></li>
					<li>Update Product</li>
				</ul>
			</div>	
			<div class="row">
				<!-- Your Profile Views Chart -->
				<div class="col-lg-12 m-b30">
					<div class="widget-box">
						<div class="wc-title">
							<h4>Update Product</h4>
						</div>
						<div class="widget-inner">
							<form class="edit-profile m-b30" method="post" enctype="multipart/form-data">
								<div class="row">
									<div class="col-12">
										<div class="ml-auto">
											<h3>Change Details</h3>
										</div>
									</div>
									<div class="form-group col-6">
										<label class="col-form-label">Product Name</label>
										<div>
											<input class="form-control" type="text" value="" name="name">
										</div>
									</div>
									<div class="form-group col-6">
										<label class="col-form-label">Product Price</label>
										<div>
											<input class="form-control" type="number" value="" name="price">
										</div>
									</div>
									<div class="form-group col-6">
										<label class="col-form-label">Product Description</label>
										<div>
											<input class="form-control" type="text" value="" name="description">
										</div>
									</div>
									<div class="form-group col-6">
										<label class="col-form-label">Product Type</label>
										<div>
											<input class="form-control" type="text" value="" name="type">
										</div>
									</div>
									<div class="form-group col-6">
										<label class="col-form-label">Product Quantity</label>
										<div>
											<input class="form-control" type="number" value="" name="quantity">
										</div>
									</div>
									<div class="form-group col-6">
										<label class="col-form-label">Product Image 1 (Image Format Should be JPEG)</label>
										<div>
											<input type="file" name="image1" id="image1" />
										</div>
									</div>
									</br>
									<div class="form-group col-6">
										<label class="col-form-label">Product Image 2 (Image Format Should be JPEG)</label>
										<div>
											<input type="file" name="image2" id="image2" />
										</div>
									</div>
									<br>
									<div class="form-group col-6">
										<label class="col-form-label">Product Image 3 (Image Format Should be JPEG)</label>
										<div>
											<input type="file" name="image3" id="image3" />
										</div>
									</div>
									<div class="col-12">
    									<input type="submit" class="btn" value="Update" name="insert"></input>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
				<!-- Your Profile Views Chart END-->
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
<script src='assets/vendors/switcher/switcher.js'></script>
<script>
// Pricing add
	function newMenuItem() {
		var newElem = $('tr.list-item').first().clone();
		newElem.find('input').val('');
		newElem.appendTo('table#item-add');
	}
	if ($("table#item-add").is('*')) {
		$('.add-item').on('click', function (e) {
			e.preventDefault();
			newMenuItem();
		});
		$(document).on("click", "#item-add .delete", function (e) {
			e.preventDefault();
			$(this).parent().parent().parent().parent().remove();
		});
	}
</script>
</body>

<!-- Mirrored from educhamp.themetrades.com/demo/admin/add-listing.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 22 Feb 2019 13:09:05 GMT -->
</html>