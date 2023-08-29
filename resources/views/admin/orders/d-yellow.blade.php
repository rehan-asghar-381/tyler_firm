@extends("admin.template", ["pageTitle"=>$pageTitle])
<style type="text/css">

.form-control {
    height:calc(1.8em + 0.25rem + 0px) !important;
    font-size:14px !important;
    padding:0 0.75rem !important;
    font-weight: 700 !important;
    color: #000000 !important;
}
textarea {
  width: auto !important; 
}
.img-rounded{
    object-fit:fill;
}
table td, table th{
    padding:2px 10px !important;
    font-size: 14px !important;
    font-weight: 700 !important;
    color: #000000 !important;
}
table>thead>tr>th{
   padding:2px 10px !important;
}
.imagess {
    display: flex;
    flex-wrap: wrap;
    margin: 0 30px;
    padding: 20px;
}

.photo {
    max-width: 31.333%;
    padding: 0 10px;
    height: 200px;
}

.photo img {
    width: 100%;
    height: 100%;
}
label{
    margin-bottom:none !important;
}
.productionSample{
    margin-left: 9%;
}
</style>
<style media="print">
@page {
    size: auto ;
    margin: 0 ;
}
@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
    #DivIdToPrint{
        margin-top: -60px !important;
    }
    .row{
        margin: 0px !important;
        padding: 0px !important;
    }
    select {
      -webkit-appearance: none !important;
      -moz-appearance: none !important;
      text-indent: 1px !important;
      text-overflow: '' !important;
  }
  .form-control{
    /*border: 1px solid #fff !important;*/
}

input  select{
  all: unset;
}
#toTop{
 display: none !important; 
}
textarea {
  resize: none !important;
}
.productionSample{
    margin-left: 6% !important;
}
}

</style>

