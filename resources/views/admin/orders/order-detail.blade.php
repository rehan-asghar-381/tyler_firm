@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<div class="body-content">
    <div class="row">
        <div class="col-sm-12 col-xl-8">
            <div class="media d-flex m-1 ">
             <template>{{json_encode($fixed_sizes)}}</template>
             <template id="order_product_ids">{{json_encode($order_product_ids_arr)}}</template>
             <template id="all_adult_sizes">{{json_encode($all_adult_sizes)}}</template>
             <template id="fixed_baby_sizes">{{json_encode($fixed_baby_sizes)}}</template>
             <template id="all_baby_sizes">{{json_encode($all_baby_sizes)}}</template>
         </div>
     </div>
 </div>
 <div class="row">
    <div class="col-sm-12 col-xl-8">
        <div class="media d-flex m-1 ">
            @if(count($order->OrderImgs) > 0)
                @foreach($order->OrderImgs as $key=>$OrderImg)
                    <div class="align-left p-1">
                        <div class="zoom-box">
                            <img src="{{asset($OrderImg->image)}}" style="object-fit: cover;" width="200" height="150" data-zoom-image="{{asset($OrderImg->image)}}" class="img-zoom-m"/>
                            
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
 <div class="row">
    <div class="col-lg-3">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">Order Info</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Client</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ $order->client->company_name ?? "-" }}</a>
                    </div>
                </div> 
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Job  name</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ $order->job_name ?? "-" }}</a>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Projected Units</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ $order->projected_units ?? "-" }}</a>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Purchase Order#</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ $order->order_number ?? "-" }}</a>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Order Status</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ $order->Orderstatus->name ?? "-" }}</a>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Sales Rep</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ $order->sales_rep ?? "-" }}</a>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Event</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ $order->event ?? "-" }}</a>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Shipping Address</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ $order->shipping_address ?? "-" }}</a>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Due Date</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ date('Y-m-d h:i',$order->due_date) ?? "-" }}</a>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Ship Date</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ date('Y-m-d h:i',$order->ship_date) ?? "-" }}</a>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Created Date</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ date('Y-m-d h:i',$order->time_id) ?? "-" }}</a>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Notes</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ $order->notes ?? "-" }}</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">Garments</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row  btn-d-none">
                    <div class="table-responsive">
                        <table class="table">
                            @if(!empty($order->OrderProducts ))
                            @foreach($order->OrderProducts  as $product)
                            <thead class="thead-light">
                                <th>{{$product->product_name}} </th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </thead>

                            <tbody>
                                @if(count($product->OrderProductVariant) > 0)
                                @foreach ($product->OrderProductVariant as $order_product_variant)
                                @php
                                    if($order_product_variant->variant2_name     == "Adult_sizes Size"){
                                        $variant2_name    = "Adult Size";
                                    }
                                    if($order_product_variant->variant2_name     == "Baby_sizes Size"){
                                        $variant2_name    = "Baby Size";
                                    }
                                @endphp
                                @if($loop->first)
                                <tr>
                                    <th>{{$order_product_variant->variant1_name}}</th>
                                    <th>{{$variant2_name}}</th>
                                    <th>Pieces</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                </tr> 
                                @endif
                                <tr>
                                 <td>{{$order_product_variant->attribute1_name}}</td> 
                                 <td>{{$order_product_variant->attribute2_name}}</td> 
                                 <td>{{$order_product_variant->pieces}}</td> 
                                 <td>{{$order_product_variant->price}}</td> 
                                 <td>{{$order_product_variant->total}}</td> 
                             </tr>      

                             @endforeach
                             @endif
                         </tbody>
                         @endforeach
                         @endif
                     </table>
                 </div>
             </div>
         </div>
     </div>
     {{--  --}}
     <div class="card mt-2">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">Print Prices</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class=" Order-form btn-d-none">
                <div class=" product-print-locations btn-d-none">
                    <div id="accordion2" class="accordion2" style="min-height: 200px;">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card mt-2">
        <div class="card-body">
            <h5>Other Charges</h5>
            <div class="table-responsive">
                <table class="table">

                    <tr>
                        <th>FOLD/BAG/TAG Pieces </th>
                        <th>FOLD/BAG/TAG Prices</th>
                        <th>Hang Tag Pieces</th>
                        <th>Hang Tag  Prices</th>
                    </tr>
                    <tr>
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->fold_bag_tag_pieces : '' }}</td>
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->fold_bag_tag_prices : '' }}</td>
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->hang_tag_pieces : '' }}</td>
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->hang_tag_prices : '' }}</td>
                    </tr>
                    <tr>
                        <th>Art Fee</th>
                        <th>Art Discount</th>
                        <th>Art Time</th>
                        <th>Tax</th>
                    </tr>
                    <tr>
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->art_fee : '' }}</td>
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->art_discount : '' }}</td>
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->art_time : '' }}</td>
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->tax : '' }}</td>
                    </tr>
                    <tr>
                        <th>Transfers Pieces</th>
                        <th>Transfers Prices</th>
                        <th>Ink Color Change Pieces</th>
                        <th>Ink Color Change Prices</th>
                    </tr>
                    <tr>
                        <td>{{ isset($order->OrderTransfer) ? $order->OrderTransfer->transfers_pieces : ''}}</td>
                        <td>{{ isset($order->OrderTransfer) ? $order->OrderTransfer->transfers_prices : ''}}</td>
                        <td>{{ isset($order->OrderTransfer) ? $order->OrderTransfer->ink_color_change_pieces : ''}}</td>
                        <td>{{ isset($order->OrderTransfer) ? $order->OrderTransfer->ink_color_change_prices : ''}}</td>
                    </tr>
                    <tr>
                        <th>Shipping Charges</th>
                        <th></th>
                        <th></th>
                        <th></th>

                    </tr>
                    <tr>
                        <td>{{ isset($order->OrderTransfer) ? $order->OrderTransfer->shipping_charges : ''}}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@section('footer-script')
