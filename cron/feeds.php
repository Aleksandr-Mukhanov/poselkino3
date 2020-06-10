<?php header('Content-Type: text/html; charset=utf-8');
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
	Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

$params = Array(
	 "max_len" => "100", // обрезает символьный код до 100 символов
	 "change_case" => "L", // буквы преобразуются к нижнему регистру
	 "replace_space" => "-", // меняем пробелы на тире
	 "replace_other" => "-", // меняем левые символы на тире
	 "delete_repeat_replace" => "true", // удаляем повторяющиеся символы
	 "use_google" => "false", // отключаем использование google
);

// получим фиды девелоперов
$hlblock_id = 5; // id HL
$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
$entity = HL\HighloadBlockTable::compileEntity($hlblock);
$entity_data_class = $entity->getDataClass();
$entity_table_name = $hlblock['TABLE_NAME'];
$sTableID = 'tbl_'.$entity_table_name;

$rsData = $entity_data_class::getList([
  'filter' => ['*'],
  'select' => ['UF_XML_ID','UF_XML_FEED','UF_DATE_FEED'],
]);
$rsData = new CDBResult($rsData, $sTableID);

while($arRes = $rsData->Fetch()){ // dump($arRes);
  if($arRes['UF_XML_FEED']){ // если есть фид
		$arDeveloper[$arRes['UF_XML_ID']] = [
	    'XML_FEED' => $arRes['UF_XML_FEED'],
	    'DATE_FEED' => $arRes['UF_DATE_FEED'],
	  ];
	  $arIdDeveloper[] = $arRes['UF_XML_ID'];
	}
} // dump($arDeveloper);

// получим поселки девелоперов
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>1,"PROPERTY_DEVELOPER_ID" => $arIdDeveloper);
$arSelect = Array("ID","NAME","PROPERTY_DEVELOPER_ID","PROPERTY_DATE_FEED","PROPERTY_COUNT_PLOTS_SOLD","PROPERTY_COUNT_PLOTS_SALE","PROPERTY_MKAD");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);
  $arVillage[$arElement['PROPERTY_DEVELOPER_ID_VALUE']][strtolower($arElement['NAME'])] = [
    'ID' => $arElement['ID'],
    'NAME' => $arElement['NAME'],
    'DATE_FEED' => $arElement['PROPERTY_DATE_FEED_VALUE'],
		'COUNT_PLOTS_SOLD' => $arElement['PROPERTY_COUNT_PLOTS_SOLD_VALUE'],
		'COUNT_PLOTS_SALE' => $arElement['PROPERTY_COUNT_PLOTS_SALE_VALUE'],
		'MKAD_KM' => $arElement['PROPERTY_MKAD_VALUE'],
  ];
	$arVillageIds[] = $arElement['ID'];
} // dump($arVillage);

// получим дома девелоперов
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>6,"PROPERTY_VILLAGE" => $arVillageIds);
$arSelect = Array("ID","NAME","PROPERTY_DEVELOPER_ID","PROPERTY_NUMBER_PLOT","PROPERTY_VILLAGE","PROPERTY_DATE_FEED");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);
	$keyElement = $arElement['PROPERTY_DEVELOPER_ID_VALUE'].'_'.$arElement['PROPERTY_VILLAGE_VALUE'].'_'.$arElement['PROPERTY_NUMBER_PLOT_VALUE'];
  $arHouse[$keyElement] = $arElement;
} // dump($arHouse);

// получим участки девелоперов
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>5,"PROPERTY_VILLAGE" => $arVillageIds);
$arSelect = Array("ID","NAME","PROPERTY_DEVELOPER_ID","PROPERTY_NUMBER","PROPERTY_VILLAGE","PROPERTY_DATE_FEED");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);
	$keyElement = $arElement['PROPERTY_DEVELOPER_ID_VALUE'].'_'.$arElement['PROPERTY_VILLAGE_VALUE'].'_'.$arElement['PROPERTY_NUMBER_VALUE'];
  $arPlot[$keyElement] = $arElement;
} // dump($arHouse);

