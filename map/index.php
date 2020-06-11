<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Карта поселков");
ini_set('memory_limit', '1024M');

use Bitrix\Main\Page\Asset;
  Asset::getInstance()->addJs('https://api-maps.yandex.ru/2.1/?apikey=0c55e225-bb2b-4b98-94a5-3390b6dbf643&lang=ru_RU');

  $shosse = $_REQUEST['SHOSSE_CODE'];
  $rayon = $_REQUEST['RAYON_CODE'];
  $typePos = $_REQUEST['TYPE_CODE'];
  $domPos = $_REQUEST['DOMA_CODE'];
  $mkadKM = $_REQUEST['MKAD_KM'];
  $priceURL = $_REQUEST['PRICE_URL'];
  $priceType = $_REQUEST['PRICE_TYPE'];
  $areaUrl = $_REQUEST['AREA_URL'];
  $areaType = $_REQUEST['AREA_TYPE'];
  $classCode = $_REQUEST['CLASS_CODE'];
  $commun = $_REQUEST['COMMUN'];
  $typeURL = $_REQUEST['TYPE_URL'];
  $plottage = $_REQUEST['PLOTTAGE'];

  // переопределим
  global $APPLICATION;
  $dir = $APPLICATION->GetCurDir();
  if (strpos($dir, 'kupit-uchastok') !== false) $domPos = 'noDom';
  if (strpos($dir, 'kupit-dom') !== false) $domPos = 'withDom';
  if (strpos($dir, 's-elektrichestvom') !== false) $commun = 'elektrichestvom';
  if (strpos($dir, 's-vodoprovodom') !== false) $commun = 'vodoprovodom';
  if (strpos($dir, 's-gazom') !== false) $commun = 'gazom';
  if (strpos($dir, 's-kommunikaciyami') !== false) $commun = 'kommunikaciyami';
  if (strpos($dir, 'snt') !== false) $typeURL = 'snt';
  if (strpos($dir, 'izhs') !== false) $typeURL = 'izhs';
  if (strpos($dir, 'ryadom-s-lesom') !== false) $typeURL = 'ryadom-s-lesom';
  if (strpos($dir, 'u-vody') !== false) $typeURL = 'u-vody';
  if (strpos($dir, 'u-ozera') !== false) $typeURL = 'u-ozera';
  if (strpos($dir, 'u-reki') !== false) $typeURL = 'u-reki';
  if (strpos($dir, 'ryadom-zhd-stanciya') !== false) $typeURL = 'ryadom-zhd-stanciya';
  if (strpos($dir, 'ryadom-avtobusnaya-ostanovka') !== false) $typeURL = 'ryadom-avtobusnaya-ostanovka';
  if (strpos($dir, 'kupit-letnij-dom') !== false) $typeURL = 'kupit-letnij-dom';
  if (strpos($dir, 'kupit-zimnij-dom') !== false) $typeURL = 'kupit-zimnij-dom';
  if (strpos($dir, 's-infrastrukturoj') !== false) $typeURL = 's-infrastrukturoj';
  if (strpos($dir, 's-ohranoj') !== false) $typeURL = 's-ohranoj';
  if (strpos($dir, 's-dorogami') !== false) $typeURL = 's-dorogami';

  global $arrFilter;
	 $arrFilter['!PROPERTY_SALES_PHASE'] = [254]; // уберем проданные
   $arrFilter['!PROPERTY_HIDE_POS'] = 273; // метка убрать из каталога

  require_once $_SERVER["DOCUMENT_ROOT"].'/poselki/seo-filter.php';
?>
<main class="page page-map">
  <div class="page-map__wrap">
    <div class="page-map__filter">
      <ol class="breadcrumb mt-0">
        <li class="breadcrumb-item"><a href="/">Главная</a></li>
        <li class="breadcrumb-item"><a href="/poselki/">Поселки</a></li>
        <li class="breadcrumb-item active" aria-current="page">Поиск по карте</li>
      </ol>
      <h1 class="mt-2">Поиск по карте
        <button class="d-lg-none ml-auto close close-filter btn-sm" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </h1>
      <?$APPLICATION->IncludeComponent(
        "bitrix:catalog.smart.filter",
        "map",
        array(
          "CACHE_GROUPS" => "Y",
          "CACHE_TIME" => "36000000",
          "CACHE_TYPE" => "N",
          "CONVERT_CURRENCY" => "N",
          "DISPLAY_ELEMENT_COUNT" => "Y",
          "FILTER_NAME" => "arrFilter",
          "FILTER_VIEW_MODE" => "horizontal",
          "HIDE_NOT_AVAILABLE" => "N",
          "IBLOCK_ID" => "1",
          "IBLOCK_TYPE" => "content",
          "PAGER_PARAMS_NAME" => "arrPager",
          "POPUP_POSITION" => "left",
          "SAVE_IN_SESSION" => "N",
          "SECTION_CODE" => "",
          "SECTION_CODE_PATH" => "",
          "SECTION_DESCRIPTION" => "-",
          "SECTION_ID" => $_REQUEST["SECTION_ID"],
          "SECTION_TITLE" => "-",
          "SEF_MODE" => "Y",
          "SEF_RULE" => "/poselki/filter/#SMART_FILTER_PATH#/apply/map/",
          "SMART_FILTER_PATH" => $_REQUEST["SMART_FILTER_PATH"],
          "TEMPLATE_THEME" => "green",
          "XML_EXPORT" => "N",
          "COMPONENT_TEMPLATE" => "poselkino"
        ),
        false
      );?>
    </div>
    <div class="page-map__container w-100 h-100">
      <button class="show-filter d-lg-none" type="button">Параметры поиска</button>
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
      		"CACHE_TYPE" => "A", // $cache
      		"COMPATIBLE_MODE" => "N",
      		"COMPONENT_TEMPLATE" => "poselkino",
      		"CONVERT_CURRENCY" => "N",
      		"CUSTOM_FILTER" => "",
      		"DETAIL_URL" => "/poselki/#ELEMENT_CODE#/",
      		"DISABLE_INIT_JS_IN_COMPONENT" => "N",
      		"DISPLAY_BOTTOM_PAGER" => "N",
      		"DISPLAY_COMPARE" => "N", // ���������
      		"DISPLAY_TOP_PAGER" => "N",
      		"ELEMENT_SORT_FIELD" => "sort",
      		"ELEMENT_SORT_FIELD2" => "SHOW_COUNTER",
      		"ELEMENT_SORT_ORDER" => "asc",
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
      		"MESS_BTN_ADD_TO_BASKET" => "� �������",
      		"MESS_BTN_BUY" => "������",
      		"MESS_BTN_DETAIL" => "���������",
      		"MESS_BTN_SUBSCRIBE" => "�����������",
      		"MESS_NOT_AVAILABLE" => "��� � �������",
      		"META_DESCRIPTION" => "-",
      		"META_KEYWORDS" => "-",
      		"OFFERS_LIMIT" => "5",
      		"PAGER_BASE_LINK_ENABLE" => "N",
      		"PAGER_DESC_NUMBERING" => "N",
      		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
      		"PAGER_SHOW_ALL" => "N",
      		"PAGER_SHOW_ALWAYS" => "N",
      		"PAGER_TEMPLATE" => "poselkino_nav",
      		"PAGER_TITLE" => "������",
      		"PAGE_ELEMENT_COUNT" => $cntAllVil,
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
      			12 => "COST_LAND_IN_CART",
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
      		"TYPE_CARD" => 'list change_type',
      		"TEMPLATE_CARD" => 'map', // карточки для карта
      	),
      	false
      );?>
    </div>
  </div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