<script>
    $(document).ready(function(){
        var _order_id       = '{{$order->id}}';
        $('#product_ids').on('select2:unselect', function (e) {
            var p_id        = ".product-detail-"+e.params.data.id;
            $(p_id).remove();
        });
        
        let order_product_ids       = JSON.parse($("#order_product_ids").html());
        console.log("order_product_ids", order_product_ids);
        $.each(order_product_ids, function(index, product_id){
            accordian2_products(product_id, _order_id);
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
                        // $('select#sales_rep').trigger('change');
                    },
                    beforeSend: function() {
                        $('#preloader').show();
                    },
                    complete: function(){
                        $('#preloader').hide();
                    },
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
                }
            });

        });


        function accordian2_products(product_id="", order_id=""){

            if(product_id != ""){
                $.ajax({
                    url: "{{ route('admin.order.print_nd_loations_view') }}",
                    type: "GET",
                    data: {
                        product_id      : product_id,
                        order_id        : order_id
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
            accordian2_products(product_id);
        });
        var init                     = 1;
        $(document).on('click', '.add_product', function(event) {
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
            append_parent.append(new_product_add);
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
    $("#ProjectedUnits").val(projected_units);
    $("#ProjectedUnits").trigger("change");

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
        $("#ProjectedUnits").trigger("change");
    }

});

$(document).on("change", ".attribute", function(e){
    e.preventDefault();
    let size_selector           = "";
    let size_select             = "";
    let all_adult_sizes         = JSON.parse($("#all_adult_sizes").html());
    let adult_fixed_sizes       = JSON.parse($('template').html());
    let fixed_baby_sizes        = JSON.parse($("#fixed_baby_sizes").html());
    let all_baby_sizes          = JSON.parse($('#all_baby_sizes').html());
    let all_sizes               = [];
    let fixed_sizes             = [];
    var product_id              = $(this).attr('data-product_id');

    if($('.product-detail-'+product_id).find(".product-type").val() == "Baby Size"){
        all_sizes                   = all_baby_sizes;
        fixed_sizes                 = fixed_baby_sizes;
        size_select                 = "OSFA-18M-";
    }else{
        all_sizes                   = all_adult_sizes;
        fixed_sizes                 = adult_fixed_sizes;
        size_select                 = "XS-XL-";
    }
    var selector                = '.form-row';
    let type                    = "";
    let v1_attr_id              = $(this).closest(selector).find('.v1_attr_id').val();
    let v2_attr_id              = $(this).closest(selector).find('.v2_attr_id').val();
    let price_selector          = $(this).closest(selector).find('.price');

    if($('.product-detail-'+product_id).find(".product-type").val() == "Baby Size"){
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

                $('.product-detail-'+product_id).find(size_selector).val(result.price);
                resetPrices(product_id);
                calcTotal(product_id);
                calcMargin(product_id);
            }
        });
    }
});
function calcDecogrationPrice(product_id=0){
    var ProjectedUnits          = $('#ProjectedUnits').val();
    var color_locations_arr     = [];
    var product_div             = ".product-detail-"+product_id;
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
                calcTotal(product_id);
                calcMargin(product_id);
            }
        });
    } 
}
$(document).on("change", ".number-of-colors", function(){
    var product_id              = $(this).attr('data-product-id');
    calcDecogrationPrice(product_id);
});

