@extends('layouts.app')

@section('breadcrumb')
<li>
    <i class="ace-icon fa fa-users users-icon"></i>
    @lang('pageTitle.users_manage')
</li>
<li>
    <a href="{{ route('users') }}">@lang('pageTitle.users_page')</a>
</li>
@endsection

@section('content')
     <div class="page-header">
        <h1>
            @lang('pageTitle.users_page')
        </h1>
    </div><!-- /.page-header -->

    <div class="row">
        <div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<form id="search_form" class="form-inline">
						<div class="form-group">
							<label for="status" class="control-label">@lang('form.status')：</label>
							<select class="form-control" name="status" id="status">
								<option value="">@lang('form.all')</option>
								<option value="0">@lang('form.disable')</option>
								<option value="1">@lang('form.enable')</option>
							</select>
						</div>
						<div class="form-group">
							<label for="role" class="control-label">@lang('form.username')：</label>
							<input type="text" name="username" id="username">
						</div>
						<div class="pull-right">
							<button type="submit" class="btn btn-info btn-sm">
								<span class="fa fa-search"> @lang('form.search')</span>
							</button>
							<a href="{{ route('users.create') }}" class="btn btn-success btn-sm">
								<span class="fa fa-plus"> @lang('form.create')</span>
							</a>
						</div>
					</form>
				</div>
				<div class="panel-body">
					<table id="grid-table"></table>
					<div id="grid-pager"></div>
				</div>
			</div>
            
        </div><!-- /.col -->
    </div><!-- /.row -->
@endsection

