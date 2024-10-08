<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Участок / дом детально");
use Bitrix\Main\Page\Asset;
  // Яндекс.Карты
  Asset::getInstance()->addJs("https://api-maps.yandex.ru/2.1/?lang=ru_RU");
$offerType = $_REQUEST['OFFER_TYPE'];
$iblockID = ($offerType == 'plots') ? 5 : 6;?>
<main class="page page-home">
	<div class="bg-white pb-5">
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
    	"cartOffer",
    	array(
    		"ACTION_VARIABLE" => "action",
    		"ADD_DETAIL_TO_SLIDER" => "N",
    		"ADD_ELEMENT_CHAIN" => "N",
    		"ADD_PICT_PROP" => "DOP_PHOTO",
    		"ADD_PROPERTIES_TO_BASKET" => "N",
    		"ADD_SECTIONS_CHAIN" => "N",
    		"BACKGROUND_IMAGE" => "-",
    		"BASKET_URL" => "/personal/basket.php",
    		"BRAND_USE" => "N",
    		"BROWSER_TITLE" => "-",
    		"CACHE_GROUPS" => "Y",
    		"CACHE_TIME" => "86400",
    		"CACHE_TYPE" => "A",
    		"CHECK_SECTION_ID_VARIABLE" => "N",
    		"COMPARE_PATH" => "",
    		"COMPATIBLE_MODE" => "N",
    		"COMPOSITE_FRAME_MODE" => "A",
    		"COMPOSITE_FRAME_TYPE" => "AUTO",
    		"DETAIL_PICTURE_MODE" => array(
    			0 => "POPUP",
    			1 => "MAGNIFIER",
    		),
    		"DETAIL_URL" => "",
    		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
    		"DISPLAY_COMPARE" => "N",
    		"DISPLAY_NAME" => "Y",
    		"DISPLAY_PREVIEW_TEXT_MODE" => "E",
    		"ELEMENT_CODE" => $_REQUEST["ELEMENT_CODE"],
    		"ELEMENT_ID" => $_REQUEST["ELEMENT_ID"],
    		"FILE_404" => "",
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
    		"IBLOCK_ID" => $iblockID,
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
    		"MESS_BTN_COMPARE" => "Сравнить",
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
    		"PROPERTY_CODE" => array(
    			0 => "",
    			1 => "",
    		),
    		"SECTION_CODE" => "",
    		"SECTION_CODE_PATH" => "",
    		"SECTION_ID" => "",
    		"SECTION_ID_VARIABLE" => "SECTION_ID",
    		"SECTION_URL" => "",
    		"SEF_MODE" => "Y",
    		"SEF_RULE" => "",
    		"SET_BROWSER_TITLE" => "Y",
    		"SET_CANONICAL_URL" => "N",
    		"SET_LAST_MODIFIED" => "Y",
    		"SET_META_DESCRIPTION" => "Y",
    		"SET_META_KEYWORDS" => "Y",
    		"SET_STATUS_404" => "Y",
    		"SET_TITLE" => "Y",
    		"SHOW_404" => "Y",
    		"SHOW_DEACTIVATED" => "Y",
    		"SHOW_PRICE_COUNT" => "1",
    		"SHOW_SLIDER" => "N",
    		"STRICT_SECTION_CHECK" => "N",
    		"TEMPLATE_THEME" => "blue",
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
    		"COMPONENT_TEMPLATE" => "cartOffer"
    	),
    	false
    );?>
  </div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
