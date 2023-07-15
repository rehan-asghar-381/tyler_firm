@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<div class="body-content">
    <div class="row">
        <div class="col-sm-12 col-xl-8">
            <div class="media d-flex m-1 ">
                {{-- {{dd($client->ClientDoc)}} --}}
                @if(isset($client->ClientDoc) && count($client->ClientDoc) > 0)
                @foreach($client->ClientDoc as $key=>$ClientDoc)
                <div class="align-left p-1 mt-2">
                    <div class="zoom-box">
                        <img src="{{asset($ClientDoc->doc)}}" style="object-fit: cover;" width="200" height="150" data-zoom-image="{{asset($ClientDoc->doc)}}" class="img-zoom-m"/>
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
                            <h6 class="fs-17 font-weight-600 mb-0">Company Details</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h6 class="mb-0 font-weight-600"> Name</h6>

                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$client->company_name}}</a>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-0 font-weight-600">Office Phone Number</h6>

                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$client->office_phone_number}}</a>
                        </div>
                    </div> 
                    <hr>
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h6 class="mb-0 font-weight-600">Website</h6>
                            
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$client->website}}</a>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-0 font-weight-600">Charge Tax</h6>
                            
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$client->tax}}</a>
                        </div>
                    </div> 
                    <hr>
                     <div class="row align-items-center">
                        <div class="col-md-12">
                            <h6 class="mb-0 font-weight-600"> Resale Number</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$client->resale_number}}</a>
                        </div>
                    </div>
                    <hr>
                       <div class="row align-items-center">
                        <div class="col-md-12">
                            <h6 class="mb-0 font-weight-600"> Billing Address</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$client->website}}</a>
                        </div>
                    </div> 
                    <hr>
                     <div class="row align-items-center">
                        <div class="col-md-12">
                            <h6 class="mb-0 font-weight-600"> Notes</h6>
                            <a href="#!" class="fs-13 font-weight-600 px-4">{{$client->notes}}</a>
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
                            <h6 class="fs-17 font-weight-600 mb-0">Sales Rep</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        @if(isset($client->ClientSaleRep) && count($client->ClientSaleRep) )
                        @foreach($client->ClientSaleRep  as $key=> $ClientSaleRep)
                        <b>{{$loop->iteration}})</b>
                        <div class="row mt-2">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">First name</label>
                                    <input type="text" class="form-control" disabled="" value="{{ $ClientSaleRep->first_name }}">
                                </div>
                            </div>
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Last Name</label>
                                    <input type="text" class="form-control" disabled="" value="{{ $ClientSaleRep->last_name }}">
                                </div>
                            </div>
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Email</label>
                                    <input type="text" class="form-control" disabled="" value="{{ $ClientSaleRep->email }}">
                                </div>
                            </div>
                             <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Phone Number</label>
                                    <input type="text" class="form-control" disabled="" value="{{ $ClientSaleRep->phone_number }}">
                                </div>
                            </div>
                        </div>
                        <hr>
                        @endforeach
                        @endif
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