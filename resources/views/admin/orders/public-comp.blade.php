<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="{{asset('b/plugins/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('b/plugins/NotificationStyles/css/ns-default.css') }}" rel="stylesheet">
	<link href="{{ asset('b/plugins/NotificationStyles/css/ns-style-growl.css') }}" rel="stylesheet">
	<link href="{{ asset('b/plugins/NotificationStyles/css/ns-style-bar.css') }}" rel="stylesheet">
    <style>
        .has-error{
            border: 1px solid red;
        }
    </style>
</head>
<body style="padding: 0;margin: 0;">
    @if(session('success'))
        <p id="--n-message" style="display: none;">{{ session('success') }}</p>
    @else
        <p id="--n-message" style="display: none;"></p>
    @endif
    <div class="wrapper">
        <!-- Page Content  -->
        <div class="content-wrapper">
            <div class="main-content">
                <div class="body-content">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="fs-17 font-weight-600 mb-0">Comp For Approval</h6>
                                </div>
                                <div class="text-right">
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="bd-example">
                                <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                                    <div class="carousel-inner">
                                        <div class="carousel-item active">
                                            <img src="{{asset($comp->file)}}" class="d-block w-100" alt="...">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- @if ($is_approved == 0) --}}
                            <table style="width: 100%;margin-bottom: 40px;border-collapse: collapse;">
                                <tr>
                                    <div style="margin-top: 20px;margin-bottom: 20px;"><a class="btn btn-success mb-3 action-btn" id="submit-form" style="color:#ffffff" data-action="1">Approve</a><a class="btn btn-danger mb-3 action-btn" id="submit-form" style="margin: 0px 10px;color:#ffffff" data-action="2">Not Approve</a></div>
                                </tr>
                            </table>
                            {{-- @endif --}}
                            <p style="position: fixed;bottom: 0;text-align: center;width: 100%;margin: 0 auto; padding: 10px; background-color: #fff;">Art Charge $60 per hour (1 Hour Min.) Production time is 7-12 business days from receipt of all necessary components. 50% deposit required. NWG not responsible for damages to customer provided goods. Approval must be received before order goes into production.</p>
                        </div>
                    </div>
                </div><!--/.body content-->
            </div><!--/.main content-->
            
        </div><!--/.wrapper-->
        
    </div>
    {{-- @if ($is_approved == 0) --}}
        <!-- The Modal -->
	<div class="modal" id="response-modal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header" style="background-color:#041e42">
					<h6 class="modal-title text-white">Comp</h6>
					<button type="button" class="close close-modal" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body" style="max-height: calc(100vh - 210px);overflow-y: auto;">
					<form  method="POST" id="sendEmail" action="{{ route('comp.store') }}"  enctype="multipart/form-data">
						@csrf
						<input type="hidden" name="comp_id" id="comp_id" value="{{ $id ??"" }}">
						<input type="hidden" name="url_email" id="url_email" value="{{ $email ??"" }}">
						<input type="hidden" name="action" id="action" value="">
					
						<div class="row">
							<div class="col-md-6 mb-3">
								<label class="form-label text-dark-gray" for="email">Your Email</label>
								<input type="email" id="clientEmail" name="email" class="form-control font-12 form-control require" value="">
							</div>
							<div class="col-md-6 mb-3">
								<label class="form-label text-dark-gray label-desc" for="description">Comments</label>
                                <textarea class="form-control comments" name="description" ></textarea>
							</div>
						</div>
						<button type="submit" class="btn btn-success" id="save-button">Submit</button>
					</form>
				</div>
				<!-- Modal footer -->
				<div class="modal-footer">
					<button class="btn btn-default close-modal" type="button">close</button>
				</div>
			</div>
		</div>
	</div>
    {{-- @endif --}}
    <script src="{{ asset('b/plugins/jQuery/jquery-3.4.1.min.js')}} "></script>
	<script src="{{ asset('b/dist/js/popper.min.js')}} "></script>
	<script src="{{ asset('b/plugins/bootstrap/js/bootstrap.min.js')}} "></script>
    <script src="{{asset('b/plugins/NotificationStyles/js/modernizr.custom.js') }}"></script>
   	<script src="{{asset('b/plugins/NotificationStyles/js/classie.js') }}"></script>
	<script src="{{asset('b/plugins/NotificationStyles/js/notificationFx.js')}}"></script>
    <script>
        $(document).ready(function(){
            function required(){

                let validated       = true;
                var alertMessages       = "";
                var alertValidated      = false;

                $(".error-details").empty();

                $(".require").each(function(key, value){
                    
                    var value       = $(this).val();
                    
                    if(value == "" || value == null){
                            
                        $(this).addClass('has-error');
                        validated   = false;
                    }else{
                        $(this).removeClass('has-error');   
                    }
                });
                if(alertValidated){
                    alert(alertMessages);
                }
                return validated;
            }
            $(document).on("click", "#save-button", function(event) {

                var validate = required();

                if (validate) {
                    return true;
                }else{
                    event.preventDefault();
                }

            });
            $(document).on('click', '.close-modal', function(e){
                $(this).closest('.modal').hide();
            });
            $(document).on('click', '.action-btn', function(e){
                e.preventDefault();
                $(".comments").removeClass('require');
                $(".comments").empty();
                $(".comments").removeClass('has-error');
                let action  = $(this).attr("data-action");
                $(".label-desc").empty();
                if(action == 1){
                    $(".label-desc").text('Comments');
                    $(".modal-title").text('Comp Approval');
                }else{
                    $(".label-desc").text('Rejection Reason');
                    $(".modal-title").text('Comp Rejection');
                    $(".comments").addClass('require');
                }
                $("#action").val(action);
                $('#response-modal').show();
            });

            function notification_message(message){
                var notification = new NotificationFx({
                    message: '<span class="icon icon-megaphone"></span><p>'+message+'</p>',
                    layout: 'growl',
                    effect: 'scale',
                    type: 'notice', // notice, warning, error or success
                    onClose: function () {
                        bttn.disabled = false;
                    }
                });

                // show the notification
                notification.show();

            }
            let message         = $("#--n-message").text();
            if(message != ""){

                notification_message(message);
            }
        });
    </script>
</body>
</html>