<?php

# Данный скрипт выводит количество дней работы сервера без перезагрузки.

# Запустите данный скрипт в браузере, если ничего не выведется или появится ошибка, значит на Вашем сервере запрещена работа данного скрипта. В таком случае используйте Perl версию этого скрипта.
$res=`uptime`;

if (preg_match('/([0-9]+) day/i',$res,$matches)) {
	print $matches[1];
}
else {
	print '0';
}

?>