<!DOCTYPE html>
<html>
<head>
    <title></title>
     <style media="print">
        @page {
            size: auto !important;
            margin: 0 !important;
        }
    </style>
</head>
<body>
    <div id='DivIdToPrint'>

     <table width="100%"  style=" bborder-collapse:collapse;" bborder='1'   >
        <tr >
            <th  class="font-weight-600 text-center" style="background: #d3d3d3;" colspan="10"><b>Tyler</b></th>
        </tr>

    </thead>
    <tbody>
        <tr >
            <th  colspan="" rowspan="" headers="" scope=""> PRINT CREW</th>
            <th  colspan="" rowspan="" headers="" scope=""> Goods REC'D</th>
            <th  colspan="" rowspan="" headers="" scope=""> ORDER DATE</th>
            <th  colspan="2" rowspan="" headers="" scope=""> TOTAL # OF BOXES</th>

        </tr>

        <tr >

            <td style=" text-align: center;" colspan="" rowspan="" headers="">{{$order_d_yellow->print_crew ?? ""}}</td>
            <td style=" text-align: center;" colspan="" rowspan="" headers="">{{$order_d_yellow->goods_rec ?? ""}}</td>
            <td style=" text-align: center;" colspan="" rowspan="" headers="">{{date("m/d/Y", $order->time_id)}}</td>
            <td style=" text-align: center;" colspan="" rowspan="" headers="">{{$order_d_yellow->boxes ?? ""}}</td>

            <td style=" text-align: center;" rowspan="5">
               <table width="100%"   bborder="1" style=" bborder-collapse:collapse; bborder-top: none;bborder-left: none;none;bborder-right: none;"  class="table table-bbordered">

                <tr >
                    <th   scope="col" colspan="2">Ship To</th>
                </tr>
            </thead>
            <tbody>
                <tr >
                    <th style=" text-align: center; " scope="row">Name</th>
                    <td style=" text-align: center;">{{$client_details["company_name"]}}</td>
                </tr>
                <tr >
                    <th  style=" text-align: center; "  scope="row">Company</th>
                    <td style=" text-align: center;">{{$client_details["company_name"]}}</td>
                </tr>
                <tr >
                    <th   style=" text-align: center; " scope="row">Address</th>
                    <td style=" text-align: center; ">{{$client_details["address"]}}</td>
                </tr>
            </tbody>
        </table>
    </td>
    <tr >
        <th  colspan="" rowspan="" headers="" scope="">PRODUCTION SAMPLE</th>
        <th  colspan="3" rowspan="" headers="" scope=""> EVENT</th>

    </tr>
    <tr >
        <td style=" text-align: center;" colspan="" rowspan="" headers="">{{$order_d_yellow->production_sample ?? ""}}</td>
        <td style=" text-align: center;" colspan="3" rowspan="" headers="">{{$order->event ?? ""}}</td>

    </tr>

</tbody>
</table>
</td>
</tr>
</tbody>



</table>
<table width="100%"  style=" bborder-collapse:collapse; bborder-top:none" bborder='1' class="table table-bbordered ">

    <tr >
        <th  class="font-weight-600 text-center" style="background: #d3d3d3; bborder:none" colspan="11"><b>Customer</b></th>
    </tr>
