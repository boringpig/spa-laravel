<li class="">
	<a href="{{ route('home') }}">
		<i class="menu-icon fa fa-tachometer"></i>
		<span class="menu-text"> @lang('pageTitle.dashboard') </span>
	</a>

	<b class="arrow"></b>
</li>

@if(in_array('users', $role_menu) || in_array('roles', $role_menu))
<li class="{{ (\Request::segment(1) == 'user-manage')? 'open' : '' }}">
	<a href="" class="dropdown-toggle">
		<i class="menu-icon fa fa-users"></i>
		<span class="menu-text"> @lang('pageTitle.user-manage') </span>
		<b class="arrow fa fa-angle-down"></b>
	</a>

	<b class="arrow"></b>
	<ul class="submenu">
		@if(in_array('users', $role_menu))
		<li class="{{ (\Request::segment(2) == 'users')? 'active' : '' }}">
			<a href="{{ route('users.index') }}">
				<i class="menu-icon fa fa-caret-right"></i>
				@lang('pageTitle.users_page')
			</a>

			<b class="arrow"></b>
		</li>
		@endif
		@if(in_array('roles', $role_menu))
		<li class="{{ (\Request::segment(2) == 'roles')? 'active' : '' }}">
			<a href="{{ route('roles.index') }}">
				<i class="menu-icon fa fa-caret-right"></i>
				@lang('pageTitle.roles_page')
			</a>

			<b class="arrow"></b>
		</li>
		@endif
	</ul>
</li>
@endif

@if(in_array('advertisements', $role_menu))
<li class="{{ (\Request::segment(1) == 'advertisement-manage')? 'open' : '' }}">
	<a href="#" class="dropdown-toggle">
		<i class="menu-icon fa fa-picture-o"></i>
		<span class="menu-text"> @lang('pageTitle.advertisement-manage') </span>
		<b class="arrow fa fa-angle-down"></b>
	</a>

	<b class="arrow"></b>
	<ul class="submenu">
		<li class="{{ (\Request::segment(2) == 'advertisements')? 'active' : '' }}">
			<a href="{{ route('advertisements.index') }}">
				<i class="menu-icon fa fa-caret-right"></i>
				@lang('pageTitle.advertisements_page')
			</a>

			<b class="arrow"></b>
		</li>
	</ul>
</li>
@endif

@if(in_array('kiosks', $role_menu))
<li class="{{ (\Request::segment(1) == 'kiosk-manage')? 'open' : '' }}">
	<a href="#" class="dropdown-toggle">
		<i class="menu-icon fa fa-desktop"></i>
		<span class="menu-text"> @lang('pageTitle.kiosk-manage') </span>
		<b class="arrow fa fa-angle-down"></b>
	</a>

	<b class="arrow"></b>
	<ul class="submenu">
		<li class="{{ (\Request::segment(2) == 'kiosks')? 'active' : '' }}">
			<a href="{{ route('kiosks.index') }}">
				<i class="menu-icon fa fa-caret-right"></i>
				@lang('pageTitle.kiosks_page')
			</a>

			<b class="arrow"></b>
		</li>
		<li class="">
			<a href="#" >
				<i class="menu-icon fa fa-caret-right"></i>
				KIOSK地区群组
			</a>

			<b class="arrow"></b>
		</li>
	</ul>
</li>
@endif

@if(in_array('articles', $role_menu) || in_array('categories', $role_menu))
<li class="{{ (\Request::segment(1) == 'article-manage')? 'open' : '' }}">
	<a href="" class="dropdown-toggle">
		<i class="menu-icon fa fa-book"></i>
		<span class="menu-text"> @lang('pageTitle.article-manage') </span>
		<b class="arrow fa fa-angle-down"></b>
	</a>

	<b class="arrow"></b>
	<ul class="submenu">
		@if(in_array('articles', $role_menu))
		<li class="{{ (\Request::segment(2) == 'articles')? 'active' : '' }}">
			<a href="{{ route('articles.index') }}" >
				<i class="menu-icon fa fa-caret-right"></i>
				@lang('pageTitle.articles_page')
			</a>

			<b class="arrow"></b>
		</li>
		@endif
		@if(in_array('categories', $role_menu))
		<li class="{{ (\Request::segment(2) == 'categories')? 'active' : '' }}">
			<a href="{{ route('categories.index') }}" >
				<i class="menu-icon fa fa-caret-right"></i>
				@lang('pageTitle.categories_page')
			</a>

			<b class="arrow"></b>
		</li>
		@endif
	</ul>
</li>
@endif

@if(in_array('settings', $role_menu) || in_array('actionlogs', $role_menu))
<li class="{{ (\Request::segment(1) == 'setting-manage')? 'open' : '' }}">
	<a href="#" class="dropdown-toggle">
		<i class="menu-icon fa fa-cogs"></i>
		<span class="menu-text"> @lang('pageTitle.setting-manage') </span>
		<b class="arrow fa fa-angle-down"></b>
	</a>

	<b class="arrow"></b>
	<ul class="submenu">
		@if(in_array('actionlogs', $role_menu))
		<li class="{{ (\Request::segment(2) == 'actionlogs')? 'active' : '' }}">
			<a href="{{ route('actionlogs.index') }}" >
				<i class="menu-icon fa fa-caret-right"></i>
				@lang('pageTitle.actionlogs_page')
			</a>

			<b class="arrow"></b>
		</li>
		@endif
		@if(in_array('settings', $role_menu))
		<li class="{{ (\Request::segment(2) == 'settings')? 'active' : '' }}">
			<a href="{{ route('settings.index') }}" >
				<i class="menu-icon fa fa-caret-right"></i>
				@lang('pageTitle.settings_page')
			</a>

			<b class="arrow"></b>
		</li>
		@endif
	</ul>
</li>
@endif