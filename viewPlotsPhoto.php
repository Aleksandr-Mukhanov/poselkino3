<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader;
	Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL, Bitrix\Main\Entity;

$arElHL = getElHL(18,[],[],['*']);

foreach ($arElHL as $key => $value) {?>
  <h2><?=$value['UF_NAME']?></h2>
  <div>
    <?php foreach ($value['UF_PHOTO'] as $photo): ?>
      <img src="<?=\CFile::GetPath($photo)?>" alt="" data-amlazy-skip data-amwebp-skip width="200">
    <?php endforeach; ?>
  </div>
<?}?>
