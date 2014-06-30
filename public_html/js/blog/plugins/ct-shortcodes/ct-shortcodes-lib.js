jQuery.noConflict()(function($){
	"use strict";
	$(document).ready(function() {

	
		$('.tab-content .tab-pane:first-child').addClass('active');

		$('.accordion-toggle').click( function() {

			if ( $(this).hasClass('clicked') ) {
				$(this).removeClass('clicked')
			} else $(this).addClass('clicked');		

		});


	});
});