<?php
    function getSiteMap($sites, $fileType, $path){
        if(!(checkSites($sites) || checkPath($path, $fileType))){
            fillFile($fileType, $sites, $path);
        } 
    }

    function fillFile($fileType, $sites, $path){
        $filling = createFilling($fileType, $sites);
        file_put_contents($path, $filling);
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
        if(!empty($sites)){
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
                if(!validateChangeFreq($site['changefreq'])){
                    throw new Exception("{$site['changefreq']} Неправильная периодичность обновления");
                }
            }
        } else {
            throw new Exception('Массив страниц сайта пуст');
        }
    }

    function validateDate($date, $format = 'Y-m-d'){
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }
    function validateChangeFreq($changefreq){
        $freq = [
            'always',
            'hourly',
            'daily',
            'weekly',
            'monthly',
            'yearly',
            'never'
        ];
        if(array_search($changefreq, $freq)){
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
        if (!(empty($path) || empty($fileType))){
            $fileType = strtoupper($fileType);
            $pathEXT = strtoupper(substr($path, strrpos($path, ".") + 1));
            if ($fileType == $pathEXT){
                $folders = substr($path, 0, strrpos($path, '/'));
                if (!file_exists($folders) && !$folders == NULL) {
                    mkdir($folders, 0777, true);
                }
            } else {
                throw new Exception("Расширение {$fileType} не равно расширению {$pathEXT}");
            }
        } else {
            throw new Exception("Параметр пути файла или его расширения пуст");
        }
    }

?>