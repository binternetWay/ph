
var primSenha = document.getElementById('primeira__senha');
var segSenha = document.getElementById('segunda__senha');

function validePass () {
    if (primSenha.value != '' && segSenha.value != ''){
        if (primSenha.value == segSenha.value){
            console.log('Ok');
            primSenha.style = "border: 3px solid var(--main-sucesse);"
            segSenha.style = "border: 3px solid var(--main-sucesse);"
        } else {
            console.log('não Ok');
            primSenha.style = "border: 3px solid var(--main-danger);"
            segSenha.style = "border: 3px solid var(--main-danger);"
        }
    }
}

primSenha.onchange = function get() {validePass()};
segSenha.onchange = function get() {validePass()};

