// lazy load
$("img.lazy").lazyload();

// добавление в избранное
function add2delay(p_act, p_id, pp_id, p, name, dpu, th) {

	// var likeElem = $('#fav_' + p_id);
	var likeElem = $('.fav_' + p_id);

	if (likeElem.hasClass('active')) p_act = 'remove'; //alert(p_act);
	else p_act = 'add';

	$.ajax({
		type: "POST",
		url: "/ajax/ajax_fav.php",
		data: "p_act=" + p_act + "&p_id=" + p_id + "&pp_id=" + pp_id + "&p=" + p + "&name=" + name + "&dpu=" + dpu,
		success: function (data) { //alert(data);
			if (!likeElem.hasClass('active')) {
				likeElem.addClass('active');
				likeElem.attr('title', 'Удалить из избранного');
			}
			else {
				likeElem.removeClass('active');
				likeElem.attr('title', 'Добавить в избранное');
			}

			// инфа в шапку
			$('#izbDesc').text($.trim(data));
			/*if(data == 0)$('#fav_A').removeClass('active');
			else $('#fav_A').addClass('active');*/
		}
	});
};

$(document).ready(function(){
	$('.iconDouble').on('click', function(){ //alert('ok');
		id1 = $(this).attr('data-id1');
		id2 = $(this).attr('data-id2');
		id3 = $(this).attr('data-id3');
		id4 = $(this).attr('data-id4');
		$('#'+id1).trigger("click");
		$('#'+id2).trigger("click");
		$('#'+id3).trigger("click");
		$('#'+id4).trigger("click");
	});

	// выбор Шоссе
	$('.changeHighway').change(function(){ //alert('ok');
		var activeHighway = false;
		$('.changeHighway').each(function(){
			if ($(this).prop('checked')) activeHighway = true;
		});
		if(activeHighway)$('.Highway').addClass('active');
		else $('.Highway').removeClass('active');
	});
	// выбор Районы МО
	$('.changeAreas').change(function(){ //alert('ok');
		var activeAreas = false;
		$('.changeAreas').each(function(){
			if ($(this).prop('checked')) activeAreas = true;
		});
		if(activeAreas)$('.Areas').addClass('active');
		else $('.Areas').removeClass('active');
	});

	if ($('#arrFilter_2_4088798008').prop('checked')) { // выбраны дома - переключение цен
		$('.cost_land').hide();
		$('.cost_home').show();
	}

	// сброс значений с домом
	$('#arrFilter_2_1842515611, #arrFilter_2_4088798008').change(function(){
		if (!$('#arrFilter_2_4088798008').prop('checked')) { // выбраны участки

			// переключение стоимости
			$('.cost_home').hide();
			$('.cost_land').show();
			$('#arrFilter_17_MIN').val('').trigger("keyup");
			$('#arrFilter_17_MAX').val('').trigger("keyup");

			// уберем выбранные значения по дому
			$('.window-with-house').find('label').removeClass('active').find('input').prop('checked', false);

			// поставим слайдер Площадь дома в нужную позицию
			minSlider4 = parseInt($('#arrFilter_15_MIN').attr('data-min-val'));
			maxSlider4 = parseInt($('#arrFilter_15_MAX').attr('data-max-val'));
			$('#arrFilter_15_MIN').val('').trigger("keyup");
			$('#arrFilter_15_MAX').val('').trigger("keyup");
			$("#slider-4").slider({
				min: minSlider4,
				max: maxSlider4,
				values: [minSlider4,maxSlider4],
				step: 1,
				range: true,
				stop: function(event, ui) {
					var th = $(this);
					th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
					th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
					$('#arrFilter_15_MIN').trigger('onkeyup');
					$('#arrFilter_15_MAX').trigger('onkeyup');
				},
				slide: function(event, ui){
					var th = $(this);
					th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
					th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
				}
			});
		}else{ // выбраны дома
			// переключение стоимости
			$('.cost_land').hide();
			$('.cost_home').show();
			$('#arrFilter_120_MIN').val('').trigger("keyup");
			$('#arrFilter_120_MAX').val('').trigger("keyup");

			// окно параметров домов
			$(".modal-window-fil[data-wodal-fill=select_house]").fadeIn(400).addClass('active');
		}
	});

	// клик по якорям
	$('a.slowScroll').click(function(e){
	  e.preventDefault();
	  elementClick = $(this).attr("href");
	  $("html, body").animate({scrollTop:$(elementClick).offset().top},"slow");
	});

	// клик по якорям
	// $('.openTab').click(function(e){
	//   e.preventDefault();
	//   tab = $(this).attr("tab");
	//   $('.tab-swich .item .list').removeClass("active");
	//   $('#'+tab).addClass("active");
	//   $('.tabs-item .itemTab').hide();
	//   $('#tab_'+tab).show();
	// });

	// переключение вкладок участок и участок с домом
	$('.houses-swich a').click(function(event){
		event.preventDefault();
		$(this).parent('.houses-swich').find('a').removeClass('active');
		$(this).addClass('active');
		var th_index = $(this).index(); //alert(th_index);
		var h_item = $(this).parents('.title-reviews').next().find('.houses-item');
		h_item.hide(); // скрывем все
		h_item.eq(th_index).show(); // показываем нужный
	});

	// изменение цены в фильтре Стоимость участка
	$('.priceVariant').change(function(){

		if (!$('#arrFilter_2_4088798008').prop('checked')){ // не выбрано в фильтре с домом
			inputCostMin = '#arrFilter_120_MIN';
			inputCostMax = '#arrFilter_120_MAX';
			maxVal = $('#maxVal120').val(); // максимальное значение стоимости
			sliderId = '#slider-2';
		}else{
			inputCostMin = '#arrFilter_17_MIN';
			inputCostMax = '#arrFilter_17_MAX';
			maxVal = $('#maxVal17').val(); // максимальное значение стоимости домов
			sliderId = '#slider-cost-home';
		}

		// переберем выбранные варианты
		$('.priceVariant').each(function(){
			if($(this).prop("checked")){
				vid = $(this).attr('vid');
				switch(vid){
					case 'econom':
						$(inputCostMin).val(0).trigger("keyup");
						if(!$('input[vid=premium]').is(":checked") && !$('input[vid=comfort]').is(":checked"))$(inputCostMax).val(300000).trigger("keyup");
						$(inputCostMax).attr('data-max-val',300000);
						break;
					case 'comfort':
						if(!$('input[vid=econom]').is(":checked"))$(inputCostMin).val(300000).trigger("keyup");
						if(!$('input[vid=premium]').is(":checked"))$(inputCostMax).val(1000000).trigger("keyup");
						$(inputCostMax).attr('data-max-val',1000000);
						break;
					case 'premium':
						if(!$('input[vid=econom]').is(":checked") && !$('input[vid=comfort]').is(":checked"))$(inputCostMin).val(1000000).trigger("keyup");
						$(inputCostMax).val(maxVal).trigger("keyup");
						$(inputCostMax).attr('data-max-val',maxVal);
						break;
				}
			}
		});

		// поставим слайдер Стоимость участка в нужную позицию
		minSlider2 = parseInt($(inputCostMin).attr('data-min-val'));
		maxSlider2 = parseInt($(inputCostMax).attr('data-max-val'));
		$(sliderId).slider({
			min: minSlider2,
			max: maxSlider2,
			values: [minSlider2,maxSlider2],
			step: 1,
			range: true,
			stop: function(event, ui) {
				var th = $(this);
				th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
				th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
				$(inputCostMin).trigger('onkeyup');
				$(inputCostMax).trigger('onkeyup');
			},
			slide: function(event, ui){
				var th = $(this);
				th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
				th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
			}
		});

	});

	// ввод только чисел в Стоимость участка
	$('#arrFilter_6_MIN, #arrFilter_6_MAX, #arrFilter_11_MIN, #arrFilter_11_MAX, #arrFilter_120_MIN, #arrFilter_120_MAX, #arrFilter_17_MIN, #arrFilter_17_MAX, #arrFilter_70_MAX').bind("change keyup input click", function() {
		if (this.value.match(/[^0-9]/g)) {
			this.value = this.value.replace(/[^0-9]/g, '');
		}
	});

	// ввод поиска
	$('#searchButton').click(function(event){
		event.preventDefault();
		searchWord = $('#searchWord').val();
		location.href = '/poisk/?q='+searchWord;
	});

	// очистить все в сравнении
	$('#deleteAllCompare').click(function(event){
		event.preventDefault();
		$('.remove-link').trigger("click");
	});

	// переключалка отзывов
	$('.comments-switch a').click(function(event){
		event.preventDefault();
		show = $(this).attr('data-show'); // alert(show);
		$('.comments-switch a').removeClass('active');
		$(this).addClass('active');
		if(show == 'all'){
			$('.reviews-block .comment').show();
		}else{
			$('.reviews-block .comment').hide();
			$('.reviews-block .marker').show();
		}
	});

	// политика
	$('.policy').click(function(event){
		chek = $(this).prop('checked');
		but = $(this).attr('data-but');
		if (!chek) $('.'+but).prop("disabled", true);
		else $('.'+but).prop("disabled", false);

	});

	// отправка форм
	// Написать нам
	$('#formToUs').submit(function(event){
		//alert(777);return false;
		name = $('#nameToUs').val();
		tel = $('#telToUs').val();
		email = $('#emailToUs').val();
		mes = $('#textToUs').val();
		idButton = $('#idButton').val();
		yaCounter50830593.reachGoal(idButton);
		$.post("/ajax/sendForm.php",{
				name: name,
				tel: tel,
				email: email,
				mes: mes,
				ourForm: 'ToUs'
			},function(data){
				//alert(data);
				$('#formToUs').html(data);
				return false;
			}
		);
	});
	//  Записаться на просмотр
	$('#formSignToView').submit(function(event){
		//alert(777);return false;
		name = $('#nameSignToView').val();
		tel = $('#telSignToView').val();
		idButton = $('#idButton').val();
		yaCounter50830593.reachGoal(idButton);
		idPos = $('#posInfo').attr('data-idPos');
		namePos = $('#posInfo').attr('data-namePos');
		codePos = $('#posInfo').attr('data-codePos');
		cntPos = $('#posInfo').attr('data-cntPos');
		develId = $('#develInfo').attr('data-develId');
		develName = $('#develInfo').attr('data-develName');
		if(idButton == 'LEAVE_REQUEST'){
			subject = 'Заявка с сайта Поселкино.ру';
		}else{
			subject = 'Запись на просмотр';
		}
		$.post("/ajax/sendForm.php",{
				name: name,
				tel: tel,
				ourForm: 'SignToView',
				subject: subject,
				idPos: idPos,
				namePos: namePos,
				codePos: codePos,
				cntPos: cntPos,
				develId: develId,
				develName: develName
			},function(data){
				//alert(data);
				$('#formSignToView').html(data);
				return false;
			}
		);
	});
	// Подписка
	$('#subscribeForm').submit(function(event){
		event.preventDefault();
		email = $('#emailSubscribeForm').val();
		yaCounter50830593.reachGoal('SUBSCRIBE');
		$.post("/ajax/sendForm.php",{
				email: email,
				ourForm: 'Subscribe'
			},function(data){
				//alert(data);
				$('#subscribeForm').css({'background':'none'}).html(data);
				return false;
			}
		);
	});
	// Отправка ошибки
	$('#formSendError').submit(function(event){
		event.preventDefault();
		textPosEr = $('#textPosEr').val();
		yaCounter50830593.reachGoal('SEND_ERROR');
		$.post("/ajax/sendForm.php",{
				url: window.location.href,
				mes: textPosEr,
				ourForm: 'SendError'
			},function(data){
				//alert(data);
				$('#formSendError').css({'background':'none'}).html(data);
				return false;
			}
		);
	});
	// отправка отзыва
	$('#formSendReview').submit(function(event){
		event.preventDefault();
		idPos = $('#posInfo').attr('data-idPos');
		namePos = $('#posInfo').attr('data-namePos');
		codeDevel = $('#develInfo').attr('codeDevel');
		nameDevel = $('#develInfo').attr('nameDevel');
		name = $(this).find('input[name=NAME]').val();
		fname = $(this).find('input[name=FNAME]').val();
		email = $(this).find('input[name=EMAIL]').val();
		star = $(this).find('input[name=star-1]:checked').val();
		dignities = $(this).find('textarea[name=DIGNITIES]').val();
		disadvantages = $(this).find('textarea[name=DISADVANTAGES]').val();
		comment = $(this).find('textarea[name=COMMENT]').val();
		resident = $(this).find('input[name=RESIDENT]:checked').val();
		// alert(comment);
		$.post("/ajax/sendForm.php",{
				ourForm: 'SendReview',
				idPos: idPos,
				namePos: namePos,
				codeDevel: codeDevel,
				nameDevel: nameDevel,
				name: name,
				fname: fname,
				email: email,
				star: star,
				dignities: dignities,
				disadvantages: disadvantages,
				comment: comment,
				resident: resident,
			},function(data){
				//alert(data);
				$('#formSendReview').html(data);
				return false;
			}
		);
	});

	// закрытие всплыв. окна на карте
	$('.card-map .close-map').click(function(event) {
		$('.card-map').hide(0);
	});

	// скроем блок рекламы
	cntPosRek = $('.reklama-block .similar-items').attr('data-cnt-pos');
	cntPosSale = $('.sale-block .similar-items').attr('data-cnt-pos');
	if (cntPosRek == 0) $('.reklama-block').hide();
	if (cntPosSale == 0) $('.sale-block').hide();
	// console.log('cntPosRek '+cntPosRek);

	// выбор значения Все
	$('.changeTypeSelect').selectmenu({
		change: function( event, ui ) {
			selType = $(this).val(); // alert(selType);
			$('#allTypeSelect').val(selType); // снятие галки
			$('#'+selType).trigger("click");
			// if(selType == 'arrFilter_2_4088798008'){ // выбрали дом - окно параметров домов
			// 	$(".modal-window-fil[data-wodal-fill=select_house]").fadeIn(400);
			// }
		}
	});

	// замена рубля
	$('.rep_rubl').html('<span class="rubl">a</span>');

	// чтобы отделять 3 знака в числах
	$('.split-number').each(function(index, el) {
		var text_number = $(this).text();
		var text_number = String(text_number).replace(/(\d)(?=(\d{3})+([^\d]|$))/g, '$1 ');
		$(this).text(text_number);
	});

	// Яндекс.Карты
	/*ymaps.ready(init);
    function init(){
        // Создание карты.
        var myMap = new ymaps.Map("map", {
            center: [55.76, 37.64], // Координаты центра карты.
            zoom: 7 // Уровень масштабирования
        });
    }*/
});

(function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
(window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");

ym(55033927, "init", {
		 clickmap:true,
		 trackLinks:true,
		 accurateTrackBounce:true
});
