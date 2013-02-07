//Sliding Up and Down Information.

jQuery(function($) {
	
    $('.zogo_punchin_timecard_user').click(function(e) {
        $(this).closest('tr').find('.zogo_punchin_user_time_table').slideToggle();
    });
    
});