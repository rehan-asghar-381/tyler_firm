@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
@php
$common->full_editor();
@endphp
<div class="body-content">
	<div class="row">
		<div class="col-lg-12">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Add Homepage Data</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
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
					@php
						$r = DB::table("setting")->where("key", "homepage_data")->first();
						if(isset($r->id)){
							$data = json_decode($r->value, true);
						}else{
							$data = array();
						}
						
					@endphp
					<form method="post" action="">
						<div class="row">
						@csrf
						@for($n=0; $n<4; $n++ )
							@php
								if(isset($data[$n])){
									$d = $data[$n];
									$title = $d["title"];
									$desp = $d["desp"];
								}else{
									$title = "";
									$desp  = "";
								}
							@endphp

							<div class="col-md-6">
								<h3>Box {{$n+1}}</h3>
								<div class="form-group">
									<label>Box {{$n+1}} Title</label>
									<input type="text" name="box{{$n+1}}_title" class="form-control" value="{{$title}}" >
								</div>
								<div class="form-group">
									<label>Box {{$n+1}} Description</label>
									<textarea name="box{{$n+1}}_desp" class="form-control oneditor" style="height:150px;">{{$desp}}</textarea>
								</div>
							</div>
						@endfor
						</div>
						<input type="submit" name="submit" value="Submit" class="btn btn-primary">
					</form>
				</div>
			</div>
							
							
							
							
		</div>
	</div>
</div>
@endsection