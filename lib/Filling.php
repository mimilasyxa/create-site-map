<?php 

require 'interfaces/IFilling.php';

class Filling implements IFilling
{
    public function __construct( string $type, array $sites)
    {
        $this->sites = new Sites($sites);
        $this->type = strtoupper($type);
        $this->create();
    }

    public function create()
    {
        switch ($this->type) {
            case 'JSON':
                $this->content =  json_encode($this->sites->getSites(), JSON_PRETTY_PRINT);
                break;
            case 'CSV':
                $this->content = "loc;lastmod;priority;changefreq \n";
                foreach ($this->sites->getSites() as $site){
                    $this->content .="{$site['loc']};{$site['lastmod']};{$site['priority']};{$site['changefreq']}; \n";
                }
                break;
            case 'XML':
                $this->content = $this->getXMLFilling($this->sites->getSites());
                break;
            default:
                throw new Exception("Неизвестный тип файла {$this->type}");
        }
    }

    private function getXMLFilling($sites){
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
}
?>