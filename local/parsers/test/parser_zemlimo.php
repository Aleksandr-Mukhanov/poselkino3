<?php
libxml_use_internal_errors(TRUE); //Отключить вывод ошибок при обработке страниц полученных сайтов
const SITE_NAME = 'zemlimo'; //Название сайта для получения настроек конкретного парсера из config.json

//Получение и запись в переменные настроек из файла config.json
$configuration = get_config(); 

$output_errores = $configuration[SITE_NAME]['output_errores'];
$output_plots = $configuration[SITE_NAME]['output_plots'];
$output_villages = $configuration[SITE_NAME]['output_villages'];
$create_new_files = $configuration[SITE_NAME]['create_new_files'];
$use_buffer = $configuration[SITE_NAME]['use_buffer'];
$village_filename = $configuration[SITE_NAME]['village_filename'];
$plots_filename = $configuration[SITE_NAME]['plots_filename'];
$base_site_link = $configuration[SITE_NAME]['base_site_link'];
$max_copies = $configuration[SITE_NAME]['max_copies'];
$use_logs = $configuration[SITE_NAME]['use_logs'];
//Начальная иинициализация переменных
$parser_errors = [];
$village_buf_arr = [];
$village_arr = [];
$plots_buf_arr = [];
$plots_arr = [];
$customs = [];

innit_file();
$file_contest = file_get_contents("$base_site_link/villages/");
if (!$file_contest) //Если доступ к сайту не получен, закрыть парсер
{
    reg_parse_error('main page not found', 'Не удалось получить главную страницу сайта.');
    end_parsing_session();
}

//Открытие файлов и запись в них заголовков csv таблиц
$plots_file = fopen("$plots_filename.csv", 'w');
$village_file = fopen("$village_filename.csv", 'w');
fwrite($village_file, get_village_str());
fwrite($plots_file, get_plot_str());

//Создание dom и xpath для главной страницы
$dom = new DOMDocument();
$dom->loadHTML($file_contest);
$main_page = new DOMXPath($dom);

