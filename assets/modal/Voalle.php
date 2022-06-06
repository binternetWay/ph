<?php

class Voalle{
    
    private $token;
    private $Url = "https://erp.internetway.com.br";

    function __construct()
    {

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Url.':45700/connect/token',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'grant_type=password&scope=syngw%20synpaygw%20offline_access&client_id=synauth&client_secret=df956154024a425eb80f1a2fc12fef0c&username=integracao.voalle&password=1979d340f0f7a5d117fa9db142df61214801f3f2&syndata=TWpNMU9EYzVaakk1T0dSaU1USmxaalprWldFd00ySTFZV1JsTTJRMFptUT06WlhsS1ZHVlhOVWxpTTA0d1NXcHZhVnBZU25kWmJWRjFZVmMxTUZwWVNuVmFXRkl6V1ZocmRWa3lPWFJNYlVwNVNXbDNhVlV6YkhWU1IwbHBUMmxLYTFsdFZuUmpSRUYzVFhwamVVbHBkMmxTUjBwVlpWaENiRWxxYjJsalJ6bDZaRWRrZVZwWVRXbG1VVDA5OlpUaGtNak0xWWprMFl6bGlORE5tWkRnM01EbGtNalkyWXpBeE1HTTNNR1U9',
        CURLOPT_HTTPHEADER => array(
            'Content-Type: application/x-www-form-urlencoded'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $chave = json_decode($response, true);

        $this->token = $chave['access_token'];

    }

    public function NovaSolicitacao(string $cliente, string $plano, string $up, string $local, string $contrato)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Url.':45715/external/integrations/thirdparty/opendetailedsolicitation',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "incidentStatusId": 2,
            "personId": '.$cliente.', 
            "clientId": '.$cliente.', 
            "incidentTypeId": 1802,
            "serviceLevelAgreementId": 15, 
            "assignment": {
                "title": "'.$contrato.' SOLICITAÇÃO - TROCA PLANO - PORTAL SVA (PLAYHUB)", 
                "description": "PLANO ANTIGO: ['.$plano.']  PLANO NOVO: ['.$up.']", 
                "priority": 1,
                "beginningDate": "", 
                "finalDate": "", 
                "report": {
                    "beginningDate": "",
                    "finalDate": "", 
                    "description": "Solicitação aberta pelo portal SVA" 
                },
                "companyPlaceId": '.$local.' 
            }
                
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$this->token,
            'Content-Type: application/json',
            'Cookie: SYNSUITE=dhfvuu6l4pai0q8n6o13jb37p1'
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $chave = json_decode($response, true);

        if ($chave['success'] == false) {
            return false;
        }
        else {
            $protocolo = $chave['response'];
            return $protocolo['protocol'];
        }

    }

    public function Criar_Valor($valor, $contrato, $servico, $data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $this->Url.':45715/external/integrations/thirdparty/contract/contracteventualvalues',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "contractId": '.$contrato.',
            "serviceProductCode": "'.$servico.'",
            "monthYearType": 2,
            "monthYear": "'.$data.'",
            "initialMonthYear": "",
            "finalMonthYear": "",
            "description": "SVA - PlayHub",
            "presentInvoiceNote": false,
            "unitAmount": '.$valor.',
            "units": 1
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$this->token,
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);

        $chave = json_decode($response, true);

        if ($chave['success'] == false) {
            return false;
        }
        else {
            return true;
        }

    }
}