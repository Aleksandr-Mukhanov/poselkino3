<?
// получим список шоссе
$propEnums = CIBlockPropertyEnum::GetList(
  ["SORT"=>"ASC","VALUE"=>"ASC"],
  ["IBLOCK_ID"=>1,"CODE"=>"SHOSSE"]
);
while($enumFields = $propEnums->GetNext()){ // dump($enumFields);
  $arShosse[$enumFields['XML_ID']] = [
    'ID' => $enumFields['ID'],
    'NAME' => $enumFields['VALUE'],
  ];
}

// получим список районов
$propEnums = CIBlockPropertyEnum::GetList(
  ["SORT"=>"ASC","VALUE"=>"ASC"],
  ["IBLOCK_ID"=>1,"CODE"=>"REGION"]
);
while($enumFields = $propEnums->GetNext()){ // dump($enumFields);
  $arRegion[$enumFields['XML_ID']] = $enumFields['VALUE'];
}

$urlVillageHide = (CSite::InDir('/kupit-uchastki/')) ? 'hide' : '';
?>
<div class="container">
  <div class="block_url <?=$urlVillageHide?>" id="block_url_village">
    <div class="nav nav-tabs" id="addressTab" role="tablist">

      <div class="nav-item"><a class="nav-link <?if(!$_REQUEST['show_rayon'])echo'active';?>" id="highwayTab-tab" data-toggle="tab" href="#highwayTab" role="tab" aria-controls="highwayTab" aria-selected="true">Шоссе</a></div>

      <div class="nav-item"><a class="nav-link <?if($_REQUEST['show_rayon'])echo'active';?>" id="areaTab-tab" data-toggle="tab" href="#areaTab" role="tab" aria-controls="areaTab" aria-selected="false">Районы</a></div>

      <div class="nav-item"><a class="nav-link" id="mkadTab-tab" data-toggle="tab" href="#mkadTab" role="tab" aria-controls="mkadTab" aria-selected="false">от МКАД</a></div>

      <div class="nav-item"><a class="nav-link" id="priceTab-tab" data-toggle="tab" href="#priceTab" role="tab" aria-controls="priceTab" aria-selected="false">Цена</a></div>

      <div class="nav-item"><a class="nav-link" id="sizeTab-tab" data-toggle="tab" href="#sizeTab" role="tab" aria-controls="sizeTab" aria-selected="false">Площадь</a></div>

      <div class="nav-item"><a class="nav-link" id="classTab-tab" data-toggle="tab" href="#classTab" role="tab" aria-controls="classTab" aria-selected="false">Класс</a></div>

      <div class="nav-item"><a class="nav-link" id="communicationsTab-tab" data-toggle="tab" href="#communicationsTab" role="tab" aria-controls="communicationsTab" aria-selected="false">Коммуникации</a></div>

      <div class="nav-item"><a class="nav-link" id="infrastructureTab-tab" data-toggle="tab" href="#infrastructureTab" role="tab" aria-controls="infrastructureTab" aria-selected="false">Инфраструктура</a></div>

      <div class="nav-item"><a class="nav-link" id="natureTab-tab" data-toggle="tab" href="#natureTab" role="tab" aria-controls="natureTab" aria-selected="false">Природа</a></div>

    </div>
    <div class="tab-content">
      <div class="tab-pane fade <?if(!$_REQUEST['show_rayon'])echo'show active';?>" id="highwayTab" role="tabpanel" aria-labelledby="highwayTab-tab">
        <div class="row">
          <?foreach ($arShosse as $key => $value):
            $colorHW = getColorRoad($value['ID']);?>
            <div class="col-lg-3 col-md-4 col-sm-6">
              <a class="metro-title highway-color" href="/poselki/<?=$key?>-shosse/">
                <div class="metro-title__color <?=$colorHW?>"></div>
                <div class="metro-title__title"><?=$value['NAME']?></div>
              </a>
            </div>
          <?endforeach;?>
        </div>
      </div>
      <div class="tab-pane fade <?if($_REQUEST['show_rayon'])echo'show active';?>" id="areaTab" role="tabpanel" aria-labelledby="areaTab-tab">
        <div class="row">
          <?foreach ($arRegion as $key => $value): $i++;?>
            <div class="col-lg-3 col-md-4 col-sm-6">
              <a class="metro-title" href="/poselki/<?=$key?>-rayon/">
                <div class="metro-title__title"><?=$value?></div>
              </a>
            </div>
          <?endforeach;?>
        </div>
      </div>
      <div class="tab-pane fade" id="mkadTab" role="tabpanel" aria-labelledby="mkadTab-tab">
        <div class="row">
          <?for($x=10; $x<=80; $x+=5){?>
            <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/do-<?=$x?>-km-ot-mkad/">
                <div class="metro-title__title">до <?=$x?> км</div>
              </a></div>
          <?}?>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/do-100-km-ot-mkad/">
              <div class="metro-title__title">до 100 км</div>
            </a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/do-120-km-ot-mkad/">
              <div class="metro-title__title">до 120 км</div>
            </a></div>
        </div>
      </div>
      <div class="tab-pane fade" id="priceTab" role="tabpanel" aria-labelledby="priceTab-tab">
        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-do-100-tys-rub/"><div class="metro-title__title">Участки 100 тыс руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-do-150-tys-rub/"><div class="metro-title__title">Участки 150 тыс руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-do-200-tys-rub/"><div class="metro-title__title">Участки 200 тыс руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-do-300-tys-rub/"><div class="metro-title__title">Участки 300 тыс руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-do-400-tys-rub/"><div class="metro-title__title">Участки 400 тыс руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-do-500-tys-rub/"><div class="metro-title__title">Участки 500 тыс руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-do-600-tys-rub/"><div class="metro-title__title">Участки 600 тыс руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-do-700-tys-rub/"><div class="metro-title__title">Участки 700 тыс руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-do-1-mln-rub/"><div class="metro-title__title">Участки 1 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-do-1,5-mln-rub/"><div class="metro-title__title">Участки 1,5 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-do-2-mln-rub/"><div class="metro-title__title">Участки 2 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-do-3-mln-rub/"><div class="metro-title__title">Участки 3 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-do-4-mln-rub/"><div class="metro-title__title">Участки 4 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-do-5-mln-rub/"><div class="metro-title__title">Участки 5 млн руб</div></a></div>

          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-do-1-mln-rub/"><div class="metro-title__title">Дома 1 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-do-1,5-mln-rub/"><div class="metro-title__title">Дома 1,5 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-do-2-mln-rub/"><div class="metro-title__title">Дома 2 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-do-3-mln-rub/"><div class="metro-title__title">Дома 3 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-do-4-mln-rub/"><div class="metro-title__title">Дома 4 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-do-5-mln-rub/"><div class="metro-title__title">Дома 5 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-do-6-mln-rub/"><div class="metro-title__title">Дома 6 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-do-7-mln-rub/"><div class="metro-title__title">Дома 7 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-do-8-mln-rub/"><div class="metro-title__title">Дома 8 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-do-9-mln-rub/"><div class="metro-title__title">Дома 9 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-do-10-mln-rub/"><div class="metro-title__title">Дома 10 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-do-15-mln-rub/"><div class="metro-title__title">Дома 15 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-do-20-mln-rub/"><div class="metro-title__title">Дома 20 млн руб</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-do-30-mln-rub/"><div class="metro-title__title">Дома 30 млн руб</div></a></div>
        </div>
      </div>
      <div class="tab-pane fade" id="sizeTab" role="tabpanel" aria-labelledby="sizeTab-tab">
        <div class="row">
          <?for ($i=2; $i <= 20; $i++) { // участки?>
            <?if($i == 2 || $i == 3 || $i == 4){
              $nameSot = 'сотки'; $urlSot = 'sotki';
            }else{
              $nameSot = 'соток'; $urlSot = 'sotok';
            }?>
            <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-<?=$i?>-<?=$urlSot?>/"><div class="metro-title__title">Участок <?=$i?> <?=$nameSot?></div></a></div>
          <?}?>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-25-sotok/"><div class="metro-title__title">Участок 25 соток</div></a></div>
          <?for ($i=30; $i <= 100; $i+=10) {?>
            <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-<?=$i?>-sotok/"><div class="metro-title__title">Участок <?=$i?> соток</div></a></div>
          <?}?>

          <?for ($i=2; $i <= 20; $i++) { // дома?>
            <?if($i == 2 || $i == 3 || $i == 4){
              $nameSot = 'сотки'; $urlSot = 'sotki';
            }else{
              $nameSot = 'соток'; $urlSot = 'sotok';
            }?>
            <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-na-<?=$i?>-sotkah/"><div class="metro-title__title">Дом на <?=$i?> сотках</div></a></div>
          <?}?>
            <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-na-25-sotkah/"><div class="metro-title__title">Дом на 25 сотках</div></a></div>
          <?for ($i=30; $i <= 100; $i+=10) {?>
            <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-na-<?=$i?>-sotkah/"><div class="metro-title__title">Дом на <?=$i?> сотках</div></a></div>
          <?}?>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-100-kv-m/"><div class="metro-title__title">Купить дом 100 кв.м.</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-120-kv-m/"><div class="metro-title__title">Купить дом 120 кв.м.</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-150-kv-m/"><div class="metro-title__title">Купить дом 150 кв.м.</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-200-kv-m/"><div class="metro-title__title">Купить дом 200 кв.м.</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-250-kv-m/"><div class="metro-title__title">Купить дом 250 кв.м.</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-300-kv-m/"><div class="metro-title__title">Купить дом 300 кв.м.</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-400-kv-m/"><div class="metro-title__title">Купить дом 400 кв.м.</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-500-kv-m/"><div class="metro-title__title">Купить дом 500 кв.м.</div></a></div>
        </div>
      </div>
      <div class="tab-pane fade" id="classTab" role="tabpanel" aria-labelledby="classTab-tab">
        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/econom-class/"><div class="metro-title__title">Эконом класса</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/biznes-class/"><div class="metro-title__title">Бизнес класса</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/komfort-class/"><div class="metro-title__title">Комфорт класса</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/elit-class/"><div class="metro-title__title">Элитного класса</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/premium-class/"><div class="metro-title__title">Премиум класса</div></a></div>

          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-econom-class/"><div class="metro-title__title">Участки эконом класса</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-biznes-class/"><div class="metro-title__title">Участки бизнес класса</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-komfort-class/"><div class="metro-title__title">Участки комфорт класса</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-elit-class/"><div class="metro-title__title">Участки элитного класса</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-premium-class/"><div class="metro-title__title">Участки премиум класса</div></a></div>

          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-econom-class/"><div class="metro-title__title">Дома эконом класса</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-biznes-class/"><div class="metro-title__title">Дома бизнес класса</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-komfort-class/"><div class="metro-title__title">Дома комфорт класса</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-elit-class/"><div class="metro-title__title">Дома элитного класса</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-premium-class/"><div class="metro-title__title">Дома премиум класса</div></a></div>
        </div>
      </div>
      <div class="tab-pane fade" id="communicationsTab" role="tabpanel" aria-labelledby="communicationsTab-tab">
        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/s-elektrichestvom/"><div class="metro-title__title">Поселки с электричеством</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/s-vodoprovodom/"><div class="metro-title__title">Поселки с водопроводом</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/s-gazom/"><div class="metro-title__title">Поселки с газом</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/s-kommunikaciyami/"><div class="metro-title__title">Поселки с коммуникациями</div></a></div>

          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-s-elektrichestvom/"><div class="metro-title__title">Участки с электричеством</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-s-vodoprovodom/"><div class="metro-title__title">Участки с водопроводом</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-s-gazom/"><div class="metro-title__title">Участки с газом</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-s-kommunikaciyami/"><div class="metro-title__title">Участки с коммуникациями</div></a></div>

          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-s-elektrichestvom/"><div class="metro-title__title">Дома с электричеством</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-s-vodoprovodom/"><div class="metro-title__title">Дома с водопроводом</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-s-gazom/"><div class="metro-title__title">Дома с газом</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-s-kommunikaciyami/"><div class="metro-title__title">Дома с коммуникациями</div></a></div>
        </div>
      </div>
      <div class="tab-pane fade" id="infrastructureTab" role="tabpanel" aria-labelledby="infrastructureTab-tab">
        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/snt/"><div class="metro-title__title">Поселки СНТ</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/izhs/"><div class="metro-title__title">Поселки ИЖС</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/ryadom-zhd-stanciya/"><div class="metro-title__title">Поселки рядом с Ж/Д станцией</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/ryadom-avtobusnaya-ostanovka/"><div class="metro-title__title">Поселки с автобусной остановкой</div></a></div>

          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-snt/"><div class="metro-title__title">Участки СНТ</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-izhs/"><div class="metro-title__title">Участки ИЖС</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-ryadom-zhd-stanciya/"><div class="metro-title__title">Участки рядом с Ж/Д станцией</div></a></div>

          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-snt/"><div class="metro-title__title">Дома СНТ</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-izhs/"><div class="metro-title__title">Дома ИЖС</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-ryadom-zhd-stanciya/"><div class="metro-title__title">Дома рядом с Ж/Д станцией</div></a></div>
        </div>
      </div>
      <div class="tab-pane fade" id="natureTab" role="tabpanel" aria-labelledby="natureTab-tab">
        <div class="row">
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/ryadom-s-lesom/"><div class="metro-title__title">Поселки рядом с лесом</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/u-vody/"><div class="metro-title__title">Поселки у воды</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/u-ozera/"><div class="metro-title__title">Поселки у озера</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/u-reki/"><div class="metro-title__title">Поселки у реки</div></a></div>

          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-ryadom-s-lesom/"><div class="metro-title__title">Участки рядом с лесом</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-u-vody/"><div class="metro-title__title">Участки у воды</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-u-ozera/"><div class="metro-title__title">Участки у озера</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-uchastok-u-reki/"><div class="metro-title__title">Участки у реки</div></a></div>

          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-ryadom-s-lesom/"><div class="metro-title__title">Дома рядом с лесом</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-u-vody/"><div class="metro-title__title">Дома у воды</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-u-ozera/"><div class="metro-title__title">Дома у озера</div></a></div>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/poselki/kupit-dom-u-reki/"><div class="metro-title__title">Дома у реки</div></a></div>
        </div>
      </div>
    </div>
    <button class="d-md-none btn btn-outline-secondary w-100 font-weight-normal" id="showCollapseAddress" type="button">
      Ещё &nbsp;
      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 12 7" class="inline-svg">
        <g transform="rotate(-90 59.656 59.156)">
          <path d="M113.258 5.441l4.915-4.915a.308.308 0 1 0-.436-.436L112.6 5.225a.307.307 0 0 0 0 .436l5.134 5.132a.31.31 0 0 0 .217.091.3.3 0 0 0 .217-.091.307.307 0 0 0 0-.436z" />
        </g>
      </svg>
    </button>
  </div>
</div>
