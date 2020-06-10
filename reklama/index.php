<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Реклама и сотрудничество");
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
						<p><b>Если вы официальный представитель поселка, владелец или девелопер</b> и хотите, чтобы ваш поселок был на сайте. Просто напишите нам на почту <a href="mailto:welcome@poselkino.ru">welcome@poselkino.ru</a>. Мы рассмотрим обращение и свяжемся с вами по указанным контактным данным.</p>

						<p><b>Если вы официальный представитель поселка, владелец или девелопер </b>и хотите разместить рекламу на сайте poselkino.ru, напишите на почту <a href="mailto:dm@poselkino.ru">dm@poselkino.ru</a>. Мы предложим вам все доступные рекламные форматы.</p>

						<p><b>Если вы веб-мастер</b> и хотите стать партнером нашего сайта по привлечению трафика, пишите на почту <a href="mailto:dm@poselkino.ru">dm@poselkino.ru</a>, обсудим возможные пути для сотрудничества.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
