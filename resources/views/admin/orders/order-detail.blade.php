@extends("admin.template", ["pageTitle"=>$pageTitle])
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
                            <a class="example-image-link" href="{{asset($OrderImg->image)}}" data-lightbox="example-1">
                                <img src="{{asset($OrderImg->image)}}" style="object-fit: cover;" width="200" height="150"/>
                            </a>
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
                        <a href="#!" class="fs-13 font-weight-600">{{ $sales_rep_name }}</a>
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
                        <h6 class="mb-0 font-weight-600">Ship Method</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ $order->ship_method ?? "-" }}</a>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Due Date</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ ($order->due_date > 0) ? date('m-d-Y',$order->due_date): "-" }}</a>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Ship Date</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ ($order->ship_date > 0) ? date('m-d-Y',$order->ship_date): "-" }}</a>
                    </div>
                </div>
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Created Date</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ ($order->time_id > 0) ? date('m-d-Y',$order->time_id): "-" }}</a>
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
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Internal Notes</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ $order->internal_notes ?? "-" }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">Profit Calculation</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">

                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Cost Of Goods</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ $cost_of_goods ?? 0 }}</a>
                    </div>
                </div> 
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Subtotal</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ $sub_total ?? 0 }}</a>
                    </div>
                </div> 
                <hr>
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600">Profit</h6>
                    </div>
                    <div class="col-auto">
                        <a href="#!" class="fs-13 font-weight-600">{{ ($sub_total-$cost_of_goods) }}</a>
                    </div>
                </div> 
                
            </div>
        </div>
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">Order Documents</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col">
                        <h6 class="mb-0 font-weight-600"><i class="far fa fa-paperclip"></i> Order Docs</h6>
                    </div>
                    <div class="col-auto">
                        <a class="btn btn-primary --open-doc-popup" data-id="{{ $order->id }}" href="#"> View  </a>
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
                                @if ($order_product_variant->pieces > 0)
                                    
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
                                @endif

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
            <h5>Additional Services</h5>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        @if (isset($order->OrderTransfer) && $order->OrderTransfer->ink_color_change_pieces != '')
                            <th>Ink Color Change Pieces</th>
                        @endif
                        @if (isset($order->OrderTransfer) && $order->OrderTransfer->ink_color_change_prices != '')
                            <th>Ink Color Change Prices</th>
                        @endif
                        @if (isset($order->OrderTransfer) && $order->OrderTransfer->shipping_pieces != '')
                            <th>Shipping Pieces</th>
                        @endif
                        @if (isset($order->OrderTransfer) && $order->OrderTransfer->shipping_charges != '')
                            <th>Shipping Prices</th>
                        @endif
                    </tr>
                    <tr>
                        @if (isset($order->OrderTransfer) && $order->OrderTransfer->ink_color_change_pieces != '')
                        <td>{{ isset($order->OrderTransfer) ? $order->OrderTransfer->ink_color_change_pieces : ''}}</td>
                        @endif
                        @if (isset($order->OrderTransfer) && $order->OrderTransfer->ink_color_change_prices != '')
                        <td>{{ isset($order->OrderTransfer) ? $order->OrderTransfer->ink_color_change_prices : ''}}</td>
                        @endif
                        @if (isset($order->OrderTransfer) && $order->OrderTransfer->shipping_pieces != '')
                        <td>{{ isset($order->OrderTransfer) ? $order->OrderTransfer->shipping_pieces : ''}}</td>
                        @endif
                        @if (isset($order->OrderTransfer) && $order->OrderTransfer->shipping_charges != '')
                        <td>{{ isset($order->OrderTransfer) ? $order->OrderTransfer->shipping_charges : ''}}</td>
                        @endif
                    </tr>
                    <tr>
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->label_pieces != '')
                        <th>Inside Label Pieces </th>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->label_prices != '')
                        <th>Inside Label Prices</th>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->fold_pieces != '')
                        <th>Fold Only Pieces</th>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->fold_prices != '')
                        <th>Fold Only  Prices</th>
                        @endif
                    </tr>
                    <tr>
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->label_pieces != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->label_pieces : '' }}</td>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->label_prices != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->label_prices : '' }}</td>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->fold_pieces != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->fold_pieces : '' }}</td>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->fold_prices != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->fold_prices : '' }}</td>
                        @endif
                    </tr>
                    <tr>
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->fold_bag_pieces != '')
                        <th>Fold Bag Pieces </th>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->fold_bag_prices != '')
                        <th>Fold Bag Prices</th>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->fold_bag_tag_pieces != '')
                        <th>FOLD/BAG/TAG Pieces </th>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->fold_bag_tag_prices != '')
                        <th>FOLD/BAG/TAG Prices</th>
                        @endif
                    </tr>
                    <tr>
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->fold_bag_pieces != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->fold_bag_pieces : '' }}</td>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->fold_bag_prices != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->fold_bag_prices : '' }}</td>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->fold_bag_tag_pieces != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->fold_bag_tag_pieces : '' }}</td>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->fold_bag_tag_prices != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->fold_bag_tag_prices : '' }}</td>
                        @endif
                    </tr>
                    <tr>
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->foil_pieces != '')
                        <th>Foil Pieces</th>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->fold_bag_prices != '')
                        <th>Foil Prices</th>
                        @endif
                        @if (isset($order->OrderTransfer) && $order->OrderTransfer->transfers_pieces != '')
                        <th>Transfers Pieces</th>
                        @endif
                        @if (isset($order->OrderTransfer) && $order->OrderTransfer->transfers_prices != '')
                        <th>Transfers Prices</th>
                        @endif
                    </tr>
                    <tr>
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->foil_pieces != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->foil_pieces : '' }}</td>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->fold_bag_prices != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->foil_prices : '' }}</td>
                        @endif
                        @if (isset($order->OrderTransfer) && $order->OrderTransfer->transfers_pieces != '')
                        <td>{{ isset($order->OrderTransfer) ? $order->OrderTransfer->transfers_pieces : ''}}</td>
                        @endif
                        @if (isset($order->OrderTransfer) && $order->OrderTransfer->transfers_prices != '')
                        <td>{{ isset($order->OrderTransfer) ? $order->OrderTransfer->transfers_prices : ''}}</td>
                        @endif
                    </tr>
                    <tr>
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->palletizing_pieces != '')
                        <th>Palletizing Pieces</th>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->palletizing_prices != '')
                        <th>Palletizing  Prices</th>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->remove_packaging_pieces != '')
                        <th>Remove Packaging Pieces</th>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->remove_packaging_prices != '')
                        <th>Remove Packaging Prices</th>
                        @endif
                    </tr>
                    <tr>
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->palletizing_pieces != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->palletizing_pieces : '' }}</td>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->palletizing_prices != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->palletizing_prices : '' }}</td>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->remove_packaging_pieces != '')
                        <td>{{ isset($order->OrderOtherCharges) ? $order->OrderOtherCharges->remove_packaging_pieces : ''}}</td>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->remove_packaging_prices != '')
                        <td>{{ isset($order->OrderOtherCharges) ? $order->OrderOtherCharges->remove_packaging_prices : ''}}</td>
                        @endif
                    </tr>
                    <tr>
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->art_fee != '')
                        <th>Art Fee</th>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->art_discount != '')
                        <th>Art Discount</th>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->art_time != '')
                        <th>Art Time</th>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->tax != '')
                        <th>Tax</th>
                        @endif    
                    </tr>
                    <tr>
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->art_fee != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->art_fee : '' }}</td>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->art_discount != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->art_discount : '' }}</td>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->art_time != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->art_time : '' }}</td>
                        @endif
                        @if (isset($order->OrderOtherCharges) && $order->OrderOtherCharges->tax != '')
                        <td>{{ isset($order->OrderOtherCharges) ?  $order->OrderOtherCharges->tax : '' }}</td>
                        @endif
                    </tr>
                </table>
            </div>
            {{-- <div class="card-footer">
                <button type="button" class="btn btn-lg btn-success mb-3 no-print" onclick='printDiv();' id="submit-form">
                    <span class="fa fa-print">
                    </span>
                </button>
            </div> --}}
        </div>
    </div>
