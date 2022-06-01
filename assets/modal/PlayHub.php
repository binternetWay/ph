<?php

require_once "Usuario.php";
require_once "Contratos.php";

class PH {

    private $token;

    function __construct()
    {
        $this->ApiKey = "20898402-DAA9-4901-A629-DFFBD492BCF3";
        $this->ApiSecret = "30kqXFg6xHlngRCs0yEOhaAm6kjgZnLSex913gypnZTJrX2hK7xrYxUUY41xiDFC1F4tlraOHtZzGRXROKAn8U8WP0Jz3O2tUwe6"; 
        $this->Url = "https://www.playhub.com.br/API/PlayhubApi/api/v3";

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Url.'/authentication/tokens',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{ 
            "ApiKey": "'.$this->ApiKey.'", 
            "ApiSecret": "'.$this->ApiSecret.'"}',
        CURLOPT_HTTPHEADER => array(
            'Accept: text/json',
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        $chave = json_decode($response, true);
        $this->token = $chave['AccessToken'];
    }

    public function adicionar_cliente(string $usuario, string $cpf, string $senha, string $nome, string $email, string $numero)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL =>  $this->Url.'/customers',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{ 
            "Username": "'.$usuario.'", 
            "Document": "'.$cpf.'", 
            "Password": "'.$senha.'", 
            "Name": "'.$nome.'", 
            "Email": "'.$email.'", 
            "Mobile": "'.$numero.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        $chave = json_decode($response, true);
        
        return $chave;

    }
    public function editar_usuario(string $senha, string $nome, string $email, string $numero)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL =>  $this->Url.'/customers/reginaldo.silva',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'PUT',
        CURLOPT_POSTFIELDS =>'{ 
            "Password": "'.$senha.'", 
            "Name": "'.$nome.'", 
            "Email": "'.$email.'", 
            "Mobile": "'.$numero.'"
        }',
        CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        $chave = json_decode($response, true);
        
        return $chave;

    }
    public function buscar_usuario(string $usuario)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Url.'/customers/'.$usuario,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'Authorization: Bearer '.$this->token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        $chave = json_decode($response, true);
        
        return $chave;

    }
    public function inscrever(string $produto, string $usuario)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Url.'/customers/'.$usuario.'/subscriptions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{ "ProductId": "'.$produto.'"}',
        CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'Content-Type: application/json',
            'Authorization: Bearer '.$this->token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        $chave = json_decode($response, true);
        
        return $chave;

    }
    public function buscar_inscricao(string $usuario)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Url.'/customers/'.$usuario.'/subscriptions',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'Authorization: Bearer '.$this->token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        
        $chave = json_decode($response, true);
        
        return $chave;

    }
    public function remover_inscricao(string $usuario)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Url.'/customers/'.$usuario.'/subscriptions/EIT',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'DELETE',
        CURLOPT_HTTPHEADER => array(
            'accept: application/json',
            'Authorization: Bearer '.$this->token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $chave = json_decode($response, true);
        
        return $chave;

    }

    public function insertar_inscricao($cod__servico)
    {
        $login = new Usuario($_SESSION['cpf']);

        $contrato = new Contratos();

        $contrato = $contrato->Quantidade_Contratos($_SESSION['cpf'])[0];

        $stmt = PDO_Conexao::getInstance()->prepare("
                SELECT 
                servico.id,
                catalogo.tipo_contrato,
                plano.cod_plano,
                servico.nome,
                servico.codigo_playhub AS codigo_index,
                servico.src_img,
                catalogo.categoria_id,
                preco.valor,
                TO_CHAR(CURRENT_DATE, 'DD/MM') AS data_inicio, 
                TO_CHAR((CURRENT_DATE+30), 'DD/MM') AS data_final

                FROM catalogo
                LEFT JOIN plano ON plano.id = catalogo.cod_plano_id
                LEFT JOIN categoria ON categoria.id = catalogo.categoria_id
                LEFT JOIN servico ON servico.id = catalogo.servico_id

                LEFT JOIN preco ON (preco.categoria_id = catalogo.categoria_id 
                                                        AND preco.cod_plano_id = catalogo.cod_plano_id
                                                        AND preco.tipo_contrato = catalogo.tipo_contrato)

                WHERE catalogo.tipo_contrato = '".$_SESSION['tipo_contrato']."'
                AND plano.cod_plano = '".$_SESSION['codigo_plano']."'
                AND servico.codigo_playhub = '".$cod__servico."'");

        $stmt->execute();
        $servicos = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

        $sql = "INSERT INTO servico_disponivel (usuario_id, servico_id, data_contratacao, data_inicial, data_final, valor_servico, data_fatura, valor_fatura)
        VALUES (:usuario_id, :servico_id, :data_contratacao, :data_inicial, :data_final, :valor_servico, :data_fatura, :valor_fatura) ";
        
        $stmt = PDO_Conexao::getInstance()->prepare($sql);

        $user = $login->Get_Id_Usuario();

        $data = date('Y-m-d');
        $vencimento = date('Y-m-d', strtotime("+30 days",strtotime(date('Y-m-d'))));

        $fatura = 0;

        $stmt->bindParam(':usuario_id', $user);
        $stmt->bindParam(':servico_id', $servicos['id']);
        $stmt->bindParam(':data_contratacao', $data);
        $stmt->bindParam(':data_inicial', $data);
        $stmt->bindParam(':data_final', $vencimento);
        $stmt->bindParam(':valor_servico', $fatura);
        $stmt->bindParam(':data_fatura', $contrato['prox_vencimento']);
        $stmt->bindParam(':valor_fatura', $fatura);

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }
        else {
            return false;
        }
    }
}