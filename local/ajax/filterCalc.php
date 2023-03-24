<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
	Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

$formData = $_REQUEST['formData']; // dump($formData);

$arFilter['ACTIVE'] = 'Y';
$arFilter['!PROPERTY_SALES_PHASE'] = [PROP_SOLD_ID]; // уберем проданные
$arFilter['!PROPERTY_HIDE_POS'] = PROP_HIDE_ID; // метка убрать из каталога

$arInfra = ['MAGAZIN','CERKOV','SHKOLA','DETSAD','CAFE','AVTOZAPRAVKA','APTEKA','STROYMATERIALI'];
$iblockID = IBLOCK_ID;
$filterURL_DIR = '/poselki/';

// переберем данные
foreach ($formData as $data)
{
	if ($data['value'])
	{
		if ($data['name'] == 'FILTER_TYPE')
		{
			if ($data['value'] == 'filterPlots'){
				$iblockID = 5;
				$filterURL_DIR = '/kupit-uchastki/';
			}
			elseif ($data['value'] == 'filterHouse'){
				// $iblockID = 6;
				// $filterURL_DIR = '/doma/';
				$arDoma = ['withDom','housePlot'];
				$arFilter['PROPERTY_DOMA'] = [PROP_WITH_DOM,PROP_HOUSE_PLOT];
				$urlPath .= 'doma-is-'.implode('-or-',$arDoma).'/';
			}
		}
		elseif ($data['name'] == 'MKAD_MIN')
		{
			$mkadKM_ot = $data['value'];
			$mkadURLfrom = '-from-'.$mkadKM_ot;
		}
		elseif ($data['name'] == 'MKAD_MAX')
		{
			$mkadKM_do = $data['value'];
			$mkadURLto = '-to-'.$mkadKM_do;
		}
		elseif ($data['name'] == 'COST_LAND_IN_CART_MIN')
		{
			$price_ot = $data['value'];
			$priceURLfrom = '-from-'.$price_ot;
		}
		elseif ($data['name'] == 'COST_LAND_IN_CART_MAX')
		{
			$price_do = $data['value'];
			$priceURLto = '-to-'.$price_do;
		}
		elseif ($data['name'] == 'HOUSE_AREA_MIN')
		{
			$houseArea_ot = $data['value'];
			$houseAreaURLfrom = '-from-'.$houseArea_ot;
		}
		elseif ($data['name'] == 'HOUSE_AREA_MAX')
		{
			$houseArea_do = $data['value'];
			$houseAreaURLto = '-to-'.$houseArea_do;
		}
		elseif ($data['name'] == 'SHOSSE')
		{
			if ($iblockID == IBLOCK_ID)
				$arFilter['PROPERTY_SHOSSE'][] = getNamesList($data['value'],'SHOSSE',$iblockID)['ID'];
			else
				$arFilter['PROPERTY_SHOSSE'][] = $data['value'];

			$arShosse[] = $data['value'];
		}
		elseif ($data['name'] == 'REGION')
		{
			if ($iblockID == IBLOCK_ID)
				$arFilter['PROPERTY_REGION'][] = getNamesList($data['value'],'REGION',$iblockID)['ID'];
			else
				$arFilter['PROPERTY_REGION'][] = $data['value'];

			$arRegion[] = $data['value'];
		}
		elseif ($data['name'] == 'PLOTTAGE_MIN')
		{
			$plottage_ot = $data['value'];
			$plottageURLfrom = '-from-'.$plottage_ot;
		}
		elseif ($data['name'] == 'PLOTTAGE_MAX')
		{
			$plottage_do = $data['value'];
			$plottageURLto = '-to-'.$plottage_do;
		}
		elseif ($data['name'] == 'RAILWAY_KM')
		{
			$arFilter['<=PROPERTY_RAILWAY_KM'] = $data['value'];
			$urlPath .= 'railway_km-to-'.$data['value'].'/';
		}
		elseif ($data['name'] == 'TYPE_PERMITTED')
		{
			$arFilter['PROPERTY_TYPE'][] = getNamesList($data['value'],'TYPE',$iblockID)['ID'];
			$arType[] = $data['value'];
		}
		// if ($data['name'] == 'INS')
		// {
		// 	$arFilter['PROPERTY_INS'] = getNamesList($data['value'],'INS')['ID'];
		// 	$urlPath .= 'ins-is-'.$data['value'].'/';
		// }
		// if ($data['name'] == 'ACTION')
		// {
		// 	$arFilter['PROPERTY_ACTION'] = getNamesList($data['value'],'ACTION')['ID'];
		// 	$urlPath .= 'action-is-'.$data['value'].'/';
		// }
		elseif ($data['name'] == 'ROADS_IN_VIL')
		{
			$arFilter['PROPERTY_ROADS_IN_VIL'][] = getNamesList($data['value'],'ROADS_IN_VIL')['ID'];
			$arRoads[] = $data['value'];
		}
		elseif ($data['name'] == 'ARRANGE')
		{
			$arFilter['PROPERTY_ARRANGE'][] = getNamesList($data['value'],'ARRANGE')['ID'];
			$arArrange[] = $data['value'];
		}
		elseif ($data['name'] == 'WATER')
		{
			$arWaterList = ['river','lake','pond'];
			foreach ($arWaterList as $value) {
				$arFilter['PROPERTY_WATER'][] = getNamesList($value,'WATER',$iblockID)['ID'];
				$arWater[] = $value;
			}
		}
		elseif ($data['name'] == 'LES')
		{
			$arLesList = ['conif','pine','berez','mixed'];
			foreach ($arLesList as $value) {
				$arFilter['PROPERTY_LES'][] = getNamesList($value,'LES',$iblockID)['ID'];
				$arLes[] = $value;
			}
		}
		elseif ($data['name'] == 'READY_STAGE')
		{
			$arFilter['PROPERTY_READY_STAGE'][] = getNamesList($data['value'],'READY_STAGE')['ID'];
			$arReadyStage[] = $data['value'];
		}
		elseif ($data['name'] == 'HOUSE_DECOR')
		{
			$arFilter['PROPERTY_HOUSE_DECOR'][] = getNamesList($data['value'],'HOUSE_DECOR')['ID'];
			$arHouseDecor[] = $data['value'];
		}
		elseif ($data['name'] == 'MATERIAL_HOUSE')
		{
			$arFilter['PROPERTY_MATERIAL_HOUSE'][] = getNamesList($data['value'],'MATERIAL_HOUSE')['ID'];
			$arMaterialHouse[] = $data['value'];
		}
		elseif (in_array($data['name'],$arInfra))
		{
			$arPropList = ['in_vil','rad_5_km'];
			foreach ($arPropList as $value) {
				$arFilter['PROPERTY_'.$data['name']][] = getNamesList($value,$data['name'])['ID'];
				$arProp[$data['name']][] = $value;
			}
		}
		else
		{
			$arFilter['PROPERTY_'.$data['name']] = getNamesList($data['value'],$data['name'],$iblockID)['ID'];
			$urlPath .= $data['name'].'-is-'.$data['value'].'/';
		}
	}
}

