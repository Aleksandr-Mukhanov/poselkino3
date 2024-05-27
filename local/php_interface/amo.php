<?
// авторизация в АМО
function authInAmo(){

	$user=array(
		'USER_LOGIN'=>'d7825718@yandex.ru', #Логин
		'USER_HASH'=>'30d117318cb1728ba949457b89ab48dc60f4e70a' #Хэш для доступа к API
	);
	$url = '/private/api/auth.php?type=json';

	#Формируем ссылку для запроса
	$link='https://d7825718.amocrm.ru'.$url;

	$curl=curl_init(); #Устанавливаем необходимые опции для сеанса cURL
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
	curl_setopt($curl,CURLOPT_URL,$link);
	curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
	curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($user));
	curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
	curl_setopt($curl,CURLOPT_HEADER,false);
	curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
	curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
	$out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
	$code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
	curl_close($curl); #Завершаем сеанс cURL
	/* Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
	$code=(int)$code;
	$errors=array(
	  301=>'Moved permanently',
	  400=>'Bad request',
	  401=>'Unauthorized',
	  403=>'Forbidden',
	  404=>'Not found',
	  500=>'Internal server error',
	  502=>'Bad gateway',
	  503=>'Service unavailable'
	);
	try{
	  #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
	  if($code!=200 && $code!=204)
		throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
	}catch(Exception $E){
	  die('Ошибка авторизации AMO: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
	}
	/*
	 Данные получаем в формате JSON, поэтому, для получения читаемых данных,
	 нам придётся перевести ответ в формат, понятный PHP
	 */
	$Response=json_decode($out,true);
	//dump($Response);
	$Response=$Response['response'];
	if(isset($Response['auth'])) #Флаг авторизации доступен в свойстве "auth"
	 return 1; // Авторизация прошла успешно
	return 0; // Авторизация не удалась
}

// $authAmoResult = authInAmo(); // результат авторизации в АМО
// echo "Авторизация в АМО: ".$authAmoResult;

