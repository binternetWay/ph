<?php

require_once "../modal/PDO_Voalle.php";
require_once "../modal/PDO_Conexao.php";
require_once "../modal/Voalle.php";
require_once "../modal/Usuario.php";
require_once "../modal/Contratos.php";

session_name(md5('ph_primario'.$_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']));
session_start();

$csrf = isset($_POST['csrf']) ? $_POST['csrf'] : '';

if ($_SESSION['csrf'] != $csrf) {
    header('Location: logout');
}

if (isset($_POST['salvar'])) {

    $z = new Contratos();
    $x = new Voalle();

    $cpf = $_POST['cpf'];
    $contrato = $_POST['contrato'];
    $data = $_POST['data'];

    $sql = "SELECT DISTINCT
            CASE 
            WHEN types.title LIKE '%IZAZ%' THEN 'Izaz'
            WHEN contracts.date > '2020-08-01' THEN 'Way & Izaz' ELSE 'Way' END AS base,
            
            contracts.id AS numero_contrato,
            contracts.client_id AS numero_cliente,
            contracts.v_status AS status_contrato,
            types.title AS tipo_contrato,
            people.tx_id AS cpf,
            people.name AS nome_cliente,
            
            -- validação de contratos ativos e inativos
            CASE 
            WHEN contracts.v_status IN ('Cancelado','Suspenso','Encerrado') THEN 'Inativo' 
            WHEN (tipo_inadimplencia = 'Inadimplência Inativa' AND contracts.v_status NOT IN ('Normal')) THEN 'Inativo' 
            ELSE 'Ativo' END AS status_base,
            
            -- criação da data de bloquieo
            CASE 
            WHEN contracts.v_status IN ('Bloqueio Financeiro','Bloqueio Administrativo') THEN bloqueio.data_bloqueio
            ELSE NULL END AS data_bloqueio,
            
            contracts.collection_day AS dia_vencimento,
            contracts.amount AS valor_contrato,
            contracts.beginning_date AS data_venda,
            
            -- criando faixa de tempo na base
            (CASE 
            WHEN (DATEDIFF(CURRENT_DATE,contracts.beginning_date)/30) < 6 THEN '01 - Até 6 Meses'
            WHEN (DATEDIFF(CURRENT_DATE,contracts.beginning_date)/30) < 12 THEN '02 - Até 1 Ano'
            WHEN (DATEDIFF(CURRENT_DATE,contracts.beginning_date)/30) < 24 THEN '03 - 1 a 2 Anos'
            WHEN (DATEDIFF(CURRENT_DATE,contracts.beginning_date)/30) < 36 THEN '04 - 2 a 3 Anos'
            WHEN (DATEDIFF(CURRENT_DATE,contracts.beginning_date)/30) < 48 THEN '05 - 3 a 5 Anos' ELSE '06 - Acima de 5 Anos' END) AS faixa_tempo_base,
            people.birth_date AS data_aniversario,
            
            -- criando faixa etaria (base)
            (CASE 
            WHEN SUBSTRING(CURRENT_DATE::VARCHAR, 1, 4)::INT - SUBSTRING(people.birth_date::VARCHAR, 1, 4)::INT < 20 THEN '01 - Até 20 Anos'
            WHEN SUBSTRING(CURRENT_DATE::VARCHAR, 1, 4)::INT - SUBSTRING(people.birth_date::VARCHAR, 1, 4)::INT < 30 THEN '02 - 21 a 30 Anos'
            WHEN SUBSTRING(CURRENT_DATE::VARCHAR, 1, 4)::INT - SUBSTRING(people.birth_date::VARCHAR, 1, 4)::INT < 40 THEN '03 - 31 a 40 Anos'
            WHEN SUBSTRING(CURRENT_DATE::VARCHAR, 1, 4)::INT - SUBSTRING(people.birth_date::VARCHAR, 1, 4)::INT < 50 THEN '04 - 41 a 50 Anos'
            WHEN SUBSTRING(CURRENT_DATE::VARCHAR, 1, 4)::INT - SUBSTRING(people.birth_date::VARCHAR, 1, 4)::INT < 60 THEN '05 - 51 a 60 Anos' ELSE '06 - Acima de 61 Anos' END) AS faixa_etaria,
            
            inadimplencia.qtd_dias_atraso,
            inadimplencia.tipo_inadimplencia,
            inadimplencia.faixa_atraso,
            planos.plano,
            fin_col.title AS banco_emissor,
            
            -- organizando as colunas de telefone
            SUBSTRING(REPLACE(REPLACE(REPLACE(REPLACE(people.phone, '(', '') ,')',''),'-',''),' ','')::VARCHAR, 1, 20) AS Telefone_1,
            
            CASE WHEN people.phone = people.cell_phone_1 THEN '' ELSE SUBSTRING(REPLACE(REPLACE(REPLACE(people.cell_phone_1, '(', '') ,')',''),'-',''), 1, 20) END AS Telefone_2,
            people.email AS email,
            
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
                LEFT JOIN people ON people.id = contracts.client_id
                LEFT JOIN contract_types AS types ON types.id = contracts.contract_type_id
                LEFT JOIN financial_collection_types AS fin_col ON fin_col.id = contracts.financial_collection_type_id
                LEFT JOIN people_addresses AS address ON address.id = contracts.people_address_id
            
            
                -- Left para informações de plano
                LEFT JOIN (
                        SELECT DISTINCT
                        items.contract_id AS numero_contrato,
                        items.description AS plano,
                        gro.title AS 	tipo,
                        MAX(SUBSTRING(service.created::VARCHAR,1,10)) AS data_criacao_plano
                            
                        FROM contract_items AS items
                            LEFT JOIN service_products AS service ON service.id = items.service_product_id
                            LEFT JOIN service_product_groups AS gro ON gro.id = service.service_product_group_id

                            WHERE items.deleted::INT IN (0) -- deixa apenas os serviços ativos no contrato
                            AND gro.title LIKE ('%Internet%') -- deixando apenas planos de internet
                            AND items.description NOT LIKE '%Servi%' -- Retira alguns casos de serviço
                            
                        GROUP BY items.contract_id, items.description, gro.title) AS planos
                        ON planos.numero_contrato = contracts.id
            
                -- Left para infoamções de inadimplência
                LEFT JOIN (
                        SELECT 
                        info.numero_contrato, 

                        -- criando dias de atraso
                        CASE WHEN info.prim_data_vencimento::DATE < CURRENT_DATE THEN DATEDIFF(CURRENT_DATE, info.prim_data_vencimento) ELSE 0 END AS qtd_dias_atraso,
                        CASE WHEN DATEDIFF(CURRENT_DATE, info.prim_data_vencimento) <= 45 THEN 'Inadimplência Ativa' ELSE 'Inadimplência Inativa' END AS tipo_inadimplencia,

                        REPLACE(fin.title_amount::VARCHAR,'.',',')AS valor_titulo,
                        info.qtd_titulo_atrasados, 
                        info.prim_data_emissao, 
                        info.prim_data_vencimento, 
                        info.prim_mes_competencia,

                        (CASE 
                        WHEN DATEDIFF(CURRENT_DATE, info.prim_data_vencimento) < 5 THEN '01 - 1 a 5 Dias em atraso'
                        WHEN  DATEDIFF(CURRENT_DATE, info.prim_data_vencimento) < 10 THEN '02 - 6 a 10 Dias em atraso'
                        WHEN  DATEDIFF(CURRENT_DATE, info.prim_data_vencimento) < 15 THEN '03 - 11 a 15 Dias em atraso' 
                        WHEN  DATEDIFF(CURRENT_DATE, info.prim_data_vencimento) < 20 THEN '04 - 16 a 20 Dias em atraso' 
                        WHEN  DATEDIFF(CURRENT_DATE, info.prim_data_vencimento) < 25 THEN '05 - 21 a 25 Dias em atraso' 
                        WHEN  DATEDIFF(CURRENT_DATE, info.prim_data_vencimento) < 30 THEN '06 - 26 a 30 Dias em atraso' 
                        WHEN  DATEDIFF(CURRENT_DATE, info.prim_data_vencimento) < 45 THEN '07 - 31 a 45 Dias em atraso' 
                        WHEN  DATEDIFF(CURRENT_DATE, info.prim_data_vencimento) < 60 THEN '08 - 46 a 60 Dias em atraso' 
                        WHEN  DATEDIFF(CURRENT_DATE, info.prim_data_vencimento) < 90 THEN '09 - 61 a 90 Dias em atraso' 
                        WHEN  DATEDIFF(CURRENT_DATE, info.prim_data_vencimento) < 180 THEN '10 - 91 a 180 Dias em atraso' 
                        WHEN  DATEDIFF(CURRENT_DATE, info.prim_data_vencimento) < 360 THEN '11 - 181 a 360 Dias em atraso' 
                        ELSE '12 - Acima de 360 Dias em atraso' END) AS faixa_atraso


                        FROM
                        (SELECT 
                        MIN(id)
            
            AS id, 
        fin.contract_id AS numero_contrato,

        COUNT(fin.contract_id) AS qtd_titulo_atrasados,
        MIN(fin.issue_date) AS prim_data_emissao, 
        MIN(fin.expiration_date) AS prim_data_vencimento, 
        MIN(fin.competence) AS prim_mes_competencia

        FROM financial_receivable_titles AS fin

        WHERE fin.expiration_date < CURRENT_DATE -- filtro de venciemento
        AND fin.contract_id  IS NOT NULL  -- tira tudo que não tem contratos
        AND fin.deleted::INT = 0 -- considerar apenas os boletos não deletados
        AND fin.origin = 8
        AND fin.balance > 0 -- filtra apenas o que não tem pagamento
        AND fin.renegotiated::INT = 0 -- filtro os boletos de renegociação
        AND fin.finished::INT = 0 -- remove os titulos baixados manualmento
        AND fin.type::INT = 2 -- remove pedido de venda

        GROUP BY fin.contract_id,  fin.client_id
        ORDER BY MIN(fin.expiration_date) DESC) AS info
            
            -- Left join informações do boleto
            LEFT JOIN (SELECT * FROM financial_receivable_titles
                                WHERE expiration_date < CURRENT_DATE -- filtro de venciemento
                                AND contract_id  IS NOT NULL  -- tira tudo que não tem contratos
                                AND deleted::INT = 0 -- considerar apenas os boletos não deletados
                                AND origin = 8
                                AND balance > 0 -- filtra apenas o que não tem pagamento
                                AND renegotiated::INT = 0 -- filtro os boletos de renegociação
                                AND finished::INT = 0 -- remove os titulos baixados manualmento
                                AND type::INT = 2) AS fin
                                ON (fin.id = info.id)) AS inadimplencia
                                ON inadimplencia.numero_contrato = contracts.id
            
            
                -- Left join para ultima data de bloqueio
                LEFT JOIN (
                        SELECT 
                        contract_id AS numero_contrato, 
                        MAX(blocked_day) AS data_bloqueio, 
                        MAX(unblocked_day) AS data_desbloqueio

                        FROM contract_blocked_days
                        GROUP BY contract_id) AS bloqueio
                        ON bloqueio.numero_contrato = contracts.id
            
            WHERE contracts.v_stage IN ('Aprovado')
            AND contracts.id = :contrato
            ORDER BY contracts.id";

    $stmt = PDO_Voalle::getInstance()->prepare($sql);
    $stmt->execute(array(':contrato' => $contrato));

    if ($stmt->rowCount() > 0) {
        
        $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if ($row[0]['numero_contrato'] == $contrato && $row[0]['cpf'] == $cpf && $row[0]['data_aniversario'] == $data) {
            $stt = PDO_Conexao::getInstance()->prepare("UPDATE usuario SET senha = :senha WHERE id = :id");
            $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $y = new Usuario($_POST['cpf']);
            $stt->bindParam(':senha', $senha);
            $stt->bindValue(':id', $y->getIdUsuario());

            $stt->execute();

            if ($stt->rowCount() > 0) {
                $_SESSION['msg'] = 'edit_success';

                header('Location: logout');
            }
            else{
                $_SESSION['msg'] = 'erro_alt_senha';
        
                header('Location: logout');
            }
        }
        else{
            $_SESSION['msg'] = 'erro_alt_senha';
    
            header('Location: logout');
        }
    }
    else{
        $_SESSION['msg'] = 'erro_alt_senha';

        header('Location: logout');
    }

}
else {
    $_SESSION['msg'] = 'erro';

    header('Location: logout');
}