</thead>
<tbody>
    <tr >
        <th  colspan="" rowspan="" headers="" scope="">CUSTOMER</th>
        <th  colspan="" rowspan="" headers="" scope=""> P.O #</th>
        <th  colspan="" rowspan="" headers="" scope=""> SHIP DATE</th>
        <th  colspan="" rowspan="" headers="" scope=""> OTHER INFO</th>
        <th  colspan="2" rowspan="" headers="" scope="" > PALLETIZE</th>

    </tr>
    <tr >
        <td style=" text-align: center;">{{$client_details["company_name"]}}</td>
        <td style=" text-align: center;">{{$order->order_number}}</td>
        <td style=" text-align: center;">{{date("m-d-Y", $order->ship_date)}}</td>
        <td style=" text-align: center;">{{$client_details["sales_rep"]}}</td>
        <td style=" text-align: center;">{{$order_d_yellow->palletize ?? ""}}</td>
        <td style=" text-align: center;">{{$order_d_yellow->palletize_opt?? ""}}</td>
    </tr>

    <tr >
        <th >IN HANDS</th>
        <th >DESIGN</th>
        <th >SHIP</th>
        <th >ACCNT</th>
        <th colspan="2">DATE SHIPPED</th>
    </tr>
    <tr >
        <td style=" text-align: center;">{{$order_d_yellow->in_hands ?? ""}} </td>
        <td style=" text-align: center;">{{$order_d_yellow->design ?? ""}}</td>
        <td style=" text-align: center;">{{$order_d_yellow->ship ?? ""}}</td>
        <td  style=" text-align: center;" colspan="" rowspan="" headers=""> {{$order_d_yellow->acct ?? ""}}</td>
        <td colspan="2" style=" text-align: center;">{{$order->ship_date > 0  ?  date("m-d-Y", $order->ship_date) : "-"}}</td>
    </tr>
</tbody>

</table>

@if(count($order_d_yellow_inks) > 0)
{{-- @if(false) --}}


<table width="100%"  style=" bborder-collapse:collapse;bborder-top: none;"  bborder='1'  class="table table-bbordered ">


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
    @endforeach

    @foreach ($order_d_yellow_inks as $order_d_yellow_ink)

    <tr >
     <td style=" text-align: center;">{{$order_d_yellow_ink->location_number}}</td>                        
     <td style=" text-align: center;">{{$order_d_yellow_ink->color_per_location}}</td>
     @if($loop->first )
     <td style=" text-align: center;" rowspan="6">
       <table width="100%" bborder="1" style=" bborder-collapse:collapse; bborder-top: none;bborder-left: none; bborder-right: none;" class="table table-bbordered">

        <tr  class="t-header">
            @foreach ($table_header_arr as $kk=>$name)
            <th  colspan="1" class="{{$kk}}">{{$name}}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>


        <tr >

            @foreach ($table_header_arr as $kk=>$name)
            <td style=" text-align: center;" colspan="1" style="font-size: 12px;font-weight: bold;">INK COLORS</td>
            @endforeach
        </tr>
        <tr >
            @foreach ($keys_arr as $column_key)
            @php
            $index= 0;
            @endphp
            <td style=" text-align: center;" colspan="1" class="{{$column_key}}" style="padding:0px;">{{$table_body_arr[$column_key]['"'.$index.'"']}}</td>
            @endforeach

        </tr>
        <tr >
            @foreach ($keys_arr as $column_key)
            @php
            $index= 1;
            @endphp
            <td style=" text-align: center;" colspan="1" class="{{$column_key}}" style="padding:0px;">{{$table_body_arr[$column_key]['"'.$index.'"']}}</td>
            @endforeach
        </tr>
        <tr >
            @foreach ($keys_arr as $column_key)
            @php
            $index= 2;
            @endphp
            <td style=" text-align: center;" colspan="1" class="{{$column_key}}" style="padding:0px;">{{$table_body_arr[$column_key]['"'.$index.'"']}}</td>
            @endforeach
        </tr>
        <tr >
            @foreach ($keys_arr as $column_key)
            @php
            $index= 3;
            @endphp
            <td style=" text-align: center;" colspan="1" class="{{$column_key}}" style="padding:0px;">{{$table_body_arr[$column_key]['"'.$index.'"']}}</td>
            @endforeach
        </tr>
        <tr >
            @foreach ($keys_arr as $column_key)
            @php
            $index= 4;
            @endphp
            <td style=" text-align: center;" colspan="1" class="{{$column_key}}" style="padding:0px;">{{$table_body_arr[$column_key]['"'.$index.'"']}}</td>
            @endforeach
        </tr>
        <tr >
            @foreach ($keys_arr as $column_key)
            @php
            $index= 5;
            @endphp
            <td style=" text-align: center;" colspan="1" class="{{$column_key}}" style="padding:0px;">{{$table_body_arr[$column_key]['"'.$index.'"']}}</td>
            @endforeach
        </tr>
        <tr >
            @foreach ($keys_arr as $column_key)
            @php
            $index= 6;
            @endphp
            <td style=" text-align: center;" colspan="1" class="{{$column_key}}" style="padding:0px;">{{$table_body_arr[$column_key]['"'.$index.'"']}}</td>
            @endforeach
        </tr>
        <tr >
            @foreach ($keys_arr as $column_key)
            @php
            $index= 7;
            @endphp
            <td style=" text-align: center;" colspan="1" class="{{$column_key}}" style="padding:0px;">{{$table_body_arr[$column_key]['"'.$index.'"']}}</td>
            @endforeach
        </tr>
    </tbody>
