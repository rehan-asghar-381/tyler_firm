@extends("admin.template", ["pageTitle"=>$pageTitle])
<style type="text/css">
    .form-control {
        height:calc(1.8em + 0.25rem + 0px) !important;
        font-size:13px !important;
        padding:0 0.75rem !important;
    }
    textarea {
      width: auto !important; 
    }
    .img-rounded{
        object-fit:cover;
    }
    table td, table th{
        padding:2px 10px !important;
        font-size: 13px !important;
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
        width: 300px;
        height: 200px;
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
        .footer-print {
            position: fixed;
            bottom: 0;
            text-align: center;
        }
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
            /border: 1px solid #fff !important;/
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
            <div class="row">
                <div class="col-sm-2 offset-sm-5">
                <img src="{{asset('assets/images/logo/logo.webp')}}" class="img-fluid mb-3" alt="">
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <address>
                        <strong>Nu World Graphics, LLC.</strong><br>
                        1801 Western Ave.<br>
                        Las Vegas, NV. 89102<br>
                        Office: (702)671-0000<br>
                        Email: Tyler@NuWorldGraphicsLV.com<br>
                        Website: www.NuWorldGraphicsLV.com
                    </address>
                </div>
                <div class="col-sm-6 text-right">
                    <h1 class="h3">Quote #{{ $client_details["invoice_number"]??"" }}</h1>
                    <div>Date: {{ $client_details["date"] ?? "-" }}</div>
                    <div>Client: {{ $client_details["company_name"] ?? "-" }}</div>
                    <div>Job Name: {{ $client_details["job_name"] ?? "-" }}</div>
                    <div>PO# {{ $client_details["order_number"] ?? "-" }}</div>
                    <div>Email: {{ $client_details["email"] ?? "-" }}</div>
                </div>
            </div> 
            <div class="table-responsive">
                @php
                    // dd($invoice_details);
                    $sub_total                  = 0;
                    $grand_total                = 0; 
                    $tax_percent                = 0;
                    $additional_services_flag   = 0;
                    $flag   = (isset($invoice_details["adult_sizes"]))?1:0;
                    $flag   += (isset($invoice_details["baby_sizes"]))?1:0;
                    $initializer    = 0;
                @endphp
                @foreach ($invoice_details as $size=>$invoice)
                @php
                    $initializer++;
                @endphp
                <table class="table-nowrap" border="0">
                    <thead>
                        <tr>
                            @if($size == "adult_sizes")
                            <th style="width: 45%;">Description</th>
                            <th>XS-XL</th>
                            <th>2XL</th>
                            <th>3XL</th>
                            <th>4XL</th>
                            <th>5XL</th>
                            <th>6XL</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            @elseif($size == "baby_sizes")
                            <th style="width: 45%;">Description</th>
                            <th>OSFA-18M</th>
                            <th>2T</th>
                            <th>3T</th>
                            <th>4T</th>
                            <th>5T</th>
                            <th>6T</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoice as $product_name=>$invoice_detail)
                            @foreach ($invoice_detail as $selector_ref=>$_detail)
                            @php
                                $__flag     = count($_detail);
                                $__start    = 0;
                            @endphp
                                @foreach ($_detail as $color=>$detail)
                                    @php
                                        $__start++;
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
                                            <div><strong>{{ $product_name }}</strong></div>
                                            <small style="font-weight: bold;">{{$color}} </small>
                                            <small style="font-weight: bold;">{{$fixed_sizes}}</small>
                                            
                                        </td>
                                        <td>
                                            <div>{{($fixed_sizes_qty>0)?$fixed_sizes_qty:""}}</div>
                                            <div>{{($fixed_size_price>0)? "$".number_format($fixed_size_price, 2): ""}}</div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ (isset($detail["2XL"]["pieces"]))?$detail["2XL"]["pieces"]:""}}
                                                {{ (isset($detail["2T"]["pieces"]))?$detail["2T"]["pieces"]:""}}
                                            </div>
                                            <div>
                                                {{ (isset($detail["2XL"]["price"])) ? "$".$detail["2XL"]["price"] : ""}}
                                                {{ (isset($detail["2T"]["price"])) ? "$".$detail["2T"]["price"] : ""}}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ (isset($detail["3XL"]["pieces"]))?$detail["3XL"]["pieces"]:""}}
                                                {{ (isset($detail["3T"]["pieces"]))?$detail["3T"]["pieces"]:""}}
                                            </div>
                                            <div>
                                                {{ (isset($detail["3XL"]["price"])) ? "$".$detail["3XL"]["price"] : ""}}
                                                {{ (isset($detail["3T"]["price"])) ? "$".$detail["3T"]["price"] : ""}}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ (isset($detail["4XL"]["pieces"]))?$detail["4XL"]["pieces"]:""}}
                                                {{ (isset($detail["4T"]["pieces"]))?$detail["4T"]["pieces"]:""}}
                                            </div>
                                            <div>
                                                {{ (isset($detail["4XL"]["price"])) ? "$".$detail["4XL"]["price"] : ""}}
                                                {{ (isset($detail["4T"]["price"])) ? "$".$detail["4T"]["price"] : ""}}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ (isset($detail["5XL"]["pieces"]))?$detail["5XL"]["pieces"]:""}}
                                                {{ (isset($detail["5T"]["pieces"]))?$detail["5T"]["pieces"]:""}}
                                            </div>
                                            <div>
                                                {{ (isset($detail["5XL"]["price"])) ? "$".$detail["5XL"]["price"] : ""}}
                                                {{ (isset($detail["5T"]["price"])) ? "$".$detail["5T"]["price"] : ""}}
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                {{ (isset($detail["6XL"]["pieces"]))?$detail["6XL"]["pieces"]:""}}
                                                {{ (isset($detail["6T"]["pieces"]))?$detail["6T"]["pieces"]:""}}
                                            </div>
                                            <div>
                                                {{ (isset($detail["6XL"]["price"])) ? "$".$detail["6XL"]["price"] : ""}}
                                                {{ (isset($detail["6T"]["price"])) ? "$".$detail["6T"]["price"] : ""}}
                                            </div>
                                        </td>
                                        <td>
                                            <div><strong>{{$total_qty}}</strong></div>
                                        </td>
                                        <td>
                                            <div><strong>{{"$".$r_total}}</strong></div>
                                        </td>
                                    </tr>
                                    @if($__flag == $__start)
                                        <tr>
                                            <td style="width: 100%;">
                                                <div><strong>Color Per Location</strong></div>
                                                @foreach ($color_per_locations[$product_name][$selector_ref]["location_number"] as $key=>$location)
                                                <div>
                                                    <small style="font-weight: bold;">{{$location}} {{$color_per_locations[$product_name][$selector_ref]["color_per_location"][$key] . " C. "}}</small>
                                                </div>
                                                @endforeach
                                            </td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        <tr>        
                                    @endif
                                @endforeach
                            @endforeach
                        @endforeach
                        @foreach ($extra_details as $coulmn_name=>$extra_detail)
                            @php
                                $except_end = "";
                                $prc        = explode("_", $coulmn_name);
                                $end_value  = end($prc);
                                for ($i=0; $i < count($prc)-1; $i++) { 
                                    $except_end     .= $prc[$i]."_";
                                }
                                if($end_value == "pieces"){
                                    $prices     = $extra_details[$except_end."prices"] ?? "";
                                    $charges    = $extra_details[$except_end."charges"] ?? "";
                                    if($extra_details[$coulmn_name] > 0 && ($prices>0 || $charges>0)){
                                        $additional_services_flag = 1;
                                        break;
                                    }
                                }elseif($end_value == "prices" OR $end_value == "charges"){
                                    $pieces     = $extra_details[$except_end."pieces"] ?? "";
                                    if($extra_details[$coulmn_name] > 0 && $pieces>0){
                                        $additional_services_flag = 1;
                                        break;
                                    }
                                }
                            @endphp 
                        @endforeach
                    </tbody>
                </table>
                @endforeach
                @if ($additional_services_flag == 1)
                    <table class="table table-nowrap" border="0">
                        <tbody>
                            <tr><td colspan="10" style="background-color: #dfdada;padding:5px;font-weight:bold;text-align:center;">Additional Services</td></tr>
                            @if($extra_details["ink_color_change_pieces"] > 0 && $extra_details["ink_color_change_prices"] > 0)
                                <tr>
                                    <td style="width: 80%;">
                                        <div><strong>Ink Color Change</strong></div>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Quantity</strong></div> --}}
                                        <strong>{{ $extra_details["ink_color_change_pieces"] }}</strong>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Price Per Piece</strong></div> --}}
                                        <strong>{{ "$".$extra_details["ink_color_change_pieces"]*$extra_details["ink_color_change_prices"] }}</strong>
                                    </td>
                                </tr>
                            @endif
                            @if($extra_details["shipping_pieces"] > 0 && $extra_details["shipping_charges"] > 0)
                                <tr>
                                    <td style="width: 80%;">
                                        <div><strong>Shipping</strong></div>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Quantity</strong></div> --}}
                                        <strong>{{ $extra_details["shipping_pieces"] }}</strong>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Price Per Piece</strong></div> --}}
                                        <strong>{{ "$".$extra_details["shipping_pieces"]*$extra_details["shipping_charges"] }}</strong>
                                    </td>
                                </tr>
                            @endif
                            @if($extra_details["label_pieces"] > 0 && $extra_details["label_prices"] > 0)
                                <tr>
                                    <td style="width: 80%;">
                                        <div><strong>Inside Labels</strong></div>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Quantity</strong></div> --}}
                                        <strong>{{ $extra_details["label_pieces"] }}</strong>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Price Per Piece</strong></div> --}}
                                        <strong>{{ "$".$extra_details["label_pieces"]*$extra_details["label_prices"] }}</strong>
                                    </td>
                                </tr>
                            @endif
                            @if($extra_details["fold_pieces"] > 0 && $extra_details["fold_prices"] > 0)
                                <tr>
                                    <td style="width: 80%;">
                                        <div><strong>Fold Only</strong></div>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Quantity</strong></div> --}}
                                        <strong>{{ $extra_details["fold_pieces"] }}</strong>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Price Per Piece</strong></div> --}}
                                        <strong>{{ "$".$extra_details["fold_pieces"]*$extra_details["fold_prices"] }}</strong>
                                    </td>
                                </tr>
                            @endif
                            @if($extra_details["fold_bag_pieces"] > 0 && $extra_details["fold_bag_prices"] > 0)
                                <tr>
                                    <td style="width: 80%;">
                                        <div><strong>Fold Bag Only</strong></div>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Quantity</strong></div> --}}
                                        <strong>{{ $extra_details["fold_bag_pieces"] }}</strong>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Price Per Piece</strong></div> --}}
                                        <strong>{{ "$".$extra_details["fold_bag_pieces"]*$extra_details["fold_bag_prices"] }}</strong>
                                    </td>
                                </tr>
                            @endif
                            @if($extra_details["fold_bag_tag_pieces"] > 0 && $extra_details["fold_bag_tag_prices"] > 0)
                                <tr>
                                    <td style="width: 80%;">
                                        <div><strong>Fold/Bag/Tag</strong></div>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Quantity</strong></div> --}}
                                        <strong>{{ $extra_details["fold_bag_tag_pieces"] }}</strong>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Price Per Piece</strong></div> --}}
                                        <strong>{{ "$".$extra_details["fold_bag_tag_pieces"]*$extra_details["fold_bag_tag_prices"] }}</strong>
                                    </td>
                                </tr>
                            @endif
                            
                            @if($extra_details["hang_tag_pieces"] > 0 && $extra_details["hang_tag_prices"] > 0)
                                <tr>
                                    <td style="width: 80%;">
                                        <div><strong>Hang Tags</strong></div>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Quantity</strong></div> --}}
                                        <strong>{{ $extra_details["hang_tag_pieces"] }}</strong>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Price Per Piece</strong></div> --}}
                                        <strong>{{ "$".$extra_details["hang_tag_pieces"]*$extra_details["hang_tag_prices"] }}</strong>
                                    </td>
                                    
                                </tr>
                            @endif
                            @if($extra_details["foil_pieces"] > 0 && $extra_details["foil_prices"] > 0)
                                <tr>
                                    <td style="width: 80%;">
                                        <div><strong>Foil</strong></div>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Quantity</strong></div> --}}
                                        <strong>{{ $extra_details["foil_pieces"] }}</strong>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Price Per Piece</strong></div> --}}
                                        <strong>{{ "$".$extra_details["foil_pieces"]*$extra_details["foil_prices"] }}</strong>
                                    </td>
                                </tr>
                            @endif
                            
                            @if($extra_details["transfers_pieces"] > 0 && $extra_details["transfers_prices"] > 0)
                                <tr>
                                    <td style="width: 80%;">
                                        <div><strong>Transfers</strong></div>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Quantity</strong></div> --}}
                                        <strong>{{ $extra_details["transfers_pieces"] }}</small>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Price Per Piece</strong></div> --}}
                                        <strong>{{ "$".$extra_details["transfers_pieces"]*$extra_details["transfers_prices"] }}</strong>
                                    </td>
                                </tr>
                            @endif
                            @if($extra_details["palletizing_pieces"] > 0 && $extra_details["palletizing_prices"] > 0)
                                <tr>
                                    <td style="width: 80%;">
                                        <div><strong>Palletizing</strong></div>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Quantity</strong></div> --}}
                                        <strong>{{ $extra_details["palletizing_pieces"] }}</strong>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Price Per Piece</strong></div> --}}
                                        <strong>{{ "$".$extra_details["palletizing_pieces"]*$extra_details["palletizing_prices"] }}</strong>
                                    </td>
                                </tr>
                            @endif
                            @if($extra_details["remove_packaging_pieces"] > 0 && $extra_details["remove_packaging_prices"] > 0)
                                <tr>
                                    <td style="width: 80%;">
                                        <div><strong>Remove Packaging</strong></div>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Quantity</strong></div> --}}
                                        <strong>{{ $extra_details["remove_packaging_pieces"] }}</strong>
                                    </td>
                                    <td>
                                        {{-- <div><strong>Price Per Piece</strong></div> --}}
                                        <strong>{{ "$".$extra_details["remove_packaging_pieces"]*$extra_details["remove_packaging_prices"] }}</strong>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                @endif
                @php
                    $art_fee            = ($extra_details["art_fee"]>0)?$extra_details["art_fee"]:0;
                    $art_discount       = ($extra_details["art_discount"]>0)?(int)$extra_details["art_discount"]:0;
                    $sub_total          += ((int)$extra_details["fold_bag_tag_pieces"] * (float)$extra_details["fold_bag_tag_prices"]);
                    $sub_total          += ((int)$extra_details["hang_tag_pieces"] * (float)$extra_details["hang_tag_prices"]);
                    $sub_total          += ((int)$extra_details["transfers_pieces"] * (float)$extra_details["transfers_prices"]);
                    $sub_total          += ((int)$extra_details["ink_color_change_pieces"] * (float)$extra_details["ink_color_change_prices"]);
                    $sub_total          += ($extra_details["shipping_charges"]>0)?$extra_details["shipping_charges"] * (float)$extra_details["shipping_pieces"]:0;
                    $sub_total          += ((int)$extra_details["label_pieces"] * (float)$extra_details["label_prices"]);
                    $sub_total          += ((int)$extra_details["fold_pieces"] * (float)$extra_details["fold_prices"]);
                    $sub_total          += ((int)$extra_details["foil_pieces"] * (float)$extra_details["foil_prices"]);
                    $sub_total          += ((int)$extra_details["palletizing_pieces"] * (float)$extra_details["palletizing_prices"]);
                    $sub_total          += ((int)$extra_details["remove_packaging_pieces"] * (float)$extra_details["remove_packaging_prices"]);
                    $sub_total          = ($sub_total+$art_fee)-($art_discount);
                    $tax                = (float)$extra_details["tax"];
                    $tax_percent        = ($sub_total/100)*$tax;
                    $grand_total        = $tax_percent+$sub_total;
                @endphp
            </div>
            <div class="row">
                <div class="col-sm-8">
                    {{-- <ul class="list-unstyled">
                        @if (count($color_per_locations) > 0)
                            @foreach ($color_per_locations as $p_name=>$color_per_location)
                            @foreach ($color_per_location as $selector_ref=>$location)
                            <li><strong style="padding-right: 24px;">{{$p_name}}</strong></li>
                                    @foreach ($location["location_number"] as $key=>$location_number)
                                        <li>
                                            <strong style="padding-right: 24px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$location_number}}</strong>{{$location["color_per_location"][$key]." colors"}}
                                        </li>
                                    @endforeach
                                @endforeach
                            @endforeach
                        @endif
                    </ul> --}}
                </div>
                <div class="col-sm-4">
                    <ul class="list-unstyled text-right">
                        <li><strong>Total Quantity: </strong> {{$client_details["projected_units"]}} </li>
                        <li><strong>Art: </strong> {{ "$".$art_fee}} </li>
                        <li><strong>Discount: </strong> {{ "$".$art_discount}} </li>
                        <li><strong>Sub Total:&nbsp;</strong>{{"$".number_format((float)$sub_total, 2, '.', ',')}}</li>
                        <li><strong>Sales Tax: </strong> {{ $extra_details["tax"]."%" }} </li>
                        <li><strong>Total:&nbsp;</strong>{{ "$".number_format((float)$grand_total, 2, '.', ',') }}</li>
                    </ul>
                </div>
            </div>
            @if(count($order_images) > 0)
            <div class="row">
                <div class="col-md-12">
                    <div class="form-row">
                        <div class="row imagess">
                            @foreach($order_images as $key=>$OrderImg)
                                <div class="col-md-6 photo mt-1">
                                    
                                    <a class="example-image-link" href="{{asset($OrderImg->image)}}" data-lightbox="example-1">
                                        <img src="{{asset($OrderImg->image)}}" class="img-rounded" alt="{{$OrderImg->order_id}}" style="object-fit: fill;" height="200px" width="300px">
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>
        <div class="card-footer">
            <button type="button" class="btn btn-lg btn-success mb-3 no-print" onclick='printDiv();' id="submit-form">
                <span class="fa fa-print">
                </span>
            </button>
            <a href="{{route("admin.order.generateInvoice", $extra_details["order_id"])}}?download_invoice=true" class="btn btn-md btn-info mb-3 no-print">Save</a>
            {{-- <a href="{{route("admin.order.generateInvoice", $extra_details["order_id"])}}?download_invoice=true" class="btn btn-md btn-info mb-3 no-print">Save</a> --}}
            <a class="btn btn-md btn-warning mb-3 no-print send-email-modal" href="#" data-client_id="{{$order->client_id}}" data-id="{{$order->id}}" data-email="{{$order->ClientSaleRep->email ?? ''}}"  data-sale_rep_name="{{$order->ClientSaleRep->first_name ?? ''}} {{$order->ClientSaleRep->last_name ?? ''}}" data-company_name="{{$order->client->company_name ?? ''}}" data-job_name="{{$order->job_name ?? ''}}" data-order_number="{{$order->order_number ?? ''}}"><i class="hvr-buzz-out far fa-envelope"></i> Send Email</a>
            <p class="footer-print">Art Charge $60 per hour (1 Hour Min.) Production time is 7-12 business days from receipt of all necessary components. 50% deposit required. NWG not responsible for damages to customer provided goods. Approval must be received before order goes into production.</p>
        </div>
    </div>
</div>
<div class="email-popup no-print">

</div>
@endsection 
@section('footer-script')
<script>
   function printDiv() 
    {
        setTimeout(function(){
            console.log('test');
            window.print();

        },200);
        if (!$("#sidebarCollapse").hasClass("open")) {
            $('#sidebarCollapse').click();
        }
    }    

    $(document).on('click', '.send-email-modal', function(e){
		e.preventDefault();
		$('.email-popup').empty();
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
				$('#send-email-modal').show();
			}
		});
	});
	$(document).on('click', '.copy-to-clipboard', function(e){
		e.preventDefault();
		var link = $(this).attr('data-link');
		var temp = $("<input>");
		$("body").append(temp);
		temp.val(link).select();
		document.execCommand("copy");
		temp.remove();
	});
	$(document).on('click', '.close-modal', function(e){
  		$(this).closest('.modal').hide();
	});
    $(document).ready(function (e) {
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$(document).submit("form#sendEmail", function(e) {
			e.preventDefault();
			var form 		= $("form#sendEmail");
			var formData = new FormData(form[0]);
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
                    $('#send-email-modal').show();
					$('.email-popup').empty();
				},
				error: function(data){
					console.log(data);
				}
			});
		});
	});
</script>
@endsection