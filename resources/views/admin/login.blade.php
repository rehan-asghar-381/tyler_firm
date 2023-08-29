<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Bootstrap 4 Admin &amp; Dashboard Template">
    <meta name="author" content="Bdtask">
    <title>Login</title>
    <link rel="shortcut icon" href="assets/dist/img/favicon.png">
    <link href="{{asset('b/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('b/plugins/bootstrap/css/metisMenu.min.css')}}" rel="stylesheet">
    <link href="{{asset('b/plugins/bootstrap/css/all.min.css')}}" rel="stylesheet">
    <link href="{{asset('b/plugins/bootstrap/css/typicons.min.css')}}" rel="stylesheet">
    <link href="{{asset('b/plugins/bootstrap/css/themify-icons.min.css')}}" rel="stylesheet">
    <link href="{{asset('b/dist/css/style.css')}}" rel="stylesheet">
    <style>
        .btn-success {
			color: #fff;
			background-color: #041e42;
			border-color: #041e42;
		}
        .btn-success {
			box-shadow: 0 2px 6px 0 rgb(255 255 255 / 50%);
		}
        .btn-success.focus, .btn-success:focus {
            box-shadow: 0 0 0 0.2rem rgba(72,180,97,.5);
        }
        .btn-success:hover {
            color: #fff;
            background-color: #041e42;
            border-color: #041e42;
        }
        a {
			color: #041e42;
			text-decoration: none;
		}
    </style>
</head>
<body class="bg-white">
    <div class="d-flex align-items-center justify-content-center text-center h-100vh">
        <div class="form-wrapper m-auto">
            <div class="form-container my-4">
                <div class="register-logo text-center mb-4">
                    <img src="assets/dist/img/logo2.html" alt="">
                </div>
                <div class="panel">
                    <div class="panel-header text-center mb-3">
                        <h3 class="fs-24">Sign into your account!</h3>
                        <p class="text-muted text-center mb-0">Nice to see you! Please log in with your account.</p>
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
                    <form class="login" action="{{ route('login.post') }}" method="POST">
                       
                     @csrf
                     <div class="form-group">
                        <input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
                        
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" id="pass" placeholder="Password">
                    </div>
                    
                    <button type="submit" class="btn btn-success btn-block">Sign in</button>
                    <p class="text-muted text-center mt-3 mb-0">
                        Forget Password? <a class="external" href="{{route('password.reset')}}"> Click Here.</a>
                    </p>
                </form>
            </div>
            
        </div>
    </div>
</div>
@include("admin.temp.footer-script")