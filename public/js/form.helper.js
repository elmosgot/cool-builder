var form = function() {
	return {
		init: function() {
			console.log( 'Initializing form helper...' );
		}
	}
}();

$(document).ready( function() {
	form.init();
});
