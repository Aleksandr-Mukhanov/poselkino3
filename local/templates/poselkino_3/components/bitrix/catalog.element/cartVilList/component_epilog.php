<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $templateData
 * @var array $arParams
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

global $APPLICATION;

$APPLICATION->SetPageProperty("title",$arResult['SEO_TITLE']);
$APPLICATION->SetPageProperty('description', $arResult['SEO_DESCRIPTION']);
?>
