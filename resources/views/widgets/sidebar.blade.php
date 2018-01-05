<li class="">
	<a href="{{ route('home') }}">
		<i class="menu-icon fa fa-tachometer"></i>
		<span class="menu-text"> @lang('pageTitle.dashboard') </span>
	</a>

	<b class="arrow"></b>
</li>

<li class="{{ (\Request::segment(1) == 'user-manage')? 'open' : '' }}">
	<a href="" class="dropdown-toggle">
		<i class="menu-icon fa fa-user"></i>
		<span class="menu-text"> @lang('pageTitle.users_manage') </span>
		<b class="arrow fa fa-angle-down"></b>
	</a>

	<b class="arrow"></b>
	<ul class="submenu">
		<li class="{{ (\Request::segment(2) == 'users')? 'active' : '' }}">
			<a href="{{ route('users.index') }}">
				<i class="menu-icon fa fa-caret-right"></i>
				@lang('pageTitle.users_page')
			</a>

			<b class="arrow"></b>
		</li>
		<li class="{{ (\Request::segment(2) == 'roles')? 'active' : '' }}">
			<a href="{{ route('roles.index') }}">
				<i class="menu-icon fa fa-caret-right"></i>
				角色資料
			</a>

			<b class="arrow"></b>
		</li>
	</ul>
</li>

<li class="">
	<a href="#" class="dropdown-toggle">
		<i class="menu-icon fa fa-picture-o"></i>
		<span class="menu-text"> 廣告管理 </span>
		<b class="arrow fa fa-angle-down"></b>
	</a>

	<b class="arrow"></b>
	<ul class="submenu">
		<li class="">
			<a href="#">
				<i class="menu-icon fa fa-caret-right"></i>
				廣告資料
			</a>

			<b class="arrow"></b>
		</li>
	</ul>
</li>

<li class="">
	<a href="#" class="dropdown-toggle">
		<i class="menu-icon fa fa-desktop"></i>
		<span class="menu-text"> KIOSK管理 </span>
		<b class="arrow fa fa-angle-down"></b>
	</a>

	<b class="arrow"></b>
	<ul class="submenu">
		<li class="">
			<a href="#" >
				<i class="menu-icon fa fa-caret-right"></i>
				KIOSK資料
			</a>

			<b class="arrow"></b>
		</li>
	</ul>
</li>

<li class="">
	<a href="#" class="dropdown-toggle">
		<i class="menu-icon fa fa-book"></i>
		<span class="menu-text"> 文章管理 </span>
		<b class="arrow fa fa-angle-down"></b>
	</a>

	<b class="arrow"></b>
	<ul class="submenu">
		<li class="">
			<a href="#" >
				<i class="menu-icon fa fa-caret-right"></i>
				文章資料
			</a>

			<b class="arrow"></b>
		</li>
	</ul>
</li>

<li class="">
	<a href="#" class="dropdown-toggle">
		<i class="menu-icon fa fa-cogs"></i>
		<span class="menu-text"> 系統管理 </span>
		<b class="arrow fa fa-angle-down"></b>
	</a>

	<b class="arrow"></b>
	<ul class="submenu">
		<li class="">
			<a href="#" >
				<i class="menu-icon fa fa-caret-right"></i>
				系統操作紀錄查詢
			</a>

			<b class="arrow"></b>
		</li>
		<li class="">
			<a href="#" >
				<i class="menu-icon fa fa-caret-right"></i>
				系統參數設定
			</a>

			<b class="arrow"></b>
		</li>
	</ul>
</li>
