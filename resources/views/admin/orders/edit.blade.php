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
.art_btn {
    display: inline-block;
    font-weight: 600;
    color: #fff;
    text-align: center;
    padding: 2px;
    min-width: 116px;
    transition: all 0.3s ease;
    cursor: pointer;
    border: 2px solid;
    background-color: #041e42;
    border-color: #041e42;
    border-radius: 10px;
    line-height: 26px;
    font-size: 14px;
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
.btn-sucess-custom{
	background-color: #28a745;
	color: #fff;
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
                    <form  method="POST"  action="{{ route('admin.orders.update', $order->id) }}" enctype="multipart/form-data" novalidate>
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{url('admin/orders/generate_invoice/'.$order->id)}}"  class="btn btn-primary" style="height: 40px;margin-top: 30px;margin-left: 12px;float:right;">Create Quote</a>
                                <a href="{{url('admin/orders/d_yellow/'.$order->id)}}"  class="btn btn-danger" style="height: 40px;margin-top: 30px;margin-left: 12px;float:right;">Create Yellow</a>
                            </div>
                        </div>
                        <div class="row">
                            <div class="upload__box">
                              <div class="upload__btn-box">
                                <label class="upload__btn">
                                  <p>Upload images</p>
                                  <input type="file" name="filePhoto[]" multiple="" data-max_length="20" class="upload__inputfile">
                                </label>
                              </div>
                              <div class="upload__img-wrap">
                                @if(count($order->OrderImgs) > 0)
                                    @foreach($order->OrderImgs as $key=>$OrderImg)
                                        <div class='upload__img-box'>
                                            <div style='background-image: url("{{asset($OrderImg->image)}}")' data-number='{{ $key }}' data-file='" + f.name + "' class='img-bg'>
                                                <div class='upload__img-close' data-order-id='{{ $order->id }}' data-img-id='{{ $OrderImg->id }}'></div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                              </div>
                            </div>
                        </div>
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

                                <select name="sales_rep" id="sales_rep" class="form-control">
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
                                        <input type="text" name="due_date" class="form-control bg-light flatpickr" value="@if($order->due_date>0) {{date("m-d-Y h:i", $order->due_date)}} @endif" required="" id="due_date">
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
                                    <label>Ship Date: </label>&nbsp;&nbsp;&nbsp;
                                    <div class="input-group date">
                                        <input type="text" name="ship_date" class="form-control bg-light flatpickr" value="@if($order->ship_date>0){{date("m-d-Y h:i",$order->ship_date)}} @endif" required="" id="ship_date">
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
                                <textarea type="text" value="" class="form-control" name="shipping_address" id="shipping_address" placeholder="" rows="2" >{{$order->shipping_address}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Notes</label>
                                    <textarea type="text" value="" class="form-control" name="notes" id="notes" placeholder="" rows="2" >{{$order->notes}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Internal Notes</label>
                                    <textarea type="text" value="" class="form-control" name="internal_notes" id="internal_notes" placeholder="" rows="2" >{{$order->internal_notes}}</textarea>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary mt-5" id="submit-form">Save Order</button>
                            </div>
                        </div>
                        <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link @if(!$active_art_room && !$active_comp) active @endif" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Garments</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Print Details</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="OTHERCHARGES-tab" data-toggle="pill" href="#OTHERCHARGES" role="tab" aria-controls="OTHERCHARGES" aria-selected="false">Other Charges</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($active_art_room) active show @endif" id="art-room-tab" data-toggle="pill" href="#art-room" role="tab" aria-controls="art-room" aria-selected="false">Art Room</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($active_comp) active show @endif" id="comps-tab" data-toggle="pill" href="#comps" role="tab" aria-controls="comps" aria-selected="false">Comps</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="pills-tabContent">
                         <div class="tab-pane fade @if(!$active_art_room && !$active_comp) show active @endif" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">

                            <div class="row mb-3">
                                    <div class="col-md-5">
                                        <label>Products</label>
                                        <select name="product_ids[]" id="product_ids" class="form-control basic-multiple" multiple="multiple">
                                            @if (count($products) > 0)
                                            @foreach ($products as $product)
                                            <option value="{{$product->id}}" @if(in_array($product->id, array_keys($order_product_ids_arr))) {{"selected"}} @endif data-custom-selector="{{$product->id."-1"}}">{{$product->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="form-group row">
                                        <label for="art_fee" class="col-sm-2 font-weight-600">Projected Units</label>
                                        <div class="col-sm-3">
                                            <input type="text" value="{{$order->projected_units}}" readonly="" style="background-color: #ced4da" class="my-form-control ProjectedUnits" 
                                            name="projected_units" id="ProjectedUnits" placeholder="">
                                        </div>
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
                                            <input type="text" value="{{$order->projected_units}}" readonly="" style="background-color: #ced4da" class="my-form-control ProjectedUnits" 
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
                                                <label for="ink_color_change_pieces" class="col-sm-3 font-weight-600">Ink Color Change</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="ink_color_change_pieces" value="{{$order->OrderTransfer->ink_color_change_pieces ?? ""}}" class="my-form-control " id="ink_color_change_pieces" placeholder="Pieces">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="ink_color_change_prices" value="{{$order->OrderTransfer->ink_color_change_prices ?? ""}}" class="my-form-control mr-2" id="ink_color_change_prices" placeholder="Prices">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="shipping_pieces" class="col-sm-3 font-weight-600">Shipping Charges</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="shipping_pieces" value="{{$order->OrderTransfer->shipping_pieces ?? ""}}" class="my-form-control " id="shipping_pieces" placeholder="Pieces">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="shipping_charges" value="{{$order->OrderTransfer->shipping_charges ?? ""}}" class="my-form-control mr-2" id="shipping_charges" placeholder="Prices">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="label_pieces" class="col-sm-3 font-weight-600">Inside Labels</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="label_pieces" value="{{$order->OrderOtherCharges->label_pieces ?? ""}}" class="my-form-control " id="label_pieces" placeholder="Pieces">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="label_prices" value="{{$order->OrderOtherCharges->label_prices ?? ""}}" class="my-form-control mr-2" id="label_prices" placeholder="Prices">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            
                                            <div class="form-group row">
                                                <label for="fold_pieces" class="col-sm-3 font-weight-600">Fold Only</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="fold_pieces" value="{{$order->OrderOtherCharges->fold_pieces ?? ""}}" class="my-form-control " id="fold_pieces" placeholder="Pieces">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="fold_prices" value="{{$order->OrderOtherCharges->fold_prices ?? ""}}" class="my-form-control mr-2" id="fold_prices" placeholder="Prices">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="fold_bag_pieces" class="col-sm-3 font-weight-600">Fold Bag Only</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="fold_bag_pieces" value="{{$order->OrderOtherCharges->fold_bag_pieces ?? ""}}" class="my-form-control " id="fold_bag_pieces" placeholder="Pieces">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="fold_bag_prices" value="{{$order->OrderOtherCharges->fold_bag_prices ?? ""}}" class="my-form-control mr-2" id="fold_bag_prices" placeholder="Prices">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="fold_bag_tag_pieces" class="col-sm-3 font-weight-600">FOLD/BAG/TAG</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="fold_bag_tag_pieces" value="{{$order->OrderOtherCharges->fold_bag_tag_pieces ?? ""}}" class="my-form-control " id="fold_bag_tag_pieces" placeholder="Pieces">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="fold_bag_tag_prices" value="{{$order->OrderOtherCharges->fold_bag_tag_prices ?? ""}}" class="my-form-control mr-2" id="fold_bag_tag_prices" placeholder="Prices">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="hang_tag_pieces" class="col-sm-3 font-weight-600">Hang Tag</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="hang_tag_pieces" value="{{$order->OrderOtherCharges->hang_tag_pieces ?? ""}}" class="my-form-control " id="hang_tag_pieces" placeholder="Pieces">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="hang_tag_prices" value="{{$order->OrderOtherCharges->hang_tag_prices ?? ""}}" class="my-form-control mr-2" id="hang_tag_prices" placeholder="Prices">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="fold_pieces" class="col-sm-3 font-weight-600">Foil</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="foil_pieces" value="{{$order->OrderOtherCharges->foil_pieces ?? ""}}" class="my-form-control " id="fold_pieces" placeholder="Pieces">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="foil_prices" value="{{$order->OrderOtherCharges->foil_prices ?? ""}}" class="my-form-control mr-2" id="fold_prices" placeholder="Prices">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="transfers_pieces" class="col-sm-3 font-weight-600">Transfers</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="transfers_pieces" value="{{$order->OrderTransfer->transfers_pieces ?? ""}}" class="my-form-control " id="transfers_pieces" placeholder="Pieces">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="transfers_prices" value="{{$order->OrderTransfer->transfers_prices ?? ""}}" class="my-form-control mr-2" id="transfers_prices" placeholder="Prices">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="palletizing_pieces" class="col-sm-3 font-weight-600">Palletizing</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="palletizing_pieces" value="{{$order->OrderOtherCharges->palletizing_pieces ?? ""}}" class="my-form-control " id="palletizing_pieces" placeholder="Pieces">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="palletizing_prices" value="{{$order->OrderOtherCharges->palletizing_prices ?? ""}}" class="my-form-control mr-2" id="palletizing_prices" placeholder="Prices">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group row">
                                                <label for="remove_packaging_pieces" class="col-sm-3 font-weight-600">Remove Packaging</label>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="remove_packaging_pieces" value="{{$order->OrderOtherCharges->remove_packaging_pieces ?? ""}}" class="my-form-control " id="remove_packaging_pieces" placeholder="Pieces">
                                                </div>
                                                <div class="col-sm-4">
                                                    <input type="number" min="0" name="remove_packaging_prices" value="{{$order->OrderOtherCharges->remove_packaging_prices ?? ""}}" class="my-form-control mr-2" id="remove_packaging_prices" placeholder="Prices">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade @if($active_art_room) show active @endif" id="art-room" role="tabpanel" aria-labelledby="art-room-tab">
                                <input type="hidden" id="is_art_submit" name="is_art_submit" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if (count($order->OrderArtFiles) > 0)
                                        @php
                                            $i = 1;
                                        @endphp
                                            @foreach ($order->OrderArtFiles as $OrderArtFile)
                                            <a href="{{route('admin.order.downloadArtFiles', $OrderArtFile->id)}}" class="btn btn-purple btn-circle mb-2 mr-1" style="width: 100px !important;"><i class="fas fa-download"></i> File {{$i++}}</a>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="art_btn">
                                            <p style="margin: 0px;">Add Files</p>
                                            <input type="file" class="artFile upload__inputfile" name="artFile[]" multiple="" data-max_length="20">
                                        </label>
                                    </div>
                                    <div class="col-md-9 mb-3">
                                        <label class="form-label text-dark-gray" for="">Description</label>
                                        <textarea class="form-control art-room-directions summernote" name="art_details" rows="2">
                                            @if (isset($order->OrderArtDetail) && $order->OrderArtDetail != ""){{$order->OrderArtDetail->art_detail}}@endif
                                        </textarea>
                                    </div>
                                    <div class="col-md-12 form-check mt-5">
                                        <button class="btn btn-primary mb-3" id="saveArt">Save Art Data</button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade @if($active_comp) show active @endif" id="comps" role="tabpanel" aria-labelledby="comps-tab">
                                <input type="hidden" id="is_comps_submit" name="is_comps_submit" value="">
                                @if (count($order->orderCompFiles) > 0)
                                <div class="row">
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($order->orderCompFiles as $orderCompFile)
                                    <div class="col-md-6">
                                        <a href="{{route('admin.order.downloadCompFiles', $orderCompFile->id)}}" class="btn btn-purple btn-circle mb-2 mr-1" style="width: 150px !important;"><i class="fas fa-download"></i> Comp {{$i++}}</a>
                                    </div>
                                    <div class="col-md-2 float-right">
                                        @php
                                            $cls            = "light";
                                            $com_approved   = ($orderCompFile->is_approved != "") ? $orderCompFile->is_approved:"";
                                            if($com_approved != "" && $com_approved == "Changes Needed"){
                                                $cls        = "light";
                                            }elseif($com_approved != "" && $com_approved == "Approved"){
                                                $cls        = "sucess-custom";
                                            }elseif($com_approved != "" && $com_approved == "Approved No Films"){
                                                $cls        = "info";
                                            }elseif($com_approved != "" && $com_approved == "Films Done"){
                                                $cls        = "black";
                                            }elseif($com_approved != "" && $com_approved == "Comp Sent"){
                                                $cls        = "violet";
                                            }elseif($com_approved != "" && $com_approved == "Need Approval"){
                                                $cls        = "warning";
                                            }elseif($com_approved != "" && $com_approved == "Reorder"){
                                                $cls        = "pink";
                                            }elseif($com_approved != "" && $com_approved == "In Art Room"){
                                                $cls        = "light";
                                            }
                                        @endphp
                                        <div class="btn-group mb-2 mr-1  --status-div">
                                            <button type="button" class="btn btn-{{$cls}} --new-value dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="white-space: nowrap;width:125px;">{{$orderCompFile->is_approved ?? "--select--"}}</button>
                                            <div class="dropdown-menu" x-placement="top-start" style="position: absolute; transform: translate3d(0px, -152px, 0px); top: 0px; left: 0px; will-change: transform;">
                                               <a class="dropdown-item --comp-action" href="#" data-id="{{$orderCompFile->id}}" data-order-id="{{$order->id}}" data-value="Changes Needed" data-prev-class="{{$cls}}" data-new-class="light">Changes Needed</a>
                                               <a class="dropdown-item --comp-action" href="#" data-id="{{$orderCompFile->id}}" data-order-id="{{$order->id}}" data-value="Approved" data-prev-class="{{$cls}}" data-new-class="sucess-custom">Approved</a>
                                               <a class="dropdown-item --comp-action" href="#" data-id="{{$orderCompFile->id}}" data-order-id="{{$order->id}}" data-value="Approved No Films" data-prev-class="{{$cls}}" data-new-class="info">Approved No Films</a>
                                               <a class="dropdown-item --comp-action" href="#" data-id="{{$orderCompFile->id}}" data-order-id="{{$order->id}}" data-value="Films Done" data-prev-class="{{$cls}}" data-new-class="black">Films Done</a>
                                               <a class="dropdown-item --comp-action" href="#" data-id="{{$orderCompFile->id}}" data-order-id="{{$order->id}}" data-value="Comp Sent" data-prev-class="{{$cls}}" data-new-class="violet">Comp Sent</a>
                                               <a class="dropdown-item --comp-action" href="#" data-id="{{$orderCompFile->id}}" data-order-id="{{$order->id}}" data-value="Need Approval" data-prev-class="{{$cls}}" data-new-class="warning">Need Approval</a>
                                               <a class="dropdown-item --comp-action" href="#" data-id="{{$orderCompFile->id}}" data-order-id="{{$order->id}}" data-value="Reorder" data-prev-class="{{$cls}}" data-new-class="pink">Reorder</a>
                                               <a class="dropdown-item --comp-action" href="#" data-id="{{$orderCompFile->id}}" data-order-id="{{$order->id}}" data-value="In Art Room" data-prev-class="{{$cls}}" data-new-class="light">In Art Room</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 float-right">
                                        <a class="btn btn-md btn-warning mb-3 send-email-modal" href="#" data-client_id="{{ $order->client_id }}" data-id="{{ $order->id }}" data-email="{{ $order->ClientSaleRep->email ?? '' }}"  data-sale_rep_name="{{$order->ClientSaleRep->first_name ?? ''}} {{ $order->ClientSaleRep->last_name ?? '' }}" data-company_name="{{ $order->client->company_name ?? '' }}" data-job_name="{{ $order->job_name ?? '' }}" data-order_number="{{ $order->order_number ?? '' }}" data-comp-id="{{$orderCompFile->id}}"><i class="hvr-buzz-out far fa-envelope"></i> Send Email</a>
                                    </div>
                                    @endforeach
                                </div>
                                @endif
                                @if (count($order->orderCompFiles) > 0)
                                    <div class="row">
                                        @php
                                            $i = 1;
                                        @endphp
                                        @foreach ($order->OrderCompDetail as $comp)
                                        <div class="col-md-12">
                                            <h6 class="fs-14 font-weight-600 mb-0">Comment Added By- {{$comp->added_by_role}}</h6>
                                            {!! $comp->comp_detail !!} 
                                        </div>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="art_btn">
                                            <p style="margin: 0px;">Add Comp File</p>
                                            <input type="file" class="compFile upload__inputfile" name="compFile" data-max_length="20">
                                        </label>
                                    </div>
                                    <div class="col-md-9 mb-3">
                                        <label class="form-label text-dark-gray" for="">Comp Description</label>
                                        <textarea class="form-control art-room-directions summernote" name="comp_details" rows="2"></textarea>
                                    </div>
                                    <div class="col-md-12 form-check mt-5">
                                        <button class="btn btn-primary mb-3" id="saveComp">Save Comp</button>
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
    <div class="email-popup no-print">

    </div>
    @endsection
    @section('footer-script')
    <script>
    $(document).ready(function(){
        $('#sales_rep').SumoSelect({
			search: true
		});
        $('.summernote').summernote({
            height: 100, // set editor height
            minHeight: null, // set minimum height of editor
            maxHeight: null, // set maximum height of editor
            focus: true                  // set focus to editable area after initializing summernote
        });
        var _order_id       = '{{$order->id}}';
        $('#product_ids').on('select2:unselect', function (e) {
            var p_id        = ".product-detail-"+e.params.data.id;
            $(p_id).remove();
        });
        
        let order_product_ids       = JSON.parse($("#order_product_ids").html());

        $.each(order_product_ids, function(i, arr){
            $.each(arr, function(index, product_id){
                console.log("product_id:", product_id);
                var selector_number     = product_id+'-'+index;
                accordian_products(product_id, _order_id,selector_number);
                accordian2_products(product_id, _order_id, selector_number);
            });
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
                        $('#sales_rep')[0].sumo.reload();
                    },
                    beforeSend: function() {
                        $('.page-loader-wrapper').show();
                    },
                    complete: function(){
                        $('.page-loader-wrapper').hide();
                    }
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
                },
                beforeSend: function() {
                    $('.page-loader-wrapper').show();
                },
                complete: function(){
                    $('.page-loader-wrapper').hide();
                }
            });

        });
        function accordian_products(product_id="", order_id, selector_number){
            if(product_id != ""){
                $.ajax({
                    url: "{{ route('admin.order.product') }}",
                    type: "GET",
                    data: {
                        product_id          : product_id,
                        order_id            : order_id,
                        selector_number     : selector_number
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
        function accordian2_products(product_id="", order_id="",selector_number=""){

            if(product_id != ""){
                $.ajax({
                    url: "{{ route('admin.order.print_nd_loations') }}",
                    type: "GET",
                    data: {
                        product_id      : product_id,
                        order_id        : order_id,
                        selector_number : selector_number
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
            var elm             = e.params.data.element;
            var selector_number = $(elm).attr('data-custom-selector');
            accordian_products(product_id, "", selector_number);
            accordian2_products(product_id, "", selector_number);
        });
        var init                     = 1;
        $(document).on('click', '.add_product', function(event) {
            $('#preloader').show();
          
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
            let sizecurrentIndex        = $(this).closest("#cloneDev").find(".row:last").find('.v2_attr_id').find("option:selected").index();
            let colorcurrentIndex       = $(this).closest("#cloneDev").find(".row:last").find('.v1_attr_id').find("option:selected").index();
            let sizeLength              = $(this).closest("#cloneDev").find(".row:last").find('.v2_attr_id').find("option").length;
            let colorLength             = $(this).closest("#cloneDev").find(".row:last").find('.v1_attr_id').find("option").length;
            if(sizecurrentIndex == sizeLength-2){
                let newSize             = new_product_add.find('.v2_attr_id').find("option:eq(" + (1) + ")").attr("value");
                new_product_add.find('.v2_attr_id').val(newSize);
                let newColor             = new_product_add.find('.v1_attr_id').find("option:eq(" + (colorcurrentIndex + 1) + ")").attr("value");
                new_product_add.find('.v1_attr_id').val(newColor);
            }else if(colorcurrentIndex < colorLength){
                let newSize             = new_product_add.find('.v2_attr_id').find("option:eq(" + (sizecurrentIndex + 1) + ")").attr("value");
                new_product_add.find('.v2_attr_id').val(newSize);
                let newColor             = new_product_add.find('.v1_attr_id').find("option:eq(" + (colorcurrentIndex) + ")").attr("value");
                new_product_add.find('.v1_attr_id').val(newColor);
                console.log("sizecurrentIndex: ", sizecurrentIndex);
                console.log("sizeLength - 1: ", sizeLength-1);
            }else{
                // do nothing
            }
            append_parent.append(new_product_add);
            append_parent.append(new_product_add);
            var product_id              = new_product_add.find('.v2_attr_id').attr('data-product_id');
            var selector_number         = new_product_add.find('.v2_attr_id').attr('data-selector');
            var selector                = '.form-row';
            let v1_attr_id              = new_product_add.find('.v1_attr_id').val();
            let v2_attr_id              = new_product_add.find('.v2_attr_id').val();
            let price_selector          = new_product_add.find('.price');
            addProductChildRow(product_id, selector_number, v1_attr_id, v2_attr_id, price_selector, selector);
            init++;
        });
        $(document).on('click', '#remove_product', function(e) {
            e.preventDefault();
            var  product_id     = $(this).data('product_id');
            let initializer     = $('#product-detail-'+product_id).find('.add_product').length;
            console.log(initializer);
            if(initializer>1){
                $(this).closest('.row').remove();
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
            $(".ProjectedUnits").val(projected_units);
            $(".ProjectedUnits").trigger("change");

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
            $(".ProjectedUnits").trigger("change");
        }
        
    });

    $(document).on("change", ".attribute", function(e){
        e.preventDefault();
        var product_id              = $(this).attr('data-product_id');
        var selector_number         = $(this).attr('data-selector');
        var selector                = '.form-row';
        let v1_attr_id              = $(this).closest(selector).find('.v1_attr_id').val();
        let v2_attr_id_arr          = [];

        $($(this).closest(selector).find('.v2_attr_id')).each(function(i, e){
            if($(this).val() != ""){

                v2_attr_id_arr.push($(this).attr('data-attr-id'));
            }
        });

        let price_selector          = '';
        let v2_attr_id              = 0;
        if($(this).hasClass('v2_attr_id')){
            v2_attr_id              = $(this).attr('data-attr-id');
            price_selector          = $(this).closest('.row').find('.price-'+v2_attr_id);
            $(this).prev().val(v2_attr_id);
            addProductChildRow(product_id, selector_number, v1_attr_id, v2_attr_id, price_selector, selector);
            
        }else if($(this).hasClass('v1_attr_id')){
            $.each(v2_attr_id_arr, function(index, v2_attr_id){

                price_selector          = $(this).closest('.row').find('.price-'+v2_attr_id);
                addProductChildRow(product_id, selector_number, v1_attr_id, v2_attr_id, price_selector, selector);
            });
        }
    });
    function addProductChildRow(product_id, selector_number, v1_attr_id, v2_attr_id, price_selector, selector){
        let size_selector           = "";
        let size_select             = "";
        let all_adult_sizes         = JSON.parse($("#all_adult_sizes").html());
        let adult_fixed_sizes       = JSON.parse($('template').html());
        let fixed_baby_sizes        = JSON.parse($("#fixed_baby_sizes").html());
        let all_baby_sizes          = JSON.parse($('#all_baby_sizes').html());
        let all_sizes               = [];
        let fixed_sizes             = [];
        
        var collapse_box_selector   = ".slector-number-"+product_id+"-"+selector_number;
        if($(collapse_box_selector).find(".product-type").val() == "Baby Size"){
            all_sizes                   = all_baby_sizes;
            fixed_sizes                 = fixed_baby_sizes;
            size_select                 = "OSFA-18M-";
        }else{
            all_sizes                   = all_adult_sizes;
            fixed_sizes                 = adult_fixed_sizes;
            size_select                 = "XS-XL-";
        }
        let type                    = "";
        if($(collapse_box_selector).find(".product-type").val() == "Baby Size"){
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
               
                    $(collapse_box_selector).find(size_selector).val(result.price);
                    resetPrices(product_id, collapse_box_selector);
                    calcTotal(product_id, collapse_box_selector);
                    calcMargin(product_id, collapse_box_selector);
                },
                beforeSend: function() {
                    $('.page-loader-wrapper').show();
                },
                complete: function(){
                    $('.page-loader-wrapper').hide();
                }
            });
        }
    }
    function calcDecogrationPrice(product_id=0, collapse_box_selector = ""){
        var ProjectedUnits          = $('#ProjectedUnits').val();
        var color_locations_arr     = [];
        var product_div             = collapse_box_selector;
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
                calcTotal(product_id, collapse_box_selector);
                calcMargin(product_id, collapse_box_selector);
            },
            beforeSend: function() {
                $('.page-loader-wrapper').show();
            },
            complete: function(){
                $('.page-loader-wrapper').hide();
            }
        });
        } 
    }
    $(document).on("change", ".number-of-colors", function(){
        var product_id              = $(this).attr('data-product-id');
        let selector_number         = $(this).attr('data-selector');

        var collapse_box_selector   = ".slector-number-"+product_id+"-"+selector_number;
        calcDecogrationPrice(product_id, collapse_box_selector);
    });

    function calcTotal(product_id=0, collapse_box_selector=""){

        let whole_sale_price            = 0;
        let location_price              = 0;
        let total_price                 = 0;
        for(var i=1; i <=6; i++){
            
            let whole_sale_price         =  $(collapse_box_selector).find(".whole-sale-"+i).val();
            let location_price           =  $(collapse_box_selector).find(".location-"+i).val();

            whole_sale_price            = (whole_sale_price != "") ? whole_sale_price: 0;
            location_price              = (location_price != "")? location_price: 0;
            let total                   = (parseFloat(whole_sale_price)+ parseFloat(location_price)).toFixed(2);
            $($(collapse_box_selector).find(".total-"+i)).val(total);
        }
    } 
    function resetPrices(product_id = 0, collapse_box_selector = ""){
        let size_selector               = "";
        let all_adult_sizes             = JSON.parse($("#all_adult_sizes").html());
        let adult_fixed_sizes           = JSON.parse($('template').html());
        let fixed_baby_sizes            = JSON.parse($("#fixed_baby_sizes").html());
        let all_baby_sizes              = JSON.parse($('#all_baby_sizes').html());
        let all_sizes                   = [];
        let fixed_sizes                 = [];
        let selected_sizes              = [];
        let flag                        = 0;
        let selector                    = $(collapse_box_selector).find('.v2_attr_id');
        if($(collapse_box_selector).find(".product-type").val() == "Baby Size"){
            all_sizes                   = all_baby_sizes;
            fixed_sizes                 = fixed_baby_sizes;
            size_selector               = "#OSFA-18M-";
        }else{
            all_sizes                   = all_adult_sizes;
            fixed_sizes                 = adult_fixed_sizes;
            size_selector               = "#S-XL-";
        }
        $(selector).each(function(indx, elm){;
            selected_sizes.push($(this).attr('placeholder'));
        });
        
        $.each(fixed_sizes, function(index, element){
            if(jQuery.inArray(element, selected_sizes) != -1) {
                flag                    = 1;
            }
        });
        if(flag == 0){
            $(collapse_box_selector).find(size_selector+product_id).val('');
        }
        $.each(all_sizes, function(index, element){
            if(jQuery.inArray(element, selected_sizes) != -1) {
                //do nothing
            }else{
                $(collapse_box_selector).find("#"+element+"-"+product_id).val('');
            }
        });
    } 

    $(document).on("change", ".profit-margin", function(){
        let product_id              = $(this).attr('data-product-id');
        let selector_number         = $(this).attr('data-selector');

        var collapse_box_selector   = ".slector-number-"+product_id+"-"+selector_number;
        calcMargin(product_id, collapse_box_selector);
    });

    function calcMargin(product_id= 0, collapse_box_selector=""){

        let profit_margin               = $(collapse_box_selector).find('.profit-margin').val();
        let total_selector              = ".total-";
        let profit_margin_selector      = ".margin-";
        let final_price_selector        = ".final-price-";
        if(profit_margin > 0){
            var diff = 100 - parseInt(profit_margin); 
            var diff2= diff / 100 ;
            
            for(var i=1; i <=6; i++){

                let total           = $(collapse_box_selector).find(total_selector+i).val();
                let value           =  total / diff2; 
                $(collapse_box_selector).find(profit_margin_selector+i).val(value.toFixed(2));   
                $(collapse_box_selector).find(final_price_selector+i).val(value.toFixed(2));   
            }
        }
    }

    $(document).on("change",".ProjectedUnits", function(){
        let product_ids             = $("#product_ids").val();
        let selector_number         = 0;
        var collapse_box_selector   = "";
        $.each(product_ids, function(index, product_id){
            
            let all_collapse_boxes   = ".product-detail-"+product_id;
            $(all_collapse_boxes).each(function(index, element){
                selector_number         = $(this).find(".profit-margin").attr("data-selector");
                if(selector_number != undefined){
                    collapse_box_selector   = ".slector-number-"+product_id+"-"+selector_number;
                    resetPrices(product_id, collapse_box_selector);
                    calcDecogrationPrice(product_id, collapse_box_selector);
                    calcTotal(product_id, collapse_box_selector);
                    calcMargin(product_id, collapse_box_selector);
                }
            });
        });

    });
    function ImgUpload() {
          var imgWrap = "";
          var imgArray = [];

          $('.upload__inputfile').each(function () {
            $(this).on('change', function (e) {
              imgWrap = $(this).closest('.upload__box').find('.upload__img-wrap');
              var maxLength = $(this).attr('data-max_length');

              var files = e.target.files;
              var filesArr = Array.prototype.slice.call(files);
              var iterator = 0;
              filesArr.forEach(function (f, index) {

                if (!f.type.match('image.*')) {
                  return;
                }

                if (imgArray.length > maxLength) {
                  return false
                } else {
                  var len = 0;
                  for (var i = 0; i < imgArray.length; i++) {
                    if (imgArray[i] !== undefined) {
                      len++;
                    }
                  }
                  if (len > maxLength) {
                    return false;
                  } else {
                    imgArray.push(f);

                    var reader = new FileReader();
                    reader.onload = function (e) {
                      var html = "<div class='upload__img-box'><div style='background-image: url(" + e.target.result + ")' data-number='" + $(".upload__img-close").length + "' data-file='" + f.name + "' class='img-bg'><div class='upload__img-close' data-order-id='' data-img-id=''></div></div></div>";
                      imgWrap.append(html);
                      iterator++;
                    }
                    reader.readAsDataURL(f);
                  }
                }
              });
            });
          });

          $(document).on('click', ".upload__img-close", function (e) {
            var file = $(this).parent().data("file");
            for (var i = 0; i < imgArray.length; i++) {
              if (imgArray[i].name === file) {
                imgArray.splice(i, 1);
                break;
              }
            }
            $(this).parent().parent().remove();

            var order_id        = $(this).attr('data-order-id');
            var img_id          = $(this).attr('data-img-id');
            
            if(order_id != "" && img_id != ""){

              if(confirm("Are you sure?")){
                $.ajax({
                    url: "{{ route('admin.order.delete-image') }}",
                    type: "GET",
                    data: {
                        order_id: order_id,
                        img_id: img_id
                    },
                    success: function(data) {
                        console.log(data);
                    },
                    beforeSend: function() {
                        $('.page-loader-wrapper').show();
                    },
                    complete: function(){
                        $('.page-loader-wrapper').hide();
                    }
                })
              }
              
            }
          });
        }  
        ImgUpload();  
        function _update_field_name(field_name, selector){
            let removed_element     = field_name.split('[')[0];
            var array = field_name.split(/\[|\]/).filter(function(item) {
                return item !== "" && item != removed_element;
            });
            array[1] = selector;
            var modifiedString = field_name.split('[')[0] + "[" + array.join("][") + "][]";  
            return   modifiedString;
        }
        $(document).on('click', '.--add-product', function(event) {

            var product_id                      = $(this).attr("data-id");
            var terminator                      = $(this).attr("data-selector");
            var selector                        = "";
            var total_boxes                     = $(".--product-row").length;
            let initial_selector                = 0;
            $(".--product-row").each(function(index, item){
                
                selector                     = parseInt($(this).find(".--add-product").attr("data-selector"));
                if(initial_selector < selector){
                    initial_selector        = selector;
                }
                
            });
            selector    = parseInt(initial_selector)+1;
            var prev_selector_number            = "slector-number-"+product_id+"-"+terminator;
            var new_selector_number             = "slector-number-"+product_id+"-"+selector;

            // Garments Tab Product Clonning 
            var product_template                = $(this).closest('.--product-row').clone();
            var parent_selector                 = $(this).closest(".container-fluid");
            var new_product_template            = product_template.clone();
            event.preventDefault();
            parent_selector.append(new_product_template);
            // Changing Selector
            new_product_template.find('.--add-product').attr('data-selector', selector);
            new_product_template.find('.--remove-product').attr('data-selector', selector);
            new_product_template.find("."+prev_selector_number).addClass(new_selector_number);
            new_product_template.find("."+prev_selector_number).removeClass(prev_selector_number);
            let field_name_seletor      = ".--update-name";
            $.each(new_product_template.find(field_name_seletor), function(index, element){
                let field_name          = $(this).attr("name");
                let updated_name        = _update_field_name(field_name, selector);
                new_product_template.find(element).attr("name", updated_name);
            });
            // 
            var collapse_href                   = "#collapse-"+product_id+"-"+selector;
            var collapse_id                     = "collapse-"+product_id+"-"+selector;
            new_product_template.find('.collapse-href').attr('href', collapse_href);
            new_product_template.find('.collapse-id').attr('id', collapse_id);
            new_product_template.find('.attribute').attr('data-selector', selector);

            // Print Details tab print and locations clonning
            var prev_selector                           = "--print-and-location-row-"+product_id+"-"+terminator;
            var new_selector                            = "--print-and-location-row-"+product_id+"-"+selector;
            var print_and_location_template             = $("#accordion2").find('.--print-and-location-row-'+product_id+"-"+terminator).clone();
            var parent_selector                         = $("#accordion2").find('.--print-and-location-row-'+product_id+"-"+terminator).closest(".container-fluid");
            var new_print_and_location_template         = print_and_location_template.clone();
            event.preventDefault();
            parent_selector.append(new_print_and_location_template);
            // Changing Selector
            new_print_and_location_template.addClass(new_selector);
            new_print_and_location_template.removeClass(prev_selector);
            new_print_and_location_template.find("."+prev_selector_number).addClass(new_selector_number);
            new_print_and_location_template.find("."+prev_selector_number).removeClass(prev_selector_number);
            // 
            new_print_and_location_template.find('.collapse-href').attr('href', collapse_href);
            new_print_and_location_template.find('.collapse-id').attr('id', collapse_id);
            new_print_and_location_template.find('.profit-margin').attr('data-selector', selector);
            new_print_and_location_template.find('.number-of-colors').attr('data-selector', selector);
            let int=1;
            $.each(new_print_and_location_template.find(field_name_seletor), function(index, element){
                let field_name          = $(this).attr("name"); 
                let updated_name        = _update_field_name(field_name, selector);
                new_print_and_location_template.find(element).attr("name", updated_name);
            });
            projected_units();
        });
        $(document).on('click', '.--remove-product', function(event) {
            let min                             = 1;
            var product_template                = $(this).closest('.--product-row');
            var total                           = $(this).closest(".accordion").find(".--product-row").length;
            console.log(total);
            event.preventDefault();
            if(total > 1){
                product_template.remove();
                let product_id                      = $(this).attr('data-id');
                let selector                        = $(this).attr('data-selector');
                $("#accordion2").find('.--print-and-location-row-'+product_id+"-"+selector).remove();
                projected_units();
            }
        });
        $(document).on("click", "#saveArt", function(event){
            event.preventDefault();
            $("#is_art_submit").val('1');
            $('form').submit();
        });
        $(document).on("click", "#saveComp", function(event){
            event.preventDefault();
            $("#is_comps_submit").val('1');
            $('form').submit();
        });
        $(document).on('click', ".--comp-action", function (e) {
            e.preventDefault();
            var id          = $(this).attr('data-id');
            var order_id    = $(this).attr('data-order-id');
            var approve     = $(this).attr('data-value');
            var prev_cls    = "btn-"+$(this).attr('data-prev-class');
            var new_cls     = "btn-"+$(this).attr('data-new-class');
            $(this).closest('.--status-div').find('.dynamic-btn').removeClass(prev_cls);
            $(this).closest('.--status-div').find('.dynamic-btn').addClass(new_cls);
            $(this).closest('.--status-div').find('.--new-value').text(approve);
            if(id != ""){
                $.ajax({
                    url: "{{ route('admin.order.approveComp') }}",
                    type: "GET",
                    data: {
                        id: id,
                        order_id: order_id,
                        approve: approve
                    },
                    success: function(data) {
                        data = JSON.parse(data);
                        if(data.status){
                           
                        }
                    },
                    beforeSend: function() {
                        $('.page-loader-wrapper').show();
                    },
                    complete: function(){
                        $('.page-loader-wrapper').hide();
                    }
                    })
            }
        });
        $(document).on('click', '.send-email-modal', function(e){
            e.preventDefault();
            $('.email-popup').empty();
            var comp_id 		  	= $(this).attr('data-comp-id');
            var order_id 		  	= $(this).attr('data-id');
            var client_id 		  	= $(this).attr('data-client_id');
            var email 		  		= $(this).attr('data-email');
            var sale_rep_name 		= $(this).attr('data-sale_rep_name');
            var company_name 		= $(this).attr('data-company_name');
            var job_name 			= $(this).attr('data-job_name');
            var order_number 		= $(this).attr('data-order_number');
            
            $.ajax({
                url: '{{ route("admin.email-template.email_popup") }}',
                type: "GET",
                data: {
                    comp_id: comp_id,
                    order_id: order_id,
                    client_id: client_id,
                    sale_rep_name: sale_rep_name,
                    company_name: company_name,
                    job_name: job_name,
                    order_number: order_number,
                    email: email
                },
                success: function(data) {
                    $('.email-popup').html(data);
                    "use strict"; // Start of use strict
                    //summernote
                    $('#summernote').summernote({
                        height: 200, // set editor height
                        minHeight: null, // set minimum height of editor
                        maxHeight: null, // set maximum height of editor
                        focus: true                  // set focus to editable area after initializing summernote
                    });
                    
                    $('#send-email-modal').show();
                }
            });
        });
        $(document).on('change', '.template', function(e){
            e.preventDefault();
            $('.email-popup').empty();
            var comp_id 		  	= $(this).closest("#sendEmail").find("#comp_id").val();
            var order_id 		  	= $(this).closest("#sendEmail").find("#order_number").val();
            var client_id 		  	= $(this).closest("#sendEmail").find("#clientId").val();
            var email 		  		= $(this).closest("#sendEmail").find("#clientEmail").val();
            var sale_rep_name 		= $(this).closest("#sendEmail").find("#saleRepName").val();
            var company_name 		= $(this).closest("#sendEmail").find("#compantName").val();
            var job_name 			= $(this).closest("#sendEmail").find("#jobName").val();
            var order_number 		= $(this).closest("#sendEmail").find("#orderNumber").val();
            var template_id 		= $(this).val();
            $.ajax({
                url: '{{ route("admin.email-template.email_popup") }}',
                type: "GET",
                data: {
                    comp_id: comp_id,
                    order_id: order_id,
                    client_id: client_id,
                    sale_rep_name: sale_rep_name,
                    company_name: company_name,
                    template_id: template_id,
                    job_name: job_name,
                    order_number: order_number,
                    email: email
                },
                success: function(data) {
                    $('.email-popup').html(data);
                    "use strict"; // Start of use strict
                    //summernote
                    $('#summernote').summernote({
                        height: 200, // set editor height
                        minHeight: null, // set minimum height of editor
                        maxHeight: null, // set maximum height of editor
                        focus: true                  // set focus to editable area after initializing summernote
                    });
                    $('.copy-to-clipboard').hide();
                    $('#send-email-modal').show();
                }
            });
        });
        $(document).on('click', '.close-modal', function(e){
            $(this).closest('.modal').hide();
        });
        $(document).ready(function (e) {
            $(document).on('click', '.copy-to-clipboard', function(e){
                e.preventDefault();
                var link = $(this).attr('data-link');
                var temp = $("<input>");
                $("body").append(temp);
                temp.val(link).select();
                document.execCommand("copy");
                temp.remove();
            });
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on("click", "#--sendEmail", function(e) {
                e.preventDefault();
                var form 		= $("form#sendEmail");
                var formData = new FormData(form[0]);
                formData.append("send_comp_attachment", true);
                console.log(formData);
                $.ajax({
                    url: "{{ route('admin.sendEmail')}}",
                    type:'POST',
                    data: formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success: (data) => {
                        $('#send-email-modal').modal('hide');
                        $('#sendEmail').trigger('reset');
                        console.log(data);
                        $.confirm({
                            title : "Alert",
                            content:function(){
                                return data;
                            },
                            buttons:{
                                ok:{
                                    text:"Ok",
                                    btnClass:"btn btn-success confirmed"
                                }
                            }
                        });
                    },
                    beforeSend: function() {
                        $('.page-loader-wrapper').show();
                    },
                    complete: function(){
                        $('.page-loader-wrapper').hide();
                        $('.Order-form').show();
                    },
                    error: function(data){
                        console.log(data);
                    }
                });
            });
        });
</script>
@endsection