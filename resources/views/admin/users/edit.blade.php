@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<div class="col-md-12">
    <div class="card mb-4">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h6 class="fs-17 font-weight-600 mb-0">Create User</h6>
                </div>
                <div class="text-right">
                    
                </div>
            </div>
        </div>
        <div class="card-body">
            <form  method="POST" action="{{ route('admin.users.update', $user->id) }}">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-4 mb-3">
                            <label class="form-label text-dark-gray" for="">Name</label>
                        <input type="text" name="name" class="form-control font-12 form-control-lg require" value="{{ old('name', $user->name) }}">
                        
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-dark-gray" for="">Email</label>
                        <input type="email" name="email" class="form-control font-12 form-control-lg require" value="{{old('email', $user->email)}}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-dark-gray" for="">Password</label>
                        {!! Form::password('password', array('placeholder' => 'Password','class' => 'form-control font-12 form-control-lg require')) !!}
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label text-dark-gray" for="">Confirm Password</label>
                        {!! Form::password('confirm-password', array('placeholder' => 'Confirm Password','class' => 'form-control font-12 form-control-lg require')) !!}
                    </div>
                </div>
                @if (!auth()->user()->hasRole('Super Admin'))
                    
                    <div class="form-group">
                        <div class="roles_titles mt-4 mb-4" style="font-size: 16px;font-weight: bold;">Roles</div>
                        @if(count($roles) > 0)
                        <div class='water-check-boxs'>
                            <div class="row">
                            @foreach($roles as $id=>$name)
                                @if(count($roles) > 0)
                                    @php
                                    
                                        $old_roles      = [];
                                        if( old("roles") !=null && is_array(old("roles")) ){
        
                                            $old_roles  = old("roles"); 
                                        }else{
        
                                            $old_roles  = $userRole;
                                        }
                                    @endphp
                                    @if($name != 'Super Admin')
                                    <div class="col-md-2 col">
                                        <div class="form-check mb-3 hover-text">
                                            <input class="form-check-input  shadow-none" type="checkbox" name="roles[]" value="{{ $id }}" id="flexCheckDefault" {{ (in_array($id, $old_roles))? "checked" :"" }}>
                                            <span class="checkmark"></span>
                                            <label class="form-check-label" for="">
                                                {{ $name }}
                                            </label>
                                        </div>
                                    </div>
                                    @endif
                                @endif     
                            @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                @endif
                <button type="submit" class="btn btn-success">Submit</button>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    function required(){

        let validated       = true;
        var alertMessages       = "";
        var alertValidated      = false;

        $(".error-details").empty();

        $(".require").each(function(key, value){
            
            var value       = $(this).val();

            if(value == "" || value == null){
                if($(this).parent().hasClass('d-none') == false){
                    
                    $(this).addClass('has-error');
                    validated   = false;
                }else{

                    if($(this).parent().hasClass('d-none') == true){
                        $(this).removeClass('has-error');
                    }
                }
            }else{
                $(this).removeClass('has-error');

                
            }
        });
        if(alertValidated){
            alert(alertMessages);
        }
        return validated;
        }
        $('#save-button').click(function(event) {

        var validate = required();

        if (validate) {
            return true;
        }else{
            event.preventDefault();
        }

    });
</script>
@endsection

