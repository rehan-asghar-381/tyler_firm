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
/* .accordion2 .card-header:after {
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
} */
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
                                            <label class="font-weight-600">Min Margin</label>
                                            <select name="min_profit_margin" class="my-form-control profit-margin">
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
                    <template>{{json_encode($fixed_sizes)}}</template>
                    <template id="all_adult_sizes">{{json_encode($all_adult_sizes)}}</template>
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
        setProjectedUnits();
    }
    function setProjectedUnits(){
        var pieces = $(".pieces");
        var totalPieces = 0;
        for(var i = 0; i < pieces.length; i++){
            totalPieces = totalPieces + + $(pieces[i]).val()
        }
        $('#ProjectedUnits').val(totalPieces);
        $('.location_color').each(function(i, obj) {
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

        if (ProjectedUnits > 0 && number_of_colors > 0) {
            $.ajax({
                url: "{{ route('admin.get_decoration_price') }}",
                type: "GET",
                data: {
                    total_pieces: ProjectedUnits,
                    number_of_colors:number_of_colors,
                },
                success: function(value) {
                    
                }
            });

        }

    }
    function location_labels(selector){

        if(selector != ""){
            var length          = $(selector).find(".print-location").length;
            $($(selector).find(".print-location")).each(function(index, element){
                let number              = index+1;             
                let label_text          = '# '+number;
                $(this).find('label').text(label_text);
            });
        }

    }
    function projected_units(){

            var projected_units     = 0;
            $(".pieces").each(function(index, element){
                let number              = index+1;             
                let label_text          = '#'+number;
                projected_units         = projected_units+parseInt($(this).val());
            });
            $("#ProjectedUnits").val(projected_units);

    }

    $(document).on('click', '.add-p-location', function(event) {
        var parent_id                       = $(this).attr('data-id');
        var parent_selector                 = '.p-print-location-'+parent_id;

        var print_location_template         = $(this).closest(parent_selector).find(".print-location").first().clone();
        var print_location_parent           = $(this).closest(parent_selector);
        var new_print_location_template = print_location_template.clone();
        event.preventDefault();
        print_location_parent.append(new_print_location_template);
        new_print_location_template.find('input').val(null);


        location_labels(parent_selector);
    });

    $(document).on('click', '.remove-p-location', function(e) {
        var parent_id                       = $(this).attr('data-id');
        var parent_selector                 = '.p-print-location-'+parent_id;
        e.preventDefault();
        $(this).closest('.print-location').remove();
        location_labels(parent_selector);
    });

    $(document).on("change", ".attribute", function(e){
        e.preventDefault();
        let size_selector           = "";
        var fixed_sizes             = JSON.parse($('template').html());
        var selector                = '.form-row';
        var product_id              = $(this).attr('data-product_id');
        let v1_attr_id              = $(this).closest(selector).find('.v1_attr_id').val();
        let v2_attr_id              = $(this).closest(selector).find('.v2_attr_id').val();
        let price_selector          = $(this).closest(selector).find('.price');
    
        if(v1_attr_id != "" && v2_attr_id != ""){
            $.ajax({
                url: "{{ route('admin.product.get_price') }}",
                type: "GET",
                data: {
                    product_id: product_id,
                    v1_attr_id: v1_attr_id,
                    v2_attr_id: v2_attr_id
                },
                success: function(result) {
                    result      = JSON.parse(result);
                    price_selector.val(result.price);
                    if(jQuery.inArray(result.name, fixed_sizes) != -1) {
                        size_selector       = "#S-XL-"+product_id;
                    } else if(result.name == "2XL") {
                        size_selector       = "#2XL-"+product_id;
                    } else if(result.name == "3XL") {
                        size_selector       = "#3XL-"+product_id;
                    } else if(result.name == "4XL") {
                        size_selector       = "#4XL-"+product_id;
                    } else if(result.name == "5XL") {
                        size_selector       = "#5XL-"+product_id;
                    } 
               
                    $('.product-detail-'+product_id).find(size_selector).val(result.price);
                    resetPrices(product_id);
                    calcTotal();
                }
            });
        }
    });
    $(document).on("change", ".number-of-colors", function(){
        var ProjectedUnits          = $('#ProjectedUnits').val();
        var color_locations_arr     = [];
        var product_id              = $(this).attr('data-product-id');
        var product_div             = ".product-detail-"+product_id;
        var selector                = $(this).closest(product_div).find('.number-of-colors');
        $($(selector)).each(function(index, element){
            if($(this).val() > 0 && $(this).val() != ""){

                color_locations_arr.push($(this).val());
            }
        });
        if(color_locations_arr.length > 0 ){
            $.ajax({
            url: "{{ route('admin.get_decoration_price') }}",
            type: "GET",
            data: {
                total_pieces: ProjectedUnits,
                number_of_colors:color_locations_arr
            },
            success: function(price) {
                $(".print_locations").each(function(index, element){
                    $(this).val(price);
                });
                calcTotal();
            }
        });
        } 
    });

    function calcTotal(){
        let whole_sale_selector         = ".whole-sale-";
        let location_selector           = ".location-";
        let total_selector              = ".total-";

        let whole_sale_price            = 0;
        let location_price              = 0;
        let total_price                 = 0;
        for(var i=1; i <=5; i++){
            
            whole_sale_price            = ($(whole_sale_selector+i).val() != "") ? $(whole_sale_selector+i).val(): 0;
            location_price              = ($(location_selector+i).val() != "")? $(location_selector+i).val(): 0;
            let total                   = (parseFloat(whole_sale_price)+ parseFloat(location_price)).toFixed(2);
            $(total_selector+i).val(total);
            
        }
    } 
    function resetPrices(product_id = 0){
        let all_adult_sizes             = $("#all_adult_sizes").html();
        let fixed_sizes                 = JSON.parse($('template').html());
        let selected_sizes              = [];
        all_adult_sizes                 = JSON.parse(all_adult_sizes);
        let flag                        = 0;

        let selector                    = $('.product-detail-'+product_id).find('.v2_attr_id');
        $(selector).each(function(indx, elm){
            selected_sizes.push($(this).find('option:selected').text());
        });
        
        $.each(fixed_sizes, function(index, element){
            if(jQuery.inArray(element, selected_sizes) != -1) {
                flag                    = 1;
                console.log('in_array');
            }
        });
        console.log('flag', flag);
        if(flag == 0){
            $('.product-detail-'+product_id).find("#S-XL-"+product_id).val('');
        }
        $.each(all_adult_sizes, function(index, element){
            if(jQuery.inArray(element, selected_sizes) != -1) {
                //do nothing
            }else{
                $('.product-detail-'+product_id).find("#"+element+"-"+product_id).val('');
            }
        });
    } 

    $(document).on("change", ".", function(){

    });
    
    function calcMargin(prduct_id   = 0){
        
    }
</script>
@endsection