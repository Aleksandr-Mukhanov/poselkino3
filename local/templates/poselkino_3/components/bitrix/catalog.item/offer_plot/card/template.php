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
// dump($item['PROPERTIES']['DOP_PHOTO']);
// $arPhoto = ($item['PROPERTIES']['DOP_PHOTO']['VALUE']) ? $item['PROPERTIES']['DOP_PHOTO']['VALUE'] : [];
$arPhoto = ($arResult['PHOTO_VILLAGE']) ? $arResult['PHOTO_VILLAGE'] : [];

// добавим превьюшку в фото
if ($item["PREVIEW_PICTURE"])
	array_unshift($arPhoto,$item["PREVIEW_PICTURE"]["ID"]); // положим в начало
shuffle($arPhoto);

$offerURL = '/kupit-uchastki/uchastok-'.$item['ID'].'/';
?>
<div class="d-flex flex-wrap bg-white card-grid">
	<div class="card-house__photo photo">
		<div class="slider__header">
			<?if($item['PROPERTIES']['ACTION']['VALUE']){?>
				<div class="slider__label">Акция</div>
			<?}?>
		</div>
		<div class="card-photo__list">
			<?foreach ($arPhoto as $key => $photo){ // Фото
	    	$photoRes = CFile::ResizeImageGet($photo, array('width'=>580, 'height'=>358), BX_RESIZE_IMAGE_EXACT);?>
				<div class="card-photo__item" style="background: url(<?=$photoRes['src']?>) center center / cover no-repeat; width: 495px;"></div>
	    <?}?>
    </div>
    <div class="photo__count">
			<span class="current">1</span> / <span class="count"><?=count($arPhoto)?></span>
    </div>
	</div>
	<div class="card-house__content">
		<div class="wrap-title">
			<div class="card-house__title">
				<a href="<?=$offerURL?>">Участок <?=round($item['PROPERTIES']['PLOTTAGE']['VALUE'])?> соток в посёлке <?=$arResult['VILLAGE']['NAME']?></a>
			</div>
			<?if($arResult['VILLAGE']['REGION']):?>
				<div class="card-house__area">
					<a href="/kupit-uchastki/<?=$arResult['REGION'][$arResult['VILLAGE']['REGION_ENUM_ID']]?>-rayon/"><?= $arResult['VILLAGE']['REGION']?> район</a>
				</div>
			<?endif;?>
			<?if($arResult['VILLAGE']['SHOSSE']):?>
				<div class="card-house__metro mt-2 mt-lg-3 metro_no_top">
					<?foreach ($arResult['VILLAGE']['SHOSSE'] as $key => $value) {
						if($key == 0):?>
							<div class="d-flex flex-wrap w-100 mt-1 mt-lg-2">
								<a class="metro z-index-1 highway-color mr-3" href="/kupit-uchastki/<?=$value['valEnumHW']?>-shosse/">
									<span class="metro-color <?=$value['colorHW']?>"></span>
									<span class="metro-name"><?=$value['nameHW']?> шоссе</span>
								</a>
								<a class="metro ml-0 z-index-1" href="/kupit-uchastki/<?=$arResult['VILLAGE']['url_km_MKAD']?>/">
									<span class="metro-other"><?=$arResult['VILLAGE']['km_MKAD']?> км от МКАД</span>
								</a>
							</div>
						<?else:?>
							<div class="d-flex w-100 mt-1 mt-lg-2">
								<a class="metro z-index-1 pl-0 highway-color" href="/kupit-uchastki/<?=$value['valEnumHW']?>-shosse/">
									<span class="metro-color <?=$value['colorHW']?>"></span>
									<span class="metro-name"><?=$value['nameHW']?> шоссе</span>
								</a>
							</div>
						<?endif;
					}?>
				</div>
			<?endif;?>
		</div>
		<div class="card-house__inline"><img class="mr-3" src="/assets/img/site/house.svg" alt>
			<div class="card-house__inline-title">
				Площадь участка:&nbsp;</div>
			<div class="card-house__inline-value"><?=$item['PROPERTIES']['PLOTTAGE']['VALUE']?> соток</div>
		</div>
		<?if($arResult['VILLAGE']['TRAIN'] == 'Есть'): // Электричка?>
			<div class="map-block">
				<div class="map-block__icon"><img src="/assets/img/site/bus.svg" alt></div>
				<div class="map-block__text">
					<div class="map-block__title">На электричке:</div>
					<div class="map-block__info"><b><?=$arResult['VILLAGE']['TRAIN_TRAVEL_TIME'] // Электричка (время в пути)?></b> от вокзала: <?=$arResult['VILLAGE']['TRAIN_VOKZAL'] // Электричка (вокзал)?></div>
				</div>
			</div>
		<?endif;?>
		<div class="footer-card d-flex align-items-center">
			<div class="footer-card__price">
				<span class="split-number"><?=$item['PROPERTIES']['PRICE']['VALUE']?></span> <span class="rep_rubl">руб.</span>
			</div>
			<a class="btn btn-outline-warning rounded-pill" href="<?=$offerURL?>">Подробнее</a>
		</div>
	</div>
</div>
