<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;
	Loader::includeModule('highloadblock');
  Loader::includeModule('iblock');

	// Вытаскиваем элементы инфоблока
	// $arOrder = ['SORT'=>'ASC'];
	// $arFilter = ['IBLOCK_ID'=>6];
	// $arSelect = ['ID','NAME','PROPERTY_MATERIAL','PROPERTY_MATERIAL2'];
	// $rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	// while ($arElement = $rsElements->Fetch()) { // dump($arElement);
	//   switch ($arElement['PROPERTY_MATERIAL2_VALUE']) {
	// 		case 'каркас':
	//   		$newProp = 582;
	//   		break;
	// 		case 'брус':
	//   		$newProp = 583;
	//   		break;
	// 		case 'кирпич':
	//   		$newProp = 584;
	//   		break;
	// 		case 'газоблок':
	//   		$newProp = 585;
	//   		break;
	// 		case 'теплая керамика':
	//   		$newProp = 586;
	//   		break;
	// 		case 'газосиликат':
	//   		$newProp = 587;
	//   		break;
	// 		case 'монолит':
	//   		$newProp = 588;
	//   		break;
	// 		case 'пеноблок':
	//   		$newProp = 589;
	//   		break;
	// 		case 'теплый бетон':
	//   		$newProp = 590;
	//   		break;
	// 		case 'фахтверк':
	//   		$newProp = 591;
	//   		break;
	// 		case 'Сруб':
	//   		$newProp = 592;
	//   		break;
	//
	//   	default:
	//   		$newProp = '';
	//   		break;
	//   }
	//
	// 	// if ($newProp) CIBlockElement::SetPropertyValues($arElement['ID'], 6, $newProp, "MATERIAL");
	// }

// получим шоссе и районы
// $arElHL = getElHL(16,[],[],['*']);
// foreach ($arElHL as $value)
// 	$arShosse[$value['UF_NAME']] = $value['UF_XML_ID'];
//
// $arElHL = getElHL(17,[],[],['*']);
// foreach ($arElHL as $value)
// 	$arRegion[$value['UF_NAME']] = $value['UF_XML_ID'];
//
// // Вытаскиваем элементы инфоблока
// $arOrder = ['SORT'=>'ASC'];
// $arFilter = ['IBLOCK_ID'=>6];
// $arSelect = ['ID','NAME','PROPERTY_VILLAGE'];
// $rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
// while ($arElement = $rsElements->Fetch()) {
//   if ($arElement['PROPERTY_VILLAGE_VALUE'][0]) {
//     $arHouseIds[$arElement['ID']] = $arElement['PROPERTY_VILLAGE_VALUE'][0];
//   	$arVillageIds[] = $arElement['PROPERTY_VILLAGE_VALUE'][0];
//   }
//   // if ($arElement['PROPERTY_VILLAGE_VALUE'][1]) dump($arElement);
// }
//
// $arOrder = ['SORT'=>'ASC'];
// $arFilter = ['IBLOCK_ID'=>1,'ID'=>$arVillageIds];
// $arSelect = ['ID','NAME',"PROPERTY_MKAD",'PROPERTY_REGION','PROPERTY_SHOSSE'];
// $rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
// while ($arElement = $rsElements->Fetch()) {
// 	// dump($arElement);
//   $arVillage[$arElement['ID']] = [
//     // 'MKAD' => $arElement['PROPERTY_MKAD_VALUE'],
//     // 'REGION' => $arRegion[$arElement['PROPERTY_REGION_VALUE']],
//     'SHOSSE' => $arElement['PROPERTY_SHOSSE_VALUE'],
//   ];
// }
// // dump($arVillage);
//
// foreach ($arHouseIds as $idHouse => $idVil) {
//   // dump($arVillage[$idVil]['SHOSSE']);
//   // CIBlockElement::SetPropertyValues($idHouse, 6, $arVillage[$idVil]['MKAD'], "MKAD");
//   // CIBlockElement::SetPropertyValues($idHouse, 6, $arVillage[$idVil]['REGION'], "REGION");
//   foreach ($arVillage[$idVil]['SHOSSE'] as $value)
//     $arShosse2[] = $arShosse[$value];
//   // CIBlockElement::SetPropertyValues($idHouse, 6, $arShosse2, "SHOSSE");
//   unset($arShosse2);
// }


