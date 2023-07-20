<div class="container-fluid mt-3" >
    <div class="row">
        <div class="col-md-12  product-detail rh-product-detail-{{$product_detail->id}} product-detail-{{$product_detail->id}}" id="product-detail-{{$product_detail->id}}">
            <div class="card card_product_order mb-4 mt-4">
                <input type="hidden" class="product-type" value="{{$type}}">
                <div class="card-header collapsed" data-toggle="collapse" href="#collapse-{{$product_detail->id}}" style="background-color: #eee;">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-0">{{$product_detail->name}} {{ " [".$product_detail->code."]" }}</p>
                        </div>
                        <div class="text-right">
                            <div class="actions">
                                <p class="action-item" style="margin-right:70px;">Color Per Location</p>
                                <p class="action-item"><i class="fa fa-angle-down"></i></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="collapse-{{$product_detail->id}}" class="card-body collapse" data-parent="#accordion" >
                    <div class="row" style="margin-bottom:40px;">
                        <div class="col-md-4">
                            <label class="font-weight-600">Profit Margin</label>
                            <select name="min_profit_margin" class="my-form-control profit-margin" data-product-id="{{$product_detail->id}}">
                                <option value="">Select Margin</option>
                                @for ($i = 1; $i <=100; $i++)
                                <option value="{{$i}}" >{{$i}} %</option>
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
                                            <th>{{ ($type == "Baby Size")?"OSFA-18M":"XS-XL" }}</th>
                                            <th>{{ ($type == "Baby Size")? "2T":"2XL" }}</th>
                                            <th>{{ ($type == "Baby Size")? "3T":"3XL" }}</th>
                                            <th>{{ ($type == "Baby Size")? "4T":"4XL" }}</th>
                                            <th>{{ ($type == "Baby Size")? "5T":"5XL" }}</th>
                                            <th>{{ ($type == "Baby Size")? "6T":"6XL" }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th scope="row">Whole Sale Price</th>
                                            <td>
                                                <input type="number" class="my-form-control whole-sale-1" id="{{ ($type == "Baby Size")?"OSFA-18M-":"XS-XL-" }}{{$product_detail->id}}" name="print_locations[{{$product_detail->id}}][]" readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control whole-sale-2" id="{{ ($type == "Baby Size")?"2T-":"2XL-" }}{{$product_detail->id}}" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control whole-sale-3" id="{{ ($type == "Baby Size")?"3T-":"3XL-" }}{{$product_detail->id}}" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control whole-sale-4" id="{{ ($type == "Baby Size")?"4T-":"4XL-" }}{{$product_detail->id}}" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control whole-sale-5" id="{{ ($type == "Baby Size")?"5T-":"5XL-" }}{{$product_detail->id}}" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control whole-sale-6" id="{{ ($type == "Baby Size")?"6T-":"6XL-" }}{{$product_detail->id}}" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Print Price</th>
                                            <td>
                                                <input type="number" class="my-form-control location-1 print_locations" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control location-2 print_locations" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control location-3 print_locations" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control location-4 print_locations" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control location-5 print_locations" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control location-6 print_locations" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                        </tr>
                                        <tr>    
                                            <th scope="row">Total Price</th>
                                            <td>
                                                <input type="number" class="my-form-control total-1" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control total-2" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control total-3" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control total-4" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control total-5" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control total-6" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Profit Margin</th>
                                            <td>
                                                <input type="number" class="my-form-control margin-1" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control margin-2" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control margin-3" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control margin-4" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control margin-5" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control margin-6" name="print_locations[{{$product_detail->id}}][]"  readonly>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th scope="row">Final Price</th>
                                            <td>
                                                <input type="number" class="my-form-control final-price-1" name="print_locations[{{$product_detail->id}}][]">
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control final-price-2" name="print_locations[{{$product_detail->id}}][]">
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control final-price-3" name="print_locations[{{$product_detail->id}}][]">
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control final-price-4" name="print_locations[{{$product_detail->id}}][]">
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control final-price-5" name="print_locations[{{$product_detail->id}}][]">
                                            </td>
                                            <td>
                                                <input type="number" class="my-form-control final-price-6" name="print_locations[{{$product_detail->id}}][]">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-print-location-{{$product_detail->id}}">
                                <div class="form-group row print-location">
                                    <label class="col-sm-2 font-weight-600">#1</label>
                                    <div class="col-sm-8">
                                        <input class="form-control number-of-colors" data-product-id="{{$product_detail->id}}" name="" type="number" value="">
                                    </div>
                                    <div class="col-sm-1">
                                        <i type="submit" class="fas fa-plus add-p-location" style="color:green;cursor:pointer;"  style="max-width: 114px;max-height: 47px;margin-top: 25px;" data-id="{{$product_detail->id}}"></i>
                                    </div>
                                    <div class="col-sm-1">
                                        <i  class="fas fa-minus remove-p-location" style="color:red;cursor:pointer;" style="max-width: 114px;max-height: 47px;margin-top: 25px; margin-left: 5px;" data-id="{{$product_detail->id}}"></i>
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
</div>
</div>
