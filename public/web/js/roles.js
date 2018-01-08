//  使用者資料權限全選
function selectAllUsers() {
    $('#users_selectAll').click(function() {
        if($('#users_selectAll').prop("checked")) {
            $("input[id='users_permission[]']").prop('checked', true);
        } else {
            $("input[id='users_permission[]']").prop('checked', false);
        }
    });
}
// 角色資料權限全選
function selectAllRoles() {
    $('#roles_selectAll').click(function() {
        if($('#roles_selectAll').prop("checked")) {
            $("input[id='roles_permission[]']").prop('checked', true);
        } else {
            $("input[id='roles_permission[]']").prop('checked', false);
        }
    });
}
// 文章資料權限全選
function selectAllArticles() {
    $('#articles_selectAll').click(function() {
        if($('#articles_selectAll').prop("checked")) {
            $("input[id='articles_permission[]']").prop('checked', true);
        } else {
            $("input[id='articles_permission[]']").prop('checked', false);
        }
    });
}