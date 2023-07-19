@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
.accordion .card-header:after {
    font-family: "Font Awesome 5 Free";
    content: "\f106";
    font-weight: 900; 
    float: right; 
}
.accordion .card-header.collapsed:after {
    font-family: "Font Awesome 5 Free";
    content: "\f107"; 
    font-weight: 900;
    float: right;
}
.row {
    width: 100% !important;
}
.accordion2 .card-header:after {
    font-family: "Font Awesome 5 Free";
    content: "\f106";
    font-weight: 900; 
    float: right; 
}
.accordion2 .card-header.collapsed:after {
    font-family: "Font Awesome 5 Free";
    content: "\f107"; 
    font-weight: 900;
    float: right;
}
.btn-d-none{
    display: none;
}
.has-error{
    border: 1px solid red;
}
.upload__box {
    padding: 20px 0px;
}
.upload__btn-box {
    margin-bottom: 10px;
}
.upload__btn {
    display: inline-block;
    font-weight: 600;
    color: #fff;
    text-align: center;
    min-width: 116px;
    padding: 5px;
    transition: all 0.3s ease;
    cursor: pointer;
    border: 2px solid;
    background-color: #4045ba;
    border-color: #4045ba;
    border-radius: 10px;
    line-height: 26px;
    font-size: 14px;
}
.upload__inputfile {
    width: 0.1px;
    height: 0.1px;
    opacity: 0;
    overflow: hidden;
    position: absolute;
    z-index: -1;
}
.upload__img-wrap {
    display: flex;
    flex-wrap: wrap;
    margin: 0 -10px;
}
.upload__img-box {
    width: 200px;
    padding: 0 10px;
    margin-bottom: 12px;
}
element.style {
}
.upload__btn:hover {
    background-color: unset;
    color: #4045ba;
    transition: all 0.3s ease;
}
.upload__img-close {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background-color: rgba(0, 0, 0, 0.5);
    position: absolute;
    top: 10px;
    right: 10px;
    text-align: center;
    line-height: 24px;
    z-index: 1;
    cursor: pointer;
}
.upload__img-close:after {
    content: '\2716';
    font-size: 14px;
    color: white;
}
.img-bg {
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    position: relative;
    padding-bottom: 100%;
}
.my-form-control{
    display: inline-block;
    width: 100%;
    height: calc(2.25rem + 2px);
    padding: 0.375rem 0.75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: 0.25rem;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
}
hr{
    border: 0;
    clear:both;
    display:block;
    width: 96%;               
    background-color:#93938861;
    height: 1px;
}
</style>
<div class="container-fluid mt-2">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Create Order</h6>
                        </div>
                        <div class="text-right">
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                    @endif
                    <form  method="POST"  action="{{ route('admin.order.store') }}" enctype="multipart/form-data" novalidate>
                        @csrf

                        <div class="row mb-4">
                            <div class="col-md-4">
                                <label>Client</label>

                                <select name="client_id" id="client_id" class="form-control search_test select-one"  >
                                    <option value=""> Select</option>
                                    {{-- <option value="new">Add New Client</option>--}}
                                    @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->company_name}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                            <div class="col-md-4">
                                <label>Job Name</label>
                                <input type="text" class="form-control" name="job_name" value="" placeholder="Job Name">
                            </div>
                            <div class="col-md-4">
                                <label>Order Number</label>
                                <input type="text" class="form-control" name="order_number" value="" placeholder="Order Number">
                            </div>
                        </div>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Garments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" onclick="setProjectedUnits();" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Print Location & Colors</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contract & Shirt + Print Price</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="OTHERCHARGES-tab" data-toggle="pill" href="#OTHERCHARGES" role="tab" aria-controls="OTHERCHARGES" aria-selected="false">Other Charges</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="MARGINS-tab" data-toggle="pill" href="#MARGINS" role="tab" aria-controls="MARGINS" aria-selected="false">Margins</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="FinalPrice-tab" data-toggle="pill" href="#FinalPrice" role="tab" aria-controls="FinalPrice" aria-selected="false">Final Price</a>
                            </li>
                        </ul>

                        <div class="tab-content" id="pills-tabContent">
                         <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                            <div class="row mb-3">
                                    {{--  
                                    <div class="col-md-6">
                                        <label>Brands</label>
                                        <select  name="brand[]"  id="brand" class="form-control require required-online">
                                            <option value="">All Brands</option>
                                            }
                                            @foreach ($brands as $brand)
                                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    --}}
                                    <div class="col-md-4">
                                        <label>Products</label>
                                        <select name="product_ids[]" id="product_ids" class="form-control basic-multiple" multiple="multiple">
                                            {{-- 
                                            <option value="" selected="">All Product</option>
                                            --}}
                                            @if (count($products) > 0)
                                            @foreach ($products as $product)
                                            <option value="{{$product->id}}">{{$product->name}} [ {{$product->code}}]</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="row client-form btn-d-none">
                                    {{-- @include('admin.clients.add-client', ['errors'=>$errors]) --}}
                                </div>
                                <div class="row Order-form btn-d-none">
                                    <div id="accordion" class="accordion">
                                    </div>
                                </div>

                            </div>
                            <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="art_fee" class="col-sm-2 font-weight-600">Projected Units</label>
                                        <div class="col-sm-3">
                                            <input type="text" value="" readonly="" style="background-color: #ced4da" class="my-form-control" 
                                            name="projected_units" id="ProjectedUnits" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row product-print-locations btn-d-none">
                                    <div id="accordion2" class="accordion2" style="min-height: 200px;">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                                {{-- <form class="form-inline offset-md-2"> --}}
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label for="location1_charge" class="col-sm-2 font-weight-600">Location 1 Charge</label>
                                            <input type="hidden" name="location_charge[]" value="Location 1 Charge">
                                            <div class="col-sm-3">
                                                <input type="number" min="0" name="location_charge_price[]" readonly value="" class="my-form-control location_charges" id="location1_charge" placeholder="">
                                            </div>
                                            <label for="s-xl" class="col-sm-2 font-weight-600">S-XL</label>
                                            <input type="hidden" name="size[]" value="S-XL">
                                            <div class="col-sm-3">
                                                <input type="number" min="0" name="size_total_price[]" readonly value="" class="my-form-control" id="sp_s_xl" placeholder="">

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label for="location2_charge" class="col-sm-2 font-weight-600">Location 2 Charge</label>
                                            <input type="hidden" name="location_charge[]" value="Location 2 Charge">
                                            <div class="col-sm-3">
                                                <input type="number" min="0" name="location_charge_price[]" readonly value="" class="my-form-control location_charges" id="location2_charge" placeholder="">
                                            </div>
                                            <label for="sp_xxl" class="col-sm-2 font-weight-600">XXL</label>
                                            <input type="hidden" name="size[]" value="XXL">
                                            <div class="col-sm-3">
                                                <input type="number" min="0" name="size_total_price[]" readonly value="" class="my-form-control" id="sp_xxl" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label for="location3_charge" class="col-sm-2 font-weight-600">Location 3 Charge</label>
                                            <input type="hidden" name="location_charge[]" value="Location 3 Charge">
                                            <div class="col-sm-3">
                                                <input type="number" min="0" name="location_charge_price[]" readonly value="" class="my-form-control location_charges" id="location3_charge" placeholder="">
                                            </div>
                                            <label for="sp_xxxl" class="col-sm-2 font-weight-600">XXXL</label>
                                            <input type="hidden" name="size[]" value="XXXL">
                                            <div class="col-sm-3">
                                                <input type="number" min="0" name="size_total_price[]" readonly value="" class="my-form-control" id="sp_xxxl" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label for="location4_charge" class="col-sm-2 font-weight-600">Location 4 Charge</label>
                                            <input type="hidden" name="location_charge[]" value="Location 4 Charge">
                                            <div class="col-sm-3">
                                                <input type="number" min="0" name="location_charge_price[]" readonly value="" class="my-form-control location_charges" id="location4_charge" placeholder="">
                                            </div>
                                            <label for="sp_xxxxl" class="col-sm-2 font-weight-600">XXXXL</label>
                                            <input type="hidden" name="size[]" value="XXXXL">
                                            <div class="col-sm-3">
                                                <input type="number" min="0" name="size_total_price[]" readonly value="" class="my-form-control" id="sp_xxxxl" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="form-group row">
                                            <label for="location5_charge" class="col-sm-2 font-weight-600">Location 5 Charge</label>
                                            <input type="hidden" name="location_charge[]" value="Location 5 Charge">
                                            <div class="col-sm-3">
                                                <input type="number" min="0" name="location_charge_price[]" readonly value="" class="my-form-control location_charges" id="location5_charge" placeholder="">
                                            </div>
                                            <label for="sp_xxxxxl" class="col-sm-2 font-weight-600">XXXXXL</label>
                                            <input type="hidden" name="size[]" value="XXXXXL">
                                            <div class="col-sm-3">
                                                <input type="number" min="0" name="size_total_price[]" readonly value="" class="my-form-control" id="sp_xxxxxl" placeholder="">
                                            </div>
                                        </div>
                                    </div>
                                {{-- </form> --}}
                            </div>
                            <div class="tab-pane fade" id="OTHERCHARGES" role="tabpanel" aria-labelledby="OTHERCHARGES-tab">
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="fold_bag_tag_pieces" class="col-sm-2 font-weight-600">FOLD/BAG/TAG</label>
                                        <div class="col-sm-3">
                                            <input type="number" min="0" name="fold_bag_tag_pieces" value="" class="my-form-control " id="fold_bag_tag_pieces" placeholder="Pieces">

                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" min="0" name="fold_bag_tag_prices" value="" class="my-form-control mr-2" id="fold_bag_tag_prices" placeholder="Prices">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="hang_tag_pieces" class="col-sm-2 font-weight-600">Hang Tag</label>
                                        <div class="col-sm-3">
                                            <input type="number" min="0" name="hang_tag_pieces" value="" class="my-form-control " id="hang_tag_pieces" placeholder="Pieces">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" min="0" name="hang_tag_prices" value="" class="my-form-control mr-2" id="hang_tag_prices" placeholder="Prices">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="art_fee" class="col-sm-2 font-weight-600">Art Fee</label>
                                        <div class="col-sm-3">
                                            <select name="art_fee" id="art_fee" class="my-form-control">
                                                <option value="">Select</option>
                                                <option value="0">$0.00</option>
                                                <option value="20">$20.00</option>
                                                <option value="30">$30.00</option>
                                                <option value="40">$40.00</option>
                                                <option value="50">$50.00</option>
                                                <option value="55">$55.00</option>
                                                <option value="60">$60.00</option>
                                                <option value="100">$100.00</option>
                                                <option value="120">$120.00</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="art_discount" class="col-md-2 font-weight-600">Art Discount</label>
                                        <div class="col-sm-3">
                                            <select name="art_discount" id="art_discount" class="my-form-control">
                                                <option value="">Select</option>
                                                <option value="0" >$0.00</option>
                                                <option value="20" >-$20.00</option>
                                                <option value="25" >-$25.00</option>
                                                <option value="30" >-$30.00</option>
                                                <option value="35" >-$35.00</option>
                                                <option value="40" >-$40.00</option>
                                                <option value="50" >-$50.00</option>
                                                <option value="60" >-$60.00</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="art_time" class="col-sm-2 font-weight-600">Art Time</label>
                                        <div class="col-sm-3">
                                            <select name="art_time" id="art_time" class="my-form-control">
                                                <option value="">Select</option>
                                                <option value="1">1 Hour</option>
                                                <option value="2">2 Hour</option>
                                                <option value="3">3 Hour</option>
                                                <option value="4">4 Hour</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="tax" class="col-md-2 font-weight-600">Tax</label>
                                        <div class="col-sm-3">
                                            <select name="tax" id="tax" class="my-form-control">
                                                <option value="">Select</option>
                                                <option value="0" >0</option>
                                                <option value="8.375" >8.375%</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="MARGINS" role="tabpanel" aria-labelledby="MARGINS-tab">
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="transfers_pieces" class="col-sm-2 font-weight-600">Transfers</label>
                                        <div class="col-sm-3">
                                            <input type="number" min="0" name="transfers_pieces" value="" class="my-form-control " id="transfers_pieces" placeholder="Pieces">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" min="0" name="transfers_prices" value="" class="my-form-control mr-2" id="transfers_prices" placeholder="Prices">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="ink_color_change_pieces" class="col-sm-2 font-weight-600">Ink Color Change</label>
                                        <div class="col-sm-3">
                                            <input type="number" min="0" name="ink_color_change_pieces" value="" class="my-form-control " id="ink_color_change_pieces" placeholder="Pieces">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" min="0" name="art_discount_prices" value="" class="my-form-control mr-2" id="art_discount_prices" placeholder="Prices">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="hang_tag1" class="col-sm-2 font-weight-600">Shipping</label>
                                        <div class="col-sm-3">
                                            <select name="art_fee" id="art_fee" class="my-form-control">
                                                <option value="">Select</option>
                                                <option value="20">$20.00</option>
                                                <option value="30">$30.00</option>
                                                <option value="40">$40.00</option>
                                                <option value="50">$50.00</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-3">

                                        </div>
                                    </div>
                                </div>
                                <hr class="dotted">
                                <div class="col-md-10">
                                    <div class="form-group row">

                                        <div class="col-sm-3 offset-2">
                                            <label for="min_profit_margin" class="font-weight-600">Min Margin</label>
                                            <select onchange="setMinMargin(this);" name="min_profit_margin" id="min_profit_margin" class="my-form-control">
                                                <option value="">Select Min Margin</option>
                                                @for ($i = 1; $i <=100; $i++)
                                                <option value="{{$i}}" >{{$i}} %</option>
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="max_profit_margin" class="font-weight-600">Max Margin</label>
                                            <select name="max_profit_margin" onchange="setMaxMargin();" id="max_profit_margin" class="my-form-control">
                                                <option value="">Select Max Margin</option>
                                                @for ($i = 1; $i <=100; $i++)
                                                <option value="{{$i}}" >{{$i}} %</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="sxl_min_mar" class="col-sm-2 font-weight-600">S-XL</label>
                                        <input type="hidden" name="margin_size[]" value="S-XL">
                                        <div class="col-sm-3">
                                            <input type="number" class="my-form-control" placeholder="Min" name="min_margin[]" readonly="" id="sxl_min_mar">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" class="my-form-control" placeholder="Max"  name="max_margin[]" readonly="" id="sxl_max_mar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="xxl_min_mar" class="col-sm-2 font-weight-600">XXL</label>
                                        <input type="hidden" name="margin_size[]" value="XXL">
                                        <div class="col-sm-3">
                                            <input type="number" class="my-form-control" name="min_margin[]" placeholder="Min" readonly="" id="xxl_min_mar">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" class="my-form-control" placeholder="Max"  name="max_margin[]" readonly="" id="xxl_max_mar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="xxxl_min_mar" class="col-sm-2 font-weight-600">XXXL</label>
                                        <input type="hidden" name="margin_size[]" value="XXXL">
                                        <div class="col-sm-3">
                                            <input type="number" class="my-form-control" name="min_margin[]" placeholder="Min" readonly="" id="xxxl_min_mar">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" class="my-form-control"  placeholder="Max" name="max_margin[]" readonly="" id="xxxl_max_mar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="xxxl_min_mar" class="col-sm-2 font-weight-600">XXXXL</label>
                                        <input type="hidden" name="margin_size[]" value="XXXXL">
                                        <div class="col-sm-3">
                                            <input type="number" class="my-form-control" name="min_margin[]" placeholder="Min" readonly="" id="xxxxl_min_mar">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" class="my-form-control" placeholder="Max" name="max_margin[]" readonly="" id="xxxxl_max_mar">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="xxxxxl_min_mar" class="col-sm-2 font-weight-600">XXXXXL</label>
                                        <input type="hidden" name="margin_size[]" value="XXXXXL">
                                        <div class="col-sm-3">
                                            <input type="number" class="my-form-control" name="min_margin[]" placeholder="Min" readonly="" id="xxxxxl_min_mar">
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="number" class="my-form-control"  placeholder="Max" name="max_margin[]" readonly="" id="xxxxxl_max_mar">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('footer-script')
    <script>
        $(document).ready(function(){

            $('#product_ids').on('select2:unselect', function (e) {
                var p_id        = ".product-detail-"+e.params.data.id;
                $(p_id).remove();
            });
        // $('select').select2();
        $(".select-supply").select2({
            tags: true
        });
        $("#brand").select2({
            tags: true
        });
        var order_box_template         = $(".order-box").clone();
        var order_box_parent           = $(".order-box-p");
        $(document).on("change", "#brand", function(){
            var  brand = $("#brand").val();
            $.ajax({
                url: "{{ route('admin.get_product_by_brand') }}",
                type: "GET",
                data: {
                    brand: brand
                },
                success: function(data) {
                    $('#product_ids').empty();
                    $('#product_ids').html(data);
                }
            });

        });
        $("#product_ids").on("select2:select", function (e){
            var product_id      = e.params.data.id;
            if(product_id != ""){
                $.ajax({
                    url: "{{ route('admin.order.product') }}",
                    type: "GET",
                    data: {
                        product_id      : product_id
                    },
                    success: function(data) {
                        $('.accordion').append(data);   
                    },
                    beforeSend: function() {
                        $('.page-loader-wrapper').show();
                    },
                    complete: function(){
                        $('.page-loader-wrapper').hide();
                        $('.Order-form').show();
                    }
                });
            } 
        });
        $("#product_ids").on("select2:select", function (e){
            var product_id      = e.params.data.id;
            if(product_id != ""){
                $.ajax({
                    url: "{{ route('admin.order.print_nd_loations') }}",
                    type: "GET",
                    data: {
                        product_id      : product_id
                    },
                    success: function(data) {
                        $('#accordion2').append(data);   
                    },
                    beforeSend: function() {
                        $('.page-loader-wrapper').show();
                    },
                    complete: function(){
                        $('.page-loader-wrapper').hide();
                        $('.product-print-locations').show();
                    }
                });
            } 
        });
        var init                     = 1;
        $(document).on('click', '.add_product', function(event) {
            event.preventDefault();
            var time = {{time()}};
            var  product_id = $(this).data('product_id');

            console.log('product_id' + product_id);
            console.log('init' + init);
            // Clone Final Price Tab
            var final_price_clone = $(".clone-product-"+product_id).clone().find("input").val("").end();

            var ttt = $(final_price_clone).removeClass("clone-product-"+product_id);
            $(final_price_clone).addClass("clone-product-"+product_id+'-'+init);

            $("#cloneDev-"+product_id).append(final_price_clone);

            var product_add             = $(this).parent().parent().clone();
            var append_parent           = $(this).parent().parent().parent().last();
            // console.log(append_parent);
            var new_product_add         = product_add.clone().find("input").val("").end();
            var ttt = $(new_product_add).children().eq(1).children().eq(0).attr('data-add_product',product_id+'-'+init);
            var ttt = $(new_product_add).children().eq(1).children().eq(1).attr('data-remove_product',product_id+'-'+init);
            // console.log(ttt);
            append_parent.append(new_product_add);
            init++;
        });
        $(document).on('click', '#remove_product', function(e) {
            e.preventDefault();
            var  product_id = $(this).data('product_id');
            var  remove_product = $(this).data('remove_product');

            console.log('product_id  length' + product_id);
            console.log('remove_product :' + remove_product);
            if(product_id != remove_product){
                $(this).parent().parent().remove();
                var id  = $(this).attr('data-remove_product');

                $(".clone-product-"+id).remove();
                init--; //Decrement field counter
            }
        });

        $(document).on('change', 'input[name=measurement_type]', function(){

            if($(this).is(':checked')){

                var measurement_type        = $(this).val();
                $('.rh-m-text').each(function(index, value){

                    if(measurement_type == 'Inches'){

                        $(this).text('Inches');
                    }else if(measurement_type == 'cms'){

                        $(this).text('cms');
                    }
                });

            }
        });

        $(document).on('change', '#client_id', function(){
            var client_id       = $(this).val();
            get_client_recent_order(client_id);
            if(client_id != 'new'){
                $('.client-form').addClass('btn-d-none');
                $.ajax({
                    {{-- url: "{{ route('admin.client.get_detail') }}",  --}}
                    type: "GET",
                    data: {
                        client_id: client_id
                    },
                    success: function(data) {

                        $('input[name=first_name]').val(data.first_name);
                        $('input[name=last_name]').val(data.last_name);
                        $('input[name=phone_number]').val(data.phone_number);
                        $('input[name=email]').val(data.email);   

                        $('input[name=first_name]').attr('readonly', true);
                        $('input[name=last_name]').attr('readonly', true);
                        $('input[name=phone_number]').attr('readonly', true);
                        $('input[name=email]').attr('readonly', true);
                        $('#add-client').addClass('btn-d-none');

                        get_client_recent_order(client_id);
                    }
                });

            }else if(client_id == 'new'){

                $('.client-form').removeClass('btn-d-none');
                $('input[name=first_name]').val('');
                $('input[name=last_name]').val('');
                $('input[name=phone_number]').val('');
                $('input[name=email]').val('');

                read_only(true);
            }
        });
        function read_only(readonly=false){
            if(readonly){
                $('input[name=first_name]').attr('readonly', false);
                $('input[name=last_name]').attr('readonly', false);
                $('input[name=phone_number]').attr('readonly', false);
                $('input[name=email]').attr('readonly', false);

                $('#add-client').removeClass('btn-d-none');
            }else{
                $('input[name=first_name]').attr('readonly', true);
                $('input[name=last_name]').attr('readonly', true);
                $('input[name=phone_number]').attr('readonly', true);
                $('input[name=email]').attr('readonly', true);

                $('#add-client').addClass('btn-d-none');
            }
        }
        $(document).on("click", "#add-client", function(event){

            event.preventDefault();

            var first_name          = $('input[name=first_name]').val();
            var last_name           = $('input[name=last_name]').val();
            var phone_number        = $('input[name=phone_number]').val();
            var email               = $('input[name=email]').val();

            $.ajax({
                url: "{{ route('admin.client.add_client') }}",
                type: "GET",
                data: {
                    first_name      : first_name,
                    last_name       : last_name,
                    phone_number    : phone_number,
                    email           : email
                },
                success: function(data) {
                    $('.client-form').html('');
                    $('.client-form').html(data);

                    if($('#client_return_id').val() != ""){

                        get_clients($('#client_return_id').val());
                    }
                    if($('#error_return').val() == ""){
                        setTimeout(function(){
                            console.log($('#client_return_id').val());
                            $('#client_id').val($('#client_return_id').val()).trigger("change");
                        }, 1000);
                    }
                }
            });
        });
        read_only();

        function get_clients(client_id){

            $.ajax({
                url: "{{ route('admin.client.get_client') }}",
                type: "GET",
                data: {
                    client_id      : client_id
                },
                success: function(data) {
                    $('select[name=client_id]').html('');
                    $('select[name=client_id]').html(data);
                }
            });

        }

        function get_client_recent_order(client_id){
            $.ajax({
                url: "{{ route('admin.order.get_client_recent_order') }}",
                type: "GET",
                data: {
                    client_id      : client_id
                },
                success: function(result) {
                    result          = JSON.parse(result);
                    if(result.status){
                        data        = result.data;
                        console.log(data);
                        $.each(data, function(key, val){

                            if(key == 'measurement_type'){
                                $.each($('input[name='+key+']'), function(){
                                    if($(this).val() == val){
                                        $(this).prop("checked", true);
                                        $(this).trigger('change');
                                    }
                                });
                            }else if(key == 'title'){

                                $('#title').val(val).trigger('change');

                            }else{

                                $('input[name='+key+']').val(val);
                            }
                        });

                    }
                }
            });
        }
    });
