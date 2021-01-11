<?php

require_once "config/config.php";

// Cargamos las libs
spl_autoload_register(function($nameClass){
    require_once "libs/" . $nameClass . ".php";
});