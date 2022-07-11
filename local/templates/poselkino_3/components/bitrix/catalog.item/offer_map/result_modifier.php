<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
// получим участки поселка
$arOrder = Array("PROPERTY_PRICE"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>5,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$arResult['ITEM']['ID']);
$arNavParams = ['nPageSize'=>1,"bShowAll" => false];
$arSelect = Array("ID","CODE","PREVIEW_PICTURE","PROPERTY_PLOTTAGE","PROPERTY_PRICE","PROPERTY_DOP_PHOTO","PROPERTY_NUMBER");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,$arNavParams,$arSelect);
while($arElement = $rsElements->GetNext()){
	// соберем фото
	if($arElement["PREVIEW_PICTURE"])$arPhoto = ResizeIMG($arElement["PREVIEW_PICTURE"]);
	// if($arElement["DETAIL_PICTURE"])$arPhoto[] = ResizeIMG($arElement["DETAIL_PICTURE"]);
	// if($arElement["PROPERTY_DOP_PHOTO_VALUE"]){
	// 	foreach ($arElement["PROPERTY_DOP_PHOTO_VALUE"] as $key => $val) {
	// 		$arPhoto[] = ResizeIMG($val);
	// 	}
	// }
	// shuffle($arPhoto);
	// мин и макс площадь
	$plottage = $arElement["PROPERTY_PLOTTAGE_VALUE"];
	$minArea = ($minArea < $plottage) ? $plottage : $minArea;
	$maxArea = ($maxArea < $plottage) ? $plottage : $maxArea;
	// соберем участки
	$arPlots[$arElement["ID"]] = [
		"ID" => $arElement["ID"],
		"NAME" => $arElement["NAME"],
		"URL" => '/kupit-uchastki/uchastok-'.$arElement["ID"].'/',
		"IMG" => $arPhoto,
		"PLOTTAGE" => $arElement["PROPERTY_PLOTTAGE_VALUE"],
		"PRICE" => formatPrice($arElement["PROPERTY_PRICE_VALUE"]),
		"NUMBER" => $arElement["PROPERTY_NUMBER_VALUE"],
	];
	unset($arPhoto);
}

$arResult["PLOTS"] = $arPlots;
