@extends('frontend.app')

@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/public/frontend/styles/cart_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/public/frontend/styles/cart_responsive.css') }}">
@endpush

@section('content')

	<!-- Cart -->

	<div class="cart_section">
		<div class="container">
			<div class="row">
				<div class="col-lg-7" style="border-right: 1px solid grey; padding: 20px;">
					<div class="cart_container">
						<div class="cart_title text-center">Product Informatin</div>
						<div class="cart_items">
							<ul class="cart_list">
								@foreach($cart as $row)
								<li class="cart_item clearfix">
									<div class="cart_item_image"><img height="80" src="{{ asset('/public/backend/media/product/'.$row->options->image) }}" alt=""></div>
									<div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
										<div class="cart_item_name cart_info_col">
											<div class="cart_item_title">Name</div>
											<div class="cart_item_text">{{ $row->name }}</div>
										</div>
										<div class="cart_item_color cart_info_col">
											<div class="cart_item_title">Color</div>
											<div class="cart_item_text">{{ $row->options->color }}</div>
										</div>
										<div class="cart_item_quantity cart_info_col">
											<div class="cart_item_title">Quantity</div>
											<div class="cart_item_text">{{ $row->qty }}</div>
										</div>
										<div class="cart_item_price cart_info_col">
											<div class="cart_item_title">Price</div>
											<div class="cart_item_text">${{ $row->price }}</div>
										</div>
										<div class="cart_item_total cart_info_col">
											<div class="cart_item_title">Total</div>
											<div class="cart_item_text">${{ $row->price*$row->qty }}</div>
										</div>
									</div>
								</li>
								@endforeach
							</ul>
						</div>
						
						<!-- Order Total -->
						<div class="order_total">
							<div class="order_total_content text-md-right">

								<div class="order_total_title">Sub Total :  </div>
								<div class="order_total_amount">$ {{ Cart::Subtotal() }}</div><br>

								<!-- Coupon -->

								@if (Session::has('coupon'))
									<div class="order_total_title">Coupon :  ({{   Session::get('coupon')['name'] }})</div>
									<div class="order_total_amount">$ {{ Session::get('coupon')['amount'] }}</div><br>
								@endif
								
								<!-- Shipping Charge -->

								@php
									$shipping = App\model\admin\Setting::first();
									$charge = $shipping->shipping_charge;
									$coupon = Session::get('coupon')['amount'];

									$str = Cart::Subtotal();
									$cartTotal = str_replace( ',', '', $str);
								@endphp
								 @if (Session::has('coupon'))
									<div class="order_total_title">Shipping Charge:</div>
									<div class="order_total_amount">$ {{ $coupon/100 * $charge }}</div><br>
								@else
									<div class="order_total_title">Shipping Charge:</div>
									<div class="order_total_amount">$ {{ $cartTotal/100 * $charge }}</div><br>
								@endif

								<!-- VAT -->

								@php
									$vatId = App\model\admin\Setting::first();
									$vat = $vatId->vat;
								@endphp

								<div class="order_total_title">VAT :  </div>
								@if (Session::has('coupon'))
									<div class="order_total_amount">$ {{ $coupon/100 * $vat }}</div><br>
								@else
									<div class="order_total_amount">$ {{ $cartTotal/100 * $vat }}</div><br>
								@endif

								<div class="order_total_title">Total Amount :</div>
								@if(Session::has('coupon'))
									<div class="order_total_amount">$ {{ $coupon + $coupon/100 * $charge  + $coupon/100 * $vat}}</div>
								@else
									<div class="order_total_amount">$ {{ $cartTotal + $cartTotal/100 * $charge +$cartTotal/100 * $vat}}</div>
								@endif
							</div>
						</div>

					</div>
				</div><!--- end row colum 7 -->

				<div class="col-lg-5" style=" padding: 20px;">
					<div class="cart_container">
						<div class="cart_title text-center">Shipping Address</div><br><br>
						<form method="POST" action="{{ route('payment.process') }}" id="loginform">
							@csrf
							<div class="form-group">
								<label class="info-title" for="name">Your Name<span>*</span></label>
								<input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" autocomplete="name" placeholder="Please Your Name">
					
									@error('name')
									<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
									</span>
									@enderror
							</div>
							<div class="form-group">
								<label class="info-title" for="email">Your Email Address <span>*</span></label>
								<input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" autocomplete="email" placeholder="Your Email">
					
								@error('email')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
							<div class="form-group">
								<label class="info-title" for="phone_number">Phone Number <span>*</span></label>
								<input id="phone_number" type="number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}" autocomplete="phone_number" placeholder="Your Mobile Number">
					
								@error('phone_number')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
							<div class="form-group">
								<label class="info-title" for="password">Address <span>*</span></label>
								<input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" autocomplete="new-password" placeholder="Your Full Address">
					
								@error('password')
									<span class="invalid-feedback" role="alert">
										<strong>{{ $message }}</strong>
									</span>
								@enderror
							</div>
							<div class="form-group">
								<label class="info-title" for="exampleInputEmail1">City<span>*</span></label>
								<input id="city" type="text" class="form-control" name="city" placeholder="Your City Name">

								@error('city')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
							</div>
							<div class="form-group">
								<label class="info-title" for="exampleInputEmail1">post Code<span>*</span></label>
								<input id="post_code" type="text" class="form-control" name="post_code" placeholder="Please Post Code">

								@error('post_code')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
							</div>
							<br>
							<h3 style="text-align: center;">Choose Payment Gateway</h3>
							<br>
							<div class="logos ml-sm-auto">
								<ul class="logos_list">
									<li><input type="radio" value="stripe" name="payment"><img src="{{ asset('/public/frontend/images/logos_1.png') }}" alt="" style="width: 40px; padding-left: 5px;"></li>
									<li><input type="radio" value="paypal" name="payment"><img src="{{ asset('/public/frontend/images/logos_3.png') }}" alt="" style="width: 60px; padding-left: 5px;"></li>
									<li><input type="radio" value="ideal" name="payment"><img src="{{ asset('/public/frontend/images/logos_2.png') }}" alt="" style="width: 40px; padding-left: 5px;"></li>
								</ul>
								@error('payment')
								<span class="invalid-feedback" role="alert">
									<strong>{{ $message }}</strong>
								</span>
							@enderror
							</div>
							<br><br>
							<button type="submit" class="btn btn-info">
								Pay Now
							</button>
						</form>
					</div>
				</div><!-- end rwo colum 5 -->
			</div>
		</div>
	</div>

@endsection
@push('js')
    <script src="{{ asset('/public/frontend/js/cart_custom.js') }}"></script>
@endpush