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
if ($item["PREVIEW_PICTURE"])
	array_unshift($item['PROPERTIES']['DOP_PHOTO']['VALUE'],$item["PREVIEW_PICTURE"]["ID"]); // положим в начало

$itemPhotos = $item['PROPERTIES']['DOP_PHOTO']['VALUE'];
if (count($itemPhotos) > 5) $itemPhotos = array_slice($itemPhotos,0,5);

// dump($arResult);
$offerURL = '/kupit-dom/'.$arResult['VILLAGE']['CODE'].'-dom-'.$item['ID'].'/';

// dump($arParams);
$comp_active = ($arParams['COMPARISON'] == 'Y') ? 'active' : '';
$fav_active = ($arParams['FAVORITES'] == 'Y') ? 'active' : '';
$comp_text = ($arParams['COMPARISON'] == 'Y') ? 'Удалить из сравнения' : 'Добавить к сравнению';
$fav_text = ($arParams['FAVORITES'] == 'Y') ? 'Удалить из избранного' : 'Добавить в избранное';
?>
<div class="card-house">
	<div class="d-flex flex-wrap bg-white card-grid">
		<div class="card-house__photo photo">
      <a href="<?=$offerURL?>" class="stretched-link"></a>
			<div class="slider__header">
				<?if($item['PROPERTIES']['ACTION']['VALUE']){?>
					<div class="slider__label">Акция</div>
				<?}?>
				<?if($USER->IsAdmin()){?>
					<div class="photo__buttons">
	            <button title="<?= $comp_text ?>" class="comparison-click <?= $comp_active ?>" data-id="<?= $item['ID'] ?>" data-cookie="comparison_house">
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
	            <button title="<?= $fav_text ?>" class="favorites-click <?= $fav_active ?>" data-id="<?= $item['ID'] ?>" data-cookie="favorites_house">
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
				<?}?>
			</div>
			<div class="card-photo__list" id="card-house-in-village-photo">
				<?foreach ($itemPhotos as $photo){ // Фото
		    	$photoRes = CFile::ResizeImageGet($photo, array('width'=>580, 'height'=>358), BX_RESIZE_IMAGE_EXACT);?>
					<img class="card-photo__item" src="<?=$photoRes['src']?>" alt="" />
		    <?}?>
	    </div>
			<div class="photo__count">
				<span class="current">1</span> / <span class="count"><?=($itemPhotos)?count($itemPhotos):0?></span>
	    </div>
		</div>
		<div class="card-house__content">
			<div class="wrap-title">
				<div class="card-house__title">Дом в посёлке <?=$arResult['VILLAGE']['NAME']?>
          <a href="<?=$offerURL?>" class="stretched-link"></a>
        </div>
			</div>
			<div class="card-house__inline">
				<svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8" class="inline-svg">
					<path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z"
						transform="translate(.15 -22.745)" />
				</svg>
				<div class="card-house__inline-title">
					Площадь дома:&nbsp;</div>
				<div class="card-house__inline-value"><?=$item['PROPERTIES']['AREA_HOUSE']['VALUE']?> м<sup>2</sup></div>
			</div>
			<div class="card-house__inline">
				<svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8" class="inline-svg">
					<path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z"
						transform="translate(.15 -22.745)" />
				</svg>
				<div class="card-house__inline-title">
					Этажей:&nbsp;</div>
				<div class="card-house__inline-value"><?=$item['PROPERTIES']['FLOORS']['VALUE']?></div>
			</div>
			<div class="card-house__inline">
				<svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8" class="inline-svg">
					<path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z"
						transform="translate(.15 -22.745)" />
				</svg>
				<div class="card-house__inline-title">
					Материал:&nbsp;</div>
				<div class="card-house__inline-value"><span><?=$item['PROPERTIES']['MATERIAL']['VALUE']?></span></div>
			</div>
			<div class="footer-card d-flex align-items-center">
				<div class="footer-card__price"><span class="split-number"><?=$item['PROPERTIES']['PRICE']['VALUE']?></span> <span class="rub_currency">&#8381;</span></div><a class="btn btn-outline-warning rounded-pill" href="<?=$offerURL?>">Подробнее</a>
			</div>
		</div>
	</div>
</div>
