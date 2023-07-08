@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
@php
    $measurement_text       = ($order_detail->measurement == 'cms')? 'cms': 'Inches'; 
@endphp
<div class="body-content">
    <div class="row">
        <div class="col-sm-12 col-xl-8">
            <div class="media d-flex m-1 ">
                @if(count($order_detail->OrderImgs) > 0)
                    @foreach($order_detail->OrderImgs as $key=>$OrderImg)
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
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Client Info</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0 font-weight-600">Shop Size</h6>
                        </div>
                        <div class="col-auto">
                            <a href="#!" class="fs-13 font-weight-600">{{ $order_detail->title }}</a>
                        </div>
                    </div> 
                    <hr>
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0 font-weight-600">Order Type</h6>
                        </div>
                        <div class="col-auto">
                            <a href="#!" class="fs-13 font-weight-600">{{ $order_detail->OrderType->name ?? '-' }}</a>
                        </div>
                    </div> 
                    <hr>
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0 font-weight-600">First name</h6>
                        </div>
                        <div class="col-auto">
                            <a href="#!" class="fs-13 font-weight-600">{{ $order_detail->client->first_name ?? "-" }}</a>
                        </div>
                    </div> 
                    <hr>
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0 font-weight-600">Last name</h6>
                        </div>
                        <div class="col-auto">
                            <a href="#!" class="fs-13 font-weight-600">{{ $order_detail->client->last_name ?? "-" }}</a>
                        </div>
                    </div>
                    <hr>
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0 font-weight-600">Email</h6>
                        </div>
                        <div class="col-auto">
                            <a href="#!" class="fs-13 font-weight-600">{{ $order_detail->client->email ?? "-" }}</a>
                        </div>
                    </div>
                    <hr>
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0 font-weight-600">Phone number</h6>
                        </div>
                        <div class="col-auto">
                            <a href="#!" class="fs-13 font-weight-600">{{ $order_detail->client->phone_number ?? "-" }}</a>
                        </div>
                    </div>
                    <hr>
                    <div class="row align-items-center">
                        <div class="col">
                            <h6 class="mb-0 font-weight-600">Country</h6>
                        </div>
                        <div class="col-auto">
                            <span class="fs-13 font-weight-600 text-muted">{{ $order_detail->country }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @if(count($order_detail->AdditionalFields) > 0)
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h6 class="fs-17 font-weight-600 mb-0">Tasks Info</h6>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <thead>
                            <tr>
                                <th width="50px">Task</th>
                                <th width="50px">Tailor</th>
                                <th width="50px">Start Date</th>
                                <th width="50px">Completion Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order_detail->OrderJobs as $OrderJob)
                            <tr>
                                <td width="50px">{{ $OrderJob->Status->name }}</td>
                                <td width="50px">{{ $OrderJob->User->name }}</td>
                                <td width="50px">{{ $OrderJob->start_date_time }}</td>
                                <td width="50px">{{ $OrderJob->completion_date_time }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
        </div>
        
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="fs-17 font-weight-600 mb-0">Body Measurements</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form>
                        <div class="row">
                            <div class="col-md-3 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">High Bust</label>
                        <div class="input-group">
                                    <input type="text" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field1_hb }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3 px-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Bust/Chest</label>
                        <div class="input-group">
                                    <input type="text" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field2_b }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Waist</label>
                        <div class="input-group">
                                    <input type="email" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field3_w }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">High Hip</label>
                        <div class="input-group">
                                    <input type="email" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field4_hh }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Hip</label>
                        <div class="input-group">
                                    <input type="text" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field5_h }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-2 px-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Shoulder</label>
                        <div class="input-group">
                                    <input type="text" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field6_sh }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-2 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">1/2 Shoulder</label>
                        <div class="input-group">
                                    <input type="email" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field7_half_sh }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-2 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Shoulder - Waist</label>
                        <div class="input-group">
                                    <input type="email" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field8_sh_w }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class="font-weight-600">Shoulder - High Hip </label>
                                <div class="input-group">
                                <input type="number" step="any" name="field20_sh_hh" class="form-control require" value="{{ $order_detail->field20_sh_hh }}" disabled>
                                
                                <div class="input-group-addon input-group-append">
                                    <div class="input-group-text rh-m-text">
                                        {{ $measurement_text }}
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Shoulder - Knee</label>
                        <div class="input-group">
                                    <input type="text" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field9_sh_kn }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3 px-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Shoulder - Ground</label>
                        <div class="input-group">
                                    <input type="text" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field10_sh_g }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Waist - Knee</label>
                        <div class="input-group">
                                    <input type="email" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field11_w_kn }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Waist - Ground</label>
                        <div class="input-group">
                                    <input type="email" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field12_w_g }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Arm</label>
                        <div class="input-group">
                                    <input type="text" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field13_arm }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3 px-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">1/2Arm</label>
                        <div class="input-group">
                                    <input type="text" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field14_half_arm }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Armhole Depth</label>
                        <div class="input-group">
                                    <input type="email" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field15_arm_depth }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Bicep</label>
                        <div class="input-group">
                                    <input type="email" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field16_bicep }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Wrist</label>
                        <div class="input-group">
                                    <input type="text" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field17_wrist }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3 px-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Shoulder - Waist (front)</label>
                        <div class="input-group">
                                    <input type="text" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field18_sh_w }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Thigh</label>
                        <div class="input-group">
                                    <input type="email" class="form-control" disabled="" placeholder="" value="{{ $order_detail->field19_tw }}">
                                    <div class="input-group-addon input-group-append">
                                        <div class="input-group-text rh-m-text">
                                            {{ $measurement_text }}
                                        </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-3 pl-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Description</label>
                                    <textarea type="email" class="form-control" disabled="" placeholder="">{{ $order_detail->description }}</textarea>
                                </div>
                            </div>
                        </div>
                        @if(count($order_detail->AdditionalFields) > 0)
                        <h5>Additional Fields</h5>

                            @foreach ($order_detail->AdditionalFields as $additional_field)
                            <div class="row">
                                <div class="col-md-6 pr-md-1">
                                    <div class="form-group">
                                        <label for="">Label</label>
                                        <input type="text" class="form-control" disabled="" placeholder="" value="{{ $additional_field->label }}">
                                    </div>
                                </div>
                                <div class="col-md-6 pr-md-1">
                                    <div class="form-group">
                                        <label for="">Value</label>
                                        <input type="text" class="form-control" disabled="" placeholder="" value="{{ $additional_field->value }}">
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        
                        @endif
                        <h5>Schedule</h5>
                        <div class="row">
                            <div class="col-md-6 pr-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Order Date</label>
                                    <input type="text" class="form-control" disabled="" placeholder="" value="{{ $order_detail->order_date }}">
                                </div>
                            </div>
                            <div class="col-md-6 px-md-1">
                                <div class="form-group">
                                    <label class="font-weight-600">Collection Date</label>
                                    <input type="text" class="form-control" disabled="" placeholder="" value="{{ $order_detail->collection_date }}">
                                </div>
                            </div>
                        </div>
                        <h5>Supplies</h5>
                        @if(count($order_detail->OrderSupply) > 0)
                            @foreach ($order_detail->OrderSupply as $OrderSupply)
                       
                            <div class="row">
                                <div class="col-md-6 pr-md-1">
                                    <div class="form-group">
                                        <label>Item</label>
                                        <input type="text" class="form-control" disabled="" placeholder="" value="{{ $OrderSupply->SupplyInventoryItem->item ?? "" }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label>Quantity</label>
                                    <input type="number" name="quantity[]" class="form-control require" value="{{ $OrderSupply->quantity }}" disabled="">
                                  </div>
                            </div>
                            @endforeach
                        
                        @endif
                        <h5>Till</h5>
                        <div class="row">
                            <div class="col-md-2">
                                <label>Selling Price</label>
                                <input type="number" name="selling_price" disabled=""  class="form-control require selling_price" value="{{ $order_detail->OrderTill->selling_price ?? "" }}">
                            </div>
                            <div class="col-md-2">
                                <label>Deposit</label>
                                <input type="number" name="deposit" disabled=""  class="form-control require deposit" value="{{ $order_detail->OrderTill->deposit ?? "" }}">
                            </div>
                            <div class="col-md-2">
                                <label>Balance</label>
                                <input type="number" name="balance" disabled=""  class="form-control require balance" value="{{ $order_detail->OrderTill->balance ?? "" }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label>Payment Type</label>
                                <select type="text" name="payment_type" disabled=""  id="payment_type" class="form-control require" value="" >
                                    <option value="">--select--</option>
                                    @foreach ($payments_types as $payments_type)
                                        <option value="{{ $payments_type->id }}" @if($payments_type->id == (isset($order_detail->OrderTill->payment_type)) ?$order_detail->OrderTill->payment_type:"") {{ "selected" }} @endif>{{ $payments_type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <h5>Additional Info</h5>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="font-weight-600">Comments</label>
                                    <textarea rows="4" cols="80" class="form-control" placeholder="Here can be your description"  disabled="">{{ $order_detail->tailor_comments }}</textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('footer-script')
<script>
    $(".img-zoom-m").ezPlus();
</script>
@endsection