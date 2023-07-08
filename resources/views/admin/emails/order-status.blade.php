@php
$r = DB::table("orders")->where("id", $id)->first();
$pickup = json_decode($r->pickup_detail,true);
$delivery = json_decode($r->delivery_detail,true);
$courier = json_decode($r->courier_detail,true);
$service = json_decode($r->service,true);
$status = str_replace("-", " ", $status);
$status = ucwords($status);
@endphp
<div style="padding:10px 40px;background: #E5E5E5;">
	<div style="background: #ff5e14; padding:20px; text-align: center;">
		<img src='{{url("images/logo.png")}}' style="width: 150px;">
	</div>
	<div style="padding: 10px;font-size:18px;background: #3034F7;color:#fff;text-align: center;">
		Your order status has been changed to: <strong>{{$status}}</strong>
	</div>

	<div style="padding-top: 30px;padding-left:30px;padding-right:30px;padding-bottom:30px;background:#fff;">
		<div style="float: left;">
			<strong>Pickup Detail</strong><br>
			Name: {{$pickup["name"]}}<br>
			Email: {{$pickup["eamil"]}}<br>
			Phone: {{$pickup["phone"]}}<br>
			Town: {{$pickup["town"]}}<br>
			Address: {{$pickup["address"]}}<br>
		</div>
		<div style="float:right;">
			<strong>Delivery Detail</strong><br>
			Name: {{$delivery["name"]}}<br>
			Email: {{$delivery["eamil"]}}<br>
			Phone: {{$delivery["phone"]}}<br>
			Town: {{$delivery["town"]}}<br>
			Address: {{$delivery["address"]}}<br>
		</div>
		<div style="clear: both"></div>
		<hr>
		<strong>Courier Detail</strong>
		<table style="width: 100%; margin-top: 15px;">
			<tr>
				<th style="text-align: left;">Package</th>
				<th style="text-align: left;">Weight</th>
				<th style="text-align: left;">Dimensions (cm)</th>
				<th style="text-align: left;">Delivery Time</th>
				<th style="text-align: left;">Price</th>
			</tr>
			<tr>
				@if($courier["packaging"]=="Parcel")
				<td>Box</td>
				@else
				<td>{{$courier["packaging"]}}</td>
				@endif
				<td>{{$courier["weight"]}} kg</td>
				<td>{{$courier["dimensions"]}}</td>
				<td>{{$courier["delivery_time"]}} business days</td>
				<td><strong>{{$service["amount"]}}</strong></td>
			</tr>
		</table>
	</div>

	<div style="margin-top:40px;text-align: center;padding: 10px;font-size: 12px;color:#8A8A8A;">
		Email sent via <a href="{{url("/")}}" style="color:#8A8A8A;">Courier Now</a><br>
		 <a href="{{url('/terms-conditions')}}" style="color:#8A8A8A;">Terms & Conditions</a> | 
		 <a href="{{url('/about')}}" style="color:#8A8A8A;">About Us</a> | 
		 <a href="{{url('/contact')}}" style="color:#8A8A8A;">Contact Us</a>
	</div>

</div>
