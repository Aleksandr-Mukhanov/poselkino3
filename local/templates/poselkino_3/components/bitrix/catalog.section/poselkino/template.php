<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use \Bitrix\Main\Localization\Loc;

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 */

$this->setFrameMode(true);

// кол-во поселков
$this->SetViewTarget('COUNT_POS');
echo $arResult['NAV_RESULT']->NavRecordCount;
$this->EndViewTarget();
$GLOBALS['COUNT_POS'] = $arResult['NAV_RESULT']->NavRecordCount;

if (!empty($arResult['NAV_RESULT']))
{
	$navParams =  array(
		'NavPageCount' => $arResult['NAV_RESULT']->NavPageCount,
		'NavPageNomer' => $arResult['NAV_RESULT']->NavPageNomer,
		'NavNum' => $arResult['NAV_RESULT']->NavNum
	);
}
else
{
	$navParams = array(
		'NavPageCount' => 1,
		'NavPageNomer' => 1,
		'NavNum' => $this->randString()
	);
}

$showTopPager = false;
$showBottomPager = false;
$showLazyLoad = false;

if ($arParams['PAGE_ELEMENT_COUNT'] > 0 && $navParams['NavPageCount'] > 1)
{
	$showTopPager = $arParams['DISPLAY_TOP_PAGER'];
	$showBottomPager = $arParams['DISPLAY_BOTTOM_PAGER'];
	$showLazyLoad = $arParams['LAZY_LOAD'] === 'Y' && $navParams['NavPageNomer'] != $navParams['NavPageCount'];
}

$templateLibrary = array('popup', 'ajax', 'fx');
$currencyList = '';

if (!empty($arResult['CURRENCIES']))
{
	$templateLibrary[] = 'currency';
	$currencyList = CUtil::PhpToJSObject($arResult['CURRENCIES'], false, true, true);
}

$templateData = array(
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'TEMPLATE_LIBRARY' => $templateLibrary,
	'CURRENCIES' => $currencyList
);
unset($currencyList, $templateLibrary);

$elementEdit = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_EDIT');
$elementDelete = CIBlock::GetArrayByID($arParams['IBLOCK_ID'], 'ELEMENT_DELETE');
$elementDeleteParams = array('CONFIRM' => GetMessage('CT_BCS_TPL_ELEMENT_DELETE_CONFIRM'));

$positionClassMap = array(
	'left' => 'product-item-label-left',
	'center' => 'product-item-label-center',
	'right' => 'product-item-label-right',
	'bottom' => 'product-item-label-bottom',
	'middle' => 'product-item-label-middle',
	'top' => 'product-item-label-top'
);

