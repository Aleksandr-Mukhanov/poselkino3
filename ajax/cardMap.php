<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');

$item = $_REQUEST['item']; // dump($_REQUEST['item']);

if(isset($_COOKIE['comparison_vil']))
  $arComparison = explode('-',$_COOKIE['comparison_vil']);

if(isset($_COOKIE['favorites_vil']))
  $arFavorites = explode('-',$_COOKIE['favorites_vil']);

$generalParams['COMPARISON'] = ($arComparison && in_array($item['ID'],$arComparison)) ? 'Y' : 'N';
$generalParams['FAVORITES'] = ($arFavorites && in_array($item['ID'],$arFavorites)) ? 'Y' : 'N';
$generalParams['TEMPLATE_CARD'] = 'map';
?>
<div class="close-map"></div>
<?$APPLICATION->IncludeComponent(
	"bitrix:catalog.item",
	"poselok_index",
	array(
		"RESULT" => array(
			"ITEM" => $item,
			"TYPE" => "CARD",
			"BIG_LABEL" => "N",
			"BIG_DISCOUNT_PERCENT" => "N",
			"BIG_BUTTONS" => "N",
			"SCALABLE" => "N",
		),
		"PARAMS" => $generalParams,
		"COMPONENT_TEMPLATE" => "poselok_index"
	),
	false
);?>
