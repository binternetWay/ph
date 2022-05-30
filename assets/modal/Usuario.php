<?php

require_once "PDO_Conexao.php";

class Usuario {

    private $usuario;
    private $id_usuario;

    public function __construct($usuario)
    {
        $fetch = $this->Selecionar_usuario($usuario);

        $this->Set_Usuario($fetch['cpf']);
        $this->Set_Id_Usuario($fetch['id']);

    }

    public function Set_Usuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function Set_Id_Usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    public function Get_Usuario()
    {
        return $this->usuario;
    }

    public function Get_Id_Usuario()
    {
        return $this->id_usuario;
    }

    public function Selecionar_usuario($usuario)
    {
        $stmt = PDO_Conexao::getInstance()->prepare("SELECT * FROM usuario WHERE usuario = :usuario");
        $stmt->execute(array(':usuario' => $usuario));

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}