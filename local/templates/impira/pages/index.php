<?
$APPLICATION->SetTitle($arVillage['NAME']);
$APPLICATION->SetPageProperty("title", "Коттеджный поселок ".$arVillage['NAME'].", ".$regionName." район - официальный сайт");
$APPLICATION->SetPageProperty("description", "Купить земельный участок в КП ".$arVillage['NAME']." от ".formatPriceSite($arVillage['PROPERTY_PRICE_SOTKA_VALUE'][0])." руб. за сотку. ".$shosseName." шоссе, ".$arVillage['PROPERTY_MKAD_VALUE']." км от МКАД. ИЖС, охрана, свет, газ, ".$regionName." район");
?>
<section class="section-1" style="background-image: url(<?=$prevSrc['src']?>);">
	<div class="section-1-main">
		<div class="container-fluid">
			<h1 class="section-1__title">Коттеджный поселок <?=$arVillage['NAME']?></h1>
			<div class="section-1__desc">Поселок с центральными коммуникациями в <?=$arVillage['PROPERTY_MKAD_VALUE']?> км от МКАД по <?=$shosseNameKomu?> шоссе</div>
			<button class="button section-1__button" data-bs-toggle="modal" data-bs-target="#exampleModal2">Записаться на просмотр</button>
		</div>
	</div>
</section>
<section class="section-2 section" id="section-2">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-11">
				<h2 class="section-title">О поселке</h2>
				<div class="section-text">
					<p><?=$arVillage['PREVIEW_TEXT']?></p>
				</div>
			</div>
		</div>
		<div class="about-desc">
			<div class="row">
				<div class="col-lg-4 mb-3 col-md-6">
					<div class="card card--section-3">
						<div class="card__body">
							<div class="card__icon">
								<svg class="icon">
									<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#arrangement-1"></use>
								</svg>
							</div>
							<div class="card__title">Коммуникации</div>
							<div class="card__desc">
								<p>Подведено электричество <?=$arVillage['PROPERTY_ELECTRO_KVT_VALUE']?> кВт<?if($arVillage['PROPERTY_GAS_ENUM_ID'] == 15): // есть газ?>, магистральный газ по госпрограмме<?endif;?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 mb-3 col-md-6">
					<div class="card card--section-3">
						<div class="card__body">
							<div class="card__icon">
								<svg class="icon">
									<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#arrangement-2"></use>
								</svg>
							</div>
							<div class="card__title">Дороги</div>
							<div class="card__desc">
								<p>В поселке дорожная сеть с твердым покрытием: <?=mb_strtolower($roadsInName['WHAT'])?></p>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-4 mb-3 col-md-6">
					<div class="card card--section-3">
						<div class="card__body">
							<div class="card__icon">
								<svg class="icon">
									<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#infrastr"></use>
								</svg>
							</div>
							<div class="card__title">Инфраструктура</div>
							<div class="card__desc">В нескольких минутах езды: супермаркет, школа, детский сад</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?if($arVillage['PROPERTY_VIDEO_VALUE']):?>
			<div class="section-2__video">
				<!-- <div class="section-btn"><svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M27.2241 13.3996L10.3528 3.08894C10.0686 2.91516 9.74326 2.82024 9.41022 2.81393C9.07718 2.80763 8.74847 2.89018 8.45792 3.05307C8.16737 3.21597 7.92547 3.45334 7.75711 3.74076C7.58874 4.02818 7.5 4.35526 7.5 4.68836V25.3115C7.50027 25.6445 7.58919 25.9714 7.75762 26.2587C7.92604 26.5459 8.16791 26.7832 8.45837 26.946C8.74882 27.1089 9.07739 27.1915 9.41033 27.1853C9.74326 27.1791 10.0686 27.0844 10.3528 26.911L27.2241 16.6003C27.4982 16.4327 27.7246 16.1975 27.8817 15.9173C28.0388 15.6371 28.1213 15.3212 28.1213 14.9999C28.1213 14.6787 28.0388 14.3628 27.8817 14.0826C27.7246 13.8024 27.4982 13.5672 27.2241 13.3996Z"
							fill="white" />
					</svg>
				</div> -->
				<iframe width="100%" height="500" src="https://www.youtube.com/embed/<?=$arVideo[1]?>" title="Поселкино" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			</div>
		<?endif;?>
	</div>
