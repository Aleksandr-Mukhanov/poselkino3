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

// dump($arResult);
// кол-во участков
$this->SetViewTarget('COUNT_PLOTS');
echo $arResult['NAV_RESULT']->result->num_rows;
$this->EndViewTarget();
$GLOBALS['COUNT_PLOTS'] = $arResult['NAV_RESULT']->result->num_rows;

// сравнение / избранное
$arComparison = []; $arFavorites = [];

if(isset($_COOKIE['comparison_plots']))
	$arComparison = explode('-',$_COOKIE['comparison_plots']);

if(isset($_COOKIE['favorites_plots']))
	$arFavorites = explode('-',$_COOKIE['favorites_plots']);

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

				// сравнение / избранное
				$comparison = (in_array($item['ID'],$arComparison)) ? 'Y' : 'N';
				$favorites = (in_array($item['ID'],$arFavorites)) ? 'Y' : 'N';
				$comp_active = ($comparison == 'Y') ? 'active' : '';
				$fav_active = ($favorites == 'Y') ? 'active' : '';
				$comp_text = ($comparison != 'Y') ? 'Добавить к сравнению' : 'Удалить из сравнения';
				$fav_text = ($favorites != 'Y') ? 'Добавить в избранное' : 'Удалить из избранного';
			?>
				<div class="card-house area">
					<div class="d-flex flex-wrap bg-white card-grid">
						<div class="card-house__photo photo">
							<div class="slider__header">
								<?if($item['PROPERTIES']['ACTION']['VALUE']){?>
									<div class="slider__label">Акция</div>
								<?}?>
								<div class="photo__buttons">
				            <button title="<?= $comp_text ?>" class="comparison-click <?= $comp_active ?>" data-id="<?= $item['ID'] ?>" data-cookie="comparison_plots">
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
				            <button title="<?= $fav_text ?>" class="favorites-click <?= $fav_active ?>" data-id="<?= $item['ID'] ?>" data-cookie="favorites_plots">
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
							</div>
							<div class="card-photo__list">
								<?foreach ($item['IMG'] as $photo){?>
									<img class="card-photo__item" src="<?=$photo['src']?>" alt="" />
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
									<span class="split-number"><?=$item['PROPERTIES']['PRICE']['VALUE']?></span> <span class="rub_currency">&#8381;</span>
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
