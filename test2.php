<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
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
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
