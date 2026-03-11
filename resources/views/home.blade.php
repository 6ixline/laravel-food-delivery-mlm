@extends("app")
@section('content')

		<!-- Header -->
		<header class="site-header mo-left header header-transparent transparent-white style-2">
			<!-- Main Header -->
			<div class="sticky-header main-bar-wraper navbar-expand-lg">
				<div class="main-bar clearfix ">
					<div class="container-fluid clearfix">

						<!-- Website Logo -->
						<div class="logo-header mostion">
							<a href="index.html" class="anim-logo"><img src="{{asset('fs/assets/img/logo.png')}}" alt="/"></a>
						</div>

						<!-- Nav Toggle Button -->
						<!-- <button
							class="navbar-toggler navbar-toggler navbar-toggler collapsed navicon justify-content-end"
							type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
							aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
							<span></span>
							<span></span>
							<span></span>
						</button> -->



						<!-- <div class="extra-nav">
							<div class="extra-cell">
								<a href="#" class="app-download-btn">
									<i class="fa fa-download"></i> Download the App
								</a>
							</div>
						</div> -->


					</div>
				</div>
			</div>
			<!-- Main Header End -->
		</header>

		<!-- Header -->

		<!-- bg-white -->
		<div class="page-content ">
			<!-- Banner -->
			<div class="main-bnr-four overflow-hidden  video-section">
				<div class="container section-content">
					<div class="banner-inner">
						<div class="row m-t40">
							<div class="col-lg-7  mb-lg-0 d-flex justify-content-center align-items-center">
								<div class="banner-content mb-0">
									<h1 class="title wow fadeInUp text-light" data-wow-delay="0.4s"> <span
											class="text-secondary">Delicious </span> Food <span
											class="text-primary">Delivered</span> to Your Doorstep</h1>
									<p class="wow fadeInUp text-light" data-wow-delay="0.6s">Order from your favorite
										local
										restaurants and enjoy hot, fresh meals delivered to your door in just minutes —
										anytime, anywhere, with just a few taps on your phone.
									</p>
									<div class="banner-btn d-flex align-items-center wow fadeInUp"
										data-wow-delay="0.8s">
										<div class="store-buttons">
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
							<div class="col-lg-5">
								<div class="banner-media1">
									<img src="{{asset('fs/assets/img/img-001.png')}}" class="img-fluid" alt="">

								</div>
							</div>
						</div>
					</div>
				</div>

				<video class="video-background section-video" poster="{{asset('fs/assets/img/pic3.jpg')}}" autoplay muted loop>
					<source src="{{asset('fs/assets/img/33256-396487978_medium.mp4')}}" type="video/mp4">
				</video>



			</div>
			<!--Banner-->





			<!--Today's Menu-->
			<section class="content-inner-1 ">
				<div class="container">

					<div class="section-head text-center">
						<!-- <h2 class="title wow flipInX" data-wow-delay="0.2s">Key Features</h2> -->
						<h2 class="highlighter wow flipInX" data-wow-delay="0.2s">Key Features</h2>
						<h4 class="title-custom">Smart Features That Make <br>Every Order Seamless.</h4>
					</div>
					<!-- Icon Wrapper 1 -->
					<div class="icon-wrapper1">
						<div class="row wow fadeInUp" data-wow-delay="0.2s">
							<div class="col-lg-3 col-md-6 col-sm-6">
								<div class="icon-bx-wraper style-1 box-hover center"
									style="background-image: url({{asset('fs/assets/images/gallery/grid/pic1.jpg')}})">
									<div class="inner-content">
										<div class="icon-bx m-b25">
											<span class="icon-cell icon-md">
												<img src="{{asset('fs/assets/img/delivery.png')}}" class="img-fluid" alt="">
											</span>
										</div>
										<div class="icon-content">
											<h5 class="dz-title">Fast Delivery</h5>
											<p>Lightning-fast delivery in under 30 minutes.</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-6">
								<div class="icon-bx-wraper style-1 box-hover center"
									style="background-image: url({{asset('fs/assets/images/gallery/grid/pic2.jpg')}})">
									<div class="inner-content">
										<div class="icon-bx m-b25">
											<span class="icon-cell icon-md">
												<img src="{{asset('fs/assets/img/route.png')}}" class="img-fluid" alt="">
											</span>
										</div>
										<div class="icon-content">
											<h5 class="dz-title">Live Tracking</h5>
											<p>Track your order in real time.</p>
										</div>
									</div>
								</div>

							</div>
							<div class="col-lg-3 col-md-6 col-sm-6">
								<div class="icon-bx-wraper style-1 box-hover center"
									style="background-image: url({{asset('fs/assets/images/gallery/grid/pic3.jpg')}})">
									<div class="inner-content">
										<div class="icon-bx m-b25">
											<span class="icon-cell icon-md">
												<img src="{{asset('fs/assets/img/healthy-food.png')}}" class="img-fluid" alt="">
											</span>
										</div>
										<div class="icon-content">
											<h5 class="dz-title">Multiple Cuisines</h5>
											<p>From Indian to Italian – all at your fingertips</p>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-3 col-md-6 col-sm-6">
								<div class="icon-bx-wraper style-1 box-hover center"
									style="background-image: url({{asset('fs/assets/images/gallery/grid/pic4.jpg')}})">
									<div class="inner-content">
										<div class="m-b25">
											<span class="icon-cell icon-md">
												<img src="{{asset('fs/assets/img/credit-card.png')}}" class="img-fluid" alt="">
											</span>
										</div>
										<div class="icon-content">
											<h5 class="dz-title">Easy Payment</h5>
											<p>Pay via card, UPI</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Icon Wrapper 1 -->
				</div>

			</section>
			<!--Today's Menu-->

			<!-- Are Menu-->
			<section class="content-inner-1">
				<div class="container">
					<div class="section-head text-center">
						<!-- <h2 class="title wow flipInX" data-wow-delay="0.2s">App Screens Preview</h2> -->
						<h2 class="highlighter wow flipInX" data-wow-delay="0.2s">App Screens Preview</h2>
						<h4 class="title-custom">Your Food Journey Starts <br> Here — Visually.</h4>
					</div>
					<div class="row">
						<div class="col-lg-12 text-center ">
							<div class="swiper-btn-lr">
								<div class="swiper portfolio-swiper">
									<div class="swiper-wrapper">
										<div class="swiper-slide">
											<div class="dz-img-box style-1 wow fadeInUp" data-wow-delay="0.4s">
												<div class="dz-media">
													<img src="{{asset('fs/assets/img/screen-1.png')}}" alt="/">
												</div>

											</div>
										</div>
										<div class="swiper-slide">
											<div class="dz-img-box style-1 wow fadeInUp" data-wow-delay="0.6s">
												<div class="dz-media">
													<img src="{{asset('fs/assets/img/screen-2.png')}}" alt="/">
												</div>

											</div>
										</div>
										<div class="swiper-slide">
											<div class="dz-img-box style-1 wow fadeInUp" data-wow-delay="0.8s">
												<div class="dz-media">
													<img src="{{asset('fs/assets/img/screen-3.png')}}" alt="/">
												</div>

											</div>
										</div>
										<div class="swiper-slide">
											<div class="dz-img-box style-1 wow fadeInUp" data-wow-delay="0.10s">
												<div class="dz-media">
													<img src="{{asset('fs/assets/img/screen-4.png')}}" alt="/">
												</div>

											</div>
										</div>
										<div class="swiper-slide">
											<div class="dz-img-box style-1 wow fadeInUp" data-wow-delay="0.4s">
												<div class="dz-media">
													<img src="{{asset('fs/assets/img/screen-5.png')}}" alt="/">
												</div>


											</div>
										</div>

									</div>
								</div>
								<div class="pagination mt-xl-0 m-t40">
									<div class="img-button-prev btn-prev-long"><i class="fa-solid fa-arrow-left"></i>
									</div>
									<div class="img-button-next btn-next-long"><i class="fa-solid fa-arrow-right"></i>
									</div>
								</div>
							</div>
						</div>

					</div>

				</div>
			</section>
			<!-- Are Menu-->


			<section class="content-inner ">
				<div class="container">
					<div class="section-head text-center">
						<!-- <h2 class="title">How It Works </h2> -->
						<h2 class="highlighter wow flipInX" data-wow-delay="0.2s">How It Works</h2>
						<h4 class="title-custom">Delicious Meals Are Just a <br>Few Clicks Away.</h4>
					</div>
					<div class="row">
						<div class="col-lg-4 col-sm-6 m-b30">
							<div class="icon-bx-wraper style-3">
								<div class="icon-bx">
									<div class="icon-cell">
										<img src="{{asset('fs/assets/img/restaurant.png')}}" class="img-fluid" alt="">
									</div>
								</div>
								<div class="icon-content">
									<h5 class="title"><a href="#">Browse Dishes</a></h5>
									<p>Discover your favorite dishes. </p>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-sm-6 m-b30">
							<div class="icon-bx-wraper style-3">
								<div class="icon-bx">
									<div class="icon-cell">
										<img src="{{asset('fs/assets/img/rice.png')}}" class="img-fluid" alt="">
									</div>
								</div>
								<div class="icon-content">
									<h5 class="title"><a href="#">Choose Your Dish </a></h5>
									<p>Pick from a wide variety of meals.</p>
								</div>
							</div>
						</div>
						<div class="col-lg-4 col-sm-6 m-b30">
							<div class="icon-bx-wraper style-3">
								<div class="icon-bx">
									<div class="icon-cell">
										<img src="{{asset('fs/assets/img/choices.png')}}" class="img-fluid" alt="">
									</div>
								</div>
								<div class="icon-content">
									<h5 class="title"><a href="#">Place Your Order</a></h5>
									<p>Enjoy quick delivery at your door.</p>
								</div>
							</div>
						</div>

					</div>
				</div>
			</section>

			<!-- Are Menu-->
			<section class="content-inner-1 content-inner-1 overflow-hidden " style="background:#c599584a;">
				<div class="container">
					<div class="section-head text-center">

						<h2 class="highlighter wow flipInX" data-wow-delay="0.2s">Why Choose Us</h2>
						<h4 class="title-custom">Not Just Delivery—It’s a <br>Food Experience.</h4>
					</div>
					<div class="row">
						<div class="col-lg-6 d-flex align-items-center justify-content-center">
							<div class="banner-media1 m-b30">
								<img src="{{asset('fs/assets/img/img-001.png')}}" class="img-fluid" alt="">

							</div>

						</div>

						<div class="col-lg-6 wow fadeInUp" data-wow-delay="0.4s">
							<h3 class="mb-3 ">What Makes Us the Best Food Delivery Choice</h3>
							<p class="mb-4">Enjoy the best food delivery experience with fast service, reliable support,
								and
								top-quality restaurants. Here's why millions trust us:</p>

							<ul class="box-ulx-why">
								<li> <b>Fast & Fresh Delivery </b>– Get your meals hot and on time, every time.</li>
								<li><b>Trusted Restaurants</b> – Only top-rated and verified places near you.</li>
								<li><b>Multiple Payment Options</b> – Pay your way: UPI, card.</li>
								<li> <b>Live Order Tracking</b> – See exactly where your food is in real-time.></li>


								<li> <b>24/7 Customer Support</b> – We’re here to help, day or night.</li>
								<li> <b> Exciting Offers & Rewards</b> – Save more with deals and loyalty points.</li>

							</ul>
						</div>
					</div>

				</div>
			</section>
			<!-- Are Menu-->


			<!-- Are Menu-->
			<section class="content-inner-1 pb-0">
				<div class="container">
					<div class="section-head text-center">
						<!-- <h2 class="title wow flipInX" data-wow-delay="0.2s">FAQ Questions</h2> -->
						<h2 class="highlighter wow flipInX" data-wow-delay="0.2s">FAQ Questions</h2>
						<h4 class="title-custom">Find Help with Your <br>App Experience</h4>
					</div>
					<div class="row justify-content-center">
						<div class="col-md-10">
							<div class="accordion dz-accordion" id="accordionFaq2">
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingOne1">
										<a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
											data-bs-target="#collapseOne1" aria-expanded="true"
											aria-controls="collapseOne1">
											Q1: How do I place an order using the app?
											<span class="toggle-close"></span>
										</a>
									</h2>
									<div id="collapseOne1" class="accordion-collapse collapse"
										aria-labelledby="headingOne1" data-bs-parent="#accordionFaq2">
										<div class="accordion-body">
											<p class="m-b0">Open the app, browse your favorite dishes,
												add items to your cart, and tap “Checkout” to place your order.</p>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingTwo1">
										<a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
											data-bs-target="#collapseTwo1" aria-expanded="false"
											aria-controls="collapseTwo1">
											Q2: Can I track my delivery in real-time?
											<span class="toggle-close"></span>
										</a>
									</h2>
									<div id="collapseTwo1" class="accordion-collapse collapse"
										aria-labelledby="headingTwo1" data-bs-parent="#accordionFaq2">
										<div class="accordion-body">
											<p class="m-b0">Yes, you can track your order live from the restaurant to
												your doorstep through the app's tracking feature.</p>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingThree1">
										<a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
											data-bs-target="#collapseThree1" aria-expanded="false"
											aria-controls="collapseThree1">
											Q3: What payment methods are accepted?
											<span class="toggle-close"></span>
										</a>
									</h2>
									<div id="collapseThree1" class="accordion-collapse collapse"
										aria-labelledby="headingThree1" data-bs-parent="#accordionFaq2">
										<div class="accordion-body">
											<p class="m-b0">We accept credit/debit cards, UPI, digital wallets.</p>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingFour1">
										<a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
											data-bs-target="#collapseFour1" aria-expanded="false"
											aria-controls="collapseFour1">
											Q4: Is there a minimum order amount?
											<span class="toggle-close"></span>
										</a>
									</h2>
									<div id="collapseFour1" class="accordion-collapse collapse"
										aria-labelledby="headingFour1" data-bs-parent="#accordionFaq2">
										<div class="accordion-body">
											<p class="m-b0">Yes, You'll see any
												minimum requirement at checkout.</p>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingSix1">
										<a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
											data-bs-target="#collapseSix1" aria-expanded="false"
											aria-controls="collapseSix1">
											Q5: What should I do if my order is incorrect or missing items?
											<span class="toggle-close"></span>
										</a>
									</h2>
									<div id="collapseSix1" class="accordion-collapse collapse"
										aria-labelledby="headingSix1" data-bs-parent="#accordionFaq2">
										<div class="accordion-body">
											<p class="m-b0">Use the “Help” option in your order history to report
												issues. Our support team will assist you quickly.</p>
										</div>
									</div>
								</div>
								<div class="accordion-item">
									<h2 class="accordion-header" id="headingSeven1">
										<a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
											data-bs-target="#collapseSeven1" aria-expanded="false"
											aria-controls="collapseSeven1">
											Q6: How do I cancel an order?
											<span class="toggle-close"></span>
										</a>
									</h2>
									<div id="collapseSeven1" class="accordion-collapse collapse"
										aria-labelledby="headingSeven1" data-bs-parent="#accordionFaq2">
										<div class="accordion-body">
											<p class="m-b0">You can cancel your order from the app before it's confirmed
												by the restaurant. After confirmation, cancellation may not be possible.
											</p>
										</div>
									</div>
								</div>

								<div class="accordion-item">
									<h2 class="accordion-header" id="headingEight1">
										<a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
											data-bs-target="#collapseEight1" aria-expanded="false"
											aria-controls="collapseEight1">
											Q7: How do I contact customer support?
											<span class="toggle-close"></span>
										</a>
									</h2>
									<div id="collapseEight1" class="accordion-collapse collapse"
										aria-labelledby="headingEight1" data-bs-parent="#accordionFaq2">
										<div class="accordion-body">
											<p class="m-b0">Tap the “Help & Support” section in the app menu for quick
												chat support or to raise a complaint.</p>
										</div>
									</div>
								</div>

								<div class="accordion-item">
									<h2 class="accordion-header" id="headingTen1">
										<a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
											data-bs-target="#collapseTen1" aria-expanded="false"
											aria-controls="collapseTen1">
											Q8: Are there delivery charges?
											<span class="toggle-close"></span>
										</a>
									</h2>
									<div id="collapseTen1" class="accordion-collapse collapse"
										aria-labelledby="headingTen1" data-bs-parent="#accordionFaq2">
										<div class="accordion-body">
											<p class="m-b0">Delivery fees vary based on distance and any
												ongoing offers. Charges are shown clearly before payment.</p>
										</div>
									</div>
								</div>

								<div class="accordion-item">
									<h2 class="accordion-header" id="headingTwelve1">
										<a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
											data-bs-target="#collapseTwelve1" aria-expanded="false"
											aria-controls="collapseTwelve1">
											Q9: Is contactless delivery available?
											<span class="toggle-close"></span>
										</a>
									</h2>
									<div id="collapseTwelve1" class="accordion-collapse collapse"
										aria-labelledby="headingTwelve1" data-bs-parent="#accordionFaq2">
										<div class="accordion-body">
											<p class="m-b0">Absolutely! Choose "Contactless Delivery" at checkout and
												the delivery partner will leave your order at your doorstep.</p>
										</div>
									</div>
								</div>

								<div class="accordion-item">
									<h2 class="accordion-header" id="headingThirteen1">
										<a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
											data-bs-target="#collapseThirteen1" aria-expanded="false"
											aria-controls="collapseThirteen1">
											Q10: How do I update my address or payment info?
											<span class="toggle-close"></span>
										</a>
									</h2>
									<div id="collapseThirteen1" class="accordion-collapse collapse"
										aria-labelledby="headingThirteen1" data-bs-parent="#accordionFaq2">
										<div class="accordion-body">
											<p class="m-b0">Go to “Profile” in the app and select “Addresses” or
												“Payments” to update your details.</p>
										</div>
									</div>
								</div>

								<div class="accordion-item">
									<h2 class="accordion-header" id="headingFourteen1">
										<a href="#" class="accordion-button collapsed" data-bs-toggle="collapse"
											data-bs-target="#collapseFourteen1" aria-expanded="false"
											aria-controls="collapseFourteen1">
											Q11: Are tips for delivery partners optional?
											<span class="toggle-close"></span>
										</a>
									</h2>
									<div id="collapseFourteen1" class="accordion-collapse collapse"
										aria-labelledby="headingFourteen1" data-bs-parent="#accordionFaq2">
										<div class="accordion-body">
											<p class="m-b0">Yes, tipping is optional and can be added during or after
												the order via the app.</p>
										</div>
									</div>
								</div>

							</div>
						</div>
					</div>

				</div>
			</section>
			<!-- Are Menu-->




			<section class="content-inner section-wrapper-6 mt-0 ">

				<div class="container contact-area bg-parallax"
					style="background-image: url({{asset('fs/assets/images/background/pic13.png')}}); background-attachment: fixed; background-position-y: 71.36px;">
					<div class="download-app">
						<div class="container">
							<img src="{{asset('fs/assets/img/logo.png')}}" alt="FINTESA Logo" class="logo" />
							<h2>Download Our Best App</h2>
							<p>Download and Sign up to more information for this application</p>
							<div class="store-buttons">
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
			</section>


		</div>
    
@endsection