function calcTotal(product_id=0){

    let whole_sale_price            = 0;
    let location_price              = 0;
    let total_price                 = 0;
    for(var i=1; i <=6; i++){

        let whole_sale_price         =  $('.product-detail-'+product_id).find(".whole-sale-"+i).val();
        let location_price           =  $('.product-detail-'+product_id).find(".location-"+i).val();

        whole_sale_price            = (whole_sale_price != "") ? whole_sale_price: 0;
        location_price              = (location_price != "")? location_price: 0;
        let total                   = (parseFloat(whole_sale_price)+ parseFloat(location_price)).toFixed(2);
        $($('.product-detail-'+product_id).find(".total-"+i)).val(total);
    }
} 
function resetPrices(product_id = 0){
    let size_selector               = "";
    let all_adult_sizes             = JSON.parse($("#all_adult_sizes").html());
    let adult_fixed_sizes           = JSON.parse($('template').html());
    let fixed_baby_sizes            = JSON.parse($("#fixed_baby_sizes").html());
    let all_baby_sizes              = JSON.parse($('#all_baby_sizes').html());
    let all_sizes                   = [];
    let fixed_sizes                 = [];
    let selected_sizes              = [];
    let flag                        = 0;
    let selector                    = $('.product-detail-'+product_id).find('.v2_attr_id');

    if($('.product-detail-'+product_id).find(".product-type").val() == "Baby Size"){
        all_sizes                   = all_baby_sizes;
        fixed_sizes                 = fixed_baby_sizes;
        size_selector               = "#OSFA-18M-";
    }else{
        all_sizes                   = all_adult_sizes;
        fixed_sizes                 = adult_fixed_sizes;
        size_selector               = "#S-XL-";
    }
    $(selector).each(function(indx, elm){
        selected_sizes.push($(this).find('option:selected').text());
    });

    $.each(fixed_sizes, function(index, element){
        if(jQuery.inArray(element, selected_sizes) != -1) {
            flag                    = 1;
        }
    });
    if(flag == 0){
        $('.product-detail-'+product_id).find(size_selector+product_id).val('');
    }
    $.each(all_sizes, function(index, element){
        if(jQuery.inArray(element, selected_sizes) != -1) {
                //do nothing
            }else{
                $('.product-detail-'+product_id).find("#"+element+"-"+product_id).val('');
            }
        });
} 

$(document).on("change", ".profit-margin", function(){
    let product_id          = $(this).attr('data-product-id');
    calcMargin(product_id);
});

function calcMargin(product_id= 0){

    let profit_margin               = $('.product-detail-'+product_id).find('.profit-margin').val();
    let total_selector              = ".total-";
    let profit_margin_selector      = ".margin-";
    let final_price_selector        = ".final-price-";
    if(profit_margin > 0){
        var diff = 100 - parseInt(profit_margin); 
        var diff2= diff / 100 ;

        for(var i=1; i <=6; i++){

            let total           = $('.product-detail-'+product_id).find(total_selector+i).val();
            let value           =  total / diff2; 
            $('.product-detail-'+product_id).find(profit_margin_selector+i).val(value.toFixed(2));   
            $('.product-detail-'+product_id).find(final_price_selector+i).val(value.toFixed(2));   
        }
    }
}

$(document).on("change","#ProjectedUnits", function(){
    let product_ids     = $("#product_ids").val();
    $.each(product_ids, function(index, element){

        resetPrices(element);
        calcDecogrationPrice(element);
        calcTotal(element);
        calcMargin(element);
    });

});
</script>
@endsection