<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Застройщики коттеджных поселков");?>
<main class="page page-developer-list">
	<div class="bg-white page-va-list__info">
		<div class="container">
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
	<div class="bg-white">
		<div class="container">
			<div class="block-page__title">
				<h1 class="h2"><?$APPLICATION->ShowTitle(false);?></h1>
			</div>
		</div>
		<?$APPLICATION->IncludeComponent(
			"bitrix:highloadblock.list",
			"list_developer",
			array(
				"BLOCK_ID" => "5",
				"CHECK_PERMISSIONS" => "N",
				"COMPOSITE_FRAME_MODE" => "A",
				"COMPOSITE_FRAME_TYPE" => "AUTO",
				"DETAIL_URL" => "/developery/#ID#/",
				"FILTER_NAME" => "",
				"PAGEN_ID" => "page",
				"ROWS_PER_PAGE" => "900",
				"SORT_FIELD" => "ID",
				"SORT_ORDER" => "DESC",
				"COMPONENT_TEMPLATE" => "list_developer"
			),
			false
		);?>
	</div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
