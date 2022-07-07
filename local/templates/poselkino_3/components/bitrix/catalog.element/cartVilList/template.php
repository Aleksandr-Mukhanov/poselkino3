<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Grid\Declension;

$this->setFrameMode(true);

$templateLibrary = array('popup', 'fx');

// формируем имя
$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

// добавим превьюшку в фото
if($arResult["PREVIEW_PICTURE"]){
	array_unshift($arResult['MORE_PHOTO'],$arResult["PREVIEW_PICTURE"]); // положим в начало
} //dump($arResult['MORE_PHOTO']);

// ссылка на ютуб Видеосъемка
$arVideo = explode('https://youtu.be/',$arResult['PROPERTIES']['VIDEO']['VALUE']); //dump($arVideo);
$arResult['PROPERTIES']['VIDEO']['CODE_YB'] = $arVideo[1];

// объекты на тер. и в радиусе 5 км
if (mb_strtolower($arResult['PROPERTIES']['MAGAZIN']['VALUE']) == 'в поселке') $inTer['shop']='Магазин';
elseif(mb_strtolower($arResult['PROPERTIES']['MAGAZIN']['VALUE']) == 'в радиусе 5км') $rad5km['shop']='Магазин';
if (mb_strtolower($arResult['PROPERTIES']['APTEKA']['VALUE']) == 'в поселке') $inTer['pharmacy']='Аптека';
elseif(mb_strtolower($arResult['PROPERTIES']['APTEKA']['VALUE']) == 'в радиусе 5км') $rad5km['pharmacy']='Аптека';
if (mb_strtolower($arResult['PROPERTIES']['CERKOV']['VALUE']) == 'в поселке') $inTer['temple']='Церковь';
elseif(mb_strtolower($arResult['PROPERTIES']['CERKOV']['VALUE']) == 'в радиусе 5км') $rad5km['temple']='Церковь';
if (mb_strtolower($arResult['PROPERTIES']['SHKOLA']['VALUE']) == 'в поселке') $inTer['school']='Школа';
elseif(mb_strtolower($arResult['PROPERTIES']['SHKOLA']['VALUE']) == 'в радиусе 5км') $rad5km['school']='Школа';
if (mb_strtolower($arResult['PROPERTIES']['DETSAD']['VALUE']) == 'в поселке') $inTer['kindergarten']='Дет.сад';
elseif(mb_strtolower($arResult['PROPERTIES']['DETSAD']['VALUE']) == 'в радиусе 5км') $rad5km['kindergarten']='Дет.сад';
if (mb_strtolower($arResult['PROPERTIES']['STROYMATERIALI']['VALUE']) == 'в поселке') $inTer['shop_building']='Строймат.';
elseif(mb_strtolower($arResult['PROPERTIES']['STROYMATERIALI']['VALUE']) == 'в радиусе 5км') $rad5km['shop_building']='Строймат.';
if (mb_strtolower($arResult['PROPERTIES']['CAFE']['VALUE']) == 'в поселке') $inTer['cafe']='Кафе';
elseif(mb_strtolower($arResult['PROPERTIES']['CAFE']['VALUE']) == 'в радиусе 5км') $rad5km['cafe']='Кафе';
if (mb_strtolower($arResult['PROPERTIES']['AVTOZAPRAVKA']['VALUE']) == 'в поселке') $inTer['gas']='АЗС';
elseif(mb_strtolower($arResult['PROPERTIES']['AVTOZAPRAVKA']['VALUE']) == 'в радиусе 5км') $rad5km['gas']='АЗС';
// dump($inTer); dump($rad5km);

// водный знак
$arWaterMark = [
	[
		"name" => "watermark",
		"position" => "bottomright", // Положение
		"type" => "image",
		//"size" => "medium",
		"coefficient" => 3,
		"file" => $_SERVER["DOCUMENT_ROOT"].'/upload/water_sign.png', // Путь к картинке
		"fill" => "resize",
	]
];
foreach ($arResult['MORE_PHOTO'] as $key => $photo){
	 $photoRes = CFile::ResizeImageGet($photo['ID'], array('width'=>3000, 'height'=>3000), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true, $arWaterMark);
	 //dump($photoRes);
	 $arResult['MORE_PHOTO'][$key]['SRC'] = $photoRes['src'];
	 unset($photoRes);
}

// отображение по Наличию домов
$housesValEnum = $arResult['PROPERTIES']['DOMA']['VALUE_ENUM_ID'];

switch ($arResult['PROPERTIES']['TYPE']['VALUE_ENUM_ID']) { // название по типу
	case 1:
			$typePos = "дачном поселке"; break;
	case 2:
			$typePos = "коттеджном поселке"; break;
	case 171:
			$typePos = "фермерстве"; break;
}

