<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<ul class="footer-nav">

<?
foreach($arResult as $arItem):
	if ($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) continue;
	$current = ($arItem["SELECTED"]) ? 'is-current' : '';
?>

	<li class="footer-nav__item"><a class="footer-nav__link <?=$current?>" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></li>

<?endforeach?>

</ul>
<?endif?>
