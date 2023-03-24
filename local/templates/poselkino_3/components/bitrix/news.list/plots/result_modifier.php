<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */

foreach($arResult["ITEMS"] as $key => $arOffer)
{ // dump($arOffer);
	// сформируем фото
	if ($arOffer["PREVIEW_PICTURE"]) $arPhoto[] = ResizeIMG($arOffer["PREVIEW_PICTURE"]);
	if ($arOffer["DETAIL_PICTURE"]) $arPhoto[] = ResizeIMG($arOffer["DETAIL_PICTURE"]);
	// if ($arOffer['PROPERTIES']['DOP_PHOTO']['VALUE']){
	// 	foreach ($arOffer['PROPERTIES']['DOP_PHOTO']['VALUE'] as $val)
	// 		$arPhoto[] = ResizeIMG($val);
	// 	shuffle($arPhoto);
	// }
	$arResult["ITEMS"][$key]['IMG'] = $arPhoto;

	$arVillageIDs[] = $arOffer['PROPERTIES']['VILLAGE']['VALUE'];
}

$rsPropertyEnum = CIBlockPropertyEnum::GetList([],["CODE"=>"REGION"]);
while ($arPropertyEnum = $rsPropertyEnum->Fetch())
  $arResult['REGION'][$arPropertyEnum['ID']] = $arPropertyEnum['XML_ID'];

$rsPropertyEnum = CIBlockPropertyEnum::GetList([],["CODE"=>"SHOSSE"]);
while ($arPropertyEnum = $rsPropertyEnum->Fetch())
  $arResult['SHOSSE'][$arPropertyEnum['ID']] = $arPropertyEnum['XML_ID'];

if ($arVillageIDs)
{
	// получим поселки
	$arOrder = Array('SORT'=>'ASC');
	$arFilter = Array('IBLOCK_ID'=>1,'ID'=>$arVillageIDs);
	$arSelect = Array('ID','NAME','CODE','PROPERTY_REGION','PROPERTY_SHOSSE','PROPERTY_MKAD','PROPERTY_DOP_FOTO','PROPERTY_TRAIN','PROPERTY_TRAIN_TRAVEL_TIME','PROPERTY_TRAIN_VOKZAL');
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	while ($arElement = $rsElements->Fetch())
	{ // dump($arElement);
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
		$arElement['km_MKAD'] = $km_MKAD;
		$arElement['url_km_MKAD'] = $url_km_MKAD;

		foreach ($arElement['PROPERTY_SHOSSE_VALUE'] as $idEnumHW => $value) {
			$arElement['SHOSSE'][] = [
				'valEnumHW' => $arResult['SHOSSE'][$idEnumHW],
				'nameHW' => $value,
				'colorHW' => getColorRoad($idEnumHW)
			];
		}

		$arResult['arVillage'][$arElement['ID']] = $arElement;
	} // dump($arResult['arVillage']);
}
