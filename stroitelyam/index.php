<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вы в поисках участка для застройки?");

use Bitrix\Main\Page\Asset;
	Asset::getInstance()->addCss("/assets/css/lend.css");

// получим отзывы
$arOrder = Array("ACTIVE_FROM"=>"DESC");
$arFilter = Array("IBLOCK_ID"=>2,"ACTIVE"=>"Y");
$arSelect = Array("ID","ACTIVE_FROM","PREVIEW_TEXT","PROPERTY_RATING","PROPERTY_DIGNITIES","PROPERTY_DISADVANTAGES","PROPERTY_FIO","PROPERTY_RESIDENT");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,['nTopCount'=>2],$arSelect);
while($arElement = $rsElements->GetNext())
{
	$arDateTime = explode(' ',$arElement["ACTIVE_FROM"]);
	$arDate = explode('.',$arDateTime[0]);
	$arTime = explode(':',$arDateTime[1]);
	// оценка
	$rating = ($arElement["PROPERTY_RATING_VALUE"]) ? $arElement["PROPERTY_RATING_VALUE"] : 4;
	$arComments[] = [
		"FIO" => $arElement["PROPERTY_FIO_VALUE"],
		"DATE" => $arDateTime[0].' '.$arTime[0].':'.$arTime[1],
		"DATE_SCHEMA" => $arDate[2].'-'.$arDate[1].'-'.$arDate[0],
		"RATING" => $rating,
		"DIGNITIES" => $arElement["PROPERTY_DIGNITIES_VALUE"],
		"DISADVANTAGES" => $arElement["PROPERTY_DISADVANTAGES_VALUE"],
		"TEXT" => $arElement["PREVIEW_TEXT"],
		"RESIDENT" => $arElement["PROPERTY_RESIDENT_VALUE"],
	];
}

