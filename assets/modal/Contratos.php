<?php

require_once 'PDO_Voalle.php';
require_once 'PDO_Conexao.php';

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
        contracts.amount AS valor_contrato,
        contracts.company_place_id AS base,
        
        CASE 
        WHEN vencimento.prox_vencimento IS NULL AND SUBSTRING(CURRENT_DATE::VARCHAR, 9, 2)::INT > contracts.collection_day::INT
        THEN (SUBSTRING((CURRENT_DATE::DATE + INTERVAL '1' MONTH)::VARCHAR, 1, 8) || contracts.collection_day)::DATE
        
        WHEN vencimento.prox_vencimento IS NULL AND SUBSTRING(CURRENT_DATE::VARCHAR, 9, 2)::INT < contracts.collection_day::INT
        THEN (SUBSTRING((CURRENT_DATE::DATE + INTERVAL '0' MONTH)::VARCHAR, 1, 8) || contracts.collection_day)::DATE ELSE NULL END AS prox_vencimento,
        CASE WHEN typefatura.expiration_docket = 1 THEN 1 ELSE 0 END AS tipo_faturmento,
        
        vencimento.prox_vencimento AS prox_vencimento_original,
        contracts.collection_day AS dia_vencimento,
        contracts.v_status AS status,
        people.name AS nome,
        people.tx_id AS cpf,
        
        CASE WHEN people.phone = '' 
        THEN SUBSTRING(REPLACE(REPLACE(REPLACE(people.cell_phone_1, '(', '') ,')',''),'-',''), 1, 20) 
        ELSE SUBSTRING(REPLACE(REPLACE(REPLACE(REPLACE(people.phone, '(', '') ,')',''),'-',''),' ','')::VARCHAR, 1, 20) END AS telefone,
        people.email,
        planos.plano,
        planos.codigo_servico,
        planos.download,
        
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
        ELSE TRIM(LOWER(address.neighborhood))  END AS bairro,
        protocolo.numero_protocolo
        
        
        FROM contracts
        LEFT JOIN people ON people.id = contracts.client_id
        LEFT JOIN people_addresses AS address ON address.id = contracts.people_address_id
        LEFT JOIN contract_date_configurations AS typefatura ON typefatura.id = contracts.contract_date_configuration_id
        
        -- Left para informações de plano
        LEFT JOIN (
                            SELECT DISTINCT
                            items.contract_id AS numero_contrato,
                            items.description AS plano,
                            service.code AS codigo_servico,
                            gro.title AS 	tipo,
                            service.download_max_limit AS download,
                            MAX(SUBSTRING(service.created::VARCHAR,1,10)) AS data_criacao_plano
                                            
                            FROM contract_items AS items
                                            LEFT JOIN service_products AS service ON service.id = items.service_product_id
                                            LEFT JOIN service_product_groups AS gro ON gro.id = service.service_product_group_id
        
                                            WHERE items.deleted::INT IN (0) -- deixa apenas os serviços ativos no contrato
                                            AND gro.title LIKE ('%Internet%') -- deixando apenas planos de internet
                                            AND items.description NOT LIKE '%Servi%' -- Retira alguns casos de serviço
                                            
                            GROUP BY items.contract_id, items.description, gro.title, service.code, service.download_max_limit) AS planos
                            ON planos.numero_contrato = contracts.id
        
        -- Left join para solicitações em andamento
        LEFT JOIN (
                                SELECT numero_contrato, MIN(numero_protocolo) AS numero_protocolo
                                FROM (SELECT DISTINCT
                                CASE 
                                WHEN types_ctt.title ILIKE '%IZAZ%' THEN 'Izaz'
                                WHEN ctt.date > '2020-08-01' THEN 'Way & Izaz' ELSE 'Way' END AS base,
        
                                items.contract_id AS numero_contrato,
                                people.id AS numero_cliente,
                                tag.protocol AS numero_protocolo,
                                people.name AS nome_cliente,
                                people.tx_id AS cpf,
                                types.title AS Tipo_solicitacao,
                                class.title AS contexto,
                                problema.title AS problema,
                                SUBSTRING(ass.beginning_date::VARCHAR, 1, 10) AS Data_abertura, 
                                SUBSTRING(ass.conclusion_date::VARCHAR, 1, 10) AS Data_fechamento, 
                                teams_id.title AS equipe_responsavel,
                                pp.name AS responsavel_atual,
                                teams_ori.title AS equipe_abertura,
                                resp_abertura.nome_abertura AS respo_abertura,
                                resp_abertura.cpf_abertura,
                                users.login AS login_aebertura,
                                status.title AS status_ordem
        
        FROM assignments AS ass
            LEFT JOIN assignment_incidents AS tag ON ass.id = tag.assignment_id
            LEFT JOIN incident_status AS status ON status.id = tag.incident_status_id
            LEFT JOIN incident_types AS types ON types.id = tag.incident_type_id
            LEFT JOIN contract_items AS items ON items.contract_service_tag_id = tag.contract_service_tag_id
            LEFT JOIN contracts AS ctt ON ctt.id =  items.contract_id
            LEFT JOIN teams AS teams_id ON teams_id.id = tag.team_id
            LEFT JOIN teams AS teams_ori ON teams_ori.id = tag.origin_team_id
            LEFT JOIN people ON people.id = ass.requestor_id
            LEFT JOIN people AS pp ON pp.id = ass.responsible_id
            LEFT JOIN contract_types AS types_ctt ON types_ctt.id = ctt.contract_type_id
            LEFT JOIN solicitation_classifications AS class ON class.id = tag.solicitation_classification_id
            LEFT JOIN solicitation_problems AS problema ON problema.id = tag.solicitation_problem_id
            LEFT JOIN people_addresses AS address ON address.id = ctt.people_address_id
        
            -- Lef join responsavel pela abertura
            LEFT JOIN (SELECT assignment_id, 
                                    MIN(people.name) AS nome_abertura, 
                                    MIN(tx_id) AS cpf_abertura, 	
                                    MIN(beginning_date) AS data_relato
                                    
                                    FROM reports
                                        LEFT JOIN people ON people.id = reports.person_id
                                    GROUP BY assignment_id) AS resp_abertura
                                    ON resp_abertura.assignment_id = ass.id
        
                                    LEFT JOIN users ON users.tx_id = resp_abertura.cpf_abertura
                                
        
                                -- Condições
                                WHERE status.title NOT IN ('Cancelado','Abertura','Encerramento')
                                AND types.title ILIKE '%SOLICITAÇÃO - TROCA DE PLANO%'
                                AND items.contract_id IS NOT NULL) qtd
                                GROUP BY numero_contrato) AS protocolo
                                ON protocolo.numero_contrato = contracts.id
                                
            -- left join para maior palno
            LEFT JOIN (SELECT DISTINCT
                                    people.tx_id AS cpf,
                                    MAX(service.download_max_limit) AS download
                                                    
                                    FROM contract_items AS items
                                                    LEFT JOIN service_products AS service ON service.id = items.service_product_id
                                                    LEFT JOIN service_product_groups AS gro ON gro.id = service.service_product_group_id
                                                    LEFT JOIN contracts ON contracts.id = items.contract_id
                                                    LEFT JOIN people ON people.id = contracts.client_id
        
                                                    WHERE items.deleted::INT IN (0) -- deixa apenas os serviços ativos no contrato
                                                    AND gro.title LIKE ('%Internet%') -- deixando apenas planos de internet
                                                    AND items.description NOT LIKE '%Servi%' -- Retira alguns casos de serviço
                                                    AND people.tx_id = :cpf
                                                    AND contracts.v_status = 'Normal'
                                                    
                                    GROUP BY people.tx_id) AS velo
                                    ON velo.cpf = people.tx_id
        
        -- left join para identificar a proxima fatura
        LEFT JOIN (SELECT DISTINCT
        fin.contract_id AS numero_contrato, 
        MAX(pg.client_paid_date) AS data_pagamento,
        
        (SUBSTRING(date_trunc('MONTH',MAX(pg.client_paid_date)::DATE + INTERVAL '1' MONTH)::VARCHAR, 1, 8) || MAX(contracts.collection_day))::DATE AS prox_venciemnto_composto,
        
        (CURRENT_DATE+11)::DATE AS prev_faturamento,
        
        CASE WHEN 
        (SUBSTRING(date_trunc('MONTH',MAX(pg.client_paid_date)::DATE + INTERVAL '1' MONTH)::VARCHAR, 1, 8) || MAX(contracts.collection_day))::DATE >=  (CURRENT_DATE+11)::DATE 
        THEN (SUBSTRING(date_trunc('MONTH',MAX(pg.client_paid_date)::DATE + INTERVAL '1' MONTH)::VARCHAR, 1, 8) || MAX(contracts.collection_day))::DATE
        
        ELSE  (SUBSTRING(date_trunc('MONTH',MAX(pg.client_paid_date)::DATE + INTERVAL '2' MONTH)::VARCHAR, 1, 8) || MAX(contracts.collection_day))::DATE END AS prox_vencimento
        
                                    FROM financial_receivable_titles AS fin
                                            LEFT JOIN people ON people.id = fin.client_id 
                                            LEFT JOIN financial_operations AS fin_op ON fin_op.id = fin.financial_operation_id
                                            LEFT JOIN financers_natures AS fin_nt ON fin_nt.id = fin.financer_nature_id
                                            LEFT JOIN financial_collection_types AS fin_col ON fin_col.id = fin.financial_collection_type_id
                                            LEFT JOIN contracts ON contracts.id = fin.contract_id
                                            LEFT JOIN contract_types AS types ON types.id = contracts.contract_type_id
                                            LEFT JOIN people AS pp ON pp.id = fin.resource_request_id
                                            LEFT JOIN financial_remittance_return_registers AS remessa ON remessa.financial_receivable_title_id = fin.id
                                            
                                            -- cruzando para verificar a data de pagamento dentro do mes
                                            LEFT JOIN (SELECT pg.*, bk_recebi.description AS conta_recebimento
                                                                 FROM financial_receipt_titles AS pg
                                                                 LEFT JOIN bank_accounts AS bk_recebi ON bk_recebi.id = pg.bank_account_id) AS pg 
                                                                 ON pg.financial_receivable_title_id = fin.id
                                                                    
                                            -- cruzamento para verificar quem emissor do boleto
                                            LEFT JOIN (SELECT fin.financial_receivable_title_id, people.name
                                                                 FROM financial_receivable_title_occurrences AS fin
                                                                 LEFT JOIN people ON people.id = fin.person_id
                                                                 WHERE financial_title_occurrence_type_id = '50') AS name_emissor
                                                                 ON name_emissor.financial_receivable_title_id = fin.id
        
                                    WHERE fin.expiration_date > CURRENT_DATE-120 
                                    AND pg.client_paid_date IS NOT NULL -- filtra apenas as faturas pagas
                                    AND fin.contract_id IS NOT NULL  -- tira tudo que não tem contratos 
                                    AND fin.deleted::INT = 0 -- considerar apenas os boletos não deletados
                                    AND fin.origin = 8 -- apenas boletos validos (exibe na OP por cliente)
                                    AND fin.renegotiated::INT = 0 -- Retira boletos renegociados
                                    AND fin.sale_request_id IS NULL -- retira os pedidos de vendas
                                    GROUP BY fin.contract_id) AS vencimento
                                    ON vencimento.numero_contrato = contracts.id
        
        WHERE people.tx_id = :cpf
        AND contracts.v_status = 'Normal'
        AND velo.download = planos.download
            ";
        
        return $sql;
    }

    public function valores_de_servico($cod_plano, $tipo_contrato)
    {
        $stmt = PDO_Conexao::getInstance()->prepare($this->get_valores());

        $stmt->execute(array(':tipo' => $tipo_contrato, ':cod' => $cod_plano));

        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $row;
    }

    public function get_valores()
    {
        $sql = "SELECT preco.tipo_contrato, 
        categoria.id,
        categoria.nome,
        preco.qtd_free,
        preco.valor
        
        FROM preco
        LEFT JOIN plano ON plano.id = preco.cod_plano_id
        LEFT JOIN categoria ON categoria.id = preco.categoria_id
        
        WHERE plano.cod_plano = :cod
        AND tipo_contrato  = :tipo";
        
        return $sql;
    }

    public function comparar_codigo_plano(array $array)
    {
        $sql = "SELECT * FROM plano";

        $stmt = PDO_Conexao::getInstance()->prepare($sql);
        $stmt->execute();

        $linha = $stmt->fetchAll(PDO::FETCH_ASSOC);

        for ($i=0; $i < count($linha); $i++) { 
            if ($linha[$i]['cod_plano'] == $array[0]['codigo_servico']) {
                return true;
                exit();
            }
        }
        return false;
    }

    public function get_categoria()
    {
        $sql = "SELECT 
        preco.categoria_id
        
        
        FROM usuario
            LEFT JOIN plano ON plano.cod_plano = usuario.cod_plano_id
            LEFT JOIN preco ON (preco.tipo_contrato = usuario.tipo_contrato 
                                                    AND preco.cod_plano_id = plano.id)
            LEFT JOIN (SELECT 
        usuario.usuario,
        catalogo.categoria_id,
        COUNT(usuario.usuario) AS qtd_servico
        
        FROM servico_disponivel AS sd
        LEFT JOIN usuario ON usuario.id = sd.usuario_id
        LEFT JOIN plano ON plano.cod_plano = usuario.cod_plano_id
        LEFT JOIN catalogo ON (catalogo.tipo_contrato = usuario.tipo_contrato
                                                    AND catalogo.cod_plano_id = plano.id
                                                    AND catalogo.servico_id = sd.servico_id)
        
        GROUP BY usuario.usuario, catalogo.categoria_id) AS qtds
                                    ON (qtds.usuario = usuario.usuario AND qtds.categoria_id = preco.categoria_id)
        
        WHERE preco.qtd_free > 0
        AND (qtds.qtd_servico IS NULL OR qtds.qtd_servico < 0)
        AND usuario.usuario = :cpf
        ORDER BY usuario.usuario";

        return $sql;
    }

    public function Categorias($cpf)
    {
        $stmt = PDO_Conexao::getInstance()->prepare($this->get_categoria());
        $stmt->execute(array(':cpf' => $cpf));
        if ($stmt->rowCount() > 0) {
                $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $condicao = "AND catalogo.categoria_id IN (";
                
                for ($i=0; $i < count($row); $i++) { 
                    $condicao .= $row[$i]['categoria_id'];
                    if(isset($row[$i+1]['categoria_id'])){
                        $condicao .= ",";
                    }
                }

                $condicao .= ")";
                
            return $condicao;
        }
        else{
            return "";
        }
    }
}
