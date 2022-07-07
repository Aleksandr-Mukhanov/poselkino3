<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $templateData
 * @var array $arParams
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

global $APPLICATION;

$APPLICATION->SetPageProperty('title',$arResult['SEO_TITLE']);
$APPLICATION->SetPageProperty('description', $arResult['SEO_DESCRIPTION']);
// $APPLICATION->AddChainItem($nameVil,'/poselki/'.$arResult['CODE'].'/',true);
// $APPLICATION->AddChainItem($arResult['OFFER_TYPE'].' в '.$typePos.' '.$arResult['NAME'],'',true);
// $APPLICATION->AddChainItem($arResult['NAME'],'/poselki/'.$arResult['CODE'].'/',true);
$APPLICATION->AddChainItem($arResult['OFFER_TYPE'].' в поселке '.$arResult['NAME'],'',true);
?>