// require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
// сортировка urlrewrite.php
// $i = 0;
// foreach ($arUrlRewrite as $key => $value) {
//   $i += 10;
//   echo $i." => "."[<br>".
//     "qqqq'CONDITION' => '".$value["CONDITION"]."',<br>".
//     "qqqq'RULE' => '".$value["RULE"]."',<br>".
//     "qqqq'ID' => '".$value["ID"]."',<br>".
//     "qqqq'PATH' => '".$value["PATH"]."',<br>".
//     "qqqq'SORT' => ".$i.",<br>"
//   ."],<br>";
// }

// блог
// echo 'test'.'<br>';
// $arOrder = ['ID'=>'ASC'];
// $arFilter = ['IBLOCK_ID'=>3];
// $arSelect = ['ID','NAME','DETAIL_PAGE_URL'];
// $rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
// while ($arElement = $rsElements->GetNext()) {
// 	echo $arElement['DETAIL_PAGE_URL'].'<br>';
// }

// перенесем дома
// \Bitrix\Main\Loader::includeModule('iblock');
//
// $params = Array(
// 	 "max_len" => "100", // обрезает символьный код до 100 символов
// 	 "change_case" => "L", // буквы преобразуются к нижнему регистру
// 	 "replace_space" => "-", // меняем пробелы на тире
// 	 "replace_other" => "-", // меняем левые символы на тире
// 	 "delete_repeat_replace" => "true", // удаляем повторяющиеся символы
// 	 "use_google" => "false", // отключаем использование google
// );
//
// $arOrder = Array("ID"=>"DESC");
// $arFilter = Array("IBLOCK_ID"=>4);
// $arSelect = Array("ID","NAME","ACTIVE","PREVIEW_PICTURE","DETAIL_PICTURE","PREVIEW_TEXT",'PROPERTY_VILLAGE','PROPERTY_TURN_KEY','PROPERTY_WITHOUT_FINISHING','PROPERTY_DOP_PHOTO','PROPERTY_MATERIAL','PROPERTY_VILLAGE_2');
// $rsElements = \CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
// while($arElement = $rsElements->GetNext()){ // dump($arElement);
//
//   if ($arElement['PROPERTY_VILLAGE_2_VALUE']) dump($arElement);
//
//   if ($arElement['DETAIL_PICTURE']) $arDopFoto[] = CFile::MakeFileArray($arElement['DETAIL_PICTURE']);
//
//   foreach ($arElement['PROPERTY_DOP_PHOTO_VALUE'] as $key => $value) {
//     $arDopFoto[] = CFile::MakeFileArray($value);
//   }
//
//   $el = new CIBlockElement;
//   $PROP = array();
// 	$PROP['VILLAGE'] = $arElement['PROPERTY_VILLAGE_VALUE'];
//   $PROP['PRICE'] = $arElement['PROPERTY_TURN_KEY_VALUE'];
//   $PROP['PRICE_WITHOUT_FINISHING'] = $arElement['PROPERTY_WITHOUT_FINISHING_VALUE'];
//   $PROP['DOP_PHOTO'] = $arDopFoto;
//   $PROP['MATERIAL'] = $arElement['PROPERTY_MATERIAL_VALUE'];
//
//   $arLoadProductArray = Array(
//     "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
//     "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
//     "IBLOCK_ID"      => 6,
//     "PROPERTY_VALUES"=> $PROP,
//     "NAME"           => $arElement['NAME'],
//     "CODE"           => CUtil::translit($arElement['NAME'], "ru", $params),
//     "ACTIVE"         => 'N',            // активен
//     "PREVIEW_TEXT"   => $arElement['PREVIEW_TEXT'],
//     "PREVIEW_PICTURE"   => CFile::MakeFileArray($arElement['PREVIEW_PICTURE']),
//   );
// 	unset($arDopFoto); unset($PROP);
//
// 	// dump($arLoadProductArray);
//   // if($el->Add($arLoadProductArray))
//   //   echo 'Успешно!';
//   // else echo 'Ошибка!'.$arElement['ID'];
//   // echo '<br>';
// }
echo 'ok_OLD';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
