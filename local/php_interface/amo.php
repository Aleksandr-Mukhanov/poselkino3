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

	#Формируем ссылку для запроса
	$link='https://d7825718.amocrm.ru'.$url;

	$curl=curl_init(); #Устанавливаем необходимые опции для сеанса cURL
	curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
	curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-API-client/1.0');
	curl_setopt($curl,CURLOPT_URL,$link);
	curl_setopt($curl,CURLOPT_CUSTOMREQUEST,'POST');
	curl_setopt($curl,CURLOPT_POSTFIELDS,json_encode($arPostFields));
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
	  die('Ошибка передачи в АМО: '.$E->getMessage().PHP_EOL.'Код ошибки: '.$E->getCode());
	}
	/*
	 Данные получаем в формате JSON, поэтому, для получения читаемых данных,
	 нам придётся перевести ответ в формат, понятный PHP
	 */
	$Response=json_decode($out,true); //dump($Response);
	return $Response;
}
?>