</table>
</td>
@endif

</tr>

@endforeach




</table>


@else
<div class="row">
    <div class="col-md-4">
        <div class="form-row">
            <div class="p-print-location">

                <div class="form-group row print-location">
                    <div class="col-sm-5">
                        <select class="form-control location-name" name="location_number[1][]" data-column="1">
                            <option value="">select</option>
                            @foreach ($print_locations as $print_location)
                            <option value="{{$print_location->name}}" @if($print_location->name == "Full Back") {{"selected"}} @endif>{{$print_location->abbr}}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <table width="100%"  style=" bborder-collapse:collapse;" bborder='1' class="table table-nowrap dynamic-table" >

        <tr  class="t-header">
            <th  colspan="1" class="1">Full Back</th>
        </tr>
    </thead>
    <tbody class="t-body">
        <tr >
            <td style=" text-align: center;" colspan="1" style="font-size: 12px;font-weight: bold;">INK COLORS</td>
        </tr>
        <tr >
            <td style=" text-align: center;" colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="bborder-radius: 0 !important;"></td>
        </tr>
        <tr >
            <td style=" text-align: center;" colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="bborder-radius: 0 !important;"></td>
        </tr>
        <tr >
            <td style=" text-align: center;" colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="bborder-radius: 0 !important;"></td>
        </tr>
        <tr >
            <td style=" text-align: center;" colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="bborder-radius: 0 !important;"></td>
        </tr>
        <tr >
            <td style=" text-align: center;" colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="bborder-radius: 0 !important;"></td>
        </tr>
        <tr >
            <td style=" text-align: center;" colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="bborder-radius: 0 !important;"></td>
        </tr>
        <tr >
            <td style=" text-align: center;" colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="bborder-radius: 0 !important;"></td>
        </tr>
        <tr >
            <td style=" text-align: center;" colspan="1" class="1" style="padding:0px;"><input type="text" name="ink_color[1][]" class="form-control" value="" style="bborder-radius: 0 !important;"></td>
        </tr>
    </tbody>
</table>

