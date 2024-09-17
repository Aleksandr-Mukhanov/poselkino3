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

if ($arResult['PROPERTIES']['NAME_OTHER']['VALUE']) $name = $arResult['PROPERTIES']['NAME_OTHER']['VALUE'];

// добавим превьюшку в фото
if($arResult["PREVIEW_PICTURE"]){
	array_unshift($arResult['MORE_PHOTO'],$arResult["PREVIEW_PICTURE"]); // положим в начало
	$arResult['MORE_PHOTO_COUNT']++;
} //dump($arResult['MORE_PHOTO']);

// ссылка на ютуб Видеосъемка
$arVideo = explode('https://youtu.be/',$arResult['PROPERTIES']['VIDEO']['VALUE']);
$arResult['PROPERTIES']['VIDEO']['CODE_YB'] = $arVideo[1];
$arVideoVil = explode('https://youtu.be/',$arResult['PROPERTIES']['VIDEO_VIL']['VALUE']);
$arResult['PROPERTIES']['VIDEO_VIL']['CODE_YB'] = $arVideoVil[1];

// объекты на тер. и в радиусе 5 км
$inTer = [];
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

foreach ($arResult['PROPERTIES']['ON_TERRITORY']['VALUE'] as $value)
	$inTer[$value] = $arResult['INFRASTRUKTURA'][$value];

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
// фото поселков для участка
foreach ($arResult['MORE_PHOTO'] as $photo){
	 $photoRes = CFile::ResizeImageGet($photo['ID'], array('width'=>580, 'height'=>358), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true);
	 $arResult['PHOTO_VILLAGE'][] = $photoRes;
	 unset($photoRes);
}

// отображение по Наличию домов
$housesValEnum = $arResult['PROPERTIES']['DOMA']['VALUE_ENUM_ID'];

switch ($arResult['PROPERTIES']['TYPE']['VALUE_ENUM_ID']) { // название по типу
	case PROP_DACHA:
			$typePos = "дачном поселке"; break;
	case PROP_COTTAGE:
			$typePos = "коттеджном поселке"; break;
	case PROP_FARMING:
			$typePos = "фермерстве"; break;
}

$LES = $arResult['PROPERTIES']['LES']['VALUE']; // Лес
$FOREST_KM = $arResult['PROPERTIES']['FOREST_KM']['VALUE']; // Лес расстояние, км
if (mb_strtolower($LES) == 'нет') $LES = 'Рядом нет';

// выводим водоемы
$arWater = $arResult['PROPERTIES']['WATER']['VALUE']; // Водоем
foreach($arWater as $water){
	$strWater .= ($strWater) ? ', '.$water : $water;
}
if (!$arWater) $strWater = 'Рядом нет';

// выводим почву
$arSoil = $arResult['PROPERTIES']['SOIL']['VALUE']; // Почва
foreach($arSoil as $soil){
	$strSoil .= ($strSoil) ? ', '.$soil : $soil;
}
if (!$arSoil) $strSoil = 'Информации нет';

$landscape = $arResult['PROPERTIES']['LANDSCAPE']['VALUE']; // Ландшафт
if (!$landscape) $landscape = 'Информации нет';

// км от МКАД
$km_MKAD = (float)$arResult['PROPERTIES']['MKAD']['VALUE'];
switch ($km_MKAD) {
	case $km_MKAD <= 10: $url_km_MKAD = "do-10-km-ot-".ROAD_URL; break;
	case $km_MKAD <= 15: $url_km_MKAD = "do-15-km-ot-".ROAD_URL; break;
	case $km_MKAD <= 20: $url_km_MKAD = "do-20-km-ot-".ROAD_URL; break;
	case $km_MKAD <= 25: $url_km_MKAD = "do-25-km-ot-".ROAD_URL; break;
	case $km_MKAD <= 30: $url_km_MKAD = "do-30-km-ot-".ROAD_URL; break;
	case $km_MKAD <= 35: $url_km_MKAD = "do-35-km-ot-".ROAD_URL; break;
	case $km_MKAD <= 40: $url_km_MKAD = "do-40-km-ot-".ROAD_URL; break;
	case $km_MKAD <= 45: $url_km_MKAD = "do-45-km-ot-".ROAD_URL; break;
	case $km_MKAD <= 50: $url_km_MKAD = "do-50-km-ot-".ROAD_URL; break;
	case $km_MKAD <= 55: $url_km_MKAD = "do-55-km-ot-".ROAD_URL; break;
	case $km_MKAD <= 60: $url_km_MKAD = "do-60-km-ot-".ROAD_URL; break;
	case $km_MKAD <= 65: $url_km_MKAD = "do-65-km-ot-".ROAD_URL; break;
	case $km_MKAD <= 70: $url_km_MKAD = "do-70-km-ot-".ROAD_URL; break;
	case $km_MKAD <= 75: $url_km_MKAD = "do-75-km-ot-".ROAD_URL; break;
	case $km_MKAD <= 80: $url_km_MKAD = "do-80-km-ot-".ROAD_URL; break;

	default: $url_km_MKAD = "do-80-km-ot-".ROAD_URL; break;
} // echo $url_km_MKAD;

// объекты экологии
	// склады
	$STORAGE_KM = $arResult['PROPERTIES']['STORAGE_KM']['VALUE'];
	$storage = (mb_strtolower($arResult['PROPERTIES']['STORAGE']['VALUE']) == 'есть') ? true : false;
	// Промзона
	$INDUSTRIAL_ZONE_KM = (float)$arResult['PROPERTIES']['INDUSTRIAL_ZONE_KM']['VALUE'];
	$industrialZone = (mb_strtolower($arResult['PROPERTIES']['INDUSTRIAL_ZONE']['VALUE']) != 'нет' && $INDUSTRIAL_ZONE_KM <= 1) ? true : false;
	// Полигон ТБО
	$LANDFILL_KM = (float)$arResult['PROPERTIES']['LANDFILL_KM']['VALUE'];
	$landfill = (mb_strtolower($arResult['PROPERTIES']['LANDFILL']['VALUE']) == 'есть' && $LANDFILL_KM <= 3) ? true : false;

	$nameVil = $arResult['PROPERTIES']['TYPE']['VALUE'].' '.$name; // тип поселка

	if($housesValEnum == PROP_NO_DOM){ // Только участки
		$priceSotka = 'Сотка от <span class="split-number">'.formatPrice($arResult['PROPERTIES']['PRICE_SOTKA']['VALUE'][0]).'</span><span class="rub_currency">&#8381;</span>';
	}elseif($housesValEnum == PROP_WITH_DOM || $housesValEnum == PROP_HOUSE_PLOT){ // Участки с домами
		$priceSotka = 'Дом от <span class="split-number">'.formatPrice($arResult['PROPERTIES']['HOME_VALUE']['VALUE'][0]).'</span><span class="rub_currency">&#8381;</span>';
	}

	// выводим правильные окончания
	// отзывы
	$reviewsDeclension = new Declension('отзыв', 'отзыва', 'отзывов');
	$reviewsText = $reviewsDeclension->get($arResult['CNT_COMMENTS']);
	// просмотр
	$cntPos = ($arResult['PROPERTIES']['UP_TO_VIEW']['VALUE']) ? $arResult['PROPERTIES']['UP_TO_VIEW']['VALUE'] + 1 : 1;
	$ourDeclension = new Declension('человек', 'человека', 'человек');
	$correctText = $ourDeclension->get($cntPos);

	// dump($_COOKIE); // разбираем куки
	$arComparison = $arComparisonPlots = $arComparisonHouses = [];
	$arFavorites = $arFavoritesPlots = $arFavoritesHouses = [];

	if(isset($_COOKIE['comparison_vil']))
		$arComparison = explode('-',$_COOKIE['comparison_vil']);

	if (isset($_COOKIE['comparison_plots']))
		$arComparisonPlots = explode('-',$_COOKIE['comparison_plots']);

	if (isset($_COOKIE['comparison_houses']))
		$arComparisonHouses = explode('-',$_COOKIE['comparison_houses']);

	if(isset($_COOKIE['favorites_vil']))
		$arFavorites = explode('-',$_COOKIE['favorites_vil']);

	if(isset($_COOKIE['favorites_plots']))
		$arFavoritesPlots = explode('-',$_COOKIE['favorites_plots']);

	if(isset($_COOKIE['favorites_houses']))
		$arFavoritesHouses = explode('-',$_COOKIE['favorites_houses']);

	$comparison = (in_array($arResult['ID'],$arComparison)) ? 'Y' : 'N';
	$favorites = (in_array($arResult['ID'],$arFavorites)) ? 'Y' : 'N';
	$comp_active = ($comparison == 'Y') ? 'active' : '';
	$fav_active = ($favorites == 'Y') ? 'active' : '';
	$comp_text = ($comparison != 'Y') ? 'Добавить к сравнению' : 'Удалить из сравнения';
	$fav_text = ($favorites != 'Y') ? 'Добавить в избранное' : 'Удалить из избранного';

	// цвета этапа продаж
	switch ($arResult['PROPERTIES']['SALES_PHASE']['VALUE_XML_ID']) {
		case 'start':
			$colorIcon = 'f7ba61'; $colorBG = 'fdf4d7'; break;
		case 'final':
			$colorIcon = 'f23838'; $colorBG = 'feebeb'; break;
		case 'sold':
			$colorIcon = '919fa3'; $colorBG = 'e5eaeb'; break;
		default:
			$colorIcon = '78a86d'; $colorBG = 'edf8ea'; break;
	}

	$statusSold = ($arResult['PROPERTIES']['SALES_PHASE']['VALUE_XML_ID'] == 'sold') ? true : false;

	$SETTLEM_KM = (float)$arResult['PROPERTIES']['SETTLEM_KM']['VALUE'];
	$TOWN_KM = (float)$arResult['PROPERTIES']['TOWN_KM']['VALUE'];
	$RAILWAY_KM = (float)$arResult['PROPERTIES']['RAILWAY_KM']['VALUE'];
	$arArrange = $arResult['PROPERTIES']['ARRANGE']['VALUE'];

