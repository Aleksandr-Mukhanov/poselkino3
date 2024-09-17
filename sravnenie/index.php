<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Сравнение");

\Bitrix\Main\Loader::includeModule('highloadblock');

// dump($_COOKIE);

if (isset($_COOKIE['comparison_vil']))
	$arComparisonVil = explode('-',$_COOKIE['comparison_vil']);

if (isset($_COOKIE['comparison_plots']))
	$arComparisonPlots = explode('-',$_COOKIE['comparison_plots']);

if (isset($_COOKIE['comparison_houses']))
	$arComparisonHouses = explode('-',$_COOKIE['comparison_houses']);

$activeBtnVil = 'btn-success';
$activeBtnPlots = 'btn-outline-secondary';
$activeBtnHouse = 'btn-outline-secondary';

$showBlockVil = '';
$showBlockPlots = 'hide';
$showBlockHouse = 'hide';

// получим шоссе и районы
$arElHL = getElHL(16,[],[],['*']);
foreach ($arElHL as $value)
	$arShosse[$value['UF_XML_ID']] = $value['UF_NAME'];

if ($arComparisonVil)
{
	// получим наши поселки
	$arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>IBLOCK_ID,"ACTIVE"=>"Y","ID"=>$arComparisonVil);
	$arSelect = Array('ID','NAME','PREVIEW_PICTURE','DETAIL_PAGE_URL','PROPERTY_SHOSSE','PROPERTY_MKAD','PROPERTY_PRICE_SOTKA','PROPERTY_HOME_VALUE','PROPERTY_PRICE_ARRANGE','PROPERTY_PRICE_ARRANGE_TIP','PROPERTY_ELECTRO','PROPERTY_GAS','PROPERTY_PLUMBING','PROPERTY_WATER','PROPERTY_SOIL','PROPERTY_BUS','PROPERTY_ROADS_IN_VIL','PROPERTY_ROADS_TO_VIL','PROPERTY_AREA_VIL'); // ,'PROPERTY_'
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	while($arElement = $rsElements->GetNext()){ // dump($arElement);
		// выводим водоемы
		$arWater = $arElement['PROPERTY_WATER_VALUE']; // Водоем
		foreach($arWater as $water)
			$arElement['WATER'] .= ($arElement['WATER']) ? ', '.$water : $water;

		// выводим почву
		$arSoil = $arElement['PROPERTY_SOIL_VALUE']; // Почва
		foreach($arSoil as $soil)
			$arElement['SOIL'] .= ($arElement['SOIL']) ? ', '.$soil : $soil;

		if ($arElement['PROPERTY_SHOSSE_VALUE']) $arElement['SHOSSE'] = implode(', ',$arElement['PROPERTY_SHOSSE_VALUE']);

		$arVillageComp[$arElement['ID']] = $arElement;
	} // dump($arVillageComp);
}

if ($arComparisonPlots)
{
	// $arElHL = getElHL(16,[],[],['*']); dump($arElHL);
	// получим участки
	$arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>5,"ACTIVE"=>"Y","ID"=>$arComparisonPlots);
	$arSelect = Array('ID','NAME','PREVIEW_PICTURE','DETAIL_PAGE_URL','PROPERTY_SHOSSE','PROPERTY_PLOTTAGE','PROPERTY_PRICE','PROPERTY_ARRANGEMENT','PROPERTY_MKAD','PROPERTY_ELECTRO','PROPERTY_GAS','PROPERTY_PLUMBING','PROPERTY_WATER','PROPERTY_BUS','PROPERTY_TRAIN','PROPERTY_LES','PROPERTY_PLYAZH','PROPERTY_VILLAGE'); // ,'PROPERTY_'
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	while($arElement = $rsElements->GetNext()){ // dump($arElement);
		// выводим водоемы
		$arWater = $arElement['PROPERTY_WATER_VALUE']; // Водоем
		foreach($arWater as $water)
			$arElement['WATER'] .= ($arElement['WATER']) ? ', '.$water : $water;

		foreach ($arElement['PROPERTY_SHOSSE_VALUE'] as $value)
			$arPlotShosse[] = $arShosse[$value];
		if ($arElement['PROPERTY_SHOSSE_VALUE']) $arElement['SHOSSE'] = implode(', ',$arPlotShosse);
		unset($arPlotShosse);

		$arPlotsComp[$arElement['ID']] = $arElement;
	} // dump($arPlotsComp);

	if (!$arComparisonVil) {
		$activeBtnVil = 'btn-outline-secondary';
		$activeBtnPlots = 'btn-success';
		$showBlockVil = 'hide';
		$showBlockPlots = '';
	}
}