foreach ($arDeveloper as $idDeveloper => $feed) { // переберем фиды девелоперов

  $xmlFeed = file_get_contents($feed['XML_FEED']);

  $arFeed = new SimpleXMLElement($xmlFeed);

  $generation_date = $arFeed->{'generation-date'};

  if(strtotime($generation_date) >= strtotime($feed['DATE_FEED'])){ // фид был обновлен

    $offers = $arFeed->offer;
    foreach ($offers as $offer) { // переберем поселки

			$vilName = (string)$offer->{'village-name'};
			$vilNameLower = strtolower((string)$offer->{'village-name'});
			$dateUpdateVil = $offer->{'date-update'};
			$COUNT_PLOTS_SOLD = $offer->{'number-of-lands-sold'};
			$COUNT_PLOTS_SALE = $offer->{'number-of-lands-for-sale'};
			$COST_LAND_IN_CART_MIN = $offer->{'min-cost-of-the-land'};
			$COST_LAND_IN_CART_MAX = $offer->{'max-cost-of-the-land'};
			$PRICE_SOTKA_MIN = $offer->{'min-cost-of-a-sotka'};
			$PRICE_SOTKA_MAX = $offer->{'max-cost-of-a-sotka'};
			$HOME_VALUE_MIN = $offer->{'min-cost-of-the-house'};
			$HOME_VALUE_MAX = $offer->{'max-cost-of-the-house'};

			if(array_key_exists($vilNameLower,$arVillage[$idDeveloper])){ // нашли поселок

				$ourVillage = $arVillage[$idDeveloper][$vilNameLower];
				$idVil = $ourVillage['ID'];
				$vilMKAD = $ourVillage['MKAD_KM'];

				if(strtotime($dateUpdateVil) > strtotime($ourVillage['DATE_FEED'])){ // если обновлен
					mesEr('Обновляем поселок: '.$vilName);
					// обновляем поселок
					// if($dateUpdateVil)
					// 	CIBlockElement::SetPropertyValues($idVil, 1, $dateUpdateVil, "DATE_FEED");
					// if($COUNT_PLOTS_SOLD && $COUNT_PLOTS_SOLD != $ourVillage['COUNT_PLOTS_SOLD']);
					// 	CIBlockElement::SetPropertyValues($idVil, 1, $COUNT_PLOTS_SOLD, "COUNT_PLOTS_SOLD");
					// if($COUNT_PLOTS_SALE && $COUNT_PLOTS_SALE != $ourVillage['COUNT_PLOTS_SALE']);
					// 	CIBlockElement::SetPropertyValues($idVil, 1, $COUNT_PLOTS_SALE, "COUNT_PLOTS_SALE");
					// if($COST_LAND_IN_CART_MIN || $COST_LAND_IN_CART_MAX)
					// 	CIBlockElement::SetPropertyValues($idVil, 1, [$COST_LAND_IN_CART_MIN,$COST_LAND_IN_CART_MAX], "COST_LAND_IN_CART");
					// if($PRICE_SOTKA_MIN || $PRICE_SOTKA_MAX)
					// 	CIBlockElement::SetPropertyValues($idVil, 1, [$PRICE_SOTKA_MIN,$PRICE_SOTKA_MAX], "PRICE_SOTKA");
					// if($HOME_VALUE_MIN || $HOME_VALUE_MAX)
					// 	CIBlockElement::SetPropertyValues($idVil, 1, [$HOME_VALUE_MIN,$HOME_VALUE_MAX], "HOME_VALUE");
	      }
			}else{
				mesEr('Добавляем поселок: '.$vilName);
				// добавляем поселок
				$el = new CIBlockElement;
				// св-ва поселка
				$PROP = array();
				$PROP['DATE_FEED'] = $dateUpdateVil;
				$PROP['COUNT_PLOTS_SOLD'] = $COUNT_PLOTS_SOLD;
				$PROP['COUNT_PLOTS_SALE'] = $COUNT_PLOTS_SALE;
				$PROP['COST_LAND_IN_CART'] = [$COST_LAND_IN_CART_MIN,$COST_LAND_IN_CART_MAX];
				$PROP['PRICE_SOTKA'] = [$PRICE_SOTKA_MIN,$PRICE_SOTKA_MAX];
				$PROP['HOME_VALUE'] = [$HOME_VALUE_MIN,$HOME_VALUE_MAX];
				$PROP['DEVELOPER_ID'] = $idDeveloper;

				$arLoadProductArray = Array(
				  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
				  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
				  "IBLOCK_ID"      => 1,
				  "PROPERTY_VALUES"=> $PROP,
				  "NAME"           => $vilName,
				  "ACTIVE"         => "N",            // активен
				); // dump($arLoadProductArray);

				if($idVil = $el->Add($arLoadProductArray))
				  mesOk("Поселок успешно добавлен!");
				else
				  mesEr("Error: ".$el->LAST_ERROR);
			}

			$vilCode = CUtil::translit($vilName, "ru", $params);

			// обновим дома
			$list_of_houses = $offer->{'list-of-houses'}; // dump($list_of_houses);
			if($list_of_houses){
				$list_house = $list_of_houses->{'list-house'}; // dump($list_house);
				foreach ($list_house as $key => $house) { // dump($house);

					$dateUpdate = $house->{'date-update-house'};
					$AREA_HOUSE = $house->{'area-house'};
					$PRICE = $house->{'price-house'};
					$MATERIAL = $house->{'material-house'};
					$FINISH = $house->{'finish-house'};
					$FLOORS = $house->{'floors-house'};
					$STAGE = $house->{'stage-house'};
					$NUMBER_PLOT = $house->{'number-land-house'};
					$PLOTTAGE = $house->{'area-land-house'};
					$houseName = $vilName.': дом '.$NUMBER_PLOT;
					$houseCode = 'kupit-dom-'.$vilCode.'-'.$AREA_HOUSE.'-m-'.$FLOORS.'-etazha-id-'.$NUMBER_PLOT;
					$PREVIEW_TEXT = $house->{'description-house'};
					$keyHouse = $idDeveloper.'_'.$idVil.'_'.$NUMBER_PLOT;

					// получим фото
					$DOP_PHOTO = array(); $i=0;
					$arImage = $house->{'image-house-block'};
					if($arImage){
						$image = $arImage->{'image-house'};
						foreach ($image as $value) {
							$arPhoto = CFile::MakeFileArray($value);
							if($arPhoto['name']){
								if ($i == 0)
									$PREVIEW_PICTURE = $arPhoto;
								else
									$DOP_PHOTO[] = $arPhoto;
								$i++;
							}
						}
					} // dump($DOP_PHOTO);

					if(array_key_exists($keyHouse,$arHouse)){ // если дом уже есть

						$ourHouse = $arHouse[$keyHouse]; // dump($ourHouse);

						if(strtotime($dateUpdate) > strtotime($ourHouse['PROPERTY_DATE_FEED_VALUE'])){ // если обновлен
							mesEr('Обновляем дом: '.$houseName);
							CIBlockElement::SetPropertyValues($ourHouse['ID'], 6, $dateUpdate, "DATE_FEED");
							CIBlockElement::SetPropertyValues($ourHouse['ID'], 6, $FINISH, "FINISH");
							CIBlockElement::SetPropertyValues($ourHouse['ID'], 6, $STAGE, "STAGE");
							CIBlockElement::SetPropertyValues($ourHouse['ID'], 6, $AREA_HOUSE, "AREA_HOUSE");
							CIBlockElement::SetPropertyValues($ourHouse['ID'], 6, $PLOTTAGE, "PLOTTAGE");
							CIBlockElement::SetPropertyValues($ourHouse['ID'], 6, $PRICE, "PRICE");
						}

					}else{ // добавляем

						mesEr('Добавляем дом: '.$houseName);
						$el = new CIBlockElement;
						// св-ва поселка
						$PROP = array();
						$PROP['VILLAGE'] = $idVil;
						$PROP['FLOORS'] = $FLOORS;
						$PROP['MATERIAL'] = $MATERIAL;
						$PROP['FINISH'] = $FINISH;
						$PROP['STAGE'] = $STAGE;
						$PROP['AREA_HOUSE'] = $AREA_HOUSE;
						$PROP['NUMBER_PLOT'] = $NUMBER_PLOT;
						$PROP['PLOTTAGE'] = $PLOTTAGE;
						$PROP['PRICE'] = $PRICE;
						$PROP['DATE_FEED'] = $dateUpdate;
						$PROP['DEVELOPER_ID'] = $idDeveloper;
						$PROP['DOP_PHOTO'] = $DOP_PHOTO;

						$arLoadProductArray = Array(
						  "MODIFIED_BY"    		=> $USER->GetID(), // элемент изменен текущим пользователем
						  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
						  "IBLOCK_ID"      		=> 6,
						  "PROPERTY_VALUES"		=> $PROP,
						  "NAME"           		=> $houseName,
							"CODE"					 		=> $houseCode,
						  "ACTIVE"         		=> "Y",            // активен
							"PREVIEW_TEXT"	 		=> $PREVIEW_TEXT,
							"PREVIEW_PICTURE"		=> $PREVIEW_PICTURE,
						); // dump($arLoadProductArray);

						if($PRODUCT_ID = $el->Add($arLoadProductArray))
						  mesOk("Дом успешно добавлен!");
						else
						  mesEr("Error: ".$el->LAST_ERROR);

						unset($PREVIEW_PICTURE); unset($DOP_PHOTO);
					}
				}
			}

			// обновим участки
			$list_of_plots = $offer->{'list-of-lands'}; // dump($list_of_plots);
			if($list_of_plots){
				$list_plot = $list_of_plots->{'list-land'}; // dump($list_plot);
				foreach ($list_plot as $plot) { // dump($plot);

					$dateUpdate = $plot->{'date-update-land'};
					$PRICE = $plot->{'price-land'};
					$NUMBER = $plot->{'number-plan-land'};
					$PLOTTAGE = $plot->{'area-land'};
					$plotName = $vilName.': участок '.$NUMBER;
					$plotCode = 'kupit-uchastok-'.$vilCode.'-'.$PLOTTAGE.'-sotok-'.$vilMKAD.'-km-mkad-id-'.$NUMBER;
					$PREVIEW_TEXT = $plot->{'description-land'};
					$keyPlot = $idDeveloper.'_'.$idVil.'_'.$NUMBER;

					// получим фото
					$DOP_PHOTO = array(); $i=0;
					$arImage = $plot->{'image-land-block'};
					if($arImage){
						$image = $arImage->{'image-land'};
						foreach ($image as $value) {
							$arPhoto = CFile::MakeFileArray($value);
							if($arPhoto['name']){
								if ($i == 0)
									$PREVIEW_PICTURE = $arPhoto;
								else
									$DOP_PHOTO[] = $arPhoto;
								$i++;
							}
						}
					} // dump($DOP_PHOTO);

					if(array_key_exists($keyPlot,$arPlot)){ // если участок уже есть

						$ourPlot = $arPlot[$keyPlot]; // dump($ourPlot);

						if(strtotime($dateUpdate) > strtotime($ourPlot['PROPERTY_DATE_FEED_VALUE'])){ // если обновлен
							mesEr('Обновляем участок: '.$plotName);
							CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $dateUpdate, "DATE_FEED");
							CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $PRICE, "PRICE");
							CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $NUMBER, "NUMBER");
							CIBlockElement::SetPropertyValues($ourPlot['ID'], 5, $PLOTTAGE, "PLOTTAGE");
						}

					}else{ // добавляем

						mesEr('Добавляем участок: '.$plotName);
						$el = new CIBlockElement;
						// св-ва участка
						$PROP = array();
						$PROP['VILLAGE'] = $idVil;
						$PROP['PRICE'] = $PRICE;
						$PROP['NUMBER'] = $NUMBER;
						$PROP['PLOTTAGE'] = $PLOTTAGE;
						$PROP['DATE_FEED'] = $dateUpdate;
						$PROP['DEVELOPER_ID'] = $idDeveloper;
						$PROP['DOP_PHOTO'] = $DOP_PHOTO;

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

						if($PRODUCT_ID = $el->Add($arLoadProductArray))
						  mesOk("Участок успешно добавлен!");
						else
						  mesEr("Error: ".$el->LAST_ERROR);

						unset($PREVIEW_PICTURE); unset($DOP_PHOTO);
					}
				}
			}
    }
  }
}
?>
