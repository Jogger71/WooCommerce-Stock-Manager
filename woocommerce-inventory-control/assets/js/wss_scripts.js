
jQuery( document ).ready( function( $ ) {
	$( '.out_of_stock').change( function() {
		var id = $(this).attr( 'data-id' );
		$( '[type="number"][name="reorder_stock_set_point[' + id + ']"').attr( 'min', + $( this).val() + 1 );
	});

	$( '.reorder_stock' ).change( function() {
		var id = $( this ).attr( 'data-id' );
		$( '[type="number"][name="out_of_stock_set_point[' + id + ']"' ).attr( 'max', + $( this ).val() - 1 );
		$( '[type="number"][name="low_stock_set_point[' + id + ']"' ).attr( 'min', + $( this ).val() + 1 );
	});

	$( '.low_stock' ).change( function() {
		var id = $( this ).attr( 'data-id' );
		$( '[type="number"][name="reorder_stock_set_point[' + id + ']"').attr( 'max', + $( this).val() - 1 );
	});

	$( '.wcic_dropdown' ).select2();
});