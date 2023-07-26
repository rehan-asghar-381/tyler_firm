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
                            <div class="col-md-3">
                                <label>Client</label>

                                <select name="client_id" id="client_id" class="form-control search_test select-one"  >
                                    <option value=""> Select</option>
                                    {{-- <option value="new">Add New Client</option>--}}
                                    @foreach ($clients as $client)
                                    <option value="{{ $client->id }}" @if($order->client_id == $client->id) {{ "selected" }} @endif>{{ $client->company_name}}</option>
                                    @endforeach
                                </select>
                                
                            </div>
                            <div class="col-md-3">
                                <label>Sales Rep.</label>

                                <select name="sales_rep" id="sales_rep" class="form-control"  >
                                    <option value=""> Select</option>
                                </select>
                                
                            </div>
                            <div class="col-md-3">
                                <label>Job Name</label>
                                <input type="text" class="form-control" name="job_name" value="{{$order->job_name}}" placeholder="Job Name">
                            </div>
                            <div class="col-md-3">
                                <label>Purchase Order #</label>
                                <input type="text" class="form-control" name="order_number" value="{{$order->order_number}}" placeholder="Order Number">
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="form-group">
                                    <label>Due Date: </label>&nbsp;&nbsp;&nbsp;
                                    <div class="input-group date">
                                        <input type="text" name="due_date" class="form-control bg-light flatpickr" value="{{date("Y-m-d h:i", $order->due_date)}}" required="" id="due_date">
                                        <div class="input-group-addon input-group-append">
                                            <div class="input-group-text">
                                                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Event</label>

                                    <select name="event" id="event" class="form-control"  >
                                        <option value=""> Select</option>
                                        <option value="Yes" @if($order->event == "Yes") {{ "selected" }} @endif> Yes</option>
                                        <option value="No" @if($order->event == "No") {{ "selected" }} @endif> No</option>
                                </select>
                                </div>
                                
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                <label>Shipping Address</label>
                                <textarea type="text" value="" class="form-control" name="shipping_address" id="shipping_address" placeholder="" rows="3" >{{$order->shipping_address}}</textarea>
                                </div>
                                
                            </div>
                        </div>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Garments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Print Location & Colors + Contract & Shirt + Print Price</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="OTHERCHARGES-tab" data-toggle="pill" href="#OTHERCHARGES" role="tab" aria-controls="OTHERCHARGES" aria-selected="false">Other Charges</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                         <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                            <div class="row mb-3">
                                    <div class="col-md-5">
                                        <label>Products</label>
                                        <select name="product_ids[]" id="product_ids" class="form-control basic-multiple" multiple="multiple">
                                            @if (count($products) > 0)
                                            @foreach ($products as $product)
                                            <option value="{{$product->id}}" @if(in_array($product->id, $order_product_ids_arr)) {{"selected"}} @endif>{{$product->name}} [ {{$product->code}}]</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
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
                                            <input type="text" value="{{$order->projected_units}}" readonly="" style="background-color: #ced4da" class="my-form-control" 
                                            name="projected_units" id="ProjectedUnits" placeholder="">
                                        </div>
                                    </div>
                                </div>
                                <div class="row product-print-locations btn-d-none">
                                    <div id="accordion2" class="accordion2" style="min-height: 200px;">
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="OTHERCHARGES" role="tabpanel" aria-labelledby="OTHERCHARGES-tab">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="fold_bag_tag_pieces" class="col-sm-3 font-weight-600">FOLD/BAG/TAG</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="fold_bag_tag_pieces" value="{{$order->OrderOtherCharges->fold_bag_tag_pieces ?? 0}}" class="my-form-control " id="fold_bag_tag_pieces" placeholder="Pieces">
        
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="fold_bag_tag_prices" value="{{$order->OrderOtherCharges->fold_bag_tag_prices ?? 0}}" class="my-form-control mr-2" id="fold_bag_tag_prices" placeholder="Prices">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="hang_tag_pieces" class="col-sm-3 font-weight-600">Hang Tag</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="hang_tag_pieces" value="{{$order->OrderOtherCharges->hang_tag_pieces ?? 0}}" class="my-form-control " id="hang_tag_pieces" placeholder="Pieces">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="hang_tag_prices" value="{{$order->OrderOtherCharges->hang_tag_prices ?? 0}}" class="my-form-control mr-2" id="hang_tag_prices" placeholder="Prices">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="art_fee" class="col-sm-3 font-weight-600">Art Fee</label>
                                                <div class="col-sm-4">
                                                    <select name="art_fee" id="art_fee" class="my-form-control">
                                                        <option value="">Select</option>
                                                        <option value="0" @if(isset($order->OrderOtherCharges->art_fee) && $order->OrderOtherCharges->art_fee == 0) {{"selected"}} @endif>$0.00</option>
                                                        <option value="20" @if(isset($order->OrderOtherCharges->art_fee) && $order->OrderOtherCharges->art_fee == 20) {{"selected"}} @endif>$20.00</option>
                                                        <option value="30" @if(isset($order->OrderOtherCharges->art_fee) && $order->OrderOtherCharges->art_fee == 30) {{"selected"}} @endif>$30.00</option>
                                                        <option value="40" @if(isset($order->OrderOtherCharges->art_fee) && $order->OrderOtherCharges->art_fee == 40) {{"selected"}} @endif>$40.00</option>
                                                        <option value="50" @if(isset($order->OrderOtherCharges->art_fee) && $order->OrderOtherCharges->art_fee == 50) {{"selected"}} @endif>$50.00</option>
                                                        <option value="55" @if(isset($order->OrderOtherCharges->art_fee) && $order->OrderOtherCharges->art_fee == 55) {{"selected"}} @endif>$55.00</option>
                                                        <option value="60" @if(isset($order->OrderOtherCharges->art_fee) && $order->OrderOtherCharges->art_fee == 60) {{"selected"}} @endif>$60.00</option>
                                                        <option value="100" @if(isset($order->OrderOtherCharges->art_fee) && $order->OrderOtherCharges->art_fee == 100) {{"selected"}} @endif>$100.00</option>
                                                        <option value="120" @if(isset($order->OrderOtherCharges->art_fee) && $order->OrderOtherCharges->art_fee == 120) {{"selected"}} @endif>$120.00</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="art_discount" class="col-sm-3 font-weight-600">Art Discount</label>
                                                <div class="col-sm-4">
                                                    <select name="art_discount" id="art_discount" class="my-form-control">
                                                        <option value="">Select</option>
                                                        <option value="0"  @if(isset($order->OrderOtherCharges->art_discount) && $order->OrderOtherCharges->art_discount == 0) {{"selected"}} @endif>$0.00</option>
                                                        <option value="20"  @if(isset($order->OrderOtherCharges->art_discount) && $order->OrderOtherCharges->art_discount == 20) {{"selected"}} @endif>-$20.00</option>
                                                        <option value="25"  @if(isset($order->OrderOtherCharges->art_discount) && $order->OrderOtherCharges->art_discount == 25) {{"selected"}} @endif>-$25.00</option>
                                                        <option value="30"  @if(isset($order->OrderOtherCharges->art_discount) && $order->OrderOtherCharges->art_discount == 30) {{"selected"}} @endif>-$30.00</option>
                                                        <option value="35"  @if(isset($order->OrderOtherCharges->art_discount) && $order->OrderOtherCharges->art_discount == 35) {{"selected"}} @endif>-$35.00</option>
                                                        <option value="40"  @if(isset($order->OrderOtherCharges->art_discount) && $order->OrderOtherCharges->art_discount == 40) {{"selected"}} @endif>-$40.00</option>
                                                        <option value="50"  @if(isset($order->OrderOtherCharges->art_discount) && $order->OrderOtherCharges->art_discount == 50) {{"selected"}} @endif>-$50.00</option>
                                                        <option value="60"  @if(isset($order->OrderOtherCharges->art_discount) && $order->OrderOtherCharges->art_discount == 60) {{"selected"}} @endif>-$60.00</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="art_time" class="col-sm-3 font-weight-600">Art Time</label>
                                                <div class="col-sm-4">
                                                    <select name="art_time" id="art_time" class="my-form-control">
                                                        <option value="">Select</option>
                                                        <option value="1" @if(isset($order->OrderOtherCharges->art_time) && $order->OrderOtherCharges->art_time == 1) {{"selected"}} @endif>1 Hour</option>
                                                        <option value="2" @if(isset($order->OrderOtherCharges->art_time) && $order->OrderOtherCharges->art_time == 2) {{"selected"}} @endif>2 Hour</option>
                                                        <option value="3" @if(isset($order->OrderOtherCharges->art_time) && $order->OrderOtherCharges->art_time == 3) {{"selected"}} @endif>3 Hour</option>
                                                        <option value="4" @if(isset($order->OrderOtherCharges->art_time) && $order->OrderOtherCharges->art_time == 4) {{"selected"}} @endif>4 Hour</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="tax" class="col-sm-3 font-weight-600">Tax</label>
                                                <div class="col-sm-4">
                                                    <select name="tax" id="tax" class="my-form-control">
                                                        <option value="">Select</option>
                                                        <option value="0" @if(isset($order->OrderOtherCharges->tax) && $order->OrderOtherCharges->tax == 0) {{"selected"}} @endif>0</option>
                                                        <option value="8.375" @if(isset($order->OrderOtherCharges->tax) && $order->OrderOtherCharges->tax == 8.375) {{"selected"}} @endif>8.375%</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="transfers_pieces" class="col-sm-3 font-weight-600">Transfers</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="transfers_pieces" value="{{$order->OrderTransfer->transfers_pieces ?? 0}}" class="my-form-control " id="transfers_pieces" placeholder="Pieces">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="transfers_prices" value="{{$order->OrderTransfer->transfers_prices ?? 0}}" class="my-form-control mr-2" id="transfers_prices" placeholder="Prices">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="ink_color_change_pieces" class="col-sm-3 font-weight-600">Ink Color Change</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="ink_color_change_pieces" value="{{$order->OrderTransfer->ink_color_change_pieces ?? 0}}" class="my-form-control " id="ink_color_change_pieces" placeholder="Pieces">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="art_discount_prices" value="{{$order->OrderTransfer->art_discount_prices ?? 0}}" class="my-form-control mr-2" id="art_discount_prices" placeholder="Prices">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="hang_tag1" class="col-sm-3 font-weight-600">Shipping charges</label>
                                                <div class="col-sm-4">
                                                    <select name="shipping_charges" id="shipping_charges" class="my-form-control">
                                                        <option value="">Select</option>
                                                        <option value="20" @if(isset($order->OrderTransfer->shipping_charges) && $order->OrderTransfer->shipping_charges == 20) {{"selected"}} @endif>$20.00</option>
                                                        <option value="30" @if(isset($order->OrderTransfer->shipping_charges) && $order->OrderTransfer->shipping_charges == 30) {{"selected"}} @endif>$30.00</option>
                                                        <option value="40" @if(isset($order->OrderTransfer->shipping_charges) && $order->OrderTransfer->shipping_charges == 40) {{"selected"}} @endif>$40.00</option>
                                                        <option value="50" @if(isset($order->OrderTransfer->shipping_charges) && $order->OrderTransfer->shipping_charges == 50) {{"selected"}} @endif>$50.00</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-3">
        
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12 form-check mt-5">
                                        <button type="submit" class="btn btn-primary mb-3" id="submit-form">Save Order</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <template>{{json_encode($fixed_sizes)}}</template>
                    <template id="order_product_ids">{{json_encode($order_product_ids_arr)}}</template>
                    <template id="all_adult_sizes">{{json_encode($all_adult_sizes)}}</template>
                    <template id="fixed_baby_sizes">{{json_encode($fixed_baby_sizes)}}</template>
                    <template id="all_baby_sizes">{{json_encode($all_baby_sizes)}}</template>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('footer-script')
    <script>
    $(document).ready(function(){
        var _order_id       = '{{$order->id}}';
        $('#product_ids').on('select2:unselect', function (e) {
            var p_id        = ".product-detail-"+e.params.data.id;
            $(p_id).remove();
        });
        
        let order_product_ids       = JSON.parse($("#order_product_ids").html());
        console.log("order_product_ids", order_product_ids);
        $.each(order_product_ids, function(index, product_id){
            console.log("product_id:", product_id);
            accordian_products(product_id, _order_id);
            accordian2_products(product_id, _order_id);
        });
    
        var _client_id      = '{{$order->client_id}}';
        var _sale_rep       = '{{$order->sales_rep}}';
        get_sales_rep(_client_id, _sale_rep);
        $('#client_id').on('change', function(e) {
            var client_id       = $(this).val();
            get_sales_rep(client_id);
        });

        function get_sales_rep(client_id="", _sale_rep = ""){

            if(client_id != "" && _sale_rep != ""){
                
                $.ajax({
                    url: "{{ route('admin.client.get_sales_rep') }}",
                    type: "GET",
                    data: {
                        client_id: client_id
                    },
                    success: function(data) {
                        $('#sales_rep').empty();
                        var html    = '<option value=""> --Select-- </option>';
                        $.each(data.sales_rep, function(index, sales_rep) {
                            let selected        = '';
                            if(sales_rep.id == _sale_rep){
                                selected        = 'selected';
                            }
                            html +='<option value="' + sales_rep.id + '" '+selected+'>' + sales_rep.first_name + ' ' +sales_rep.last_name+'</option>';
                        })
                        $('#sales_rep').html(html);
                        // $('select#sales_rep').trigger('change');
                    },
                    beforeSend: function() {
                    $('#preloader').show();
                    },
                    complete: function(){
                    $('#preloader').hide();
                    },
                })

            }else{

                $('#dictrict').empty();
                var html    = '<option value=""> --Select-- </option>';
                $('#dictrict').html(html);
            }

        }
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
        function accordian_products(product_id="", order_id){
            if(product_id != ""){
                $.ajax({
                    url: "{{ route('admin.order.product') }}",
                    type: "GET",
                    data: {
                        product_id      : product_id,
                        order_id        : order_id
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
        }
        $("#product_ids").on("select2:select", function (e){
            var product_id      = e.params.data.id;
            accordian_products(product_id="");
            
        });
        function accordian2_products(product_id="", order_id=""){

            if(product_id != ""){
                $.ajax({
                    url: "{{ route('admin.order.print_nd_loations') }}",
                    type: "GET",
                    data: {
                        product_id      : product_id,
                        order_id        : order_id
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
        }
        $("#product_ids").on("select2:select", function (e){
            var product_id      = e.params.data.id;
            accordian2_products(product_id);
        });
        var init                     = 1;
        $(document).on('click', '.add_product', function(event) {
            event.preventDefault();
            var time = {{time()}};
            var  product_id = $(this).data('product_id');
            // Clone Final Price Tab
            var final_price_clone = $(".clone-product-"+product_id).clone().find("input").val("").end();

            var ttt = $(final_price_clone).removeClass("clone-product-"+product_id);
            $(final_price_clone).addClass("clone-product-"+product_id+'-'+init);

            $("#cloneDev-"+product_id).append(final_price_clone);

            var product_add             = $(this).parent().parent().clone();
            var append_parent           = $(this).parent().parent().parent().last();
            var new_product_add         = product_add.clone().find("input").val("").end();
            var ttt = $(new_product_add).children().eq(1).children().eq(0).attr('data-add_product',product_id+'-'+init);
            var ttt = $(new_product_add).children().eq(1).children().eq(1).attr('data-remove_product',product_id+'-'+init);
            append_parent.append(new_product_add);
            init++;
        });
        $(document).on('click', '#remove_product', function(e) {
            e.preventDefault();
            var  product_id = $(this).data('product_id');
            var  remove_product = $(this).data('remove_product');
            if(product_id != remove_product){
                $(this).parent().parent().remove();
                var id  = $(this).attr('data-remove_product');

                $(".clone-product-"+id).remove();
                init--; //Decrement field counter
            }
        });
        
    });
    $(document).on("change", ".pieces, .price", function(){
        $(this).closest('.form-row').find('.total').val('');
        let pieces      = $(this).closest('.form-row').find('.pieces').val();
        let price       = $(this).closest('.form-row').find('.price').val();
        if(pieces != "" && price != ""){
            $(this).closest('.form-row').find('.total').val((pieces*price).toFixed(2));
        }

    });
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
    $(document).on("change", ".pieces", function(index, element){
        projected_units();
    });
    function projected_units(){

            var projected_units     = 0;
            $(".pieces").each(function(index, element){
                let number              = index+1;             
                let label_text          = '#'+number;
                projected_units         = projected_units+parseInt(($(this).val()!="")?$(this).val():0);
            });
            $("#ProjectedUnits").val(projected_units);
            $("#ProjectedUnits").trigger("change");

    }

    $(document).on('click', '.add-p-location', function(event) {
        var parent_id                       = $(this).attr('data-id');
        var parent_selector                 = '.p-print-location-'+parent_id;
        let count                           = $('.product-detail-'+parent_id).find('.location-count').val();
        var print_location_template         = $(this).closest(parent_selector).find(".print-location").first().clone();
        var print_location_parent           = $(this).closest(parent_selector);
        var new_print_location_template     = print_location_template.clone();
        event.preventDefault();
        print_location_parent.append(new_print_location_template);
        new_print_location_template.find('input').val(null);
        location_labels(parent_selector);
        count                               = parseInt(count)+1;
        $('.product-detail-'+parent_id).find('.location-count').val(count);
    });

    $(document).on('click', '.remove-p-location', function(e) {
        var parent_id                       = $(this).attr('data-id');
        var parent_selector                 = '.p-print-location-'+parent_id;
        console.log(parent_id);
        let count                           = $('.product-detail-'+parent_id).find('.location-count').val();
        count                               = parseInt(count)-1;
        console.log(count);
        e.preventDefault();
        if(count >= 1){
            $(this).closest('.print-location').remove();
            $($('.product-detail-'+parent_id)).find('.location-count').val(count);
            location_labels(parent_selector);
            $("#ProjectedUnits").trigger("change");
        }
        
    });

    $(document).on("change", ".attribute", function(e){
        e.preventDefault();
        let size_selector           = "";
        let size_select             = "";
        let all_adult_sizes         = JSON.parse($("#all_adult_sizes").html());
        let adult_fixed_sizes       = JSON.parse($('template').html());
        let fixed_baby_sizes        = JSON.parse($("#fixed_baby_sizes").html());
        let all_baby_sizes          = JSON.parse($('#all_baby_sizes').html());
        let all_sizes               = [];
        let fixed_sizes             = [];
        var product_id              = $(this).attr('data-product_id');
        
        if($('.product-detail-'+product_id).find(".product-type").val() == "Baby Size"){
            all_sizes                   = all_baby_sizes;
            fixed_sizes                 = fixed_baby_sizes;
            size_select                 = "OSFA-18M-";
        }else{
            all_sizes                   = all_adult_sizes;
            fixed_sizes                 = adult_fixed_sizes;
            size_select                 = "XS-XL-";
        }
        var selector                = '.form-row';
        let type                    = "";
        let v1_attr_id              = $(this).closest(selector).find('.v1_attr_id').val();
        let v2_attr_id              = $(this).closest(selector).find('.v2_attr_id').val();
        let price_selector          = $(this).closest(selector).find('.price');

        if($('.product-detail-'+product_id).find(".product-type").val() == "Baby Size"){
            type                = "Baby Size";
        }
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
                        size_selector       = "#"+size_select+product_id;
                    }else{
                        size_selector       = "#"+result.name+"-"+product_id;
                    } 
               
                    $('.product-detail-'+product_id).find(size_selector).val(result.price);
                    resetPrices(product_id);
                    calcTotal(product_id);
                    calcMargin(product_id);
                }
            });
        }
    });
    function calcDecogrationPrice(product_id=0){
        var ProjectedUnits          = $('#ProjectedUnits').val();
        var color_locations_arr     = [];
        var product_div             = ".product-detail-"+product_id;
        var selector                = $(product_div).find('.number-of-colors');
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
                $(product_div).find(".print_locations").each(function(index, element){
                    $(this).val(price);
                });
                calcTotal(product_id);
                calcMargin(product_id);
            }
        });
        } 
    }
    $(document).on("change", ".number-of-colors", function(){
        var product_id              = $(this).attr('data-product-id');
        calcDecogrationPrice(product_id);
    });

    function calcTotal(product_id=0){

        let whole_sale_price            = 0;
        let location_price              = 0;
        let total_price                 = 0;
        for(var i=1; i <=6; i++){
            
            let whole_sale_price         =  $('.product-detail-'+product_id).find(".whole-sale-"+i).val();
            let location_price           =  $('.product-detail-'+product_id).find(".location-"+i).val();

            whole_sale_price            = (whole_sale_price != "") ? whole_sale_price: 0;
            location_price              = (location_price != "")? location_price: 0;
            let total                   = (parseFloat(whole_sale_price)+ parseFloat(location_price)).toFixed(2);
            $($('.product-detail-'+product_id).find(".total-"+i)).val(total);
        }
    } 
    function resetPrices(product_id = 0){
        let size_selector               = "";
        let all_adult_sizes             = JSON.parse($("#all_adult_sizes").html());
        let adult_fixed_sizes           = JSON.parse($('template').html());
        let fixed_baby_sizes            = JSON.parse($("#fixed_baby_sizes").html());
        let all_baby_sizes              = JSON.parse($('#all_baby_sizes').html());
        let all_sizes                   = [];
        let fixed_sizes                 = [];
        let selected_sizes              = [];
        let flag                        = 0;
        let selector                    = $('.product-detail-'+product_id).find('.v2_attr_id');

        if($('.product-detail-'+product_id).find(".product-type").val() == "Baby Size"){
            all_sizes                   = all_baby_sizes;
            fixed_sizes                 = fixed_baby_sizes;
            size_selector               = "#OSFA-18M-";
        }else{
            all_sizes                   = all_adult_sizes;
            fixed_sizes                 = adult_fixed_sizes;
            size_selector               = "#S-XL-";
        }
        $(selector).each(function(indx, elm){
            selected_sizes.push($(this).find('option:selected').text());
        });
        
        $.each(fixed_sizes, function(index, element){
            if(jQuery.inArray(element, selected_sizes) != -1) {
                flag                    = 1;
            }
        });
        if(flag == 0){
            $('.product-detail-'+product_id).find(size_selector+product_id).val('');
        }
        $.each(all_sizes, function(index, element){
            if(jQuery.inArray(element, selected_sizes) != -1) {
                //do nothing
            }else{
                $('.product-detail-'+product_id).find("#"+element+"-"+product_id).val('');
            }
        });
    } 

    $(document).on("change", ".profit-margin", function(){
        let product_id          = $(this).attr('data-product-id');
        calcMargin(product_id);
    });

    function calcMargin(product_id= 0){

        let profit_margin               = $('.product-detail-'+product_id).find('.profit-margin').val();
        let total_selector              = ".total-";
        let profit_margin_selector      = ".margin-";
        let final_price_selector        = ".final-price-";
        if(profit_margin > 0){
            var diff = 100 - parseInt(profit_margin); 
            var diff2= diff / 100 ;
            
            for(var i=1; i <=6; i++){

                let total           = $('.product-detail-'+product_id).find(total_selector+i).val();
                let value           =  total / diff2; 
                $('.product-detail-'+product_id).find(profit_margin_selector+i).val(value.toFixed(2));   
                $('.product-detail-'+product_id).find(final_price_selector+i).val(value.toFixed(2));   
            }
        }
    }

    $(document).on("change","#ProjectedUnits", function(){
        let product_ids     = $("#product_ids").val();
        $.each(product_ids, function(index, element){
            
            resetPrices(element);
            calcDecogrationPrice(element);
            calcTotal(element);
            calcMargin(element);
        });

    });
</script>
@endsection