(function($){
    $(document).on('click','.rbao-item-info',function(){
        $('.rbao-item-details').html('');
        $(this).closest('.rbao-item').find('.rbao-item-details').stop(true, true).slideDown(400, 'swing');
        let post_id = $(this).data('post-id');
        rbfw_rent_detail(post_id);
    });
})(jQuery);

function rbfw_rent_detail(post_id){
    jQuery.ajax({
        type: 'POST',
        url: rbfw_ajax.rbfw_ajaxurl,
        data: {
            'action' : 'rbfw_rent_item_detail',
            'post_id': post_id
        },
        beforeSend: function() {
            //jQuery('.rbfw_admin_ajax_'+post_id).addClass('rbfw_loader_in');
           // jQuery('.rbfw_admin_ajax_'+post_id).append('<i class="fas fa-spinner fa-spin"></i>');
            jQuery('.rbfw_admin_ajax_loader').addClass('rbfw_loader_in');
            jQuery('.rbfw_admin_ajax_loader').append('<i class="fas fa-spinner fa-spin"></i>');
        },
        success: function (response) {
            //jQuery('.rbfw_admin_ajax_'+post_id).removeClass('rbfw_loader_in');
            //jQuery('.rbfw_admin_ajax_+'+post_id+' i.fa-spinner').remove();
            jQuery('.rbfw_admin_ajax_loader').removeClass('rbfw_loader_in');
            jQuery('.rbfw_admin_ajax_loader i.fa-spinner').remove();
            jQuery('#rent_detail_'+post_id).html(response);
        }
    });
}

(function($) {
    
    // =====================sidebar modal open close=============
	$(document).on('click', '[data-modal]', function (e) {
        e.preventDefault();
		const modalTarget = $(this).data('modal');
		$(`[data-modal-target="${modalTarget}"]`).addClass('open');
	});

	$(document).on('click', '[data-modal-target] .rbao-modal-close', function (e) {
		$(this).closest('[data-modal-target]').removeClass('open');
	});
})(jQuery);



jQuery(document).ready(function(jQuery) {

    jQuery( ".date_picker_appointment" ).datepicker({
        dateFormat: "yy-mm-dd",
        minDate: 0,
        beforeShowDay: function(date) {
            var enable_day = jQuery(this).data('enable_day');
            let d;
            enable_day = enable_day.toString();
            if (enable_day.indexOf(',') != -1) {
                d = enable_day.split(',')

            } else {
                d = [enable_day]
            }
            if (d.length > 0) {
                if (d.includes(date.getDay().toString())) {
                    return [true];
                }
            }
            return [false];
        },
        onSelect: function(dateText) {

            var post_id = jQuery(this).data('post_id');

            jQuery("#dropoff_date_"+post_id).datepicker("option","minDate", dateText);

            var rent_type = jQuery(this).data('rent_type');

            jQuery.ajax({
                type: 'POST',
                url: rbfw_ajax.rbfw_ajaxurl,
                data: {
                    'action' : 'rbfw_time_slot_list',
                    'post_id': post_id,
                    'selected_date': dateText,
                    'rent_type': rent_type,
                },
                success: function (response) {
                    jQuery('#rent_detail_'+post_id+' .rbfw_time_slot').html(response);
                    jQuery('#rent_detail_'+post_id+' .service_extra_service_custom_form').html('');
                    price_calculation(0,post_id);
                }
            })
        }
    });
})








