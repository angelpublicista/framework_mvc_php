<?php

class Database {
    private $db_host = DB_HOST;
    private $db_user = DB_USER;
    private $db_pass = DB_PASS;
    private $db_name = DB_NAME;

    private $dbh;
    private $stmt;
    private $error;

    public function __construct(){
        // Configurar conexión
        $dsn = "mysql:host=" . $this->db_host . ";dbname=" . $this->db_name;
        $opciones = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        // Creando instancia PDO
        try{
            $this->dbh = new PDO($dsn, $this->db_user, $this->db_pass, $opciones);
            $this->dbh->exec('set names utf8');
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // PREPARANDO CONSULTA
    public function query($sql){
        $this->stmt = $this->dbh->prepare($sql);
    }

    // VINCULANDO PARAMETROS
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                break;

                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                break;

                case is_null($value):
                    $type = PDO::PARAM_NULL;
                break;
                default:
                    $type = PDO::PARAM_NULL;
                break;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    // EJECUTA LA CONSULTA
    public function execute(){
        return $this->stmt->execute();
    }

    // OBTENER REGISTROS
    public function registers(){
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // OBTENER ÚNICO REGISTRO
    public function register(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // OBTENER CANTIDAD REGISTROS
    public function rowCount(){
        return $this->stmt->rowCount();
    }

}