if ($arComparisonHouses)
{
	// получим дома
	$arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>6,"ACTIVE"=>"Y","ID"=>$arComparisonHouses);
	$arSelect = Array('ID','NAME','PREVIEW_PICTURE','PROPERTY_SHOSSE','PROPERTY_AREA_HOUSE','PROPERTY_PLOTTAGE','PROPERTY_PRICE','PROPERTY_MKAD','PROPERTY_VILLAGE','PROPERTY_VILLAGE.NAME','PROPERTY_VILLAGE.CODE','PROPERTY_FLOORS','PROPERTY_MATERIAL','PROPERTY_FINISH','PROPERTY_STAGE','PROPERTY_TYPE'); // ,'PROPERTY_'
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	while($arElement = $rsElements->Fetch()){ // dump($arElement);

		if ($arElement['PROPERTY_SHOSSE_VALUE']) {
			foreach ($arElement['PROPERTY_SHOSSE_VALUE'] as $value)
				$arPlotShosse[] = $arShosse[$value];
			$arElement['SHOSSE'] = implode(', ',$arPlotShosse);
			unset($arPlotShosse);
		}

		if ($arElement['PROPERTY_MKAD_VALUE']) {
			foreach ($arElement['PROPERTY_MKAD_VALUE'] as $value)
				$arMkad[] = round($value);
			$arElement['MKAD'] = implode(', ',$arMkad);
			unset($arMkad);
		}

		$arHousesComp[$arElement['ID']] = $arElement;
	} // dump($arHousesComp);

	if (!$arComparisonVil && !$arComparisonPlots) {
		$activeBtnVil = 'btn-outline-secondary';
		$activeBtnHouse = 'btn-success';
		$showBlockVil = 'hide';
		$showBlockHouse = '';
	}
}

