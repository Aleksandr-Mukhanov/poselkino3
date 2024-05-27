<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
	Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

$ourForm = $_POST['ourForm'];
$formName = $_POST['formName'];
$name = $_POST['name'];
$tel = $_POST['tel'];
$email = $_POST['email'];
$mes = $_POST['mes'];
$namePos = $_POST['namePos'];
$highway = $_POST['highway'];
$codePos = $_POST['codePos'];
$subject = $_POST['subject'];
$captcha_code = $_POST['captcha_code'];
$captcha_word = $_POST['captcha_word'];
$manager = $_POST['manager'];
$urlPage = $_POST['url'];
$fromPage = $_SERVER['HTTP_REFERER'];

if ($ourForm == 'ToUs') // Написать нам
{
	$mailFields = array(
		"name" => $name,
		"tel" => $tel,
		"email" => $email,
		"mes" => $mes,
		"page" => $fromPage,
	);
	if (CEvent::Send("SENT_TO_US", "s1", $mailFields)) mesOk("Сообщение успешно отправлено!");
	else mesEr("Error: ".$el->LAST_ERROR);
}
elseif($ourForm == 'OrderLend') // Заявки с лендинга
{
	$mailFields = array(
		"lend" => $formName,
		"name" => $name,
		"tel" => $tel,
		"page" => $fromPage,
	);
	if (CEvent::Send("SEND_ORDER_LEND", "s1", $mailFields)) mesOk("Сообщение успешно отправлено!");
	else mesEr("Error: ".$el->LAST_ERROR);
}
elseif($ourForm == 'SignToView') // Записаться на просмотр
{
	// блокировка заявок по E-mail
	$arElHL = getElHL(11,[],[],['*']);
	foreach ($arElHL as $value)
		$arEmails[] = $value['UF_EMAIL'];

	if (!in_array($email,$arEmails))
	{
		// получим E-mail девелопера
		$hlblock_id = 5; // id HL
		$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
		$entity = HL\HighloadBlockTable::compileEntity($hlblock);
		$entity_data_class = $entity->getDataClass();
		$entity_table_name = $hlblock['TABLE_NAME'];
		$sTableID = 'tbl_'.$entity_table_name;

		$rsData = $entity_data_class::getList([
			'filter' => ['UF_XML_ID' => $_POST['develId']],
			'select' => ['ID','UF_EMAIL'],
		]);
		$rsData = new CDBResult($rsData, $sTableID);

		if($arRes = $rsData->Fetch()){ // dump($arRes);
			foreach ($arRes['UF_EMAIL'] as $uf_email) {
				$emailDevel = ($emailDevel) ? $emailDevel.','.trim($uf_email) : trim($uf_email);
			}
		}

		$siteId = ($_POST['siteId']) ? $_POST['siteId'] : 's1';

		// разбивка по шоссе
		// switch ($highway) {
		// 	case 'Дмитровское':
		// 		$toEmail = 's-lozovaya@yandex.ru';
		// 		$toPhone = '+7 (901) 505-41-01';
		// 		$responsibleUserId = '8542930'; // Светлана Лозовая
		// 		break;
		// 	case 'Рогачёвское':
		// 		$toEmail = 's-lozovaya@yandex.ru';
		// 		$toPhone = '+7 (901) 505-41-01';
		// 		$responsibleUserId = '8542930'; // Светлана Лозовая
		// 		break;
		// 	case 'Осташковское':
		// 		$toEmail = 'gomuleckaya@mail.ru';
		// 		$toPhone = '+7 (968) 396-13-34';
		// 		$responsibleUserId = '8076100'; // Александра
		// 		break;
		// 	case 'Ленинградское':
		// 		$toEmail = 's-lozovaya@yandex.ru';
		// 		$toPhone = '+7 (901) 505-41-01';
		// 		$responsibleUserId = '8542930'; // Светлана Лозовая
		// 		break;
		// 	case 'Пятницкое':
		// 		$toEmail = 's-lozovaya@yandex.ru';
		// 		$toPhone = '+7 (901) 505-41-01';
		// 		$responsibleUserId = '8542930'; // Светлана Лозовая
		// 		break;
		// 	case 'Волоколамское':
		// 		$toEmail = 'alexa_morozova30@mail.ru';
		// 		$toPhone = '+7 (985) 224-03-04';
		// 		$responsibleUserId = '7244824'; // Александра М.
		// 		break;
		// 	case 'Новорижское':
		// 		$toEmail = 'alexa_morozova30@mail.ru';
		// 		$toPhone = '+7 (985) 224-03-04';
		// 		$responsibleUserId = '7244824'; // Александра М.
		// 		break;
		// 	case 'Минское':
		// 		$toEmail = '7825718@mail.ru';
		// 		$toPhone = '+7 (926) 108-73-32';
		// 		$responsibleUserId = '3584062'; // Дима Маслов
		// 		break;
		// 	// case 'Ильинское':
		// 	// 	$toEmail = 'sobolevau75@gmail.com';
		// 	// 	$toPhone = '+7 (916) 742-03-01';
		// 	// 	$responsibleUserId = '3584062'; // Юлия С. / Дмитрий
		// 	// 	break;
		// 	// case 'Рублевское':
		// 	// 	$toEmail = 'sobolevau75@gmail.com';
		// 	// 	$toPhone = '+7 (916) 742-03-01';
		// 	// 	$responsibleUserId = '3584062'; // Юлия С. / Дмитрий
		// 	// 	break;
		// 	case 'Горьковское':
		// 		$toEmail = 'a.pishchikova1@mail.ru';
		// 		$toPhone = '+7 (963) 674-84-61';
		// 		$responsibleUserId = '7913857'; // Айнура
		// 		break;
		// 	case 'Щелковское':
		// 		$toEmail = 'a.pishchikova1@mail.ru';
		// 		$toPhone = '+7 (963) 674-84-61';
		// 		$responsibleUserId = '7913857'; // Айнура
		// 		break;
		// 	case 'Носовихинское':
		// 		$toEmail = 'a.pishchikova1@mail.ru';
		// 		$toPhone = '+7 (963) 674-84-61';
		// 		$responsibleUserId = '7913857'; // Айнура
		// 		break;
		// 	case 'Егорьевское':
		// 		$toEmail = 'a.pishchikova1@mail.ru';
		// 		$toPhone = '+7 (963) 674-84-61';
		// 		$responsibleUserId = '7913857'; // Айнура
		// 		break;
		// 	case 'Новорязанское':
		// 		$toEmail = 'syusin.al@yandex.ru';
		// 		$toPhone = '+7 (963) 674-84-61';
		// 		$responsibleUserId = '7818886'; // Александр
		// 		break;
		// 	case 'Каширское':
		// 		$toEmail = 'a.pishchikova1@mail.ru';
		// 		$toPhone = '+7 (963) 674-84-61';
		// 		$responsibleUserId = '7913857'; // Айнура
		// 		break;
		// 	case 'Симферопольское':
		// 		$toEmail = 'alexa_morozova30@mail.ru';
		// 		$toPhone = '+7 (985) 224-03-04';
		// 		$responsibleUserId = '7244824'; // Александра М.
		// 		break;
		// 	case 'Варшавское':
		// 		$toEmail = 'alexa_morozova30@mail.ru';
		// 		$toPhone = '+7 (985) 224-03-04';
		// 		$responsibleUserId = '7244824'; // Александра М.
		// 		break;
		// 	case 'Калужское':
		// 		$toEmail = 'alexa_morozova30@mail.ru';
		// 		$toPhone = '+7 (985) 224-03-04';
		// 		$responsibleUserId = '7244824'; // Александра М.
		// 		break;
		// 	// case 'Киевское':
		// 	// 	$toEmail = 'sobolevau75@gmail.com';
		// 	// 	$toPhone = '+7 (916) 742-03-01';
		// 	// 	$responsibleUserId = '3584062'; // Юлия С. / Дмитрий
		// 	// 	break;
		// 	case 'Ярославское':
		// 		$toEmail = 's-lozovaya@yandex.ru';
		// 		$toPhone = '+7 (901) 505-41-01';
		// 		$responsibleUserId = '8542930'; // Светлана Лозовая
		// 		break;
		//
		// 	default:
		// 		$toEmail = 'start@poselkino.ru';
		// 		$toPhone = '+7 (926) 108-73-32';
		// 		break;
		// }

		// распределение менеджерам по шоссе
		$arElHL = getElHL(16,[],[],['ID','UF_NAME','UF_MANAGER']);
		foreach ($arElHL as $value)
			$arHighway[$value['UF_NAME']] = $value['UF_MANAGER'];

		if ($manager) // менеджер у поселка
		{
			$arElHL = getElHL(13,[],['UF_XML_ID'=>$manager],['*']);
			$arManager = array_values($arElHL)[0];
			if ($arManager['UF_EMAIL']) $toEmail = $arManager['UF_EMAIL'];
			if ($arManager['UF_PHONE']) $toPhone = $arManager['UF_PHONE'];
			if ($arManager['UF_AMO_ID']) $responsibleUserId = $arManager['UF_AMO_ID'];
		}
		elseif ($arHighway[$highway]) // менеджер у шоссе
		{
			$arElHL = getElHL(13,[],['ID'=>$arHighway[$highway]],['*']);
			$arManager = array_values($arElHL)[0];
			if ($arManager['UF_EMAIL']) $toEmail = $arManager['UF_EMAIL'];
			if ($arManager['UF_PHONE']) $toPhone = $arManager['UF_PHONE'];
			if ($arManager['UF_AMO_ID']) $responsibleUserId = $arManager['UF_AMO_ID'];
		}

		if (!$toEmail) $toEmail = defaultEmail;
		if (!$toPhone) $toPhone = defaultPhone;
		if (!$responsibleUserId) $responsibleUserId = defaultAmoID;

		$mailFields = array(
			"name" => $name,
			"tel" => $tel,
			"email" => $email,
			"namePos" => $namePos,
			"codePos" => $codePos,
			"highway" => $highway,
			"subject" => $subject,
			"develId" => $_POST['develId'],
			"develName" => $_POST['develName'],
			"phoneDevel" => $_POST['phoneDevel'],
			"emailDevel" => $emailDevel,
			"page" => $fromPage,
			"toEmail" => $toEmail,
		);

		$whoContact = (strpos($fromPage,'/blog/') !== false) ? 'Наш эксперт' : 'Представитель поселка';

		if (CEvent::Send("SEND_TO_VIEW", $siteId, $mailFields)) mesOk("Ваша заявка успешно отправлена!<br /> ".$whoContact." свяжется с Вами в самое ближайшее время)");
		else mesEr("Error: ".$el->LAST_ERROR);

		// отправим смс менеджеру
		$textSMS = 'Вам пришли заявка на почту, зарегистрируйте клиента! Телефон: '.$tel;
		sendSMS($toPhone,$textSMS);

		// обновим счетчик UP_TO_VIEW
		$cntPos = ($_POST['cntPos']) ? $_POST['cntPos'] : 0;
		$idEl = $_POST['idPos'];
		$IBLOCK_ID = 1;
		$PROPERTY_VAL = $cntPos + 1;
		$PROPERTY_CODE = "UP_TO_VIEW";
		CIBlockElement::SetPropertyValues($idEl, $IBLOCK_ID, $PROPERTY_VAL, $PROPERTY_CODE);

		$leadName = ($_POST['formID'] == 'sale') ? $name.' ('.$namePos.') скидка - с сайта' : $name.' ('.$namePos.') - с сайта';

		if (strpos($fromPage,'/kupit-uchastki/') !== false)
			$leadName = $name.' ('.$namePos.') участки — с сайта';
		elseif ($_POST['formID'] == 'sale_poselkino')
			$leadName = $name.' ('.$namePos.') скидка Поселкино — с сайта';
		elseif ($_POST['formID'] == 'blog_poselkino')
			$leadName = $name.' ('.$namePos.') блог Поселкино — с сайта';

		// передадим в АМО
		$arLead = [
			[
				'name' => $leadName, // имя сделки
				// 'status_id' => '28709515', // статус 'Новый лид'
				'responsible_user_id' => (int)$responsibleUserId,
				// 'created_at' => time(),
				'custom_fields_values' => [
					[
						'field_id' => 650157, // Девелопер
						'values' => [
							[
								'value' => $_POST['develName']
							]
						]
					],
				],
				'_embedded' => [
					'contacts' => [
						[
							'name' => $name, // имя контакта
							'responsible_user_id' => (int)$responsibleUserId,
							'custom_fields_values' => [
								[
									"field_code" => "PHONE",
									"values" => [
										[
											"enum_code" => "WORK",
											"value" => $tel
										]
									]
								],
							]
						]
					]
				]
			]
		];

		$url = "/api/v4/leads/complex";
		$resultAmo = inAmoV4($arLead,$url);

		// добавим в админку
		$hlblock_id = 24; // id HL
		$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
		$entity = HL\HighloadBlockTable::compileEntity($hlblock);
		$entity_data_class = $entity->getDataClass();

		$arData =[
			"UF_NAME" => $name,
			"UF_PHONE" => $tel,
			"UF_VILLAGE" => $namePos,
			"UF_HIGHWAY" => $highway,
			"UF_FORM" => $leadName,
			"UF_DEVELOPER" => $_POST['develName'],
			"UF_PAGE" => $fromPage,
			"UF_M_EMAIL" => $toEmail,
			"UF_M_PHONE" => $toPhone,
			"UF_M_AMO" => $responsibleUserId,
			"UF_DATE" => date('d.m.Y H:i:s')
		];
		$entity_data_class::add($arData);

		// $arLead['add'] = [
		// 	[
		// 		'name' => $leadName, // имя сделки
		// 		'status_id' => '28709515', // статус 'Новый лид'
		// 		'responsible_user_id' => $responsibleUserId,
		// 		'created_at' => time(),
		// 		'custom_fields' => [
		// 			[
		// 				'id' => 650157, // Девелопер
		// 				'values' => [
		// 					[
		// 						'value' => $_POST['develName']
		// 					]
		// 				]
		// 			],
		// 		]
		// 	]
		// ];
		//
		// $url = "/api/v2/leads";
		// $resultAmo = inAmo($arLead,$url);
		// $requestId = $resultAmo['_embedded']['items'][0]['id'];
		//
		// // создадим контакт в АМО
		// $arCont['add'] = [
		// 	[
		// 		'name' => $name, // имя контакта
		// 		'leads_id' => [$requestId],
		// 		'created_at' => time(),
		// 		'custom_fields' => [
		// 			[
		// 				'id' => 426347, // Телефон
		// 				'values' => [
		// 					[
		// 						'value' => $tel,
		// 						'enum' => 600995 // Раб. тел.
		// 					]
		// 				]
		// 			],
		// 		]
		// 	]
		// ];
		// $url = "/api/v2/contacts";
		// $resultAmo = inAmo($arCont,$url); //dump($resultAmo);
	}
}
elseif($ourForm == 'Subscribe') // Подписка
{
	$mailFields = array(
		"email" => $email,
		"page" => $fromPage,
	);
	if (CEvent::Send("SUBSCRIPTION", "s1", $mailFields)) mesOk("Вы успешно подписаны!");
	else mesEr("Error: ".$el->LAST_ERROR);
}
elseif($ourForm == 'SendError') // Отправка ошибки
{
	$mailFields = array(
		"url" => $urlPage,
		"mes" => $mes,
		"page" => $fromPage,
	);
	if (CEvent::Send("SEND_ERROR", "s1", $mailFields)) mesOk("Ошибка успешно отправлена - спасибо!");
	else mesEr("Error: ".$el->LAST_ERROR);
}
elseif ($ourForm == 'SendReview') // Добавление отзыва
{
	// добавляем элемент
	$el = new CIBlockElement;

	$PROP = array();
	$PROP['RATING'] = $_POST['star'];
	$PROP['DIGNITIES'] = $_POST['dignities'];
	$PROP['DISADVANTAGES'] = $_POST['disadvantages'];
	if ($_POST["idPos"]) $PROP['VILLAGE'] = $_POST["idPos"]; // отзыв о поселке
	if ($_POST["codeDevel"]) $PROP['DEVELOPER'] = $_POST["codeDevel"]; // отзыв о девелопере
	$PROP['FIO'] = $_POST['name'].' '.$_POST['fname'];
	$PROP['RESIDENT'] = $_POST['resident'];

	$name = ($_POST["idPos"]) ? 'Отзыв-'.date('d.m.Y H:i:s').'-'.$_POST["idPos"] : 'Отзыв о девелопере-'.date('d.m.Y H:i:s').'-'.$_POST["codeDevel"];

	$arLoadProductArray = Array(
	  "MODIFIED_BY"    => $USER->GetID(), // элемент изменен текущим пользователем
	  "IBLOCK_SECTION_ID" => false,          // элемент лежит в корне раздела
	  "IBLOCK_ID"      => 2,
	  "PROPERTY_VALUES"=> $PROP,
	  "NAME"           => $name,
	  "ACTIVE"         => "N",            // активен
	  "ACTIVE_FROM" => date('d.m.Y H:i:s'),
	  "PREVIEW_TEXT"   => $_POST['comment'],
	  //"DETAIL_PICTURE" => CFile::MakeFileArray($_SERVER["DOCUMENT_ROOT"]."/image.gif")
	);

	if($PRODUCT_ID = $el->Add($arLoadProductArray)){
		 mesOk("<b>Спасибо за ваш отзыв!</b><br>Ваш отзыв отправлен на модерацию. После проверки мы опубликуем его.<br><span style='color:lightgray'>Администрация сайта оставляет за собой право публикации отзыва. Если отзыв содержит рекламную информацию, нецензурную лексику, фальсифицированную информация или информацию, нарушающую законодательство РФ, отзыв не будет размещен на сайте.</span>");
		 $resident = ($_POST['resident']) ? 'Да' : 'Нет';
		 $object = ($_POST['idPos']) ? 'Посёлок: '.$_POST["namePos"] : 'Девелопер: '.$_POST["nameDevel"];
		 // письмо об успешной оплате!
		$mailFields = array(
			"OBJECT" => $object,
			"FIO" => $_POST['name'].' '.$_POST['fname'],
			"EMAIL" => $_POST['email'],
			"RATING" => $_POST['star'],
			"DIGNITIES" => $_POST['dignities'],
			"DISADVANTAGES" => $_POST['disadvantages'],
			"COMMENT" => $_POST['comment'],
			"RESIDENT" => $resident,
			"PAGE" => $fromPage
		);
		CEvent::Send("SEND_OTZIV", "s1", $mailFields);
	}else{
		mesEr("Error: ".$el->LAST_ERROR);
	}
}
elseif($ourForm == 'chekCaptcha') // Проверка капчи
{
	if (!$APPLICATION->CaptchaCheckCode($captcha_word, $captcha_code))
		echo 'no';
	else
		echo 'ok';
}

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/epilog_after.php");?>
