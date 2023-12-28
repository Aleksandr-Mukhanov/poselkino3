<?
$onlyParam = false;

if ($shosse && $mkadKM)
{
  $newH1 = 'Земельные участки на '.$arNames['NAME_KOM'].' шоссе до '.$mkadKM.' км от МКАД';
  $newTitle = 'Земельные участки на '.$arNames['NAME_KOM'].' шоссе до '.$mkadKM.' км от МКАД';
  $newDesc = '▶Земельные участки на '.$arNames['NAME_KOM'].' шоссе до '.$mkadKM.' км от МКАД ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($shosse && $priceURL)
{
  $newH1 = 'Земельные участки на '.$arNames['NAME_KOM'].' шоссе до '.$priceURL.' '.$nameBC.' рублей';
  $newTitle = 'Купить участок на '.$arNames['NAME_KOM'].' шоссе до '.$priceURL.' '.$nameBC.' рублей';
  $newDesc = '▶Земельные участки на '.$arNames['NAME_KOM'].' шоссе до '.$priceURL.' '.$nameBC.' рублей ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($shosse && $areaUrl)
{
  $newH1 = 'Земельные участки на '.$arNames['NAME_KOM'].' шоссе площадью '.$areaUrl.' '.$nameArea;
  $newTitle = 'Купить участок на '.$arNames['NAME_KOM'].' шоссе площадью '.$areaUrl.' '.$nameArea;
  $newDesc = '▶Земельные участки на '.$arNames['NAME_KOM'].' шоссе площадью '.$areaUrl.' '.$nameArea.' ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($shosse && $classCode)
{
  $newH1 = 'Земельные участки на '.$arNames['NAME_KOM'].' шоссе '.$nameClass2.' класса';
  $newTitle = 'Купить участок на '.$arNames['NAME_KOM'].' шоссе '.$nameClass2.' класса';
  $newDesc = '▶Земельные участки на '.$arNames['NAME_KOM'].' шоссе '.$nameClass2.' класса ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($shosse && $commun)
{
  $newH1 = 'Земельные участки на '.$arNames['NAME_KOM'].' шоссе '.$communTxt;
  $newTitle = 'Купить участок на '.$arNames['NAME_KOM'].' шоссе '.$communTxt;
  $newDesc = '▶Земельные участки на '.$arNames['NAME_KOM'].' шоссе '.$communTxt.' ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($shosse && $typeURL)
{
  $newH1 = 'Земельные участки на '.$arNames['NAME_KOM'].' шоссе '.$inChainItem;
  $newTitle = 'Купить участок на '.$arNames['NAME_KOM'].' шоссе '.$inChainItem;
  $newDesc = '▶Земельные участки на '.$arNames['NAME_KOM'].' шоссе '.$inChainItem.' ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
if ($rayon && $mkadKM)
{
  $newH1 = 'Земельные участки в '.$arNames['NAME_KOM'].' районе до '.$mkadKM.' км от МКАД';
  $newTitle = 'Земельные участки в '.$arNames['NAME_KOM'].' районе до '.$mkadKM.' км от МКАД';
  $newDesc = '▶Земельные участки в '.$arNames['NAME_KOM'].' районе до '.$mkadKM.' км от МКАД ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;

}
elseif ($rayon && $priceURL)
{
  $newH1 = 'Земельные участки в '.$arNames['NAME_KOM'].' районе до '.$priceURL.' '.$nameBC.' рублей';
  $newTitle = 'Купить участок в '.$arNames['NAME_KOM'].' районе до '.$priceURL.' '.$nameBC.' рублей';
  $newDesc = '▶Земельные участки в '.$arNames['NAME_KOM'].' район до '.$priceURL.' '.$nameBC.' рублей ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($rayon && $areaUrl)
{
  $newH1 = 'Земельные участки в '.$arNames['NAME_KOM'].' районе площадью '.$areaUrl.' '.$nameArea;
  $newTitle = 'Купить участок в '.$arNames['NAME_KOM'].' районе площадью '.$areaUrl.' '.$nameArea;
  $newDesc = '▶Земельные участки в '.$arNames['NAME_KOM'].' районе площадью '.$areaUrl.' '.$nameArea.' ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($rayon && $classCode)
{
  $newH1 = 'Земельные участки в '.$arNames['NAME_KOM'].' районе '.$nameClass2.' класса';
  $newTitle = 'Купить участок в '.$arNames['NAME_KOM'].' районе '.$nameClass2.' класса';
  $newDesc = '▶Земельные участки в '.$arNames['NAME_KOM'].' районе '.$nameClass2.' класса ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($rayon && $commun)
{
  $newH1 = 'Земельные участки в '.$arNames['NAME_KOM'].' районе '.$communTxt;
  $newTitle = 'Купить участок в '.$arNames['NAME_KOM'].' районе '.$communTxt;
  $newDesc = '▶Земельные участки в '.$arNames['NAME_KOM'].' районе '.$communTxt.' ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($rayon && $typeURL)
{
  $newH1 = 'Земельные участки в '.$arNames['NAME_KOM'].' районе '.$inChainItem;
  $newTitle = 'Купить участок в '.$arNames['NAME_KOM'].' районе '.$inChainItem;
  $newDesc = '▶Земельные участки в '.$arNames['NAME_KOM'].' районе '.$inChainItem.' ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($mkadKM && $typeURL)
{
  $newH1 = 'Земельные участки '.$inChainItem.' до '.$mkadKM.' км от МКАД';
  $newTitle = 'Земельные участки '.$inChainItem.' до '.$mkadKM.' км от МКАД';
  $newDesc = '▶Земельные участки '.$inChainItem.' районе до '.$mkadKM.' км от МКАД ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;

}
elseif ($mkadKM && $commun)
{
  $newH1 = 'Земельные участки '.$communTxt.' до '.$mkadKM.' км от МКАД';
  $newTitle = 'Земельные участки '.$communTxt.' до '.$mkadKM.' км от МКАД';
  $newDesc = '▶Земельные участки '.$communTxt.' районе до '.$mkadKM.' км от МКАД ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;

}
?>
