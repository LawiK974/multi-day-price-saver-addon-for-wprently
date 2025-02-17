(function($) {
    jQuery(document).ready(function() {
        jQuery(".rbfw_seasonal_price_config_wrapper .date_type").datepicker({ dateFormat: 'yy-mm-dd' });
    });
    jQuery(document).on('click', '.mp_item_remove,.mp_remove_icon', function() {
        if (confirm('Are You Sure , Remove this row ? \n\n 1. Ok : To Remove . \n 2. Cancel : To Cancel .')) {
            jQuery(this).closest('.mp_remove_area').slideUp(250, function() {
                jQuery(this).remove();
            });
            return true;
        }
        return false;
    });
    jQuery(document).on('click', '.mp_add_item', function() {
        let parent = jQuery(this).closest('.rbfw_seasonal_price_config_wrapper');
        let item = parent.find('.mp_hidden_content').first().find('.mp_hidden_item').html();
        parent.find('.mp_item_insert').first().append(item).promise().done(function() {
            parent.find(".date_type").removeClass('hasDatepicker').attr('id', '').removeData('datepicker').unbind().datepicker({ dateFormat: 'yy-mm-dd' });
        });
    });
})(jQuery);