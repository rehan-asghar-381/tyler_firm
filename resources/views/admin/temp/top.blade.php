@php
	$segment_one = request()->segment(2);
	$segment_2 		= request()->segment(3);
@endphp
<nav class="navbar-custom-menu navbar navbar-expand-lg m-0 no-print @if($segment_one == "orders" && $segment_2 == "") {{"active"}} @endif">
	<div class="sidebar-toggle-icon" id="sidebarCollapse">
		sidebar toggle<span></span>
	</div>
	<div class="d-flex flex-grow-1">
		<ul class="navbar-nav flex-row align-items-center ml-auto">
			<li class="nav-item dropdown notification">
				<a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-expanded="false">
					<i class="typcn typcn-bell"></i>
					<span class="badge badge-notification bg-danger text-white nt-count" style="position: absolute;top: 0;right: 0;padding: 0em 0.11em;"></span>
				</a>
				<div class="dropdown-menu dropdown-menu-right">
					<h6 class="notification-title">Notifications</h6>
					<div class="notification-list">
						
					</div>
					<div class="dropdown-footer"><a href="{{ route('admin.dashboard.get_all_notifications') }}">View All Notifications</a></div>
				</div>
			</li>
		</ul>
		<div class="nav-clock">
			<div class="time">
				<span class="time-hours"></span>
				<span class="time-min"></span>
				<span class="time-sec"></span>
			</div>
		</div>
	</div>
</nav>