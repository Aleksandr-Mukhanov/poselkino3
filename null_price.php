<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
CModule::IncludeModule("iblock");
// Получим поселки
	$arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>1,"ACTIVE"=>"Y","PROPERTY_STOIMOST_UCHASTKA"=>false); // стоимость участка в фильтр
	$arSelect = Array("ID","NAME","DETAIL_PAGE_URL","PROPERTY_STOIMOST_UCHASTKA","PROPERTY_COST_LAND_IN_CART","PROPERTY_HOME_VALUE");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	while($arElement = $rsElements->GetNext()){ // dump($arElement);
    echo '<a href="'.$arElement['DETAIL_PAGE_URL'].'">'.$arElement['NAME'].'</a><br>';
	}
?>
