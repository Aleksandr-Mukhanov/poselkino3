<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Контакты");?>
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
				<div class="col-sm-12">
					<h1 class="mt-5 mt-sm-0"><?$APPLICATION->ShowTitle(false);?></h1>
					<address class="mt-4 mt-sm-5" itemscope itemtype="http://schema.org/Organization">
						<p itemprop="name">Посёлкино</p>
						<p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">Адрес: г. <span itemprop="addressLocality">Москва</span>, <span itemprop="streetAddress">м. Ленинский проспект, ул. Орджоникидзе 11с11, офис 809</span></p>
						<p>График работы: пн-пт с 10:00 до 18:00</p>
						<p>E-mail: <a href="mailto:welcome@poselkino.ru" itemprop="email">welcome@poselkino.ru</a></p>
						<p>ОГРНИП 314503420200018</p>
					</address>
					<iframe src="https://yandex.ru/map-widget/v1/?z=12&ol=biz&oid=64228142818" width="100%" height="400" frameborder="0"></iframe>
				</div>
			</div>
		</div>
	</div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
