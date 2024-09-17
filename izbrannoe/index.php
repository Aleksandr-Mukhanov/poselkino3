<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Избранное");

// dump($_COOKIE);

$activeBtnVil = 'btn-success';
$activeBtnPlots = 'btn-outline-secondary';
$activeBtnHouse = 'btn-outline-secondary';

$showBlockVil = '';
$showBlockPlots = 'hide';
$showBlockHouse = 'hide';

if (isset($_COOKIE['favorites_vil'])) {
	$arFavoritesVil = explode('-',$_COOKIE['favorites_vil']);
}

if (isset($_COOKIE['favorites_plots'])) {
	$arFavoritesPlots = explode('-',$_COOKIE['favorites_plots']);
	if (!$arFavoritesVil) {
		$activeBtnVil = 'btn-outline-secondary';
		$activeBtnPlots = 'btn-success';
		$showBlockVil = 'hide';
		$showBlockPlots = '';
	}
}

if (isset($_COOKIE['favorites_houses'])) {
	$arFavoritesHouse = explode('-',$_COOKIE['favorites_houses']);
	if (!$arFavoritesVil && !$arFavoritesPlots) {
		$activeBtnVil = 'btn-outline-secondary';
		$activeBtnHouse = 'btn-success';
		$showBlockVil = 'hide';
		$showBlockHouse = '';
	}
}

$h1 = ($arFavoritesVil) ? 'Посёлки в избранном' : 'Нет поселков в избранном!';
$h1Plots = ($arFavoritesPlots) ? 'Участки в избранном' : 'Нет участков в избранном!';
$h1House = ($arFavoritesHouse) ? 'Дома в избранном' : 'Нет домов в избранном!';
// $h1 = 'Избранное';
?>
<script type="text/javascript">
	$(document).ready(function(){
		$('.chooseFav .nav-link').on('click', function() {
			$('.card-photo__list').slick('resize');
		});
	})
