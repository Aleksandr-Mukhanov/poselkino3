<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

// водный знак
	$arWaterMark = [
		[
			"name" => "watermark",
			"position" => "bottomright", // Положение
			"type" => "image",
			//"size" => "medium",
			"coefficient" => 3,
			"file" => $_SERVER["DOCUMENT_ROOT"].'/upload/water_sign.png', // Путь к картинке
			"fill" => "resize",
		]
	];
// ресайз фото
	function ResizeImage($idPhoto){
		$photoRes = CFile::ResizeImageGet($idPhoto, array('width'=>580, 'height'=>358), BX_RESIZE_IMAGE_PROPORTIONAL_ALT, true, $arWaterMark);
		$photoRes['id'] = $idPhoto;
		// dump($photoRes);
		return $photoRes;
	}

// получим привязанные дома
	// $arOrder = Array("SORT"=>"ASC");
	// $arFilter = Array("IBLOCK_ID"=>4,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$arResult["ID"]);
	// $arSelect = Array("ID","NAME","PREVIEW_PICTURE","DETAIL_PICTURE","PREVIEW_TEXT","PROPERTY_TURN_KEY","PROPERTY_MATERIAL","PROPERTY_WITHOUT_FINISHING","PROPERTY_DOP_PHOTO");
	// $rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	// while($arElement = $rsElements->GetNext()){ // dump($arElement);
  //
	// 	// соберем фото
	// 	if($arElement["PREVIEW_PICTURE"])$arPhoto[] = ResizeImage($arElement["PREVIEW_PICTURE"]);
	// 	if($arElement["DETAIL_PICTURE"])$arPhoto[] = ResizeImage($arElement["DETAIL_PICTURE"]);
	// 	if($arElement["PROPERTY_DOP_PHOTO_VALUE"]){
	// 		foreach ($arElement["PROPERTY_DOP_PHOTO_VALUE"] as $key => $val) {
	// 			$arPhoto[] = ResizeImage($val);
	// 		}
	// 	}
	// 	// соберем дома
	// 	$arHouses[$arElement["ID"]] = [
	// 		"NAME" => $arElement["NAME"],
	// 		"IMG" => $arPhoto,
	// 		"TEXT" => $arElement["PREVIEW_TEXT"],
	// 		"TURN_KEY" => formatPrice($arElement["PROPERTY_TURN_KEY_VALUE"]),
	// 		"WITHOUT_FINISHING" => formatPrice($arElement["PROPERTY_WITHOUT_FINISHING_VALUE"]),
	// 		"MATERIAL" => $arElement["PROPERTY_MATERIAL_VALUE"],
	// 	];
	// 	unset($arPhoto);
	// } // dump($arPhoto);

