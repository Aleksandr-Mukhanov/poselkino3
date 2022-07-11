<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */

use Bitrix\Main\Grid\Declension;
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

$villageID = $arResult['PROPERTIES']['VILLAGE']['VALUE'];
$villageCode = $_REQUEST['VILLAGE_CODE'];
$material = $arResult['PROPERTIES']['MATERIAL']['VALUE'];
$areaHouse = $arResult['PROPERTIES']['AREA_HOUSE']['VALUE'];
$floors = $arResult['PROPERTIES']['FLOORS']['VALUE'];
$price = $arResult['PROPERTIES']['PRICE']['VALUE'];
$plottage = $arResult['PROPERTIES']['PLOTTAGE']['VALUE'];
$number = $arResult['PROPERTIES']['NUMBER']['VALUE'];

// получим поселок
$arOrder = ['SORT'=>'ASC'];

if ($villageCode)
	$arFilter = ['IBLOCK_ID'=>1,'CODE'=>$villageCode];
else
	$arFilter = ['IBLOCK_ID'=>1,'ID'=>$villageID];

$arSelect = Array('ID','NAME','CODE','PROPERTY_MKAD','PROPERTY_SHOSSE','PROPERTY_REGION','PROPERTY_TYPE','PROPERTY_SETTLEM','PROPERTY_ELECTRO','PROPERTY_GAS','PROPERTY_PLUMBING','PROPERTY_ELECTRO_DONE','PROPERTY_ELECTRO_KVT','PROPERTY_PROVEDEN_GAZ','PROPERTY_PROVEDENA_VODA','PROPERTY_LAND_CAT','PROPERTY_TYPE_USE','PROPERTY_LEGAL_FORM','PROPERTY_DEVELOPER_ID','PROPERTY_COORDINATES','PROPERTY_AUTO_NO_JAMS','PROPERTY_TRAIN_TRAVEL_TIME','PROPERTY_TRAIN_VOKZAL','PROPERTY_TRAIN_PRICE','PROPERTY_TRAIN_PRICE_TAXI','PROPERTY_TRAIN_ID_YANDEX','PROPERTY_BUS_VOKZAL','PROPERTY_BUS_TIME_KM','PROPERTY_PLAN_IMG','PROPERTY_PLAN_IMG_IFRAME','PROPERTY_UP_TO_VIEW','PROPERTY_CONTACTS','PROPERTY_PHONE','PROPERTY_PHONE','PROPERTY_PRICE_ARRANGE_INT','PROPERTY_SRC_MAP','PROPERTY_SITE','PROPERTY_RATING','PROPERTY_DOP_FOTO');
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
if ($arElement = $rsElements->GetNext())
{
	$villageID = $arElement['ID'];

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

	// узнаем отзывы
	$cntCom = 0;
	$arOrder = Array("ACTIVE_FROM"=>"DESC");
	$arFilter = Array("IBLOCK_ID"=>2,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$arElement['ID']);
	$arSelect = Array("ID");
	$rsElementsCom = CIBlockElement::GetList($arOrder,$arFilter,false,['nTopCount'=>4],$arSelect);
	while ($arElementCom = $rsElementsCom->Fetch())
		$cntCom++; // кол-во отзывов

	// выводим правильное окончание
	$reviewsDeclension = new Declension('отзыв', 'отзыва', 'отзывов');
	$reviewsText = $reviewsDeclension->get($cntCom);
	$reviewsText = ($cntCom) ? $cntCom . ' ' . $reviewsText : 'нет отзывов';

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
		'PLAN_IMG_IFRAME' => $arElement['PROPERTY_PLAN_IMG_IFRAME_VALUE'],
    'UP_TO_VIEW' => $arElement['PROPERTY_UP_TO_VIEW_VALUE'],
		'CONTACTS' => $arElement['PROPERTY_CONTACTS_ENUM_ID'],
		'PHONE' => $arElement['PROPERTY_PHONE_VALUE'],
		'PRICE_ARRANGE' => $arElement['PROPERTY_PRICE_ARRANGE_INT_VALUE'],
		'SRC_MAP' => $arElement['PROPERTY_SRC_MAP_VALUE'],
		'SITE' => $arElement['PROPERTY_SITE_VALUE'],
		'RATING' => $arElement['PROPERTY_RATING_VALUE'],
		'CNT_REVIEWS' => $reviewsText,
  ];

	$arResult['PHOTO_VILLAGE'] = $arElement['PROPERTY_DOP_FOTO_VALUE'];
}

