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
				<div class="col-xl-5 col-lg-6 col-sm-5">
					<div class="rounded page-contacts__img d-flex justify-content-center align-items-center"><img src="/assets/img/site/contacts-img.svg" alt></div>
				</div>
				<div class="offset-xl-1 col-lg-6 col-sm-7">
					<h1 class="mt-5 mt-sm-0"><?$APPLICATION->ShowTitle(false);?></h1>
					<address class="mt-4 mt-sm-5" itemscope itemtype="http://schema.org/Organization">
						<p itemprop="name">Посёлкино</p>
						<p itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">Адрес: Московская обл., г. <span itemprop="addressLocality">Балашиха</span>, <span itemprop="streetAddress">проспект Ленина, 32Д</span></p>
						<p>E-mail: <a href="mailto:welcome@poselkino.ru" itemprop="email">welcome@poselkino.ru</a></p>
						<p>ОГРНИП 314503420200018</p>
					</address>
				</div>
			</div>
		</div>
	</div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
