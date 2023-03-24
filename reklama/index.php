<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Реклама и сотрудничество");
if (in_array($_SERVER['HTTP_HOST'],SITES_DIR)) header('Location: https://poselkino.ru/reklama/');
?>
<main>
	<div class="container ad__breadcrumb">
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
		<section class="ad__wrap">
			<h1 class="ad__h1"><?$APPLICATION->ShowTitle(false)?></h1>
			<p>Приглашаем к&nbsp;сотрудничеству представителей поселков, застройщиков, девелоперов. Предлагаем несколько видов сотрудничества:</p>
			<div class="benefits">
				<div class="benefits__item">
					<h3 class="ad__h3">Брокеры</h3>
					<ul class="benefits__list">
						<li class="list__item">Продажи</li>
						<li class="list__item">Команда профессиональных брокеров</li>
						<li class="list__item">Покупатели готовые к&nbsp;сделке</li>
						<li class="list__item">Увеличение объема продаж</li>
					</ul>
				</div>
				<div class="benefits__item">
					<h3 class="ad__h3">Сервис Поселкино</h3>
					<ul class="benefits__list">
						<li class="list__item">Реклама и&nbsp;лиды</li>
						<li class="list__item">Эффективный и&nbsp;удобный сервис поиска загородной недвижимости</li>
						<li class="list__item">1&nbsp;000 переходов в&nbsp;день</li>
						<li class="list__item">Ваш проект в&nbsp;ТОПе</li>
						<li class="list__item">Актуальная информация</li>
					</ul>
				</div>
			</div>
			<div class="leg">
				<h2 class="leg__title">Вариант: Брокеры</h2>
				<p class="leg__txt">Мы&nbsp;выступаем брокерами, берем весь процесс продажи на&nbsp;себя</p>
				<ul class="leg__list">
					<li class="leg__list-item">Находим клиентов</li>
					<li class="leg__list-item">Презентуем поселок</li>
					<li class="leg__list-item">Консультируем</li>
					<li class="leg__list-item">Осуществляем показ</li>
					<li class="leg__list-item">Выводим на&nbsp;сделку</li>
				</ul>
				<div class="info">
					<p class="info__txt">Наш отдел продаж насчитывает 15&nbsp;экспертов в&nbsp;загородной недвижимости, каждый
						из&nbsp;менеджеров по&nbsp;показам закреплен за&nbsp;своим шоссе и&nbsp;отлично знает свой район. Команда регулярно проходит обучение по&nbsp;техникам продаж, средняя конверсия из&nbsp;показа в&nbsp;сделку составляет 30%.</p>
				</div>
			</div>
			<div class="leg s-leg">
				<h2 class="leg__title">Вариант: Сервис Поселкино</h2>
				<p class="leg__txt">Платное размещение поселка на&nbsp;сайте и&nbsp;продвижение в&nbsp;ТОП выдачи
					по&nbsp;району и&nbsp;шоссе</p>
				<ul class="leg__list s-leg__list">
					<li class="list__item">Создаем отдельную страницу для вашего объекта на&nbsp;Poselkino.ru</li>
					<li class="list__item">Размещаем подробную информацию о&nbsp;поселке (коммуникации, обустройство, план
						поселка с&nbsp;ценами, юридическая информация, отзывы, поселок на&nbsp;карте)</li>
					<li class="list__item">Добавляем сайт поселка и&nbsp;телефон, чтобы покупатели могли связаться с&nbsp;вами
						напрямую</li>
					<li class="list__item">Обеспечиваем присутствие поселка в&nbsp;ТОП выдачи по&nbsp;релевантному шоссе
						и&nbsp;району</li>
					<li class="list__item">Регулярно обновляем информацию (план поселка, описание)</li>
				</ul>
			</div>
			<div class="ad__center">
				<a href="/upload/КП_Евгения Сюсина.pdf" class="ad__button btn-warning" target="_blank">Скачать предложение</a>
			</div>
		</section>
	</div>
	<section class="textPage ad__textPage">
		<div class="container">
			<p><b>Если вы&nbsp;официальный представитель поселка, владелец или девелопер</b> и&nbsp;хотите, чтобы ваш
				поселок был на&nbsp;сайте. Просто напишите нам на&nbsp;почту <a
					href="mailto:welcome@poselkino.ru">welcome@poselkino.ru</a>. Мы&nbsp;рассмотрим обращение и&nbsp;свяжемся
				с&nbsp;вами по&nbsp;указанным контактным данным.</p>
			<p><b>Если вы&nbsp;официальный представитель поселка, владелец или девелопер </b>и&nbsp;хотите разместить
				рекламу на&nbsp;сайте poselkino.ru, напишите на&nbsp;почту <a
					href="mailto:dm@poselkino.ru">dm@poselkino.ru</a>. Мы&nbsp;предложим вам все доступные рекламные форматы.
			</p>
			<p><b>Если вы&nbsp;веб-мастер</b> и&nbsp;хотите стать партнером нашего сайта по&nbsp;привлечению трафика, пишите
				на&nbsp;почту <a href="mailto:dm@poselkino.ru">dm@poselkino.ru</a>, обсудим возможные пути для сотрудничества.
			</p>
		</div>
	</section>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
