<?php header('Content-Type: text/html; charset=utf-8');
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
$i=0;

// получим поселки
$arOrder = ['SORT'=>'ASC'];
$arFilter = ['IBLOCK_ID'=>1,'PROPERTY_IN_YA_FEED'=>283];
$arSelect = ['ID','NAME','PREVIEW_TEXT','PROPERTY_DOMA','DETAIL_PAGE_URL','DATE_CREATE','PROPERTY_REGION','PROPERTY_MKAD','PROPERTY_PLOTTAGE','PROPERTY_HOUSE_AREA','PROPERTY_DOP_FOTO','PROPERTY_SHOSSE','PROPERTY_COST_LAND_IN_CART','PROPERTY_COORDINATES','PROPERTY_LOCATION_YA_REAL'];
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while ($arElement = $rsElements->GetNext()) { // dump($arElement);
	$arVillage[$arElement['ID']] = $arElement;
	$arVillageIDs[] = $arElement['ID'];
}

// получим участки
$arOrder = ['SORT'=>'ASC'];
$arFilter = ['IBLOCK_ID'=>5,'PROPERTY_VILLAGE'=>$arVillageIDs];
$arSelect = ['ID','NAME','DETAIL_PAGE_URL','PROPERTY_VILLAGE','PROPERTY_PRICE','PROPERTY_PLOTTAGE'];
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while ($arElementPlot = $rsElements->GetNext())
{ // dump($arElementPlot);
	$arElement = $arVillage[$arElementPlot['PROPERTY_VILLAGE_VALUE']];

	echo 'Участок: '.$arElementPlot['NAME'].'<br>';
	if (count($arElement['PROPERTY_DOP_FOTO_VALUE']) < 3) continue;

	$villageTypeID = $arElement['PROPERTY_DOMA_ENUM_ID']; // Наличие домов: 3 - Участки, 256 - Дома и участки

  $category = ($villageTypeID == 3 || $villageTypeID == 256) ? 'участок' : 'дом';
  $creation_date = strtotime($arElementPlot['DATE_CREATE']);
	$price = $arElementPlot['PROPERTY_PRICE_VALUE'];
  $unit = ($villageTypeID == 3 || $villageTypeID == 256) ? 'сотка' : 'кв. м';
  $area = ($villageTypeID == 3 || $villageTypeID == 256) ? '<lot-area><value>'.$arElementPlot['PROPERTY_PLOTTAGE_VALUE'].'</value><unit>сотка</unit></lot-area>' : '<area><value>'.$arElement['PROPERTY_HOUSE_AREA_VALUE'][0].'</value><unit>кв. м</unit></area>';

	// разбивка по шоссе
	$highway = array_values($arElement['PROPERTY_SHOSSE_VALUE'])[0];
	switch ($highway) {
		case 'Дмитровское':
			$toName = 'Иван';
			$toPhone = '+74951860665';
			break;
		case 'Рогачёвское':
			$toName = 'Иван';
			$toPhone = '+74951860665';
			break;
		case 'Ленинградское':
			$toName = 'Иван';
			$toPhone = '+74951860665';
			break;
		case 'Пятницкое':
			$toName = 'Андрей';
			$toPhone = '+74958590209';
			break;
		case 'Волоколамское':
			$toName = 'Андрей';
			$toPhone = '+74958590209';
			break;
		case 'Новорижское':
			$toName = 'Андрей';
			$toPhone = '+74958590209';
			break;
		case 'Ильинское':
			$toName = 'Андрей';
			$toPhone = '+74958590209';
			break;
		case 'Рублевское':
			$toName = 'Андрей';
			$toPhone = '+74958590209';
			break;
		case 'Горьковское':
			$toName = 'Владислав';
			$toPhone = '+74958590208';
			break;
		case 'Щелковское':
			$toName = 'Владислав';
			$toPhone = '+74958590208';
			break;
		case 'Носовихинское':
			$toName = 'Владислав';
			$toPhone = '+74958590208';
			break;
		case 'Егорьевское':
			$toName = 'Игорь';
			$toPhone = '+74951541673';
			break;
		case 'Новорязанское':
			$toName = 'Игорь';
			$toPhone = '+74951541673';
			break;
		case 'Каширское':
			$toName = 'Дмитрий';
			$toPhone = '+74951724409';
			break;
		case 'Симферопольское':
			$toName = 'Лилия';
			$toPhone = '+74954456119';
			break;
		case 'Варшавское':
			$toName = 'Лилия';
			$toPhone = '+74954456119';
			break;
		case 'Калужское':
			$toName = 'Лилия';
			$toPhone = '+74954456119';
			break;
		case 'Киевское':
			$toName = 'Лилия';
			$toPhone = '+74954456119';
			break;

		default:
			$toName = 'Посёлкино';
			$toPhone = '+74951860665';
			break;
	}

	$toCategory = ($toPhone == '+74951860665') ? 'agency' : 'developer';

	$description = str_replace('&nbsp;','',$arElement['PREVIEW_TEXT']);
	$description = trim(strip_tags($description));

	$arCoordinates = explode(',',$arElement['PROPERTY_COORDINATES_VALUE']);
	$latitude = trim($arCoordinates[0]);
	$longitude = trim($arCoordinates[1]);

  $xml_content .= '<offer internal-id="'.$arElementPlot['ID'].'">';
    $xml_content .= '<type>продажа</type>';
    $xml_content .= '<property-type>жилая</property-type>';
    $xml_content .= '<category>'.$category.'</category>';
    $xml_content .= '<url>https://poselkino.ru'.$arElementPlot['DETAIL_PAGE_URL'].'</url>';
    $xml_content .= '<creation-date>'.date('c',$creation_date).'</creation-date>';
		$xml_content .= '<description>'.$description.'</description>';
    $xml_content .= '<location>';
      $xml_content .= '<country>Россия</country>';
			$xml_content .= '<region>Московская область</region>';

			if ($arElement['PROPERTY_LOCATION_YA_REAL_VALUE'])
				$xml_content .= '<district>'.$arElement['PROPERTY_LOCATION_YA_REAL_VALUE'].'</district>';
			else
      	$xml_content .= '<district>'.$arElement['PROPERTY_REGION_VALUE'].' район</district>';

      $xml_content .= '<locality-name>'.$arElementPlot['NAME'].'</locality-name>';
      $xml_content .= '<distance>'.$arElement['PROPERTY_MKAD_VALUE'].'</distance>';
			$xml_content .= '<direction>'.$highway.'</direction>';
			if ($latitude) $xml_content .= '<latitude>'.$latitude.'</latitude>';
			if ($longitude) $xml_content .= '<longitude>'.$longitude.'</longitude>';
    $xml_content .= '</location>';

		if ($_REQUEST['agent'] == 'poselkino') {
			$xml_content .= '<sales-agent>';
				$xml_content .= '<organization>Поселкино.ру</organization>';
				$xml_content .= '<phone>+74951860665</phone>';
				$xml_content .= '<category>agency</category>';
			$xml_content .= '</sales-agent>';
		} else {
			$xml_content .= '<sales-agent>';
				$xml_content .= '<name>'.$toName.'</name>';
				$xml_content .= '<phone>'.$toPhone.'</phone>';
				$xml_content .= '<category>'.$toCategory.'</category>';
			$xml_content .= '</sales-agent>';
		}

    $xml_content .= '<price>';
      $xml_content .= '<value>'.$price.'</value>';
      $xml_content .= '<currency>RUB</currency>';
      // $xml_content .= '<unit>'.$unit.'</unit>';
    $xml_content .= '</price>';
    $xml_content .= $area;

		foreach ($arElement['PROPERTY_DOP_FOTO_VALUE'] as $photo)
			$xml_content .= '<image>https://poselkino.ru'.\CFile::GetPath($photo).'</image>';

  $xml_content .= '</offer>'; $i++;

}
echo 'Всего: '.$i.'<br>';

$inFile = ($_REQUEST['agent'] == 'poselkino') ? 'yandexPlotsAgency.xml' : 'yandexPlots.xml';

// запись в файл
$fp = fopen($_SERVER["DOCUMENT_ROOT"].'/'.$inFile, 'w+');
$xml = '<?xml version="1.0" encoding="UTF-8"?><realty-feed xmlns="http://webmaster.yandex.ru/schemas/feed/realty/2010-06"><generation-date>'.date('c').'</generation-date>'.$xml_content.'</realty-feed>';
fwrite($fp,$xml);
fclose($fp);
