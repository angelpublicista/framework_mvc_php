<?php
    /*
    === Mapear URL ===
    1. Controlador
    2. Método
    3. Parámetro
    Ejemplo: /articulos/actualizar/4
    */

    class Core {
        protected $controladorActual = "pages";
        protected $metodoActual = "index";
        protected $parametros = [];

        public function __construct(){
            // print_r($this->getUrl());
            $url = $this->getUrl();

            // Buscar controlador si existe
            if(isset($url)){
                if(file_exists("../app/controller/" . ucwords($url[0]) . ".php")){
                    $this->controladorActual = ucwords($url[0]);
    
                    unset($url[0]);
                }
            }
            

            require_once "../app/controller/" . $this->controladorActual . ".php";
            $this->controladorActual = new $this->controladorActual;

            // Verificar método
            if(isset($url[1])){
                if(method_exists($this->controladorActual, $url[1])){
                    $this->metodoActual = $url[1];
                    unset($url[1]);
                }
            }

            // Obtener posibles parametros
            $this->parametros = $url ? array_values($url) : [];

            // Callback con parametros array
            call_user_func_array([$this->controladorActual, $this->metodoActual], $this->parametros);
        }

        public function getUrl(){
            // echo $_GET["url"];

            if(isset($_GET['url'])){
                $url = rtrim($_GET['url'], "/");
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);

                return $url;
            }
        }
    }
