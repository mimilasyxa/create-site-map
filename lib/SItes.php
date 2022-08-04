<?php

require 'interfaces/ISites.php';

class Sites implements ISites
{
    protected $sites;
    
    public function __construct( array $sites )
    {
        $this->sites = $sites;
        $this->check();
    }

    public function check()
    {
        if(!empty($this->sites)){
            foreach ($this->sites as $site){
                if(filter_var($site['loc'], FILTER_VALIDATE_URL) === false){
                    throw new Exception("{$site['loc']} Неправильный адрес");
                }
                if(!$this->checkDate($site['lastmod'])){
                    throw new Exception("{$site['lastmod']} Неправильная дата");
                }
                if(!($site['priority'] >= 0 && $site['priority'] <= 1)){
                    throw new Exception("{$site['priority']} Неправильный приоритет парсинга");
                }
                if(!$this->checkFreq($site['changefreq'])){
                    throw new Exception("{$site['changefreq']} Неправильная периодичность обновления");
                }
            }
        } else {
            throw new Exception('Массив страниц сайта пуст');
        }
    }

    public function checkDate( string $date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    public function checkFreq( string $freq )
    {
        $freqs = [
            'always',
            'hourly',
            'daily',
            'weekly',
            'monthly',
            'yearly',
            'never'
        ];
        if(array_search($freq, $freqs)){
            return true;
        } else {
            return false;
        }
    }

    public function getSites()
    {
        return $this->sites;
    }

}