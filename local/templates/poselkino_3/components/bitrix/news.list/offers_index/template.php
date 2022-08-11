<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
$offerType = 'plots';
$offerName = ($offerType == 'plots') ? 'Участок' : 'Дом';
// $offerNameM = ($offerType == 'plots') ? 'Участки' : 'Дома';
// $offerPriceFor = ($offerType == 'plots') ? 'сотку' : 'кв.м.';
?>
<div class="card-house-carousel house-in-village area-in-village">
	<?foreach($arResult["ITEMS"] as $arOffer):
		$arVillage = $arResult['arVillage'][$arOffer['PROPERTIES']['VILLAGE']['VALUE']];
		foreach ($arVillage['PROPERTY_DOP_FOTO_VALUE'] as $value)
			$arOffer['IMG'][] = ['src' => CFile::GetPath($value)];
		shuffle($arOffer['IMG']);?>
		<div class="item mr-4">
			<!-- Ссылка карточки-->
			<div class="offer-house__item card-house house-in-village">
				<div class="photo offer-house__photo">
					<div class="photo__list">
						<?foreach ($arOffer['IMG'] as $value) {?>
							<div class="photo__item" style="background: url('<?=$value['src']?>') no-repeat; background-size: cover; background-position: center center;"></div>
						<?}?>
					</div>
					<div class="photo__count"><span class="current">1</span> / <span class="count"><?=count($arOffer['IMG'])?></span>
					</div>
				</div>
				<div class="offer-house__info card-house__content px-3">
					<div class="offer-house__title">
						<a href="<?=$arOffer['URL']?>">
							<?=$offerName?> <?=round($arOffer['PROPERTIES']['PLOTTAGE']['VALUE'])?> соток в посёлке <?=$arVillage['NAME']?>
						</a>
					</div>
					<?if($arVillage['PROPERTY_REGION_VALUE']):?>
	          <div class="offer-house__area"><a class="z-index-1 position-relative" href="/kupit-uchastki/<?=$arResult['REGION'][$arVillage['PROPERTY_REGION_ENUM_ID']]?>-rayon/"><?=$arVillage['PROPERTY_REGION_VALUE']?> район</a></div>
	        <?endif;?>
					<div class="offer-house__metro metro_no_top">
						<?if($arVillage['SHOSSE'][0]):?>
							<a class="metro z-index-1 highway-color" href="/kupit-uchastki/<?=$arVillage['SHOSSE'][0]['valEnumHW']?>-shosse/">
								<span class="metro-color <?=$arVillage['SHOSSE'][0]['colorHW']?>"></span>
								<span class="metro-name"><?=$arVillage['SHOSSE'][0]['nameHW']?> шоссе</span>
							</a>
						<?endif;?>
						<a class="metro z-index-1" href="/kupit-uchastki/<?=$arVillage['url_km_MKAD']?>/">
							<span class="metro-other"><?=$arVillage['km_MKAD']?> км от МКАД</span>
						</a>
					</div>
					<?if($offerType == 'plots'){ // если участки?>
						<div class="offer-house__inline-info">
							<div class="card-house__inline"><svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8" class="inline-svg">
												<path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z" transform="translate(.15 -22.745)"></path>
										</svg>
								<div class="card-house__inline-title">
									Площадь участка:&nbsp;</div>
								<div class="card-house__inline-value"><?=$arOffer['PROPERTIES']['PLOTTAGE']['VALUE']?> соток</div>
							</div>
						</div>
					<?}else{?>
						<div class="offer-house__inline-info">
							<div class="card-house__inline px-0"><svg xmlns="http://www.w3.org/2000/svg" width="16.523" height="16.523" viewBox="0 0 16.523 16.523" class="inline-svg">
												<path d="M16.523 1.614v13.3a1.615 1.615 0 0 1-1.614 1.614h-1.57a.645.645 0 1 1 0-1.291h1.571a.323.323 0 0 0 .323-.323V8.939h-5.7a.645.645 0 0 1 0-1.291h5.7V1.614a.323.323 0 0 0-.323-.323H7.618v1.893a.645.645 0 0 1-1.291 0V1.291H1.614a.323.323 0 0 0-.323.323v6h5.036V5.723a.645.645 0 0 1 1.291 0V10.8a.645.645 0 1 1-1.291 0V8.907H1.291v6a.323.323 0 0 0 .323.323h4.713v-1.891a.645.645 0 0 1 1.291 0v1.893H10.8a.645.645 0 1 1 0 1.291H1.614A1.615 1.615 0 0 1 0 14.909V1.614A1.615 1.615 0 0 1 1.614 0h13.3a1.615 1.615 0 0 1 1.609 1.614zm0 0"></path>
										</svg>
								<div class="card-house__inline-title">
									Площадь дома:&nbsp;</div>
								<div class="card-house__inline-value"><?=$arOffer['PROPERTIES']['AREA_HOUSE']['VALUE']?> м<sup>2</sup></div>
							</div>
							<div class="card-house__inline px-0">
										<svg xmlns="http://www.w3.org/2000/svg" width="16.523" height="16.523" viewBox="0 0 16.523 16.523" class="inline-svg">
												<path d="M16.523 1.614v13.3a1.615 1.615 0 0 1-1.614 1.614h-1.57a.645.645 0 1 1 0-1.291h1.571a.323.323 0 0 0 .323-.323V8.939h-5.7a.645.645 0 0 1 0-1.291h5.7V1.614a.323.323 0 0 0-.323-.323H7.618v1.893a.645.645 0 0 1-1.291 0V1.291H1.614a.323.323 0 0 0-.323.323v6h5.036V5.723a.645.645 0 0 1 1.291 0V10.8a.645.645 0 1 1-1.291 0V8.907H1.291v6a.323.323 0 0 0 .323.323h4.713v-1.891a.645.645 0 0 1 1.291 0v1.893H10.8a.645.645 0 1 1 0 1.291H1.614A1.615 1.615 0 0 1 0 14.909V1.614A1.615 1.615 0 0 1 1.614 0h13.3a1.615 1.615 0 0 1 1.609 1.614zm0 0"></path>
										</svg>
								<div class="card-house__inline-title">
									Этажей:&nbsp;</div>
								<div class="card-house__inline-value"><?=$arOffer['PROPERTIES']['FLOORS']['VALUE']?></div>
							</div>
							<div class="card-house__inline px-0"><svg xmlns="http://www.w3.org/2000/svg" width="16.523" height="16.523" viewBox="0 0 16.523 16.523" class="inline-svg">
												<path d="M16.523 1.614v13.3a1.615 1.615 0 0 1-1.614 1.614h-1.57a.645.645 0 1 1 0-1.291h1.571a.323.323 0 0 0 .323-.323V8.939h-5.7a.645.645 0 0 1 0-1.291h5.7V1.614a.323.323 0 0 0-.323-.323H7.618v1.893a.645.645 0 0 1-1.291 0V1.291H1.614a.323.323 0 0 0-.323.323v6h5.036V5.723a.645.645 0 0 1 1.291 0V10.8a.645.645 0 1 1-1.291 0V8.907H1.291v6a.323.323 0 0 0 .323.323h4.713v-1.891a.645.645 0 0 1 1.291 0v1.893H10.8a.645.645 0 1 1 0 1.291H1.614A1.615 1.615 0 0 1 0 14.909V1.614A1.615 1.615 0 0 1 1.614 0h13.3a1.615 1.615 0 0 1 1.609 1.614zm0 0"></path>
										</svg>
								<div class="card-house__inline-title">Материал:</div>
							</div>
							<div class="card-house__inline-value mt-2"><?=$arOffer['PROPERTIES']['MATERIAL']['VALUE']?></div>
						</div>
					<?}?>
					<div class="footer-card d-flex align-items-center mt-3">
						<div class="footer-card__price mt-2 mb-4 w-100 mx-2"><span class="split-number"><?=$arOffer['PROPERTIES']['PRICE']['VALUE']?></span> <span class="rep_rubl">руб.</span></div>
						<a class="btn btn-outline-warning rounded-pill w-100" href="<?=$arOffer['URL']?>">Подробнее</a>
					</div>
				</div>
			</div>
		</div>
	<?endforeach;?>
</div>
