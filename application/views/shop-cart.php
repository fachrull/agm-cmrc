<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<section class="page-header page-header-md">
	<div class="container">

		<h1>SHOP CART</h1>

		<!-- breadcrumbs -->
		<ol class="breadcrumb">
			<li><a href="<?= site_url('#home');?>">Home</a></li>
			<li><a href="<?= site_url('home/shop');?>">Shop</a></li>
			<li class="active">Cart</li>
		</ol><!-- /breadcrumbs -->

	</div>
</section>
<!-- /PAGE HEADER -->




<!-- CART -->
<section>
	<div class="container">


		<!-- EMPTY CART -->
		<div class="card card-default">
			<div class="card-block">
				<strong>Shopping cart is empty!</strong><br />
				You have no items in your shopping cart.<br />
				Click <a href="shop-2col-left.html">here</a> to continue shopping. <br />
				<span class="badge badge-warning">this is just an empty cart example</span>
			</div>
		</div>
		<!-- /EMPTY CART -->



		<!-- CART -->
		<div class="row">

			<!-- LEFT -->
			<div class="col-lg-9 col-sm-8">

				<!-- CART -->
				<form class="cartContent clearfix" method="post" action="#">

					<!-- cart content -->
					<div id="cartContent">
						<!-- cart header -->
						<div class="item head clearfix">
							<span class="cart_img"></span>
							<span class="product_name fs-13 bold">PRODUCT NAME</span>
							<span class="remove_item fs-13 bold"></span>
							<span class="total_price fs-13 bold">TOTAL</span>
							<span class="qty fs-13 bold">QUANTITY</span>
						</div>
						<!-- /cart header -->

						<!-- cart item -->
						<div class="item">
							<div class="cart_img float-left fw-100 p-10 text-left"><img src="<?= site_url('statis/agm-customer/assets/content-images/slider-1-100x100.png');?>" alt="product name"
								 width="80" /></div>
							<a href="#" class="product_name">
								<span>Product Name</span>
								<small>Size: XL</small>
							</a>
							<a href="#" class="remove_item"><i class="fa fa-times"></i></a>
							<div class="total_price">Rp. <span>2,000,000</span></div>
							<div class="qty"><input type="number" value="1" name="qty" maxlength="3" max="999" min="1" /> &times; Rp.
								2,000,000</div>
							<div class="clearfix"></div>
						</div>
						<!-- /cart item -->

						<!-- cart item -->
						<div class="item">
							<div class="cart_img float-left fw-100 p-10 text-left"><img src="<?= site_url('statis/agm-customer/assets/content-images/slider-1-100x100.png');?>" alt="product name"
								 width="80" /></div>
							<a href="#" class="product_name">
								<span>Product Name</span>
								<small>Size: 8.5</small>
							</a>
							<a href="#" class="remove_item"><i class="fa fa-times"></i></a>
							<div class="total_price">Rp. <span>2,000,000</span></div>
							<div class="qty"><input type="number" value="1" name="qty" maxlength="3" max="999" min="1" /> &times; Rp.
								2,000,000</div>
							<div class="clearfix"></div>
						</div>
						<!-- /cart item -->

						<!-- cart item -->
						<div class="item">
							<div class="cart_img float-left fw-100 p-10 text-left"><img src="<?= site_url('statis/agm-customer/assets/content-images/slider-1-100x100.png');?>" alt="product name"
								 width="80" /></div>
							<a href="#" class="product_name">
								<span>Product Name</span>
								<small>Size: 6.5</small>
							</a>
							<a href="#" class="remove_item"><i class="fa fa-times"></i></a>
							<div class="total_price">Rp. <span>2,000,000</span></div>
							<div class="qty"><input type="number" value="1" name="qty" maxlength="3" max="999" min="1" /> &times; Rp.
								2,000,000</div>
							<div class="clearfix"></div>
						</div>
						<!-- /cart item -->


						<!-- update cart -->
						<button class="btn btn-oldblue mt-20 mr-10 float-right"><i class="glyphicon glyphicon-ok"></i> UPDATE CART</button>
						<button class="btn btn-quitered mt-20 mr-10 float-right"><i class="fa fa-remove"></i> CLEAR CART</button>
						<!-- /update cart -->

						<div class="clearfix"></div>
					</div>
					<!-- /cart content -->

				</form>
				<!-- /CART -->

			</div>


			<!-- RIGHT -->
			<div class="col-lg-3 col-sm-4">

				<!-- TOGGLE -->
				<div class="toggle-transparent toggle-bordered-full clearfix">

					<div class="toggle mt-0">
						<label>Voucher</label>

						<div class="toggle-content">
							<p class="mb-20">Enter your discount coupon code.</p>

							<form action="#" method="post" class="m-0">
								<input type="text" id="cart-code" name="cart-code" class="form-control text-center mb-10" placeholder="Voucher Code"
								 required="required">
								<button class="btn btn-oldblue btn-block" type="submit">SUBMIT</button>
							</form>
						</div>
					</div>

					<!-- <div class="toggle">
								<label>Shipping tax calculator</label>

								<div class="toggle-content">
									<p class="pb-10">To get a shipping estimate, please enter your destination.</p>

									<form action="#" method="post" class="m-0">
										<label>Country*</label>
										<select id="cart-tax-country" name="cart-tax-country" class="form-control pointer mb-20">
											<option value="1">United States</option>
											<option value="2">United Kingdom</option>
											<option value="2">...........</option>
											add all here
										</select>

										<label>State/Province</label>
										<select id="cart-tax-state" name="cart-tax-state" class="form-control pointer mb-20">
											<option value="1">Alabama</option>
											<option value="2">Alaska</option>
											<option value="2">...........</option>
											add all here
										</select>

										<label>Zip/Postal Code</label>
										<input type="text" id="cart-tax-postal" name="cart-tax-postal" class="form-control mb-20">

										<button class="btn btn-oldblue btn-block" type="submit">SUBMIT</button>
									</form>
								</div>
							</div> -->

				</div>
				<!-- /TOGGLE -->

				<div class="toggle-transparent toggle-bordered-full clearfix">
					<div class="toggle active">
						<div class="toggle-content">

							<span class="clearfix">
								<span class="float-right">Rp. 6,000,000</span>
								<strong class="float-left">Subtotal:</strong>
							</span>
							<span class="clearfix">
								<span class="float-right">Rp. 0</span>
								<span class="float-left">Discount:</span>
							</span>
							<span class="clearfix">
								<span class="float-right">Rp. 0</span>
								<span class="float-left">Shipping:</span>
							</span>

							<hr />

							<span class="clearfix">
								<span class="float-right fs-20">Rp. 6,000,000</span>
								<strong class="float-left">TOTAL:</strong>
							</span>

							<hr />

							<a href="<?= site_url('home/shopCheckout');?>" class="btn btn-oldblue btn-lg btn-block"><i class="fa fa-mail-forward"></i>
								Check Out</a>
						</div>
					</div>
				</div>

			</div>

		</div>
		<!-- /CART -->

	</div>
</section>
<!-- /CART -->