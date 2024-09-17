<?php
libxml_use_internal_errors(TRUE); //Отключить вывод ошибок при обработке страниц полученных сайтов
const SITE_NAME = 'tpom'; //Название сайта для получения настроек конкретного парсера из config.json
const FILES_ROOT = '/var/www/u0428181/data/www/olne.ru/local/parsers/'.SITE_NAME.'/';

//Получение и запись в переменные настроек из файла config.json
$configuration = get_config();
$parser = new Parser($configuration);

//Создание dom и xpath для главной страницы
$dom = new DOMDocument();
$dom->loadHTML($parser->open_main_page("{$parser->base_site_link}/genplan.html"));
$main_page = new DOMXPath($dom);

//Получение всех поселков страницы
foreach($main_page->query('//div[@class = "row"]/div[@class="col-lg-4"]') as $li)
{
    //Для экономии оперативной памяти парер в конкретный момент времени содержит
    //информацию только об одном поселке и участке, которая заменяется новой при записи в файл.



    //Получение ссылки на страницу данного поселка
    $village_link = $main_page->query('figure/a', $li);
    if ($village_link->length == 0)
        $village_link = $main_page->query('a', $li);
    $village_link = $parser->base_site_link.($village_link[0]->getAttribute('href'));

    $file_contest = $parser->open_village_page($village_link);
    if (!$file_contest)
        continue;

    //Создание dom и xpath данного поселка
    $village_dom = new DOMDocument();
    $village_dom->loadHTML($file_contest);
    $village_page = new DOMXPath($village_dom);

    //Получение участков данного поселка
    $plots = $village_page->query('//map[@name = "mainMap"]/area');
    if ($plots == null || sizeof($plots) == 0)
    {
        $parser->reg_parse_error('plots not found', "Не удалось найти участки в поселке со сыллкой '$village_link'");
        continue;
    }
    //Запись имени и количества участков в поселке
    $parser->add_village_info('name', explode('"', $main_page->query('div[@class = "field-name"]', $li)[0]->textContent)[1]);
    $parser->add_village_info('plots_count', sizeof($plots));

    //Перезапись все участков на только те, что продаются
    $plots = $village_page->query('//div[@class="field-table"]/table/tbody/tr');

    //Получение галереи данного поселка
    $galery_file = explode('/', $village_link);
    $galery_file = substr($galery_file[sizeof($galery_file) - 1], 0, -4);
    $file_contest = file_get_contents("$parser->base_site_link/gallery/gallery-$galery_file.html");
    if (!$file_contest)
        $parser->reg_parse_error('gallery not found', "Не удалось получить галерею поселка со ссылкой '$village_link'.");

    //Создание dom и xpath галереи данного поселка
    $gallery_dom = new DOMDocument();
    $gallery_dom->loadHTML($file_contest);
    $gallery_page = new DOMXPath($gallery_dom);

    //Получение изображений в галерее
    $buf = $gallery_page->query('//div[@class = "grid-item"]/a');
    if (sizeof($buf) > 0)
        foreach ($buf as $village_link_add)
            $parser->add_village_info('link', $parser->base_site_link.$village_link_add->getAttribute('href'));
    else
        $parser->reg_parse_error('gallery images not found', "Изображения в галерее не найдены - участок $num в ".$village_arr['village_name']);


    output_information("\nНачат парсинг поселка ".$parser->getVillageProperty('name').', всего в нем '.$parser->getVillageProperty('plots_count').' участков', true);
    foreach($plots as $plot)
    {
        set_time_limit(20); //Добавление времени работы скрипта с каждым участком

        //Получение характеристик данного участка
        $chars = $village_page->query('td', $plot);
        if (preg_replace('/[ \t\n]/', '', $chars[3]->textContent) != 'Продается')
            continue;


        //Запись информации об участке

        $num = preg_replace('/[^0-9]/', '', $chars[0]->textContent);
        $parser->add_plot_info('num_id', $num);
        $parser->add_plot_info('price', $chars[2]->textContent);
        $parser->add_plot_info('area', $chars[1]->textContent);

        $parser->dump_plot_info();
    }
    $parser->dump_village_info();
}
$parser->end_parsing_session();
function get_config() //Получить текущие настройки парсера из файла config.json
{
    $config_str = file_exists(FILES_ROOT.'config.json') ? file_get_contents(FILES_ROOT.'config.json') : false;

    //Если config.json не существует, создать его
    if (!$config_str)
    {
        $config_str = '{
        "max_logs_size" : 10485760,
        "'.SITE_NAME.'":
        {
            "use_logs" : false,

            "output_errores" : true,
            "output_warnings" : true,
            "output_plots" : true,
            "output_villages" : true,

            "create_new_files": false,
            "max_copies" : 1,
            "max_images" : 1,

            "keep_zero_villages" : false,

            "base_site_link" : "https://'.SITE_NAME.'.ru",
            "village_filename" : "villages_'.SITE_NAME.'",
            "plots_filename" : "plots_'.SITE_NAME.'"
        }
    }';
        file_put_contents(FILES_ROOT.'config.json', $config_str);
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
            "output_warnings" : true,
            "output_plots" : true,
            "output_villages" : true,

            "create_new_files": false,
            "max_copies" : 1,
            "max_images" : 1,

            "keep_zero_villages" : false,

            "base_site_link" : "https://'.SITE_NAME.'.ru",
            "village_filename" : "villages_'.SITE_NAME.'",
            "plots_filename" : "plots_'.SITE_NAME.'"
        }
    }';
        file_put_contents(FILES_ROOT.'config.json', $config_str);
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

