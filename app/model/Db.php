<?php
namespace app;
//mysqli n'est pas dans le namespace app du coup je lui dis d'utiliser mysqli qui se trouve à la racine
use \mysqli;

class Db
{
    public $mySQLI;

    public function __construct()
    {
        $this->mySQLI = new mysqli('localhost', 'root', '', 'site_de_rencontre');
    }
}