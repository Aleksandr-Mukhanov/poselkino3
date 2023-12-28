<?

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if (!empty($arResult['ERROR']))
{
	echo $arResult['ERROR'];
	return false;
}
// dump($arResult);
?>
	<div class="container hide">
		<div class="page-developer-list__sorting">
			<div class="d-flex">
				<div class="page__sort">
					<div class="text-secondary mr-2">Сортировать по</div>
					<select class="select-success select-bold selectric-select-bg-white" id="sortinng_developer">
						<option value="developer_name">Названию</option>
						<option value="developer_raiting">Рейтингу</option>
						<option value="developer_village_raiting">Рейтингу поселков</option>
						<option value="expensive" selected>Поселкам в продаже</option>
						<option value="mkad">Отзывам</option>
					</select>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="bg-gray-mobile">
	<div class="container">
		<div class="developer__list">
			<?foreach ($arResult['rows'] as $val) {
				$arDeveloper = $arResult['DEVEL'][$val['UF_XML_ID']];
				$arFile = explode('"',$val['UF_FILE']);
				$cntPos = $arDeveloper['CNT_POS'];
				$cntCom = ($arDeveloper['CNT_COMMENTS']) ? $arDeveloper['CNT_COMMENTS'].' отзыва' : 'нет отзывов';
				$ratingTotal = ($arDeveloper['CNT_COMMENTS']>0) ? round($arDeveloper['RATING_SUM'] / $arDeveloper['CNT_COMMENTS'],1) : 'нет данных';
				$posRating = ($cntPos) ? round($arDeveloper['RATING_POS'] / $cntPos,1) : 'нет данных';
				$cntPosSale = ($arDeveloper['CNT_POS_SALE']) ? $arDeveloper['CNT_POS_SALE'] : 'нет данных';
			?>
				<div class="developer__list-item">
					<div class="logo"><img src="<?=$arFile[1]?>" alt="<?=$val['UF_NAME']?>" title="<?=$val['UF_NAME']?>"></div>
					<div class="name item"><?=$val['UF_NAME']?></div>
					<div class="raiting__company item">
						<div class="item__title">Рейтинг компаний</div>
						<div class="item__value"><?=$ratingTotal?></div>
					</div>
					<div class="reviews item">
						<div class="item__title">Отзывы</div>
						<div class="item__value"><?=$cntCom?></div>
					</div>
					<div class="raiting__village item">
						<div class="item__title">Рейтинг поселков</div>
						<div class="item__value"><?=$posRating?></div>
					</div>
					<div class="village__sale item">
						<div class="item__title">Поселков в продаже</div>
						<div class="item__value"><?=$cntPosSale?></div>
					</div>
					<div class="button"><a class="btn btn-outline-warning rounded-pill d-sm-none d-md-block" href="/developery/<?=$val['UF_XML_ID']?>/">Перейти</a></div>
				</div>
			<?}?>
		</div>
	</div>
