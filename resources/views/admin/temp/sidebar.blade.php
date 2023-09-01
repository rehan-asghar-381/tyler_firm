<nav class="sidebar sidebar-bunker no-print no-print">
	<div class="sidebar-header">
		{{-- <a href="#" class="logo"><span>Tyler Firm</span></a> --}}
		<a href="{{url("/")}}" class="logo"><img src="{{asset('assets/images/logo/logo.webp')}}" alt=""></a>
	</div>
	<div class="profile-element d-flex align-items-center flex-shrink-0">
		{{-- <div class="avatar online">
			<img src="assets/dist/img/avatar-1.jpg" class="img-fluid rounded-circle" alt="">
		</div> --}}
		<div class="profile-text">
			<h6 class="m-0">{{ auth()->user()->name }}</h6>
			<span>{{ auth()->user()->email }}</span>
		</div>
	</div>
	<div class="sidebar-body" style="height: 100% !important;">
		<nav class="sidebar-nav">
			<ul class="metismenu">
				{{-- <li class="nav-label">Main Menu</li> --}}
				@can('dashboard-view')
				<li class="@if(Request::segment(2) == "dashboard")) {{ "mm-active" }}  @endif">
					<a class="" href="{{ route('admin.dashboard') }}">
						<i class="typcn typcn-home-outline mr-2"></i>
						Dashboard
					</a>
				</li>
				@endcan
				@can('orders-list')
				<li class="@if( Request::segment(2) == "orders") {{ "mm-active" }}  @endif">
					<a class="" href="{{ route('admin.orders.index') }}">
						<i class="typcn typcn-shopping-cart  mr-2"></i>
						Orders
					</a>
				</li>
				@endcan
				@can('clients-list')
				<li class="@if( Request::segment(2) == "clients") {{ "mm-active" }}  @endif">
					<a class="" href="{{ route('admin.clients.index') }}">
						<i class="typcn typcn-user-outline mr-2"></i>
						Clients
					</a>
				</li>
				@endcan
				@if(auth()->user()->can('product-list') || auth()->user()->can('brand-list'))
				<li>
					<a class="has-arrow material-ripple" href="#" aria-expanded="false">
                         <i class="typcn typcn-chart-pie-outline mr-2"></i> Products
                    </a>
                    <ul class="nav-second-level mm-collapse">
                    	@can('brand-list')
						<li class="@if(Request::segment(2) == "brand")) {{ "mm-active" }}  @endif">
							<a class="" href="{{ route('admin.brand.index') }}">
								<i class="typcn typcn-ticket mr-2"></i>
								Brands
							</a>
						</li>
						<li class="@if(Request::segment(2) == "product")) {{ "mm-active" }}  @endif">
							<a class="" href="{{ route('admin.product.index') }}">
								<i class="typcn typcn-waves-outline mr-2"></i>
								Products
							</a>
						</li>
						@endcan
                    </ul>
				</li>
				@endif
				@if(auth()->user()->can('prices-list'))
				<li>
					<a class="has-arrow material-ripple" href="#" aria-expanded="false">
                         <i class="typcn typcn-cog-outline mr-2"></i> Settings
                    </a>
                    <ul class="nav-second-level mm-collapse">
                    	@can('brand-list')
						<li class="@if(Request::segment(2) == "settings" && Request::segment(3) == "decoration-prices" ) {{ "mm-active" }}  @endif">
							<a class="" href="{{ route('admin.price.index') }}">
								<i class="typcn typcn-book mr-2"></i>
								Decoration Prices
							</a>
						</li>
						@endcan
						@can('roles-list')
							<li class="@if(Request::segment(2) == "roles")) {{ "mm-active" }}  @endif">
								<a class="" href="{{ route('admin.roles.index') }}">
									<i class="typcn typcn-key-outline mr-2"></i>
									Roles
								</a>
							</li>
						@endcan
						@can('users-list')
							<li class="@if(Request::segment(2) == "users")) {{ "mm-active" }}  @endif">
								<a class="" href="{{ route('admin.users.index') }}">
									<i class="typcn typcn-user mr-2"></i>
									Users
								</a>
							</li>
						@endcan
						@can('users-list')
							<li class="@if(Request::segment(2) == "email-template")) {{ "mm-active" }}  @endif">
								<a class="" href="{{ route('admin.email-template.index') }}">
									<i class="typcn typcn-message mr-2"></i>
									Email Template
								</a>
							</li>
						@endcan
						<li>
							<a class="" href="{{ route('admin.changePassword') }}">
								<i class="typcn typcn-user mr-2"></i>
								Change Password
							</a>
						</li>
                    </ul>
				</li>
				@endif
				<li>
					<a class="" href="{{ route('logout') }}">
						<i class="typcn typcn-user-delete mr-2"></i>
						Logout
					</a>
				</li>
			</ul>
		</nav>
	</div><!-- sidebar-body -->
</nav>