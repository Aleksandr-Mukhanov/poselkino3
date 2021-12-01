<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Тест"); // на почту start@poselkino.ru ?>
<main class="page page-test">
	<div class="bg-white">
		<div class="container">
			<?$APPLICATION->IncludeComponent(
				"bitrix:breadcrumb",
				"poselkino",
				array(
					"PATH" => "",
					"SITE_ID" => "s1",
					"START_FROM" => "0",
					"COMPONENT_TEMPLATE" => "poselkino"
				),
				false
			);?>
		</div>
	</div>
	<?if($_POST["sendTest"]){ // dump($_POST);
		$mailFields = array(
			"CHEK1" => $_POST["route"], // направление
			"CHEK2" => $_POST["for_what"],
			"CHEK3" => $_POST["remoteness"],
			"CHEK4" => $_POST["cost"],
			"CHEK5" => $_POST["plan"],
			"CHEK6" => $_POST["size"],
			"CHEK7" => $_POST["transport"],
			"FIO" => $_POST["nameTest"],
			"TEL" => $_POST["phoneTest"],
			"EMAIL" => $_POST["emailTest"],
		);
		if (CEvent::Send("SEND_TEST", "s1", $mailFields)) mesOk("Результат теста отправлен!<br>Наш менеджер свяжется с вами в ближайшее время.");
		else mesEr("Error: ".$el->LAST_ERROR);
	}else{?>
	<div class="py-4 py-sm-5">
		<div class="container">
			<div class="row align-items-end">
				<div class="order-1 order-sm-0 col-xl-8 col-sm-9">
					<h2 class="mb-0 text-transform">Ответьте на 6 вопросов, и мы подберем 5 лучших участков по Вашим требованиям!</h2>
				</div>
			</div>
		</div>
	</div>
	<form class="test" id="test" action="" method="post" onSubmit="yaCounter50830593.reachGoal('SEND_TEST');ga('event','SEND_TEST');return true;">
		<div class="test-step">
			<div class="bg-white py-4 py-sm-5">
				<div class="container">
					<div class="row align-items-end">
						<div class="order-1 order-sm-0 col-xl-8 col-sm-9">
							<h1 class="mb-0 text-transform title-step">Выберите направление:</h1>
							<p class="subtitle mb-0"></p>
						</div>
						<div class="order-0 order-sm-1 col-xl-4 col-sm-3 text-sm-right"><span class="question-count">Вопрос:</span><span class="question__number">01</span><span class="question__all">/06</span></div>
					</div>
				</div>
			</div>
			<div class="container test-body pt-4 pt-sm-5 pb-4">
				<div class="row test-body__step" data-title-step="Выберите направление" data-step="1" data-show-step="true">
					<input class="hidden sr-only" id="route" value name="route">
					<div class="col-lg-3 col-sm-6">
						<button class="form-card__item" data-input-name="route" data-input-value="Юг" type="button"> <img src="/assets/img/test/south.svg" alt="Юг"><img class="img-active" src="/assets/img/test/south-active.svg" alt="Юг"><span>Юг</span></button>
					</div>
					<div class="col-lg-3 col-sm-6">
						<button class="form-card__item" data-input-name="route" data-input-value="Север" type="button"> <img src="/assets/img/test/north.svg" alt="Север"><img class="img-active" src="/assets/img/test/north-active.svg" alt="Север"><span>Север</span></button>
					</div>
					<div class="col-lg-3 col-sm-6">
						<button class="form-card__item" data-input-name="route" data-input-value="Запад" type="button"> <img src="/assets/img/test/west.svg" alt="Запад"><img class="img-active" src="/assets/img/test/west-active.svg" alt="Запад"><span>Запад</span></button>
					</div>
					<div class="col-lg-3 col-sm-6">
						<button class="form-card__item" data-input-name="route" data-input-value="Восток" type="button"> <img src="/assets/img/test/east.svg" alt="Восток"><img class="img-active" src="/assets/img/test/east-active.svg" alt="Восток"><span>Восток</span></button>
					</div>
				</div>
				<div class="row test-body__step" data-title-step="На какой удаленности от Москвы рассматриваете земельный участок?" data-step="2" data-show-step="false" style="display: none;">
					<input class="hidden sr-only" id="remoteness" value name="remoteness">
					<div class="col-lg-3 col-md-4 col-sm-6">
						<button class="form-card__item form-card__item--small" data-input-name="remoteness" data-input-value="20" type="button"> <img src="/assets/img/test/20.svg" alt="20"><img class="img-active" src="/assets/img/test/20-active.svg" alt="20"><span>До
								20 км.</span></button>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<button class="form-card__item form-card__item--small" data-input-name="remoteness" data-input-value="50" type="button"> <img src="/assets/img/test/50.svg" alt="50"><img class="img-active" src="/assets/img/test/50-active.svg" alt="50"><span>До
								50 км.</span></button>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<button class="form-card__item form-card__item--small" data-input-name="remoteness" data-input-value="70" type="button"> <img src="/assets/img/test/70.svg" alt="70"><img class="img-active" src="/assets/img/test/70-active.svg" alt="70"><span>До
								70 км.</span></button>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<button class="form-card__item form-card__item--small" data-input-name="remoteness" data-input-value="100" type="button"> <img src="/assets/img/test/100.svg" alt="100"><img class="img-active" src="/assets/img/test/100-active.svg" alt="100"><span>До
								100 км.</span></button>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<button class="form-card__item form-card__item--small" data-input-name="remoteness" data-input-value="irrelevant" type="button"> <span>Не имеет значения</span></button>
					</div>
				</div>
				<div class="row test-body__step" data-title-step="В какую стоимость планируете уложиться при выборе участка?" data-step="3" data-show-step="false" style="display: none;">
					<input class="hidden sr-only" id="cost" value name="cost">
					<div class="col-lg-3 col-md-4 col-sm-6">
						<button class="form-card__item form-card__item--small" data-input-name="cost" data-input-value="До 500 000" type="button"><span>До 500 000</span></button>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<button class="form-card__item form-card__item--small" data-input-name="cost" data-input-value="До 1,5 млн." type="button"><span>До 1,5 млн.</span></button>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<button class="form-card__item form-card__item--small" data-input-name="cost" data-input-value="До 2 млн." type="button"><span>До 2 млн.</span></button>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<button class="form-card__item form-card__item--small" data-input-name="cost" data-input-value="Выше 2 млн." type="button"><span>Выше 2 млн.</span></button>
					</div>
				</div>
				<div class="row test-body__step" data-title-step="Какой размер участка для Вас наиболее подходящий?" data-step="4" data-show-step="false" style="display: none;">
					<input class="hidden sr-only" id="size" value name="size">
					<div class="col-lg-3 col-md-4 col-sm-6">
						<button class="form-card__item form-card__item--small" data-input-name="size" data-input-value="5-6 соток" type="button"><span>5-6 соток</span></button>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<button class="form-card__item form-card__item--small" data-input-name="size" data-input-value="7-9 соток" type="button"><span>7-9 соток</span></button>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<button class="form-card__item form-card__item--small" data-input-name="size" data-input-value="10-12 соток" type="button"><span>10-12 соток</span></button>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<button class="form-card__item form-card__item--small" data-input-name="size" data-input-value="15 соток" type="button"><span>15 соток</span></button>
					</div>
					<div class="col-lg-3 col-md-4 col-sm-6">
						<button class="form-card__item form-card__item--small" data-input-name="size" data-input-value="Любой" type="button"><span>Любой</span></button>
					</div>
				</div>
				<div class="row test-body__step" data-title-step="Каким видом транспорта планируете добираться до посёлка?" data-step="5" data-show-step="false" style="display: none;">
					<input class="hidden sr-only" id="transport" value name="transport">
					<div class="col-md-4 col-sm-6">
						<button class="form-card__item" data-input-name="transport" data-input-value="Автомобиль" type="button"> <img src="/assets/img/test/car.svg" alt="Автомобиль"><img class="img-active" src="/assets/img/test/car-active.svg" alt="Автомобиль"><span>Автомобиль</span></button>
					</div>
					<div class="col-md-4 col-sm-6">
						<button class="form-card__item" data-input-name="transport" data-input-value="Общественный транспорт" type="button"> <img src="/assets/img/test/bus.svg" alt="Общественный транспорт"><img class="img-active" src="/assets/img/test/bus-active.svg"
								alt="Общественный транспорт"><span>Общественный транспорт</span></button>
					</div>
					<div class="col-md-4 col-sm-6">
						<button class="form-card__item" data-input-name="transport" data-input-value="Беру на дальнюю перспективу" type="button"> <img src="/assets/img/test/carbus.svg" alt="Беру на дальнюю перспективу"><img class="img-active" src="/assets/img/test/carbus-active.svg"
								alt="Беру на дальнюю перспективу"><span>Оба варианта</span></button>
					</div>
				</div>
				<div class="row test-body__step step-last" data-title-step="Отправьте нам результаты теста" data-subtitle-step="И мы пришлем перечень поселков, которые вам подходят:" data-step="6" data-show-step="false" style="display: none;">
					<div class="col-md-4 mb-3 mb-md-0">
						<input id="nameTest" type="text" value placeholder="Ваше имя" name="nameTest" required>
					</div>
					<div class="col-md-4 mb-3 mb-md-0">
						<input class="phone" id="phoneTest" type="text" value placeholder="Номер телефона" name="phoneTest" required>
					</div>
					<div class="col-md-4 mb-3 mb-md-0">
						<input id="emailTest" type="email" value placeholder="Адрес электронной почты" name="emailTest" required>
					</div>
					<div class="col-lg-7 col-md-9 privacy-policy-label mt-4">
						<div class="custom-control custom-checkbox custom-control-inline">
							<input class="custom-control-input" id="privacy-policy" type="checkbox" name="privacy-policy" checked required>
							<label class="custom-control-label" for="privacy-policy">Нажимая на кнопку, вы даете согласие на обработку персональных данных и соглашаетесь с  <a class="text-success font-weight-bold" href="/politika-konfidentsialnosti/" title="Ознакомиться с политикой конфиденциальности">Политикой
									Конфиденциальности</a></label>
						</div>
					</div>
				</div>
			</div>
			<div class="container mb-5 test-footer">
				<div class="d-flex justify-content-between w-100"><a class="btn btn--prev btn-secondary rounded-pill" href="#" style="display: none;">
						<svg xmlns="http://www.w3.org/2000/svg" width="15.174" height="9.415" viewBox="0 0 15.174 9.415" class="inline-svg">
							<g transform="translate(0 -75.914)">
								<path d="M14.517,79.964H2.243l2.929-2.929a.657.657,0,1,0-.929-.929l-4.05,4.05a.657.657,0,0,0,0,.929l4.05,4.051a.657.657,0,1,0,.929-.929L2.243,81.278H14.517a.657.657,0,1,0,0-1.314Z" transform="translate(0 0)" fill="#3c4b5a" />
							</g>
						</svg>Шаг&nbsp;назад</a>
						<input type="hidden" name="sendTest" value="1">
					<button class="ml-auto text-white btn btn--next btn-warning rounded-pill" type="button">
						Далее
						<svg xmlns="http://www.w3.org/2000/svg" width="15.174" height="9.415" viewBox="0 0 15.174 9.415" class="inline-svg">
							<g transform="translate(0 -75.914)">
								<path d="M14.517,79.964H2.243l2.929-2.929a.657.657,0,1,0-.929-.929l-4.05,4.05a.657.657,0,0,0,0,.929l4.05,4.051a.657.657,0,1,0,.929-.929L2.243,81.278H14.517a.657.657,0,1,0,0-1.314Z" transform="translate(0 0)" fill="#3c4b5a" />
							</g>
						</svg>
					</button>
					<button class="btn btn-warning rounded-pill text-white" type="submit" disabled="disabled" style="display: none;">Отправить</button>
				</div>
			</div>
		</div>
	</form>
	<?}?>
    <script>
        // Tests
        $('.form-card__item').on('click', function() {
            // Берем значение имеги инпута из кнопки
            const cardData = $(this).data('input-name');

            // Берем значение имеги инпута из кнопки
            const cardValue = $(this).data('input-value');

            // Находим нужнй input
            const inputValue = $('form#test').find('input[name="' + cardData +'"]');

            // Добавляем значегие кнопки в value
            inputValue.val(cardValue);

            // Добавляем константу текущему шагу
            const activeStep = $('.test-body__step[data-show-step="true"]');

            // Удаляем активный пункт с других
            activeStep.find('.form-card__item').removeClass('active');

            // Добавляем класс active по чему кликнули
            $(this).addClass('active');

            if ($('.test-body__step[data-show-step="true"]').data('step') == 6) {
                $('.btn[type="submit"]').removeAttr('disabled');
            }
        });

        $('.btn--next').on('click', function() {
            var destination = $("header").height();
            $('html, body').animate({ scrollTop: destination }, 1100);

            if ($('.test-body__step[data-show-step="true"] input').val().length) {
                // Скрываем активный шаг и открываем следующий
                $('.test-body__step[data-show-step="true"]').hide().attr('data-show-step', false).next().show().attr('data-show-step', true);

                // Меняем заголовок
                $('.title-step').html($('.test-body__step[data-show-step="true"]').data('title-step'));

                // Меняем заголовок
                $('.subtitle').html($('.test-body__step[data-show-step="true"]').data('subtitle-step'));

                // Если шаг больше чем 1, показываем кнопку назад
                if ($('.test-body__step[data-show-step="true"]').data('step') !== 1) {
                    $('.btn--prev').show();
                }

                // Если шаг 8, скрываем кнопку далее и показываем кнопку отправить
                if ($('.test-body__step[data-show-step="true"]').data('step') == 6) {
                    $('.btn--next').hide();
                    $('.btn[type="submit"]').show();
                }

                // Изменяем номер активного шага
                $('.question__number').html('0'+$('.test-body__step[data-show-step="true"]').data('step'));
            } else {
                alert('Выберите один из пунктов');
            }
        });


        $('.btn--prev').on('click', function() {
            // Скрываем активный шаг и открываем следующий
            $('.test-body__step[data-show-step="true"]').hide().attr('data-show-step', false).prev().show().attr('data-show-step', true);

            // Меняем заголовок
            $('.title-step').html($('.test-body__step[data-show-step="true"]').data('title-step'));

            // Меняем заголовок
            $('.subtitle').html('');

            // Если шаг больше чем 1, показываем кнопку назад
            if ($('.test-body__step[data-show-step="true"]').data('step') == 1) {
                $('.btn--prev').hide();
            }

            // Если шаг 8, скрываем кнопку далее и показываем кнопку отправить
            if ($('.test-body__step[data-show-step="true"]').data('step') !== 6) {
                $('.btn--next').show();
                $('.btn[type="submit"]').hide();
            }

            // Изменяем номер активного шага
            $('.question__number').html('0'+$('.test-body__step[data-show-step="true"]').data('step'));

        });
        // Проверяем на заполненность последний шаг и раздизейбливаем кнопку отправить
        var eachInput = $('.step-last input').each(function() {
            if ($(this).val().length != '') {
                $('.btn[type="submit"]').removeAttr('disabled');
            } else {
                $('.btn[type="submit"]').attr('disabled', true);
            }
        });

        setTimeout(eachInput, 500);

    </script>
</main>
<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '1573489849672695');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=1573489849672695&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