function client_format_str(string $str, int $flag)
{
    switch ($flag)
    {
    case 0:
        return preg_replace('/[\n]/', "\r\n", $str);
    case 1:
        return '<span>'.preg_replace('/[\n]/', '<br>', $str).'</span>';
    }
}
function output_error($description) //Вывести сообщение об ошибке
{
    switch (PHP_SAPI)
    {
    case 'cli':
        echo "\r\nОшибка: ".client_format_str($description, 0);
        break;
    default:
        echo "<br/><b>Ошибка: </b>".client_format_str($description, 1);
        break;
    }
}

function output_warning($description)//Вывести предупреждение
{
    global $configuration;

    switch (PHP_SAPI)
    {
    case 'cli':
        echo "\r\nВнимание: ".client_format_str($description, 0);
        break;
    default:
        echo "<br/><b>Внимание: </b>".client_format_str($description, 1);
        break;
    }

    global $use_logs;
    if ($use_logs)
        file_put_contents(FILES_ROOT.'logs.txt', date('Y-m-d H:i:s').": Предупреждение -  $description\n", FILE_APPEND);
}

function output_information($description, $bold = false) //Вывести любую информацию
{
    switch (PHP_SAPI)
    {
    case 'cli':
        echo client_format_str($description, 0);
        break;
    default:
        echo ($bold ? '<b>' : '').client_format_str($description, 1).($bold ? "</b>" : '');
        break;
    }
}
function debug_output($information, $beg_str = '', $end_str = '', $new_line = true) //Вывести техническую информацию. Нужна для разработки
{
    echo ($new_line ? '<br/>' : '')."<b>$beg_str</b>".'|';
    var_dump($information);
    echo "|<b>$end_str</b>";
}

class Parser
{
    private array $plot_arr = [];//Масссив, содержащий данные о текущем участке
    private array $village_arr = []; //Масссив, содержащий данные о текущем поселке
    private array $parser_errores = []; //Ошибки, возникшие в ходе парсинга
    private array $configuration; //Настройки парсера
    private array $customs = [];
    private array $gallery_links = [];
    private int $gallery_index;
    readonly string $village_filename;
    readonly string $plots_filename;
    readonly string $base_site_link;

    function __construct($configuration)
    {
        $this->village_arr = ['name' => 'Название поселка', 'last_update' => 'Последнее обновление',
        'one_price_from' => 'Стоимость сотки ОТ', 'one_price_to' => 'Стоимость сотки ДО',
        'price_from' => 'Стоимость участков ОТ', 'price_to' => 'Стоимость участков ДО',
        'area_from' => 'Площадь участков ОТ', 'area_to' => 'Площадь участков ДО',
        'plots_count' => 'Участков в поселке', 'plots_on_sale' => 'Участков в продаже'];

        $this->plot_arr = ['name' => 'Название поселка', 'last_update' => 'Последнее обновление', 'num_id' => 'Номер участка',
        'price' => 'Стоимость участка', 'area' => 'Площадь участка',
        'cadastral_number' => 'Кадастровый номер', 'links' => 'Ссылки на фото'];

        $this->configuration = $configuration;
        $this->village_filename = FILES_ROOT.$this->configuration[SITE_NAME]['village_filename'];
        $this->plots_filename = FILES_ROOT.$this->configuration[SITE_NAME]['plots_filename'];
        $this->base_site_link = $this->configuration[SITE_NAME]['base_site_link'];
        $this->gallery_index = 0;
        $this->initialize_files();
    }

