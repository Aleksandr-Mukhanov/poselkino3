jQuery(document).ready(function($) {
	/*select menu*/
	$("select").selectmenu();







	/*
		описания работы сладера
		в html в slider-ui есть input со значениям data-max-val туда записываем максимальное значения которое может быть в input
	*/
	$( function() {

		// find max val
		var name_slider = $( "#distances-min" );
		var data_max = name_slider.parents('.slider-ui').find('input').attr('data-max-val');

		name_slider.slider({
			range: "min",
			value: 0,
			min: 0,
			max: data_max,
			slide: function( event, ui ) {
				$(this).parents('.slider-ui').find('input').val( ui.value );
				if(ui.value <= 0){
					$(this).parents('.slider-ui').find('input').val('')
				}
			}
		});
		// find max val
		var name_slider = $( "#distances-max" );
		var data_max = name_slider.parents('.slider-ui').find('input').attr('data-max-val');

		name_slider.slider({
			range: "min",
			value: 0,
			min: 0,
			max: data_max,
			slide: function( event, ui ) {
				$(this).parents('.slider-ui').find('input').val( ui.value );
				if(ui.value <= 0){
					$(this).parents('.slider-ui').find('input').val('')
				}
			}
		});

		/*--------price--------*/

		// find max val
		var name_slider = $( "#price-min" );
		var data_max = name_slider.parents('.slider-ui').find('input').attr('data-max-val');

		name_slider.slider({
			range: "min",
			value: 0,
			step: 1000,
			max: data_max,
			slide: function( event, ui ) {
				$(this).parents('.slider-ui').find('input').val( ui.value );
				if(ui.value <= 0){
					$(this).parents('.slider-ui').find('input').val('')
				}
				var val_max = $(this).parents('.slider-ui-wr').find('.slider-ui.max').find('input').val();

			}
		});
		var name_slider = $( "#price-max" );
		var data_max = name_slider.parents('.slider-ui').find('input').attr('data-max-val');

		name_slider.slider({
			range: "min",
			value: 0,
			min: 0,
			step: 1000,
			max: data_max,
			slide: function( event, ui ) {
				$(this).parents('.slider-ui').find('input').val( ui.value );
				if(ui.value <= 0){
					$(this).parents('.slider-ui').find('input').val('')
				}
			}
		});

		/*--------areas --------*/

		var name_slider = $( "#areas-min" );
		var data_max = name_slider.parents('.slider-ui').find('input').attr('data-max-val');

		name_slider.slider({
			range: "min",
			value: 0,
			step: 5,
			max: data_max,
			slide: function( event, ui ) {
				$(this).parents('.slider-ui').find('input').val( ui.value );
				if(ui.value <= 0){
					$(this).parents('.slider-ui').find('input').val('')
				}
				var val_max = $(this).parents('.slider-ui-wr').find('.slider-ui.max').find('input').val();

			}
		});
		var name_slider = $( "#areas-max" );
		var data_max = name_slider.parents('.slider-ui').find('input').attr('data-max-val');

		name_slider.slider({
			range: "min",
			value: 0,
			min: 0,
			step: 5,
			max: data_max,
			slide: function( event, ui ) {
				$(this).parents('.slider-ui').find('input').val( ui.value );
				if(ui.value <= 0){
					$(this).parents('.slider-ui').find('input').val('')
				}
			}
		});
	});

	/*--------price--------*/
		// find max val
		var name_slider = $( "#price-min-2" );
		var data_max = name_slider.parents('.slider-ui').find('input').attr('data-max-val');

		name_slider.slider({
			range: "min",
			value: 0,
			step: 5,
			max: data_max,
			slide: function( event, ui ) {
				$(this).parents('.slider-ui').find('input').val( ui.value );
				if(ui.value <= 0){
					$(this).parents('.slider-ui').find('input').val('')
				}
				var val_max = $(this).parents('.slider-ui-wr').find('.slider-ui.max').find('input').val();

			}
		});
		var name_slider = $( "#price-max-2" );
		var data_max = name_slider.parents('.slider-ui').find('input').attr('data-max-val');

		name_slider.slider({
			range: "min",
			value: 0,
			min: 0,
			step: 5,
			max: data_max,
			slide: function( event, ui ) {
				$(this).parents('.slider-ui').find('input').val( ui.value );
				if(ui.value <= 0){
					$(this).parents('.slider-ui').find('input').val('')
				}
			}
		});

	/*chenge inpput*/
	$('.slider-ui input').keyup(function() {
		//check for numbers
		var th_val = $(this).val();
		th_val = parseInt(th_val);
		var has_nan = isNaN(th_val);
		if(has_nan == true){
			$(this).val('');
			th_val = 0;
			$(this).parents('.slider-ui').find('.slider-range').slider("value" , th_val);
			return false;
		}
		$(this).parents('.slider-ui').find('.slider-range').slider("value" , th_val);

		// check for max val
		var data_max = $(this).attr('data-max-val');
		data_max =+ data_max;
		if(th_val > data_max){
			$(this).val(data_max)
		}

	});

	$('.slider-ui input').focusout(function(event) {
		var th_val = $(this).val();
		th_val = parseInt(th_val);
		var has_nan = isNaN(th_val);
		if(has_nan == true){
			return false;
		}
		$(this).val(th_val);
	});

	/*------------------select menu------------------*/
	$( ".fill-sel" ).selectmenu({
		// classes: {
		// "ui-selectmenu-menu": "fill-st-1"
		// },
		change: function(){ // сортировка
			sort = $(this).val(); //alert(sort);
			location.href = '?sort='+sort+'#showPoselki';
		}
	});

		//------------  slider 1
		minSlider1 = parseInt($('#arrFilter_6_MIN').attr('data-min-val'));
		maxSlider1 = parseInt($('#arrFilter_6_MAX').attr('data-max-val'));
		$("#slider-1").slider({
			min: minSlider1,
			max: maxSlider1,
			values: [minSlider1,maxSlider1],
			step: 1,
			range: true,
			stop: function(event, ui) {
				var th = $(this);
				th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
				th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
				$('#arrFilter_6_MIN').trigger('onkeyup');
				$('#arrFilter_6_MAX').trigger('onkeyup');
			},
			slide: function(event, ui){
				var th = $(this);
				th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
				th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
			}
		});

		//------------ slider 2 Стоимость участка
		minSlider2 = parseInt($('#arrFilter_120_MIN').attr('data-min-val'));
		maxSlider2 = parseInt($('#arrFilter_120_MAX').attr('data-max-val'));
		$("#slider-2").slider({
			min: minSlider2,
			max: maxSlider2,
			values: [minSlider2,maxSlider2],
			step: 1,
			range: true,
			stop: function(event, ui) {
				var th = $(this);
				th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
				th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
				$('#arrFilter_120_MIN').trigger('onkeyup');
				$('#arrFilter_120_MAX').trigger('onkeyup');
			},
			slide: function(event, ui){
				var th = $(this);
				th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
				th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
			}
		});

		//------------ slider home Стоимость домов
		minSliderHome = parseInt($('#arrFilter_17_MIN').attr('data-min-val'));
		maxSliderHome = parseInt($('#arrFilter_17_MAX').attr('data-max-val'));
		$("#slider-cost-home").slider({
			min: minSliderHome,
			max: maxSliderHome,
			values: [minSliderHome,maxSliderHome],
			step: 1,
			range: true,
			stop: function(event, ui) {
				var th = $(this);
				th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
				th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
				$('#arrFilter_17_MIN').trigger('onkeyup');
				$('#arrFilter_17_MAX').trigger('onkeyup');
			},
			slide: function(event, ui){
				var th = $(this);
				th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
				th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
			}
		});

		//------------ slider 3
		minSlider3 = parseInt($('#arrFilter_11_MIN').attr('data-min-val'));
		maxSlider3 = parseInt($('#arrFilter_11_MAX').attr('data-max-val'));
		$("#slider-3").slider({
			min: minSlider3,
			max: maxSlider3,
			values: [minSlider3,maxSlider3],
			step: 1,
			range: true,
			stop: function(event, ui) {
				var th = $(this);
				th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
				th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
				$('#arrFilter_11_MIN').trigger('onkeyup');
				$('#arrFilter_11_MAX').trigger('onkeyup');
			},
			slide: function(event, ui){
				var th = $(this);
				th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
				th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
			}
		});

		//------------ slider 4
		minSlider4 = parseInt($('#arrFilter_15_MIN').attr('data-min-val'));
		maxSlider4 = parseInt($('#arrFilter_15_MAX').attr('data-max-val'));
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

		//------------ slider 5
		$("#slider-5").slider({
			min: 0,
			max: 100,
			values: [0,100],
			step: 1,
			range: true,
			stop: function(event, ui) {
				var th = $(this);
				th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
				th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
			},
			slide: function(event, ui){
				var th = $(this);
				th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
				th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
			}
		});

		//------------ slider 6
		$("#slider-6").slider({
			min: 0,
			max: 100,
			values: [0,100],
			step: 1,
			range: true,
			stop: function(event, ui) {
				var th = $(this);
				th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
				th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
			},
			slide: function(event, ui){
				var th = $(this);
				th.parents('.slider-wr-ui').find(".minCost").val($(th).slider("values",0));
				th.parents('.slider-wr-ui').find(".maxCost").val($(th).slider("values",1));
			}
		});

		/*---------------------------------------------------------*/
		$(".slider-wr-ui input").keyup(function(event) {
			var th_val = $(this).val();
			th_val = $.trim(th_val);
			th_val_number = $.isNumeric(th_val);
			if(th_val_number == false){
				$(this).val('');
			}
			else{
				$(this).val(th_val)
			}
		});
		// $(".slider-wr-ui input").change(function(event) {
		// 	var th_val = $(this).val();
		// 	if(th_val == ""){
		// 		$(this).val($(this).attr('value'));
		// 	}
		// });

		// $(".slider-wr-ui input.minCost").change(function(event) {
		// 	var th_val = $(this).val();
		// 	var th_val_min = $(this).attr('data-min');
		// 	if(parseInt(th_val) < parseInt(th_val_min)){
		// 		$(this).val($(this).attr('data-min'));
		// 	}
		// });
		// $(".slider-wr-ui input.maxCost").change(function(event) {
		// 	var th_val = $(this).val();
		// 	var th_val_max = $(this).attr('data-max');
		// 	if(parseInt(th_val) > parseInt(th_val_max)){
		// 		$(this).val($(this).attr('data-max'));
		// 	}
		// });

		// проверка полей мин и макс при потери фокуса
		$(".slider-wr-ui .minCost").focusout(function(){
			var value1= $(this).parents('.slider-wr-ui').find(".minCost").val();
			var value2= $(this).parents('.slider-wr-ui').find(".maxCost").val();
			if(parseInt(value1) > parseInt(value2)){
				value1 = value2
				$(this).parents('.slider-wr-ui').find(".minCost").val(value1);
			}
			$(this).parents('.slider-wr-ui').find(".slider-ui").slider("values",0,value1);
		});
		$(".slider-wr-ui .maxCost").focusout(function(){
			var value1= $(this).parents('.slider-wr-ui').find(".minCost").val();
			var value2= $(this).parents('.slider-wr-ui').find(".maxCost").val();
			if(parseInt(value1) > parseInt(value2)){
				value2 = value1
				$(this).parents('.slider-wr-ui').find(".maxCost").val(value1);
			}
			$(this).parents('.slider-wr-ui').find(".slider-ui").slider("values",1,value2);
		});
});