// передача в амо
function inAmo($arPostFields,$url){

	$authAmoResult = authInAmo(); // результат авторизации в АМО
	if ($authAmoResult != 1) echo ($authAmoResult);

	$accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQ2OTU5NGI1ZDA0ZDE3MTZlNmY4ZjcwMDZhYjJhMDI2OGY4MDc1MTQyODM0OGJiYzkwMjM2OTlkNmM3MjNmZDZlYjM1M2FjNDU2MzkyY2JjIn0.eyJhdWQiOiJkYzk5MjI2MC0zMjViLTRjYmQtOWUxMy1iMTJlYjk2OWFmYjUiLCJqdGkiOiJkNjk1OTRiNWQwNGQxNzE2ZTZmOGY3MDA2YWIyYTAyNjhmODA3NTE0MjgzNDhiYmM5MDIzNjk5ZDZjNzIzZmQ2ZWIzNTNhYzQ1NjM5MmNiYyIsImlhdCI6MTcxMzk2OTg5MiwibmJmIjoxNzEzOTY5ODkyLCJleHAiOjE3NDg2NDk2MDAsInN1YiI6IjM1ODQwNjIiLCJncmFudF90eXBlIjoiIiwiYWNjb3VudF9pZCI6Mjg1MzQ3OTgsImJhc2VfZG9tYWluIjoiYW1vY3JtLnJ1IiwidmVyc2lvbiI6Miwic2NvcGVzIjpbImNybSIsImZpbGVzIiwiZmlsZXNfZGVsZXRlIiwibm90aWZpY2F0aW9ucyIsInB1c2hfbm90aWZpY2F0aW9ucyJdLCJoYXNoX3V1aWQiOiI0NjkwN2M1ZS01OGE4LTRmMzctYjczNS1hYWRkMWYxOWM5ZTkifQ.TQmMKmTzF0FybkKpPdbnhB3_06HqdprKX2tBwe2mp0K2j9KJS64u1F2BGcZT1ur7EqnAtFS29POuqF6cjUV_HC_WKge8MQ_Vw3-t0wIHWNF5zevzmzP4QeU0kfq7nPeqzARXCEFhwOzrtApQ2R7SZ8RcfhU7Z-R_gqfhc5u2ldH_yI-ZCACrXit70OXNoi5XgxgC-UDhNx7TGU0HEULbTv4L6Y3Pdj-HNTTu3w3xsiKwoqeeCOrGcsgN2-PnScT58MHURwHELLJAopJKMLhe5k9nEvzZJLNAA2POtdD0_OgQukhLhn9uMXagoxz_u-hVGSwpsqwinM9Lry1ksh-MTg';

	$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken,
	];

	#Формируем ссылку для запроса
	$link='https://d7825718.amocrm.ru'.$url;

	$curl=curl_init(); #Устанавливаем необходимые опции для сеанса cURL
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
	curl_setopt($curl,CURLOPT_URL,$link);
	curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
	curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($arPostFields));
	curl_setopt($curl,CURLOPT_HTTPHEADER,array('Content-Type: application/json'));
	// curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
	curl_setopt($curl,CURLOPT_HEADER,false);
	curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
	curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
	$out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
	$code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
	curl_close($curl); #Завершаем сеанс cURL
	/* Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
	$code=(int)$code;
	$errors=array(
	  301=>'Moved permanently',
	  400=>'Bad request',
	  401=>'Unauthorized',
	  403=>'Forbidden',
	  404=>'Not found',
	  500=>'Internal server error',
	  502=>'Bad gateway',
	  503=>'Service unavailable'
	);
	try{
	  #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
	  if($code!=200 && $code!=204)
		throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
	}catch(Exception $E){
	  die('Ошибка передачи в АМО: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
	}
	/*
	 Данные получаем в формате JSON, поэтому, для получения читаемых данных,
	 нам придётся перевести ответ в формат, понятный PHP
	 */
	$Response=json_decode($out,true); //dump($Response);
	return $Response;
}

