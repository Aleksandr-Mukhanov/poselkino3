<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Поиск");
?>
<main class="page page-search">
	<div class="page__breadcrumbs">
		<div class="container">
			<div class="row align-items-center">
				<div class="order-1 order-sm-0 col-xl-5 col-lg-4">
					<?$APPLICATION->IncludeComponent(
						"bitrix:breadcrumb",
						"poselkino",
						array(
							"PATH" => "",
							"SITE_ID" => "s1",
							"START_FROM" => "0",
							"COMPONENT_TEMPLATE" => "poselkino"
						),
						false
					);?>
				</div>
			</div>
		</div>
	</div>
	<div class="page__content-title">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-xl-7 col-lg-6">
          <h1 class="h2">Найденные посёлки <span class="text-secondary"><?$APPLICATION->ShowViewContent('COUNT_POS');?></span></h1>
        </div>
      </div>
    </div>
	</div>
	<?$APPLICATION->IncludeComponent(
		"bitrix:search.page",
		"poselkino",
		array(
			"AJAX_MODE" => "N",
			"AJAX_OPTION_ADDITIONAL" => "",
			"AJAX_OPTION_HISTORY" => "N",
			"AJAX_OPTION_JUMP" => "N",
			"AJAX_OPTION_STYLE" => "Y",
			"CACHE_TIME" => "3600",
			"CACHE_TYPE" => "A",
			"CHECK_DATES" => "N",
			"DEFAULT_SORT" => "rank",
			"DISPLAY_BOTTOM_PAGER" => "Y",
			"DISPLAY_TOP_PAGER" => "N",
			"FILTER_NAME" => "",
			"NO_WORD_LOGIC" => "N",
			"PAGER_SHOW_ALWAYS" => "N",
			"PAGER_TEMPLATE" => "",
			"PAGER_TITLE" => "Результаты поиска",
			"PAGE_RESULT_COUNT" => "50",
			"RESTART" => "Y",
			"SHOW_WHEN" => "N",
			"SHOW_WHERE" => "N",
			"USE_LANGUAGE_GUESS" => "Y",
			"USE_SUGGEST" => "Y",
			"USE_TITLE_RANK" => "Y",
			"arrFILTER" => array(
				0 => "iblock_content",
			),
			"arrWHERE" => array(
				0 => "iblock_content",
			),
			"COMPONENT_TEMPLATE" => "poselkino",
			"TAGS_SORT" => "NAME",
			"TAGS_PAGE_ELEMENTS" => "150",
			"TAGS_PERIOD" => "",
			"TAGS_URL_SEARCH" => "",
			"TAGS_INHERIT" => "Y",
			"FONT_MAX" => "50",
			"FONT_MIN" => "10",
			"COLOR_NEW" => "000000",
			"COLOR_OLD" => "C8C8C8",
			"PERIOD_NEW_TAGS" => "",
			"SHOW_CHAIN" => "Y",
			"COLOR_TYPE" => "Y",
			"WIDTH" => "100%",
			"STRUCTURE_FILTER" => "structure",
			"NAME_TEMPLATE" => "",
			"SHOW_LOGIN" => "Y",
			"SHOW_ITEM_TAGS" => "Y",
			"SHOW_ITEM_DATE_CHANGE" => "Y",
			"SHOW_ORDER_BY" => "Y",
			"SHOW_TAGS_CLOUD" => "N",
			"arrFILTER_iblock_content" => array(
				0 => "1",
			)
		),
		false
	);?>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