// узнаем отзывы
	$cntCom = 0;$ratingSum = 0;
	$arOrder = Array("ACTIVE_FROM"=>"DESC");
	$arFilter = Array("IBLOCK_ID"=>2,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$arResult["ID"]);
	$arSelect = Array("ID","ACTIVE_FROM","PREVIEW_TEXT","PROPERTY_RATING","PROPERTY_DIGNITIES","PROPERTY_DISADVANTAGES","PROPERTY_FIO","PROPERTY_RESIDENT");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,['nTopCount'=>4],$arSelect);
	while($arElement = $rsElements->GetNext()){ // dump($arElement);
		$cntCom++; // кол-во отзывов
		$arDateTime = explode(' ',$arElement["ACTIVE_FROM"]);
		$arDate = explode('.',$arDateTime[0]);
		$arTime = explode(':',$arDateTime[1]);
		// оценка
		$rating = ($arElement["PROPERTY_RATING_VALUE"]) ? $arElement["PROPERTY_RATING_VALUE"] : 4;
		$arComments[] = [
			"FIO" => $arElement["PROPERTY_FIO_VALUE"],
			"DATE" => $arDateTime[0].' '.$arTime[0].':'.$arTime[1],
			"DATE_SCHEMA" => $arDate[2].'-'.$arDate[1].'-'.$arDate[0],
			"RATING" => $rating,
			"DIGNITIES" => $arElement["PROPERTY_DIGNITIES_VALUE"],
			"DISADVANTAGES" => $arElement["PROPERTY_DISADVANTAGES_VALUE"],
			"TEXT" => $arElement["PREVIEW_TEXT"],
			"RESIDENT" => $arElement["PROPERTY_RESIDENT_VALUE"],
		];

		// соберем отзывы от жителя
		if($arElement["PROPERTY_RESIDENT_VALUE"]){
			$arCommentsRes[] = [
				"FIO" => $arElement["PROPERTY_FIO_VALUE"],
				"DATE" => $arDateTime[0].' '.$arTime[0].':'.$arTime[1],
				"RATING" => $rating,
				"DIGNITIES" => $arElement["PROPERTY_DIGNITIES_VALUE"],
				"DISADVANTAGES" => $arElement["PROPERTY_DISADVANTAGES_VALUE"],
				"TEXT" => $arElement["PREVIEW_TEXT"],
				"RESIDENT" => $arElement["PROPERTY_RESIDENT_VALUE"],
			];
		}

		// общая оценка
		$ratingSum = $ratingSum + $rating;
	} //dump($ratingSum);

	$ratingTotal = ($cntCom>0) ? $ratingSum / $cntCom : 4;

  // получим дома
  $arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>6,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$arResult["ID"]);
	$arSelect = Array("ID","CODE","PREVIEW_PICTURE","PROPERTY_FLOORS","PROPERTY_MATERIAL","PROPERTY_AREA_HOUSE","PROPERTY_PRICE","PROPERTY_DOP_PHOTO");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,['nTopCount'=>2],$arSelect);
	while($arElement = $rsElements->GetNext()){ // dump($arElement);
    // соберем фото
		if($arElement["PREVIEW_PICTURE"])$arPhoto[] = ResizeImage($arElement["PREVIEW_PICTURE"]);
		if($arElement["PROPERTY_DOP_PHOTO_VALUE"]){
			foreach ($arElement["PROPERTY_DOP_PHOTO_VALUE"] as $key => $val) {
				$arPhoto[] = ResizeImage($val);
			}
		}
		// соберем дома
		$arHouses[$arElement["ID"]] = [
			"NAME" => $arElement["NAME"],
      "CODE" => $arElement["CODE"],
			"IMG" => $arPhoto,
			"FLOORS" => $arElement["PROPERTY_FLOORS_VALUE"],
      "MATERIAL" => $arElement["PROPERTY_MATERIAL_VALUE"],
      "AREA_HOUSE" => $arElement["PROPERTY_AREA_HOUSE_VALUE"],
			"PRICE" => formatPrice($arElement["PROPERTY_PRICE_VALUE"]),
		];
		unset($arPhoto);
  }

  // получим участки
  $arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>5,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$arResult["ID"]);
	$arSelect = Array("ID","CODE","PREVIEW_PICTURE","PROPERTY_PLOTTAGE","PROPERTY_PRICE","PROPERTY_DOP_PHOTO");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,['nTopCount'=>2],$arSelect);
	while($arElement = $rsElements->GetNext()){ // dump($arElement);
    // соберем фото
		if($arElement["PREVIEW_PICTURE"])$arPhoto[] = ResizeImage($arElement["PREVIEW_PICTURE"]);
		if($arElement["PROPERTY_DOP_PHOTO_VALUE"]){
			foreach ($arElement["PROPERTY_DOP_PHOTO_VALUE"] as $key => $val) {
				$arPhoto[] = ResizeImage($val);
			}
		}
		// соберем дома
		$arPlots[$arElement["ID"]] = [
			"NAME" => $arElement["NAME"],
      "CODE" => $arElement["CODE"],
			"IMG" => $arPhoto,
			"PLOTTAGE" => $arElement["PROPERTY_PLOTTAGE_VALUE"],
			"PRICE" => formatPrice($arElement["PROPERTY_PRICE_VALUE"]),
		];
		unset($arPhoto);
  }

if (!$arHouses && $arPlots) { // если нет домов
  $arHouses = $arPlots;
  unset($arPlots);
}

