<div class="container-fluid mt-3" >
    <div class="row --print-and-location-row-{{$selector_number}}">
        <div class="col-md-12  product-detail rh-product-detail-{{$product_detail->id}} product-detail-{{$product_detail->id}} slector-number-{{$selector_number}}" id="product-detail-{{$product_detail->id}}">
            <div class="card card_product_order mb-1 mt-1">
                <input type="hidden" class="product-type" value="{{$type}}">
                <input type="hidden" class="location-count" value="@if(count($order_color_location)>0){{count($order_color_location)}}@else{{"1"}}@endif">
                <div class="card-header collapse-href collapsed" data-toggle="collapse" href="#collapse-{{$selector_number}}" style="background-color: #eee;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0">{{$product_detail->name}}</p>
                        </div>
                        <div class="text-right">
                            <div class="actions">
                                <p class="action-item" style="margin-right:70px;">Color Per Location</p>
                                <p class="action-item"><i class="fa fa-angle-down"></i></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="collapse-{{$selector_number}}" class="card-body collapse-id collapse" data-parent="#accordion" >
                    <div class="row" style="margin-bottom:40px;">
                        <div class="col-md-4">
                            <label class="font-weight-600">Profit Margin</label>
                            <select name="profit_margin_percentage[{{$product_detail->id}}][{{$terminator}}][]" class="my-form-control profit-margin --update-name" data-product-id="{{$product_detail->id}}" data-selector="{{$terminator}}">
                                <option value="0">No Markup</option>
                                @for ($i = 18; $i <=100; $i++)
                                <option value="{{$i}}" @if(isset($order_price['profit_margin_percentage'][0]) && $order_price['profit_margin_percentage'][0] ==$i ) {{"selected"}} @endif>{{$i}} %</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>
                                                {{ ($type == "Baby Size")?"OSFA-18M":"XS-XL" }}
                                                <input type="hidden" class="--update-name" name="product_size[{{$product_detail->id}}][{{$terminator}}][]" value="{{ ($type == "Baby Size")?"OSFA-18M":"XS-XL" }}">
                                            </th>
                                            <th>
                                                {{ ($type == "Baby Size")? "2T":"2XL" }}
                                                <input type="hidden" class="--update-name" name="product_size[{{$product_detail->id}}][{{$terminator}}][]" value="{{ ($type == "Baby Size")? "2T":"2XL" }}">
                                            </th>
                                            <th>
                                                {{ ($type == "Baby Size")? "3T":"3XL" }}
                                                <input type="hidden" class="--update-name" name="product_size[{{$product_detail->id}}][{{$terminator}}][]" value="{{ ($type == "Baby Size")? "3T":"3XL" }}">
                                            </th>
                                            <th>
                                                {{ ($type == "Baby Size")? "4T":"4XL" }}
                                                <input type="hidden" class="--update-name" name="product_size[{{$product_detail->id}}][{{$terminator}}][]" value="{{ ($type == "Baby Size")? "4T":"4XL" }}">
                                            </th>
                                            <th>
                                                {{ ($type == "Baby Size")? "5T":"5XL" }}
                                                <input type="hidden" class="--update-name" name="product_size[{{$product_detail->id}}][{{$terminator}}][]" value="{{ ($type == "Baby Size")? "5T":"5XL" }}">
                                            </th>
                                            <th>
                                                {{ ($type == "Baby Size")? "6T":"6XL" }}
                                                <input type="hidden" class="--update-name" name="product_size[{{$product_detail->id}}][{{$terminator}}][]" value="{{ ($type == "Baby Size")? "6T":"6XL" }}">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Whole Sale Price</th>
                                            <td>
                                                <input type="number" class="my-form-control whole-sale-1 --update-name" id="{{ ($type == "Baby Size")?"OSFA-18M-":"XS-XL-" }}{{$product_detail->id}}" name="wholesale_price[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["whole_sale"][0] ?? ""}}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control whole-sale-2 --update-name" id="{{ ($type == "Baby Size")?"2T-":"2XL-" }}{{$product_detail->id}}" value="{{$order_price["whole_sale"][1] ?? ""}}" name="wholesale_price[{{$product_detail->id}}][{{$terminator}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control whole-sale-3 --update-name" id="{{ ($type == "Baby Size")?"3T-":"3XL-" }}{{$product_detail->id}}" value="{{$order_price["whole_sale"][2] ?? ""}}" name="wholesale_price[{{$product_detail->id}}][{{$terminator}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control whole-sale-4 --update-name" id="{{ ($type == "Baby Size")?"4T-":"4XL-" }}{{$product_detail->id}}" value="{{$order_price["whole_sale"][3] ?? ""}}" name="wholesale_price[{{$product_detail->id}}][{{$terminator}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control whole-sale-5 --update-name" id="{{ ($type == "Baby Size")?"5T-":"5XL-" }}{{$product_detail->id}}" value="{{$order_price["whole_sale"][4] ?? ""}}" name="wholesale_price[{{$product_detail->id}}][{{$terminator}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control whole-sale-6 --update-name" id="{{ ($type == "Baby Size")?"6T-":"6XL-" }}{{$product_detail->id}}" value="{{$order_price["whole_sale"][5] ?? ""}}" name="wholesale_price[{{$product_detail->id}}][{{$terminator}}][]"  readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Print Price</th>
                                            <td>
                                                <input type="number" class="my-form-control location-1 print_locations --update-name" name="print_price[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["print_price"][0] ?? ""}}"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control location-2 print_locations --update-name" name="print_price[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["print_price"][1] ?? ""}}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control location-3 print_locations --update-name" name="print_price[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["print_price"][2] ?? ""}}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control location-4 print_locations --update-name" name="print_price[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["print_price"][3] ?? ""}}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control location-5 print_locations --update-name" name="print_price[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["print_price"][4] ?? ""}}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control location-6 print_locations --update-name" name="print_price[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["print_price"][5] ?? ""}}" readonly>
                                            </td>
                                        </tr>
                                        <tr>    
                                            <th scope="row">Total Price</th>
                                            <td>
                                                <input type="number" class="my-form-control total-1 --update-name" name="total_price[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["total_price"][0] ?? ""}}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control total-2 --update-name" name="total_price[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["total_price"][1] ?? ""}}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control total-3 --update-name" name="total_price[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["total_price"][2] ?? ""}}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control total-4 --update-name" name="total_price[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["total_price"][3] ?? ""}}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control total-5 --update-name" name="total_price[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["total_price"][4] ?? ""}}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control total-6 --update-name" name="total_price[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["total_price"][5] ?? ""}}" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Profit Margin</th>
                                            <td>
                                                <input type="number" class="my-form-control margin-1 --update-name" name="profit_margin[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["profit_margin"][0] ?? ""}}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control margin-2 --update-name" name="profit_margin[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["profit_margin"][1] ?? ""}}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control margin-3 --update-name" name="profit_margin[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["profit_margin"][2] ?? ""}}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control margin-4 --update-name" name="profit_margin[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["profit_margin"][3] ?? ""}}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control margin-5 --update-name" name="profit_margin[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["profit_margin"][4] ?? ""}}" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control margin-6 --update-name" name="profit_margin[{{$product_detail->id}}][{{$terminator}}][]" value="{{$order_price["profit_margin"][5] ?? ""}}" readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Final Price</th>
                                            <td>
                                                <input type="number" class="my-form-control final-price-1 --update-name" name="final_price[{{$product_detail->id}}][{{$terminator}}][]"  value="{{$order_price["final_price"][0] ?? ""}}" >
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control final-price-2 --update-name" name="final_price[{{$product_detail->id}}][{{$terminator}}][]"  value="{{$order_price["final_price"][1] ?? ""}}" >
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control final-price-3 --update-name" name="final_price[{{$product_detail->id}}][{{$terminator}}][]"  value="{{$order_price["final_price"][2] ?? ""}}" >
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control final-price-4 --update-name" name="final_price[{{$product_detail->id}}][{{$terminator}}][]"  value="{{$order_price["final_price"][3] ?? ""}}" >
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control final-price-5 --update-name" name="final_price[{{$product_detail->id}}][{{$terminator}}][]"  value="{{$order_price["final_price"][4] ?? ""}}" >
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control final-price-6 --update-name" name="final_price[{{$product_detail->id}}][{{$terminator}}][]"  value="{{$order_price["final_price"][5] ?? ""}}" >
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-print-location-{{$product_detail->id}}">
                                @if(count($order_color_location) > 0)
                                @foreach ($order_color_location as $k=>$item)
                                <div class="form-group row print-location">
                                    <div class="col-sm-5">
                                        <select class="form-control --update-name" data-product-id="{{$product_detail->id}}" name="location_number[{{$product_detail->id}}][{{$terminator}}][]">
                                            <option value="">select</option>
                                            @foreach ($print_locations as $print_location)
                                                <option value="{{$print_location->name}}" @if($print_location->name == $order_color_location_number[$k]) {{"selected"}} @endif>{{$print_location->abbr}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <input class="form-control number-of-colors --update-name" data-product-id="{{$product_detail->id}}" name="color_per_location[{{$product_detail->id}}][{{$terminator}}][]" type="number" value="{{$item}}" data-selector="{{$terminator}}">
                                    </div>
                                    <div class="col-sm-1">
                                        <i type="submit" class="fas fa-plus add-p-location" style="color:green;cursor:pointer;"  style="max-width: 114px;max-height: 47px;margin-top: 25px;" data-id="{{$product_detail->id}}"></i>
                                    </div>
                                    <div class="col-sm-1">
                                        <i  class="fas fa-minus remove-p-location" style="color:red;cursor:pointer;" style="max-width: 114px;max-height: 47px;margin-top: 25px; margin-left: 5px;" data-id="{{$product_detail->id}}"></i>
                                    </div>
                                </div>
                                @endforeach
                                @else
                                <div class="form-group row print-location">
                                    <div class="col-sm-5">
                                        <select class="form-control --update-name" data-product-id="{{$product_detail->id}}" name="location_number[{{$product_detail->id}}][{{$terminator}}][]">
                                            <option value="">select</option>
                                            @foreach ($print_locations as $print_location)
                                                <option value="{{$print_location->name}}">{{$print_location->abbr}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <input class="form-control number-of-colors --update-name" data-product-id="{{$product_detail->id}}" name="color_per_location[{{$product_detail->id}}][{{$terminator}}][]" type="number" value="" data-selector="{{$terminator}}">
                                    </div>
                                    <div class="col-sm-1">
                                        <i type="submit" class="fas fa-plus add-p-location" style="color:green;cursor:pointer;"  style="max-width: 114px;max-height: 47px;margin-top: 25px;" data-id="{{$product_detail->id}}"></i>
                                    </div>
                                    <div class="col-sm-1">
                                        <i  class="fas fa-minus remove-p-location" style="color:red;cursor:pointer;" style="max-width: 114px;max-height: 47px;margin-top: 25px; margin-left: 5px;" data-id="{{$product_detail->id}}"></i>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div> 
                </div>
            </div>
        </div>
    </div>
</div>
</div>
