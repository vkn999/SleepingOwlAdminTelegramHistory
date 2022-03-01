$(function() {

    // Cookie identificator
    if (typeof remember_nested_set_model_state_id === 'undefined') {
        var remember_nested_set_model_state_id = window.location.pathname;
    }
    //console.log('remember_nested_set_model_state_id = ' + remember_nested_set_model_state_id);

    // Get current remembered state
    let remember = getCookie(remember_nested_set_model_state_id) || {};
    //let remember = {};
    if (typeof remember === 'string') {
        remember = JSON.parse(remember);
    }
    //console.log(remember);
    //console.log(Object.keys(remember).length);

    // If we have some remembered data...
    if (Object.keys(remember).length) {
        // Apply it!
        $.each(remember, function(index, value) {
            let item = $('.dd-list .dd-item[data-id=' + index + ']');
            //console.log(item);
            if (item) {
                if (value === 'collapse' && !item.hasClass('dd-collapsed')) {
                    // to Collapse
                    $(item).find('button[data-action=collapse]').trigger('click');
                } else if (value === 'expand' && item.hasClass('dd-collapsed')) {
                    // to Expand
                    $(item).find('button[data-action=expand]').trigger('click');
                }
            }
        });
    }

    // Remember item state on click
    $(document).on('click', '.dd-list .dd-item > button', function () {
        let action = $(this).attr('data-action');
        let item_id = $(this).parent().attr('data-id');
        //console.log('item_id = ' + item_id + ' / action = ' + action);

        remember[item_id] = action;
        //console.log(remember);

        setCookie(remember_nested_set_model_state_id, JSON.stringify(remember), 60*60*24*30);
    });
});