$arResult["CNT_COMMENTS"] = $cntCom;
$arResult["RATING_TOTAL"] = round($ratingTotal,1);
$arResult["COMMENTS"] = $arComments;
$arResult["COMMENTS_RES"] = $arCommentsRes;
$arResult["ratingItogo"] = $arResult['PROPERTIES']['RATING']['VALUE'];
$arResult["arHouses"] = $arHouses;
$arResult["arPlots"] = $arPlots;

// добаление отзыва
// if($_POST["sendOtziv"]){ //dump($_POST);
// 	// добавляем элемент
// 	$el = new CIBlockElement;
//
// 	$PROP = array();
// 	$PROP['RATING'] = $_POST['star-1'];
// 	$PROP['DIGNITIES'] = $_POST['DIGNITIES'];
// 	$PROP['DISADVANTAGES'] = $_POST['DISADVANTAGES'];
// 	$PROP['VILLAGE'] = $arResult["ID"];
// 	$PROP['FIO'] = $_POST['NAME'].' '.$_POST['FNAME'];
// 	$PROP['RESIDENT'] = $_POST['RESIDENT'];
//
// 	$name = 'Отзыв-'.date('d.m.Y H:i:s').'-'.$arResult["ID"];
//
// 	$arLoadProductArray = Array(
// 	  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
// 	  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
// 	  "IBLOCK_ID"      => 2,
// 	  "PROPERTY_VALUES"=> $PROP,
// 	  "NAME"           => $name,
// 	  "ACTIVE"         => "N",            // активен
// 	  "ACTIVE_FROM" => date('d.m.Y H:i:s'),
// 	  "PREVIEW_TEXT"   => $_POST['COMMENT'],
// 	  //"DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image.gif")
// 	);
//
// 	if($PRODUCT_ID = $el->Add($arLoadProductArray)){
// 		 mesOk("Отзыв успешно добавлен!");
// 		 $resident = ($_POST['RESIDENT']) ? 'Да' : 'Нет';
// 		 // письмо об успешной оплате!
// 		$mailFields = array(
// 			"VIL" => $arResult["NAME"],
// 			"FIO" => $_POST['NAME'].' '.$_POST['FNAME'],
// 			"EMAIL" => $_POST['EMAIL'],
// 			"RATING" => $_POST['star-1'],
// 			"DIGNITIES" => $_POST['DIGNITIES'],
// 			"DISADVANTAGES" => $_POST['DISADVANTAGES'],
// 			"COMMENT" => $_POST['COMMENT'],
// 			"RESIDENT" => $resident
// 		);
// 		CEvent::Send("SEND_OTZIV", "s1", $mailFields);
// 	}else{
// 		mesEr("Error: ".$el->LAST_ERROR);
// 	}
// }

// SET BROWSER TITLE
$poselokName = "";
$tempposelokName = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
switch ($arResult['PROPERTIES']['TYPE']['VALUE_ENUM_ID']) {
	case 1:
			$poselokName.= "дачном поселке ".$tempposelokName;
			break;
	case 2:
			$poselokName.= "коттеджном поселке ".$tempposelokName;
			break;
	case 171:
			$poselokName.= "фермерстве ".$tempposelokName;
			break;
	}
$strLandType = "";
$strDescrType = "";
$strDescrType2 = "";
switch ($arResult['PROPERTIES']['LAND_CAT']['VALUE_ENUM_ID']) {
	case 107:
	$strLandType = "дачу";
	$strDescrType = "дачный";
	$strDescrType2 = "об участках под дачу";
	break;
	case 153:
	$strLandType = "ИЖС";
	$strDescrType = "коттеджный";
	$strDescrType2 = "об участках под ИЖС";
	break;
}
$arrComunications = [];
if ($arResult['PROPERTIES']['ELECTRO_DONE']['VALUE_ENUM_ID'] == 14) { $arrComunications[] = 'Электричество'; }
if ($arResult['PROPERTIES']['PROVEDEN_GAZ']['VALUE_ENUM_ID'] == 17) { $arrComunications[] = 'Газ'; }
if ($arResult['PROPERTIES']['PROVEDENA_VODA']['VALUE_ENUM_ID'] == 20) { $arrComunications[] = 'Вода'; }

