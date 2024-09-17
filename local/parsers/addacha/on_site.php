<?php set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
	Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

$parserName = 'addacha';
$siteName = 'addacha.ru';
$xmlDeveloper = 'aj-da-dacha';
$test = false; // режим теста

// получим шоссе и районы
$arElHL = getElHL(16,[],[],['*']);
foreach ($arElHL as $value)
	$arShosse[$value['UF_NAME']] = $value['UF_XML_ID'];

$arElHL = getElHL(17,[],[],['*']);
foreach ($arElHL as $value)
	$arRegion[$value['UF_NAME']] = $value['UF_XML_ID'];

$arPlotsWater = [
	'Река' => 293,
	'Озеро' => 294,
	'Пруд' => 295,
];
$arPlotsLes = [
	'Хвойный' => 296,
	'Сосновый' => 297,
	'Березняк' => 298,
	'Смешанный' => 299,
];

$arParams = [
  "max_len" => "100", // обрезает символьный код до 100 символов
  "change_case" => "L", // буквы преобразуются к нижнему регистру
  "replace_space" => "-", // меняем пробелы на тире
  "replace_other" => "-", // меняем левые символы на тире
  "delete_repeat_replace" => "true", // удаляем повторяющиеся символы
  "use_google" => "false", // отключаем использование google
];

$strCSV = " --- ".date('d.m.Y H:i:s')." --- \n";
$strCSV .= "Parser: ".$siteName."\n\n";

$urlFeedVillages = $_SERVER["DOCUMENT_ROOT"].'/local/parsers/'.$parserName.'/villages_'.$parserName.'.csv';
$feedFileVillages = file_get_contents($urlFeedVillages);
$arFileVillages = explode("\n",$feedFileVillages);

$urlFeedPlots = $_SERVER["DOCUMENT_ROOT"].'/local/parsers/'.$parserName.'/plots_'.$parserName.'.csv';
$feedFilePlots = file_get_contents($urlFeedPlots);
$arFilePlots = explode("\n",$feedFilePlots);

// переберем поселки из фида
foreach ($arFileVillages as $key => $village)
{
  if ($key == 0) continue; // пропустим заголовок
  if ($village) {
    $arVillageInfo = explode(";",$village); // dump($arVillageInfo);
    if ($arVillageInfo[0])
		{
			// если не соответствует название
			if ($arVillageInfo[0] == 'Петрухино дальнее') $arVillageInfo[0] = 'Петрухино-Дальнее';
			if ($arVillageInfo[0] == 'Арнеево') $arVillageInfo[0] = 'Арнеево-2';

      $arVillageNames[] = $arVillageInfo[0];
      $arVillageFeed[$arVillageInfo[0]] = [
				'DATE_UPDATE' => date('d.m.Y',strtotime($arVillageInfo[1])),
        'PRICE_SOTKA_MIN' => $arVillageInfo[2],
        'PRICE_SOTKA_MAX' => $arVillageInfo[3],
        'COST_LAND_IN_CART_MIN' => $arVillageInfo[4],
        'COST_LAND_IN_CART_MAX' => $arVillageInfo[5],
        'PLOTTAGE_MIN' => $arVillageInfo[6],
        'PLOTTAGE_MAX' => $arVillageInfo[7],
        'COUNT_PLOTS_SOLD' => $arVillageInfo[8]-$arVillageInfo[9],
        'COUNT_PLOTS_SALE' => $arVillageInfo[9],
      ];
    } else
			$strCSV .= "Нет поселка в файле: ".$arVillageInfo[0]."\n";
  }
} // dump($arVillageFeed);

// переберем участки из фида
foreach ($arFilePlots as $key => $plot)
{
  if ($key == 0) continue; // пропустим заголовок
  if ($plot) {
    $arPlotInfo = explode(";",$plot); // dump($arPlotInfo);
    if ($arPlotInfo[2]) {
      $arPlotFeed[$arPlotInfo[2]] = [
				'VILLAGE' => $arPlotInfo[0],
				'DATE_UPDATE' => date('d.m.Y',strtotime($arPlotInfo[1])),
        'NUMBER' => $arPlotInfo[2],
        'PRICE' => $arPlotInfo[3],
        'PLOTTAGE' => $arPlotInfo[4],
        'CADASTRAL' => $arPlotInfo[5],
				'IMAGE' => $arPlotInfo[6],
      ];
    }
  }
} // dump($arPlotFeed);

