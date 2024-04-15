<?
$onlyParam = false;

if ($shosse && $mkadKM)
{
  $newH1 = 'Частные дома на '.$arNames['NAME_KOM'].' шоссе до '.$mkadKM.' км от МКАД';
  $newTitle = 'Частные дома на '.$arNames['NAME_KOM'].' шоссе до '.$mkadKM.' км от МКАД';
  $newDesc = '▶Частные дома на '.$arNames['NAME_KOM'].' шоссе до '.$mkadKM.' км от МКАД ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($shosse && $priceURL)
{
  $newH1 = 'Частные дома на '.$arNames['NAME_KOM'].' шоссе до '.$priceURL.' '.$nameBC.' рублей';
  $newTitle = 'Купить дом на '.$arNames['NAME_KOM'].' шоссе до '.$priceURL.' '.$nameBC.' рублей';
  $newDesc = '▶Частные дома на '.$arNames['NAME_KOM'].' шоссе до '.$priceURL.' '.$nameBC.' рублей ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($shosse && $areaUrl)
{
  $newH1 = 'Частные дома на '.$arNames['NAME_KOM'].' шоссе площадью '.$areaUrl.' '.$nameArea;
  $newTitle = 'Купить дом на '.$arNames['NAME_KOM'].' шоссе площадью '.$areaUrl.' '.$nameArea;
  $newDesc = '▶Частные дома на '.$arNames['NAME_KOM'].' шоссе площадью '.$areaUrl.' '.$nameArea.' ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($shosse && $classCode)
{
  $newH1 = 'Частные дома на '.$arNames['NAME_KOM'].' шоссе '.$nameClass2.' класса';
  $newTitle = 'Купить дом на '.$arNames['NAME_KOM'].' шоссе '.$nameClass2.' класса';
  $newDesc = '▶Частные дома на '.$arNames['NAME_KOM'].' шоссе '.$nameClass2.' класса ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($shosse && $commun)
{
  $newH1 = 'Частные дома на '.$arNames['NAME_KOM'].' шоссе '.$communTxt;
  $newTitle = 'Купить дом на '.$arNames['NAME_KOM'].' шоссе '.$communTxt;
  $newDesc = '▶Частные дома на '.$arNames['NAME_KOM'].' шоссе '.$communTxt.' ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($shosse && $typeURL)
{
  $newH1 = 'Частные дома на '.$arNames['NAME_KOM'].' шоссе '.$inChainItem;
  $newTitle = 'Купить дом на '.$arNames['NAME_KOM'].' шоссе '.$inChainItem;
  $newDesc = '▶Частные дома на '.$arNames['NAME_KOM'].' шоссе '.$inChainItem.' ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
if ($rayon && $mkadKM)
{
  $newH1 = 'Частные дома в '.$arNames['NAME_KOM'].' районе до '.$mkadKM.' км от МКАД';
  $newTitle = 'Частные дома в '.$arNames['NAME_KOM'].' районе до '.$mkadKM.' км от МКАД';
  $newDesc = '▶Частные дома в '.$arNames['NAME_KOM'].' районе до '.$mkadKM.' км от МКАД ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;

}
elseif ($rayon && $priceURL)
{
  $newH1 = 'Частные дома в '.$arNames['NAME_KOM'].' районе до '.$priceURL.' '.$nameBC.' рублей';
  $newTitle = 'Купить дом в '.$arNames['NAME_KOM'].' районе до '.$priceURL.' '.$nameBC.' рублей';
  $newDesc = '▶Частные дома в '.$arNames['NAME_KOM'].' район до '.$priceURL.' '.$nameBC.' рублей ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($rayon && $areaUrl)
{
  $newH1 = 'Частные дома в '.$arNames['NAME_KOM'].' районе площадью '.$areaUrl.' '.$nameArea;
  $newTitle = 'Купить дом в '.$arNames['NAME_KOM'].' районе площадью '.$areaUrl.' '.$nameArea;
  $newDesc = '▶Частные дома в '.$arNames['NAME_KOM'].' районе площадью '.$areaUrl.' '.$nameArea.' ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($rayon && $classCode)
{
  $newH1 = 'Частные дома в '.$arNames['NAME_KOM'].' районе '.$nameClass2.' класса';
  $newTitle = 'Купить дом в '.$arNames['NAME_KOM'].' районе '.$nameClass2.' класса';
  $newDesc = '▶Частные дома в '.$arNames['NAME_KOM'].' районе '.$nameClass2.' класса ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($rayon && $commun)
{
  $newH1 = 'Частные дома в '.$arNames['NAME_KOM'].' районе '.$communTxt;
  $newTitle = 'Купить дом в '.$arNames['NAME_KOM'].' районе '.$communTxt;
  $newDesc = '▶Частные дома в '.$arNames['NAME_KOM'].' районе '.$communTxt.' ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($rayon && $typeURL)
{
  $newH1 = 'Частные дома в '.$arNames['NAME_KOM'].' районе '.$inChainItem;
  $newTitle = 'Купить дом в '.$arNames['NAME_KOM'].' районе '.$inChainItem;
  $newDesc = '▶Частные дома в '.$arNames['NAME_KOM'].' районе '.$inChainItem.' ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;
}
elseif ($mkadKM && $typeURL)
{
  $newH1 = 'Частные дома '.$inChainItem.' до '.$mkadKM.' км от МКАД';
  $newTitle = 'Частные дома '.$inChainItem.' до '.$mkadKM.' км от МКАД';
  $newDesc = '▶Частные дома '.$inChainItem.' районе до '.$mkadKM.' км от МКАД ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;

}
elseif ($mkadKM && $commun)
{
  $newH1 = 'Частные дома '.$communTxt.' до '.$mkadKM.' км от МКАД';
  $newTitle = 'Частные дома '.$communTxt.' до '.$mkadKM.' км от МКАД';
  $newDesc = '▶Частные дома '.$communTxt.' районе до '.$mkadKM.' км от МКАД ▶ Независимый рейтинг! ✔Видео с квадрокоптера ✔Экология местности ✔Отзывы покупателей ✔Юридическая чистота ✔Стоимость коммуникаций!';
  $onlyParam = true;

}
?>
