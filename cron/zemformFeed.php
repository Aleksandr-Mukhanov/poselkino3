<?php header('Content-Type: text/html; charset=utf-8');
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

$urlFeed = 'https://zemform.ru/plan/xml/pushkino.xml';

$xmlFeed = file_get_contents($urlFeed);
$arFeed = new SimpleXMLElement($xmlFeed);
