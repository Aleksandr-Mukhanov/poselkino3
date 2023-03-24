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
$km_MKAD = $arResult['PROPERTIES']['MKAD']['VALUE'];
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
	$INDUSTRIAL_ZONE_KM = $arResult['PROPERTIES']['INDUSTRIAL_ZONE_KM']['VALUE'];
	$industrialZone = (mb_strtolower($arResult['PROPERTIES']['INDUSTRIAL_ZONE']['VALUE']) != 'нет' && $INDUSTRIAL_ZONE_KM <= 1) ? true : false;
	// Полигон ТБО
	$LANDFILL_KM = $arResult['PROPERTIES']['LANDFILL_KM']['VALUE'];
	$landfill = (mb_strtolower($arResult['PROPERTIES']['LANDFILL']['VALUE']) == 'есть' && $LANDFILL_KM <= 3) ? true : false;

	$nameVil = $arResult['PROPERTIES']['TYPE']['VALUE'].' '.$name; // тип поселка

	if($housesValEnum == PROP_NO_DOM){ // Только участки
		$priceSotka = 'Сотка от <span class="split-number">'.formatPrice($arResult['PROPERTIES']['PRICE_SOTKA']['VALUE'][0]).'</span><span class="rep_rubl">руб.</span>';
	}elseif($housesValEnum == PROP_WITH_DOM || $housesValEnum == PROP_HOUSE_PLOT){ // Участки с домами
		$priceSotka = 'Дом от <span class="split-number">'.formatPrice($arResult['PROPERTIES']['HOME_VALUE']['VALUE'][0]).'</span><span class="rep_rubl">руб.</span>';
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
	$arComparison = []; $arFavorites = [];
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
        <?if($arResult['PROPERTIES']['REGION']['VALUE']):?>
          <a class="ml-4 area-link" href="/poselki/<?=$arResult['PROPERTIES']['REGION']['VALUE_XML_ID']?>-rayon/">
            <svg xmlns="http://www.w3.org/2000/svg" width="9.24" height="13.193" viewBox="0 0 9.24 13.193" class="inline-svg">
              <path d="M16.09 1.353a4.62 4.62 0 0 0-6.534 0 5.263 5.263 0 0 0-.435 6.494l3.7 5.346 3.7-5.339a5.265 5.265 0 0 0-.431-6.501zm-3.224 4.912a1.687 1.687 0 1 1 1.687-1.687 1.689 1.689 0 0 1-1.687 1.687z" transform="translate(-8.203)" />
            </svg><?=$arResult['PROPERTIES']['REGION']['VALUE'] // Район?> район</a>
        <?endif;?>
			</div>
		</div>
		<div class="order-2 order-md-1 col-xl-4 col-md-5 mt-4 mt-md-0">
			<div class="wrap-raiting" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
				<div class="card-house__raiting d-flex justify-content-md-end">
					<div class="line-raiting">
						<div class="line-raiting__star">
							<div class="line-raiting__star--wrap" style="width: <?= $arResult['ratingItogo'] * 100 / 5 ?>%;"></div>
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
					<a class="btn btn-outline-success rounded-pill" href="#price">Цены</a>
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
          <a class="dropdown-item" href="#price">Цены</a>
          <a class="dropdown-item" href="#mapShow">Как добраться</a>
					<a class="dropdown-item" href="#arrangement">Обустройство</a>
          <a class="dropdown-item" href="#block_reviews">Отзывы</a>
        </div>
      </div>

			<!-- Навигация-->
			<div class="slider-bottom-info">
			  <div class="d-none d-lg-flex">
			    <div class="nav page-nav nav-village anchor">
			      <a class="btn btn-outline-success rounded-pill" href="#price">Цены</a>
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
			<div class="plan--village px-0 d-flex flex-column align-items-start text-left" style="height: auto">
			  <h2 class="h2">План поселка</h2>
			  <?
			    $planIMG_res = CFile::ResizeImageGet($arResult['PROPERTIES']['PLAN_IMG'.$nProp]['VALUE'], array(), BX_RESIZE_IMAGE_EXACT);

			    if($arResult['PROPERTIES']['PLAN_IMG_IFRAME'.$nProp]['VALUE']){
		        $planIMG = $arResult['PROPERTIES']['PLAN_IMG_IFRAME'.$nProp]['VALUE'];
		        // $frame = 'data-iframe="true"';
						$frame = 'data-type="iframe"';
			    }else{
		        $planIMG = CFile::GetPath($arResult['PROPERTIES']['PLAN_IMG'.$nProp]['VALUE']);
		        $frame = '';
			    }
			  ?>
				<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/lg-zoom/1.3.0/lg-zoom.js"></script> openPlan -->
			  <div class="w-100">
					<?if($frame):?>
						<a data-src="<?=$planIMG?>" data-fancybox <?=$frame?> rel="nofollow">
				      <img class="w-100 mt-4" src="<?=$planIMG_res["src"]?>" alt="План поселка <?=$name?>" style="max-width: none; min-height: 468px; max-height: 45vh; object-fit: cover; object-position: top;">
				    </a>
					<?else:?>
						<a href="<?=$planIMG?>" data-fancybox <?=$frame?>>
				      <img class="w-100 mt-4" src="<?=$planIMG_res["src"]?>" alt="План поселка <?=$name?>" style="max-width: none; min-height: 468px; max-height: 45vh; object-fit: cover; object-position: top;">
				    </a>
					<?endif;?>
			  </div>
			</div>

		</div>
		<div class="order-3 order-md-3 col-xl-4 col-md-5">
			<div class="card-info card-info--village radius">

				<div class="row">
					<div class="col-12">
					    <div class="d-flex flex-wrap w-100 mb-1">
	                <?if($arResult['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][0]): // если есть шоссе
	                    $idEnumHW = $arResult['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][0];
	                    $valEnumHW = $arResult['PROPERTIES']['SHOSSE']['VALUE_XML_ID'][0];
	                    $colorHW = getColorRoad($idEnumHW);
	                    $nameHW = $arResult['PROPERTIES']['SHOSSE']['VALUE'][0];
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
                  <?if($arResult['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][1]): // если есть шоссе
                      $idEnumHW2 = $arResult['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][1];
                      $valEnumHW2 = $arResult['PROPERTIES']['SHOSSE']['VALUE_XML_ID'][1];
                      $colorHW2 = getColorRoad($idEnumHW2);
                      $nameHW2 = $arResult['PROPERTIES']['SHOSSE']['VALUE'][1];
                  ?>
                    <a class="metro z-index-1 highway-color pl-0" href="/poselki/<?=$valEnumHW2?>-shosse/">
                        <span class="metro-color <?=$colorHW2?>"></span>
                        <span class="metro-name"><?=$nameHW2?> шоссе</span>
                    </a>
                  <?endif;?>
									<?if($arResult['PROPERTIES']['SHOSSE_DOP']['VALUE'][0]): // если есть доп. шоссе
                      $valEnumHW2 = $arResult['PROPERTIES']['SHOSSE_DOP']['VALUE'][0];
											$idEnumHW2 = getNamesList($valEnumHW2,'SHOSSE')['ID'];
                      $colorHW2 = getColorRoad($idEnumHW2);
                      $nameHW2 = getNamesList($valEnumHW2,'SHOSSE')['NAME'];
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
				<?if($arResult['PROPERTIES']['CONTACTS']['VALUE_XML_ID'] == 'tel' && $arResult['PROPERTIES']['PHONE']['VALUE'] && count($arResult['DEVELOPERS']) == 1){?>
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
				<?if($arResult['PROPERTIES']['SITE']['VALUE']):
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
					<div class="map-container position-relative">
						<div id="villageMap" style="width: 100%; height: 100%;"></div>
						<div id="villageMapBalliin">
							<div class="map-baloon">
								<a href="/poselki/<?=$url_km_MKAD?>/"><span class="metro-other" style="margin-left: 0;"><?=$km_MKAD?> км от <?=ROAD?></span></a><br>
								<?if($arResult['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][0]): // если есть шоссе ?>
									<a href="/poselki/<?=$valEnumHW?>-shosse/" class="highway-color">
										<span class="metro-color <?=$colorHW?>"></span>
										<span class="metro-name"><?=$nameHW?> шоссе</span></a>
								<?endif;?>
								<?if($arResult['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][1]): // если есть шоссе ?>
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
									<div class="value"><?=$arResult['PROPERTIES']['SETTLEM']['VALUE'] // Ближайший населенный пункт?>. Расстояние <?$SETTLEM_KM = $arResult['PROPERTIES']['SETTLEM_KM']['VALUE'];?><?=($SETTLEM_KM < 1) ? ($SETTLEM_KM*1000).' м' : $SETTLEM_KM.' км' // Ближайший населенный пункт расстояние, км?></div>
								</div>
								<div class="text-block">
									<div class="title">Ближайший город:</div>
									<div class="value"><?=$arResult['PROPERTIES']['TOWN']['VALUE'] // Ближайший город?>. Расстояние <?$TOWN_KM = $arResult['PROPERTIES']['TOWN_KM']['VALUE'];?><?=($TOWN_KM < 1) ? ($TOWN_KM*1000).' м' : $TOWN_KM.' км' // Ближайший город расстояние, км?></div>
								</div>
								<div class="text-block">
									<div class="title">Ближайшая ж/д станция:</div>
									<div class="value"><?=$arResult['PROPERTIES']['RAILWAY']['VALUE'] // Ближайший ж/д станция?>.<br>Расстояние до станции <?$RAILWAY_KM = $arResult['PROPERTIES']['RAILWAY_KM']['VALUE'];?><?=($RAILWAY_KM < 1) ? ($RAILWAY_KM*1000).' м' : $RAILWAY_KM.' км' //Ближайшая ж/д станция расстояние до поселка, км?></div>
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
									<div class="map-block__info">ст. отправления <?=$nameStation?>, <b><?$BUS_TIME_KM = $arResult['PROPERTIES']['BUS_TIME_KM']['VALUE'];?><?=($BUS_TIME_KM < 1) ? ($BUS_TIME_KM*1000).' м' : $BUS_TIME_KM.' км' // Автобус (расстояние от остановки, км)?></b> от&nbsp;остановки</div>
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
<div class="p-b-60 container <?if(count($arResult['DEVELOPERS']) == 1)echo 'mt-3 mt-md-5';?>" id="description">
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
					$offerURL = '/doma/'.$arResult['CODE'].'-dom-'.$house['ID'].'/';?>
				<div class="card-house">
					<div class="d-flex flex-wrap bg-white card-grid">
						<div class="card-house__photo photo">
							<div class="card-photo__list">
								<?foreach ($house['IMG'] as $value) {?>
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
			</div><a class="btn bg-white text-success w-100" href="/doma/v-poselke-<?=$arResult['CODE']?>/">
				Показать ещё
				<svg xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 12 7" class="inline-svg">
					<g transform="rotate(-90 59.656 59.156)">
						<path d="M113.258 5.441l4.915-4.915a.308.308 0 1 0-.436-.436L112.6 5.225a.307.307 0 0 0 0 .436l5.134 5.132a.31.31 0 0 0 .217.091.3.3 0 0 0 .217-.091.307.307 0 0 0 0-.436z" />
					</g>
				</svg></a>
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
					shuffle($arResult['PHOTO_VILLAGE']);?>
				<div class="card-house">
					<div class="d-flex flex-wrap bg-white card-grid">
						<div class="card-house__photo photo">
							<div class="card-photo__list">
								<?foreach ($arResult['PHOTO_VILLAGE'] as $value) {?>
									<div class="card-photo__item" style="background: url(<?=$value['src']?>) center center / cover no-repeat; width: 495px;"></div>
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

							<?if($arResult['PROPERTIES']['REGION']['VALUE']):?>
			          <div class="card-house__area"><a href="/kupit-uchastki/<?=$arResult['PROPERTIES']['REGION']['VALUE_XML_ID']?>-rayon/"><?=$arResult['PROPERTIES']['REGION']['VALUE']?> район</a></div>
			        <?endif;?>

							<div class="offer-house__metro metro_no_top">
								<?if($arResult['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][0]):?>
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
								<div class="footer-card__price"><span class="split-number"><?=$plot['PRICE']?></span> <span class="rep_rubl">руб.</span></div>
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
					<?if(in_array('Охрана', $arResult['PROPERTIES']['ARRANGE']['VALUE'])){ // Обустройство поселка: Охрана?>
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
					<?if(in_array('Огорожен', $arResult['PROPERTIES']['ARRANGE']['VALUE'])){ // Обустройство поселка: Огорожен?>
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
					<?if(in_array('Нет', $arResult['PROPERTIES']['ARRANGE']['VALUE'])){ // Обустройство поселка: Нет?>
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
						<?if(count($rad5km) == 0){?>
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
				<div class="ecology__item radius" style="background: url(/assets/img/content/forest.jpg) no-repeat center center; background-size: cover;">
					<div class="ecology__card-img">
						<div class="ecology__card-img-title">Лес</div>
						<div class="ecology__card-img-type"><?=$LES?></div>
						<div class="ecology__card-img-distance"><?if($FOREST_KM):?>расстояние <?=($FOREST_KM < 1) ? ($FOREST_KM*1000).' м' : $FOREST_KM.' км'?><?endif;?></div>
					</div>
				</div>
			</div>
			<?endif;?>
			<div class="col-lg-3 col-sm-6">
				<div class="ecology__item radius" style="background: url(/assets/img/content/landscape.jpg) no-repeat center center; background-size: cover;">
					<div class="ecology__card-img">
						<div class="ecology__card-img-title">Ландшафт</div>
						<div class="ecology__card-img-type"><?=$landscape?></div>
						<div class="ecology__card-img-distance"></div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="ecology__item radius" style="background: url(/assets/img/content/water.jpg) no-repeat center center; background-size: cover;">
					<div class="ecology__card-img">
						<div class="ecology__card-img-title">Водоем</div>
						<div class="ecology__card-img-type"><?=$strWater // Водоем?></div>
						<div class="ecology__card-img-distance"><?if(mb_strtolower($strWater) != 'нет'):?>расстояние <?$WATER_KM = $arResult['PROPERTIES']['WATER_KM']['VALUE']?><?=($WATER_KM < 1) ? ($WATER_KM*1000).' м' : $WATER_KM.' км' // Водоем расстояние, км?><?endif;?></div>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-sm-6">
				<div class="ecology__item radius" style="background: url(/assets/img/content/soil.jpg) no-repeat center center; background-size: cover;">
					<div class="ecology__card-img">
						<div class="ecology__card-img-title">Почва</div>
						<div class="ecology__card-img-type"><?=$strSoil // Почва?></div>
						<div class="ecology__card-img-distance"></div>
					</div>
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
					shuffle($arResult['PHOTO_VILLAGE']);?>
				<div class="card-house">
					<div class="d-flex flex-wrap bg-white card-grid">
						<div class="card-house__photo photo">
							<div class="card-photo__list">
								<?foreach ($arResult['PHOTO_VILLAGE'] as $value) {?>
									<div class="card-photo__item" style="background: url(<?=$value['src']?>) center center / cover no-repeat; width: 495px;"></div>
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

							<?if($arResult['PROPERTIES']['REGION']['VALUE']):?>
			          <div class="card-house__area"><a href="/kupit-uchastki/<?=$arResult['PROPERTIES']['REGION']['VALUE_XML_ID']?>-rayon/"><?=$arResult['PROPERTIES']['REGION']['VALUE']?> район</a></div>
			        <?endif;?>

							<div class="offer-house__metro metro_no_top">
								<?if($arResult['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][0]):?>
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
								<div class="footer-card__price"><span class="split-number"><?=$plot['PRICE']?></span> <span class="rep_rubl">руб.</span></div>
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
					<p itemprop="description"><?=$arResult["PREVIEW_TEXT"]; // dump($arResult); // Описание для анонса ?></p>
					<p><?=$arResult['PROPERTIES']['WHAT_KNOW']['VALUE']['TEXT']?></p>
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
                    <div class="price__value">от <span class="split-number" itemprop="lowPrice"><?=formatPrice($arResult['PROPERTIES']['COST_LAND_IN_CART'.$nProp]['VALUE'][0])?></span> <span class="rep_rubl">руб.</span> до <span class="split-number" itemprop="highPrice"><?=formatPrice($arResult['PROPERTIES']['COST_LAND_IN_CART'.$nProp]['VALUE'][1])?></span> <span class="rep_rubl">руб.</span></div>
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
                    <div class="price__value">от <span class="split-number"><?=formatPrice($arResult['PROPERTIES']['HOME_VALUE'.$nProp]['VALUE'][0])?></span> <span class="rep_rubl">руб.</span> до <span class="split-number"><?=formatPrice($arResult['PROPERTIES']['HOME_VALUE'.$nProp]['VALUE'][1])?></span> <span class="rep_rubl">руб.</span></div>
                </div>
            <?}?>
            <div class="d-flex price__row bg-white" itemscope itemtype="http://schema.org/AggregateOffer">
                <div class="price__title" style="width: 190px">
                    Цена за обустройство:&nbsp;</div>
                <div class="price__value"><?=$arResult['PROPERTIES']['PRICE_ARRANGE'.$nProp]['VALUE']?></div>
            </div>
            <?if($arResult["arHouses"] || $arResult["arPlots"]){
                $hrefAll = (!$arResult["arHouses"] && $arResult["arPlots"]) ? 'area' : 'home';?>
                <a class="text-success text-decoration-none font-weight-bold" href="#<?=$hrefAll?>" title="Смотреть все предложения">
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
            <?if($arResult['PROPERTIES']['SITE']['VALUE']):?>
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
                <?if($arResult['PROPERTIES']['CONTACTS']['VALUE_XML_ID'] == 'tel' && $arResult['PROPERTIES']['PHONE']['VALUE'] && count($arResult['DEVELOPERS']) == 1){?>
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
		<div class="block-page__offer" id="raiting-area-home-slick">
			<?global $arrFilter;
			$arrFilter = [
				'!ID' => $arResult['ID'],
				'PROPERTY_DOMA' => $housesValEnum,
				'PROPERTY_SHOSSE' => $arResult['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'],
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

	<script type="text/javascript">
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

		setTimeout(loadMaps, 3000);
	</script>

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
