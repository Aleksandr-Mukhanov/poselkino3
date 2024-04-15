<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var CBitrixComponentTemplate $this
 * @var CatalogElementComponent $component
 */
// dump($arResult);

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
	$cntCom = 0;
	$arOrder = Array("ACTIVE_FROM"=>"DESC");
	$arFilter = Array("IBLOCK_ID"=>2,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$arResult["ID"]);
	$arSelect = Array("ID");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	while($arElement = $rsElements->Fetch()){ // dump($arElement);
		$cntCom++; // кол-во отзывов
	}

// узнаем новости
	$arOrder = Array("ACTIVE_FROM"=>"DESC");
	$arFilter = Array("IBLOCK_ID"=>8,"ACTIVE"=>"Y","PROPERTY_VILLAGE"=>$arResult["ID"]);
	$arSelect = Array('ID','NAME','PREVIEW_PICTURE','PREVIEW_TEXT');
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	while($arElement = $rsElements->Fetch()){ // dump($arElement);
		$arNews[] = $arElement;
	}

$arResult["CNT_COMMENTS"] = $cntCom;
$arResult["NEWS"] = $arNews;
$arResult["ratingItogo"] = $arResult['PROPERTIES']['RATING']['VALUE'];

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

// формирование TITLE
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

// правка титл для поселков-дубли
switch ($arResult['CODE']) {
	case 'lesnoe-ozero-shach': $regionTitle = ' в '.$descRayon.' районе'; $arResult["TITLE_DOP"] = ', '.$arResult['PROPERTIES']['REGION']['VALUE_ENUM'].' район'; break;
	case 'lesnoe-ozero': $regionTitle = ' в '.$descRayon.' районе'; $arResult["TITLE_DOP"] = ', '.$arResult['PROPERTIES']['REGION']['VALUE_ENUM'].' район'; break;
	case 'polesie': $regionTitle = ' в '.$descRayon.' районе'; $arResult["TITLE_DOP"] = ', '.$arResult['PROPERTIES']['REGION']['VALUE_ENUM'].' район'; break;
	case 'polese': $regionTitle = ' в '.$descRayon.' районе'; $arResult["TITLE_DOP"] = ', '.$arResult['PROPERTIES']['REGION']['VALUE_ENUM'].' район'; break;
	case 'solnechnyy-bereg': $regionTitle = ' в '.$descRayon.' районе'; $arResult["TITLE_DOP"] = ', '.$arResult['PROPERTIES']['REGION']['VALUE_ENUM'].' район'; break;
	case 'solnechniy_bereg': $regionTitle = ' в '.$descRayon.' районе'; $arResult["TITLE_DOP"] = ', '.$arResult['PROPERTIES']['REGION']['VALUE_ENUM'].' район'; break;

	default: $regionTitle = ''; $arResult["TITLE_DOP"] = ''; break;
}

$seoTitle = 'Новости о поселке '.trim($arResult['NAME']).$regionTitle.' - новости жильцов КП '.trim($arResult['NAME']);
$setDescription = 'Новости жильцов о поселке '.trim($arResult['NAME']).$regionTitle.'. Все новости, плюсы и минусы о КП '.trim($arResult['NAME']).' на сайте Поселкино';

$cp = $this->__component;
if (is_object($cp))
{
  $cp->arResult["SEO_TITLE"] = $seoTitle;
  $cp->arResult["SEO_DESCRIPTION"] = $setDescription;
  $cp->SetResultCacheKeys(array("SEO_TITLE","SEO_DESCRIPTION"));
}

$component = $this->getComponent();
$arParams = $component->applyTemplateModifications();
