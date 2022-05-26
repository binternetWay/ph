

function createCategoriaService (lista, nome) {
	// set variaveis
	var nameServiceList = nome + '__list';
	var nameArrowLeft = nome + '__arrow__left';
	var nameArrowRight = nome + '__arrow_rigth';
	var iconArrow = '<i class="fa-solid fa-angle-left"></i>';

	const div_categoria = document.createElement('div');
	div_categoria.className = 'container__categoria';
	div_categoria.id = nome;
	document.getElementById('container__service').appendChild(div_categoria);

	const div_name = document.createElement('div');
	div_name.className = 'cetegoria__name';
	div_name.innerHTML = nome;
	document.getElementById(nome).appendChild(div_name)

	const div_service = document.createElement('div');
	div_service.className = 'service__list';
	div_service.id = nameServiceList;
	document.getElementById(nome).appendChild(div_service);

	const leftArrow = document.createElement('div');
	leftArrow.className = 'arrow__left';
	leftArrow.id = nameArrowLeft;
	leftArrow.innerHTML = iconArrow;
	leftArrow.divRoll = nameServiceList;
	leftArrow.onclick = function get() {getRollLeft(leftArrow.divRoll)};
	document.getElementById(nome).appendChild(leftArrow);
	
	const rightArrow = document.createElement('div');
	rightArrow.className = 'arrow__right';
	rightArrow.id = nameArrowRight;
	rightArrow.innerHTML = iconArrow;
	rightArrow.divRoll = nameServiceList;
	rightArrow.onclick = function get() {getRollRight(rightArrow.divRoll)};
	document.getElementById(nome).appendChild(rightArrow);

	createServiceList(lista, nameServiceList);	
}


function createServiceList (lista, idDiv){

	// set veriaveis
	var qtdLista = lista.length;
	var caminho_img = 'assets/img/banner/'
	
	for (i = 1; i <= qtdLista; i++){
		var nameIdService = idDiv + i
		var src_img_completo = caminho_img + lista[i -1]['src_img'];

		const div = document.createElement('div');
		div.src_img = src_img_completo
		div.nome = lista[i -1]['nome'];
		div.cod_servico = lista[i-1]['codigo_index'];
		div.dataInicio = lista[i-1]['data_inicio'];
		div.dataFinal = lista[i-1]['data_final'];
		div.valorServico = lista[i-1]['valor'];

		div.className='service_item';
		div.id= nameIdService

		div.onclick = function get() {getImg(div.src_img, div.cod_servico, div.nome, div.dataInicio, div.dataFinal, div.valorServico)};
		document.getElementById(idDiv).appendChild(div);

		const img = document.createElement('img');
		img.src_img = src_img_completo
		img.setAttribute("src", img.src_img);
		document.getElementById(nameIdService).appendChild(img);
	}
}

function getImg (var_link, codigo, nome_servico, dataInicial, dataFinal, valorServico) {
	var nameService = document.getElementById('name__service');
	var dtInicial = document.getElementById('inicio__service');
	var dtFinal = document.getElementById('fim__service');
	var vlServico = document.getElementById('valor__service');

	nameService.innerHTML = nome_servico;
	dtInicial.innerHTML = dataInicial;
	dtFinal.innerHTML = dataFinal;
	vlServico.innerHTML = valorServico;



    document.getElementById('banner').style.backgroundImage = "url('"+ var_link +"')";
	document.getElementById('shop__box--img').style.backgroundImage = "url('"+ var_link +"')";
	document.getElementById('cod__servico').value = codigo;
	openShop();
}

function getRollRight(idArrow) {
	const arrow = document.getElementById(idArrow)
	arrow.scrollLeft += -180; 
}

function getRollLeft (idArrow) {
	const arrow = document.getElementById(idArrow)
	arrow.scrollLeft += 180;
}

function openShop () {
	var popup = document.getElementById('shop');
	if (popup.style.display === "none") {
		popup.style.display = "block";
	} else {
		popup.style.display = "none";
	}
}
