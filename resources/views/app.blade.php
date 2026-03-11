<!DOCTYPE html>
<html lang="en">

<head>

	<!-- Title -->
	<title></title>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="DexignZone">

	<meta name="format-detection" content="telephone=no">

	<!-- Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Favicon icon -->



	<!-- Stylesheet -->
	<link href="{{asset("fs/assets/vendor/animate/animate.css")}}" rel="stylesheet">
	<link href="{{asset("fs/assets/vendor/magnific-popup/magnific-popup.min.css")}}" rel="stylesheet">
	<link href="{{asset("fs/assets/vendor/swiper/swiper-bundle.min.css")}}" rel="stylesheet">
	<link href="{{asset("fs/assets/vendor/bootstrap-select/css/bootstrap-select.min.css")}}" rel="stylesheet">


	<!-- Custom Stylesheet -->
	<link rel="stylesheet" href="{{asset('fs/assets/vendor/rangeslider/rangeslider.css')}}">
	<link rel="stylesheet" href="{{asset('fs/assets/vendor/switcher/switcher.css')}}">
	<link rel="stylesheet" href="{{asset('fs/assets/css/style.css')}}">


	<!-- Google Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com/">
	<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Lobster&amp;family=Lobster+Two:ital,wght@0,400;0,700;1,400;1,700&amp;family=Poppins:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"
		rel="stylesheet">

</head>

<body id="bg">

	<div class="page-wraper">

	     @yield("content")
  

		<!--Footer-->
		<footer class="site-footer style-1 bg-dark" id="footer">
			<div class="footer-top">
				<div class="container">

					<div class="row justify-content-center">
						<div class="col-md-6 text-center">
							<div class="footer-custom"><img src="{{asset('fs/assets/img/logo.png')}}" alt="FINTESA Logo" class="logo" />
								<p>Get your favorite meals delivered fast from top local restaurants. Choose from
									multiple cuisines, track your order live, and pay easily with UPI, cards, or cash.
									Delicious food, quick delivery, and unbeatable convenience — all in one app!</p>

								<ul class="ulbo-footer">
									<li><a href="/terms-and-conditions"><span>Terms & Conditions</span></a></li>
									<li><a href="/privacy-policy"><span> Privacy Policy </span></a></li>

								</ul>

								<div class="store-buttons m-t30">
									<a href="#"><img
											src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg"
											alt="App Store"></a>
									<a href="#"><img
											src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg"
											alt="Google Play"></a>
								</div>
							</div>

						</div>
					</div>

				</div>
			</div>
			<!-- Footer Bottom Part -->
			<div class="container">
				<div class="footer-bottom">
					<div class="row">
						<div class="col-xl-12 col-md-12 text-center">
							<p>Copyright <span class="current-year">2025</span> All rights reserved.</p>
						</div>

					</div>
				</div>
			</div>
			<img class="bg1 dz-move" src="{{asset('fs/assets/images/background/pic5.png')}}" alt="/">
			<img class="bg2 dz-move" src="{{asset('fs/assets/images/background/pic6.png')}}" alt="/">
		</footer>

		<div class="scroltop-progress scroltop-primary">
			<svg width="100%" height="100%" viewBox="-1 -1 102 102">
				<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
			</svg>
		</div>

	</div>
	<!-- JAVASCRIPT FILES ========================================= -->
	<script src="{{asset('fs/assets/js/jquery.min.js')}}"></script><!-- JQUERY.MIN JS -->
	<script src="{{asset('fs/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script><!-- BOOTSTRAP.MIN JS -->
	<script src="{{asset('fs/assets/vendor/bootstrap-select/js/bootstrap-select.min.js')}}"></script><!-- BOOTSTRAP SELEECT -->
	<script src="{{asset('fs/assets/vendor/magnific-popup/magnific-popup.js')}}"></script><!-- MAGNIFIC POPUP JS -->
	<script src="{{asset('fs/assets/vendor/masonry/masonry-4.2.2.js')}}"></script><!-- MASONRY -->
	<script src="{{asset('fs/assets/vendor/masonry/isotope.pkgd.min.js')}}"></script><!-- ISOTOPE -->
	<script src="{{asset('fs/assets/vendor/imagesloaded/imagesloaded.js')}}"></script><!-- IMAGESLOADED -->
	<script src="{{asset('fs/assets/vendor/counter/waypoints-min.js')}}"></script><!-- WAYPOINTS JS -->
	<script src="{{asset('fs/assets/vendor/wow/wow.js')}}"></script><!-- WOW JS -->
	<script src="{{asset('fs/assets/vendor/counter/counterup.min.js')}}"></script><!-- COUNTERUP JS -->
	<script src="{{asset('fs/assets/vendor/swiper/swiper-bundle.min.js')}}"></script><!-- OWL-CAROUSEL -->
	<script src="{{asset('fs/assets/vendor/popper/popper.js')}}"></script><!-- Popper -->
	<!-- <script src="fs/assets/vendor/tempus-dominus/js/tempus-dominus.min.js"></script> -->
	<script src="{{asset('fs/assets/js/dz.carousel.min.js')}}"></script>




</body>

</html>