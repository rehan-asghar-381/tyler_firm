@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<div class="body-content">
    <div class="row">
        <div class="col-sm-12 col-xl-8">
            <div class="media d-flex m-1 ">
                @if(count($product->ProductImg) > 0)
                    @foreach($product->ProductImg as $key=>$ProductImg)
                        <div class="align-left p-1">
                            <div class="zoom-box">
                                <img src="{{asset($ProductImg->image)}}" style="object-fit: cover;" width="200" height="150" data-zoom-image="{{asset($ProductImg->image)}}" class="img-zoom-m"/>
                                
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Product variants</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            @if(count($product->ProductVariant) > 0)
                                @foreach($product->ProductVariant as $key=>$ProductVariant)
                                <h6 class="mb-0 font-weight-600">{{$ProductVariant->name}}</h6>
                                @if(count($ProductVariant->Atrributes) > 0)
                                    @foreach($ProductVariant->Atrributes as $key=>$Atrribute)
                                    <a href="#!" class="fs-13 font-weight-600 px-4">{{$Atrribute->name}}</a>
                                    @endforeach
                                @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="col-auto">
                            
                        </div>
                    </div> 
                    <hr>
                </div>
            </div>
        </div>
        
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Product Detail</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-12 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Product Name</label>
                                    <input type="text" class="form-control" disabled="" value="{{ $product->name }}">
                                </div>
                            </div>
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">SKU</label>
                                    <input type="text" class="form-control" disabled="" value="{{ $product->code }}">
                                </div>
                            </div>
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Brand</label>
                                    <input type="text" class="form-control" disabled="" value="{{ $product->Brand->name ?? "" }}">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label text-dark-gray" for="">Description</label>
                                <div>
                                    {!! $product->description !!}
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
    $(".img-zoom-m").ezPlus();
</script>
@endsection