<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
echo 'parsing<br>';

// запрос к сайту
function getPageHtml($url,$ref = "https://google.com/")
{
	return @file_get_contents($url, false, StreamContext($ref));
}

function StreamContext($ref='')
{
	if($ref!=''){
		$Referer = "Referer: $ref\r\n";
	}else{
		$Referer = '';
	}
	$opts = array(
		"ssl"=>array(
			"verify_peer"       => false,
			"verify_peer_name"  => false,
		),
		'http'=>array(
			'method'=>"GET",
			'header'=>"User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/74.0.3729.169 Safari/537.36"."\r\n" .
			          "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8" . "\r\n".
			          $Referer.
			          "Connection: close" . "\r\n"
		)
	);
	return stream_context_create($opts);
}

// урл сайта донора
// $url = "https://www.svoya-zemlya.ru/catalog/dachi/";
// // xpatch к данным для парсинга
// $Price_xpath = "//a[@class='pos-itm']";
//
// $page = getPageHtml($url);
// $data_page = new DOMDocument();
// @$data_page->loadHTML($page);
//
// $xpath_price = new DOMXPath($data_page);
// $pars_prices = $xpath_price->query($Price_xpath);
// $cntElements = $pars_prices->length;
//
// $_price = $pars_prices->item(19);
// dump($cntElements);
//
// for($i=0;$i<$cntElements;$i++){ // пройдемся по ценам
//
//   $_price = $pars_prices->item($i);
//   foreach ($_price->attributes as $key => $value) {
//     if ($key == 'href') {
//       $villageURL = $value->value;
//       dump($villageURL);
//       $page = getPageHtml('https://www.svoya-zemlya.ru'.$villageURL);
//       $data_page = new DOMDocument();
//       @$data_page->loadHTML($page);
//
//       $Price_xpath = "//span[@class='sdc-r-descr-2 sdc-r-price pink']";
//       $xpath_price = new DOMXPath($data_page);
//       $pars_prices2 = $xpath_price->query($Price_xpath);
//       dump($pars_prices2);
//     }
//   }
//
// }
