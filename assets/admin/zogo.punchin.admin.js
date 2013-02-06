//Sliding Up and Down Information.

jQuery(document).ready(function($){
	$(".timecardslide").hide()
	$(".usertimecard").click(function(e){
	  //e.preventDefault();
	  $(this).closest('td').nextSibling().slideToggle();
	});
});