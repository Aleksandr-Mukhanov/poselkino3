<?php header('Content-Type: text/html; charset=utf-8');
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
	Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

$params = [
  "max_len" => "100", // обрезает символьный код до 100 символов
  "change_case" => "L", // буквы преобразуются к нижнему регистру
  "replace_space" => "-", // меняем пробелы на тире
  "replace_other" => "-", // меняем левые символы на тире
  "delete_repeat_replace" => "true", // удаляем повторяющиеся символы
  "use_google" => "false", // отключаем использование google
];

// получим поселки девелопера
$xmlDeveloper = 'Udacha';
// $xmlDeveloper = 'Zemelniy-Ekspress';
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>1,"PROPERTY_DEVELOPER_ID" => $xmlDeveloper);
$arSelect = Array("ID","NAME","CODE","PROPERTY_DEVELOPER_ID","PROPERTY_DATE_FEED","PROPERTY_COUNT_PLOTS_SOLD","PROPERTY_COUNT_PLOTS_SALE","PROPERTY_MKAD");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);
  $arVillage[$arElement['CODE']] = [
    'ID' => $arElement['ID'],
    'NAME' => $arElement['NAME'],
    'DATE_FEED' => $arElement['PROPERTY_DATE_FEED_VALUE'],
		'COUNT_PLOTS_SOLD' => $arElement['PROPERTY_COUNT_PLOTS_SOLD_VALUE'],
		'COUNT_PLOTS_SALE' => $arElement['PROPERTY_COUNT_PLOTS_SALE_VALUE'],
		'MKAD_KM' => $arElement['PROPERTY_MKAD_VALUE'],
		'DEVELOPER_ID' => $arElement['PROPERTY_DEVELOPER_ID_VALUE'][0]
  ];
	$arVillageIds[] = $arElement['ID'];
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

$urlFeed = 'https://www.ydacha.ru/local/ydacha/export/index.php?format=poselkino&token=tulYT78ysdk7T';
// $urlFeed = 'https://poselkino.ru/cron/zemexx.xml';

$xmlFeed = file_get_contents($urlFeed);
$arFeed = new SimpleXMLElement($xmlFeed);

$i = 0;

