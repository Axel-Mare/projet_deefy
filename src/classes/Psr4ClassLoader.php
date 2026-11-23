<?php
/*
namespace loader;

class Psr4ClassLoader {

    public function __construct
    (
        private string $prefixe,
        private string $repertoire,
    ) {}

    public function loadClass(string $name){
        $name = str_replace($this->prefixe,$this->repertoire,$name).".php";
        $name = str_replace("\\", "/", $name);
        if (is_file($name)){require_once($name);}
    }

    public function register(){
        spl_autoload_register([$this, "loadClass"]);
    }
}
*/
