<?php set_time_limit(0);
header('Content-Type: text/html; charset=utf-8');
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
	Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

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

// получим поселки девелопера
// $xmlDeveloper = 'Udacha';
// $typeFeed = 'ydacha';
// $urlFeed = 'https://www.ydacha.ru/local/ydacha/export/index.php?format=poselkino&token=tulYT78ysdk7T';

$xmlDeveloper = 'Zemelniy-Ekspress';
$typeFeed = 'zemexx';
$urlFeed = 'https://zemexx.ru/yrl/?version=dealer';

$strCSV .= "XML Developer: ".$xmlDeveloper."\n\n";

$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>1,"PROPERTY_DEVELOPER_ID" => $xmlDeveloper);
$arSelect = Array("ID","NAME","CODE",'PREVIEW_PICTURE',"PROPERTY_DEVELOPER_ID","PROPERTY_DATE_FEED","PROPERTY_COUNT_PLOTS","PROPERTY_COUNT_PLOTS_SOLD","PROPERTY_COUNT_PLOTS_SALE","PROPERTY_MKAD",'PROPERTY_REGION','PROPERTY_SHOSSE','PROPERTY_TYPE','PROPERTY_ELECTRO','PROPERTY_GAS','PROPERTY_PLUMBING','PROPERTY_BUS','PROPERTY_TRAIN','PROPERTY_WATER','PROPERTY_LES','PROPERTY_PLYAZH');
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

  $arVillage[$arElement['CODE']] = [
    'ID' => $arElement['ID'],
    'NAME' => $arElement['NAME'],
		'PREVIEW_PICTURE' => $arElement['PREVIEW_PICTURE'],
    'DATE_FEED' => $arElement['PROPERTY_DATE_FEED_VALUE'],
		'COUNT_PLOTS' => $arElement['PROPERTY_COUNT_PLOTS_VALUE'],
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
	$arVillageIds[] = $arElement['ID'];
	unset($arWater); unset($shosse);
} // dump($arVillage);

// получим участки девелоперов
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>5,"PROPERTY_VILLAGE" => $arVillageIds);
$arSelect = Array("ID","NAME","PROPERTY_DEVELOPER_ID","PROPERTY_NUMBER","PROPERTY_VILLAGE","PROPERTY_DATE_FEED");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);
	$keyElement = $arElement['PROPERTY_DEVELOPER_ID_VALUE'].'_'.$arElement['PROPERTY_VILLAGE_VALUE'].'_'.$arElement['PROPERTY_NUMBER_VALUE'];
  $arPlot[$keyElement] = $arElement;
} // dump($arPlot);

$xmlFeed = file_get_contents($urlFeed);
$arFeed = new SimpleXMLElement($xmlFeed);

