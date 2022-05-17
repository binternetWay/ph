//---------- Chamo o json da pagina dashboard para ler as informações ---------//
var servico = [];
var myservice = [];
$('document').ready(function () {

    $.ajax({
        type: "POST",
        url: "assets/controller/painel.php",
        dataType: "json",
        success: function (data) {
            
            var servico = data[0];
            var myservice = data[1];

            createCategoriaService(myservice,'Meus Serviços');
            createCategoriaService(servico,'destaque');
            document.getElementById('close').onclick = function get (){openShop();}

        }
    });

})