//Получение всех поселков страницы
foreach($main_page->query('//section[@class="container village"]/ul/li') as $village_index => $li)
{
    //Для экономии оперативной памяти парер в конкретный момент времени содержит 
    //информацию только об одном поселке и участке, которая заменяется новой при записи в файл.

    null_village_arr();// <-- Сброс информации о предыдущем поселке

    //Получение ссылки на страницу данного поселка
    $village_link = $main_page->query('a', $li)[0]->getAttribute('href');
    if (!str_starts_with($village_link, 'https://'))
        $village_link = "$base_site_link$village_link";

    $file_contest = file_get_contents($village_link);
    if (!$file_contest)
    {
        reg_parse_error('village not found', "Не удалось получить поселок со ссылкой '$village_link'.");
        continue;
    }

    //Создание dom и xpath данного поселка
    $village_dom = new DOMDocument();
    $village_dom->loadHTML($file_contest);
    $village_page = new DOMXPath($village_dom);

    //Запись имени
    $village_arr['village_name'] = $main_page->query('div[@class = "sale__item-content"]/a/h3', $li)[0]->textContent;

    //Получение id поселка для запроса к БД на хосте
    $id_poselok = (int)($village_page->query('//svg[@data-poselok != ""]')[0]->getAttribute('data-poselok'));
    $post_data = ['poselok_id' => $id_poselok];
    if ($village_arr['village_name'] == 'Резиденция Минино')
        $post_data['poselok_mainid'] = 741847;
    else
        $post_data['poselok_mainid'] = (int)($village_page->query('//section[@class="container genplan"]')[0]->getAttribute('data-mainid'));
    
    //Получить данные из БД хоста за счет POST запроса
    $plots = get_json_post("https://zemlimo.ru/bitrix/templates/zemli/ajax/ajax.php", $post_data);
    if ($plots['status'] != 200)
    {
        output_warning('Ответ сервера с базой данных - '.$plots['status']);
        continue;
    }

    //Обработать полученный ответ
    $plots = json_decode($plots['response'], true);

    //Запись количества участков в поселке
    $village_arr['plots_count'] = sizeof($plots);
    $village_arr['plots_on_sale'] = 0; // <-- В будущем с каждым пройденым участком их число будет увеличиваться

    output_information('Начат парсинг поселка '.$village_arr['village_name'].', всего в нем '.$village_arr['plots_count'].' участков', true, true, 'village');
    foreach ($plots as $plot)
    {
        set_time_limit(20); //Добавление времени работы скрипта с каждым участком

        if ($plot['PROPERTY_STATUS_VALUE'] != 'Свободен')
            continue;

        null_plots_arr(); // <-- Сброс информации о предыдущем участке
        //Получение информации об участке

        $num = $plot['ID'];
        $plots_arr['num_id'] = $plot['NAME']; //Номер участка
        $plots_arr['name'] = $village_arr['village_name']; //Имя поселка
        $plots_arr['price'] = (int)preg_replace('/[^0-9]/', '', $plot['PROPERTY_PRICE_CALC_VALUE']);//Цена
        $plots_arr['area'] =  (float)(preg_replace('/,/', '.', $plot['PROPERTY_PLOSHAD_VALUE']));//Площадь в сотках
        
        //Цена за сотку
        if ($plots_arr['price'] != null && $plots_arr['area'] != null)
            $plots_arr['price_one'] =  (int)($plots_arr['price'] / $plots_arr['area']);

        //Получение Xpath query для изображений в галерее
        $buf = null;
        if ($village_arr['village_name'] == 'Резиденция Минино')
            $buf = $village_page->query('//div[@class="gallery-slide"]/img');
        else
            $buf = $village_page->query('//div[@class="spec__galer-item"]/img');

        if (sizeof($buf) > 0)
        {
            $plots_arr['links'] = '';
            foreach ($buf as $village_link_add)
                $plots_arr['links'] .= $base_site_link.$village_link_add->getAttribute('src').';';
            $plots_arr['links'] = substr($plots_arr['links'], 0, -1);                
        }
        else
        {
            $plots_arr['links'] = null;
            if ($use_logs || $output_errores)
                reg_parse_error('gallery images not found', "Изображения в галерее не найдены - участок $num в ".$village_arr['village_name']);               
        }

        //Запись полученных данных об участке в файл
        $price_one = $plots_arr['price_one'];
        write_plots_information();
        $plots_arr['price_one'] = $price_one;

        //Увеличение кол-ва участков в продаже
        ++$village_arr['plots_on_sale'];

        //Скорректировать информацию об поселке в соответствии с текущим участком
        compute_village_arr();

        //Вывести данные об участке
        if ($output_plots)
            show_plot_information($village_link, "$village_link$num");
    }

    if ($village_arr['plots_on_sale'] == 0 && !$configuration[SITE_NAME]['keep_zero_villages'])
    {
        //Если в поселке 0 продаваемых участков, пропустить его
        if ($output_errores || $output_villages)
        {
            if (array_key_exists('not_wriiten_warning', $customs))   
                output_information('В поселке '.$village_arr['village_name'].' не найдены участки в продаже, поселок не записан.', true, false, null, true);
            else
            {
                output_warning('В поселке '.$village_arr['village_name'].' не найдены участки в продаже, поселок не записан. Чтобы оставлять такие поселки, поменяйте в файле config.json для '.SITE_NAME.' настройку keep_zero_villages на true.');
                $customs['not_wriiten_warning'] = true;
            }            
        }
        continue;
    }

    //Записать данные поселка в файл
    write_village_information();

    //Вывести данные о поселке
    if ($output_villages)
        show_village_information($village_link);
}
end_parsing_session();

