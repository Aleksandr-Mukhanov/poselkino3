<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Карта сайта");
// if (in_array($_SERVER['HTTP_HOST'],SITES_DIR)) header('Location: /sitemap/');

use Bitrix\Main\Loader;
	Loader::includeModule('iblock');
	Loader::includeModule('highloadblock');
use Bitrix\Seo\SitemapTable;
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

// получим поселки
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>1,"ACTIVE"=>"Y");
$arSelect = Array("ID","NAME","DETAIL_PAGE_URL","PROPERTY_TYPE");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext())
	$arPoselki[] = $arElement;

// получим страницы блога
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>3,"ACTIVE"=>"Y");
$arSelect = Array("ID","NAME","DETAIL_PAGE_URL");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while ($arElement = $rsElements->GetNext())
	$arBlog[] = $arElement;
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
		<div class="container my-3 sitemap">
			<h1><?$APPLICATION->ShowTitle(false);?></h1>
			<div class="row">
				<div class="col-md-4 col-sm-12">
					<h3 class="font-GPB">Поселки</h3>
					<div class="links-item houses-item">
				    <div class="item">
				      <ul>
								<?foreach ($arPoselki as $key => $value) {?>
									<li><a href="<?=$value['DETAIL_PAGE_URL']?>"><?=$value['PROPERTY_TYPE_VALUE']?> <?=$value['NAME']?></a></li>
									<?if($key == 150 || $key == 300)echo'</ul></div><div class="item"><ul>';?>
								<?}?>
				      </ul>
				    </div>
				  </div>
				</div>
				<div class="col-md-4 col-sm-12">
					<h3 class="font-GPB">Шоссе</h3>
				  <div class="links-item houses-item">
				    <div class="item">
				      <ul>
				        <?$propEnums = CIBlockPropertyEnum::GetList(
				          ["SORT"=>"ASC","VALUE"=>"ASC"],
				          ["IBLOCK_ID"=>1,"CODE"=>"SHOSSE"]
				        );
				        while($enumFields = $propEnums->GetNext()){ // dump($enumFields);
				          $arShosse[$enumFields['XML_ID']] = $enumFields['VALUE'];
				        }
				        $i = 0;
				        $cntDiv = count($arShosse) / 3;?>
				        <?foreach ($arShosse as $key => $value): $i++;?>
				          <li><a href="/poselki/<?=$key?>-shosse/"><?=$value?></a></li>
				          <?if($i > ($cntDiv - 1)){
				            echo '</ul></div><div class="item"><ul>';
				            $i = 0;
				          }?>
				        <?endforeach;?>
				      </ul>
				    </div>
				  </div>

					<h3 class="font-GPB">Районы</h3>
				  <div class="links-item houses-item">
				    <div class="item">
				      <ul>
				        <?$propEnums = CIBlockPropertyEnum::GetList(
				          ["SORT"=>"ASC","VALUE"=>"ASC"],
				          ["IBLOCK_ID"=>1,"CODE"=>"REGION"]
				        );
				        while($enumFields = $propEnums->GetNext()){ // dump($enumFields);
				          $arRegion[$enumFields['XML_ID']] = $enumFields['VALUE'];
				        }
				        $i = 0;
				        $cntDiv = count($arRegion) / 3;?>
				        <?foreach ($arRegion as $key => $value): $i++;?>
				          <li><a href="/poselki/<?=$key?>-rayon/"><?=$value?></a></li>
				          <?if($i > ($cntDiv - 1)){
				            echo '</ul></div><div class="item"><ul>';
				            $i = 0;
				          }?>
				        <?endforeach;?>
				      </ul>
				    </div>
				  </div>

					<h3 class="font-GPB">От МКАД</h3>
				  <div class="links-item houses-item">
				    <div class="item">
				      <ul>
				        <?$i = 0;
				        for($x=10; $x<=80; $x+=5){ $i++;?>
				          <li><a href="/poselki/do-<?=$x?>-km-ot-mkad/">до <?=$x?> км</a></li>
				          <?if($i == 6){
				            echo '</ul></div><div class="item"><ul>';
				            $i = 0;
				          }?>
				        <?}?>
				        <li><a href="/poselki/do-100-km-ot-mkad/">до 100 км</a></li>
				        <li><a href="/poselki/do-120-km-ot-mkad/">до 120 км</a></li>
				      </ul>
				    </div>
				  </div>

					<h3 class="font-GPB">Цена</h3>
				  <div class="links-item houses-item">
				    <div class="item">
				      <ul>
				        <li><a href="/kupit-uchastki/do-100-tys-rub/">Участки 100 тыс руб</a></li>
				        <li><a href="/kupit-uchastki/do-150-tys-rub/">Участки 150 тыс руб</a></li>
				        <li><a href="/kupit-uchastki/do-200-tys-rub/">Участки 200 тыс руб</a></li>
				        <li><a href="/kupit-uchastki/do-300-tys-rub/">Участки 300 тыс руб</a></li>
				        <li><a href="/kupit-uchastki/do-400-tys-rub/">Участки 400 тыс руб</a></li>
				        <li><a href="/kupit-uchastki/do-500-tys-rub/">Участки 500 тыс руб</a></li>
				        <li><a href="/kupit-uchastki/do-600-tys-rub/">Участки 600 тыс руб</a></li>
				        <li><a href="/kupit-uchastki/do-700-tys-rub/">Участки 700 тыс руб</a></li>
				        <li><a href="/kupit-uchastki/do-1-mln-rub/">Участки 1 млн руб</a></li>
				        <li><a href="/kupit-uchastki/do-1,5-mln-rub/">Участки 1,5 млн руб</a></li>
				        <li><a href="/kupit-uchastki/do-2-mln-rub/">Участки 2 млн руб</a></li>
				        <li><a href="/kupit-uchastki/do-3-mln-rub/">Участки 3 млн руб</a></li>
				        <li><a href="/kupit-uchastki/do-4-mln-rub/">Участки 4 млн руб</a></li>
				        <li><a href="/kupit-uchastki/do-5-mln-rub/">Участки 5 млн руб</a></li>
				      </ul>
				    </div>
				    <div class="item">
				      <ul>
				        <li><a href="/kupit-dom/do-1-mln-rub/">Дома 1 млн руб</a></li>
				        <li><a href="/kupit-dom/do-1,5-mln-rub/">Дома 1,5 млн руб</a></li>
				        <li><a href="/kupit-dom/do-2-mln-rub/">Дома 2 млн руб</a></li>
				        <li><a href="/kupit-dom/do-3-mln-rub/">Дома 3 млн руб</a></li>
				        <li><a href="/kupit-dom/do-4-mln-rub/">Дома 4 млн руб</a></li>
				        <li><a href="/kupit-dom/do-5-mln-rub/">Дома 5 млн руб</a></li>
				        <li><a href="/kupit-dom/do-6-mln-rub/">Дома 6 млн руб</a></li>
				        <li><a href="/kupit-dom/do-7-mln-rub/">Дома 7 млн руб</a></li>
				        <li><a href="/kupit-dom/do-8-mln-rub/">Дома 8 млн руб</a></li>
				        <li><a href="/kupit-dom/do-9-mln-rub/">Дома 9 млн руб</a></li>
				        <li><a href="/kupit-dom/do-10-mln-rub/">Дома 10 млн руб</a></li>
				        <li><a href="/kupit-dom/do-15-mln-rub/">Дома 15 млн руб</a></li>
				        <li><a href="/kupit-dom/do-20-mln-rub/">Дома 20 млн руб</a></li>
				        <li><a href="/kupit-dom/do-30-mln-rub/">Дома 30 млн руб</a></li>
				      </ul>
				    </div>
				  </div>

					<h3 class="font-GPB">Площадь</h3>
				  <div class="links-item houses-item">
				    <div class="item">
				      <ul>
				        <?for ($i=2; $i <= 20; $i++) { // участки?>
				          <?if($i == 2 || $i == 3 || $i == 4){
				            $nameSot = 'сотки'; $urlSot = 'sotki';
				          }else{
				            $nameSot = 'соток'; $urlSot = 'sotok';
				          }?>
				          <li><a href="/kupit-uchastki/<?=$i?>-<?=$urlSot?>/">Участок <?=$i?> <?=$nameSot?></a></li>
				        <?}?>
				        <li><a href="/kupit-uchastki/25-sotok/">Участок 25 соток</a></li>
				      <?for ($i=30; $i <= 100; $i+=10) {?>
				        <?if($i == 40)echo '</ul></div><div class="item"><ul>';?>
				        <li><a href="/kupit-uchastki/<?=$i?>-sotok/">Участок <?=$i?> соток</a></li>
				      <?}?>
				        <?for ($i=2; $i <= 20; $i++) { // дома?>
				          <?if($i == 2 || $i == 3 || $i == 4){
				            $nameSot = 'сотки'; $urlSot = 'sotki';
				          }else{
				            $nameSot = 'соток'; $urlSot = 'sotok';
				          }?>
				          <li><a href="/kupit-dom/na-<?=$i?>-sotkah/">Дом на <?=$i?> сотках</a></li>
				          <?if($i == 15)echo '</ul></div><div class="item"><ul>';?>
				        <?}?>
				          <li><a href="/kupit-dom/na-25-sotkah/">Дом на 25 сотках</a></li>
				        <?for ($i=30; $i <= 100; $i+=10) {?>
				          <li><a href="/kupit-dom/na-<?=$i?>-sotkah/">Дом на <?=$i?> сотках</a></li>
				        <?}?>
				        <li><a href="/kupit-dom/100-kv-m/">Купить дом 100 кв.м.</a></li>
				        <li><a href="/kupit-dom/120-kv-m/">Купить дом 120 кв.м.</a></li>
				        <li><a href="/kupit-dom/150-kv-m/">Купить дом 150 кв.м.</a></li>
				        <li><a href="/kupit-dom/200-kv-m/">Купить дом 200 кв.м.</a></li>
				        <li><a href="/kupit-dom/250-kv-m/">Купить дом 250 кв.м.</a></li>
				        <li><a href="/kupit-dom/300-kv-m/">Купить дом 300 кв.м.</a></li>
				        <li><a href="/kupit-dom/400-kv-m/">Купить дом 400 кв.м.</a></li>
				        <li><a href="/kupit-dom/500-kv-m/">Купить дом 500 кв.м.</a></li>
				      </ul>
				    </div>
				  </div>

					<h3 class="font-GPB">Класс</h3>
				  <div class="links-item houses-item">
				    <div class="item">
				      <ul>
				        <li><a href="/poselki/econom-class/">Эконом класса</a></li>
				        <li><a href="/poselki/biznes-class/">Бизнес класса</a></li>
				        <li><a href="/poselki/komfort-class/">Комфорт класса</a></li>
				        <li><a href="/poselki/elit-class/">Элитного класса</a></li>
				        <li><a href="/poselki/premium-class/">Премиум класса</a></li>
				      </ul>
				    </div>
				    <div class="item">
				      <ul>
				        <li><a href="/kupit-uchastki/econom-class/">Участки эконом класса</a></li>
				        <li><a href="/kupit-uchastki/biznes-class/">Участки бизнес класса</a></li>
				        <li><a href="/kupit-uchastki/komfort-class/">Участки комфорт класса</a></li>
				        <li><a href="/kupit-uchastki/elit-class/">Участки элитного класса</a></li>
				        <li><a href="/kupit-uchastki/premium-class/">Участки премиум класса</a></li>
				      </ul>
				    </div>
				    <div class="item">
				      <ul>
				        <li><a href="/kupit-dom/econom-class/">Дома эконом класса</a></li>
				        <li><a href="/kupit-dom/biznes-class/">Дома бизнес класса</a></li>
				        <li><a href="/kupit-dom/komfort-class/">Дома комфорт класса</a></li>
				        <li><a href="/kupit-dom/elit-class/">Дома элитного класса</a></li>
				        <li><a href="/kupit-dom/premium-class/">Дома премиум класса</a></li>
				      </ul>
				    </div>
				  </div>

					<h3 class="font-GPB">Коммуникации</h3>
				  <div class="links-item houses-item">
				    <div class="item">
				      <ul>
				        <li><a href="/poselki/s-elektrichestvom/">Поселки с электричеством</a></li>
				        <li><a href="/poselki/s-vodoprovodom/">Поселки с водопроводом</a></li>
				        <li><a href="/poselki/s-gazom/">Поселки с газом</a></li>
				        <li><a href="/poselki/s-kommunikaciyami/">Поселки с коммуникациями</a></li>
				      </ul>
				    </div>
				    <div class="item">
				      <ul>
				        <li><a href="/kupit-uchastki/s-elektrichestvom/">Участки с электричеством</a></li>
				        <li><a href="/kupit-uchastki/s-vodoprovodom/">Участки с водопроводом</a></li>
				        <li><a href="/kupit-uchastki/s-gazom/">Участки с газом</a></li>
				        <li><a href="/kupit-uchastki/s-kommunikaciyami/">Участки с коммуникациями</a></li>
				      </ul>
				    </div>
				    <div class="item">
				      <ul>
				        <li><a href="/kupit-dom/s-elektrichestvom/">Дома с электричеством</a></li>
				        <li><a href="/kupit-dom/s-vodoprovodom/">Дома с водопроводом</a></li>
				        <li><a href="/kupit-dom/s-gazom/">Дома с газом</a></li>
				        <li><a href="/kupit-dom/s-kommunikaciyami/">Дома с коммуникациями</a></li>
				      </ul>
				    </div>
				  </div>

					<h3 class="font-GPB">Инфраструктура</h3>
				  <div class="links-item houses-item">
				    <div class="item">
				      <ul>
				        <li><a href="/poselki/snt/">Поселки СНТ</a></li>
				        <li><a href="/poselki/izhs/">Поселки ИЖС</a></li>
				        <li><a href="/poselki/ryadom-zhd-stanciya/">Поселки рядом с Ж/Д станцией</a></li>
				        <li><a href="/poselki/ryadom-avtobusnaya-ostanovka/">Поселки с автобусной остановкой</a></li>
				      </ul>
				    </div>
				    <div class="item">
				      <ul>
				        <li><a href="/kupit-uchastki/snt/">Участки СНТ</a></li>
				        <li><a href="/kupit-uchastki/izhs/">Участки ИЖС</a></li>
				        <li><a href="/kupit-uchastki/ryadom-zhd-stanciya/">Участки рядом с Ж/Д станцией</a></li>
				      </ul>
				    </div>
				    <div class="item">
				      <ul>
				        <li><a href="/kupit-dom/snt/">Дома СНТ</a></li>
				        <li><a href="/kupit-dom/izhs/">Дома ИЖС</a></li>
				        <li><a href="/kupit-dom/ryadom-zhd-stanciya/">Дома рядом с Ж/Д станцией</a></li>
				      </ul>
				    </div>
				  </div>

					<h3 class="font-GPB">Природа</h3>
				  <div class="links-item houses-item">
				    <div class="item">
				      <ul>
				        <li><a href="/poselki/ryadom-s-lesom/">Поселки рядом с лесом</a></li>
				        <li><a href="/poselki/u-vody/">Поселки у воды</a></li>
				        <li><a href="/poselki/u-ozera/">Поселки у озера</a></li>
				        <li><a href="/poselki/u-reki/">Поселки у реки</a></li>
				      </ul>
				    </div>
				    <div class="item">
				      <ul>
				        <li><a href="/kupit-uchastki/ryadom-s-lesom/">Участки рядом с лесом</a></li>
				        <li><a href="/kupit-uchastki/u-vody/">Участки у воды</a></li>
				        <li><a href="/kupit-uchastki/u-ozera/">Участки у озера</a></li>
				        <li><a href="/kupit-uchastki/u-reki/">Участки у реки</a></li>
				      </ul>
				    </div>
				    <div class="item">
				      <ul>
				        <li><a href="/kupit-dom/ryadom-s-lesom/">Дома рядом с лесом</a></li>
				        <li><a href="/kupit-dom/u-vody/">Дома у воды</a></li>
				        <li><a href="/kupit-dom/u-ozera/">Дома у озера</a></li>
				        <li><a href="/kupit-dom/u-reki/">Дома у реки</a></li>
				      </ul>
				    </div>
				  </div>

					<h3 class="font-GPB">Девелоперы</h3>
					<div class="links-item houses-item">
				    <div class="item">
				      <ul>
								<li><a href="/developery/">Все девелоперы</a></li>
							<? // получим девелоперов
								$hlblock_id = 5; // id HL
								$hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
								$entity = HL\HighloadBlockTable::compileEntity($hlblock);
								$entity_data_class = $entity->getDataClass();
								$entity_table_name = $hlblock['TABLE_NAME'];
								$sTableID = 'tbl_'.$entity_table_name;

								$rsData = $entity_data_class::getList([
								  'filter' => ['*'],
								  'select' => ['UF_XML_ID','UF_NAME'],
								]);
								$rsData = new CDBResult($rsData, $sTableID);

								while ($arRes = $rsData->Fetch()) { // dump($arRes);?>
									<li><a href="/developery/<?=$arRes['UF_XML_ID']?>/"><?=$arRes['UF_NAME']?></a></li>
								<?}?>
							</ul>
						</div>
					</div>

					<h3 class="font-GPB">Остальное</h3>
				  <div class="links-item houses-item">
				    <div class="item">
				      <ul>
				        <li><a href="/poselki/kottedzhnye/">Коттеджные поселки</a></li>
				        <li><a href="/poselki/kupit-kottedzhnyj-uchastok/">Купить коттеджный участок</a></li>
				        <li><a href="/poselki/kupit-kottedzh/">Купить коттедж</a></li>
				        <li><a href="/kupit-dom/">Купить дом</a></li>
				      </ul>
				    </div>
				    <div class="item">
				      <ul>
				        <li><a href="/poselki/dachnye/">Дачные поселки</a></li>
				        <li><a href="/poselki/kupit-dachnyj-uchastok/">Купить дачный участок</a></li>
				        <li><a href="/poselki/kupit-dachnyj-dom/">Купить дачный дом</a></li>
				        <li><a href="/kupit-uchastki/">Купить участок</a></li>
				      </ul>
				    </div>
				  </div>

					<h3 class="font-GPB">Другие страницы</h3>
					<div class="links-item houses-item">
				    <div class="item">
				      <ul>
				        <li><a href="/">Главная</a></li>
				        <li><a href="/test/">Тест</a></li>
				        <li><a href="/kontakty/">Контакты</a></li>
				        <li><a href="/izbrannoe/">Избранное</a></li>
				      </ul>
				    </div>
				    <div class="item">
				      <ul>
				        <li><a href="/reklama/">Реклама</a></li>
				        <li><a href="/o-proekte/">О проекте</a></li>
				        <li><a href="/polzovatelskoe-soglashenie/">Пользовательское соглашение</a></li>
				        <li><a href="/politika-konfidentsialnosti/">Политика обработки персональных данных</a></li>
				      </ul>
				    </div>
				    <div class="item">
				      <ul>
				        <li><a href="/blog/">Блог</a></li>
				        <li><a href="/blog?tag=novosti">Новости</a></li>
				        <li><a href="/blog?tag=pro-uchastki">Про участки</a></li>
								<li><a href="/blog?tag=pro-doma">Про дома</a></li>
								<li><a href="/blog?tag=obzor-rynka">Обзор рынка</a></li>
				      </ul>
				    </div>
				  </div>

					<h3 class="font-GPB">Статьи блога</h3>
					<div class="links-item houses-item">
				    <div class="item">
				      <ul>
								<?foreach ($arBlog as $key => $value) {?>
									<li><a href="<?=$value['DETAIL_PAGE_URL']?>"><?=$value['NAME']?></a></li>
									<?if($key == 1 || $key == 3)echo'</ul></div><div class="item"><ul>';?>
								<?}?>
				      </ul>
				    </div>
				  </div>

				</div>
				<div class="col-md-4 col-sm-12">

					<h3 class="font-GPB">Теги</h3>
					<div class="links-item houses-item">
				    <div class="item">
				      <ul>
					<? // сформируем теги
					// шоссе до МКАД и газ
						foreach ($arShosse as $shosse => $value) {
							for ($i=10; $i < 60; $i+=10) { // до МКАД
								?>
								<li><a href="/kupit-uchastki/<?=$shosse?>-shosse-do-<?=$i?>-km-mkad/">Купить участок <?=$value?> шоссе до <?=$i?> км от МКАД</a></li>
								<li><a href="/kupit-dom/<?=$shosse?>-shosse-do-<?=$i?>-km-mkad/">Купить дом <?=$value?> шоссе до <?=$i?> км от МКАД</a></li>
								<li><a href="/poselki/<?=$shosse?>-shosse-do-<?=$i?>-km-mkad/">Поселки <?=$value?> шоссе до <?=$i?> км от МКАД</a></li>
							<?}?>
							<li><a href="/kupit-uchastki/<?=$shosse?>-shosse-gaz/">Купить участок <?=$value?> шоссе с газом</a></li>
							<li><a href="/kupit-dom/<?=$shosse?>-shosse-gaz/">Купить дом <?=$value?> шоссе с газом</a></li>
							<li><a href="/poselki/<?=$shosse?>-shosse-gaz/">Поселки <?=$value?> шоссе с газом</a></li>
						<?}?>
							</ul>
						</div>
					</div>
					<div class="links-item houses-item">
				    <div class="item">
				      <ul>
					<?// район до МКАД и газ
						foreach ($arRegion as $rayon => $value) {?>
							<li><a href="/kupit-uchastki/<?=$rayon?>-rayon-gaz/">Купить участок <?=$value?> район с газом</a></li>
							<li><a href="/kupit-dom/<?=$rayon?>-rayon-gaz/">Купить дом <?=$value?> район с газом</a></li>
							<li><a href="/poselki/<?=$rayon?>-rayon-gaz/">Поселки <?=$value?> с газом</a></li>
						<?}?>
							</ul>
						</div>
					</div>
					<div class="links-item houses-item">
						<div class="item">
							<ul>
					<?// до МКАД газ
						for ($i=10; $i < 60; $i+=10) {?>
							<li><a href="/kupit-uchastki/gaz-do-<?=$i?>-km-mkad/">Купить участок с газом до <?=$i?> км от МКАД</a></li>
							<li><a href="/kupit-dom/gaz-do-<?=$i?>-km-mkad/">Купить дом с газом до <?=$i?> км от МКАД</a></li>
							<li><a href="/poselki/gaz-do-<?=$i?>-km-mkad/">Поселки с газом до <?=$i?> км от МКАД</a></li>
						<?}?>
							</ul>
						</div>
					</div>
					<div class="links-item houses-item">
						<div class="item">
							<ul>
					<?// до МКАД ИЖС
						for ($i=10; $i < 60; $i+=10) {?>
							<li><a href="/kupit-uchastki/do-<?=$i?>-km-mkad-izhs/">Купить участок до <?=$i?> км от МКАД ИЖС</a></li>
							<li><a href="/kupit-dom/do-<?=$i?>-km-mkad-izhs/">Купить дом до <?=$i?> км от МКАД ИЖС</a></li>
							<li><a href="/poselki/do-<?=$i?>-km-mkad-izhs/">Поселки до <?=$i?> км от МКАД ИЖС</a></li>
						<?}?>
							</ul>
						</div>
					</div>
					<div class="links-item houses-item">
						<div class="item">
							<ul>
					<?// стоимость
						$onlyShosse = ['dmitrovskoe','novoryazanskoe','simferopolskoe','novorijskoe'];
						$urlPriceShosse = [
						 'do-100-tysyach',
						 'do-150-tysyach',
						 'do-200-tysyach',
						 'do-300-tysyach',
						 'do-400-tysyach',
						 'do-500-tysyach',
						 'do-600-tysyach',
						 'do-700-tysyach',
						 'do-1-milliona',
						 'do-1,5-milliona',
						 'do-2-milliona',
						 'do-3-milliona',
						 'do-4-milliona',
						 'do-5-milliona',
						 'do-1-milliona',
						 'do-1,5-milliona',
						 'do-2-milliona',
						 'do-3-milliona',
						 'do-4-milliona',
						 'do-5-milliona',
						 'do-6-milliona',
						 'do-7-milliona',
						 'do-8-milliona',
						 'do-9-milliona',
						 'do-10-milliona',
						 'do-15-milliona',
						 'do-20-milliona',
						 'do-30-milliona',
						];
						$noUrlPriceShosse = [
						 'do-100-tysyach',
					 	 'do-150-tysyach',
					 	 'do-200-tysyach',
					 	 'do-300-tysyach',
					 	 'do-400-tysyach',
					 	 'do-500-tysyach',
					 	 'do-600-tysyach',
					 	 'do-700-tysyach',
						];

						foreach ($urlPriceShosse as $price) {
							foreach ($onlyShosse as $shosse) {?>
								<li><a href="/kupit-uchastki/<?=$shosse?>-shosse-<?=$price?>/">Купить участок <?=$value?> шоссе <?=$price?></a></li>
								<?if(!in_array($price,$noUrlPriceShosse)){?>
									<li><a href="/kupit-dom/<?=$shosse?>-shosse-<?=$price?>/">Купить дом <?=$value?> шоссе <?=$price?></a></li>
								<?}
							}
						}?>
							</ul>
						</div>
					</div>
					<div class="links-item houses-item">
						<div class="item">
							<ul>
					<?
					// коммуникации и шоссе
						$commun2 = ['svet','voda','gaz','kommunikatsii','ryadom-s-lesom','u-vody','izhs','snt'];
						$commun3 = ['svet','voda','gaz','kommunikatsii'];
						$communName = ['со светом','с водой','с газом','с коммуникациями','рядом с лесом','у воды','ИЖС','СНТ'];

						foreach ($commun2 as $key => $commun) {
							foreach ($onlyShosse as $shosse) {?>
								<li><a href="/kupit-uchastki/<?=$shosse?>-shosse-<?=$commun?>/">Купить участок <?=$value?> шоссе <?=$communName[$key]?></a></li>
								<li><a href="/kupit-dom/<?=$shosse?>-shosse-<?=$commun?>/">Купить дом <?=$value?> шоссе <?=$communName[$key]?></a></li>
								<li><a href="/poselki/<?=$shosse?>-shosse-<?=$commun?>/">Поселки <?=$value?> шоссе <?=$communName[$key]?></a></li>
							<?}
						}?>
							</ul>
						</div>
					</div>
					<div class="links-item houses-item">
						<div class="item">
							<ul>
					<?
					// коммуникации и МКАД
						foreach ($commun3 as $key => $commun) {
							for ($i=10; $i < 60; $i+=10) { // до МКАД?>
								<li><a href="/kupit-uchastki/<?=$commun?>-do-<?=$i?>-km-mkad/">Купить участок <?=$communName[$key]?> до <?=$i?> км от МКАД</a></li>
								<li><a href="/kupit-dom/<?=$commun?>-do-<?=$i?>-km-mkad/">Купить дом <?=$communName[$key]?> до <?=$i?> км от МКАД</a></li>
								<li><a href="/poselki/<?=$commun?>-do-<?=$i?>-km-mkad/">Поселки <?=$communName[$key]?> до <?=$i?> км от МКАД</a></li>
							<?}
						}
					?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