    private function initialize_files()
    {
        //Если включено use_buffer сохранить данные из текущего файла
        $this->customs['buff_plots'] = [];
        $this->customs['buff_villages'] = [];

        $village_information = file_exists($this->configuration[SITE_NAME]['village_filename'].'.csv') ?
            fopen($this->configuration[SITE_NAME]['village_filename'].'.csv', 'r') : false;

        if ($village_information)
        {
            fgets($village_information);
            while (!feof($village_information))
                $this->customs['buff_villages'][] = explode(';', substr(fgets($village_information), 0, -1));
            fclose($village_information);
        }

        $plots_information = file_exists($this->configuration[SITE_NAME]['plots_filename'].'.csv') ?
                fopen($this->configuration[SITE_NAME]['plots_filename'].'.csv', 'r') : false;
        if ($plots_information)
        {
            fgets($plots_information);
            while (!feof($plots_information))
                $this->customs['buff_plots'][] = explode(';', substr(fgets($plots_information), 0, -1));
            fclose($plots_information);
        }

        //Если включено create_new_files создать новую копию файла. Копия не влияет на оригинальный файл, но и id сохраняет только оттуда
        if ($this->configuration[SITE_NAME]['create_new_files'] && file_exists($this->configuration[SITE_NAME]['village_filename'].'.csv'))
        {
            $village_version = 1;
            while (file_exists($this->configuration[SITE_NAME]['village_filename']."{$village_version}.csv") && $village_version < $this->configuration[SITE_NAME]['max_copies'])
                ++$village_version;
            $this->village_filename = $this->configuration[SITE_NAME]['village_filename']."{$village_version}";

            if (file_exists($this->configuration[SITE_NAME]['plots_filename']."{$village_version}.csv") && $village_version <= $this->configuration[SITE_NAME]['max_copies'])
            {
                $plot_version = $village_version;
                while (file_exists($this->configuration[SITE_NAME]['plots_filename']."{$village_version}_$plot_version.csv") && $plot_version < $this->configuration[SITE_NAME]['max_copies'])
                    ++$plot_version;
                $this->plots_filename = $this->configuration[SITE_NAME]['plots_filename']."{$village_version}_$plot_version";
            }
            else
                $this->plots_filename = $this->configuration[SITE_NAME]['plots_filename']."{$village_version}";

        }

        //Если включено использование логов и файл логов меньше максимального размера, записать начало новой сессии парсинга
        if ($this->configuration[SITE_NAME]['use_logs'])
            file_put_contents(FILES_ROOT.'logs.txt', "[НОВАЯ СЕССИЯ: ".SITE_NAME." - ".date('Y-m-d H:i:s')."]\n", FILE_APPEND);
    }

    function open_main_page($link)
    {
        $contest = file_get_contents($link);
        if (!$contest)
        {
            $this->reg_parse_error('main page not found', 'Не удалось получить главную страницу сайта.');
            $this->end_parsing_session();
        }

        file_put_contents($this->plots_filename.".csv", $this->get_plot_str());
        foreach ($this->plot_arr as &$param)
            $param = null;

        file_put_contents($this->village_filename.".csv", $this->get_village_str());
        foreach ($this->village_arr as &$param)
            $param = null;

        return $contest;
    }
    function open_village_page($link)
    {
        $file_contest = file_get_contents($link);
        if (!$file_contest)
            $this->reg_parse_error('village not found', "Не удалось получить поселок по ссылке $link.");
        return $file_contest;
    }

    function open_plot_page($link)
    {
        $file_contest = file_get_contents($link);
        if (!$file_contest)
            $this->reg_parse_error('plots not found', "Не удалось получить участки поселка ".$this->village_arr['name']." по ссылке $link.");
        return $file_contest;
    }

