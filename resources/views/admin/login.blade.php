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
                        <form class="login" action="{{ route('login.post') }}" method="POST">
                        	@if (session('error'))
								<div class="alert alert-danger">
									{{ session('error') }}
								</div>
							@endif
                           @csrf
                            <div class="form-group">
                                <input type="text" class="form-control" name="email" id="email" placeholder="Enter email">
                                
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" id="pass" placeholder="Password">
                            </div>
                            
                            <button type="submit" class="btn btn-success btn-block">Sign in</button>
                        </form>
                    </div>
                    
                </div>
            </div>
        </div>
       @include("admin.temp.footer-script")