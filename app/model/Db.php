<?php
namespace app;

use \mysqli;

class Db
{
    public $mySQLI;

    public function __construct()
    {
        $this->mySQLI = new mysqli('localhost', 'root', '', 'site_de_rencontre');
    }
}