$LES = $arResult['PROPERTIES']['LES']['VALUE']; // Лес
$FOREST_KM = $arResult['PROPERTIES']['FOREST_KM']['VALUE']; // Лес расстояние, км

// выводим водоемы
$arWater = $arResult['PROPERTIES']['WATER']['VALUE']; // Водоем
foreach($arWater as $water){
	$strWater .= ($strWater) ? ', '.$water : $water;
}
// выводим почву
$arSoil = $arResult['PROPERTIES']['SOIL']['VALUE']; // Почва
foreach($arSoil as $soil){
	$strSoil .= ($strSoil) ? ', '.$soil : $soil;
}

// км от МКАД
$km_MKAD = $arResult['PROPERTIES']['MKAD']['VALUE'];
switch ($km_MKAD) {
	case $km_MKAD <= 10: $url_km_MKAD = "do-10-km-ot-mkad"; break;
	case $km_MKAD <= 15: $url_km_MKAD = "do-15-km-ot-mkad"; break;
	case $km_MKAD <= 20: $url_km_MKAD = "do-20-km-ot-mkad"; break;
	case $km_MKAD <= 25: $url_km_MKAD = "do-25-km-ot-mkad"; break;
	case $km_MKAD <= 30: $url_km_MKAD = "do-30-km-ot-mkad"; break;
	case $km_MKAD <= 35: $url_km_MKAD = "do-35-km-ot-mkad"; break;
	case $km_MKAD <= 40: $url_km_MKAD = "do-40-km-ot-mkad"; break;
	case $km_MKAD <= 45: $url_km_MKAD = "do-45-km-ot-mkad"; break;
	case $km_MKAD <= 50: $url_km_MKAD = "do-50-km-ot-mkad"; break;
	case $km_MKAD <= 55: $url_km_MKAD = "do-55-km-ot-mkad"; break;
	case $km_MKAD <= 60: $url_km_MKAD = "do-60-km-ot-mkad"; break;
	case $km_MKAD <= 65: $url_km_MKAD = "do-65-km-ot-mkad"; break;
	case $km_MKAD <= 70: $url_km_MKAD = "do-70-km-ot-mkad"; break;
	case $km_MKAD <= 75: $url_km_MKAD = "do-75-km-ot-mkad"; break;
	case $km_MKAD <= 80: $url_km_MKAD = "do-80-km-ot-mkad"; break;

	default: $url_km_MKAD = "do-80-km-ot-mkad"; break;
} // echo $url_km_MKAD;

// объекты экологии
	// склады
	$STORAGE_KM = $arResult['PROPERTIES']['STORAGE_KM']['VALUE'];
	$storage = (mb_strtolower($arResult['PROPERTIES']['STORAGE']['VALUE']) == 'есть') ? true : false;
	// Промзона
	$INDUSTRIAL_ZONE_KM = $arResult['PROPERTIES']['INDUSTRIAL_ZONE_KM']['VALUE'];
	$industrialZone = (mb_strtolower($arResult['PROPERTIES']['INDUSTRIAL_ZONE']['VALUE']) != 'нет' && $INDUSTRIAL_ZONE_KM <= 1) ? true : false;
	// Полигон ТБО
	$LANDFILL_KM = $arResult['PROPERTIES']['LANDFILL_KM']['VALUE'];
	$landfill = (mb_strtolower($arResult['PROPERTIES']['LANDFILL']['VALUE']) == 'есть' && $LANDFILL_KM <= 3) ? true : false;

	$nameVil = $arResult['PROPERTIES']['TYPE']['VALUE'].' '.$name; // тип поселка

	if($housesValEnum == 3){ // Только участки
		$priceSotka = 'Сотка от <span class="split-number">'.formatPrice($arResult['PROPERTIES']['PRICE_SOTKA']['VALUE'][0]).'</span> <span class="rep_rubl">руб.</span>';
	}elseif($housesValEnum == 4 || $housesValEnum == 256){ // Участки с домами
		$priceSotka = 'Дом от <span class="split-number">'.formatPrice($arResult['PROPERTIES']['HOME_VALUE']['VALUE'][0]).'</span> <span class="rep_rubl">руб.</span>';
	}

	// выводим правильные окончания
	// отзывы
	$reviewsDeclension = new Declension('отзыв', 'отзыва', 'отзывов');
	$reviewsText = $reviewsDeclension->get($arResult['CNT_COMMENTS']);
	// просмотр
	$cntPos = $arResult['PROPERTIES']['UP_TO_VIEW']['VALUE'] + 1;
	$ourDeclension = new Declension('человек', 'человека', 'человек');
	$correctText = $ourDeclension->get($cntPos);

	// dump($_COOKIE); // разбираем куки
	if(isset($_COOKIE['comparison_vil'])){
		$arComparison = explode('-',$_COOKIE['comparison_vil']);
	}
	if(isset($_COOKIE['favorites_vil'])){
		$arFavorites = explode('-',$_COOKIE['favorites_vil']);
	}
	$comparison = (in_array($arResult['ID'],$arComparison)) ? 'Y' : 'N';
	$favorites = (in_array($arResult['ID'],$arFavorites)) ? 'Y' : 'N';
	$comp_active = ($comparison == 'Y') ? 'active' : '';
	$fav_active = ($favorites == 'Y') ? 'active' : '';
	$comp_text = ($comparison != 'Y') ? 'Добавить к сравнению' : 'Удалить из сравнения';
	$fav_text = ($favorites != 'Y') ? 'Добавить в избранное' : 'Удалить из избранного';