$i = 0;
$offers = $arFeed->offer;
foreach ($offers as $offer)
{
	$i++; // переберем офферы
  $category = $offer -> {'category'};
  $village_name = $offer -> {'village-name'};
	// if ($village_name == 'Рэд') $village_name = 'Рэд (Red)';
  $village_code = CUtil::translit($village_name, "ru", $params);
	if ($village_code == 'kalipso-villadzh-2') $village_code = 'calipso-village-2';
	elseif ($village_code == 'favorit') $village_code = 'favorit-';
	elseif ($village_code == 'svetlyy') $village_code = 'svetlyj';

	$region = $offer->{'location'}->{'region'};
  // echo '<p>'.$i.') '.$category.' '.$nomer.' - поселок: '.$village_name.'</p>';

  if ($category == 'участок') {
    if (array_key_exists($village_code,$arVillage)) { // если поселок есть на сайте

			$arOfferVillage = $arVillage[$village_code];

      $idVil = $arOfferVillage['ID'];
      $vilName = $arOfferVillage['NAME'];
      $vilCode = $village_code;
      $vilMKAD = $arOfferVillage['MKAD_KM'];
    	$idDeveloper = $arOfferVillage['DEVELOPER_ID'];

      // получим номер участка
			if ($typeFeed == 'ydacha')
			{
	      $url = $offer -> {'url'};
	      $arUrl1 = explode('?',$url);
	      $arUrl2 = explode('-',$arUrl1[0]);
	      $plotId = $arUrl2[count($arUrl2) - 1];
			}
			else $plotId = $offer -> {'plot_id'};

			$dateUpdate = $offer -> {'last-update-date'};
			$dateUpdateOnSite = date('d.m.Y H:i',strtotime($dateUpdate));
			$plotPrice = $offer -> {'price'} -> {'value'};
	    $plotArea = $offer -> {'lot-area'} -> {'value'};

	    $PRICE = str_replace(' ','',$plotPrice);
	    $NUMBER = $plotId;
	    $PLOTTAGE = str_replace(',','.',$plotArea);

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
	    $PREVIEW_TEXT = $offer->{'description'};
	    $keyPlot = $idDeveloper.'_'.$idVil.'_'.$NUMBER;

			// узнаем мин стоимость сотки
			if($PRICE && $PLOTTAGE)
				$plotPriceSotka = round((int)$PRICE / (float)$PLOTTAGE);

			$minPriceSotka = $arUpdateVillage[$vilCode]['minPriceSotka'];
			if(!$minPriceSotka || $minPriceSotka > $plotPriceSotka)
				$minPriceSotka = $plotPriceSotka;

			$maxPriceSotka = $arUpdateVillage[$vilCode]['maxPriceSotka'];
			if(!$maxPriceSotka || $maxPriceSotka < $plotPriceSotka)
				$maxPriceSotka = $plotPriceSotka;

			// if ($village_name == 'Рэд')
			// 	echo $plotName.' - '.$PRICE.' / '.$PLOTTAGE.' = '.$plotPriceSotka.'<br>';

			if (array_key_exists($keyPlot,$arPlot)) // если участок уже есть
			{
				$ourPlot = $arPlot[$keyPlot]; // dump($ourPlot);

				// if ($village_name == 'Матчино Парк') dump($ourPlot);

				if(strtotime($dateUpdate) > strtotime($ourPlot['PROPERTY_DATE_FEED_VALUE'])){ // если обновлен
					$strCSV .= "Обновляем участок: ".$plotName."\n";
					CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $dateUpdateOnSite, "DATE_FEED");
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

					// обработчик фото
					if (!$arVillageIMG[$vilCode])
					{
						$arImage = $offer->{'image'};
						if ($arImage) {
							$i = 0;
							foreach ($arImage as $value) {
								if ($i == 0)
								{
									$arPhoto = CFile::MakeFileArray($value);
									$arVillageIMG[$vilCode]['PREVIEW'] = $arPhoto;
								}
								$i++;
								// $arPhoto = CFile::MakeFileArray($value);
								// if ($arPhoto['name']) {
								// 	if ($i == 0)
								// 		$arVillageIMG[$vilCode]['PREVIEW'] = $arPhoto;
								// 	else
								// 		$arVillageIMG[$vilCode]['DOP_PHOTO'][] = $arPhoto;
								// 	$i++;
								// }
							}
						}
					}

					// получим фото
					// $DOP_PHOTO = array(); $i=0;
					// $arImage = $offer->{'image'};
					// if($arImage){
					// 	foreach ($arImage as $value) {
					// 		$arPhoto = CFile::MakeFileArray($value);
					// 		if($arPhoto['name']){
					// 			if ($i == 0)
					// 				$PREVIEW_PICTURE = $arPhoto;
					// 			else
					// 				$DOP_PHOTO[] = $arPhoto;
					// 			$i++;
					// 		}
					// 	}
					// }

					$PREVIEW_PICTURE = ($arVillageIMG[$vilCode]['PREVIEW']) ? $arVillageIMG[$vilCode]['PREVIEW'] : CFile::MakeFileArray($arOfferVillage['PREVIEW_PICTURE']);
					// $DOP_PHOTO = $arVillageIMG[$vilCode]['DOP_PHOTO'];

			    $el = new CIBlockElement;
			    // св-ва участка
			    $PROP = array();
			    $PROP['VILLAGE'] = $idVil;
			    $PROP['PRICE'] = $PRICE;
			    $PROP['NUMBER'] = $NUMBER;
			    $PROP['PLOTTAGE'] = $PLOTTAGE;
			    $PROP['DATE_FEED'] = $dateUpdateOnSite;
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
			    // if ($DOP_PHOTO) $PROP['DOP_PHOTO'] = $DOP_PHOTO;

			    $arLoadProductArray = Array(
			      "MODIFIED_BY"    		=> $USER->GetID(), // элемент изменен текущим пользователем
			      "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
			      "IBLOCK_ID"      		=> 5,
			      "PROPERTY_VALUES"		=> $PROP,
			      "NAME"           		=> $plotName,
			      "CODE"					 		=> $plotCode,
			      "ACTIVE"         		=> "Y",            // активен
			      "PREVIEW_TEXT"	 		=> $PREVIEW_TEXT,
			      "PREVIEW_PICTURE"		=> $PREVIEW_PICTURE,
			    ); // dump($arLoadProductArray);

			    if (!$el->Add($arLoadProductArray))
						$strCSV .= "Ошибка добавления: ".$el->LAST_ERROR."\n";

				} else
					$strCSV .= " ... Пропускаем участок: ".$plotName."\n";
			}

			// кол-во участков в продаже
			$plotCntSale = $arUpdateVillage[$vilCode]['plotCntSale'];
			$plotCntSale = ($plotCntSale) ? $plotCntSale+1 : 1;

			// if ($village_name == 'Матчино Парк') dump($plotCntSale);

			// мин, макс стоимость участка
			$minPriceLand = $arUpdateVillage[$vilCode]['minPriceLand'];
			if (!$minPriceLand) $minPriceLand = $PRICE;
			$minPriceLand = ($minPriceLand > $PRICE) ? $PRICE : $minPriceLand;

			$maxPriceLand = $arUpdateVillage[$vilCode]['maxPriceLand'];
			if (!$maxPriceLand) $maxPriceLand = 0;
			$maxPriceLand = ($maxPriceLand < $PRICE) ? $PRICE : $maxPriceLand;

			$arUpdateVillage[$vilCode] = [
				'ID' => $idVil,
				'NAME' => $vilName,
				'plotCntSale' => $plotCntSale,
				'minPriceLand' => $minPriceLand,
				'maxPriceLand' => $maxPriceLand,
				'minPriceSotka' => $minPriceSotka,
				'maxPriceSotka' => $maxPriceSotka,
				'region' => $region
			];
    }else{
			$arNotVillage[$village_code] = [
				'NAME' => $village_name,
				'region' =>$region
			];
		}
  }
} // dump($arNotVillage);

