//Sliding Up and Down Information.

jQuery(function($) {
	
    $('.zogo_punchin_timecard_user').click(function(e) {
		
		var self = $(this);
		
		if(self.hasClass('zogo_punchin_timecard_user_active')) {
			self.removeClass('zogo_punchin_timecard_user_active');
		} else {
			self.addClass('zogo_punchin_timecard_user_active');
		}
		
        $(this).closest('tr').find('.zogo_punchin_user_time_table').slideToggle();
    });
    
});