function get_config() //Получить текущие настройки парсера из файла config.json
{
    $config_str = file_exists('config.json') ? file_get_contents('config.json') : false;

    //Если config.json не существует, создать его
    if (!$config_str)
    {
        $config_str = '{
        "max_logs_size" : 10485760,
        "'.SITE_NAME.'":
        {
            "use_logs" : false,

            "output_errores" : true,
            "output_plots" : true,
            "output_villages" : true,  

            "create_new_files": false,
            "max_copies" : 1,
            "use_buffer" : true,

            "keep_zero_villages" : false,

            "base_site_link" : "https://'.SITE_NAME.'.ru",
            "village_filename" : "villages_'.SITE_NAME.'",
            "plots_filename" : "plots_'.SITE_NAME.'"    
        }
    }';
        file_put_contents('config.json', $config_str);
    }
    $configuration = json_decode($config_str, true);

    //Если файл существует, но текущего парсера в нем нет, добавить текущий парсер к уже существующим
    if (!array_key_exists(SITE_NAME, $configuration))
    {
        $config_str = substr(file_get_contents('config.json'), 0, -1).',
        "'.SITE_NAME.'":
        {
            "use_logs" : false,
            
            "output_errores" : true,
            "output_plots" : true,
            "output_villages" : true,  

            "create_new_files": false,
            "max_copies" : 1,
            "use_buffer" : true,

            "keep_zero_villages" : false,

            "base_site_link" : "https://'.SITE_NAME.'.ru",
            "village_filename" : "villages_'.SITE_NAME.'",
            "plots_filename" : "plots_'.SITE_NAME.'"        
        }
    }';
        file_put_contents('config.json', $config_str);
        $configuration = json_decode($config_str, true);
    }

    //Если включен консольный вывод, вывести уведомление об этом
    if ($configuration[SITE_NAME]['output_errores'])
    {
        if (PHP_SAPI == 'cli')
            echo "Консольный вывод ошибок включен. Чтобы изменить эту настройку, поменяйте \"output_errores\" в config.json на false.\n";
        else
            echo "<b> Консольный вывод ошибок включен. Чтобы изменить эту настройку, поменяйте \"output_errores\" в config.json на false.</b><br>";
    }

    if (PHP_SAPI == 'cli')
    {
        echo "Текущие настройки парсера (configs.json):[\n
        max_logs_size : ".$configuration['max_logs_size'];

        foreach ($configuration[SITE_NAME] as $config => $value)
        {
            if (is_bool($value))
                echo "\n$config : ".($value ? 'true' : 'false'); 
            else
                echo "\n$config : $value";            
        }
        echo "]\n\n";
    }
    else
    {
        echo "Текущие настройки парсера (configs.json):[<br>
        <b>max_logs_size </b>: ".$configuration['max_logs_size'];

        foreach ($configuration[SITE_NAME] as $config => $value)
        {
            if (is_bool($value))
                echo "<br/><b>$config </b>: ".($value ? 'true' : 'false'); 
            else
                echo "<br/><b>$config </b>: $value";            
        }
        echo ']<br><br>';
    }

    if (file_exists('logs.txt') && (filesize('logs.txt') >= (int)$configuration['max_logs_size']))
        $configuration[SITE_NAME]['use_logs'] = false;
    
    return $configuration;
}

