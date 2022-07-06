$(document).ready(function() {

		var currentSlide = 0;
		var lastSlide = 1;
		var slides = $('.slide');
		var numberOfSlides = slides.length;
		var slideShowInterval;
		var speed = 5000;
		var firstTime = 1; // page has just loaded

		// prvi slide
		nextSlide();
		//$("#slide1").fadeIn(900);
		// slideshow 
		slideShowInterval = setInterval(nextSlide, speed);
		

		function nextSlide() {
			if(currentSlide > numberOfSlides-1) {
				currentSlide=1;
				lastSlide = numberOfSlides;
			} else {
				lastSlide = currentSlide;
				currentSlide++;
			}
			showSlide();
			
		}

		function showSlide() {
				if(lastSlide > 0) {
					$("#slide"+lastSlide).fadeOut(900,function() {
						//$("#slide"+lastSlide).hide();
						$("#slide"+currentSlide).fadeIn(400);
					});
				}
				//$(".parallax-window").parallax();
				if(firstTime == 1) {
					$("#slide"+currentSlide).fadeIn(400);
					firstTime = 0;
				}
		}

});
