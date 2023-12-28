<?php header('Content-Type: text/html; charset=utf-8');
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');

// получим поселки
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>1,"ACTIVE"=>"Y","PROPERTY_STOIMOST_UCHASTKA"=>false);
$arSelect = Array("ID","NAME","PROPERTY_COST_LAND_IN_CART","PROPERTY_HOME_VALUE","PROPERTY_DOMA");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);
	$i++;
	if($arElement['PROPERTY_DOMA_ENUM_ID'] == 3){
		$PROPERTY_VAL = [["VALUE" => $arElement['PROPERTY_COST_LAND_IN_CART'][0]],["VALUE" => $arElement['PROPERTY_COST_LAND_IN_CART'][1]]];
		$PROPERTY_CODE = 'STOIMOST_UCHASTKA';
		echo 'Участки: '.$arElement['NAME'].'<br>';
		// CIBlockElement::SetPropertyValues($arElement['ID'], 1, $PROPERTY_VAL, $PROPERTY_CODE);
	}elseif($arElement['PROPERTY_DOMA_ENUM_ID'] == 4){
		$PROPERTY_VAL = [["VALUE" => $arElement['PROPERTY_HOME_VALUE'][0]],["VALUE" => $arElement['PROPERTY_HOME_VALUE'][1]]];
		$PROPERTY_CODE = 'STOIMOST_UCHASTKA';
		echo 'Дома: '.$arElement['NAME'].'<br>';
		// CIBlockElement::SetPropertyValues($arElement['ID'], 1, $PROPERTY_VAL, $PROPERTY_CODE);
	}else{
		echo 'Другое: '.$arElement['NAME'].'<br>';
	}
} echo 'Кол-во: '.$i.'<br>';
?>
