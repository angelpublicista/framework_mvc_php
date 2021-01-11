<?php

class Pages extends Controller{
    public function __construct(){

    }

    public function index(){
        $data = [
            'title' => 'Welcome to Framework MVC'
        ];

        $this->view("pages/home", $data);
    }

}