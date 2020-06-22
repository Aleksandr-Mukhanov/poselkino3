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

// добавим превьюшку в фото
if($item["PREVIEW_PICTURE"]){
	array_unshift($item['PROPERTIES']['DOP_PHOTO']['VALUE'],$item["PREVIEW_PICTURE"]["ID"]); // положим в начало
} // dump($item['PROPERTIES']['DOP_PHOTO']['VALUE']);

// dump($arResult);
?>
<div class="d-flex flex-wrap bg-white card-grid align-items-baseline">
	<div class="card-house__photo photo ">
		<div class="slider__header">
			<?if($item['PROPERTIES']['ACTION']['VALUE']){?>
				<div class="slider__label">Акция</div>
			<?}?>
		</div>
		<div class="card-photo__list">
			<?foreach ($item['PROPERTIES']['DOP_PHOTO']['VALUE'] as $key => $photo){ // Фото
	    	$photoRes = CFile::ResizeImageGet($photo, array('width'=>580, 'height'=>358), BX_RESIZE_IMAGE_EXACT);?>
				<div class="card-photo__item" style="background: url(<?=$photoRes['src']?>) center center / cover no-repeat; width: 495px;"></div>
	    <?}?>
    </div>
    <div class="photo__count">
			<span class="current">1</span> / <span class="count"><?=count($item['PROPERTIES']['DOP_PHOTO']['VALUE'])?></span>
    </div>
	</div>
	<div class="card-house__content">
		<div class="wrap-title">
			<div class="card-house__title">Участок в посёлке <?=$arResult['VILLAGE']['NAME']?></div>
		</div>
		<div class="card-house__inline"><img class="mr-3" src="/assets/img/site/house.svg" alt>
			<div class="card-house__inline-title">
				Площадь участка:&nbsp;</div>
			<div class="card-house__inline-value"><?=$item['PROPERTIES']['PLOTTAGE']['VALUE']?> соток</div>
		</div>
		<?if($arResult['VILLAGE']['TRAIN'] == 'Есть'): // Электричка?>
			<div class="map-block">
				<div class="map-block__icon"><img class="mr-3" src="/assets/img/site/bus.svg" alt></div>
				<div class="map-block__text">
					<div class="map-block__title">На электричке:</div>
					<div class="map-block__info"><b><?=$arResult['VILLAGE']['TRAIN_TRAVEL_TIME'] // Электричка (время в пути)?></b> от вокзала: <?=$arResult['VILLAGE']['TRAIN_VOKZAL'] // Электричка (вокзал)?></div>
				</div>
			</div>
		<?endif;?>
		<div class="map-block">
			<div class="map-block__icon"><img class="mr-3" src="/assets/img/site/car.svg" alt></div>
			<div class="map-block__text">
				<div class="map-block__title">На автомобиле:</div>
				<div class="map-block__info"><b><?=$arResult['VILLAGE']['AUTO_NO_JAMS']?></b> от МКАДа без пробок</div>
			</div>
		</div>
		<div class="footer-card d-flex align-items-center">
			<div class="footer-card__price"><span class="split-number"><?=$item['PROPERTIES']['PRICE']['VALUE']?></span> <span class="rep_rubl">руб.</span></div><a class="btn btn-outline-warning rounded-pill" href="/uchastki/<?=$item['CODE']?>/">Подробнее</a>
		</div>
	</div>
</div>
