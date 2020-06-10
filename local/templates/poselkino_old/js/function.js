jQuery(document).ready(function($) {
	/*load section*/
	$(window).load(function() {
		$('.section-card').addClass('load-section');
	});
	/*load section*/
	/*phone-block*/
	var th_span = $('.phone-block span').text();
	th_span = th_span.substring(0, th_span.length - 6);

	$('.phone-block span').text(th_span + '...');


	$('.phone-block .callback a').click(function(event) {
		event.preventDefault();
		$('.phone-block .callback').hide(0);
		var data_phone = $('.phone-block').attr('data-phone');
		$('.phone-block span').text(data_phone);
	});
	/*phone-block*/
	/*checkbox*/
	function checkbox_fun(th) {
		var checked = th.find('input').prop('checked');
		if(checked == true){
			th.addClass('active');
		}
		else{
			th.removeClass('active');
		}
	}
	$('label.checkbox').click(function(event) {
		checkbox_fun($(this))
	});
	$('label.checkbox[data-name]').click(function(event) { // клик Наличие домов
		var data_name = $(this).attr('data-name');
		$('label.checkbox[data-name=' + data_name + ']').not($(this)).removeClass('active').find('input').prop('checked', false);

		// ставим значение Дома и участки
		if($(this).find('input').prop('checked')){
			$('#arrFilter_2_3039150019').prop('checked', true);
			// alert('da');
		}else{
			$('#arrFilter_2_3039150019').prop('checked', false);
			// alert('net');
		}
	});
	$('label.checkbox').each(function(event) {
		checkbox_fun($(this))
	});
	/*checkbox*/
	/*swich-route*/
	$('.swich-route .list').click(function(event) {
		$('.swich-route .list').removeClass('active');
		$(this).addClass('active');
		var idne_th = $(this).index();
		$('.text-map .list').hide(0);
		$('.text-map .list').eq(idne_th).show(0);
	});
	/*swich-route*/
	/*select rating*/
	$('ul.select-ul li').hover(function() {
		$(this).addClass('active');
		$(this).prevAll('li').addClass('active');
	}, function() {
		$(this).parents('ul.select-ul').find('li').removeClass('active');
	});

	function check_star(th) {
		var checked = th.prop('checked');
		th.parents('ul.select-ul').find('li').removeClass('checked');
		if(checked == true){
			th.parents('li').prevAll('li').addClass('checked');
			th.parents('li').addClass('checked');
		}
	}

	$('ul.select-ul li input').click(function(event) {
		check_star($(this));
	});
	/*select rating*/
	/*tabs block*/
	$('.tab-swich .list').click(function(event) {
		$('.tab-swich .list').removeClass('active');
		$(this).addClass('active');
		var th_index = $(this).parents('.item').index();
		$('.tabs-item > .item').hide(0);
		$('.tabs-item > .item').eq(th_index).show(0);
	});
	/*tabs block*/
	/*slider hover*/
	$('.slider-hover').each(function(index, el) {
		var last_index = $(this).find('.item').last().index();
		last_index = last_index + 1;
		$(this).append('<div class="nav-ul-sl"></div>');
		for (var i = 0; i < last_index; i++) {
			$(this).find('.nav-ul-sl').append('<div></div>');
		}
		$(this).find('.nav-ul-sl div').first().addClass('active');

		var widht_div = 100 / last_index;
		$(this).find('.nav-ul-sl div').css('width', widht_div + '%');
	});


	$('.slider-hover .nav-ul-sl div').hover(function() {
		var th_index = $(this).index();
		$(this).parents('.slider-hover').find('.wr-slider-img .item').hide();
		$(this).parents('.slider-hover').find('.wr-slider-img .item').eq(th_index).show();
		$(this).parents('.nav-ul-sl').find('div').removeClass('active');
		$(this).addClass('active');
	}, function() {
		/* Stuff to do when the mouse leaves the element */
	});


	$(".slider-hover").on("swipeleft",function(){
		$(this).find('.nav-ul-sl div.active').next('div').mouseenter();
	});
	$(".slider-hover").on("swiperight",function(){
		$(this).find('.nav-ul-sl div.active').prev('div').mouseenter();
	});


	$('.similar-items .item').each(function(index, el) {
		var th_clone = $(this).find('> a').clone();
		$(this).find('.slider-hover .nav-ul-sl div').append(th_clone);
	});
	/*-----------filter-----------*/
	$('label.radio').each(function(index, el) {
		var checked = $(this).find('input').prop('checked');
		if(checked == true){
			$(this).addClass('active');
		}
		else{
			$(this).removeClass('active');
		}
	});

	$('label.radio').click(function(event) {
		$('label.radio').each(function(index, el) {
			var checked = $(this).find('input').prop('checked');
			if(checked == true){
				$(this).addClass('active');
			}
			else{
				$(this).removeClass('active');
			}
		});
	});

	$("label[data-has-modal='select-house']").each(function(event) {
		var th = $(this);
		var checked = th.find('input').prop('checked');
		if(checked == true){
			th.addClass('has-active');
		}
		else{
			th.removeClass('has-active');
		}
	});
	$("label[data-has-modal='select-house']").click(function(event) {
		var th = $(this);
		var checked = th.find('input').prop('checked');

		if(checked == true){
			th.addClass('has-active');
			$('.modal-window-checkbox').fadeIn(0).addClass('active');
		}
		else{
			th.removeClass('has-active');
			$('.modal-window-checkbox').fadeOut(0).removeClass('active');
		}
	});
	$("label[data-has-modal='select-house'] i").click(function(event) {
		event.preventDefault();
		$('.modal-window-checkbox').fadeIn(400).addClass('active');
		// $('html, body').addClass('over-body');
	});


	$('.close-win').click(function(event) {
		$('.modal-window-fil').fadeOut(400).removeClass('active');
		$('html, body').removeClass('over-body');
	});
	jQuery(document).click( function(event){
		if(jQuery(event.target).closest("label, .window, .radio, .ui-selectmenu-menu").length )
		return;
			$('.modal-window-fil').fadeOut(400).removeClass('active');
			$('html, body').removeClass('over-body');
		event.stopPropagation();
	});
	$('div.radio[data-wodal-fill]').click(function(event) {
		var wodal_fill = $(this).attr('data-wodal-fill');
		$(".modal-window-fil[data-wodal-fill='" + wodal_fill +"']").fadeIn(400).addClass('active');
		// $('html, body').addClass('over-body');

	});
	$(window).scroll(function(){
		if ($(this).scrollTop() > 300){
			$('.fixed-block').fadeIn(400);
		}
		else{
			$('.fixed-block').fadeOut(400);
		}
	});
	$('.scroll-top').click(function(event){
		$('html,body').animate({"scrollTop":0}, 950);
	});





	$('ul.ul-highway-cheked .title').click(function(event) {
		$(this).parents('li').find('label').each(function(index, el) {
			var checked = $(this).find('input').prop('checked');
			if(checked == false){
				$(this).parents('li').find('label input').prop('checked', 'checked');
				$(this).parents('li').find('label').addClass('active');
				return false;
			}
			else{

				$(this).parents('li').find('label input').removeAttr('checked', 'checked');
				$(this).parents('li').find('label').removeClass('active');
				return false;
			}
		});
	});



	/*-----------filter-----------*/
	/*------img-map-mobile--------*/
	$('.img-map-mobile .item').click(function(event) {
		$('.img-map-mobile .item').not($(this)).removeClass('active');
		$('.img-map-mobile .item').not($(this)).find('.modal-item').slideUp(200);
		$(this).find('.modal-item').slideToggle(200);
		$(this).toggleClass('active');
	});

	/*------img-map-mobile--------*/
	/*------has-mobile-swich------*/
	$('.has-mobile-swich').each(function(index, el) {

		var has_text = $('.has-mobile-swich').find('.item a.active').text();

		$(this).wrap('<div class="has-mobile-swich-wr"></div>');
		$(this).parents('.has-mobile-swich-wr').prepend('<div class="top-swich">' + has_text +  '<i class="fs1 parameters" aria-hidden="true" data-icon="&#x43;"></i>'+ '</div>')
	});

	$('.has-mobile-swich-wr .top-swich').click(function(event) {
		$(this).parents('.has-mobile-swich-wr').find('.has-mobile-swich').toggleClass('active');
		$(this).toggleClass('active');
	});


	jQuery(document).click( function(event){
		if(jQuery(event.target).closest(".top-swich").length )
		return;
			$('.has-mobile-swich').removeClass('active');
			$('.top-swich').removeClass('active');
		event.stopPropagation();
	});
	/*------has-mobile-swich------*/
	/*------tab-swich mobile------*/
	$('.tabs-wrapper .tab-swich').each(function(index, el) {

		var has_text = $('.tabs-wrapper .tab-swich').find('.list.active').text();

		$(this).wrap('<div class="has-mobile-swich-wr"></div>');
		$(this).parents('.has-mobile-swich-wr').prepend('<div class="top-swich"><span>' + has_text +  '</span><i class="fs1 parameters" aria-hidden="true" data-icon="&#x47;"></i>'+ '</div>')
	});



	$('.tabs-wrapper .tab-swich .item .list').click(function(event) {
		var th_text =  $(this).text();
		$('.tabs-wrapper .top-swich span').text(th_text);

		$('.tabs-section .has-mobile-swich-wr .top-swich').removeClass('active');
		$('.tabs-wrapper .tab-swich').removeClass('active');
	});
	/*------tab-swich mobile------*/
	$('.tabs-section .has-mobile-swich-wr .top-swich').click(function(event) {
		$(this).toggleClass('active');
		$('.tabs-wrapper .tab-swich').toggleClass('active');
	});

	function level_height(th){
		th.css('height', 'auto');
		var height_th = 0;
		th.each(function(index, el) {
			var hi_each = jQuery(this).outerHeight();
			if(hi_each > height_th){
				height_th = hi_each;
			}
		});
		th.css('height', height_th - 13 + 'px');
	};
	level_height(jQuery('.flex-filter > .item'));
	// load window
	jQuery(window).load(function() {
		level_height(jQuery('.flex-filter > .item'));
	});
	// resize window
	jQuery(window).resize(function() {
		clearTimeout(window.resizedFinished);
		window.resizedFinished = setTimeout(function(){
			level_height(jQuery('.flex-filter > .item'));
		}, 500);
	});



	/*---------------filter---------------*/
	$('.block-filter .all-parameters').click(function(event) {
		$('.block-filter').toggleClass('active');
		$('.block-filter .hide-fill').slideToggle(400);

		var window_w = $(window).outerWidth();
		var has_cl = $('.block-filter').hasClass('active');
		if(has_cl == true &&  window_w >= 992){
			var offset_th = $('.block-filter').offset();
			$('html,body').animate({"scrollTop": offset_th.top}, 400);
		}
	});
	/*---------display maps and list------*/

	/*---------------menu drob---------------*/
	$('.click-nav').click(function(event) {
		$(this).toggleClass('active');
		$('.drob-nav').slideToggle(400);
	});
	jQuery(document).click( function(event){
		if(jQuery(event.target).closest(".click-nav, .drob-nav").length )
		return;
			$('.click-nav').removeClass('active')
			$('.drob-nav').slideUp(400);
		event.stopPropagation();
	});
	/*---------------menu drob---------------*/
	/*modal windows*/

	$('body').on('click', 'a[data-modal]', function(event){
		event.preventDefault();

		var data_modal = $(this).attr('data-modal');
		$('.modal-window[data-modal="' + data_modal +'"]').fadeIn(400).addClass('active');

		// заголовок окна для Записаться на просмотр и Оставить заявку
		if(data_modal == 'sung-up-view'){
			var data_title = $(this).attr('data-title');
			$('div[data-modal=sung-up-view]').find('div.h3').text(data_title);
		}
		// установка цели
		var id_button = $(this).attr('data-id-button');
		$('#idButton').val(id_button);
	});

	$('body').on('click', '.close-win', function(event){
		$('.modal-window').fadeOut(400).removeClass('active');
	});

	jQuery(document).click( function(event){
		if(jQuery(event.target).closest("a[data-modal], .window").length )
		return;
			$('.modal-window').fadeOut(400).removeClass('active');
		event.stopPropagation();
	});
	/*modal windows*/
	/*-----------test function-----------*/
	$(window).load(function() {
		$('.test-items label.checkbox-radio input').prop('checked',false);
		$('.test-items label.checkbox-radio').removeClass('active')
	});


	$('.test-items label.checkbox-radio').click(function(event) {
		$(this).parents('.item').find('label.checkbox-radio input').each(function(index, el) {
			var checked = $(this).prop('checked');
			if(checked == true){
				$('.test-items .item').each(function(index, el) {
					var checked_2 = $(this).find('label.checkbox-radio input').prop('checked');
					if(checked_2 == true){
						$(this).addClass('active');
						$(this).next('.item').addClass('active');
					}
				});
				$(this).parents('.item').next('.item').addClass('active');
				return false
			}
			else{
				$(this).parents('.item').nextAll('.item').removeClass('active');
			}
		});
	});



	/*add calss has_checked*/
	$('.test-items label.checkbox-radio').click(function(event) {
		$('.test-items .item').each(function(index, el) {
			$(this).find('label.checkbox-radio input').each(function(index, el) {
				var checked = $(this).prop('checked');
				if(checked == true){
					$(this).parents('.item').find('.next-item div').last().addClass('has_check');
					return false;
				}
				else{
					$(this).parents('.item').find('.next-item div').last().removeClass('has_check');
				}
			});
		});
	});


	$('.test-items label.radio').click(function(event) {
		var offset_this = $(this).parents('.item').next('.item').offset();
		var height_item = $(this).parents('.item').outerHeight();
		var height_window = $(window).outerHeight();

		var wid_win = $(window).outerWidth();
		if(wid_win >=750){
			var formula = offset_this.top - (height_window / 2) - (height_item/2) - 30;
			$('html,body').animate({"scrollTop":formula}, 200);
		}


	});



	$('.next-item').click(function(event) {
		var has_class = $(this).hasClass('has_check');
		if(has_class == true){
			var offset_this = $(this).parents('.item').next('.item').offset();
			var height_item = $(this).parents('.item').next('.item').outerHeight();
			var height_window = $(window).outerHeight();

			var wid_win = $(window).outerWidth();
			if(wid_win >=750){
				var formula = offset_this.top - (height_window / 2) + (height_item/2);
				$('html,body').animate({"scrollTop":formula}, 200);
			}
			else{
				var formula = offset_this.top;
				$('html,body').animate({"scrollTop":formula}, 200);
			}

		}
	});


	$('.prev-item').click(function(event) {
		var offset_this = $(this).parents('.item').offset();
		var height_item = $(this).parents('.item').outerHeight();
		var height_window = $(window).outerHeight();


		var wid_win = $(window).outerWidth();
		if(wid_win >=750){
			var formula = offset_this.top - (height_window / 2) - (height_item/2) - 30;
			$('html,body').animate({"scrollTop":formula}, 200);
		}
		else{
			var offset_this_2 = $(this).parents('.item').prev('.item').offset();
			var formula = offset_this_2.top;
			$('html,body').animate({"scrollTop":formula}, 200);
		}
	});




	$('.test-items > .item').click(function(event) {
		$('.test-items > .item .eroor-items').remove();
		clearTimeout(timerId);

		var th_has_cl = $(this).hasClass('active');
		if(th_has_cl == false){
			var th_clone = $('.service-info .eroor-items').clone();
			$(this).append(th_clone);
			$(this).find('.eroor-items').fadeIn(400);
			var last_index = $('.test-items > .item.active').last().index();
			$(this).find('.eroor-items').find('span').text(last_index + 1)

			var timerId = setTimeout(function(){
				$('.test-items > .item .eroor-items').fadeOut(700);
			}, 2000);


		}
	});
	/*-----------test function-----------*/
/*------------valid form------------*/
	/*
		data-test - валідація
		(приклад: data-test="text")
		text- - only text
		email - email input
		number - number input
		text-number - text and nuber

		------------------------------------
		data-valid="required" - обов'зкове поле

		------------------------------------
		data-concurrences - перевірка на співпадіння
		(.error-concurrences - помилка при не співпадінні полів)
		(приклад: data-concurrences='email')

		---------------------------------
		data-checkbox="required" - обов'язковий input checkbox
		.error-checkbox - помилка на код валідаціїї checkbox

		------------------------------------
		.error - помилка валідації на keyup
		.error-input - помилка валідації на submit
		.error-empty - помилка пустого поля на submit
	*/
	function valid_form(){
		$('input').keyup(function(event) {
			$(this).parents('label').removeClass('error-empty error-input');
			var th_val = $(this).val();
			var data_test = $(this).attr('data-test');
			data_test = $.trim(data_test);

			/*-----------text input-----------*/
			if(data_test == 'text'){
				var result = th_val.match('^[а-яА-ЯёЁa-zA-Z ]+$');
				//=================
				var count_val = th_val.length;
				var count_val =+ count_val;
				//=================
				if(count_val >= 1){
					if(result == null){
						$(this).addClass('error');
					}
					else{
						$(this).removeClass('error');
					}
				}
				else{
					$(this).removeClass('error');
				}
			}
			/*-----------text input-----------*/

			/*-----------email input-----------*/
			if(data_test == 'email'){
				var result = th_val.match('^([Aa-Zz0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$');
				//=================
				var count_val = th_val.length;
				var count_val =+ count_val;
				//=================
				if(count_val >= 1){
					if(result == null){
						$(this).addClass('error');
					}
					else{
						$(this).removeClass('error');
					}
				}
				else{
					$(this).removeClass('error');
				}
			}
			/*-----------email input-----------*/
			/*-----------number input-----------*/
			if(data_test == 'number'){
				var result = th_val.match('^[0-9]+$');
				//=================
				var count_val = th_val.length;
				var count_val =+ count_val;
				//=================
				if(count_val >= 1){
					if(result == null){
						$(this).addClass('error');
					}
					else{
						$(this).removeClass('error');
					}
				}
				else{
					$(this).removeClass('error');
				}
			}
			/*-----------number inp-----------*/
			/*-----------number and text input-----------*/
			if(data_test == 'text-number'){
				var result = th_val.match('^[а-яА-ЯёЁa-zA-Z0-9]+$');
				//=================
				var count_val = th_val.length;
				var count_val =+ count_val;
				//=================
				if(count_val >= 1){
					if(result == null){
						$(this).addClass('error');
					}
					else{
						$(this).removeClass('error');
					}
				}
				else{
					$(this).removeClass('error');
				}
			}
			/*-----------number and text input-----------*/
			/*-----------concurrences input-----------*/
			var concurrences = $(this).attr('data-concurrences');
			concurrences = $.trim(concurrences);
			if(concurrences != undefined){
				var val_rirst = $(this).val();
				val_rirst = $.trim(val_rirst);

				$(this).parents('form').find('input[data-concurrences]').not($(this)).each(function(index, el) {
					var th_attr = $(this).attr('data-concurrences');
					if(th_attr == concurrences){
						var length_val = $(this).val().length;
						if(length_val > 0){
							var th_val = $(this).val();
							th_val = $.trim(th_val);
							if(val_rirst != th_val){
								$('input[data-concurrences="' + th_attr +'"]').addClass('error-concurrences');
							}
							else{
								$('input[data-concurrences="' + th_attr +'"]').removeClass('error-concurrences');
							}
						}
						else{
							$('input[data-concurrences="' + th_attr +'"]').removeClass('error-concurrences');
						}

					}
				});
			}
			/*-----------concurrences input-----------*/
		});
		/*select with option*/
		$('select').change(function(event) {
			$(this).parents('label').removeClass('error-empty error-input');
			$(this).removeClass('error');
		});
		/*clik-submit*/
		$('.submit input').click(function(event) {
			$(this).parents('form').find('label').removeClass('error-empty error-input error-checkbox')
			// перевірка input
			$(this).parents('form').find('input').not($(this)).each(function(index, el) {
				var data_valid = $(this).is('[data-valid]');


				// перевірка на наявність data-valid
				if(data_valid == true){
					var th_val = $(this).val();
					// якщо input з data-valid пустий
					if(th_val == ''){
						event.preventDefault();
						$(this).parent('label').addClass('error-empty')
					}
				}

				// перевірка на помилку в полі
				var has_arror = $(this).hasClass('error');
				var data_concurrences = $(this).hasClass('error-concurrences');
				if(has_arror == true || data_concurrences == true){
					event.preventDefault();
					$(this).parents('label').addClass('error-input')
				}
			});
			// перевірка select
			$(this).parents('form').find('select').each(function(index, el) {
				var th_sel = $(this).children('option:first-child').is(':selected');
				if(th_sel == true){
					event.preventDefault();
					$(this).addClass('error')
					$(this).parents('label').addClass('error-empty');
				}
			});
			// перевірка checkbox
			$(this).parents('form').find('input[type="checkbox"][data-checkbox]').each(function(index, el) {
				var checked = $(this).prop('checked');
				if(checked == false){
					event.preventDefault();
					$(this).parents('label').addClass('error-checkbox');
				}
			});
		});
	}
	valid_form();
	/*------------valid form------------*/
	/*------------lin social------------*/
	$('.title-reviews.title-comparison .link-cocial > i').click(function(event) {
		$(this).toggleClass('active');
		$('.title-reviews.title-comparison .social-block').slideToggle(200);
	});
	jQuery(document).click( function(event){
		if(jQuery(event.target).closest(".link-cocial").length )
		return;
			$('.title-reviews.title-comparison .link-cocial > i').removeClass('active');
			$('.title-reviews.title-comparison .social-block').slideUp(200);
		event.stopPropagation();
	});
	/*------------lin social------------*/
	/*------------lin social------------*/
	$('body').before('<div class="auncor-tabs"></div>');
	$('.items-blocks *[data-name-tab]').each(function(index, el) {
		var this_id = $(this).attr('id');
		var this_data = $(this).attr('data-name-tab');
		$('.auncor-tabs').append('<a class="auncor" href="#' + this_id + '"><span>' + this_data + '</span></a>');
	});
	$('.items-blocks *[data-name-tab]').mouseover(function(event) {
		$('.auncor-tabs a').removeClass('active');
		var this_id = $(this).attr('id');
		$('.auncor-tabs a[href=#' + this_id + ']').addClass('active');
	});
	$('.items-blocks').mouseout(function(event) {
		$('.auncor-tabs a').removeClass('active');
	});
	jQuery('a.auncor').click(function(event){
		history.pushState({}, "", $(this).attr('href'));
		var target = $(this).attr('href').replace('/', '');
		var scroll_t = $(window).scrollTop();
		if(scroll_t<=60){
			$('html, body').stop(true, false).animate({scrollTop: $(target).offset().top - 0}, 900);
		}
		else{
			$('html, body').stop(true, false).animate({scrollTop: $(target).offset().top - 0}, 900);
		}
		return false;
	});
	/*------------lin social------------*/
	$('nav .search input[type="text"]').keyup(function(event) {
		var th_val = $(this).val();
		th_val = $.trim(th_val);
		if(th_val.length >= 1){
			$('nav .search').addClass('active');
		}
		else{
			$('nav .search').removeClass('active');
		}
	});
	/*--------item-sort--------*/
	$('.item-sort a').click(function(event) {
		event.preventDefault();
		$('.item-sort a').removeClass('active');
		$(this).addClass('active');

		var th_list = $(this).index();
		if(th_list == 0){
			$('.similar-items').addClass('list');
		}
		else{
			$('.similar-items').removeClass('list');
		}
		$('.owl-similar').trigger('refresh.owl.carousel');
	});


	/*clone element for mobile*/
	$('.items-blocks > .item.items-slider').after('<div class="item mobile-item-slider"></div>');
	var clone_1 = $('.items-blocks > .item.items-slider .block-for-clone').clone();
	var clone_2 = $('.items-blocks > .item.items-slider table').clone();
	$('.mobile-item-slider').append(clone_1, clone_2, '<div class="mobile-show"><span>Подробнее о поселке</span><span>Свернуть</span></div>');

	$('.mobile-show span').click(function(event) {
		$(this).parent('.mobile-show').toggleClass('acitve');
		$(this).parents('.item.mobile-item-slider').find('table').toggleClass('show-table');


		$(this).parents('.item').find('.lists-add-info .list ul.for-mobile').toggleClass('show-li');
		$(this).parents('.item.furnishing-mobile').find('.furnishing-items').toggleClass('show-item')
		$(this).parents('.item.furnishing-mobile').toggleClass('show-block');


		$(this).parents('.item.items-how-get').toggleClass('show-block');


		$(this).parents('.items-blocks > .item.item-plan').toggleClass('show-block');


		$(this).parents('.items-blocks > .item.item-plan').find(' .items-house .item p').slideToggle(0)


		$(this).parents('.item.item-legal').find('p').slideToggle(0)
	});



	/*show/hide filter for main page*/
	$('.form-main').click(function(event) {
		$('.section-title-main .wr-filter').fadeIn(400);
		$('.section-title-main .close-filter').click(function(event) {
			$('.section-title-main .wr-filter').fadeOut(400);
		});
	});
	jQuery(document).click( function(event){
		if(jQuery(event.target).closest(".section-title-main .wr-filter, .form-main, .ui-selectmenu-menu").length )
		return;
			$('.section-title-main .wr-filter').fadeOut(400);
		event.stopPropagation();
	});



	/*table developer_table*/
	$('#developer_table tbody td').each(function(index, el) {
		var th_index = $(this).index();
		var th_text = $('#developer_table thead th').eq(th_index).text();
		$(this).prepend('<div class="mobile-title">' + th_text + ':</div>');
		if(th_index == 6){
			$(this).find('.mobile-title').remove();
			$(this).prepend('<div class="mobile-title">Сылка на сайт:</div>');
		}

	});
	/*mobile js*/

	$('.char-block, .items-house').each(function(index, el) {
		var has_char =  $(this).find('> *').length;
		console.log(has_char)
		if(has_char <= 0){
			$(this).next('.mobile-show').remove();
		}
	});




});



// copy modal
function copy_modal() {
	$('.success-cppy').addClass('active');
	setTimeout(function(){
		$('.success-cppy').removeClass('active');
	}, 5000);
}
/*copy text*/
function myFunction() {
	/* Get the text field */
	var copyText = document.getElementById("copyLink");
	copyText.select();
	document.execCommand("copy");
	copy_modal();
}