$h1 = ($arComparisonVil || $arComparisonPlots || $arComparisonHouses) ? 'Сравните выбранное' : 'В сравнении пусто!';
?>
<main class="page page-comparison slider">
	<div class="page__breadcrumbs mt-0 py-4">
		<div class="container">
			<div class="row align-items-center">
				<div class="order-1 order-sm-0 col-xl-5 col-lg-4">
					<?$APPLICATION->IncludeComponent(
						"bitrix:breadcrumb",
						"poselkino",
						array(
							"PATH" => "",
							"SITE_ID" => "s1",
							"START_FROM" => "0",
							"COMPONENT_TEMPLATE" => "poselkino"
						),
						false
					);?>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="row align-items-center">
				<div class="col-xl-9 col-md-8 mt-3">
					<div class="block-page__title block-page__title--icon">
						<div class="icon">
							<svg xmlns="http://www.w3.org/2000/svg" width="29.608" height="30.1" viewBox="0 0 29.608 30.1" class="inline-svg">
								<g id="Group_1819" data-name="Group 1819" transform="translate(-1216.349 -36)">
									<line id="Line_5" data-name="Line 5" y2="27.898" transform="translate(1217.349 37)" fill="none" stroke="#3c4b5a" stroke-linecap="round" stroke-width="2" />
									<line id="Line_8" data-name="Line 8" y2="27.898" transform="translate(1244.957 37)" fill="none" stroke="#3c4b5a" stroke-linecap="round" stroke-width="2" />
									<line id="Line_6" data-name="Line 6" y2="22.844" transform="translate(1226.783 42.257)" fill="none" stroke="#3c4b5a" stroke-linecap="round" stroke-width="2" />
									<line id="Line_7" data-name="Line 7" y2="13.208" transform="translate(1236.217 51.691)" fill="none" stroke="#3c4b5a" stroke-linecap="round" stroke-width="2" />
								</g>
							</svg>
						</div>
						<h1 class="mt-2"><?=$h1?></h1>
					</div>
				</div>
				<div class="col-xl-3 col-md-4">
					<div class="d-flex justify-content-end">
						<ul class="nav tab-switcher mt-0" role="tablist">
							<li><a id="comparison-all-tab" data-toggle="tab" href="#comparison-all" role="tab" aria-controls="comparison-all" aria-selected="false">Все</a></li>
							<li><a class="active" id="comparison-differences-tab" data-toggle="tab" href="#comparison-differences" role="tab" aria-controls="comparison-differences" aria-selected="true">Различия</a></li>
						</ul>
					</div>
				</div>
				<div class="col-md-12 filter__tab">
						<ul class="nav mt-lg-0 mt-2 chooseFav">
							<li class="nav-item">
								<a class="nav-link btn rounded-pill <?=$activeBtnVil?>" href="#comparison_vil">Поселки</a>
							</li>
							<li class="nav-item">
								<a class="nav-link btn rounded-pill <?=$activeBtnPlots?>" href="#comparison_plots">
									<svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8" class="inline-svg"><path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z" transform="translate(.15 -22.745)"></path></svg>
									Участки
								</a>
							</li>
							<?//if($USER->IsAdmin()):?>
							<li class="nav-item">
								<a class="nav-link btn rounded-pill <?=$activeBtnHouse?>" href="#comparison_houses">
									<svg xmlns="http://www.w3.org/2000/svg" width="16.523" height="16.523" viewBox="0 0 16.523 16.523" class="inline-svg">
										<path d="M16.523 1.614v13.3a1.615 1.615 0 0 1-1.614 1.614h-1.57a.645.645 0 1 1 0-1.291h1.571a.323.323 0 0 0 .323-.323V8.939h-5.7a.645.645 0 0 1 0-1.291h5.7V1.614a.323.323 0 0 0-.323-.323H7.618v1.893a.645.645 0 0 1-1.291 0V1.291H1.614a.323.323 0 0 0-.323.323v6h5.036V5.723a.645.645 0 0 1 1.291 0V10.8a.645.645 0 1 1-1.291 0V8.907H1.291v6a.323.323 0 0 0 .323.323h4.713v-1.891a.645.645 0 0 1 1.291 0v1.893H10.8a.645.645 0 1 1 0 1.291H1.614A1.615 1.615 0 0 1 0 14.909V1.614A1.615 1.615 0 0 1 1.614 0h13.3a1.615 1.615 0 0 1 1.609 1.614zm0 0"/>
									</svg>
									Дома
								</a>
							</li>
							<?//endif;?>
						</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="block_comparison">

		<div class="container comparison-content <?=$showBlockVil?>" id="comparison_vil">
			<div class="row">
				<?if($arComparisonVil){?>
					<div class="col-xl-2 col-md-3 col-sm-4 d-sm-flex d-none">
						<div class="comparison-tabs__char">
							<div class="char__title tr_0">Шоссе:</div>
							<div class="char__title tr_1">Удаленность от МКАД:</div>
							<div class="char__title tr_2">Цена за сотку:</div>
							<div class="char__title tr_3">Цена за дом:</div>
							<div class="char__title tr_4">Цена за обустройство (описание):</div>
							<div class="char__title tr_5">Цена за обустройство (кто):</div>
							<div class="char__title tr_6">Электричество:</div>
							<div class="char__title tr_7">Газ:</div>
							<div class="char__title tr_8">Вода:</div>
							<div class="char__title tr_9">Водоем:</div>
							<div class="char__title tr_10">Почва:</div>
							<div class="char__title tr_11">Автобус:</div>
							<div class="char__title tr_12">Дороги в поселке:</div>
							<div class="char__title tr_13">Дороги до поселка:</div>
							<div class="char__title tr_14">Площадь поселка, Га</div>
						</div>
					</div>
					<div class="col-xl-10 col-md-9 col-sm-8">
					<div class="tab-content comparison-tabs">
						<div class="tab-pane active" id="comparison-all" role="tabpanel" aria-labelledby="comparison-all-tab">
							<div class="comparison-tabs__wrap">
								<?foreach ($arVillageComp as $key => $villageComp) {
									$photoRes = CFile::ResizeImageGet($villageComp['PREVIEW_PICTURE'], array('width'=>580, 'height'=>358), BX_RESIZE_IMAGE_EXACT);?>
									<div class="card card-comparison" id="comparisonId-<?=$key?>">
										<div class="card-photo">
	                    <a href="<?=$villageComp['DETAIL_PAGE_URL']?>">
												<div class="photo" style="background: url(<?=$photoRes['src']?>) center center / cover no-repeat;"></div>
	                    </a>
											<button class="card-delete comparison-click" type="button" title="Удалить из сравнения" data-id="<?=$key?>" onclick="$('#comparisonId-<?=$key?>').hide();return true;"><svg xmlns="http://www.w3.org/2000/svg" width="9.703" height="9.703" viewBox="0 0 9.703 9.703" class="inline-svg">
													<path d="M5.71,4.852,9.525,1.037A.607.607,0,0,0,8.667.179L4.852,3.994,1.036.179a.607.607,0,0,0-.858.858L3.994,4.852.178,8.668a.607.607,0,1,0,.858.858L4.852,5.71,8.667,9.526a.607.607,0,0,0,.858-.858Z" transform="translate(0 -0.001)" fill="#919fa3" />
												</svg></button>
										</div>
										<div class="card-info">
											<div class="card-info__title">
	                      <a href="<?=$villageComp['DETAIL_PAGE_URL']?>">
	                        <?=$villageComp['NAME']?>
	                      </a>
	                    </div>
											<div class="card-description tr_0">
												<div class="card-description__title">Шоссе:</div>
												<div class="card-description__value"><?=$villageComp['SHOSSE']?></div>
											</div>
											<div class="card-description tr_1">
												<div class="card-description__title">Удаленность от МКАД:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_MKAD_VALUE']?></div>
											</div>
											<div class="card-description tr_2">
												<div class="card-description__title">Цена за сотку:</div>
												<div class="card-description__value"><?if($villageComp['PROPERTY_PRICE_SOTKA_VALUE']){?><span class="split-number"><?=$villageComp['PROPERTY_PRICE_SOTKA_VALUE'][0]?></span>/<span class="split-number"><?=$villageComp['PROPERTY_PRICE_SOTKA_VALUE'][1]?></span> ₽<?}?></div>
											</div>
											<div class="card-description tr_3">
												<div class="card-description__title">Цена за дом:</div>
												<div class="card-description__value"><span class="split-number"><?if($villageComp['PROPERTY_HOME_VALUE_VALUE']){?><?=$villageComp['PROPERTY_HOME_VALUE_VALUE'][0]?></span>/<span class="split-number"><?=$villageComp['PROPERTY_HOME_VALUE_VALUE'][1]?></span> ₽<?}?></div>
											</div>
											<div class="card-description tr_4">
												<div class="card-description__title pr-0">Цена за обустройство (описание):</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_PRICE_ARRANGE_VALUE']?></div>
											</div>
											<div class="card-description tr_5">
												<div class="card-description__title">Цена за обустройство (кто):</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_PRICE_ARRANGE_TIP_VALUE']?></div>
											</div>
											<div class="card-description tr_6">
												<div class="card-description__title">Электричество:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_ELECTRO_VALUE']?></div>
											</div>
											<div class="card-description tr_7">
												<div class="card-description__title">Газ:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_GAS_VALUE']?></div>
											</div>
											<div class="card-description tr_8">
												<div class="card-description__title">Вода:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_PLUMBING_VALUE']?></div>
											</div>
											<div class="card-description tr_9">
												<div class="card-description__title">Водоем:</div>
												<div class="card-description__value"><?=$villageComp['WATER']?></div>
											</div>
											<div class="card-description tr_10">
												<div class="card-description__title">Почва:</div>
												<div class="card-description__value"><?=$villageComp['SOIL']?></div>
											</div>
											<div class="card-description tr_11">
												<div class="card-description__title">Автобус:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_BUS_VALUE']?></div>
											</div>
											<div class="card-description tr_12">
												<div class="card-description__title">Дороги в поселке:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_ROADS_IN_VIL_VALUE']?></div>
											</div>
											<div class="card-description tr_13">
												<div class="card-description__title">Дороги до поселка:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_ROADS_TO_VIL_VALUE']?></div>
											</div>
											<div class="card-description tr_14">
												<div class="card-description__title">Площадь поселка, Га</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_AREA_VIL_VALUE']?></div>
											</div>
										</div>
									</div>
								<?}?>
							</div>
						</div>
					</div>
				</div>
				<?}else{?>
					<h2>Поселков нет в сравнении!</h2>
				<?}?>
			</div>
		</div>

		<div class="container comparison-content <?=$showBlockPlots?>" id="comparison_plots">
			<div class="row">
				<?if($arComparisonPlots){?>
					<div class="col-xl-2 col-md-3 col-sm-4 d-sm-flex d-none">
						<div class="comparison-tabs__char">
							<div class="char__title tr_21">Шоссе:</div>
							<div class="char__title tr_22">Удаленность от МКАД:</div>
							<div class="char__title tr_23">Площадь:</div>
							<div class="char__title tr_24">Цена:</div>
							<div class="char__title tr_25">Обустройство:</div>
							<div class="char__title tr_26">Электричество:</div>
							<div class="char__title tr_27">Газ:</div>
							<div class="char__title tr_28">Вода:</div>
							<div class="char__title tr_29">Водоем:</div>
							<div class="char__title tr_210">Автобус:</div>
							<div class="char__title tr_211">Электричка:</div>
							<!-- <div class="char__title tr_212">Лес:</div> -->
							<div class="char__title tr_212">Пляж:</div>
						</div>
					</div>
					<div class="col-xl-10 col-md-9 col-sm-8">
					<div class="tab-content comparison-tabs">
						<div class="tab-pane active" id="comparison-all-plots" role="tabpanel" aria-labelledby="comparison-all-tab">
							<div class="comparison-tabs__wrap">
								<?foreach ($arPlotsComp as $key => $villageComp) {
									$photoRes = CFile::ResizeImageGet($villageComp['PREVIEW_PICTURE'], array('width'=>580, 'height'=>358), BX_RESIZE_IMAGE_EXACT);?>
									<div class="card card-comparison" id="comparisonId-<?=$key?>">
										<div class="card-photo">
	                    <a href="<?=$villageComp['DETAIL_PAGE_URL']?>">
												<div class="photo" style="background: url(<?=$photoRes['src']?>) center center / cover no-repeat;"></div>
	                    </a>
											<button class="card-delete comparison-click" type="button" title="Удалить из сравнения" data-id="<?=$key?>" onclick="$('#comparisonId-<?=$key?>').hide();return true;" data-cookie="comparison_plots"><svg xmlns="http://www.w3.org/2000/svg" width="9.703" height="9.703" viewBox="0 0 9.703 9.703" class="inline-svg">
													<path d="M5.71,4.852,9.525,1.037A.607.607,0,0,0,8.667.179L4.852,3.994,1.036.179a.607.607,0,0,0-.858.858L3.994,4.852.178,8.668a.607.607,0,1,0,.858.858L4.852,5.71,8.667,9.526a.607.607,0,0,0,.858-.858Z" transform="translate(0 -0.001)" fill="#919fa3" />
												</svg></button>
										</div>
										<div class="card-info">
											<div class="card-info__title">
	                      <a href="<?=$villageComp['DETAIL_PAGE_URL']?>">
	                        <?=$villageComp['NAME']?>
	                      </a>
	                    </div>
											<div class="card-description tr_21">
												<div class="card-description__title">Шоссе:</div>
												<div class="card-description__value"><?=$villageComp['SHOSSE']?></div>
											</div>
											<div class="card-description tr_22">
												<div class="card-description__title">Удаленность от МКАД:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_MKAD_VALUE']?></div>
											</div>
											<div class="card-description tr_23">
												<div class="card-description__title">Площадь:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_PLOTTAGE_VALUE']?></div>
											</div>
											<div class="card-description tr_24">
												<div class="card-description__title">Цена:</div>
												<div class="card-description__value"><span class="split-number"><?=$villageComp['PROPERTY_PRICE_VALUE']?></span> ₽</div>
											</div>
											<div class="card-description tr_25">
												<div class="card-description__title pr-0">Обустройство:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_ARRANGEMENT_VALUE']?></div>
											</div>
											<div class="card-description tr_26">
												<div class="card-description__title">Электричество:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_ELECTRO_VALUE']?></div>
											</div>
											<div class="card-description tr_27">
												<div class="card-description__title">Газ:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_GAS_VALUE']?></div>
											</div>
											<div class="card-description tr_28">
												<div class="card-description__title">Вода:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_PLUMBING_VALUE']?></div>
											</div>
											<div class="card-description tr_29">
												<div class="card-description__title">Водоем:</div>
												<div class="card-description__value"><?=$villageComp['WATER']?></div>
											</div>
											<div class="card-description tr_210">
												<div class="card-description__title">Автобус:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_BUS_VALUE']?></div>
											</div>
											<div class="card-description tr_211">
												<div class="card-description__title">Электричка:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_TRAIN_VALUE']?></div>
											</div>
											<!-- <div class="card-description tr_212">
												<div class="card-description__title">Лес:</div>
												<div class="card-description__value"><?//=implode(', ',$villageComp['PROPERTY_LES_VALUE'])?></div>
											</div> -->
											<div class="card-description tr_212">
												<div class="card-description__title">Пляж:</div>
												<div class="card-description__value"><?=$villageComp['PROPERTY_PLYAZH_VALUE']?></div>
											</div>
										</div>
									</div>
								<?}?>
							</div>
						</div>
					</div>
				</div>
				<?}else{?>
					<h2>Участков нет в сравнении!</h2>
				<?}?>
			</div>
		</div>

		<?//if($USER->IsAdmin()):?>
			<div class="container comparison-content <?=$showBlockHouse?>" id="comparison_houses">
				<div class="row">
					<?if($arComparisonHouses){?>
						<div class="col-xl-2 col-md-3 col-sm-4 d-sm-flex d-none">
							<div class="comparison-tabs__char">
								<div class="char__title tr_31">Шоссе:</div>
								<div class="char__title tr_32">Удаленность от МКАД:</div>
								<div class="char__title tr_33">Площадь дома:</div>
								<div class="char__title tr_34">Площадь участка:</div>
								<div class="char__title tr_35">Цена:</div>
								<div class="char__title tr_36">Этажность:</div>
								<div class="char__title tr_37">Материал:</div>
								<div class="char__title tr_38">Отделка:</div>
								<div class="char__title tr_39">Этап строительства:</div>
								<div class="char__title tr_310">Тип дома:</div>
								<!-- <div class="char__title tr_311">Статус:</div> -->
							</div>
						</div>
						<div class="col-xl-10 col-md-9 col-sm-8">
						<div class="tab-content comparison-tabs">
							<div class="tab-pane active" id="comparison-all-plots" role="tabpanel" aria-labelledby="comparison-all-tab">
								<div class="comparison-tabs__wrap">
									<?foreach ($arHousesComp as $key => $villageComp) {
										$photoRes = CFile::ResizeImageGet($villageComp['PREVIEW_PICTURE'], array('width'=>580, 'height'=>358), BX_RESIZE_IMAGE_EXACT);?>
										<div class="card card-comparison" id="comparisonId-<?=$key?>">
											<div class="card-photo">
												<a href="/kupit-dom/<?=$villageComp['PROPERTY_VILLAGE_CODE']?>-dom-<?=$villageComp['ID']?>/">
													<div class="photo" style="background: url(<?=$photoRes['src']?>) center center / cover no-repeat;"></div>
												</a>
												<button class="card-delete comparison-click" type="button" title="Удалить из сравнения" data-id="<?=$key?>" onclick="$('#comparisonId-<?=$key?>').hide();return true;" data-cookie="comparison_houses"><svg xmlns="http://www.w3.org/2000/svg" width="9.703" height="9.703" viewBox="0 0 9.703 9.703" class="inline-svg">
														<path d="M5.71,4.852,9.525,1.037A.607.607,0,0,0,8.667.179L4.852,3.994,1.036.179a.607.607,0,0,0-.858.858L3.994,4.852.178,8.668a.607.607,0,1,0,.858.858L4.852,5.71,8.667,9.526a.607.607,0,0,0,.858-.858Z" transform="translate(0 -0.001)" fill="#919fa3" />
													</svg></button>
											</div>
											<div class="card-info">
												<div class="card-info__title">
													<a href="/kupit-dom/<?=$villageComp['PROPERTY_VILLAGE_CODE']?>-dom-<?=$villageComp['ID']?>/">
														Дом в поселке <?=$villageComp['PROPERTY_VILLAGE_NAME']?>
													</a>
												</div>
												<div class="card-description tr_31">
													<div class="card-description__title">Шоссе:</div>
													<div class="card-description__value"><?=$villageComp['SHOSSE']?></div>
												</div>
												<div class="card-description tr_32">
													<div class="card-description__title">Удаленность от МКАД:</div>
													<div class="card-description__value"><?=$villageComp['MKAD']?></div>
												</div>
												<div class="card-description tr_33">
													<div class="card-description__title">Площадь дома:</div>
													<div class="card-description__value"><?=$villageComp['PROPERTY_AREA_HOUSE_VALUE']?></div>
												</div>
												<div class="card-description tr_34">
													<div class="card-description__title">Площадь участка:</div>
													<div class="card-description__value"><?=$villageComp['PROPERTY_PLOTTAGE_VALUE']?></div>
												</div>
												<div class="card-description tr_35">
													<div class="card-description__title">Цена:</div>
													<div class="card-description__value"><span class="split-number"><?=$villageComp['PROPERTY_PRICE_VALUE']?></span> ₽</div>
												</div>
												<div class="card-description tr_36">
													<div class="card-description__title pr-0">Этажность:</div>
													<div class="card-description__value"><?=$villageComp['PROPERTY_FLOORS_VALUE']?></div>
												</div>
												<div class="card-description tr_37">
													<div class="card-description__title">Материал:</div>
													<div class="card-description__value"><?=$villageComp['PROPERTY_MATERIAL_VALUE']?></div>
												</div>
												<div class="card-description tr_38">
													<div class="card-description__title">Отделка:</div>
													<div class="card-description__value"><?=$villageComp['PROPERTY_FINISH_VALUE']?></div>
												</div>
												<div class="card-description tr_39">
													<div class="card-description__title">Этап строительства:</div>
													<div class="card-description__value"><?=$villageComp['PROPERTY_STAGE_VALUE']?></div>
												</div>
												<div class="card-description tr_310">
													<div class="card-description__title">Тип дома:</div>
													<div class="card-description__value"><?=$villageComp['PROPERTY_TYPE_VALUE']?></div>
												</div>
												<!-- <div class="card-description tr_311">
													<div class="card-description__title">Статус:</div>
													<div class="card-description__value"><?=$villageComp['PROPERTY_STATUS_VALUE']?></div>
												</div> -->
											</div>
										</div>
									<?}?>
								</div>
							</div>
						</div>
					</div>
					<?}else{?>
						<h2>Домов нет в сравнении!</h2>
					<?}?>
				</div>
			</div>
		<?//endif;?>

	</div>
</main>
<script>
	$(document).ready(function()
	{
		for (var i = 1; i < 15; i++) {
      var show_dif = true;
      var j = 0;
      $('.tr_'+i).each(function(){ // переберем строки
        td_text = $(this).find('.card-description__value').text();
        // console.log('tr_'+i+': '+td_text);
        if (j > 1)
          if (td_text != td_text_old) show_dif = false;
        td_text_old = td_text; j++;
      });
      if (show_dif) $('.tr_'+i).hide();
    }

		$('.chooseFav .nav-link').on('click', function() {
			$('.card-photo__list').slick('resize');
		});

	});
</script>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
