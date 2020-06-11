<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
// dump($arResult['ITEM']['PROPERTIES']['VILLAGE']);
// получим поселок
	$arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>1,"ID"=>$arResult['ITEM']['PROPERTIES']['VILLAGE']['VALUE']);
	$arSelect = Array("ID","NAME");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	if($arElement = $rsElements->GetNext()){ // dump($arElement);
		$arResult['VILLAGE'] = [
			'NAME' => $arElement['NAME'],
		];
	} // dump($arResult);
?>
