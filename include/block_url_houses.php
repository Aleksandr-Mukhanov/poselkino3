<?
// получим список шоссе
$propEnums = CIBlockPropertyEnum::GetList(
  ["SORT"=>"ASC","VALUE"=>"ASC"],
  ["IBLOCK_ID"=>IBLOCK_ID,"CODE"=>ROAD_CODE]
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
  ["IBLOCK_ID"=>IBLOCK_ID,"CODE"=>REGION_CODE]
);
while($enumFields = $propEnums->GetNext()){ // dump($enumFields);
  $arRegion[$enumFields['XML_ID']] = $enumFields['VALUE'];
}
?>
<div class="container block_url" id="block_url_houses">
  <ul class="nav nav-tabs" id="addressTabHouses" role="tablist">
    <li class="nav-item"><a class="nav-link <?if(!$_REQUEST['show_rayon'])echo'active';?>" id="highwayTab-tab" data-toggle="tab" href="#highwayTabHouses" role="tab" aria-controls="highwayTab" aria-selected="true">Шоссе</a></li>
    <li class="nav-item"><a class="nav-link <?if($_REQUEST['show_rayon'])echo'active';?>" id="areaTab-tab" data-toggle="tab" href="#areaTabHouses" role="tab" aria-controls="areaTab" aria-selected="false">Районы</a></li>
    <li class="nav-item"><a class="nav-link" id="mkadTab-tab" data-toggle="tab" href="#mkadTabHouses" role="tab" aria-controls="mkadTab" aria-selected="false">от <?=ROAD?></a></li>
    <li class="nav-item"><a class="nav-link" id="priceTab-tab" data-toggle="tab" href="#priceTabHouses" role="tab" aria-controls="priceTab" aria-selected="false">Цена</a></li>
    <li class="nav-item"><a class="nav-link" id="sizeTab-tab" data-toggle="tab" href="#sizeTabHouses" role="tab" aria-controls="sizeTab" aria-selected="false">Площадь</a></li>
    <li class="nav-item"><a class="nav-link" id="classTab-tab" data-toggle="tab" href="#classTabHouses" role="tab" aria-controls="classTab" aria-selected="false">Класс</a></li>
    <li class="nav-item"><a class="nav-link" id="communicationsTab-tab" data-toggle="tab" href="#communicationsTabHouses" role="tab" aria-controls="communicationsTab" aria-selected="false">Коммуникации</a></li>
    <li class="nav-item"><a class="nav-link" id="infrastructureTab-tab" data-toggle="tab" href="#infrastructureTabHouses" role="tab" aria-controls="infrastructureTab" aria-selected="false">Инфраструктура</a></li>
    <!-- <li class="nav-item"><a class="nav-link" id="natureTab-tab" data-toggle="tab" href="#natureTabHouses" role="tab" aria-controls="natureTab" aria-selected="false">Природа</a></li> -->
  </ul>
  <div class="tab-content">
    <div class="tab-pane fade <?if(!$_REQUEST['show_rayon'])echo'show active';?>" id="highwayTabHouses" role="tabpanel" aria-labelledby="highwayTab-tab">
      <div class="row">
        <?foreach ($arShosse as $key => $value):
          $colorHW = getColorRoad($value['ID']);?>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <a class="metro-title highway-color" href="/doma/<?=$key?>-shosse/">
              <div class="metro-title__color <?=$colorHW?>"></div>
              <div class="metro-title__title"><?=$value['NAME']?></div>
            </a>
          </div>
        <?endforeach;?>
      </div>
    </div>
    <div class="tab-pane fade <?if($_REQUEST['show_rayon'])echo'show active';?>" id="areaTabHouses" role="tabpanel" aria-labelledby="areaTab-tab">
      <div class="row">
        <?foreach ($arRegion as $key => $value): $i++;?>
          <div class="col-lg-3 col-md-4 col-sm-6">
            <a class="metro-title" href="/doma/<?=$key?>-rayon/">
              <div class="metro-title__title"><?=$value?></div>
            </a>
          </div>
        <?endforeach;?>
      </div>
    </div>
    <div class="tab-pane fade" id="mkadTabHouses" role="tabpanel" aria-labelledby="mkadTab-tab">
      <div class="row">
        <?for($x=10; $x<=80; $x+=5){?>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/do-<?=$x?>-km-ot-<?=ROAD_URL?>/">
              <div class="metro-title__title">до <?=$x?> км</div>
            </a></div>
        <?}?>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/do-100-km-ot-<?=ROAD_URL?>/">
            <div class="metro-title__title">до 100 км</div>
          </a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/do-120-km-ot-<?=ROAD_URL?>/">
            <div class="metro-title__title">до 120 км</div>
          </a></div>
      </div>
    </div>
    <div class="tab-pane fade" id="priceTabHouses" role="tabpanel" aria-labelledby="priceTab-tab">
      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-do-100-tys-rub/"><div class="metro-title__title">Участки 100 тыс руб</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-do-150-tys-rub/"><div class="metro-title__title">Участки 150 тыс руб</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-do-200-tys-rub/"><div class="metro-title__title">Участки 200 тыс руб</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-do-300-tys-rub/"><div class="metro-title__title">Участки 300 тыс руб</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-do-400-tys-rub/"><div class="metro-title__title">Участки 400 тыс руб</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-do-500-tys-rub/"><div class="metro-title__title">Участки 500 тыс руб</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-do-600-tys-rub/"><div class="metro-title__title">Участки 600 тыс руб</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-do-700-tys-rub/"><div class="metro-title__title">Участки 700 тыс руб</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-do-1-mln-rub/"><div class="metro-title__title">Участки 1 млн руб</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-do-1,5-mln-rub/"><div class="metro-title__title">Участки 1,5 млн руб</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-do-2-mln-rub/"><div class="metro-title__title">Участки 2 млн руб</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-do-3-mln-rub/"><div class="metro-title__title">Участки 3 млн руб</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-do-4-mln-rub/"><div class="metro-title__title">Участки 4 млн руб</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-do-5-mln-rub/"><div class="metro-title__title">Участки 5 млн руб</div></a></div>
      </div>
    </div>
    <div class="tab-pane fade" id="sizeTabHouses" role="tabpanel" aria-labelledby="sizeTab-tab">
      <div class="row">
        <?for ($i=2; $i <= 20; $i++) { // участки?>
          <?if($i == 2 || $i == 3 || $i == 4){
            $nameSot = 'сотки'; $urlSot = 'sotki';
          }else{
            $nameSot = 'соток'; $urlSot = 'sotok';
          }?>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-<?=$i?>-<?=$urlSot?>/"><div class="metro-title__title">Участок <?=$i?> <?=$nameSot?></div></a></div>
        <?}?>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-25-sotok/"><div class="metro-title__title">Участок 25 соток</div></a></div>
        <?for ($i=30; $i <= 100; $i+=10) {?>
          <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-<?=$i?>-sotok/"><div class="metro-title__title">Участок <?=$i?> соток</div></a></div>
        <?}?>
      </div>
    </div>
    <div class="tab-pane fade" id="classTabHouses" role="tabpanel" aria-labelledby="classTab-tab">
      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-econom-class/"><div class="metro-title__title">Участки эконом класса</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-biznes-class/"><div class="metro-title__title">Участки бизнес класса</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-komfort-class/"><div class="metro-title__title">Участки комфорт класса</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-elit-class/"><div class="metro-title__title">Участки элитного класса</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-premium-class/"><div class="metro-title__title">Участки премиум класса</div></a></div>
      </div>
    </div>
    <div class="tab-pane fade" id="communicationsTabHouses" role="tabpanel" aria-labelledby="communicationsTab-tab">
      <div class="row"><div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-s-elektrichestvom/"><div class="metro-title__title">Участки с электричеством</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-s-vodoprovodom/"><div class="metro-title__title">Участки с водопроводом</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-s-gazom/"><div class="metro-title__title">Участки с газом</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-s-kommunikaciyami/"><div class="metro-title__title">Участки с коммуникациями</div></a></div>
      </div>
    </div>
    <div class="tab-pane fade" id="infrastructureTabHouses" role="tabpanel" aria-labelledby="infrastructureTab-tab">
      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-snt/"><div class="metro-title__title">Участки СНТ</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-izhs/"><div class="metro-title__title">Участки ИЖС</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-ryadom-zhd-stanciya/"><div class="metro-title__title">Участки рядом с Ж/Д станцией</div></a></div>
      </div>
    </div>
    <!-- <div class="tab-pane fade" id="natureTabHouses" role="tabpanel" aria-labelledby="natureTab-tab">
      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-ryadom-s-lesom/"><div class="metro-title__title">Участки рядом с лесом</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-u-vody/"><div class="metro-title__title">Участки у воды</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-u-ozera/"><div class="metro-title__title">Участки у озера</div></a></div>
        <div class="col-lg-3 col-md-4 col-sm-6"><a class="metro-title" href="/doma/uchastki-u-reki/"><div class="metro-title__title">Участки у реки</div></a></div>
      </div>
    </div> -->
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