</div>
@endif
<table width="100%"  style=" bborder-collapse:collapse; bborder-top: none;" bborder='1' class="table table-bbordered">

    <tr >
        <th    colspan="3">Film Number</th>
        <td colspan="" rowspan="5" headers="">
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
            <table width="100%"  style=" bborder-collapse:collapse;bborder-top: none;bborder-left: none;" bborder='1' class="table table-nowrap" >

                <tr >
                    @if($size == "adult_sizes")
                    <th colspan="2" style="bborder-left: none;" >Description</th>
                    <th >XS-XL</th>
                    <th >2XL</th>
                    <th >3XL</th>
                    <th >4XL</th>
                    <th >5XL</th>
                    <th >6XL</th>
                    @elseif($size == "baby_sizes")
                    
                    <th colspan="2" >Description</th>
                    <th >OSFA-18M</th>
                    <th >2T</th>
                    <th >3T</th>
                    <th >4T</th>
                    <th >5T</th>
                    <th >6T</th>
                    @endif
                </tr>
           
            
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
                <tr style="bborder: 1px solid gray;">
                    <td style=" text-align: center;">
                        <div><strong>Brand & Sizes</strong></div>
                        <div><strong>Garment Color</strong></div>
                    </td>
                    <td style=" text-align: center;">
                        <div><strong>{{ $product_name }}</strong></div>
                        <small>{{$color}} </small>

                        <small>{{$fixed_sizes}}</small>
                    </td>
                    <td style=" text-align: center;">
                        <div>{{($fixed_sizes_qty>0)?$fixed_sizes_qty:""}}</div>
                    </td>
                    <td style=" text-align: center;">
                        <div>
                            {{ (isset($detail["2XL"]["pieces"]))?$detail["2XL"]["pieces"]:""}}
                        </div>
                        <div>
                            {{ (isset($detail["2XL"]["price"])) ? "$".$detail["2XL"]["price"] : ""}}
                        </div>
                    </td>
                    <td style=" text-align: center;">
                        <div>
                            {{ (isset($detail["3XL"]["pieces"]))?$detail["3XL"]["pieces"]:""}}
                        </div>
                        <div>
                            {{ (isset($detail["3XL"]["price"])) ? "$".$detail["3XL"]["price"] : ""}}
                        </div>
                    </td>
                    <td style=" text-align: center;">
                        <div>
                            {{ (isset($detail["4XL"]["pieces"]))?$detail["4XL"]["pieces"]:""}}
                        </div>
                        <div>
                            {{ (isset($detail["4XL"]["price"])) ? "$".$detail["4XL"]["price"] : ""}}
                        </div>
                    </td>
                    <td style=" text-align: center;">
                        <div>
                            {{ (isset($detail["5XL"]["pieces"]))?$detail["5XL"]["pieces"]:""}}
                        </div>
                        <div>
                            {{ (isset($detail["5XL"]["price"])) ? "$".$detail["5XL"]["price"] : ""}}
                        </div>
                    </td>
                    <td style=" text-align: center;">
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
            
        </table>
        @endforeach
    </td>
</tr>


    <tr >
        <th  scope="row">Alpha#</th>
        <td style=" text-align: center;">{{$order_d_yellow->alpha ?? ""}}</td>
    </tr>
    <tr >
        <th  scope="row">S&S#</th>
        <td style=" text-align: center;">{{$order_d_yellow->s_and_s ?? ""}}</td>
    </tr>
    <tr >
        <th  scope="row">SANMAR#</th>
        <td style=" text-align: center;">{{$order_d_yellow->sanmar ?? ""}}</td>
    </tr>
</table>




<table width="100%"  style=" bborder-collapse:collapse; bborder-top: none;" bborder='1' class="table table-nowrap" >
    <tr >
        <th  colspan="5">Total</th>

    </tr>
    <tr >
       
        <td  colspan="5" style=" text-align: center;">{{$client_details["projected_units"]}}</td>
    </tr>
    <tr >
        <th  colspan="4" style="text-align: center;padding-left: 143px;">Any Rejects OR Shortages</th>
        <td colspan="4" style=" text-align: center;" colspan="" rowspan="" headers="">{{$order_d_yellow->is_rejected}}</td>
    </tr>
    <tr >
        <th  colspan="2">Notes</th>
        <td  colspan="2" style=" text-align: center;">{{$order_d_yellow->notes ?? ""}}</td>
    </tr>
</table>         

</div>            
<script src="{{asset('/b/plugins/jQuery/jquery-3.4.1.min.js')}}" type="text/javascript" charset="utf-8" async defer></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
<script>
  $(document).ready(function($) {
      printDiv();
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
</body>

</html>
