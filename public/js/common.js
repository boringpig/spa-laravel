// 顯示錯誤訊息
function errorMessage(msg)
{
    $.gritter.add({
        title: msg,
        class_name: "gritter-error",
        sticky: false,
        time: 2000,
    });	
}

// 顯示成功訊息
function successMessage(msg)
{
    $.gritter.add({
        title: msg,
        class_name: "gritter-success",
        sticky: false,
        time: 2000,
    });	
}

// 刪除方法
function deleteData(content,title,url,csrf_token,redirect)
{
    $("#confirm-dialog").removeClass('hide').dialog({
        resizable: false,
        width: '320',
        modal: true,
        title: `<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-exclamation-triangle red'></i> ${title}</h4></div>`,
        title_html: true,
        open: function () {
            $("#confirm-dialog").html(content);
        },
        buttons: [
            {
                html: "<i class='ace-icon fa fa-trash-o bigger-110'></i>&nbsp; 删除",
                "class": "btn btn-danger btn-minier",
                click: function () {
                    $.ajax({
                        type: 'DELETE',
                        url: url,
                        data: {"_token": csrf_token },
                        success: function (data, textStatus, jqXHR) {
                            $("#confirm-dialog").removeClass('hide').dialog({
                                resizable: false,
                                width: '320',
                                modal: true,
                                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-check bigger-110 green'></i> 删除资料成功</h4></div>",
                                title_html: true,
                                open: function () {
                                    $("#confirm-dialog").html(content);
                                },
                                buttons: [
                                    {
                                        html: "确定",
                                        "class": "btn btn-primary btn-minier",
                                        click: function () {
                                            location.href = redirect;
                                            $(this).dialog("close");
                                        }
                                    }
                                ]
                            });
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            $("#confirm-dialog").removeClass('hide').dialog({
                                resizable: false,
                                width: '320',
                                modal: true,
                                title: "<div class='widget-header'><h4 class='smaller'><i class='ace-icon fa fa-times bigger-110 red'></i> 删除资料失败</h4></div>",
                                title_html: true,
                                open: function () {
                                    $("#confirm-dialog").html("<h4 class='center'>"+ jqXHR.responseJSON.RetMsg + "</h4>");
                                },
                                buttons: [
                                    {
                                        html: "确定",
                                        "class": "btn btn-primary btn-minier",
                                        click: function () {
                                            $(this).dialog("close");
                                        }
                                    }
                                ]
                            });
                        }
                    });
                    $(this).dialog("close");
                }
            },
            {
                html: "<i class='ace-icon fa fa-times bigger-110'></i>&nbsp; 取消",
                "class": "btn btn-minier",
                click: function () { 
                    $(this).dialog("close");
                }
            }
        ]
    });
}