// передача в АМО v4 вторая интеграция
function inAmoV4Test($arPostFields,$url){

	$accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImRlMzA3ZWQzMmY0MDQ5ZWJlNzkwODBlOTg5N2IwZGNiMDZiZWNhZWRiNTU0OWM0OWIyOWU1YThlMTlkNTA4NTc4NGU2MTE4YzEzMDVhZDgzIn0.eyJhdWQiOiJkYmM0Yjg1Zi1lZDEwLTQzZTgtOGUwMi01N2I2YTA4NWE1NDUiLCJqdGkiOiJkZTMwN2VkMzJmNDA0OWViZTc5MDgwZTk4OTdiMGRjYjA2YmVjYWVkYjU1NDljNDliMjllNWE4ZTE5ZDUwODU3ODRlNjExOGMxMzA1YWQ4MyIsImlhdCI6MTcxNjI5OTU3OSwibmJmIjoxNzE2Mjk5NTc5LCJleHAiOjE4MTE3MjE2MDAsInN1YiI6IjM1ODQwNjIiLCJncmFudF90eXBlIjoiIiwiYWNjb3VudF9pZCI6Mjg1MzQ3OTgsImJhc2VfZG9tYWluIjoiYW1vY3JtLnJ1IiwidmVyc2lvbiI6Miwic2NvcGVzIjpbImNybSIsImZpbGVzIiwiZmlsZXNfZGVsZXRlIiwibm90aWZpY2F0aW9ucyIsInB1c2hfbm90aWZpY2F0aW9ucyJdLCJoYXNoX3V1aWQiOiIwNjhhMjQzZS0xYjU4LTQ0Y2ItYmZhZS02M2NmZmI0YmU4MDcifQ.lTz2Y8VmGVlWVlAY3KrQ_BxZ3LdoX7l81EQeC8LYEostDZsPwyL6XbG9Ym9cI5czX0nWxnq9Gty5BPAoox4PSrHZSRpFGhJHn4BVN2dSgd0jO7XhVZueDqNvZnFHayPEJJ8sxhzLExrqpbLyLP6zu2m27TNrDOI6wZkglDZdK_f6vl-qxcPEGEXyUl5CB_bKvPL65xv17T1KWiXnYoXzUcsPA_K1AZf61MQ29ds5_uw55sOg7rG7mMaS04DIycd0cguHPwCRMV3KnE_Dscmf5-T4vY8E9fmezC6l2HgJmSsQLWwAdCQ-jhmxmQxgOXiVUfU6faFqvLJINYLmCC49RQ';

	$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken,
	];

	#Формируем ссылку для запроса
	$link='https://d7825718.amocrm.ru'.$url;

	$curl=curl_init(); #Устанавливаем необходимые опции для сеанса cURL
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
	curl_setopt($curl,CURLOPT_URL,$link);
	curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
	curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($arPostFields));
	curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
	curl_setopt($curl,CURLOPT_HEADER,false);
	curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
	curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
	$out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
	// dump($link);
	// dump($out);
	$code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
	// dump($code);
	curl_close($curl); #Завершаем сеанс cURL
	/* Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
	$code=(int)$code;
	$errors=array(
	  301=>'Moved permanently',
	  400=>'Bad request',
	  401=>'Unauthorized',
	  403=>'Forbidden',
	  404=>'Not found',
	  500=>'Internal server error',
	  502=>'Bad gateway',
	  503=>'Service unavailable'
	);
	try{
	  #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
	  if($code!=200 && $code!=204)
		throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
	}catch(Exception $E){
		// $arInfo = [
		// 	'url' => $url,
		// 	'date' => date('d.m.Y H:i:s'),
		// ];
		// $fp = fopen('/var/www/u0428181/data/www/olne.ru/amo-log.txt', 'a+');
		// fwrite($fp,'Инфо: '.var_export($arInfo, true)."\r\n");
		// fwrite($fp,'Запрос: '.var_export($arPostFields, true)."\r\n");
		// fwrite($fp,'Ответ: '.var_export($out, true)."\r\n");
		// fwrite($fp,'Код: '.var_export($code, true)."\r\n\r\n\r\n");
		// fclose($fp);
	  // die('Ошибка передачи в АМОv4: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
	}
	/*
	 Данные получаем в формате JSON, поэтому, для получения читаемых данных,
	 нам придётся перевести ответ в формат, понятный PHP
	 */
	$Response=json_decode($out,true); //dump($Response);
	return $Response;
}

