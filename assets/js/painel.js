//---------- Chamo o json da pagina dashboard para ler as informações ---------//

var servico = [];
var myservice = [];
var p_servicos = [];
$('document').ready(function () {

    $.ajax({
        type: "POST",
        url: "assets/controller/painel.php",
        dataType: "json",
        success: function (data) {
            
            var servico = data[0];
            var myservice = data[1];
            // var p_servicos = data[2];

            createCategoriaService(myservice,'Meus Serviços');
            createCategoriaService(servico,'Todos os Serviços');
            document.getElementById('close').onclick = function get (){openShop();}

        }
    });

})
