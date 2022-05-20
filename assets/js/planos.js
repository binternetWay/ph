function getRollRight(idArrow) {
    const arrow = document.getElementById(idArrow)
    arrow.scrollLeft += 30; 
}
document.getElementById('arRight').onclick = function get() {getRollRight('container__plano')};

function getRollLeft (idArrow) {
    const arrow = document.getElementById(idArrow)
    arrow.scrollLeft -= 30;
}
document.getElementById('arLeft').onclick = function get() {getRollLeft('container__plano')};


function createPlanosLista(lista){
    for(i=1;i <= lista.lenght; i++){
        var nome = 'option';
        var velocidade = lista[i-1]['velocidade'];

        const div_lista = document.createElement('div');
        div_lista.className = 'select_plano';
        div_lista.id = nome+i;
        document.getElementById('container__plano').appendChild(div_lista);

        const span_speed = document.createElement('span');
        span_speed.className = 'velocidade';
        span_speed.innerHTML =  velocidade;
        document.getElementById(nome+i).appendChild(span_speed);

        const span_preco = document.createElement('span');
        span_preco.className = 'preco';
        span_preco.innerHTML =  preco;
        document.getElementById(nome+i).appendChild(span_preco);
    }
}


{/* <div class="select_plano">
<span class="valocidade">100MB</span>
<span class="preco">R$ 69,90</span>
</div> */}