$offers = $arFeed->offer;
foreach ($offers as $offer) { $i++; // переберем оферы
  $category = $offer -> {'category'};
  $village_name = $offer -> {'village-name'};
  $village_code = CUtil::translit($village_name, "ru", $params);
	$region = $offer->{'location'}->{'region'};
  // echo '<p>'.$i.') '.$category.' '.$nomer.' - поселок: '.$village_name.'</p>';

  if ($category == 'участок') {
    if(array_key_exists($village_code,$arVillage)){ // если поселок есть на сайте

      $idVil = $arVillage[$village_code]['ID'];
      $vilName = $arVillage[$village_code]['NAME'];
      $vilCode = $village_code;
      $vilMKAD = $arVillage[$village_code]['MKAD_KM'];
    	$idDeveloper = $arVillage[$village_code]['DEVELOPER_ID'];

      // получим номер участка
      $url = $offer -> {'url'};
      $arUrl1 = explode('?',$url);
      $arUrl2 = explode('-',$arUrl1[0]);
      $plotId = $arUrl2[count($arUrl2) - 1];

			$dateUpdate = $offer -> {'last-update-date'};
			$dateUpdateOnSite = date('d.m.Y H:i',strtotime($dateUpdate));
			$plotPrice = $offer -> {'price'} -> {'value'};
	    $plotArea = $offer -> {'lot-area'} -> {'value'};

	    $PRICE = str_replace(' ','',$plotPrice);
	    $NUMBER = $plotId;
	    $PLOTTAGE = str_replace(',','.',$plotArea);
	    $plotName = $vilName.': участок '.$NUMBER;
	    $plotCode = 'kupit-uchastok-'.$vilCode.'-'.$PLOTTAGE.'-sotok-'.$vilMKAD.'-km-mkad-id-'.$NUMBER;
	    $PREVIEW_TEXT = $offer->{'description'};
	    $keyPlot = $idDeveloper.'_'.$idVil.'_'.$NUMBER;

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
			// } // dump($DOP_PHOTO);

			if(array_key_exists($keyPlot,$arPlot)){ // если участок уже есть

				$ourPlot = $arPlot[$keyPlot]; // dump($ourPlot);

				if(strtotime($dateUpdate) > strtotime($ourPlot['PROPERTY_DATE_FEED_VALUE'])){ // если обновлен
					mesEr('Обновляем участок: '.$plotName);
					// CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $dateUpdateOnSite, "DATE_FEED");
					// CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $PRICE, "PRICE");
					// CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $NUMBER, "NUMBER");
					// CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $PLOTTAGE, "PLOTTAGE");
					// CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $cadastr, "CADASTRAL");
					// CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $arrangement, "ARRANGEMENT");
				}

			}else{ // добавляем

		    // mesEr('Добавляем участок: '.$plotName);

		    $el = new CIBlockElement;
		    // св-ва участка
		    $PROP = array();
		    $PROP['VILLAGE'] = $idVil;
		    $PROP['PRICE'] = $PRICE;
		    $PROP['NUMBER'] = $NUMBER;
		    $PROP['PLOTTAGE'] = $PLOTTAGE;
		    $PROP['DATE_FEED'] = $dateUpdateOnSite;
		    $PROP['DEVELOPER_ID'] = $idDeveloper;
		    if ($DOP_PHOTO) $PROP['DOP_PHOTO'] = $DOP_PHOTO;

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

		    // if($PRODUCT_ID = $el->Add($arLoadProductArray))
		    //   mesOk("Участок успешно добавлен!");
		    // else
		    //   mesEr("Error: ".$el->LAST_ERROR);
			}

			// кол-во участков в продаже
			$plotCntSale = $arUpdateVillage[$idVil]['plotCntSale'];
			$plotCntSale = ($plotCntSale) ? $plotCntSale+1 : 1;

			// мин, макс стоимость участка
			$minPriceLand = $arUpdateVillage[$idVil]['minPriceLand'];
			if (!$minPriceLand) $minPriceLand = $PRICE;
			$minPriceLand = ($minPriceLand > $PRICE) ? $PRICE : $minPriceLand;

			$maxPriceLand = $arUpdateVillage[$idVil]['maxPriceLand'];
			if (!$maxPriceLand) $maxPriceLand = 0;
			$maxPriceLand = ($maxPriceLand < $PRICE) ? $PRICE : $maxPriceLand;

			$arUpdateVillage[$vilCode] = [
				'ID' => $idVil,
				'NAME' => $vilName,
				'plotCntSale' => $plotCntSale,
				'minPriceLand' => $minPriceLand,
				'maxPriceLand' => $maxPriceLand,
				'region' => $region
			];
    }else{
			$arNotVillage[$village_code] = [
				'NAME' => $village_name,
				'region' =>$region
			];
		}
  }
} // dump($arUpdateVillage);

