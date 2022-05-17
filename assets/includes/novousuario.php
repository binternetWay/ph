<div class="form__line"><i class="fa-solid fa-key"></i><input type="password" id="primeira__senha" name="primeira__senha" placeholder="Escolha uma senha" required="required" /></div>
<div class="form__line"><i class="fa-solid fa-key"></i><input type="password" id="segunda__senha" name="segunda__senha" placeholder="Confirmação de senha" required="required" /></div>
<div class="form__line"><button id="cadastrar" type="submit">Cadastrar usuário</button></div>

<style>
.btn__buscar{
    display: none;
}
</style>

<script>
var primSenha = document.getElementById('primeira__senha');
var segSenha = document.getElementById('segunda__senha');
var btn = document.getElementById('cadastrar');

function validePass () {
    if (primSenha.value != '' && segSenha.value != ''){
        if (primSenha.value == segSenha.value){
            primSenha.style = "border: 3px solid var(--main-sucesse);";
            segSenha.style = "border: 3px solid var(--main-sucesse);";
            btn.disabled = false;
        } else {
            primSenha.style = "border: 3px solid var(--main-danger);";
            segSenha.style = "border: 3px solid var(--main-danger);";
            btn.disabled = true;
        }
    }
}
primSenha.onchange = function get() {validePass()};
segSenha.onchange = function get() {validePass()};
</script>

