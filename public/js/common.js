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