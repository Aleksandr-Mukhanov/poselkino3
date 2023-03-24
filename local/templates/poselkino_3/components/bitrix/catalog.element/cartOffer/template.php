<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 * @var string $templateFolder
 */

use Bitrix\Main\Grid\Declension;

$this->setFrameMode(true);

$templateLibrary = array('popup', 'fx');

$offerType = $_REQUEST['OFFER_TYPE'];
$offerName = ($offerType == 'plots') ? 'Участок' : 'Дом';
$offerNameM = ($offerType == 'plots') ? 'Участки' : 'Дома';
$offerPriceFor = ($offerType == 'plots') ? 'сотку' : 'кв.м.';

$name = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
$title = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_TITLE']
	: $arResult['NAME'];
$alt = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_DETAIL_PICTURE_FILE_ALT']
	: $arResult['NAME'];

if (!$arResult['PHOTO_VILLAGE'][0]) $arResult['PHOTO_VILLAGE'] = [];

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
// foreach ($arResult['PHOTO_VILLAGE'] as $key => $photo){
// 	 // $photoRes = CFile::ResizeImageGet($photo['ID'], array('width'=>3000, 'height'=>3000), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true, $arWaterMark);
// 	 $photoRes = CFile::ResizeImageGet($photo['ID'], array('width'=>1232, 'height'=>872), BX_RESIZE_IMAGE_EXACT, true, $arWaterMark);
// 	 $arResult['PHOTO_VILLAGE'][$key]['SRC'] = $photoRes['src'];
// 	 unset($photoRes);
// }

$offerPhoto = ($offerType == 'plots') ? $arResult['PHOTO_VILLAGE'] : $arResult['PROPERTIES']['DOP_PHOTO']['VALUE'];

// добавим превьюшку в фото
if ($arResult["PREVIEW_PICTURE"])
	array_unshift($offerPhoto,$arResult["PREVIEW_PICTURE"]); // положим в начало

foreach ($offerPhoto as $key => $photo){
	 $photoRes = CFile::ResizeImageGet($photo, array('width'=>1232, 'height'=>872), BX_RESIZE_IMAGE_EXACT, true, $arWaterMark);
	 $offerPhoto[$key] = $photoRes;
	 unset($photoRes);
}
if ($offerType == 'plots') shuffle($offerPhoto);

// км от МКАД
$km_MKAD = $arResult['arVillage']['MKAD'];
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

$plottage = ($offerType == 'plots') ? 'PLOTTAGE' : 'AREA_HOUSE';
$oneKVMetr = ($arResult['PROPERTIES'][$plottage]['VALUE']) ? round((int)$arResult['PROPERTIES']['PRICE']['VALUE'] / (int)$arResult['PROPERTIES'][$plottage]['VALUE']) : 0;
// выводим правильное окончание
$plottageDeclension = new Declension('сотка', 'сотки', 'соток');
$plottageText = ($offerType == 'plots') ? $plottageDeclension->get($arResult['PROPERTIES'][$plottage]['VALUE']) : 'кв.м.';

// План поселка
$nProp = '';
if($arResult['arVillage']['PLAN_IMG_IFRAME'.$nProp]){
	$planIMG = $arResult['arVillage']['PLAN_IMG_IFRAME'.$nProp];
	$frame = 'data-iframe="true"';
}else{
	$planIMG = CFile::GetPath($arResult['arVillage']['PLAN_IMG'.$nProp]);
	$frame = '';
}

if ($arResult['PROPERTIES']['ARRANGEMENT']['VALUE']) $priceArrange = formatPriceSite($arResult['PROPERTIES']['ARRANGEMENT']['VALUE']).' <span class="rep_rubl">руб.</span>';
$priceArrange = ($priceArrange) ? $priceArrange : $arResult['arVillage']['PRICE_ARRANGE'];
if (!$priceArrange) $priceArrange = 'Включено';

if ($offerType == 'plots')
	$h1 = $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'];
else
	$h1 = $arResult['NAME'];

if($offerType != 'plots')
{
	$finish = $arResult['PROPERTIES']['FINISH']['VALUE'];
	$house_disclaimer = $arResult['PROPERTIES']['TYPE']['VALUE'];
	$house_disclaimer_txt = ($arResult['PROPERTIES']['TYPE']['VALUE_XML_ID'] == 'ready') ? 'В стоимость входит дом и участок' : 'Цена указана за дом без участка';
}

// dump($_COOKIE); // разбираем куки

$cookieComparison = ($offerType == 'plots') ? 'comparison_plots' : 'comparison_houses';
$cookieFavorites = ($offerType == 'plots') ? 'favorites_plots' : 'favorites_houses';

$arComparison = []; $arFavorites = [];

if(isset($_COOKIE[$cookieComparison]))
	$arComparison = explode('-',$_COOKIE[$cookieComparison]);

if(isset($_COOKIE[$cookieFavorites]))
	$arFavorites = explode('-',$_COOKIE[$cookieFavorites]);

