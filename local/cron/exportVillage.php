<?php header('Content-Type: text/html; charset=utf-8');
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
	Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

// получим девелоперов
$arElHL = getElHL(5,[],[],['ID','UF_XML_ID','UF_NAME']);
foreach ($arElHL as $value)
	$arDevelopers[$value['UF_XML_ID']] = $value['UF_NAME'];

// получим Инфраструктуру
$arElHL = getElHL(12,[],[],['ID','UF_XML_ID','UF_NAME']);
foreach ($arElHL as $value)
	$arInfrastruktura[$value['UF_XML_ID']] = $value['UF_NAME'];

$info = "Девелопер;Поселок;Менеджер;Шоссе;от МКАД;Район;Ближайший населенный пункт;Координаты;Вид разрешенного строительства;Автобус;Инфраструктура;Площадь участков;Цена за сотку;Количество участков;Количество участков в продаже;Наличие домов;Стоимость домов;Сайт;Водопровод;Электричество;Газ;\n";

// получим поселки
$arOrder = Array('SORT'=>'ASC');
$arFilter = [
	'IBLOCK_ID' => 1,
	'ACTIVE' => 'Y',
	'!PROPERTY_SALES_PHASE' => 254, // уберем проданные
	'!PROPERTY_HIDE_POS' => 273, // метка убрать из каталога
	'PROPERTY_TOP_100' => 554, // метка Топ 100
];
$arSelect = Array('ID','NAME','PROPERTY_DEVELOPER_ID','PROPERTY_SHOSSE','PROPERTY_MKAD','PROPERTY_BUS','PROPERTY_ON_TERRITORY','PROPERTY_PLOTTAGE','PROPERTY_PRICE_SOTKA','PROPERTY_COUNT_PLOTS','PROPERTY_COUNT_PLOTS_SALE','PROPERTY_DOMA','PROPERTY_HOME_VALUE','PROPERTY_SITE','PROPERTY_PLUMBING','PROPERTY_ELECTRO','PROPERTY_GAS','PROPERTY_MANAGER','PROPERTY_TYPE_USE','PROPERTY_REGION','PROPERTY_SETTLEM','PROPERTY_COORDINATES');
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->Fetch())
{ // dump($arElement);
  foreach ($arElement['PROPERTY_ON_TERRITORY_VALUE'] as $value)
    $ON_TERRITORY[] = $arInfrastruktura[$value];

  $info .= $arDevelopers[$arElement['PROPERTY_DEVELOPER_ID_VALUE'][0]].';';
  $info .= $arElement['NAME'].';';
	$info .= $arElement['PROPERTY_MANAGER_VALUE'].';';
  $info .= implode(',',$arElement['PROPERTY_SHOSSE_VALUE']).';';
  $info .= $arElement['PROPERTY_MKAD_VALUE'].';';
	$info .= $arElement['PROPERTY_REGION_VALUE'].';';
	$info .= $arElement['PROPERTY_SETTLEM_VALUE'].';';
	$info .= $arElement['PROPERTY_COORDINATES_VALUE'].';';
	$info .= $arElement['PROPERTY_TYPE_USE_VALUE'].';';
  $info .= $arElement['PROPERTY_BUS_VALUE'].';';
  $info .= ($ON_TERRITORY)?implode(',',$ON_TERRITORY).';':';';
	$info .= implode('-',$arElement['PROPERTY_PLOTTAGE_VALUE']).';';
	$info .= implode('-',$arElement['PROPERTY_PRICE_SOTKA_VALUE']).';';
	$info .= $arElement['PROPERTY_COUNT_PLOTS_VALUE'].';';
	$info .= $arElement['PROPERTY_COUNT_PLOTS_SALE_VALUE'].';';
	$info .= $arElement['PROPERTY_DOMA_VALUE'].';';
	$info .= implode('-',$arElement['PROPERTY_HOME_VALUE_VALUE']).';';
	$info .= $arElement['PROPERTY_SITE_VALUE'].';';
	$info .= $arElement['PROPERTY_PLUMBING_VALUE'].';';
	$info .= $arElement['PROPERTY_ELECTRO_VALUE'].';';
	$info .= $arElement['PROPERTY_GAS_VALUE'].';';
  $info .= "\n";

  unset($ON_TERRITORY);
}

dump($info);

$fp = fopen($_SERVER["DOCUMENT_ROOT"].'/exportVillage.csv', 'w+');
fwrite($fp,$info);
fclose($fp);
