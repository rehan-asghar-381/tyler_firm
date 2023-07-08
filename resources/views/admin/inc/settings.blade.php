@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<div class="body-content">
	<div class="row">
		@if (Session::has('resp'))
			@php
				$resp = session()->get("resp");
				$msg = session()->get("msg");
			@endphp
			<div class="col-md-12">
				@if ($resp=="success")
					<div class="alert alert-success">
						{!!$msg!!}
					</div>
				@endif
			</div>
		@endif
		<div class="col-lg-6">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">General Settings</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" action="" enctype="multipart/form-data">
						@csrf
						@php
							$r=DB::table("setting")->where("key","general_setting")->first();
							$value = (isset($r->value)) ? json_decode($r->value, true):array();
							$logo1 = (isset($value["light_logo"])) ? $value["light_logo"] : ""; 
							$logo2 = (isset($value["dark_logo"])) ? $value["dark_logo"] : ""; 
							$fb = (isset($value["facebook"])) ? $value["facebook"] : "";
							$tw = (isset($value["twitter"])) ? $value["twitter"] : "";
							$ig = (isset($value["instagram"])) ? $value["instagram"] : "";
						@endphp
						<div class="form-group">
							@if($logo1!="" and file_exists(base_path('/images/').$logo1))
								<div style="background: #bbb7b7;padding:10px;border:1px solid #666;text-align: center;">
									<img src="{{url('/images/'.$logo1)}}" style="width: 100px;"><br><br>
									<a href="?lg=light" class='btn btn-danger _deld'> <i class="fa fa-trash"></i> Delete</a>
								</div>
							@else
								<label>Upload Light Logo</label>
								<input type="file" name="light_logo" class="form-control" >
							@endif
							
						</div>
						<div class="form-group">
							@if($logo2!="" and file_exists(base_path('/images/').$logo2))
								<div class="" style="background: #E3E3E3;padding:10px;border:1px solid #666;text-align: center;">
									<img src="{{url('/images/'.$logo2)}}" style="width: 100px;">
									<br><br>
									<a href="?lg=dark" class='btn btn-danger _deld'> <i class="fa fa-trash"></i> Delete</a>
								</div>
							@else
								<label>Upload Dark Logo</label>
								<input type="file" name="dark_logo" class="form-control">
							@endif
						</div>
						<div class="form-group">
							<label>Facebook Page Link</label>
							<input type="text" name="facebook" class="form-control" value="{{$fb}}">
						</div>
						<div class="form-group">
							<label>Twitter Profile Link</label>
							<input type="text" name="twitter" class="form-control" value="{{$tw}}">
						</div>
						<div class="form-group">
							<label>Instagram Progile Link</label>
							<input type="text" name="instagram" class="form-control" value="{{$ig}}">
						</div>
						<div class="form-group">
							<input type="submit" name="submit-gn" value="Submit" class="btn btn-success">
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Contact Detail</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" action="">
						@csrf
						@php
							$r=DB::table("setting")->where("key","contact_setting")->first();
							$value = (isset($r->value)) ? json_decode($r->value, true):array();
							$ph = (isset($value["phone"])) ? $value["phone"] : "";
							$em = (isset($value["email"])) ? $value["email"] : "";
							$adr = (isset($value["address"])) ? $value["address"] : "";
						@endphp
						<div class="form-group">
							<label>Phone</label>
							<input type="text" name="phone" class="form-control" value="{{$ph}}">
						</div>
						<div class="form-group">
							<label>Email</label>
							<input type="text" name="email" class="form-control" value="{{$em}}">
						</div>
						<div class="form-group">
							<label>Address</label>
							<input type="text" name="address" class="form-control" value="{{$adr}}">
						</div>
						<div class="form-group">
							<input type="submit" name="submit-cn" value="Submit" class="btn btn-success">
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Admin Credentials</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" action="">
						@csrf
						@php
							$r=DB::table("setting")->where("key","admin_setting")->first();
							$value = (isset($r->value)) ? json_decode($r->value, true):array();
							$mpath = (isset($value["admin_path"])) ? $value["admin_path"] : "";
							$memail = (isset($value["admin_login_email"])) ? $value["admin_login_email"] : "";
							$mpass = (isset($value["admin_login_pass"])) ? $value["admin_login_pass"] : "";
						@endphp
						<div class="form-group">
							<label>Admin Path</label>
							<input type="text" name="cr_path" class="form-control" value="{{$mpath}}">
						</div>
						<div class="form-group">
							<label>Admin Login Email</label>
							<input type="text" name="cr_email" class="form-control" value="{{$memail}}">
						</div>
						<div class="form-group">
							<label>Admin Login Password</label>
							<input type="password" name="cr_password" class="form-control" value="{{$mpass}}">
						</div>
						<div class="form-group">
							<input type="submit" name="submit-cr" value="Submit" class="btn btn-success">
						</div>
					</form>
				</div>
			</div>
		</div>
		
		<div class="col-lg-6">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Api Settings</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
					<form method="post" action="">
						@csrf
						@php
							$r=DB::table("setting")->where("key","api_setting")->first();
							$value = (isset($r->value)) ? json_decode($r->value, true):array();
							
							$psp = (isset($value["passpharse"])) ? $value["passpharse"] : "";
							$markup = (isset($value["makrup"])) ? $value["makrup"] : "";
							$markup2 = (isset($value["makrup2"])) ? $value["makrup2"] : "";
							$exceed_parcel = (isset($value["exceed_parcel"])) ? $value["exceed_parcel"] : "";
							$exceed_satchel = (isset($value["exceed_satchel"])) ? $value["exceed_satchel"] : "";
						@endphp
						<div class="form-group">
							<label>PayFast PassPhrase</label>
							<input type="text" name="passphares" class="form-control" value="{{$psp}}">
						</div>
						<div class="form-group">
							<label>PayFast Markup (Parcel)</label>
							<input type="text" name="makrup" class="form-control" value="{{$markup}}">
						</div>
						<div class="form-group">
							<label>PayFast Markup (Satchel)</label>
							<input type="text" name="makrup2" class="form-control" value="{{$markup2}}">
						</div>
						<div class="form-group">
							<label>Label Exceed Amount per Kg (Parcel)</label>
							<input type="text" name="exceed_parcel" class="form-control" value="{{$exceed_parcel}}">
						</div>
						<div class="form-group">
							<label>Label Exceed Amount per Kg (Satchel)</label>
							<input type="text" name="exceed_satchel" class="form-control" value="{{$exceed_satchel}}">
						</div>
						<div class="form-group">
							<input type="submit" name="submit-api" value="Submit" class="btn btn-success">
						</div>
					</form>
				</div>
			</div>
		</div>
		
	</div>
</div>
@endsection