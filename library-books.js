( function( $ ) {
	"use strict";
	
	jQuery( document ).ready(function() {
		$( ".regular-datepicker" ).datepicker();
		$( "#slider-range" ).slider({
		  range: true,
		  min: 1,
		  max: 300,
		  values: [ 1, 300 ],
		  slide: function( event, ui ) {
			$( "#price" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
		  }
		});
		$( "#price" ).val( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );
	
		
		$("#library-book-submit").on( "click", function(event ){
			
			jQuery.ajax({
				url: bookconfig.ajaxurl,
				type:'post',
				data: 'action=library_book_search&' + jQuery( 'form#library-book-search-form' ).serialize(),				
				beforeSend: function() {
					
				},
				success: function( data ){
					var $html = $(data);
					console.log( $html.find('#load-book-lists').html());
					$('#load-book-lists').html( $html.find('#load-book-lists').html() )
				},
				
			});
			
			event .preventDefault();
			return false;
			
		});
		
	});
	
	 
})( jQuery );