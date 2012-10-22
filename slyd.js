jQuery(document).ready(function(){
	/*****************************************
	* Available variables:
	******************************************
	*  
	*  slyd_posts		=	The number of posts to be displayed
	*						DEFAULT: 5
	*  
	*  slyd_height		=	A height value set by the user OR
	*						The height of the tallest image
	*						DEFAULT: auto
	*  
	*  slyd_nav			=	Show to display nav arrows OR
	*						Hide to hide nav arrows OR
	*						Hover to display nav arrows only on hover
	*						DEFAULT: hover
	*  
	*  slyd_titles		=	True to display titles OR
	*						False to hide titles
	*						DEFAULT: true
	*  
	*  slyd_captions	=	True to display captions OR
	*						False to hide captions
	*						DEFAULT: true
	*  
	*  slyd_autoadvance	=	True to autoadvance slydr OR
	*						False to stop autoadvance
	*						DEFAULT: true
	*  
	*  slyd_speed		=	A speed value in milliseconds set by the user
	*						DEFAULT: 4000
	*  
	*/
	
	// Expand Slyd once it loads
	//jQuery(".slyd").load(function(){
	//	jQuery(".slyd").removeClass(".slyd_loading");
	//});
	
	// Start a counter to measure slidecount against
	var i = 1;
		
	if ( ( slyd_height !== undefined ) ) {
		// Set Slyd's height based on setting from shortcode
		jQuery(".a_slyd").css({ height: slyd_height });
		jQuery(".slyd_content").css({ height: slyd_height });
	};
	
	// Show/Hide Titles and Captions based on setting from shortcode
	if ( slyd_titles == false ) { jQuery(".slyd_title").hide(); };
	if ( slyd_captions == false ) { jQuery(".slyd_caption").hide(); };
	
	// Hide Prev/Next arrows if we're on the first/last slide
	function hideNav() {
		if ( i <= 1 && jQuery(".slyd_previous").not(":hidden") ) {
			jQuery(".slyd_previous").fadeOut(500);
			jQuery(".slyd_next").fadeIn(500);
		} else if ( i >= slyd_posts && jQuery(".slyd_next").not(":hidden") ) {
			jQuery(".slyd_next").fadeOut(500);
			jQuery(".slyd_previous").fadeIn(500);
		} else {
			jQuery(".slyd_previous").fadeIn(500);
			jQuery(".slyd_next").fadeIn(500);
		};
	};
	
	// Create timer for changing slides
	function slyd_clock_analysis() {
		jQuery.doTimeout( "slyd_timer", slyd_speed, function() {
			slyd_next();
			return true;
		});
	};
	
	// Move to the next slide
	function slyd_next() {
		if ( i >= slyd_posts ) {
			jQuery(".slyd_wrapper").animate({
				marginLeft: '0%'
				}, 1000
			);
			i = 1;
		} else {
			jQuery(".slyd_wrapper").animate({
				marginLeft: '-=100%'
				}, 1000
			);
			i++;
		};
		hideNav();
	};
	
	// Move to previous slide
	function slyd_previous() {
		if ( i <= 1 ) {
			slyd_foo = ( slyd_posts - 1 ) + "00%";
			jQuery(".slyd_wrapper").animate({
				marginLeft: slyd_foo
				}, 1000
			);
			i = slyd_posts;
		} else {
			jQuery(".slyd_wrapper").animate({
				marginLeft: '+=100%'
				}, 1000
			);
			i--;
		}
		hideNav();
	};
	
	// Next arrow functionality
	jQuery(".slyd_next").click( function() {
		slyd_next();
		jQuery.doTimeout( "slyd_timer", true );
	});
	
	// Previous arrow functionality
	jQuery(".slyd_previous").click(function(){
		slyd_previous();
		jQuery.doTimeout( "slyd_timer", true );
	});
	
	// Things to change based on if there's 1 post or more
	if ( slyd_posts == 1 ) {
		// Hide the navigation arrows if there's only one post
		jQuery(".slyd_nav").hide();
	} else {
		// Stop the clock on hover, start it on mouseOut and on document ready
		jQuery(".slyd").hover( function() {
			jQuery.doTimeout( "slyd_timer" );
		}, function() {
			slyd_clock_analysis();
		});
		
		if ( slyd_autoadvance ) {
			// Stop clock on hover, restart it on mouseOut
			slyd_clock_analysis();
		};
		
		switch ( slyd_nav ) {
			case "show":
				jQuery(".slyd_nav").addClass("show_always");
				break;
			case "hide":
				jQuery(".slyd_nav").addClass("show_never");
				break;
			case "hover":
				jQuery(".slyd_nav").addClass("show_hover");
				break;
			default:
		}
	};
});