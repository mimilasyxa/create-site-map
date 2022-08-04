<?php

interface ISites
{
    public function check();
    public function checkDate( string $date, $format = 'Y-m-d' );
    public function checkFreq( string $freq);
    public function getSites();
}

?>