<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

$rsPropertyEnum = CIBlockPropertyEnum::GetList([],["CODE"=>"REGION"]);
while ($arPropertyEnum = $rsPropertyEnum->Fetch())
  $arResult['REGION'][$arPropertyEnum['ID']] = $arPropertyEnum['XML_ID'];

$rsPropertyEnum = CIBlockPropertyEnum::GetList([],["CODE"=>"SHOSSE"]);
while ($arPropertyEnum = $rsPropertyEnum->Fetch())
  $arResult['SHOSSE'][$arPropertyEnum['ID']] = $arPropertyEnum['XML_ID'];

// получим поселок
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>IBLOCK_ID,"ID"=>$arResult['ITEM']['PROPERTIES']['VILLAGE']['VALUE']);
$arSelect = Array("ID","NAME","PROPERTY_TRAIN","PROPERTY_TRAIN_TRAVEL_TIME","PROPERTY_TRAIN_VOKZAL","PROPERTY_AUTO_NO_JAMS",'PROPERTY_REGION','PROPERTY_SHOSSE','PROPERTY_MKAD','PROPERTY_DOP_FOTO');
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
if($arElement = $rsElements->Fetch()){
	// км от МКАД
	$km_MKAD = $arElement['PROPERTY_MKAD_VALUE'];
	switch ($km_MKAD) {
		case $km_MKAD <= 10: $url_km_MKAD = "do-10-km-ot-".ROAD_URL; break;
		case $km_MKAD <= 15: $url_km_MKAD = "do-15-km-ot-".ROAD_URL; break;
		case $km_MKAD <= 20: $url_km_MKAD = "do-20-km-ot-".ROAD_URL; break;
		case $km_MKAD <= 25: $url_km_MKAD = "do-25-km-ot-".ROAD_URL; break;
		case $km_MKAD <= 30: $url_km_MKAD = "do-30-km-ot-".ROAD_URL; break;
		case $km_MKAD <= 35: $url_km_MKAD = "do-35-km-ot-".ROAD_URL; break;
		case $km_MKAD <= 40: $url_km_MKAD = "do-40-km-ot-".ROAD_URL; break;
		case $km_MKAD <= 45: $url_km_MKAD = "do-45-km-ot-".ROAD_URL; break;
		case $km_MKAD <= 50: $url_km_MKAD = "do-50-km-ot-".ROAD_URL; break;
		case $km_MKAD <= 55: $url_km_MKAD = "do-55-km-ot-".ROAD_URL; break;
		case $km_MKAD <= 60: $url_km_MKAD = "do-60-km-ot-".ROAD_URL; break;
		case $km_MKAD <= 65: $url_km_MKAD = "do-65-km-ot-".ROAD_URL; break;
		case $km_MKAD <= 70: $url_km_MKAD = "do-70-km-ot-".ROAD_URL; break;
		case $km_MKAD <= 75: $url_km_MKAD = "do-75-km-ot-".ROAD_URL; break;
		case $km_MKAD <= 80: $url_km_MKAD = "do-80-km-ot-".ROAD_URL; break;

		default: $url_km_MKAD = "do-80-km-ot-".ROAD_URL; break;
	}

	foreach ($arElement['PROPERTY_SHOSSE_VALUE'] as $idEnumHW => $value) {
		$arShosse[] = [
			'valEnumHW' => $arResult['SHOSSE'][$idEnumHW],
			'nameHW' => $value,
			'colorHW' => getColorRoad($idEnumHW)
		];
	}

	$arResult['VILLAGE'] = [
		'NAME' => $arElement['NAME'],
		'PROPERTY_TRAIN' => $arElement['PROPERTY_TRAIN_VALUE'],
		'TRAIN_TRAVEL_TIME' => $arElement['PROPERTY_TRAIN_TRAVEL_TIME_VALUE'],
		'TRAIN_VOKZAL' => $arElement['PROPERTY_TRAIN_VOKZAL_VALUE'],
		'AUTO_NO_JAMS' => $arElement['PROPERTY_AUTO_NO_JAMS_VALUE'],
		'REGION' => $arElement['PROPERTY_REGION_VALUE'],
		'REGION_ENUM_ID' => $arElement['PROPERTY_REGION_ENUM_ID'],
		'SHOSSE' => $arShosse,
		'km_MKAD' => $km_MKAD,
		'url_km_MKAD' => $url_km_MKAD,
	];
	unset($arShosse);

  $arResult['PHOTO_VILLAGE'] = $arElement['PROPERTY_DOP_FOTO_VALUE'];
}
?>