if ($mkadKM_ot || $mkadKM_do)
{
	if (!$mkadKM_do)
		$arFilter['>=PROPERTY_MKAD'] = $mkadKM_ot;
	else
		$arFilter['><PROPERTY_MKAD'] = [$mkadKM_ot,$mkadKM_do];

	$urlPath .= 'mkad'.$mkadURLfrom.$mkadURLto.'/';
}

if ($price_ot || $price_do)
{
	$propertyPrice = ($iblockID == IBLOCK_ID) ? 'COST_LAND_IN_CART' : 'PRICE';

	if (!$price_do)
		$arFilter['>=PROPERTY_'.$propertyPrice] = $price_ot;
	else
		$arFilter['><PROPERTY_'.$propertyPrice] = [$price_ot,$price_do];

	$urlPath .= 'cost_land_in_cart'.$priceURLfrom.$priceURLto.'/';
}

if ($houseArea_ot || $houseArea_do)
{
	if (!$houseArea_do)
		$arFilter['>=PROPERTY_HOUSE_AREA'] = $houseArea_ot;
	else
		$arFilter['><PROPERTY_HOUSE_AREA'] = [$houseArea_ot,$houseArea_do];

	$urlPath .= 'house_area'.$houseAreaURLfrom.$houseAreaURLto.'/';
}

if ($arShosse) $urlPath .= 'shosse-is-'.implode('-or-',$arShosse).'/';

if ($arRegion) $urlPath .= 'region-is-'.implode('-or-',$arRegion).'/';

if ($plottage_ot || $plottage_do)
{
	if (!$plottage_do)
		$arFilter['>=PROPERTY_PLOTTAGE'] = $plottage_ot;
	else
		$arFilter['><PROPERTY_PLOTTAGE'] = [$plottage_ot,$plottage_do];

	$urlPath .= 'plottage'.$plottageURLfrom.$plottageURLto.'/';
}

if ($arType) $urlPath .= 'type-is-'.implode('-or-',$arType).'/';

if ($arRoads) $urlPath .= 'roads_in_vil-is-'.implode('-or-',$arRoads).'/';

if ($arArrange) $urlPath .= 'arrange-is-'.implode('-or-',$arArrange).'/';

if ($arReadyStage) $urlPath .= 'ready_stage-is-'.implode('-or-',$arReadyStage).'/';

if ($arHouseDecor) $urlPath .= 'house_decor-is-'.implode('-or-',$arHouseDecor).'/';

if ($arMaterialHouse) $urlPath .= 'material_house-is-'.implode('-or-',$arMaterialHouse).'/';

if ($arWater) $urlPath .= 'water-is-'.implode('-or-',$arWater).'/';

if ($arLes) $urlPath .= 'les-is-'.implode('-or-',$arLes).'/';

if ($arProp)
	foreach ($arProp as $key => $value)
		$urlPath .= $key.'-is-'.implode('-or-',$value).'/';

$arOrder = ['SORT'=>'ASC'];
$arFilter['IBLOCK_ID'] = $iblockID;
// участки из СПБ
if ($iblockID == 5 && in_array($_SERVER['HTTP_HOST'],SITES_DIR)) $arFilter['PROPERTY_AREA'] = PLOTS_PROP_AREA;
$arSelect = ['ID','NAME'];
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
$arResult['cntElements'] = $rsElements->result->num_rows;

$arResult['filterURL'] = ($urlPath) ? strtolower($filterURL_DIR.'filter/'.$urlPath.'apply/') : $filterURL_DIR;

// dump($arFilter);
echo json_encode($arResult);
?>
