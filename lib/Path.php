<?php

require 'interfaces/IPath.php';

class Path implements IPath
{
    protected $path;

    public function __construct( string $path )
    {
        $this->path = $path;   
        $this->check(); 
        $this->ext = strtoupper(end(explode('.', $path)));
    }

    public function createFolder()
    {
        $folders = substr($this->path, 0, strrpos($this->path, '\\'));
        if (!file_exists($folders) && !$folders == NULL) {
                mkdir($folders, 0777, true);
        }
    }

    public function check(){
        if(empty($this->path)){
            $this->path = dirname(__DIR__,1);
        }
        $this->createFolder();
    }

    public function getPath()
    {
        return $this->path;
    }
}

?>