// формируем несколько шоссе
foreach($arResult['PROPERTIES']['SHOSSE']['VALUE'] as $HIGTWAY){
	$arResult['PROPERTIES']['SHOSSE']['SHOW'] .= ($arResult['PROPERTIES']['SHOSSE']['SHOW']) ? ', '.$HIGTWAY : $HIGTWAY;
}
// dump($arResult['PROPERTIES']['REGION']);
$descShosse = str_replace('кое' ,'ком',$arResult['PROPERTIES']['SHOSSE']['SHOW']);
$descRayon = str_replace('кий' ,'ком',$arResult['PROPERTIES']['REGION']['VALUE_ENUM']);
$cenaZaSotkyOrDom = "";
// if ($arResult['PROPERTIES']['PRICE_SOTKA']['VALUE'][0] <= 1) {
// 	$cenaZaSotkyOrDom =  '5 250 000 руб за дом';
// }
if($arResult['PROPERTIES']['DOMA']['VALUE_ENUM_ID'] == 3 ){ // Только участки
	$cenaZaSotkyOrDom = formatPrice($arResult['PROPERTIES']['PRICE_SOTKA']['VALUE'][0]).' руб. за сотку';
	$minPrice = formatPrice($arResult['PROPERTIES']['PRICE_SOTKA']['VALUE'][0]);
}elseif($arResult['PROPERTIES']['DOMA']['VALUE_ENUM_ID'] == 4 || $arResult['PROPERTIES']['DOMA']['VALUE_ENUM_ID'] == 256){ // Участки с домами
	$cenaZaSotkyOrDom =  formatPrice($arResult['PROPERTIES']['HOME_VALUE']['VALUE'][0]).'₽ за участок с домом';
	$minPrice = formatPrice($arResult['PROPERTIES']['HOME_VALUE']['VALUE'][0]);
}

if (formatPrice($arResult['PROPERTIES']['PRICE_SOTKA']['VALUE'][0])==0) {
	 $descriptionCenaZaSotky = formatPrice($arResult['PROPERTIES']['HOME_VALUE']['VALUE'][0]);
} else {
   $descriptionCenaZaSotky = formatPrice($arResult['PROPERTIES']['PRICE_SOTKA']['VALUE'][0]);
}

// $seoTitle = 'Продажа участков по '.$descShosse.' шоссе под '.$strLandType.' в '.$poselokName.'. '.implode(', ',$arrComunications).' по границе, от '.$cenaZaSotkyOrDom;
// $setDescription = 'Видео обзор, фото, рейтинг и отзывы на '.$strDescrType.' поселок '.$tempposelokName.' в '.$descRayon.' районе. Стоимость сотки от '.$descriptionCenaZaSotky.' руб. Земельные участки от '.$arResult['PROPERTIES']['PLOTTAGE']['VALUE'][0].' соток до '.$arResult['PROPERTIES']['PLOTTAGE']['VALUE'][1].' соток с коммуникациями. Поселок расположен на '.$descRayon.' шоссе, '.$arResult['PROPERTIES']['MKAD']['VALUE'].' км от МКАД.';
// $setDescription = 'Продажа '.$strDescrType.' в '.$poselokName.' от '.$cenaZaSotkyOrDom.'. Проверенный застройщик, только реальные фото, видео и отзывы '.$strDescrType2.'. На участке есть: '.implode(', ',$arrComunications).'.';

