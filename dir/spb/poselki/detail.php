<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Поселки");
use Bitrix\Main\Page\Asset;
 // Яндекс.Поделиться
 Asset::getInstance()->addJs("//yastatic.net/es5-shims/0.0.2/es5-shims.min.js");
 Asset::getInstance()->addJs("//yastatic.net/share2/share.js");
 // Яндекс.Карты
 Asset::getInstance()->addJs("https://api-maps.yandex.ru/2.1/?lang=ru_RU");?>
<main class="page page-village" itemscope itemtype="http://schema.org/Product">
	<div class="bg-white">
		<div class="container d-none d-sm-block">
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
		<?$APPLICATION->IncludeComponent(
			"bitrix:catalog.element",
			"cartVil",
			array(
				"ACTION_VARIABLE" => "action",
				"ADD_DETAIL_TO_SLIDER" => "Y",
				"ADD_ELEMENT_CHAIN" => "Y",
				"ADD_PICT_PROP" => "DOP_FOTO",
				"ADD_PROPERTIES_TO_BASKET" => "N",
				"ADD_SECTIONS_CHAIN" => "Y",
				"ADD_TO_BASKET_ACTION" => array(
					0 => "BUY",
				),
				"ADD_TO_BASKET_ACTION_PRIMARY" => array(
					0 => "BUY",
				),
				"BACKGROUND_IMAGE" => "-",
				"BASKET_URL" => "/personal/basket.php",
				"BRAND_USE" => "N",
				"BROWSER_TITLE" => "-",
				"CACHE_GROUPS" => "Y",
				"CACHE_TIME" => "36000000",
				"CACHE_TYPE" => "A",
				"CHECK_SECTION_ID_VARIABLE" => "N",
				"COMPATIBLE_MODE" => "Y",
				"CONVERT_CURRENCY" => "N",
				"DETAIL_PICTURE_MODE" => array(
					0 => "POPUP",
					1 => "MAGNIFIER",
				),
				"DETAIL_URL" => "/poselki/#ELEMENT_CODE#/",
				"DISABLE_INIT_JS_IN_COMPONENT" => "N",
				"DISPLAY_COMPARE" => "N",
				"DISPLAY_NAME" => "Y",
				"DISPLAY_PREVIEW_TEXT_MODE" => "E",
				"ELEMENT_CODE" => $_REQUEST["ELEMENT_CODE"],
				"ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],
				"GIFTS_DETAIL_BLOCK_TITLE" => "Выберите один из подарков",
				"GIFTS_DETAIL_HIDE_BLOCK_TITLE" => "N",
				"GIFTS_DETAIL_PAGE_ELEMENT_COUNT" => "4",
				"GIFTS_DETAIL_TEXT_LABEL_GIFT" => "Подарок",
				"GIFTS_MAIN_PRODUCT_DETAIL_BLOCK_TITLE" => "Выберите один из товаров, чтобы получить подарок",
				"GIFTS_MAIN_PRODUCT_DETAIL_HIDE_BLOCK_TITLE" => "N",
				"GIFTS_MAIN_PRODUCT_DETAIL_PAGE_ELEMENT_COUNT" => "4",
				"GIFTS_MESS_BTN_BUY" => "Выбрать",
				"GIFTS_SHOW_DISCOUNT_PERCENT" => "Y",
				"GIFTS_SHOW_IMAGE" => "Y",
				"GIFTS_SHOW_NAME" => "Y",
				"GIFTS_SHOW_OLD_PRICE" => "Y",
				"HIDE_NOT_AVAILABLE_OFFERS" => "N",
				"IBLOCK_ID" => IBLOCK_ID,
				"IBLOCK_TYPE" => "content",
				"IMAGE_RESOLUTION" => "16by9",
				"LABEL_PROP" => array(
				),
				"LINK_ELEMENTS_URL" => "link.php?PARENT_ELEMENT_ID=#ELEMENT_ID#",
				"LINK_IBLOCK_ID" => "",
				"LINK_IBLOCK_TYPE" => "",
				"LINK_PROPERTY_SID" => "",
				"MAIN_BLOCK_PROPERTY_CODE" => array(
				),
				"MESSAGE_404" => "",
				"MESS_BTN_ADD_TO_BASKET" => "В корзину",
				"MESS_BTN_BUY" => "Купить",
				"MESS_BTN_SUBSCRIBE" => "Подписаться",
				"MESS_COMMENTS_TAB" => "Комментарии",
				"MESS_DESCRIPTION_TAB" => "Описание",
				"MESS_NOT_AVAILABLE" => "Нет в наличии",
				"MESS_PRICE_RANGES_TITLE" => "Цены",
				"MESS_PROPERTIES_TAB" => "Характеристики",
				"META_DESCRIPTION" => "-",
				"META_KEYWORDS" => "-",
				"OFFERS_LIMIT" => "0",
				"PARTIAL_PRODUCT_PROPERTIES" => "N",
				"PRICE_CODE" => array(
				),
				"PRICE_VAT_INCLUDE" => "N",
				"PRICE_VAT_SHOW_VALUE" => "N",
				"PRODUCT_ID_VARIABLE" => "id",
				"PRODUCT_INFO_BLOCK_ORDER" => "sku,props",
				"PRODUCT_PAY_BLOCK_ORDER" => "rating,price,priceRanges,quantityLimit,quantity,buttons",
				"PRODUCT_PROPERTIES" => array(
				),
				"PRODUCT_PROPS_VARIABLE" => "prop",
				"PRODUCT_QUANTITY_VARIABLE" => "quantity",
				"PRODUCT_SUBSCRIPTION" => "N",
				"PROPERTY_CODE" => array(
					0 => "",
					1 => "",
				),
				"SECTION_CODE" => "",
				"SECTION_CODE_PATH" => "",
				"SECTION_ID" => $_REQUEST["SECTION_ID"],
				"SECTION_ID_VARIABLE" => "SECTION_ID",
				"SECTION_URL" => "/poselki/",
				"SEF_MODE" => "Y",
				"SEF_RULE" => "/poselki/#ELEMENT_CODE#/",
				"SET_BROWSER_TITLE" => "Y",
				"SET_CANONICAL_URL" => "N",
				"SET_LAST_MODIFIED" => "Y",
				"SET_META_DESCRIPTION" => "Y",
				"SET_META_KEYWORDS" => "Y",
				"SET_STATUS_404" => "Y",
				"SET_TITLE" => "Y",
				"SET_VIEWED_IN_COMPONENT" => "N",
				"SHOW_404" => "Y",
				"SHOW_CLOSE_POPUP" => "N",
				"SHOW_DEACTIVATED" => "N",
				"SHOW_DISCOUNT_PERCENT" => "N",
				"SHOW_MAX_QUANTITY" => "N",
				"SHOW_OLD_PRICE" => "N",
				"SHOW_PRICE_COUNT" => "1",
				"SHOW_SLIDER" => "N",
				"STRICT_SECTION_CHECK" => "N",
				"TEMPLATE_THEME" => "",
				"USE_COMMENTS" => "N",
				"USE_ELEMENT_COUNTER" => "Y",
				"USE_ENHANCED_ECOMMERCE" => "N",
				"USE_GIFTS_DETAIL" => "N",
				"USE_GIFTS_MAIN_PR_SECTION_LIST" => "N",
				"USE_MAIN_ELEMENT_SECTION" => "N",
				"USE_PRICE_COUNT" => "N",
				"USE_PRODUCT_QUANTITY" => "N",
				"USE_RATIO_IN_RANGES" => "N",
				"USE_VOTE_RATING" => "N",
				"COMPONENT_TEMPLATE" => "cartVil",
				"SLIDER_INTERVAL" => "5000",
				"SLIDER_PROGRESS" => "Y",
				"COMPARE_PATH" => "/sravnenie/",
				"MESS_BTN_COMPARE" => "Сравнить",
				"BRAND_PROP_CODE" => array(
					0 => "DEVELOPER_ID",
					1 => "",
				),
				"FILE_404" => ""
			),
			false
		);?>
	</div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