if ($arVillageNames)
{
  $arOrder = Array("SORT"=>"ASC");
  $arFilter = Array("IBLOCK_ID"=>1,"NAME" => $arVillageNames,'PROPERTY_DEVELOPER_ID'=>$xmlDeveloper);
  $arSelect = Array("ID","NAME","CODE","PREVIEW_PICTURE","PROPERTY_DEVELOPER_ID","PROPERTY_DATE_FEED","PROPERTY_COUNT_PLOTS_SOLD","PROPERTY_COUNT_PLOTS_SALE","PROPERTY_MKAD",'PROPERTY_REGION','PROPERTY_SHOSSE','PROPERTY_TYPE','PROPERTY_ELECTRO','PROPERTY_GAS','PROPERTY_PLUMBING','PROPERTY_BUS','PROPERTY_TRAIN','PROPERTY_WATER','PROPERTY_LES','PROPERTY_PLYAZH','PROPERTY_PLOTTAGE');
  $rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
  while($arElement = $rsElements->Fetch())
	{
		$arVillageIDs[] = $arElement['ID'];

		foreach ($arElement['PROPERTY_SHOSSE_VALUE'] as $value)
			$shosse[] = $arShosse[$value];

		switch ($arElement['PROPERTY_TYPE_ENUM_ID']) {
			case 1:
				$vilType = 285; break; // Дачный поселок
			case 2:
				$vilType = 286; break; // Коттеджный поселок

			default:
				$vilType = 287; break; // Фермерство
		}

		foreach ($arElement['PROPERTY_WATER_VALUE'] as $value)
			$arWater[] = $arPlotsWater[$value];

		$arVillageOur[$arElement['CODE']] = [
	    'ID' => $arElement['ID'],
	    'NAME' => $arElement['NAME'],
			'PREVIEW_PICTURE' => $arElement['PREVIEW_PICTURE'],
	    'DATE_FEED' => $arElement['PROPERTY_DATE_FEED_VALUE'],
			'COUNT_PLOTS_SOLD' => $arElement['PROPERTY_COUNT_PLOTS_SOLD_VALUE'],
			'COUNT_PLOTS_SALE' => $arElement['PROPERTY_COUNT_PLOTS_SALE_VALUE'],
			'MKAD_KM' => $arElement['PROPERTY_MKAD_VALUE'],
			'DEVELOPER_ID' => $arElement['PROPERTY_DEVELOPER_ID_VALUE'][0],
			'REGION' => $arRegion[$arElement['PROPERTY_REGION_VALUE']],
			'SHOSSE' => $shosse,
			'TYPE' => $vilType,
			'ELECTRO' => ($arElement['PROPERTY_ELECTRO_ENUM_ID'] == 12) ? 288 : 0,
			'PLUMBING' => ($arElement['PROPERTY_PLUMBING_ENUM_ID'] == 18) ? 289 : 0,
			'GAS' => ($arElement['PROPERTY_GAS_ENUM_ID'] == 15) ? 290 : 0,
			'BUS' => ($arElement['PROPERTY_BUS_ENUM_ID'] == 57) ? 291 : 0,
			'TRAIN' => ($arElement['PROPERTY_TRAIN_ENUM_ID'] == 56) ? 292 : 0,
			'WATER' => $arWater,
			'LES' => $arPlotsLes[$arElement['PROPERTY_LES_VALUE']],
			'PLYAZH' => ($arElement['PROPERTY_PLYAZH_ENUM_ID'] == 42) ? 300 : 0,
	  ];
		unset($arWater); unset($shosse);
  }

	// получим участки
	if ($arVillageIDs) {
		$arOrder = Array("SORT"=>"ASC");
		$arFilter = Array("IBLOCK_ID"=>5,"PROPERTY_VILLAGE" => $arVillageIDs);
		$arSelect = Array("ID","ACTIVE","NAME","PROPERTY_DEVELOPER_ID","PROPERTY_NUMBER","PROPERTY_VILLAGE","PROPERTY_DATE_FEED");
		$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
		while($arElement = $rsElements->Fetch()){ // dump($arElement);
			$keyElement = $arElement['PROPERTY_DEVELOPER_ID_VALUE'].'_'.$arElement['PROPERTY_VILLAGE_VALUE'].'_'.$arElement['PROPERTY_NUMBER_VALUE'];
			$arPlotOur[$keyElement] = $arElement;
		}
	}

	foreach ($arPlotFeed as $plotFeed) // перебираем участки из фида
	{
		$dateUpdate = $plotFeed['DATE_UPDATE'];
		$NUMBER = $plotFeed['NUMBER'];
		$PRICE = $plotFeed['PRICE'];
		$PLOTTAGE = $plotFeed['PLOTTAGE'];
		$plotImage = $plotFeed['IMAGE'];

		$villageCode = CUtil::translit($plotFeed['VILLAGE'], "ru", $arParams);

		// если не соответствует символьный код

		$arOfferVillage = $arVillageOur[$villageCode];

		$villageID = $arOfferVillage['ID'];
		$developerID = $arOfferVillage['DEVELOPER_ID'];
		$villageName = $arOfferVillage['NAME'];
		$villageMKAD = $arOfferVillage['MKAD_KM'];

		if (!$villageID) $arVillageNO[$villageCode] = $plotFeed["VILLAGE"];
		else $arVillageYes[$villageCode] = $plotFeed["VILLAGE"];

		$keyPlot = $developerID.'_'.$villageID.'_'.$NUMBER;
		$arPlotUpdate[] = $keyPlot;

		$plotName = $villageName.': участок '.$NUMBER;
		$plotCode = 'kupit-uchastok-'.$villageCode.'-'.$PLOTTAGE.'-sotok-'.$villageMKAD.'-km-mkad-id-'.$NUMBER;

		// формула добавления участков
		switch ($PLOTTAGE) {
			case $PLOTTAGE < 5:
				$strPlot = '0_5'; $cntPlots = 0; break;
			case $PLOTTAGE <= 6:
				$strPlot = '5_6'; $cntPlots = 1; break;
			case $PLOTTAGE <= 7:
				$strPlot = '6_7'; $cntPlots = 2; break;
			case $PLOTTAGE <= 8:
				$strPlot = '7_8'; $cntPlots = 2; break;
			case $PLOTTAGE <= 10:
				$strPlot = '8_10'; $cntPlots = 2; break;
			default:
				$strPlot = 'other'; $cntPlots = 1; break;
		}
		$arPlottage[$villageID][$strPlot][] = $NUMBER;

		if ($arPlotOur && array_key_exists($keyPlot,$arPlotOur)) // если участок уже есть
		{
			$ourPlot = $arPlotOur[$keyPlot]; // dump($ourPlot);

			// if ($village_name == 'Матчино Парк') dump($ourPlot);

			if (strtotime($dateUpdate) > strtotime($ourPlot['PROPERTY_DATE_FEED_VALUE'])) { // если обновлен
				$strCSV .= "Обновляем участок: ".$plotName."\n";
				if (!$test) {
					CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $dateUpdate, "DATE_FEED");
					CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $plotFeed['PRICE'], "PRICE");
				}
			}

		} elseif($villageID) { // добавляем

			$cntPlotsVil = count($arPlottage[$villageID][$strPlot]);

			if ($cntPlotsVil <= $cntPlots)
			{
				$strCSV .= "Добавляем участок: ".$plotName."\n";

				// обработчик фото
				if ($plotImage)
					$PREVIEW_PICTURE = CFile::MakeFileArray($plotImage);
				else
					$PREVIEW_PICTURE = CFile::MakeFileArray($arOfferVillage['PREVIEW_PICTURE']);

				$el = new CIBlockElement;
				// св-ва участка
				$PROP = array();
				$PROP['VILLAGE'] = $villageID;
				$PROP['PRICE'] = $PRICE;
				$PROP['NUMBER'] = $NUMBER;
				$PROP['PLOTTAGE'] = $PLOTTAGE;
				$PROP['DATE_FEED'] = $dateUpdate;
				$PROP['DEVELOPER_ID'] = $developerID;
				$PROP['REGION'] = $arOfferVillage['REGION'];
				$PROP['SHOSSE'] = $arOfferVillage['SHOSSE'];
				$PROP['MKAD'] = $arOfferVillage['MKAD_KM'];
				$PROP['TYPE'] = $arOfferVillage['TYPE'];
				$PROP['ELECTRO'] = $arOfferVillage['ELECTRO'];
				$PROP['PLUMBING'] = $arOfferVillage['PLUMBING'];
				$PROP['GAS'] = $arOfferVillage['GAS'];
				$PROP['BUS'] = $arOfferVillage['BUS'];
				$PROP['TRAIN'] = $arOfferVillage['TRAIN'];
				$PROP['WATER'] = $arOfferVillage['WATER'];
				$PROP['LES'] = $arOfferVillage['LES'];
				$PROP['PLYAZH'] = $arOfferVillage['PLYAZH'];
				$PROP['CADASTRAL'] = $plotFeed['CADASTRAL'];

				$arLoadProductArray = Array(
					"MODIFIED_BY"    		=> $USER->GetID(), // элемент изменен текущим пользователем
					"IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
					"IBLOCK_ID"      		=> 5,
					"PROPERTY_VALUES"		=> $PROP,
					"NAME"           		=> $plotName,
					"CODE"					 		=> $plotCode,
					"ACTIVE"         		=> "Y",            // активен
					"PREVIEW_PICTURE"		=> $PREVIEW_PICTURE,
				); // dump($arLoadProductArray);

				if (!$test) {
					if (!$el->Add($arLoadProductArray))
						$strCSV .= "Ошибка добавления: ".$el->LAST_ERROR."\n";
				}

			} else
				$strCSV .= " ... Пропускаем участок: ".$plotName."\n";
		}
	}

	foreach ($arVillageOur as $ourVillage) // перебираем наши поселки
	{

		$villageID = $ourVillage['ID'];
		$feedVillage = $arVillageFeed[$ourVillage['NAME']];

		if(strtotime($feedVillage['DATE_UPDATE']) > strtotime($ourVillage['DATE_FEED'])) // если обновлен
		{
			$strCSV .= "\nОбновляем поселок: ".$ourVillage['NAME']."\n";

			if(!$test && $feedVillage['DATE_UPDATE'])
				CIBlockElement::SetPropertyValues($villageID, 1, $feedVillage['DATE_UPDATE'], "DATE_FEED");

			if($feedVillage['COUNT_PLOTS_SOLD'] && ($feedVillage['COUNT_PLOTS_SOLD'] != $ourVillage['COUNT_PLOTS_SOLD']));
			{
				if (!$test)
					CIBlockElement::SetPropertyValues($villageID, 1, $feedVillage['COUNT_PLOTS_SOLD'], "COUNT_PLOTS_SOLD");
				$strCSV .= " - Участков продано: ".$feedVillage['COUNT_PLOTS_SOLD']."\n";
			}

			if($feedVillage['COUNT_PLOTS_SALE'] && ($feedVillage['COUNT_PLOTS_SALE'] != $ourVillage['COUNT_PLOTS_SALE']));
			{
				if (!$test)
					CIBlockElement::SetPropertyValues($villageID, 1, $feedVillage['COUNT_PLOTS_SALE'], "COUNT_PLOTS_SALE");
				$strCSV .= " - Участков в продаже: ".$feedVillage['COUNT_PLOTS_SALE']."\n";
			}

			if($feedVillage['COST_LAND_IN_CART_MIN'] || $feedVillage['COST_LAND_IN_CART_MAX'])
			{
				if (!$test)
					CIBlockElement::SetPropertyValues($villageID, 1, [$feedVillage['COST_LAND_IN_CART_MIN'],$feedVillage['COST_LAND_IN_CART_MAX']], "COST_LAND_IN_CART");
				$strCSV .= " - Стоимость участка min: ".$feedVillage['COST_LAND_IN_CART_MIN']."\n";
				$strCSV .= " - Стоимость участка max: ".$feedVillage['COST_LAND_IN_CART_MAX']."\n";
			}

			if($feedVillage['PRICE_SOTKA_MIN'] || $feedVillage['PRICE_SOTKA_MAX'])
			{
				if (!$test)
					CIBlockElement::SetPropertyValues($villageID, 1, [$feedVillage['PRICE_SOTKA_MIN'],$feedVillage['PRICE_SOTKA_MAX']], "PRICE_SOTKA");
				$strCSV .= " - Цена за сотку min: ".$feedVillage['PRICE_SOTKA_MIN']."\n";
				$strCSV .= " - Цена за сотку max: ".$feedVillage['PRICE_SOTKA_MAX']."\n";
			}
			if($feedVillage['PLOTTAGE_MIN'] || $feedVillage['PLOTTAGE_MAX'])
			{
				if (!$test)
					CIBlockElement::SetPropertyValues($villageID, 1, [$feedVillage['PLOTTAGE_MIN'],$feedVillage['PLOTTAGE_MAX']], "PLOTTAGE");
				$strCSV .= " - Площадь min: ".$feedVillage['PLOTTAGE_MIN']."\n";
				$strCSV .= " - Площадь max: ".$feedVillage['PLOTTAGE_MAX']."\n";
			}
		}
	}
}

