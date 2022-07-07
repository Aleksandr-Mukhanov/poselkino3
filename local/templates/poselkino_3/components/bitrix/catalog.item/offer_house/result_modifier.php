<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
// dump($arResult['ITEM']['PROPERTIES']['VILLAGE']);
// получим поселок
	$arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>1,"ID"=>$arResult['ITEM']['PROPERTIES']['VILLAGE']['VALUE']);
	$arSelect = Array("ID","NAME","CODE");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	if ($arElement = $rsElements->Fetch())
		$arResult['VILLAGE'] = $arElement;
?>
