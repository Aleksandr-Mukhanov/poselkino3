<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("О проекте");
if (in_array($_SERVER['HTTP_HOST'],SITES_DIR)) header('Location: https://poselkino.ru/o-proekte/');
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
						<p>Поселкино.ру - это сервис поиска загородной недвижимости. На сайте представлены коттеджные и дачные поселки с подробным описанием, рейтингом и отзывами. Сайт является информационным помощником и создан с целью сделать выбор участка или дома удобным и прозрачным. Мы делаем полноценный обзор поселков и предоставляем пользователям следующую информацию:</p>
						<ul>
							<li>видео поселка с квадрокоптера,</li>
							<li>отзывы от жителей поселка,</li>
							<li>регистрационные данные: категория земель, вид разрешенного использования, юридическая форма, ссылка на карту Росреестра,</li>
							<li>стоимость и сроки подключения коммуникаций,</li>
							<li>инфраструктура поселка: на территории поселка и в радиусе 5 км,</li>
							<li>способы добраться общественным транспортом,</li>
							<li>собственный рейтинг и оценки пользователей,</li>
							<li>экология,</li>
							<li>природное окружение,</li>
							<li>дороги до и внутри поселка,</li>
							<li>актуальные цены,</li>
							<li>кол-во реализованных объектов,</li>
							<li>адрес: район, шоссе и удаленность от МКАД,</li>
							<li>фото поселка.</li>
						</ul>
						<p>Вы можете узнать интересующую вас информацию о поселке у нас на сайте. Выбрать загородный дом, дачу или участок, который будет устраивать вас по всем критериям и записаться на просмотр.</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
