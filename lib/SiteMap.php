<?php 

require 'interfaces/ISiteMap.php';

class SiteMap implements ISiteMap
{
    static function createFile(array $sites, string $type, string $path)
    {
        $filling = (new Filling($type, $sites))->content;
        $filePath = ($path = new Path($path))->getPath();
        $ext =  $path->ext;
        if ($type == $ext){
            if (file_put_contents($filePath, $filling)){
                return true;
            } else {return false;}
        } else {
            throw new Exception('Расширение файла и переданный тип не соответствуют');
        } 
    }
}

?>