@section('content')
<div class="body-content">
    <div class="card">
        <div class="card-body">
            <div id='DivIdToPrint'>

                <form  method="POST"  action="{{ route('admin.order.storeDYellow') }}" enctype="multipart/form-data" novalidate>
                    <input type="hidden" name="order_id" value="{{$order->id}}">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            @if(Session::has('success'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('success') }}
                            </div>
                            @endif
                            <h6 class="font-weight-600 text-center" style="background: #d3d3d3;">{{$order->created_by_name}}</h6>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="form-row">
                                        <div class="col-md-3 mb-3">
                                            <label for="print_crew" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">PRINT CREW</label>
                                            <input type="text" name="print_crew" class="form-control input-sm" id="print_crew" readonly="" value="{{$order_d_yellow->print_crew ?? ""}}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="goods_rec" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">Goods REC'D</label>
                                            <input type="text" name="goods_rec" readonly="" class="form-control input-sm" id="goods_rec" value="{{$order_d_yellow->goods_rec ?? ""}}">
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="order_date" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">ORDER DATE</label>
                                            <input type="text" name="order_date" class="form-control input-sm" id="order_date" value="{{date("m/d/Y", $order->time_id)}}" disabled>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <label for="boxes" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">TOTAL # OF BOXES</label>
                                            <input type="text" readonly="" name="boxes" class="form-control input-sm" id="boxes" value="{{$order_d_yellow->boxes ?? ""}}">
                                        </div>
                                        <div class="col-md-4  mt-4">
                                            <label for="production_sample" style="font-size: 13px;font-weight: bold; margin-bottom:unset;width: 100%">PRODUCTION SAMPLE 
                                                <span  class="productionSample" >Yes</span>
                                                <span class="productionSample">No</span>
                                                {{-- <span class="productionSample">1</span> --}}
                                                {{-- <span class="productionSample">2</span> --}}
                                                {{-- <span class="productionSample" >3</span></label> --}}
                                                <input type="hidden" name="production_sample" id="production_sample" value="">
                                            {{-- <select name="production_sample" id="production_sample" class="form-control input-sm">
                                                <option value="">Select</option>
                                                <option value="Yes" @if(isset($order_d_yellow->production_sample) && $order_d_yellow->production_sample == "Yes") {{"selected"}} @endif>Yes</option>
                                                <option value="No" @if(isset($order_d_yellow->production_sample) && $order_d_yellow->production_sample == "No") {{"selected"}} @endif>No</option>
                                                <option value="1" @if(isset($order_d_yellow->production_sample) && $order_d_yellow->production_sample == "1") {{"selected"}} @endif>1</option>
                                                <option value="2" @if(isset($order_d_yellow->production_sample) && $order_d_yellow->production_sample == "2") {{"selected"}} @endif>2</option>
                                                <option value="3" @if(isset($order_d_yellow->production_sample) && $order_d_yellow->production_sample == "3") {{"selected"}} @endif>3</option>
                                            </select> --}}
                                        </div>
                                        <div class="col-md-5 mt-4">
                                            <label for="production_sample" style="font-size: 13px;font-weight: bold; margin-bottom:unset;width: 100%">BURN PLACEMENT
                                                <span  class="productionSample">1</span>
                                                <span class="productionSample">2</span>
                                                <span class="productionSample">3</span>
                                                <span class="productionSample">4</span>
                                                <span class="productionSample">5</span>
                                                {{-- <span class="productionSample">1</span> --}}
                                                {{-- <span class="productionSample">2</span> --}}
                                                {{-- <span class="productionSample" >3</span> --}}
                                            </label>
                                                <input type="hidden" name="production_sample" id="production_sample" value="">

                                            </div>
                                            <div class="col-md-2 mt-4 mb-1">
                                                <label for="event" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">EVENT
                                                    {{-- <span style="margin-left: 30%;">Yes</span> --}}
                                                    {{-- <span style="margin-left: 30%;">No</span> --}}
                                                </label>
                                                {{-- <input type="hidden" name="event" id="event" value=""> --}}

                                                <select name="event" id="event" class="form-control input-sm" style="margin-left: 65px;margin-top: -22px;" disabled>
                                                    <option value="">Select</option>
                                                    <option value="Yes" @if($order->event == "Yes") {{"selected"}} @endif>Yes</option>
                                                    <option value="No" @if($order->event == "No") {{"selected"}} @endif>No</option>
                                                </select >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-row">
                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col" colspan="2">Ship To</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        {{-- <tr>
                                                            <th scope="row">Name</th>
                                                            <td>{{$client_details["company_name"]}}</td>
                                                        </tr>
                                                        <tr>
                                                            <th scope="row">Company</th>
                                                            <td>{{$client_details["company_name"]}}</td>
                                                        </tr> --}}
                                                        <tr>
                                                            {{-- <th scope="row">Address</th> --}}
                                                            <td colspan="2" rowspan="3">{{$order->shipping_address ?? ""}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h6 class="font-weight-600 text-center" style="background: #d3d3d3;">Customer</h6>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="col-md-2 mb-3">
                                                <label for="company_name" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">CUSTOMER</label>
                                                <input type="text" name="company_name" class="form-control input-sm" id="company_name" value="{{$client_details["company_name"]}}" disabled>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="design" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">Job Name</label>
                                                <input type="text" name="design" class="form-control" id="design" value="{{$order->job_name ?? ""}}" disabled>
                                                
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="order_number" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">P.O #</label>
                                                <input type="text" name="order_number" class="form-control" id="order_number" value="{{$order->order_number}}" disabled>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="other_info" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">Sales Rep</label>
                                                <input type="text" name="other_info" class="form-control" id="other_info" value="{{$client_details["sales_rep"]}}" disabled>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="palletize" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">PALLETIZE</label>
                                                <select name="palletize_opt" id="palletize_opt" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="Yes" @if(isset($order_d_yellow->palletize_opt) && $order_d_yellow->palletize_opt == "Yes") {{"selected"}} @endif>Yes</option>
                                                    <option value="No" @if(isset($order_d_yellow->palletize_opt) && $order_d_yellow->palletize_opt == "No") {{"selected"}} @endif>No</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="in_hands" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">Due Date</label>
                                                <input type="text" name="in_hands" class="form-control" id="in_hands" value="@if($order->due_date>0){{date("m-d-Y", $order->due_date)}} @endif" disabled>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="ship_date" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">SHIP DATE</label>
                                                <input type="text" name="ship_date" class="form-control" id="ship_date" value="@if($order->ship_date>0){{date("m-d-Y", $order->ship_date)}}@endif" disabled>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="ship" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">SHIP</label>
                                                <select name="ship" id="ship" class="form-control">
                                                    <option value="">Select</option>
                                                    <option value="WC" @if(isset($order_d_yellow->ship) && $order_d_yellow->ship == "WC") {{"selected"}} @endif>WC</option>
                                                    <option value="OT" @if(isset($order_d_yellow->ship) && $order_d_yellow->ship == "OT") {{"selected"}} @endif>OT</option>
                                                    <option value="GRND" @if(isset($order_d_yellow->ship) && $order_d_yellow->ship == "GRND") {{"selected"}} @endif>GRND</option>
                                                    <option value="2-DAY" @if(isset($order_d_yellow->ship) && $order_d_yellow->ship == "2-DAY") {{"selected"}} @endif>2-DAY</option>
                                                    <option value="OVERNIGHT" @if(isset($order_d_yellow->ship) && $order_d_yellow->ship == "OVERNIGHT") {{"selected"}} @endif>OVERNIGHT</option>
                                                    <option value="FEDEX" @if(isset($order_d_yellow->ship) && $order_d_yellow->ship == "FEDEX") {{"selected"}} @endif>FEDEX</option>
                                                    <option value="FX-3DAY AIR" @if(isset($order_d_yellow->ship) && $order_d_yellow->ship == "FX-3DAY AIR") {{"selected"}} @endif>FX-3DAY AIR</option>
                                                    <option value="POWER FORCE" @if(isset($order_d_yellow->ship) && $order_d_yellow->ship == "POWER FORCE") {{"selected"}} @endif>POWER FORCE</option>
                                                </select>
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="acct" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">ACCNT</label>
                                                <input type="text" name="acct" class="form-control" id="acct" value="{{$order_d_yellow->acct ?? ""}}">
                                            </div>
                                            <div class="col-md-2 mb-3">
                                                <label for="ship_date" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">DATE SHIPPED</label>
                                                <input type="text" name="ship_date" class="form-control" id="ship_date" value="" readonly="">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <h6 class="font-weight-600 text-center" style="background: #d3d3d3; padding: 13px;"></h6>
                        @if(count($order_d_yellow_inks) > 0)
                        @php
                // dd($order_d_yellow_inks);
                        @endphp
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="p-print-location">
                                        <input type="hidden" class="location-count" value="{{count($order_d_yellow_inks)}}">
                                        <input type="hidden" class="counts" value="{{$max_key}}">
                                        @php
                                        $table_header_arr       = [];
                                        $table_body_arr         = [];
                                        $keys_arr               = [];
                                        @endphp
                                        @foreach ($order_d_yellow_inks as $order_d_yellow_ink)
                                        @php
                                        $table_header_arr[$order_d_yellow_ink->key] = $order_d_yellow_ink->location_number;
                                        $table_body_arr[$order_d_yellow_ink->key]   = json_decode($order_d_yellow_ink->ink_colors, true);
                                        $keys_arr[]         = $order_d_yellow_ink->key;
                                        @endphp
                                        <div class="form-group row print-location">
                                            <div class="col-sm-5">
                                                <select class="form-control location-name" name="location_number[{{$order_d_yellow_ink->key}}][]" data-column="{{$order_d_yellow_ink->key}}">
                                                    <option value="">select</option>
                                                    @foreach ($print_locations as $print_location)
                                                    <option value="{{$print_location->name}}" @if($order_d_yellow_ink->location_number == $print_location->name) {{"selected"}} @endif>{{$print_location->abbr}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-5">
                                                <input class="form-control number-of-colors" name="color_per_location[{{$order_d_yellow_ink->key}}][]" type="number" value="{{$order_d_yellow_ink->color_per_location}}">
                                            </div>
                                            <div class="col-sm-1">
                                                <i type="submit" class="fas fa-plus add-p-location no-print" style="color:green;cursor:pointer;"  style="max-width: 114px;max-height: 47px;margin-top: 25px;" data-id=""></i>
                                            </div>
                                            <div class="col-sm-1">
                                                <i  class="fas fa-minus remove-p-location no-print" style="color:red;cursor:pointer;" style="max-width: 114px;max-height: 47px;margin-top: 25px; margin-left: 5px;" data-id=""></i>
                                            </div>
                                        </div>
                                        @endforeach
                                        @php
                                // dd($keys_arr, $table_body_arr);
                                        @endphp
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="table-responsive" style=" overflow: hidden;">
                                    <table class="table table-nowrap dynamic-table" style=" overflow: hidden;" border="0">
                                        <thead>
                                            <tr class="t-header">
                                                @foreach ($table_header_arr as $kk=>$name)
                                                <th colspan="1" class="{{$kk}}">{{$name}}</th>
                                                @endforeach
                                            </tr>
                                        </thead>
                                        <tbody class="t-body">
                                            <tr>

                                                @foreach ($table_header_arr as $kk=>$name)
                                                <td colspan="1" style="font-size: 13px;font-weight: bold;" class="{{$kk}}">INK COLORS</td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                @foreach ($keys_arr as $column_key)
                                                @php
                                                $index= 0;
                                                @endphp
                                                <td colspan="1" class="{{$column_key}}" style="padding:0px;"><input type="text" name="ink_color[{{$column_key}}][]" class="form-control" value="{{$table_body_arr[$column_key]['"'.$index.'"']}}" style="border-radius: 0 !important;"></td>
                                                @endforeach

                                            </tr>
                                            <tr>
                                                @foreach ($keys_arr as $column_key)
                                                @php
                                                $index= 1;
                                                @endphp
                                                <td colspan="1" class="{{$column_key}}" style="padding:0px;"><input type="text" name="ink_color[{{$column_key}}][]" class="form-control" value="{{$table_body_arr[$column_key]['"'.$index.'"']}}" style="border-radius: 0 !important;"></td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                @foreach ($keys_arr as $column_key)
                                                @php
                                                $index= 2;
                                                @endphp
                                                <td colspan="1" class="{{$column_key}}" style="padding:0px;"><input type="text" name="ink_color[{{$column_key}}][]" class="form-control" value="{{$table_body_arr[$column_key]['"'.$index.'"']}}" style="border-radius: 0 !important;"></td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                @foreach ($keys_arr as $column_key)
                                                @php
                                                $index= 3;
                                                @endphp
                                                <td colspan="1" class="{{$column_key}}" style="padding:0px;"><input type="text" name="ink_color[{{$column_key}}][]" class="form-control" value="{{$table_body_arr[$column_key]['"'.$index.'"']}}" style="border-radius: 0 !important;"></td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                @foreach ($keys_arr as $column_key)
                                                @php
                                                $index= 4;
                                                @endphp
                                                <td colspan="1" class="{{$column_key}}" style="padding:0px;"><input type="text" name="ink_color[{{$column_key}}][]" class="form-control" value="{{$table_body_arr[$column_key]['"'.$index.'"']}}" style="border-radius: 0 !important;"></td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                @foreach ($keys_arr as $column_key)
                                                @php
                                                $index= 5;
                                                @endphp
                                                <td colspan="1" class="{{$column_key}}" style="padding:0px;"><input type="text" name="ink_color[{{$column_key}}][]" class="form-control" value="{{$table_body_arr[$column_key]['"'.$index.'"']}}" style="border-radius: 0 !important;"></td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                @foreach ($keys_arr as $column_key)
                                                @php
                                                $index= 6;
                                                @endphp
                                                <td colspan="1" class="{{$column_key}}" style="padding:0px;"><input type="text" name="ink_color[{{$column_key}}][]" class="form-control" value="{{$table_body_arr[$column_key]['"'.$index.'"']}}" style="border-radius: 0 !important;"></td>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                @foreach ($keys_arr as $column_key)
                                                @php
                                                $index= 7;
                                                @endphp
                                                <td colspan="1" class="{{$column_key}}" style="padding:0px;"><input type="text" name="ink_color[{{$column_key}}][]" class="form-control" value="{{$table_body_arr[$column_key]['"'.$index.'"']}}" style="border-radius: 0 !important;"></td>
                                                @endforeach
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-row">
                                    <div class="p-print-location">
                                        <input type="hidden" class="location-count" value="1">
                                        <input type="hidden" class="counts" value="1">
                                        <div class="form-group row print-location">
                                            <div class="col-sm-5">
                                                <select class="form-control location-name" name="location_number[1][]" data-column="1">
                                                    <option value="">select</option>
                                                    @foreach ($print_locations as $print_location)
                                                    <option value="{{$print_location->name}}" @if($print_location->name == "Full Back") {{"selected"}} @endif>{{$print_location->abbr}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-sm-5">
                                                <input class="form-control number-of-colors" data-product-id="" name="color_per_location[1][]" type="number" value="">
                                            </div>
                                            <div class="col-sm-1">
                                                <i type="submit" class="fas fa-plus add-p-location no-print" style="color:green;cursor:pointer;"  style="max-width: 114px;max-height: 47px;margin-top: 25px;" data-id=""></i>
                                            </div>
                                            <div class="col-sm-1">
                                                <i  class="fas fa-minus remove-p-location no-print" style="color:red;cursor:pointer;" style="max-width: 114px;max-height: 47px;margin-top: 25px; margin-left: 5px;" data-id=""></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-nowrap dynamic-table" border="0">
                                        <thead>
                                            <tr class="t-header">
                                                <th colspan="1" class="1">Full Back</th>
                                            </tr>
                                        </thead>
                                        <tbody class="t-body">
                                            <tr>
                                                <td colspan="1" style="font-size: 13px;font-weight: bold;">INK COLORS</td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="border-radius: 0 !important;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="border-radius: 0 !important;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="border-radius: 0 !important;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="border-radius: 0 !important;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="border-radius: 0 !important;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="border-radius: 0 !important;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="border-radius: 0 !important;"></td>
                                            </tr>
                                            <tr>
                                                <td colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="border-radius: 0 !important;"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endif
                        <h6 class="font-weight-600 text-center" style="background: #d3d3d3;padding:13px;"></h6>
                        <div class="row">
                            <div class="col-md-12">

                                <div class="form-row">

                                    <div class="col-md-2 mb-3">
                                    <label for="film_number" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">Film Number</label>
                                    <input type="text" name="film_number" class="form-control input-sm" id="film_number" value="{{$order_d_yellow->film_number ?? ""}}">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="print_crew" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">Alpha#</label>
                                    <input type="text" name="alpha" readonly="" class="form-control" id="alpha" value="{{$order_d_yellow->alpha ?? ""}}">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="print_crew" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">S&S#</label>
                                    <input type="text" name="s_and_s" readonly="" class="form-control" id="s_and_s" value="{{$order_d_yellow->s_and_s ?? ""}}">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="print_crew" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">SANMAR#</label>
                                    <input type="text" name="sanmar" readonly="" class="form-control" id="sanmar" value="{{$order_d_yellow->sanmar ?? ""}}">
                                </div>
                                 <div class="col-md-2 mb-3">
                                    <label for="print_crew" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">Textiled</label>
                                    <input type="text" name="" readonly="" class="form-control" id="" value="">
                                </div> 
                                 <div class="col-md-2 mb-3">
                                    <label for="print_crew" style="font-size: 13px;font-weight: bold; margin-bottom:unset;">Other Info</label>
                                    <input type="text" name="" readonly="" class="form-control" id="" value="">
                                </div>                                       
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive" style=" overflow: hidden;">
                                @php
                                $sub_total                  = 0;
                                $grand_total                = 0; 
                                $tax_percent                = 0;
                                $flag                       = (isset($invoice_details["adult_sizes"]))?1:0;
                                $flag                       += (isset($invoice_details["baby_sizes"]))?1:0;
                                $initializer    = 0;

                                // dd($invoice_details);
                                @endphp
                                
                                @foreach ($invoice_details as $size_for=>$invoice)
                                @php
                                $initializer++;
                                @endphp
                                <table class="table table-nowrap" border="0" style=" overflow: hidden;"  colspan="13" width="100%">
                                    <thead>
                                        <tr>
                                            @if($size_for == "adult_sizes")
                                            <th colspan="1" style="width: 45%;">Description</th>
                                            <th colspan="1">Color</th>
                                            <th colspan="1">XS</th>
                                            <th colspan="1">S</th>
                                            <th colspan="1">M</th>
                                            <th colspan="1">L</th>
                                            <th colspan="1">XL</th>
                                            <th colspan="1">2XL</th>
                                            <th colspan="1">3XL</th>
                                            <th colspan="1">4XL</th>
                                            <th colspan="1">5XL</th>
                                            <th colspan="1">6XL</th>
                                            @elseif($size_for == "baby_sizes")
                                            <th colspan="1" style="width: 45%;">Description</th>
                                            <th colspan="1">Color</th>
                                            <th colspan="1">OSFA</th>
                                            <th colspan="1">New Born</th>
                                            <th colspan="1">6M</th>
                                            <th colspan="1">12M</th>
                                            <th colspan="1">18M</th>
                                            <th colspan="1">2T</th>
                                            <th colspan="1">3T</th>
                                            <th colspan="1">4T</th>
                                            <th colspan="1">5T</th>
                                            <th colspan="1">6T</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice as $product_name=>$invoice_detail)
                                        @foreach ($invoice_detail as $color=>$detail)
                                        @php
                                        $r_total            = 0;
                                        $total_qty          = 0;
                                        $fixed_sizes_qty    = 0;
                                        $fixed_size_price   = 0;
                                        $fixed_sizes        = "";
                                        
                                        foreach ($detail as $size=>$value){
                                            if(in_array($size, $fixed_adult_sizes) || in_array($size, $fixed_baby_sizes)){
                                                $fixed_sizes_qty    = $fixed_sizes_qty+$value["pieces"];
                                                $fixed_size_price   = $value["price"]??0; 
                                                $fixed_sizes        .= $size."(".$value["pieces"].") ";
                                            }else{
                                                $qty                = $value["pieces"]??0;
                                                $price              = $value["price"]??0;
                                                $r_total            += ($qty*$price);
                                                $total_qty          += $qty;
                                            }
                                        }
                                        $total_qty          += $fixed_sizes_qty;
                                        $r_total            +=($fixed_sizes_qty*$fixed_size_price);
                                        $sub_total          += $r_total;
                                        @endphp
                                        @if($size_for == "adult_sizes")
                                        <tr>
                                            <td>
                                                <div>{{ $product_name }}</div>
                                            </td>
                                            <td>
                                                <div> {{$color}}</div>
                                            </td>
                                            <td>
                                                <div> {{ (isset($detail["XS"]["pieces"]))?$detail["XS"]["pieces"]:""}}</div>
                                            </td>
                                            <td>
                                                <div> {{ (isset($detail["S"]["pieces"]))?$detail["S"]["pieces"]:""}}</div>
                                            </td>
                                            <td>
                                                <div> {{ (isset($detail["M"]["pieces"]))?$detail["M"]["pieces"]:""}}</div>
                                            </td>
                                            <td>
                                                <div> {{ (isset($detail["L"]["pieces"]))?$detail["L"]["pieces"]:""}}</div>
                                            </td>
                                            <td>
                                                <div> {{ (isset($detail["XL"]["pieces"]))?$detail["XL"]["pieces"]:""}}</div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ (isset($detail["2XL"]["pieces"]))?$detail["2XL"]["pieces"]:""}}
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ (isset($detail["3XL"]["pieces"]))?$detail["3XL"]["pieces"]:""}}
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ (isset($detail["4XL"]["pieces"]))?$detail["4XL"]["pieces"]:""}}
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ (isset($detail["5XL"]["pieces"]))?$detail["5XL"]["pieces"]:""}}
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ (isset($detail["6XL"]["pieces"]))?$detail["6XL"]["pieces"]:""}}
                                                </div>
                                            </td>
                                        </tr>
                                        @elseif($size_for == "baby_sizes")
                                        <tr>
                                            <td>
                                                <div><strong>{{ $product_name }}</strong></div>
                                            </td>
                                            <td>
                                                <div> {{$color}}</div>
                                            </td>
                                            <td>
                                                <div> {{ (isset($detail["OSFA"]["pieces"]))?$detail["OSFA"]["pieces"]:""}}</div>
                                            </td>
                                            <td>
                                                <div> {{ (isset($detail["New Born"]["pieces"]))?$detail["New Born"]["pieces"]:""}}</div>
                                            </td>
                                            <td>
                                                <div> {{ (isset($detail["6M"]["pieces"]))?$detail["6M"]["pieces"]:""}}</div>
                                            </td>
                                            <td>
                                                <div> {{ (isset($detail["12M"]["pieces"]))?$detail["12M"]["pieces"]:""}}</div>
                                            </td>
                                            <td>
                                                <div> {{ (isset($detail["18M"]["pieces"]))?$detail["18M"]["pieces"]:""}}</div>
                                            </td>
                                            <td>
                                                <div>{{ (isset($detail["2T"]["pieces"]))?$detail["2T"]["pieces"]:""}}</div>
                                            </td>
                                            <td>
                                                <div>{{ (isset($detail["3T"]["pieces"]))?$detail["3T"]["pieces"]:""}}</div>
                                            </td>
                                            <td>
                                                <div>{{ (isset($detail["4T"]["pieces"]))?$detail["4T"]["pieces"]:""}}</div>
                                            </td>
                                            <td>
                                                <div>{{ (isset($detail["5T"]["pieces"]))?$detail["5T"]["pieces"]:""}}</div>
                                            </td>
                                            <td>
                                                <div>{{ (isset($detail["6T"]["pieces"]))?$detail["6T"]["pieces"]:""}}</div>
                                            </td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="form-row">
                              <div class="row imagess">
                                {{-- {{dd($order->OrderImgs)}} --}}
                                @if(count($order->OrderImgs) > 0)
                                @foreach($order->OrderImgs as $key=>$OrderImg)
                                <div class="col-md-3 photo mt-1">
                                    <a class="example-image-link" href="{{asset($OrderImg->image)}}" data-lightbox="example-1">
                                        <img src="{{asset($OrderImg->image)}}" class="img-rounded" alt="{{$OrderImg->order_id}}" >
                                    </a>
                                </div>
                             @endforeach
                             @endif

                         </div>
                     </div>
                 </div>
                 <div class="col-md-5">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label for="total" class="col-md-12" style="text-align:center;font-weight: 700 !important;color: #000000 !important;">Total</label>
                            <input type="text" name="total" class="form-control" id="total" value="{{$client_details["projected_units"]}}" disabled>
                        </div>
                    </div>
                    <div class="form-group row">
                        {{-- <label for="is_rejected" class="col-sm-4 font-weight-600">Any Rejects OR Shortages</label> --}}
                        <label for="is_rejected" style="font-size: 13px;font-weight: bold; margin-bottom:unset;width: 100%">Any Rejects OR Shortages? 
                            <span style="margin-left: 20%;">Yes</span>
                            <span style="margin-left: 20%;">No</span>
                        </label>
                        <input type="hidden" name="is_rejected" id="is_rejected" value="">

                        <hr>
                        {{-- <div class="col-sm-8"> --}}
                                    {{-- <select name="is_rejected" id="is_rejected" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Yes" @if(isset($order_d_yellow->is_rejected) && $order_d_yellow->is_rejected == "Yes") {{"selected"}} @endif>Yes</option>
                                        <option value="No" @if(isset($order_d_yellow->is_rejected) && $order_d_yellow->is_rejected == "No") {{"selected"}} @endif>No</option>
                                    </select> --}}
                                {{-- </div> --}}
                                <label for="is_rejected" style="font-size: 13px;font-weight: bold; margin-bottom:unset;width: 100%">List Rejects(Size/QTY) 
                                </div>
                                <div class="form-group row" style="">
                                    <label for="notes" class="col-sm-8 font-weight-600 text-center">Notes</label>
                                   
                                    <div class="col-sm-10">
                                        <textarea type="text" rows="4" cols="55" value="" class="form-control" name="notes" id="notes" placeholder="" style="height: auto !important;">{!!$order->notes ?? ""!!}</textarea>
                                      
                                    </div>
                                </div>
                                {{--  --}}

                                @if(count($extra_details) > 0)

                                <div class="row mt-3">
                                    <div class="col-md-12">
                                        <div class="form">
                                            <div class="p-print-location">
                                                @foreach ($extra_details as $service=>$value)
                                                @if ($service != "order_id" && $value != "")
                                                <div class="form-group row print-location">
                                                    <div class="col-sm-5">
                                                        <input class="form-control number-of-colors"  disabled="" value="{{$value}}">
                                                    </div>
                                                </div>
                                                @endif
                                                
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endif
                            {{--  --}}
                        </div>
                    </div>

                    <div class="col-md-12 form-check mt-5">
                        @if(auth()->user()->can('orders-update-d-yellow'))
                        <button type="submit" class="btn btn-primary mb-3 no-print" id="submit-form">Submit</button>
                        @endif
                        <button type="button" class="btn btn-lg btn-success mb-3 no-print" onclick='printDiv();' id="submit-form">
                            <span class="fa fa-print">
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection 
@section('footer-script')

