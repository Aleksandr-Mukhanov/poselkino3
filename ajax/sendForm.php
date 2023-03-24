<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
	Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

	$ourForm = $_POST['ourForm'];
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

	if($ourForm == 'ToUs'){ // Написать нам

		$mailFields = array(
			"name" => $name,
			"tel" => $tel,
			"email" => $email,
			"mes" => $mes,
		);
		if (CEvent::Send("SENT_TO_US", "s1", $mailFields)) mesOk("Сообщение успешно отправлено!");
		else mesEr("Error: ".$el->LAST_ERROR);

	}elseif($ourForm == 'SignToView'){ // Записаться на просмотр

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
		switch ($highway) {
			case 'Дмитровское':
				$toEmail = '89645358935@bk.ru';
				$toPhone = '+7 (964) 535-89-35';
				break;
			case 'Рогачевское':
				$toEmail = '89645358935@bk.ru';
				$toPhone = '+7 (964) 535-89-35';
				break;
			case 'Ленинградское':
				$toEmail = '89645358935@bk.ru';
				$toPhone = '+7 (964) 535-89-35';
				break;
			case 'Пятницкое':
				$toEmail = 'andrey1761300@ya.ru';
				$toPhone = '+7 (926) 176-13-00';
				break;
			case 'Волоколамское':
				$toEmail = 'andrey1761300@ya.ru';
				$toPhone = '+7 (926) 176-13-00';
				break;
			case 'Новорижское':
				$toEmail = 'andrey1761300@ya.ru';
				$toPhone = '+7 (926) 176-13-00';
				break;
			case 'Ильинское':
				$toEmail = 'andrey1761300@ya.ru';
				$toPhone = '+7 (926) 176-13-00';
				break;
			case 'Рублевское':
				$toEmail = 'andrey1761300@ya.ru';
				$toPhone = '+7 (926) 176-13-00';
				break;
			case 'Горьковское':
				$toEmail = '7611911@gmail.com';
				$toPhone = '+7 (931) 888-85-08';
				break;
			case 'Щелковское':
				$toEmail = '7611911@gmail.com';
				$toPhone = '+7 (931) 888-85-08';
				break;
			case 'Носовихинское':
				$toEmail = '7611911@gmail.com';
				$toPhone = '+7 (931) 888-85-08';
				break;
			case 'Егорьевское':
				$toEmail = 'rosstroi2013@yandex.ru';
				$toPhone = '+7 (905) 587-70-94';
				break;
			case 'Новорязанское':
				$toEmail = 'rosstroi2013@yandex.ru';
				$toPhone = '+7 (905) 587-70-94';
				break;
			case 'Каширское':
				$toEmail = 'Dmitriy_alex86@mail.ru';
				$toPhone = '+7 (925) 566-59-78';
				break;
			case 'Симферопольское':
				$toEmail = 'Liya.Shvec@inbox.ru';
				$toPhone = '+7 (977) 308-97-81';
				break;
			case 'Варшавское':
				$toEmail = 'Liya.Shvec@inbox.ru';
				$toPhone = '+7 (977) 308-97-81';
				break;
			case 'Калужское':
				$toEmail = 'Liya.Shvec@inbox.ru';
				$toPhone = '+7 (977) 308-97-81';
				break;
			case 'Киевское':
				$toEmail = 'Liya.Shvec@inbox.ru';
				$toPhone = '+7 (977) 308-97-81';
				break;

			default:
				$toEmail = 'start@poselkino.ru';
				$toPhone = '+7 (926) 108-73-32';
				break;
		}

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
			"page" => $_SERVER['HTTP_REFERER'],
			"toEmail" => $toEmail,
		);
		if (CEvent::Send("SEND_TO_VIEW", $siteId, $mailFields)) mesOk("Ваша заявка успешно отправлена!<br /> Представитель поселка свяжется с Вами в самое ближайшее время)");
		else mesEr("Error: ".$el->LAST_ERROR);

		// обновим счетчик UP_TO_VIEW
		$cntPos = ($_POST['cntPos']) ? $_POST['cntPos'] : 0;
		$idEl = $_POST['idPos'];
		$IBLOCK_ID = 1;
		$PROPERTY_VAL = $cntPos + 1;
		$PROPERTY_CODE = "UP_TO_VIEW";
		CIBlockElement::SetPropertyValues($idEl, $IBLOCK_ID, $PROPERTY_VAL, $PROPERTY_CODE);

		// передадим в АМО
		$arLead['add'] = [
			[
				'name' => $name.' ('.$namePos.') - с сайта', // имя сделки
				'status_id' => '28709515', // статус 'Новый лид'
				'created_at' => time(),
				'custom_fields' => [
					[
						'id' => 650157, // Девелопер
						'values' => [
							[
								'value' => $_POST['develName']
							]
						]
					],
				]
			]
		];

		$url = "/api/v2/leads";
		$resultAmo = inAmo($arLead,$url);
		$requestId = $resultAmo['_embedded']['items'][0]['id'];

		// создадим контакт в АМО
		$arCont['add'] = [
			[
				'name' => $name, // имя контакта
				'leads_id' => [$requestId],
				'created_at' => time(),
				'custom_fields' => [
					[
						'id' => 426347, // Телефон
						'values' => [
							[
								'value' => $tel,
								'enum' => 600995 // Раб. тел.
							]
						]
					],
				]
			]
		];
		$url = "/api/v2/contacts";
		$resultAmo = inAmo($arCont,$url); //dump($resultAmo);

		// отправим смс менеджеру
		$textSMS = 'Вам пришли заявка на почту, зарегистрируйте клиента!';
		sendSMS($toPhone,$textSMS);

	}elseif($ourForm == 'Subscribe'){ // Подписка

		$mailFields = array(
			"email" => $email,
		);
		if (CEvent::Send("SUBSCRIPTION", "s1", $mailFields)) mesOk("Вы успешно подписаны!");
		else mesEr("Error: ".$el->LAST_ERROR);

	}elseif($ourForm == 'SendReview'){ // Добавление отзыва

		// добавляем элемент
		\Bitrix\Main\Loader::includeModule('iblock');
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
				"PAGE" => $_SERVER['HTTP_REFERER']
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
