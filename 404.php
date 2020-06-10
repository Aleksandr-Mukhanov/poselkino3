<?
include_once($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404","Y");

require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

$APPLICATION->SetTitle("404 Not Found");?>
<main class="page page-404 bg-white">
	<div class="container">
		<div class="w-100 text-center error-img page-404"><img src="/assets/img/content/404.png" alt="404">
			<p class="font-weight-bold">Запрашиваемая Вами страница не найдена</p><a class="btn btn-warning btn-lg rounded-pill mt-2" href="/">Вернуться на главную</a>
		</div>
	</div>
	<div class="container">
		<?$APPLICATION->IncludeComponent(
			 "bitrix:main.include",
			 "",
			 Array(
				 "AREA_FILE_SHOW" => "file",
				 "AREA_FILE_SUFFIX" => "inc",
				 "EDIT_TEMPLATE" => "",
				 "PATH" => "/include/block_url.php"
			)
		);?>
	</div>
</main>
<style>
	.bread-cover{
		display: none;
	}
</style>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
