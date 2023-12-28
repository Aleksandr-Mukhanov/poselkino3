<?php header('Content-Type: text/html; charset=utf-8');
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
// 	Loader::includeModule('highloadblock');
// use Bitrix\Highloadblock as HL, Bitrix\Main\Entity; IN_YA_FEED - 283
$i=0;

$arDeveloper = ['Zemelniy-Ekspress','Zemelniy-Format','meta_gruppa','Krasivaya-Zemlya','Dmitrovka-zagorodnaya-nedvizhimost','rosszem','Svoya-Zemlya','Udacha'];

// $csv_content .= "ID,Title,URL,Image,Description,Price,Currency\n";
$siteURL = 'https://poselkino.ru';

// получим поселки девелоперов
$arOrder = Array("SORT"=>"ASC");
// $arFilter = Array("IBLOCK_ID"=>1,'ACTIVE'=>'Y','!PROPERTY_SALES_PHASE'=>254,'PROPERTY_DOMA'=>3,'<=SORT'=>200,'PROPERTY_DEVELOPER_ID'=>$arDeveloper); // проданные не выводим и только участки
$arFilter = ["IBLOCK_ID"=>1,'PROPERTY_IN_YA_FEED'=>283]; // ,'ACTIVE'=>'Y','!PROPERTY_SALES_PHASE'=>254,'PROPERTY_DOMA'=>3
$arSelect = Array("ID","NAME","PREVIEW_TEXT","PROPERTY_DOMA","DETAIL_PAGE_URL","DATE_CREATE","PROPERTY_REGION","PROPERTY_MKAD","PROPERTY_PRICE_SOTKA","PROPERTY_HOME_VALUE","PROPERTY_PLOTTAGE","PROPERTY_HOUSE_AREA",'PROPERTY_DEVELOPER_ID','PROPERTY_DOP_FOTO','PROPERTY_SHOSSE','PROPERTY_COST_LAND_IN_CART');
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while ($arElement = $rsElements->GetNext()) { // dump($arElement);

	if (count($arElement['PROPERTY_DOP_FOTO_VALUE']) < 3) continue;

	echo 'Поселок: '.$arElement['NAME'].'<br>';

	// получим девелопера
	// if($arElement['PROPERTY_DEVELOPER_ID_VALUE'])
	// 	$arDeveloper = getElHL(5,[],['UF_XML_ID'=>$arElement['PROPERTY_DEVELOPER_ID_VALUE']],['ID','UF_NAME','UF_PHONE']);

  $category = ($arElement['PROPERTY_DOMA_ENUM_ID'] == 3) ? 'участок' : 'дом';
  $creation_date = strtotime($arElement['DATE_CREATE']);
  // $price = ($arElement['PROPERTY_DOMA_ENUM_ID'] == 3) ? $arElement['PROPERTY_PRICE_SOTKA_VALUE'][0] : $arElement['PROPERTY_HOME_VALUE_VALUE'][0];
	$price = $arElement['PROPERTY_COST_LAND_IN_CART_VALUE'][0];
  $unit = ($arElement['PROPERTY_DOMA_ENUM_ID'] == 3) ? 'соток' : 'кв. м';
  $area = ($arElement['PROPERTY_DOMA_ENUM_ID'] == 3) ? '<lot-area><value>'.$arElement['PROPERTY_PLOTTAGE_VALUE'][0].'</value><unit>соток</unit></lot-area>' : '<area><value>'.$arElement['PROPERTY_HOUSE_AREA_VALUE'][0].'</value><unit>кв. м</unit></area>';

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

	$toName = 'Поселкино.ру';
	$toPhone = '+74951860665';
	$toCategory = ($toPhone == '+74951860665') ? 'agency' : 'developer';

	$description = trim(strip_tags($arElement['PREVIEW_TEXT']));
	$description = str_replace(['&nbsp;',',','\n','\r','\r\n','\n\r'],'',$description);
	$description = '';

	$photo = $siteURL.\CFile::GetPath($arElement['PROPERTY_DOP_FOTO_VALUE'][0]);

	// $csv_content .= $arElement["ID"].",".$arElement["NAME"].",".$siteURL.$arElement["DETAIL_PAGE_URL"].",".$photo.",".$description.",".$price.",RUB\n";

  $csv_content .= '<offer internal-id="'.$arElement['ID'].'">';
    $csv_content .= '<type>продажа</type>';
    $csv_content .= '<property-type>жилая</property-type>';
    $csv_content .= '<category>'.$category.'</category>';
    $csv_content .= '<url>https://poselkino.ru'.$arElement['DETAIL_PAGE_URL'].'</url>';
    $csv_content .= '<creation-date>'.date('c',$creation_date).'</creation-date>';
		// $csv_content .= '<description>'.$description.'</description>';
    $csv_content .= '<location>';
      $csv_content .= '<country>Россия</country>';
      $csv_content .= '<district>'.$arElement['PROPERTY_REGION_VALUE'].' район</district>';
      $csv_content .= '<locality-name>Поселок '.$arElement['NAME'].'</locality-name>';
      $csv_content .= '<distance>'.$arElement['PROPERTY_MKAD_VALUE'].'</distance>';
			$csv_content .= '<direction>'.$highway.'</direction>';
    $csv_content .= '</location>';

		$csv_content .= '<sales-agent>';
			$csv_content .= '<organization>'.$toName.'</organization>';
			$csv_content .= '<phone>'.$toPhone.'</phone>';
			$csv_content .= '<category>'.$toCategory.'</category>';
		$csv_content .= '</sales-agent>';

    $csv_content .= '<price>';
      $csv_content .= '<value>'.$price.'</value>';
      $csv_content .= '<currency>RUB</currency>';
      $csv_content .= '<unit>'.$unit.'</unit>';
    $csv_content .= '</price>';
    $csv_content .= $area;

		foreach ($arElement['PROPERTY_DOP_FOTO_VALUE'] as $photo)
			$csv_content .= '<image>https://poselkino.ru'.\CFile::GetPath($photo).'</image>';

  $csv_content .= '</offer>';
	$i++;

} // dump($arVillage);
echo 'Всего: '.$i.'<br>';

// запись в файл
	$fp = fopen($_SERVER["DOCUMENT_ROOT"].'/yandexSmartB.xml', 'w+');
	$xml = '<?xml version="1.0" encoding="UTF-8"?><realty-feed xmlns="http://webmaster.yandex.ru/schemas/feed/realty/2010-06"><generation-date>'.date('c').'</generation-date>'.$csv_content.'</realty-feed>';
	fwrite($fp,$xml);
	fclose($fp);
