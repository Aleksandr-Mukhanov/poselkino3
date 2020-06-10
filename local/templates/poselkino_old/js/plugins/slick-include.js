jQuery(document).ready(function($) {
	$('.slider-for').slick({
		slidesToShow: 1,
		slidesToScroll: 1,
		arrows: false,
		fade: true,
		asNavFor: '.slider-nav',
		swipe: false,
		swipeToSlide: false,
		touchMove: false,
	});

	$('.slider-nav').slick({
		slidesToShow: 4,
		slidesToScroll: 1,
		asNavFor: '.slider-for',
		dots: false,
		focusOnSelect: true,
		infinite: false,
		responsive: [{
			breakpoint: 739,
			settings: {
				slidesToShow: 1,
			},
		},]
	});


	$('.slider-nav').each(function(index, el) {
		var last_index = $(this).find('.slick-list .list').last().index();
		last_index = last_index + 1;
		$(this).append('<div class="count-slick"><span>1</span>/<span>' + last_index +'</span></div>');
	});

	$('.slider-nav').on('afterChange', function(event, slick, direction){
		var th_index = $(this).find('.slick-list .list.slick-active').index();
		$('.count-slick span').first().text(th_index + 1);
	});






	$(window).load(function() {
		$('.slider-slick').addClass('load-slick');
	});
});
