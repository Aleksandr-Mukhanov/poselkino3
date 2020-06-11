<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Grid\Declension;
$areaDeclension = new Declension('участок', 'участка', 'участков');
$areaName = $areaDeclension->get(getMetaInfo($arrFilter)['cntPos']);
$houseDeclension = new Declension('дом', 'дома', 'домов');
$houseName = $houseDeclension->get(getMetaInfo($arrFilter)['cntPos']);
$vilDeclension = new Declension('поселок', 'поселка', 'поселков');
$vilName = $vilDeclension->get(getMetaInfo($arrFilter)['cntPos']);

$SEO_text_add = false;

if($shosse && $domPos){ // если выбор шоссе и участок/дом

  $arMetaInfo = getMetaInfo($arrFilter);

  switch ($domPos) {
    case 'noDom': // Участки
      $SEO_text = '
      <p>В данном разделе представлены ▶ земельные участки на '.$arNames['NAME_KOM'].' шоссе. Здесь представлено ▶ '.$arMetaInfo['cntPos'].' '.$areaName.' с независимыми отзывами и рейтингом. Вы можете выбрать самые доступные цены на землю на '.$arNames['NAME_KOM'].' направлении ▶ стоимость варьируется от '.$arMetaInfo['minPrice'].' рублей до '.$arMetaInfo['maxPrice'].' рублей.</p>
      <p>★ Особенности проекта Poselkino ★ - для каждого объекта мы подбираем данные:</p>';
      break;
    case 'withDom': // Дома
      $SEO_text = '
      <p>В данном разделе представлены ▶ коттеджи и дома на '.$arNames['NAME_KOM'].' шоссе. Здесь представлено ▶ '.$arMetaInfo['cntPos'].' '.$houseName.' с независимыми отзывами и рейтингом. Вы можете выбрать самые доступные цены на коттеджи на '.$arNames['NAME_KOM'].' направлении ▶ стоимость варьируется от '.$arMetaInfo['minPrice'].' рублей до '.$arMetaInfo['maxPrice'].' рублей.</p>
      <p>★ Особенности проекта Poselkino ★ - для каждого объекта мы подбираем данные:</p>';
      break;
  }
  $SEO_text_add = true;

}elseif($rayon && $domPos){ // если выбор район и участок/дом

  $arMetaInfo = getMetaInfo($arrFilter);

  switch ($domPos) {
    case 'noDom': // Участки
      $SEO_text = '<p>В данном разделе представлены ▶ земельные участки в '.$arNames['NAME_KOM'].' районе. Здесь представлено ▶ '.$arMetaInfo['cntPos'].' '.$areaName.' с независимыми отзывами и рейтингом. Вы можете выбрать самые доступные цены на землю в '.$arNames['NAME_KOM'].' районе ▶ стоимость варьируется от '.$arMetaInfo['minPrice'].' рублей до '.$arMetaInfo['maxPrice'].' рублей.</p>
      <p>★ Особенности проекта Poselkino ★ - для каждого объекта мы подбираем данные:</p>';
      break;
    case 'withDom': // Дома
      $SEO_text = '<p>В данном разделе представлены ▶ коттеджи и дома в '.$arNames['NAME_KOM'].' районе. Здесь представлено ▶ '.$arMetaInfo['cntPos'].' '.$houseName.' с независимыми отзывами и рейтингом. Вы можете выбрать самые доступные цены на коттеджи в '.$arNames['NAME_KOM'].' районе ▶ стоимость варьируется от '.$arMetaInfo['minPrice'].' рублей до '.$arMetaInfo['maxPrice'].' рублей.</p>
      <p>★ Особенности проекта Poselkino ★ - для каждого объекта мы подбираем данные:</p>';
      break;
  }
  $SEO_text_add = true;

}elseif($mkadKM){ // если выбор расстояние от МКАД

  $arMetaInfo = getMetaInfo($arrFilter);

  switch ($domPos) {
    case 'noDom': // Участки
      $SEO_text = '<p>В данном разделе представлены ▶ земельные участки в '.$mkadKM.' км от МКАД. Здесь представлено ▶ '.$arMetaInfo['cntPos'].' '.$areaName.' с независимыми отзывами и рейтингом. Вы можете выбрать самые доступные цены на землю в '.$mkadKM.' км от МКАД ▶ стоимость варьируется от '.$arMetaInfo['minPrice'].' рублей до '.$arMetaInfo['maxPrice'].' рублей.</p>
      <p>★ Особенности проекта Poselkino ★ - для каждого участка мы подбираем данные:</p>';
      break;
    case 'withDom': // Дома
      $SEO_text = '<p>В данном разделе представлены ▶ коттеджи и дома в '.$mkadKM.' км от МКАД. Здесь представлено ▶ '.$arMetaInfo['cntPos'].' '.$houseName.' с независимыми отзывами и рейтингом. Вы можете выбрать самые доступные цены на коттеджи в '.$mkadKM.' км от МКАД ▶ стоимость варьируется от '.$arMetaInfo['minPrice'].' рублей до '.$arMetaInfo['maxPrice'].' рублей.</p>
      <p>★ Особенности проекта Poselkino ★ - для каждого загородного дома мы подбираем данные:</p>';
      break;
    default: // поселки
      $SEO_text = '<p>В данном разделе представлены ▶ коттеджные поселки в '.$mkadKM.' км от МКАД. Здесь представлено ▶ '.$arMetaInfo['cntPos'].' '.$vilName.' с независимыми отзывами и рейтингом. Вы можете выбрать самые доступные цены на коттеджи в поселках на расстоянии '.$mkadKM.' км от МКАД ▶ стоимость варьируется от '.$arMetaInfo['minPrice'].' рублей до '.$arMetaInfo['maxPrice'].' рублей.</p>
      <p>★ Особенности проекта Poselkino ★ - для каждого объекта мы подбираем данные:</p>';
      break;
  }
  $SEO_text_add = true;

}elseif($commun){ // коммуникации

  $arMetaInfo = getMetaInfo($arrFilter);
  $nameCommun2 = ($commun == 'elektrichestvom') ? 'электричеством' : $nameCommun;

  switch ($commun) {
    case 'elektrichestvom':
      $nameCommun = 'светом';
      break;
    case 'vodoprovodom':
      $nameCommun = 'водой';
      break;
    case 'gazom':
      $nameCommun = 'газом';
      break;
    default:
      $nameCommun = 'коммуникациями';
      break;
  }

  switch ($domPos) {
    case 'noDom': // Участки
      $SEO_text = '<p>В данном разделе представлены ▶ земельные участки с '.$nameCommun2.'. Здесь представлено ▶ '.$arMetaInfo['cntPos'].' загородных '.$areaName.' с независимыми отзывами и рейтингом. Вы можете выбрать самые доступные цены на землю с проведенным '.$nameCommun.' ▶ стоимость варьируется от '.$arMetaInfo['minPrice'].' рублей до '.$arMetaInfo['maxPrice'].' рублей.</p>
      <p>★ Особенности проекта Poselkino ★ - для каждого участка мы подбираем данные:</p>';
      break;
    case 'withDom': // Дома
      $SEO_text = '<p>В данном разделе представлены ▶ коттеджи и дома с '.$nameCommun2.'. Здесь представлено ▶ '.$arMetaInfo['cntPos'].' загородных '.$houseName.' с независимыми отзывами и рейтингом. Вы можете выбрать самые доступные цены на коттеджи с '.$nameCommun.' ▶ стоимость варьируется от '.$arMetaInfo['minPrice'].' рублей до '.$arMetaInfo['maxPrice'].' рублей.</p>
      <p>★ Особенности проекта Poselkino ★ - для каждого объекта мы подбираем данные:</p>';
      break;
    default: // поселки
      $SEO_text = '<p>В данном разделе представлены ▶ коттеджные поселки с '.$nameCommun2.'. Здесь представлено ▶ '.$arMetaInfo['cntPos'].' загородных '.$vilName.' с независимыми отзывами и рейтингом. Вы можете выбрать самые доступные цены на коттеджи в поселках с проведенным '.$nameCommun.' ▶ стоимость варьируется от '.$arMetaInfo['minPrice'].' рублей до '.$arMetaInfo['maxPrice'].' рублей.</p>
      <p>★ Особенности проекта Poselkino ★ - для каждого поселка мы подбираем данные:</p>';
      break;
  }
  $SEO_text_add = true;
}
if($SEO_text_add){ // дополним текст
  $SEO_text .= '
  <ul>
    <li>✔Видео с квадрокоптера;</li>
    <li>✔Экология местности вокруг объекта;</li>
    <li>✔Отзывы покупателей;</li>
    <li>✔Данные о юридической чистоте;</li>
    <li>✔Стоимость всех коммуникаций.</li>
  </ul>';
}
$SEO_text_add = false;

// $SEO_text = '<p></p>
// <p>★ Особенности проекта Poselkino ★ - для каждого объекта мы подбираем данные:</p>';

// switch ($domPos) {
//   case 'noDom': // Участки
//     $SEO_text = '<p></p>';
//     break;
//   case 'withDom': // Дома
//     $SEO_text = '<p></p>';
//     break;
//   default: // поселки
//     $SEO_text = '<p></p>';
//     break;
// }
?>
