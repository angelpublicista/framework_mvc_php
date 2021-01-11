<?php

class Controller{
    // Cargando modelo
    public function model($model){
        require_once "../app/model/" . $model . ".php";
        // Instanciando el modelo
        return new $model();
    }

    // Cargar vista
    public function view($view, $data = []){
        if(file_exists("../app/view/" . $view . ".php")){
            require_once "../app/view/" . $view . ".php";
        } else {
            die("La vista no existe");
        }
    }
}