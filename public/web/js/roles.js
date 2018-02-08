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
// 標題分類資料權限全選
function selectAllCategories() {
    $('#categories_selectAll').click(function() {
        if($('#categories_selectAll').prop("checked")) {
            $("input[id='categories_permission[]']").prop('checked', true);
        } else {
            $("input[id='categories_permission[]']").prop('checked', false);
        }
    });
}
// 廣告資料權限全選
function selectAllAdvertisements() {
    $('#advertisements_selectAll').click(function() {
        if($('#advertisements_selectAll').prop("checked")) {
            $("input[id='advertisements_permission[]']").prop('checked', true);
        } else {
            $("input[id='advertisements_permission[]']").prop('checked', false);
        }
    });
}
// KIOSK資料權限全選
function selectAllKiosks() {
    $('#kiosks_selectAll').click(function() {
        if($('#kiosks_selectAll').prop("checked")) {
            $("input[id='kiosks_permission[]']").prop('checked', true);
        } else {
            $("input[id='kiosks_permission[]']").prop('checked', false);
        }
    });
}
// KIOSK地區群組權限全選
function selectAllAreaGroups() {
    $('#areagroups_selectAll').click(function () {
        if ($('#areagroups_selectAll').prop("checked")) {
            $("input[id='areagroups_permission[]']").prop('checked', true);
        } else {
            $("input[id='areagroups_permission[]']").prop('checked', false);
        }
    });
} 
// 系統參數設定權限全選
function selectAllSettings() {
    $('#settings_selectAll').click(function() {
        if($('#settings_selectAll').prop("checked")) {
            $("input[id='settings_permission[]']").prop('checked', true);
        } else {
            $("input[id='settings_permission[]']").prop('checked', false);
        }
    });
}
// 系統操作紀錄權限全選
function selectAllActionlogs() {
    $('#actionlogs_selectAll').click(function() {
        if($('#actionlogs_selectAll').prop("checked")) {
            $("input[id='actionlogs_permission[]']").prop('checked', true);
        } else {
            $("input[id='actionlogs_permission[]']").prop('checked', false);
        }
    });
}
// 系統排程監控權限全選
function selectAllSchedules() {
    $('#schedules_selectAll').click(function() {
        if($('#schedules_selectAll').prop("checked")) {
            $("input[id='schedules_permission[]']").prop('checked', true);
        } else {
            $("input[id='schedules_permission[]']").prop('checked', false);
        }
    });
}