function innit_file() //Начальная инициализация village_arr и $plots_arr
{
    //Подключение глобальных переменных для изменения их внутри функции
    global $configuration;

    global $village_arr;
    global $village_filename;

    global $plots_arr;
    global $plots_filename;

    //Создание заголовков csv файлов
    $village_arr = ['village_name' => 'Название поселка', 'id' => 'id Поселкино',
    'one_price_from' => 'Стоимость сотки ОТ', 'one_price_to' => 'Стоимость сотки ДО',
    'price_from' => 'Стоимость участков ОТ', 'price_to' => 'Стоимость участков ДО',
    'area_from' => 'Площадь участков ОТ', 'area_to' => 'Площадь участков ДО',
    'plots_count' => 'Участков в поселке', 'plots_on_sale' => 'Участков в продаже'];

    $plots_arr = ['name' => 'Название поселка', 'id' => 'id Поселкино', 'num_id' => 'Номер участка',
    'price' => 'Стоимость участка', 'area' => 'Площадь участка',
    'cadastral_number' => 'Кадастровый номер', 'links' => 'Ссылки на фото'];

    //Если включено use_buffer сохранить данные из текущего файла
    if ($configuration[SITE_NAME]['use_buffer'])
    {
        global $village_buf_arr;
        global $plots_buf_arr;

        $village_information = file_exists($configuration[SITE_NAME]['village_filename'].'.csv') ? 
                fopen($configuration[SITE_NAME]['village_filename'].'.csv', 'r') : false;
        if ($village_information)
        {
            fgets($village_information);
            while (!feof($village_information))
                $village_buf_arr[] = explode(';', substr(fgets($village_information), 0, -1)); 
            fclose($village_information);      
        }

        $plots_information = file_exists($configuration[SITE_NAME]['plots_filename'].'.csv') ? 
                fopen($configuration[SITE_NAME]['plots_filename'].'.csv', 'r') : false;
        if ($plots_information)
        {
            fgets($plots_information);
            while (!feof($plots_information))
                $plots_buf_arr[] = explode(';', substr(fgets($plots_information), 0, -1));
            fclose($plots_information);        
        }
    }

    //Если включено create_new_files создать новую копию файла. Копия не влияет на оригинальный файл, но и id сохраняет только оттуда
    if ($configuration[SITE_NAME]['create_new_files'] && file_exists($configuration[SITE_NAME]['village_filename'].'.csv'))
    {
        $village_version = 1;
        while (file_exists($configuration[SITE_NAME]['village_filename']."{$village_version}.csv") && $village_version < $configuration[SITE_NAME]['max_copies'])
            ++$village_version;
        $village_filename = $configuration[SITE_NAME]['village_filename']."{$village_version}";

        if (file_exists($configuration[SITE_NAME]['plots_filename']."{$village_version}.csv") && $village_version <= $configuration[SITE_NAME]['max_copies'])
        {
            $plot_version = $village_version;
            while (file_exists($configuration[SITE_NAME]['plots_filename']."{$village_version}_$plot_version.csv") && $plot_version < $configuration[SITE_NAME]['max_copies'])
                ++$plot_version;
            $plots_filename = $configuration[SITE_NAME]['plots_filename']."{$village_version}_$plot_version";
        }
        else
            $plots_filename = $configuration[SITE_NAME]['plots_filename']."{$village_version}";

    }

    //Если включено использование логов и файл логов меньше максимального размера, записать начало новой сессии парсинга
    if ($configuration[SITE_NAME]['use_logs'])
        file_put_contents('logs.txt', "[НОВАЯ СЕССИЯ: ".SITE_NAME." - ".date('Y-m-d H:i:s')."]\n", FILE_APPEND);
}


function write_plots_information() //Записать данные, находящиеся в данный момент в plots_arr в файл csv
{
    global $plots_file;
    global $plots_arr;
    global $use_buffer;

    //Если включена опция use_buffer, искать соответствующий участок в предыдущий данных файла
    if ($use_buffer)
    {
        global $plots_buf_arr;
        foreach($plots_buf_arr as $saved_index => &$saved_value)
        {             
            if ($plots_arr['num_id'] == $saved_value[2] && $plots_arr['name'] == $saved_value[0])
            {
                $i = 0;
                foreach ($plots_arr as $param => &$value)
                {
                    if ($value === null || $value === '')
                        $plots_arr[$param] = $saved_value[$i];                            
                    
                    ++$i;
                }
                unset($plots_buf_arr[$saved_index]);
                break;                 
            }
        }
    }
    fwrite($plots_file, "\n".get_plot_str());
}

function write_village_information() //Записать данные, находящиеся в данный момент в village_arr в файл csv
{
    global $village_file;
    global $village_arr;
    global $use_buffer;

    if ($use_buffer)
    {
        global $village_buf_arr;
        foreach($village_buf_arr as $saved_index => &$saved_value)
        {
            if ($village_arr['village_name'] == $saved_value[0])
            {
                $i = 0;
                foreach ($village_arr as $param => &$value)
                {
                    if (($village_arr[$param] === null || $village_arr[$param] === '') && $saved_value[$i] != "\n")
                        $village_arr[$param] = $saved_value[$i];
                    ++$i;
                }
                unset($village_buf_arr[$saved_index]);
                break;                 
            }
        }
    }
    fwrite($village_file, "\n".get_village_str());
}