$comparison = (in_array($arResult['ID'],$arComparison)) ? 'Y' : 'N';
$favorites = (in_array($arResult['ID'],$arFavorites)) ? 'Y' : 'N';
$comp_active = ($comparison == 'Y') ? 'active' : '';
$fav_active = ($favorites == 'Y') ? 'active' : '';
$comp_text = ($comparison != 'Y') ? 'Добавить к сравнению' : 'Удалить из сравнения';
$fav_text = ($favorites != 'Y') ? 'Добавить в избранное' : 'Удалить из избранного';
?>
<div class="container mt-md-5">
	<div class="row">
	 <?if($finish || $house_disclaimer): // если есть отделка?>
			<div class="order-0 order-md-0 col-xl-8 col-md-7">
				<div class="page-title title_h2">
					<h1><?=$h1?></h1>
				</div>
			</div>
			<div class="col-xl-4 col-md-5 justify-content-end">
				<div class="active-sale justify-content-end">
					<div class="d-none d-md-inline-block">
						<?if($house_disclaimer):?>
							<div class="active-sale__badge disclaimer__badge">
								<span><?=$house_disclaimer?></span>
							</div>
						<?endif;?>
						<?if($finish):?>
							<div class="active-sale__badge">
								<span><?=$finish?></span>
							</div>
						<?endif;?>
					</div>
				</div>
			</div>
	 <?else:?>
		<div class="order-0 order-md-0 col-12">
			<div class="page-title title_h2">
				<h1><?=$h1?></h1>
			</div>
		</div>
	 <?endif;?>
		<div class="order-1 order-md-2 col-lg-8 col-md-7">
			<div class="village-slider">
				<?if($USER->IsAdmin()){?>
				<div class="slider__header">
					<div class="photo__buttons">
						<button title="<?=$comp_text?>" class="comparison-click <?=$comp_active?>" data-id="<?=$arResult['ID']?>" data-cookie="<?=$cookieComparison?>">
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
						<button title="<?=$fav_text?>" class="favorites-click <?=$fav_active?>" data-id="<?=$arResult['ID']?>" data-cookie="<?=$cookieFavorites?>">
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
				<?}?>
				<div class="village-slider__list" id="village-slider">
					<?foreach ($offerPhoto as $photo){ // Основные фото?>
						<div class="village-slider__item" style="background: #eee url('<?=$photo['src']?>') no-repeat; background-size: cover;"></div>
					<?}?>
				</div>
				<div class="village-slider__list-thumb" id="village-slider-thumb">
					<?foreach ($offerPhoto as $photo){ // Доп. фото?>
						<div class="village-slider__item-thumb" style="background: url('<?=$photo['src']?>') no-repeat; background-size: cover;"></div>
				  <?}?>
				</div>
			</div>
		 <?if($offerType == 'plots'): // если участок?>
			 <div class="home-info__slider-bottom justify-content-start">
				 <div class="home-info-col">
					 <div class="home-info-col__value"><?=$arResult['PROPERTIES']['PLOTTAGE']['VALUE']?> соток</div>
					 <div class="home-info-col__title">Площадь</div>
				 </div>
				 <div class="home-info-col">
					 <div class="home-info-col__value"><?=$arResult['PROPERTIES']['NUMBER']['VALUE']?></div>
					 <div class="home-info-col__title">Номер на плане</div>
				 </div>
				 <div class="home-info-col">
					<div class="home-info-col__value"><?=$priceArrange?></div>
					<div class="home-info-col__title">Цена за обустройство</div>
				</div>
				 <div class="home-info__slider-plan text-left text-lg-right ml-auto openPlan"><a class="text-success" href="<?=$planIMG?>" <?=$frame?>>План поселка</a></div>
			 </div>
		 <?else: // если дом
			 $plottage = ($arResult['PROPERTIES']['PLOTTAGE']['VALUE']) ? $arResult['PROPERTIES']['PLOTTAGE']['VALUE'].' сот.' : 'Любой';?>
			<div class="home-info__slider-bottom">
				<div class="home-info-col">
					<div class="home-info-col__value"><?=$arResult['PROPERTIES']['AREA_HOUSE']['VALUE']?> м<sup>2</sup></div>
					<div class="home-info-col__title">Площадь</div>
				</div>
				<div class="home-info-col">
					<div class="home-info-col__value"><?=$arResult['PROPERTIES']['FLOORS']['VALUE']?></div>
					<div class="home-info-col__title">Этажей</div>
				</div>
				<div class="home-info-col">
					<div class="home-info-col__value"><?=$arResult['PROPERTIES']['STAGE']['VALUE']?></div>
					<div class="home-info-col__title">Этап строительства</div>
				</div>
				<div class="home-info-col">
					<div class="home-info-col__value"><?=$plottage?></div>
					<div class="home-info-col__title">Участок дома</div>
				</div>
				<div class="home-info__slider-plan text-left text-sm-right openPlan"><a class="text-success" href="<?=$planIMG?>" <?=$frame?>>План поселка</a></div>
			</div>
			<p class="px-30 mt-4">
				Материал: <b class="d-block d-sm-inline"><?=$arResult['PROPERTIES']['MATERIAL']['VALUE']?></b></p>
		 <?endif;?>
			<div class="d-flex d-md-none w-100">
				<div class="card-info card-info--village card-info--home radius">
					<? // мобильная версия
					if($arResult['arVillage']['SHOSSE_ONE']['VALUE_ENUM_ID']): // если есть шоссе
						$idEnumHW = $arResult['arVillage']['SHOSSE_ONE']['VALUE_ENUM_ID'];
						$valEnumHW = $arResult['arVillage']['SHOSSE_ONE']['VALUE_XML_ID'];
						$colorHW = getColorRoad($idEnumHW);
						$nameHW = $arResult['arVillage']['SHOSSE_ONE']['VALUE'];?>
						<a class="metro z-index-1 highway-color" href="/kupit-uchastki/<?=$valEnumHW?>-shosse/">
							<span class="metro-color <?=$colorHW?>"></span>
							<span class="metro-name"><?=$nameHW?> шоссе</span></a>
					<?endif;?>
					<a class="metro z-index-1" href="/kupit-uchastki/<?=$url_km_MKAD?>/">
						<span class="metro-other"><?=$km_MKAD?> км от <?=ROAD?></span></a>
					<?if($arResult['arVillage']['REGION']):?>
						<a class="area-link" href="/kupit-uchastki/<?=$arResult['arVillage']['REGION_XML']?>-rayon/">
							<svg xmlns="http://www.w3.org/2000/svg" width="9.24" height="13.193" viewBox="0 0 9.24 13.193" class="inline-svg">
								<path d="M16.09 1.353a4.62 4.62 0 0 0-6.534 0 5.263 5.263 0 0 0-.435 6.494l3.7 5.346 3.7-5.339a5.265 5.265 0 0 0-.431-6.501zm-3.224 4.912a1.687 1.687 0 1 1 1.687-1.687 1.689 1.689 0 0 1-1.687 1.687z" transform="translate(-8.203)" />
							</svg><?=$arResult['arVillage']['REGION']?> р-н, <?=$arResult['arVillage']['SETTLEM']?></a>
					<?endif;?>
					<div class="price-main"><b><span class="split-number"><?=$arResult['PROPERTIES']['PRICE']['VALUE']?></span></b> <span class="rep_rubl">руб.</span></div>
					<div class="card-info__price"><span class="split-number"><?=$oneKVMetr?></span> <span class="rep_rubl">руб.</span> за 1 <?=$offerPriceFor?></div>
					<?if($arResult['PROPERTIES']['INS']['VALUE']){ // рассрочка?>
						<p><a class="text-success a__bold" data-toggle="modal" data-target="#bank-widget" href="#">Доступна рассрочка</a></p>
					<?}else{?><p></p><?}?>
          <?if($arResult['arVillage']['CONTACTS'] != 30 && $arResult['arVillage']['PHONE']){?>
          	<div class="phone-cart__block">
							<a href="tel:<?=$arResult['arVillage']['PHONE']?>"><?=$arResult['arVillage']['PHONE']?></a>
						</div>
						<a class="btn btn-warning rounded-pill w-100" href="#" data-toggle="modal" data-target="#feedbackModal" data-id-button='SIGN_UP_TO_VIEW' data-title='Записаться на просмотр'>Посмотреть <?=mb_strtolower($offerName)?></a>
          <?}else{?>
						<a class="btn btn-warning rounded-pill w-100" href="#" data-toggle="modal" data-target="#feedbackModal" data-id-button='SIGN_UP_TO_VIEW' data-title='Записаться на просмотр'>Посмотреть <?=mb_strtolower($offerName)?></a>
						<a class="btn btn-outline-warning rounded-pill w-100" href="#" data-toggle="modal" data-target="#writeToUs" data-id-button="WRITE_TO_US_FOOT">Задать вопрос</a>
					<?}?>
				</div>
			</div>
			<div class="home-description">
				<h2>Описание</h2>
				<?if($house_disclaimer):?>
					<p class="house_disclaimer"><img src="/assets/img/svg/alert-triangle.svg" alt=""><?=$house_disclaimer_txt?></p>
				<?endif;?>
				<p>Поселок <a href="/poselki/<?=$arResult['arVillage']['CODE']?>/" target="_blank" class="text-success a__bold"><?=$arResult['arVillage']['NAME']?></a></p>
				<p>Поселок расположен в <?=$km_MKAD?> км от <?=ROAD?> - <?=$arResult['arVillage']['SHOSSE']?> шоссе. Есть возможность добраться на личном авто и электричке.</p>
				<p><?=$arResult['PREVIEW_TEXT']?></p>
			</div>
			<div class="home-communication">
				<h2>Коммуникации</h2>
				<div class="row">
					<?if(mb_strtolower($arResult['arVillage']['ELECTRO']) == 'есть'):?>
					<div class="d-block col-sm-4">
						<div class="communication-card communication-card--light">
							<div class="communication-card__icon"><svg xmlns="http://www.w3.org/2000/svg" width="50.019" height="60" viewBox="0 0 50.019 60" class="inline-svg">
									<g transform="translate(-4.991)">
										<path d="M30.046,12.932A15.453,15.453,0,0,0,19.833,39.963c2.442,2.442,2.22,7.66,2.165,7.715a.919.919,0,0,0,.278.722,1.024,1.024,0,0,0,.666.278H37.095a.919.919,0,0,0,.666-.278,1.055,1.055,0,0,0,.278-.722c0-.056-.278-5.273,2.165-7.715l.167-.167A15.407,15.407,0,0,0,30.046,12.932ZM38.926,38.52c-.056.056-.167.167-.167.222-2.165,2.331-2.553,6.161-2.609,7.993H23.885c-.056-1.832-.444-5.828-2.775-8.215a13.515,13.515,0,1,1,17.817,0Z"
											fill="#78a86d" />
										<path d="M29.99,16.873a.944.944,0,0,0,0,1.887,10.1,10.1,0,0,1,10.1,10.1.944.944,0,1,0,1.887,0A11.939,11.939,0,0,0,29.99,16.873Z" fill="#78a86d" opacity="0.75" />
										<path d="M36.151,49.732H23.829a2.331,2.331,0,1,0,0,4.662H36.1a2.394,2.394,0,0,0,2.387-2.331A2.345,2.345,0,0,0,36.151,49.732Zm0,2.72H23.829a.438.438,0,0,1-.444-.444.409.409,0,0,1,.444-.444H36.1a.438.438,0,0,1,.444.444A.4.4,0,0,1,36.151,52.451Z"
											fill="#78a86d" />
										<path d="M34.319,55.338H25.661a2.331,2.331,0,1,0,0,4.662h8.659a2.345,2.345,0,0,0,2.331-2.331A2.31,2.31,0,0,0,34.319,55.338Zm0,2.72H25.661a.438.438,0,0,1-.444-.444.408.408,0,0,1,.444-.444h8.659a.444.444,0,0,1,0,.888Z" fill="#78a86d"
											opacity="0.8" />
										<path d="M29.99,8.326a.936.936,0,0,0,.944-.944V.944a.944.944,0,0,0-1.887,0V7.382A.973.973,0,0,0,29.99,8.326Z" fill="#78a86d" opacity="0.75" />
										<path d="M45.7,4.773A.9.9,0,0,0,44.421,5l-3.552,5.328a.914.914,0,0,0,.222,1.332.9.9,0,0,0,.5.167.886.886,0,0,0,.777-.444L45.92,6.05A.86.86,0,0,0,45.7,4.773Z" fill="#78a86d" opacity="0.75" />
										<path d="M18.723,11.6a.9.9,0,0,0,.5-.167A.972.972,0,0,0,19.5,10.1L16.059,4.718a.962.962,0,0,0-1.61,1.055l3.441,5.384A.921.921,0,0,0,18.723,11.6Z" fill="#78a86d" opacity="0.75" />
										<path d="M12.007,17.484,6.4,14.431a.977.977,0,0,0-1.277.389A.886.886,0,0,0,5.513,16.1l5.606,3.053a1.306,1.306,0,0,0,.444.111.916.916,0,0,0,.833-.5A.977.977,0,0,0,12.007,17.484Z" fill="#78a86d" opacity="0.75" />
										<path d="M54.912,14.82a.977.977,0,0,0-1.277-.389l-5.661,3.053a.977.977,0,0,0-.389,1.277.916.916,0,0,0,.833.5,1.046,1.046,0,0,0,.444-.111L54.523,16.1A.977.977,0,0,0,54.912,14.82Z" fill="#78a86d" opacity="0.75" />
									</g>
								</svg></div>
							<div class="communication-card__title">Свет</div>
								<?if($arResult['arVillage']['ELECTRO_KVT']){?>
									<div class="communication-card__text"><?=$arResult['arVillage']['ELECTRO_KVT']?> кВт на уч.</div>
								<?}elseif($arResult['arVillage']['ELECTRO_DONE']){?>
									<div class="communication-card__text"><?=$arResult['arVillage']['ELECTRO_DONE']?></div>
								<?}?>
						</div>
					</div>
					<?endif;?>
					<?if(mb_strtolower($arResult['arVillage']['GAS']) == 'есть'):?>
					<div class="d-block col-sm-4">
						<div class="communication-card communication-card--gas">
							<div class="communication-card__icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="55" height="60" viewBox="0 0 55 60" class="inline-svg">
									<defs>
										<clipPath>
											<rect width="55" height="60" transform="translate(79 1843)" fill="#fbb358" />
										</clipPath>
									</defs>
									<g transform="translate(-79 -1843)" opacity="0.75" clip-path="url(#clip-path)">
										<g transform="translate(88.5 1843)">
											<path d="M21,4H15a2,2,0,0,0-2,2V8a2,2,0,0,0,2,2h6a2,2,0,0,0,2-2V6a2,2,0,0,0-2-2ZM15,8V6h6V8Zm0,0" fill="#fbb358" />
											<path d="M24,0H12A3,3,0,0,0,9,3v9.191A11.012,11.012,0,0,0,0,23V45a11,11,0,0,0,5,9.208V56a4,4,0,0,0,4,4H27a4,4,0,0,0,4-4V54.208A11,11,0,0,0,36,45V23a11.011,11.011,0,0,0-9-10.809V3a3,3,0,0,0-3-3ZM11,3a1,1,0,0,1,1-1H24a1,1,0,0,1,1,1v9H11ZM29,55.249V56a2,2,0,0,1-2,2H9a2,2,0,0,1-2-2v-.751c.144.056.293.1.44.148s.266.095.4.136c.2.058.393.1.591.152.148.036.293.075.442.1.213.042.429.069.644.1.136.019.27.044.408.058.356.034.714.054,1.073.054H25c.359,0,.717-.02,1.073-.054.138-.014.272-.039.408-.058.215-.029.431-.056.644-.1.149-.03.294-.069.442-.1.2-.047.4-.094.591-.152.136-.041.269-.09.4-.136s.3-.092.442-.148ZM34,23V45a9.079,9.079,0,0,1-5.512,8.3c-.077.032-.158.056-.235.086-.256.1-.515.189-.779.264-.11.031-.221.058-.333.086q-.375.091-.759.151c-.1.015-.2.034-.307.047A9.181,9.181,0,0,1,25,54H11a9.185,9.185,0,0,1-1.075-.07c-.1-.013-.2-.032-.307-.047q-.384-.06-.759-.151c-.112-.028-.223-.055-.333-.086-.264-.075-.523-.165-.779-.264-.077-.03-.158-.054-.235-.086A9.078,9.078,0,0,1,2,45V23a9.011,9.011,0,0,1,9-9H25a9.011,9.011,0,0,1,9,9Zm0,0"
												fill="#fbb358" />
											<path d="M21.155,30.479c-1.8-1.446-3.355-2.7-3.355-4.2a1.742,1.742,0,0,1,.856-1.255,1.1,1.1,0,0,0,.4-1.3,1.119,1.119,0,0,0-1.179-.712c-3.6.43-5.281,4.694-5.281,7.44a7.175,7.175,0,0,0,1.291,3.7,4.09,4.09,0,0,1,.709,1.606c0,.9-.291.9-.6.9-.446,0-.671-.093-.734-.181a1.494,1.494,0,0,1,.077-1.078,1.053,1.053,0,0,0-.422-1.224,1.114,1.114,0,0,0-1.293.105A8.162,8.162,0,0,0,9,39.931C9,44.357,12.364,47,18,47s9-2.643,9-7.069C27,35.177,23.759,32.572,21.155,30.479ZM18,45c-2.614,0-7-.659-7-5.069a5.14,5.14,0,0,1,.6-2.346c.012.018.023.035.036.051A2.7,2.7,0,0,0,14,38.655c1.257,0,2.6-.76,2.6-2.9a5.3,5.3,0,0,0-.989-2.625A5.434,5.434,0,0,1,14.6,30.448a7.32,7.32,0,0,1,1.209-3.881c.15,2.3,2.067,3.844,4.093,5.471,2.506,2.015,5.1,4.1,5.1,7.893C25,44.341,20.614,45,18,45Zm0,0"
												fill="#fbb358" opacity="0.76" />
										</g>
									</g>
								</svg></div>
							<div class="communication-card__title">Газ</div>
							<div class="communication-card__text"><?=$arResult['arVillage']['PROVEDEN_GAZ']?></div>
						</div>
					</div>
					<?endif;?>
					<?if(mb_strtolower($arResult['arVillage']['PLUMBING']) == 'есть'):?>
					<div class="d-block col-sm-4">
						<div class="communication-card communication-card--water">
							<div class="communication-card__icon"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="55" height="60" viewBox="0 0 55 60" class="inline-svg">
									<g transform="translate(-688 -1843)">
										<g transform="translate(688 1846.417)">
											<path d="M5.621,38.958c-.388.682-3.788,6.716-3.788,9.625a4.583,4.583,0,0,0,9.167,0c0-2.909-3.4-8.943-3.788-9.625a.953.953,0,0,0-1.592,0Zm.8,12.375a2.75,2.75,0,0,1-2.75-2.75c0-1.621,1.593-5.031,2.75-7.247,1.157,2.216,2.75,5.626,2.75,7.247A2.75,2.75,0,0,1,6.417,51.333Zm0,0"
												fill="#919fa3" />
											<path d="M54.083,11h-5.5a.917.917,0,0,0-.917.917v2.75H35.348L33.985,9.835a.917.917,0,0,0-.883-.668H30.25V5.5h6.417a2.75,2.75,0,0,0,0-5.5H18.333a2.75,2.75,0,0,0,0,5.5H24.75V9.167H21.9a.917.917,0,0,0-.883.668l-1.363,4.832H11.917A11.93,11.93,0,0,0,0,26.583v7.333a.917.917,0,0,0,.917.917h11a.917.917,0,0,0,.917-.917V30.25a2.75,2.75,0,0,1,2.75-2.75h1.074c.811,4.159,4.859,7.333,9.722,7.333H28.62c4.865,0,8.911-3.174,9.722-7.333h9.324v2.75a.917.917,0,0,0,.917.917h5.5A.917.917,0,0,0,55,30.25V11.917A.917.917,0,0,0,54.083,11ZM17.417,2.75a.917.917,0,0,1,.917-.917H36.667a.917.917,0,1,1,0,1.833H18.333A.917.917,0,0,1,17.417,2.75ZM26.583,5.5h1.833V9.167H26.583ZM11,30.25V33H1.833V26.583A10.1,10.1,0,0,1,11.917,16.5h7.219l-2.585,9.167h-.967A4.589,4.589,0,0,0,11,30.25ZM28.62,33H26.38c-4.39,0-7.97-3.087-8.045-6.905L22.592,11h9.816l4.259,15.095C36.591,29.913,33.01,33,28.62,33Zm9.829-7.333L35.865,16.5h11.8v9.167Zm14.717,3.667H49.5v-16.5h3.667Zm0,0"
												fill="#919fa3" />
										</g>
									</g>
								</svg></div>
							<div class="communication-card__title">Вода</div>
							<div class="communication-card__text"><?=$arResult['arVillage']['PROVEDENA_VODA']?></div>
						</div>
					</div>
					<?endif;?>
				</div>
			</div>
			<div class="home-legal-information">
				<h2>Юридическая информация</h2>
				<p>Категория замель: <?=$arResult['arVillage']['LAND_CAT']?></p>
				<p>Вид разрешенного использования: <?=$arResult['arVillage']['TYPE_USE']?></p>
				<p>Юридическая форма: <?=$arResult['arVillage']['LEGAL_FORM']?></p>
				<?if($arResult['PROPERTIES']['CADASTRAL']['VALUE']):?>
					<p>Кадастровый номер: <?=$arResult['PROPERTIES']['CADASTRAL']['VALUE']?></p>
				<?endif;?>
				<p class="mt-2"><a class="font-weight-bold text-success text-decoration-none" href="<?=$arResult['arVillage']['SRC_MAP'] // Ссылка на публичную карту?>" target="_blank" rel="nofollow">
					Посёлок на карте Росреестра&nbsp;
					<svg xmlns="http://www.w3.org/2000/svg" width="6.847" height="11.883" viewBox="0 0 6.847 11.883" class="inline-svg">
						<g transform="rotate(180 59.406 5.692)">
							<path d="M113.258 5.441l4.915-4.915a.308.308 0 1 0-.436-.436L112.6 5.225a.307.307 0 0 0 0 .436l5.134 5.132a.31.31 0 0 0 .217.091.3.3 0 0 0 .217-.091.307.307 0 0 0 0-.436z" />
						</g>
					</svg></a>
				</p>
				<?if($arResult['arVillage']['SITE']):?>
					<p class="w-100 mt-3">
						Сайт поселка: <a href="<?=$arResult['arVillage']['SITE']?>" class="text-success font-weight-bold" target="_blank" rel="dofollow"><?=$arResult['arVillage']['NAME']?></a>
					</p>
				<?endif;?>
				<? // dump($arResult['arVillage']['DEVELOPER_ID']); // Девелопер ID
				/*
				$APPLICATION->IncludeComponent( // выводим девелопера
					'bitrix:catalog.brandblock',
					'cardHome',
					array(
						'IBLOCK_TYPE' => $arParams['IBLOCK_TYPE'],
						'IBLOCK_ID' => 1,
						'ELEMENT_ID' => $arResult['arVillage']['ID'],
						'ELEMENT_CODE' => '',
						'PROP_CODE' => ['DEVELOPER_ID'],
						'CACHE_TYPE' => $arParams['CACHE_TYPE'],
						'CACHE_TIME' => $arParams['CACHE_TIME'],
						'CACHE_GROUPS' => $arParams['CACHE_GROUPS'],
						'WIDTH' => '200',
						'HEIGHT' => '200',
						'WIDTH_SMALL' => '200',
						'HEIGHT_SMALL' => '200',
						'CODE_DEVEL' => $arResult['arVillage']['DEVELOPER_ID'] // передадим
					),
					$component,
					array('HIDE_ICONS' => 'N')
				);*/?>
				<div class="d-flex flex-wrap flex-md-nowrap text-left justify-content-start mt-3 mt-md-5 align-items-center">
				  <div class="d-block d-md-none mb-4 mb-md-0 w-100 text-left width-md-auto">
				    <a class="developer-logo mt-3 mt-md-0" href="/" target="_blank"><img src="/assets/img/logo_site.svg" alt="Посёлкино" width="200"></a>
				  </div>
				  <a class="btn btn-warning rounded-pill mb-3 mr-5" href="#" data-toggle="modal" data-target="#feedbackModal" data-id-button='LEAVE_REQUEST' data-title='Перезвоните мне'>Связаться с нами</a>
				  <a class="d-none d-md-inline developer-logo" href="/" target="_blank"><img src="/assets/img/logo_site.svg" alt="Посёлкино" width="200"></a>
				</div>
			</div>
			<div class="village-map page-map bg-white">
				<div class="container px-0">
					<h2>Карта</h2>
					<div class="map-container-page position-relative">
						<div id="villageMap" style="width: 100%; height: 100%;"></div>
					</div>
				</div>
				<div class="container mobile--margin-top px-0">
					<div class="row">
						<div class="col-md-6">
							<div class="map-block">
								<div class="map-block__icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="33.298" height="13.319" viewBox="0 0 33.298 13.319" class="inline-svg">
										<path d="M250.156,139.33h2.22a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33A.555.555,0,0,0,250.156,139.33Zm.555-3.33h1.11v2.22h-1.11Zm0,0" transform="translate(-235.172 -132.671)"
											fill="#3c4b5a" />
										<path d="M137.173,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM135.509,136h1.11v2.22h-1.11Zm0,0" transform="translate(-126.629 -132.671)" fill="#3c4b5a" />
										<path d="M60.376,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM58.711,136h1.11v2.22h-1.11Zm0,0" transform="translate(-54.272 -132.671)" fill="#3c4b5a" />
										<path d="M2.22,138.775v-3.33a.555.555,0,0,0-.555-.555H0V136H1.11v2.22H0v1.11H1.665A.555.555,0,0,0,2.22,138.775Zm0,0" transform="translate(0 -132.671)" fill="#3c4b5a" />
										<path d="M364.8,192.488h2.22v1.11H364.8Zm0,0" transform="translate(-343.712 -186.939)" fill="#3c4b5a" />
										<path d="M460.8,230.887h1.11V232H460.8Zm0,0" transform="translate(-434.162 -223.117)" fill="#3c4b5a" />
										<path d="M518.4,230.887h1.11V232H518.4Zm0,0" transform="translate(-488.43 -223.117)" fill="#3c4b5a" />
										<path d="M15.242,96.488H0V97.6H12.209v6.66H0v1.11H12.209v1.11H0v1.11H2.775a2.2,2.2,0,0,0,.308,1.11H0v1.11H33.3V108.7H26.885a2.2,2.2,0,0,0,.308-1.11H29.72a3.578,3.578,0,0,0,2.291-6.327l-3.718-3.1a7.23,7.23,0,0,0-4.62-1.673h-8.43ZM4.995,108.7a1.11,1.11,0,0,1-1.11-1.11H6.1A1.11,1.11,0,0,1,4.995,108.7Zm3.33,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,8.325,108.7Zm4.995-3.33h5.55v1.11h-5.55Zm-3.083,3.33a2.2,2.2,0,0,0,.308-1.11H22.754a2.2,2.2,0,0,0,.309,1.11Zm14.738,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,24.974,108.7Zm3.573-8.879,2.664,2.22H25.973a.555.555,0,0,1-.427-.2l-1.682-2.02h4.683Zm-8.567,5.55h5.55v-1.11h-5.55V97.6h3.693a6.118,6.118,0,0,1,3.508,1.11H23.864a1.11,1.11,0,0,0-.852,1.82l1.685,2.02a1.661,1.661,0,0,0,1.277.6h6.049a2.439,2.439,0,0,1-2.3,3.33H19.979Zm-1.11-7.77v6.66h-5.55V97.6Z"
											transform="translate(0 -96.488)" fill="#3c4b5a" />
									</svg>
								</div>
								<div class="map-block__text">
									<div class="map-block__title">На автомобиле:</div>
									<div class="map-block__info"><b><?=$arResult['arVillage']['AUTO_NO_JAMS']?></b> от <?=ROAD?>а без пробок</div>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="map-block">
								<div class="map-block__icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="33.298" height="13.319" viewBox="0 0 33.298 13.319" class="inline-svg">
										<path d="M250.156,139.33h2.22a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33A.555.555,0,0,0,250.156,139.33Zm.555-3.33h1.11v2.22h-1.11Zm0,0" transform="translate(-235.172 -132.671)"
											fill="#3c4b5a" />
										<path d="M137.173,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM135.509,136h1.11v2.22h-1.11Zm0,0" transform="translate(-126.629 -132.671)" fill="#3c4b5a" />
										<path d="M60.376,139.33a.555.555,0,0,0,.555-.555v-3.33a.555.555,0,0,0-.555-.555h-2.22a.555.555,0,0,0-.555.555v3.33a.555.555,0,0,0,.555.555ZM58.711,136h1.11v2.22h-1.11Zm0,0" transform="translate(-54.272 -132.671)" fill="#3c4b5a" />
										<path d="M2.22,138.775v-3.33a.555.555,0,0,0-.555-.555H0V136H1.11v2.22H0v1.11H1.665A.555.555,0,0,0,2.22,138.775Zm0,0" transform="translate(0 -132.671)" fill="#3c4b5a" />
										<path d="M364.8,192.488h2.22v1.11H364.8Zm0,0" transform="translate(-343.712 -186.939)" fill="#3c4b5a" />
										<path d="M460.8,230.887h1.11V232H460.8Zm0,0" transform="translate(-434.162 -223.117)" fill="#3c4b5a" />
										<path d="M518.4,230.887h1.11V232H518.4Zm0,0" transform="translate(-488.43 -223.117)" fill="#3c4b5a" />
										<path d="M15.242,96.488H0V97.6H12.209v6.66H0v1.11H12.209v1.11H0v1.11H2.775a2.2,2.2,0,0,0,.308,1.11H0v1.11H33.3V108.7H26.885a2.2,2.2,0,0,0,.308-1.11H29.72a3.578,3.578,0,0,0,2.291-6.327l-3.718-3.1a7.23,7.23,0,0,0-4.62-1.673h-8.43ZM4.995,108.7a1.11,1.11,0,0,1-1.11-1.11H6.1A1.11,1.11,0,0,1,4.995,108.7Zm3.33,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,8.325,108.7Zm4.995-3.33h5.55v1.11h-5.55Zm-3.083,3.33a2.2,2.2,0,0,0,.308-1.11H22.754a2.2,2.2,0,0,0,.309,1.11Zm14.738,0a1.11,1.11,0,0,1-1.11-1.11h2.22A1.11,1.11,0,0,1,24.974,108.7Zm3.573-8.879,2.664,2.22H25.973a.555.555,0,0,1-.427-.2l-1.682-2.02h4.683Zm-8.567,5.55h5.55v-1.11h-5.55V97.6h3.693a6.118,6.118,0,0,1,3.508,1.11H23.864a1.11,1.11,0,0,0-.852,1.82l1.685,2.02a1.661,1.661,0,0,0,1.277.6h6.049a2.439,2.439,0,0,1-2.3,3.33H19.979Zm-1.11-7.77v6.66h-5.55V97.6Z"
											transform="translate(0 -96.488)" fill="#3c4b5a" />
									</svg>
								</div>
								<div class="map-block__text">
									<div class="map-block__title">На электричке:</div>
									<div class="map-block__info">
										<b><?=$arResult['arVillage']['TRAIN_TRAVEL_TIME']?></b> от вокзала: <?=$arResult['arVillage']['TRAIN_VOKZAL']?><br>
										Стоимость одного проезда: <b><?=$arResult['arVillage']['TRAIN_PRICE']?> руб.</b><br>
										Стоимость такси: <b><?=$arResult['arVillage']['TRAIN_PRICE_TAXI']?> руб.</b></div>
									<?$trainIdYandex = $arResult['arVillage']['TRAIN_ID_YANDEX'];
									if($trainIdYandex):?>
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
						<div class="col-md-6">
							<div class="map-block">
								<div class="map-block__icon">
									<svg xmlns="http://www.w3.org/2000/svg" width="33.298" height="17.762" viewBox="0 0 33.298 17.762" class="inline-svg">
										<path d="M.555,16.027h2.83A2.765,2.765,0,0,0,8.325,17.12a2.766,2.766,0,0,0,4.939-1.093h11.21a2.775,2.775,0,0,0,5.439,0h2.83a.555.555,0,0,0,.555-.555V11.259a7.2,7.2,0,0,0-.2-1.669l-1.212-5.1a2.226,2.226,0,0,0-2.177-1.785H13.107L12.154.8a.555.555,0,0,0-.5-.307H3.885a.555.555,0,0,0-.5.307L2.432,2.708H.555A.555.555,0,0,0,0,3.263V15.472A.555.555,0,0,0,.555,16.027Zm5.55,1.11a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,6.1,17.137Zm4.44,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,10.544,17.137Zm16.649,0a1.665,1.665,0,1,1,1.665-1.665A1.665,1.665,0,0,1,27.194,17.137Zm4.828-7.291c.006.026.008.051.013.077H27.748V6.038h3.369ZM4.228,1.6h7.084l.555,1.11H3.673ZM1.11,3.818h28.6a1.119,1.119,0,0,1,1.093.912l.05.2H1.11Zm25.529,2.22V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923h-3.33V6.038Zm-4.44,0V9.923H9.989V6.038Zm-4.44,0V9.923H5.55V6.038Zm-7.77,0H4.44V9.923H1.11Zm0,7.215H2.22v-1.11H1.11v-1.11H32.175c0,.075.013.15.013.226v.884h-1.11v1.11h1.11v1.665H29.913a.147.147,0,0,0-.009-.029,2.745,2.745,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.872,2.872,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.862,2.862,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.166-.116a2.955,2.955,0,0,0-.278-.149c-.059-.028-.116-.055-.177-.083a2.755,2.755,0,0,0-.333-.1c-.056-.014-.107-.033-.164-.044a2.631,2.631,0,0,0-1.054,0c-.056.011-.111.03-.164.044a2.768,2.768,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.927,2.927,0,0,0-.278.149q-.083.055-.166.116a2.592,2.592,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.954,2.954,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.829,2.829,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.767,2.767,0,0,0-.144.462.137.137,0,0,1-.009.029h-11.2a.147.147,0,0,0-.009-.029,2.787,2.787,0,0,0-.144-.462c-.022-.056-.051-.1-.076-.154a2.871,2.871,0,0,0-.16-.294c-.035-.056-.076-.106-.115-.158a2.907,2.907,0,0,0-.2-.238c-.047-.049-.095-.1-.145-.142a2.624,2.624,0,0,0-.234-.193q-.083-.061-.167-.116a2.923,2.923,0,0,0-.277-.149c-.059-.028-.116-.055-.177-.083a2.727,2.727,0,0,0-.33-.1c-.056-.014-.107-.033-.166-.044a2.583,2.583,0,0,0-1.033,0l-.086.016a2.767,2.767,0,0,0-.451.14l-.082.036a2.791,2.791,0,0,0-.42.228l-.022.017a2.789,2.789,0,0,0-.357.295l-.056.051a2.778,2.778,0,0,0-.235.272,2.827,2.827,0,0,0-.242-.278c-.018-.018-.036-.034-.056-.051a2.81,2.81,0,0,0-.357-.295l-.022-.017a2.8,2.8,0,0,0-.42-.228L7.146,12.9a2.792,2.792,0,0,0-.451-.14l-.086-.016a2.581,2.581,0,0,0-1.033,0c-.056.011-.111.03-.164.044a2.716,2.716,0,0,0-.333.1c-.061.024-.118.056-.177.083a2.91,2.91,0,0,0-.275.149c-.055.037-.111.075-.166.116a2.627,2.627,0,0,0-.234.193c-.05.046-.1.092-.145.142a2.832,2.832,0,0,0-.2.238c-.039.052-.079.1-.115.158a2.809,2.809,0,0,0-.16.294c-.025.052-.056.1-.076.154a2.732,2.732,0,0,0-.144.462.147.147,0,0,1-.009.029H1.11Zm0,0"
											transform="translate(0 -0.488)" fill="#3c4b5a" />
										<path d="M230.4,202.09h11.1v1.11H230.4Zm0,0" transform="translate(-217.079 -190.435)" fill="#3c4b5a" />
									</svg>
								</div>
								<div class="map-block__text">
									<div class="map-block__title">На автобусе:</div>
									<?$BUS_TIME_KM = $arResult['arVillage']['BUS_TIME_KM'];?>
									<div class="map-block__info">ст. отправления <?=$arResult['arVillage']['BUS_VOKZAL']?>, <b><?=($BUS_TIME_KM < 1) ? ($BUS_TIME_KM*1000).' м' : $BUS_TIME_KM.' км'?></b> от&nbsp;остановки</div>
									<?if($trainIdYandex):?>
										<div class="map-block__link"><a class="text-success text-decoration-nont font-weight-bold" href="https://rasp.yandex.ru/station/<?=$trainIdYandex?>?span=day&type=bus&event=departure" target="_blank" rel="nofollow">
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
					</div>
				</div>
			</div>
			<div class="home-about-villiage">
				<h2>О поселке</h2>
				<div class="row mt-4">
					<div class="d-block col-md-4"><a class="stretched-link" href="/poselki/<?=$arResult['arVillage']['CODE']?>/" target="_blank"></a>
						<div class="offer-card" style="background-color: #F2F8FD;">
							<div class="offer-card__icon">
								<img class="inline-svg" src="/assets/img/site/city.svg">
							</div>
							<div class="offer-card__title">Обустройство поселка</div>
						</div>
					</div>
					<div class="d-block col-md-4"><a class="stretched-link" href="/poselki/<?=$arResult['arVillage']['CODE']?>/#ecologyBlock" target="_blank"></a>
						<div class="offer-card" style="background-color: #F1F8EF;">
							<div class="offer-card__icon">
								<img class="inline-svg" src="/assets/img/site/eco.svg">
							</div>
							<div class="offer-card__title">Экология и природа</div>
						</div>
					</div>
					<div class="d-block col-md-4"><a class="stretched-link" href="/poselki/<?=$arResult['arVillage']['CODE']?>/#mapShow" target="_blank"></a>
						<div class="offer-card" style="background-color: #F6F5FA;">
							<div class="offer-card__icon">
								<img class="inline-svg" src="/assets/img/site/navigation.svg">
							</div>
							<div class="offer-card__title">Как добраться</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="order-2 order-md-3 col-lg-4 col-md-5">
			<div class="d-none d-md-block h-100">
				<div class="card-info card-info--village card-info--home radius">
					<? // десктопная версия
					if($arResult['arVillage']['SHOSSE_ONE']['VALUE_ENUM_ID']): // если есть шоссе
						$idEnumHW = $arResult['arVillage']['SHOSSE_ONE']['VALUE_ENUM_ID'];
						$valEnumHW = $arResult['arVillage']['SHOSSE_ONE']['VALUE_XML_ID'];
						$colorHW = getColorRoad($idEnumHW);
						$nameHW = $arResult['arVillage']['SHOSSE_ONE']['VALUE'];?>
						<a class="metro z-index-1 highway-color" href="/kupit-uchastki/<?=$valEnumHW?>-shosse/">
							<span class="metro-color <?=$colorHW?>"></span>
							<span class="metro-name"><?=$nameHW?> шоссе</span></a>
					<?endif;?>
					<a class="metro z-index-1" href="/kupit-uchastki/<?=$url_km_MKAD?>/">
						<span class="metro-other"><?=$km_MKAD?> км от <?=ROAD?></span></a>
					<?if($arResult['arVillage']['REGION']):?>
						<a class="area-link" href="/kupit-uchastki/<?=$arResult['arVillage']['REGION_XML']?>-rayon/">
							<svg xmlns="http://www.w3.org/2000/svg" width="9.24" height="13.193" viewBox="0 0 9.24 13.193" class="inline-svg">
								<path d="M16.09 1.353a4.62 4.62 0 0 0-6.534 0 5.263 5.263 0 0 0-.435 6.494l3.7 5.346 3.7-5.339a5.265 5.265 0 0 0-.431-6.501zm-3.224 4.912a1.687 1.687 0 1 1 1.687-1.687 1.689 1.689 0 0 1-1.687 1.687z" transform="translate(-8.203)" />
							</svg><?=$arResult['arVillage']['REGION']?> р-н, <?=$arResult['arVillage']['SETTLEM']?></a>
					<?endif;?>
					<div class="price-main"><b><span class="split-number"><?=$arResult['PROPERTIES']['PRICE']['VALUE']?></span></b> <span class="rep_rubl">руб.</span></div>
					<div class="card-info__price"><span class="split-number"><?=$oneKVMetr?></span> <span class="rep_rubl">руб.</span> за 1 <?=$offerPriceFor?></div>
					<?if($arResult['PROPERTIES']['INS']['VALUE']){ // рассрочка?>
						<p><a class="text-success a__bold" data-toggle="modal" data-target="#bank-widget" href="#">Доступна рассрочка</a></p>
					<?}else{?><p></p><?}?>
					<?if($arResult['arVillage']['CONTACTS'] != 30 && $arResult['arVillage']['PHONE']){?>
          	<div class="phone-cart__block">
							<a href="tel:<?=$arResult['arVillage']['PHONE']?>"><?=$arResult['arVillage']['PHONE']?></a>
						</div>
						<a class="btn btn-warning rounded-pill w-100" href="#" data-toggle="modal" data-target="#feedbackModal" data-id-button='SIGN_UP_TO_VIEW' data-title='Записаться на просмотр'>Посмотреть <?=mb_strtolower($offerName)?></a>
          <?}else{?>
						<a class="btn btn-warning rounded-pill w-100" href="#" data-toggle="modal" data-target="#feedbackModal" data-id-button='SIGN_UP_TO_VIEW' data-title='Записаться на просмотр'>Посмотреть <?=mb_strtolower($offerName)?></a>
						<a class="btn btn-outline-warning rounded-pill w-100" href="#" data-toggle="modal" data-target="#writeToUs" data-id-button="WRITE_TO_US_FOOT">Задать вопрос</a>
					<?}?>

					<input type="hidden" id="posInfo" data-namePos='<?=$arResult['arVillage']['NAME']?>' data-codePos='<?=$arResult['arVillage']['CODE']?>' data-highwayPos='<?=$nameHW?>' data-idPos='<?=$arResult['arVillage']['ID']?>' data-cntPos='<?=$arResult['arVillage']['UP_TO_VIEW']?>' data-manager='<?=$arResult['arVillage']['MANAGER']?>'>

				</div>
			</div>
		</div>
	</div>