// передача в АМО v4
function inAmoV4($arPostFields,$url){

	$accessToken = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsImp0aSI6ImQ2OTU5NGI1ZDA0ZDE3MTZlNmY4ZjcwMDZhYjJhMDI2OGY4MDc1MTQyODM0OGJiYzkwMjM2OTlkNmM3MjNmZDZlYjM1M2FjNDU2MzkyY2JjIn0.eyJhdWQiOiJkYzk5MjI2MC0zMjViLTRjYmQtOWUxMy1iMTJlYjk2OWFmYjUiLCJqdGkiOiJkNjk1OTRiNWQwNGQxNzE2ZTZmOGY3MDA2YWIyYTAyNjhmODA3NTE0MjgzNDhiYmM5MDIzNjk5ZDZjNzIzZmQ2ZWIzNTNhYzQ1NjM5MmNiYyIsImlhdCI6MTcxMzk2OTg5MiwibmJmIjoxNzEzOTY5ODkyLCJleHAiOjE3NDg2NDk2MDAsInN1YiI6IjM1ODQwNjIiLCJncmFudF90eXBlIjoiIiwiYWNjb3VudF9pZCI6Mjg1MzQ3OTgsImJhc2VfZG9tYWluIjoiYW1vY3JtLnJ1IiwidmVyc2lvbiI6Miwic2NvcGVzIjpbImNybSIsImZpbGVzIiwiZmlsZXNfZGVsZXRlIiwibm90aWZpY2F0aW9ucyIsInB1c2hfbm90aWZpY2F0aW9ucyJdLCJoYXNoX3V1aWQiOiI0NjkwN2M1ZS01OGE4LTRmMzctYjczNS1hYWRkMWYxOWM5ZTkifQ.TQmMKmTzF0FybkKpPdbnhB3_06HqdprKX2tBwe2mp0K2j9KJS64u1F2BGcZT1ur7EqnAtFS29POuqF6cjUV_HC_WKge8MQ_Vw3-t0wIHWNF5zevzmzP4QeU0kfq7nPeqzARXCEFhwOzrtApQ2R7SZ8RcfhU7Z-R_gqfhc5u2ldH_yI-ZCACrXit70OXNoi5XgxgC-UDhNx7TGU0HEULbTv4L6Y3Pdj-HNTTu3w3xsiKwoqeeCOrGcsgN2-PnScT58MHURwHELLJAopJKMLhe5k9nEvzZJLNAA2POtdD0_OgQukhLhn9uMXagoxz_u-hVGSwpsqwinM9Lry1ksh-MTg';

	$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer ' . $accessToken,
	];

	#Формируем ссылку для запроса
	$link='https://d7825718.amocrm.ru'.$url;

	$curl=curl_init(); #Устанавливаем необходимые опции для сеанса cURL
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
	curl_setopt($curl,CURLOPT_URL,$link);
	curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
	curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($arPostFields));
	curl_setopt($curl,CURLOPT_HTTPHEADER,$headers);
	curl_setopt($curl,CURLOPT_HEADER,false);
	curl_setopt($curl,CURLOPT_COOKIEFILE,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
	curl_setopt($curl,CURLOPT_COOKIEJAR,dirname(__FILE__).'/cookie.txt'); #PHP>5.3.6 dirname(__FILE__) -> __DIR__
	curl_setopt($curl,CURLOPT_SSL_VERIFYPEER,0);
	curl_setopt($curl,CURLOPT_SSL_VERIFYHOST,0);
	$out=curl_exec($curl); #Инициируем запрос к API и сохраняем ответ в переменную
	$code=curl_getinfo($curl,CURLINFO_HTTP_CODE); #Получим HTTP-код ответа сервера
	curl_close($curl); #Завершаем сеанс cURL
	/* Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
	$code=(int)$code;
	$errors=array(
	  301=>'Moved permanently',
	  400=>'Bad request',
	  401=>'Unauthorized',
	  403=>'Forbidden',
	  404=>'Not found',
	  500=>'Internal server error',
	  502=>'Bad gateway',
	  503=>'Service unavailable'
	);
	try{
	  #Если код ответа не равен 200 или 204 - возвращаем сообщение об ошибке
	  if($code!=200 && $code!=204)
		throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undescribed error',$code);
	}catch(Exception $E){

		inAmoV4Test($arPostFields,$url);

		$arInfo = [
			'url' => $url,
			'date' => date('d.m.Y H:i:s'),
		];
		$fp = fopen('/var/www/u0428181/data/www/olne.ru/amo-log.txt', 'a+');
		fwrite($fp,'Инфо: '.var_export($arInfo, true)."\r\n");
		fwrite($fp,'Запрос: '.var_export($arPostFields, true)."\r\n");
		fwrite($fp,'Ответ: '.var_export($out, true)."\r\n");
		fwrite($fp,'Код: '.var_export($code, true)."\r\n\r\n\r\n");
		fclose($fp);
	  // die('Ошибка передачи в АМОv4: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
	}
	/*
	 Данные получаем в формате JSON, поэтому, для получения читаемых данных,
	 нам придётся перевести ответ в формат, понятный PHP
	 */
	$Response=json_decode($out,true); //dump($Response);
	return $Response;
}
