jQuery(document).ready(function($) {











	var owl_similar = $('.owl-similar').owlCarousel({
		loop:true,
		margin:10,
		nav:true,
		items:1
	});


	$('.owl-similar').each(function(index, el) {
		var last_index = $(this).find('.owl-dots div').last().index();
		last_index = last_index + 1;
		$(this).append('<div class="count-owl"><span>1</span>/<span>' + last_index +'</span></div>');
	});

	owl_similar.on('changed.owl.carousel', function(event) {
		var th_index = $(this).find('.owl-dots div.active').index();
		$(this).find('.count-owl span').first().text(th_index + 1);
	})








	$('.owl-devoloper').owlCarousel({
		loop:true,
		margin:10,
		nav:true,
		items:5,
		responsive : {
			// breakpoint from 0 up
			// breakpoint from 0 up
			0 : {
				items:2,
				margin:20,
			},
			480 : {
				items:3,
				margin:20,
			},
			749 : {
				items:5,
			},
		}
	});

	$('.benefist-ul').owlCarousel({
		loop: false,
		margin:5,
		nav:true,
		items:5,
		responsive : {
			// breakpoint from 0 up
			// breakpoint from 0 up
			0 : {
				items:5,
			},
			400 : {
				items:6,
			},
			480 : {
				items:9,
			},
			750 : {
				items:6,
			},
			800 : {
				items:7,
			},
		}
	});

});
