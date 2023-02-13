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

?>
<div class="container">
	<div class="house-in-village area-in-village page__content-list offers__index">
		<div class="list--grid">
			<?foreach ($arResult["ITEMS"] as $item):

				$offerURL = '/kupit-uchastki/uchastok-'.$item['ID'].'/';
				$arVillage = $arResult['arVillage'][$item['PROPERTIES']['VILLAGE']['VALUE']];

				foreach ($arVillage['PROPERTY_DOP_FOTO_VALUE'] as $value)
					$item['IMG'][] = ['src' => CFile::GetPath($value)];
				shuffle($item['IMG']);
			?>
				<div class="card-house area">
					<div class="d-flex flex-wrap bg-white card-grid">
						<div class="card-house__photo photo">
							<div class="slider__header">
								<?if($item['PROPERTIES']['ACTION']['VALUE']){?>
									<div class="slider__label">Акция</div>
								<?}?>
							</div>
							<div class="card-photo__list">
								<?foreach ($item['IMG'] as $photo){?>
									<div class="card-photo__item" style="background: url(<?=$photo['src']?>) center center / cover no-repeat; width: 495px;"></div>
						    <?}?>
					    </div>
					    <div class="photo__count">
								<span class="current">1</span> / <span class="count"><?=count($item['IMG'])?></span>
					    </div>
						</div>
						<div class="card-house__content">
							<div class="wrap-title">
								<div class="card-house__title">
									<a href="<?=$offerURL?>">Участок <?=round($item['PROPERTIES']['PLOTTAGE']['VALUE'])?> соток в посёлке <?=$arVillage['NAME']?></a>
								</div>
								<?if($arVillage['PROPERTY_REGION_VALUE']):?>
									<div class="card-house__area">
										<a href="/kupit-uchastki/<?=$arResult['REGION'][$arVillage['PROPERTY_REGION_ENUM_ID']]?>-rayon/"><?= $arVillage['PROPERTY_REGION_VALUE']?> район</a>
									</div>
								<?endif;?>
								<?if($arVillage['SHOSSE']):?>
									<div class="card-house__metro mt-2 mt-lg-3 metro_no_top">
										<?foreach ($arVillage['SHOSSE'] as $key => $value) {
											if($key == 0):?>
												<div class="d-flex flex-wrap w-100 mt-1 mt-lg-2">
													<a class="metro z-index-1 highway-color mr-3" href="/kupit-uchastki/<?=$value['valEnumHW']?>-shosse/">
														<span class="metro-color <?=$value['colorHW']?>"></span>
														<span class="metro-name"><?=$value['nameHW']?> шоссе</span>
													</a>
													<a class="metro ml-0 z-index-1" href="/kupit-uchastki/<?=$arVillage['url_km_MKAD']?>/">
														<span class="metro-other"><?=$arVillage['km_MKAD']?> км от МКАД</span>
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
							<?if($arVillage['PROPERTY_TRAIN_VALUE'] == 'Есть'): // Электричка?>
								<div class="map-block">
									<div class="map-block__icon"><img src="/assets/img/site/bus.svg" alt></div>
									<div class="map-block__text">
										<div class="map-block__title">На электричке:</div>
										<div class="map-block__info">
											<b><?=$arVillage['PROPERTY_TRAIN_TRAVEL_TIME_VALUE'] // Электричка (время в пути)?></b> от вокзала: <?=$arVillage['PROPERTY_TRAIN_VOKZAL_VALUE'] // Электричка (вокзал)?>
										</div>
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
				</div>
			<?endforeach;?>
		</div>
	</div>
</div>
