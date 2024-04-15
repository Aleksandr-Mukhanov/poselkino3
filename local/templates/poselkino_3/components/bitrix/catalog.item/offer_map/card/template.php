<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;
use Bitrix\Main\Grid\Declension;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $item
 * @var array $actualItem
 * @var array $minOffer
 * @var array $itemIds
 * @var array $price
 * @var array $measureRatio
 * @var bool $haveOffers
 * @var bool $showSubscribe
 * @var array $morePhoto
 * @var bool $showSlider
 * @var string $imgTitle
 * @var string $productTitle
 * @var string $buttonSizeClass
 * @var CatalogSectionComponent $component
 */

// км от МКАД
$km_MKAD = $item['PROPERTIES']['MKAD']['VALUE'];
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
}

// dump($arParams);
$offerType = $arParams['OFFER_TYPE'];
$offerName = ($offerType == 'plots') ? 'Участок' : 'Дом';

// dump($item['PROPERTIES']['DOP_FOTO']['VALUE']);
// фото поселков для участка
foreach ($item['PROPERTIES']['DOP_FOTO']['VALUE'] as $photo){
	 $photoRes = CFile::ResizeImageGet($photo, array('width'=>580, 'height'=>358), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true, $arWaterMark);
	 $item['PHOTO_VILLAGE'][] = $photoRes;
	 unset($photoRes);
}
?>
<div class="card-house-carousel house-in-village area-in-village" style="padding:0">
	<?foreach($arResult["PLOTS"] as $arOffer):
		$arVillage = $arResult['arVillage'][$arOffer['PROPERTIES']['VILLAGE']['VALUE']];
		if ($arOffer["IMG"])
			array_unshift($item['PHOTO_VILLAGE'],$arOffer["IMG"]); // положим в начало
		shuffle($item['PHOTO_VILLAGE']);

		$itemPhotos = $item['PHOTO_VILLAGE'];
		if (count($itemPhotos) > 5) $itemPhotos = array_slice($itemPhotos,0,5);
	?>
		<div class="item">
			<!-- Ссылка карточки-->
			<div class="offer-house__item card-house house-in-village">
				<div class="photo offer-house__photo">
					<div class="photo__list">
						<?foreach ($itemPhotos as $value) {?>
							<div class="photo__item" style="background: url('<?=$value['src']?>') no-repeat; background-size: cover; background-position: center center;"></div>
						<?}?>
					</div>
					<div class="photo__count"><span class="current">1</span> / <span class="count"><?=($itemPhotos)?count($itemPhotos):0?></span>
					</div>
				</div>
				<div class="offer-house__info card-house__content px-3">
					<div class="offer-house__title">
						<a href="<?=$arOffer['URL']?>">
							<?=$offerName?> <?=round($arOffer['PLOTTAGE'])?> соток в посёлке <?=$item['NAME']?>
						</a>
					</div>
					<?if($item['PROPERTIES']['REGION']['VALUE']):?>
	          <div class="offer-house__area"><a class="z-index-1 position-relative" href="/kupit-uchastki/<?=$item['PROPERTIES']['REGION']['VALUE_XML_ID']?>-rayon/"><?=$item['PROPERTIES']['REGION']['VALUE']?> район</a></div>
	        <?endif;?>
					<div class="offer-house__metro metro_no_top">
						<?if($item['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][0]): // если есть шоссе
							$idEnumHW = $item['PROPERTIES']['SHOSSE']['VALUE_ENUM_ID'][0];
							$valEnumHW = $item['PROPERTIES']['SHOSSE']['VALUE_XML_ID'][0];
							$colorHW = getColorRoad($idEnumHW);
							$nameHW = $item['PROPERTIES']['SHOSSE']['VALUE'][0];
						?>
							<a class="metro z-index-1 highway-color" href="/kupit-uchastki/<?=$valEnumHW?>-shosse/">
								<span class="metro-color <?=$colorHW?>"></span>
								<span class="metro-name"><?=$nameHW?> шоссе</span>
							</a>
						<?endif;?>
						<a class="metro z-index-1" href="/kupit-uchastki/<?=$url_km_MKAD?>/">
							<span class="metro-other"><?=$km_MKAD?> км от <?=ROAD?></span></a>
					</div>
					<?if($offerType == 'plots'){ // если участки?>
						<div class="offer-house__inline-info">
							<div class="card-house__inline"><svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8" class="inline-svg">
												<path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z" transform="translate(.15 -22.745)"></path>
										</svg>
								<div class="card-house__inline-title">
									Площадь участка:&nbsp;</div>
								<div class="card-house__inline-value"><?=$arOffer['PLOTTAGE']?> соток</div>
							</div>
						</div>
					<?}else{?>
						<div class="offer-house__inline-info">
							<div class="card-house__inline px-0"><svg xmlns="http://www.w3.org/2000/svg" width="16.523" height="16.523" viewBox="0 0 16.523 16.523" class="inline-svg">
												<path d="M16.523 1.614v13.3a1.615 1.615 0 0 1-1.614 1.614h-1.57a.645.645 0 1 1 0-1.291h1.571a.323.323 0 0 0 .323-.323V8.939h-5.7a.645.645 0 0 1 0-1.291h5.7V1.614a.323.323 0 0 0-.323-.323H7.618v1.893a.645.645 0 0 1-1.291 0V1.291H1.614a.323.323 0 0 0-.323.323v6h5.036V5.723a.645.645 0 0 1 1.291 0V10.8a.645.645 0 1 1-1.291 0V8.907H1.291v6a.323.323 0 0 0 .323.323h4.713v-1.891a.645.645 0 0 1 1.291 0v1.893H10.8a.645.645 0 1 1 0 1.291H1.614A1.615 1.615 0 0 1 0 14.909V1.614A1.615 1.615 0 0 1 1.614 0h13.3a1.615 1.615 0 0 1 1.609 1.614zm0 0"></path>
										</svg>
								<div class="card-house__inline-title">
									Площадь дома:&nbsp;</div>
								<div class="card-house__inline-value"><?=$arOffer['AREA_HOUSE']?> м<sup>2</sup></div>
							</div>
							<div class="card-house__inline px-0">
										<svg xmlns="http://www.w3.org/2000/svg" width="16.523" height="16.523" viewBox="0 0 16.523 16.523" class="inline-svg">
												<path d="M16.523 1.614v13.3a1.615 1.615 0 0 1-1.614 1.614h-1.57a.645.645 0 1 1 0-1.291h1.571a.323.323 0 0 0 .323-.323V8.939h-5.7a.645.645 0 0 1 0-1.291h5.7V1.614a.323.323 0 0 0-.323-.323H7.618v1.893a.645.645 0 0 1-1.291 0V1.291H1.614a.323.323 0 0 0-.323.323v6h5.036V5.723a.645.645 0 0 1 1.291 0V10.8a.645.645 0 1 1-1.291 0V8.907H1.291v6a.323.323 0 0 0 .323.323h4.713v-1.891a.645.645 0 0 1 1.291 0v1.893H10.8a.645.645 0 1 1 0 1.291H1.614A1.615 1.615 0 0 1 0 14.909V1.614A1.615 1.615 0 0 1 1.614 0h13.3a1.615 1.615 0 0 1 1.609 1.614zm0 0"></path>
										</svg>
								<div class="card-house__inline-title">
									Этажей:&nbsp;</div>
								<div class="card-house__inline-value"><?=$arOffer['FLOORS']?></div>
							</div>
							<div class="card-house__inline px-0"><svg xmlns="http://www.w3.org/2000/svg" width="16.523" height="16.523" viewBox="0 0 16.523 16.523" class="inline-svg">
												<path d="M16.523 1.614v13.3a1.615 1.615 0 0 1-1.614 1.614h-1.57a.645.645 0 1 1 0-1.291h1.571a.323.323 0 0 0 .323-.323V8.939h-5.7a.645.645 0 0 1 0-1.291h5.7V1.614a.323.323 0 0 0-.323-.323H7.618v1.893a.645.645 0 0 1-1.291 0V1.291H1.614a.323.323 0 0 0-.323.323v6h5.036V5.723a.645.645 0 0 1 1.291 0V10.8a.645.645 0 1 1-1.291 0V8.907H1.291v6a.323.323 0 0 0 .323.323h4.713v-1.891a.645.645 0 0 1 1.291 0v1.893H10.8a.645.645 0 1 1 0 1.291H1.614A1.615 1.615 0 0 1 0 14.909V1.614A1.615 1.615 0 0 1 1.614 0h13.3a1.615 1.615 0 0 1 1.609 1.614zm0 0"></path>
										</svg>
								<div class="card-house__inline-title">Материал:</div>
							</div>
							<div class="card-house__inline-value mt-2"><?=$arOffer['MATERIAL']?></div>
						</div>
					<?}?>
					<div class="footer-card d-flex align-items-center mt-3">
						<div class="footer-card__price mt-2 mb-4 w-100 mx-2"><span class="split-number"><?=$arOffer['PRICE']?></span> <span class="rub_currency">&#8381;</span></div>
						<a class="btn btn-outline-warning rounded-pill w-100" href="<?=$arOffer['URL']?>">Подробнее</a>
					</div>
				</div>
			</div>
		</div>
	<?endforeach;?>
</div>