</div>

<div class="doc-popup">

</div>
</div>
@endsection
@section('footer-script')
<script>
    function _docPopup(order_id=""){
        if(order_id != ""){

            $('.doc-popup').empty();
            $.ajax({
                url: '{{ route("admin.order.doc") }}',
                type: "GET",
                data: {
                    order_id: order_id
                },
                success: function(data) {
                    $('.doc-popup').html(data);
                    $('#doc-modal').show();
                }
            });
        }
    }
    $(document).on('click', '.--open-doc-popup', function(e){
        e.preventDefault();
        var order_id 		  	= $(this).attr('data-id');
        _docPopup(order_id);
    });
    $(document).on('change', '.docFile', function(e){
			e.preventDefault();
			var formData = new FormData(document.getElementById('uploadForm'));
			console.log(formData);
			$.ajax({
				url: '{{ route("admin.order.upload_doc") }}',
				type: "POST",
				data: formData,
				processData: false,
        		contentType: false,
				success: function(data) {
					data 	= JSON.parse(data);
					_docPopup(data.order_id);
				},
				beforeSend: function() {
					$('.page-loader-wrapper').show();
				},
				complete: function(){
					$('.page-loader-wrapper').hide();
				},
			});
		});
		$(document).on("click", ".--delete-doc-file", function(){
			if(window.confirm('Are You Sure You Want To Delete?')){
				let file_id 		= $(this).attr("data-file-id");
				console.log("file_id", file_id);
				if(file_id != ""){
					$.ajax({
						url: '{{ route("admin.order.deletePurchaseDocFile") }}',
						type: "GET",
						data: {
							file_id:file_id
						},
						success: function(data) {
							data 	= JSON.parse(data);
							console.log(data);
							_docPopup(data.order_id);
						},
						beforeSend: function() {
							$('.page-loader-wrapper').show();
						},
						complete: function(){
							$('.page-loader-wrapper').hide();
						},
					});
				}
			}else{
				return false;
			}
		});
        $(document).on("click", ".--doc-preview", function(event){
			event.preventDefault();
			let popup_id        = $(this).attr('data-popup-id');
			$('#'+popup_id).modal('show');
		});
        $(document).on('click', '.close-modal', function(e){
            $(this).closest('.modal').hide();
        });
</script>
@endsection