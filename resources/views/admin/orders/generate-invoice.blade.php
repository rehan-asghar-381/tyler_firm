@extends("admin.template", ["pageTitle"=>$pageTitle])
@section('content')
<div class="content-wrapper">
    <div class="main-content">
        <nav class="navbar-custom-menu navbar navbar-expand-lg m-0 active">
            <div class="sidebar-toggle-icon open" id="sidebarCollapse">
                sidebar toggle<span></span>
            </div><!--/.sidebar toggle icon-->
            <div class="d-flex flex-grow-1">
                <ul class="navbar-nav flex-row align-items-center ml-auto">
                    <li class="nav-item dropdown quick-actions">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <i class="typcn typcn-th-large-outline"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="nav-grid-row row">
                                <a href="#" class="icon-menu-item col-4">
                                    <i class="typcn typcn-cog-outline d-block"></i>
                                    <span>Settings</span>
                                </a>
                                <a href="#" class="icon-menu-item col-4">
                                    <i class="typcn typcn-group-outline d-block"></i>
                                    <span>Users</span>
                                </a>
                                <a href="#" class="icon-menu-item col-4">
                                    <i class="typcn typcn-puzzle-outline d-block"></i>
                                    <span>Components</span>
                                </a>
                                <a href="#" class="icon-menu-item col-4">
                                    <i class="typcn typcn-chart-bar-outline d-block"></i>
                                    <span>Profits</span>
                                </a>
                                <a href="#" class="icon-menu-item col-4">
                                    <i class="typcn typcn-time d-block"></i>
                                    <span>New Event</span>
                                </a>
                                <a href="#" class="icon-menu-item col-4">
                                    <i class="typcn typcn-edit d-block"></i>
                                    <span>Tasks</span>
                                </a>
                            </div>
                        </div>
                    </li><!--/.dropdown-->
                    <li class="nav-item">
                        <a class="nav-link" href="chat.html"><i class="typcn typcn-messages"></i></a>
                    </li>
                    <li class="nav-item dropdown notification">
                        <a class="nav-link dropdown-toggle badge-dot" href="#" data-toggle="dropdown">
                            <i class="typcn typcn-bell"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <h6 class="notification-title">Notifications</h6>
                            <p class="notification-text">You have 2 unread notification</p>
                            <div class="notification-list">
                                <div class="media new">
                                    <div class="img-user"><img src="assets/dist/img/avatar.png" alt=""></div>
                                    <div class="media-body">
                                        <h6>Congratulate <strong>Socrates Itumay</strong> for work anniversaries</h6>
                                        <span>Mar 15 12:32pm</span>
                                    </div>
                                </div><!--/.media -->
                                <div class="media new">
                                    <div class="img-user online"><img src="assets/dist/img/avatar2.png" alt=""></div>
                                    <div class="media-body">
                                        <h6><strong>Joyce Chua</strong> just created a new blog post</h6>
                                        <span>Mar 13 04:16am</span>
                                    </div>
                                </div><!--/.media -->
                                <div class="media">
                                    <div class="img-user"><img src="assets/dist/img/avatar3.png" alt=""></div>
                                    <div class="media-body">
                                        <h6><strong>Althea Cabardo</strong> just created a new blog post</h6>
                                        <span>Mar 13 02:56am</span>
                                    </div>
                                </div><!--/.media -->
                                <div class="media">
                                    <div class="img-user"><img src="assets/dist/img/avatar4.png" alt=""></div>
                                    <div class="media-body">
                                        <h6><strong>Adrian Monino</strong> added new comment on your photo</h6>
                                        <span>Mar 12 10:40pm</span>
                                    </div>
                                </div><!--/.media -->
                            </div><!--/.notification -->
                            <div class="dropdown-footer"><a href="#">View All Notifications</a></div>
                        </div><!--/.dropdown-menu -->
                    </li><!--/.dropdown-->
                    <li class="nav-item dropdown user-menu">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">
                            <!--<img src="assets/dist/img/user2-160x160.png" alt="">-->
                            <i class="typcn typcn-user-add-outline"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <div class="dropdown-header d-sm-none">
                                <a href="#" class="header-arrow"><i class="icon ion-md-arrow-back"></i></a>
                            </div>
                            <div class="user-header">
                                <div class="img-user">
                                    <img src="assets/dist/img/avatar-1.jpg" alt="">
                                </div><!-- img-user -->
                                <h6>Naeem Khan</h6>
                                <span>example@gmail.com</span>
                            </div><!-- user-header -->
                            <a href="#" class="dropdown-item"><i class="typcn typcn-user-outline"></i> My Profile</a>
                            <a href="#" class="dropdown-item"><i class="typcn typcn-edit"></i> Edit Profile</a>
                            <a href="#" class="dropdown-item"><i class="typcn typcn-arrow-shuffle"></i> Activity Logs</a>
                            <a href="#" class="dropdown-item"><i class="typcn typcn-cog-outline"></i> Account Settings</a>
                            <a href="page-signin.html" class="dropdown-item"><i class="typcn typcn-key-outline"></i> Sign Out</a>
                        </div><!--/.dropdown-menu -->
                    </li>
                </ul><!--/.navbar nav-->
                <div class="nav-clock">
                    <div class="time">
                        <span class="time-hours">21</span>
                        <span class="time-min">04</span>
                        <span class="time-sec">14</span>
                    </div>
                </div><!-- nav-clock -->
            </div>
        </nav><!--/.navbar-->
        <!--Content Header (Page header)-->
      {{--   <div class="content-header row align-items-center m-0">
            <nav aria-label="breadcrumb" class="col-sm-4 order-sm-last mb-3 mb-sm-0 p-0 ">
                <ol class="breadcrumb d-inline-flex font-weight-600 fs-13 bg-white mb-0 float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">App Views</a></li>
                    <li class="breadcrumb-item active">Invoice</li>
                </ol>
            </nav>
            <div class="col-sm-8 header-title p-0">
                <div class="media">
                    <div class="header-icon text-success mr-3"><i class="typcn typcn-document-text"></i></div>
                    <div class="media-body">
                        <h1 class="font-weight-bold">Invoice</h1>
                        <small>From now on you will start your activities.</small>
                    </div>
                </div>
            </div>
        </div> --}}
        <!--/.Content Header (Page header)--> 
        <div class="body-content">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <img src="assets/dist/img/mini-logo.png" class="img-fluid mb-3" alt="">
                            <br>
                            <address>
                                <strong>Twitter, Inc.</strong><br>
                                1355 Market Street, Suite 900<br>
                                San Francisco, CA 94103<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>
                            <address>
                                <strong>Full Name</strong><br>
                                <a href="cdn-cgi/l/email-protection.html#a281">first.last@example.com</a>
                            </address>
                        </div>
                        <div class="col-sm-6 text-right">
                            <h1 class="h3">Invoice #0044777</h1>
                            <div>Issued March 19th, 2017</div>
                            <div class="text-danger m-b-15">Payment due April 21th, 2017</div>
                            <address>
                                <strong>Twitter, Inc.</strong><br>
                                1355 Market Street, Suite 900<br>
                                San Francisco, CA 94103<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>
                        </div>
                    </div> 
                    <div class="table-responsive">
                        <table class="table table-striped table-nowrap">
                            <thead>
                                <tr>
                                    <th>Item List</th>
                                    <th>Quantity</th>
                                    <th>Unit Price</th>
                                    <th>Tax</th>
                                    <th>Total Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><div><strong>Lorem Ipsum is simply dummy text</strong></div>
                                        <small>Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots</small></td>
                                        <td>1</td>
                                        <td>$39.00</td>
                                        <td>$71.98</td>
                                        <td>$27,98</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div><strong>It is a long established fact that a reader will be</strong></div>
                                            <small>There are many variations of passages of Lorem Ipsum available, but the majority</small>
                                        </td>
                                        <td>2</td>
                                        <td>$57.00</td>
                                        <td>$56.80</td>
                                        <td>$112.80</td>
                                    </tr>
                                    <tr>
                                        <td><div><strong>The standard chunk of Lorem Ipsum used since</strong></div>
                                            <small>It has survived not only five centuries, but also the leap into electronic .</small></td>
                                            <td>3</td>
                                            <td>$645.00</td>
                                            <td>$321.20</td>
                                            <td>$1286.20</td>
                                        </tr>
                                        <tr>
                                            <td><div><strong>The standard chunk of Lorem Ipsum used since</strong></div>
                                                <small>It has survived not only five centuries, but also the leap into electronic .</small></td>
                                                <td>3</td>
                                                <td>$486.00</td>
                                                <td>$524.20</td>
                                                <td>$789.20</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's 
                                            standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it
                                        to make a type specimen book.</p>
                                        <p><strong>Thank you very much for choosing us. It was a pleasure to have worked with you.</strong></p>
                                        <img src="{{ asset('b/dist/img/credit/AM_mc_vs_ms_ae_UK.png') }}" class="img-responsive" alt="">

                                    </div>
                                    <div class="col-sm-4">
                                        <ul class="list-unstyled text-right">
                                            <li>
                                                <strong>Sub - Total amount:</strong> $9265 </li>
                                                <li>
                                                    <strong>Discount:</strong> 12.9% </li>
                                                    <li>
                                                        <strong>VAT:</strong> ----- </li>
                                                        <li>
                                                            <strong>Grand Total:</strong> $12489 </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-info mr-2" onclick="myFunction()"><span class="fa fa-print"></span></button>
                                                <button type="button" class="btn btn-success"><i class="fa fa-dollar"></i> Make A Payment</button>
                                            </div>
                                        </div>
                                    </div><!--/.body content-->
                                </div><!--/.main content-->
                            </div>
                            @endsection