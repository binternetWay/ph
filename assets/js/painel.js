//---------- Chamo o json da pagina dashboard para ler as informações ---------//

const var_type = "POST"
const var_url = "assets/controller/painel.php"
const var_dataType = "json"

$('document').ready(function () {
    $.ajax({
        type: var_type,
        url: var_url,
        dataType: var_dataType,
        success: function (data) {
            
            var servico = data[0];
            var p_servicos = data[1];
            var minhas_inscricoes = data[2];

            createMeuServico(minhas_inscricoes, servico);
            createCategoriaService(servico,'Todos os Serviços');
            document.getElementById('close').onclick = function get (){openShop();}
        }
    });
});