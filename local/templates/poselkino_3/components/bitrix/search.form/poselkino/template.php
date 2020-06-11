<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);?>
<form class="search-header" action="<?=$arResult["FORM_ACTION"]?>">
	<?$APPLICATION->IncludeComponent(
		"bitrix:search.suggest.input",
		"",
		array(
			"NAME" => "q",
			"VALUE" => "",
			"INPUT_SIZE" => 15,
			"DROPDOWN_SIZE" => 10,
		),
		$component, array("HIDE_ICONS" => "Y")
	);?>
	<button class="nav-link d-md-none button-submit" name="s" type="submit"><span class="sr-only">Поиск по сайту</span><svg xmlns="http://www.w3.org/2000/svg" width="16.843" height="16.843" viewBox="0 0 16.843 16.843" class="inline-svg">
		<g transform="translate(-11 -11)">
			<path d="M27.637 26.647L23.588 22.6a7.092 7.092 0 1 0-.993.993l4.049 4.046a.7.7 0 0 0 .993-.99zM18.1 23.784a5.687 5.687 0 1 1 5.687-5.684 5.693 5.693 0 0 1-5.687 5.684z" class="search" />
		</g>
	</svg></button>
	<button class="nav-link icon-search" type="button"><span class="sr-only">Поиск по сайту</span><svg xmlns="http://www.w3.org/2000/svg" width="16.843" height="16.843" viewBox="0 0 16.843 16.843" class="inline-svg">
		<g transform="translate(-11 -11)">
			<path d="M27.637 26.647L23.588 22.6a7.092 7.092 0 1 0-.993.993l4.049 4.046a.7.7 0 0 0 .993-.99zM18.1 23.784a5.687 5.687 0 1 1 5.687-5.684 5.693 5.693 0 0 1-5.687 5.684z" class="search" />
		</g>
	</svg></button>
</form>