if($arUpdateVillage){
	foreach ($arUpdateVillage as $vilCode => $village) {
		mesEr('Обновляем поселок: '.$village['NAME']);

		$ourVillage = $arVillage[$vilCode];

		$idVil = $village['ID'];
		$dateUpdate = date('d.m.Y H:i');
		// $COUNT_PLOTS_SOLD = $plotCntSold;
		$COUNT_PLOTS_SALE = $village['plotCntSale'];
		$COST_LAND_IN_CART_MIN = $village['minPriceLand'];
		$COST_LAND_IN_CART_MAX = $village['maxPriceLand'];
		// $PRICE_SOTKA_MIN = $minPriceSotka;
		// $PRICE_SOTKA_MAX = $maxPriceSotka;
		// $HOME_VALUE_MIN = str_replace(' ','',$offer->{'min-cost-of-the-house'});
		// $HOME_VALUE_MAX = str_replace(' ','',$offer->{'max-cost-of-the-house'});

		// // обновляем поселок
		// if($dateUpdate)
		// 	CIBlockElement::SetPropertyValues($idVil, 1, $dateUpdate, "DATE_FEED");
		// // if($COUNT_PLOTS_SOLD && $COUNT_PLOTS_SOLD != $ourVillage['COUNT_PLOTS_SOLD']);
		// // 	CIBlockElement::SetPropertyValues($idVil, 1, $COUNT_PLOTS_SOLD, "COUNT_PLOTS_SOLD");
		// if($COUNT_PLOTS_SALE && $COUNT_PLOTS_SALE != $ourVillage['COUNT_PLOTS_SALE']);
		// 	CIBlockElement::SetPropertyValues($idVil, 1, $COUNT_PLOTS_SALE, "COUNT_PLOTS_SALE");
		// if($COST_LAND_IN_CART_MIN || $COST_LAND_IN_CART_MAX)
		// 	CIBlockElement::SetPropertyValues($idVil, 1, [$COST_LAND_IN_CART_MIN,$COST_LAND_IN_CART_MAX], "COST_LAND_IN_CART");
		// // if($PRICE_SOTKA_MIN || $PRICE_SOTKA_MAX)
		// // 	CIBlockElement::SetPropertyValues($idVil, 1, [$PRICE_SOTKA_MIN,$PRICE_SOTKA_MAX], "PRICE_SOTKA");
		// // if($HOME_VALUE_MIN || $HOME_VALUE_MAX)
		// // 	CIBlockElement::SetPropertyValues($idVil, 1, [$HOME_VALUE_MIN,$HOME_VALUE_MAX], "HOME_VALUE");
	}
}

echo '<br>найдены: <br><br>';
foreach ($arUpdateVillage as $code => $village) {
  if(array_key_exists($code,$arVillage)){ // нашли поселок
    echo $village['NAME'].' - '.$village['region'].'<br>';
  }
}
echo '<br>не найдены: <br><br>';
foreach ($arNotVillage as $code => $village) {
	echo $village['NAME'].' - '.$village['region'].'<br>';
}
/*
<offer internal-id="25021">
 <type>продажа</type>
 <property-type>жилая</property-type>
 <category>участок</category>
 <url>https://www.ydacha.ru/uchastki/berezhki-2/uchastok-39-v-poselke-berezhki-2-39?utm_source=poselkino.ru</url>
 <creation-date>2020-04-06T00:00:00</creation-date>
 <last-update-date>2020-04-28T19:51:01</last-update-date>
 <location>
   <country>Россия</country>
   <region>Московская область</region>
   <district>Можайский район</district>
   <locality-name>Бережки 2</locality-name>
   <direction>Минское шоссе</direction>
   <direction>Можайское шоссе</direction>
   <distance>110</distance>
   <latitude>55.693629798614</latitude>
   <longitude>35.61289014777</longitude>
 </location>
 <village-name>Бережки 2</village-name>
 <sales-agent>
   <name>Удача Ваша Дача</name>
   <phone>(495)480-03-10</phone>
   <category>застройщик</category>
   <organization>Удача</organization>
   <url>https://www.ydacha.ru/</url>
   <email>info@ydacha.ru</email>
   <photo>https://www.ydacha.ru/local/templates/lince/images/svg/logo.svg</photo>
 </sales-agent>
 <price>
   <value>102240</value>
   <currency>RUB</currency>
 </price>
  <haggle>1</haggle>
  <mortgage>1</mortgage>
  <image>https://www.ydacha.ru/upload/iblock/64a/64a5b26bd1a21282f2363ecfede0d3b5.jpg</image>
  <description>Продается участок земли №39 в поселке Бережки 2, площадью 6.4 сот. Поселок находится на расстоянии 110 км от МКАД, Минское шоссе. К участку подведены коммуникации: электричество. В поселке ограждение, дороги, детская площадка, офис днп, охрана, гостевая парковка.  От собственника. Рассрочка без процентов. Агентам бонус.</description>
  <lot-area>
    <value>6.39</value>
    <unit>Сот</unit>
  </lot-area>
  <lot-type>садоводство</lot-type>
  <pmg>1</pmg>
  <gas-supply>0</gas-supply>
  <electricity-supply>1</electricity-supply>
  <water-supply>0</water-supply>
  <sewerage-supply>0</sewerage-supply>
  <is-elite>0</is-elite>
 </offer>
