<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
echo 'test2<br>';
use Bitrix\Main\Loader;
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;
	Loader::includeModule('highloadblock');
  Loader::includeModule('iblock');

	// dump($_SERVER["DOCUMENT_ROOT"]);

	// получим поселки земекса
	// $arOrder = Array('SORT'=>'ASC');
  // $arFilter = Array('IBLOCK_ID'=>1,"PROPERTY_DEVELOPER_ID" => 'Zemelniy-Ekspress','!PROPERTY_SITE'=>false,'!PROPERTY_SALES_PHASE'=>254);
  // $arSelect = Array('ID','NAME','PROPERTY_SITE');
  // $rsElements = \CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
  // while($arElements = $rsElements->Fetch()){
	// 	echo $arElements['PROPERTY_SITE_VALUE'].'<br>';
	// }

	// https://api.telegram.org/bot7073227220:AAGhNegb0u10BDbw9cbrZ37iF3nmsKw8_N0/getUpdates
	// 7339729126 - мой теле2

	// $token = '7073227220:AAGhNegb0u10BDbw9cbrZ37iF3nmsKw8_N0';
	// $chat_id = 461529239;

	// sendTelegram($chat_id,'тестовое');

	// $result = sendTelegram($chat_id,'тестовое');
	// dump($result);

	// $getQuery = array(
  //   "chat_id" 	=> $chat_id,
  //   "text"  	=> "Новое сообщение из формы",
	// );
	// $ch = curl_init("https://api.telegram.org/bot". $token ."/sendMessage?" . http_build_query($getQuery));
	// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// curl_setopt($ch, CURLOPT_HEADER, false);
	// $resultQuery = curl_exec($ch);
	// curl_close($ch);
	//
	// dump($resultQuery);
	//
	// dump($getQuery);

	// $params = array(
  //   'chat_id' => $chat_id, // id получателя сообщения
  //   'text' => 'privet', // текст сообщения
  //   // 'parse_mode' => 'HTML', // режим отображения сообщения, не обязательный параметр
	// );
	//
	// $curl = curl_init();
	// curl_setopt($curl, CURLOPT_URL, 'https://api.telegram.org/bot' . $token . '/sendMessage'); // адрес api телеграмм
	// curl_setopt($curl, CURLOPT_POST, true); // отправка данных методом POST
	// curl_setopt($curl, CURLOPT_TIMEOUT, 10); // максимальное время выполнения запроса
	// curl_setopt($curl, CURLOPT_POSTFIELDS, $params); // параметры запроса
	// $result = curl_exec($curl); // запрос к api
	// curl_close($curl);
	//
	// dump($result);

	// https://api.telegram.org/bot7073227220:AAGhNegb0u10BDbw9cbrZ37iF3nmsKw8_N0/sendMessage?chat_id=461529239&text=привет


	// $mailFields = array(
	// 	"name" => $name,
	// 	"tel" => $tel,
	// 	"email" => $email,
	// 	"namePos" => $namePos,
	// 	"codePos" => $codePos,
	// 	"highway" => $highway,
	// 	"subject" => $subject,
	// 	"develId" => $_POST['develId'],
	// 	"develName" => $_POST['develName'],
	// 	"phoneDevel" => $_POST['phoneDevel'],
	// 	"emailDevel" => $emailDevel,
	// 	"page" => $fromPage,
	// 	"toEmail" => $toEmail,
	// );

	// $mailFields = [
	// 	'111' => 222,
	// 	'333' => 444
	// ];
	//
	// $hlblock_id = 24; // id HL
	// $hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
	// $entity = HL\HighloadBlockTable::compileEntity($hlblock);
	// $entity_data_class = $entity->getDataClass();
	//
	// $arData =[
	// 	// "UF_ORDER" => $mailFields,
	// 	"UF_NAME" => $name,
	// 	"UF_PHONE" => $tel,
	// 	"UF_VILLAGE" => $namePos,
	// 	"UF_HIGHWAY" => $highway,
	// 	"UF_FORM" => $leadName,
	// 	"UF_DEVELOPER" => $name,
	// 	"UF_PAGE" => $fromPage,
	// 	"UF_M_EMAIL" => $toEmail,
	// 	"UF_M_PHONE" => $toPhone,
	// 	"UF_M_AMO" => $responsibleUserId,
	// 	"UF_DATE" => date('d.m.Y H:i:s')
	// ];
	// dump($arData);
	// // $result = $entity_data_class::add($arData);

	// // тестовая отправка
	// $mailFields = array(
	// 	"NAME" => 'Тест Поселкино',
	// );
	// if ($result = CEvent::Send("TEST_SEND", "s1", $mailFields)) echo "Сообщение успешно отправлено!";
	// else echo "Error: ".$result->LAST_ERROR;

	// if (mail('mukhanov.au@gmail.com','test1','test1'))
	// 	echo 'ok gmail';
	// else
	// 	echo 'no gmail';
	//
	// echo '<br>';
	//
	// if (mail('mukhanov.au@ya.ru','test2','test2'))
	// 	echo 'ok ya';
	// else
	// 	echo 'no ya';
	//
	// echo '<br>';
	//
	// if (mail('muxa___@mail.ru','test3','test3'))
	// 	echo 'ok mail';
	// else
	// 	echo 'no mail';

	// $success = mail('muxa___@mail.ru', 'My Subject1', 'test');
	// if (!$success) {
	// 		echo 'not';
	//    $errorMessage = error_get_last()['message'];
	// 	 dump($errorMessage);
	// } else echo 'da';

	// $site = 1;
	// $arElHL = getElHL(13,['ID'=>'desc'],['UF_ROUTE'=>$site],['ID','UF_EMAIL','UF_PHONE','UF_ROUTE']);
	// foreach ($arElHL as $value) {
	// 	$arEmail[] = trim($value['UF_EMAIL']);
	// 	$arPhone[] = trim($value['UF_PHONE']);
	// }
	// $toEmail = implode(',',$arEmail);
	// $toPhone = implode(',',$arPhone);
	// dump($toPhone);

	// $arPhones = [
	// 	'novoe-tashirovo.ru' => '+7(499)450-55-12',
	// 	'lapino-kp.ru' => '+7(499)450-55-12',
	// 	'elizarovo-kp.ru' => '+7(499)450-55-12',
	// 	'admiral-kp.ru' => '+7(499)288-74-81',
	// 	'velikie-ozera.ru' => '+7(499)288-74-81',
	// 	'kp-saltykovo.ru' => '+7(499)288-74-81',
	// 	'pahra-river-kp.ru' => '+7(499)430-08-41',
	// 	'sosnovyi-bor.ru' => '+7(499)430-08-41',
	// 	'faustovo-kp.ru' => '+7(499)430-08-41',
	// 	'eco-razdolie.ru' => '+7(499)430-08-41',
	// 	'mishutinckaya-sloboda.ru' => '+7(499)288-23-86',
	// 	'malinky-park.ru' => '+7(499)288-23-86',
	// 	'kalitino-kp.ru' => '+7(499)288-23-86',
	// 	'berezky-park.ru' => '+7(499)288-23-86',
	// 	'kp-ogudnevo.ru' => '+7(499)288-23-86',
	// 	'edem-kp.ru' => '+7(499)288-23-86',
	// 	'kp-tradicii.ru' => '+7(499)288-23-86',
	// 	'dariino-park.ru' => '+7(499)226-28-24',
	// 	'rizskie-zori.ru' => '+7(499)226-28-24',
	// 	'maximovo-park.ru' => '+7(499)226-28-24',
	// 	'repino-kp.ru' => '+7(499)757-57-25',
	// 	'lesnoi-ostrov.ru' => '+7(499)757-57-25',
	// 	'regata-kp.ru' => '+7(499)757-57-25',
	// 	'favorit-kp.ru' => '+7(499)757-57-25',
	// 	'ilinskoe-kp.ru' => '+7(499)757-57-25',
	// 	'red-poselok.ru' => '+7(499)757-57-25',
	// 	'karamel-kp.ru' => '+7(499)757-57-25',
	// 	'kp-divniy.ru' => '+7(499)757-57-25',
	// 	'zem-polyana.ru' => '+7(499)757-57-25',
	// 	'rublevo-kp.ru' => '+7(499)757-57-25',
	// 	'kp-kalina.ru' => '+7(499)757-57-25',
	// 	'kp-svetliy.ru' => '+7(499)757-57-25',
	// 	'kp-bunino.ru' => '+7(499)757-57-25',
	// 	'esenino-kp.ru' => '+7(499)757-57-25',
	// 	'dinastiya-kp.ru' => '+7(499)757-57-25',
	// 	'kp-brusnikino.ru' => '+7(499)757-57-25',
	// 	'fisher-poselok.ru' => '+7(499)757-57-25',
	// 	'kp-lider.ru' => '+7(499)757-57-25',
	// 	'minaevo-igs.ru' => '+7(499)757-57-25',
	// 	'kuzminskiy-kp.ru' => '+7(901)505-41-01',
	// 	'kp-beregovoy.ru' => '+7(499)757-57-25',
	// 	'stepigino.ru' => '+7(499)757-57-25',
	// 	'vasnetsovo-kp.ru' => '+7(499)757-57-25',
	// 	'skazka-kp.ru' => '+7(499)757-57-25',
	// 	'kp-mirnyi.ru' => '+7(499)757-57-25',
	// 	'novoe-sonino.ru' => '+7(499)757-57-25',
	// 	'matchino-park.ru' => '+7(499)757-57-25',
	// 	'rastunovo-kp.ru' => '+7(499)757-57-25',
	// 	'soninskiy-les.ru' => '+7(499)757-57-25',
	// 	'shelest-kp.ru' => '+7(499)757-57-25',
	// 	'dachnaya-practika.ru' => '+7(499)757-57-25',
	// 	'kalipso-village.ru' => '+7(499)495-40-56',
	// 	'kp-brehovo.ru' => '+7(499)495-40-56',
	// 	'sokolniki-kp.ru' => '+7(499)495-40-56',
	// 	'shadrino.su' => '+7(499)495-40-56',
	// 	'kp-lyzhnik.ru' => '+7(499)495-40-56',
	// 	'vasilkovo-kp.ru' => '+7(499)504-98-09',
	// 	'socolinaya-gora.ru' => '+7(499)504-98-09',
	// 	'orlinye-holmy.ru' => '+7(499)504-98-09',
	// 	'swiss-dolina.ru' => '+7(499)504-98-09',
	// 	'kp-ivanovka.ru' => '+7(499)455-08-70',
	// 	'hodaevskie-dachi.ru' => '+7(499)455-08-70',
	// 	'kp-koledino.ru' => '+7(499)455-08-70',
	// 	'kp-skurygino.ru' => '+7(499)455-08-70',
	// 	'kp-bityagovo.ru' => '+7(499)455-08-70',
	// 	'uzhnye-ozera.ru' => '+7(499)504-98-09',
	// 	'svyataja-gora.ru' => '+7(499)504-98-09',
	// 	'uzhny-park.ru' => '+7(499)455-08-70',
	// 	'borodino-kp.ru' => '+7(499)455-08-70',
	// 	'dolyna-ozer.ru' => '+7(499)288-74-81',
	// 	'sohinki-igs.ru' => '+7(499)504-98-09',
	// ];
	//
	// $hlblock_id = 23; // id HL
	// $hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
	// $entity = HL\HighloadBlockTable::compileEntity($hlblock);
	// $entity_data_class = $entity->getDataClass();
	//
	// foreach ($arPhones as $key => $value) {
	// 	$arData = [
	// 		'UF_NAME' => $key,
	// 		'UF_PHONE' => $value,
	// 	];
	// 	// $result = $entity_data_class::add($arData);
	// }
	//
	// $site = 'borodino-kp.ru';
	// $arElHL = getElHL(23,['ID'=>'desc'],['UF_NAME'=>$site],['ID','UF_PHONE']);
	// $phoneSite = array_values($arElHL)[0]['UF_PHONE'];
	// dump($phoneSite);

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
echo 'ok_VPS';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