</section>
<section class="section-3 section" id="section-3">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-5 mb-3 mb-xl-0">
				<h2 class="section-title"><?=$arVillage['NAME']?> на карте</h2>
				<div class="section-text">
					<p>От МКАД по <?=$shosseNameKomu?> шоссе до поселка — всего <?=$arVillage['PROPERTY_AUTO_NO_JAMS_VALUE'] // Авто (Время в пути от МКАД без пробок)?> по асфальтированной дороге.<br> В <?$SETTLEM_KM = $arVillage['PROPERTY_SETTLEM_KM_VALUE'];?><?=($SETTLEM_KM < 1) ? ($SETTLEM_KM*1000).' м' : $SETTLEM_KM.' км' // Ближайший населенный пункт расстояние, км?> от поселка расположен <?=$arVillage['PROPERTY_SETTLEM_VALUE'] // Ближайший населенный пункт?>.</p>
				</div>
				<div class="address">
					<div class="address__icon">
						<svg class="icon icon--pin">
							<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#map-pin"></use>
						</svg>
					</div>
					<div class="address__text">Московская область, <?=$regionName?> район, <?=$arVillage['PROPERTY_SETTLEM_VALUE'] // Ближайший населенный пункт?></div>
				</div>
			</div>
			<div class="col-xl">
				<div id="map" data-lon="<?=trim($arCoordinates[1])?>" data-lat="<?=trim($arCoordinates[0])?>"></div>
			</div>
		</div>
	</div>
