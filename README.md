<h1> Подключение </h1>
require "vendor/autoload.php";
<h1> Использование </h1>
<h2>SiteMap::createFile($array, $type, $path); </h2> <br>
$array - массив данных о сайте (сайтах) вида <br> <pre>
$array = [ 
    [
        'loc'=> 'https://github.com',
        'lastmod' => '2022-12-20',
        'priority' => '1',
        'changefreq' => 'never'
    ]
]; </pre>
$type -  строка - тип создаваемоего файла, в зависимости от типа меняется формат данных внутри файла. Поддерживаемые типы - JSON, XML, CSV <br>
$path -  строка - путь по которому нужно будет сохранить создаваемый файл
