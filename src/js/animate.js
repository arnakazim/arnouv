// SMOOTH SCROLL ON ANCHOR CLICK

$(document).ready(function(){
	$("#navbar a[href^='#']").click(function(e) {
		e.preventDefault();
		var hash = this.hash;

		if(hash.length > 1) {
			$('html, body').animate({
				scrollTop: $(hash).offset().top - $('body').data('offset')
			}, 750, 'swing', function(){});
		}
	});
})