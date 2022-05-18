<?php

require_once 'PDO_Voalle.php';

class Contratos{

    public function Quantidade_Contratos($cpf)
    {
        $v = PDO_Voalle::getInstance()->prepare(Contratos::get_contratos());
        $cpf = preg_replace('/[\@\.\;\/" "-]+/ ', '', $cpf);
    
        $v->execute(array(':cpf' => $cpf));

        return $v->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listar_contratos(string $cpf)
    {
        $stmt = PDO_Voalle::getInstance()->prepare(Contratos::get_contratos());
        $stmt->execute(array(':cpf' => $cpf));
        $x = 0;
        while ($fetch = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $linha[] = '<option value="'.$fetch['numero_contrato'].'" name="contrato">'.$fetch['plano'].' - Contrato('.$fetch['numero_contrato'].') - '.$fetch['nome_rua'].' - Nº'.$fetch['numero_casa'].' - '.$fetch['bairro'].'</option>';
            $x ++;
        }

        return $linha;
    }
    public function get_contratos()
    {
        $sql = "SELECT
        contracts.client_id AS numero_cliente,
        contracts.id AS numero_contrato,
        contracts.v_status AS status,
        people.name AS nome,
        people.tx_id AS cpf,
        
        CASE WHEN people.phone = '' 
        THEN SUBSTRING(REPLACE(REPLACE(REPLACE(people.cell_phone_1, '(', '') ,')',''),'-',''), 1, 20) 
        ELSE SUBSTRING(REPLACE(REPLACE(REPLACE(REPLACE(people.phone, '(', '') ,')',''),'-',''),' ','')::VARCHAR, 1, 20) END AS telefone,
        people.email,
        planos.plano,
        planos.codigo_servico,
        
        CASE 
        WHEN planos.codigo_servico ILIKE '%RT%' THEN 'RT'
        WHEN contracts.date > '2022-05-01' THEN 'AQ' ELSE 'FD' END AS tipo_contrato,
        
        
        -- informaçõe de endereço
        CASE 
        WHEN contracts.people_address_id IS NULL THEN TRIM(LOWER(people.city))
        ELSE TRIM(LOWER(address.city)) END AS cidade,
        
        CASE 
        WHEN contracts.people_address_id IS NULL THEN REPLACE(people.postal_code,'-','') 
        ELSE REPLACE(address.postal_code, '-','') END AS cep,
        
        CASE 
        WHEN contracts.people_address_id IS NULL THEN TRIM(LOWER(people.street))
        ELSE TRIM(LOWER(address.street))  END AS nome_rua,
        
        CASE 
        WHEN contracts.people_address_id IS NULL THEN TRIM(LOWER(people.number))
        ELSE TRIM(LOWER(address.number))  END AS numero_casa,
        
        CASE 
        WHEN contracts.people_address_id IS NULL THEN TRIM(LOWER(people.neighborhood))
        ELSE TRIM(LOWER(address.neighborhood))  END AS bairro
        
        
        FROM contracts
        LEFT JOIN people on people.id = contracts.client_id
        LEFT JOIN people_addresses AS address ON address.id = contracts.people_address_id
        
                -- Left para informações de plano
                LEFT JOIN (
                                        SELECT DISTINCT
                                        items.contract_id AS numero_contrato,
                                        items.description AS plano,
                                        service.code AS codigo_servico,
                                        gro.title AS 	tipo,
                                        MAX(SUBSTRING(service.created::VARCHAR,1,10)) AS data_criacao_plano
                                                
                                        FROM contract_items AS items
                                                LEFT JOIN service_products AS service ON service.id = items.service_product_id
                                                LEFT JOIN service_product_groups AS gro ON gro.id = service.service_product_group_id
        
                                                WHERE items.deleted::INT IN (0) -- deixa apenas os serviços ativos no contrato
                                                AND gro.title LIKE ('%Internet%') -- deixando apenas planos de internet
                                                AND items.description NOT LIKE '%Servi%' -- Retira alguns casos de serviço
                                                
                                        GROUP BY items.contract_id, items.description, gro.title, service.code) AS planos
                                        ON planos.numero_contrato = contracts.id
                
        WHERE people.tx_id = :cpf
        AND contracts.v_status = 'Normal'";
        
        return $sql;
    }
}
