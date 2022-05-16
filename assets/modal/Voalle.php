<?php

class Voalle{
    
    private $token;

    function __construct()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://erp-staging.internetway.com.br:45700/connect/token',
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

    public function NovaSolicitacao()
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
            "incidentStatusId": 0,
            "personId": 0,
            "clientId": 0,
            "incidentTypeId": 0,
            "contractServiceTagId": 0,
            "catalogServiceId": 0,
            "serviceLevelAgreementId": 0,
            "catalogServiceItemId": 0,
            "catalogServiceItemClassId": 0,
            "assignment": {
                "title": "string",
                "description": "string",
                "priority": 0,
                "beginningDate": "2021-11-09T19:25:58.666Z",
                "finalDate": "2021-11-09T19:25:58.666Z",
                "report": {
                    "beginningDate": "2021-11-09T19:25:58.666Z",
                    "finalDate": "2021-11-09T19:25:58.666Z",
                    "description": "string"
                },
                "companyPlaceId": 0
            }
        }',
        CURLOPT_HTTPHEADER => array(
            'Authorization: '.$this->token,
            'Content-Type: application/json'
        ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;

    }
}