<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("404 Not Found");?>
<main class="page page-404 bg-white">
	<div class="container">
		<div class="w-100 text-center error-img page-404"><img src="<?=SITE_TEMPLATE_PATH?>/images/404.png" alt="404">
			<p class="font-weight-bold">Запрашиваемая Вами страница не найдена</p>
			<a class="btn btn--theme_blue" href="/">Вернуться на главную</a>
		</div>
	</div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
