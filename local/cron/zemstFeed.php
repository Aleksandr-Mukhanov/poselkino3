<?php set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
	Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

// земформат

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

$params = [
  "max_len" => "100", // обрезает символьный код до 100 символов
  "change_case" => "L", // буквы преобразуются к нижнему регистру
  "replace_space" => "-", // меняем пробелы на тире
  "replace_other" => "-", // меняем левые символы на тире
  "delete_repeat_replace" => "true", // удаляем повторяющиеся символы
  "use_google" => "false", // отключаем использование google
];

$strCSV = " --- ".date('d.m.Y H:i:s')." --- \n";
$strCSV .= "XML Developer: zemform\n\n";

$arURLFeed = [
	3497 => 'https://zemst.ru/plan/xml/shadrino.xml', // Шадрино
	// 3154 => 'https://zemst.ru/plan/xml/ignatovo.xml', // Игнатово
	3256 => 'https://zemst.ru/plan/xml/flora-park-2.xml', // Флора-Парк-2
	// 3339 => 'https://zemst.ru/plan/xml/vesna-park.xml', // Весна Парк
	3394 => 'https://zemst.ru/plan/xml/pahra-river-park.xml', // Пахра Ривер Парк
	// 1590 => 'https://zemst.ru/plan/xml/novoe-borilovo.xml', // Новое Борилово
	3272 => 'https://zemst.ru/plan/xml/ekokvartal-razdole.xml', // ЭкоКвартал Раздолье
	// 3306 => 'https://zemst.ru/plan/xml/udino-park.xml', // Удино Парк
	3345 => 'https://zemst.ru/plan/xml/elki-park.xml', // Елки-Парк
	3255 => 'https://zemst.ru/plan/xml/homutovo.xml', // Хомутово
	3193 => 'https://zemst.ru/plan/xml/yujniy-park.xml', // Южный парк
	3204 => 'https://zemst.ru/plan/xml/rusavkino-zarecnoe.xml', // Русавкино-Заречное
	3358 => 'https://zemst.ru/plan/xml/faustovo.xml', // Фаустово
	// 3360 => 'https://zemst.ru/plan/xml/festival.xml', // Фестиваль
	3321 => 'https://zemst.ru/plan/xml/kalitino.xml', // Калитино
	3396 => 'https://zemst.ru/plan/xml/sokolniki.xml', // Сокольники
	3333 => 'https://zemst.ru/plan/xml/nazaryevo.xml', // Назарьево
	// 4077 => 'https://zemst.ru/plan/xml/malinki-park.xml', // Малинки Парк
	4485 => 'https://zemst.ru/plan/xml/mishutinskaya-sloboda.xml', // Мишутинская слобода
	3613 => 'https://zemst.ru/plan/xml/rizhskie-zori.xml', // Рижские зори
	5350 => 'https://zemst.ru/plan/xml/yarkoe.xml', // Яркое
	5639 => 'https://zemst.ru/plan/xml/lapino.xml', // Лапино
	// 5639 => 'https://zemst.ru/plan/xml/kupavna.xml', // Купавна
	// 6809 => 'https://zemst.ru/plan/xml/pirogovo.xml', // ЭК Пирогово
	6149 => 'https://zemst.ru/plan/xml/perviy.xml', // Первый
	8413 => 'https://zemst.ru/plan/xml/karcevo.xml', // Карцево
];

foreach ($arURLFeed as $idVil => $urlFeed)
	$arVillageIds[] = $idVil;

// получим поселки
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>1,"ID" => $arVillageIds);
$arSelect = Array("ID","NAME","PREVIEW_PICTURE","PROPERTY_DEVELOPER_ID","PROPERTY_DATE_FEED","PROPERTY_COUNT_PLOTS_SOLD","PROPERTY_COUNT_PLOTS_SALE","PROPERTY_MKAD",'PROPERTY_REGION','PROPERTY_SHOSSE','PROPERTY_TYPE','PROPERTY_ELECTRO','PROPERTY_GAS','PROPERTY_PLUMBING','PROPERTY_BUS','PROPERTY_TRAIN','PROPERTY_WATER','PROPERTY_LES','PROPERTY_PLYAZH');
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);

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

  $arVillage[$arElement['ID']] = [
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
} // dump($arVillage);

