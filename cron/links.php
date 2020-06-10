<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
\Bitrix\Main\Loader::includeModule('highloadblock');
use Bitrix\Highloadblock as HL,
  Bitrix\Main\Entity;

  // получим размещенные ссылки
  $hlblock_id = 8; // id HL
  $hlblock = HL\HighloadBlockTable::getById($hlblock_id)->fetch();
  $entity = HL\HighloadBlockTable::compileEntity($hlblock);
  $entity_data_class = $entity->getDataClass();
  $entity_table_name = $hlblock['TABLE_NAME'];
  $sTableID = 'tbl_'.$entity_table_name;

  $rsData = $entity_data_class::getList();
  $rsData = new CDBResult($rsData, $sTableID);

  while($arRes = $rsData->Fetch()){ // dump($arRes);
    $arLinks[$arRes['UF_URL_WHERE']] = [
      'URL_LEADS' => $arRes['UF_URL_LEADS'],
      'ID' => $arRes['ID'],
      'TEXT' => $arRes['UF_URL_TEXT'],
    ];
  } // dump($arLinks);

  echo 'import links<br>'; $i=0; $i1=0; $i2=0; $i3=0;
  $str = file_get_contents("../links.csv");
  $arr = explode("\n",$str);
  // dump($str);
  function trim_and_del ($val){
    $val = trim($val); // убираем пробелы
    return $val;
  }
  foreach($arr as $item){ $i++;

    if ($i == 1) continue;
    $arItem = array_map("trim_and_del",explode(";",$item)); // dump($arItem);
    if (!$arItem[0]) continue;

    if($arLinks[$arItem[0]]['URL_LEADS'] == $arItem[1]){ // если ссылка размещена
      if($arLinks[$arItem[0]]['TEXT'] != $arItem[2]){ // изменился анкор
        $data = [
          "UF_URL_TEXT" => $arItem[2],
        ];
        $result = $entity_data_class::update($arLinks[$arItem[0]]['ID'],$data);
        if($ID = $result->getId())$i2++;
      }else{
        $i3++;
      }
    }else{ // добавляем ссылку
      $data = [
        "UF_URL_WHERE" => $arItem[0],
        "UF_URL_LEADS" => $arItem[1],
        "UF_URL_TEXT" => $arItem[2],
        "UF_URL_DATE" => date('d.m.Y'),
      ];
      $result = $entity_data_class::add($data);
      if($ID = $result->getId())$i1++;
    }
  }
  echo 'Добавлено: '.$i1.'<br>';
  echo 'Обновлено анкоров: '.$i2.'<br>';
  echo 'Имеющихся: '.$i3.'<br>';
