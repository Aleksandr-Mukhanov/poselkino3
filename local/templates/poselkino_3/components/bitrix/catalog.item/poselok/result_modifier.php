<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
// узнаем кол-во отзывов
	$arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>2,"ACTIVE"=>"Y");
	$arSelect = Array("ID","PROPERTY_VILLAGE");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	while($arElement = $rsElements->GetNext()){
		//dump($arElement);
		$cntCom = $arComment[$arElement["PROPERTY_VILLAGE_VALUE"]];
		$arComment[$arElement["PROPERTY_VILLAGE_VALUE"]] = ($cntCom) ? $cntCom+1 : 1;
	} //dump($arComment);

$arResult["COMMENTS"] = $arComment;
?>