$discountPositionClass = '';
if ($arParams['SHOW_DISCOUNT_PERCENT'] === 'Y' && !empty($arParams['DISCOUNT_PERCENT_POSITION']))
{
	foreach (explode('-', $arParams['DISCOUNT_PERCENT_POSITION']) as $pos)
	{
		$discountPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$labelPositionClass = '';
if (!empty($arParams['LABEL_PROP_POSITION']))
{
	foreach (explode('-', $arParams['LABEL_PROP_POSITION']) as $pos)
	{
		$labelPositionClass .= isset($positionClassMap[$pos]) ? ' '.$positionClassMap[$pos] : '';
	}
}

$arParams['~MESS_BTN_BUY'] = $arParams['~MESS_BTN_BUY'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_BUY');
$arParams['~MESS_BTN_DETAIL'] = $arParams['~MESS_BTN_DETAIL'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_DETAIL');
$arParams['~MESS_BTN_COMPARE'] = $arParams['~MESS_BTN_COMPARE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_COMPARE');
$arParams['~MESS_BTN_SUBSCRIBE'] = $arParams['~MESS_BTN_SUBSCRIBE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_SUBSCRIBE');
$arParams['~MESS_BTN_ADD_TO_BASKET'] = $arParams['~MESS_BTN_ADD_TO_BASKET'] ?: Loc::getMessage('CT_BCS_TPL_MESS_BTN_ADD_TO_BASKET');
$arParams['~MESS_NOT_AVAILABLE'] = $arParams['~MESS_NOT_AVAILABLE'] ?: Loc::getMessage('CT_BCS_TPL_MESS_PRODUCT_NOT_AVAILABLE');
$arParams['~MESS_SHOW_MAX_QUANTITY'] = $arParams['~MESS_SHOW_MAX_QUANTITY'] ?: Loc::getMessage('CT_BCS_CATALOG_SHOW_MAX_QUANTITY');
$arParams['~MESS_RELATIVE_QUANTITY_MANY'] = $arParams['~MESS_RELATIVE_QUANTITY_MANY'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_MANY');
$arParams['~MESS_RELATIVE_QUANTITY_FEW'] = $arParams['~MESS_RELATIVE_QUANTITY_FEW'] ?: Loc::getMessage('CT_BCS_CATALOG_RELATIVE_QUANTITY_FEW');

$arParams['MESS_BTN_LAZY_LOAD'] = $arParams['MESS_BTN_LAZY_LOAD'] ?: Loc::getMessage('CT_BCS_CATALOG_MESS_BTN_LAZY_LOAD');

$generalParams = array(
	'SHOW_DISCOUNT_PERCENT' => $arParams['SHOW_DISCOUNT_PERCENT'],
	'PRODUCT_DISPLAY_MODE' => $arParams['PRODUCT_DISPLAY_MODE'],
	'SHOW_MAX_QUANTITY' => $arParams['SHOW_MAX_QUANTITY'],
	'RELATIVE_QUANTITY_FACTOR' => $arParams['RELATIVE_QUANTITY_FACTOR'],
	'MESS_SHOW_MAX_QUANTITY' => $arParams['~MESS_SHOW_MAX_QUANTITY'],
	'MESS_RELATIVE_QUANTITY_MANY' => $arParams['~MESS_RELATIVE_QUANTITY_MANY'],
	'MESS_RELATIVE_QUANTITY_FEW' => $arParams['~MESS_RELATIVE_QUANTITY_FEW'],
	'SHOW_OLD_PRICE' => $arParams['SHOW_OLD_PRICE'],
	'USE_PRODUCT_QUANTITY' => $arParams['USE_PRODUCT_QUANTITY'],
	'PRODUCT_QUANTITY_VARIABLE' => $arParams['PRODUCT_QUANTITY_VARIABLE'],
	'ADD_TO_BASKET_ACTION' => $arParams['ADD_TO_BASKET_ACTION'],
	'ADD_PROPERTIES_TO_BASKET' => $arParams['ADD_PROPERTIES_TO_BASKET'],
	'PRODUCT_PROPS_VARIABLE' => $arParams['PRODUCT_PROPS_VARIABLE'],
	'SHOW_CLOSE_POPUP' => $arParams['SHOW_CLOSE_POPUP'],
	'DISPLAY_COMPARE' => $arParams['DISPLAY_COMPARE'],
	'COMPARE_PATH' => $arParams['COMPARE_PATH'],
	'COMPARE_NAME' => $arParams['COMPARE_NAME'],
	'PRODUCT_SUBSCRIPTION' => $arParams['PRODUCT_SUBSCRIPTION'],
	'PRODUCT_BLOCKS_ORDER' => $arParams['PRODUCT_BLOCKS_ORDER'],
	'LABEL_POSITION_CLASS' => $labelPositionClass,
	'DISCOUNT_POSITION_CLASS' => $discountPositionClass,
	'SLIDER_INTERVAL' => $arParams['SLIDER_INTERVAL'],
	'SLIDER_PROGRESS' => $arParams['SLIDER_PROGRESS'],
	'~BASKET_URL' => $arParams['~BASKET_URL'],
	'~ADD_URL_TEMPLATE' => $arResult['~ADD_URL_TEMPLATE'],
	'~BUY_URL_TEMPLATE' => $arResult['~BUY_URL_TEMPLATE'],
	'~COMPARE_URL_TEMPLATE' => $arResult['~COMPARE_URL_TEMPLATE'],
	'~COMPARE_DELETE_URL_TEMPLATE' => $arResult['~COMPARE_DELETE_URL_TEMPLATE'],
	'TEMPLATE_THEME' => $arParams['TEMPLATE_THEME'],
	'USE_ENHANCED_ECOMMERCE' => $arParams['USE_ENHANCED_ECOMMERCE'],
	'DATA_LAYER_NAME' => $arParams['DATA_LAYER_NAME'],
	'BRAND_PROPERTY' => $arParams['BRAND_PROPERTY'],
	'MESS_BTN_BUY' => $arParams['~MESS_BTN_BUY'],
	'MESS_BTN_DETAIL' => $arParams['~MESS_BTN_DETAIL'],
	'MESS_BTN_COMPARE' => $arParams['~MESS_BTN_COMPARE'],
	'MESS_BTN_SUBSCRIBE' => $arParams['~MESS_BTN_SUBSCRIBE'],
	'MESS_BTN_ADD_TO_BASKET' => $arParams['~MESS_BTN_ADD_TO_BASKET'],
	'MESS_NOT_AVAILABLE' => $arParams['~MESS_NOT_AVAILABLE']
);

$obName = 'ob'.preg_replace('/[^a-zA-Z0-9_]/', 'x', $this->GetEditAreaId($navParams['NavNum']));
$containerName = 'container-'.$navParams['NavNum'];

// dump($arParams);
// dump($arResult);
?>
<?if ($arParams['TEMPLATE_CARD'] == 'poselok'){ // в разделе ?>

<div class="page__content-list list w-100">
  <div class="container">
    <div class="list--grid" data-entity="<?=$containerName?>" data-cnt-pos=<?=count($arResult['ITEMS'])?>>

	<?}elseif($arParams['TEMPLATE_CARD'] == 'map'){ // на карте?>

		<div id="pageMapContainer" style="width: 100%; height: 100%;"></div>
		<div class="card-map">
			<div class="close-map"></div>
		</div>

	<?}
	if (!empty($arResult['ITEMS']) && !empty($arResult['ITEM_ROWS']))
	{
		$areaIds = array();

		foreach ($arResult['ITEMS'] as $item)
		{
			$uniqueId = $item['ID'].'_'.md5($this->randString().$component->getAction());
			$areaIds[$item['ID']] = $this->GetEditAreaId($uniqueId);
			$this->AddEditAction($uniqueId, $item['EDIT_LINK'], $elementEdit);
			$this->AddDeleteAction($uniqueId, $item['DELETE_LINK'], $elementDelete, $elementDeleteParams);
			// dump($item);
			if($arParams['TEMPLATE_CARD'] == 'map'){ // на карте
				// создадим массив меток для карты
				$adresItem = $item['PROPERTIES']['OBLAST']['VALUE'].", ".$item['PROPERTIES']['REGION']['VALUE']." р-он, ".$item['PROPERTIES']['HIGTWAY']['VALUE'][0]." шоссе, ".$item['PROPERTIES']['MKAD']['VALUE']." км. от МКАД ";
				$point = $item['PROPERTIES']['COORDINATES']['VALUE'];
				//$point2 = curl_get_coordinates($adresItem); // сполучаем координаты метки
				$arMapItem[$item['ID']] = [
					"NAME" => $item["NAME"],
					"adresItem" => $adresItem,
					"point" => $point,
					//"point2" => $point2,
				];
				$arResult['ITEMS_JSON'][$item['ID']] = json_encode($item,JSON_UNESCAPED_SLASHES);
			}
		}

if($arParams['TEMPLATE_CARD'] != 'map'){ // в разделе

		foreach ($arResult['ITEM_ROWS'] as $rowData)
		{
			$rowItems = array_splice($arResult['ITEMS'], 0, $rowData['COUNT']);
			// dump($_COOKIE); // разбираем куки
			if(isset($_COOKIE['comparison_vil'])){
				$arComparison = explode('-',$_COOKIE['comparison_vil']);
			}
			if(isset($_COOKIE['favorites_vil'])){
				$arFavorites = explode('-',$_COOKIE['favorites_vil']);
			}
			foreach ($rowItems as $item){ // вывод карточек
				$generalParams['COMPARISON'] = (in_array($item['ID'],$arComparison)) ? 'Y' : 'N';
				$generalParams['FAVORITES'] = (in_array($item['ID'],$arFavorites)) ? 'Y' : 'N';
				$generalParams['TEMPLATE_CARD'] = $arParams['TEMPLATE_CARD'];?>
				<?$APPLICATION->IncludeComponent(
					'bitrix:catalog.item',
					$arParams['TEMPLATE_CARD'],
					array(
						'RESULT' => array(
							'ITEM' => $item,
							'AREA_ID' => $areaIds[$item['ID']],
							'TYPE' => $rowData['TYPE'],
							'BIG_LABEL' => 'N',
							'BIG_DISCOUNT_PERCENT' => 'N',
							'BIG_BUTTONS' => 'N',
							'SCALABLE' => 'N'
						),
						'PARAMS' => $generalParams
							+ array('SKU_PROPS' => $arResult['SKU_PROPS'][$item['IBLOCK_ID']])
					),
					$component,
					array('HIDE_ICONS' => 'Y')
				);?>
			<?}
		}
}
		unset($generalParams, $rowItems);
	}

if($arParams['TEMPLATE_CARD'] == 'poselok'){ // в разделе ?>

		</div>
	</div>
</div>

<?}elseif($arParams['TEMPLATE_CARD'] == 'map'){ // на карте ?>

	<script>
		function loadMaps() {
			ymaps.ready(function() {

				var myMap = new ymaps.Map("pageMapContainer", {
					center: [55.76, 37.64], // Координаты центра карты
					zoom: 7 // Уровень масштабирования
				});

				var myClusterer = new ymaps.Clusterer({
					preset: 'islands#redClusterIcons',
				});
				var imageIcon = '/assets/img/site/placeholder-map.svg';

				<?foreach($arMapItem as $id => $item){ // выводим метки ?>

					var myPlacemark_<?=$id?> = new ymaps.Placemark([<?=$item["point"]?>], {
						hintContent: '<?=$item["NAME"]?>',
						id: 'mark_<?=$id?>',
					},{
						iconLayout: 'default#image',
						iconImageHref: imageIcon,
						iconImageSize: [30, 42],
					});

					// клик по метке
					myPlacemark_<?=$id?>.events.add('click', function() {

						item = <?=$arResult['ITEMS_JSON'][$id]?>,

						$.post("/ajax/cardMap.php",
						  { item: item },
						  function(data) {

						    $('.card-map').html(data);

								// заново переопределим некоторые события
								// слайдер изображений
							  $('.photo__list, .card-photo__list').not('.slick-initialized').slick(getPhoto()).on('init reInit afterChange', function(event, slick, currentSlide, nextSlide) {
							    var counter = $(this).parent('.photo').find('.photo__count .current');
							    if (currentSlide) {
							      console.log(currentSlide, counter);

							      counter.text(currentSlide + 1);
							    } else {
							      counter.text(1);
							    }
							  });
								// чтобы отделять 3 знака в числах
								$('.split-number').each(function(index, el) {
									var text_number = $(this).text();
									var text_number = String(text_number).replace(/(\d)(?=(\d{3})+([^\d]|$))/g, '$1 ');
									$(this).text(text_number);
								});
							  // замена рубля
								$('.rep_rubl').html('<span class="rubl">a</span>');
						  }
						);

						$('.card-map').show(0).css({'z-index':'99999999999'});
					});

					myMap.geoObjects.add(myPlacemark_<?=$id?>);
					myClusterer.add(myPlacemark_<?=$id?>);
				<?}?>
				myMap.geoObjects.add(myClusterer);
			});
		}
		setTimeout(loadMaps, 500);
	</script>
<?}
	if ($showBottomPager)
	{
		?>
		<div class="page__pagination" data-pagination-num="<?=$navParams['NavNum']?>">
	    <div class="container">
	      <nav aria-label="Постраничная навигация">
					<ul class="pagination d-none d-md-flex justify-content">
	      		<?=$arResult['NAV_STRING']?>
				  </ul>
					<ul class="pagination d-flex d-md-none justify-content-around">
	      		<?=$arResult['NAV_STRING']?>
				  </ul>
	      </nav>
	    </div>
	  </div>
		<?
	}
	if ($showLazyLoad)
	{
		?>
		<div class="row bx-<?=$arParams['TEMPLATE_THEME']?>">
			<div class="btn btn-default btn-lg center-block" style="margin: 15px;"
				data-use="show-more-<?=$navParams['NavNum']?>">
				<?=$arParams['MESS_BTN_LAZY_LOAD']?>
			</div>
		</div>
		<?
	}

$signer = new \Bitrix\Main\Security\Sign\Signer;
$signedTemplate = $signer->sign($templateName, 'catalog.section');
$signedParams = $signer->sign(base64_encode(serialize($arResult['ORIGINAL_PARAMETERS'])), 'catalog.section');
?>
