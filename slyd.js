jQuery(document).ready(function(){
	var i = 1;
	
	jQuery(".a_slyd").css({ height: slyd_height });
	jQuery(".slyd_content").css({ height: slyd_height });
	
	if ( slyd_titles == false ) {
		jQuery(".slyd_title").hide();
	}
	
	if ( slyd_captions == false ) {
		jQuery(".slyd_caption").hide();
	}
	
	if ( slyd_posts == 1 ) {
		jQuery(".slyd_nav").hide();
	}
	
	function hideNav(){
		if ( i <= 1 && jQuery(".slyd_previous").not(":hidden") ) {
			jQuery(".slyd_previous").fadeOut(500);
		} else if ( i >= slyd_posts && jQuery(".slyd_next").not(":hidden") ) {
			jQuery(".slyd_next").fadeOut(500);
		} else {
			jQuery(".slyd_previous:hidden").fadeIn(500);
			jQuery(".slyd_next:hidden").fadeIn(500);
		}
	}
	
	jQuery(".slyd_previous").click(function(){
		jQuery(".slyd_wrapper").animate({
			marginLeft: '+=100%'
			}, 500
		);
		i--;
		hideNav();
	});
	
	jQuery(".slyd_next").click( function() {
		jQuery(".slyd_wrapper").animate({
			marginLeft: '-=100%'
			}, 500
		);
		i++;
		hideNav();
	});
});