<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

// dump($arResult);

$offerType = $_REQUEST['OFFER_TYPE'];

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

$idVillage = $arResult['PROPERTIES']['VILLAGE']['VALUE'];
$material = $arResult['PROPERTIES']['MATERIAL']['VALUE'];
$areaHouse = $arResult['PROPERTIES']['AREA_HOUSE']['VALUE'];
$floors = $arResult['PROPERTIES']['FLOORS']['VALUE'];
$price = $arResult['PROPERTIES']['PRICE']['VALUE'];
$plottage = $arResult['PROPERTIES']['PLOTTAGE']['VALUE'];

// получим поселок
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>1,"ID"=>$idVillage);
$arSelect = Array("ID","NAME","CODE","PROPERTY_MKAD","PROPERTY_SHOSSE","PROPERTY_REGION","PROPERTY_TYPE","PROPERTY_SETTLEM","PROPERTY_ELECTRO","PROPERTY_GAS","PROPERTY_PLUMBING","PROPERTY_ELECTRO_DONE","PROPERTY_ELECTRO_KVT","PROPERTY_PROVEDEN_GAZ","PROPERTY_PROVEDENA_VODA","PROPERTY_LAND_CAT","PROPERTY_TYPE_USE","PROPERTY_LEGAL_FORM","PROPERTY_DEVELOPER_ID","PROPERTY_COORDINATES","PROPERTY_AUTO_NO_JAMS","PROPERTY_TRAIN_TRAVEL_TIME","PROPERTY_TRAIN_VOKZAL","PROPERTY_TRAIN_PRICE","PROPERTY_TRAIN_PRICE_TAXI","PROPERTY_TRAIN_ID_YANDEX","PROPERTY_BUS_VOKZAL","PROPERTY_BUS_TIME_KM","PROPERTY_PLAN_IMG","PROPERTY_UP_TO_VIEW","PROPERTY_CONTACTS","PROPERTY_PHONE");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
if($arElement = $rsElements->GetNext()){ // dump($arElement);
  $i = 0;
  foreach ($arElement['PROPERTY_SHOSSE_VALUE'] as $key => $value) {
    if ($i == 0) $arShosseOne['VALUE_ENUM_ID'] = $key;
    $strShosse = ($strShosse) ? $strShosse.', '.$value : $value;
    $i++;
  }
  $propEnums = CIBlockPropertyEnum::GetList([],["IBLOCK_ID"=>1,"CODE"=>"SHOSSE","ID"=>$arShosseOne['VALUE_ENUM_ID']]);
	if($enumFields = $propEnums->GetNext()){ // dump($enumFields);
    $arShosseOne['VALUE_XML_ID'] = $enumFields['XML_ID'];
    $arShosseOne['VALUE'] = $enumFields['VALUE'];
  }
  $propEnums = CIBlockPropertyEnum::GetList([],["IBLOCK_ID"=>1,"CODE"=>"REGION","ID"=>$arElement['PROPERTY_REGION_ENUM_ID']]);
	if($enumFields = $propEnums->GetNext()){ // dump($enumFields);
    $arRegionXML = $enumFields['XML_ID'];
  }

  switch ($arElement['PROPERTY_TYPE_ENUM_ID']) { // название по типу
  	case 1: $typePos = "ДП"; break;
  	case 2: $typePos = "КП"; break;
  	case 171: $typePos = "Ф"; break;
  }
  $arVillage = [
    'ID' => $arElement['ID'],
    'NAME' => $arElement['NAME'],
    'CODE' => $arElement['CODE'],
    'MKAD' => $arElement['PROPERTY_MKAD_VALUE'],
    'SHOSSE' => $strShosse,
    'SHOSSE_ONE' => $arShosseOne,
    'REGION' => $arElement['PROPERTY_REGION_VALUE'],
    'REGION_XML' => $arRegionXML,
    'TYPE_AB' => $typePos,
    'SETTLEM' => $arElement['PROPERTY_SETTLEM_VALUE'],
    'ELECTRO' => $arElement['PROPERTY_ELECTRO_VALUE'],
    'ELECTRO_DONE' => $arElement['PROPERTY_ELECTRO_DONE_VALUE'],
    'ELECTRO_KVT' => $arElement['PROPERTY_ELECTRO_KVT_VALUE'],
    'GAS' => $arElement['PROPERTY_GAS_VALUE'],
    'PROVEDEN_GAZ' => $arElement['PROPERTY_PROVEDEN_GAZ_VALUE'],
    'PLUMBING' => $arElement['PROPERTY_PLUMBING_VALUE'],
    'PROVEDENA_VODA' => $arElement['PROPERTY_PROVEDENA_VODA_VALUE'],
    'LAND_CAT' => $arElement['PROPERTY_LAND_CAT_VALUE'],
    'TYPE_USE' => $arElement['PROPERTY_TYPE_USE_VALUE'],
    'LEGAL_FORM' => $arElement['PROPERTY_LEGAL_FORM_VALUE'],
    'DEVELOPER_ID' => $arElement['PROPERTY_DEVELOPER_ID_VALUE'],
    'COORDINATES' => $arElement['PROPERTY_COORDINATES_VALUE'],
    'AUTO_NO_JAMS' => $arElement['PROPERTY_AUTO_NO_JAMS_VALUE'],
    'TRAIN_TRAVEL_TIME' => $arElement['PROPERTY_TRAIN_TRAVEL_TIME_VALUE'],
    'TRAIN_VOKZAL' => $arElement['PROPERTY_TRAIN_VOKZAL_VALUE'],
    'TRAIN_PRICE' => $arElement['PROPERTY_TRAIN_PRICE_VALUE'],
    'TRAIN_PRICE_TAXI' => $arElement['PROPERTY_TRAIN_PRICE_TAXI_VALUE'],
    'TRAIN_ID_YANDEX' => $arElement['PROPERTY_TRAIN_ID_YANDEX_VALUE'],
    'BUS_VOKZAL' => $arElement['PROPERTY_BUS_VOKZAL_VALUE'],
    'BUS_TIME_KM' => $arElement['PROPERTY_BUS_TIME_KM_VALUE'],
    'PLAN_IMG' => $arElement['PROPERTY_PLAN_IMG_VALUE'],
    'UP_TO_VIEW' => $arElement['PROPERTY_UP_TO_VIEW_VALUE'],
		'CONTACTS' => $arElement['PROPERTY_CONTACTS_ENUM_ID'],
		'PHONE' => $arElement['PROPERTY_PHONE_VALUE'],
  ];
} // dump($arVillage);