<script>
function printDiv() 
{
    setTimeout(function(){
        window.print();

    },200);
    if (!$("#sidebarCollapse").hasClass("open")) {
        $('#sidebarCollapse').click();
    }
}
$(document).on("change", ".location-name", function(){
    let class_name      = "."+$(this).attr("data-column");
    let column_header   = $(this).val();
        $(".t-header").find(class_name).text(column_header);
});
function add_column(class_name=""){
    let header_html     ='<th colspan="1" class="'+class_name+'"></th>';
    let ink_color       ='<td colspan="1" class="'+class_name+'" style="font-size: 13px;font-weight: bold;">INK COLORS</td>';
    let body_html       ='<td colspan="1" class="'+class_name+'" style="padding:0px;"><input type="text" name="ink_color['+class_name+'][]" class="form-control" value="" style="border-radius: 0 !important;"></td>';
    $(".t-header").append(header_html);
    $("body .t-body tr").each(function(index, element){
        if(index == 0){

            $(this).append(ink_color);
        }else{

            $(this).append(body_html);
        }
    });
}
function remove_column(class_name=""){
    let header_html     ='<th colspan="1" class="'+class_name+'"></th>';
    let body_html       ='<td colspan="1" class="'+class_name+'">'+class_name+'</td>';
    $(".t-header").find("."+class_name).remove();
    $("body .t-body tr").each(function(index, element){
        $(this).find("."+class_name).remove();
    });
}
$(document).ready(function(){
    $(document).on('click', '.add-p-location', function(event) {
        var parent_selector                 = '.p-print-location';
        let count                           = $('.p-print-location').find('.location-count').val();
        let increament_count                = $('.p-print-location').find('.counts').val();
        var print_location_template         = $(this).closest(parent_selector).find(".print-location").first().clone();
        var print_location_parent           = $(this).closest(parent_selector);
        var new_print_location_template     = print_location_template.clone();
        event.preventDefault();
        print_location_parent.append(new_print_location_template);
        new_print_location_template.find('input').val(null);
        new_print_location_template.find('select').val(null);
        count                               = parseInt(count)+1;
        increament_count                    = parseInt(increament_count)+1;
        $('.p-print-location').find('.location-count').val(count);
        $('.p-print-location').find('.counts').val(increament_count);
        new_print_location_template.find('select').attr('data-column', increament_count);
        new_print_location_template.find('select').attr('name', 'location_number['+increament_count+'][]');
        new_print_location_template.find('input').attr('name', 'color_per_location['+increament_count+'][]');
        add_column(increament_count);
    });
});
$(document).on('click', '.remove-p-location', function(e) {
    e.preventDefault();
    var parent_selector     = '.p-print-location';
    let count               = $('.p-print-location').find('.location-count').val();
    count                   = parseInt(count)-1;
    let class_name          = $(this).closest(".print-location").find("select").attr("data-column");
    if(count >= 1){
        $(this).closest('.print-location').remove();
        $($('.p-print-location')).find('.location-count').val(count);
        remove_column(class_name);
    } 
});
</script>
@endsection