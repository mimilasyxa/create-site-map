<h1>Как она работает</h2>
Для создания карты сайта в различных файловых форматах: xml, csv, json. необходимо:<p>
1. Подключить библиотеку.<p>
include 'vendor/mapper-by-mimilasyxa/mapper-site/lib/mapping.php';<p>
2. Воспользоваться функцией getSiteMap()<p>
Функция getSiteMap() принимает в себя 3 аргумента:<p>
  1.1 $sites - массив данных о сайте, параметры 'loc', 'lastmod', 'priority', 'changefreq'<p>
  Пример:<p>
  $sites = [<br>
  "loc" => "https://packagist.org/",<br>
  "lastmod" => "2020-12-14",<br>
  "priority" => "1",<br>
  "changefreq" => "weekly"<br>
  ];<br>
  1.2 $fileType - тип файла который необходимо создать, по ТЗ есть всего 3 типа файлов - JSON, CSV, XML<p>
  1.3 $path - по какому пути нужно сохранить созданный файл.<p>
  Пример использования библиотеки:<p>
  <?php <br>
    include 'vendor/mapper-by-mimilasyxa/mapper-site/lib/mapping.php';<br>
    $sites = [<br>
        [<br>
            "loc" => "https://packagist.org/",<br>
            "lastmod" => "2020-12-14",<br>
            "priority" => "1",<br>
            "changefreq" => "weekly"<br>
        ],<br>
        [<br>
            "loc" => "https://www.youtube.com/watch?v=fhBA6ynorvc",<br>
            "lastmod" => "2020-01-14",<br>
            "priority" => "0.5",<br>
            "changefreq" => "monthly"<br>
        ],<br>
        [<br>
            "loc" => "https://github.com/",<br>
            "lastmod" => "2022-02-14",<br>
            "priority" => "0.7",<br>
            "changefreq" => "daily"<br>
        ]<br>
    ];<br>
    getSiteMap($sites, 'JSON', "folder/site.json");<br>
  
<h1>Библиотека сама создёт папки прописанные в $path и выдаёт соответствующие исключения в случае ошибок</h1>
