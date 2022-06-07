
function activePopup (velocidade, valor, codPlano) {
    var popup = document.getElementById('popup');
    var idValor = document.getElementById('valor_plano');
    var idVelocidade = document.getElementById('velocidade');
    var valueCodPlano = document.getElementById('cod_plano');

	if (popup.style.display === "none") {
		popup.style.display = "flex";
        idVelocidade.innerHTML = velocidade;
        idValor.innerHTML = 'R$ '+valor;
        valueCodPlano.value = codPlano;

	} else {
		popup.style.display = "none";

        // remove imgBenef
         var qtdImg = document.getElementsByClassName('benef__line').length;
         var listaImg =  document.getElementsByClassName('benef__line');
        for(i=1;i <= qtdImg; i++){
            listaImg[0].remove()
        }
	}
}
document.getElementById('close').onclick = function get() {activePopup()}


function createlista(lista){
    	// set veriaveis
	var qtdLista = lista.length;

    for(i=1;i <= qtdLista; i++){

        // set variavies
        var nome = 'option';
        var nome_img = 'cat';
        var velocidade = lista[i-1]['velocidade'];
        var preco = lista[i-1]['preco'];
        var codPlano = lista[i-1]['cod_plano'];
        var numPlano = i-1;

        const div_lista = document.createElement('div');
        div_lista.className = 'select_plano';
        div_lista.id = nome+i;
        div_lista.parVelocidade = velocidade;
        div_lista.parPreco = preco;
        div_lista.numPlano = numPlano;
        div_lista.codPlano = codPlano;
        div_lista.onclick = function get() {activePopup(div_lista.parVelocidade, div_lista.parPreco, div_lista.codPlano), createListaIcone(lista, 'benef', div_lista.numPlano)}
        document.getElementById('container__plano').appendChild(div_lista);

        const span_speed = document.createElement('span');
        span_speed.className = 'velocidade';
        span_speed.innerHTML =  velocidade;
        document.getElementById(nome+i).appendChild(span_speed);

        const span_preco = document.createElement('span');
        span_preco.className = 'preco';
        span_preco.innerHTML =  'R$ '+preco;
        document.getElementById(nome+i).appendChild(span_preco);

        const span_benef = document.createElement('span');
        span_benef.className = 'benf';
        span_benef.innerHTML =  'Benefício';
        document.getElementById(nome+i).appendChild(span_benef);

        const div_servico = document.createElement('div');
        div_servico.className = 'service__line';
        div_servico.id = nome_img+i;
        document.getElementById(nome+i).appendChild(div_servico);

        if(lista[i-1]['servico1'] != ' '){
            const serv = document.createElement('img');
            serv.src = lista[i-1]['servico1'];
            document.getElementById(nome_img+i).appendChild(serv);
        }
        if(lista[i-1]['servico2'] != ' '){
            const serv = document.createElement('img');
            serv.src = lista[i-1]['servico2'];
            document.getElementById(nome_img+i).appendChild(serv);
        }
        if(lista[i-1]['servico3'] != ' '){
            const serv = document.createElement('img');
            serv.src = lista[i-1]['servico3'];
            document.getElementById(nome_img+i).appendChild(serv);
        }
        if(lista[i-1]['servico4'] != ' '){
            const serv = document.createElement('img');
            serv.src = lista[i-1]['servico4'];
            document.getElementById(nome_img+i).appendChild(serv);
        }
    }
}

if (lista_planos.length > 0){
    createlista(lista_planos);
} else {
    var semPlano = document.getElementById('popup__planoincomp');
    semPlano.style.display = 'flex';
}

function createListaIcone (lista, idDiv, numPlano){
    if(lista[numPlano]['servico1'] != ' '){
        const serv = document.createElement('img');
        serv.className = 'benef__line';
        serv.src = lista[numPlano]['servico1'];
        document.getElementById(idDiv).appendChild(serv);
    }
    if(lista[numPlano]['servico2'] != ' '){
        const serv = document.createElement('img');
        serv.className = 'benef__line';
        serv.src = lista[numPlano]['servico2'];
        document.getElementById(idDiv).appendChild(serv);
    }
    if(lista[numPlano]['servico3'] != ' '){
        const serv = document.createElement('img');
        serv.className = 'benef__line';
        serv.src = lista[numPlano]['servico3'];
        document.getElementById(idDiv).appendChild(serv);
    }
    if(lista[numPlano]['servico4'] != ' '){
        const serv = document.createElement('img');
        serv.className = 'benef__line';
        serv.src = lista[numPlano]['servico4'];
        document.getElementById(idDiv).appendChild(serv);
    }
}

function getRollRight(idArrow) {
    const arrow = document.getElementById(idArrow)
    arrow.scrollLeft += 80; 
}
document.getElementById('arRight').onclick = function get() {getRollRight('container__plano')};

function getRollLeft (idArrow) {
    const arrow = document.getElementById(idArrow)
    arrow.scrollLeft -= 80;
}
document.getElementById('arLeft').onclick = function get() {getRollLeft('container__plano')};

if (typeof jsProtocolo == 'undefined') {
    var popup =  document.getElementById('popup__notificacao');
    popup.style.display = 'none';
} else {
    var protocolo = document.getElementById('protocolo');
    protocolo.innerHTML = jsProtocolo;
};