</div>
<div class="modal fade" id="bank-widget" tabindex="-1" role="dialog" aria-labelledby="bank-widget" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title mt-3" id="exampleModalLabel">Заголовок</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?=$arResult['PROPERTIES']['INS_TERMS']['VALUE']?>
			</div>
		</div>
	</div>
</div>
</div>
<div class="container">
<?if($arResult["arOffers"]):?>
	<div class="block-page">
		<h2><?=$offerNameM?> в этом поселке</h2>
		<div class="card-house-carousel house-in-village area-in-village" id="house_in_village">
			<?foreach ($arResult["arOffers"] as $id => $house) {?>
				<div class="item mr-4">
          <!-- Ссылка карточки-->
          <div class="offer-house__item card-house house-in-village">
            <div class="photo offer-house__photo">
              <div class="photo__list">
								<?foreach ($house['IMG'] as $key => $value) {?>
									<div class="photo__item" style="background: url('<?=$value['src']?>') no-repeat; background-size: cover; background-position: center center;"></div>
								<?}?>
              </div>
              <div class="photo__count"><span class="current">1</span> / <span class="count"><?=count($house['IMG'])?></span>
              </div>
            </div>
            <div class="offer-house__info card-house__content px-3">
              <div class="offer-house__title">
								<a href="<?=$house['URL']?>">
									<?if($offerType == 'plots'):?>
										<?=$offerName?> <?=round($house['PLOTTAGE'])?> соток в посёлке <?=$arResult['arVillage']['NAME']?>
									<?else:?>
										<?=$house['NAME']?>
									<?endif;?>
								</a>
							</div>

							<?if($arResult['arVillage']['REGION']):?>
								<div class="offer-house__area">
									<a href="/kupit-uchastki/<?=$arResult['arVillage']['REGION_XML']?>-rayon/"><?= $arResult['arVillage']['REGION']?> район</a>
								</div>
							<?endif;?>

							<?if($arResult['arVillage']['SHOSSE_ONE']['VALUE_ENUM_ID']):?>
								<div class="card-house__metro mt-2 mt-lg-3 metro_no_top">
									<div class="d-flex flex-wrap w-100 mt-1 mt-lg-2">
										<a class="metro z-index-1 highway-color mr-3" href="/kupit-uchastki/<?=$valEnumHW?>-shosse/">
											<span class="metro-color <?=$colorHW?>"></span>
											<span class="metro-name"><?=$nameHW?> шоссе</span>
										</a>
										<a class="metro ml-0 z-index-1" href="/kupit-uchastki/<?=$url_km_MKAD?>/">
											<span class="metro-other"><?=$km_MKAD?> км от <?=ROAD?></span>
										</a>
									</div>
								</div>
							<?endif;?>

							<?if($offerType == 'plots'){ // если участки?>
	              <div class="offer-house__inline-info">
	                <div class="card-house__inline">
										<img class="mr-3" src="/assets/img/site/house.svg" alt>
	                  <div class="card-house__inline-title">
	                    Площадь участка:&nbsp;</div>
	                  <div class="card-house__inline-value"><?=$house['PLOTTAGE']?> соток</div>
	                </div>
	              </div>
							<?}else{?>
								<div class="offer-house__inline-info">
	                <div class="card-house__inline px-0">
										<img src="/assets/img/svg/house-plan.svg" alt="Площадь дома" class="svg_image">
	                  <div class="card-house__inline-title">
	                    Площадь дома:&nbsp;</div>
	                  <div class="card-house__inline-value"><?=$house['AREA_HOUSE']?> м<sup>2</sup></div>
	                </div>
	                <div class="card-house__inline px-0">
                    <img src="/assets/img/svg/stairs.svg" alt="Этажей" class="svg_image">
	                  <div class="card-house__inline-title">
	                    Этажей:&nbsp;</div>
	                  <div class="card-house__inline-value"><?=$house['FLOORS']?></div>
	                </div>
	                <div class="card-house__inline px-0">
										<img src="/assets/img/svg/brickwall.svg" alt="Материал" class="svg_image">
	                  <div class="card-house__inline-title">
											Материал:&nbsp;</div>
										<div class="card-house__inline-value mt-2"><?=$house['MATERIAL']?></div>
	                </div>
	              </div>
							<?}?>
              <div class="footer-card d-flex align-items-center mt-3">
                <div class="footer-card__price mt-2 mb-4 w-100 mx-2"><span class="split-number"><?=$house['PRICE']?></span> <span class="rep_rubl">руб.</span></div>
								<a class="btn btn-outline-warning rounded-pill w-100" href="<?=$house['URL']?>">Подробнее</a>
              </div>
            </div>
          </div>
        </div>
			<?}?>
		</div>
	</div>
