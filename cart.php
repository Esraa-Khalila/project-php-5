<?php 



try {
    $connection = new PDO('mysql:host=localhost;dbname=library' , 'root' , '');
	
$GLOBALS['db'] = $connection;
} 
catch (PDOEexception $e) {
echo 'not connect ' . $e.getMessage(); 
}

// foreach($_SESSION['Cart'] as $key => $v){
// if(isset($_POST['quantity'])){
// 	$index="'". $v['cart_id'];
// 	echo '
// 	<h1>'.$_POST[$index] .$_POST['quantity'].'</h1>
// 	';
// }
// }


session_start();


if (isset($_POST['update'])) {
	if (isset($_SESSION['Cart'])) {
	  $i = 1;
	  
	  foreach ($_SESSION['Cart'] as $keys => $values) {
		$_SESSION["Cart"][$keys]['quantity'] = $_POST['quantity'.$i];
		$_SESSION["Cart"][$keys]['total'] = $values['pro_price'] * $_POST['quantity'.$i];
		$i++;
	  }
	
}
}

if(isset($_GET['actiona'])){
	
	$pro_id = $_GET['pro_id'];
	$q = "
	SELECT * FROM `product` WHERE product_id = $pro_id
	";
	$result = $GLOBALS['db']->query($q); 
	$row=$result->fetch(PDO::FETCH_ASSOC);
	
	
	if(isset($_GET['pro_id'])){
		


			$pro_id = $row['product_id'];
			$quantity = 1 ; 
			$op = true ; 
			$pro_name = $row['product_name'];
			$total = $row['price'];
			$pro_img = $row['url_image'];
			$pro_price = $row['price'];
	
			$product = array
			( 
			"cart_id" => "$pro_id" ,
			"total" => "$total",
			"quantity"=>"$quantity" ,
			"pro_id" => "$pro_id",
			"pro_name" => "$pro_name",
			"pro_price" => "$pro_price",
			"pro_img" => "$pro_img"
			); 
			
			foreach($_SESSION['Cart'] as $key => $value ){
				if($value["pro_id"] == $pro_id ) {
					$_SESSION['Cart'][$key]['quantity'] =$value["quantity"]+= 1;
					$_SESSION['Cart'][$key]['total'] = $value['pro_price'] *=   $value["quantity"];
					$op =false ; 
				}
			 }
			
			
		   if($op){
			array_push($_SESSION['Cart'] , $product);
		   }
		}
	}


function AddToCart(){
   
      
	$pro_id = $_GET['pro_id'];
	$quantity = 1 ; 
	$op = true ; 
	$pro_name = $_GET['pro_name'];
	$total = $_GET['pro_price'];
	$pro_img = $_GET['pro_img'];
	$pro_price = $_GET['pro_price'];

	$product = array
	( 
	"cart_id" => "$pro_id" ,
	"total" => "$total",
	"quantity"=>"$quantity" ,
	"pro_id" => "$pro_id",
	"pro_name" => "$pro_name",
	"pro_price" => "$pro_price",
	"pro_img" => "$pro_img"
	); 
	
	foreach($_SESSION['Cart'] as $key => $v ){
		if($v["pro_id"] == $pro_id ) {
			$_SESSION['Cart'][$key]['quantity'] =$v["quantity"]+= 1;
			$_SESSION['Cart'][$key]['total'] = $v['pro_price'] *=   $v["quantity"];
			$op =false ; 
		}
	 }
	
	
   if($op){
	array_push($_SESSION['Cart'] , $product);
   }
}

function RemoveFromCart(){

	foreach($_SESSION['Cart'] as $key => $v){
		if($v['cart_id'] == $_GET['cart_id'] ){
			unset($_SESSION['Cart'][$key]);
		}
	}
	
	}    
	
	if(isset($_GET['actiond'])){
	RemoveFromCart();
	}






function ViewCartData(){
	print_r($_SESSION['Cart']);

	 $i=1 ;
	if(isset($_SESSION['Cart'])){

		foreach ($_SESSION['Cart'] as $v) {
      
					echo '
					<tr class="table-body-row">
					
					<td class="product-remove"><a href="?actiond=true&cart_id='.$v['cart_id'].'"><i class="far fa-window-close"></i></a></td>
					<td class="product-image"><img src="assets/img/products/product-img-3.jpg" alt=""></td>
					<td class="product-name">'.$v['pro_name'].'</td>
					<td class="product-price">$'.$v['pro_price'].'</td>
					<td class="product-quantity"><input type="number" min="1" value="'.$v['quantity'].'" name="quantity<?php echo $i?>"></td>
					<td class="product-total">'.$v['total'].'</td>
					<td class="product-total"><a class="cart-buttons" href = "?cart_id='.$v['cart_id'].'">update</a></td>
				</tr>
				
					';
					$i++ ;
			}
			
	}
	
	}


	
	




	

?>







