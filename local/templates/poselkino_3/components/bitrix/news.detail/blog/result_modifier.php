﻿<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
// dump($arResult);
/* вставка статьи */
// получим статью
if($arResult['PROPERTIES']['INSERT_ARTICLE']['VALUE']){
	$arOrder = Array("SORT"=>"ASC");
	$arFilter = Array("IBLOCK_ID"=>3,"ID"=>$arResult['PROPERTIES']['INSERT_ARTICLE']['VALUE']);
	$arSelect = Array("ID","NAME","DETAIL_PAGE_URL","PREVIEW_PICTURE","PREVIEW_TEXT","ACTIVE_FROM");
	$rsElements = CIBlockElement::GetList($arOrder,$arFilter,false,false,$arSelect);
	if($arElement = $rsElements->GetNext()){
		//dump($arElement);
		$arDate = explode(' ',$arElement['ACTIVE_FROM']);
		$prevPic = CFile::GetPath($arElement["PREVIEW_PICTURE"]);
		$vstavka = '<div class="vstavka">
			<div class="items">
				<div class="item">
					<img src="'.$prevPic.'" alt="">
				</div>
				<div class="item">
					<div class="title-page">
						<h3>
							<i class="posts"></i>
							Читайте также:
						</h3>
					</div>
					<div class="links">
						<a href="'.$arElement['DETAIL_PAGE_URL'].'">
							'.$arElement['NAME'].'
						</a>
					</div>
					<div class="data">
						'.$arDate[0].'
					</div>
					<p>
						'.$arElement['PREVIEW_TEXT'].'...
						<a href="'.$arElement['DETAIL_PAGE_URL'].'">
							Читать далее...
						</a>
					</p>
				</div>
			</div>
		</div>';
		$arResult["DETAIL_TEXT"] = str_replace('%vstavka%',$vstavka,$arResult["DETAIL_TEXT"]);
	}
}

// Галереи поселков
if($arResult['PROPERTIES']['BLOCK_VIL_1']['VALUE']){
	// %block_gallery_1%
}
if($arResult['PROPERTIES']['BLOCK_VIL_2']['VALUE']){
	// %block_gallery_2%
}

/*TAGS*/
if ($arParams["SEARCH_PAGE"])
{
	if ($arResult["FIELDS"] && isset($arResult["FIELDS"]["TAGS"]))
	{
		$tags = array();
		foreach (explode(",", $arResult["FIELDS"]["TAGS"]) as $tag)
		{
			$tag = trim($tag, " \t\n\r");
			if ($tag)
			{
				$url = CHTTP::urlAddParams(
					$arParams["SEARCH_PAGE"],
					array(
						"tags" => $tag,
					),
					array(
						"encode" => true,
					)
				);
				$tags[] = '<a href="'.$url.'">'.$tag.'</a>';
			}
		}
		$arResult["FIELDS"]["TAGS"] = implode(", ", $tags);
	}
}
/*VIDEO & AUDIO*/
$mediaProperty = trim($arParams["MEDIA_PROPERTY"]);
if ($mediaProperty)
{
	if (is_numeric($mediaProperty))
	{
		$propertyFilter = array(
			"ID" => $mediaProperty,
		);
	}
	else
	{
		$propertyFilter = array(
			"CODE" => $mediaProperty,
		);
	}

	$elementIndex = array();
	$elementIndex[$arResult["ID"]] = array(
		"PROPERTIES" => array(),
	);

	CIBlockElement::GetPropertyValuesArray($elementIndex, $arResult["IBLOCK_ID"], array(
		"IBLOCK_ID" => $arResult["IBLOCK_ID"],
		"ID" => $arResult["ID"],
	), $propertyFilter);

	foreach ($elementIndex as $idx)
	{
		foreach ($idx["PROPERTIES"] as $property)
		{
			$url = '';
			if ($property["MULTIPLE"] == "Y" && $property["VALUE"])
			{
				$url = current($property["VALUE"]);
			}
			if ($property["MULTIPLE"] == "N" && $property["VALUE"])
			{
				$url = $property["VALUE"];
			}

			if (preg_match('/(?:youtube\\.com|youtu\\.be).*?[\\?\\&]v=([^\\?\\&]+)/i', $url, $matches))
			{
				$arResult["VIDEO"] = 'https://www.youtube.com/embed/'.$matches[1].'/?rel=0&controls=0showinfo=0';
			}
			elseif (preg_match('/(?:vimeo\\.com)\\/([0-9]+)/i', $url, $matches))
			{
				$arResult["VIDEO"] = 'https://player.vimeo.com/video/'.$matches[1];
			}
			elseif (preg_match('/(?:rutube\\.ru).*?\\/video\\/([0-9a-f]+)/i', $url, $matches))
			{
				$arResult["VIDEO"] = 'http://rutube.ru/video/embed/'.$matches[1].'?sTitle=false&sAuthor=false';
			}
			elseif (preg_match('/(?:soundcloud\\.com)/i', $url, $matches))
			{
				$arResult["SOUND_CLOUD"] = $url;
			}
		}
	}
}

