@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
.btn-d-none{
    display: none;
}
.has-error{
    border: 1px solid red;
}
</style>
@php
    $measurement_text       = (isset($measurmement->measurement_type) && $measurmement->measurement_type == 'cms')? 'cms': 'Inches'; 
@endphp
<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">Add Body Measurement</h6>
                </div>
                <div class="text-right">
                    
                </div>
            </div>
        </div>
        <div class="card-body">
            @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif
            <form  method="POST" action="{{ route('admin.clients.store_measurement', $client_id) }}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-4 col">
                        <div class="form-group">
                            <div class="roles_titles mt-4">Measurement Type</div>
                            <div class="water-check-boxs">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-check mb-3 hover-text">
                                            <input class="form-check-input  shadow-none" type="radio" name="measurement_type" value="Inches" @if(isset($measurmement->measurement_type) && $measurmement->measurement_type == 'Inches') {{ "checked" }} @endif>
                                            <span class="checkmark"></span>
                                            <label class="" for="">
                                                Inches
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-check mb-3 hover-text">
                                            <input class="form-check-input  shadow-none" type="radio" name="measurement_type" value="cms" @if(isset($measurmement->measurement_type) &&$measurmement->measurement_type == 'cms') {{ "checked" }} @endif>
                                            <span class="checkmark"></span>
                                            <label class="" for="">
                                                cms
                                            </label>
                                        </div>
                                    </div>                                     
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="row">
                    
                    <div class="col-md-3">
                        <label>Shop size</label>
                        <select type="text" name="title" id="title" class="form-control" value="">
                            <option value="">--select--</option>
                            @foreach ($shop_sizes as $shop_size)
                                <option value="{{ $shop_size->name }}" @if(isset($measurmement->title) && $measurmement->title == $shop_size->name) {{ "selected" }} @endif>{{ $shop_size->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3"> 
                        <label>High Bust</label>
                        <div class="input-group">
                            <input type="number" step="any" name="field1_hb" id="high_bust" class="form-control require" value="{{ $measurmement->field1_hb ?? "" }}" >
                            <div class="input-group-addon input-group-append">
                                <div class="input-group-text rh-m-text">
                                    {{ $measurement_text }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label>Bust/Chest</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field2_b" id="bust" class="form-control require required-online" value="{{ $measurmement->field2_b ?? "" }}" >
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Waist</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field3_w" id="waist" class="form-control require required-online" value="{{ $measurmement->field3_w ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>High Hip</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field4_hh" id="high_hip" class="form-control require" value="{{ $measurmement->field4_hh ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Hip </label>
                        <div class="input-group">
                        <input type="number" step="any" name="field5_h" id="hip" class="form-control require required-online" value="{{ $measurmement->field5_h ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field6_sh" class="form-control require" value="{{ $measurmement->field6_sh ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>1/2 Shoulder</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field7_half_sh" class="form-control require" value="{{ $measurmement->field7_half_sh ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder - Waist </label>
                        <div class="input-group">
                        <input type="number" step="any" name="field8_sh_w" class="form-control require" value="{{ $measurmement->field8_sh_w ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder - High Hip </label>
                        <div class="input-group">
                        <input type="number" step="any" name="field20_sh_hh" class="form-control require" value="{{ $measurmement->field20_sh_hh ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder - Knee</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field9_sh_kn" class="form-control require" value="{{ $measurmement->field9_sh_kn ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder - Ground</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field10_sh_g" class="form-control require" value="{{ $measurmement->field10_sh_g ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Waist - Knee</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field11_w_kn" class="form-control require" value="{{ $measurmement->field11_w_kn ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Waist - Ground</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field12_w_g" class="form-control require" value="{{ $measurmement->field12_w_g ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Arm</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field13_arm" class="form-control require" value="{{ $measurmement->field13_arm ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>1/2Arm</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field14_half_arm" class="form-control require" value="{{ $measurmement->field14_half_arm ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Armhole Depth</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field15_arm_depth" class="form-control require" value="{{ $measurmement->field15_arm_depth ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Bicep</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field16_bicep" class="form-control require" value="{{ $measurmement->field16_bicep ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Wrist</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field17_wrist" class="form-control require" value="{{ $measurmement->field17_wrist ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Shoulder - Waist (front)</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field18_sh_w" class="form-control require" value="{{ $measurmement->field18_sh_w ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                    <div class="col-md-3">
                        <label>Thigh</label>
                        <div class="input-group">
                        <input type="number" step="any" name="field19_tw" class="form-control require" value="{{ $measurmement->field19_tw ?? "" }}" >
                        
                        <div class="input-group-addon input-group-append">
                            <div class="input-group-text rh-m-text">
                                {{ $measurement_text }}
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="row" style="margin-top: 20px;">
                    <div class="col-md-12 form-check">
                        <button type="submit" class="btn btn-primary mb-3" id="submit-form">Submit</button>
                    </div>
                </div
            </form>
        </div>
    </div>
</div>
@endsection
@section('footer-script')
<script>
    $(document).ready(function(){
        $('select').select2();
        function required(seletor=""){

            let validated           = true;
            $(".require").each(function(key, value){
    
                var value       = $(this).val();
                if(value == "" || value == null){
                    
                    $(this).addClass('has-error');
                    validated   = false;

                }else{

                    $(this).removeClass('has-error');
                    
                }
            });
            return validated;
        }

        $('#submit-form').click(function(event) {

            var validate = required();
            if (validate) {
                return true;
            }else{
                event.preventDefault();
            }

        });
      
      $(document).on('change', 'input[name=measurement_type]', function(){

          if($(this).is(':checked')){

            var measurement_type        = $(this).val();
            $('.rh-m-text').each(function(index, value){

                if(measurement_type == 'Inches'){

                    $(this).text('Inches');
                }else if(measurement_type == 'cms'){

                    $(this).text('cms');
                }
            });

        }
      });
    });
    
</script>

@endsection
