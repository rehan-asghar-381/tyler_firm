@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<div class="body-content">
    <div class="row">
        <div class="col-sm-12 col-xl-8">
            <div class="media d-flex m-1 ">
                @if(count($brand->BrandImg) > 0)
                    @foreach($brand->BrandImg as $key=>$BrandImg)
                        <div class="align-left p-1">
                            <div class="zoom-box">
                                <img src="{{asset($BrandImg->image)}}" style="background:white;" width="150" height="50" data-zoom-image="{{asset($BrandImg->image)}}" class="img-zoom-m"/>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Brand Detail</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Brand Name</label>
                                    <input type="text" class="form-control" disabled="" value="{{ $brand->name }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-dark-gray" for="">Description</label>
                                <div>
                                    {!! $brand->description !!}
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer-script')
<script>
    // $(".img-zoom-m").ezPlus();
</script>
@endsection