// dump($arResult['PROPERTIES']);?>
<div class="container mt-md-5">
	<div class="row">
		<div class="order-0 order-md-0 col-xl-8 col-md-7">
			<div class="page-title title_h2">
				<h1 itemprop="name"><?=$nameVil?></h1>
			</div>
			<div class="active-sale"><span class="mr-2 mr-md-5"><?=$priceSotka?></span>
				<div class="d-none d-md-inline-block">
					<div class="active-sale__badge" style="background-color: #<?=$colorBG?>; color: #<?=$colorIcon?>;">
						<svg xmlns="http://www.w3.org/2000/svg" width="15.275" height="10.988" viewBox="0 0 15.275 10.988" class="inline-svg">
							<g id="speaker-symbol-of-voice-volume" transform="translate(0 -78.721)">
								<path d="M10.178,79.068v9.385a.344.344,0,0,1-.632.191c-1.054-1.643-2.1-2.5-5.752-2.687l1.154,3.752H3.224L2.057,85.914a2.158,2.158,0,0,1,.1-4.313c5.014,0,6.193-.858,7.39-2.724A.345.345,0,0,1,10.178,79.068Zm2.97,5.147a4.019,4.019,0,0,1-.758,2.35.652.652,0,0,1-.485.25.6.6,0,0,1-.587-.59.661.661,0,0,1,.116-.351,2.843,2.843,0,0,0,0-3.317.661.661,0,0,1-.116-.351.6.6,0,0,1,.587-.59.652.652,0,0,1,.485.25A4.019,4.019,0,0,1,13.148,84.215Zm-.438-3.4a.667.667,0,0,1-.266-.489.593.593,0,0,1,.59-.592.738.738,0,0,1,.388.142,6.014,6.014,0,0,1,0,8.685.738.738,0,0,1-.388.142.593.593,0,0,1-.59-.592.667.667,0,0,1,.266-.489,4.876,4.876,0,0,0,0-6.809Z" fill="#<?=$colorIcon?>" style="fill: #<?=$colorIcon?>"/>
							</g>
						</svg> <span><?=$arResult['PROPERTIES']['SALES_PHASE']['VALUE'] // Этап продаж?></span>
					</div>
				</div>
        <?if($arResult['PROPERTIES'][REGION_CODE]['VALUE']):?>
          <a class="ml-4 area-link" href="/poselki/<?=$arResult['PROPERTIES'][REGION_CODE]['VALUE_XML_ID']?>-rayon/">
            <svg xmlns="http://www.w3.org/2000/svg" width="9.24" height="13.193" viewBox="0 0 9.24 13.193" class="inline-svg">
              <path d="M16.09 1.353a4.62 4.62 0 0 0-6.534 0 5.263 5.263 0 0 0-.435 6.494l3.7 5.346 3.7-5.339a5.265 5.265 0 0 0-.431-6.501zm-3.224 4.912a1.687 1.687 0 1 1 1.687-1.687 1.689 1.689 0 0 1-1.687 1.687z" transform="translate(-8.203)" />
            </svg><?=$arResult['PROPERTIES'][REGION_CODE]['VALUE'] // Район?> район</a>
        <?endif;?>
			</div>
		</div>
		<div class="order-2 order-md-1 col-xl-4 col-md-5 mt-4 mt-md-0">
			<div class="wrap-raiting" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
				<div class="card-house__raiting d-flex justify-content-md-end">
					<div class="line-raiting">
						<div class="line-raiting__star">
							<div class="line-raiting__star--wrap" style="width: <?=($arResult['ratingItogo']) ? $arResult['ratingItogo'] * 100 / 5 : 0?>%;"></div>
						</div>
						<span itemprop="bestRating" class="hide">5</span>
						<span itemprop="worstRating" class="hide">1</span>
						<div class="line-raiting__title" itemprop="ratingValue"><?=$arResult['ratingItogo']?></div>
					</div>
				</div>
				<div class="card-house__review review">
					<div class="d-flex text-right justify-content-md-end text-right"><a href="#block_reviews">
						<svg xmlns="http://www.w3.org/2000/svg" width="18.455" height="15.821" viewBox="0 0 18.455 15.821" class="inline-svg">
							<g transform="translate(0 -36.507)">
								<path d="M17.22 39.787a8.348 8.348 0 0 0-3.357-2.4 11.972 11.972 0 0 0-4.634-.881 12.246 12.246 0 0 0-3.584.52A10.023 10.023 0 0 0 2.7 38.433a7.025 7.025 0 0 0-1.969 2.106A4.905 4.905 0 0 0 0 43.1a5 5 0 0 0 .932 2.894 7.562 7.562 0 0 0 2.549 2.266 6.546 6.546 0 0 1-.268.782q-.154.371-.278.608a4.184 4.184 0 0 1-.335.525q-.211.288-.319.407l-.355.391q-.247.273-.319.355a.72.72 0 0 0-.082.093l-.072.087-.063.092q-.052.077-.046.1a.274.274 0 0 1-.021.1.136.136 0 0 0 .005.124v.01a.518.518 0 0 0 .18.3.4.4 0 0 0 .314.092A7.73 7.73 0 0 0 3 52.1a11.256 11.256 0 0 0 4.737-2.492 14.09 14.09 0 0 0 1.493.082 11.968 11.968 0 0 0 4.634-.881 8.347 8.347 0 0 0 3.357-2.4 5.053 5.053 0 0 0 0-6.622z"
									class="cls-2" data-name="Path 7" />
							</g>
						</svg><?if($arResult["CNT_COMMENTS"]){?>
							<span itemprop="reviewCount"><?=$arResult["CNT_COMMENTS"]?></span> <?=$reviewsText?> от жителей
						<?}else{?>
							<span itemprop="reviewCount" class="hide">0</span>
							Пока нет отзывов
						<?}?></a></div>
				</div>
			</div>
		</div>
		<div class="order-1 order-md-2 col-xl-8 col-md-7">
			<div class="village-slider">
				<div class="slider__header">
					<?if($arResult['PROPERTIES']['ACTION']['VALUE']){ // вывод акции?>
						<?if($arResult['PROPERTIES']['ACTION_TEXT']['VALUE']): // условия акции?>
							<div class="slider__label"><a class="action_text" data-toggle="modal" data-target="#action-widget">Акция<?if($arResult['PROPERTIES']['SALE_SUM']['VALUE']){?> - <?=$arResult['PROPERTIES']['SALE_SUM']['VALUE']?>%<?}?></a></div>
						<?else:?>
							<div class="slider__label">Акция<?if($arResult['PROPERTIES']['SALE_SUM']['VALUE']){?> - <?=$arResult['PROPERTIES']['SALE_SUM']['VALUE']?>%<?}?></div>
						<?endif?>
					<?}?>
					<?if(($arResult['PROPERTIES']['TOP_100']['VALUE'] || $arResult['TOP_100']) && !$statusSold){?>
						<div class="photo__top">
							<svg width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M0 0H50V35C50 43.2843 43.2843 50 35 50H15C6.71573 50 0 43.2843 0 35V0Z" fill="#4B833E"></path>
								<path d="M14.464 22V15.304H11.908V13.6H18.868V15.304H16.312V22H14.464ZM27.5613 20.884C26.7133 21.724 25.6493 22.144 24.3693 22.144C23.0893 22.144 22.0253 21.724 21.1773 20.884C20.3373 20.044 19.9173 19.016 19.9173 17.8C19.9173 16.592 20.3413 15.568 21.1893 14.728C22.0453 13.88 23.1133 13.456 24.3933 13.456C25.6733 13.456 26.7333 13.876 27.5733 14.716C28.4213 15.556 28.8453 16.584 28.8453 17.8C28.8453 19.008 28.4173 20.036 27.5613 20.884ZM22.5693 19.672C23.0493 20.184 23.6573 20.44 24.3933 20.44C25.1293 20.44 25.7333 20.188 26.2053 19.684C26.6773 19.172 26.9133 18.544 26.9133 17.8C26.9133 17.064 26.6733 16.44 26.1933 15.928C25.7133 15.416 25.1053 15.16 24.3693 15.16C23.6333 15.16 23.0293 15.416 22.5573 15.928C22.0853 16.432 21.8493 17.056 21.8493 17.8C21.8493 18.536 22.0893 19.16 22.5693 19.672ZM30.4846 22V13.6H37.4926V22H35.6446V15.268H32.3326V22H30.4846ZM15.8391 36V29.412L14.3751 29.772L13.9911 28.26L16.4031 27.54H17.6631V36H15.8391ZM25.8336 34.908C25.1376 35.732 24.2376 36.144 23.1336 36.144C22.0296 36.144 21.1336 35.732 20.4456 34.908C19.7576 34.084 19.4136 33.048 19.4136 31.8C19.4136 30.56 19.7616 29.528 20.4576 28.704C21.1536 27.872 22.0536 27.456 23.1576 27.456C24.2536 27.456 25.1456 27.868 25.8336 28.692C26.5296 29.516 26.8776 30.552 26.8776 31.8C26.8776 33.04 26.5296 34.076 25.8336 34.908ZM21.8136 33.72C22.1576 34.224 22.6056 34.476 23.1576 34.476C23.7096 34.476 24.1496 34.228 24.4776 33.732C24.8136 33.228 24.9816 32.584 24.9816 31.8C24.9816 31.032 24.8096 30.396 24.4656 29.892C24.1216 29.38 23.6776 29.124 23.1336 29.124C22.5896 29.124 22.1496 29.376 21.8136 29.88C21.4776 30.376 21.3096 31.016 21.3096 31.8C21.3096 32.576 21.4776 33.216 21.8136 33.72ZM34.5993 34.908C33.9033 35.732 33.0033 36.144 31.8993 36.144C30.7953 36.144 29.8993 35.732 29.2113 34.908C28.5233 34.084 28.1793 33.048 28.1793 31.8C28.1793 30.56 28.5273 29.528 29.2233 28.704C29.9193 27.872 30.8193 27.456 31.9233 27.456C33.0193 27.456 33.9113 27.868 34.5993 28.692C35.2953 29.516 35.6433 30.552 35.6433 31.8C35.6433 33.04 35.2953 34.076 34.5993 34.908ZM30.5793 33.72C30.9233 34.224 31.3713 34.476 31.9233 34.476C32.4753 34.476 32.9153 34.228 33.2433 33.732C33.5793 33.228 33.7473 32.584 33.7473 31.8C33.7473 31.032 33.5753 30.396 33.2313 29.892C32.8873 29.38 32.4433 29.124 31.8993 29.124C31.3553 29.124 30.9153 29.376 30.5793 29.88C30.2433 30.376 30.0753 31.016 30.0753 31.8C30.0753 32.576 30.2433 33.216 30.5793 33.72Z" fill="white"></path>
							</svg>
						</div>
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
						<img class="village-slider__item" src="<?=$photoRes['src']?>" style="background: #eee; object-fit: cover;" alt="" itemprop="image" lazyload>
					<?unset($photoRes);}?>
				</div>
				<div class="village-slider__list-thumb" id="village-slider-thumb">
					<?foreach ($arResult['MORE_PHOTO'] as $photo){ // Доп. фото
					  $photoRes = CFile::ResizeImageGet($photo['ID'], array('width'=>616, 'height'=>436), BX_RESIZE_IMAGE_EXACT);?>
						<div class="village-slider__item-thumb" style="background: url('<?=$photoRes['src']?>') 0 100% no-repeat; background-size: cover;" itemprop="image"></div>
				  <?unset($photoRes);}?>
				</div>
			</div>

			<!-- Дублирование кода для адаптива-->
			<div class="nav page-nav nav-village d-lg-none d-sm-block d-none mt-4 mt-md-0" id="mobile-nav-slider">
				<?if($arResult["arPlots"]){?>
					<a class="btn btn-outline-success rounded-pill" href="#area">Участки</a>
				<?}?>
				<?if($arResult["arHouses"]){?>
					<a class="btn btn-outline-success rounded-pill" href="#home">Дома</a>
				<?}?>
				<?if(!$arResult["arPlots"] && !$arResult["arHouses"]){?>
					<a class="btn btn-outline-success rounded-pill" href="#villagePlan">Цены</a>
				<?}?>
        <a class="btn btn-outline-success rounded-pill" href="#mapShow">Как добраться</a>
				<a class="btn btn-outline-success rounded-pill" href="#arrangement">Обустройство</a>
				<?if(!$arResult["arPlots"] || !$arResult["arHouses"]){?>
        	<a class="btn btn-outline-success rounded-pill" href="#block_reviews">Отзывы</a>
				<?}?>
			</div>

	    <div class="dropdown w-100 d-flex d-sm-none mt-3">
        <button class="btn btn-outline-success btn-outline-success-dropdown py-3 btn-sm w-100" type="button" id="pageNavigation" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Навигация по странице
          <svg xmlns="http://www.w3.org/2000/svg" width="6.847" height="11.883" viewBox="0 0 6.847 11.883" class="ml-2 inline-svg" style="transform: rotate(90deg)">
            <g transform="rotate(180 59.406 5.692)">
              <path d="M113.258 5.441l4.915-4.915a.308.308 0 1 0-.436-.436L112.6 5.225a.307.307 0 0 0 0 .436l5.134 5.132a.31.31 0 0 0 .217.091.3.3 0 0 0 .217-.091.307.307 0 0 0 0-.436z"></path>
            </g>
          </svg>
        </button>
        <div class="dropdown-menu w-100" aria-labelledby="pageNavigation">
					<?if($arResult["arPlots"]){?>
						<a class="dropdown-item" href="#area">Участки</a>
					<?}?>
					<?if($arResult["arHouses"]){?>
						<a class="dropdown-item" href="#home">Дома</a>
					<?}?>
          <a class="dropdown-item" href="#villagePlan">Цены</a>
          <a class="dropdown-item" href="#mapShow">Как добраться</a>
					<a class="dropdown-item" href="#arrangement">Обустройство</a>
          <a class="dropdown-item" href="#block_reviews">Отзывы</a>
        </div>
      </div>

			<!-- Навигация-->
			<div class="slider-bottom-info">
			  <div class="d-none d-lg-flex">
			    <div class="nav page-nav nav-village anchor">
			      <a class="btn btn-outline-success rounded-pill" href="#villagePlan">Цены</a>
			      <a class="btn btn-outline-success rounded-pill" href="#mapShow">Как добраться</a>
			      <a class="btn btn-outline-success rounded-pill" href="#arrangement">Обустройство</a>
			      <a class="btn btn-outline-success rounded-pill" href="#block_reviews">Отзывы</a>
			    </div>
			    <?if($arResult['PROPERTIES']['INS']['VALUE']){ // рассрочка?>
				    <div class="bank-widget ml-auto">
				      <div class="bank-widget__icon">
				        <svg xmlns="http://www.w3.org/2000/svg" width="22.013" height="21.96" viewBox="0 0 22.013 21.96" class="inline-svg">
				          <g id="bank" transform="translate(0 -0.605)" opacity="0.5">
				            <path d="M89.39,217.275h2.6v5.492h-2.6Z" transform="translate(-85.532 -207.318)" fill="#919fa3" />
				            <path d="M179.7,217.275h2.6v5.492h-2.6Z" transform="translate(-171.944 -207.318)" fill="#919fa3" />
				            <path d="M270,217.275h2.6v5.492H270Z" transform="translate(-258.346 -207.318)" fill="#919fa3" />
				            <path d="M360.3,217.275h2.6v5.492h-2.6Z" transform="translate(-344.749 -207.318)" fill="#919fa3" />
				            <path d="M87.745.665,80.43,5.1H95.5L88.184.665a.431.431,0,0,0-.439,0Z" transform="translate(-76.958 0)" fill="#919fa3" />
				            <path d="M59.017,136.667v-1.832H40.5v1.832a.432.432,0,0,0,.432.432H58.585A.432.432,0,0,0,59.017,136.667Z" transform="translate(-38.752 -128.437)" fill="#919fa3" />
				            <path d="M58.585,374.505H40.932a.432.432,0,0,0-.432.432v1.832H59.017v-1.832A.432.432,0,0,0,58.585,374.505Z" transform="translate(-38.752 -357.762)" fill="#919fa3" />
				            <path d="M0,457.387v1.4a.432.432,0,0,0,.432.432H21.581a.432.432,0,0,0,.432-.432v-1.4a.432.432,0,0,0-.432-.432H.432A.432.432,0,0,0,0,457.387Z" transform="translate(0 -436.653)" fill="#919fa3" />
				          </g>
				        </svg>
				      </div>
				      <div class="bank-widget__text"><span>Доступна рассрочка</span><br><a class="text-success" data-toggle="modal" data-target="#bank-widget">Посмотреть условия</a></div>
				      <div class="modal fade" id="bank-widget" tabindex="-1" role="dialog" aria-labelledby="bank-widget" aria-hidden="true">
				        <div class="modal-dialog">
				          <div class="modal-content">
				            <div class="modal-header">
				              <h5 class="modal-title mt-3" id="exampleModalLabel">Условия рассрочки</h5>
				              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				                <span aria-hidden="true">&times;</span>
				              </button>
				            </div>
				            <div class="modal-body">
				              <p>
				                <?=$arResult['PROPERTIES']['INS_TERMS']['VALUE']?>
				              </p>
				            </div>
				          </div>
				        </div>
				      </div>
				    </div>
			    <?}?>
			  </div>
			</div>

			<!-- План поселка-->
			<div class="plan--village px-0 d-flex flex-column align-items-start text-left" style="height: auto" id="villagePlan">
			  <h2 class="h2">План поселка</h2>
			  <?
			    $planIMG_res = CFile::ResizeImageGet($arResult['PROPERTIES']['PLAN_IMG'.$nProp]['VALUE'], array('width'=>1000, 'height'=>1000), BX_RESIZE_IMAGE_EXACT);

			    if($arResult['PROPERTIES']['PLAN_IMG_IFRAME'.$nProp]['VALUE']){
		        $planIMG = $arResult['PROPERTIES']['PLAN_IMG_IFRAME'.$nProp]['VALUE'];
		        // $frame = 'data-iframe="true"';
						$frame = 'data-type="iframe"';
			    }else{
		        // $planIMG = CFile::GetPath($arResult['PROPERTIES']['PLAN_IMG'.$nProp]['VALUE']);
						$arPlanIMG = CFile::ResizeImageGet($arResult['PROPERTIES']['PLAN_IMG'.$nProp]['VALUE'], array('width'=>3000, 'height'=>3000), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
						$planIMG = $arPlanIMG['src'];
		        $frame = '';
			    }
			  ?>
				<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/lg-zoom/1.3.0/lg-zoom.js"></script> openPlan -->
			  <div class="w-100">
					<?if($frame):?>
						<a data-src="<?=$planIMG?>" data-fancybox <?=$frame?> rel="nofollow" class="mt-4 fill_img">
							<span class="btn btn-warning rounded-pill">Открыть планировку</span>
							<span class="w-100 fill-bg"></span>
				      <img class="w-100" src="<?=$planIMG_res["src"]?>" alt="План поселка <?=$name?>" style="max-width: none; min-height: 468px; max-height: 45vh; object-fit: cover; object-position: top;">
				    </a>
					<?else:?>
						<a href="<?=$planIMG?>" data-fancybox <?=$frame?> class="mt-4 fill_img">
							<span class="btn btn-warning rounded-pill">Открыть планировку</span>
							<span class="w-100 fill-bg"></span>
				      <img class="w-100" src="<?=$planIMG_res["src"]?>" alt="План поселка <?=$name?>" style="max-width: none; min-height: 468px; max-height: 45vh; object-fit: cover; object-position: top;">
				    </a>
					<?endif;?>
			  </div>

				<div class="row w-100 mt-4 mt-lg-5">
					<div class="col-lg-4 col-12 mb-4 mb-lg-0">
						<div class="sale-block">
							<div class="sale-block__title">
								<svg width="22" height="26" viewBox="0 0 22 26" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M14.3634 15.4731C14.0775 15.4731 13.8033 15.5867 13.6011 15.7889C13.3989 15.9911 13.2854 16.2653 13.2854 16.5512C13.2854 16.8371 13.3989 17.1113 13.6011 17.3135C13.8033 17.5157 14.0775 17.6292 14.3634 17.6292C14.6493 17.6292 14.9235 17.5157 15.1257 17.3135C15.3279 17.1113 15.4415 16.8371 15.4415 16.5512C15.4415 16.2653 15.3279 15.9911 15.1257 15.7889C14.9235 15.5867 14.6493 15.4731 14.3634 15.4731Z" fill="#78A86D"/>
									<path d="M21.4341 0.443885C21.2961 0.361259 21.1393 0.315009 20.9785 0.309464C20.8177 0.303919 20.6581 0.339259 20.5146 0.412178L17.661 1.77559L14.7756 0.412178C14.647 0.350339 14.5061 0.31823 14.3634 0.31823C14.2207 0.31823 14.0798 0.350339 13.9512 0.412178L11.0976 1.77559L8.21219 0.412178C8.08358 0.350339 7.9427 0.31823 7.8 0.31823C7.65729 0.31823 7.51642 0.350339 7.3878 0.412178L4.53414 1.77559L1.68049 0.412178C1.53705 0.339259 1.37746 0.303919 1.21664 0.309464C1.05583 0.315009 0.899049 0.361259 0.760974 0.443885C0.622171 0.531351 0.50835 0.653229 0.430568 0.797682C0.352786 0.942134 0.313688 1.10425 0.317072 1.26828V24.7317C0.312643 24.8578 0.334218 24.9835 0.380454 25.1009C0.42669 25.2183 0.496597 25.3249 0.585824 25.4142C0.675052 25.5034 0.78169 25.5733 0.899101 25.6195C1.01651 25.6658 1.14218 25.6873 1.26829 25.6829H20.9268C21.0529 25.6873 21.1786 25.6658 21.296 25.6195C21.4134 25.5733 21.5201 25.5034 21.6093 25.4142C21.6985 25.3249 21.7684 25.2183 21.8147 25.1009C21.8609 24.9835 21.8825 24.8578 21.878 24.7317V1.26828C21.8814 1.10425 21.8423 0.942134 21.7646 0.797682C21.6868 0.653229 21.5729 0.531351 21.4341 0.443885ZM4.85122 10.0195C4.85747 9.4314 5.03758 8.8583 5.36886 8.37235C5.70014 7.8864 6.16779 7.50933 6.71292 7.28859C7.25806 7.06786 7.85631 7.01334 8.43236 7.1319C9.00842 7.25046 9.53652 7.5368 9.95018 7.95486C10.3638 8.37292 10.6446 8.90403 10.757 9.4813C10.8695 10.0586 10.8086 10.6562 10.5822 11.199C10.3557 11.7418 9.97366 12.2054 9.48423 12.5315C8.99481 12.8576 8.41983 13.0317 7.83171 13.0317C7.43762 13.0317 7.04744 12.9536 6.68375 12.8018C6.32006 12.6501 5.99008 12.4277 5.71289 12.1475C5.43571 11.8674 5.21683 11.5351 5.06893 11.1698C4.92102 10.8045 4.84703 10.4136 4.85122 10.0195ZM5.89756 17.1219L15.2195 7.83169L16.5512 9.1634L7.26097 18.4853L5.89756 17.1219ZM14.3634 19.5634C13.7663 19.5697 13.1809 19.3984 12.6814 19.0712C12.1819 18.7441 11.7909 18.2759 11.558 17.7261C11.3251 17.1762 11.261 16.5696 11.3736 15.9832C11.4862 15.3968 11.7705 14.8572 12.1905 14.4327C12.6105 14.0083 13.1471 13.7182 13.7323 13.5994C14.3175 13.4806 14.9247 13.5384 15.477 13.7654C16.0292 13.9924 16.5016 14.3785 16.834 14.8745C17.1664 15.3705 17.3439 15.9541 17.3439 16.5512C17.3439 17.3446 17.0309 18.106 16.4729 18.67C15.9148 19.234 15.1568 19.555 14.3634 19.5634Z" fill="#78A86D"/>
									<path d="M8.9101 10.0193C8.9101 9.73335 8.79652 9.45915 8.59435 9.25698C8.39218 9.0548 8.11797 8.94122 7.83205 8.94122C7.54614 8.94122 7.27193 9.0548 7.06976 9.25698C6.86759 9.45915 6.75401 9.73335 6.75401 10.0193C6.75401 10.3052 6.86759 10.5794 7.06976 10.7816C7.27193 10.9837 7.54614 11.0973 7.83205 11.0973C8.11797 11.0973 8.39218 10.9837 8.59435 10.7816C8.79652 10.5794 8.9101 10.3052 8.9101 10.0193Z" fill="#78A86D"/>
								</svg>
								Скидка
							</div>
							<div class="sale-block__content">
								Скидка при полной оплате (индивидуально с менеджером)
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-12 mb-4 mb-lg-0">
						<div class="sale-block">
							<div class="sale-block__title">
								<svg width="34" height="26" viewBox="0 0 34 26" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M31.7326 12.1111L26.88 8.26903V3.07375C26.88 2.74994 26.6141 2.48284 26.2891 2.48284H24.1961C23.8723 2.48284 23.6052 2.74994 23.6052 3.07375V5.67612L17.4633 0.814118C16.9256 0.387482 16.1669 0.387482 15.6291 0.814118L1.35632 12.1111C1.10105 12.3132 1.0585 12.6855 1.25941 12.9419L2.36086 14.3318C2.56177 14.5858 2.93523 14.6296 3.1905 14.4275L16.545 3.8573L29.8984 14.4275C30.1537 14.6296 30.526 14.5858 30.7292 14.3318L31.8283 12.9419C32.0316 12.6855 31.9867 12.3132 31.7326 12.1111Z" fill="#78A86D"/>
									<path d="M13.0458 13.6416C12.3722 13.6416 12.0566 14.4192 12.0566 15.3942C12.0566 16.413 12.4017 17.1469 13.0612 17.1469C13.7053 17.1469 14.0208 16.4874 14.0208 15.3942C14.0196 14.4051 13.7502 13.6416 13.0458 13.6416Z" fill="#78A86D"/>
									<path d="M20.0748 21.1949C20.7177 21.1949 21.0332 20.5343 21.0332 19.4411C21.0332 18.4531 20.778 17.6885 20.0748 17.6885C19.3846 17.6885 19.0844 18.4673 19.0844 19.4411C19.0702 20.461 19.4141 21.1949 20.0748 21.1949Z" fill="#78A86D"/>
									<path d="M6.21094 13.5448V24.9151C6.21094 25.2401 6.47685 25.506 6.80185 25.506H26.2877C26.6127 25.506 26.8786 25.2401 26.8786 24.9151V13.5448L16.5448 5.36426L6.21094 13.5448ZM10.3638 15.4534C10.3638 13.7162 11.4275 12.3973 13.0915 12.3973C14.7685 12.3973 15.7139 13.6264 15.7139 15.2892C15.7139 17.3278 14.4246 18.3914 13.0158 18.3914C11.5327 18.3926 10.3638 17.2829 10.3638 15.4534ZM22.7257 19.3357C22.7257 21.3743 21.4363 22.4368 20.0276 22.4368C18.5598 22.4368 17.3909 21.3283 17.3756 19.5C17.3756 17.7615 18.4392 16.4438 20.1032 16.4438C21.7826 16.4438 22.7257 17.6717 22.7257 19.3357ZM19.9543 12.3973L14.3489 22.4675H13.1364L18.7252 12.3973H19.9543Z" fill="#78A86D"/>
								</svg>
								Ипотека
							</div>
							<div class="sale-block__content">
								Доступна ипотека на покупку земельного участка по программам «Ипотека на строительство» и «Ипотека на земельный участок»
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-12">
						<div class="sale-block">
							<div class="sale-block__title">
								<svg width="23" height="26" viewBox="0 0 23 26" fill="none" xmlns="http://www.w3.org/2000/svg">
									<g clip-path="url(#clip0_3294_6539)">
										<path d="M22.42 8.85996H0V7.32002C0 5.26002 1.67999 3.57998 3.73999 3.57998H4.48V1.67998C4.48 0.75998 5.24001 0 6.16001 0C7.08001 0 7.83999 0.75998 7.83999 1.67998V3.57998H14.56V1.67998C14.56 0.75998 15.32 0 16.24 0C17.16 0 17.92 0.75998 17.92 1.67998V3.57998H18.66C20.72 3.57998 22.4 5.26002 22.4 7.32002V8.85996H22.42ZM22.42 10.06V22.26C22.42 24.32 20.74 26 18.68 26H3.73999C1.67999 26 0 24.32 0 22.26V10.06H22.42ZM16.42 4.94004C15.64 4.94004 15.02 5.56004 15.02 6.34004C15.02 7.12004 15.64 7.74004 16.42 7.74004C17.2 7.74004 17.82 7.12004 17.82 6.34004C17.82 5.56004 17.2 4.94004 16.42 4.94004ZM6.16001 4.82002C5.36001 4.82002 4.7 5.47998 4.7 6.27998C4.7 7.07998 5.36001 7.74004 6.16001 7.74004C6.96001 7.74004 7.62 7.07998 7.62 6.27998C7.62 5.47998 6.98001 4.82002 6.16001 4.82002ZM11.2 23.4C14.4 23.4 17 20.8 17 17.6C17 14.4 14.4 11.8 11.2 11.8C8 11.8 5.4 14.4 5.4 17.6C5.4 20.8 8 23.4 11.2 23.4Z" fill="#78A86D"/>
										<path d="M9.11859 21.1798C9.07859 21.1398 9.05859 21.0798 9.05859 20.9998V19.8998H8.29859C8.23859 19.8998 8.17859 19.8798 8.11859 19.8398C8.07859 19.7998 8.05859 19.7398 8.05859 19.6798V19.3598C8.05859 19.2798 8.07859 19.2198 8.11859 19.1798C8.15859 19.1398 8.21859 19.1198 8.29859 19.1198H9.05859V18.5798H8.29859C8.23859 18.5798 8.17859 18.5598 8.11859 18.4998C8.07859 18.4598 8.05859 18.3998 8.05859 18.3398V17.7798C8.05859 17.6998 8.07859 17.6398 8.11859 17.5998C8.15859 17.5598 8.21859 17.5398 8.29859 17.5398H9.05859V14.4998C9.05859 14.4198 9.07859 14.3598 9.11859 14.3198C9.15859 14.2798 9.21859 14.2598 9.29859 14.2598H11.9786C12.7786 14.2598 13.4186 14.4598 13.8786 14.8198C14.3386 15.1998 14.5786 15.7598 14.5786 16.4798C14.5786 17.1798 14.3586 17.6998 13.8786 18.0598C13.4186 18.4198 12.7786 18.5998 11.9786 18.5998H10.5186V19.1398H12.1386C12.2186 19.1398 12.2786 19.1598 12.3186 19.1998C12.3586 19.2398 12.3786 19.2998 12.3786 19.3798V19.6998C12.3786 19.7598 12.3586 19.8198 12.3186 19.8598C12.2786 19.8998 12.2186 19.9198 12.1386 19.9198H10.5186V21.0198C10.5186 21.0798 10.4986 21.1398 10.4586 21.1998C10.4186 21.2398 10.3586 21.2598 10.2786 21.2598H9.31859C9.21859 21.2398 9.15859 21.2198 9.11859 21.1798ZM11.9186 17.5398C12.2986 17.5398 12.5986 17.4398 12.7986 17.2598C12.9986 17.0798 13.0986 16.7998 13.0986 16.4598C13.0986 16.1198 12.9986 15.8598 12.7986 15.6598C12.5986 15.4598 12.2986 15.3598 11.8986 15.3598H10.4586V17.5398H11.9186Z" fill="#78A86D"/>
									</g>
								</svg>
								Рассрочка
							</div>
							<div class="sale-block__content">
								<?if($arResult['PROPERTIES']['INS_TERMS']['VALUE']):?>
									<?=$arResult['PROPERTIES']['INS_TERMS']['VALUE']?>
								<?else:?>
									Возможна рассрочка от застройщика с первоначальным взносом от 30% от 6 до 18 месяцев (подробности у менеджера)
								<?endif;?>
							</div>
						</div>
					</div>
			  </div>

			</div>

		</div>
		<div class="order-3 order-md-3 col-xl-4 col-md-5">
			<div class="card-info card-info--village radius">

				<div class="row">
					<div class="col-12">
					    <div class="d-flex flex-wrap w-100 mb-1">
	                <?if($arResult['PROPERTIES'][ROAD_CODE]['VALUE_ENUM_ID'][0]): // если есть шоссе
	                    $idEnumHW = $arResult['PROPERTIES'][ROAD_CODE]['VALUE_ENUM_ID'][0];
	                    $valEnumHW = $arResult['PROPERTIES'][ROAD_CODE]['VALUE_XML_ID'][0];
	                    $colorHW = getColorRoad($idEnumHW);
	                    $nameHW = $arResult['PROPERTIES'][ROAD_CODE]['VALUE'][0];
	                ?>
                    <a class="metro z-index-1 highway-color" href="/poselki/<?=$valEnumHW?>-shosse/">
                        <span class="metro-color <?=$colorHW?>"></span>
                        <span class="metro-name "><?=$nameHW?> шоссе</span>
                    </a>
	                <?endif;?>
		                <a class="metro ml-sm-auto ml-0 pl-2 z-index-1" href="/poselki/<?=$url_km_MKAD?>/">
		                    <span class="metro-other"><?=$km_MKAD?> км от <?=ROAD?></span>
		                </a>
	            </div>
					    <div class="d-flex w-100">
                  <?if($arResult['PROPERTIES'][ROAD_CODE]['VALUE_ENUM_ID'][1]): // если есть шоссе
                      $idEnumHW2 = $arResult['PROPERTIES'][ROAD_CODE]['VALUE_ENUM_ID'][1];
                      $valEnumHW2 = $arResult['PROPERTIES'][ROAD_CODE]['VALUE_XML_ID'][1];
                      $colorHW2 = getColorRoad($idEnumHW2);
                      $nameHW2 = $arResult['PROPERTIES'][ROAD_CODE]['VALUE'][1];
                  ?>
                    <a class="metro z-index-1 highway-color pl-0" href="/poselki/<?=$valEnumHW2?>-shosse/">
                        <span class="metro-color <?=$colorHW2?>"></span>
                        <span class="metro-name"><?=$nameHW2?> шоссе</span>
                    </a>
                  <?endif;?>
									<?if($arResult['PROPERTIES']['SHOSSE_DOP']['VALUE'][0]): // если есть доп. шоссе
                      $valEnumHW2 = $arResult['PROPERTIES']['SHOSSE_DOP']['VALUE'][0];
											$idEnumHW2 = getNamesList($valEnumHW2,ROAD_CODE)['ID'];
                      $colorHW2 = getColorRoad($idEnumHW2);
                      $nameHW2 = getNamesList($valEnumHW2,ROAD_CODE)['NAME'];
                  ?>
                    <a class="metro z-index-1 highway-color pl-0" href="/poselki/<?=$valEnumHW2?>-shosse/">
                        <span class="metro-color <?=$colorHW2?>"></span>
                        <span class="metro-name"><?=$nameHW2?> шоссе</span>
                    </a>
                  <?endif;?>
              </div>
					</div>
				</div>

				<div class="row extra-options">
					<div class="col-md-6">
						<div class="extra-options-block--circle <?if($arResult['PROPERTIES']['ELECTRO']['VALUE_ENUM_ID'] == PROP_ELECTRO_Y)echo'active';?>">
							<div class="icon icon--svet">
								<svg xmlns="http://www.w3.org/2000/svg" width="23.032" height="24" viewBox="0 0 23.032 24" class="inline-svg">
									<g transform="translate(-9.8)">
										<path d="M24.052,20.973v.7a1.112,1.112,0,0,1-.943,1.1l-.173.637A.793.793,0,0,1,22.17,24H20.457a.793.793,0,0,1-.765-.588l-.168-.637a1.117,1.117,0,0,1-.948-1.106v-.7a.674.674,0,0,1,.677-.677h4.123A.682.682,0,0,1,24.052,20.973Zm3.175-9.452a5.883,5.883,0,0,1-1.659,4.1,5.422,5.422,0,0,0-1.452,2.943.978.978,0,0,1-.968.825H19.479a.968.968,0,0,1-.963-.82,5.482,5.482,0,0,0-1.462-2.953,5.912,5.912,0,1,1,10.173-4.1Zm-5.244-3.58a.667.667,0,0,0-.667-.667,4.271,4.271,0,0,0-4.267,4.267.667.667,0,1,0,1.333,0,2.937,2.937,0,0,1,2.933-2.933A.664.664,0,0,0,21.983,7.941Zm-.667-4.272A.667.667,0,0,0,21.983,3V.667a.667.667,0,0,0-1.333,0V3A.667.667,0,0,0,21.316,3.669Zm-7.847,7.847a.667.667,0,0,0-.667-.667H10.467a.667.667,0,1,0,0,1.333H12.8A.664.664,0,0,0,13.469,11.516Zm18.7-.667H29.83a.667.667,0,1,0,0,1.333h2.336a.667.667,0,1,0,0-1.333ZM14.827,17.067l-1.654,1.654a.665.665,0,0,0,.938.943l1.654-1.654a.665.665,0,0,0-.938-.943Zm12.509-10.9A.666.666,0,0,0,27.8,5.97l1.654-1.654a.667.667,0,1,0-.943-.943L26.862,5.027a.665.665,0,0,0,0,.943A.677.677,0,0,0,27.336,6.163Zm-12.509-.2a.665.665,0,0,0,.938-.943L14.111,3.368a.667.667,0,1,0-.943.943ZM27.8,17.067a.667.667,0,1,0-.943.943l1.654,1.654a.665.665,0,1,0,.938-.943Z" class="color-fill" />
									</g>
								</svg>
							</div>
							<div class="text"><span>Свет</span><span class="description">
								<?=$arResult['PROPERTIES']['ELECTRO_DONE']['VALUE'] // Электричество (проведен)?>
								<?if($arResult['PROPERTIES']['ELECTRO_KVT']['VALUE']): // Электричество (кВт)?>
									<br><?=$arResult['PROPERTIES']['ELECTRO_KVT']['VALUE'] ?> кВт на уч.
								<?endif;?></span></div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="extra-options-block--circle <?if($arResult['PROPERTIES']['GAS']['VALUE_ENUM_ID'] == PROP_GAS_Y)echo'active';?>">
							<div class="icon icon--gaz">
								<svg xmlns="http://www.w3.org/2000/svg" width="17.883" height="23.844" viewBox="0 0 17.883 23.844" class="inline-svg">
									<g transform="translate(-64 0)">
										<g transform="translate(64 0)">
											<path d="M81.832,13.96C81.559,10.4,79.9,8.176,78.442,6.209,77.09,4.389,75.922,2.817,75.922.5a.5.5,0,0,0-.27-.442.492.492,0,0,0-.516.038,12.633,12.633,0,0,0-4.663,6.739,22,22,0,0,0-.511,5.038c-2.026-.433-2.485-3.463-2.49-3.5A.5.5,0,0,0,66.764,8c-.106.051-2.607,1.322-2.753,6.4-.01.169-.011.338-.011.507a8.951,8.951,0,0,0,8.941,8.941.069.069,0,0,0,.02,0h.006A8.952,8.952,0,0,0,81.883,14.9C81.883,14.654,81.832,13.96,81.832,13.96Zm-8.89,8.889a3.086,3.086,0,0,1-2.98-3.175c0-.06,0-.12,0-.194a4.027,4.027,0,0,1,.314-1.577,1.814,1.814,0,0,0,1.64,1.188.5.5,0,0,0,.5-.5,9.937,9.937,0,0,1,.191-2.259,4.8,4.8,0,0,1,1.006-1.9,6.4,6.4,0,0,0,1.024,1.879,5.659,5.659,0,0,1,1.273,3.1c.006.085.013.171.013.263A3.086,3.086,0,0,1,72.941,22.849Z" transform="translate(-64 0)" class="color-fill" />
										</g>
									</g>
								</svg>
							</div>
							<div class="text">
								<span>Газ</span>
								<span class="description">
									<?=$arResult['PROPERTIES']['PROVEDEN_GAZ']['VALUE'] // Газ (проведен)?>
									<?if($arResult['PROPERTIES']['GAS_YEAR']['VALUE']): // Электричество (кВт)?>
										<br><?=$arResult['PROPERTIES']['GAS_YEAR']['VALUE'] ?>
									<?endif;?></span></div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="extra-options-block--circle <?if($arResult['PROPERTIES']['PLUMBING']['VALUE_ENUM_ID'] == PROP_PLUMBING_Y)echo'active';?>">
							<div class="icon icon--voda">
								<svg xmlns="http://www.w3.org/2000/svg" width="15.782" height="22.051" viewBox="0 0 15.782 22.051" class="inline-svg">
									<g transform="translate(-35.275 0)">
										<g transform="translate(35.275 0)">
											<path d="M44.09.76c-.6-1.031-1.244-1-1.848,0-2.772,4.123-6.967,10.308-6.967,13.4a7.891,7.891,0,1,0,15.782,0C51.057,11.033,46.862,4.883,44.09.76Zm4.763,16.919a6.749,6.749,0,0,1-2.381,2.31.955.955,0,0,1-.924-1.671,4.705,4.705,0,0,0,1.706-1.635,4.634,4.634,0,0,0,.711-2.275.943.943,0,0,1,1.884.107A7.042,7.042,0,0,1,48.853,17.679Z" transform="translate(-35.275 0)" class="color-fill" />
										</g>
									</g>
								</svg>
							</div>
							<div class="text">
								<span>Вода</span>
								<span class="description"><?=$arResult['PROPERTIES']['PROVEDENA_VODA']['VALUE'] // Водопровод (проведен)?></span></div>
						</div>
					</div>
				</div>
				<?//=dump($arResult['PROPERTIES']['CONTACTS'])?>
				<?if($arResult['PROPERTIES']['CONTACTS']['VALUE_XML_ID'] == 'tel' && $arResult['PROPERTIES']['PHONE']['VALUE'] && $arResult['DEVELOPERS'] && count($arResult['DEVELOPERS']) == 1){?>
        	<div class="phone-cart__block">
        	    <a href="tel:<?=$arResult['PROPERTIES']['PHONE']['VALUE']?>">
								<?=$arResult['PROPERTIES']['PHONE']['VALUE']?>
							</a>
							<!-- <span onclick="ym(50830593,'reachGoal','phone_click');ga('send','event','button','phone_click');return true;">Показать</span> -->
					</div>
				<?}?>
				<a class="btn btn-warning rounded-pill w-100" href="#" data-toggle="modal" data-target="#feedbackModal" data-id-button='SIGN_UP_TO_VIEW' data-title='Записаться на просмотр'>Записаться на просмотр</a>
				<div class="mt-4 text-lg-center">На просмотр уже записались: <b><?=$cntPos?> <?=$correctText?></b></div>
				<input type="hidden" id="posInfo" data-namePos='<?=$arResult['NAME']?>' data-codePos='<?=$arResult['CODE']?>' data-highwayPos='<?=$nameHW?>' data-idPos='<?=$arResult['ID']?>' data-cntPos='<?=$arResult['PROPERTIES']['UP_TO_VIEW']['VALUE']?>' data-manager='<?=$arResult['PROPERTIES']['MANAGER']['VALUE']?>'>
				<?if($arResult['PROPERTIES']['SITE']['VALUE'] && !$statusSold):
					$arSite = explode('//',$arResult['PROPERTIES']['SITE']['VALUE']);?>
					<div class="w-100 text-lg-center mt-3">
						<noindex><p>Сайт поселка: <a href="<?=$arResult['PROPERTIES']['SITE']['VALUE']?>" class="text-success font-weight-bold" target="_blank" rel="dofollow"><?=$arSite[1]?></a></p></noindex>
					</div>
				<?endif;?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-12">
    <!-- Как добраться -->
      <div class="village-map" id="mapShow">
				<div class="container">
					<h2>Как добраться</h2>
					<div class="map-container position-relative fill_img">
						<div id="YaMaps"></div>
							<span class="btn btn-default rounded-pill" id="btnLoadMap">
								Загрузить карту
								<svg width="22" height="28" viewBox="0 0 22 28" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M21.2001 14C21.2001 14.04 21.2001 14.08 21.2001 14.12C21.2401 14.48 21.7201 22.84 20.0801 26.92C19.9601 27.24 19.6401 27.44 19.3201 27.44C19.2001 27.44 19.1201 27.4 19.0001 27.36C18.5601 27.2 18.3601 26.68 18.5201 26.28C19.9601 22.76 19.5601 15.12 19.5201 14.32C19.4401 13.96 19.2001 13.32 18.6001 13.32C18.1201 13.32 17.7201 13.72 17.7201 14.2V15.88C17.7201 16.36 17.3601 16.72 16.8801 16.72C16.4001 16.72 16.0401 16.36 16.0401 15.88V14.2C16.0401 14.12 16.0401 14 16.0401 13.92C16.0401 13.88 16.0401 13.8 16.0401 13.76V12.64C16.0401 12.16 15.6401 11.76 15.1601 11.76C14.6801 11.76 14.2801 12.16 14.2801 12.64V13.52V15.88C14.2801 16.36 13.9201 16.72 13.4401 16.72C12.9601 16.72 12.6001 16.36 12.6001 15.88V13.52V12.64V11.52C12.6001 11.04 12.2001 10.64 11.7201 10.64C11.2801 10.64 10.8801 11 10.8401 11.44C10.8401 11.44 10.8401 11.44 10.8401 11.48V15.64C10.8401 16.12 10.4801 16.48 10.0001 16.48C9.52007 16.48 9.16007 16.12 9.16007 15.64V6.00004C9.16007 5.52004 8.76007 5.12003 8.28007 5.12003C7.80007 5.12003 7.40007 5.52004 7.40007 6.00004V19.88C7.40007 20.28 7.16007 20.6 6.76007 20.68C6.40007 20.76 6.00007 20.6 5.80007 20.28L3.28007 15.92C3.16007 15.68 3.00007 15.56 2.76007 15.48C2.56007 15.44 2.36007 15.48 2.20007 15.56C1.92007 15.72 1.92007 16.36 2.12007 17.04C2.24007 17.32 4.56007 23.84 7.12007 26.4C7.44007 26.72 7.44007 27.24 7.12007 27.6C6.96007 27.76 6.76007 27.84 6.52007 27.84C6.32007 27.84 6.08007 27.76 5.92007 27.6C3.04007 24.72 0.640069 17.88 0.520069 17.6C0.0400691 16.12 0.360067 14.8 1.28007 14.16C1.84007 13.8 2.52007 13.68 3.16007 13.84C3.80007 14 4.36007 14.44 4.72007 15.08L5.64007 16.68V5.92003C5.64007 4.52003 6.80007 3.36003 8.20007 3.36003C9.60007 3.36003 10.7601 4.52003 10.7601 5.92003V9.04004C11.0401 8.92004 11.3601 8.88004 11.6401 8.88004C12.6401 8.88004 13.5201 9.44004 13.9201 10.28C14.2801 10.08 14.6801 10 15.0801 10C16.2001 10 17.2001 10.76 17.5201 11.76C17.8401 11.64 18.2001 11.56 18.5601 11.56C19.8801 11.6 20.8801 12.52 21.2001 14ZM12.7601 8.16003C13.2001 8.28003 13.6801 8.04004 13.8001 7.60004C13.9601 7.08004 14.0401 6.52003 14.0401 5.96003C14.0401 2.76003 11.4401 0.160034 8.24007 0.160034C5.04007 0.160034 2.44007 2.76003 2.44007 5.96003C2.44007 6.68003 2.56007 7.36004 2.80007 8.00004C2.92007 8.32004 3.24007 8.56003 3.60007 8.56003C3.68007 8.56003 3.80007 8.56003 3.88007 8.52003C4.32007 8.36003 4.52007 7.88004 4.36007 7.44004C4.20007 6.96004 4.08007 6.48004 4.08007 6.00004C4.08007 3.72004 5.92007 1.88004 8.20007 1.88004C10.4801 1.88004 12.3201 3.72004 12.3201 6.00004C12.3201 6.40004 12.2801 6.80003 12.1601 7.16003C12.0401 7.56003 12.3201 8.04003 12.7601 8.16003Z" fill="white"/>
								</svg>
							</span>
							<span class="w-100 fill-bg"></span>
						<div id="villageMap" class="map" style="display: none; width: 100%; height: 100%; border-radius: 15px;"></div>
						<div id="villageMapBalliin">
							<div class="map-baloon">
								<a href="/poselki/<?=$url_km_MKAD?>/"><span class="metro-other" style="margin-left: 0;"><?=$km_MKAD?> км от <?=ROAD?></span></a><br>
								<?if($arResult['PROPERTIES'][ROAD_CODE]['VALUE_ENUM_ID'][0]): // если есть шоссе ?>
									<a href="/poselki/<?=$valEnumHW?>-shosse/" class="highway-color">
										<span class="metro-color <?=$colorHW?>"></span>
										<span class="metro-name"><?=$nameHW?> шоссе</span></a>
								<?endif;?>
								<?if($arResult['PROPERTIES'][ROAD_CODE]['VALUE_ENUM_ID'][1]): // если есть шоссе ?>
									<br><a href="/poselki/<?=$valEnumHW2?>-shosse/" class="highway-color">
										<span class="metro-color <?=$colorHW2?>"></span>
										<span class="metro-name"><?=$nameHW2?> шоссе</span></a>
								<?endif;?>
								<?if($arResult['PROPERTIES']['SHOSSE_DOP']['VALUE'][0]): // если есть шоссе ?>
									<br><a href="/poselki/<?=$valEnumHW2?>-shosse/" class="highway-color">
										<span class="metro-color <?=$colorHW2?>"></span>
										<span class="metro-name"><?=$nameHW2?> шоссе</span></a>
								<?endif;?>
								<div class="text-block">
									<div class="title">Ближайший населенный пункт:</div>
									<div class="value"><?=$arResult['PROPERTIES']['SETTLEM']['VALUE'] // Ближайший населенный пункт?>. Расстояние <?=($SETTLEM_KM < 1) ? ($SETTLEM_KM*1000).' м' : $SETTLEM_KM.' км' // Ближайший населенный пункт расстояние, км?></div>
								</div>
								<div class="text-block">
									<div class="title">Ближайший город:</div>
									<div class="value"><?=$arResult['PROPERTIES']['TOWN']['VALUE'] // Ближайший город?>. Расстояние <?=($TOWN_KM < 1) ? ($TOWN_KM*1000).' м' : $TOWN_KM.' км' // Ближайший город расстояние, км?></div>
								</div>
								<div class="text-block">
									<div class="title">Ближайшая ж/д станция:</div>
									<div class="value"><?=$arResult['PROPERTIES']['RAILWAY']['VALUE'] // Ближайший ж/д станция?>.<br>Расстояние до станции <?=($RAILWAY_KM < 1) ? ($RAILWAY_KM*1000).' м' : $RAILWAY_KM.' км' //Ближайшая ж/д станция расстояние до поселка, км?></div>
								</div>
								<div class="text-block">
									<div class="title">Координаты поселка:</div>
									<div class="value" id="coordMap"><?=$arResult['PROPERTIES']['COORDINATES']['VALUE'] // Координаты поселка?></div>
								</div>
								<div class="button-block">
									<button class="btn btn-success rounded-pill" type="button" id="bildRoute">Построить маршрут</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="container mobile--margin-top">
					<div class="row">
						<div class="col-md-4">
							<div class="map-block">
								<div class="map-block__icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="33.298" height="13.32" viewBox="0 0 33.298 13.32" class="inline-svg">
										<path d="M242.22,86.891H240V88h2.22Zm0,0" transform="translate(-222.796 -81.896)" fill="#3c4b5a" />
										<path d="M.476,3.827l3.77-.538A19.021,19.021,0,0,1,6.382,2.157,18.689,18.689,0,0,1,14.114.492h.655a18.864,18.864,0,0,1,9.008,2.3l1.9,1.038a13.113,13.113,0,0,1,6.346,1.72A2.534,2.534,0,0,1,33.3,7.741v3.3a.555.555,0,0,1-.555.555H30.88a3.318,3.318,0,0,1-6.262,0H9.791a3.318,3.318,0,0,1-6.262,0h-.2a.557.557,0,0,1-.206-.04l-1.8-.721A2.1,2.1,0,0,1,0,8.872v-4.5A.555.555,0,0,1,.476,3.827Zm25.1,7.1a2.22,2.22,0,1,0-.045-.444A2.22,2.22,0,0,0,25.574,10.925Zm-10.034-.444h8.88a3.33,3.33,0,1,1,6.66,0h1.11V7.741a1.42,1.42,0,0,0-.714-1.23,12,12,0,0,0-5.945-1.579H15.539Zm0-6.66h7.813l-.107-.058a17.745,17.745,0,0,0-7.706-2.137ZM14.429,1.6h-.314a17.565,17.565,0,0,0-6.53,1.251l.969.969h5.875ZM4.485,10.925a2.22,2.22,0,1,0-.045-.444A2.22,2.22,0,0,0,4.485,10.925ZM1.11,5.487H2.775V6.6H1.11V8.872a.993.993,0,0,0,.628.927l1.592.639c0-.051.007-.1.01-.153s0-.111.01-.166.017-.111.026-.166.016-.111.027-.161.027-.107.042-.159.026-.106.042-.158.037-.1.055-.152.036-.1.056-.153.046-.1.069-.142.046-.1.072-.147.056-.088.081-.133.055-.1.087-.14.061-.082.092-.123.065-.089.1-.132.069-.076.1-.111.073-.082.111-.121.076-.07.114-.1.079-.075.122-.111.085-.064.127-.1.084-.065.129-.1.094-.055.142-.086.087-.056.132-.079.1-.049.152-.073.091-.046.138-.066.111-.041.166-.061.092-.036.139-.051c.063-.019.128-.033.193-.049.042-.01.083-.023.125-.032.068-.014.138-.022.208-.032.041-.005.08-.014.121-.018a3.383,3.383,0,0,1,.338-.017,3.333,3.333,0,0,1,3.33,3.33h4.441V4.932h-6.1a.554.554,0,0,1-.392-.163L6.493,3.33a17.8,17.8,0,0,0-1.759.962.557.557,0,0,1-.215.079L1.11,4.858Zm0,0" transform="translate(0 -0.492)" fill="#3c4b5a" />
									</svg>
								</div>
								<div class="map-block__text">
									<div class="map-block__title">На автомобиле:</div>
									<div class="map-block__info"><b><?=$arResult['PROPERTIES']['AUTO_NO_JAMS']['VALUE'] // Авто (Время в пути от МКАД без пробок)?></b> от <?=ROAD?>а без пробок</div>
								</div>
							</div>
						</div>
						<?
							$trainIdYandex = $arResult['PROPERTIES']['TRAIN_ID_YANDEX']['VALUE']; // Электричка (ID станции прибытия)
							if($arResult['PROPERTIES']['TRAIN']['VALUE'] == 'Есть'): // Электричка
								$nameStation = $arResult['PROPERTIES']['RAILWAY']['VALUE']; // Ближайшая ж/д станция
						?>
							<div class="col-md-4">
								<div class="map-block">
									<div class="map-block__icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="33.298" height="13.319" viewBox="0 0 33.298 13.319" class="inline-svg">
											<path d="M250.156,139.33h2.22a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33A.555.555,0,0,0,250.156,139.33Zm.555-3.33h1.11v2.22h-1.11Zm0,0" transform="translate(-235.172 -132.671)" fill="#3c4b5a" />
											<path d="M137.173,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM135.509,136h1.11v2.22h-1.11Zm0,0" transform="translate(-126.629 -132.671)" fill="#3c4b5a" />
											<path d="M60.376,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM58.711,136h1.11v2.22h-1.11Zm0,0" transform="translate(-54.272 -132.671)" fill="#3c4b5a" />
											<path d="M2.22,138.775v-3.33a.555.555,0,0,0-.555-.555H0V136H1.11v2.22H0v1.11H1.665A.555.555,0,0,0,2.22,138.775Zm0,0" transform="translate(0 -132.671)" fill="#3c4b5a" />
											<path d="M364.8,192.488h2.22v1.11H364.8Zm0,0" transform="translate(-343.712 -186.939)" fill="#3c4b5a" />
											<path d="M460.8,230.887h1.11V232H460.8Zm0,0" transform="translate(-434.162 -223.117)" fill="#3c4b5a" />
											<path d="M518.4,230.887h1.11V232H518.4Zm0,0" transform="translate(-488.43 -223.117)" fill="#3c4b5a" />
											<path d="M15.242,96.488H0V97.6H12.209v6.66H0v1.11H12.209v1.11H0v1.11H2.775a2.2,2.2,0,0,0,.308,1.11H0v1.11H33.3V108.7H26.885a2.2,2.2,0,0,0,.308-1.11H29.72a3.578,3.578,0,0,0,2.291-6.327l-3.718-3.1a7.23,7.23,0,0,0-4.62-1.673h-8.43ZM4.995,108.7a1.11,1.11,0,0,1-1.11-1.11H6.1A1.11,1.11,0,0,1,4.995,108.7Zm3.33,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,8.325,108.7Zm4.995-3.33h5.55v1.11h-5.55Zm-3.083,3.33a2.2,2.2,0,0,0,.308-1.11H22.754a2.2,2.2,0,0,0,.309,1.11Zm14.738,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,24.974,108.7Zm3.573-8.879,2.664,2.22H25.973a.555.555,0,0,1-.427-.2l-1.682-2.02h4.683Zm-8.567,5.55h5.55v-1.11h-5.55V97.6h3.693a6.118,6.118,0,0,1,3.508,1.11H23.864a1.11,1.11,0,0,0-.852,1.82l1.685,2.02a1.661,1.661,0,0,0,1.277.6h6.049a2.439,2.439,0,0,1-2.3,3.33H19.979Zm-1.11-7.77v6.66h-5.55V97.6Z" transform="translate(0 -96.488)" fill="#3c4b5a" />
										</svg>
									</div>
									<div class="map-block__text">
										<div class="map-block__title">На электричке:</div>
										<div class="map-block__info"><b><?=$arResult['PROPERTIES']['TRAIN_TRAVEL_TIME']['VALUE'] // Электричка (время в пути)?></b> от вокзала: <?=$arResult['PROPERTIES']['TRAIN_VOKZAL']['VALUE'] // Электричка (вокзал)?><br>Стоимость одного проезда: <b><?=$arResult['PROPERTIES']['TRAIN_PRICE']['VALUE'] // Электричка (стоимость проезда)?> руб.</b><br>Стоимость такси: <b><?=$arResult['PROPERTIES']['TRAIN_PRICE_TAXI']['VALUE'] // Электричка (стоимость такси)?> руб.</b></div>
										<?if($trainIdYandex):?>
											<div class="map-block__link"><a class="text-success text-decoration-nont font-weight-bold" href="https://rasp.yandex.ru/station/<?=$trainIdYandex?>?span=day&type=suburban&event=departure" target="_blank" rel="nofollow">
												Посмотреть расписание&nbsp;
												<svg xmlns="http://www.w3.org/2000/svg" width="6.847" height="11.883" viewBox="0 0 6.847 11.883" class="inline-svg">
													<g transform="rotate(180 59.406 5.692)">
														<path d="M113.258 5.441l4.915-4.915a.308.308 0 1 0-.436-.436L112.6 5.225a.307.307 0 0 0 0 .436l5.134 5.132a.31.31 0 0 0 .217.091.3.3 0 0 0 .217-.091.307.307 0 0 0 0-.436z" />
													</g>
												</svg></a></div>
										<?endif;?>
									</div>
								</div>
							</div>
						<?endif;?>
						<?if($arResult['PROPERTIES']['BUS']['VALUE'] == 'Есть'): // Автобус
							$nameStation = $arResult['PROPERTIES']['BUS_VOKZAL']['VALUE']; // Автобус (вокзал)
						?>
							<div class="col-md-4">
								<div class="map-block">
									<div class="map-block__icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="33.298" height="17.762" viewBox="0 0 33.298 17.762" class="inline-svg">
											<path d="M.555,16.027h2.83A2.765,2.765,0,0,0,8.325,17.12a2.766,2.766,0,0,0,4.939-1.093h11.21a2.775,2.775,0,0,0,5.439,0h2.83a.555.555,0,0,0,.555-.555V11.259a7.2,7.2,0,0,0-.2-1.669l-1.212-5.1a2.226,2.226,0,0,0-2.177-1.785H13.107L12.154.8a.555.555,0,0,0-.5-.307H3.885a.555.555,0,0,0-.5.307L2.432,2.708H.555A.555.555,0,0,0,0,3.263V15.472A.555.555,0,0,0,.555,16.027Zm5.55,1.11a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,6.1,17.137Zm4.44,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,10.544,17.137Zm16.649,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,27.194,17.137Zm4.828-7.291c.006.026.008.051.013.077H27.748V6.038h3.369ZM4.228,1.6h7.084l.555,1.11H3.673ZM1.11,3.818h28.6a1.119,1.119,0,0,1,1.093.912l.05.2H1.11Zm25.529,2.22V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923H9.989V6.038Zm-4.44,0V9.923H5.55V6.038Zm-7.77,0H4.44V9.923H1.11Zm0,7.215H2.22v-1.11H1.11v-1.11H32.175c0,.075.013.15.013.226v.884h-1.11v1.11h1.11v1.665H29.913a.147.147,0,0,0-.009-.029,2.745,2.745,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.872,2.872,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.862,2.862,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.166-.116a2.955,2.955,0,0,0-.278-.149c-.059-.028-.116-.055-.177-.083a2.755,2.755,0,0,0-.333-.1c-.056-.014-.107-.033-.164-.044a2.631,2.631,0,0,0-1.054,0c-.056.011-.111.03-.164.044a2.768,2.768,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.927,2.927,0,0,0-.278.149q-.083.055-.166.116a2.592,2.592,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.954,2.954,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.829,2.829,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.767,2.767,0,0,0-.144.462.137.137,0,0,1-.009.029h-11.2a.147.147,0,0,0-.009-.029,2.787,2.787,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.871,2.871,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.907,2.907,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.167-.116a2.923,2.923,0,0,0-.277-.149c-.059-.028-.116-.055-.177-.083a2.727,2.727,0,0,0-.33-.1c-.056-.014-.107-.033-.166-.044a2.583,2.583,0,0,0-1.033,0l-.086.016a2.767,2.767,0,0,0-.451.14l-.082.036a2.791,2.791,0,0,0-.42.228l-.022.017a2.789,2.789,0,0,0-.357.295l-.056.051a2.778,2.778,0,0,0-.235.272,2.827,2.827,0,0,0-.242-.278c-.018-.018-.036-.034-.056-.051a2.81,2.81,0,0,0-.357-.295l-.022-.017a2.8,2.8,0,0,0-.42-.228L7.146,12.9a2.792,2.792,0,0,0-.451-.14l-.086-.016a2.581,2.581,0,0,0-1.033,0c-.056.011-.111.03-.164.044a2.716,2.716,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.91,2.91,0,0,0-.275.149c-.055.037-.111.075-.166.116a2.627,2.627,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.832,2.832,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.809,2.809,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.732,2.732,0,0,0-.144.462.147.147,0,0,1-.009.029H1.11Zm0,0" transform="translate(0 -0.488)" fill="#3c4b5a" />
											<path d="M230.4,202.09h11.1v1.11H230.4Zm0,0" transform="translate(-217.079 -190.435)" fill="#3c4b5a" />
										</svg>
									</div>
									<div class="map-block__text">
										<div class="map-block__title">На автобусе:</div>
										<div class="map-block__info">ст. отправления <?=$nameStation?>, <b><?$BUS_TIME_KM = (float)$arResult['PROPERTIES']['BUS_TIME_KM']['VALUE'];?><?=($BUS_TIME_KM < 1) ? ($BUS_TIME_KM*1000).' м' : $BUS_TIME_KM.' км' // Автобус (расстояние от остановки, км)?></b> от&nbsp;остановки</div>
									</div>
								</div>
							</div>
						<?endif;?>
					</div>
				</div>
			</div>
    </div>
  </div>
</div>

<?if($arResult["NEWS"]){?>
	<div class="about about-home-portal bg-white block-articles">
		<div class="container">
			<h2>Что нового в посёлке КП <?=$arResult["NAME"]?></h2>
			<?foreach ($arResult["NEWS"] as $value) {
				// обрежем текст
				$countText = strlen($value["PREVIEW_TEXT"]);
				if ($countText > 1000) {
					$string = strip_tags($value["PREVIEW_TEXT"]);
					$string = substr($string, 0, 1000);
					$string = rtrim($string, "!,.-");
					$string = substr($string, 0, strrpos($string, ' '));
					$text = $string."...";
				}
				else
					$text = $value["PREVIEW_TEXT"];
				?>
				<div class="row mb-5">
					<div class="order-0 order-sm-0 col-12 d-sm-none">
						<h2 class="about-home-portal__title h2 text-left">
							<?=$value['NAME']?>
							<br>
							<span class="date"><?=$value["ACTIVE_FROM"]?></span>
						</h2>
					</div>
					<div class="order-0 order-sm-1 col-sm-6 col-xl-5 text-left">
						<img src="<?=CFile::GetPath($value['PREVIEW_PICTURE'])?>" alt="Новости о посёлке <?=$value['NAME']?>" title="Новости о посёлке <?=$value['NAME']?>">
					</div>
					<div class="order-2 order-sm-2 col-sm-6 col-xl-7">
						<div class="d-none d-sm-block">
							<div class="about-home-portal__title h2">
								<?=$value['NAME']?>
								<br>
								<span class="date"><?=$value["ACTIVE_FROM"]?></span>
							</div>
						</div>
						<div class="about-home-portal__text">
							<p><?=$text?></p>
						</div>
					</div>
				</div>
			<?}?>
			<?if($arResult["NEWS"] && count($arResult["NEWS"]) >= 3){?>
			<a class="btn bg-white text-success w-100" href="/poselki/<?=$arResult['CODE']?>/news/">
				Показать ещё
				<svg xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 12 7" class="inline-svg">
					<g transform="rotate(-90 59.656 59.156)">
						<path d="M113.258 5.441l4.915-4.915a.308.308 0 1 0-.436-.436L112.6 5.225a.307.307 0 0 0 0 .436l5.134 5.132a.31.31 0 0 0 .217.091.3.3 0 0 0 .217-.091.307.307 0 0 0 0-.436z" />
					</g>
				</svg>
			</a>
			<?}?>
		</div>
	</div>
<?}?>
<?if ($arResult['DEVELOPERS']):?>
	<div class="container <?if(count($arResult['DEVELOPERS']) == 1)echo 'mt-3 mt-md-5';?>" id="description">
		<div class="row">
			<?$i = 0;
			foreach ($arResult['DEVELOPERS'] as $value) { $i++;
				$nProp = ($i == 1 ) ? '' : '_'.$i;
				$imgDevel = CFile::ResizeImageGet($value['UF_FILE'], array('width'=>290, 'height'=>100), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);?>
				<?if(count($arResult['DEVELOPERS']) > 1):?>
					<div class="col-12 my-3">
		        <div class="row developer__title-line mt-3 mt-md-5">
		          <div class="col-lg-7">
		            <div class="developer__title">
		              <h2 class="mt-0 mr-auto">
		                  Поселки от компании «<?=$value['UF_NAME']?>»
		              </h2>
		            </div>
		          </div>
		          <div class="col-lg-5 text-lg-right pt-2">
								<div class="phone-cart__block mt-2">
									<?=$value['UF_PHONE']?>
									<!-- <span onclick="ym(50830593,'reachGoal','phone_click');ga('send','event','button','phone_click');return true;">Показать</span> -->
								</div>
							</div>
		        </div>
		      </div>
				<?endif;?>
			<?}?>
		</div>
	</div>
<?endif;?>

<?if($arResult['PROPERTIES']['VIDEO_VIL']['VALUE']){ //  Видео поселка ?>
	<div class="bg-white about-village__video">
		<div class="container">
			<div class="video radius" style="background: #333 url(/assets/img/site/hero@2x.jpg) no-repeat center center; background-size: cover;" data-youtube="<?=$arResult['PROPERTIES']['VIDEO_VIL']['CODE_YB']?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="102" height="102" viewBox="0 0 102 102" class="inline-svg play">
					<g transform="translate(-314 -1783)">
						<g>
							<circle cx="31" cy="31" r="31" transform="translate(334 1803)" class="circle-main-stroke" />
							<circle cx="27" cy="27" r="27" transform="translate(338 1807)" class="circle-main" />
							<g>
								<g transform="translate(324 1793)" fill="none" class="circle-line" stroke-linecap="round" stroke-width="1" stroke-dasharray="45">
									<circle cx="41" cy="41" r="41" stroke="none" />
									<circle cx="41" cy="41" r="40.5" fill="none" />
								</g>
								<g transform="translate(314 1783)" fill="none" class="circle-line" stroke-linecap="round" stroke-width="1" stroke-dasharray="45 10">
									<circle cx="51" cy="51" r="51" stroke="none" />
									<circle cx="51" cy="51" r="50.5" fill="none" />
								</g>
							</g>
							<path class="triangle" d="M17.779,8.1,6.13.071A.4.4,0,0,0,5.5.4V16.47a.4.4,0,0,0,.63.331l11.65-8.034a.4.4,0,0,0,0-.661Z" transform="translate(354.774 1826.564)" />
						</g>
					</g>
				</svg>
			</div>
		</div>
	</div>
<?}?>

<?if($arResult["arHouses"]):?>
 <div id="home">
	<div class="house-in-village area-in-village page__content-list">
		<div class="container">
			<h2>Дома в этом посёлке</h2>
			<div class="list--grid">
				<?foreach ($arResult["arHouses"] as $id => $house) {
					$offerURL = '/kupit-dom/'.$arResult['CODE'].'-dom-'.$house['ID'].'/';

					$comparisonHouses = (in_array($house['ID'],$arComparisonHouses)) ? 'Y' : 'N';
					$favoritesHouses = (in_array($house['ID'],$arFavoritesHouses)) ? 'Y' : 'N';
					$comp_activeHouses = ($comparisonHouses == 'Y') ? 'active' : '';
					$fav_activeHouses = ($favoritesHouses == 'Y') ? 'active' : '';
					$comp_textHouses = ($comparisonHouses != 'Y') ? 'Добавить к сравнению' : 'Удалить из сравнения';
					$fav_textHouses = ($favoritesHouses != 'Y') ? 'Добавить в избранное' : 'Удалить из избранного';
				?>
				<div class="card-house">
					<div class="d-flex flex-wrap bg-white card-grid">
						<div class="card-house__photo photo">
							<div class="photo__buttons in_village">
			            <button title="<?= $comp_textHouses ?>" class="comparison-click <?= $comp_activeHouses ?>" data-id="<?= $house['ID'] ?>" data-cookie="comparison_houses">
			                <svg xmlns="http://www.w3.org/2000/svg" width="19.42" height="17.556" viewBox="0 0 19.42 17.556" class="inline-svg add-comparison">
			                    <g transform="translate(-1216.699 -36.35)">
			                        <path d="M0 0v16.139" class="s-1" transform="translate(1217.349 37)"/>
			                        <path d="M0 0v8.468" class="s-1" transform="translate(1233.321 37)"/>
			                        <g transform="translate(.586 .586)">
			                            <path d="M0 0v4.297" class="s-2" transform="translate(1232.735 48)"/>
			                            <path d="M0 0v4.297" class="s-2" transform="rotate(90 592.368 642.516)"/>
			                        </g>
			                        <path d="M0 0v13.215" class="s-1" transform="translate(1222.807 40.041)"/>
			                        <path d="M0 0v7.641" class="s-1" transform="translate(1228.265 45.499)"/>
			                    </g>
			                </svg>
			            </button>
			            <button title="<?= $fav_textHouses ?>" class="favorites-click <?= $fav_activeHouses ?>" data-id="<?= $house['ID'] ?>" data-cookie="favorites_houses">
			                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="21" viewBox="0 0 24 21" class="inline-svg add-heart">
			                    <g transform="translate(.05 -26.655)">
			                        <path d="M19.874 30.266a5.986 5.986 0 0 0-8.466 0l-.591.591-.6-.6a5.981 5.981 0 0 0-8.466-.009 5.981 5.981 0 0 0 .009 8.466l8.608 8.608a.614.614 0 0 0 .871 0l8.626-8.594a6 6 0 0 0 .009-8.47zm-.88 7.595L10.8 46.019l-8.169-8.172a4.745 4.745 0 1 1 6.71-6.71l1.036 1.036a.617.617 0 0 0 .875 0l1.027-1.027a4.748 4.748 0 0 1 6.715 6.715z" class="s-1"/>
			                        <circle cx="4.5" cy="4.5" r="4.5" class="s-2" transform="translate(14.96 26.655)"/>
			                        <g transform="translate(-1213.44 -18.727)">
			                            <path d="M0 0v4.297" class="s-3" transform="translate(1232.735 48)"/>
			                            <path d="M0 0v4.297" class="s-3" transform="rotate(90 592.368 642.516)"/>
			                        </g>
			                    </g>
			                </svg>
			            </button>
			        </div>
							<div class="card-photo__list">
								<?foreach ($house['IMG'] as $value) {?>
									<img class="card-photo__item" src="<?=$value['src']?>" alt="" />
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
								<div class="footer-card__price"><span class="split-number"><?=$house['PRICE']?></span> <span class="rub_currency">&#8381;</span></div>
								<a class="btn btn-outline-warning rounded-pill" href="<?=$offerURL?>">Подробнее</a>
							</div>
						</div>
					</div>
				</div>
				<?}?>
			</div>
			<a class="btn bg-white text-success w-100" href="/kupit-dom/v-poselke-<?=$arResult['CODE']?>/">
				Показать ещё
				<svg xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 12 7" class="inline-svg">
					<g transform="rotate(-90 59.656 59.156)">
						<path d="M113.258 5.441l4.915-4.915a.308.308 0 1 0-.436-.436L112.6 5.225a.307.307 0 0 0 0 .436l5.134 5.132a.31.31 0 0 0 .217.091.3.3 0 0 0 .217-.091.307.307 0 0 0 0-.436z" />
					</g>
				</svg>
			</a>
		</div>
	</div>
 </div>

<?elseif(!$arResult["arHouses"] && $arResult["arPlots"]):?>

 <div id="area">
	<div class="area-in-village page__content-list">
		<div class="container">
			<h2>Участки в этом посёлке</h2>
			<div class="list--grid">
				<?foreach ($arResult["arPlots"] as $id => $plot) {
					$offerURL = '/kupit-uchastki/uchastok-'.$plot['ID'].'/';

					if ($plot["IMG"])
						array_unshift($arResult['PHOTO_VILLAGE'],$plot["IMG"]); // положим в начало

					shuffle($arResult['PHOTO_VILLAGE']);

					if (count($arResult['PHOTO_VILLAGE']) > 5)
						$arResult['PHOTO_VILLAGE'] = array_slice($arResult['PHOTO_VILLAGE'],0,5);

					$comparisonPlots = (in_array($plot['ID'],$arComparisonPlots)) ? 'Y' : 'N';
					$favoritesPlots = (in_array($plot['ID'],$arFavoritesPlots)) ? 'Y' : 'N';
					$comp_activePlots = ($comparisonPlots == 'Y') ? 'active' : '';
					$fav_activePlots = ($favoritesPlots == 'Y') ? 'active' : '';
					$comp_textPlots = ($comparisonPlots != 'Y') ? 'Добавить к сравнению' : 'Удалить из сравнения';
					$fav_textPlots = ($favoritesPlots != 'Y') ? 'Добавить в избранное' : 'Удалить из избранного';
				?>
				<div class="card-house">
					<div class="d-flex flex-wrap bg-white card-grid">
						<div class="card-house__photo photo">
							<div class="photo__buttons in_village">
			            <button title="<?= $comp_textPlots ?>" class="comparison-click <?= $comp_activePlots ?>" data-id="<?= $plot['ID'] ?>" data-cookie="comparison_plots">
			                <svg xmlns="http://www.w3.org/2000/svg" width="19.42" height="17.556" viewBox="0 0 19.42 17.556" class="inline-svg add-comparison">
			                    <g transform="translate(-1216.699 -36.35)">
			                        <path d="M0 0v16.139" class="s-1" transform="translate(1217.349 37)"/>
			                        <path d="M0 0v8.468" class="s-1" transform="translate(1233.321 37)"/>
			                        <g transform="translate(.586 .586)">
			                            <path d="M0 0v4.297" class="s-2" transform="translate(1232.735 48)"/>
			                            <path d="M0 0v4.297" class="s-2" transform="rotate(90 592.368 642.516)"/>
			                        </g>
			                        <path d="M0 0v13.215" class="s-1" transform="translate(1222.807 40.041)"/>
			                        <path d="M0 0v7.641" class="s-1" transform="translate(1228.265 45.499)"/>
			                    </g>
			                </svg>
			            </button>
			            <button title="<?= $fav_textPlots ?>" class="favorites-click <?= $fav_activePlots ?>" data-id="<?= $plot['ID'] ?>" data-cookie="favorites_plots">
			                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="21" viewBox="0 0 24 21" class="inline-svg add-heart">
			                    <g transform="translate(.05 -26.655)">
			                        <path d="M19.874 30.266a5.986 5.986 0 0 0-8.466 0l-.591.591-.6-.6a5.981 5.981 0 0 0-8.466-.009 5.981 5.981 0 0 0 .009 8.466l8.608 8.608a.614.614 0 0 0 .871 0l8.626-8.594a6 6 0 0 0 .009-8.47zm-.88 7.595L10.8 46.019l-8.169-8.172a4.745 4.745 0 1 1 6.71-6.71l1.036 1.036a.617.617 0 0 0 .875 0l1.027-1.027a4.748 4.748 0 0 1 6.715 6.715z" class="s-1"/>
			                        <circle cx="4.5" cy="4.5" r="4.5" class="s-2" transform="translate(14.96 26.655)"/>
			                        <g transform="translate(-1213.44 -18.727)">
			                            <path d="M0 0v4.297" class="s-3" transform="translate(1232.735 48)"/>
			                            <path d="M0 0v4.297" class="s-3" transform="rotate(90 592.368 642.516)"/>
			                        </g>
			                    </g>
			                </svg>
			            </button>
			        </div>
							<div class="owl-carousel card-photo__list">
								<?foreach ($arResult['PHOTO_VILLAGE'] as $value) {?>
									<img class="card-photo__item" src="<?=$value['src']?>" alt="" />
								<?}?>
							</div>
							<div class="photo__count">
								<span class="current">1</span> / <span class="count"><?=count($arResult['PHOTO_VILLAGE'])?></span>
							</div>
						</div>
						<div class="card-house__content">
							<div class="wrap-title">
								<div class="card-house__title">
									<a href="<?=$offerURL?>">Участок <?=round($plot['PLOTTAGE'])?> соток в посёлке <?=$arResult['NAME']?></a>
									</div>
							</div>
							<div class="card-house__inline">
								<svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8" class="inline-svg">
									<path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z" transform="translate(.15 -22.745)" />
								</svg>
								<div class="card-house__inline-title">
									Площадь участка:&nbsp;</div>
								<div class="card-house__inline-value"><?=$plot['PLOTTAGE']?> соток</div>
							</div>

							<?if($arResult['PROPERTIES'][REGION_CODE]['VALUE']):?>
			          <div class="card-house__area"><a href="/kupit-uchastki/<?=$arResult['PROPERTIES'][REGION_CODE]['VALUE_XML_ID']?>-rayon/"><?=$arResult['PROPERTIES'][REGION_CODE]['VALUE']?> район</a></div>
			        <?endif;?>

							<div class="offer-house__metro metro_no_top">
								<?if($arResult['PROPERTIES'][ROAD_CODE]['VALUE_ENUM_ID'][0]):?>
									<a class="metro z-index-1 highway-color" href="/kupit-uchastki/<?=$valEnumHW?>-shosse/">
										<span class="metro-color <?=$colorHW?>"></span>
										<span class="metro-name"><?=$nameHW?> шоссе</span>
									</a>
								<?endif;?>
								<a class="metro z-index-1" href="/kupit-uchastki/<?=$url_km_MKAD?>/">
									<span class="metro-other"><?=$km_MKAD?> км от <?=ROAD?></span>
								</a>
							</div>

							<div class="footer-card d-flex align-items-center">
								<div class="footer-card__price">
									<span class="split-number"><?=$plot['PRICE']?></span>
									<span class="rub_currency">&#8381;</span>
								</div>
								<a class="btn btn-outline-warning rounded-pill" href="<?=$offerURL?>">Подробнее</a>
							</div>
						</div>
					</div>
				</div>
				<?}?>
			</div>
			<a class="btn bg-white text-success w-100" href="/kupit-uchastki/v-poselke-<?=$arResult['CODE']?>/">
				Показать ещё
				<svg xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 12 7" class="inline-svg">
					<g transform="rotate(-90 59.656 59.156)">
						<path d="M113.258 5.441l4.915-4.915a.308.308 0 1 0-.436-.436L112.6 5.225a.307.307 0 0 0 0 .436l5.134 5.132a.31.31 0 0 0 .217.091.3.3 0 0 0 .217-.091.307.307 0 0 0 0-.436z" />
					</g>
				</svg>
			</a>
		</div>
	</div>
 </div>
<?endif;?>

<div class="bg-white feedback-sale-form">
    <div class="container">
        <div class="feedback-form">
            <div class="feedback-form__title pt-0 text-center text-lg-left">
                <h2>Хотите первыми узнавать об&nbsp;акциях и&nbsp;спецпредложениях по&nbsp;поселку?</h2>
                <p>Подпишитесь на обновление цены участков</p>
            </div>
            <div class="feedback-form__body">
                <form class="formSignToView" data-formID="sale_poselkino">
                    <div class="row">
                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="form-group">
                                <input class="form-control nameSignToView ym-record-keys" id="form-sale-name" type="text" name="form-sale-name" placeholder="Ваше имя" required>
                            </div>
                        </div>
                        <div class="col-lg-4 d-none d-lg-block">
                            <div class="form-group">
                                <input class="form-control phone telSignToView ym-record-keys" id="form-sale-phone" type="text" name="form-sale-name" placeholder="Номер телефона" autocomplete="off" required inputmode="text">
                            </div>
                        </div>
                        <div class="col-lg-4 text-center">
                            <button class="btn btn-warning rounded-pill btn-submit d-none d-lg-inline" type="submit">Хочу знать о скидках</button>
                            <button class="btn btn-warning rounded-pill btn-submit d-inline d-lg-none" type="button" data-toggle="modal" data-target="#modalFeedbackSale">Хочу знать о скидках</button>
                        </div>
                        <div class="col-lg-12 d-none d-lg-block">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input class="custom-control-input" id="form-sale-policy" type="checkbox" name="form-sale-policy" checked="checked" required>
                                <label class="custom-control-label" for="form-sale-policy">
                                    Нажимая на кнопку, вы даете согласие на обработку персональных данных и соглашаетесь с&nbsp;
                                    <a href="/politika-konfidentsialnosti/" class="font-weight-bold" onclick="window.open('/politika-konfidentsialnosti/', '_blank'); return false;" title="Ознакомиться с политикой конфиденциальности">Политикой Конфиденциальности</a>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalFeedbackSale" tabindex="-1" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content bg-light">
            <div class="modal-header">
                <div class="d-flex w-100 justify-content-between align-items-center">
                    <h5 class="text-uppercase" id="writeToUsLabel">Подписаться на обновление цены участков</h5>
                    <button class="close btn-sm" type="button" data-dismiss="modal" aria-label="Close">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.0044 14.8471C15.3949 14.4566 15.3949 13.8235 15.0044 13.4329L9.34785 7.77641L15.0045 2.11975C15.395 1.72923 15.395 1.09606 15.0045 0.705538C14.614 0.315014 13.9808 0.315014 13.5903 0.705538L7.93364 6.3622L2.27644 0.705003C1.88592 0.314478 1.25275 0.314478 0.862229 0.705003C0.471705 1.09553 0.471705 1.72869 0.862229 2.11922L6.51942 7.77641L0.862379 13.4335C0.471855 13.824 0.471855 14.4571 0.862379 14.8477C1.2529 15.2382 1.88607 15.2382 2.27659 14.8477L7.93364 9.19063L13.5901 14.8471C13.9807 15.2377 14.6138 15.2377 15.0044 14.8471Z" fill="#808080"/>
                        </svg>
                    </button>
                </div>
            </div>
            <div class="modal-body">
                <form class="formSignToView" data-formID="sale_poselkino">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <input class="form-control nameSignToView ym-record-keys" id="form-sale-name" type="text" name="form-sale-name" placeholder="Ваше имя" required>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <input class="form-control phone telSignToView ym-record-keys" id="form-sale-phone" type="text" name="form-sale-name" placeholder="Номер телефона" autocomplete="off" required inputmode="text">
                            </div>
                        </div>
                        <div class="col-12">
                            <button class="btn btn-warning rounded-pill btn-submit w-100" type="submit">Подписаться</button>
                        </div>
                        <div class="col-12">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input class="custom-control-input" id="form-sale-policy" type="checkbox" name="form-sale-policy" checked="checked" required>
                                <label class="custom-control-label" for="form-sale-policy">
                                    Нажимая на кнопку, вы даете согласие на обработку персональных данных и соглашаетесь с&nbsp;
                                    <a href="/politika-konfidentsialnosti/" class="font-weight-bold" onclick="window.open('/politika-konfidentsialnosti/', '_blank'); return false;" title="Ознакомиться с политикой конфиденциальности">Политикой Конфиденциальности</a>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div id="arrangement" class="arrangement bg-light">
	<div class="container">
		<h2>Обустройство</h2>
	</div>
	<div class="container arrangement__list">
		<div class="row">
			<div class="col-md-4 px-2 my-2">
				<div class="arrangement__card radius">
					<div class="arrangement__title">Дороги в поселке</div>
					<div class="row">
						<div class="col-xl-6">
							<div class="arrangement__item">
								<?=file_get_contents('https://'.$_SERVER['HTTP_HOST'].'/assets/img/svg/road-'.$arResult['PROPERTIES']['ROADS_IN_VIL']['VALUE_XML_ID'].'.svg');?>
								<div class="arrangement__text"><?=$arResult['PROPERTIES']['ROADS_IN_VIL']['VALUE']?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 px-2 my-2">
				<div class="arrangement__card radius">
					<div class="arrangement__title">Дороги до поселка</div>
					<div class="row">
						<div class="col-xl-6">
							<div class="arrangement__item">
								<?=file_get_contents('https://'.$_SERVER['HTTP_HOST'].'/assets/img/svg/road-'.$arResult['PROPERTIES']['ROADS_TO_VIL']['VALUE_XML_ID'].'.svg');?>
								<div class="arrangement__text"><?=$arResult['PROPERTIES']['ROADS_TO_VIL']['VALUE']?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 px-2 my-2">
				<div class="arrangement__card radius">
					<div class="arrangement__title">Безопасность</div>
					<?if($arArrange && in_array('Охрана', $arArrange)){ // Обустройство поселка: Охрана?>
						<div class="col-xl-6">
							<div class="arrangement__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="19.974" height="23.456" viewBox="0 0 19.974 23.456" class="inline-svg">
									<g transform="translate(0 0.001)">
										<path d="M124.911,158.457a4.469,4.469,0,1,0,4.469,4.469A4.474,4.474,0,0,0,124.911,158.457Zm2.653,3.627-3.2,3.2a.688.688,0,0,1-.973,0l-1.224-1.224a.688.688,0,0,1,.973-.973l.737.737,2.715-2.715a.688.688,0,0,1,.973.973Zm0,0" transform="translate(-114.924 -151.199)" fill="#5277f5" class="color-fill" />
										<path d="M19.951,6.363V6.345c-.01-.225-.017-.464-.021-.729a2.486,2.486,0,0,0-2.341-2.435A9.647,9.647,0,0,1,11.023.413L11.008.4a1.5,1.5,0,0,0-2.04,0L8.952.413A9.648,9.648,0,0,1,2.387,3.181,2.486,2.486,0,0,0,.046,5.616c0,.263-.011.5-.021.729v.042c-.052,2.75-.118,6.173,1.027,9.279A11.812,11.812,0,0,0,3.885,20.08,14.824,14.824,0,0,0,9.43,23.36a1.715,1.715,0,0,0,.227.062,1.679,1.679,0,0,0,.66,0,1.716,1.716,0,0,0,.228-.062,14.833,14.833,0,0,0,5.54-3.282,11.829,11.829,0,0,0,2.834-4.415C20.068,12.547,20,9.118,19.951,6.363ZM9.987,17.573a5.846,5.846,0,1,1,5.846-5.846A5.852,5.852,0,0,1,9.987,17.573Zm0,0" transform="translate(0)" fill="#5277f5" class="color-fill" />
									</g>
								</svg>
								<div class="arrangement__text">Охрана</div>
							</div>
						</div>
					<?}?>
					<?if($arArrange && in_array('Огорожен', $arArrange)){ // Обустройство поселка: Огорожен?>
						<div class="col-xl-6">
							<div class="arrangement__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="22.974" height="21.967" viewBox="0 0 22.974 21.967" class="inline-svg">
									<g transform="translate(0 -6.247)">
										<g transform="translate(0 6.247)">
											<rect width="1.904" height="2.188" transform="translate(6.206 6.28)" fill="#06b26b" class="color-fill" />
											<rect width="1.904" height="2.188" transform="translate(14.864 6.28)" fill="#06b26b" class="color-fill" />
											<rect width="1.904" height="2.188" transform="translate(6.206 16.781)" fill="#06b26b" class="color-fill" />
											<rect width="1.904" height="2.188" transform="translate(14.864 16.781)" fill="#06b26b" class="color-fill" />
											<path d="M3.3,6.516a.547.547,0,0,0-.942,0L.077,10.372A.537.537,0,0,0,0,10.65V27.666a.547.547,0,0,0,.547.547H5.112a.547.547,0,0,0,.546-.547V10.65a.546.546,0,0,0-.076-.278Z" transform="translate(0 -6.247)" fill="#06b26b" class="color-fill" />
											<path d="M110.694,6.729a.568.568,0,0,0-.941,0l-2.283,3.857a.546.546,0,0,0-.076.278V27.88a.547.547,0,0,0,.546.547h4.567a.547.547,0,0,0,.546-.547V10.864a.542.542,0,0,0-.076-.278Z" transform="translate(-98.737 -6.461)" fill="#06b26b" class="color-fill" />
											<path d="M220.384,10.586,218.1,6.729a.569.569,0,0,0-.942,0l-2.282,3.857a.545.545,0,0,0-.076.278V27.88a.547.547,0,0,0,.546.547h4.565a.548.548,0,0,0,.547-.547V10.864A.538.538,0,0,0,220.384,10.586Z" transform="translate(-197.487 -6.461)" fill="#06b26b" class="color-fill" />
										</g>
									</g>
								</svg>
								<div class="arrangement__text">Огорожен</div>
							</div>
						</div>
					<?}?>
					<?if($arArrange && in_array('Нет', $arArrange)){ // Обустройство поселка: Нет?>
						<div class="arrangement__item--no text-secondary">- По решению собственников</div>
					<?}?>
				</div>
			</div>
			<div class="col-md-4 px-2 my-2">
				<div class="arrangement__card radius">
					<div class="arrangement__title">Природа</div>
					<div class="row">
						<?if(mb_strtolower($arResult['PROPERTIES']['LES']['VALUE']) != 'нет'): // Лес?>
						<div class="col-xl-6">
							<div class="arrangement__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="17.38" height="24.833" viewBox="0 0 17.38 24.833" class="inline-svg">
									<path d="M72.266,7.657a4.88,4.88,0,0,0-.51-.475,2.01,2.01,0,0,0-1.871-2.747c-.065,0-.13,0-.194.009a4.838,4.838,0,0,0-8.9-2.2,3.412,3.412,0,0,0-3.306,5.4l-.012.013a4.841,4.841,0,0,0,3.549,8.133,4.93,4.93,0,0,0,.743-.056l1.787,2.76-.871,5.642a.6.6,0,0,0,.133.486.623.623,0,0,0,.476.211h3.186a.623.623,0,0,0,.476-.211.6.6,0,0,0,.133-.486l-.856-5.547,1.84-2.842a4.932,4.932,0,0,0,.652.044,4.841,4.841,0,0,0,3.549-8.133Zm-7.349,9.29-1.254-1.938a4.829,4.829,0,0,0,1.2-1.123,4.826,4.826,0,0,0,1.275,1.167Z" transform="translate(-56.177)" fill="#78A86D" class="color-fill" />
								</svg>
								<div class="arrangement__text">Лес</div>
							</div>
						</div>
						<?endif;?>
						<?if(mb_strtolower($arResult['PROPERTIES']['WATER']['VALUE'][0]) != 'нет'): // Водоем?>
						<div class="col-xl-6">
							<div class="arrangement__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="23.111" height="14.182" viewBox="0 0 23.111 14.182" class="inline-svg">
									<g transform="translate(0 -98.909)">
										<g transform="translate(0 98.909)">
											<g>
												<path d="M20.686,100.11a5.278,5.278,0,0,0-6.7,0,3.561,3.561,0,0,1-2.425.9,3.561,3.561,0,0,1-2.426-.9,5.078,5.078,0,0,0-3.352-1.2,5.078,5.078,0,0,0-3.352,1.2,3.561,3.561,0,0,1-2.426.9V103.9a3.561,3.561,0,0,0,2.426-.9,5.078,5.078,0,0,1,3.352-1.2A5.078,5.078,0,0,1,9.13,103a3.561,3.561,0,0,0,2.426.9,3.561,3.561,0,0,0,2.425-.9,5.278,5.278,0,0,1,6.7,0,3.561,3.561,0,0,0,2.425.9V101.01A3.561,3.561,0,0,1,20.686,100.11Z" transform="translate(0 -98.909)" fill="#66C1C4" class="color-fill" />
											</g>
										</g>
										<g transform="translate(0 108.101)">
											<g>
												<path d="M19.759,303.446a3.719,3.719,0,0,0-4.851,0,5.077,5.077,0,0,1-3.352,1.2,5.078,5.078,0,0,1-3.352-1.2,3.562,3.562,0,0,0-2.426-.9,3.561,3.561,0,0,0-2.426.9A5.078,5.078,0,0,1,0,304.647v2.889a5.078,5.078,0,0,0,3.352-1.2,3.561,3.561,0,0,1,2.426-.9,3.561,3.561,0,0,1,2.426.9,5.078,5.078,0,0,0,3.352,1.2,5.077,5.077,0,0,0,3.352-1.2,3.719,3.719,0,0,1,4.851,0,5.077,5.077,0,0,0,3.352,1.2v-2.889A5.077,5.077,0,0,1,19.759,303.446Z" transform="translate(0 -302.546)" fill="#66C1C4" class="color-fill" />
											</g>
										</g>
										<g transform="translate(0 103.374)">
											<g>
												<path d="M19.759,198.718a3.719,3.719,0,0,0-4.851,0,5.077,5.077,0,0,1-3.352,1.2,5.078,5.078,0,0,1-3.352-1.2,3.561,3.561,0,0,0-2.426-.9,3.561,3.561,0,0,0-2.426.9A5.077,5.077,0,0,1,0,199.919v3.152a3.561,3.561,0,0,0,2.426-.9,5.078,5.078,0,0,1,3.352-1.2,5.078,5.078,0,0,1,3.352,1.2,3.561,3.561,0,0,0,2.426.9,3.561,3.561,0,0,0,2.425-.9,5.278,5.278,0,0,1,6.7,0,3.561,3.561,0,0,0,2.425.9v-3.152A5.077,5.077,0,0,1,19.759,198.718Z" transform="translate(0 -197.818)" fill="#66C1C4" class="color-fill" />
											</g>
										</g>
									</g>
								</svg>
								<div class="arrangement__text">Водоем</div>
							</div>
						</div>
						<?endif;?>
						<?if(mb_strtolower($arResult['PROPERTIES']['PLYAZH']['VALUE']) != 'нет'): // Пляж для купания?>
						<div class="col-xl-6">
							<div class="arrangement__item">
								<svg xmlns="http://www.w3.org/2000/svg" width="21.889" height="21.799" viewBox="0 0 21.889 21.799" class="inline-svg">
									<g transform="translate(0 -0.093)">
										<path d="M21.565,18.948a.947.947,0,0,0-.744-.229,25.544,25.544,0,0,1-4.17.2,11.6,11.6,0,0,1-3-.558L10.325,8.835a37.7,37.7,0,0,1,7.317-1.6.943.943,0,0,0,.734-1.372A9.638,9.638,0,0,0,7.571.953L7.491.725A.942.942,0,0,0,6.29.146L6.274.151a.943.943,0,0,0-.579,1.2l.079.228A9.636,9.636,0,0,0,.368,12.113a.943.943,0,0,0,1.44.615A34.44,34.44,0,0,1,8.528,9.46l2.8,8.012c-2.261-.958-4.424-1.961-7.28-1.526A6.96,6.96,0,0,0,.237,18.28.95.95,0,0,0,0,18.9V20.95a.946.946,0,0,0,.947.943H20.942a.947.947,0,0,0,.948-.943v-1.3A.952.952,0,0,0,21.565,18.948Z" fill="#E5A33B" class="color-fill" />
									</g>
								</svg>
								<div class="arrangement__text">Пляж</div>
							</div>
						</div>
						<?endif;?>
					</div>
				</div>
			</div>
			<div class="col-md-4 px-2 my-2">
				<div class="arrangement__card radius">
					<div class="arrangement__title">Инфраструктура на территории поселка:</div>
					<div class="row">
						<?if(count($inTer) == 0){?>
							<div class="col-xl-6">
								<div class="arrangement__item">
									<div class="arrangement__item--no text-secondary">- По решению жителей</div>
								</div>
							</div>
						<?}?>
						<?foreach($inTer as $code => $val){?>
							<div class="col-xl-6">
								<div class="arrangement__item">
									<?=file_get_contents('https://'.$_SERVER['HTTP_HOST'].'/assets/img/svg/'.$code.'.svg');?>
									<div class="arrangement__text"><?=$val?></div>
								</div>
							</div>
						<?}?>
					</div>
				</div>
			</div>
			<div class="col-md-4 px-2 my-2">
				<div class="arrangement__card radius">
					<div class="arrangement__title">Инфраструктура в радиусе 5 км:</div>
					<div class="row">
						<?if($rad5km && count($rad5km) == 0){?>
							<div class="col-xl-6">
								<div class="arrangement__item">
									<div class="arrangement__item--no text-secondary">- По решению жителей</div>
								</div>
							</div>
						<?}?>
						<?foreach($rad5km as $code => $val){?>
							<div class="col-xl-6">
								<div class="arrangement__item">
									<?=file_get_contents('https://'.$_SERVER['HTTP_HOST'].'/assets/img/svg/'.$code.'.svg');?>
									<div class="arrangement__text"><?=$val?></div>
								</div>
							</div>
						<?}?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container mt-40">
		<?if($arResult['PROPERTIES']['UTILITY_PAY']['VALUE']): // Коммунальные платежи?>
			<p>– Коммунальные платежи: <?=$arResult['PROPERTIES']['UTILITY_PAY']['VALUE']?> руб в месяц</p>
		<?endif;?>
		<?if(mb_strtolower($arResult['PROPERTIES']['ART_WELLS']['VALUE']) != 'нет'): // Артезианские скважины на участках?>
			<?if($arResult['PROPERTIES']['ART_WELLS_DEPTH']['VALUE']){?>
				<p>– Средняя глубина <?=mb_strtolower($arResult['PROPERTIES']['ART_WELLS']['VALUE']) // Артезианские скважины на участках?> в этой местности составляет — <?=$arResult['PROPERTIES']['ART_WELLS_DEPTH']['VALUE'] // Артезианские скважины на участках глубина, м?> м</p>
			<?}?>
		<?endif;?>
		<?if($arResult['PROPERTIES']['DOP_OBJECT']['VALUE']): // Описание доп. объектов в поселке?>
			<p>– <?=$arResult['PROPERTIES']['DOP_OBJECT']['VALUE']?></p>
		<?endif;?>
		<?if($arResult['PROPERTIES']['KASHIRKA_RU']['VALUE']):?>
			<p class="kashirka_url">
				Панораму посёлка можно посмотреть на <a href="<?=$arResult['PROPERTIES']['KASHIRKA_RU']['VALUE']?>" target="_blank">Каширка.ру</a>
			</p>
		<?endif;?>
	</div>
</div>

<div class="ecology bg-white d-none d-md-block" id="ecologyBlock">
	<div class="container">
		<h2>Экология и природа</h2>
		<div class="row ecology-card">
			<div class="col-md-4 mb-3 mb-md-0">
				<div class="ecology__card radius">
					<svg xmlns="http://www.w3.org/2000/svg" width="44.854" height="44.854" viewBox="0 0 44.854 44.854" class="svg inline-svg">
						<g id="compass" opacity="0.5">
							<path d="M22.427,0A22.427,22.427,0,1,0,44.854,22.427,22.427,22.427,0,0,0,22.427,0Zm0,43.358A20.932,20.932,0,1,1,43.358,22.427,20.932,20.932,0,0,1,22.427,43.358Zm0,0" transform="translate(0)" fill="#78a86d" />
							<path d="M58.689,40A18.689,18.689,0,1,0,77.378,58.689,18.689,18.689,0,0,0,58.689,40Zm0,35.883A17.194,17.194,0,1,1,75.883,58.689,17.194,17.194,0,0,1,58.689,75.883Zm0,0" transform="translate(-36.262 -36.262)" fill="#78a86d" />
							<path d="M142.076,120.059a.747.747,0,0,0-.9-.12l-13.346,7.617c-.008.005-.012.014-.02.019a2.238,2.238,0,0,0-.239.239c0,.008-.014.012-.019.02l-7.619,13.346a.748.748,0,0,0,1.02,1.02l13.344-7.617c.008-.005.012-.014.02-.019a2.238,2.238,0,0,0,.239-.239c0-.008.014-.012.019-.02l7.619-13.344A.748.748,0,0,0,142.076,120.059Zm-19.484,19.484,5.776-10.115,4.343,4.339Zm11.173-6.829-4.336-4.336,10.115-5.776Zm0,0"
								transform="translate(-108.639 -108.643)" fill="#78a86d" />
							<path d="M75.738,232h-2.99a.748.748,0,1,0,0,1.5h2.99a.748.748,0,0,0,0-1.5Zm0,0" transform="translate(-65.272 -210.321)" fill="#78a86d" />
							<path d="M363.738,232h-2.99a.748.748,0,1,0,0,1.5h2.99a.748.748,0,1,0,0-1.5Zm0,0" transform="translate(-326.36 -210.321)" fill="#78a86d" />
							<path d="M232.748,76.485a.748.748,0,0,0,.748-.748v-2.99a.748.748,0,1,0-1.5,0v2.99A.748.748,0,0,0,232.748,76.485Zm0,0" transform="translate(-210.321 -65.272)" fill="#78a86d" />
							<path d="M232.748,360a.748.748,0,0,0-.748.748v2.99a.748.748,0,1,0,1.5,0v-2.99A.748.748,0,0,0,232.748,360Zm0,0" transform="translate(-210.321 -326.36)" fill="#78a86d" />
						</g>
					</svg>
					<div class="ecology__card-text">
						<div class="ecology__card-title">Сторона света относительно <?=REGION_CITY?>:</div>
						<div class="ecology__card-description"><?=$arResult['PROPERTIES']['SIDE']['VALUE'] // Сторона света относительно?></div>
					</div>
				</div>
			</div>
			<div class="col-md-4 mb-3 mb-md-0">
				<div class="ecology__card radius">
					<svg xmlns="http://www.w3.org/2000/svg" width="45.65" height="45.427" viewBox="0 0 45.65 45.427" class="svg inline-svg">
						<path d="M157.177,0,156.1,1.076,157.623,2.6a.76.76,0,0,0,1.075,0l1.522-1.522L159.145,0l-.984.984Zm0,0" transform="translate(-142.184)" fill="#a86d6d" />
						<path d="M310.775,0,309.7,1.076,311.221,2.6a.761.761,0,0,0,1.076,0l1.522-1.522L312.743,0l-.984.984Zm0,0" transform="translate(-282.087)" fill="#a86d6d" />
						<path d="M145.066,219.367h1.522v1.522h-1.522Zm0,0" transform="translate(-132.132 -199.808)" fill="#a86d6d" />
						<path d="M162.133,202.3h1.522v1.522h-1.522Zm0,0" transform="translate(-147.677 -184.264)" fill="#a86d6d" />
						<path d="M349.867,219.367h1.522v1.522h-1.522Zm0,0" transform="translate(-318.673 -199.808)" fill="#a86d6d" />
						<path d="M332.8,202.3h1.522v1.522H332.8Zm0,0" transform="translate(-303.128 -184.264)" fill="#a86d6d" />
						<path d="M247.465,244.965h1.522v1.522h-1.522Zm0,0" transform="translate(-225.401 -223.124)" fill="#a86d6d" />
						<path d="M264.535,262.031h1.522v1.522h-1.522Zm0,0" transform="translate(-240.949 -238.669)" fill="#a86d6d" />
						<path d="M230.4,262.031h1.522v1.522H230.4Zm0,0" transform="translate(-209.856 -238.669)" fill="#a86d6d" />
						<path d="M42.606,26.74a3.048,3.048,0,0,0-2.947,2.282h-4.3L33.9,26.23l2.473.495.3-1.491-3.043-.608,1.607-1.607,2.625.657.368-1.476-1.739-.435,1.109-1.11h4.25a.761.761,0,0,0,.538-1.3l-4.565-4.565a.761.761,0,0,0-1.3.538v4.25l-1.109,1.11-.435-1.741-1.476.37.657,2.625L32.51,23.588l-.1-.182a10.831,10.831,0,0,0-19.179,0l-.1.182-1.646-1.646.657-2.625-1.476-.37-.435,1.741-1.11-1.11v-4.25a.761.761,0,0,0-1.3-.538L3.266,19.354a.761.761,0,0,0,.538,1.3h4.25l1.11,1.109L7.424,22.2l.368,1.476,2.626-.657,1.607,1.607-3.044.609.3,1.491,2.473-.495-1.467,2.793H5.99A3.043,3.043,0,0,0,0,29.783,3,3,0,0,0,.415,31.3,3,3,0,0,0,0,32.826a3.043,3.043,0,0,0,5.99.761h1.9L2.206,44.408A19.352,19.352,0,0,0,0,53.369a.761.761,0,0,0,.761.761H3.8v.142a4.427,4.427,0,0,0,4.422,4.423h4.849a4.421,4.421,0,0,0,3.662-1.945A4.421,4.421,0,0,0,20.4,58.695H25.25a4.421,4.421,0,0,0,3.662-1.945,4.421,4.421,0,0,0,3.662,1.945h4.85a4.427,4.427,0,0,0,4.422-4.423V54.13h3.043a.761.761,0,0,0,.761-.761,19.357,19.357,0,0,0-2.206-8.96L37.76,33.587h1.9a3.043,3.043,0,0,0,5.988-.761,3,3,0,0,0-.416-1.522,3,3,0,0,0,.416-1.522A3.043,3.043,0,0,0,42.606,26.74Zm-4.565-9.576,1.967,1.967H38.042ZM7.608,19.131H5.641l1.967-1.967ZM5.326,32.065a.761.761,0,0,0-.761.761,1.522,1.522,0,0,1-3.043,0,1.5,1.5,0,0,1,.4-1.013.761.761,0,0,0,0-1.018,1.5,1.5,0,0,1-.4-1.012,1.522,1.522,0,1,1,3.043,0,.761.761,0,0,0,.761.761H9.487l-.8,1.522ZM15.977,54.272a2.9,2.9,0,0,1-2.9,2.9H8.227a2.9,2.9,0,0,1-2.9-2.9V50.944a2.9,2.9,0,0,1,2.9-2.9h.841L7.014,50.611l1.189.951,1.688-2.111v2.4h1.522v-2.4L13.1,51.562l1.188-.951-2.054-2.568h.841a2.9,2.9,0,0,1,2.9,2.9Zm-8.2-9.881.064-.064a1.086,1.086,0,0,1,1.369-.135,2.6,2.6,0,0,0,2.891,0,1.089,1.089,0,0,1,1.37.135l.064.064-1.065,2.13H8.839Zm20.378,9.881a2.9,2.9,0,0,1-2.9,2.9H20.4a2.9,2.9,0,0,1-2.9-2.9V50.944a2.905,2.905,0,0,1,2.9-2.9h.841l-2.054,2.568,1.188.951,1.688-2.111v2.4h1.522v-2.4l1.688,2.111,1.188-.951-2.054-2.568h.841a2.9,2.9,0,0,1,2.9,2.9Zm-8.2-9.881.064-.064a1.086,1.086,0,0,1,1.37-.135,2.6,2.6,0,0,0,2.891,0,1.088,1.088,0,0,1,1.369.135l.064.064-1.065,2.13H21.013Zm20.377,9.881a2.9,2.9,0,0,1-2.9,2.9h-4.85a2.9,2.9,0,0,1-2.9-2.9V50.944a2.905,2.905,0,0,1,2.9-2.9h.842l-2.055,2.568,1.188.951,1.688-2.111v2.4h1.522v-2.4l1.688,2.111,1.189-.951-2.054-2.568h.841a2.9,2.9,0,0,1,2.9,2.9Zm-8.2-9.881.064-.064a1.086,1.086,0,0,1,1.369-.135,2.6,2.6,0,0,0,2.891,0,1.089,1.089,0,0,1,1.37.135l.064.064-1.065,2.13H33.186Zm9.973.727a17.83,17.83,0,0,1,2.019,7.49H41.846V50.944a4.427,4.427,0,0,0-3.4-4.3l1.038-2.067a.761.761,0,0,0-.143-.878l-.452-.452a2.611,2.611,0,0,0-3.288-.326,1.084,1.084,0,0,1-1.2,0,2.612,2.612,0,0,0-3.288.326l-.452.452a.761.761,0,0,0-.143.878l1.034,2.067a4.435,4.435,0,0,0-2.639,1.82,4.437,4.437,0,0,0-2.636-1.82l1.038-2.067a.761.761,0,0,0-.143-.878l-.452-.452a2.612,2.612,0,0,0-3.288-.326,1.084,1.084,0,0,1-1.2,0,2.611,2.611,0,0,0-3.288.326l-.452.452a.761.761,0,0,0-.143.878l1.034,2.067a4.437,4.437,0,0,0-2.639,1.82,4.436,4.436,0,0,0-2.635-1.82l1.038-2.067A.761.761,0,0,0,15,43.7l-.452-.452a2.611,2.611,0,0,0-3.288-.326,1.084,1.084,0,0,1-1.2,0,2.612,2.612,0,0,0-3.288.326l-.452.452a.761.761,0,0,0-.143.878L7.2,46.646a4.427,4.427,0,0,0-3.4,4.3v1.664H1.538a17.831,17.831,0,0,1,2.019-7.493l11.026-21a9.309,9.309,0,0,1,16.484,0Zm1.639-13.3a1.5,1.5,0,0,1,.4,1.01,1.522,1.522,0,0,1-3.043,0,.761.761,0,0,0-.761-.761H36.961l-.8-1.522h4.162a.761.761,0,0,0,.761-.761,1.522,1.522,0,1,1,3.043,0,1.5,1.5,0,0,1-.4,1.012.761.761,0,0,0,0,1.018Zm0,0" transform="translate(0 -13.268)" fill="#a86d6d" />
						<path d="M232.681,125.5a2.282,2.282,0,1,0,2.282,2.283A2.282,2.282,0,0,0,232.681,125.5Zm0,3.043a.761.761,0,1,1,.761-.761A.761.761,0,0,1,232.681,128.543Zm0,0" transform="translate(-209.856 -114.31)" fill="#a86d6d" />
						<path d="M201.592,91.367a5.326,5.326,0,1,0,5.326,5.326A5.326,5.326,0,0,0,201.592,91.367Zm0,9.13a3.8,3.8,0,1,1,3.8-3.8A3.8,3.8,0,0,1,201.592,100.5Zm0,0" transform="translate(-178.767 -83.221)" fill="#a86d6d" />
					</svg>
					<div class="ecology__card-text">
						<div class="ecology__card-title">Неблагоприятные объекты:</div>
						<div class="ecology__card-description">
							<?if(!$industrialZone && !$landfill):?>Не обнаружены<?endif;?>
							<?if($industrialZone): // Промзона?>
								Промзона в радиусе <?=($INDUSTRIAL_ZONE_KM < 1) ? ($INDUSTRIAL_ZONE_KM*1000).' м' : $INDUSTRIAL_ZONE_KM.' км';// Промзона (удаленность)?>
						  <?endif;?>
							<?if($landfill): // Полигон ТБО?>
								Полигон ТБО в радиусе <?=($LANDFILL_KM < 1) ? ($LANDFILL_KM*1000).' м' : $LANDFILL_KM.' км' // Полигон ТБО (удаленность)?>
						  <?endif;?>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4 mb-3 mb-md-0">
				<div class="ecology__card radius">
					<svg xmlns="http://www.w3.org/2000/svg" width="44.627" height="44.627" viewBox="0 0 44.627 44.627" class="svg inline-svg">
						<g id="verified" transform="translate(0.35 0.35)" opacity="0.5">
							<g>
								<g>
									<path d="M37.494,6.433A21.963,21.963,0,0,0,6.433,37.494,21.963,21.963,0,1,0,37.494,6.433Zm-15.53,34.92a19.39,19.39,0,1,1,19.39-19.39A19.411,19.411,0,0,1,21.963,41.353Z" fill="#78a86d" stroke="#fff" stroke-width="0.7" />
								</g>
							</g>
							<g transform="translate(11.093 14.539)">
								<g>
									<path d="M150.664,169.844a1.287,1.287,0,0,0-1.82,0L137.48,181.208l-5.982-5.982a1.287,1.287,0,0,0-1.82,1.82l6.892,6.892a1.287,1.287,0,0,0,1.82,0l12.274-12.274A1.287,1.287,0,0,0,150.664,169.844Z" transform="translate(-129.301 -169.467)"
										fill="#78a86d" stroke="#fff" stroke-width="0.7" />
								</g>
							</g>
						</g>
					</svg>
					<div class="ecology__card-text">
						<div class="ecology__card-title">Экологические нормы:</div>
						<div class="ecology__card-description"><?=$arResult['PROPERTIES']['ECOLOGY']['VALUE'] // Экология?></div>
					</div>
				</div>
			</div>
		</div>
		<div class="row ecology-card-img">
			<?if($LES && mb_strtolower($LES) != 'нет'): // Лес?>
			<div class="col-lg-3 col-sm-6">
				<div class="ecology__item radius" style="background-color: #78A86D1A;">
					<svg width="77" height="70" viewBox="0 0 77 70" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path fill-rule="evenodd" clip-rule="evenodd" d="M59.2787 59.8848C55.949 59.8848 52.7494 58.6777 50.2633 56.5253C56.4775 52.4387 60.2647 45.5122 60.2647 38.0162C60.2647 33.3769 58.8488 28.9544 56.1644 25.1934C56.1476 24.0813 56.0287 22.9753 55.8097 21.8903C56.8593 21.2819 58.0425 20.964 59.2787 20.964C63.0985 20.964 66.2064 24.0572 66.2064 27.8596C66.2064 27.9576 66.2026 28.055 66.1986 28.1521C66.1815 28.5765 66.3492 28.9874 66.6591 29.2796C68.8237 31.3196 70.016 34.0762 70.016 37.0416L70.0142 37.1704C70.0103 37.4925 70.1129 37.8069 70.3061 38.0654C72.0765 40.4349 73.0125 43.2528 73.0125 46.2147C73.0125 53.7525 66.8515 59.8848 59.2787 59.8848ZM39.4385 51.8375L47.8215 45.8318C48.4838 45.3575 48.6342 44.4385 48.1576 43.7791C47.6811 43.1203 46.758 42.9701 46.0954 43.4447L39.4385 48.2138V35.8068L44.9477 31.8599C45.6099 31.3853 45.7605 30.4663 45.2837 29.8072C44.8074 29.1481 43.8841 28.9982 43.2215 29.4726L39.4385 32.1829V24.5163C39.4385 23.7041 38.7769 23.0457 37.961 23.0457C37.1452 23.0457 36.4836 23.7041 36.4836 24.5163V40.7982L29.9366 36.1078C29.2744 35.6334 28.3512 35.7832 27.8744 36.4424C27.3978 37.1015 27.5482 38.0206 28.2105 38.495L36.4836 44.4221V57.1975C33.7365 56.9897 31.1485 56.2072 28.8399 54.9718C28.8241 54.9625 28.8095 54.9519 28.7932 54.9431C22.5412 51.5724 18.6574 45.0863 18.6574 38.0162C18.6574 33.8484 19.9744 29.8828 22.466 26.5482C22.6596 26.2894 22.7621 25.9743 22.758 25.6516L22.7568 25.5785C22.7562 25.5426 22.7555 25.5068 22.7555 25.4706C22.7555 24.1649 22.9232 22.8666 23.2537 21.6125C23.276 21.5282 23.2879 21.4435 23.2947 21.3587C24.026 18.7525 25.4554 16.3831 27.4937 14.4621C27.8039 14.1699 27.9718 13.7584 27.9542 13.3335C27.9484 13.1976 27.9433 13.0526 27.9433 12.9128C27.9433 7.41441 32.4373 2.94118 37.961 2.94118C43.485 2.94118 47.979 7.41441 47.979 12.9128C47.979 13.0419 47.9745 13.1744 47.9679 13.3335C47.9503 13.7584 48.1181 14.1699 48.4284 14.4622C51.4985 17.3556 53.1892 21.2651 53.1892 25.4706C53.1892 25.5034 53.1886 25.5362 53.188 25.5688L53.1869 25.6547C53.1832 25.9763 53.2858 26.2903 53.4786 26.5482C55.9703 29.8828 57.2873 33.8484 57.2873 38.0162C57.2873 48.1288 49.4076 56.4438 39.4385 57.1975V51.8375ZM16.6886 59.8848C9.11581 59.8848 2.95483 53.7525 2.95483 46.2147C2.95483 43.2528 3.89063 40.4349 5.66116 38.0654C5.85426 37.8069 5.9568 37.4925 5.95295 37.1704L5.95118 37.0416C5.95118 34.0762 7.14331 31.3196 9.30817 29.2796C9.61843 28.9871 9.78641 28.5753 9.76853 28.1501C9.76439 28.0537 9.76085 27.9571 9.76085 27.8596C9.76085 24.0572 12.8686 20.964 16.6886 20.964C17.9152 20.964 19.0896 21.2778 20.1331 21.8772C19.9166 22.9575 19.7969 24.066 19.7801 25.1935C17.0959 28.9544 15.68 33.3769 15.68 38.0162C15.68 45.7404 19.6686 52.5538 25.7025 56.5263C23.2169 58.6779 20.0177 59.8848 16.6886 59.8848ZM75.9673 46.2147C75.9673 42.7807 74.9315 39.5054 72.9668 36.7101C72.8858 33.2734 71.5449 30.074 69.1579 27.605C69.0218 22.2981 64.6424 18.0228 59.2787 18.0228C57.7584 18.0228 56.2943 18.36 54.9599 19.0088C54.0788 16.7074 52.721 14.596 50.9332 12.7884C50.8663 5.72515 45.0727 0 37.961 0C30.8498 0 25.0567 5.72559 24.989 12.7882C23.2059 14.5913 21.8505 16.6963 20.9693 18.9909C19.6449 18.354 18.1944 18.0228 16.6886 18.0228C11.3248 18.0228 6.94534 22.2981 6.80927 27.605C4.42206 30.074 3.0813 33.2734 3.00019 36.7101C1.03567 39.5056 0 42.7809 0 46.2147C0 54.8787 6.69846 62.0134 15.2112 62.7603V68.5137C15.2112 69.3257 15.8726 69.9843 16.6886 69.9843C17.5044 69.9843 18.166 69.3257 18.166 68.5137V62.7594C22.0163 62.4181 25.6382 60.7521 28.3993 58.0457C30.8776 59.2225 33.6068 59.956 36.4836 60.1444V68.5137C36.4836 69.3257 37.1452 69.9843 37.961 69.9843C38.7769 69.9843 39.4385 69.3257 39.4385 68.5137V60.1444C42.327 59.9553 45.0671 59.2168 47.5533 58.0315C50.3165 60.7462 53.9443 62.4175 57.8013 62.7594V68.5137C57.8013 69.3257 58.4629 69.9843 59.2787 69.9843C60.0945 69.9843 60.7561 69.3257 60.7561 68.5137V62.7603C69.2687 62.0134 75.9673 54.8787 75.9673 46.2147Z" fill="#78A86D"/>
					</svg>

					<div class="ecology__item-title">Лес</div>
					<div class="ecology__item-type"><?=$LES?></div>
					<div class="ecology__item-distance"><?if($FOREST_KM):?>расстояние <?=($FOREST_KM < 1) ? ($FOREST_KM*1000).' м' : $FOREST_KM.' км'?><?endif;?></div>
				</div>
			</div>
			<?endif;?>
			<div class="col-lg-3 col-sm-6">
				<div class="ecology__item radius" style="background-color: #FBB3581A;">
					<svg width="79" height="70" viewBox="0 0 79 70" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M72.2004 58.5002L48.2004 34.5002C47.9004 34.2002 47.6004 34.1002 47.2004 34.1002C46.8004 34.1002 46.4004 34.3002 46.2004 34.5002L43.4004 37.3002C42.8004 28.0002 35.0004 20.7002 25.7004 20.7002C15.9004 20.7002 7.90039 28.7002 7.90039 38.5002C7.90039 42.7002 9.40039 46.8002 12.1004 50.0002L1.30039 60.7002C1.00039 61.0002 0.900391 61.3002 0.900391 61.7002C0.900391 62.1002 1.10039 62.5002 1.30039 62.7002C1.60039 63.0002 1.90039 63.1002 2.30039 63.1002C2.70039 63.1002 3.10039 62.9002 3.30039 62.7002L25.6004 40.4002L52.2004 67.0002H29.9004C29.1004 67.0002 28.5004 67.6002 28.5004 68.4002C28.5004 69.2002 29.1004 69.8002 29.9004 69.8002H55.7004C56.3004 69.8002 56.8004 69.4002 57.0004 68.9002C57.2004 68.4002 57.1004 67.7002 56.7004 67.3002L37.0004 47.7002L47.2004 37.5002L67.7004 58.0002H55.2004C54.4004 58.0002 53.8004 58.6002 53.8004 59.4002C53.8004 60.2002 54.4004 60.8002 55.2004 60.8002H71.1004C71.7004 60.8002 72.2004 60.4002 72.4004 59.9002C72.7004 59.5002 72.6004 58.9002 72.2004 58.5002ZM26.7004 37.4002C26.1004 36.8002 25.2004 36.8002 24.7004 37.4002L14.1004 47.9002C11.9004 45.2002 10.7004 42.0002 10.7004 38.4002C10.7004 30.2002 17.4004 23.5002 25.6004 23.5002C33.8004 23.5002 40.5004 30.2002 40.5004 38.4002C40.5004 39.0002 40.5004 39.5002 40.4004 40.1002L34.9004 45.6002L26.7004 37.4002Z" fill="#FBB358"/>
						<path d="M26.7992 26.6996C26.3992 26.6996 25.9992 26.5996 25.5992 26.5996C24.7992 26.5996 24.1992 27.1996 24.1992 27.9996C24.1992 28.7996 24.7992 29.3996 25.5992 29.3996C25.8992 29.3996 26.1992 29.3996 26.4992 29.3996C26.5992 29.3996 26.5992 29.3996 26.5992 29.3996C27.2992 29.3996 27.9992 28.7996 27.9992 28.0996C28.1992 27.4996 27.5992 26.7996 26.7992 26.6996Z" fill="#FBB358"/>
						<path d="M37.3004 36.2002C36.7004 33.1002 34.8004 30.3002 32.2004 28.6002C31.5004 28.2002 30.6004 28.3002 30.2004 29.0002C30.0004 29.3002 29.9004 29.7002 30.0004 30.1002C30.1004 30.5002 30.3004 30.8002 30.6004 31.0002C32.6004 32.3002 34.0004 34.4002 34.5004 36.8002C34.6004 37.5002 35.2004 38.0002 35.9004 38.0002C36.0004 38.0002 36.1004 38.0002 36.2004 38.0002C36.9004 37.8002 37.4004 37.0002 37.3004 36.2002Z" fill="#FBB358"/>
						<path d="M30.1012 13.4C29.9012 13.1 29.5012 12.9 29.1012 12.8C28.3012 12.7 27.6012 13.3 27.5012 14L27.0012 18C26.9012 18.8 27.5012 19.5 28.2012 19.6C28.3012 19.6 28.3012 19.6 28.4012 19.6C29.1012 19.6 29.7012 19.1 29.8012 18.3L30.3012 14.3C30.4012 14.1 30.3012 13.7 30.1012 13.4Z" fill="#FBB358"/>
						<path d="M19.1992 19.1004L17.6992 15.4004C17.5992 15.0004 17.2992 14.8004 16.8992 14.6004C16.4992 14.5004 16.1992 14.5004 15.7992 14.6004C15.0992 14.9004 14.6992 15.7004 14.9992 16.5004L16.4992 20.2004C16.6992 20.7004 17.1992 21.1004 17.7992 21.1004C17.9992 21.1004 18.1992 21.1004 18.2992 21.0004C19.1992 20.7004 19.4992 19.8004 19.1992 19.1004Z" fill="#FBB358"/>
						<path d="M11.0012 25.7998C11.0012 25.3998 10.8012 25.0998 10.4012 24.7998L7.20117 22.2998C6.60117 21.7998 5.70117 21.8998 5.20117 22.5998C4.70117 23.1998 4.80117 24.0998 5.50117 24.5998L8.70117 27.0998C9.00117 27.2998 9.30117 27.3998 9.60117 27.3998C10.1012 27.3998 10.5012 27.1998 10.7012 26.7998C10.9012 26.5998 11.0012 26.1998 11.0012 25.7998Z" fill="#FBB358"/>
						<path d="M5.60039 34.2998L1.60039 33.7998C0.900391 33.6998 0.100391 34.1998 0.000390626 34.9998C-0.0996094 35.3998 0.000390619 35.7998 0.300391 36.0998C0.600391 36.3998 0.900391 36.5998 1.30039 36.6998L5.30039 37.1998C5.40039 37.1998 5.40039 37.1998 5.50039 37.1998C6.20039 37.1998 6.80039 36.6998 6.90039 35.8998C7.00039 35.0998 6.40039 34.3998 5.60039 34.2998Z" fill="#FBB358"/>
						<path d="M8.1 45.7002C8 45.3002 7.7 45.0002 7.4 44.9002C7 44.8002 6.7 44.8002 6.3 44.9002L2.6 46.4002C1.9 46.7002 1.5 47.6002 1.8 48.3002C2 48.8002 2.5 49.2002 3.1 49.2002C3.3 49.2002 3.5 49.2002 3.6 49.1002L7.3 47.6002C8.1 47.2002 8.4 46.4002 8.1 45.7002Z" fill="#FBB358"/>
						<path d="M49.6 28.6996C49.3 27.9996 48.5 27.5996 47.7 27.8996L44 29.3996C43.6 29.4996 43.4 29.7996 43.2 30.1996C43.1 30.5996 43.1 30.9996 43.2 31.2996C43.4 31.7996 43.9 32.1996 44.5 32.1996C44.7 32.1996 44.9 32.1996 45 32.0996L48.7 30.5996C49.5 30.1996 49.9 29.3996 49.6 28.6996Z" fill="#FBB358"/>
						<path d="M42 19C42 18.6 41.8 18.3 41.4 18C40.8 17.5 39.9 17.6 39.4 18.3L37 21.5C36.5 22.1 36.6 23 37.3 23.5C37.6 23.7 37.9 23.8 38.2 23.8C38.7 23.8 39.1 23.6 39.3 23.2L41.8 20C41.9 19.7 42 19.4 42 19Z" fill="#FBB358"/>
						<path d="M72.9008 19.6C72.7008 19.6 72.4008 19.6 72.2008 19.6C70.9008 17.6 68.7008 16.5 66.3008 16.5C64.5008 16.5 62.8008 17.2 61.5008 18.4C60.6008 19.3 59.9008 20.4 59.5008 21.6C57.2008 21.8 55.3008 23.8 55.3008 26.1C55.3008 28.6 57.3008 30.6 59.8008 30.6C60.6008 30.6 61.2008 30 61.2008 29.2C61.2008 28.4 60.6008 27.8 59.8008 27.8C58.9008 27.8 58.2008 27.1 58.2008 26.2C58.2008 25.3 58.9008 24.6 59.8008 24.6C59.9008 24.6 60.1008 24.6 60.2008 24.7C60.6008 24.8 61.1008 24.7 61.4008 24.5C61.8008 24.3 62.0008 23.9 62.0008 23.4C62.2008 21.3 64.0008 19.6 66.2008 19.6C67.8008 19.6 69.3008 20.6 70.0008 22.1C70.3008 22.8 71.1008 23.1 71.8008 22.9C72.1008 22.8 72.4008 22.7 72.7008 22.7C74.1008 22.7 75.3008 23.9 75.3008 25.3C75.3008 26.7 74.1008 27.9 72.7008 27.9H68.6008C67.8008 27.9 67.2008 28.5 67.2008 29.3C67.2008 30.1 67.8008 30.7 68.6008 30.7H72.7008C75.7008 30.7 78.2008 28.2 78.2008 25.2C78.2008 22.2 75.9008 19.6 72.9008 19.6Z" fill="#FBB358"/>
						<path d="M53.0008 2.7C52.8008 2.7 52.7008 2.7 52.5008 2.7C51.3008 1 49.4008 0 47.4008 0C45.8008 0 44.3008 0.6 43.1008 1.7C42.3008 2.4 41.7008 3.4 41.4008 4.4C39.3008 4.6 37.8008 6.4 37.8008 8.5C37.8008 10.8 39.6008 12.6 41.9008 12.6C42.7008 12.6 43.3008 12 43.3008 11.2C43.3008 10.4 42.6008 9.8 41.9008 9.8C41.2008 9.8 40.7008 9.3 40.7008 8.6C40.7008 7.9 41.2008 7.4 41.9008 7.4C42.0008 7.4 42.1008 7.4 42.2008 7.4C42.6008 7.5 43.1008 7.4 43.4008 7.2C43.8008 6.8 44.0008 6.4 44.0008 6C44.1008 4.3 45.6008 2.9 47.4008 2.9C48.7008 2.9 49.9008 3.7 50.5008 4.9C50.8008 5.6 51.6008 5.9 52.3008 5.7C52.5008 5.6 52.8008 5.6 53.0008 5.6C54.1008 5.6 55.0008 6.5 55.0008 7.6C55.0008 8.7 54.1008 9.6 53.0008 9.6H49.4008C48.6008 9.6 48.0008 10.2 48.0008 11C48.0008 11.8 48.6008 12.4 49.4008 12.4H53.0008C55.7008 12.4 57.9008 10.2 57.9008 7.5C57.9008 4.9 55.7008 2.7 53.0008 2.7Z" fill="#FBB358"/>
					</svg>

					<div class="ecology__item-title">Ландшафт</div>
					<div class="ecology__item-type"><?=$landscape?></div>
					<div class="ecology__item-distance"></div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="ecology__item radius" style="background-color: #65A7D81A;">
					<svg width="71" height="70" viewBox="0 0 71 70" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M42.3996 4C38.8996 4 36.0996 6.8 36.0996 10.3C36.0996 13.8 38.8996 16.6 42.3996 16.6C45.8996 16.6 48.6996 13.8 48.6996 10.3C48.5996 6.8 45.7996 4 42.3996 4ZM42.3996 13.6C40.5996 13.6 39.0996 12.1 39.0996 10.3C39.0996 8.5 40.5996 7 42.3996 7C44.1996 7 45.6996 8.5 45.6996 10.3C45.5996 12.1 44.1996 13.6 42.3996 13.6Z" fill="#65A7D8"/>
						<path d="M32.0992 39.7004C30.1992 35.5004 26.0992 32.9004 21.4992 32.9004C16.8992 32.9004 12.7992 35.5004 10.8992 39.7004L9.69922 42.3004L10.8992 44.9004C12.7992 49.1004 16.8992 51.7004 21.4992 51.7004H21.6992C26.1992 51.6004 30.1992 49.0004 32.0992 44.9004C32.7992 43.3004 32.7992 41.4004 32.0992 39.7004ZM29.2992 43.7004C27.8992 46.8004 24.7992 48.8004 21.3992 48.8004C17.9992 48.8004 14.8992 46.9004 13.4992 43.7004L12.8992 42.5004V42.4004V42.3004V42.2004V42.1004L13.4992 40.9004C14.8992 37.8004 17.9992 35.8004 21.3992 35.8004C24.7992 35.8004 27.8992 37.7004 29.2992 40.9004C29.6992 41.8004 29.6992 42.8004 29.2992 43.7004Z" fill="#65A7D8"/>
						<path d="M68.6992 3C69.5276 3 70.1992 2.32843 70.1992 1.5C70.1992 0.671573 69.5276 0 68.6992 0C67.8708 0 67.1992 0.671573 67.1992 1.5C67.1992 2.32843 67.8708 3 68.6992 3Z" fill="#65A7D8"/>
						<path d="M47.0996 51.5996C46.2996 51.5996 45.5996 52.2996 45.5996 53.0996C45.5996 53.8996 46.2996 54.5996 47.0996 54.5996C47.8996 54.5996 48.5996 53.8996 48.5996 53.0996C48.5996 52.2996 47.9996 51.5996 47.0996 51.5996Z" fill="#65A7D8"/>
						<path d="M1.59961 70C2.42804 70 3.09961 69.3284 3.09961 68.5C3.09961 67.6716 2.42804 67 1.59961 67C0.771182 67 0.0996094 67.6716 0.0996094 68.5C0.0996094 69.3284 0.771182 70 1.59961 70Z" fill="#65A7D8"/>
						<path d="M22.9004 40.7998C22.1004 40.7998 21.4004 41.4998 21.4004 42.2998C21.4004 43.0998 22.1004 43.7998 22.9004 43.7998C23.7004 43.7998 24.4004 43.0998 24.4004 42.2998C24.4004 41.4998 23.7004 40.7998 22.9004 40.7998Z" fill="#65A7D8"/>
						<path d="M1.59961 54.7002C0.799609 54.7002 0.0996094 55.4002 0.0996094 56.2002V59.0002C0.0996094 61.2002 1.59961 63.0002 3.69961 63.4002C5.29961 63.7002 6.29961 64.3002 7.49961 65.0002C9.19961 66.0002 11.1996 67.2002 14.9996 67.2002C18.7996 67.2002 20.6996 66.0002 22.4996 65.0002C24.0996 64.0002 25.4996 63.2002 28.3996 63.2002C31.2996 63.2002 32.6996 64.0002 34.2996 65.0002C35.9996 66.0002 37.9996 67.2002 41.7996 67.2002C45.5996 67.2002 47.4996 66.0002 49.2996 65.0002C50.8996 64.0002 52.2996 63.2002 55.1996 63.2002C58.0996 63.2002 59.4996 64.0002 61.0996 65.0002C61.8996 65.5002 62.6996 66.0002 63.7996 66.4002C64.2996 66.6002 64.8996 66.7002 65.4996 66.7002C66.3996 66.7002 67.2996 66.4002 68.0996 65.9002C69.2996 65.1002 70.0996 63.6002 70.0996 62.1002V13.5002C70.0996 11.3002 68.5996 9.4002 66.3996 9.0002C64.7996 8.7002 63.7996 8.1002 62.5996 7.4002C60.8996 6.4002 58.8996 5.2002 55.0996 5.2002C51.2996 5.2002 49.3996 6.4002 47.5996 7.4002L47.4996 7.5002C47.1996 7.7002 46.8996 7.9002 46.4996 8.1002C46.7996 9.3002 47.3996 10.6002 47.6996 10.9002H47.7996C49.3996 9.9002 52.1996 8.3002 55.0996 8.3002C57.9996 8.3002 59.4996 9.2002 60.9996 10.1002C62.1996 10.8002 63.6996 11.7002 65.6996 12.1002C66.3996 12.2002 66.8996 12.9002 66.8996 13.6002V62.3002C66.8996 63.0002 66.4996 63.4002 66.1996 63.6002C65.9996 63.7002 65.6996 63.9002 65.2996 63.9002C65.0996 63.9002 64.8996 63.9002 64.6996 63.8002C63.8996 63.5002 63.1996 63.1002 62.4996 62.6002C60.7996 61.6002 58.7996 60.4002 54.9996 60.4002C51.1996 60.4002 49.2996 61.6002 47.4996 62.6002C45.8996 63.6002 44.4996 64.4002 41.5996 64.4002C38.6996 64.4002 37.2996 63.6002 35.6996 62.6002C33.9996 61.6002 31.9996 60.4002 28.1996 60.4002C24.3996 60.4002 22.4996 61.6002 20.6996 62.6002C19.0996 63.6002 17.6996 64.4002 14.7996 64.4002C11.8996 64.4002 10.4996 63.6002 8.89961 62.6002C7.59961 61.8002 6.19961 61.0002 4.09961 60.6002C3.39961 60.5002 2.89961 59.8002 2.89961 59.1002V56.3002C3.09961 55.4002 2.49961 54.7002 1.59961 54.7002Z" fill="#65A7D8"/>
						<path d="M35.8996 7.4002C34.1996 6.4002 32.1996 5.2002 28.3996 5.2002C24.5996 5.2002 22.6996 6.4002 20.8996 7.4002C19.2996 8.4002 17.8996 9.2002 14.9996 9.2002C12.0996 9.2002 10.6996 8.4002 9.09961 7.4002C8.09961 6.8002 6.99961 6.1002 5.59961 5.7002C5.19961 5.6002 4.79961 5.5002 4.29961 5.5002C3.39961 5.5002 2.49961 5.8002 1.79961 6.3002C0.699609 7.1002 0.0996094 8.3002 0.0996094 9.6002V30.0002H3.09961V9.6002C3.09961 9.1002 3.39961 8.8002 3.59961 8.6002C3.69961 8.7002 3.99961 8.5002 4.39961 8.5002C4.49961 8.5002 4.59961 8.5002 4.69961 8.5002C5.79961 8.8002 6.59961 9.3002 7.59961 9.9002C9.29961 10.9002 11.2996 12.1002 15.0996 12.1002C18.8996 12.1002 20.7996 10.9002 22.5996 9.9002C24.1996 8.9002 25.5996 8.1002 28.4996 8.1002C31.3996 8.1002 32.7996 8.9002 34.3996 9.9002C35.2996 10.4002 36.2996 11.0002 37.5996 11.5002L38.4996 8.6002C37.4996 8.3002 36.6996 7.9002 35.8996 7.4002Z" fill="#65A7D8"/>
						<path d="M15.0004 27.2998C18.8004 27.2998 20.7004 26.0998 22.5004 25.0998C24.1004 24.0998 25.5004 23.2998 28.4004 23.2998C31.3004 23.2998 32.7004 24.0998 34.3004 25.0998C36.0004 26.0998 38.0004 27.2998 41.8004 27.2998C45.6004 27.2998 47.5004 26.0998 49.3004 25.0998C50.9004 24.0998 52.3004 23.2998 55.2004 23.2998C58.1004 23.2998 59.5004 24.0998 61.1004 25.0998C62.8004 26.0998 64.7004 27.2998 68.3004 27.2998V24.2998C65.6004 24.1998 64.2004 23.3998 62.7004 22.4998C61.0004 21.4998 59.0004 20.2998 55.2004 20.2998C51.4004 20.2998 49.5004 21.4998 47.7004 22.4998C46.1004 23.4998 44.7004 24.2998 41.8004 24.2998C38.9004 24.2998 37.5004 23.4998 35.9004 22.4998C34.2004 21.4998 32.2004 20.2998 28.4004 20.2998C24.6004 20.2998 22.7004 21.4998 20.9004 22.4998C19.3004 23.4998 17.9004 24.2998 15.0004 24.2998C12.1004 24.2998 10.7004 23.4998 9.10039 22.4998C7.40039 21.4998 5.50039 20.2998 1.90039 20.2998V23.2998C4.60039 23.3998 6.00039 24.1998 7.50039 25.0998C9.30039 26.0998 11.3004 27.2998 15.0004 27.2998Z" fill="#65A7D8"/>
						<path d="M62.7008 40.9998C61.0008 39.9998 59.0008 38.7998 55.2008 38.7998C51.4008 38.7998 49.5008 39.9998 47.7008 40.9998C46.1008 41.9998 44.7008 42.7998 41.8008 42.7998C41.1008 42.7998 40.4008 42.7998 39.9008 42.6998C39.8008 42.6998 39.7008 42.6998 39.6008 42.6998C38.9008 42.6998 38.4008 43.0998 38.2008 43.6998C38.0008 44.0998 38.1008 44.5998 38.3008 44.9998C38.5008 45.3998 38.9008 45.5998 39.3008 45.6998C40.1008 45.7998 41.0008 45.8998 41.9008 45.8998C45.7008 45.8998 47.6008 44.6998 49.4008 43.6998C51.0008 42.6998 52.4008 41.8998 55.3008 41.8998C58.2008 41.8998 59.6008 42.6998 61.2008 43.6998C62.9008 44.6998 64.8008 45.8998 68.4008 45.8998V42.8998C65.6008 42.7998 64.3008 41.9998 62.7008 40.9998Z" fill="#65A7D8"/>
						<path d="M0 40.0002V44.6002C0 46.2002 0.9 47.6002 2.3 48.3002C2.9 48.6002 3.5 48.7002 4.1 48.7002H4.2C5.1 48.7002 5.9 48.4002 6.6 47.8002L11.2 44.3002C11.9 43.8002 12.2 43.0002 12.2 42.2002C12.2 41.4002 11.8 40.6002 11.2 40.1002L6.6 36.6002C5.9 36.0002 5 35.7002 4.1 35.7002C3.5 35.7002 2.8 35.8002 2.3 36.1002C0.9 37.0002 0 38.5002 0 40.0002ZM3.3 40.0002C3.3 39.5002 3.6 39.3002 3.8 39.2002C3.9 39.2002 4 39.1002 4.2 39.1002C4.4 39.1002 4.5 39.2002 4.7 39.3002L8.6 42.3002L4.7 45.3002C4.5 45.4002 4.3 45.5002 4.2 45.5002C4 45.5002 3.9 45.5002 3.8 45.4002C3.7 45.3002 3.3 45.1002 3.3 44.6002V40.0002Z" fill="#65A7D8"/>
					</svg>

					<div class="ecology__item-title">Водоем</div>
					<div class="ecology__item-type"><?=$strWater // Водоем?></div>
					<div class="ecology__item-distance"><?if(mb_strtolower($strWater) != 'нет'):?>расстояние <?$WATER_KM = (float)$arResult['PROPERTIES']['WATER_KM']['VALUE']?><?=($WATER_KM < 1) ? ($WATER_KM*1000).' м' : $WATER_KM.' км' // Водоем расстояние, км?><?endif;?></div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="ecology__item radius" style="background-color: #BFA2721A;">
					<svg width="72" height="70" viewBox="0 0 72 70" fill="none" xmlns="http://www.w3.org/2000/svg">
						<path d="M71.0997 59.5997C70.1997 55.4997 66.5997 52.5997 62.3997 52.6997C60.6997 48.9997 56.9997 46.6997 52.8997 46.6997C51.6997 46.6997 50.4997 46.8997 49.2997 47.2997C46.9997 42.8997 42.0997 40.4997 37.1997 41.3997V29.6997C41.1997 29.6997 50.6997 28.8997 56.8997 22.6997C64.6997 14.8997 63.7997 1.49974 63.7997 1.39974C63.6997 0.699742 63.0997 -0.000258388 62.3997 -0.000258388H62.2997C58.8997 -0.100258 47.8997 0.0997415 40.9997 6.99974C38.4997 9.59974 36.6997 12.7997 35.5997 16.2997C34.4997 12.7997 32.6997 9.69974 30.1997 6.99974C22.2997 -0.900259 8.99971 -0.000258388 8.89971 -0.000258388C8.09971 0.0997416 7.49971 0.699742 7.49971 1.49974V1.59974C7.39971 4.79974 7.59971 15.8997 14.3997 22.6997C20.5997 28.8997 30.0997 29.6997 34.0997 29.6997V42.3997C32.1997 43.2997 30.6997 44.6997 29.4997 46.3997C23.4997 43.3997 16.0997 45.6997 12.8997 51.6997C12.5997 52.2997 12.2997 52.8997 12.0997 53.4997C10.1997 52.6997 7.99971 52.5997 5.99971 53.1997C3.79971 53.8997 1.99971 55.4997 0.899713 57.4997C-1.30029 61.7997 0.399713 66.9997 4.69971 69.1997C5.29971 69.4997 5.99971 69.7997 6.69971 69.8997C6.79971 69.8997 6.79971 69.8997 6.89971 69.8997H6.99971H63.9997H64.2997C66.5997 69.3997 68.4997 68.0997 69.7997 66.0997C71.0997 64.1997 71.5997 61.8997 71.0997 59.5997ZM23.5997 14.0997C23.2997 13.7997 22.9997 13.5997 22.5997 13.5997C22.1997 13.5997 21.7997 13.6997 21.4997 13.9997C21.1997 14.2997 20.9997 14.5997 20.9997 14.9997C20.9997 15.3997 21.0997 15.7997 21.3997 16.0997C21.4997 16.1997 21.4997 16.1997 21.4997 16.1997L31.8997 26.5997C27.5997 26.2997 20.9997 24.9997 16.4997 20.5997C11.0997 15.1997 10.4997 6.29974 10.3997 2.99974C14.2997 3.09974 22.7997 3.79974 27.9997 9.09974C32.3997 13.5997 33.6997 20.2997 33.9997 24.4997L23.5997 14.0997ZM49.5997 16.2997C50.1997 15.6997 50.1997 14.7997 49.5997 14.1997C49.2997 13.8997 48.8997 13.7997 48.4997 13.7997C48.0997 13.7997 47.6997 13.8997 47.3997 14.1997L37.1997 24.4997C37.4997 20.2997 38.7997 13.5997 43.1997 9.19974C48.3997 3.79974 56.8997 3.09974 60.7997 2.99974C60.6997 6.89974 59.9997 15.2997 54.6997 20.5997C50.2997 24.9997 43.5997 26.2997 39.2997 26.5997L49.5997 16.2997ZM68.1997 61.3997C68.1997 63.9997 66.4997 66.2997 63.8997 66.8997H7.19971C5.09971 66.2997 3.59971 64.6997 3.09971 62.5997C2.79971 60.8997 3.19971 59.1997 4.29971 57.7997C6.19971 55.3997 9.69971 54.9997 12.0997 56.8997C12.7997 57.3997 13.6997 57.2997 14.1997 56.5997C14.2997 56.3997 14.3997 56.1997 14.4997 55.8997C14.8997 53.3997 16.2997 51.1997 18.3997 49.6997C20.4997 48.1997 22.9997 47.6997 25.4997 48.0997C26.7997 48.2997 27.9997 48.7997 29.0997 49.4997C29.3997 49.6997 29.7997 49.7997 30.1997 49.6997C30.5997 49.5997 30.8997 49.3997 31.1997 48.9997C31.1997 48.8997 31.2997 48.8997 31.2997 48.7997C33.2997 44.5997 38.2997 42.7997 42.4997 44.7997C44.4997 45.7997 46.0997 47.4997 46.7997 49.5997C46.8997 49.9997 47.1997 50.2997 47.5997 50.4997C47.9997 50.6997 48.3997 50.6997 48.7997 50.5997C48.8997 50.5997 48.9997 50.4997 49.0997 50.4997C50.1997 49.8997 51.4997 49.5997 52.6997 49.4997C55.8997 49.4997 58.7997 51.5997 59.7997 54.5997C59.9997 55.2997 60.7997 55.6997 61.4997 55.5997C61.7997 55.5997 61.9997 55.4997 62.2997 55.4997C62.2997 55.4997 62.2997 55.4997 62.3997 55.4997C65.5997 55.7997 68.1997 58.2997 68.1997 61.3997Z" fill="#BFA272"/>
						<path d="M40.3992 51.2998H38.6992C37.8992 51.2998 37.1992 51.9998 37.1992 52.7998C37.1992 53.5998 37.8992 54.2998 38.6992 54.2998H40.3992C41.1992 54.2998 41.8992 53.5998 41.8992 52.7998C41.8992 51.9998 41.2992 51.2998 40.3992 51.2998Z" fill="#BFA272"/>
						<path d="M13.1004 59.9004L11.4004 60.0004C10.6004 60.0004 9.90039 60.7004 9.90039 61.5004C9.90039 62.3004 10.5004 62.9004 11.3004 63.0004H11.4004L13.2004 62.9004C13.6004 62.9004 14.0004 62.7004 14.3004 62.4004C14.6004 62.1004 14.7004 61.7004 14.7004 61.3004C14.6004 60.6004 13.9004 60.0004 13.1004 59.9004Z" fill="#BFA272"/>
						<path d="M26.5996 56.7002H25.0996C24.2996 56.7002 23.5996 57.4002 23.5996 58.2002C23.5996 59.0002 24.2996 59.7002 25.0996 59.7002H26.5996C27.3996 59.7002 28.0996 59.0002 28.0996 58.2002C28.0996 57.4002 27.4996 56.7002 26.5996 56.7002Z" fill="#BFA272"/>
						<path d="M58.5 56.7002H57C56.2 56.7002 55.5 57.4002 55.5 58.2002C55.5 59.0002 56.2 59.7002 57 59.7002H58.5C59.3 59.7002 60 59.0002 60 58.2002C60 57.4002 59.3 56.7002 58.5 56.7002Z" fill="#BFA272"/>
						<path d="M43.3008 60H41.8008C41.0008 60 40.3008 60.7 40.3008 61.5C40.3008 62.3 41.0008 63 41.8008 63H43.3008C44.1008 63 44.8008 62.3 44.8008 61.5C44.8008 60.7 44.2008 60 43.3008 60Z" fill="#BFA272"/>
					</svg>

					<div class="ecology__item-title">Почва</div>
					<div class="ecology__item-type"><?=$strSoil // Почва?></div>
					<div class="ecology__item-distance"></div>
				</div>
			</div>
		</div>
	</div>
</div>

<?if($arResult["arHouses"] && $arResult["arPlots"]):?>
 <div id="area">
	<div class="area-in-village page__content-list">
		<div class="container">
			<h2>Участки в этом посёлке</h2>
			<div class="list--grid">
				<?foreach ($arResult["arPlots"] as $id => $plot) { // dump($plot);
					$offerURL = '/kupit-uchastki/uchastok-'.$plot['ID'].'/';

					if ($plot["IMG"])
						array_unshift($arResult['PHOTO_VILLAGE'],$plot["IMG"]); // положим в начало

					shuffle($arResult['PHOTO_VILLAGE']);

					if (count($arResult['PHOTO_VILLAGE']) > 5)
						$arResult['PHOTO_VILLAGE'] = array_slice($arResult['PHOTO_VILLAGE'],0,5);

					$comparisonPlots = (in_array($plot['ID'],$arComparisonPlots)) ? 'Y' : 'N';
					$favoritesPlots = (in_array($plot['ID'],$arFavoritesPlots)) ? 'Y' : 'N';
					$comp_activePlots = ($comparisonPlots == 'Y') ? 'active' : '';
					$fav_activePlots = ($favoritesPlots == 'Y') ? 'active' : '';
					$comp_textPlots = ($comparisonPlots != 'Y') ? 'Добавить к сравнению' : 'Удалить из сравнения';
					$fav_textPlots = ($favoritesPlots != 'Y') ? 'Добавить в избранное' : 'Удалить из избранного';
				?>
				<div class="card-house">
					<div class="d-flex flex-wrap bg-white card-grid">
						<div class="card-house__photo photo">
							<div class="photo__buttons in_village">
			            <button title="<?= $comp_textPlots ?>" class="comparison-click <?= $comp_activePlots ?>" data-id="<?= $plot['ID'] ?>" data-cookie="comparison_plots">
			                <svg xmlns="http://www.w3.org/2000/svg" width="19.42" height="17.556" viewBox="0 0 19.42 17.556" class="inline-svg add-comparison">
			                    <g transform="translate(-1216.699 -36.35)">
			                        <path d="M0 0v16.139" class="s-1" transform="translate(1217.349 37)"/>
			                        <path d="M0 0v8.468" class="s-1" transform="translate(1233.321 37)"/>
			                        <g transform="translate(.586 .586)">
			                            <path d="M0 0v4.297" class="s-2" transform="translate(1232.735 48)"/>
			                            <path d="M0 0v4.297" class="s-2" transform="rotate(90 592.368 642.516)"/>
			                        </g>
			                        <path d="M0 0v13.215" class="s-1" transform="translate(1222.807 40.041)"/>
			                        <path d="M0 0v7.641" class="s-1" transform="translate(1228.265 45.499)"/>
			                    </g>
			                </svg>
			            </button>
			            <button title="<?= $fav_textPlots ?>" class="favorites-click <?= $fav_activePlots ?>" data-id="<?= $plot['ID'] ?>" data-cookie="favorites_plots">
			                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="21" viewBox="0 0 24 21" class="inline-svg add-heart">
			                    <g transform="translate(.05 -26.655)">
			                        <path d="M19.874 30.266a5.986 5.986 0 0 0-8.466 0l-.591.591-.6-.6a5.981 5.981 0 0 0-8.466-.009 5.981 5.981 0 0 0 .009 8.466l8.608 8.608a.614.614 0 0 0 .871 0l8.626-8.594a6 6 0 0 0 .009-8.47zm-.88 7.595L10.8 46.019l-8.169-8.172a4.745 4.745 0 1 1 6.71-6.71l1.036 1.036a.617.617 0 0 0 .875 0l1.027-1.027a4.748 4.748 0 0 1 6.715 6.715z" class="s-1"/>
			                        <circle cx="4.5" cy="4.5" r="4.5" class="s-2" transform="translate(14.96 26.655)"/>
			                        <g transform="translate(-1213.44 -18.727)">
			                            <path d="M0 0v4.297" class="s-3" transform="translate(1232.735 48)"/>
			                            <path d="M0 0v4.297" class="s-3" transform="rotate(90 592.368 642.516)"/>
			                        </g>
			                    </g>
			                </svg>
			            </button>
			        </div>
							<div class="owl-carousel card-photo__list">
								<?foreach ($arResult['PHOTO_VILLAGE'] as $value) {?>
									<img class="card-photo__item" src="<?=$value['src']?>" alt="" />
								<?}?>
							</div>
							<div class="photo__count"><span class="current">1</span> / <span class="count"><?=count($arResult['PHOTO_VILLAGE'])?></span>
							</div>
						</div>
						<div class="card-house__content">
							<div class="wrap-title">
								<div class="card-house__title">
									<a href="<?=$offerURL?>">Участок <?=round($plot['PLOTTAGE'])?> соток в посёлке <?=$arResult['NAME']?></a>
								</div>
							</div>
							<div class="card-house__inline">
								<svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8" class="inline-svg">
									<path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z" transform="translate(.15 -22.745)" />
								</svg>
								<div class="card-house__inline-title">
									Площадь участка:&nbsp;</div>
								<div class="card-house__inline-value"><?=$plot['PLOTTAGE']?> соток</div>
							</div>

							<?if($arResult['PROPERTIES'][REGION_CODE]['VALUE']):?>
			          <div class="card-house__area"><a href="/kupit-uchastki/<?=$arResult['PROPERTIES'][REGION_CODE]['VALUE_XML_ID']?>-rayon/"><?=$arResult['PROPERTIES'][REGION_CODE]['VALUE']?> район</a></div>
			        <?endif;?>

							<div class="offer-house__metro metro_no_top">
								<?if($arResult['PROPERTIES'][ROAD_CODE]['VALUE_ENUM_ID'][0]):?>
									<a class="metro z-index-1 highway-color" href="/kupit-uchastki/<?=$valEnumHW?>-shosse/">
										<span class="metro-color <?=$colorHW?>"></span>
										<span class="metro-name"><?=$nameHW?> шоссе</span>
									</a>
								<?endif;?>
								<a class="metro z-index-1" href="/kupit-uchastki/<?=$url_km_MKAD?>/">
									<span class="metro-other"><?=$km_MKAD?> км от <?=ROAD?></span>
								</a>
							</div>

							<div class="footer-card d-flex align-items-center">
								<div class="footer-card__price"><span class="split-number"><?=$plot['PRICE']?></span> <span class="rub_currency">&#8381;</span></div>
								<a class="btn btn-outline-warning rounded-pill" href="<?=$offerURL?>">Подробнее</a>
							</div>
						</div>
					</div>
				</div>
				<?}?>
			</div><a class="btn bg-white text-success w-100" href="/kupit-uchastki/v-poselke-<?=$arResult['CODE']?>/">
				Показать ещё
				<svg xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 12 7" class="inline-svg">
					<g transform="rotate(-90 59.656 59.156)">
						<path d="M113.258 5.441l4.915-4.915a.308.308 0 1 0-.436-.436L112.6 5.225a.307.307 0 0 0 0 .436l5.134 5.132a.31.31 0 0 0 .217.091.3.3 0 0 0 .217-.091.307.307 0 0 0 0-.436z" />
					</g>
				</svg></a>
		</div>
	</div>
 </div>
<?endif;?>

<div class="about about-home-portal bg-white">
	<div class="container">
		<div class="row">
			<div class="order-1 order-sm-0 col-12 d-sm-none">
				<h2 class="about-home-portal__title h2">Что нужно знать об&nbsp;этом&nbsp;поселке?</h2>
			</div>
			<div class="order-0 order-sm-1 col-sm-6 col-xl-5">
				<div class="video" id="video-gallery">
					<div class="video__background-color"></div>
					<div class="video__background" style="background: url(/assets/img/dron-bg.png) no-repeat center center;" id="openVideo">
					    <div class="video__background-title">Обзор поселка с дрона</div>
						<a href="https://www.youtube.com/watch?v=<?=$arResult['PROPERTIES']['VIDEO']['CODE_YB']?>" data-poster="/assets/img/content/video-bg-village.jpg">
							<svg xmlns="http://www.w3.org/2000/svg" width="102" height="102" viewBox="0 0 102 102" class="inline-svg play">
								<g transform="translate(-314 -1783)">
									<g>
										<circle cx="31" cy="31" r="31" transform="translate(334 1803)" class="circle-main-stroke" />
										<circle cx="27" cy="27" r="27" transform="translate(338 1807)" class="circle-main" />
										<g>
											<g transform="translate(324 1793)" fill="none" class="circle-line" stroke-linecap="round" stroke-width="1" stroke-dasharray="45">
												<circle cx="41" cy="41" r="41" stroke="none" />
												<circle cx="41" cy="41" r="40.5" fill="none" />
											</g>
											<g transform="translate(314 1783)" fill="none" class="circle-line" stroke-linecap="round" stroke-width="1" stroke-dasharray="45 10">
												<circle cx="51" cy="51" r="51" stroke="none" />
												<circle cx="51" cy="51" r="50.5" fill="none" />
											</g>
										</g>
										<path class="triangle" d="M17.779,8.1,6.13.071A.4.4,0,0,0,5.5.4V16.47a.4.4,0,0,0,.63.331l11.65-8.034a.4.4,0,0,0,0-.661Z" transform="translate(354.774 1826.564)" />
									</g>
								</g>
							</svg><img class="logo-white" src="/assets/img/site/logo-white.png" alt="Поселкино"></a>
					</div>
				</div>
			</div>
			<div class="order-2 order-sm-2 col-sm-6 col-xl-7 about-home-portal__block-right">
				<div class="d-none d-sm-block">
					<div class="about-home-portal__title h2">Что нужно знать об&nbsp;этом&nbsp;поселке?</div>
				</div>
				<div class="about-home-portal__text">
					<p itemprop="description"><?=$arResult["PREVIEW_TEXT"]; // Описание для анонса ?></p>
					<p><?=($arResult['PROPERTIES']['WHAT_KNOW']['VALUE']) ? $arResult['PROPERTIES']['WHAT_KNOW']['~VALUE']['TEXT'] : ''?></p>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="legal-information bg-light" style="padding: 60px 0;">
	<div class="container">
    <div class="row">
      <div class="col-lg-6">
        <div class="bg-white radius price price--village">
            <h2 class="h2">Краткая информация</h2>
            <div class="d-flex price__row">
                <div class="price__title w-auto mr-2">
                    Площадь поселка:
                </div>
                <div class="price__value"><?=$arResult['PROPERTIES']['AREA_VIL']['VALUE'] // Площадь поселка, Га?> га.</div>
            </div>
            <div class="d-flex price__row">
                <div class="price__title w-auto mr-2">
                    Количество участков:
                </div>
                <div class="price__value"><?=$arResult['PROPERTIES']['COUNT_PLOTS'.$nProp]['VALUE'] // Количество участков, ед.?></div>
            </div>
            <div class="d-flex price__row">
                <div class="price__title w-auto mr-2">
                    Количество проданных участков:
                </div>
                <div class="price__value"><?=$arResult['PROPERTIES']['COUNT_PLOTS_SOLD'.$nProp]['VALUE'] // Количество проданных участков, ед.?></div>
            </div>
            <div class="d-flex price__row">
                <div class="price__title w-auto mr-2">
                    Количество участков в продаже:
                </div>
                <div class="price__value"><?=$arResult['PROPERTIES']['COUNT_PLOTS_SALE'.$nProp]['VALUE'] // Количество участков в продаже, ед. ?></div>
            </div>
            <?if($arResult['PROPERTIES']['HOUSES_BUILD'.$nProp]['VALUE']){?>
            <div class="d-flex price__row">
                <div class="price__title w-auto mr-2">
                    Количество построенных домов:
                </div>
                <div class="price__value"><?=$arResult['PROPERTIES']['HOUSES_BUILD'.$nProp]['VALUE']?></div>
            </div>
            <?}?>
        </div>
      </div>

      <div class="col-lg-6 pt-5 pt-lg-0" id="price">
        <div class="bg-white radius price price--village">
            <h2 class="h2">Стоимость</h2>
            <div class="d-flex price__row">
                <div class="price__icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8" class="inline-svg">
                        <path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z" transform="translate(.15 -22.745)" />
                    </svg>
                </div>
                <div class="price__title">
                    Площадь участков:&nbsp;</div>
                <div class="price__value">от <?=$arResult['PROPERTIES']['PLOTTAGE'.$nProp]['VALUE'][0]?> до <?=$arResult['PROPERTIES']['PLOTTAGE'.$nProp]['VALUE'][1]?> соток</div>
            </div>
            <?if($housesValEnum != PROP_WITH_DOM){ // Только участки ?>
                <div class="d-flex price__row" itemscope itemtype="http://schema.org/AggregateOffer">
                    <div class="price__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="9.694" height="13.151" viewBox="0 0 9.694 13.151" class="inline-svg">
                            <path d="M.322-3.562H1.881V-9.8H5.376a5.858,5.858,0,0,1,2.142.348,4,4,0,0,1,1.437.921A3.475,3.475,0,0,1,9.763-7.2a4.929,4.929,0,0,1,.254,1.569A4.734,4.734,0,0,1,9.763-4.07a3.429,3.429,0,0,1-.808,1.3,3.876,3.876,0,0,1-1.437.892,6.16,6.16,0,0,1-2.142.329H4.324V-.124H7.63V1.811H4.324V3.351H1.881V1.811H.322V-.124H1.881V-1.552H.322Zm4.81,0a5.045,5.045,0,0,0,.949-.085,2.1,2.1,0,0,0,.78-.31,1.492,1.492,0,0,0,.526-.629,2.485,2.485,0,0,0,.188-1.043A2.689,2.689,0,0,0,7.386-6.7a1.666,1.666,0,0,0-.526-.686,2.068,2.068,0,0,0-.78-.357,4.157,4.157,0,0,0-.949-.1H4.324v4.284Z" transform="translate(-0.322 9.8)" fill="#3c4b5a" />
                        </svg>
                    </div>
                    <div class="price__title">
                        Стоимость участков:&nbsp;</div>
                    <div class="price__value">от <span class="split-number" itemprop="lowPrice"><?=formatPrice($arResult['PROPERTIES']['COST_LAND_IN_CART'.$nProp]['VALUE'][0])?></span> <span class="rub_currency">&#8381;</span> до <span class="split-number" itemprop="highPrice"><?=formatPrice($arResult['PROPERTIES']['COST_LAND_IN_CART'.$nProp]['VALUE'][1])?></span> <span class="rub_currency">&#8381;</span></div>
                </div>
                <div itemprop="offers" itemscope itemtype="http://schema.org/Offer" class="hide">
                    <meta itemprop="price" content="<?=formatPrice($arResult['PROPERTIES']['PRICE_SOTKA']['VALUE'][0]) // Цена за сотку мин?>">
                    <meta itemprop="priceCurrency" content="RUB">
                    <link itemprop="availability" href="http://schema.org/InStock">
                    <meta itemprop="priceValidUntil" content="2030-12-31">
                    <span itemprop="url"><?=$arResult["DETAIL_PAGE_URL"]?></span>
                </div>
            <?}?>
            <?if($housesValEnum != PROP_NO_DOM){ // Участки с домами ?>
                <div class="d-flex price__row">
                    <div class="price__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16.523" height="16.523" viewBox="0 0 16.523 16.523" class="inline-svg">
                            <path d="M16.523 1.614v13.3a1.615 1.615 0 0 1-1.614 1.614h-1.57a.645.645 0 1 1 0-1.291h1.571a.323.323 0 0 0 .323-.323V8.939h-5.7a.645.645 0 0 1 0-1.291h5.7V1.614a.323.323 0 0 0-.323-.323H7.618v1.893a.645.645 0 0 1-1.291 0V1.291H1.614a.323.323 0 0 0-.323.323v6h5.036V5.723a.645.645 0 0 1 1.291 0V10.8a.645.645 0 1 1-1.291 0V8.907H1.291v6a.323.323 0 0 0 .323.323h4.713v-1.891a.645.645 0 0 1 1.291 0v1.893H10.8a.645.645 0 1 1 0 1.291H1.614A1.615 1.615 0 0 1 0 14.909V1.614A1.615 1.615 0 0 1 1.614 0h13.3a1.615 1.615 0 0 1 1.609 1.614zm0 0" />
                        </svg>
                    </div>
                    <div class="price__title">
                        Площадь домов:&nbsp;</div>
                    <div class="price__value">от <?=$arResult['PROPERTIES']['HOUSE_AREA'.$nProp]['VALUE'][0]?> до <?=$arResult['PROPERTIES']['HOUSE_AREA'.$nProp]['VALUE'][1]?> м<sup>2</sup></div>
                </div>
                <div class="d-flex price__row">
                    <div class="price__icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="9.694" height="13.151" viewBox="0 0 9.694 13.151" class="inline-svg">
                            <path d="M.322-3.562H1.881V-9.8H5.376a5.858,5.858,0,0,1,2.142.348,4,4,0,0,1,1.437.921A3.475,3.475,0,0,1,9.763-7.2a4.929,4.929,0,0,1,.254,1.569A4.734,4.734,0,0,1,9.763-4.07a3.429,3.429,0,0,1-.808,1.3,3.876,3.876,0,0,1-1.437.892,6.16,6.16,0,0,1-2.142.329H4.324V-.124H7.63V1.811H4.324V3.351H1.881V1.811H.322V-.124H1.881V-1.552H.322Zm4.81,0a5.045,5.045,0,0,0,.949-.085,2.1,2.1,0,0,0,.78-.31,1.492,1.492,0,0,0,.526-.629,2.485,2.485,0,0,0,.188-1.043A2.689,2.689,0,0,0,7.386-6.7a1.666,1.666,0,0,0-.526-.686,2.068,2.068,0,0,0-.78-.357,4.157,4.157,0,0,0-.949-.1H4.324v4.284Z" transform="translate(-0.322 9.8)" fill="#3c4b5a" />
                        </svg>
                    </div>
                    <div class="price__title">
                        Стоимость домов:&nbsp;</div>
                    <div class="price__value">от <span class="split-number"><?=formatPrice($arResult['PROPERTIES']['HOME_VALUE'.$nProp]['VALUE'][0])?></span> <span class="rub_currency">&#8381;</span> до <span class="split-number"><?=formatPrice($arResult['PROPERTIES']['HOME_VALUE'.$nProp]['VALUE'][1])?></span> <span class="rub_currency">&#8381;</span></div>
                </div>
            <?}?>
            <div class="d-flex price__row bg-white" itemscope itemtype="http://schema.org/AggregateOffer">
                <div class="price__title" style="width: 190px">
                    Цена за обустройство:&nbsp;</div>
                <div class="price__value"><?=$arResult['PROPERTIES']['PRICE_ARRANGE'.$nProp]['VALUE']?></div>
            </div>
            <?if($arResult["arHouses"] || $arResult["arPlots"]){
                $hrefAll = (!$arResult["arHouses"] && $arResult["arPlots"]) ? '/kupit-uchastki/v-poselke-'.$arResult['CODE'].'/' : '/kupit-dom/v-poselke-'.$arResult['CODE'].'/';?>
                <a class="text-success text-decoration-none font-weight-bold" href="<?=$hrefAll?>" title="Смотреть все предложения">
                    Посмотреть предложения&nbsp;
                    <svg xmlns="http://www.w3.org/2000/svg" width="6.847" height="11.883" viewBox="0 0 6.847 11.883" class="inline-svg price__icon">
                        <g transform="rotate(180 59.406 5.692)">
                            <path d="M113.258 5.441l4.915-4.915a.308.308 0 1 0-.436-.436L112.6 5.225a.307.307 0 0 0 0 .436l5.134 5.132a.31.31 0 0 0 .217.091.3.3 0 0 0 .217-.091.307.307 0 0 0 0-.436z" />
                        </g>
                    </svg></a>
            <?}?>
        </div>
      </div>
    </div>
  </div>
  <div class="container" style="margin-top: 45px;">
    <div class="radius bg-white w-100">
      <div class="row">
        <div class="col-12">
            <h2>Юридическая информация</h2>
        </div>
        <div class="col-xl-5 col-md-6 mb-3 mb-md-0">
            <?if($arResult['PROPERTIES']['SCRIN_EGRN']['VALUE']){ // Скрин ЕГРН онлайн
                $egrnIMG_res = CFile::ResizeImageGet($arResult['PROPERTIES']['SCRIN_EGRN']['VALUE'], array('width'=>600, 'height'=>600), BX_RESIZE_IMAGE_PROPORTIONAL_ALT);
                $egrnIMG = CFile::GetPath($arResult['PROPERTIES']['SCRIN_EGRN']['VALUE']);
            }else{
                $egrnIMG_res['src'] = '/assets/img/content/legal-info-village.png';
            }?>
            <div id="legalInformation"><a href="<?=$egrnIMG?>"><img class="w-100" src="<?=$egrnIMG_res['src']?>" alt="Скрин ЕГРН Онлайн"></a></div>
        </div>
        <div class="offset-xl-1 col-xl-6 col-md-6">
            <p>Категория земель: <?=$arResult['PROPERTIES']['LAND_CAT']['VALUE'] // Категория земель?></p>
            <p>Вид разрешенного использования: <?=$arResult['PROPERTIES']['TYPE_USE']['VALUE'] // Вид разрешенного использования?></p>
            <p>Юридическая форма: <?=$arResult['PROPERTIES']['LEGAL_FORM']['VALUE'] // Юридическая форма?></p>
            <p class="mt-2"><a class="font-weight-bold text-success text-decoration-none" href="<?=$arResult['PROPERTIES']['SRC_MAP']['VALUE'] // Ссылка на публичную карту?>" target="_blank" rel="nofollow">
                Посёлок на карте Росреестра&nbsp;
                <svg xmlns="http://www.w3.org/2000/svg" width="6.847" height="11.883" viewBox="0 0 6.847 11.883" class="inline-svg">
                    <g transform="rotate(180 59.406 5.692)">
                        <path d="M113.258 5.441l4.915-4.915a.308.308 0 1 0-.436-.436L112.6 5.225a.307.307 0 0 0 0 .436l5.134 5.132a.31.31 0 0 0 .217.091.3.3 0 0 0 .217-.091.307.307 0 0 0 0-.436z" />
                    </g>
                </svg></a>
            </p>
            <?if($arResult['PROPERTIES']['SITE']['VALUE'] && !$statusSold):?>
                <p class="w-100 mt-3">
                    Сайт поселка: <a href="<?=$arResult['PROPERTIES']['SITE']['VALUE']?>" class="text-success font-weight-bold" target="_blank" rel="dofollow"><?=$arResult['NAME']?></a>
                </p>
            <?endif;?>
            <? // dump($arResult['PROPERTIES']['DEVELOPER_ID']); // Девелопер ID
            $APPLICATION->IncludeComponent( // выводим девелопера
                'bitrix:catalog.brandblock',
                '.default',
                array(
                    'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
                    'IBLOCK_ID' => $arParams['IBLOCK_ID'],
                    'ELEMENT_ID' => $arResult['ID'],
                    'ELEMENT_CODE' => '',
                    'PROP_CODE' => $arParams['BRAND_PROP_CODE'],
                    'CACHE_TYPE' => $arParams['CACHE_TYPE'],
                    'CACHE_TIME' => $arParams['CACHE_TIME'],
                    'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
                    'WIDTH' => '200',
                    'HEIGHT' => '200',
                    'WIDTH_SMALL' => '200',
                    'HEIGHT_SMALL' => '200',
                    'CODE_DEVEL' => $arResult['PROPERTIES']['DEVELOPER_ID']['VALUE'] // передадим
                ),
                $component,
                array('HIDE_ICONS' => 'N')
            );?>
						<?/*?>
            <div class="social-card mt-sm-3">
                <div class="social-card__title mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="13.699" height="12.231" viewBox="0 0 13.699 12.231" class="inline-svg">
                        <path d="M13.554,31.467,9.64,27.553a.489.489,0,0,0-.833.344v1.957H7.094q-5.451,0-6.689,3.081A6.961,6.961,0,0,0,0,35.481a9.18,9.18,0,0,0,.971,3.448l.08.183q.057.13.1.229a.869.869,0,0,0,.1.168.261.261,0,0,0,.214.13.223.223,0,0,0,.18-.076.285.285,0,0,0,.065-.191,1.557,1.557,0,0,0-.019-.2,1.581,1.581,0,0,1-.019-.18q-.038-.52-.038-.94a6.507,6.507,0,0,1,.134-1.384,4.155,4.155,0,0,1,.371-1.059,2.659,2.659,0,0,1,.612-.772,3.589,3.589,0,0,1,.806-.531,4.372,4.372,0,0,1,1.017-.325,9.694,9.694,0,0,1,1.177-.164q.593-.046,1.342-.046H8.807v1.957a.487.487,0,0,0,.833.344l3.914-3.914a.48.48,0,0,0,0-.688Z"
                            transform="translate(0 -27.408)" fill="#919fa3" />
                    </svg>&nbsp;
                    Поделиться:
                </div>
                <div class="social-card__nav">
                    <div class="ya-share2" data-services="vkontakte,twitter,odnoklassniki,telegram"></div>
                </div>
            </div>
						<?*/?>
        </div>
      </div>
		</div>
	</div>
</div>
<div class="bg-white" style="padding-top: 60px; padding-bottom: 20px;">
    <div class="container">
        <div class="feedback-form" style="background: #f7fafc; padding: 30px; border-radius: 15px;">
            <div class="feedback-form__title pt-0">
                <h2>Записаться на просмотр</h2>
                <?if($arResult['PROPERTIES']['CONTACTS']['VALUE_XML_ID'] == 'tel' && $arResult['PROPERTIES']['PHONE']['VALUE'] && $arResult['DEVELOPERS'] && count($arResult['DEVELOPERS']) == 1){?>
                    <p>Позвоните по телефону <a href="tel:<?=$arResult['PROPERTIES']['PHONE']['VALUE']?>"><?=$arResult['PROPERTIES']['PHONE']['VALUE']?></a>, или заполните форму ниже</p>
                <?}else{?>
                    <p>Заполните форму ниже</p>
                <?}?>
            </div>
            <div class="feedback-form__body" style="padding: 15px 0;">
                <form action="" class="formSignToView">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="form-group"><input class="form-control nameSignToView ym-record-keys" id="request-name" type="text" name="review-name" placeholder="Ваше имя" required></div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group"><input class="form-control phone telSignToView ym-record-keys" id="request-phone" type="text" name="review-name" placeholder="Номер телефона" autocomplete="off" required></div>
                        </div>
                        <div class="col-lg-4">
                            <!-- <div class="form-group"><input class="form-control emailSignToView ym-record-keys" id="request-email" type="email" name="review-name" placeholder="Адрес электронной почты" required></div> -->
														<button class="btn btn-warning rounded-pill w-100" type="submit">Записаться на просмотр</button>
                        </div>
                        <div class="col-lg-8">
                            <div class="custom-control custom-checkbox custom-control-inline">
                                <input class="custom-control-input" id="privacy-policy-3" type="checkbox" name="privacy-policy" checked required>
                                <label class="custom-control-label" for="privacy-policy-3" style="font-size: 13px;"> Нажимая на кнопку, вы даете согласие на обработку персональных данных и соглашаетесь с&nbsp;
                                    <a href="/politika-konfidentsialnosti/" class="font-weight-bold" onclick="window.open('/politika-konfidentsialnosti/', '_blank'); return false;" title="Ознакомиться с политикой конфиденциальности">Политикой Конфиденциальности</a>
                                </label>
                            </div>
                        </div>
                        <!-- <div class="col-md-4 col-sm-8 pt-lg-2 pt-4">
                            <button class="btn btn-warning rounded-pill w-100" type="submit">Записаться на просмотр</button>
                        </div> -->
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="bg-white" id="block_reviews">
	<div class="review-list pt-3 pt-md-5">
		<div class="container">
			<div class="row mb-4">
				<div class="col-xl-9 col-md-8">
					<h3 class="h2">
						Отзывы&nbsp;<span class="text-secondary"><?=$arResult["CNT_COMMENTS"]?></span></h3>
				</div>
				<div class="col-xl-3 col-md-4 justify-content-end">
					<div class="review-list__average-rating text-left text-md-right">Средняя оценка пользователей:</div>
					<div class="wrap-raiting">
						<div class="card-house__raiting d-flex justify-content-md-end">
							<div class="line-raiting">
								<div class="line-raiting__star">
									<div class="line-raiting__star--wrap" style="width: <?=$arResult['RATING_TOTAL'] * 100 / 5; ?>%;"></div>
								</div>
								<div class="line-raiting__title"><?=$arResult["RATING_TOTAL"]?></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<ul class="nav nav-tabs" id="reviewList" role="tablist">
				<li class="nav-item"><a class="nav-link active" id="allReviews-tab" data-toggle="tab" href="#allReviews" role="tab" aria-controls="allReviews" aria-selected="true">Все отзывы</a></li>
				<li class="nav-item"><a class="nav-link" id="residentReviews-tab" data-toggle="tab" href="#residentReviews" role="tab" aria-controls="residentReviews" aria-selected="false">Отзывы жителей</a></li>
			</ul>
			<div class="tab-content" id="reviewListContent">
				<div class="tab-pane fade show active" id="allReviews" role="tabpanel" aria-labelledby="allReviews-tab">
					<div class="row">
						<?
						if (!$arResult["COMMENTS"]) echo '<div class="col-12"><h3>Пока здесь нет ни одного отзыва, Вы можете быть первым!</h3></div>';
						// выводим отзывы
						foreach($arResult["COMMENTS"] as $comment){
							$marker = ($comment["RESIDENT"]) ? true : false; // отзыв от жителя
							if (!$comment["FIO"]) $comment["FIO"] = 'Покупатель';
						?>
						<div class="col-md-6">
							<div class="review-card" itemprop="review" itemscope itemtype="http://schema.org/Review">
								<meta itemprop="itemReviewed" content="о поселке <?=$arResult['name']?>">
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
						<div class="col-12 mt-4 text-center">
							<div class="row">
								<div class="offset-lg-4 col-lg-4 offset-md-3 col-md-6 offset-sm-3 col-sm-6"><a class="btn btn-outline-warning rounded-pill w-100" href="/poselki/<?=$arResult["CODE"]?>/reviews/">Все отзывы</a></div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="residentReviews" role="tabpanel" aria-labelledby="residentReviews-tab">
					<div class="row">
						<?// выводим отзывы жителей
						foreach($arResult["COMMENTS_RES"] as $comment){?>
						<div class="col-md-6">
							<div class="review-card">
								<div class="review-card__user">
									<div class="review-card__user-avatar"></div>
									<div class="name"><?=$comment["FIO"]?></div>
									<div class="date"><?=$comment["DATE"]?></div>
									<div class="review-star">
										<div class="line-raiting">
											<div class="line-raiting__star">
												<div class="line-raiting__star--wrap" style="width: <?=$comment['RATING'] * 100 / 5; ?>%;"></div>
											</div>
											<div class="line-raiting__title"><?=$comment["RATING"]?></div>
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
									<p><?=$comment["TEXT"]?></p>
								</div>
							</div>
						</div>
						<?}?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="review-add">
		<div class="container">
			<div class="row">
				<div class="offset-xl-2 col-xl-8">
					<h3 class="h2 text-center">Оставить отзыв</h3>
					<form method="post" enctype="multipart/form-data" action="#" id="formSendReview">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<input class="form-control" id="review-name" type="text" name="review-name" placeholder="Ваше имя" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input class="form-control" id="review-surname" type="text" name="review-surname" placeholder="Фамилия">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<input class="form-control" id="review-email" type="email" name="review-email" placeholder="Адрес электронной почты" required>
								</div>
							</div>
							<div class="col-md-6">
								<div class="review-star">
									<label class="you-star">Ваша оценка:</label>
									<div class="star-list">
										<label for="star-5"></label>
										<input id="star-5" name="review-raiting" type="radio" value="5">
										<label for="star-4"></label>
										<input id="star-4" name="review-raiting" type="radio" value="4">
										<label for="star-3"></label>
										<input id="star-3" name="review-raiting" type="radio" value="3">
										<label for="star-2"></label>
										<input id="star-2" name="review-raiting" type="radio" value="2">
										<label for="star-1"></label>
										<input id="star-1" name="review-raiting" type="radio" value="1">
									</div>
									<div class="star-value"><span class="star-value__title">0</span>.0</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group quality quality-advantages">
									<button type="button"><svg xmlns="http://www.w3.org/2000/svg" width="18.523" height="18.523" viewBox="0 0 18.523 18.523" class="inline-svg">
										<path d="M9.262,0a9.262,9.262,0,1,0,9.262,9.262A9.272,9.272,0,0,0,9.262,0Zm4.453,9.974H9.974v3.918a.712.712,0,0,1-1.425,0V9.974H4.809a.712.712,0,1,1,0-1.425h3.74V4.987a.712.712,0,1,1,1.425,0V8.549h3.74a.712.712,0,0,1,0,1.425Z" fill="#78a86d" />
										</svg></button>
									<input class="form-control" id="review-advantages" type="text" name="review-advantages" placeholder="Достоинства">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group quality quality-disadvantages">
									<button type="button"><svg xmlns="http://www.w3.org/2000/svg" width="18.523" height="18.523" viewBox="0 0 18.523 18.523" class="inline-svg">
											<path d="M9.262,0a9.262,9.262,0,1,0,9.262,9.262A9.272,9.272,0,0,0,9.262,0Zm4.453,9.974H4.809a.712.712,0,1,1,0-1.425h8.905a.712.712,0,0,1,0,1.425Z" fill="#c66574" />
										</svg></button>
									<input class="form-control" id="review-disadvantages" type="text" name="review-disadvantages" placeholder="Недостатки">
								</div>
							</div>
							<div class="col-12">
								<div class="review-add__textarea">
									<textarea class="form-control" id="review-text" placeholder="Введите текст отзыва" name="review-text" required></textarea>
									<div class="custom-control custom-checkbox custom-control-inline">
										<input class="custom-control-input" id="review-resident" type="checkbox" name="review-resident" value="175">
										<label class="custom-control-label" for="review-resident">Отметьте, если вы житель поселка</label>
									</div>
								</div>
							</div>
						</div>
						<div class="row align-items-center">
							<div class="col-md-8 privacy-policy-label">
								<div class="custom-control custom-checkbox custom-control-inline">
									<input class="custom-control-input" id="privacy-policy-4" type="checkbox" name="privacy-policy" checked required>
									<label class="custom-control-label" for="privacy-policy-4">
										Нажимая на кнопку, вы даете согласие на обработку персональных данных и соглашаетесь с&nbsp; <a href="/politika-konfidentsialnosti/" onclick="window.open('/politika-konfidentsialnosti/', '_blank'); return false;" title="Ознакомиться с политикой конфиденциальности">Политикой Конфиденциальности</a></label>
								</div>
							</div>
							<div class="col-md-4 mt-4 mt-md-0">
								<button class="btn btn-warning rounded-pill w-100" type="submit">Оставить отзыв</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="high-raiting">
	<div class="container">
		<h2>Скорее всего вам будут интересны данные поселки:</h2>
		<div class="owl-carousel block-page__offer" id="raiting-area-home-slick">
			<?global $arrFilter;
			$arrFilter = [
				'!ID' => $arResult['ID'],
				'PROPERTY_DOMA' => $housesValEnum,
				'PROPERTY_SHOSSE' => $arResult['PROPERTIES'][ROAD_CODE]['VALUE_ENUM_ID'],
				'>=PROPERTY_MKAD' => $km_MKAD - 10,
				'<=PROPERTY_MKAD' => $km_MKAD + 10,
				'PROPERTY_GAS' => $arResult['PROPERTIES']['GAS']['VALUE_ENUM_ID'],
				'PROPERTY_PLUMBING' => $arResult['PROPERTIES']['PLUMBING']['VALUE_ENUM_ID'],
			];
			if($housesValEnum == PROP_NO_DOM){ // Только участки
				$percent = 20;
				$priceSotka1 = $arResult['PROPERTIES']['PRICE_SOTKA']['VALUE'][0];
				$priceSotka2 = $arResult['PROPERTIES']['PRICE_SOTKA']['VALUE'][1];
				$priceSotkaFrom = $priceSotka1 - ($priceSotka1 / 100 * $percent);
				$priceSotkaTo = $priceSotka2 + ($priceSotka2 / 100 * $percent);
				$arrFilter['>=PROPERTY_PRICE_SOTKA'] = $priceSotkaFrom;
				$arrFilter['<=PROPERTY_PRICE_SOTKA'] = $priceSotkaTo;
			}elseif($housesValEnum == PROP_WITH_DOM || $housesValEnum == PROP_HOUSE_PLOT){ // Участки с домами
				$percent = 20;
				$homeValue1 = $arResult['PROPERTIES']['HOME_VALUE']['VALUE'][0];
				$homeValue2 = $arResult['PROPERTIES']['HOME_VALUE']['VALUE'][1];
				$homeValueFrom = $homeValue1 - ($homeValue1 / 100 * $percent);
				$homeValueTo = $homeValue2 + ($homeValue2 / 100 * $percent);
				$arrFilter['>=PROPERTY_HOME_VALUE'] = $homeValueFrom;
				$arrFilter['<=PROPERTY_HOME_VALUE'] = $homeValueTo;
			}
			$arrFilter = [
				['LOGIC' => 'OR',
					['ID' => $arResult['PROPERTIES']['RECOM']['VALUE']],
					$arrFilter
				]
			]; // dump($arrFilter);
			// $arrFilter=array('PROPERTY_DOMA'=>3,'!PROPERTY_ACTION'=>false); // показывать только акции?>
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
<?if($arResult['PROPERTIES']['ACTION_TEXT']['VALUE']): // условия акции?>
	<div class="modal fade" id="action-widget" tabindex="-1" role="dialog" aria-labelledby="action-widget" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title mt-3" id="exampleModalLabel">Условия акции</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p><?=$arResult['PROPERTIES']['ACTION_TEXT']['VALUE']?></p>
				</div>
			</div>
		</div>
	</div>
<?endif?>
<div class="bg-white py-4">
	<div class="footer-feedback-village">
		<div class="container">
			<div class="row">
				<div class="col-lg-4 col-md-5 px-5"><img class="w-100 lazyload footer-feedback-village__img" src="/assets/img/content/feedback-village@2x.jpg" alt></div>
				<div class="col-xl-5 col-lg-6 col-md-7 footer-feedback-village__text">
					<div class="h1">Не нашли ничего&nbsp;подходящего?</div>
					<p>Оставьте заявку и мы совершенно бесплатно подберем для вас участок или дом в поселке!</p>
					<div class="d-flex footer-feedback-village__buttons"><a class="btn btn-warning rounded-pill mr-4" href="#" data-toggle="modal" data-target="#writeToUs" data-id-button='WRITE_TO_US_FOOT'>Оставить заявку</a></div>
				</div>
			</div>
		</div>
	</div>

<?if($arResult['PROPERTIES']['COORDINATES']['VALUE']):?>
	<script>
		// YaMapsShown = false;

		function showYaMaps(){
		 var script   = document.createElement("script");
		 // script.type  = "text/javascript";
		 script.src   = "https://api-maps.yandex.ru/2.1/?lang=ru_RU&apikey=0c55e225-bb2b-4b98-94a5-3390b6dbf643";
		 document.getElementById("YaMaps").appendChild(script);
		}

	  // Яндекс.Карты
		function loadMaps() {
	    ymaps.ready(function() {
	      var myMap = new ymaps.Map('villageMap', {
	        center: [<?=$arResult['PROPERTIES']['COORDINATES']['VALUE'] // Координаты поселка?>],
	        zoom: 12,
	        controls: ["zoomControl"]
	      });

	      var myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
					hintContent: '<?=$nameVil?>',
				}, {
	        preset: 'islands#redDotIcon'
	      });

	      myMap.geoObjects.add(myPlacemark);
	      myMap.behaviors.disable('scrollZoom');
	    });
		};

		$(document).ready(function () {
			// $('#btnLoadMap').click(function(){
			// 	$(this).hide();
			// 	$('.map-container .fill-bg').hide();
			// 	setTimeout(showYaMaps, 100);
			// 	setTimeout(loadMaps, 1000);
			// });
			 // $(window).scroll(function() {
			    // if (!YaMapsShown){
			     // if($(window).scrollTop() == 1000) {
						// console.log(2222);
			      // showYaMaps();
						setTimeout(showYaMaps, 100);
						setTimeout(loadMaps, 1000);
						// YaMapsShown = true;
			     // }
			    // }
			 // });
		});

		// setTimeout(loadMaps, 3000);
	</script>
<?endif;?>

<?php if (stripos(@$_SERVER['HTTP_USER_AGENT'], 'Lighthouse') === false): ?>

	<?$arVillageFB = ['gorki-layf','dmitrovka-lesnaya','lesnoy-bereg'];
	if(in_array($arResult['CODE'],$arVillageFB)):?>
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
	<?endif;?>

	<? // jivosite
	/*$jivositeCode = getInfoHW($idEnumHW)['JIVOSITE'];
	if($jivositeCode):?>
		<script src="//code-sb1.jivosite.com/widget/<?=$jivositeCode?>" async></script>
	<?endif;*/
	?>

<?endif;?>
