<?php

class Voalle{
    
    private $token;

    function __construct()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://erp.internetway.com.br:45700/connect/token',
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

    public function NovaSolicitacao(string $cliente, int $cod_cliente, string $plano, string $up)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://erp-staging.internetway.com.br:45715/external/integrations/thirdparty/opendetailedsolicitation',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS =>'{
            "incidentStatusId": 2, //Status da solicitação
            "personId": 118814, //ID do solicitante
            "clientId": 118814, //ID do cliente da solicitação
            "incidentTypeId": 1802, //ID do tipo de solicitação
            "contractServiceTagId": 0, //ID da etiqueta de serviço
            "catalogServiceId": 1, //ID do tipo de atendimento
            "serviceLevelAgreementId": 0, //ID do service level agreement
            "catalogServiceItemId": 2, //ID do iten de serviço
            "catalogServiceItemClassId": 1, //ID do subitem de serviço
            "assignment": {
                "title": "teste", //Titulo da solicitação
                "description": "teste", //Texto de abertura
                "priority": 1, //Prioridade
                "beginningDate": "2022-05-27 14:50:00", //Data de abertura
                "finalDate": "2022-05-30 14:50:00", //Prazo para encerramento
                "report": {
                    "beginningDate": "2022-05-27 14:50:00", //Data inicial do relato
                    "finalDate": "2022-05-27 14:50:00", //Data final do relato
                    "description": "teste" //Descrição
                },
                "companyPlaceId": 0 //ID do local de atendimento
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: Bearer '.$this->token
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }

    public function Criar_Valor($valor, $contrato, $servico, $data)
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://erp.internetway.com.br:45715/external/integrations/thirdparty/contract/contracteventualvalues',
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