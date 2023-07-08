@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
  .dropdown-toggle::after {
      border: none !important;
  }
</style>
<div class="body-content">
	<div class="row">
		<div class="col-lg-12">
			<div class="card mb-4">
				<div class="card-header">
					<div class="d-flex justify-content-between align-items-center">
						<div>
							<h6 class="fs-17 font-weight-600 mb-0">Edit Prices</h6>
						</div>
					</div>
				</div>
				<div class="card-body">
            <div class="col-md-12">
                @if (Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
                @endif
            </div>
            <form method="POST" action="{{ route('admin.price.update') }}">
                @csrf
					<div class="table-responsive">
						<div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">Sub Cost</th>
                                    @foreach ($price_ranges as $price_range)
                                        <th scope="col">{{$price_range->range}}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 1; $i < 9; $i++)
                                <tr>
                                    <th scope="row">{{$i}}</th>
                                    <td></td>
                                    @foreach ($price_ranges as $price_range)
                                        @if($price_range->range != 1)
                                        <td><input type="text" name="{{$i."_".$price_range->range}}" class="form-control font-12 form-control-lg require" value="{{ $prices_arr[$i."_".$price_range->range] }}"></td>
                                        @endif
                                    @endforeach
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                        </div>
					</div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
@section('footer-script')
<script type="text/javascript">

</script>
@endsection