<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="description" content="Responsive Bootstrap4 Shop Template, Created by Imran Hossain from https://imransdesign.com/">

	<!-- title -->
	<title>Cart</title>

	<!-- favicon -->
	<link rel="shortcut icon" type="image/png" href="assets/img/favicon.png">
	<!-- google font -->
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
	<!-- fontawesome -->
	<link rel="stylesheet" href="css/all.min.css">
	<!-- bootstrap -->
	<link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
	<!-- owl carousel -->
	<link rel="stylesheet" href="css/owl.carousel.css">
	<!-- magnific popup -->
	<link rel="stylesheet" href="css/magnific-popup.css">
	<!-- animate css -->
	<link rel="stylesheet" href="css/animate.css">
	<!-- mean menu css -->
	<link rel="stylesheet" href="css/meanmenu.min.css">
	<!-- main style -->
	<link rel="stylesheet" href="css/main.css">
	<!-- responsive -->
	<link rel="stylesheet" href="css/responsive.css">

</head>
<body>
	
	<!--PreLoader-->
    <div class="loader">
        <div class="loader-inner">
            <div class="circle"></div>
        </div>
    </div>
    <!--PreLoader Ends-->
	
	<!-- header -->
	<div class="top-header-area" id="sticker">
		<div class="container">
			<div class="row">
				<div class="col-lg-12 col-sm-12 text-center">
					<div class="main-menu-wrap">
						<!-- logo -->
						<div class="site-logo">
							<a href="index.html">
								<img src="assets/img/logo.png" alt="">
							</a>
						</div>
						<!-- logo -->

						<!-- menu start -->
						<nav class="main-menu">
							<ul>
								<li class="current-list-item"><a href="#">Home</a>
									<ul class="sub-menu">
										<li><a href="index.html">Static Home</a></li>
										<li><a href="index_2.html">Slider Home</a></li>
									</ul>
								</li>
								<li><a href="about.html">About</a></li>
								<li><a href="#">Pages</a>
									<ul class="sub-menu">
										<li><a href="404.html">404 page</a></li>
										<li><a href="about.html">About</a></li>
										<li><a href="cart.html">Cart</a></li>
										<li><a href="checkout.html">Check Out</a></li>
										<li><a href="contact.html">Contact</a></li>
										<li><a href="news.html">News</a></li>
										<li><a href="shop.html">Shop</a></li>
									</ul>
								</li>
								<li><a href="news.html">News</a>
									<ul class="sub-menu">
										<li><a href="news.html">News</a></li>
										<li><a href="single-news.html">Single News</a></li>
									</ul>
								</li>
								<li><a href="contact.html">Contact</a></li>
								<li><a href="shop.html">Shop</a>
									<ul class="sub-menu">
										<li><a href="shop.html">Shop</a></li>
										<li><a href="checkout.html">Check Out</a></li>
										<li><a href="single-product.html">Single Product</a></li>
										<li><a href="cart.html">Cart</a></li>
									</ul>
								</li>
								<li>
									<div class="header-icons">
										<a class="shopping-cart" href="cart.php"><i class="fas fa-shopping-cart"></i></a>
										<a class="mobile-hide search-bar-icon" href="#"><i class="fas fa-search"></i></a>
									</div>
								</li>
							</ul>
						</nav>
						<a class="mobile-show search-bar-icon" href="#"><i class="fas fa-search"></i></a>
						<div class="mobile-menu"></div>
						<!-- menu end -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end header -->

	<!-- search area -->
	<div class="search-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<span class="close-btn"><i class="fas fa-window-close"></i></span>
					<div class="search-bar">
						<div class="search-bar-tablecell">
							<h3>Search For:</h3>
							<input type="text" placeholder="Keywords">
							<button type="submit">Search <i class="fas fa-search"></i></button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end search arewa -->
	
	<!-- breadcrumb-section -->
	<div class="breadcrumb-section breadcrumb-bg">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 offset-lg-2 text-center">
					<div class="breadcrumb-text">
						<p>Fresh and Organic</p>
						<h1>Cart</h1>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end breadcrumb section -->

	<!-- cart -->
	<form action="" method="post">
	<div class="cart-section mt-150 mb-150">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-12">
					<div class="cart-table-wrap">
						<table class="cart-table">
							<thead class="cart-table-head">
								<tr class="table-head-row">
									<th class="product-remove"></th>
									<th class="product-image">Product Image</th>
									<th class="product-name">Name</th>
									<th class="product-price">Price</th>
									<th class="product-quantity">Quantity</th>
									<th class="product-total">Total</th>
								
								</tr>
							</thead>
							<tbody>
				
						<?php

						if(isset($_SESSION['Cart'])){
							$i=1 ;

      foreach ($_SESSION['Cart'] as $v) {

			?>
			<tr class="table-body-row">
			
			<td class="product-remove"><a href="?actiond=true&cart_id='.$v['cart_id'].'"><i class="far fa-window-close"></i></a></td>
			<td class="product-image"><img src="assets/img/products/product-img-3.jpg" alt=""></td>
			<td class="product-name"><?php echo $v['pro_name'];?></td>
			<td class="product-price"><?php echo $v['pro_price'];?></td>
			<td class="product-quantity"><input type="number" min="1" value="<?php echo $v['quantity']?>" name="quantity<?php echo $i?>"></td>
			<td class="product-total"><?php echo $v['total'];?></td>
			
		</tr>
		
		<?php
			$i++ ;
	}
	
}
?>

							</tbody>
						</table>
					</div>
				</div>

				<div class="col-lg-4">
					<div class="total-section">
						<table class="total-table">
							<thead class="total-table-head">
								<tr class="table-total-row">
									<th>Total</th>
									<th>Price</th>
								</tr>
							</thead>
							<tbody>
								<tr class="total-data">
									<td><strong>Subtotal: </strong></td>
									
									<td><?php
                    if (isset($_SESSION['Cart'])) {
                      $total = 0;
                      foreach ($_SESSION['Cart'] as $keys => $values) {
                        $total += $values['total'] ;
                      }
                      echo $total;
                    }
                    ?></td>

								</tr>
								<tr class="total-data">
									<td><strong> Taxes: </strong></td>
									<td> <?php
                    if (isset($_SESSION['Cart'])) {
                      $total = 0;
                      foreach ($_SESSION['Cart'] as $keys => $values) {
                        $total +=(10*$values['total']/100);
                      }
                      echo $total;
                    }
                    ?> </td>
								</tr>
								
								<tr class="total-data">
									<td><strong>Total: </strong></td>
									<td><?php
                    if (isset($_SESSION['Cart'])) {
                      $total = 0;
                      foreach ($_SESSION['Cart'] as $keys => $values) {
                        $total += $values['total']+(10*$values['total']/100);
                      }
                      echo $total;
                    }
                    ?></td>
								</tr>
							</tbody>
						</table>
						<div class="cart-buttons">
							<input  type="submit" class="boxed-btn" value ="Update Cart" name="update">
							
							<a href="checkout.php" class="boxed-btn black">Check Out</a>
						</div>
					</div>

					<div class="coupon-section">
						<!-- <h3>Apply Coupon</h3>
						<div class="coupon-form-wrap">
							<form action="index.html">
								<p><input type="text" placeholder="Coupon"></p>
								<p><input type="submit" value="Apply"></p> -->
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
	<!-- end cart -->

	<!-- logo carousel -->
	<div class="logo-carousel-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<div class="logo-carousel-inner">
						<div class="single-logo-item">
							<img src="assets/img/company-logos/1.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/2.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/3.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/4.png" alt="">
						</div>
						<div class="single-logo-item">
							<img src="assets/img/company-logos/5.png" alt="">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end logo carousel -->

	<!-- footer -->
	<div class="footer-area">
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-6">
					<div class="footer-box about-widget">
						<h2 class="widget-title">About us</h2>
						<p>Ut enim ad minim veniam perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae.</p>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box get-in-touch">
						<h2 class="widget-title">Get in Touch</h2>
						<ul>
							<li>34/8, East Hukupara, Gifirtok, Sadan.</li>
							<li>support@fruitkha.com</li>
							<li>+00 111 222 3333</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box pages">
						<h2 class="widget-title">Pages</h2>
						<ul>
							<li><a href="index.html">Home</a></li>
							<li><a href="about.html">About</a></li>
							<li><a href="services.html">Shop</a></li>
							<li><a href="news.html">News</a></li>
							<li><a href="contact.html">Contact</a></li>
						</ul>
					</div>
				</div>
				<div class="col-lg-3 col-md-6">
					<div class="footer-box subscribe">
						<h2 class="widget-title">Subscribe</h2>
						<p>Subscribe to our mailing list to get the latest updates.</p>
						<form action="index.html">
							<input type="email" placeholder="Email">
							<button type="submit"><i class="fas fa-paper-plane"></i></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end footer -->
	
	<!-- copyright -->
	<div class="copyright">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-12">
					<p>Copyrights &copy; 2019 - <a href="https://imransdesign.com/">Imran Hossain</a>,  All Rights Reserved.</p>
				</div>
				<div class="col-lg-6 text-right col-md-12">
					<div class="social-icons">
						<ul>
							<li><a href="#" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-twitter"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-instagram"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-linkedin"></i></a></li>
							<li><a href="#" target="_blank"><i class="fab fa-dribbble"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end copyright -->
	
	<!-- jquery -->
	<script src="js/jquery-1.11.3.min.js"></script>
	<!-- bootstrap -->
	<script src="bootstrap/js/bootstrap.min.js"></script>
	<!-- count down -->
	<script src="js/jquery.countdown.js"></script>
	<!-- isotope -->
	<script src="js/jquery.isotope-3.0.6.min.js"></script>
	<!-- waypoints -->
	<script src="js/waypoints.js"></script>
	<!-- owl carousel -->
	<script src="js/owl.carousel.min.js"></script>
	<!-- magnific popup -->
	<script src="js/jquery.magnific-popup.min.js"></script>
	<!-- mean menu -->
	<script src="js/jquery.meanmenu.min.js"></script>
	<!-- sticker js -->
	<script src="js/sticker.js"></script>
	<!-- main js -->
	<script src="js/main.js"></script>

</body>
</html>