</script>
<main class="page page-search">
	<div class="page__breadcrumbs">
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
				<div class="order-0 order-sm-1 col-xl-7 col-lg-8">
          <div class="d-flex justify-content-lg-end">
            <div class="page__sort mr-lg-3 mr-auto">
              <div class="text-secondary">Сортировать:</div>
              <div class="ml-4">
                <select class="select-success select-bold hover-white" id="sortinng">
                  <option value="sort" <?if($_REQUEST['sort'] == 'sort')echo 'selected'?>>По релевантности</option>
                  <option value="rating" <?if($_REQUEST['sort'] == 'rating')echo 'selected'?>>По рейтингу</option>
                  <option value="cost_ask" <?if($_REQUEST['sort'] == 'cost_ask')echo 'selected'?>>Сначала дешевле</option>
                  <option value="cost_desc" <?if($_REQUEST['sort'] == 'cost_desc')echo 'selected'?>>Сначала дороже</option>
                  <option value="mkad" <?if($_REQUEST['sort'] == 'mkad')echo 'selected'?>>Удаленность от МКАД</option>
                </select>
              </div>
            </div>
          </div>
        </div>
			</div>
		</div>
	</div>
	<div class="page__content-title mb-4">
    <div class="container">
      <!-- <div class="row align-items-center">
        <div class="col-xl-7 col-lg-6">
          <h1 class="h2"><?=$h1?> <span class="text-secondary"><?//$APPLICATION->ShowViewContent('COUNT_POS');?></span></h1>
        </div>
			</div> -->
			<div class="row">
				<div class="col-md-12 filter__tab">
						<ul class="nav mt-lg-0 mt-2 chooseFav">
							<li class="nav-item">
								<a class="nav-link btn rounded-pill <?=$activeBtnVil?>" href="#favorites_villages">Поселки</a>
							</li>
							<li class="nav-item">
								<a class="nav-link btn rounded-pill <?=$activeBtnPlots?>" href="#favorites_plots">
									<svg xmlns="http://www.w3.org/2000/svg" width="17.323" height="15.8" viewBox="0 0 17.323 15.8" class="inline-svg"><path d="M16.524 29.385q-.558 0-1.109.036-.186-.128-.4-.258v-1.35a1.5 1.5 0 0 0 1-1.415v-2a1.5 1.5 0 0 0-3 0v2a1.5 1.5 0 0 0 1 1.415v.8a12.065 12.065 0 0 0-3.009-1V26.01a.5.5 0 0 0 .468-.868l-2.671-2a.5.5 0 0 0-.6 0l-2.671 2A.5.5 0 0 0 6 26.01v1.606a12.066 12.066 0 0 0-3.009 1v-.8A1.5 1.5 0 0 0 4 26.4v-2a1.5 1.5 0 1 0-3 0v2a1.5 1.5 0 0 0 1 1.415v1.35q-.209.13-.4.258-.543-.037-1.1-.038a.5.5 0 0 0-.5.5V37.9a.5.5 0 0 0 .5.5h16.024a.5.5 0 0 0 .5-.5v-8.016a.5.5 0 0 0-.5-.499zm-.5 8.013h-2.253a11 11 0 0 0-1.816-3.028 12.807 12.807 0 0 0-2.48-2.26 14.967 14.967 0 0 1 6.55-1.72zm-3.335 0H7.632a7.556 7.556 0 0 0-2.569-3.49A7.524 7.524 0 0 0 1 32.406v-2.015c5.242.168 9.9 2.971 11.693 7.007zm-8.358 0H1v-3.992A6.6 6.6 0 0 1 6.564 37.4H4.332zm9.686-13a.5.5 0 1 1 1.006 0v2a.5.5 0 1 1-1.006 0zm-7.011.894l1.5-1.128 1.5 1.128v2.176A13.2 13.2 0 0 0 9 27.394v-.749a.5.5 0 0 0-1 0v.749c-.347.013-.682.038-1.006.074zM2 24.4a.5.5 0 1 1 1 0v2a.5.5 0 1 1-1 0zm6.512 3.984a11.459 11.459 0 0 1 5.272 1.229 15.351 15.351 0 0 0-5.272 1.884 15.351 15.351 0 0 0-5.272-1.884 11.459 11.459 0 0 1 5.271-1.234z" transform="translate(.15 -22.745)"></path></svg>
									Участки
								</a>
							</li>
							<?//if($USER->IsAdmin()):?>
							<li class="nav-item">
								<a class="nav-link btn rounded-pill <?=$activeBtnHouse?>" href="#favorites_houses">
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

	<div class="block_favorites">
		<div id="favorites_villages" class="<?=$showBlockVil?>">
			<div class="container">
	      <div class="row align-items-center">
	        <div class="col-xl-7 col-lg-6">
	          <h1 class="h2"><?=$h1?> <span class="text-secondary"><?//$APPLICATION->ShowViewContent('COUNT_POS');?></span></h1>
	        </div>
				</div>
			</div>
			<?if ($arFavoritesVil) {
				$arrFilter = array('ID'=>$arFavoritesVil); // показывать только избранные
			?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:main.include",
					"",
					Array(
						"AREA_FILE_SHOW" => "file",
						"AREA_FILE_SUFFIX" => "inc",
						"EDIT_TEMPLATE" => "",
						"PATH" => "/include/section_cards.php"
					)
				);?>
			<?}else{?>
				<div class="container">
					<p>Поселков нет в избранном!</p>
				</div>
			<?}?>
		</div>
		<div id="favorites_plots" class="<?=$showBlockPlots?>">
			<div class="container">
	      <div class="row align-items-center">
	        <div class="col-xl-7 col-lg-6">
	          <h1 class="h2"><?=$h1Plots?> <span class="text-secondary"><?//$APPLICATION->ShowViewContent('COUNT_PLOTS');?></span></h1>
	        </div>
				</div>
			</div>
			<?if ($arFavoritesPlots) {
				global $arrFilterPlots;
				$arrFilterPlots = ['ID'=>$arFavoritesPlots]; // показывать только избранные
			?>
				<?$APPLICATION->IncludeComponent(
					"bitrix:news.list",
					"plots",
					array(
						"ACTIVE_DATE_FORMAT" => "d.m.Y",
						"ADD_SECTIONS_CHAIN" => "N",
						"AJAX_MODE" => "N",
						"AJAX_OPTION_ADDITIONAL" => "",
						"AJAX_OPTION_HISTORY" => "N",
						"AJAX_OPTION_JUMP" => "N",
						"AJAX_OPTION_STYLE" => "Y",
						"CACHE_FILTER" => "Y",
						"CACHE_GROUPS" => "N",
						"CACHE_TIME" => "86400",
						"CACHE_TYPE" => "A",
						"CHECK_DATES" => "Y",
						"DETAIL_URL" => "",
						"DISPLAY_BOTTOM_PAGER" => "N",
						"DISPLAY_DATE" => "N",
						"DISPLAY_NAME" => "Y",
						"DISPLAY_PICTURE" => "Y",
						"DISPLAY_PREVIEW_TEXT" => "Y",
						"DISPLAY_TOP_PAGER" => "N",
						"FIELD_CODE" => array(
							0 => "",
							1 => "",
						),
						"FILTER_NAME" => "arrFilterPlots", // фильтр акционных участков
						"HIDE_LINK_WHEN_NO_DETAIL" => "N",
						"IBLOCK_ID" => "5",
						"IBLOCK_TYPE" => "content",
						"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
						"INCLUDE_SUBSECTIONS" => "N",
						"MESSAGE_404" => "",
						"NEWS_COUNT" => "20",
						"PAGER_BASE_LINK_ENABLE" => "N",
						"PAGER_DESC_NUMBERING" => "N",
						"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
						"PAGER_SHOW_ALL" => "N",
						"PAGER_SHOW_ALWAYS" => "N",
						"PAGER_TEMPLATE" => ".default",
						"PAGER_TITLE" => "Новости",
						"PARENT_SECTION" => "",
						"PARENT_SECTION_CODE" => "",
						"PREVIEW_TRUNCATE_LEN" => "",
						"PROPERTY_CODE" => array(
							0 => "NUMBER",
							1 => "",
						),
						"SET_BROWSER_TITLE" => "N",
						"SET_LAST_MODIFIED" => "N",
						"SET_META_DESCRIPTION" => "N",
						"SET_META_KEYWORDS" => "N",
						"SET_STATUS_404" => "N",
						"SET_TITLE" => "N",
						"SHOW_404" => "N",
						"SORT_BY1" => "ACTIVE_FROM",
						"SORT_BY2" => "SORT",
						"SORT_ORDER1" => "DESC",
						"SORT_ORDER2" => "ASC",
						"STRICT_SECTION_CHECK" => "N",
						"COMPONENT_TEMPLATE" => "plots"
					),
					false
				);?>
			<?}else{?>
				<div class="container">
					<p>Участков нет в избранном!</p>
				</div>
			<?}?>
		</div>

		<div id="favorites_houses" class="<?=$showBlockHouse?>">
			<div class="container">
	      <div class="row align-items-center">
	        <div class="col-xl-7 col-lg-6">
	          <h1 class="h2"><?=$h1House?> <span class="text-secondary"><?//$APPLICATION->ShowViewContent('COUNT_HOUSE');?></span></h1>
	        </div>
				</div>
			</div>
			<?if ($arFavoritesHouse) {
				global $arrFilterHouse;
				$arrFilterHouse = ['ID'=>$arFavoritesHouse]; // показывать только избранные
			?>
			<div class="container">
				<div class="house-in-village area-in-village page__content-list offers__index">
					<div class="list--grid">
						<?$APPLICATION->IncludeComponent(
							"bitrix:catalog.section",
							"poselkino",
							array(
								"ACTION_VARIABLE" => "action",
								"ADD_PICT_PROP" => "-",
								"ADD_PROPERTIES_TO_BASKET" => "N",
								"ADD_SECTIONS_CHAIN" => "N",
								"AJAX_MODE" => "N",
								"AJAX_OPTION_ADDITIONAL" => "",
								"AJAX_OPTION_HISTORY" => "N",
								"AJAX_OPTION_JUMP" => "N",
								"AJAX_OPTION_STYLE" => "Y",
								"BACKGROUND_IMAGE" => "-",
								"BASKET_URL" => "/personal/basket.php",
								"BROWSER_TITLE" => "-",
								"CACHE_FILTER" => "Y",
								"CACHE_GROUPS" => "N",
								"CACHE_TIME" => "86400",
								"CACHE_TYPE" => "A",
								"COMPARE_NAME" => "CATALOG_COMPARE_HOUSE",
								"COMPARE_PATH" => "",
								"COMPATIBLE_MODE" => "N",
								"COMPONENT_TEMPLATE" => "poselkino",
								"COMPOSITE_FRAME_MODE" => "A",
								"COMPOSITE_FRAME_TYPE" => "AUTO",
								"DETAIL_URL" => "",
								"DISABLE_INIT_JS_IN_COMPONENT" => "N",
								"DISPLAY_BOTTOM_PAGER" => "Y",
								"DISPLAY_COMPARE" => "N",
								"DISPLAY_TOP_PAGER" => "N",
								"ELEMENT_SORT_FIELD" => "RAND",
								"ELEMENT_SORT_FIELD2" => "SHOW_COUNTER",
								"ELEMENT_SORT_ORDER" => "asc",
								"ELEMENT_SORT_ORDER2" => "desc",
								"ENLARGE_PRODUCT" => "STRICT",
								"FILE_404" => "",
								"FILTER_NAME" => "arrFilterHouse", // фильтр участков
								"IBLOCK_ID" => "6",
								"IBLOCK_TYPE" => "content",
								"INCLUDE_SUBSECTIONS" => "Y",
								"LABEL_PROP" => array(
								),
								"LAZY_LOAD" => "N",
								"LINE_ELEMENT_COUNT" => "3",
								"LOAD_ON_SCROLL" => "N",
								"MESSAGE_404" => "",
								"MESS_BTN_ADD_TO_BASKET" => "В корзину",
								"MESS_BTN_BUY" => "Купить",
								"MESS_BTN_COMPARE" => "Сравнить",
								"MESS_BTN_DETAIL" => "Подробнее",
								"MESS_BTN_SUBSCRIBE" => "Подписаться",
								"MESS_NOT_AVAILABLE" => "Нет в наличии",
								"META_DESCRIPTION" => "-",
								"META_KEYWORDS" => "-",
								"OFFERS_LIMIT" => "10",
								"PAGER_BASE_LINK_ENABLE" => "N",
								"PAGER_DESC_NUMBERING" => "N",
								"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
								"PAGER_SHOW_ALL" => "N",
								"PAGER_SHOW_ALWAYS" => "N",
								"PAGER_TEMPLATE" => "poselkino_nav",
								"PAGER_TITLE" => "Дома",
								"PAGE_ELEMENT_COUNT" => "18",
								"PARTIAL_PRODUCT_PROPERTIES" => "N",
								"PRICE_CODE" => array(
									0 => "PRICE",
								),
								"PRICE_VAT_INCLUDE" => "N",
								"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
								"PRODUCT_ID_VARIABLE" => "id",
								"PRODUCT_PROPERTIES" => array(
								),
								"PRODUCT_PROPS_VARIABLE" => "prop",
								"PRODUCT_QUANTITY_VARIABLE" => "quantity",
								"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false},{'VARIANT':'2','BIG_DATA':false}]",
								"PROPERTY_CODE" => array(
									0 => "ACTION",
									1 => "MATERIAL",
									2 => "FINISH",
									3 => "AREA_HOUSE",
									4 => "PLOTTAGE",
									5 => "VILLAGE",
									6 => "PRICE",
									7 => "FLOORS",
									8 => "STAGE",
									9 => "",
								),
								"PROPERTY_CODE_MOBILE" => array(
								),
								"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
								"RCM_TYPE" => "personal",
								"SECTION_CODE" => "",
								"SECTION_CODE_PATH" => "",
								"SECTION_ID" => "",
								"SECTION_ID_VARIABLE" => "SECTION_ID",
								"SECTION_URL" => "",
								"SECTION_USER_FIELDS" => array(
									0 => "",
									1 => "",
								),
								"SEF_MODE" => "Y",
								"SEF_RULE" => "",
								"SET_BROWSER_TITLE" => "Y",
								"SET_LAST_MODIFIED" => "Y",
								"SET_META_DESCRIPTION" => "Y",
								"SET_META_KEYWORDS" => "Y",
								"SET_STATUS_404" => "Y",
								"SET_TITLE" => "Y",
								"SHOW_404" => "Y",
								"SHOW_ALL_WO_SECTION" => "Y",
								"SHOW_FROM_SECTION" => "N",
								"SHOW_PRICE_COUNT" => "1",
								"SHOW_SLIDER" => "N",
								"SLIDER_INTERVAL" => "3000",
								"SLIDER_PROGRESS" => "N",
								"TEMPLATE_THEME" => "",
								"USE_ENHANCED_ECOMMERCE" => "N",
								"USE_MAIN_ELEMENT_SECTION" => "N",
								"USE_PRICE_COUNT" => "N",
								"USE_PRODUCT_QUANTITY" => "N",
								"TEMPLATE_CARD" => 'offer_house',
							),
							false
						);?>
						</div>
					</div>
				</div>
			<?}else{?>
				<div class="container">
					<p>Домов нет в избранном!</p>
				</div>
			<?}?>
		</div>
	</div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
