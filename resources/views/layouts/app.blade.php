<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta charset="utf-8" />
		<title>KIOSK - {{ empty($page_title)? "" : $page_title }}</title>
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
		@include('widgets.style')
		@yield('style')
		<!-- ace styles -->
		<link rel="stylesheet" href="{{ asset('assets/css/ace.min.css') }}" class="ace-main-stylesheet" id="main-ace-style" />
		<link rel="stylesheet" href="{{ asset('assets/css/ace-skins.min.css') }}" />
		<link rel="stylesheet" href="{{ asset('assets/css/ace-rtl.min.css') }}" />
	</head>

	<body class="skin-1">
        @include('widgets.header')

		<div class="main-container ace-save-state" id="main-container">
			<script type="text/javascript">
				try{ace.settings.loadState('main-container')}catch(e){}
			</script>

			<div id="sidebar" class="sidebar responsive ace-save-state">
				<script type="text/javascript">
					try{ace.settings.loadState('sidebar')}catch(e){}
				</script>

				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<button class="btn btn-success">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<button class="btn btn-info">
							<i class="ace-icon fa fa-pencil"></i>
						</button>

						<button class="btn btn-warning">
							<i class="ace-icon fa fa-users"></i>
						</button>

						<button class="btn btn-danger">
							<i class="ace-icon fa fa-cogs"></i>
						</button>
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
                </div><!-- /.sidebar-shortcuts -->
                
                <ul class="nav nav-list">
                    @include('widgets.sidebar')
				</ul><!-- /.nav-list -->

				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>
			</div>

			<div class="main-content">
				<div class="main-content-inner">
                    <div class="breadcrumbs ace-save-state" id="breadcrumbs">
                        <ul class="breadcrumb">
                            @yield('breadcrumb')
                        </ul><!-- /.breadcrumb -->
                    </div>
                    <div class="page-content">
						@include('widgets.message')
                        @yield('content')
                    </div><!-- /.page-content -->
				</div>
			</div><!-- /.main-content -->

			<div class="footer">
				<div class="footer-inner">
					<div class="footer-content">
                        @include('widgets.footer')
					</div>
				</div>
			</div>

			<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
				<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
			</a>
		</div><!-- /.main-container -->

		@include('widgets.script')
		@yield('script')
		<script>
			$('[data-toggle="tooltip"]').tooltip()
			$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
				_title: function(title) {
					var $title = this.options.title || '&nbsp;'
					if( ("title_html" in this.options) && this.options.title_html == true )
						title.html($title);
					else title.text($title);
				}
			}));
			$('.chosen-select').chosen({
				allow_single_deselect:true
			}); 
			@if(Session::has('success'))
				$.gritter.add({
					title: "{{ Session::get('success') }}",
					class_name: "gritter-success",
					sticky: false,
					time: 2000,
				});	
			@endif

			@if(Session::has('error'))
				$.gritter.add({
					title: "{{ Session::get('error') }}",
					class_name: "gritter-error",
					sticky: false,
					time: 2000,
				});	
			@endif

			$('#logout').click(function(event) {
				event.preventDefault();
				$.ajax({
					type:'POST',
					url:'/logout',
					data: {"_token": "{{ csrf_token() }}"},
					success: function (data, textStatus, jqXHR) {
						location.href = '/login';
					},
					error:  function (jqXHR, textStatus, errorThrown) {
						//
					}
				});
			});
		</script>
	</body>
</html>
