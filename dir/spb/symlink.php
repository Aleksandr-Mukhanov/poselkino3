<html>
<head><title>Создание ссылок на папки bitrix, local и upload</title></head>
<body>
<?
error_reporting(E_ALL & ~E_NOTICE);
@ini_set("display_errors",1);

if ($_POST['path'])
   $path = rtrim($_POST['path'],"/\\");
else
   $path = '/var/www/u0428181/data/www/olne.ru';

if ($_POST['create'])
{
   if (preg_match("#^/#",$path))
      $full_path = $path;
   else
      $full_path = realpath($_SERVER['DOCUMENT_ROOT'].'/'.$path);

  // symlink($path."/stroitelyam",$_SERVER['DOCUMENT_ROOT']."/stroitelyam");
  // symlink($path."/investoram",$_SERVER['DOCUMENT_ROOT']."/investoram");
  // symlink($path."/o-proekte",$_SERVER['DOCUMENT_ROOT']."/o-proekte");
  // symlink($path."/blog",$_SERVER['DOCUMENT_ROOT']."/blog");
  // symlink($path."/reklama",$_SERVER['DOCUMENT_ROOT']."/reklama");
  // symlink($path."/kontakty",$_SERVER['DOCUMENT_ROOT']."/kontakty");
  // symlink($path."/sitemap",$_SERVER['DOCUMENT_ROOT']."/sitemap");
  // symlink($path."/politika-konfidentsialnosti",$_SERVER['DOCUMENT_ROOT']."/politika-konfidentsialnosti");
  // symlink($path."/polzovatelskoe-soglashenie",$_SERVER['DOCUMENT_ROOT']."/polzovatelskoe-soglashenie");
  // symlink($path."/map",$_SERVER['DOCUMENT_ROOT']."/map");
  // symlink($path."/poisk",$_SERVER['DOCUMENT_ROOT']."/poisk");
  // symlink($path."/izbrannoe",$_SERVER['DOCUMENT_ROOT']."/izbrannoe");
  // symlink($path."/test",$_SERVER['DOCUMENT_ROOT']."/test");
  // symlink($path."/sravnenie",$_SERVER['DOCUMENT_ROOT']."/sravnenie");
  // symlink($path."/ajax",$_SERVER['DOCUMENT_ROOT']."/ajax");
  // symlink($path."/assets",$_SERVER['DOCUMENT_ROOT']."/assets");

  // symlink($path."/kupit-uchastki",$_SERVER['DOCUMENT_ROOT']."/kupit-uchastki");
  // symlink($path."/include",$_SERVER['DOCUMENT_ROOT']."/include");
  // symlink($path."/poselki",$_SERVER['DOCUMENT_ROOT']."/poselki");

  // symlink($path."/.access.php",$_SERVER['DOCUMENT_ROOT']."/.access.php");
  // symlink($path."/.section.php",$_SERVER['DOCUMENT_ROOT']."/.section.php");
  // symlink($path."/404.php",$_SERVER['DOCUMENT_ROOT']."/404.php");
  // symlink($path."/favicon.png",$_SERVER['DOCUMENT_ROOT']."/favicon.png");
  // symlink($path."/favicon.svg",$_SERVER['DOCUMENT_ROOT']."/favicon.svg");
  // symlink($path."/index.php",$_SERVER['DOCUMENT_ROOT']."/index.php");

  // symlink($path."/urlrewrite_my.php",$_SERVER['DOCUMENT_ROOT']."/urlrewrite_my.php");

   // if (file_exists($_SERVER['DOCUMENT_ROOT']."/bitrix"))
   //    $strError = "В текущей папке уже существует папка bitrix";
   // elseif (is_dir($full_path))
   // {
   //    if (is_dir($full_path."/bitrix"))
   //    {
   //       if (symlink($path."/bitrix",$_SERVER['DOCUMENT_ROOT']."/bitrix"))
   //       {
   //          if (symlink($path."/upload",$_SERVER['DOCUMENT_ROOT']."/upload"))
   //           {
   //             if (symlink($path."/local",$_SERVER['DOCUMENT_ROOT']."/local"))
   //                echo "Символические ссылки удачно созданы";
   //             else
   //             $strError = 'Не удалось создать ссылку на папку local, обратитесь к администратору сервера';
   //            }
   //         else
   //         $strError = 'Не удалось создать ссылку на папку upload, обратитесь к администратору сервера';
   //        }
   //        else
   //        $strError = 'Не удалось создать ссылку на папку bitrix, обратитесь к администратору сервера';
   //    }
   //    else
   //       $strError = 'Указанный путь не содержит папку bitrix';
   // }
   // else
   //    $strError = 'Неверно указан путь или ошибка прав доступа';

   if ($strError)
      echo ''.$strError.'Исходный путь: '.$full_path;
}
?>
<form method=post>
Путь к папке, содержащей папки bitrix, local и upload: <input name=path  value="<?=htmlspecialchars($path)?>"><br>
<input type=submit value='Создать' name=create>
</form>
</body>
</html>
