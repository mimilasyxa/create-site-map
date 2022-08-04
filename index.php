<?php

require "vendor/autoload.php";

$array = [
    [
        'loc'=> 'https://iportal.com.ua/',
        'lastmod' => '2022-12-20',
        'priority' => '1',
        'changefreq' => 'never'
    ]
];

SiteMap::createFile($array, 'XML', "C:\\nginx-1.23.0\\html\\site-mapping\\dsadsads\\dasds\\leel.xml");
?>