function setTotal(obj) {
    if (obj.id == "price") {
        var price =  $(obj).val();
        var pieces =  $(obj).parent().prev().find('input[type=number]').val();
        $(obj).parent().next().find('input[type=number]').val(price*pieces);
    }
    if (obj.id == "pieces") {
        var pieces =  $(obj).val();
        var price =  $(obj).parent().next().find('input[type=number]').val();
        $(obj).parent().next().next().find('input[type=number]').val(price*pieces);

    }
     setProjectedUnits()
    
}
function setProjectedUnits(){
    var pieces = $(".pieces");
    var totalPieces = 0;
    for(var i = 0; i < pieces.length; i++){
        totalPieces = totalPieces + + $(pieces[i]).val()
    }
    $('#ProjectedUnits').val(totalPieces);
    updateContractShirtPrintPrice();
    setMinMargin();
    setMaxMargin();
    $('.location_color').each(function(i, obj) {
     // console.log(obj);
    getDecorationPrice(obj);
 });
    
}


function getDecorationPrice(obj){
    var ProjectedUnits = $('#ProjectedUnits').val();
    var number_of_colors = $(obj).val();
    if (number_of_colors > 8 ) {
        $(obj).val(0);
        return false;
    }
    // console.log(obj.id);
    // console.log(number_of_colors);
    if (ProjectedUnits > 0 && number_of_colors > 0) {
      $.ajax({
        url: "{{ route('admin.get_decoration_price') }}",
        type: "GET",
        data: {
            total_pieces: ProjectedUnits,
            number_of_colors:number_of_colors,
        },
        success: function(value) {
            if (obj.id == "color_location1") {

                $("#location1_charge").val(value)

            }
            else if (obj.id == "color_location2") {

                $("#location2_charge").val(value)

            }else if (obj.id == "color_location3") {

                $("#location3_charge").val(value)

            }else if (obj.id == "color_location4") {

                $("#location4_charge").val(value)

            }else if (obj.id == "color_location5") {

                $("#location5_charge").val(value)

            }
            setTimeout(function(){

             updateContractShirtPrintPrice();
             setMinMargin();
             setMaxMargin();
         },300);
        }
    });

  }else{
    {
        if (obj.id == "color_location1") {

            $("#location1_charge").val(null)

        }
        else if (obj.id == "color_location2") {

            $("#location2_charge").val(null)

        }else if (obj.id == "color_location3") {

            $("#location3_charge").val(null)

        }else if (obj.id == "color_location4") {

            $("#location4_charge").val(null)

        }else if (obj.id == "color_location5") {

            $("#location5_charge").val(null)

        }
        setTimeout(function(){
          updateContractShirtPrintPrice();
          setMinMargin();
          setMaxMargin();
      },300);
    }
    
}

}
function updateContractShirtPrintPrice() {
   var totalLocationCharges =  setLocationCharges();
   console.log('updateContractShirtPrintPrice');
   var pl_s_xl = $('#pl_s_xl').val();
   var sp_s_xl = Number(pl_s_xl) + Number(totalLocationCharges);
   sp_s_xl = (Math.round(sp_s_xl * 100) / 100).toFixed(2);
   $("#sp_s_xl").val(sp_s_xl);


   var pl_xxl = $('#pl_xxl').val();
   var sp_xxl = Number(pl_xxl) + Number(totalLocationCharges);
   sp_xxl = (Math.round(sp_xxl * 100) / 100).toFixed(2);
   $("#sp_xxl").val(sp_xxl);

   var pl_xxxl = $('#pl_xxxl').val();
   var sp_xxxl = Number(pl_xxxl) + Number(totalLocationCharges);
   sp_xxxl = (Math.round(sp_xxxl * 100) / 100).toFixed(2);
   $("#sp_xxxl").val(sp_xxxl);

   var pl_xxxxl = $('#pl_xxxxl').val();
   var sp_xxxxl = Number(pl_xxxxl) + Number(totalLocationCharges);
   sp_xxxxl = (Math.round(sp_xxxxl * 100) / 100).toFixed(2);
   $("#sp_xxxxl").val(sp_xxxxl);

   var pl_xxxxxl = $('#pl_xxxxxl').val();
   var sp_xxxxxl = Number(pl_xxxxxl) + Number(totalLocationCharges);
   sp_xxxxxl = (Math.round(sp_xxxxxl * 100) / 100).toFixed(2);
   $("#sp_xxxxxl").val(sp_xxxxxl);
}
function setDecorationPrice(obj){
    // return false;
    var totalLocationCharges =  setLocationCharges();
    if (totalLocationCharges > 0) {

        var price = $(obj).val();
        if (obj.id == "pl_s_xl"){
            var sp_s_xl = Number(price) + Number(totalLocationCharges);
            sp_s_xl = (Math.round(sp_s_xl * 100) / 100).toFixed(2);

            $("#sp_s_xl").val(sp_s_xl);
        }
        if (obj.id == "pl_xxl"){
            var sp_xxl = Number(price) + Number(totalLocationCharges);
            sp_xxl = (Math.round(sp_xxl * 100) / 100).toFixed(2);

            $("#sp_xxl").val(sp_xxl);
        }

        if (obj.id == "pl_xxxl"){
            var sp_xxxl = Number(price) + Number(totalLocationCharges);
            sp_xxxl = (Math.round(sp_xxxl * 100) / 100).toFixed(2);

            $("#sp_xxxl").val(sp_xxxl);
        }

        if (obj.id == "pl_xxxxl"){
            var sp_xxxxl = Number(price) + Number(totalLocationCharges);
            sp_xxxxl = (Math.round(sp_xxxxl * 100) / 100).toFixed(2);

            $("#sp_xxxxl").val(sp_xxxxl);
        }
        if (obj.id == "pl_xxxxxl"){
            var sp_xxxxxl = Number(price) + Number(totalLocationCharges);
            sp_xxxxxl = (Math.round(sp_xxxxxl * 100) / 100).toFixed(2);

            $("#sp_xxxxxl").val(sp_xxxxxl);
        }

    }
    setMinMargin();
    setMaxMargin();
    updateContractShirtPrintPrice();
}
    // location_charges
    function setLocationCharges(){
        var location_charges = $(".location_charges");
        var totalLocationCharges = 0;
        for(var i = 0; i < location_charges.length; i++){
            totalLocationCharges = totalLocationCharges + + $(location_charges[i]).val()
        }
        return totalLocationCharges;
    }
    // var diff = 100 - selected precentage  
    //  var diff2= diff / 100 ;
    // var value =  sp_s_xl / diff2; 
    function setMinMargin() {
        var minMargin = $("#min_profit_margin").val();

        if (minMargin != '') {
            var diff = (100 - Number(minMargin)); 
            diff = (diff / 100);

            $("#sxl_min_mar").val(0);
            $("#xxl_min_mar").val(0);
            $("#xxxl_min_mar").val(0);
            $("#xxxxl_min_mar").val(0);
            $("#xxxxxl_min_mar").val(0);

            if ($("#pl_s_xl").val() > 0 ) {

                var sxl_min_mar =  ($("#sp_s_xl").val() / diff);
                $("#sxl_min_mar").val((Math.round(sxl_min_mar * 100) / 100).toFixed(2) );
            }
            if ($("#pl_xxl").val() > 0 ) {

                var xxl_min_mar =  ($("#sp_xxl").val() / diff);
                $("#xxl_min_mar").val((Math.round(xxl_min_mar * 100) / 100).toFixed(2) );
            }
            if ($("#pl_xxxl").val() > 0 ) {
                var xxxl_min_mar =  ($("#sp_xxxl").val() / diff);
                $("#xxxl_min_mar").val((Math.round(xxxl_min_mar * 100) / 100).toFixed(2) );
            }
            if ($("#pl_xxxxl").val() > 0 ) {
                var xxxxl_min_mar =  ($("#sp_xxxxl").val() / diff);
                $("#xxxxl_min_mar").val((Math.round(xxxxl_min_mar * 100) / 100).toFixed(2) );
            }
            if ($("#pl_xxxxxl").val() > 0 ) {
                var xxxxxl_min_mar =  ($("#sp_xxxxxl").val() / diff);
                $("#xxxxxl_min_mar").val((Math.round(xxxxxl_min_mar * 100) / 100).toFixed(2) );
            }
        }

    }
    function setMaxMargin() {
        var maxMargin = $("#max_profit_margin").val();
        if (maxMargin != '') {
         var diff = (100 - Number(maxMargin)); 
         diff = (diff / 100);

         $("#sxl_max_mar").val(0);
         $("#xxl_max_mar").val(0);
         $("#xxxl_max_mar").val(0);
         $("#xxxxl_max_mar").val(0);
         $("#xxxxxl_max_mar").val(0);

         if ($("#pl_s_xl").val() > 0 ) {

            var sxl_max_mar =  ($("#sp_s_xl").val() / diff);
            $("#sxl_max_mar").val((Math.round(sxl_max_mar * 100) / 100).toFixed(2) );
        }
        if ($("#pl_xxl").val() > 0 ) {

            var xxl_max_mar =  ($("#sp_xxl").val() / diff);
            $("#xxl_max_mar").val((Math.round(xxl_max_mar * 100) / 100).toFixed(2) );
        }
        if ($("#pl_xxxl").val() > 0 ) {
            var xxxl_max_mar =  ($("#sp_xxxl").val() / diff);
            $("#xxxl_max_mar").val((Math.round(xxxl_max_mar * 100) / 100).toFixed(2) );
        }
        if ($("#pl_xxxxl").val() > 0 ) {
            var xxxxl_max_mar =  ($("#sp_xxxxl").val() / diff);
            $("#xxxxl_max_mar").val((Math.round(xxxxl_max_mar * 100) / 100).toFixed(2) );
        }
        if ($("#pl_xxxxxl").val() > 0 ) {
            var xxxxxl_max_mar =  ($("#sp_xxxxxl").val() / diff);
            $("#xxxxxl_max_mar").val((Math.round(xxxxxl_max_mar * 100) / 100).toFixed(2) );
        }}

    }

    $(document).on('click', '.add-supply-row', function(event) {
        var supply_info_template         = $(this).closest('.order-box').find(".supply-info").first().clone();
        var supply_info_parent           = $(this).closest('.order-box').find(".supply-p");

        supply_info_template.find("span.select2").remove();
        var new_supply_info_template = supply_info_template.clone();
        event.preventDefault();
        new_supply_info_template.find("select").select2({
            tags: true
        });
        supply_info_parent.append(new_supply_info_template);
        new_supply_info_template.find('input').val(null);
        init_supply++;
    });


</script>
@endsection