
function activePopup () {
    var popup = document.getElementById('popup');
	if (popup.style.display === "none") {
		popup.style.display = "flex";
	} else {
		popup.style.display = "none";
	}
}
document.getElementById('close').onclick = function get() {activePopup()}

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


function createlista(lista){
    	// set veriaveis
	var qtdLista = lista.length;

    for(i=1;i <= qtdLista; i++){
        var nome = 'option';
        var nome_img = 'cat';
        var velocidade = lista[i-1]['velocidade'];
        var preco = lista[i-1]['preco'];

        const div_lista = document.createElement('div');
        div_lista.className = 'select_plano';
        div_lista.id = nome+i;
        div_lista.onclick = function get() {activePopup()}
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

        if(lista[i-1]['servico1'] != ''){
            const serv = document.createElement('img');
            serv.src = lista[i-1]['servico1'];
            document.getElementById(nome_img+i).appendChild(serv);

        }
        if(lista[i-1]['servico2'] != ''){
            const serv = document.createElement('img');
            serv.src = lista[i-1]['servico2'];
            document.getElementById(nome_img+i).appendChild(serv);

        }
        if(lista[i-1]['servico3'] != ''){
            const serv = document.createElement('img');
            serv.src = lista[i-1]['servico3'];
            document.getElementById(nome_img+i).appendChild(serv);

        }
        if(lista[i-1]['servico4'] != ''){
            const serv = document.createElement('img');
            serv.src = lista[i-1]['servico4'];
            document.getElementById(nome_img+i).appendChild(serv);

        }
    }
}
createlista(lista_planos);