?>
<main class="page no-margin--footer">

	<section class="first">
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
			<h1 class="first__title">Вы&nbsp;в&nbsp;поисках участка для застройки?</h1>
			<span class="first__txt">Купить землю для застройки</span>
			<a href="#page_block_1" class="btn btn-warning first__button">Поехали!</a>
		</div>
	</section>

	<section class="offer" id="page_block_1">
		<div class="container">
			<h2 class="offer__title">Бесплатно подберем 5&nbsp;участков по&nbsp;вашим критериям в&nbsp;течение дня</h2>
			<div class="row">
				<div class="offer__left col-lg-4 col-md-5 col-sm-6">
					<div class="offer__wrap">
						<div class="offer__subtitle">Отправьте заявку подбор, мы подготовим <b>лучшие предложения дня</b></div>
						<form action="" method="post" class="formOrderLend" data-form="Строителям">
							<div class="form-group offer__form-group">
								<input class="form-control offer__form-control nameOrderLend" id="nameOffer" type="text" placeholder="Введите ваше имя" required>
							</div>
							<div class="form-group offer__form-group">
								<input class="phone form-control offer__form-control telOrderLend" id="telOffer" type="tel" placeholder="Введите номер телефона" autocomplete="off" required inputmode="text">
							</div>
							<button class="btn btn-warning px-5 w-100 rounded-pill offer__button" type="submit">Получить предложения</button>
							<div class="custom-control custom-checkbox custom-control-inline">
								<input class="custom-control-input" id="privacy-policy-offer-1" type="checkbox" name="privacy-policy" checked required>
								<label class="custom-control-label" for="privacy-policy-offer-1">Нажимая на&nbsp;кнопку, вы&nbsp;даете согласие на&nbsp;<a href="/politika-konfidentsialnosti/" target="_blank" class="font-weight-bold offer__link" title="Ознакомиться с обработкой персональных данных">обработку
										персональных данных</a></label>
							</div>
						</form>
					</div>
				</div>
				<div class="col-lg-8 col-md-7 offer__col">
					<div class="offer__right">
						<div class="offer__right-wrap" style="background: center / cover no-repeat url(/assets/img/invest/offer-mokap.png)">
							<div class="offer__sticker">
								<span class="offer__sticker-txt"><span class="offer__sticker-big">650+</span>
									<small class="offer__sticker-small">поселков
										в&nbsp;базе</small></span>
							</div>
							<p class="offer__right-txt">
								В нашей базе данных о продаже недвижимости <b>более 650 поселков</b> по <?=REGION_KOY?> области
							</p>
						</div>
					</div>

				</div>
			</div>
		</div>

	</section>
	<section class="step">
		<div class="container">
			<div class="step__title title_h2">Для того, чтобы найти участок самостоятельно нужно:</div>
			<div class="row">
				<div class="col-lg-4 col-6 step__left">
					<div class="step__item">
						<div style="background: center / contain no-repeat url(/assets/img/invest/step-1.png)" class="step__img"></div>
						<p class="step__txt">Cреди тысячи объявлений в&nbsp;интернете отыскать предварительно подходящее</p>
					</div>
				</div>
				<div class="col-lg-4 col-6 step__right">
					<div class="step__item">
						<div style="background: center / contain no-repeat url(/assets/img/invest/step-2.png)" class="step__img"></div>
						<p class="step__txt">Потратить время и&nbsp;убедиться, что указанная в&nbsp;объявлении информация соответствует действительности</p>
					</div>
				</div>
				<div class="col-lg-4 col-6 step__left">
					<div class="step__item">
						<div style="background: center / contain no-repeat url(/assets/img/invest/step-3.png)" class="step__img"></div>
						<p class="step__txt">Уточнить все детали и&nbsp;вскрыть возможные подводные камни</p>
					</div>
				</div>
				<div class="col-lg-4 col-6 step__right">
					<div class="step__item">
						<div style="background: center / contain no-repeat url(/assets/img/invest/step-4.png)" class="step__img"></div>
						<p class="step__txt">Поехать на&nbsp;место, чтобы убедиться, что он&nbsp;не&nbsp;соответствует вашим ожиданиям</p>
					</div>
				</div>
				<div class="col-lg-4 col-6 step__left">
					<div class="step__item">
						<div style="background: center / contain no-repeat url(/assets/img/invest/step-5.png)" class="step__img"></div>
						<p class="step__txt">Ваш номер телефона попадает в&nbsp;базы агенств недвижимости</p>
					</div>
				</div>
				<div class="col-lg-4 col-6 step__right">
					<div class="step__item step__item_accent">
						<div style="background: center / contain no-repeat url(/assets/img/invest/step-6.png)" class="step__img"></div>
						<p class="step__txt step__txt_white">Всё перечисленное можно сократить до&nbsp;одного звонка нам. И&nbsp;мы&nbsp;сделаем всё это за&nbsp;вас.</p>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="benefit">
		<div class="container">
			<div class="benefit__title title_h2">Работая с&nbsp;нами, вы&nbsp;получаете ряд преимуществ:</div>
			<div class="row">
				<div class="col-12">
					<div class="benefit__item benefit__item_accent">
						<div style="background: center / contain no-repeat url(/assets/img/invest/benefit-1.png)" class="benefit__img-1"></div>
						<p class="benefit__txt benefit__txt_accent">Специальные условия покупки: индивидуальная скидка при полной оплате. Рассрочка до&nbsp;1&nbsp;года</p>
					</div>
				</div>
				<div class="col-6 benefit__left">
					<div class="benefit__item">
						<p class="benefit__txt">Только ликвидные локации: 10-30&nbsp;км от&nbsp;<?=REGION_CITY?>.</p>
						<div style="background: center / contain no-repeat url(/assets/img/invest/benefit-2.png)" class="benefit__img-2"></div>
					</div>
				</div>
				<div class="col-6 benefit__right">
					<div class="benefit__item benefit__item_other">
						<p class="benefit__txt benefit__txt_other">Готовность поселков: 60&nbsp;-&nbsp;75%</p>
					</div>
				</div>
				<div class="col-6 benefit__left">
					<div class="benefit__item benefit__item_other">
						<p class="benefit__txt benefit__txt_other">Быстрые сроки реализации домов: 1-2 месяца</p>
					</div>
				</div>
				<div class="col-6 benefit__right">
					<div class="benefit__item benefit__item_other">
						<p class="benefit__txt">Анализируем спрос на&nbsp;дома: проекты, бюджет, площадь, материалы</p>
						<div style="background: center / contain no-repeat url(/assets/img/invest/benefit-5.png)" class="benefit__img-5"></div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="consultation">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-12 consultation__left">
					<h2 class="consultation__title">Мы&nbsp;сразу озвучиваем вам сумму с&nbsp;дополнительными тратами</h2>
					<p class="consultation__txt">Как правило, в&nbsp;стоимость участка не&nbsp;входит подключение коммуникаций:
						электричество и&nbsp;газа.<br class="consultation__over"> Мы&nbsp;поможем вам сориентироваться по&nbsp;стоимости получение техусловий, работ
						по&nbsp;подключению и&nbsp;госпошлин.<br><br>
						Также есть дополнительные расходы связанные с&nbsp;выносом границ земельного участка и&nbsp;регистрацией.
						Объясним для чего это надо и&nbsp;сколько стоит.
						Таким образом, вы&nbsp;сможете увидеть полный цикл предстоящих расходов и&nbsp;сравнить финальные цены
						за&nbsp;участок. Это поможет сделать вам правильный выбор</p>
					<button type="button" class="btn btn-warning consultation__button" data-toggle="modal" data-target="#openLendForm">Консультация специалиста</button>
				</div>
				<div class="offset-lg-1 col-lg-5 col-md-6 consultation__right">
					<div style="background: center / contain no-repeat url(/assets/img/invest/consultation.png)" class="consultation__img">
					</div>
				</div>
			</div>
		</div>
		<div class="consultation__bottom">
			<div class="container consultation__container">
				<div class="row consultation__container-row">
					<div class="col-12">
						<div class="consultation__wrap" style="background: center / cover no-repeat url(/assets/img/invest/consultation-info.jpg)">
							<div class="container consultation__wrap-container">
								<div class="row consultation__wrap-row">
									<div class="col-md-6 col-8">
										<h2 class="consultation__title">Мы&nbsp;действуем напрямую от&nbsp;собственника</h2>
										<ul class="consultation__list">
											<li class="consultation__list-item">Гарантия выполнения обязательств</li>
											<li class="consultation__list-item">Более 1&nbsp;000 сделок за&nbsp;прошедший год</li>
											<li class="consultation__list-item">Выход на&nbsp;сделку в&nbsp;день обращения</li>
										</ul>
									</div>
									<div class="col-md-6 col-4">
										<div class="consultation__inner">
											<div class="consultation__sticker">
												<span class="consultation__sticker-txt">10%</span>
											</div>
											<span class="consultation__inner-txt">С&nbsp;нами вы&nbsp;экономите&nbsp;10% стоимости участка</span>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<section class="ben-plots">
		<div class="container">
			<div class="ben-plots__title title_h2">Предложим участки:</div>
			<div class="ben-plots__map" style="background: center / cover no-repeat url(/assets/img/invest/map.jpg)">
				<div class="ben-plots__item">
					<span>Прибрежные, видовые,<br>прилесные</span>
				</div>
				<div class="ben-plots__item">
					<span>Без пробок, на электричке</span>
				</div>
				<div class="ben-plots__item">
					<span>Со школой и остановкой<br>общественного транспорта</span>
				</div>
				<div class="ben-plots__item">
					<span>Рядом с городом</span>
				</div>
			</div>
			<ul class="ben-plots__list">
				<li class="ben-plots__list-item">Прибрежные, видовые, прилесные</li>
				<li class="ben-plots__list-item">Со школой и остановкой общественного транпорта</li>
				<li class="ben-plots__list-item">Без пробок, на электричке</li>
				<li class="ben-plots__list-item">Рядом с городом</li>
			</ul>
		</div>
	</section>
	<section class="offer offer_hot">
		<div class="container">
			<h2 class="offer__title">По запросу предоставим информацию&nbsp;об участках
				по&nbsp;специальной цене</h2>
			<div class="row">
				<div class="col-lg-4 col-md-5 offer__left ">
					<div class="offer__wrap offer__wrap_white">
						<div class="offer__subtitle">Отправьте нам заявку и мы пришлем <b>самые горячие предложения</b> на рынке</div>
						<form action="" method="post" class="formOrderLend" data-form="Строителям">
							<div class="form-group offer__form-group">
								<input class="form-control offer__form-control nameOrderLend" id="nameOffer" type="text" placeholder="Введите ваше имя" required>
							</div>
							<div class="form-group offer__form-group">
								<input class="phone form-control offer__form-control telOrderLend" id="telOffer" type="tel" placeholder="Введите номер телефона" autocomplete="off" required inputmode="text">
							</div>
							<button class="btn btn-warning px-5 w-100 rounded-pill offer__button" type="submit">Узнать о скидках</button>
							<div class="custom-control custom-checkbox custom-control-inline">
								<input class="custom-control-input" id="privacy-policy-offer-2" type="checkbox" name="privacy-policy" checked required>
								<label class="custom-control-label" for="privacy-policy-offer-2">Нажимая на&nbsp;кнопку, вы&nbsp;даете согласие на&nbsp;<a href="/politika-konfidentsialnosti/" target="_blank" class="font-weight-bold offer__link" title="Ознакомиться с обработкой персональных данных">обработку
										персональных данных</a></label>
							</div>
						</form>
					</div>
				</div>
				<div class="col-lg-8 col-md-7 offer__col">
					<div class="offer__right">
						<div class="offer__plots" style="background: center  / contain no-repeat url(/assets/img/invest/offer-plots.png)">
							<div class="offer__sticker offer__sale">
								<span class="offer__sticker-txt offer__sale-txt">
									Дополнительная
									скидка в день
									обращения</span>
							</div>
							<p class="offer__right-txt offer__plots-txt">
								В нашей базе данных о продаже недвижимости <b>более 650 поселков</b> по <?=REGION_KOY?> области
							</p>
						</div>
					</div>

				</div>
			</div>
		</div>

	</section>
	<section class="terms">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-6 terms__item">
					<div>
						<div class="terms__title title_h2">Быстро организуем комфортный показ участка</div>
						<div class="terms__desc">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="terms__icon terms__icon-2">
								<path d="M5.40003 15.7998C5.10003 15.2998 4.50004 15.1998 4.10004 15.3998L2.00004 16.6998C1.80004 16.7998 1.60004 16.9998 1.50004 17.2998C1.40004 17.5998 1.50004 17.7998 1.60004 17.9998C1.70004 18.1998 1.90004 18.3998 2.20004 18.4998C2.30004 18.4998 2.40004 18.4998 2.50004 18.4998C2.70004 18.4998 2.80004 18.4998 3.00004 18.3998L5.10003 17.1998C5.50003 16.8998 5.70003 16.2998 5.40003 15.7998Z"
								  fill="#78A86D" />
								<path d="M8.19989 18.5995C7.69989 18.2995 7.09989 18.4994 6.89989 18.9994L5.69989 21.0995C5.59989 21.2995 5.49989 21.5994 5.59989 21.7994C5.69989 22.0994 5.79989 22.2994 6.09989 22.3994C6.29989 22.4994 6.39989 22.4994 6.59989 22.4994C6.89989 22.4994 7.29989 22.2994 7.39989 21.9994L8.59989 19.8994C8.69989 19.6994 8.79989 19.3995 8.69989 19.1995C8.59989 18.8995 8.39989 18.6995 8.19989 18.5995Z"
								  fill="#78A86D" />
								<path d="M2.00004 7.3L4.10004 8.5C4.30004 8.6 4.40004 8.6 4.60003 8.6C4.90003 8.6 5.30003 8.4 5.40003 8.1C5.70003 7.6 5.50003 7 5.00003 6.8L2.90004 5.6C2.70004 5.5 2.50004 5.5 2.20004 5.5C1.90004 5.6 1.70004 5.8 1.60004 6C1.50004 6.2 1.40004 6.5 1.50004 6.7C1.60004 7 1.70004 7.2 2.00004 7.3Z"
								  fill="#78A86D" />
								<path d="M4.39999 12C4.39999 11.5 3.99999 11 3.4 11H0.999999C0.499999 11 0 11.4 0 12C0 12.5 0.399999 13 0.999999 13H3.4C3.99999 13 4.39999 12.5 4.39999 12Z" fill="#78A86D" />
								<path d="M17.0998 18.8999C16.7998 18.3999 16.1998 18.2999 15.7998 18.4999C15.5998 18.5999 15.3998 18.7999 15.2998 19.0999C15.1998 19.3999 15.2998 19.5999 15.3998 19.7999L16.5998 21.8999C16.6998 22.0999 16.8998 22.2999 17.1998 22.3999C17.2998 22.3999 17.3998 22.3999 17.4998 22.3999C17.6998 22.3999 17.7998 22.3999 17.9998 22.2999C18.4998 21.9999 18.5998 21.3999 18.3998 20.9999L17.0998 18.8999Z"
								  fill="#78A86D" />
								<path d="M7.30019 1.99994C7.10019 1.49994 6.50019 1.29994 6.00019 1.59994C5.80019 1.69994 5.60019 1.89994 5.50019 2.19994C5.40019 2.49994 5.50019 2.69994 5.60019 2.89994L6.80019 4.99994C7.00019 5.39994 7.40019 5.59994 7.70019 5.59994C7.90019 5.59994 8.00019 5.59994 8.20019 5.49994C8.70019 5.19994 8.80019 4.59994 8.60019 4.19994L7.30019 1.99994Z"
								  fill="#78A86D" />
								<path d="M21.9999 16.7003L19.8999 15.5003C19.6999 15.4003 19.3999 15.3003 19.1999 15.4003C18.8999 15.5003 18.6999 15.6003 18.5999 15.9003C18.4999 16.1003 18.3999 16.4003 18.4999 16.6003C18.5999 16.9003 18.6999 17.1003 18.9999 17.2003L21.0999 18.4003C21.2999 18.5003 21.3999 18.5003 21.5999 18.5003C21.6999 18.5003 21.7999 18.5003 21.8999 18.5003C22.1999 18.4003 22.3999 18.3003 22.4999 18.0003C22.6999 17.5003 22.4999 16.9003 21.9999 16.7003Z"
								  fill="#78A86D" />
								<path d="M12.0002 0C11.5002 0 11.0002 0.4 11.0002 1V12C11.0002 12.3 11.1002 12.5 11.3002 12.7C11.5002 12.9 11.7002 13 12.0002 13H23.0001C23.5001 13 24.0001 12.6 24.0001 12C24.0001 5.4 18.6001 0 12.0002 0ZM22.0001 11H13.0001V2C17.8001 2.5 21.5001 6.2 22.0001 11Z"
								  fill="#78A86D" />
								<path d="M11.9998 19.6001C11.4998 19.6001 10.9998 20.0001 10.9998 20.6001V23.0001C10.9998 23.5001 11.3998 24.0001 11.9998 24.0001C12.4998 24.0001 12.9998 23.6001 12.9998 23.0001V20.6001C12.9998 20.0001 12.4998 19.6001 11.9998 19.6001Z" fill="#78A86D" />
							</svg>
							<p class="terms__desc-txt">В&nbsp;течение 15-ти минут скоординируем показ участка.
								Даже если вы&nbsp;уже рядом с&nbsp;поселком. </p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-6">
					<div class="terms__img terms__img-1 ml-auto"></div>
				</div>
				<div class="col-md-6 col-6">
					<div class="terms__img terms__img-2"></div>
				</div>
				<div class="col-md-6 col-6 terms__item terms__item-right">
					<div>
						<div class="terms__title title_h2">&laquo;На&nbsp;ходу&raquo; устраиваем дополнительные показы</div>
						<div class="terms__desc terms__desc-right">
							<svg width="22" height="24" viewBox="0 0 22 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="terms__icon-2">
								<path d="M10.6 3.8999C9.70002 3.8999 9.00002 4.1999 8.40002 4.7999C7.80002 5.3999 7.40002 6.1999 7.40002 6.9999C7.40002 7.7999 7.70002 8.5999 8.30002 9.1999C8.90002 9.7999 9.70002 10.0999 10.5 10.0999C11.3 10.0999 12.1 9.7999 12.7 9.1999C13.3 8.5999 13.6 7.7999 13.6 6.9999C13.6 6.1999 13.3 5.3999 12.7 4.7999C12.2 4.1999 11.4 3.8999 10.6 3.8999ZM11.4 7.8999C11.2 8.0999 10.9 8.1999 10.6 8.1999H10.5C10.2 8.1999 10 8.0999 9.80002 7.8999C9.50002 7.5999 9.40002 7.2999 9.40002 6.9999C9.40002 6.6999 9.50002 6.3999 9.70002 6.1999C10 5.9999 10.3 5.8999 10.6 5.8999C10.9 5.8999 11.2 5.9999 11.4 6.1999C11.6 6.3999 11.7 6.6999 11.7 6.9999C11.7 7.2999 11.6 7.5999 11.4 7.8999Z"
								  fill="#78A86D" />
								<path d="M20.7 23.3C21 23.1 21.1 22.8 21.1 22.5V10.2C21.1 10 21 9.8 20.9 9.6C20.8 9.4 20.6 9.3 20.4 9.2L17.6 8.3C18 6.2 17.4 4.1 16 2.5C14.7 0.9 12.7 0 10.6 0C8.5 0 6.5 0.9 5.1 2.5C3.7 4.1 3.1 6.2 3.4 8.3L0.7 9.2C0.5 9.3 0.3 9.4 0.2 9.6C0.1 9.8 0 10 0 10.2V22.5C0 22.8 0.2 23.1 0.4 23.3C0.7 23.5 1 23.5 1.3 23.4L5.7 22L10.1 23.9C10.4 24 10.7 24 10.9 23.9L15.3 22L19.7 23.4C20.1 23.5 20.5 23.5 20.7 23.3ZM4.7 20.2L2 21.1V10.9L4 10.2V10.3C4.1 10.4 4.1 10.5 4.2 10.6C4.4 10.9 4.5 11.2 4.7 11.4V20.2ZM9.6 21.4L6.8 20.2V13.6L6.9 13.7L9.6 16.4V21.4ZM14.3 20.2L11.5 21.4V16.3L14.3 13.5V20.2ZM14.3 10.9L10.6 14.6L7 11C6 10 5.5 8.7 5.5 7.3C5.5 5.9 6 4.6 7 3.6C8 2.6 9.3 2.1 10.7 2.1C12.1 2.1 13.4 2.6 14.4 3.6C15.4 4.6 15.9 5.9 15.9 7.3C15.8 8.6 15.2 9.9 14.3 10.9ZM19.1 21.1L16.3 20.2V11.5C16.6 11.1 16.8 10.7 17 10.3L19 11V21.1H19.1Z"
								  fill="#78A86D" />
							</svg>
							<p class="terms__desc-txt terms__desc-txt-right">В&nbsp;момент, когда вы&nbsp;уже находитесь в&nbsp;пути</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-6 terms__item terms__item-bottom">
					<div>
						<div class="terms__title title_h2">У&nbsp;нас есть уникальные предложения, которых нет
							в&nbsp;общем доступе</div>
						<div class="terms__desc">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="terms__icon terms__icon-2">
								<path d="M23.4 10.0998L22.9 9.4998C22.8 9.2998 22.7 9.0998 22.7 8.7998V7.9998C22.8 6.5998 22 5.2998 20.8 4.6998L20 4.2998C19.8 4.1998 19.7 4.0998 19.5 3.7998L19.1 2.9998C18.5 1.8998 17.3 1.0998 16 1.0998C15.9 1.0998 15.9 1.0998 15.8 1.0998H15C14.7 1.0998 14.5 0.999805 14.3 0.899805L13.6 0.399805C12.5 -0.400195 11 -0.400195 9.89999 0.399805L9.39999 0.999805C9.29999 1.0998 8.99999 1.1998 8.69999 1.1998H7.89999C6.49999 1.0998 5.29999 1.7998 4.69999 3.0998L4.29999 3.7998C4.19999 3.9998 3.99999 4.1998 3.79999 4.2998L3.09999 4.6998C1.89999 5.2998 1.09999 6.5998 1.19999 7.9998V8.7998C1.19999 9.0998 1.09999 9.2998 0.999994 9.4998L0.499994 10.1998C-0.300006 11.2998 -0.300006 12.7998 0.499994 13.9998L0.999994 14.5998C1.09999 14.7998 1.19999 14.9998 1.19999 15.2998V16.0998C1.09999 17.4998 1.89999 18.7998 3.09999 19.3998L3.89999 19.7998C3.99999 19.7998 4.19999 19.9998 4.29999 20.1998L4.69999 20.9998C5.29999 22.0998 6.49999 22.8998 7.69999 22.8998C7.79999 22.8998 7.89999 22.8998 7.99999 22.8998H8.79999C9.09999 22.8998 9.29999 22.9998 9.49999 23.0998L10.2 23.5998C10.8 23.9998 11.4 24.1998 12.1 24.1998C12.8 24.1998 13.4 23.9998 14 23.5998L14.7 23.0998C14.9 22.9998 15.1 22.8998 15.4 22.8998H16.2C16.3 22.8998 16.3 22.8998 16.4 22.8998C17.7 22.8998 18.9 22.1998 19.5 20.9998L19.9 20.1998C20 19.9998 20.1 19.8998 20.4 19.6998L21.2 19.2998C22.4 18.6998 23.2 17.3998 23.1 15.9998V15.1998C23.1 14.8998 23.2 14.6998 23.3 14.4998L23.8 13.7998C24.2 12.6998 24.2 11.1998 23.4 10.0998ZM10.6 21.0998C9.99999 20.6998 9.39999 20.4998 8.69999 20.4998H8.59999H7.79999C7.39999 20.4998 6.99999 20.2998 6.69999 19.8998L6.29999 19.0998C5.99999 18.3998 5.39999 17.8998 4.79999 17.5998L3.99999 17.2998C3.59999 17.0998 3.39999 16.6998 3.39999 16.1998V15.3998C3.39999 14.6998 3.19999 13.8998 2.79999 13.2998L2.29999 12.5998C1.99999 12.1998 1.99999 11.7998 2.29999 11.3998L2.79999 10.6998C3.19999 10.0998 3.39999 9.39981 3.39999 8.5998V7.7998C3.39999 7.3998 3.59999 6.9998 3.99999 6.6998L4.79999 6.2998C5.39999 5.9998 5.89999 5.3998 6.29999 4.7998L6.59999 3.9998C6.79999 3.5998 7.19999 3.3998 7.69999 3.3998H8.49999C8.59999 3.3998 8.59999 3.3998 8.69999 3.3998C9.39999 3.3998 10.1 3.1998 10.6 2.7998L11.3 2.2998C11.7 1.9998 12.1 1.9998 12.5 2.2998L13.2 2.7998C13.7 3.1998 14.4 3.3998 15.1 3.3998C15.2 3.3998 15.2 3.3998 15.3 3.3998H16.1H16.2C16.6 3.3998 17 3.5998 17.2 3.9998L17.6 4.7998C17.9 5.3998 18.5 5.9998 19.1 6.2998L19.9 6.6998C20.3 6.8998 20.5 7.2998 20.5 7.7998V8.6998C20.5 9.3998 20.7 10.1998 21.1 10.7998L21.6 11.4998C21.9 11.8998 21.9 12.2998 21.6 12.6998L21 13.2998C20.6 13.8998 20.4 14.5998 20.4 15.3998V16.1998C20.4 16.5998 20.2 16.9998 19.8 17.2998L19 17.6998C18.4 17.9998 17.8 18.5998 17.5 19.1998L17.3 19.9998C17.1 20.3998 16.7 20.5998 16.2 20.5998L15.4 20.4998C15.3 20.4998 15.3 20.4998 15.2 20.4998C14.5 20.4998 13.8 20.6998 13.3 21.0998L12.6 21.5998C12.2 21.8998 11.8 21.8998 11.4 21.5998L10.6 21.0998Z"
								  fill="#78A86D" />
								<path d="M11.3 6.5C10.7 5.9 9.89999 5.5 8.99999 5.5C8.19999 5.5 7.39999 5.8 6.79999 6.4C6.19999 7.1 5.89999 7.9 5.89999 8.7C5.89999 9.5 6.19999 10.3 6.79999 11C7.39999 11.6 8.19999 11.9 8.99999 11.9C10.8 11.9 12.2 10.5 12.2 8.7C12.2 7.9 11.9 7.1 11.3 6.5ZM9.89999 8.7C9.89999 9.2 9.49999 9.6 8.99999 9.6C8.49999 9.6 8.19999 9.2 8.19999 8.7C8.19999 8.2 8.59999 7.8 9.09999 7.8C9.59999 7.8 9.89999 8.2 9.89999 8.7Z"
								  fill="#78A86D" />
								<path d="M17.2 12.9996C16.6 12.3996 15.8 12.0996 15 12.0996C13.2 12.0996 11.8 13.4996 11.8 15.2996C11.8 16.0996 12.1 16.8996 12.7 17.5996C13.3 18.1996 14.1 18.4996 14.9 18.4996C15.7 18.4996 16.5 18.1996 17.1 17.5996C17.7 16.9996 18 16.1996 18 15.2996C18 14.3996 17.8 13.6996 17.2 12.9996ZM15.8 15.2996C15.8 15.7996 15.4 16.1996 14.9 16.1996C14.4 16.1996 14 15.7996 14 15.2996C14 14.7996 14.4 14.3996 14.9 14.3996C15.4 14.3996 15.8 14.8996 15.8 15.2996Z"
								  fill="#78A86D" />
								<path d="M16 6.2998L6.29999 15.9998L7.99999 17.6998L17.7 7.9998L16 6.2998Z" fill="#78A86D" />
							</svg>
							<p class="terms__desc-txt">Сделаем скидку при полной оплате или рассрочку на&nbsp;время строительства</p>
						</div>
					</div>
				</div>
				<div class="col-md-6 col-6">
					<div class="terms__img ml-auto terms__img-3"></div>
				</div>
				<div class="col-md-6 col-6">
					<div class="terms__img terms__img-4"></div>
				</div>
				<div class="col-md-6 col-6 terms__item terms__item-bottom terms__item-right">
					<div>
						<div class="terms__title title_h2">Составим маршрут для просмотра подходящих вам участков</div>
						<div class="terms__desc terms__desc-right">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="terms__icon-2">
								<path d="M18 1V0H16V1H8V0H6V1H0V19C0 21.8 2.2 24 5 24H19C21.8 24 24 21.8 24 19V1H18ZM6 3V5H8V3H16V5H18V3H22V7H2V3H6ZM19 22H5C3.3 22 2 20.7 2 19V9H22V19C22 20.7 20.7 22 19 22ZM10.2 11H13.2V20H11.2V13H10.2V11Z" fill="#78A86D" />
							</svg>
							<p class="terms__desc-txt terms__desc-txt-right">По&nbsp;нашему опыту за&nbsp;1&nbsp;день вы&nbsp;подберете нужный вариант</p>
						</div>
					</div>
				</div>
			</div>
		</div>

	</section>
	<section class="examples" id="example">
		<div class="container">
			<h2 class="examples__title">Примеры поселков для застройки</h2>
			<div class="tab-content">
				<div class="tab-pane active" id="raiting-area" role="tabpanel">
          <div class="block-page__offer" id="raiting-area-slick">
						<?$arrFilter=array('PROPERTY_DOMA'=>[3,256]); // показывать только участки?>
		 				<?$APPLICATION->IncludeComponent(
		 					"bitrix:main.include",
		 					"",
		 					Array(
		 						"AREA_FILE_SHOW" => "file",
		 						"AREA_FILE_SUFFIX" => "inc",
		 						"EDIT_TEMPLATE" => "",
		 						"PATH" => "/include/section_index.php"
		 					)
		 				);?>
		 				<?unset($arrFilter['PROPERTY_DOMA']);?>
          </div>
        </div>
			</div>
		</div>
	</section>
	<section class="reviews">
		<div class="container">
			<h2 class="reviews__title">Не приукрашиваем предложение</h2>
			<ul class="reviews__list">
				<li class="reviews__list-item">Для нас важно, чтобы вы остались довольны выбранным участком.</li>
				<li class="reviews__list-item">Мы заинтересованы, чтобы вы рекомендовали нас друзьям и знакомым</li>
				<li class="reviews__list-item">Поэтому говорим правду и честно предупреждаем о подводных камнях</li>
			</ul>
			<div class="row">
				<?
				foreach($arComments as $comment){
					$marker = ($comment["RESIDENT"]) ? true : false; // отзыв от жителя
					if (!$comment["FIO"]) $comment["FIO"] = 'Покупатель';
				?>
				<div class="col-md-6">
					<div class="review-card" itemprop="review" itemscope itemtype="http://schema.org/Review">
						<meta itemprop="itemReviewed" content="о поселкино">
						<div class="review-card__user">
							<div class="review-card__user-avatar"></div>
							<div class="name" itemprop="author"><?=$comment["FIO"]?></div>
							<div class="date" itemprop="datePublished" content="<?=$comment["DATE_SCHEMA"]?>>"><?if($marker)echo'Житель, '?><?=$comment["DATE"]?></div>
							<div class="review-star">
								<div class="line-raiting" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
									<div class="line-raiting__star">
										<div class="line-raiting__star--wrap" style="width: <?=$comment['RATING'] * 100 / 5; ?>%;"></div>
									</div>
									<div class="line-raiting__title" itemprop="ratingValue"><?=$comment["RATING"]?></div>
									<span itemprop="bestRating" class="hide">5</span>
									<span itemprop="worstRating" class="hide">1</span>
								</div>
							</div>
						</div>
						<div class="review-card__text">
							<div class="review-card__text-title advantages">
								<svg xmlns="http://www.w3.org/2000/svg" width="18.523" height="18.523" viewBox="0 0 18.523 18.523" class="inline-svg">
									<path d="M9.262,0a9.262,9.262,0,1,0,9.262,9.262A9.272,9.272,0,0,0,9.262,0Zm4.453,9.974H9.974v3.918a.712.712,0,0,1-1.425,0V9.974H4.809a.712.712,0,1,1,0-1.425h3.74V4.987a.712.712,0,1,1,1.425,0V8.549h3.74a.712.712,0,0,1,0,1.425Z" fill="#78a86d" />
								</svg>Достоинства
							</div>
							<p><?=$comment["DIGNITIES"]?></p>
						</div>
						<div class="review-card__text">
							<div class="review-card__text-title disadvantages">
								<svg xmlns="http://www.w3.org/2000/svg" width="18.523" height="18.523" viewBox="0 0 18.523 18.523" class="inline-svg">
									<path d="M9.262,0a9.262,9.262,0,1,0,9.262,9.262A9.272,9.272,0,0,0,9.262,0Zm4.453,9.974H4.809a.712.712,0,1,1,0-1.425h8.905a.712.712,0,0,1,0,1.425Z" fill="#c66574" />
								</svg>Недостатки
							</div>
							<p><?=$comment["DISADVANTAGES"]?></p>
						</div>
						<div class="review-card__text">
							<div class="review-card__text-title">Отзывы</div>
							<p itemprop="reviewBody"><?=$comment["TEXT"]?></p>
						</div>
					</div>
				</div>
				<?}?>
				<!-- <div class="col-12 mt-4 text-center">
					<div class="row">
						<div class="offset-lg-4 col-lg-4 offset-md-3 col-md-6 offset-sm-3 col-sm-6 reviews__all-col"><a class="btn btn-outline-warning rounded-pill w-100 reviews__all" href="/poselki/soyuz/reviews/">Все отзывы</a></div>
					</div>
				</div> -->
			</div>
		</div>
	</section>
	<section class="offer offer__actual">
		<div class="container">
			<h2 class="offer__title">Предоставим самые актуальные предложения с&nbsp;учетом ваших целей и&nbsp;пожеланий</h2>
			<div class="row">
				<div class="col-lg-4 col-md-5 offer__left">
					<div class="offer__wrap offer__wrap_white">
						<div class="offer__subtitle">Отправьте заявку подбор, мы подготовим <b>самые актуальные предложения</b></div>
						<form action="" method="post" class="formOrderLend" data-form="Строителям">
							<div class="form-group offer__form-group">
								<input class="form-control offer__form-control nameOrderLend" id="nameOffer" type="text" placeholder="Введите ваше имя" required>
							</div>
							<div class="form-group offer__form-group">
								<input class="phone form-control offer__form-control telOrderLend" id="telOffer" type="tel" placeholder="Введите номер телефона" autocomplete="off" required inputmode="text">
							</div>
							<button class="btn btn-warning px-5 w-100 rounded-pill offer__button" type="submit">Получить предложение</button>
							<div class="custom-control custom-checkbox custom-control-inline">
								<input class="custom-control-input" id="privacy-policy-offer-3" type="checkbox" name="privacy-policy" checked required>
								<label class="custom-control-label" for="privacy-policy-offer-3">Нажимая на&nbsp;кнопку, вы&nbsp;даете согласие на&nbsp;<a href="/politika-konfidentsialnosti/" target="_blank" class="font-weight-bold offer__link" title="Ознакомиться с обработкой персональных данных">обработку
										персональных данных</a></label>
							</div>
						</form>
					</div>
				</div>
				<div class="col-lg-8 col-md-7 offer__col">
					<div class="offer__right">
						<div class="offer__right-wrap offer__actual-right" style="background: center / cover no-repeat url(/assets/img/invest/offer-mokap.png)">
							<div class="offer__sticker offer__actual-sticker">
								<span class="offer__sticker-txt"><span class="offer__sticker-big">650+</span>
									<small class="offer__sticker-small">поселков
										в&nbsp;базе</small></span>
							</div>
							<p class="offer__right-txt offer__actual-right-txt">
								В нашей базе данных о продаже недвижимости <b>более 650 поселков</b> по <?=REGION_KOY?> области
							</p>
						</div>
					</div>

				</div>
			</div>
		</div>

	</section>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