</section>
<section class="section-4 section" id="section-4">
	<div class="container-fluid">
		<h2 class="section-title mb-4">План поселка</h2>
		<div class="row mb-md-1 mb-lg-3 mb-0">
			<div class="col-lg mb-3">
				<div class="advg">
					<div class="advg__mark"> </div>
					<p>В поселке осталось <?=$arVillage['PROPERTY_COUNT_PLOTS_SALE_VALUE']?> участков<br>в продаже</p>
				</div>
			</div>
			<div class="col-md mb-3">
				<div class="advg">
					<div class="advg__mark"> </div>
					<p>Земельные участки от <?=formatPriceSite($arVillage['PROPERTY_PRICE_SOTKA_VALUE'][0])?> ₽</p>
				</div>
			</div>
			<div class="col-lg mb-3">
				<div class="advg">
					<div class="advg__mark"> </div>
					<p>Площадь земельных участков<br>от <?=$arVillage['PROPERTY_PLOTTAGE_VALUE'][0]?> до <?=$arVillage['PROPERTY_PLOTTAGE_VALUE'][1]?> соток</p>
				</div>
			</div>
		</div>
		<div class="village-plan">
			<?
				$planIFrame = $arVillage['PROPERTY_PLAN_IMG_IFRAME_VALUE'];
				$planIMG = CFile::GetPath($arVillage['PROPERTY_PLAN_IMG_VALUE']);
				if ($planIFrame) $planIMG = $planIFrame;
				$frame = ($planIFrame) ? 'data-iframe="true"' : '';
				$planIMG_res = CFile::ResizeImageGet($arVillage['PROPERTY_PLAN_IMG_VALUE'], array('width'=>1200, 'height'=>700), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
			?>
			<img src="<?=$planIMG_res['src']?>" alt="" />
			<a class="section-btn" href="<?=$planIMG?>" data-fancybox="data-fancybox" <?=$frame?>>
				<svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
					<path d="M11.75 21.75C17.2728 21.75 21.75 17.2728 21.75 11.75C21.75 6.22715 17.2728 1.75 11.75 1.75C6.22715 1.75 1.75 6.22715 1.75 11.75C1.75 17.2728 6.22715 21.75 11.75 21.75Z" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
					<path d="M24.25 24.25L18.8125 18.8125" stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
				</svg>
			</a>
		</div>
	</div>
</section>
<section class="section-5 section">
	<div class="container-fluid">
		<div class="form mb-4 mb-xl-5">
			<div class="section-title">Приглашаем на экскурсию по поселку</div>
			<div class="form-subtitle">Просто заполните форму для обратной связи или позвоните по телефону: <strong class="d-inline-block"><a href="tel:<?=$phoneClear?>"><?=$phone?></a></strong></div>
			<form class="form-section row formSignToView" action="/local/ajax/sendForm.php" method="post" data-formID="view">
				<div class="col-12 col-md mb-2">
					<div class="input">
						<input class="input__controll nameSignToView" type="text" placeholder="Ваше имя" />
					</div>
				</div>
				<div class="col appeal-form__col-input lastNameSpam">
					<input class="input-el lnameSignToView" type="text" name="lname" placeholder="Ваша фамилия">
				</div>
				<div class="col-12 col-md mb-2">
					<input class="input__controll telSignToView" type="tel" placeholder="Номер телефона" />
				</div>
				<div class="col-12 col-lg mb-2">
					<button class="button w-100">Записаться на экскурсию</button>
				</div>
				<div class="col-12">
					<label class="checbox" for="check-1">
						<input type="checkbox" name="check-1" id="check-1" checked/>
						<div class="checbox__control"></div>
						<div class="checbox__label">Нажимая на кнопку, вы даете согласие на обработку персональных данных и соглашаетесь с <a href="/politika-konfidentsialnosti/"> Политикой Конфиденциальности</a></div>
					</label>
				</div>
			</form>
		</div>
	</div>
	<div class="section pb-0">
		<div class="container-fluid">
			<h2 class="section-title mb-4">Все для комфортного отдыха и проживания</h2>
			<div class="row">
				<?$i = 0;
					if ($LES && mb_strtolower($LES) != 'нет'): $i++;?>
					<div class="col-lg-4 col-md-6 mb-md-3 mb-2">
						<div class="card">
							<div class="card__body">
								<div class="card__icon">
									<svg class="icon">
										<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#arrangement-3"></use>
									</svg>
								</div>
								<div class="card__title">Лес</div>
								<div class="card__desc">
									<p>В примыкающем к поселку лесном массиве приятно побродить в тишине или собрать грибов и ягод</p>
								</div>
							</div>
						</div>
					</div>
				<?endif?>
				<?if ($arWater): $i++;?>
					<div class="col-lg-4 col-md-6 mb-md-3 mb-2">
						<div class="card">
							<div class="card__body">
								<div class="card__icon">
									<svg class="icon">
										<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#lake"></use>
									</svg>
								</div>
								<div class="card__title">Озеро или река</div>
								<div class="card__desc">
									<p>Семейный отдых у воды или рыбалка в утренней тишине прямо рядом с вашим домом</p>
								</div>
							</div>
						</div>
					</div>
				<?endif?>
				<?if (in_array('beach',$arVillage['PROPERTY_ON_TERRITORY_VALUE'])): $i++;?>
					<div class="col-lg-4 col-md-6 mb-md-3 mb-2">
						<div class="card">
							<div class="card__body">
								<div class="card__icon">
									<svg class="icon">
										<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#arrangement-9"></use>
									</svg>
								</div>
								<div class="card__title">Пляж</div>
								<div class="card__desc">
									<p>В жаркую погоду дети и взрослые с удовольствием отдохнут на берегу водоема</p>
								</div>
							</div>
						</div>
					</div>
				<?endif?>
				<?if (in_array('playground',$arVillage['PROPERTY_ON_TERRITORY_VALUE'])): $i++;?>
					<div class="col-lg-4 col-md-6 mb-md-3 mb-2">
						<div class="card">
							<div class="card__body">
								<div class="card__icon">
									<svg class="icon">
										<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#arrangement-5"></use>
									</svg>
								</div>
								<div class="card__title">Детская площадка</div>
								<div class="card__desc">
									<p>Маленькие жители весело проведут время и заведут новых друзей среди соседей</p>
								</div>
							</div>
						</div>
					</div>
				<?endif?>
				<?if (in_array('shop',$arVillage['PROPERTY_ON_TERRITORY_VALUE'])): $i++;?>
					<div class="col-lg-4 col-md-6 mb-md-3 mb-2">
						<div class="card">
							<div class="card__body">
								<div class="card__icon">
									<svg class="icon">
										<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#arrangement-6"></use>
									</svg>
								</div>
								<div class="card__title">Магазин</div>
								<div class="card__desc">
									<p>В шаговой доступности магазин продуктов и товаров первой необходимости</p>
								</div>
							</div>
						</div>
					</div>
				<?endif?>
				<?if (in_array('park',$arVillage['PROPERTY_ON_TERRITORY_VALUE'])): $i++;?>
					<div class="col-lg-4 col-md-6 mb-md-3 mb-2">
						<div class="card">
							<div class="card__body">
								<div class="card__icon">
									<svg class="icon">
										<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#arrangement-10"></use>
									</svg>
								</div>
								<div class="card__title">Парк (прогулки)</div>
								<div class="card__desc">
									<p>Дорожки для прогулок и катания на велосипеде, возможность устроить барбекю прямо в поселке</p>
								</div>
							</div>
						</div>
					</div>
				<?endif?>
				<?if(in_array('Охрана', $arVillage['PROPERTY_ARRANGE_VALUE']) && $i < 6): $i++;?>
					<div class="col-lg-4 col-md-6 mb-md-3 mb-2">
						<div class="card">
							<div class="card__body">
								<div class="card__icon">
									<svg class="icon">
										<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#arrangement-4"></use>
									</svg>
								</div>
								<div class="card__title">Охрана</div>
								<div class="card__desc">
									<p>Круглосуточная охрана исключит посторонних на территории и гарантирует безопасность</p>
								</div>
							</div>
						</div>
					</div>
				<?endif?>
				<?if (in_array('school',$arVillage['PROPERTY_ON_TERRITORY_VALUE']) && $i < 6): $i++;?>
					<div class="col-lg-4 col-md-6 mb-md-3 mb-2">
						<div class="card">
							<div class="card__body">
								<div class="card__icon">
									<svg class="icon">
										<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#school"></use>
									</svg>
								</div>
								<div class="card__title">Школа</div>
								<div class="card__desc">
									<p>Средняя общеобразовательная школа расположена в соседнем населенном пункте</p>
								</div>
							</div>
						</div>
					</div>
				<?endif?>
				<?if (in_array('kindergarten',$arVillage['PROPERTY_ON_TERRITORY_VALUE']) && $i < 6): $i++;?>
					<div class="col-lg-4 col-md-6 mb-md-3 mb-2">
						<div class="card">
							<div class="card__body">
								<div class="card__icon">
									<svg class="icon">
										<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#arrangement-9"></use>
									</svg>
								</div>
								<div class="card__title">Детский сад</div>
								<div class="card__desc">
									<p>Вам не придется утомлять малыша поездками по пробкам, детский сад находится совсем рядом</p>
								</div>
							</div>
						</div>
					</div>
				<?endif?>
				<?if (in_array('cafe',$arVillage['PROPERTY_ON_TERRITORY_VALUE']) && $i < 6): $i++;?>
					<div class="col-lg-4 col-md-6 mb-md-3 mb-2">
						<div class="card">
							<div class="card__body">
								<div class="card__icon">
									<svg class="icon">
										<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#cafe"></use>
									</svg>
								</div>
								<div class="card__title">Кафе</div>
								<div class="card__desc">
									<p>Устроить дружескую встречу можно не только у мангала, но и за вкусным ужином в кафе</p>
								</div>
							</div>
						</div>
					</div>
				<?endif?>
				<?if (in_array('pharmacy',$arVillage['PROPERTY_ON_TERRITORY_VALUE']) && $i < 6): $i++;?>
					<div class="col-lg-4 col-md-6 mb-md-3 mb-2">
						<div class="card">
							<div class="card__body">
								<div class="card__icon">
									<svg class="icon">
										<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#pharmacy"></use>
									</svg>
								</div>
								<div class="card__title">Аптека</div>
								<div class="card__desc">
									<p>Если кто-то заболеет, поездка за нужным лекарством не займет больше четверти часа</p>
								</div>
							</div>
						</div>
					</div>
				<?endif?>
				<?if (in_array('gas',$arVillage['PROPERTY_ON_TERRITORY_VALUE']) && $i < 6): $i++;?>
					<div class="col-lg-4 col-md-6 mb-md-3 mb-2">
						<div class="card">
							<div class="card__body">
								<div class="card__icon">
									<svg class="icon">
										<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#gas"></use>
									</svg>
								</div>
								<div class="card__title">АЗС</div>
								<div class="card__desc">
									<p>Заботиться о запасе бензина не нужно - до АЗС всего несколько километров</p>
								</div>
							</div>
						</div>
					</div>
				<?endif?>
			</div>
		</div>
	</div>
</section>
<section class="section-6 section">
	<div class="container-fluid">
		<h2 class="section-title mb-4">Лучшее предложение недели</h2>
		<div class="row">
			<?foreach ($arPlots as $plot) {?>
				<div class="col-md mb-2">
					<div class="card">
						<div class="card__header">
							<div class="card-tag" <?if ($plot['UF_LABEL_COLOR']) echo 'style="background: '.$plot['UF_LABEL_COLOR'].'"'?>><?=$plot['UF_LABEL']?></div>
						</div>
						<div class="card__body">
							<div class="card__body-title"><?=$plot['UF_NAME']?><br><?=formatPriceSite($plot['UF_PRICE'])?> ₽</div>
							<div class="w-100 button" data-bs-toggle="modal" data-bs-target="#exampleModal">Забронировать</div>
						</div>
					</div>
				</div>
			<?}?>
		</div>
	</div>
</section>
<section class="section-7 section pt-3" id="section-7">
	<div class="container-fluid">
		<h2 class="section-title mb-4">Фотогалерея</h2>
	</div>
	<div class="pb-5">
		<div class="swiper mySwiper mb-5">
			<div class="swiper-wrapper">
				<?foreach ($arVillage['PROPERTY_DOP_FOTO_VALUE'] as $key => $photo) { // dump($photo);
					$photoRes = CFile::ResizeImageGet($photo, array('width'=>2000, 'height'=>2000), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);?>
					<div class="swiper-slide">
						<a href="<?=$photoRes['src']?>" data-fancybox="gallery">
							<img src="<?=$photoRes['src']?>" alt="" />
						</a>
					</div>
				<?}?>
			</div>
			<div class="swiper-button">
				<div class="swiper-button-prev"></div>
				<div class="swiper-button-next"></div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="form mb-4" id="contacts">
			<div class="section-title">Остались вопросы?</div>
			<div class="form-subtitle">Заполните форму и наш менеджер свяжется с вами в течении 5 минут</div>
			<form class="form-section row formSignToView" action="/local/ajax/sendForm.php" method="post" data-formID="view">
				<div class="col-12 col-md mb-2">
					<div class="input">
						<input class="input__controll nameSignToView" type="text" placeholder="Ваше имя" />
					</div>
				</div>
				<div class="col appeal-form__col-input lastNameSpam">
					<input class="input-el lnameSignToView" type="text" name="lname" placeholder="Ваша фамилия">
				</div>
				<div class="col-12 col-md mb-2">
					<input class="input__controll telSignToView" type="tel" placeholder="Номер телефона" />
				</div>
				<div class="col-12 col-lg mb-2">
					<button class="button w-100">Отправить заявку</button>
				</div>
				<div class="col-12">
					<label class="checbox" for="check-2">
						<input type="checkbox" name="check-2" id="check-2" checked/>
						<div class="checbox__control"></div>
						<div class="checbox__label">Нажимая на кнопку, вы даете согласие на обработку персональных данных и соглашаетесь с <a href="/politika-konfidentsialnosti/"> Политикой Конфиденциальности</a></div>
					</label>
				</div>
			</form>
		</div>
		<div class="row">
			<div class="col-lg mb-2">
				<div class="card card--green">
					<div class="card__body">
						<div class="card__icon">
							<svg class="icon icon--pin">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#map-pin"></use>
							</svg>
						</div><strong>Адрес поселка:</strong>
						<p>МО, <?=$regionName?> район, <?=$arVillage['PROPERTY_SETTLEM_VALUE']?></p>
					</div>
				</div>
			</div>
			<!-- <div class="col-lg mb-2">
				<div class="card card--green">
					<div class="card__body">
						<div class="card__icon">
							<svg class="icon icon--pin">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#map-pin"></use>
							</svg>
						</div><strong>Офис продаж:</strong>
						<p>Москва, ул. Орджоникидзе 11с11, офис 809</p>
					</div>
				</div>
			</div> -->
			<div class="col-lg mb-2">
				<div class="card card--green">
					<div class="card__body">
						<div class="card__icon">
							<svg class="icon icon--phone">
								<use xlink:href="<?=SITE_TEMPLATE_PATH?>/images/sprite.svg#phone"></use>
							</svg>
						</div><strong>Телефоны:</strong>
						<p><a href="tel:<?=$phoneClear?>"><?=$phone?></a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
