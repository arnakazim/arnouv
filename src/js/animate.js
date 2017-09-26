$(document).ready(function(){
	var bodyHeight = $(document).height();

	console.log(bodyHeight);

	$(document).scroll(function() {
		
		var scrollPos = $(document).scrollTop();
		var documentHeight = $(document).height();
		var windowHeight = $(window).height();

		var scrollAchieved = Math.round(scrollPos/(documentHeight-windowHeight)*1000)/10;

		$('.scroll-indicator-bar').width(scrollAchieved + '%');
	});

	// var parallaxHeight = 0.9 * $(window).height() - $('#home-parallax').offset().top;
	// $('#home-parallax').height(parallaxHeight + 'px');
	// console.log(parallaxHeight);

	$("#navbar a[href^='#']").click(function(e) {

   // prevent default anchor click behavior
   e.preventDefault();

   // store hash
   var hash = this.hash;

   // animate
   $('html, body').animate({
       scrollTop: $(hash).offset().top - $('body').data('offset')
     }, 750, 'swing', function(){});

});
})