@section('script')
<script type="text/javascript">
	$(function ($) {
		fetch_data();
	});
	// 送出表單
	$('#search_form').submit(function(event) {
		event.preventDefault();
		var args = {
			"status": $('#status').val(),
			"username": $('#username').val(),
			"_token": "{{ csrf_token() }}",
		};
		fetch_data(args);
	});
	// 撈取全部的使用者資料
	function fetch_data(args) {
		if (args == undefined) {
			form_data = { "_token": "{{ csrf_token() }}" }; 
		} else {
			form_data = args
		}
		$.ajax({
			type:'GET',
			url:'/api/users',
			data: form_data,
			success: function (data, textStatus, jqXHR) {
				$.jgrid.gridUnload("#grid-table"); 
				createNewGrid(data.RetVal);
			},
			error:  function (jqXHR, textStatus, errorThrown) {
				$('#data-info').show();
			}
		});
	}
	// 渲染為 jqGrid 套件
	function createNewGrid(grid_data) {
		var grid_selector = "#grid-table";
		var pager_selector = "#grid-pager";
		jQuery(grid_selector).jqGrid({
			data: grid_data,
			datatype: "local",
			height: 300,
			colNames: ['状态', '帐号', '姓名', '信箱', '电话号码', '修改时间', ''],
			colModel: [
				{ name: 'status', index: 'status', align: 'center', width: 40, formatter: statusrenderer},
				{ name: 'username', index: 'username', align: 'center', width: 90},
				{ name: 'name', index: 'name', align: 'center', width: 90},
				{ name: 'email', index: 'email', align: 'center', width: 110},
				{ name: 'phone', index: 'phone', align: 'center', width: 90},
				{ name: 'updated_at', index: 'updated_at', align: 'center', width: 90, sorttype: "date"},
				{ name: 'id', index: 'id', align: 'center', width: 80, formatter: actionrenderer}
				//{name:'ship',index:'ship', width:90, editable: true,edittype:"select",editoptions:{value:"FE:FedEx;IN:InTime;TN:TNT;AR:ARAMEX"}},
				//{name:'note',index:'note', width:150, sortable:false,editable: true,edittype:"textarea", editoptions:{rows:"2",cols:"10"}},
				// {
				// 	name: 'myac', index: '', width: 80, fixed: true, sortable: false, resize: false,
				// 	formatter: 'actions',
				// 	formatoptions: {
				// 		keys: true,
				// 		//delbutton: false,//disable delete button

				// 		delOptions: { recreateForm: true, beforeShowForm: beforeDeleteCallback },
				// 		//editformbutton:true, editOptions:{recreateForm: true, beforeShowForm:beforeEditCallback}
				// 	}
				// }
			],

			viewrecords: true,  // 觀看筆數
			rowNum: 10,         // 預設顯示的頁數
			rowList: [10, 20, 30],  // 頁數清單
			pager: pager_selector, //  table 頁尾
			altRows: true,
			//toppager: true,  // 頁尾的位置

			// multiselect: true, // 多選checkbox
			// multikey: "ctrlKey",
			// multiboxonly: true,

			loadComplete: function () {
				var table = this;
				setTimeout(function () {
					styleCheckbox(table);

					updateActionIcons(table);
					updatePagerIcons(table);
					enableTooltips(table);
				}, 0);
			},

			editurl: "./dummy.php", //nothing is saved // php 後端路由
			//caption: "{{ trans('message.search_result') }}",  // table 表頭

			autowidth: true,

			// 將特定欄位用群組顯示
			// grouping:true, 
			// groupingView : { 
			// 	 groupField : ['name'],
			// 	 groupDataSorted : true,
			// 	 plusicon : 'fa fa-chevron-down bigger-110',
			// 	 minusicon : 'fa fa-chevron-up bigger-110'
			// },
			// caption: "Grouping"

		});
		$(window).triggerHandler('resize.jqGrid');//trigger window resize to make the grid get the correct size

		//switch element when editing inline
		function aceSwitch(cellvalue, options, cell) {
			setTimeout(function () {
				$(cell).find('input[type=checkbox]')
					.addClass('ace ace-switch ace-switch-5')
					.after('<span class="lbl"></span>');
			}, 0);
		}
		//enable datepicker
		function pickDate(cellvalue, options, cell) {
			setTimeout(function () {
				$(cell).find('input[type=text]')
					.datepicker({ format: 'yyyy-mm-dd', autoclose: true });
			}, 0);
		}


		// table 操作的功能
		jQuery(grid_selector).jqGrid('navGrid', pager_selector,
			{ 	//navbar options
				edit: false,
				editicon: 'ace-icon fa fa-pencil blue',
				add: false,
				addicon: 'ace-icon fa fa-plus-circle purple',
				del: false,
				delicon: 'ace-icon fa fa-trash-o red',
				search: false,
				searchicon: 'ace-icon fa fa-search orange',
				refresh: false,
				refreshicon: 'ace-icon fa fa-refresh green',
				view: false,
				viewicon: 'ace-icon fa fa-search-plus grey',
			},
			{
				//edit record form
				//closeAfterEdit: true,
				//width: 700,
				recreateForm: true,
				beforeShowForm: function (e) {
					var form = $(e[0]);
					form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
					style_edit_form(form);
				}
			},
			{
				//new record form
				//width: 700,
				closeAfterAdd: true,  //  新增完後關閉視窗
				recreateForm: true,
				errorTextFormat: function (data) {  // 錯誤訊息
					return 'Error: ' + data.responseText
				},
				beforeShowForm: function (e) {   //顯示表單
					var form = $(e[0]);
					form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
					style_edit_form(form);
				}
			},
			{
				//delete record form
				recreateForm: true,
				beforeShowForm: function (e) {
					var form = $(e[0]);
					if (form.data('styled')) return false;

					form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
					style_delete_form(form);

					form.data('styled', true);
				},
				onClick: function (e) {
					//alert(1);
				}
			},
			{
				//search form
				recreateForm: true,
				afterShowSearch: function (e) {
					var form = $(e[0]);
					form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
					style_search_form(form);
				},
				afterRedraw: function () {
					style_search_filters($(this));
				}
				,
				multipleSearch: true,
				/**
				multipleGroup:true,
				showQuery: true
				*/
			},
			{
				//view record form
				recreateForm: true,
				beforeShowForm: function (e) {
					var form = $(e[0]);
					form.closest('.ui-jqdialog').find('.ui-jqdialog-title').wrap('<div class="widget-header" />')
				}
			}
		)

		// 編輯表單
		function style_edit_form(form) {
			//enable datepicker on "sdate" field and switches for "stock" field
			//form.find('input[name=updated_at]').datepicker({format:'yyyy-mm-dd' , autoclose:true})

			form.find('input[name=active]').addClass('ace ace-switch ace-switch-5').after('<span class="lbl"></span>');
			//don't wrap inside a label element, the checkbox value won't be submitted (POST'ed)
			//.addClass('ace ace-switch ace-switch-5').wrap('<label class="inline" />').after('<span class="lbl"></span>');


			//update buttons classes
			var buttons = form.next().find('.EditButton .fm-button');
			buttons.addClass('btn btn-sm').find('[class*="-icon"]').hide();//ui-icon, s-icon
			buttons.eq(0).addClass('btn-primary').prepend('<i class="ace-icon fa fa-check"></i>');
			buttons.eq(1).prepend('<i class="ace-icon fa fa-times"></i>')

			buttons = form.next().find('.navButton a');
			buttons.find('.ui-icon').hide();
			buttons.eq(0).append('<i class="ace-icon fa fa-chevron-left"></i>');
			buttons.eq(1).append('<i class="ace-icon fa fa-chevron-right"></i>');
		}

		// 刪除表單
		function style_delete_form(form) {
			var buttons = form.next().find('.EditButton .fm-button');
			buttons.addClass('btn btn-sm btn-white btn-round').find('[class*="-icon"]').hide();//ui-icon, s-icon
			buttons.eq(0).addClass('btn-danger').prepend('<i class="ace-icon fa fa-trash-o"></i>');
			buttons.eq(1).addClass('btn-default').prepend('<i class="ace-icon fa fa-times"></i>')
		}

		// 搜尋表單  
		function style_search_filters(form) {
			form.find('.delete-rule').val('X');
			form.find('.add-rule').addClass('btn btn-xs btn-primary');
			form.find('.add-group').addClass('btn btn-xs btn-success');
			form.find('.delete-group').addClass('btn btn-xs btn-danger');
		}
		function style_search_form(form) {
			var dialog = form.closest('.ui-jqdialog');
			var buttons = dialog.find('.EditTable')
			buttons.find('.EditButton a[id*="_reset"]').addClass('btn btn-sm btn-info').find('.ui-icon').attr('class', 'ace-icon fa fa-retweet');
			buttons.find('.EditButton a[id*="_query"]').addClass('btn btn-sm btn-inverse').find('.ui-icon').attr('class', 'ace-icon fa fa-comment-o');
			buttons.find('.EditButton a[id*="_search"]').addClass('btn btn-sm btn-purple').find('.ui-icon').attr('class', 'ace-icon fa fa-search');
		}

		// 刪除前的提示視窗
		function beforeDeleteCallback(e) {
			var form = $(e[0]);
			if (form.data('styled')) return false;

			form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
			style_delete_form(form);

			form.data('styled', true);
		}

		// 編輯前的提示視窗
		function beforeEditCallback(e) {
			var form = $(e[0]);
			form.closest('.ui-jqdialog').find('.ui-jqdialog-titlebar').wrapInner('<div class="widget-header" />')
			style_edit_form(form);
		}

		//it causes some flicker when reloading or navigating grid
		//it may be possible to have some custom formatter to do this as the grid is being created to prevent this
		//or go back to default browser checkbox styles for the grid
		function styleCheckbox(table) {
			/**	
			$(table).find('input:checkbox').addClass('ace')
			.wrap('<label />')
			.after('<span class="lbl align-top" />')
	
	
			$('.ui-jqgrid-labels th[id*="_cb"]:first-child')
			.find('input.cbox[type=checkbox]').addClass('ace')
			.wrap('<label />').after('<span class="lbl align-top" />');
			**/
		}


		//unlike navButtons icons, action icons in rows seem to be hard-coded
		//you can change them like this in here if you want
		function updateActionIcons(table) {
			/**
			var replacement = 
			{
				'ui-ace-icon fa fa-pencil' : 'ace-icon fa fa-pencil blue',
				'ui-ace-icon fa fa-trash-o' : 'ace-icon fa fa-trash-o red',
				'ui-icon-disk' : 'ace-icon fa fa-check green',
				'ui-icon-cancel' : 'ace-icon fa fa-times red'
			};
			$(table).find('.ui-pg-div span.ui-icon').each(function(){
				var icon = $(this);
				var $class = $.trim(icon.attr('class').replace('ui-icon', ''));
				if($class in replacement) icon.attr('class', 'ui-icon '+replacement[$class]);
			})
			*/
		}

		//replace icons with FontAwesome icons like above
		function updatePagerIcons(table) {
			var replacement =
				{
					'ui-icon-seek-first': 'ace-icon fa fa-angle-double-left bigger-140',
					'ui-icon-seek-prev': 'ace-icon fa fa-angle-left bigger-140',
					'ui-icon-seek-next': 'ace-icon fa fa-angle-right bigger-140',
					'ui-icon-seek-end': 'ace-icon fa fa-angle-double-right bigger-140'
				};
			$('.ui-pg-table:not(.navtable) > tbody > tr > .ui-pg-button > .ui-icon').each(function () {
				var icon = $(this);
				var $class = $.trim(icon.attr('class').replace('ui-icon', ''));

				if ($class in replacement) icon.attr('class', 'ui-icon ' + replacement[$class]);
			})
		}

		// 每一個按鈕的提示訊息
		function enableTooltips(table) {
			$('.navtable .ui-pg-button').tooltip({ container: 'body' });
			$(table).find('.ui-pg-div').tooltip({ container: 'body' });
		}

		//var selr = jQuery(grid_selector).jqGrid('getGridParam','selrow');
	}
	function statusrenderer(value) {
		if (value == '禁用') {
			return '<span class="label label-danger">' + value + '</span>';
		} else if (value == '啟用') {
			return '<span class="label label-success">' + value + '</span>';
		}
	}
	function actionrenderer(value) {
		console.log(value);
		return '<a></a>'
	}
</script>
@endsection