if ($offerType == 'plots') // если участки
{
  // получим участки
  $arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>5,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$villageID,"!ID"=>$arResult['ID']);
	$arSelect = Array("ID","NAME","CODE","PREVIEW_PICTURE","PROPERTY_PLOTTAGE","PROPERTY_PRICE","PROPERTY_DOP_PHOTO","PROPERTY_NUMBER");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,['nTopCount'=>2],$arSelect);
	while ($arElement = $rsElements->GetNext()) { // dump($arElement);
    // соберем фото
		if($arElement["PREVIEW_PICTURE"])$arPhoto[] = ResizeImage($arElement["PREVIEW_PICTURE"]);
		if($arElement["DETAIL_PICTURE"])$arPhoto[] = ResizeImage($arElement["DETAIL_PICTURE"]);
		if($arResult['PHOTO_VILLAGE']){
			foreach ($arResult['PHOTO_VILLAGE'] as $val)
				$arPhoto[] = ResizeImage($val);
			shuffle($arPhoto);
		}
		// соберем участки
		$arOffers[$arElement["ID"]] = [
			"NAME" => $arElement["NAME"],
      "URL" => '/kupit-uchastki/uchastok-'.$arElement["ID"].'/',
			"IMG" => $arPhoto,
			"PLOTTAGE" => $arElement["PROPERTY_PLOTTAGE_VALUE"],
			"PRICE" => formatPrice($arElement["PROPERTY_PRICE_VALUE"]),
			"NUMBER" => $arElement["PROPERTY_NUMBER_VALUE"],
		];
		unset($arPhoto);
  }

  // получим похожие участки
  $arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>5,"ACTIVE"=>"Y","PROPERTY_PLOTTAGE"=>$plottage,"!ID"=>$arResult['ID']);
	$arSelect = Array("ID","NAME","CODE","PREVIEW_PICTURE","PROPERTY_PLOTTAGE","PROPERTY_PRICE","PROPERTY_DOP_PHOTO","PROPERTY_NUMBER");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,['nTopCount'=>2],$arSelect);
	while ($arElement = $rsElements->GetNext()) { // dump($arElement);
    // соберем фото
		if($arElement["PREVIEW_PICTURE"])$arPhoto[] = ResizeImage($arElement["PREVIEW_PICTURE"]);
		if($arElement["DETAIL_PICTURE"])$arPhoto[] = ResizeImage($arElement["DETAIL_PICTURE"]);
		if($arResult['PHOTO_VILLAGE']){
			foreach ($arResult['PHOTO_VILLAGE'] as $val)
				$arPhoto[] = ResizeImage($val);
			shuffle($arPhoto);
		}
		// соберем участки
		$arOffers[$arElement["ID"]] = [
			"NAME" => $arElement["NAME"],
      "URL" => '/kupit-uchastki/uchastok-'.$arElement["ID"].'/',
			"IMG" => $arPhoto,
			"PLOTTAGE" => $arElement["PROPERTY_PLOTTAGE_VALUE"],
			"PRICE" => formatPrice($arElement["PROPERTY_PRICE_VALUE"]),
			"NUMBER" => $arElement["PROPERTY_NUMBER_VALUE"],
		];
		unset($arPhoto);
  }

  // $seoTitle = 'Купить участок '.$plottage.' соток, '.$arVillage['MKAD'].' км от МКАД, цена '.formatPrice($price).' рублей, в поселке '.$arVillage['NAME'].', '.$arVillage['SHOSSE'].' шоссе, '.$arVillage['REGION'].' район';
	$seoTitle = 'Продажа участка в поселке '.$arVillage['NAME'].' - '.$plottage.' соток, за '.formatPrice($price).' руб.';
  // $seoH1 = 'Земельный участок '.$plottage.' соток, '.$arVillage['MKAD'].' км от МКАД, цена '.formatPrice($price).' рублей в поселке '.$arVillage['NAME'].'';
	$seoH1 = 'Продажа участка № '.$number.' в коттеджном поселке '.$arVillage['NAME'];
  // $setDescription = '▶ Земельный участок '.$plottage.' соток, '.$arVillage['MKAD'].' км от МКАД, цена '.formatPrice($price).' рублей, в поселке '.$arVillage['NAME'].', '.$arVillage['SHOSSE'].' шоссе, '.$arVillage['REGION'].' район ▶ Обзор от «Посёлкино» - это: ★★★ Независимый рейтинг!  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
	$setDescription = 'Продажа участка в КП '.$arVillage['NAME'].' на '.$arVillage['SHOSSE'].' шоссе в Московской области. '.$arVillage['MKAD'].' км от МКАД. Площадь участка '.$plottage.' соток, стоимость сотки от '.formatPrice($price).' руб. Коммуникации: на участке, газ '.$arVillage['PROVEDEN_GAZ'].'. Рейтинг поселка - '.$arVillage['RATING'].'. Количество отзывов - '.$arVillage['CNT_REVIEWS'].'.';

}else{ // если дома

  // получим дома
  $arOrder = Array("SORT"=>"ASC");
  $arFilter = Array("IBLOCK_ID"=>6,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$villageID,"!ID"=>$arResult['ID']);
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

  $seoTitle = 'Купить дом (коттедж) из '.$material.', '.$areaHouse.' метров, '.$arVillage['MKAD'].' км от МКАД, '.$floors.' этажа, цена '.formatPrice($price).' рублей, в поселке '.$arVillage['NAME'].', '.$arVillage['SHOSSE'].' шоссе, '.$arVillage['REGION'].' район';
  $seoH1 = 'Дом (коттедж) из '.$material.', '.$areaHouse.' метров, '.$arVillage['MKAD'].' км от МКАД, '.$floors.' этажа, цена '.formatPrice($price).' рублей в поселке '.$arVillage['NAME'];
  $setDescription = '▶ Дом (коттедж) из '.$material.', '.$areaHouse.' метров, '.$arVillage['MKAD'].' км от МКАД, '.$floors.' этажа, цена '.formatPrice($price).' рублей, в поселке '.$arVillage['NAME'].', '.$arVillage['SHOSSE'].' шоссе, '.$arVillage['REGION'].' район ▶ Обзор от «Посёлкино» - это: ★★★ Независимый рейтинг!  ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
}

$arResult['IPROPERTY_VALUES']['ELEMENT_PAGE_TITLE'] = $seoH1;
$arResult['arVillage'] = $arVillage;
$arResult['arOffers'] = $arOffers;
$arResult['arSimilarOffers'] = $arSimilarOffers;

$cp = $this->__component;
if (is_object($cp))
{
	$cp->arResult['SEO_TITLE'] = $seoTitle;
	$cp->arResult['SEO_DESCRIPTION'] = $setDescription;
	$cp->arResult['VILLAGE_NAME'] = $arVillage['NAME'];
	$cp->arResult['VILLAGE_CODE'] = $arVillage['CODE'];
	$cp->arResult['NUMBER'] = $number;
	$cp->SetResultCacheKeys(array('SEO_TITLE','SEO_DESCRIPTION','VILLAGE_NAME','VILLAGE_CODE','NUMBER')); //cache keys in $arResult array
}

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();
