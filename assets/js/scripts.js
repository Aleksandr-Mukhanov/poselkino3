function setCookie(cookieName,id_el,idHeader){
  if($.cookie(cookieName)){
    comparison = $.cookie(cookieName);
    ar_cookie = comparison.split('-');
    var cntHeader = $('#'+idHeader).text();
    // console.log(ar_cookie);
    if($.inArray(id_el, ar_cookie) == -1){ // добавление в избранное
      // console.log('add');
      new_cookie = comparison + '-' + id_el;
      cntHeader++;
    }else{ // удаление из избранного
      // console.log('del');
      new_cookie = '';
      cntHeader--;
      $.each(ar_cookie,function(key,val){
        if(val != id_el){
          if (new_cookie == '') new_cookie = val;
          else new_cookie = new_cookie + '-' + val;
        }
      });
    }
  }else{
    new_cookie = id_el;
    cntHeader = 1;
  }
  // console.log(new_cookie);
  if(new_cookie != '')
    $.cookie(cookieName, new_cookie, { expires: 30, path: '/' });
  else
    $.removeCookie(cookieName, { path: '/' });

  $('#'+idHeader).text(cntHeader); // обновим в шапке
}

$(document).ready(function(){

  // добавление в сравнение / избранное
  $(document).on('click','.comparison-click',function(){
    id_el = $(this).attr('data-id');
    setCookie('comparison_vil',id_el,'compHeader');
  });
  $(document).on('click','.favorites-click',function(){
    id_el = $(this).attr('data-id');
    setCookie('favorites_vil',id_el,'favHeader');
  });

  // чтобы отделять 3 знака в числах
	$('.split-number').each(function(index, el) {
		var text_number = $(this).text();
		var text_number = String(text_number).replace(/(\d)(?=(\d{3})+([^\d]|$))/g, '$1 ');
		$(this).text(text_number);
	});
  // замена рубля
	$('.rep_rubl').html('<span class="rubl">a</span>');

  // выбор типа в фильтре
  $('.changeTypeSelect').change(function(){

    selType = $(this).val();

    if(selType == 'arrFilter_2_4088798008'){ // дома

      // отмечаем нужное
      if ($('#arrFilter_2_1842515611').is(':checked')) $('#arrFilter_2_1842515611').prop('checked',false);
      if (!$('#arrFilter_2_3039150019').is(':checked')) $('#arrFilter_2_3039150019').prop('checked',true);

      // переключение стоимости
      $('.cost_land').hide();
      $('.cost_home').show();
      $('#arrFilter_120_MIN').val('');
      $('#arrFilter_120_MAX').val('');

      $('#'+selType).trigger("click");

    }else{ // участки или все

      // переключение стоимости
			$('.cost_home').hide();
			$('.cost_land').show();
			$('#arrFilter_17_MIN').val('');
			$('#arrFilter_17_MAX').val('');

			// уберем выбранные значения по дому
			$('#houseModal input:checked').prop('checked', false);

      if(selType == 'arrFilter_2_1842515611'){ // участки

        // отмечаем нужное
        if ($('#arrFilter_2_4088798008').is(':checked')) $('#arrFilter_2_4088798008').prop('checked',false);
        if (!$('#arrFilter_2_3039150019').is(':checked')) $('#arrFilter_2_3039150019').prop('checked',true);

        $('#'+selType).trigger("click");

      }else{ // все
        $('.filter__type input:checkbox:checked').trigger("click");
      }
    }
  });

  // выбраны дома - переключение цен
  if ($('#arrFilter_2_4088798008').is(':checked')) {
		$('.cost_land').hide();
		$('.cost_home').show();
    $('#arrFilter_120_MIN').val('');
    $('#arrFilter_120_MAX').val('');
	}

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

  // иконки в фильтре
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

  // сортировка
  $('#sortinng').change(function(){
    sort = $(this).val(); //alert(sort);
    location.href = '?sort='+sort+'#showPoselki';
  });

  // построить маршрут
  $('#bildRoute').click(function(){
    coordMap = $('#coordMap').text(); //alert(sort);
    // location.href = 'https://yandex.ru/maps/?rtext=~'+coordMap+'&rtt=auto';
    window.open('https://yandex.ru/maps/?rtext=~'+coordMap+'&rtt=auto','_blank');
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

  //
  $('input[name=type_permitted]').change(function(){ // Вид разрешенного использования
    permitted = $(this).val();
    if(permitted == 'dacha'){
      $('#arrFilter_33_766302424,#arrFilter_33_1577100463,#arrFilter_33_2602800704,#arrFilter_33_2286445522').trigger("click");
    }else if(permitted == 'ihs'){
      $('#arrFilter_33_500958211,#arrFilter_33_1500340406').trigger("click");
    }
  });

  // выбор направлений
  $('.highway-block__title').click(function(){
    $(this).parent().find('input').trigger('click');
  });

  // отправка форм
  $('a[data-toggle=modal],.leave_request').click(function(event){ // установка цели
		var id_button = $(this).attr('data-id-button');
		$('#idButton').val(id_button);
  });

  // Video
  $("#openVideo").lightGallery();

  // сравнение
  $('#comparison-differences-tab').click(function(){
    for (var i = 1; i < 15; i++) {
      var show_dif = true;
      var j = 0;
      $('.tr_'+i).each(function(){ // переберем строки
        td_text = $(this).find('.card-description__value').text();
        // console.log('tr_'+i+': '+td_text);
        if (j > 1)
          if (td_text != td_text_old) show_dif = false;
        td_text_old = td_text; j++;
      });
      if (show_dif) $('.tr_'+i).hide();
    }
  });
  $('#comparison-all-tab').click(function(){
    $('.char__title, .card-description').show();
  });

	// Написать нам
	$('#formToUs').submit(function(event){
		event.preventDefault();
		name = $('#nameToUs').val();
		tel = $('#telToUs').val();
		email = $('#emailToUs').val();
		mes = $('#textToUs').val();
		idButton = $('#idButton').val();
		yaCounter50830593.reachGoal(idButton);
    gtag('event',idButton,{'event_category':'button','event_action':idButton});
		$.post("/local/ajax/sendForm.php",{
				name: name,
				tel: tel,
				email: email,
				mes: mes,
				ourForm: 'ToUs'
			},function(data){
				$('#formToUs').html(data);
			}
		);
	});

	//  Записаться на просмотр
	$('.formSignToView').submit(function(event){
    event.preventDefault();
		name = $(this).find('.nameSignToView').val();
		tel = $(this).find('.telSignToView').val();
    email = $(this).find('.emailSignToView').val();
		idButton = $('#idButton').val();
    if (idButton == '') idButton = 'SIGN_UP_TO_VIEW';
		yaCounter50830593.reachGoal(idButton);
    gtag('event',idButton,{'event_category':'button','event_action':idButton});
		idPos = $('#posInfo').attr('data-idPos');
		namePos = $('#posInfo').attr('data-namePos');
		codePos = $('#posInfo').attr('data-codePos');
    highway = $('#posInfo').attr('data-highwayPos');
		cntPos = $('#posInfo').attr('data-cntPos');
		develId = $('#develInfo').attr('data-develId');
		develName = $('#develInfo').attr('data-develName');
    formID = $(this).attr('data-formID');
    manager = $('#posInfo').attr('data-manager');
		if(idButton == 'LEAVE_REQUEST'){
			subject = 'Заявка с сайта Поселкино.ру';
		}else{
			subject = 'Запись на просмотр';
		}
		$.post("/local/ajax/sendForm.php",{
				name: name,
				tel: tel,
        email: email,
				ourForm: 'SignToView',
				subject: subject,
				idPos: idPos,
				namePos: namePos,
				codePos: codePos,
        highway: highway,
				cntPos: cntPos,
				develId: develId,
				develName: develName,
        formID: formID,
        manager: manager
			},function(data){
				$('.formSignToView').html(data);
			}
		);
	});

	// Подписка
	$('#subscribeForm').submit(function(event){
		event.preventDefault();
		email = $('#emailSubscribeForm').val();
		yaCounter50830593.reachGoal('SUBSCRIBE');
    gtag('event','SUBSCRIBE',{'event_category':'button','event_action':'SUBSCRIBE'});
		$.post("/local/ajax/sendForm.php",{
				email: email,
				ourForm: 'Subscribe'
			},function(data){
				$('#subscribeForm').css({'background':'none'}).html(data);
			}
		);
	});

	// Отправка ошибки
	$('#formSendError').submit(function(event){
		event.preventDefault();
		textPosEr = $('#textPosEr').val();
		yaCounter50830593.reachGoal('SEND_ERROR');
    gtag('event','SEND_ERROR',{'event_category':'button','event_action':'SEND_ERROR'});
		$.post("/local/ajax/sendForm.php",{
				url: window.location.href,
				mes: textPosEr,
				ourForm: 'SendError'
			},function(data){
				$('#formSendError').css({'background':'none'}).html(data);
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
		name = $(this).find('input[name=review-name]').val();
		fname = $(this).find('input[name=review-surname]').val();
		email = $(this).find('input[name=review-email]').val();
		star = $(this).find('input[name=review-raiting]:checked').val();
		dignities = $(this).find('input[name=review-advantages]').val();
		disadvantages = $(this).find('input[name=review-disadvantages]').val();
		comment = $(this).find('textarea[name=review-text]').val();
		resident = $(this).find('input[name=review-resident]:checked').val();
		// alert(comment);
		$.post("/local/ajax/sendForm.php",{
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
				$('#formSendReview').html(data);
			}
		);
	});

});

// (function(m,e,t,r,i,k,a){m[i]=m[i]||function(){(m[i].a=m[i].a||[]).push(arguments)};
// m[i].l=1*new Date();k=e.createElement(t),a=e.getElementsByTagName(t)[0],k.async=1,k.src=r,a.parentNode.insertBefore(k,a)})
// (window, document, "script", "https://mc.yandex.ru/metrika/tag.js", "ym");
//
// ym(55033927, "init", {
// 		 clickmap:true,
// 		 trackLinks:true,
// 		 accurateTrackBounce:true
// });
