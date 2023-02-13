<?php header('Content-Type: text/html; charset=utf-8');
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
$i=0;

// получим id шоссе
$xmlCian = simplexml_load_file('https://poselkino.ru/cron/highways.xml');
$arCian = json_decode(json_encode($xmlCian), true); // dump($arCian);
foreach ($arCian['location'] as $id => $location)
  $arHighwayIDs[$location] = $id;
// dump($arHighwayIDs);

$siteURL = 'https://poselkino.ru';

// получим поселки девелоперов
$arOrder = Array("SORT"=>"ASC");
$arFilter = ["IBLOCK_ID"=>1,'PROPERTY_IN_CIAN_FEED'=>307];
$arSelect = Array("ID","NAME","PREVIEW_TEXT","PROPERTY_DOMA","DETAIL_PAGE_URL","DATE_CREATE","PROPERTY_REGION","PROPERTY_MKAD","PROPERTY_PRICE_SOTKA","PROPERTY_HOME_VALUE","PROPERTY_PLOTTAGE","PROPERTY_HOUSE_AREA",'PROPERTY_DEVELOPER_ID','PROPERTY_DOP_FOTO','PROPERTY_COORDINATES','PROPERTY_SHOSSE','PROPERTY_COST_LAND_IN_CART','PROPERTY_SHOSSE_RASSTOYANIE','PROPERTY_CIAN_ID','PROPERTY_ELECTRO_DONE','PROPERTY_PROVEDEN_GAZ','PROPERTY_PROVEDENA_VODA','PROPERTY_TYPE_USE','PROPERTY_LOCATION_CIAN');
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while ($arElement = $rsElements->GetNext()) { // dump($arElement);

  $price = $arElement['PROPERTY_COST_LAND_IN_CART_VALUE'][0];

  $description = str_replace('&nbsp;','',$arElement['PREVIEW_TEXT']);
	$description = trim(strip_tags($description));

  $arCoordinates = explode(',',$arElement['PROPERTY_COORDINATES_VALUE']);
	$latitude = trim($arCoordinates[0]);
	$longitude = trim($arCoordinates[1]);

  $highway = array_values($arElement['PROPERTY_SHOSSE_VALUE'])[0];

	switch ($arElement['NAME']) {
		case 'Флора-Парк-2':
			$phone = '4958590208'; // Анна
			break;
		case 'Новое Салтыково':
			$phone = '4951541673'; // Александр
			break;
		case 'Калипсо Вилладж-2':
			$phone = '4951860665'; // Иван
			break;
		case 'Трудовая ИЖС':
			$phone = '4951860665'; // Иван
			break;

		default:
			$phone = '4951724409'; // Дмитрий
			break;
	}

	$HasElectricity = ($arResult['PROPERTY_ELECTRO_DONE_ENUM_ID'] == 14) ? 'true' : 'false';
	$HasGas = ($arResult['PROPERTY_PROVEDEN_GAZ_ENUM_ID'] == 17) ? 'true' : 'false';
	$HasWater = ($arResult['PROPERTY_PROVEDENA_VODA_ENUM_ID'] == 20) ? 'true' : 'false';

	switch ($arResult['PROPERTY_TYPE_USE_ENUM_ID']) {
		case 123:
			$LandStatus = 'gardening'; break;
		case 154:
			$LandStatus = 'individualHousingConstruction'; break;

		default:
			$LandStatus = ''; break;
	}
	$address = $arElement['PROPERTY_LOCATION_CIAN_VALUE'];

  $csv_content .= '<object>';
    $csv_content .= '<Category>landSale</Category>';
    $csv_content .= '<ExternalId>'.$arElement['ID'].'</ExternalId>';
    $csv_content .= '<Description>'.$description.'</Description>';
		if ($address) $csv_content .= '<Address>'.$address.'</Address>';
    $csv_content .= '<Coordinates>';
      $csv_content .= '<Lat>'.$latitude.'</Lat>';
      $csv_content .= '<Lng>'.$longitude.'</Lng>';
    $csv_content .= '</Coordinates>';
		$csv_content .= '<Phones>';
			$csv_content .= '<PhoneSchema>';
	      $csv_content .= '<CountryCode>+7</CountryCode>';
	      $csv_content .= '<Number>'.$phone.'</Number>';
			$csv_content .= '</PhoneSchema>';
    $csv_content .= '</Phones>';
    $csv_content .= '<Highway>';
      $csv_content .= '<Id>'.$arHighwayIDs[$highway].'</Id>';
      $csv_content .= '<Distance>'.$arElement['PROPERTY_SHOSSE_RASSTOYANIE_VALUE'].'</Distance>';
    $csv_content .= '</Highway>';
    $csv_content .= '<SettlementName>'.$arElement['NAME'].'</SettlementName>';
		$csv_content .= '<HasElectricity>'.$HasElectricity.'</HasElectricity>';
		$csv_content .= '<HasWater>'.$HasWater.'</HasWater>';
		$csv_content .= '<HasGas>'.$HasGas.'</HasGas>';
    $csv_content .= '<Photos>';
    $csv_content .= '</Photos>';
    foreach ($arElement['PROPERTY_DOP_FOTO_VALUE'] as $photo){
      $csv_content .= '<PhotoSchema>';
        $csv_content .= '<FullUrl>'.'https://poselkino.ru'.\CFile::GetPath($photo).'</FullUrl>';
      $csv_content .= '</PhotoSchema>';
    }
			$xml_content .= '<image>https://poselkino.ru'.\CFile::GetPath($photo).'</image>';
    $csv_content .= '<Land>';
      $csv_content .= '<Area>'.$arElement['PROPERTY_PLOTTAGE_VALUE'][0].'</Area>';
      $csv_content .= '<AreaUnitType>sotka</AreaUnitType>';
			if ($LandStatus) $csv_content .= '<Status>'.$LandStatus.'</Status>';
    $csv_content .= '</Land>';
		if ($arElement['PROPERTY_CIAN_ID_VALUE']):
		$csv_content .= '<KP>';
			$csv_content .= '<Id>'.$arElement['PROPERTY_CIAN_ID_VALUE'].'</Id>';
		$csv_content .= '</KP>';
		endif;
    $csv_content .= '<BargainTerms>';
      $csv_content .= '<Price>'.$price.'</Price>';
      $csv_content .= '<Currency>rur</Currency>';
      $csv_content .= '<ClientFee>0</ClientFee>';
      $csv_content .= '<AgentFee>0</AgentFee>';
    $csv_content .= '</BargainTerms>';
  $csv_content .= '</object>';
  $i++;
}
echo 'Всего: '.$i.'<br>';

// запись в файл
$fp = fopen($_SERVER["DOCUMENT_ROOT"].'/cian.xml', 'w+');
$xml = '<feed><feed_version>2</feed_version>'.$csv_content.'</feed>';
fwrite($fp,$xml);
fclose($fp);
