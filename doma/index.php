<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Дома");?>
<main class="page page-va-list">
	<div class="bg-white">
		<div class="container">
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
		<div class="container my-5">
			<div class="page-title">
				<h1 class="h2"><?$APPLICATION->ShowTitle(false);?></h1>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="house-in-village area-in-village page__content-list">
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
        		"CACHE_FILTER" => "N",
        		"CACHE_GROUPS" => "Y",
        		"CACHE_TIME" => "36000000",
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
        		"ELEMENT_SORT_FIELD" => "sort",
        		"ELEMENT_SORT_FIELD2" => "id",
        		"ELEMENT_SORT_ORDER" => "asc",
        		"ELEMENT_SORT_ORDER2" => "asc",
        		"ENLARGE_PRODUCT" => "STRICT",
        		"FILE_404" => "",
        		"FILTER_NAME" => "arrFilter",
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
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
