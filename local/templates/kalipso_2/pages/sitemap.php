<?
$APPLICATION->SetPageProperty('description','Карта сайта для коттеджного поселка '.$arVillage['NAME']);
?>
<section class="page">
  <div class="container page__container">
		<h1 class="title--size_1 section-title page__title infrastructure__title">Карта сайта</h1>
		<?$APPLICATION->IncludeComponent(
			"bitrix:main.map",
			"",
			Array(
				"CACHE_TIME" => "3600",
				"CACHE_TYPE" => "A",
				"COL_NUM" => "1",
				"COMPOSITE_FRAME_MODE" => "A",
				"COMPOSITE_FRAME_TYPE" => "AUTO",
				"LEVEL" => "3",
				"SET_TITLE" => "Y",
				"SHOW_DESCRIPTION" => "N"
			)
		);?>
	</div>
</section>
