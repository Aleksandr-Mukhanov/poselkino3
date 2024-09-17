<?php

#Данный скрипт выведет количество свободных Мегабайт в указанной директории. В строчке ниже укажите нужную для контроля директорию на сервере:
$directory='/var/www';

########################################

$free_space=disk_free_space($directory);
if ($free_space!==false) echo round($free_space/1024/1024, 2);
else echo 0;

?>
