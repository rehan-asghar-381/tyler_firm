<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
</head>
<body style="padding: 0;margin: 0;">
    <div style="width: 1200px;margin: 0 auto; padding: 10px; background-color: #fff;">
        <div>
            <img src="{{asset('assets/images/logo/logo.webp')}}" style="width: 150px;display: block;margin-left:525px;" alt="">
        </div>
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; font-family: 'Poppins', sans-serif;font-size: 14px;line-height: 22px;">
                    <span style="font-weight: 600;">Nu World Graphics, LLC.</span> <br>
                    1801 Western Ave.<br>
                    Las Vegas, NV. 89102<br>
                    Office: (702)671-0000<br>
                    Email: Tyler@NuWorldGraphicsLV.com<br>
                    Website: www.NuWorldGraphicsLV.com<br>
                </td>
                 <td style="width: 50%; font-family: 'Poppins', sans-serif;font-size: 14px;line-height: 22px;text-align: right;">
                    <span style="font-size: 30px; line-height: 50px;">Quote #{{ $client_details["invoice_number"]??"" }}</span> <br>
                    Date: {{ $client_details["date"] ?? "-" }} <br>
                    Client: {{ $client_details["company_name"] ?? "-" }} <br>
                    Job Name: {{ $client_details["job_name"] ?? "-" }} <br>
                    PO# {{ $client_details["order_number"] ?? "-" }} <br>
                    Email: {{ $client_details["email"] ?? "-" }} 
                </td>
            </tr>
        </table>
        <table style="width: 100%;margin-bottom: 10px;border-collapse: collapse;margin-bottom: 20px;">
            @php
                $sub_total                  = 0;
                $grand_total                = 0; 
                $tax_percent                = 0;
                $additional_services_flag   = 0;
                $flag   = (isset($invoice_details["adult_sizes"]))?1:0;
                $flag   += (isset($invoice_details["baby_sizes"]))?1:0;
                $initializer    = 0;
            @endphp
            @foreach ($invoice_details as $size=>$invoice)
                @if($size == "adult_sizes")
                <tr>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left; border-top: 1px solid #ccc;width: 45%;">Description</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">XS-XL</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">2XL</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">3XL</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">4XL</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">5XL</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">6XL</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">Quantity</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">Total Price</th>
                </tr>
                @elseif($size == "baby_sizes")
                <tr>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">Description</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">OSFA-18M</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">2T</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">3T</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">4T</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">5T</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">6T</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">Quantity</th>
                    <th style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;text-align: left;">Total Price</th>
                </tr>
                @endif
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
                            <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;">{{ $product_name }}</td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 400;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;">{{($fixed_sizes_qty>0)?$fixed_sizes_qty:""}}</td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 400;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;">{{ (isset($detail["2XL"]["pieces"]))?$detail["2XL"]["pieces"]:""}}
                                {{ (isset($detail["2T"]["pieces"]))?$detail["2T"]["pieces"]:""}}</td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 400;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;">{{ (isset($detail["3XL"]["pieces"]))?$detail["3XL"]["pieces"]:""}}
                                {{ (isset($detail["3T"]["pieces"]))?$detail["3T"]["pieces"]:""}}</td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 400;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;">{{ (isset($detail["4XL"]["pieces"]))?$detail["4XL"]["pieces"]:""}}
                                {{ (isset($detail["4T"]["pieces"]))?$detail["4T"]["pieces"]:""}}</td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 400;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;"> {{ (isset($detail["5XL"]["pieces"]))?$detail["5XL"]["pieces"]:""}}
                                {{ (isset($detail["5T"]["pieces"]))?$detail["5T"]["pieces"]:""}}</td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 400;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;">{{ (isset($detail["6XL"]["pieces"]))?$detail["6XL"]["pieces"]:""}}
                                {{ (isset($detail["6T"]["pieces"]))?$detail["6T"]["pieces"]:""}}</td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;">{{$total_qty}}</td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;border-top: 1px solid #ccc;">{{"$".$r_total}}</td>
                        </tr>
                        <tr>
                            <td style="font-size: 12px;font-weight: 400;font-family: 'Poppins', sans-serif;padding-bottom: 10px;">{{$color}} {{$fixed_sizes}}</td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 400;font-family: 'Poppins', sans-serif;padding-bottom: 10px;">{{($fixed_size_price>0)? "$".number_format($fixed_size_price, 2): ""}}</td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 400;font-family: 'Poppins', sans-serif;padding-bottom: 10px;">{{ (isset($detail["2XL"]["price"])) ? "$".$detail["2XL"]["price"] : ""}}
                                {{ (isset($detail["2T"]["price"])) ? "$".$detail["2T"]["price"] : ""}}</td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 400;font-family: 'Poppins', sans-serif;padding-bottom: 10px;">{{ (isset($detail["3XL"]["price"])) ? "$".$detail["3XL"]["price"] : ""}}
                                {{ (isset($detail["3T"]["price"])) ? "$".$detail["3T"]["price"] : ""}}</td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 400;font-family: 'Poppins', sans-serif;padding-bottom: 10px;">{{ (isset($detail["4XL"]["price"])) ? "$".$detail["4XL"]["price"] : ""}}
                                {{ (isset($detail["4T"]["price"])) ? "$".$detail["4T"]["price"] : ""}}</td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 400;font-family: 'Poppins', sans-serif;padding-bottom: 10px;">{{ (isset($detail["5XL"]["price"])) ? "$".$detail["5XL"]["price"] : ""}}
                                {{ (isset($detail["5T"]["price"])) ? "$".$detail["5T"]["price"] : ""}}</td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 400;font-family: 'Poppins', sans-serif;padding-bottom: 10px;">{{ (isset($detail["6XL"]["price"])) ? "$".$detail["6XL"]["price"] : ""}}
                                {{ (isset($detail["6T"]["price"])) ? "$".$detail["6T"]["price"] : ""}}</td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 400;font-family: 'Poppins', sans-serif;padding-bottom: 10px;"></td>
                            <td style="font-size: 14px;line-height:22px;font-weight: 400;font-family: 'Poppins', sans-serif;padding-bottom: 10px;"></td>
                        </tr>
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
            @if ($additional_services_flag == 1)
                <tr>
                    <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: center;border-top: 1px solid #ccc;" colspan="9">Additional Services</td>
                </tr>
            @endif
            @if($extra_details["ink_color_change_pieces"] > 0 && $extra_details["ink_color_change_prices"] > 0)
            <tr>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" colspan="7">Ink Color Change</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ $extra_details["ink_color_change_pieces"] }}</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ "$".$extra_details["ink_color_change_pieces"]*$extra_details["ink_color_change_prices"] }}</td>
            </tr>
            @endif
            @if($extra_details["shipping_pieces"] > 0 && $extra_details["shipping_charges"] > 0)
            <tr>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" colspan="7">Shipping 
                </td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ $extra_details["shipping_pieces"] }}</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" > {{ "$".$extra_details["shipping_pieces"]*$extra_details["shipping_charges"] }}</td>
            </tr>
            @endif
            @if($extra_details["label_pieces"] > 0 && $extra_details["label_prices"] > 0)
            <tr>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" colspan="7">Inside Labels</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ $extra_details["label_pieces"] }}</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ "$".$extra_details["label_pieces"]*$extra_details["label_prices"] }}</td>
            </tr>
            @endif
            @if($extra_details["fold_pieces"] > 0 && $extra_details["fold_prices"] > 0)
            <tr>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" colspan="7">Fold Only</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ $extra_details["fold_pieces"] }}</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ "$".$extra_details["fold_pieces"]*$extra_details["fold_prices"] }}</td>
            </tr>
            @endif
            @if($extra_details["fold_bag_pieces"] > 0 && $extra_details["fold_bag_prices"] > 0)
            <tr>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" colspan="7">Fold Bag Only</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ $extra_details["fold_bag_pieces"] }}</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ "$".$extra_details["fold_bag_pieces"]*$extra_details["fold_bag_prices"] }}</td>
            </tr>
            @endif
            @if($extra_details["fold_bag_tag_pieces"] > 0 && $extra_details["fold_bag_tag_prices"] > 0)
            <tr>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" colspan="7">Fold/Bag/Tag</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ $extra_details["fold_bag_tag_pieces"] }}</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ "$".$extra_details["fold_bag_tag_pieces"]*$extra_details["fold_bag_tag_prices"] }}</td>
            </tr>
            @endif
            @if($extra_details["hang_tag_pieces"] > 0 && $extra_details["hang_tag_prices"] > 0)
            <tr>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" colspan="7">Hang Tags</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ $extra_details["hang_tag_pieces"] }}</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ "$".$extra_details["hang_tag_pieces"]*$extra_details["hang_tag_prices"] }}</td>
            </tr>
            @endif
            @if($extra_details["foil_pieces"] > 0 && $extra_details["foil_prices"] > 0)
            <tr>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" colspan="7">Foil</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ $extra_details["foil_pieces"] }}</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ "$".$extra_details["foil_pieces"]*$extra_details["foil_prices"] }}</td>
            </tr>
            @endif
            @if($extra_details["transfers_pieces"] > 0 && $extra_details["transfers_prices"] > 0)
            <tr>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" colspan="7">Transfers</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ $extra_details["transfers_pieces"] }}</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ "$".$extra_details["transfers_pieces"]*$extra_details["transfers_prices"] }}</td>
            </tr>
            @endif
            @if($extra_details["palletizing_pieces"] > 0 && $extra_details["palletizing_prices"] > 0)
            <tr>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" colspan="7">Palletizing</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ $extra_details["palletizing_pieces"] }}</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ "$".$extra_details["palletizing_pieces"]*$extra_details["palletizing_prices"] }}</td>
            </tr>
            @endif
            @if($extra_details["remove_packaging_pieces"] > 0 && $extra_details["remove_packaging_prices"] > 0)
            <tr>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" colspan="7">Remove Packaging</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ $extra_details["remove_packaging_pieces"] }}</td>
                <td style="font-size: 14px;line-height:22px;font-weight: 600;font-family: 'Poppins', sans-serif;text-align: left;border-top: 1px solid #ccc;" >{{ "$".$extra_details["remove_packaging_pieces"]*$extra_details["remove_packaging_prices"] }}</td>
            </tr>
            @endif

        </table>
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
        <table style="width: 100%;margin-bottom: 10px;border-collapse: collapse;">
            <tr>
                @if (count($color_per_locations) > 0)
                    @foreach ($color_per_locations as $p_name=>$color_per_location)
                        <span style="font-weight: 300;font-family: 'Poppins';">{{$p_name}}</span> <br>
                        @foreach ($color_per_location["color_per_location"] as $key=>$location)
                        <span style="font-weight: 300;margin-left: 20px;font-family: 'Poppins';">{{$color_per_location["location_number"][$key]}} <small style="font-weight: normal !important;margin-left: 20px;font-family: 'Poppins';">{{$location." colors"}}</small></span><br>
                        @endforeach
                    @endforeach
                @endif
                
                <td style="width: 50%;font-size: 14px;line-height:22px;font-weight: 400;font-family: 'Poppins', sans-serif;text-align: right;">
                   <span style="font-weight: 600;">Total Quantity:</span>  {{$client_details["projected_units"]}} <br>
                   <span style="font-weight: 600;">Art:</span>  {{ "$".$art_fee}}    <br>
                   <span style="font-weight: 600;">Discount:</span>  {{ "$".$art_discount}} <br>
                   <span style="font-weight: 600;">Sub Total:</span> {{"$".number_format($sub_total)}} <br>
                   <span style="font-weight: 600;"> Sales Tax:</span> {{ $extra_details["tax"]."%" }} <br>
                   <span style="font-weight: 600;">Total:</span> {{ "$".number_format((float)$grand_total, 2, '.', ',') }} <br>
                </td>
            </tr>
        </table>
        @if(count($order_images) > 0)
        <div>
            @foreach($order_images as $key=>$OrderImg)
                <img src="{{asset($OrderImg->image)}}" style="display: inline-block;width: 250px;">
            @endforeach
        </div>
        @endif
        <p style="position: fixed;bottom: 0;text-align: center;">Art Charge $60 per hour (1 Hour Min.) Production time is 7-12 business days from receipt of all necessary components. 50% deposit required. NWG not responsible for damages to customer provided goods. Approval must be received before order goes into production.</p>
    </div>
</body>
</html>