<?endif;?>
<?if($arResult["arSimilarOffers"]):?>
	<div class="block-page">
		<h2>Похожие <?=mb_strtolower($offerNameM)?></h2>
		<div class="card-house-carousel house-in-village area-in-village" id="similar_houses">
			<?foreach ($arResult["arSimilarOffers"] as $id => $house) {?>
				<div class="item mr-4">
          <!-- Ссылка карточки-->
          <div class="offer-house__item card-house house-in-village">
            <div class="photo offer-house__photo">
              <div class="photo__list">
								<?foreach ($house['IMG'] as $key => $value) {?>
									<div class="photo__item" style="background: url('<?=$value['src']?>') no-repeat; background-size: cover; background-position: center center;"></div>
								<?}?>
              </div>
              <div class="photo__count"><span class="current">1</span> / <span class="count"><?=count($house['IMG'])?></span>
              </div>
            </div>
            <div class="offer-house__info card-house__content px-3">
              <div class="offer-house__title px-0">
								<?if($offerType == 'plots'):?>
									<?=$offerName?> <?=$house['NAME']?> в посёлке <?=$arResult['arVillage']['NAME']?>
								<?else:?>
									<?=$house['NAME']?>
								<?endif;?>
							</div>
							<?if($offerType == 'plots'){ // если участки?>
	              <div class="offer-house__inline-info border-0 mt-0 pt-0">
	                <div class="card-house__inline px-0">
										<img class="mr-3" src="/assets/img/site/house.svg" alt>
	                  <div class="card-house__inline-title">
	                    Площадь участка:&nbsp;</div>
	                  <div class="card-house__inline-value"><?=$house['PLOTTAGE']?> соток</div>
	                </div>
	              </div>
							<?}else{?>
								<div class="offer-house__inline-info border-0 mt-0 pt-0">
	                <div class="card-house__inline px-0">
										<img src="/assets/img/svg/house-plan.svg" alt="Площадь дома" class="mr-3">
	                  <div class="card-house__inline-title">
	                    Площадь дома:&nbsp;</div>
	                  <div class="card-house__inline-value"><?=$house['AREA_HOUSE']?> м<sup>2</sup></div>
	                </div>
	                <div class="card-house__inline px-0">
										<img src="/assets/img/svg/stairs.svg" alt="Этажей" class="mr-3">
	                  <div class="card-house__inline-title">
	                    Этажей:&nbsp;</div>
	                  <div class="card-house__inline-value"><?=$house['FLOORS']?></div>
	                </div>
	                <div class="card-house__inline px-0">
										<img src="/assets/img/svg/brickwall.svg" alt="Материал" class="mr-3">
	                  <div class="card-house__inline-title">
											Материал:&nbsp;</div>
										<div class="card-house__inline-value mt-2"><?=$house['MATERIAL']?></div>
	                </div>
							<?}?>
              <div class="footer-card d-flex align-items-center mt-3">
                <div class="footer-card__price mt-2 mb-4 w-100"><span class="split-number"><?=$house['PRICE']?></span> <span class="rep_rubl">руб.</span></div>
								<a class="btn btn-outline-warning rounded-pill w-100" href="/<?=$house['URL']?>/">Подробнее</a>
              </div>
            </div>
          </div>
        </div>
			<?}?>
		</div>
	</div>
<?endif;?>
<script type="text/javascript">
  // Яндекс.Карты
	function loadMaps() {
    ymaps.ready(function () {
      var myMap = new ymaps.Map('villageMap', {
        center: [<?=$arResult['arVillage']['COORDINATES'] // Координаты поселка?>],
        zoom: 12,
        controls: []
      });

      var myPlacemark = new ymaps.Placemark(myMap.getCenter(), {
				hintContent: '<?=$arResult['arVillage']['NAME']?>',
			}, {
        preset: 'islands#redDotIcon'
      });

      myMap.geoObjects.add(myPlacemark);
      myMap.behaviors.disable('scrollZoom');
    });
	};

	setTimeout(loadMaps, 3000);
</script>
