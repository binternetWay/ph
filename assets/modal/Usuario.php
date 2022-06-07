<?php

require_once "PDO_Conexao.php";
require_once "PDO_Voalle.php";
require_once "Contratos.php";

class Usuario {

    // Interno
    private $usuario;
    private $id_usuario;

    // Voalle
    private $contrato;
    private $plano;
    private $tipo_contrato;
    private $primeiro_nome;
    private $telefone;
    private $email;
    private $codigo_servico;
    private $numero_protocolo;
    private $valor_contrato;
    private $base;
    private $numero_cliente;


    public function __construct($usuario)
    {
        $fetch = $this->Selecionar_usuario($usuario);
        $row = $this->Selecionar_contrato($usuario);
        // echo "<pre>";
        // var_dump($row);

        $this->setUsuario($fetch['cpf']);
        $this->setIdUsuario($fetch['id']);
        $this->setPlano($row['plano']);
        $this->setContrato($row['numero_contrato']);
        $this->setTipoContrato($row['tipo_contrato']);
        $this->setPrimeiroNome($row['prim_nome']);
        $this->setTelefone($row['telefone']);
        $this->setEmail($row['email']);
        $this->setCodigoServico($row['codigo_servico']);
        $this->setNumeroProtocolo($row['numero_protocolo']);
        $this->setValorContrato($row['valor_contrato']);
        $this->setBase($row['base']);
        $this->setNumeroCliente($row['numero_cliente']);
    }

    // SET'S
    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function setIdUsuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
    }

    public function setContrato($contrato)
    {
        $this->contrato = $contrato;
    }

    public function setPlano($plano)
    {
        $this->plano = $plano;
    }

    public function setTipoContrato($tipo_contrato)
    {
        $this->tipo_contrato = $tipo_contrato;
    }

    public function setPrimeiroNome($primeiro_nome)
    {
        $this->primeiro_nome = $primeiro_nome;
    }

    public function setTelefone($telefone)
    {
        $this->telefone = $telefone;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function setCodigoServico($codigo_servico)
    {
        $this->codigo_servico = $codigo_servico;
    }

    public function setNumeroProtocolo($numero_protocolo)
    {
        $this->numero_protocolo = $numero_protocolo;
    }
    
    public function setValorContrato($valor_contrato)
    {
        $this->valor_contrato = $valor_contrato;
    }

    public function setBase($base)
    {
        $this->base = $base;
    }

    public function setNumeroCliente($numero_cliente)
    {
        $this->numero_cliente = $numero_cliente;
    }


    // GET'S
    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getIdUsuario()
    {
        return $this->id_usuario;
    }

    public function getContrato()
    {
        return $this->contrato;
    }

    public function getPlano()
    {
        return $this->plano;
    }

    public function getTipoContrato()
    {
        return $this->tipo_contrato;
    }

    public function getPrimeiroNome()
    {
        return $this->primeiro_nome;
    }

    public function getTelefone()
    {
        return $this->telefone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getCodigoServico()
    {
        return $this->codigo_servico;
    }

    public function getNumeroProtoco()
    {
        return $this->numero_protocolo;
    }

    public function getValorContrato()
    {
        return $this->valor_contrato;
    }

    public function getBase()
    {
        return $this->base;
    }

    public function getNumeroCliente()
    {
        return $this->numero_cliente;
    }


    // Funções
    public function Selecionar_usuario($usuario)
    {
        $stmt = PDO_Conexao::getInstance()->prepare("SELECT * FROM usuario WHERE usuario = :usuario");
        $stmt->execute(array(':usuario' => $usuario));

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function Selecionar_contrato($usuario)
    {
        $x = new Contratos();

        $stmt = PDO_Voalle::getInstance()->prepare($x->get_contratos());
        $stmt->execute(array(':cpf' => $usuario));

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}