function get_plot_str() //Получить текущие данные участка для записи из plots_arr
{
    global $plots_arr;
    return $plots_arr['name'].';'.$plots_arr['id'].';'
    .$plots_arr['num_id'].';'.$plots_arr['price'].';'.$plots_arr['area'].';'
    .$plots_arr['cadastral_number'].';'.$plots_arr['links'];
}

function get_village_str() //Получить текущие данные поселка для записи из village_arr
{
    global $village_arr;
    return $village_arr['village_name'].';'.$village_arr['id'].';'
            .$village_arr['one_price_from'].';'.$village_arr['one_price_to'].';'
            .$village_arr['price_from'].';'.$village_arr['price_to'].';'
            .$village_arr['area_from'].';'.$village_arr['area_to'].';'
            .$village_arr['plots_count'].';'.$village_arr['plots_on_sale'];
}

function end_parsing_session() //Завершить сессию парсинга
{
    global $village_file;
    global $plots_file;
    global $village_buf_arr;
    global $plots_buf_arr;
    global $use_buffer;

    //Закрывает файловые потоки
    if ($village_file)
        fclose($village_file);
    if ($plots_file)
        fclose($plots_file);

    global $output_errores;
    global $parser_errors;
    global $configuration;

    if (PHP_SAPI == 'cli')
    {
        echo "\n\nПарсинг завершен";
        if ($output_errores && sizeof($parser_errors) > 0)
        {
            echo ", сгенерированно:\r\n";
            foreach ($parser_errors as $error_key => $error_value)
                echo "\r\nОшибка $error_key $error_value раз;";
            if (!$configuration[SITE_NAME]['use_logs'])
                echo "\nИзмените настройку use_logs на true в config.json чтобы увидеть подробности в txt файле.";
        }
           
    }
    else
    {
        echo '<br><br><b> Парсинг завершен';
        if ($output_errores && sizeof($parser_errors) > 0)
        {
            echo ", сгенерированно:</b><br/>";
            foreach ($parser_errors as $error_key => $error_value)
                echo "<span> Ошибка $error_key $error_value раз; </span><br/>";
            if (!$configuration[SITE_NAME]['use_logs'])
                echo "<br/><b>Измените настройку use_logs на true в config.json чтобы увидеть подробности в txt файле.</b>";
        }
        
    }

 if ($configuration[SITE_NAME]['use_logs'] && !(file_exists('logs.txt') && (filesize('logs.txt') >= (int)$configuration['max_logs_size'])))
        file_put_contents('logs.txt', "[КОНЕЦ СЕССИИ: ".SITE_NAME." - ".date('Y-m-d H:i:s')."]\n\n", FILE_APPEND);

    exit;
}

function show_village_information($village_link) //Отобразить данные о текущем поселке
{
    global $village_arr;

    switch (PHP_SAPI)
    {
    case 'cli':
        echo "\r\n\r\nПоселок $village_link получен, пройдено через "
        .$village_arr['plots_count']." участков";               
        
        echo ".\r\n\r\n";
        break;
    default:
        echo "<br/><b> Поселок <a href = \"{$village_link}\">{$village_link}</a> получен, пройдено через "
            .$village_arr['plots_on_sale']." участков";               
        
        echo '.</b><br/>';
        break;
    }
}

function show_plot_information($plot_link, $description = null) //Отобразить данные о текущем участке
{
    if ($description === null)
        $description = $plot_link;

    switch (PHP_SAPI)
    {
    case 'cli':
        echo "Получен участок: {$plot_link}";
        echo "\r\n";
        break;
    default:
        echo "<br/><span> Получен участок: <a href = \"{$plot_link}\">{$description}</a></span>";
        break;
    } 
}

function null_village_arr() //Сбросить все значения эментов массива village_arr к null
{
    global $village_arr;
    foreach ($village_arr as &$param)
        $param = null;
}

function null_plots_arr() //Сбросить все значения эментов массива plots_arr к null
{
    global $plots_arr;
    foreach ($plots_arr as &$param)
        $param = null;
}

