<?php header('Content-Type: text/html; charset=utf-8');
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
	Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;
$i=0;

// $arDeveloper = ['Zemelniy-Ekspress','Zemelniy-Format','meta_gruppa','Krasivaya-Zemlya','Dmitrovka-zagorodnaya-nedvizhimost','rosszem','Svoya-Zemlya','Udacha'];

// получим девелоперов ТОП 100
$arElHL = getElHL(5,[],['UF_TOP100'=>true],['ID','UF_XML_ID']);
foreach ($arElHL as $value)
	$arDevelopersTOP100[] = $value['UF_XML_ID'];

// распределение менеджерам по шоссе
$arElHL = getElHL(16,[],[],['ID','UF_NAME','UF_MANAGER']);
foreach ($arElHL as $value)
	$arHighway[$value['UF_NAME']] = $value['UF_MANAGER'];

// получим поселки девелоперов
$arOrder = Array("SORT"=>"ASC");
// $arFilter = Array("IBLOCK_ID"=>1,'ACTIVE'=>'Y','!PROPERTY_SALES_PHASE'=>254,'PROPERTY_DOMA'=>3,'<=SORT'=>200,'PROPERTY_DEVELOPER_ID'=>$arDeveloper); // проданные не выводим и только участки
// $arFilter = ["IBLOCK_ID"=>1,'PROPERTY_IN_YA_FEED'=>283]; // ,'ACTIVE'=>'Y','!PROPERTY_SALES_PHASE'=>254,'PROPERTY_DOMA'=>3
$arFilter = [
	"IBLOCK_ID" => 1,
	"ACTIVE" => "Y",
	"!PROPERTY_SALES_PHASE" => 254, // уберем проданные
	"!PROPERTY_HIDE_POS" => 273, // метка убрать из каталога
	[
		"LOGIC" => "OR",
		"PROPERTY_DEVELOPER_ID" => $arDevelopersTOP100,
		"PROPERTY_TOP_100" => 554, // Y
	]
];
$arSelect = Array("ID","NAME","PREVIEW_TEXT","PROPERTY_DOMA","DETAIL_PAGE_URL","DATE_CREATE","PROPERTY_REGION","PROPERTY_MKAD","PROPERTY_PRICE_SOTKA","PROPERTY_HOME_VALUE","PROPERTY_PLOTTAGE","PROPERTY_HOUSE_AREA",'PROPERTY_DEVELOPER_ID','PROPERTY_DOP_FOTO','PROPERTY_SHOSSE','PROPERTY_COST_LAND_IN_CART','PROPERTY_COORDINATES','PROPERTY_LOCATION_YA_REAL','PROPERTY_MANAGER');
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);
	echo 'Поселок: '.$arElement['NAME'].'<br>';
	if (count($arElement['PROPERTY_DOP_FOTO_VALUE']) < 3) continue;

	// получим девелопера
	// if($arElement['PROPERTY_DEVELOPER_ID_VALUE'])
	// 	$arDeveloper = getElHL(5,[],['UF_XML_ID'=>$arElement['PROPERTY_DEVELOPER_ID_VALUE']],['ID','UF_NAME','UF_PHONE']);

	$villageTypeID = $arElement['PROPERTY_DOMA_ENUM_ID']; // Наличие домов: 3 - Участки, 256 - Дома и участки

  $category = ($villageTypeID == 3 || $villageTypeID == 256) ? 'участок' : 'дом';
  $creation_date = strtotime($arElement['DATE_CREATE']);
  // $price = ($villageTypeID == 3 || $villageTypeID == 256) ? $arElement['PROPERTY_PRICE_SOTKA_VALUE'][0] : $arElement['PROPERTY_HOME_VALUE_VALUE'][0];
	$price = $arElement['PROPERTY_COST_LAND_IN_CART_VALUE'][0];
  $unit = ($villageTypeID == 3 || $villageTypeID == 256) ? 'сотка' : 'кв. м';
  $area = ($villageTypeID == 3 || $villageTypeID == 256) ? '<lot-area><value>'.$arElement['PROPERTY_PLOTTAGE_VALUE'][0].'</value><unit>сотка</unit></lot-area>' : '<area><value>'.$arElement['PROPERTY_HOUSE_AREA_VALUE'][0].'</value><unit>кв. м</unit></area>';

	$manager = $arElement['PROPERTY_MANAGER_VALUE'];
	$highway = array_values($arElement['PROPERTY_SHOSSE_VALUE'])[0];

	if ($manager) // менеджер у поселка
	{
		$arElHL = getElHL(13,[],['UF_XML_ID'=>$manager],['*']);
		$arManager = array_values($arElHL)[0];
		if ($arManager['UF_XML_ID']) $toName = $arManager['UF_XML_ID'];
		if ($arManager['UF_EMAIL']) $toEmail = $arManager['UF_EMAIL'];
		if ($arManager['UF_PHONE']) $toPhone = $arManager['UF_PHONE'];
		if ($arManager['UF_AMO_ID']) $responsibleUserId = $arManager['UF_AMO_ID'];
		if ($arManager['UF_TG_ID']) $toTelegram = $arManager['UF_TG_ID'];
	}
	elseif ($arHighway[$highway]) // менеджер у шоссе
	{
		$arElHL = getElHL(13,[],['ID'=>$arHighway[$highway]],['*']);
		$arManager = array_values($arElHL)[0];
		if ($arManager['UF_XML_ID']) $toName = $arManager['UF_XML_ID'];
		if ($arManager['UF_EMAIL']) $toEmail = $arManager['UF_EMAIL'];
		if ($arManager['UF_PHONE']) $toPhone = $arManager['UF_PHONE'];
		if ($arManager['UF_AMO_ID']) $responsibleUserId = $arManager['UF_AMO_ID'];
		if ($arManager['UF_TG_ID']) $toTelegram = $arManager['UF_TG_ID'];
	}

	if (!$toName) $toName = defaultName;
	if (!$toEmail) $toEmail = defaultEmail;
	if (!$toPhone) $toPhone = defaultPhone;
	if (!$responsibleUserId) $responsibleUserId = defaultAmoID;

	// разбивка по шоссе
	// switch ($highway) {
	// 	case 'Дмитровское':
	// 		$toName = 'Иван';
	// 		$toPhone = '+74951860665';
	// 		break;
	// 	case 'Рогачёвское':
	// 		$toName = 'Иван';
	// 		$toPhone = '+74951860665';
	// 		break;
	// 	case 'Ленинградское':
	// 		$toName = 'Иван';
	// 		$toPhone = '+74951860665';
	// 		break;
	// 	case 'Пятницкое':
	// 		$toName = 'Андрей';
	// 		$toPhone = '+74958590209';
	// 		break;
	// 	case 'Волоколамское':
	// 		$toName = 'Андрей';
	// 		$toPhone = '+74958590209';
	// 		break;
	// 	case 'Новорижское':
	// 		$toName = 'Андрей';
	// 		$toPhone = '+74958590209';
	// 		break;
	// 	case 'Ильинское':
	// 		$toName = 'Андрей';
	// 		$toPhone = '+74958590209';
	// 		break;
	// 	case 'Рублевское':
	// 		$toName = 'Андрей';
	// 		$toPhone = '+74958590209';
	// 		break;
	// 	case 'Горьковское':
	// 		$toName = 'Владислав';
	// 		$toPhone = '+74958590208';
	// 		break;
	// 	case 'Щелковское':
	// 		$toName = 'Владислав';
	// 		$toPhone = '+74958590208';
	// 		break;
	// 	case 'Носовихинское':
	// 		$toName = 'Владислав';
	// 		$toPhone = '+74958590208';
	// 		break;
	// 	case 'Егорьевское':
	// 		$toName = 'Игорь';
	// 		$toPhone = '+74951541673';
	// 		break;
	// 	case 'Новорязанское':
	// 		$toName = 'Игорь';
	// 		$toPhone = '+74951541673';
	// 		break;
	// 	case 'Каширское':
	// 		$toName = 'Дмитрий';
	// 		$toPhone = '+74951724409';
	// 		break;
	// 	case 'Симферопольское':
	// 		$toName = 'Лилия';
	// 		$toPhone = '+74954456119';
	// 		break;
	// 	case 'Варшавское':
	// 		$toName = 'Лилия';
	// 		$toPhone = '+74954456119';
	// 		break;
	// 	case 'Калужское':
	// 		$toName = 'Лилия';
	// 		$toPhone = '+74954456119';
	// 		break;
	// 	case 'Киевское':
	// 		$toName = 'Лилия';
	// 		$toPhone = '+74954456119';
	// 		break;
	//
	// 	default:
	// 		$toName = 'Посёлкино';
	// 		$toPhone = '+74951860665';
	// 		break;
	// }

	$toCategory = ($toPhone == '+74951860665') ? 'agency' : 'developer';

	$description = str_replace('&nbsp;','',$arElement['PREVIEW_TEXT']);
	$description = trim(strip_tags($description));

	$arCoordinates = explode(',',$arElement['PROPERTY_COORDINATES_VALUE']);
	$latitude = trim($arCoordinates[0]);
	$longitude = trim($arCoordinates[1]);

  $xml_content .= '<offer internal-id="'.$arElement['ID'].'">';
    $xml_content .= '<type>продажа</type>';
    $xml_content .= '<property-type>жилая</property-type>';
    $xml_content .= '<category>'.$category.'</category>';
    $xml_content .= '<url>https://poselkino.ru'.$arElement['DETAIL_PAGE_URL'].'</url>';
    $xml_content .= '<creation-date>'.date('c',$creation_date).'</creation-date>';
		$xml_content .= '<description>'.$description.'</description>';
    $xml_content .= '<location>';
      $xml_content .= '<country>Россия</country>';
			$xml_content .= '<region>Московская область</region>';

			if ($arElement['PROPERTY_LOCATION_YA_REAL_VALUE'])
				$xml_content .= '<district>'.$arElement['PROPERTY_LOCATION_YA_REAL_VALUE'].'</district>';
			else
      	$xml_content .= '<district>'.$arElement['PROPERTY_REGION_VALUE'].' район</district>';

      $xml_content .= '<locality-name>'.$arElement['NAME'].'</locality-name>';
      $xml_content .= '<distance>'.$arElement['PROPERTY_MKAD_VALUE'].'</distance>';
			$xml_content .= '<direction>'.$highway.'</direction>';
			if ($latitude) $xml_content .= '<latitude>'.$latitude.'</latitude>';
			if ($longitude) $xml_content .= '<longitude>'.$longitude.'</longitude>';
    $xml_content .= '</location>';

		$xml_content .= '<sales-agent>';
			$xml_content .= '<name>'.$toName.'</name>';
			$xml_content .= '<phone>'.$toPhone.'</phone>';
			$xml_content .= '<category>'.$toCategory.'</category>';
		$xml_content .= '</sales-agent>';

		/* if ($arElement['PROPERTY_DEVELOPER_ID_VALUE']) { // если указан девелопер
			foreach ($arDeveloper as $key => $developer) { // передадим девелоперов

				$arPhone = explode(',',$developer['UF_PHONE']);

				$xml_content .= '<sales-agent>';

				if ($arPhone[0]) // если указан телефон
				{
		      $xml_content .= '<name>'.$developer['UF_NAME'].'</name>';
					foreach ($arPhone as $phone) {
						$phone = str_replace(['(',')',' ','-'],'',trim($phone));
						$xml_content .= '<phone>'.$phone.'</phone>';
					}
		      $xml_content .= '<category>developer</category>';
				}
				else
				{
					$xml_content .= '<name>Посёлкино</name>';
					$xml_content .= '<phone>+74951860665</phone>';
					$xml_content .= '<category>agency</category>';
				}

				$xml_content .= '</sales-agent>';
			}
		} else {
			$xml_content .= '<sales-agent>';
				$xml_content .= '<name>Посёлкино</name>';
				$xml_content .= '<phone>+74951860665</phone>';
				$xml_content .= '<category>agency</category>';
			$xml_content .= '</sales-agent>';
		} */

    $xml_content .= '<price>';
      $xml_content .= '<value>'.$price.'</value>';
      $xml_content .= '<currency>RUB</currency>';
      // $xml_content .= '<unit>'.$unit.'</unit>';
    $xml_content .= '</price>';
    $xml_content .= $area;

		foreach ($arElement['PROPERTY_DOP_FOTO_VALUE'] as $photo)
			$xml_content .= '<image>https://poselkino.ru'.\CFile::GetPath($photo).'</image>';

  $xml_content .= '</offer>'; $i++;

} // dump($arVillage);
echo 'Всего: '.$i.'<br>';

// запись в файл
	// $fp = fopen('../yandex.xml', 'w+');

	$fp = fopen($_SERVER["DOCUMENT_ROOT"].'/yandex.xml', 'w+');
	$xml = '<?xml version="1.0" encoding="UTF-8"?><realty-feed xmlns="http://webmaster.yandex.ru/schemas/feed/realty/2010-06"><generation-date>'.date('c').'</generation-date>'.$xml_content.'</realty-feed>';
	fwrite($fp,$xml);
	fclose($fp);
