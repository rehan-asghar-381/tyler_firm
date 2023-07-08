@include("admin.temp.meta")
<body class="fixed">
@include("admin.temp.loader")
<div class="wrapper">
	@include("admin.temp.sidebar")
	<div class="content-wrapper">
		<div class="main-content">
			@include("admin.temp.top")
			@include("admin.temp.breadcrumb", compact("pageTitle"))
			@yield('content')
			@include("admin.temp.footer")
		</div>
	</div>
	
</div>
@include("admin.temp.footer-script")
@yield('footer-script')