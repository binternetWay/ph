<?php

class PDO_Voalle {

    public static $instance;

    private function __construct() {
        $this->endereco = '191.242.48.3';
        $this->banco = 'dbemp00372';
        $this->usuario = 'cliente_s';
        $this->senha = '8hnHjcBu2e5TkWGx';
    }

    public static function getInstance() {
        if (!isset(self::$instance)) {
            self::$instance = new PDO("pgsql:host=erp-staging.internetway.com.br;port=5432;dbname=dbemp00372_staging", 'cliente_s', '8hnHjcBu2e5TkWGx');
            self::$instance->setAttribute(PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS,
            PDO::NULL_EMPTY_STRING);
        }

        return self::$instance;
    }

}



?>