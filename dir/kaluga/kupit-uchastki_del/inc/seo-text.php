<?
$h2 = '';
$SEO_text = '';

$arMetaInfo = getMetaInfoPlots($arrFilterVillage);

use Bitrix\Main\Grid\Declension;
$areaDeclension = new Declension('участок', 'участка', 'участков');
$areaName = $areaDeclension->get($arMetaInfo['cntPos']);

if ($shosse)
{
  $SEO_text = '
  <p>В данном разделе представлены ▶ земельные участки на '.$arNames['NAME_KOM'].' шоссе. Здесь представлено ▶ '.$arMetaInfo['cntPos'].' '.$areaName.' с независимыми отзывами и рейтингом. Вы можете выбрать самые доступные цены на землю на '.$arNames['NAME_KOM'].' направлении ▶ стоимость варьируется от '.$arMetaInfo['minPrice'].' рублей до '.$arMetaInfo['maxPrice'].' рублей.</p>
  <p>★ Особенности проекта Poselkino ★ - для каждого объекта мы подбираем данные:</p>';
}
elseif ($rayon)
{
  $SEO_text = '<p>В данном разделе представлены ▶ земельные участки в '.$arNames['NAME_KOM'].' районе. Здесь представлено ▶ '.$arMetaInfo['cntPos'].' '.$areaName.' с независимыми отзывами и рейтингом. Вы можете выбрать самые доступные цены на землю в '.$arNames['NAME_KOM'].' районе ▶ стоимость варьируется от '.$arMetaInfo['minPrice'].' рублей до '.$arMetaInfo['maxPrice'].' рублей.</p>
  <p>★ Особенности проекта Poselkino ★ - для каждого объекта мы подбираем данные:</p>';
}
elseif($mkadKM)
{
  $SEO_text = '<p>В данном разделе представлены ▶ земельные участки в '.$mkadKM.' км от МКАД. Здесь представлено ▶ '.$arMetaInfo['cntPos'].' '.$areaName.' с независимыми отзывами и рейтингом. Вы можете выбрать самые доступные цены на землю в '.$mkadKM.' км от МКАД ▶ стоимость варьируется от '.$arMetaInfo['minPrice'].' рублей до '.$arMetaInfo['maxPrice'].' рублей.</p>
  <p>★ Особенности проекта Poselkino ★ - для каждого участка мы подбираем данные:</p>';
}

$SEO_text .= '
<ul>
  <li>✔Видео с квадрокоптера;</li>
  <li>✔Экология местности вокруг объекта;</li>
  <li>✔Отзывы покупателей;</li>
  <li>✔Данные о юридической чистоте;</li>
  <li>✔Стоимость всех коммуникаций.</li>
</ul>';
?>
