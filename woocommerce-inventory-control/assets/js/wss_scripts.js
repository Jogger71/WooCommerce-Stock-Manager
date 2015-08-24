
jQuery( document ).ready( function( $ ) {
	$( '.out_of_stock').change( function() {
		var id = $(this).attr( 'data-id' );
		$( '[type="number"][name="reorder_stock_set_point[ ' + id + ' ]"').attr( 'min', $( this).val().toInt() + 1 );
	});
});