    function getVillageProperty($property_name)
    {
        return $this->village_arr[$property_name];
    }
    function getPlotProperty($property_name)
    {
        return $this->plot_arr[$property_name];
    }
    function add_plot_info($attribute, $info)
    {
        switch ($attribute)
        {
            case 'name':
                if ($info == null || $info == ''){
                    $this->reg_parse_error('village name not found', "Имя поселка для участка ".$this->plot_arr['num_id']);
                    break;
                }
                $this->plot_arr['name'] = preg_replace('/^\s+|\s+$|\s+(?=\s)/', '', $info);

                if ( $this->plot_arr['name'] == '')
                    $this->reg_parse_error('village name not found', "Имя поселка для участка ".$this->plot_arr['num_id']);
                break;
            case 'num_id':
                $this->plot_arr['num_id'] = preg_replace('/(\D\D+)|(\D+$)|(\A\D)/', '', $info);
                break;
            case 'price':
                if ($info == null || $info == ''){
                    $this->reg_parse_error('price not found', "Цена участка ".$this->plot_arr['num_id'].' не найдена');
                    break;
                }
                $this->plot_arr['price'] = (int)preg_replace('/[^0-9]/', '', $info);

                if ($this->plot_arr['price'] == 0)
                {
                    $this->reg_parse_error('price not found', "Цена участка ".$this->plot_arr['num_id'].' не найдена');
                    $this->plot_arr['price'] = null;
                }
                break;
            case 'area':
                if ($info == null || $info == ''){
                    $this->reg_parse_error('area not found', "Площадь участка ".$this->plot_arr['num_id'].' не найдена');
                    break;
                }
                $this->plot_arr['area'] = preg_replace('/[^0-9,.]/', '', $info);
                $this->plot_arr['area'] = (float)preg_replace('/,/', '.', $this->plot_arr['area']);

                if ($this->plot_arr['area'] == 0){
                    $this->reg_parse_error('area not found', "Площадь участка ".$this->plot_arr['num_id'].' не найдена');
                    $this->plot_arr['area'] = null;
                    break;
                }
                break;
            case 'cadastral_number':
                if ($info == null || $info == ''){
                    $this->reg_parse_error('cadastral number not found', "Кадастровый номер участка ".$this->plot_arr['num_id'].' не найден');
                    break;
                }
                $this->plot_arr['cadastral_number'] = preg_replace('/[^0-9:]/', '', $info);

                if ($info == null || $info == ''){
                    $this->reg_parse_error('cadastral number not found', "Кадастровый номер участка ".$this->plot_arr['num_id'].' не найден');
                    break;
                }
                break;
            case 'link':
                if ($info == null || $info == ''){
                    $this->reg_parse_error('image not found', "Ссылка на изображение для участка ".$this->plot_arr['num_id'].' не найдено');
                    break;
                }

                if (!in_array($info, $this->gallery_links))
                    $this->gallery_links[] = $info;
                break;
            default:
                debug_output('Нет такого ключа как '.$attribute);
                break;
        }
    }

    function add_village_info($attribute, $info)
    {
        switch ($attribute)
        {
            case 'name':
                if ($info == null || $info == ''){
                    $this->reg_parse_error('village name not found', "Имя поселка не найдено");
                    break;
                }
                $this->village_arr['name'] = preg_replace('/^\s+|\s+$|\s+(?=\s)/', '', $info);
                $this->plot_arr['name'] = $this->village_arr['name'];
                break;

            case 'plots_count':
                if ($info == null || $info == ''){
                    $this->reg_parse_error('plots count not found', "Количество участков в поселке ".$this->village_arr['name']." не найдено");
                    break;
                }
                $this->village_arr['plots_count'] = (int)preg_replace('/[^0-9]/', '', $info);
                break;
            case 'link':
                if ($info == null || $info == ''){
                    $this->reg_parse_error('image not found', "Ссылка на изображение не найдена");
                    break;
                }

                if (!in_array($info, $this->gallery_links))
                    $this->gallery_links[] = $info;

                break;
            default:
                debug_output('Нет такого ключа как '.$attribute);
                break;
        }

    }

    function get_village_str()
    {
        $str = '';
        foreach ($this->village_arr as &$param) $str .= ";$param";
        return substr($str, 1);
    }