// формирование TITLE
// dump($arResult);
$housesValEnum = $arResult['PROPERTIES']['DOMA']['VALUE_ENUM_ID'];
$typeValEnum = $arResult['PROPERTIES']['TYPE']['VALUE_ENUM_ID'];
$km_MKAD = $arResult['PROPERTIES']['MKAD']['VALUE'];
$priceSotkaMin = $arResult['PROPERTIES']['PRICE_SOTKA']['VALUE'][0];
$priceHomeMin = $arResult['PROPERTIES']['HOME_VALUE']['VALUE'][0];
$priceLandMin = $arResult['PROPERTIES']['COST_LAND_IN_CART']['VALUE'][0];
$svetKVT = $arResult['PROPERTIES']['ELECTRO_KVT']['VALUE'];
$gazVal = $arResult['PROPERTIES']['PROVEDEN_GAZ']['VALUE'];
$vodaVal = $arResult['PROPERTIES']['PROVEDENA_VODA']['VALUE'];
$plottageMin = $arResult['PROPERTIES']['PLOTTAGE']['VALUE'][0];
$plottageMax = $arResult['PROPERTIES']['PLOTTAGE']['VALUE'][1];

switch ($housesValEnum) { // Наличие домов
	case 3: // Участки
		if($typeValEnum == 1){ // Дачный поселок
			// $seoTitle = 'Дачный поселок '.trim($arResult['NAME']).' в '.$descRayon.' районе - цены, фото, план, отзывы | Купить участок земли в ДП '.$arResult['NAME'];
			// $setDescription = 'Продажа земельных участков в ДП '.trim($arResult['NAME']).' на '.$descShosse.' шоссе в Московской области ►Цены от '.$minPrice.' руб. ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Независимый рейтинг ✔Честный обзор';
			$setDescription = 'Продажа земельных участков в коттеджном поселке '.trim($arResult['NAME']).' на '.$descShosse.' шоссе в Московской области '.$km_MKAD.' км от МКАД ►Цены от '.$priceLandMin.' руб, стоимость сотки от '.$priceSotkaMin.' руб. Коммуникации: свет '.$svetKVT.' кВт на участке, газ '.$gazVal.'. Участки от '.$plottageMin.' до '.$plottageMax.' соток. Рейтинг поселка - '.$arResult['ratingItogo'].'. Количество отзывов - '.$arResult["CNT_COMMENTS"];
		}elseif($typeValEnum == 2){ // Коттеджный поселок
			// $seoTitle = 'Коттеджный поселок '.trim($arResult['NAME']).' в '.$descRayon.' районе - цены, фото, план, отзывы | Купить участок земли в КП '.$arResult['NAME'];
			// $setDescription = 'Продажа земельных участков в КП '.trim($arResult['NAME']).' на '.$descShosse.' шоссе в Московской области ►Цены от '.$minPrice.' руб. ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Независимый рейтинг ✔Честный обзор';
			$setDescription = 'Продажа земельных участков в КП '.trim($arResult['NAME']).' на '.$descShosse.' шоссе в Московской области '.$km_MKAD.' км от МКАД ►Цены от '.$priceLandMin.' руб, стоимость сотки от '.$priceSotkaMin.' руб. Коммуникации: свет '.$svetKVT.' кВт на участке, газ '.$gazVal.'. Участки от '.$plottageMin.' до '.$plottageMax.' соток. Рейтинг поселка - '.$arResult['ratingItogo'].'. Количество отзывов - '.$arResult["CNT_COMMENTS"];
		}
		break;
	case 4: // Дома
		if($typeValEnum == 1){ // Дачный поселок
			// $seoTitle = 'Дачный поселок '.trim($arResult['NAME']).' в '.$descRayon.' районе - цены, фото, план, отзывы | Купить дом или дачу в ДП '.$arResult['NAME'];
			// $setDescription = 'Продажа домов и дач в ДП '.trim($arResult['NAME']).' на '.$descShosse.' шоссе в Московской области ►Цены от '.$minPrice.' руб. ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Независимый рейтинг ✔Честный обзор';
			$setDescription = 'Продажа домов и дач в коттеджном поселке '.trim($arResult['NAME']).' на '.$descShosse.' шоссе в Московской области '.$km_MKAD.' км от МКАД ►Цена дома от '.$priceHomeMin.' руб. Коммуникации: свет '.$svetKVT.' кВт на участке, газ '.$gazVal.', вода '.$vodaVal.'. Участки от '.$plottageMin.' до '.$plottageMax.' соток. Рейтинг поселка - '.$arResult['ratingItogo'].'. Количество отзывов - '.$arResult["CNT_COMMENTS"];
		}elseif($typeValEnum == 2){ // Коттеджный поселок
			// $seoTitle = 'Коттеджный поселок '.trim($arResult['NAME']).' в '.$descRayon.' районе - цены, фото, план, отзывы | Купить дом (коттедж) в КП '.$arResult['NAME'];
			// $setDescription = 'Продажа домов и коттеджей в КП '.trim($arResult['NAME']).' на '.$descShosse.' шоссе в Московской области ►Цены от '.$minPrice.' руб. ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Независимый рейтинг ✔Честный обзор';
			$setDescription = 'Продажа домов и коттеджей в КП '.trim($arResult['NAME']).' на '.$descShosse.' шоссе в Московской области '.$km_MKAD.' км от МКАД ►Цена дома от '.$priceHomeMin.' руб. Коммуникации: свет '.$svetKVT.' кВт на участке, газ '.$gazVal.', вода '.$vodaVal.'. Участки от '.$plottageMin.' до '.$plottageMax.' соток. Рейтинг поселка - '.$arResult['ratingItogo'].'. Количество отзывов - '.$arResult["CNT_COMMENTS"];
		}
		break;
	case 256: // Дома и участки
		if($typeValEnum == 1){ // Дачный поселок
			// $seoTitle = 'Дачный поселок '.trim($arResult['NAME']).' в '.$descRayon.' районе - цены, фото, план, отзывы | Купить дом или участок в ДП '.$arResult['NAME'];
			// $setDescription = 'Продажа домов, дач и участков в ДП '.trim($arResult['NAME']).' на '.$descShosse.' шоссе в Московской области ►Цены от '.$minPrice.' руб. ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Независимый рейтинг ✔Честный обзор';
			$setDescription = 'Продажа домов, коттеджей и участков в КП '.trim($arResult['NAME']).' на '.$descShosse.' шоссе в Московской области '.$km_MKAD.' км от МКАД ►Цена дома от '.$priceHomeMin.' руб, стоимость сотки от '.$priceSotkaMin.' руб. Коммуникации: свет '.$svetKVT.' кВт на участке, газ '.$gazVal.'. Участки от '.$plottageMin.' до '.$plottageMax.' соток. Рейтинг поселка - '.$arResult['ratingItogo'].'. Количество отзывов - '.$arResult["CNT_COMMENTS"];
		}elseif($typeValEnum == 2){ // Коттеджный поселок
			// $seoTitle = 'Коттеджный поселок '.trim($arResult['NAME']).' в '.$descRayon.' районе - цены, фото, план, отзывы | Купить дом или участок в КП '.$arResult['NAME'];
			// $setDescription = 'Продажа домов, коттеджей и участков в КП '.trim($arResult['NAME']).' на '.$descShosse.' шоссе в Московской области ►Цены от '.$minPrice.' руб. ✔Стоимость коммуникаций ✔Актуальные фото ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Независимый рейтинг ✔Честный обзор';
			$setDescription = 'Продажа домов, коттеджей и участков в КП '.trim($arResult['NAME']).' на '.$descShosse.' шоссе в Московской области '.$km_MKAD.' км от МКАД ►Цена дома от '.$priceHomeMin.' руб, стоимость сотки от '.$priceSotkaMin.' руб. Коммуникации: свет '.$svetKVT.' кВт на участке, газ '.$gazVal.'. Участки от '.$plottageMin.' до '.$plottageMax.' соток. Рейтинг поселка - '.$arResult['ratingItogo'].'. Количество отзывов - '.$arResult["CNT_COMMENTS"];
		}
		break;
}

$seoTitle = 'Коттеджный поселок '.trim($arResult['NAME']).' в '.$descRayon.' районе - отзывы, цены, фото, план';

$cp = $this->__component;
if (is_object($cp))
{
  $cp->arResult["SEO_TITLE"] = $seoTitle;
  $cp->arResult["SEO_DESCRIPTION"] = $setDescription;
  $cp->SetResultCacheKeys(array("SEO_TITLE","SEO_DESCRIPTION")); //cache keys in $arResult array
}

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();
