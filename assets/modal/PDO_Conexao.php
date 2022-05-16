<?php

class PDO_Conexao {

    public static $instance;
    public static $instance_2;

    public static function getInstance() {
        if (!isset(self::$instance)) {

            $endereco = '191.242.48.28';
            $banco = 'dbstreaming';
            $usuario = 'fmlindolfo';
            $senha = 'fmlindolfo';

            self::$instance = new PDO("pgsql:host=$endereco;port=5432;dbname=$banco", $usuario, $senha);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING);
        }

        return self::$instance;
    }
}

?>