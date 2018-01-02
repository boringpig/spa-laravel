// 顯示錯誤訊息的提示視窗
function showErrorDialog(msg,title,sure_button) {
    $("#error-dialog").removeClass('hide').dialog({
        resizable: false,
        width: '320',
        modal: true,
        title: `<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> ${title}</h4></div>`,
        title_html: true,
        open: function () {
            $("#error-dialog").html(msg);
        },
        buttons: [
            {
                text: sure_button,
                "class": "btn btn-primary btn-minier",
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });
}

// 顯示成功訊息的提示視窗
function showSuccessDialog(title,sure_button,cancel_button,redirectUrl) {
    $("#success-dialog").removeClass('hide').dialog({
        resizable: false,
        width: '320',
        modal: true,
        title: `<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-check'></i> ${title}</h4></div>`,
        title_html: true,
        open: function () {
            $("#success-dialog").html(msg);
        },
        buttons: [
            {
                text: cancel_button,
                "class" : "btn btn-minier",
                click: function() {
                    $( this ).dialog( "close" ); 
                } 
            },
            {
                text: sure_button,
                "class": "btn btn-primary btn-minier",
                click: function () {
                    $(this).dialog("close");
                    location.href = redirectUrl;
                }
            }
        ]
    });
}