if ($arUpdateVillage)
{
	foreach ($arUpdateVillage as $vilCode => $village) {
		$strCSV .= "\nОбновляем поселок: ".$village['NAME']."\n";

		$ourVillage = $arVillage[$vilCode];

		$idVil = $village['ID'];
		$dateUpdate = date('d.m.Y H:i');
		$COUNT_PLOTS_SALE = $village['plotCntSale'];
		$COUNT_PLOTS_SOLD = $ourVillage['COUNT_PLOTS'] - $COUNT_PLOTS_SALE;
		$COST_LAND_IN_CART_MIN = $village['minPriceLand'];
		$COST_LAND_IN_CART_MAX = $village['maxPriceLand'];
		$PRICE_SOTKA_MIN = $village['minPriceSotka'];
		$PRICE_SOTKA_MAX = $village['maxPriceSotka'];
		// $HOME_VALUE_MIN = str_replace(' ','',$offer->{'min-cost-of-the-house'});
		// $HOME_VALUE_MAX = str_replace(' ','',$offer->{'max-cost-of-the-house'});
		// процент для статуса
		if ($COUNT_PLOTS_SOLD == 0) $COUNT_PLOTS_SOLD = 1;
		$percentSold = ((int)$COUNT_PLOTS_SOLD * 100) / (int)$ourVillage['COUNT_PLOTS'];

		// if ($village['NAME'] == 'Шереметьевская усадьба')
		// {
		// 	dump($COUNT_PLOTS_SALE);
		// 	dump($COUNT_PLOTS_SOLD);
		// 	dump($ourVillage['COUNT_PLOTS']);
		// 	dump($percentSold);
		// }

		switch ($percentSold) {
			case ($percentSold < 30): $idSalesPhase = 9; $salesPhase = 'Старт продаж'; break;
			case ($percentSold < 70): $idSalesPhase = 10; $salesPhase = 'Активные продажи'; break;
			case ($percentSold < 100): $idSalesPhase = 11; $salesPhase = 'Финальные продажи'; break;
			default: $idSalesPhase = 254; $salesPhase = 'Поселок продан'; break;
		}

		// обновляем поселок
		if ($dateUpdate)
			CIBlockElement::SetPropertyValues($idVil, 1, $dateUpdate, "DATE_FEED");

		if ($COUNT_PLOTS_SOLD && $COUNT_PLOTS_SOLD != $ourVillage['COUNT_PLOTS_SOLD']) {
			CIBlockElement::SetPropertyValues($idVil, 1, $COUNT_PLOTS_SOLD, "COUNT_PLOTS_SOLD");
			$strCSV .= "- Кол-во проданных участков: ".$COUNT_PLOTS_SOLD."\n";
		}

		if ($COUNT_PLOTS_SALE && $COUNT_PLOTS_SALE != $ourVillage['COUNT_PLOTS_SALE']) {
			CIBlockElement::SetPropertyValues($idVil, 1, $COUNT_PLOTS_SALE, "COUNT_PLOTS_SALE");
			$strCSV .= "- Кол-во участков в продаже: ".$COUNT_PLOTS_SALE."\n";
		}

		if ($idSalesPhase) {
			CIBlockElement::SetPropertyValues($idVil, 1, $idSalesPhase, "SALES_PHASE");
			$strCSV .= "- Этап продаж: ".$salesPhase."\n";
		}

		if ($COST_LAND_IN_CART_MIN || $COST_LAND_IN_CART_MAX) {
			CIBlockElement::SetPropertyValues($idVil, 1, [$COST_LAND_IN_CART_MIN,$COST_LAND_IN_CART_MAX], "COST_LAND_IN_CART");
			$strCSV .= "- Стоимость участков: min - ".$COST_LAND_IN_CART_MIN.", max - ".$COST_LAND_IN_CART_MAX."\n";
		}

		if ($PRICE_SOTKA_MIN || $PRICE_SOTKA_MAX) {
			CIBlockElement::SetPropertyValues($idVil, 1, [$PRICE_SOTKA_MIN,$PRICE_SOTKA_MAX], "PRICE_SOTKA");
			$strCSV .= "- Цена за сотку: min - ".$PRICE_SOTKA_MIN.", max - ".$PRICE_SOTKA_MAX."\n";
		}

		// if ($HOME_VALUE_MIN || $HOME_VALUE_MAX) {
		// 	CIBlockElement::SetPropertyValues($idVil, 1, [$HOME_VALUE_MIN,$HOME_VALUE_MAX], "HOME_VALUE");
		// 	$strCSV .= "- Стоимость домов: min - ".$HOME_VALUE_MIN.", max - ".$HOME_VALUE_MAX."\n";
		// }
	}
}

$strCSV .= "\nНайдены поселки: \n";
foreach ($arUpdateVillage as $code => $village) {
  if(array_key_exists($code,$arVillage)){ // нашли поселок
		$strCSV .= " - ".$village['NAME']." - ".$village['region']."\n";
  }
}

$strCSV .= "\nНе найдены поселки: \n";
foreach ($arNotVillage as $code => $village) {
	$strCSV .= " - ".$village['NAME']." - ".$village['region']."\n";
}

echo str_replace("\n","<br>",$strCSV);
// запишем в файл
$fp = fopen($_SERVER["DOCUMENT_ROOT"].'/local/cron/logs_feed/'.$xmlDeveloper.': '.date('d.m.Y H:i:s').'.csv', 'a+');
fwrite($fp,$strCSV);
fclose($fp);
