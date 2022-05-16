<?php

class PH {

    private $token;

    function __construct()
    {
        $this->ApiKey = "20898402-DAA9-4901-A629-DFFBD492BCF3";
        $this->ApiSecret = "30kqXFg6xHlngRCs0yEOhaAm6kjgZnLSex913gypnZTJrX2hK7xrYxUUY41xiDFC1F4tlraOHtZzGRXROKAn8U8WP0Jz3O2tUwe6"; 

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://stage3.pca.com.br/PlayHub_Demo/API/PlayhubApi/api/v3/authentication/tokens',
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
        CURLOPT_URL => 'http://stage3.pca.com.br/PlayHub_Demo/API/PlayhubApi/api/v3/customers',
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
        CURLOPT_URL => 'http://stage3.pca.com.br/PlayHub_Demo/API/PlayhubApi/api/v3/customers/reginaldo.silva',
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
        CURLOPT_URL => 'http://stage3.pca.com.br/PlayHub_Demo/API/PlayhubApi/api/v3/customers/'.$usuario,
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
        CURLOPT_URL => 'http://stage3.pca.com.br/PlayHub_Demo/API/PlayhubApi/api/v3/customers/'.$usuario.'/subscriptions',
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
        CURLOPT_URL => 'http://stage3.pca.com.br/PlayHub_Demo/API/PlayhubApi/api/v3/customers/'.$usuario.'/subscriptions',
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
        CURLOPT_URL => 'http://stage3.pca.com.br/PlayHub_Demo/API/PlayhubApi/api/v3/customers/'.$usuario.'/subscriptions/EIT',
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
}