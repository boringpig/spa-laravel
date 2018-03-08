/** 全選特定選單的按鈕權限 */
function selectAllResource() {
    $('.selectAll').click(function() {
        let resource = $(this).attr('name').split('_')[0];
        let permission = `${resource}_permission[]`;
        if($(this).prop('checked')) {
            $(`input[id='${permission}']`).prop('checked', true);
        } else {
            $(`input[id='${permission}']`).prop('checked', false);
        }
    });
}
