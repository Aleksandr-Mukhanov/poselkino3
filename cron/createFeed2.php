<?php header('Content-Type: text/html; charset=utf-8');
$_SERVER["DOCUMENT_ROOT"] = '/var/www/u0428181/data/www/olne.ru';
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

// получим данные гугл документа
$id = '1hibir8kNvcPkQJkFuwPakmlX-5KlF39WdDpXvX4CY_k';
$gid = '0';

$gDocFile = file_get_contents('https://docs.google.com/spreadsheets/d/'.$id.'/export?format=csv&gid='.$gid);
$gDocFile = explode("\r\n", $gDocFile);
$arFile = array_map('str_getcsv', $gDocFile);

// dump($arFile);

foreach ($arFile as $key => $arStr)
{
	if ($key == 0 || $key == 1) continue; // dump($arStr);
	echo "<pre>";print_r($arStr);echo "</pre>";

	$description = str_replace(['&nbsp;','/n'],' ',$arStr[6]);
	$description = trim(strip_tags($arStr[6]));

	$xml_content .= '<offer internal-id="'.$arStr[0].'">';

    $xml_content .= '<type>'.$arStr[1].'</type>';
    $xml_content .= '<property-type>'.$arStr[2].'</property-type>';
    $xml_content .= '<category>'.$arStr[3].'</category>';
    $xml_content .= '<url>'.$arStr[4].'</url>';
    $xml_content .= '<creation-date>'.$arStr[5].'</creation-date>';
		$xml_content .= '<description>'.$description.'</description>';

    $xml_content .= '<location>';
			$xml_content .= '<address>'.$arStr[7].'</address>';
			$xml_content .= '<latitude>'.$arStr[8].'</latitude>';
			$xml_content .= '<longitude>'.$arStr[9].'</longitude>';
      // $xml_content .= '<country>'.$arStr[7].'</country>';
			// $xml_content .= '<region>'.$arStr[8].'</region>';
      // $xml_content .= '<district>'.$arStr[9].'</district>';
      // $xml_content .= '<locality-name>'.$arStr[10].'</locality-name>';
    $xml_content .= '</location>';

		$xml_content .= '<sales-agent>';
			$xml_content .= '<name>'.$arStr[10].'</name>';
			$xml_content .= '<phone>'.$arStr[11].'</phone>';
			$xml_content .= '<category>'.$arStr[12].'</category>';
		$xml_content .= '</sales-agent>';

    $xml_content .= '<price>';
      $xml_content .= '<value>'.$arStr[13].'</value>';
      $xml_content .= '<currency>'.$arStr[14].'</currency>';
    $xml_content .= '</price>';

		$xml_content .= '<lot-area>';
      $xml_content .= '<value>'.$arStr[15].'</value>';
      $xml_content .= '<unit>'.$arStr[16].'</unit>';
    $xml_content .= '</lot-area>';

		if ($arStr[18]) $xml_content .= '<image>'.$arStr[17].'</image>';
		if ($arStr[19]) $xml_content .= '<image>'.$arStr[18].'</image>';
		if ($arStr[20]) $xml_content .= '<image>'.$arStr[19].'</image>';
		if ($arStr[21]) $xml_content .= '<image>'.$arStr[20].'</image>';

  $xml_content .= '</offer>'; $i++;
}

echo 'Всего: '.$i.'<br>';
// запись в файл
$fp = fopen($_SERVER["DOCUMENT_ROOT"].'/yandex2.xml', 'w+');
$xml = '<?xml version="1.0" encoding="UTF-8"?><realty-feed xmlns="http://webmaster.yandex.ru/schemas/feed/realty/2010-06"><generation-date>'.date('c').'</generation-date>'.$xml_content.'</realty-feed>';
fwrite($fp,$xml);
fclose($fp);