// получим участки
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>5,"PROPERTY_VILLAGE" => $arVillageIds);
$arSelect = Array("ID","ACTIVE","NAME","PROPERTY_DEVELOPER_ID","PROPERTY_NUMBER","PROPERTY_VILLAGE","PROPERTY_DATE_FEED");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);
	$keyElement = $arElement['PROPERTY_DEVELOPER_ID_VALUE'].'_'.$arElement['PROPERTY_VILLAGE_VALUE'].'_'.$arElement['PROPERTY_NUMBER_VALUE'];
	$arPlot[$keyElement] = $arElement;
} // dump($arPlot);

$action = false;

foreach ($arURLFeed as $idVil => $urlFeed) {

	$xmlFeed = file_get_contents($urlFeed);
	$arFeed = new SimpleXMLElement($xmlFeed);

	$dateUpdate = date('d.m.Y',strtotime($arFeed['date']));

	$arOfferVillage = $arVillage[$idVil];

	$vilName = $arOfferVillage['NAME'];
	$vilCode = CUtil::translit($vilName, "ru", $params);
	$vilMKAD = $arOfferVillage['MKAD_KM'];
	$idDeveloper = $arOfferVillage['DEVELOPER_ID'];

	$strCSV .= $vilName."\n\n";

	$plotCntFree = 0; $maxPriceLand = 0;
	$plotCntSold = 0; $maxPriceSotka = 0;
	$plotCntOther = 0;

	$regions = $arFeed->region;
	foreach ($regions as $region) // переберем поселки
	{
	  $plotStatus = $region -> {'params'} -> {'status'};
	  $plotId = $region['id'];
		$keyPlot = $idDeveloper.'_'.$idVil.'_'.$plotId;
		$plotPrice = $region -> {'prices'} -> {'land'};

	  // echo '<p>'.$plotId.') '.$plotStatus.'</p>';

	  if ($plotStatus == 'Свободен' && $plotPrice) { $plotCntFree++; // dump($region);

			$plotSotka = $region -> {'prices'} -> {'sotka'};
			$arrangement = $region -> {'prices'} -> {'arrangement'};
	    $plotArea = $region -> {'params'} -> {'area'};
			$cadastr = $region -> {'params'} -> {'cadastr'};
			$special = $region -> {'special'};
			if ($special) $action = true;

	    $PRICE = str_replace(' ','',$plotPrice);
	    $NUMBER = $plotId;
	    $PLOTTAGE = str_replace(',','.',$plotArea);

			if (in_array($idVil,[6809,3613,4077,6149,5639,8413]) && $PLOTTAGE <= 6) continue; // ЭК Пирогово, Рижские зори, Малинки Парк, Первый, Лапино, Карцево

			// формула добавления участков
			switch ($PLOTTAGE) {
				case $PLOTTAGE <= 5:
					$strPlot = '4_5'; $cntPlots = 1; break;
				case $PLOTTAGE <= 6:
					$strPlot = '5_6'; $cntPlots = 3; break;
				case $PLOTTAGE <= 7:
					$strPlot = '6_7'; $cntPlots = 3; break;
				case $PLOTTAGE <= 8:
					$strPlot = '7_8'; $cntPlots = 3; break;
				case $PLOTTAGE <= 9:
					$strPlot = '8_9'; $cntPlots = 2; break;
				case $PLOTTAGE <= 10:
					$strPlot = '9_10'; $cntPlots = 2; break;
				case $PLOTTAGE <= 12:
					$strPlot = '10_12'; $cntPlots = 2; break;
				case $PLOTTAGE <= 15:
					$strPlot = '12_15'; $cntPlots = 1; break;
				case $PLOTTAGE <= 20:
					$strPlot = '15_20'; $cntPlots = 1; break;
				default:
					$strPlot = 'other'; $cntPlots = 0; break;
			}
			$arPlottage[$idVil][$strPlot][] = $NUMBER;

	    $plotName = $vilName.': участок '.$NUMBER;
	    $plotCode = 'kupit-uchastok-'.$vilCode.'-'.$PLOTTAGE.'-sotok-'.$vilMKAD.'-km-mkad-id-'.$NUMBER;
	    // $PREVIEW_TEXT = $plot->{'description-land'};

			$PRICE_SOTKA = str_replace(' ','',$plotSotka);

			if ($PRICE) // мин, макс стоимость участка
			{
				if (!$minPriceLand) $minPriceLand = $PRICE;
				$minPriceLand = ($minPriceLand > $PRICE) ? $PRICE : $minPriceLand;
				$maxPriceLand = ($maxPriceLand < $PRICE) ? $PRICE : $maxPriceLand;
			}

			if ($PRICE_SOTKA) // мин, макс стоимость сотки
			{
				if (!$minPriceSotka) $minPriceSotka = $PRICE_SOTKA;
				$minPriceSotka = ($minPriceSotka > $PRICE_SOTKA) ? $PRICE_SOTKA : $minPriceSotka;
				$maxPriceSotka = ($maxPriceSotka < $PRICE_SOTKA) ? $PRICE_SOTKA : $maxPriceSotka;
			}

			if(array_key_exists($keyPlot,$arPlot)){ // если участок уже есть

				$ourPlot = $arPlot[$keyPlot]; // dump($ourPlot);

				if(strtotime($dateUpdate) > strtotime($ourPlot['PROPERTY_DATE_FEED_VALUE'])) // если обновлен
				{
					$strCSV .= "Обновляем участок: ".$plotName."\n";

					CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $dateUpdate, "DATE_FEED");
					CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $PRICE, "PRICE");
					CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $NUMBER, "NUMBER");
					CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $PLOTTAGE, "PLOTTAGE");
					CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $cadastr, "CADASTRAL");
					CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $arrangement, "ARRANGEMENT");
				}

			}else{ // добавляем

				$cntPlotsVil = count($arPlottage[$idVil][$strPlot]);

				if ($cntPlotsVil <= $cntPlots)
				{
					$strCSV .= "Добавляем участок: ".$plotName."\n";

			    $el = new CIBlockElement;
			    // св-ва участка
			    $PROP = array();
			    $PROP['VILLAGE'] = $idVil;
			    $PROP['PRICE'] = $PRICE;
			    $PROP['NUMBER'] = $NUMBER;
			    $PROP['PLOTTAGE'] = $PLOTTAGE;
					$PROP['CADASTRAL'] = $cadastr;
					$PROP['ARRANGEMENT'] = $arrangement;
			    $PROP['DATE_FEED'] = $dateUpdate;
			    $PROP['DEVELOPER_ID'] = $idDeveloper;
					$PROP['REGION'] = $arOfferVillage['REGION'];
					$PROP['SHOSSE'] = $arOfferVillage['SHOSSE'];
					$PROP['MKAD'] = $vilMKAD;
					$PROP['TYPE'] = $arOfferVillage['TYPE'];
					$PROP['ELECTRO'] = $arOfferVillage['ELECTRO'];
					$PROP['PLUMBING'] = $arOfferVillage['PLUMBING'];
					$PROP['GAS'] = $arOfferVillage['GAS'];
					$PROP['BUS'] = $arOfferVillage['BUS'];
					$PROP['TRAIN'] = $arOfferVillage['TRAIN'];
					$PROP['WATER'] = $arOfferVillage['WATER'];
					$PROP['LES'] = $arOfferVillage['LES'];
					$PROP['PLYAZH'] = $arOfferVillage['PLYAZH'];
			    // $PROP['DOP_PHOTO'] = $DOP_PHOTO;

			    $arLoadProductArray = Array(
			      "MODIFIED_BY"    		=> $USER->GetID(), // элемент изменен текущим пользователем
			      "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
			      "IBLOCK_ID"      		=> 5,
			      "PROPERTY_VALUES"		=> $PROP,
			      "NAME"           		=> $plotName,
			      "CODE"					 		=> $plotCode,
			      "ACTIVE"         		=> "Y",            // активен
			      // "PREVIEW_TEXT"	 		=> $PREVIEW_TEXT,
			      "PREVIEW_PICTURE"		=> CFile::MakeFileArray($arOfferVillage['PREVIEW_PICTURE']),
			    ); // dump($arLoadProductArray);

			    if (!$el->Add($arLoadProductArray))
						$strCSV .= "Ошибка добавления: ".$el->LAST_ERROR."\n";

				} else
					$strCSV .= " ... Пропускаем участок: ".$plotName."\n";
			}

	  }elseif($plotStatus == 'Продан'){ $plotCntSold++;

			if (array_key_exists($keyPlot,$arPlot)) // если участок есть - деактивируем
			{
				$ourPlot = $arPlot[$keyPlot];

				if($ourPlot['ACTIVE'] == 'Y')
				{
					$el = new CIBlockElement;
					if($el->update($ourPlot['ID'], [ "ACTIVE" => "N"]))
						$strCSV .= "Участок: ".$plotName." - деактивирован! \n";
			    else
						$strCSV .= "Ошибка деактивации: ".$plotName." - ".$el->LAST_ERROR."\n";
				}
			}

	  }else{ $plotCntOther++;
	    // echo '<p>'.$plotId.') '.$plotStatus.'</p>';
	  }
	}

	$ourVillage = $arVillage[$idVil];

	// обновим поселок
	if(strtotime($dateUpdate) > strtotime($ourVillage['DATE_FEED'])) // если обновлен
	{
		$strCSV .= "\nОбновляем поселок: ".$vilName."\n";

		$COUNT_PLOTS_SOLD = $plotCntSold;
		$COUNT_PLOTS_SALE = $plotCntFree;
		$COST_LAND_IN_CART_MIN = $minPriceLand;
		$COST_LAND_IN_CART_MAX = $maxPriceLand;
		$PRICE_SOTKA_MIN = $minPriceSotka;
		$PRICE_SOTKA_MAX = $maxPriceSotka;
		// $HOME_VALUE_MIN = str_replace(' ','',$offer->{'min-cost-of-the-house'});
		// $HOME_VALUE_MAX = str_replace(' ','',$offer->{'max-cost-of-the-house'});

		// обновляем поселок
		if($dateUpdate)
			CIBlockElement::SetPropertyValues($idVil, 1, $dateUpdate, "DATE_FEED");

		if($COUNT_PLOTS_SOLD && $COUNT_PLOTS_SOLD != $ourVillage['COUNT_PLOTS_SOLD']);
		{
			CIBlockElement::SetPropertyValues($idVil, 1, $COUNT_PLOTS_SOLD, "COUNT_PLOTS_SOLD");
			$strCSV .= " - Участков продано: ".$COUNT_PLOTS_SOLD."\n";
		}

		if($COUNT_PLOTS_SALE && $COUNT_PLOTS_SALE != $ourVillage['COUNT_PLOTS_SALE']);
		{
			CIBlockElement::SetPropertyValues($idVil, 1, $COUNT_PLOTS_SALE, "COUNT_PLOTS_SALE");
			$strCSV .= " - Участков в продаже: ".$COUNT_PLOTS_SALE."\n";
		}

		if($COST_LAND_IN_CART_MIN || $COST_LAND_IN_CART_MAX)
		{
			CIBlockElement::SetPropertyValues($idVil, 1, [$COST_LAND_IN_CART_MIN,$COST_LAND_IN_CART_MAX], "COST_LAND_IN_CART");
			$strCSV .= " - Стоимость участка min: ".$COST_LAND_IN_CART_MIN."\n";
			$strCSV .= " - Стоимость участка max: ".$COST_LAND_IN_CART_MAX."\n";
		}

		if($PRICE_SOTKA_MIN || $PRICE_SOTKA_MAX)
		{
			CIBlockElement::SetPropertyValues($idVil, 1, [$PRICE_SOTKA_MIN,$PRICE_SOTKA_MAX], "PRICE_SOTKA");
			$strCSV .= " - Цена за сотку min: ".$PRICE_SOTKA_MIN."\n";
			$strCSV .= " - Цена за сотку max: ".$PRICE_SOTKA_MAX."\n";
		}

		// if($HOME_VALUE_MIN || $HOME_VALUE_MAX)
		// {
		// 	CIBlockElement::SetPropertyValues($idVil, 1, [$HOME_VALUE_MIN,$HOME_VALUE_MAX], "HOME_VALUE");
		// 	$strCSV .= "Стоимость домов min: ".$HOME_VALUE_MIN."\n";
		// 	$strCSV .= "Стоимость домов max: ".$HOME_VALUE_MAX."\n";
		// }

		if($action) // активируем акцию
		{
			CIBlockElement::SetPropertyValues($idVil, 1, 170, "ACTION");
			$strCSV .= " - Акция: ДА \n";
			$action = false;
		}
	}

	unset($minPriceLand); unset($minPriceSotka);

	$strCSV .= "\nУчастки в фиде:\n";
	$strCSV .= " - Свободно: ".$plotCntFree."\n";
	$strCSV .= " - Продано: ".$plotCntSold."\n";
	$strCSV .= " - Технический: ".$plotCntOther."\n\n";

}

echo str_replace("\n","<br>",$strCSV);
// запишем в файл
$fp = fopen($_SERVER["DOCUMENT_ROOT"].'/local/cron/logs_feed/zemform: '.date('d.m.Y H:i:s').'.csv', 'a+');
fwrite($fp,$strCSV);
fclose($fp);