if($offerType == 'plots'){ // если участки

  // получим участки
  $arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>5,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$idVillage,"!ID"=>$arResult['ID']);
	$arSelect = Array("ID","NAME","CODE","PREVIEW_PICTURE","PROPERTY_PLOTTAGE","PROPERTY_PRICE","PROPERTY_DOP_PHOTO");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,['nTopCount'=>2],$arSelect);
	while($arElement = $rsElements->GetNext()){ // dump($arElement);
    // соберем фото
		if($arElement["PREVIEW_PICTURE"])$arPhoto[] = ResizeImage($arElement["PREVIEW_PICTURE"]);
		if($arElement["DETAIL_PICTURE"])$arPhoto[] = ResizeImage($arElement["DETAIL_PICTURE"]);
		if($arElement["PROPERTY_DOP_PHOTO_VALUE"]){
			foreach ($arElement["PROPERTY_DOP_PHOTO_VALUE"] as $key => $val) {
				$arPhoto[] = ResizeImage($val);
			}
		}
		// соберем участки
		$arOffers[$arElement["ID"]] = [
			"NAME" => $arElement["NAME"],
      "CODE" => 'uchastki/'.$arElement["CODE"],
			"IMG" => $arPhoto,
			"PLOTTAGE" => $arElement["PROPERTY_PLOTTAGE_VALUE"],
			"PRICE" => formatPrice($arElement["PROPERTY_PRICE_VALUE"]),
		];
		unset($arPhoto);
  }

  // получим похожие участки
  $arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>5,"ACTIVE"=>"Y","PROPERTY_PLOTTAGE"=>$plottage,"!ID"=>$arResult['ID']);
	$arSelect = Array("ID","NAME","CODE","PREVIEW_PICTURE","PROPERTY_PLOTTAGE","PROPERTY_PRICE","PROPERTY_DOP_PHOTO");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,['nTopCount'=>2],$arSelect);
	while($arElement = $rsElements->GetNext()){ // dump($arElement);
    // соберем фото
		if($arElement["PREVIEW_PICTURE"])$arPhoto[] = ResizeImage($arElement["PREVIEW_PICTURE"]);
		if($arElement["DETAIL_PICTURE"])$arPhoto[] = ResizeImage($arElement["DETAIL_PICTURE"]);
		if($arElement["PROPERTY_DOP_PHOTO_VALUE"]){
			foreach ($arElement["PROPERTY_DOP_PHOTO_VALUE"] as $key => $val) {
				$arPhoto[] = ResizeImage($val);
			}
		}
		// соберем участки
		$arOffers[$arElement["ID"]] = [
			"NAME" => $arElement["NAME"],
      "CODE" => 'uchastki/'.$arElement["CODE"],
			"IMG" => $arPhoto,
			"PLOTTAGE" => $arElement["PROPERTY_PLOTTAGE_VALUE"],
			"PRICE" => formatPrice($arElement["PROPERTY_PRICE_VALUE"]),
		];
		unset($arPhoto);
  }

  $seoTitle = 'Купить участок '.$plottage.' соток, '.$arVillage['MKAD'].' км от МКАД, цена '.$price.' рублей, в поселке '.$arVillage['NAME'].', '.$arVillage['SHOSSE'].' шоссе, '.$arVillage['REGION'].' район';
  $seoH1 = 'Земельный участок '.$plottage.' соток, '.$arVillage['MKAD'].' км от МКАД, цена '.$price.' рублей в поселке '.$arVillage['NAME'].'';
  $setDescription = '▶ Земельный участок '.$plottage.' соток, '.$arVillage['MKAD'].' км от МКАД, цена '.$price.' рублей, в поселке '.$arVillage['NAME'].', '.$arVillage['SHOSSE'].' шоссе, '.$arVillage['REGION'].' район ▶ Обзор от «Посёлкино» - это: ★★★ Независимый рейтинг!  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';

}else{ // если дома

  // получим дома
  $arOrder = Array("SORT"=>"ASC");
  $arFilter = Array("IBLOCK_ID"=>6,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$idVillage,"!ID"=>$arResult['ID']);
  $arSelect = Array("ID","NAME","CODE","PREVIEW_PICTURE","PROPERTY_FLOORS","PROPERTY_MATERIAL","PROPERTY_AREA_HOUSE","PROPERTY_PRICE","PROPERTY_DOP_PHOTO");
  $rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,['nTopCount'=>3],$arSelect);
  while($arElement = $rsElements->GetNext()){ // dump($arElement);
    // соберем фото
    if($arElement["PREVIEW_PICTURE"])$arPhoto[] = ResizeImage($arElement["PREVIEW_PICTURE"]);
    if($arElement["DETAIL_PICTURE"])$arPhoto[] = ResizeImage($arElement["DETAIL_PICTURE"]);
    if($arElement["PROPERTY_DOP_PHOTO_VALUE"]){
      foreach ($arElement["PROPERTY_DOP_PHOTO_VALUE"] as $key => $val) {
        $arPhoto[] = ResizeImage($val);
      }
    }
    // соберем дома
    $arOffers[$arElement["ID"]] = [
      "NAME" => $arElement["NAME"],
      "CODE" => 'doma/'.$arElement["CODE"],
      "IMG" => $arPhoto,
      "FLOORS" => $arElement["PROPERTY_FLOORS_VALUE"],
      "MATERIAL" => $arElement["PROPERTY_MATERIAL_VALUE"],
      "AREA_HOUSE" => $arElement["PROPERTY_AREA_HOUSE_VALUE"],
      "PRICE" => formatPrice($arElement["PROPERTY_PRICE_VALUE"]),
    ];
    unset($arPhoto);
  }

  // получим похожие дома
  $arOrder = Array("SORT"=>"ASC");
  $arFilter = Array("IBLOCK_ID"=>6,"ACTIVE"=>"Y","PROPERTY_FLOORS"=>$floors,"PROPERTY_MATERIAL"=>$material,"!ID"=>$arResult['ID']);
  $arSelect = Array("ID","NAME","CODE","PREVIEW_PICTURE","PROPERTY_FLOORS","PROPERTY_MATERIAL","PROPERTY_AREA_HOUSE","PROPERTY_PRICE","PROPERTY_DOP_PHOTO");
  $rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,['nTopCount'=>3],$arSelect);
  while($arElement = $rsElements->GetNext()){ // dump($arElement);
    // соберем фото
    if($arElement["PREVIEW_PICTURE"])$arPhoto[] = ResizeImage($arElement["PREVIEW_PICTURE"]);
    if($arElement["DETAIL_PICTURE"])$arPhoto[] = ResizeImage($arElement["DETAIL_PICTURE"]);
    if($arElement["PROPERTY_DOP_PHOTO_VALUE"]){
      foreach ($arElement["PROPERTY_DOP_PHOTO_VALUE"] as $key => $val) {
        $arPhoto[] = ResizeImage($val);
      }
    }
    // соберем дома
    $arSimilarOffers[$arElement["ID"]] = [
      "NAME" => $arElement["NAME"],
      "CODE" => 'doma/'.$arElement["CODE"],
      "IMG" => $arPhoto,
      "FLOORS" => $arElement["PROPERTY_FLOORS_VALUE"],
      "MATERIAL" => $arElement["PROPERTY_MATERIAL_VALUE"],
      "AREA_HOUSE" => $arElement["PROPERTY_AREA_HOUSE_VALUE"],
      "PRICE" => formatPrice($arElement["PROPERTY_PRICE_VALUE"]),
    ];
    unset($arPhoto);
  }

  $seoTitle = 'Купить дом (коттедж) из '.$material.', '.$areaHouse.' метров, '.$arVillage['MKAD'].' км от МКАД, '.$floors.' этажа, цена '.$price.' рублей, в поселке '.$arVillage['NAME'].', '.$arVillage['SHOSSE'].' шоссе, '.$arVillage['REGION'].' район';
  $seoH1 = 'Дом (коттедж) из '.$material.', '.$areaHouse.' метров, '.$arVillage['MKAD'].' км от МКАД, '.$floors.' этажа, цена '.$price.' рублей в поселке '.$arVillage['NAME'];
  $setDescription = '▶ Дом (коттедж) из '.$material.', '.$areaHouse.' метров, '.$arVillage['MKAD'].' км от МКАД, '.$floors.' этажа, цена '.$price.' рублей, в поселке '.$arVillage['NAME'].', '.$arVillage['SHOSSE'].' шоссе, '.$arVillage['REGION'].' район ▶ Обзор от «Посёлкино» - это: ★★★ Независимый рейтинг!  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
}

$arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] = $seoH1;
$arResult['arVillage'] = $arVillage;
$arResult['arOffers'] = $arOffers;
$arResult['arSimilarOffers'] = $arSimilarOffers;

// $APPLICATION->AddChainItem('Поселки','/poselki/');
// $APPLICATION->AddChainItem($arVillage['TYPE_AB'].' '.$arVillage['NAME'],'/poselki/'.$arVillage['CODE'].'/');

$cp = $this->__component;
if (is_object($cp))
{
 $cp->arResult["SEO_TITLE"] = $seoTitle;
 $cp->arResult["SEO_DESCRIPTION"] = $setDescription;
 $cp->SetResultCacheKeys(array("SEO_TITLE","SEO_DESCRIPTION")); //cache keys in $arResult array
}

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();