    function get_plot_str()
    {
        $str = '';
        foreach ($this->plot_arr as &$param) $str .= ";$param";
        return substr($str, 1);
    }
    function compute_village_arr() //Внести коррективы в минимальные и максимальные параметры поселка в соответствии с текущим участком
    {
        if ($this->plot_arr['area'])
        {
            if ($this->village_arr['area_from'])
            {
                $this->village_arr['area_from'] = min($this->plot_arr['area'], $this->village_arr['area_from']);
                $this->village_arr['area_to'] = max($this->plot_arr['area'], $this->village_arr['area_to']);
            }
            else
            {
                $this->village_arr['area_from'] = $this->plot_arr['area'];
                $this->village_arr['area_to'] = $this->plot_arr['area'];
            }
        }
        if ($this->plot_arr['price'])
        {
            if ($this->village_arr['price_from'])
            {
                $this->village_arr['price_from'] = min($this->plot_arr['price'], $this->village_arr['price_from']);
                $this->village_arr['price_to'] = max($this->plot_arr['price'], $this->village_arr['price_to']);
            }
            else
            {
                $this->village_arr['price_from'] = $this->plot_arr['price'];
                $this->village_arr['price_to'] = $this->plot_arr['price'];
            }
        }
        if ($this->plot_arr['price'] && $this->plot_arr['area'])
        {
            $price_one = (int)($this->plot_arr['price']/$this->plot_arr['area']);
            if ($this->village_arr['one_price_from'])
            {
                $this->village_arr['one_price_from'] = min($price_one, $this->village_arr['one_price_from']);
                $this->village_arr['one_price_to'] = max($price_one, $this->village_arr['one_price_to']);
            }
            else
            {
                $this->village_arr['one_price_from'] = $price_one;
                $this->village_arr['one_price_to'] = $price_one;
            }
        }
    }

    function dump_plot_info()
    {
        if (sizeof($this->gallery_links) > 0)
        {
            for ($i = 0;$i < sizeof($this->gallery_links) && $i < $this->configuration[SITE_NAME]['max_images'];++$i)
            {
                if ($this->gallery_index >= sizeof($this->gallery_links))
                    $this->gallery_index = 0;

                $this->plot_arr['links'] .= ';'.$this->gallery_links[$this->gallery_index];
                ++$this->gallery_index;
            }
            $this->plot_arr['links'] = substr( $this->plot_arr['links'], 1);
        }

        if (sizeof($this->customs['buff_plots']) > 0)
        {
            foreach($this->customs['buff_plots'] as $saved_index => &$saved_value)
            {
                if ($this->plot_arr['num_id'] == $saved_value[2] && $this->plot_arr['name'] == $saved_value[0])
                {
                    $diff = array_diff($this->plot_arr, $saved_value);
                    if (sizeof($diff) > 2 || (sizeof($diff) > 1 && !array_key_exists('links', $diff)))
                        $this->plot_arr['last_update'] = date('d.m.Y H:i');
                    else
                        $this->plot_arr['last_update'] = $saved_value[1];
                    unset($this->customs['buff_plots'][$saved_index]);
                    break;
                }
            }
        }
        else
            $this->plot_arr['last_update'] = date('d.m.Y H:i');


        file_put_contents("$this->plots_filename.csv", "\n".$this->get_plot_str(), FILE_APPEND);

        $this->compute_village_arr();
        $this->village_arr['plots_on_sale'] += 1;
        if ($this->configuration[SITE_NAME]['output_plots'])
            output_information("\nПолучен участок ".$this->plot_arr['num_id'].' в поселке '.$this->plot_arr['name']);

        $this->plot_arr['num_id'] = null;
        $this->plot_arr['price'] = null;
        $this->plot_arr['area'] = null;
        $this->plot_arr['cadastral_number'] = null;
        $this->plot_arr['links'] = null;
    }
    function dump_village_info()
    {
        if (sizeof($this->customs['buff_villages']) > 0)
        {
            foreach($this->customs['buff_villages'] as $saved_index => &$saved_value)
            {
                if ($this->village_arr['name'] == $saved_value[0])
                {
                    $diff = array_diff($this->village_arr, $saved_value);
                    if (sizeof($diff) > (array_key_exists('last_update', $diff)))
                        $this->village_arr['last_update'] = date('d.m.Y H:i');
                    else
                        $this->village_arr['last_update'] = $saved_value[1];
                    unset($this->customs['buff_villages'][$saved_index]);
                    break;
                }
            }
        }
        else
            $this->village_arr['last_update'] = date('d.m.Y H:i');

        if ($this->village_arr['plots_on_sale'] == 0 && !$this->configuration[SITE_NAME]['keep_zero_villages'])
        {
            //Если в поселке 0 продаваемых участков, пропустить его
            if ($this->configuration[SITE_NAME]['output_warnings'])
            {
                if (array_key_exists('not_wriiten_warning', $this->customs))
                    output_information("\nВ поселке ".$this->village_arr['name'].' не найдены участки в продаже, поселок не записан.');
                else
                {
                    $this->reg_parse_warning('plots on sale not found', 'В поселке '.$this->village_arr['name'].' не найдены участки в продаже, поселок не записан. Чтобы оставлять такие поселки, поменяйте в файле config.json для '.SITE_NAME.' настройку keep_zero_villages на true.');
                    $this->customs['not_wriiten_warning'] = true;
                }
            }
            foreach ($this->village_arr as &$param)
                $param = null;
            $this->gallery_links = [];
            return;
        }

        file_put_contents("$this->village_filename.csv", "\n".$this->get_village_str(), FILE_APPEND);
        if ($this->configuration[SITE_NAME]['output_villages'])
            output_information("\nПоселок ".$this->village_arr['name']." получен, пройдено через ".$this->village_arr['plots_on_sale']." участков\n", true);

        foreach ($this->village_arr as &$param)
            $param = null;
        $this->gallery_links = [];
    }

