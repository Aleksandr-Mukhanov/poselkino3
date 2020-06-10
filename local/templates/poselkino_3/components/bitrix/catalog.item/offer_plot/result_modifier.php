<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
// получим поселок
	$arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>1,"ID"=>$arResult['ITEM']['PROPERTIES']['VILLAGE']['VALUE']);
	$arSelect = Array("ID","NAME","PROPERTY_TRAIN","PROPERTY_TRAIN_TRAVEL_TIME","PROPERTY_TRAIN_VOKZAL","PROPERTY_AUTO_NO_JAMS");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	if($arElement = $rsElements->GetNext()){ // dump($arElement);
		$arResult['VILLAGE'] = [
			'NAME' => $arElement['NAME'],
			'PROPERTY_TRAIN' => $arElement['PROPERTY_TRAIN_VALUE'],
			'TRAIN_TRAVEL_TIME' => $arElement['PROPERTY_TRAIN_TRAVEL_TIME_VALUE'],
			'TRAIN_VOKZAL' => $arElement['PROPERTY_TRAIN_VOKZAL_VALUE'],
			'AUTO_NO_JAMS' => $arElement['PROPERTY_AUTO_NO_JAMS'],
		];
	} //dump($arResult);
?>
