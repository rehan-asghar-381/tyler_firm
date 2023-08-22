@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<style>
.dropdown-toggle::after {
  border: none !important;
}
</style>
<div class="body-content">
<div class="form-wrapper m-auto">
                <div class="form-container my-4" style="height: 100px;position: absolute;top: 135px;bottom: 0;left: 0;right: 0;margin: auto;">
                    <div class="register-logo text-center mb-4">
                        <img src="assets/dist/img/logo2.html" alt="">
                    </div>
                    <div class="panel">
                        <div class="panel-header text-center mb-3">
                            <h3 class="fs-24">Change Password</h3>
                            {{-- <p class="text-muted text-center mb-0">Fill with your mail to receive instructions on how to reset your password.</p> --}}
                        </div>
                         @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                        <form  class="register-form" method="POST" action="{{ route('admin.changePasswordSave') }}">
                            @csrf

                            <div class="form-group">

                                <input type="password" id="password" placeholder="Current Password" name="currentPassword" required class="form-control @error('password') is-invalid @enderror">  
                         </div>
                         <div class="form-group">

                            <input type="password" id="password" placeholder="New Password" name="newPassword" required class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ 'Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.' }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">

                         <input type="password" placeholder="Confirm Password" id="password" name="newPasswordConfirm" required  class="form-control @error('password') is-invalid @enderror">
                         @error('password')
                         <span class="invalid-feedback" role="alert">
                            <strong>{{ 'Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character.' }}</strong>
                        </span>
                        @enderror
                    </div>
                    <small style="
                    font-size: x-small;
                    display: block;
                    text-align: left;
                    color: red;
                    ">Your password must be more than 8 characters long, should contain at-least 1 Uppercase, 1 Lowercase, 1 Numeric and 1 special character. </small> <br> 
                    <button type="submit" class="btn btn-success btn-block">Update</button>

                </form>
            </div>
       
</div>

@endsection

