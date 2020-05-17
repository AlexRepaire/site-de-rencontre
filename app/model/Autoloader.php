<?php
namespace app;

class Autoloader
{

    static function register()
    {
        spl_autoload_register(array(__CLASS__,"Autoload"));
        //spl_autoload_register(array( ,"AutoloadControl"));
    }

    //static pas besoin d'instancier ma class
    static function Autoload($class_name){
        $class_name = str_replace(__NAMESPACE__.'\\','',$class_name);
        require __DIR__.'/'.$class_name.".php";
    }
/*
    static function AutoloadControl($class_name){
        $class_name = str_replace(__NAMESPACE__.'\\','',$class_name);
        require "../app/controller/".$class_name.".php";
    }
*/
}