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

// узнаем отзывы
	$cntCom = 0;$ratingSum = 0;
	$arOrder = Array("ACTIVE_FROM"=>"DESC");
	$arFilter = Array("IBLOCK_ID"=>2,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$arResult["ID"]);
	$arSelect = Array("ID","ACTIVE_FROM","PREVIEW_TEXT","PROPERTY_RATING","PROPERTY_DIGNITIES","PROPERTY_DISADVANTAGES","PROPERTY_FIO","PROPERTY_RESIDENT");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
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

  $minArea = 0;
  $maxArea = 10000;

if($_REQUEST['OFFER_TYPE'] == 'plots'){ // если вывод участков

  // получим участки
  $arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>5,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$arResult["ID"]);
  $arNavParams = ['nPageSize'=>2,"bShowAll" => false];
	$arSelect = Array("ID","CODE","PREVIEW_PICTURE","PROPERTY_PLOTTAGE","PROPERTY_PRICE","PROPERTY_DOP_PHOTO");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,$arNavParams,$arSelect);
  $arResult["NAV_STRING"] = $rsElements->GetPageNavStringEx($navComponentObject, "", "poselkino_nav");
	while($arElement = $rsElements->GetNext()){ // dump($arElement);
    // соберем фото
		if($arElement["PREVIEW_PICTURE"])$arPhoto[] = ResizeImage($arElement["PREVIEW_PICTURE"]);
		if($arElement["DETAIL_PICTURE"])$arPhoto[] = ResizeImage($arElement["DETAIL_PICTURE"]);
		if($arElement["PROPERTY_DOP_PHOTO_VALUE"]){
			foreach ($arElement["PROPERTY_DOP_PHOTO_VALUE"] as $key => $val) {
				$arPhoto[] = ResizeImage($val);
			}
		}
    // мин и макс площадь
    $plottage = $arElement["PROPERTY_PLOTTAGE_VALUE"];
    $minArea = ($minArea < $plottage) ? $plottage : $minArea;
    $maxArea = ($maxArea < $plottage) ? $plottage : $maxArea;
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

}elseif($_REQUEST['OFFER_TYPE'] == 'houses'){ // если  вывод домов

  // получим дома
  $arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>6,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$arResult["ID"]);
  $arNavParams = ['nPageSize'=>2,"bShowAll" => false];
	$arSelect = Array("ID","CODE","PREVIEW_PICTURE","PROPERTY_FLOORS","PROPERTY_MATERIAL","PROPERTY_AREA_HOUSE","PROPERTY_PRICE","PROPERTY_DOP_PHOTO");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,$arNavParams,$arSelect);
  $arResult["NAV_STRING"] = $rsElements->GetPageNavStringEx($navComponentObject, "", "poselkino_nav");
	while($arElement = $rsElements->GetNext()){ // dump($arElement);
    // соберем фото
		if($arElement["PREVIEW_PICTURE"])$arPhoto[] = ResizeImage($arElement["PREVIEW_PICTURE"]);
		if($arElement["DETAIL_PICTURE"])$arPhoto[] = ResizeImage($arElement["DETAIL_PICTURE"]);
		if($arElement["PROPERTY_DOP_PHOTO_VALUE"]){
			foreach ($arElement["PROPERTY_DOP_PHOTO_VALUE"] as $key => $val) {
				$arPhoto[] = ResizeImage($val);
			}
		}

    // мин и макс площадь
    $areaHouse = $arElement["PROPERTY_AREA_HOUSE_VALUE"];
    $minArea = ($minArea < $areaHouse) ? $areaHouse : $minArea;
    $maxArea = ($maxArea < $areaHouse) ? $areaHouse : $maxArea;
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

}

$arResult["CNT_COMMENTS"] = $cntCom;
$arResult["RATING_TOTAL"] = round($ratingTotal,1);
$arResult["COMMENTS"] = $arComments;
$arResult["COMMENTS_RES"] = $arCommentsRes;
$arResult["ratingItogo"] = $arResult['PROPERTIES']['RATING']['VALUE'];
$arResult["arHouses"] = $arHouses;
$arResult["arPlots"] = $arPlots;
$arResult["minArea"] = $minArea;
$arResult["maxArea"] = $maxArea;

// SET BROWSER TITLE
$poselokName = "";
$tempposelokName = !empty($arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'])
	? $arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE']
	: $arResult['NAME'];
switch ($arResult['PROPERTIES']['TYPE']['VALUE_ENUM_ID']) {
	case 1:
			$typeShort = 'ДП'; $typeLong = 'дачный поселок'; $typeLong2 = 'дачном поселке';
			break;
	case 2:
			$typeShort = 'КП'; $typeLong = 'коттеджный поселок'; $typeLong2 = 'коттеджном поселке';
			break;
	case 171:
			$typeShort = 'Ф'; $typeLong = 'фермерство'; $typeLong2 = 'фермерстве';
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

if($_REQUEST['OFFER_TYPE'] == 'plots'){
  $seoTitle = 'Купить участок в '.$typeShort.' '.$tempposelokName.' ('.$typeLong.'), цены участков земли';
  $setDescription = '▶ Земельные участки в '.$typeLong2.' '.$tempposelokName.' ▶ Купить участок под строительство в '.$typeShort.' '.$tempposelokName.' от '.$minPrice.' рублей ▶ Обзор от «Посёлкино» - это: ★★★ Независимый рейтинг!  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
}else{
  $seoTitle = 'Купить дом в '.$typeShort.' '.$tempposelokName.' ('.$typeLong.'), цены на дома и коттеджи';
  $setDescription = '▶ Дома и коттеджи в '.$typeLong2.' '.$tempposelokName.' ▶ Купить готовый дом в '.$typeShort.' '.$tempposelokName.' ▶ Обзор от «Посёлкино» - это: ★★★ Независимый рейтинг!  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
}

$cp = $this->__component;
if (is_object($cp))
{
  $cp->arResult["SEO_TITLE"] = $seoTitle;
  $cp->arResult["SEO_DESCRIPTION"] = $setDescription;
  $cp->SetResultCacheKeys(array("SEO_TITLE","SEO_DESCRIPTION")); //cache keys in $arResult array
}

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();
