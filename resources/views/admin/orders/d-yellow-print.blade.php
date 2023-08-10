@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<div id='DivIdToPrint'>
  
<style media="print">
        @page {
            size: auto;
            margin: 0;
        }
         @media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}
    </style>

<div class="body-content">
    <div class="card">
        <div class="card-body">

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
                    <h5 class="font-weight-600 text-center" style="background: #d3d3d3;">Tyler</h5>
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-row">
                                <div class="col-md-3 mb-3">
                                    <label for="print_crew" style="font-size: 11px;font-weight: bold;">PRINT CREW</label>
                                    <input type="text" name="print_crew" class="form-control" id="print_crew" value="{{$order_d_yellow->print_crew ?? ""}}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="goods_rec" style="font-size: 11px;font-weight: bold;">Goods REC'D</label>
                                    <input type="text" name="goods_rec" class="form-control" id="goods_rec" value="{{$order_d_yellow->goods_rec ?? ""}}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="order_date" style="font-size: 11px;font-weight: bold;">ORDER DATE</label>
                                    <input type="text" name="order_date" class="form-control" id="order_date" value="{{date("m/d/Y", $order->time_id)}}" disabled>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="boxes" style="font-size: 11px;font-weight: bold;">TOTAL # OF BOXES</label>
                                    <input type="text" name="boxes" class="form-control" id="boxes" value="{{$order_d_yellow->boxes ?? ""}}">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="production_sample" style="font-size: 11px;font-weight: bold;">PRODUCTION SAMPLE</label>
                                    <select name="production_sample" id="production_sample" class="form-control">
                                        <option value="">Select</option>
                                        <option value="Yes" @if(isset($order_d_yellow->production_sample) && $order_d_yellow->production_sample == "Yes") {{"selected"}} @endif>Yes</option>
                                        <option value="No" @if(isset($order_d_yellow->production_sample) && $order_d_yellow->production_sample == "No") {{"selected"}} @endif>No</option>
                                        <option value="1" @if(isset($order_d_yellow->production_sample) && $order_d_yellow->production_sample == "1") {{"selected"}} @endif>1</option>
                                        <option value="2" @if(isset($order_d_yellow->production_sample) && $order_d_yellow->production_sample == "2") {{"selected"}} @endif>2</option>
                                        <option value="3" @if(isset($order_d_yellow->production_sample) && $order_d_yellow->production_sample == "3") {{"selected"}} @endif>3</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="event" class="font-weight-600" style="font-size: 11px;font-weight: bold;">EVENT</label>
                                    <select name="event" id="event" class="form-control" disabled>
                                        <option value="">Select</option>
                                        <option value="Yes" @if($order->event == "Yes") {{"selected"}} @endif>Yes</option>
                                        <option value="No" @if($order->event == "No") {{"selected"}} @endif>No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-row">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th scope="col" colspan="2">Ship To</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <th scope="row">Name</th>
                                                <td>{{$client_details["company_name"]}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Company</th>
                                                <td>{{$client_details["company_name"]}}</td>
                                            </tr>
                                            <tr>
                                                <th scope="row">Address</th>
                                                <td>{{$client_details["address"]}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="font-weight-600 text-center" style="background: #d3d3d3;">Customer</h5>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-row">
                                <div class="col-md-2 mb-3">
                                    <label for="company_name" style="font-size: 11px;font-weight: bold;">CUSTOMER</label>
                                    <input type="text" name="company_name" class="form-control" id="company_name" value="{{$client_details["company_name"]}}" disabled>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="order_number" style="font-size: 11px;font-weight: bold;">P.O #</label>
                                    <input type="text" name="order_number" class="form-control" id="order_number" value="{{$order->order_number}}" disabled>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="ship_date" style="font-size: 11px;font-weight: bold;">SHIP DATE</label>
                                    <input type="text" name="ship_date" class="form-control" id="ship_date" value="{{date("Y-m-d", $order->ship_date)}}" disabled>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="other_info" style="font-size: 11px;font-weight: bold;">OTHER INFO</label>
                                    <input type="text" name="other_info" class="form-control" id="other_info" value="{{$client_details["sales_rep"]}}" disabled>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="palletize" style="font-size: 11px;font-weight: bold;">PALLETIZE</label>
                                    <div class="form-row">
                                        <input type="text" name="palletize" class="form-control col-md-6" id="palletize" value="{{$order_d_yellow->palletize ?? ""}}">
                                        <select name="palletize_opt" id="palletize_opt" class="form-control col-md-6">
                                            <option value="">Select</option>
                                            <option value="Yes" @if(isset($order_d_yellow->palletize_opt) && $order_d_yellow->palletize_opt == "Yes") {{"selected"}} @endif>Yes</option>
                                            <option value="No" @if(isset($order_d_yellow->palletize_opt) && $order_d_yellow->palletize_opt == "No") {{"selected"}} @endif>No</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="in_hands" class="font-weight-600" style="font-size: 11px;font-weight: bold;">IN HANDS</label>
                                    <input type="text" name="in_hands" class="form-control" id="in_hands" value="{{$order_d_yellow->in_hands ?? ""}}">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="design" class="font-weight-600" style="font-size: 11px;font-weight: bold;">DESIGN</label>
                                    <input type="text" name="design" class="form-control" id="design" value="{{$order_d_yellow->design ?? ""}}">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="ship" class="font-weight-600" style="font-size: 11px;font-weight: bold;">SHIP</label>
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
                                    <label for="acct" class="font-weight-600" style="font-size: 11px;font-weight: bold;">ACCNT</label>
                                    <input type="text" name="acct" class="form-control" id="acct" value="{{$order_d_yellow->acct ?? ""}}">
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label for="ship_date" class="font-weight-600" style="font-size: 11px;font-weight: bold;">DATE SHIPPED</label>
                                    <input type="text" name="ship_date" class="form-control" id="ship_date" value="{{date("Y-m-d", $order->ship_date)}}" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <h5 class="font-weight-600 text-center" style="background: #d3d3d3; padding: 13px;"></h5>
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
                                        <i type="submit" class="no-print fas fa-plus add-p-location" style="color:green;cursor:pointer;"  style="max-width: 114px;max-height: 47px;margin-top: 25px;" data-id=""></i>
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
                    <div class="table-responsive">
                        <table class="table table-nowrap dynamic-table" border="0">
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
                                        <td colspan="1" style="font-size: 12px;font-weight: bold;">INK COLORS</td>
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
                                <i type="submit" class="fas fa-plus add-p-location" style="color:green;cursor:pointer;"  style="max-width: 114px;max-height: 47px;margin-top: 25px;" data-id=""></i>
                            </div>
                            <div class="col-sm-1">
                                <i  class="fas fa-minus remove-p-location" style="color:red;cursor:pointer;" style="max-width: 114px;max-height: 47px;margin-top: 25px; margin-left: 5px;" data-id=""></i>
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
                                    <td colspan="1" style="font-size: 12px;font-weight: bold;">INK COLORS</td>
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
            <h5 class="font-weight-600 text-center" style="background: #d3d3d3;padding:13px;"></h5>
            <div class="row">
                <div class="col-md-4">
                    <div class="form-row">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" colspan="3">Film Number</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">Alpha#</th>
                                        <td><input type="text" name="alpha" class="form-control" id="alpha" value="{{$order_d_yellow->alpha ?? ""}}"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">S&S#</th>
                                        <td><input type="text" name="s_and_s" class="form-control" id="s_and_s" value="{{$order_d_yellow->s_and_s ?? ""}}"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row">SANMAR#</th>
                                        <td><input type="text" name="sanmar" class="form-control" id="sanmar" value="{{$order_d_yellow->sanmar ?? ""}}"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="table-responsive">
                        @php
                            $sub_total                  = 0;
                            $grand_total                = 0; 
                            $tax_percent                = 0;
                            $flag   = (isset($invoice_details["adult_sizes"]))?1:0;
                            $flag   += (isset($invoice_details["baby_sizes"]))?1:0;
                            $initializer    = 0;
                        @endphp
                        @foreach ($invoice_details as $size=>$invoice)
                        @php
                            $initializer++;
                        @endphp
                        <table class="table table-nowrap" border="0">
                            <thead>
                                <tr>
                                    @if($size == "adult_sizes")
                                    <th></th>
                                    <th>Description</th>
                                    <th>XS-XL</th>
                                    <th>2XL</th>
                                    <th>3XL</th>
                                    <th>4XL</th>
                                    <th>5XL</th>
                                    <th>6XL</th>
                                    @elseif($size == "baby_sizes")
                                    <th></th>
                                    <th>Description</th>
                                    <th>OSFA-18M</th>
                                    <th>2T</th>
                                    <th>3T</th>
                                    <th>4T</th>
                                    <th>5T</th>
                                    <th>6T</th>
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
                                        <tr>
                                            <td>
                                                <div><strong>Brand & Sizes</strong></div>
                                                <div><strong>Garment Color</strong></div>
                                            </td>
                                            <td>
                                                <div><strong>{{ $product_name }}</strong></div>
                                                <small>{{$color}} </small>
                                            
                                                <small>{{$fixed_sizes}}</small>
                                            </td>
                                            <td>
                                                <div>{{($fixed_sizes_qty>0)?$fixed_sizes_qty:""}}</div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ (isset($detail["2XL"]["pieces"]))?$detail["2XL"]["pieces"]:""}}
                                                </div>
                                                <div>
                                                    {{ (isset($detail["2XL"]["price"])) ? "$".$detail["2XL"]["price"] : ""}}
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ (isset($detail["3XL"]["pieces"]))?$detail["3XL"]["pieces"]:""}}
                                                </div>
                                                <div>
                                                    {{ (isset($detail["3XL"]["price"])) ? "$".$detail["3XL"]["price"] : ""}}
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ (isset($detail["4XL"]["pieces"]))?$detail["4XL"]["pieces"]:""}}
                                                </div>
                                                <div>
                                                    {{ (isset($detail["4XL"]["price"])) ? "$".$detail["4XL"]["price"] : ""}}
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ (isset($detail["5XL"]["pieces"]))?$detail["5XL"]["pieces"]:""}}
                                                </div>
                                                <div>
                                                    {{ (isset($detail["5XL"]["price"])) ? "$".$detail["5XL"]["price"] : ""}}
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ (isset($detail["6XL"]["pieces"]))?$detail["6XL"]["pieces"]:""}}
                                                </div>
                                                <div>
                                                    {{ (isset($detail["6XL"]["price"])) ? "$".$detail["6XL"]["price"] : ""}}
                                                </div>
                                            </td>
                                        </tr>
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
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="total" class="col-md-12" style="text-align:center;">Total</label>
                                <input type="text" name="total" class="form-control" id="total" value="{{$client_details["projected_units"]}}" disabled>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="is_rejected" class="col-sm-4 font-weight-600">Any Rejects OR Shortages</label>
                            <div class="col-sm-8">
                                <select name="is_rejected" id="is_rejected" class="form-control">
                                    <option value="">Select</option>
                                    <option value="Yes" @if(isset($order_d_yellow->is_rejected) && $order_d_yellow->is_rejected == "Yes") {{"selected"}} @endif>Yes</option>
                                    <option value="No" @if(isset($order_d_yellow->is_rejected) && $order_d_yellow->is_rejected == "No") {{"selected"}} @endif>No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="notes" class="col-sm-4 font-weight-600">Notes</label>
                            <div class="col-sm-8">
                                <textarea type="text" value="" class="form-control" name="notes" id="notes" placeholder="" rows="4">{{$order_d_yellow->notes ?? ""}}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 form-check mt-5">
                    <button type="submit" class="btn btn-primary mb-3" id="submit-form">Submit</button>
                    <button type="button" class="btn btn-success mb-3" onclick='printDiv();' id="submit-form">Print</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>
@endsection 
@section('footer-script')
<script>
  $(document).ready(function($) {
      // printDiv();
  });
  function printDiv() 
  {

      var divToPrint = document.getElementById('DivIdToPrint');
      var newWin = window.open('','Print-Window');

      newWin.document.open();

      newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

      newWin.document.close();

      // setTimeout(function(){newWin.close();},100);

  }

</script>
   
</script>
@endsection