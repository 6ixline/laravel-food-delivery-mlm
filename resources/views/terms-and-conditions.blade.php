@extends('app')
@section('content')
   <!-- Header -->
		<header class="site-header mo-left header header-transparent style-1">
			<!-- Main Header -->
			<div class="sticky-header main-bar-wraper navbar-expand-lg">
				<div class="main-bar clearfix ">
					<div class="container clearfix">

						<!-- Website Logo -->
						<div class="logo-header mostion">
							<a href="/" class="anim-logo"><img src="{{asset('fs/assets/img/logo.png')}}" alt="/"></a>
							<a href="/" class="anim-logo-white"><img src="{{asset('fs/assets/img/logo.png')}}" alt="/"></a>
						</div>

						<!-- Nav Toggle Button -->
						<!-- <button class="navbar-toggler collapsed navicon justify-content-end" type="button"
							data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
							aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
							<span></span>
							<span></span>
							<span></span>
						</button> -->


					</div>
				</div>
			</div>
			<!-- Main Header End -->
		</header>

		<!-- Header -->


		<div class="page-content bg-white">
			<!-- Banner  -->
			<div class="dz-bnr-inr style-1 text-center bg-parallax"
				style="background-image:url('{{asset("fs/assets/images/banner/bnr1.jpg")}}'); background-size:cover; background-position:center;">
				<div class="container">
					<div class="dz-bnr-inr-entry">
						<h1>Terms & Conditions</h1>
						<!-- Breadcrumb Row -->
						<nav aria-label="breadcrumb" class="breadcrumb-row">
							<ul class="breadcrumb">
								<li class="breadcrumb-item"><a href="/">Home</a></li>
								<li class="breadcrumb-item active" aria-current="page">Terms & Conditions</li>
							</ul>
						</nav>
						<!-- Breadcrumb Row End -->
					</div>
				</div>
			</div>
			<!-- Banner End -->

			<section class="content-inner">
				<div class="min-container">
					<div class="row">
						<div class="col-xl-12 col-lg-12">
							<div class="blog-single dz-card sidebar">

								<div class="dz-info">

									<div class="dz-post-text">
										

										<section class="terms-conditions">
											<h1>Terms & Conditions</h1>
											<p><b>Last Updated: June 09, 2025</b></p>

											<p>Welcome to <b>example</b>, your trusted food delivery platform. These Terms and Conditions ("Terms") govern your use of our website, mobile application, and related services ("Service"). By accessing or using example, you agree to be bound by these Terms. Please read them carefully.</p>


											<h4 class="m-t30">1. Eligibility</h4>
											<p>To use our Service, you must be at least 18 years old or have legal consent from a parent or guardian. By registering, you confirm that the information provided is accurate and complete.</p>

											<h4 class="m-t30">2. Account & Responsibility</h4>
											<p>You may need to create an account to place orders. You are responsible for maintaining the confidentiality of your login credentials and for all activities that occur under your account. Please notify us immediately of any unauthorized use.</p>

											<h4 class="m-t30">
												3. Ordering & Payment
											</h4>

											<p>All food and beverages listed on example are offered by partner restaurants. Prices, availability, and delivery times are subject to change. You agree to pay all charges incurred through your account, including taxes and applicable delivery fees.</p>
											<p>Payments can be made via credit/debit cards, digital wallets, UPI, or cash on delivery (when available). In case of failed or unauthorized payments, your order may be canceled.</p>

											<h4 class="m-t30">4. Cancellations & Refunds</h4>
											<p>Orders may only be canceled within a limited time window before the restaurant accepts and begins preparing your food. Refunds are issued at the discretion of example and/or the restaurant, depending on the situation (e.g., missing items, wrong delivery, etc.).</p>

											<h4 class="m-t30">5. Service Availability</h4>
											<p>We aim to provide uninterrupted service but do not guarantee it. example may be unavailable temporarily due to technical issues, updates, or force majeure events.</p>

											<h4 class="m-t30">6. User Conduct</h4>
											<p>You agree not to misuse the Service, submit false orders, abuse our staff or partners, or engage in any fraudulent activity. We reserve the right to suspend or terminate accounts that violate our policies.</p>

											<h4 class="m-t30">7. Privacy</h4>

										    <p>Your personal data is handled according to our Privacy Policy. By using the Service, you consent to our data practices.</p>

											<h4 class="m-t30">8. Changes to Terms</h4>
											<p>We may update these Terms occasionally. Continued use of example after such changes implies your acceptance.</p>

											<h4 class="m-t30">9. Contact</h4>
											<p>For questions or concerns, contact us at <a href="#"> support@example.com</a>

</p>
										</section>

									</div>
								</div>


							</div>

						</div>
					</div>
				</div>
			</section>

		</div>
@endsection
