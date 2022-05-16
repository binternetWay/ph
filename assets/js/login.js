
var primSenha = document.getElementById('primeira__senha');
var segSenha = document.getElementById('segunda__senha');

function validePass () {
    if (primSenha.value != null && segSenha.value != null){
        if (primSenha.value = segSenha.value){
            console.log('Senha Bate');
        } else {
            console.log('Senha não bate!');
        }
    }
}

primSenha.onchange = function get() {validePass()};
segSenha.onchange = function get() {validePass()};

