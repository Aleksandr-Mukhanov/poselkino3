<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
	Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

// получим девелоперов
$hlblock_id = 5; // id HL
$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();
$entity_table_name = $hlblock['TABLE_NAME'];
$sTableID = 'tbl_'.$entity_table_name;

$rsData = $entity_data_class::getList([
  'filter' => ['*'],
  'select' => ['UF_NAME','UF_SORT','UF_XML_ID'],
]);
$rsData = new CDBResult($rsData, $sTableID);

while($arRes = $rsData->Fetch()){ // dump($arRes);
  if($arRes['UF_SORT']){ // если есть фид
		echo 'Сортировка у девелопера '.$arRes['UF_NAME'].': <b>'.$arRes['UF_SORT'].'</b><br>';
		$arDeveloper[$arRes['UF_XML_ID']] = [
	    'UF_NAME' => $arRes['UF_NAME'],
	    'UF_SORT' => $arRes['UF_SORT'],
	  ];
	  $arIdDeveloper[] = $arRes['UF_XML_ID'];
	}
} // dump($arDeveloper);

// получим поселки девелоперов
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>1,"PROPERTY_DEVELOPER_ID" => $arIdDeveloper);
$arSelect = Array("ID","NAME","SORT","PROPERTY_DEVELOPER_ID");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);
	$idDevel = $arElement['PROPERTY_DEVELOPER_ID_VALUE'];
	if($arDeveloper[$idDevel]['UF_SORT'] <> $arElement['SORT']){ // dump($arElement);
		echo 'Применена к поселку: <b>'.$arElement['NAME'].'</b><br>';
		$el = new CIBlockElement;
		$res = $el->Update($arElement['ID'], ['SORT' => $arDeveloper[$idDevel]['UF_SORT']]);
	}
}
echo '<br>---<br>';
?>
