<?if(isset($_REQUEST['sort'])){ // если есть сортировка
	// сортировка по цене
	if ($_REQUEST['DOMA_CODE'] == 'noDom') $sortFieldCost = 'PROPERTY_COST_LAND_IN_CART'; // Стоимость участка (в карточку)
	elseif ($_REQUEST['DOMA_CODE'] == 'withDom') $sortFieldCost = 'PROPERTY_HOME_VALUE'; // Стоимость домов
	else $sortFieldCost = 'PROPERTY_PRICE_SOTKA'; // Цена за сотку

	switch($_REQUEST['sort']){
		case 'sort':
			$sectionSortField = 'SORT';
			$sectionSortOrder = 'asc';
			break;
		case 'rating':
			$sectionSortField = 'PROPERTY_RATING';
			$sectionSortOrder = 'desc';
			break;
		case 'cost_ask':
			$sectionSortField = $sortFieldCost;
			$sectionSortOrder = 'asc';
			break;
		case 'cost_desc':
			$sectionSortField = $sortFieldCost;
			$sectionSortOrder = 'desc';
			break;
		case 'mkad':
			$sectionSortField = 'PROPERTY_MKAD';
			$sectionSortOrder = 'asc';
			break;
		default:
			$sectionSortField = 'SORT';
      $sectionSortOrder = 'asc';
			break;
	}
}else{
	$sectionSortField = 'SORT';
	$sectionSortOrder = 'asc';
}

global $arrFilter;
	$arrFilter['!PROPERTY_SALES_PHASE'] = [254]; // уберем проданные
	$arrFilter['!PROPERTY_HIDE_POS'] = 273; // метка убрать из каталога
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.section",
	"poselkino",
	array(
		"ACTION_VARIABLE" => "action",
		"ADD_PICT_PROP" => "DOP_FOTO",
		"ADD_PROPERTIES_TO_BASKET" => "N",
		"ADD_SECTIONS_CHAIN" => "N",
		"ADD_TO_BASKET_ACTION" => "ADD",
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
		"COMPATIBLE_MODE" => "N",
		"COMPONENT_TEMPLATE" => "poselkino",
		"CONVERT_CURRENCY" => "N",
		"CUSTOM_FILTER" => "",
		"DETAIL_URL" => "/poselki/#ELEMENT_CODE#/",
		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_COMPARE" => "N", // РЎРѓРЎР‚Р В°Р Р†Р Р…Р ВµР Р…Р С‘Р Вµ
		"DISPLAY_TOP_PAGER" => "N",
		"ELEMENT_SORT_FIELD" => $sectionSortField,
		"ELEMENT_SORT_FIELD2" => "SHOW_COUNTER",
		"ELEMENT_SORT_ORDER" => $sectionSortOrder,
		"ELEMENT_SORT_ORDER2" => "desc",
		"ENLARGE_PRODUCT" => "STRICT",
		"FILTER_NAME" => "arrFilter",
		"HIDE_NOT_AVAILABLE" => "N",
		"HIDE_NOT_AVAILABLE_OFFERS" => "N",
		"IBLOCK_ID" => "1",
		"IBLOCK_TYPE" => "content",
		"INCLUDE_SUBSECTIONS" => "Y",
		"LABEL_PROP" => array(
		),
		"LAZY_LOAD" => "N",
		"LINE_ELEMENT_COUNT" => "3",
		"LOAD_ON_SCROLL" => "N",
		"MESSAGE_404" => "",
		"MESS_BTN_ADD_TO_BASKET" => "Р вЂ™ Р С”Р С•РЎР‚Р В·Р С‘Р Р…РЎС“",
		"MESS_BTN_BUY" => "Р С™РЎС“Р С—Р С‘РЎвЂљРЎРЉ",
		"MESS_BTN_DETAIL" => "Р СџР С•Р Т‘РЎР‚Р С•Р В±Р Р…Р ВµР Вµ",
		"MESS_BTN_SUBSCRIBE" => "Р СџР С•Р Т‘Р С—Р С‘РЎРѓР В°РЎвЂљРЎРЉРЎРѓРЎРЏ",
		"MESS_NOT_AVAILABLE" => "Р СњР ВµРЎвЂљ Р Р† Р Р…Р В°Р В»Р С‘РЎвЂЎР С‘Р С‘",
		"META_DESCRIPTION" => "-",
		"META_KEYWORDS" => "-",
		"OFFERS_LIMIT" => "5",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => "poselkino_nav",
		"PAGER_TITLE" => "Р СћР С•Р Р†Р В°РЎР‚РЎвЂ№",
		"PAGE_ELEMENT_COUNT" => "3",
		"PARTIAL_PRODUCT_PROPERTIES" => "N",
		"PRICE_CODE" => array(
		),
		"PRICE_VAT_INCLUDE" => "N",
		"PRODUCT_BLOCKS_ORDER" => "price,props,sku,quantityLimit,quantity,buttons",
		"PRODUCT_ID_VARIABLE" => "id",
		"PRODUCT_PROPERTIES" => array(
		),
		"PRODUCT_PROPS_VARIABLE" => "prop",
		"PRODUCT_QUANTITY_VARIABLE" => "quantity",
		"PRODUCT_ROW_VARIANTS" => "[{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false},{'VARIANT':'3','BIG_DATA':false}]",
		"PRODUCT_SUBSCRIPTION" => "N",
		"PROPERTY_CODE" => array(
			0 => "TYPE",
			1 => "DOMA",
			2 => "OBLAST",
			3 => "REGION",
			4 => "SHOSSE",
			5 => "MKAD",
			6 => "SALES_PHASE",
			7 => "PLOTTAGE",
			8 => "STOIMOST_UCHASTKA",
			9 => "HOUSE_AREA",
			10 => "HOME_VALUE",
			11 => "COORDINATES",
			12 => "",
		),
		"PROPERTY_CODE_MOBILE" => array(
		),
		"RCM_PROD_ID" => $_REQUEST["PRODUCT_ID"],
		"RCM_TYPE" => "personal",
		"SECTION_CODE" => "",
		"SECTION_CODE_PATH" => "",
		"SECTION_ID" => "",
		"SECTION_ID_VARIABLE" => "SECTION_ID",
		"SECTION_URL" => "/poselki/",
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
		"SHOW_CLOSE_POPUP" => "N",
		"SHOW_DISCOUNT_PERCENT" => "N",
		"SHOW_FROM_SECTION" => "N",
		"SHOW_MAX_QUANTITY" => "N",
		"SHOW_OLD_PRICE" => "N",
		"SHOW_PRICE_COUNT" => "1",
		"SHOW_SLIDER" => "N",
		"SLIDER_INTERVAL" => "3000",
		"SLIDER_PROGRESS" => "N",
		"TEMPLATE_THEME" => "green",
		"USE_ENHANCED_ECOMMERCE" => "N",
		"USE_MAIN_ELEMENT_SECTION" => "N",
		"USE_PRICE_COUNT" => "N",
		"USE_PRODUCT_QUANTITY" => "N",
		"TEMPLATE_CARD" => 'poselok_index', // карточки для главной
	),
	false
);?>