    function reg_parse_error($error_name, $description) //Добавляет ошибку в массив $parser_errores и записывает её в файл logs.txt
    {
        if ($this->configuration[SITE_NAME]['use_logs'] || $this->configuration[SITE_NAME]['output_errores'])
        {
            if (!array_key_exists($error_name, $this->parser_errores))
                $this->parser_errores[$error_name] = 1;
            else
                $this->parser_errores[$error_name] += 1;

            if ($this->configuration[SITE_NAME]['use_logs'])
                file_put_contents(FILES_ROOT.'logs.txt', date('Y-m-d H:i:s')."$description\n", FILE_APPEND);
            if ($this->configuration[SITE_NAME]['output_errores'])
                output_error($description);
        }
    }

    private function reg_parse_warning($warning_name, $description)
    {
        if ($this->configuration[SITE_NAME]['use_logs'])
        {
            if ($this->configuration[SITE_NAME]['use_logs'])
                file_put_contents(FILES_ROOT.'logs.txt', date('Y-m-d H:i:s').": $warning_name - $description\n", FILE_APPEND);
        }

        if ($this->configuration[SITE_NAME]['output_warnings'])
            output_warning($description);
    }

    function end_parsing_session() //Завершить сессию парсинга
    {
        if (PHP_SAPI == 'cli')
        {
            echo "\n\nПарсинг завершен";
            if ($this->configuration[SITE_NAME]['output_errores'] && sizeof($this->parser_errores) > 0)
            {
                echo ", сгенерированно:\r\n";
                foreach ($this->parser_errores as $error_key => $error_value)
                    echo "\r\nОшибка $error_key $error_value раз;";
                if (!$this->configuration[SITE_NAME]['use_logs'])
                    echo "\nИзмените настройку use_logs на true в config.json чтобы увидеть подробности в txt файле.";
            }

        }
        else
        {
            echo '<br><br><b> Парсинг завершен';
            if ($this->configuration[SITE_NAME]['output_errores'] && sizeof($this->parser_errores) > 0)
            {
                echo ", сгенерированно:</b><br/>";
                foreach ($this->parser_errores as $error_key => $error_value)
                    echo "<span> Ошибка $error_key $error_value раз; </span><br/>";
                if ($this->configuration[SITE_NAME]['use_logs'])
                    echo "<br/><b>Измените настройку use_logs на true в config.json чтобы увидеть подробности в txt файле.</b>";
            }

        }

        if ($this->configuration[SITE_NAME]['use_logs'] && !(file_exists('logs.txt') && (filesize('logs.txt') >= $this->configuration['max_logs_size'])))
            file_put_contents(FILES_ROOT.'logs.txt', "[КОНЕЦ СЕССИИ: ".SITE_NAME." - ".date('Y-m-d H:i:s')."]\n\n", FILE_APPEND);

        exit;
    }
}
