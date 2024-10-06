<!-- Полезные ссылки -->
<?
  if (DOMEN == 'spb') {
    $arPopularRoad = [
      'leningradskoe-shosse' => 'Ленинградском шоссе',
      'kievskoe-shosse' => 'Киевском шоссе',
      'murmanskoe-shosse' => 'Мурманском шоссе',
    ];
    $arPopularRegion = [
      'vsevolozhskiy-rayon' => 'Всеволожском районе',
      'gatchinskiy-rayon' => 'Гатчинском районе',
      'vyborgskiy-rayon' => 'Выборгском районе',
    ];
    $arPopularRoadPlot = [
      'leningradskoe-shosse' => 'Ленинградское',
      'kievskoe-shosse' => 'Киевское',
      'murmanskoe-shosse' => 'Мурманское',
    ];
  } elseif (DOMEN == 'kaluga') {
    $arPopularRoad = [
      'varshavskoe-shosse' => 'Варшавском шоссе',
      'kievskoe-shosse' => 'Киевском шоссе',
      'kaluzhskoe-shosse' => 'Калужском шоссе',
    ];
    $arPopularRegion = [
      'maloyaroslavetskiy-rayon' => 'Малоярославецком районе',
      'babyninskiy-rayon' => 'Бабынинском районе',
      'yukhnovskiy-rayon' => 'Юхновским районе',
    ];
    $arPopularRoadPlot = [
      'varshavskoe-shosse' => 'Варшавское',
      'kievskoe-shosse' => 'Киевское',
      'kaluzhskoe-shosse' => 'Калужское',
    ];
  } else {
    $arPopularRoad = [
      'kashirskoe-shosse' => 'Каширском шоссе',
      'dmitrovskoe-shosse' => 'Дмитровском шоссе',
      'simferopolskoe-shosse' => 'Симферопольском шоссе',
    ];
    $arPopularRegion = [
      'domodedovskiy-rayon' => 'Домодедовском районе',
      'dmitrovskiy-rayon' => 'Дмитровском районе',
      'istrinskiy-rayon' => 'Истринском районе',
    ];
    $arPopularRoadPlot = [
      'kashirskoe-shosse' => 'Каширское',
      'dmitrovskoe-shosse' => 'Дмитровское',
      'novoryazanskoe-shosse' => 'Новорязанское',
    ];
  }

?>
<section class="useful-links">
  <div class="container">
    <h3 class="useful-links__title">Полезные ссылки</h3>
    <div class="row">
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="useful-links__card">
          <h4 class="useful-links__card-title">Поселки на популярных шоссе:</h4>
          <ul class="useful-links__list">
            <?foreach ($arPopularRoad as $key => $value) {?>
              <li class="useful-links__item">
                <a href="/poselki/<?=$key?>/" class="useful-links__link">Поселки на <?=$value?></a>
              </li>
            <?}?>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="useful-links__card">
          <h4 class="useful-links__card-title">Поселки в популярных районах:</h4>
          <ul class="useful-links__list">
            <?foreach ($arPopularRegion as $key => $value) {?>
              <li class="useful-links__item">
                <a href="/poselki/<?=$key?>/" class="useful-links__link">Поселки в <?=$value?></a>
              </li>
            <?}?>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="useful-links__card useful-links__card-link">
          <a href="/poselki/map/" class="useful-links__map">
            <span>Все поселки на карте</span>
            <img src="/assets/img/content/useful-map.png" alt="all">
          </a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="useful-links__card">
          <h4 class="useful-links__card-title">Участки на популярных шоссе:</h4>
          <ul class="useful-links__list">
            <?foreach ($arPopularRoadPlot as $key => $value) {?>
              <li class="useful-links__item">
                <a href="/kupit-uchastki/<?=$key?>/" class="useful-links__link"><?=$value?></a>
              </li>
            <?}?>
          </ul>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="useful-links__card useful-links__card-link">
          <a href="/test/" class="useful-links__questions">
            <span>Ответьте на 6 вопросов <br>и получите подборку из 5 лучших участков</span>
            <img src="/assets/img/content/useful-questions.png" alt="all">
          </a>
        </div>
      </div>
      <div class="col-lg-4 col-md-6 col-sm-6">
        <div class="useful-links__card">
          <h4 class="useful-links__card-title">Участки по стоимости:</h4>
          <ul class="useful-links__list">
            <li class="useful-links__item">
              <a href="/kupit-uchastki/do-1-mln-rub/" class="useful-links__link">Участки до 1 млн. руб.</a>
            </li>
            <li class="useful-links__item">
              <a href="/kupit-uchastki/do-1,5-mln-rub/" class="useful-links__link">Участки до 1,5 млн. руб.</a>
            </li>
            <li class="useful-links__item">
              <a href="/kupit-uchastki/do-2-mln-rub/" class="useful-links__link">Участки до 2 млн. руб.</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