// деактивируем участки, которых нет в фиде
foreach ($arPlotOur as $keyPlot => $valuePlot) {
	if (!in_array($keyPlot,$arPlotUpdate)) {
		if ($valuePlot['ACTIVE'] == 'Y' && !$test)
		{
			$el = new CIBlockElement;
			if($el->update($valuePlot['ID'], [ "ACTIVE" => "N"]))
				$strCSV .= "Участок: ".$valuePlot['NAME']." - деактивирован! \n";
			else
				$strCSV .= "Ошибка деактивации: ".$plotName." - ".$el->LAST_ERROR."\n";
		}
	}
}

if ($arVillageYes) {
	$strCSV .= "\n";
	foreach ($arVillageYes as $key => $value) {
		$strCSV .= "Обновляем поселок: ".$value." (".$key.")\n";
	}
}

if ($arVillageNO) {
	$strCSV .= "\n";
	foreach ($arVillageNO as $key => $value) {
		$strCSV .= "Нет поселка на сайте: ".$value." (".$key.")\n";
	}
}

$strCSV .= "\n\n";

echo str_replace("\n","<br>",$strCSV);

// запишем в файл
$fp = fopen($_SERVER["DOCUMENT_ROOT"].'/local/parsers/'.$parserName.'/logs_on_site.csv', 'a+');
fwrite($fp,$strCSV);
fclose($fp);
