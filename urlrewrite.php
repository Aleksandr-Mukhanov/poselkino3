<?php
$arUrlRewrite=array (
  10 => 
  array (
    'CONDITION' => '#^/poselki/filter/(.+?)/apply/\\??(.*)#',
    'RULE' => 'SMART_FILTER_PATH=$1&$2',
    'ID' => 'bitrix:catalog.smart.filter',
    'PATH' => '/poselki/index.php',
    'SORT' => 10,
  ),
  1 => 
  array (
    'CONDITION' => '#^/bitrix/services/ymarket/#',
    'RULE' => '',
    'ID' => '',
    'PATH' => '/bitrix/services/ymarket/index.php',
    'SORT' => 10,
  ),
  2 => 
  array (
    'CONDITION' => '#^/rest/#',
    'RULE' => '',
    'ID' => NULL,
    'PATH' => '/bitrix/services/rest/index.php',
    'SORT' => 20,
  ),
  3 => 
  array (
    'CONDITION' => '#^/blog/#',
    'RULE' => '',
    'ID' => 'bitrix:news',
    'PATH' => '/blog/index.php',
    'SORT' => 30,
  ),
  22 => 
  array (
    'CONDITION' => '#^/poselki/([^/]+?)/\\??(.*)#',
    'RULE' => 'ELEMENT_CODE=$1&$2',
    'ID' => 'bitrix:catalog.element',
    'PATH' => '/poselki/detail.php',
    'SORT' => 100,
  ),
  23 => 
  array (
    'CONDITION' => '#^\\??(.*)#',
    'RULE' => '&$1',
    'ID' => 'bitrix:catalog.section',
    'PATH' => '/uchastki/index.php',
    'SORT' => 100,
  ),
);