// dump($arResult);?>

<div class="container mt-md-5">
	<div class="row">
		<div class="order-0 col-12 d-md-none">
			<div class="page-title">
				<h1 class="h2"><?=$arResult["OFFER_TYPE"].' в '.$typePos.' '.$arResult['NAME']?></h1>
			</div>
		</div>
		<div class="order-2 order-md-1 col-md-6">
			<div class="page-title d-none d-md-block">
				<h1 class="h2"><?=$arResult["OFFER_TYPE"].' в '.$typePos.' '.$arResult['NAME']?></h1>
				<div class="wrap-raiting mt-4">
					<div class="card-house__raiting d-flex">
						<div class="line-raiting">
							<div class="line-raiting__star">
								<div class="line-raiting__star--wrap" style="width: <?= $arResult['ratingItogo'] * 100 / 5 ?>%;"></div>
							</div>
							<div class="line-raiting__title"><?=$arResult['ratingItogo']?></div>
						</div>
					</div>
					<div class="card-house__review review">
						<div class="d-flex justify-content-start text-left"><a href="/poselki/<?=$arResult['CODE']?>/#block_reviews">
							<svg xmlns="http://www.w3.org/2000/svg" width="18.455" height="15.821" viewBox="0 0 18.455 15.821" class="inline-svg">
								<g transform="translate(0 -36.507)">
									<path d="M17.22 39.787a8.348 8.348 0 0 0-3.357-2.4 11.972 11.972 0 0 0-4.634-.881 12.246 12.246 0 0 0-3.584.52A10.023 10.023 0 0 0 2.7 38.433a7.025 7.025 0 0 0-1.969 2.106A4.905 4.905 0 0 0 0 43.1a5 5 0 0 0 .932 2.894 7.562 7.562 0 0 0 2.549 2.266 6.546 6.546 0 0 1-.268.782q-.154.371-.278.608a4.184 4.184 0 0 1-.335.525q-.211.288-.319.407l-.355.391q-.247.273-.319.355a.72.72 0 0 0-.082.093l-.072.087-.063.092q-.052.077-.046.1a.274.274 0 0 1-.021.1.136.136 0 0 0 .005.124v.01a.518.518 0 0 0 .18.3.4.4 0 0 0 .314.092A7.73 7.73 0 0 0 3 52.1a11.256 11.256 0 0 0 4.737-2.492 14.09 14.09 0 0 0 1.493.082 11.968 11.968 0 0 0 4.634-.881 8.347 8.347 0 0 0 3.357-2.4 5.053 5.053 0 0 0 0-6.622z"
										class="cls-2" data-name="Path 7" />
								</g>
							</svg><?if($arResult["CNT_COMMENTS"]){?>
								<?=$arResult["CNT_COMMENTS"]?> <?=$reviewsText?> от жителей
							<?}else{?>
								Пока нет отзывов
							<?}?></a></div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-xl-6">
					<?if($arResult['PROPERTIES']['REGION']['VALUE']):?>
					<a class="area-link" href="/poselki/<?=$arResult['CODE']?>/#mapShow" target="_blank">
						<svg xmlns="http://www.w3.org/2000/svg" width="9.24" height="13.193" viewBox="0 0 9.24 13.193" class="inline-svg">
							<path d="M16.09 1.353a4.62 4.62 0 0 0-6.534 0 5.263 5.263 0 0 0-.435 6.494l3.7 5.346 3.7-5.339a5.265 5.265 0 0 0-.431-6.501zm-3.224 4.912a1.687 1.687 0 1 1 1.687-1.687 1.689 1.689 0 0 1-1.687 1.687z" transform="translate(-8.203)" />
						</svg><?=$arResult['PROPERTIES']['REGION']['VALUE'] // Район?> р-н, <?=$arResult['PROPERTIES']['SETTLEM']['VALUE'] // Ближайший населенный пункт?></a>
					<?endif;?>
					<div class="metro d-flex flex-wrap">
						<?if($arResult['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][0]): // если есть шоссе
							$idEnumHW = $arResult['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][0];
							$valEnumHW = $arResult['PROPERTIES']['SHOSSE']['VALUE_XML_ID'][0];
							$colorHW = getColorRoad($idEnumHW);
							$nameHW = $arResult['PROPERTIES']['SHOSSE']['VALUE'][0];
						?>
						<a class="highway-color" href="/poselki/<?=$valEnumHW?>-shosse/">
							<span class="metro-color <?=$colorHW?>"></span>
							<span class="metro-name"><?=$nameHW?> шоссе</span>
						</a>
						<?endif;?>
					</div>
					<a class="metro-other" href="/poselki/<?=$url_km_MKAD?>/"><?=$km_MKAD?> км от МКАД</a>
				</div>
				<div class="col-xl-6">
					<div class="card-house__inline d-flex">
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8" class="inline-svg">
                <path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z" transform="translate(.15 -22.745)"></path>
              </svg>
						</div>
						<div class="card-house__inline-title">Площадь участков:&nbsp;</div>
						<div class="card-house__inline-value">от <?=$arResult['PROPERTIES']['PLOTTAGE']['VALUE'][0]?> до <?=$arResult['PROPERTIES']['PLOTTAGE']['VALUE'][1]?> соток</div>
					</div>
					<div class="card-house__inline d-flex">
						<div class="icon"></div>
						<div class="card-house__inline-title">Поселок:&nbsp;</div>
						<div class="card-house__inline-value"><a class="text-success" href="/poselki/<?=$arResult['CODE']?>/"><?=$arResult['NAME']?></a></div>
					</div>
					<?if($housesValEnum != 3){ // Участки с домами ?>
						<div class="card-house__inline d-flex">
							<div class="icon">
								<svg xmlns="http://www.w3.org/2000/svg" width="16.523" height="16.523" viewBox="0 0 16.523 16.523" class="inline-svg">
                	<path d="M16.523 1.614v13.3a1.615 1.615 0 0 1-1.614 1.614h-1.57a.645.645 0 1 1 0-1.291h1.571a.323.323 0 0 0 .323-.323V8.939h-5.7a.645.645 0 0 1 0-1.291h5.7V1.614a.323.323 0 0 0-.323-.323H7.618v1.893a.645.645 0 0 1-1.291 0V1.291H1.614a.323.323 0 0 0-.323.323v6h5.036V5.723a.645.645 0 0 1 1.291 0V10.8a.645.645 0 1 1-1.291 0V8.907H1.291v6a.323.323 0 0 0 .323.323h4.713v-1.891a.645.645 0 0 1 1.291 0v1.893H10.8a.645.645 0 1 1 0 1.291H1.614A1.615 1.615 0 0 1 0 14.909V1.614A1.615 1.615 0 0 1 1.614 0h13.3a1.615 1.615 0 0 1 1.609 1.614zm0 0"></path>
                </svg></div>
							<div class="card-house__inline-title">
								Площадь домов:&nbsp;</div>
							<div class="card-house__inline-value">от <?=$arResult['PROPERTIES']['HOUSE_AREA']['VALUE'][0]?> до <?=$arResult['PROPERTIES']['HOUSE_AREA']['VALUE'][1]?> м<sup>2</sup></div>
						</div>
					<?}?>
				</div>
				<div class="col-xl-6">
					<div class="va-list-value">
						<div class="va-list-value__item">Всего участков: <?=$arResult['PROPERTIES']['COUNT_PLOTS']['VALUE'] // Количество участков, ед.?></div>
						<div class="va-list-value__item">Участков в продаже: <?=$arResult['PROPERTIES']['COUNT_PLOTS_SALE']['VALUE'] // Количество участков в продаже, ед. ?></div>
						<div class="va-list-value__item">Продано: <?=$arResult['PROPERTIES']['COUNT_PLOTS_SOLD']['VALUE'] // Количество проданных участков, ед.?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="order-1 order-md-2 col-md-6">
			<div class="village-slider">
				<div class="slider__header">
					<?if($arResult['PROPERTIES']['ACTION']['VALUE']){ // вывод акции?>
						<div class="slider__label">Акция<?if($arResult['PROPERTIES']['SALE_SUM']['VALUE']){?> - <?=$arResult['PROPERTIES']['SALE_SUM']['VALUE']?>%<?}?></div>
					<?}?>
					<div class="photo__buttons">
						<button title="<?=$comp_text?>" class="comparison-click <?=$comp_active?>" data-id="<?=$arResult['ID']?>">
							<svg xmlns="http://www.w3.org/2000/svg" width="19.42" height="17.556" viewBox="0 0 19.42 17.556" class="inline-svg add-comparison">
								<g transform="translate(-1216.699 -36.35)">
									<path d="M0 0v16.139" class="s-1" transform="translate(1217.349 37)" />
									<path d="M0 0v8.468" class="s-1" transform="translate(1233.321 37)" />
									<g transform="translate(.586 .586)">
										<path d="M0 0v4.297" class="s-2" transform="translate(1232.735 48)" />
										<path d="M0 0v4.297" class="s-2" transform="rotate(90 592.368 642.516)" />
									</g>
									<path d="M0 0v13.215" class="s-1" transform="translate(1222.807 40.041)" />
									<path d="M0 0v7.641" class="s-1" transform="translate(1228.265 45.499)" />
								</g>
							</svg>
						</button>
						<button title="<?=$fav_text?>" class="favorites-click <?=$fav_active?>" data-id="<?=$arResult['ID']?>">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="21" viewBox="0 0 24 21" class="inline-svg add-heart">
								<g transform="translate(.05 -26.655)">
									<path d="M19.874 30.266a5.986 5.986 0 0 0-8.466 0l-.591.591-.6-.6a5.981 5.981 0 0 0-8.466-.009 5.981 5.981 0 0 0 .009 8.466l8.608 8.608a.614.614 0 0 0 .871 0l8.626-8.594a6 6 0 0 0 .009-8.47zm-.88 7.595L10.8 46.019l-8.169-8.172a4.745 4.745 0 1 1 6.71-6.71l1.036 1.036a.617.617 0 0 0 .875 0l1.027-1.027a4.748 4.748 0 0 1 6.715 6.715z" class="s-1" />
									<circle cx="4.5" cy="4.5" r="4.5" class="s-2" transform="translate(14.96 26.655)" />
									<g transform="translate(-1213.44 -18.727)">
										<path d="M0 0v4.297" class="s-3" transform="translate(1232.735 48)" />
										<path d="M0 0v4.297" class="s-3" transform="rotate(90 592.368 642.516)" />
									</g>
								</g>
							</svg>
						</button>
					</div>
				</div>
				<div class="village-slider__list" id="village-slider">
					<?foreach ($arResult['MORE_PHOTO'] as $photo){ // Основные фото
					  $photoRes = CFile::ResizeImageGet($photo['ID'], array('width'=>1232, 'height'=>872), BX_RESIZE_IMAGE_EXACT);?>
						<div class="village-slider__item" style="background: #eee url('<?=$photoRes['src']?>') 0 100% no-repeat; background-size: cover;" itemprop="image"></div>
					<?unset($photoRes);}?>
				</div>
				<div class="village-slider__list-thumb" id="village-slider-thumb">
					<?foreach ($arResult['MORE_PHOTO'] as $photo){ // Доп. фото
					  $photoRes = CFile::ResizeImageGet($photo['ID'], array('width'=>1232, 'height'=>872), BX_RESIZE_IMAGE_EXACT);?>
						<div class="village-slider__item-thumb" style="background: url('<?=$photoRes['src']?>') 0 100% no-repeat; background-size: cover;" itemprop="image"></div>
				  <?unset($photoRes);}?>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
<?if($arResult["arHouses"]):?>
<div class="container">
<div class="house-in-village area-in-village page__content-list">
	<div class="list--grid">
		<?foreach ($arResult["arHouses"] as $id => $house) {
			$offerURL = '/doma/'.$arResult['CODE'].'-dom-'.$house['ID'].'/';?>
		<div class="card-house">
			<div class="d-flex flex-wrap bg-white card-grid">
				<div class="card-house__photo photo">
					<div class="card-photo__list">
						<?foreach ($house['IMG'] as $key => $value) {?>
							<div class="card-photo__item" style="background: url(<?=$value['src']?>) center center / cover no-repeat; width: 495px;"></div>
						<?}?>
					</div>
					<div class="photo__count"><span class="current">1</span> / <span class="count"><?=count($house['IMG'])?></span>
					</div>
				</div>
				<div class="card-house__content">
					<div class="wrap-title">
						<div class="card-house__title"><a href="<?=$offerURL?>"><?=$house['NAME']?></a></div>
					</div>
					<div class="card-house__inline">
						<img src="/assets/img/svg/house-plan.svg" alt="Площадь дома" class="svg_image">
						<div class="card-house__inline-title">
							Площадь дома:&nbsp;</div>
						<div class="card-house__inline-value"><?=$house['AREA_HOUSE']?> м<sup>2</sup></div>
					</div>
					<div class="card-house__inline">
						<img src="/assets/img/svg/stairs.svg" alt="Этажей" class="svg_image">
						<div class="card-house__inline-title">
							Этажей:&nbsp;</div>
						<div class="card-house__inline-value"><?=$house['FLOORS']?></div>
					</div>
					<div class="card-house__inline">
						<img src="/assets/img/svg/brickwall.svg" alt="Материал" class="svg_image">
						<div class="card-house__inline-title">
							Материал:&nbsp;</div>
						<div class="card-house__inline-value"><span><?=$house['MATERIAL']?></span></div>
					</div>
					<div class="footer-card d-flex align-items-center">
						<div class="footer-card__price"><span class="split-number"><?=$house['PRICE']?></span> <span class="rep_rubl">руб.</span></div>
						<a class="btn btn-outline-warning rounded-pill" href="<?=$offerURL?>">Подробнее</a>
					</div>
				</div>
			</div>
		</div>
		<?}?>
	</div>
</div>
</div>
<?endif;?>
<?if($arResult["arPlots"]):?>
<div class="container">
<div class="house-in-village area-in-village page__content-list">
	<div class="list--grid">
		<?foreach ($arResult["arPlots"] as $id => $plot) { // dump($house);?>
		<div class="card-house area">
			<div class="d-flex flex-wrap bg-white card-grid">
				<div class="card-house__photo photo">
					<div class="card-photo__list">
						<?foreach ($plot['IMG'] as $value) {?>
							<div class="card-photo__item" style="background: url(<?=$value['src']?>) center center / cover no-repeat; width: 495px;"></div>
						<?}?>
					</div>
					<div class="photo__count">
						<span class="current">1</span> / <span class="count"><?=count($plot['IMG'])?></span>
					</div>
				</div>
				<div class="card-house__content">
					<div class="wrap-title">
						<div class="card-house__title"><a href="/uchastki/uchastok-<?=$plot['ID']?>/">Участок <?=$plot['NUMBER']?> в посёлке <?=$arResult['NAME']?></a></div>
					</div>
					<div class="card-house__inline">
						<svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8" class="inline-svg">
							<path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z" transform="translate(.15 -22.745)" />
						</svg>
						<div class="card-house__inline-title">
							Площадь участка:&nbsp;</div>
						<div class="card-house__inline-value"><?=$plot['PLOTTAGE']?> соток</div>
					</div>
					<?if($arResult['PROPERTIES']['TRAIN']['VALUE'] == 'Есть'): // Электричка?>
					<div class="map-block">
						<div class="map-block__icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="33.298" height="17.762" viewBox="0 0 33.298 17.762" class="inline-svg">
								<path d="M.555,16.027h2.83A2.765,2.765,0,0,0,8.325,17.12a2.766,2.766,0,0,0,4.939-1.093h11.21a2.775,2.775,0,0,0,5.439,0h2.83a.555.555,0,0,0,.555-.555V11.259a7.2,7.2,0,0,0-.2-1.669l-1.212-5.1a2.226,2.226,0,0,0-2.177-1.785H13.107L12.154.8a.555.555,0,0,0-.5-.307H3.885a.555.555,0,0,0-.5.307L2.432,2.708H.555A.555.555,0,0,0,0,3.263V15.472A.555.555,0,0,0,.555,16.027Zm5.55,1.11a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,6.1,17.137Zm4.44,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,10.544,17.137Zm16.649,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,27.194,17.137Zm4.828-7.291c.006.026.008.051.013.077H27.748V6.038h3.369ZM4.228,1.6h7.084l.555,1.11H3.673ZM1.11,3.818h28.6a1.119,1.119,0,0,1,1.093.912l.05.2H1.11Zm25.529,2.22V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923H9.989V6.038Zm-4.44,0V9.923H5.55V6.038Zm-7.77,0H4.44V9.923H1.11Zm0,7.215H2.22v-1.11H1.11v-1.11H32.175c0,.075.013.15.013.226v.884h-1.11v1.11h1.11v1.665H29.913a.147.147,0,0,0-.009-.029,2.745,2.745,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.872,2.872,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.862,2.862,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.166-.116a2.955,2.955,0,0,0-.278-.149c-.059-.028-.116-.055-.177-.083a2.755,2.755,0,0,0-.333-.1c-.056-.014-.107-.033-.164-.044a2.631,2.631,0,0,0-1.054,0c-.056.011-.111.03-.164.044a2.768,2.768,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.927,2.927,0,0,0-.278.149q-.083.055-.166.116a2.592,2.592,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.954,2.954,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.829,2.829,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.767,2.767,0,0,0-.144.462.137.137,0,0,1-.009.029h-11.2a.147.147,0,0,0-.009-.029,2.787,2.787,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.871,2.871,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.907,2.907,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.167-.116a2.923,2.923,0,0,0-.277-.149c-.059-.028-.116-.055-.177-.083a2.727,2.727,0,0,0-.33-.1c-.056-.014-.107-.033-.166-.044a2.583,2.583,0,0,0-1.033,0l-.086.016a2.767,2.767,0,0,0-.451.14l-.082.036a2.791,2.791,0,0,0-.42.228l-.022.017a2.789,2.789,0,0,0-.357.295l-.056.051a2.778,2.778,0,0,0-.235.272,2.827,2.827,0,0,0-.242-.278c-.018-.018-.036-.034-.056-.051a2.81,2.81,0,0,0-.357-.295l-.022-.017a2.8,2.8,0,0,0-.42-.228L7.146,12.9a2.792,2.792,0,0,0-.451-.14l-.086-.016a2.581,2.581,0,0,0-1.033,0c-.056.011-.111.03-.164.044a2.716,2.716,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.91,2.91,0,0,0-.275.149c-.055.037-.111.075-.166.116a2.627,2.627,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.832,2.832,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.809,2.809,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.732,2.732,0,0,0-.144.462.147.147,0,0,1-.009.029H1.11Zm0,0" transform="translate(0 -0.488)" fill="#3c4b5a" />
								<path d="M230.4,202.09h11.1v1.11H230.4Zm0,0" transform="translate(-217.079 -190.435)" fill="#3c4b5a" />
							</svg>
						</div>
						<div class="map-block__text">
							<div class="map-block__title">На электричке:</div>
							<div class="map-block__info"><b><?=$arResult['PROPERTIES']['TRAIN_TRAVEL_TIME']['VALUE'] // Электричка (время в пути)?></b> от вокзала: <?=$arResult['PROPERTIES']['TRAIN_VOKZAL']['VALUE'] // Электричка (вокзал)?></div>
						</div>
					</div>
					<?endif;?>
					<div class="map-block">
						<div class="map-block__icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="33.298" height="13.32" viewBox="0 0 33.298 13.32" class="inline-svg">
								<path d="M242.22,86.891H240V88h2.22Zm0,0" transform="translate(-222.796 -81.896)" fill="#3c4b5a" />
								<path d="M.476,3.827l3.77-.538A19.021,19.021,0,0,1,6.382,2.157,18.689,18.689,0,0,1,14.114.492h.655a18.864,18.864,0,0,1,9.008,2.3l1.9,1.038a13.113,13.113,0,0,1,6.346,1.72A2.534,2.534,0,0,1,33.3,7.741v3.3a.555.555,0,0,1-.555.555H30.88a3.318,3.318,0,0,1-6.262,0H9.791a3.318,3.318,0,0,1-6.262,0h-.2a.557.557,0,0,1-.206-.04l-1.8-.721A2.1,2.1,0,0,1,0,8.872v-4.5A.555.555,0,0,1,.476,3.827Zm25.1,7.1a2.22,2.22,0,1,0-.045-.444A2.22,2.22,0,0,0,25.574,10.925Zm-10.034-.444h8.88a3.33,3.33,0,1,1,6.66,0h1.11V7.741a1.42,1.42,0,0,0-.714-1.23,12,12,0,0,0-5.945-1.579H15.539Zm0-6.66h7.813l-.107-.058a17.745,17.745,0,0,0-7.706-2.137ZM14.429,1.6h-.314a17.565,17.565,0,0,0-6.53,1.251l.969.969h5.875ZM4.485,10.925a2.22,2.22,0,1,0-.045-.444A2.22,2.22,0,0,0,4.485,10.925ZM1.11,5.487H2.775V6.6H1.11V8.872a.993.993,0,0,0,.628.927l1.592.639c0-.051.007-.1.01-.153s0-.111.01-.166.017-.111.026-.166.016-.111.027-.161.027-.107.042-.159.026-.106.042-.158.037-.1.055-.152.036-.1.056-.153.046-.1.069-.142.046-.1.072-.147.056-.088.081-.133.055-.1.087-.14.061-.082.092-.123.065-.089.1-.132.069-.076.1-.111.073-.082.111-.121.076-.07.114-.1.079-.075.122-.111.085-.064.127-.1.084-.065.129-.1.094-.055.142-.086.087-.056.132-.079.1-.049.152-.073.091-.046.138-.066.111-.041.166-.061.092-.036.139-.051c.063-.019.128-.033.193-.049.042-.01.083-.023.125-.032.068-.014.138-.022.208-.032.041-.005.08-.014.121-.018a3.383,3.383,0,0,1,.338-.017,3.333,3.333,0,0,1,3.33,3.33h4.441V4.932h-6.1a.554.554,0,0,1-.392-.163L6.493,3.33a17.8,17.8,0,0,0-1.759.962.557.557,0,0,1-.215.079L1.11,4.858Zm0,0" transform="translate(0 -0.492)" fill="#3c4b5a" />
							</svg>
						</div>
						<div class="map-block__text">
							<div class="map-block__title">На автомобиле:</div>
							<div class="map-block__info"><b><?=$arResult['PROPERTIES']['AUTO_NO_JAMS']['VALUE'] // Авто (Время в пути от МКАД без пробок)?></b> от МКАДа без пробок</div>
						</div>
					</div>
					<div class="footer-card d-flex align-items-center">
						<div class="footer-card__price"><span class="split-number"><?=$plot['PRICE']?></span> <span class="rep_rubl">руб.</span></div>
						<a class="btn btn-outline-warning rounded-pill" href="/uchastki/uchastok-<?=$plot['ID']?>/">Подробнее</a>
					</div>
				</div>
			</div>
		</div>
		<?}?>
	</div>
</div>
</div>
<?endif;?>
<div class="page__pagination">
<div class="container">
	<nav aria-label="Постраничная навигация">
		<ul class="pagination d-none d-md-flex justify-content">
			<?=$arResult["NAV_STRING"]?>
		</ul>
		<ul class="pagination d-flex d-md-none justify-content-around">
			<?=$arResult["NAV_STRING"]?>
		</ul>
	</nav>
</div>
</div>
<div class="block-page">
<div class="container">
	<div class="block-page__title block-page__title--icon">
		<div class="icon">
			<svg xmlns="http://www.w3.org/2000/svg" width="23.751" height="21.602" viewBox="0 0 23.751 21.602" class="inline-svg">
				<g transform="translate(225.776 -396.448)" opacity="0.5">
					<path d="M19.67,2.7c3.766,0,5.306-2.859,5.306-5.443a4.968,4.968,0,0,0-5.2-5.031,5.131,5.131,0,0,0-5.388,5.443A5.093,5.093,0,0,0,19.67,2.7Zm.137-1.237c-1.539,0-2.419-2.172-2.419-4.151,0-2.089.6-3.849,2.2-3.849,1.649,0,2.392,2.172,2.392,4.151C21.979-.3,21.374,1.461,19.807,1.461ZM9.663,2.808c.137-.027.165-.082.275-.33l8.055-20.04a3.975,3.975,0,0,0,.3-.825c0-.082-.082-.165-.275-.165-.715,0-5.965.632-11.243.632a5.27,5.27,0,0,0-5.553,5.443,5,5,0,0,0,5.2,5.058,5.223,5.223,0,0,0,5.388-5.443,4.945,4.945,0,0,0-1.512-3.6v-.055c.825-.082,4.069-.3,5.8-.412-.247.577-5.828,13.608-8.494,19.655-.137.33,0,.357.3.3ZM6.64-8.656c-1.622,0-2.392-2.2-2.392-4.178,0-2.034.66-3.849,2.227-3.849,1.512,0,2.337,1.814,2.337,4.178C8.811-10.36,8.234-8.656,6.64-8.656Z" transform="translate(-227 415)" fill="#919fa3" />
				</g>
			</svg>
		</div>
		<h2>Спецпредложения</h2>
	</div>
	<div class="block-page__offer" id="special_offers">
		<? // если была фильтрация по шоссе и районам
		if ($arrFilter["=PROPERTY_4"]) $addFilter["=PROPERTY_4"] = $arrFilter["=PROPERTY_4"];
		if ($arrFilter["=PROPERTY_5"]) $addFilter["=PROPERTY_5"] = $arrFilter["=PROPERTY_5"];
		$arrFilter=array('!PROPERTY_ACTION'=>false); // показывать только акции
		if ($addFilter) array_push($arrFilter,$addFilter); //dump($arrFilter);?>
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
	</div>
</div>
</div>
<?$APPLICATION->IncludeComponent(
 "bitrix:main.include",
 "",
 Array(
	 "AREA_FILE_SHOW" => "file",
	 "AREA_FILE_SUFFIX" => "inc",
	 "EDIT_TEMPLATE" => "",
	 "PATH" => "/include/block_url.php"
 )
);?>
<div class="bg-white">
<?/*?><div class="footer-description">
	<div class="container">
		<div class="row">
			<div class="offset-lg-1 col-lg-10 offset-xl-2 col-xl-8">
				<h2>Земельные участки под дом и дачу <br class="d-none d-sm-block">с хорошим месторасположением</h2>
				<p>База коттеджных и дачных поселков в Московской области. Каталог позволяет найти участки по нужным шоссе и районам, по площади и стоимости, по удаленности от МКАД и коммуникациям. Каждый поселок имеет свой рейтинг, оценку
					пользователей и отзывы.</p>
				<p>Вы можете узнать всю необходимую информацию об интересующем вас поселке, не выходя из дома. На сайте есть фото и видео обзоры поселков, юридическая информация и объекты неблагоприятной</p>
			</div>
		</div>
	</div>
</div><?*/?>
<div class="footer-feedback">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="footer-feedback__wrap">
					<div class="row align-items-center text-center text-lg-left">
						<div class="offset-lg-1 col-lg-6 offset-xl-2 col-xl-5">
							<h3>Нашли ошибку или неактуальную информацию?</h3>
						</div>
						<div class="col-xl-3 col-lg-4 px-3 mt-3 mt-lg-0"><a class="btn btn-outline-secondary rounded-pill" href="#" data-toggle="modal" data-target="#sendError" data-id-button="SEND_ERROR">Сообщить об ошибке</a></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
