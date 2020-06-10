jQuery(document).ready(function($) {
	$('[data-fancybox="gallery"]').fancybox({

	});
	// слайдер поселка
	$('.slider-village .slider-big .resize a, .slider-village .slider-for img').click(function(event) {
		event.preventDefault();
		$('.slider-village .slider-big .slick-current a').trigger('click');
	});
	// слайдер по домам
	$('.items-house .slider-big a.resize-house, .items-house .slider-for img').click(function(event) {
		event.preventDefault();
		idHouse = $(this).attr('id-house'); // alert(idHouse);
		// $('.items-house .slider-big .slick-current a').trigger('click');
		$('.items-house .slider-house-'+idHouse+' .slick-current a').trigger('click');
	});
});
