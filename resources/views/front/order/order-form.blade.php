@extends('front.layout.app')

@section('content')
<div class="row">
    <div class="col-lg-10 offset-1">
        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        <h3 class="mb-4 down-line">Client Details</h3>
        <div class="form-icon-left form-boder">
            <form action="{{ route('order.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="col-md-3">
                        <label>Upload Image</label>
                        <input type="file" name="filePhoto" value="" id="filePhoto" class="form-control bg-light">
                    </div>
                    <div class="col-md-2 offset-7">
                        <img id="previewHolder" class="pull-right" src="{{ asset('assets/images/DummyImage.jpg') }}" alt="Uploaded Image Preview Holder" width="150" height="150"/>
                    </div>
                </div>

                <div class="form-row">
                    <div class="col-md-3">
                        <label>First name</label>
                        <input type="text" name="first_name" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>Last name</label>
                        <input type="text" name="last_name" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>Phone Number</label>
                        <input type="text" name="phone_number" class="form-control bg-light" value="" required="">
                    </div>
                    
                </div>
                <h3 class="mb-4 down-line">Garment Measurements</h3>
                <div class="form-row">
                    
                    <div class="col-md-3">
                        <label>Title</label>
                        <input type="text" name="title" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>Order Type</label>
                        <select type="text" name="order_type" class="form-control bg-light" value="" required="">
                            <option value="">--select--</option>
                            <option value="Walk-in">Walk-in</option>
                            <option value="Online">Online</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Hb</label>
                        <input type="number" step="any" name="field1_hb" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>B</label>
                        <input type="number" step="any" name="field2_b" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>W</label>
                        <input type="number" step="any" name="field3_w" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>Hh</label>
                        <input type="number" step="any" name="field4_hh" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>H</label>
                        <input type="number" step="any" name="field5_h" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>Sh</label>
                        <input type="number" step="any" name="field6_sh" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>1/2SH</label>
                        <input type="number" step="any" name="field7_half_sh" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>Sh-W</label>
                        <input type="number" step="any" name="field8_sh_w" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>Sh-Kn</label>
                        <input type="number" step="any" name="field9_sh_kn" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>Sh-G</label>
                        <input type="number" step="any" name="field10_sh_g" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>W-Kn</label>
                        <input type="number" step="any" name="field11_w_kn" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>W-G</label>
                        <input type="number" step="any" name="field12_w_g" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>Arm</label>
                        <input type="number" step="any" name="field13_arm" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>1/2Arm</label>
                        <input type="number" step="any" name="field14_half_arm" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>Arm Depth</label>
                        <input type="number" step="any" name="field15_arm_depth" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>Bicep</label>
                        <input type="number" step="any" name="field16_bicep" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>Wrist</label>
                        <input type="number" step="any" name="field17_wrist" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>Sh-W</label>
                        <input type="number" step="any" name="field18_sh_w" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-3">
                        <label>TW</label>
                        <input type="number" step="any" name="field19_tw" class="form-control bg-light" value="" required="">
                    </div>
                    <div class="col-md-6">
                        <label>Description</label>
                        <textarea class="form-control bg-light" name="description" id="" required=""></textarea>
                    </div>
                </div>
                <h3 class="mb-4 down-line">Supplies</h3>
                <div class="supply-p">
                    <div class="form-row supply-info">
                        <div class="col-md-8">
                            <label>Supply Info</label>
                            <input type="text" name="suply_info[]" class="form-control bg-light" value="" required="">
                        </div>
                        <div class="col-md-4" style="margin-top: 2rem!important;">
                            <button type="button" class="btn btn-success-fixed mb-3 add-supply-row">Add more</button>
                            <button type="button" class="btn btn-danger-fixed mb-3 remove-supply-row">Remove</button>
                        </div>
                    </div>
                </div>
                <h3 class="mb-4 down-line">Schedule</h3>
                <div class="form-row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Order Date: </label>&nbsp;&nbsp;&nbsp;
                            <div class="input-group date">
                                <input type="text" name="order_date" class="form-control bg-light flatpickr" value="" required="">
                                <div class="input-group-addon input-group-append">
									<div class="input-group-text">
										<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Collection Date: </label>&nbsp;&nbsp;&nbsp;
                            <div class="input-group date">
                                <input type="text" name="collection_date" class="form-control bg-light flatpickr" value="" required="">
                                <div class="input-group-addon input-group-append">
									<div class="input-group-text">
										<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
                <h3 class="mb-4 down-line">Additional Info</h3>
                <div class="form-row">
                    <div class="col-md-9">
                        <label>Tailor Comments</label>
                        <textarea class="form-control bg-light" name="tailor_comments" id="" required=""></textarea>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-12 form-check">
                        <button type="submit" class="btn btn-primary-fixed mb-3">Submit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
