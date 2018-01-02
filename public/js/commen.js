function showValidationDialog(msg) {
    $("#validation-dialog").removeClass('hide').dialog({
        resizable: false,
        width: '320',
        modal: true,
        title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> @lang('form.column_validation_error')</h4></div>",
        title_html: true,
        open: function () {
            $("#error-dialog").html(msg);
        },
        buttons: [
            {
                text: "@lang('form.sure')",
                "class": "btn btn-primary btn-minier",
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });
}