<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Вакансии");
if (in_array($_SERVER['HTTP_HOST'],SITES_DIR)) header('Location: https://poselkino.ru/vakansii/');
?>
<main class="page page-contacts">
	<div class="bg-white">
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
		<div class="container my-5">
			<div class="row">
				<div class="col-12">
					<h1><?$APPLICATION->ShowTitle(false);?></h1>
					<div class="textPage">
						<p>1) Помощник менеджера по продажам загородной недвижимости (возможна удаленная работа)</p>
						<p>2) Менеджер по показам загородной недвижимости</p>
						<p>Резюме отправляйте на почту dm@poselkino.ru</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
