<html lang="en">
    <head>
        <style>
            @page {
                margin: 30px 25px;
            }
        </style>
    </head>
    <body>
        <main>
            <div style="text-align: left;float:left">
                <strong>Nu World Graphics, LLC.</strong><br>
                1801 Western Ave.<br>
                Las Vegas, NV. 89102<br>
                Office: (702)671-0000<br>
                Email: Tyler@NuWorldGraphicsLV.com<br>
                Website: www.NuWorldGraphicsLV.com
            </div>
            <div style="text-align: right;">
                <strong>Invoice #{{ $client_details["invoice_number"]??"" }}</strong>
                <div>Date: {{ $client_details["date"] ?? "-" }}</div>
                <div>Client: {{ $client_details["company_name"] ?? "-" }}</div>
                <div>Job Name: {{ $client_details["job_name"] ?? "-" }}</div>
                <div>PO# {{ $client_details["order_number"] ?? "-" }}</div>
                <div>Email: {{ $client_details["email"] ?? "-" }}</div>
            </div>
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
            <table border="1" style="table-layout:fixed; width:100%;margin-top:20px !important;border-color:transparent;">
                <tr>
                    @if($size == "adult_sizes")
                    <th colspan="2"></th>
                    <th colspan="4" style="font-size:14px;">Description</th>
                    <th style="text-align: left;font-size:14px;">XS-XL</th>
                    <th style="text-align: left;font-size:14px;">2XL</th>
                    <th style="text-align: left;font-size:14px;">3XL</th>
                    <th style="text-align: left;font-size:14px;">4XL</th>
                    <th style="text-align: left;font-size:14px;">5XL</th>
                    <th style="text-align: left;font-size:14px;">6XL</th>
                    <th colspan="2" style="text-align: left;font-size:14px;">Quantity</th>
                    <th colspan="2" style="text-align: left;font-size:14px;">Total Price</th>
                    @elseif($size == "baby_sizes")
                    <th colspan="2"></th>
                    <th colspan="4" style="font-size:14px;">Description</th>
                    <th style="text-align: left;font-size:14px;">OSFA-18M</th>
                    <th style="text-align: left;font-size:14px;">2T</th>
                    <th style="text-align: left;font-size:14px;">3T</th>
                    <th style="text-align: left;font-size:14px;">4T</th>
                    <th style="text-align: left;font-size:14px;">5T</th>
                    <th style="text-align: left;font-size:14px;">6T</th>
                    <th colspan="2" style="text-align: left;font-size:14px;">Quantity</th>
                    <th colspan="2" style="text-align: left;font-size:14px;">Total Price</th>
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
                        <tr style="margin-top: 30px;">
                            <td colspan="2" style="font-size: 16px">
                                <div>Brand & Sizes</div>
                                <div>Garment Color</div>
                            </td>
                            <td colspan="4">
                                <div><strong style="font-size:14px;">{{ $product_name }}</strong></div>
                                <small>{{$color}} </small>
                                
                                <small>{{$fixed_sizes}}</small>
                            </td>
                            <td>
                                <div>{{($fixed_sizes_qty>0)?$fixed_sizes_qty:""}}</div>
                                <div>{{($fixed_size_price>0)? "$".$fixed_size_price: ""}}</div>
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
                            <td colspan="2">
                                <div><strong>{{$total_qty}}</strong></div>
                            </td>
                            <td colspan="2">
                                <div><strong>{{"$".$r_total}}</strong></div>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
                @if ($initializer == $flag)
                    <tr><td colspan="16" style="background-color: #dfdada;padding:5px;font-weight:bold;text-align:center;">Additional Services</td></tr>
                    @if($extra_details["fold_bag_tag_pieces"] > 0 && $extra_details["fold_bag_tag_prices"] > 0)
                    <tr>
                        <td colspan="12">
                            <div><strong>Fold/Bag/Tag</strong></div>
                        </td>
                        <td colspan="2">
                            <strong style="font-size: 16px;">{{ $extra_details["fold_bag_tag_pieces"] }}</strong>
                        </td>
                        <td colspan="2">
                            <strong style="font-size: 16px;">{{ $extra_details["fold_bag_tag_pieces"]*$extra_details["fold_bag_tag_prices"] }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <div><strong>Transfers</strong></div>
                        </td>
                        <td colspan="2">
                            <strong style="font-size: 16px;">{{ $extra_details["transfers_pieces"] }}</strong>
                        </td>
                        <td colspan="2">
                            <strong style="font-size: 16px;">{{ $extra_details["transfers_pieces"]*$extra_details["transfers_prices"] }}</strong>
                        </td>
                    </tr>
                    @endif
                    <tr>
                    </tr>
                    @if($extra_details["fold_bag_tag_pieces"] > 0 && $extra_details["fold_bag_tag_prices"] > 0)
                    <tr>
                        <td  colspan="12">
                            <div><strong>Hang Tags</strong></div>
                        </td>
                        <td  colspan="2">
                            <strong style="font-size: 16px;">{{ $extra_details["hang_tag_pieces"] }}</strong>
                        </td>
                        <td  colspan="2">
                            <strong style="font-size: 16px;">{{ $extra_details["hang_tag_pieces"]*$extra_details["hang_tag_prices"] }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="12">
                            <div><strong>Ink Color Change</strong></div>
                        </td>
                        <td  colspan="2">
                            <strong style="font-size: 16px;">{{ $extra_details["transfers_prices"] }}</strong>
                        </td>
                        <td  colspan="2">
                            <strong style="font-size: 16px;">{{ $extra_details["transfers_prices"]*$extra_details["transfers_prices"] }}</strong>
                        </td>
                    </tr>
                    @endif
                @endif
            </table> 
            @endforeach
            @php
                $shipping_charges   = ($extra_details["shipping_charges"]>0)?$extra_details["shipping_charges"]:0;
                $art_fee            = ($extra_details["art_fee"]>0)?$extra_details["art_fee"]:0;
                $art_discount       = ($extra_details["art_discount"]>0)?(int)$extra_details["art_discount"]:0;
                $sub_total          += ((int)$extra_details["fold_bag_tag_pieces"] * (float)$extra_details["fold_bag_tag_prices"]);
                $sub_total          += ((int)$extra_details["hang_tag_pieces"] * (float)$extra_details["hang_tag_prices"]);
                $sub_total          += ((int)$extra_details["transfers_pieces"] * (float)$extra_details["transfers_prices"]);
                $sub_total          += ((int)$extra_details["ink_color_change_pieces"] * (float)$extra_details["ink_color_change_prices"]);
                $sub_total          = ($sub_total+$shipping_charges+$art_fee)-($art_discount);
                $tax                = (float)$extra_details["tax"];
                $tax_percent        = ($sub_total/100)*$tax;
                $grand_total        = $tax_percent+$sub_total;
            @endphp
            <div style="width: 100%;float:left;">
                <div style="width: 50%; float:left;">
                    <ul style="list-style: none;margin:0px !important; padding:0px !important;width:50%;margin-top:20px !important;">
                        @if (count($color_per_locations) > 0)
                            @foreach ($color_per_locations as $p_name=>$color_per_location)
                            <li><strong style="padding-right: 24px;font-size:14px;">{{$p_name}}</strong></li>
                                @foreach ($color_per_location["color_per_location"] as $key=>$location)
                                <li><strong style="padding-right: 24px;font-size:14px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$color_per_location["location_number"][$key]}}</strong>{{$location." colors"}}</li>
                                @endforeach
                            @endforeach
                        @endif
                    </ul>
                </div>
                <div>
                    <ul style="list-style: none;text-align:right;">
                        <li><strong style="font-size:14px;">Total Quantity: </strong> {{$client_details["projected_units"]}} </li>
                        <li><strong style="font-size:14px;">Art:</strong> {{"$".$art_fee}} </li>
                        <li><strong style="font-size:14px;">Discount:</strong> {{"$".$art_discount}} </li>
                        <li><strong style="font-size:14px;">Shipping:</strong> {{"$".$shipping_charges}} </li>
                        <li><strong style="font-size:14px;">Sub Total:</strong>{{"$".$sub_total}}</li>
                        <li><strong style="font-size:14px;">Sales Tax:</strong> {{ $extra_details["tax"]."%" }} </li>
                        <li><strong style="font-size:14px;">Total:</strong>{{ "$".number_format((float)$grand_total, 2, '.', '') }}</li>
                    </ul>
                </div>
            </div>
        </main>
    </body>
</html>