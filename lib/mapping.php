<?php
    function getSiteMap(array $sites, string $fileType, string $path){
        if(!(checkSites($sites) || checkPath($path, $fileType))){
            return fillFile($fileType, $sites, $path);
        } 
    }

    function fillFile($fileType, $sites, $path){
        $filling = createFilling($fileType, $sites);
        if (file_put_contents($path, $filling)){;
            return true;
        } else {
            throw new Exception("Файл не был записан");
        }
    }

    function createXMLfilling($sites){
        $filling = '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" 
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
        http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
        foreach ($sites as $site){
            $filling .= "<url>
            <loc>{$site['loc']}</loc>
            <lastmod>{$site['lastmod']}</lastmod>
            <priority>{$site['priority']}</priority>
            <changefreq>{$site['changefreq']}</changefreq>
            </url>";
        }
        $filling .= "</urlset>";
        return $filling;
    }

    function checkSites($sites){
        if(empty($sites)){
            throw new Exception('Массив страниц сайта пуст');
        }
        foreach ($sites as $site){
            if(filter_var($site['loc'], FILTER_VALIDATE_URL) === false){
                throw new Exception("{$site['loc']} Неправильный адрес");
            }
            if(!validateDate($site['lastmod'])){
                throw new Exception("{$site['lastmod']} Неправильная дата");
            }
            if(!($site['priority'] >= 0 && $site['priority'] <= 1)){
                throw new Exception("{$site['priority']} Неправильный приоритет парсинга");
            }
            if(!validateFreq($site['changefreq'])){
                throw new Exception("{$site['changefreq']} Неправильная периодичность обновления");
            }
        }
        return true;
    }

    function validateDate($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    function validateFreq($changefreq){
        $freq = [
            'always',
            'hourly',
            'daily',
            'weekly',
            'monthly',
            'yearly',
            'never'
        ];
        if(array_search($changefreq, $freq) !== false){
            return true;
        } else {
            return false;
        }
    }

    function createFilling($fileType, $sites){
        $filling = [];
        switch (strtoupper($fileType)) {
            case 'JSON':
                $filling =  json_encode($sites, JSON_PRETTY_PRINT);
                break;
            case 'CSV':
                $filling = "loc;lastmod;priority;changefreq \n";
                foreach ($sites as $site){
                    $filling .="{$site['loc']};{$site['lastmod']};{$site['priority']};{$site['changefreq']}; \n";
                }
                break;
            case 'XML':
                $filling = createXMLfilling($sites);
                break;
            default:
                throw new Exception("Неизвестный тип файла {$fileType}");
        }
        return $filling;
    }

    function checkPath($path, $fileType){
        $fileTypeUp = strtoupper($fileType);
        $pathExt = strtoupper(substr($path, strrpos($path, ".") + 1));
        if (empty($path) || empty($fileType)){
            throw new Exception("Параметр пути файла или его расширения пуст");
        }
        if ($fileTypeUp !== $pathExt){
            throw new Exception("Расширение {$fileTypeUp} не равно расширению {$pathExt}");
        }
        $folders = substr($path, 0, strrpos($path, '/'));
        if (!file_exists($folders) && !$folders == NULL) {
            mkdir($folders, 0644, true);
        }
    }
?>