/*SLIDER*/
$sliderProperty = trim($arParams["SLIDER_PROPERTY"]);
if ($sliderProperty)
{
	if (is_numeric($sliderProperty))
	{
		$propertyFilter = array(
			"ID" => $sliderProperty,
		);
	}
	else
	{
		$propertyFilter = array(
			"CODE" => $sliderProperty,
		);
	}

	$elementIndex = array();
	$elementIndex[$arResult["ID"]] = array(
		"PROPERTIES" => array(),
	);

	CIBlockElement::GetPropertyValuesArray($elementIndex, $arResult["IBLOCK_ID"], array(
		"IBLOCK_ID" => $arResult["IBLOCK_ID"],
		"ID" => $arResult["ID"],
	), $propertyFilter);

	foreach ($elementIndex as $idx)
	{
		foreach ($idx["PROPERTIES"] as $property)
		{
			$files = array();
			if ($property["MULTIPLE"] == "Y" && $property["VALUE"])
			{
				$files = $property["VALUE"];
			}
			if ($property["MULTIPLE"] == "N" && $property["VALUE"])
			{
				$files = array($property["VALUE"]);
			}

			if ($files)
			{
				$arResult["SLIDER"] = array();
				foreach ($files as $fileId)
				{
					$file = CFile::GetFileArray($fileId);
					if ($file && $file["WIDTH"] > 0 && $file["HEIGHT"] > 0)
					{
						$arResult["SLIDER"][] = $file;
					}
				}
			}
		}
	}
}

/* THEME */
$arParams["TEMPLATE_THEME"] = trim($arParams["TEMPLATE_THEME"]);
if ($arParams["TEMPLATE_THEME"] != "")
{
	$arParams["TEMPLATE_THEME"] = preg_replace("/[^a-zA-Z0-9_\-\(\)\!]/", "", $arParams["TEMPLATE_THEME"]);
	if ($arParams["TEMPLATE_THEME"] == "site")
	{
		$templateId = COption::GetOptionString("main", "wizard_template_id", "eshop_bootstrap", SITE_ID);
		$templateId = (preg_match("/^eshop_adapt/", $templateId)) ? "eshop_adapt" : $templateId;
		$arParams['TEMPLATE_THEME'] = COption::GetOptionString('main', 'wizard_'.$templateId.'_theme_id', 'blue', SITE_ID);
	}
	if ($arParams["TEMPLATE_THEME"] != "")
	{
		if (!is_file($_SERVER["DOCUMENT_ROOT"].$this->GetFolder()."/themes/".$arParams["TEMPLATE_THEME"]."/style.css"))
			$arParams["TEMPLATE_THEME"] = "";
	}
}
if ($arParams["TEMPLATE_THEME"] == "")
	$arParams["TEMPLATE_THEME"] = "blue";
