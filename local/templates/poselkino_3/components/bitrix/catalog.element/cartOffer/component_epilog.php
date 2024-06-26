<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

use Bitrix\Main\Loader;

/**
 * @var array $templateData
 * @var array $arParams
 * @var string $templateFolder
 * @global CMain $APPLICATION
 */

global $APPLICATION;

$APPLICATION->SetPageProperty('title',$arResult['SEO_TITLE']);
$APPLICATION->SetPageProperty('description', $arResult['SEO_DESCRIPTION']);

$offerType = $_REQUEST['OFFER_TYPE'];
$offerName = ($offerType == 'plots') ? 'Участок' : 'Дом';
$offerNameM = ($offerType == 'plots') ? 'Участки' : 'Дома';
$offerCodeM = ($offerType == 'plots') ? 'kupit-uchastki' : 'kupit-dom';

$APPLICATION->AddChainItem($offerNameM.' в поселке '.$arResult['VILLAGE_NAME'],'/'.$offerCodeM.'/v-poselke-'.$arResult['VILLAGE_CODE'].'/');
$APPLICATION->AddChainItem($offerName.' '.$arResult['NUMBER'],'');
