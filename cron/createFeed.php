<?php header('Content-Type: text/html; charset=utf-8');
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
// 	Loader::includeModule('highloadblock');
// use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

// получим поселки девелоперов
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>1,'ACTIVE'=>'Y','!PROPERTY_SALES_PHASE'=>254); // проданные не выводим
$arSelect = Array("ID","NAME","PROPERTY_DOMA","DETAIL_PAGE_URL","DATE_CREATE","PROPERTY_REGION","PROPERTY_MKAD","PROPERTY_PRICE_SOTKA","PROPERTY_HOME_VALUE","PROPERTY_PLOTTAGE","PROPERTY_HOUSE_AREA",'PROPERTY_DEVELOPER_ID');
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);

	// получим девелопера
	if($arElement['PROPERTY_DEVELOPER_ID_VALUE'])
		$arDeveloper = getElHL(5,[],['UF_XML_ID'=>$arElement['PROPERTY_DEVELOPER_ID_VALUE']],['ID','UF_NAME','UF_PHONE']);

  $category = ($arElement['PROPERTY_DOMA_ENUM_ID'] == 3) ? 'участок' : 'дом';
  $creation_date = strtotime($arElement['DATE_CREATE']);
  $price = ($arElement['PROPERTY_DOMA_ENUM_ID'] == 3) ? $arElement['PROPERTY_PRICE_SOTKA_VALUE'][0] : $arElement['PROPERTY_HOME_VALUE_VALUE'][0];
  $unit = ($arElement['PROPERTY_DOMA_ENUM_ID'] == 3) ? 'сотка' : 'кв. м';
  $area = ($arElement['PROPERTY_DOMA_ENUM_ID'] == 3) ? '<lot-area><value>'.$arElement['PROPERTY_PLOTTAGE_VALUE'][0].'</value><unit>сотка</unit></lot-area>' : '<area><value>'.$arElement['PROPERTY_HOUSE_AREA_VALUE'][0].'</value><unit>кв. м</unit></area>';

  $xml_content .= '<offer internal-id="'.$arElement['ID'].'">';
    $xml_content .= '<type>продажа</type>';
    $xml_content .= '<property-type>жилая</property-type>';
    $xml_content .= '<category>'.$category.'</category>';
    $xml_content .= '<url>https://poselkino.ru'.$arElement['DETAIL_PAGE_URL'].'</url>';
    $xml_content .= '<creation-date>'.date('c',$creation_date).'</creation-date>';
    $xml_content .= '<location>';
      $xml_content .= '<country>Россия</country>';
      $xml_content .= '<district>'.$arElement['PROPERTY_REGION_VALUE'].' район</district>';
      $xml_content .= '<locality-name>'.$arElement['NAME'].'</locality-name>';
      $xml_content .= '<distance>'.$arElement['PROPERTY_MKAD_VALUE'].'</distance>';
    $xml_content .= '</location>';
		if ($arElement['PROPERTY_DEVELOPER_ID_VALUE']) { // если указан девелопер
			foreach ($arDeveloper as $key => $developer) { // передадим девелоперов

				$arPhone = explode(',',$developer['UF_PHONE']);

		    $xml_content .= '<sales-agent>';
		      $xml_content .= '<name>'.$developer['UF_NAME'].'</name>';
					foreach ($arPhone as $phone) {
						$xml_content .= '<phone>'.trim($phone).'</phone>';
					}
		      $xml_content .= '<category>«застройщик»/«developer»</category>';
		    $xml_content .= '</sales-agent>';
			}
		} else {
			$xml_content .= '<sales-agent>';
				$xml_content .= '<name>Посёлкино</name>';
				$xml_content .= '<phone>+7 (495) 186-06-65</phone>';
				$xml_content .= '<category>«агентство»/«agency»</category>';
			$xml_content .= '</sales-agent>';
		}
    $xml_content .= '<price>';
      $xml_content .= '<value>'.$price.'</value>';
      $xml_content .= '<currency>RUB</currency>';
      $xml_content .= '<unit>'.$unit.'</unit>';
    $xml_content .= '</price>';
    $xml_content .= $area;
  $xml_content .= '</offer>';

} // dump($arVillage);


// запись в файл
	$fp = fopen('../yandex.xml', 'w+');
	$xml = '<?xml version="1.0" encoding="UTF-8"?><realty-feed xmlns="http://webmaster.yandex.ru/schemas/feed/realty/2010-06"><generation-date>'.date('c').'</generation-date>'.$xml_content.'</realty-feed>';
	fwrite($fp,$xml);
	fclose($fp);