function compute_village_arr() //Внести коррективы в минимальные и максимальные параметры поселка в соответствии с текущим участком
{
    global $village_arr;
    global $plots_arr;

    if ($plots_arr['area'])
    {
        if ($village_arr['area_from'])
        {
            $village_arr['area_from'] = min($plots_arr['area'], $village_arr['area_from']);
            $village_arr['area_to'] = max($plots_arr['area'], $village_arr['area_to']);                
        }
        else
        {
            $village_arr['area_from'] = $plots_arr['area'];
            $village_arr['area_to'] = $plots_arr['area'];
        }
    }
    if ($plots_arr['price'])
    {
        if ($village_arr['price_from'])
        {
            $village_arr['price_from'] = min($plots_arr['price'], $village_arr['price_from']);
            $village_arr['price_to'] = max($plots_arr['price'], $village_arr['price_to']);              
        }
        else
        {
        $village_arr['price_from'] = $plots_arr['price'];
        $village_arr['price_to'] = $plots_arr['price'];            
        }
    }
    if ($plots_arr['price_one'])
    {
        if ($village_arr['one_price_from'])
        {
            $village_arr['one_price_from'] = min($plots_arr['price_one'], $village_arr['one_price_from']);
            $village_arr['one_price_to'] = max($plots_arr['price_one'], $village_arr['one_price_to']);             
        }
        else
        {
        $village_arr['one_price_from'] = $plots_arr['price_one'];
        $village_arr['one_price_to'] = $plots_arr['price_one'];
        }       
    }
}

function reg_parse_error($error_name, $description) //Добавляет ошибку в массив $parser_errores и записывает её в файл logs.txt
{
    global $parser_errors;
    global $configuration;

    global $use_logs;

    if ($use_logs)
        file_put_contents('logs.txt', date('Y-m-d H:i:s')."$description\n", FILE_APPEND);
    if ($configuration[SITE_NAME]['output_errores'])
        output_error($description);

    if (array_key_exists($error_name, $parser_errors))
        $parser_errors[$error_name] += 1;
    else
        $parser_errors[$error_name] = 1;
}

function output_error($description) //Вывести сообщение об ошибке
{
    switch (PHP_SAPI)
    {
    case 'cli':
        echo "\r\Ошибка: $description";
        break;
    default:
        echo "<br/><b>Ошибка: </b><span>$description</span>";
        break;
    }
}

function output_warning($description)//Вывести предупреждение
{
    global $configuration;

    switch (PHP_SAPI)
    {
    case 'cli':
        echo "\r\nВнимание: $description";
        break;
    default:
        echo "<br/><b>Внимание: </b><span>$description</span>";
        break;
    }

    global $use_logs;
    if ($use_logs)
        file_put_contents('logs.txt', date('Y-m-d H:i:s').": Предупреждение -  $description\n", FILE_APPEND);
}

function output_information($description, $new_line = true, $bold = false, $binding = null, $log = false) //Вывести любую информацию
{

    if ($log)
    {
        global $use_logs;
        if ($use_logs)
            file_put_contents('logs.txt', date('Y-m-d H:i:s').": Информация - $description\n", FILE_APPEND);
    }

    if ($binding != null)
    {
        global $configuration;
        if ($binding == 'plot' && !$configuration[SITE_NAME]['output_plots'])
            return;
        if ($binding == 'village' && !$configuration[SITE_NAME]['output_villages'])
            return;
    }

    switch (PHP_SAPI)
    {
    case 'cli':
        echo ($new_line ? "\r\n" : null)."$description";
        break;
    default:
        echo ($new_line ? "<br>" : null).($bold ? '<b>' : '<span>').$description.($bold ? '</b>' : '</span>');
        break;
    }
}
function debug_output($information, $beg_str = '', $end_str = '', $new_line = true) //Вывести техническую информацию. Нужна для разработки
{
    echo ($new_line ? '<br/>' : '')."<b>$beg_str</b>".'|';
    var_dump($information);
    echo "|<b>$end_str</b>";
}

function get_json_post($url, $post_data)
{ 
    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($curl, CURLOPT_HEADER, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/x-www-form-urlencoded']);

    $json_response = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);

    curl_close($curl);
    $response = $json_response ? $response = $json_response : false;
    return ['status' => $status,'response' => $response];
}