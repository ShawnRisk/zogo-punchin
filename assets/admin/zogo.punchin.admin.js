//Sliding Up and Down Information.

jQuery(document).ready(function($){
  $(".usertimecard").click(function(e){
	  e.preventDefault();
      $(".timecardslide").slideToggle();
  });
});