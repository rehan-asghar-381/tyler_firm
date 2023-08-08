{{-- @extends("admin.template", ["pageTitle"=>$pageTitle]) --}}
{{-- @section('content') --}}

<div class="row">
    <div class="col-md-9">
        <div class="table-responsive">
            <table class="table">
               <thead class="thead-light">
                <th>{{$product_detail->name}} {{ " [".$product_detail->code."]" }}</th>
                <th></th>
            </thead>

        </table>
        <table class="table">
            <tr>

                <td style="border-top:none;"><b> Profit Margin </b></td>
                <td style="border-top:none;">{{$order_price['profit_margin_percentage'][0]}} %</td>
                <td style="border-top:none;"></td>
                <td style="border-top:none;"></td>
                <td style="border-top:none;"></td>
                <td style="border-top:none;"></td>
                <td style="border-top:none;"></td>
            </tr>

            <tr>
                <th></th>
                <th>
                    {{ ($type == "Baby Size")?"OSFA-18M":"XS-XL" }}
                    <input type="hidden" name="product_size[{{$product_detail->id}}][]" value="{{ ($type == "Baby Size")?"OSFA-18M":"XS-XL" }}">
                </th>
                <th>
                    {{ ($type == "Baby Size")? "2T":"2XL" }}
                    <input type="hidden" name="product_size[{{$product_detail->id}}][]" value="{{ ($type == "Baby Size")? "2T":"2XL" }}">
                </th>
                <th>
                    {{ ($type == "Baby Size")? "3T":"3XL" }}
                    <input type="hidden" name="product_size[{{$product_detail->id}}][]" value="{{ ($type == "Baby Size")? "3T":"3XL" }}">
                </th>
                <th>
                    {{ ($type == "Baby Size")? "4T":"4XL" }}
                    <input type="hidden" name="product_size[{{$product_detail->id}}][]" value="{{ ($type == "Baby Size")? "4T":"4XL" }}">
                </th>
                <th>
                    {{ ($type == "Baby Size")? "5T":"5XL" }}
                    <input type="hidden" name="product_size[{{$product_detail->id}}][]" value="{{ ($type == "Baby Size")? "5T":"5XL" }}">
                </th>
                <th>
                    {{ ($type == "Baby Size")? "6T":"6XL" }}
                    <input type="hidden" name="product_size[{{$product_detail->id}}][]" value="{{ ($type == "Baby Size")? "6T":"6XL" }}">
                </th>
            </tr>

            <tbody>
                <tr>
                    <th scope="row">Whole Sale Price</th>
                    <td>
                        {{$order_price["whole_sale"][0] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["whole_sale"][1] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["whole_sale"][2] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["whole_sale"][3] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["whole_sale"][4] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["whole_sale"][5] ?? ""}}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Print Price</th>
                    <td>
                        {{$order_price["print_price"][0] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["print_price"][1] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["print_price"][2] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["print_price"][3] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["print_price"][4] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["print_price"][5] ?? ""}}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Total Price</th>
                    <td>
                        {{$order_price["total_price"][0] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["total_price"][1] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["total_price"][2] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["total_price"][3] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["total_price"][4] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["total_price"][5] ?? ""}}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Profit Margin</th>
                    <td>
                        {{$order_price["profit_margin"][0] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["profit_margin"][1] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["profit_margin"][2] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["profit_margin"][3] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["profit_margin"][4] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["profit_margin"][5] ?? ""}}
                    </td>
                </tr>
                <tr>
                    <th scope="row">Final Price</th>
                    <td>
                        {{$order_price["final_price"][0] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["final_price"][1] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["final_price"][2] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["final_price"][3] ?? ""}}
                    </td>
                    <td>
                        {{$order_price["final_price"][4] ?? ""}}
                    </td>
                    <td>{{$order_price["final_price"][5] ?? ""}}</td>
                </tr>
            </tbody>

        </table>
    </div>
</div>
<div class="col-md-3" > 
{{-- style="margin-top: 10%;"> --}}
    <div class="table-responsive">
         <table class="table">
               <thead class="thead-light">
                <th>&nbsp;</th>
                <th>Color Per Location</th>
            </thead>
            <tbody>
                <tr><td>&nbsp; </td></tr>
            </tbody>
        </table>
        <table class="table">
            @if(count($order_color_location) > 0)
            <tbody>
                @foreach ($order_color_location as $k=>$item)
                <tr>
                    <th>{{$order_color_location_number[$k]}}</th>
                    <td>{{$item}}</td>
                </tr>
                @endforeach
            </tbody>
            @endif
        </table>
    </div>
</div>
</div>

{{-- @endsection --}}