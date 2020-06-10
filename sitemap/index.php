<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Карта сайта");
// получим поселки
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>1,"ACTIVE"=>"Y");
$arSelect = Array("ID","NAME","DETAIL_PAGE_URL","PROPERTY_TYPE");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);
	$arPoselki[] = $arElement;
} // dump($arPoselki);
// получим страницы блога
$arOrder = Array("SORT"=>"ASC");
$arFilter = Array("IBLOCK_ID"=>3,"ACTIVE"=>"Y");
$arSelect = Array("ID","NAME","DETAIL_PAGE_URL");
$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
while($arElement = $rsElements->GetNext()){ // dump($arElement);
	$arBlog[] = $arElement;
} // dump($arBlog);
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
					<div class="textPage sitemap">

						<h3>Поселки</h3>
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

						<h3>Шоссе</h3>
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

						<h3>Районы</h3>
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

						<h3>От МКАД</h3>
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

						<h3>Цена</h3>
					  <div class="links-item houses-item">
					    <div class="item">
					      <ul>
					        <li><a href="/poselki/kupit-uchastok-do-100-tys-rub/">Участки 100 тыс руб</a></li>
					        <li><a href="/poselki/kupit-uchastok-do-150-tys-rub/">Участки 150 тыс руб</a></li>
					        <li><a href="/poselki/kupit-uchastok-do-200-tys-rub/">Участки 200 тыс руб</a></li>
					        <li><a href="/poselki/kupit-uchastok-do-300-tys-rub/">Участки 300 тыс руб</a></li>
					        <li><a href="/poselki/kupit-uchastok-do-400-tys-rub/">Участки 400 тыс руб</a></li>
					        <li><a href="/poselki/kupit-uchastok-do-500-tys-rub/">Участки 500 тыс руб</a></li>
					        <li><a href="/poselki/kupit-uchastok-do-600-tys-rub/">Участки 600 тыс руб</a></li>
					        <li><a href="/poselki/kupit-uchastok-do-700-tys-rub/">Участки 700 тыс руб</a></li>
					        <li><a href="/poselki/kupit-uchastok-do-1-mln-rub/">Участки 1 млн руб</a></li>
					        <li><a href="/poselki/kupit-uchastok-do-1,5-mln-rub/">Участки 1,5 млн руб</a></li>
					        <li><a href="/poselki/kupit-uchastok-do-2-mln-rub/">Участки 2 млн руб</a></li>
					        <li><a href="/poselki/kupit-uchastok-do-3-mln-rub/">Участки 3 млн руб</a></li>
					        <li><a href="/poselki/kupit-uchastok-do-4-mln-rub/">Участки 4 млн руб</a></li>
					        <li><a href="/poselki/kupit-uchastok-do-5-mln-rub/">Участки 5 млн руб</a></li>
					      </ul>
					    </div>
					    <div class="item">
					      <ul>
					        <li><a href="/poselki/kupit-dom-do-1-mln-rub/">Дома 1 млн руб</a></li>
					        <li><a href="/poselki/kupit-dom-do-1,5-mln-rub/">Дома 1,5 млн руб</a></li>
					        <li><a href="/poselki/kupit-dom-do-2-mln-rub/">Дома 2 млн руб</a></li>
					        <li><a href="/poselki/kupit-dom-do-3-mln-rub/">Дома 3 млн руб</a></li>
					        <li><a href="/poselki/kupit-dom-do-4-mln-rub/">Дома 4 млн руб</a></li>
					        <li><a href="/poselki/kupit-dom-do-5-mln-rub/">Дома 5 млн руб</a></li>
					        <li><a href="/poselki/kupit-dom-do-6-mln-rub/">Дома 6 млн руб</a></li>
					        <li><a href="/poselki/kupit-dom-do-7-mln-rub/">Дома 7 млн руб</a></li>
					        <li><a href="/poselki/kupit-dom-do-8-mln-rub/">Дома 8 млн руб</a></li>
					        <li><a href="/poselki/kupit-dom-do-9-mln-rub/">Дома 9 млн руб</a></li>
					        <li><a href="/poselki/kupit-dom-do-10-mln-rub/">Дома 10 млн руб</a></li>
					        <li><a href="/poselki/kupit-dom-do-15-mln-rub/">Дома 15 млн руб</a></li>
					        <li><a href="/poselki/kupit-dom-do-20-mln-rub/">Дома 20 млн руб</a></li>
					        <li><a href="/poselki/kupit-dom-do-30-mln-rub/">Дома 30 млн руб</a></li>
					      </ul>
					    </div>
					  </div>

						<h3>Площадь</h3>
					  <div class="links-item houses-item">
					    <div class="item">
					      <ul>
					        <?for ($i=2; $i <= 20; $i++) { // участки?>
					          <?if($i == 2 || $i == 3 || $i == 4){
					            $nameSot = 'сотки'; $urlSot = 'sotki';
					          }else{
					            $nameSot = 'соток'; $urlSot = 'sotok';
					          }?>
					          <li><a href="/poselki/kupit-uchastok-<?=$i?>-<?=$urlSot?>/">Участок <?=$i?> <?=$nameSot?></a></li>
					        <?}?>
					        <li><a href="/poselki/kupit-uchastok-25-sotok/">Участок 25 соток</a></li>
					      <?for ($i=30; $i <= 100; $i+=10) {?>
					        <?if($i == 40)echo '</ul></div><div class="item"><ul>';?>
					        <li><a href="/poselki/kupit-uchastok-<?=$i?>-sotok/">Участок <?=$i?> соток</a></li>
					      <?}?>
					        <?for ($i=2; $i <= 20; $i++) { // дома?>
					          <?if($i == 2 || $i == 3 || $i == 4){
					            $nameSot = 'сотки'; $urlSot = 'sotki';
					          }else{
					            $nameSot = 'соток'; $urlSot = 'sotok';
					          }?>
					          <li><a href="/poselki/kupit-dom-na-<?=$i?>-sotkah/">Дом на <?=$i?> сотках</a></li>
					          <?if($i == 15)echo '</ul></div><div class="item"><ul>';?>
					        <?}?>
					          <li><a href="/poselki/kupit-dom-na-25-sotkah/">Дом на 25 сотках</a></li>
					        <?for ($i=30; $i <= 100; $i+=10) {?>
					          <li><a href="/poselki/kupit-dom-na-<?=$i?>-sotkah/">Дом на <?=$i?> сотках</a></li>
					        <?}?>
					        <li><a href="/poselki/kupit-dom-100-kv-m/">Купить дом 100 кв.м.</a></li>
					        <li><a href="/poselki/kupit-dom-120-kv-m/">Купить дом 120 кв.м.</a></li>
					        <li><a href="/poselki/kupit-dom-150-kv-m/">Купить дом 150 кв.м.</a></li>
					        <li><a href="/poselki/kupit-dom-200-kv-m/">Купить дом 200 кв.м.</a></li>
					        <li><a href="/poselki/kupit-dom-250-kv-m/">Купить дом 250 кв.м.</a></li>
					        <li><a href="/poselki/kupit-dom-300-kv-m/">Купить дом 300 кв.м.</a></li>
					        <li><a href="/poselki/kupit-dom-400-kv-m/">Купить дом 400 кв.м.</a></li>
					        <li><a href="/poselki/kupit-dom-500-kv-m/">Купить дом 500 кв.м.</a></li>
					      </ul>
					    </div>
					  </div>

						<h3>Класс</h3>
					  <div class="links-item houses-item">
					    <div class="item">
					      <ul>
					        <li><a href="/poselki/eсonom-class/">Эконом класса</a></li>
					        <li><a href="/poselki/biznes-class/">Бизнес класса</a></li>
					        <li><a href="/poselki/komfort-class/">Комфорт класса</a></li>
					        <li><a href="/poselki/elit-class/">Элитного класса</a></li>
					        <li><a href="/poselki/premium-class/">Премиум класса</a></li>
					      </ul>
					    </div>
					    <div class="item">
					      <ul>
					        <li><a href="/poselki/kupit-uchastok-eсonom-class/">Участки эконом класса</a></li>
					        <li><a href="/poselki/kupit-uchastok-biznes-class/">Участки бизнес класса</a></li>
					        <li><a href="/poselki/kupit-uchastok-komfort-class/">Участки комфорт класса</a></li>
					        <li><a href="/poselki/kupit-uchastok-elit-class/">Участки элитного класса</a></li>
					        <li><a href="/poselki/kupit-uchastok-premium-class/">Участки премиум класса</a></li>
					      </ul>
					    </div>
					    <div class="item">
					      <ul>
					        <li><a href="/poselki/kupit-dom-eсonom-class/">Дома эконом класса</a></li>
					        <li><a href="/poselki/kupit-dom-biznes-class/">Дома бизнес класса</a></li>
					        <li><a href="/poselki/kupit-dom-komfort-class/">Дома комфорт класса</a></li>
					        <li><a href="/poselki/kupit-dom-elit-class/">Дома элитного класса</a></li>
					        <li><a href="/poselki/kupit-dom-premium-class/">Дома премиум класса</a></li>
					      </ul>
					    </div>
					  </div>

						<h3>Коммуникации</h3>
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
					        <li><a href="/poselki/kupit-uchastok-s-elektrichestvom/">Участки с электричеством</a></li>
					        <li><a href="/poselki/kupit-uchastok-s-vodoprovodom/">Участки с водопроводом</a></li>
					        <li><a href="/poselki/kupit-uchastok-s-gazom/">Участки с газом</a></li>
					        <li><a href="/poselki/kupit-uchastok-s-kommunikaciyami/">Участки с коммуникациями</a></li>
					      </ul>
					    </div>
					    <div class="item">
					      <ul>
					        <li><a href="/poselki/kupit-dom-s-elektrichestvom/">Дома с электричеством</a></li>
					        <li><a href="/poselki/kupit-dom-s-vodoprovodom/">Дома с водопроводом</a></li>
					        <li><a href="/poselki/kupit-dom-s-gazom/">Дома с газом</a></li>
					        <li><a href="/poselki/kupit-dom-s-kommunikaciyami/">Дома с коммуникациями</a></li>
					      </ul>
					    </div>
					  </div>

						<h3>Инфраструктура</h3>
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
					        <li><a href="/poselki/kupit-uchastok-snt/">Участки СНТ</a></li>
					        <li><a href="/poselki/kupit-uchastok-izhs/">Участки ИЖС</a></li>
					        <li><a href="/poselki/kupit-uchastok-ryadom-zhd-stanciya/">Участки рядом с Ж/Д станцией</a></li>
					      </ul>
					    </div>
					    <div class="item">
					      <ul>
					        <li><a href="/poselki/kupit-dom-snt/">Дома СНТ</a></li>
					        <li><a href="/poselki/kupit-dom-izhs/">Дома ИЖС</a></li>
					        <li><a href="/poselki/kupit-dom-ryadom-zhd-stanciya/">Дома рядом с Ж/Д станцией</a></li>
					      </ul>
					    </div>
					  </div>

						<h3>Природа</h3>
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
					        <li><a href="/poselki/kupit-uchastok-ryadom-s-lesom/">Участки рядом с лесом</a></li>
					        <li><a href="/poselki/kupit-uchastok-u-vody/">Участки у воды</a></li>
					        <li><a href="/poselki/kupit-uchastok-u-ozera/">Участки у озера</a></li>
					        <li><a href="/poselki/kupit-uchastok-u-reki/">Участки у реки</a></li>
					      </ul>
					    </div>
					    <div class="item">
					      <ul>
					        <li><a href="/poselki/kupit-dom-ryadom-s-lesom/">Дома рядом с лесом</a></li>
					        <li><a href="/poselki/kupit-dom-u-vody/">Дома у воды</a></li>
					        <li><a href="/poselki/kupit-dom-u-ozera/">Дома у озера</a></li>
					        <li><a href="/poselki/kupit-dom-u-reki/">Дома у реки</a></li>
					      </ul>
					    </div>
					  </div>

						<h3>Другие страницы</h3>
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
					        <li><a href="/blog/novosti/">Новости</a></li>
					        <li><a href="/blog/pro-uchastki/">Про участки</a></li>
									<li><a href="/blog/pro-doma/">Про дома</a></li>
									<li><a href="/blog/obzor-rynka/">Обзор рынка</a></li>
					      </ul>
					    </div>
					  </div>

						<h3>Статьи блога</h3>
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
				</div>
			</div>
		</div>
	</div>
</main>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
