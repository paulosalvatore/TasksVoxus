$(function(){
	// Método de definição para o clique nas âncoras funcionar de forma suave
	$("a[href^='#']").click(function(e){
		e.preventDefault();

		var target = $('[name="' + $.attr(this, 'href').substr(1) + '"]');
		var $target = $(target);

		$("html, body").stop().animate({
			"scrollTop": $target.offset().top - 200
		}, 900, "swing");
	});

	// Base de definições para seletor de opções de diversas quantidades
	var baseDefinicoes = {
		1: {
			"posicoes": [
				[0]
			],
			"ordem": [
				[0, 0]
			],
			"posicaoInicial": [0, 0]
		},
		2: {
			"posicoes": [
				[-1, 1]
			],
			"ordem": [
				[0, 0],
				[0, 1]
			],
			"posicaoInicial": [0, 0]
		},
		3: {
			"posicoes": [
				[0],
				[-1, 1]
			],
			"ordem": [
				[0, 0],
				[1, 1],
				[1, 0]
			],
			"posicaoInicial": [1, 0]
		},
		4: {
			"posicoes": [
				[0],
				[-1, 1],
				[0]
			],
			"ordem": [
				[0, 0],
				[1, 1],
				[2, 0],
				[1, 0]
			],
			"posicaoInicial": [1, 0]
		},
		5: {
			"posicoes": [
				[0],
				[-1, 1],
				[-0.75, 0.75]
			],
			"ordem": [
				[0, 0],
				[1, 1],
				[2, 1],
				[2, 0],
				[1, 0]
			],
			"posicaoInicial": [1, 0]
		},
		6: {
			"posicoes": [
				[0],
				[-1, 1],
				[-0.75, 0.75],
				[0]
			],
			"ordem": [
				[0, 0],
				[1, 1],
				[2, 1],
				[3, 0],
				[2, 0],
				[1, 0]
			],
			"posicaoInicial": [1, 0]
		},
		7: {
			"posicoes": [
				[0],
				[-1, 1],
				[-0.75, 0.75],
				[-0.75, 0.75]
			],
			"ordem": [
				[0, 0],
				[1, 1],
				[2, 1],
				[3, 1],
				[3, 0],
				[2, 0],
				[1, 0]
			],
			"posicaoInicial": [1, 0]
		},
		8: {
			"posicoes": [
				[0],
				[-1, 1],
				[-0.75, 0.75],
				[-0.75, 0.75],
				[0]
			],
			"ordem": [
				[0, 0],
				[1, 1],
				[2, 1],
				[3, 1],
				[4, 0],
				[3, 0],
				[2, 0],
				[1, 0]
			],
			"posicaoInicial": [1, 0]
		}
	};

	// Variáveis iniciais
	var produto,
		produtos,
		selecaoDiametros,
		opcoesDiametros,
		selecaoEixos,
		opcoesEixos,
		elementoEixos,
		dica,
		menorLargura = 0,
		maiorLargura = 0,
		voltar;

	var posicaoDiferencaX = 200;
	var posicaoDiferencaY = 140;

	// Variável que armazena o diâmetro selecionado, -1 significa que não há nenhum selecionado
	// 0 ou maior significa a index do diâmetro
	var diametroSelecionado = -1;

	// Variável que armazena o eixo selecionado, -1 significa que não há nenhum selecionado
	// 0 ou maior significa a index do eixo
	var eixoSelecionado = -1;

	// Caso exista um elemento de produto na página
	// Mover essa lógica de JavaScript para um JS personalizado posteriormente
	// Remover essa checagem quando isso for feito

	// Pega o elemento do produto
	produto = $("#produto");
	produtos = $(".produto");

	if (produto.length > 0)
	{
		// Pega as opções de diâmetros disponíveis para esse produto
		opcoesDiametros = produto.find(".opcao.diametro");

		// Varre todos os elementos para checar qual é a menor largura
		opcoesDiametros.each(function(index, value){
			// Caso seja a primeira menorLargura ou seja menor do que a largura armazenada
			// atualmente, atualiza o valor
			if (menorLargura === 0 ||
				$(this)[0].offsetWidth < menorLargura)
			{
				menorLargura = $(this)[0].offsetWidth;
			}

			if (maiorLargura === 0 ||
				$(this)[0].offsetWidth > maiorLargura)
			{
				maiorLargura = $(this)[0].offsetWidth;
			}
		});

		// Pega alguns elementos básicos da página
		selecaoDiametros = $("#selecao_diametros");
		selecaoEixos = $("#selecao_eixos");
		dica = $("#dica");
		voltar = $("#voltar");

		// Ajusta a posição da seleção de eixos baseada na posição
		// da seleção de diâmetros
		selecaoEixos.css({
			"top": selecaoDiametros[0].offsetTop,
			"left": selecaoDiametros[0].offsetLeft,
			"width": selecaoDiametros[0].offsetWidth
		});

		// Pega todos os elementos de eixos
		elementoEixos = selecaoEixos.find(".caixa_opcao.base").clone();

		// Posiciona todos os elementos de diâmetros
		posicionarElementos(opcoesDiametros, "inicial", false);

		// Inicia o posicionamento animado dos elementos de diâmetros após um tempo
		setTimeout(function(){
			// Posiciona os Elementos na posição de definição, com animação
			posicionarElementos(opcoesDiametros, "definicao", true);

			// Exibe o elemento da dica
			exibirDica("diametro");
		}, 500);

		// Detecta o evento de clique em cada elemento de diâmetro
		opcoesDiametros.click(function(){
			// Ao clicar, chama a função de processamento do clique
			processarCliqueBotaoDiametro($(this));
		});

		// Checa se tem apenas uma opção de diâmetro
		if (opcoesDiametros.length === 1)
		{
			// Dispara um evento de clique na única opção do diâmetro após
			// um determinado tempo
			setTimeout(function(){
				opcoesDiametros.click();
			}, 500);
		}

		// Detecta o evento de clique no botão voltar
		voltar.click(function(){
			if (diametroSelecionado >= 0)
			{
				if (eixoSelecionado >= 0)
				{
					// Inicia o posicionamento animado dos elementos após um tempo
					setTimeout(function(){
						// Posiciona os elementos de diâmetros na posição inicial, com animação
						posicionarElementos(opcoesDiametros, "inicial", true);

						// Exibe os elementos dos diâmetros
						exibirElementos(opcoesEixos);

						// Posiciona os elementos de eixos na posição de definição, com animação
						posicionarElementos(opcoesEixos, "definicao", true);

						// Exibe o elemento da dica
						exibirDica("eixo");
					}, 500);

					// Remove a classe selecionado do elemento do eixo selecionado
					produto
						.find(".opcao.eixo.selecionado")
						.removeClass("selecionado");

					// Desseleciona e libera a seleção de diâmetro
					eixoSelecionado = -1;
				}
				else
				{
					// Checa se os elementos de opções de eixos existem
					if (opcoesEixos)
					{
						// Posiciona os elementos de eixos na posição inicial, com animação
						posicionarElementos(opcoesEixos, "inicial", true);

						// Oculta os elementos da opções de eixos
						ocultarElementos(opcoesEixos, -1);
					}

					// Inicia o posicionamento animado dos elementos de diâmetros após um tempo
					setTimeout(function(){
						// Exibe os elementos dos diâmetros
						exibirElementos(opcoesDiametros);

						// Posiciona os elementos de diâmetros na posição inicial, com animação
						posicionarElementos(opcoesDiametros, "inicial", false);

						// Posiciona os Elementos na posição de definição, com animação
						posicionarElementos(opcoesDiametros, "definicao", true);

						// Exibe o elemento da dica
						exibirDica("diametro");
					}, 500);

					// Remove a classe selecionado do elemento do diâmetro selecionado
					produto
						.find(".opcao.diametro.selecionado")
						.removeClass("selecionado");

					// Desseleciona e libera a seleção de diâmetro
					diametroSelecionado = -1;
				}
			}

			// Oculta o produto que está sendo exibido
			ocultarProduto();

			// Chama a função de posicionar o botão voltar após um tempo
			setTimeout(function(){
				// Posiciona o botão voltar
				posicionarBotaoVoltar();
			}, 1000);
		});

		// Função para posicionar elementos de acordo com as definições prévias
		// elementos: Array com elementos que serão posicionados
		// posicaoDestino: String ('inicial' ou 'definicao') - Informa a posição de destino
		// animar: Boolean - Define se o posicionamento será animado ou não
		function posicionarElementos(elementos, posicaoDestino, animar)
		{
			// Pega as bases de definições baseada na quantidade de diâmetros disponíveis
			var base = baseDefinicoes[elementos.length];
			var posicao = base.posicoes;
			var ordem = base.ordem;

			// Checa se a posição de destino é a inicial
			if (posicaoDestino === "inicial")
			{
				// Define a posição de destino como a posição inicial
				posicao = base.posicaoInicial;
			}
			else if (posicaoDestino === "inicial_duplo_esquerda")
			{
				// Define a posição de destino como a posição inicial
				// modificando o valor da esquerda
				posicao = base.posicaoInicial.slice();
				posicao[1] -= 0.5
			}
			else if (posicaoDestino === "inicial_duplo_direita")
			{
				// Define a posição de destino como a posição inicial
				// modificando o valor da direita
				posicao = base.posicaoInicial.slice();
				posicao[1] += 0.5
			}
			// Checa se a posição de destino é a de definição
			else if (posicaoDestino === "definicao")
			{
				// Constrói o array de definições corretamente, baseado nas posições definidas
				var definicoes = [];
				$.each(ordem, function(index, value){
					definicoes.push([value[0], posicao[value[0]][value[1]]]);
				});
			}

			// Varre todos os elementos para posicioná-los
			elementos.each(function(index, value){
				// Checa se a posição de destino é a de definição
				if (posicaoDestino === "definicao")
				{
					// Procura qual é a definição do elemento baseado no índice dele
					posicao = definicoes[index];
				}

				// Calcula o adicional de X, para corrigir a centralização do elemento
				var adicionalX = pegarAdicionalX($(this));

				// Posiciona o elemento na posição de destino
				posicionarElemento($(this), posicao, adicionalX, animar);
			});
		}

		// Função que calcula o adicional de X baseada na menor largura definida e na
		// largura do elemento. O valor retorna tem como objetivo ajustar a centralização
		// de todos os elementos.
		function pegarAdicionalX(elemento)
		{
			var largura = elemento[0].offsetWidth;

			return (maiorLargura - largura) / 2;
		}

		// Função para posicionar um elemento individualmente
		function posicionarElemento(elemento, posicao, adicionalX, animar)
		{
			// Declara as variáveis da posição de X (left) e de Y (top)
			var left = posicaoDiferencaX * posicao[1] + adicionalX;
			var top = posicaoDiferencaY * posicao[0];

			// Redefine o array de posição com os valores em pixels
			posicao = {
				"left": left,
				"top": top
			};

			// Checa se é necessário animar o posicionamento
			if (animar)
			{
				// Anima o posicionamento
				elemento.animate(posicao);
			}
			// Caso contrário
			else
			{
				// Posiciona diretamente
				elemento.css(posicao);
			}
		}

		// Função de processamento do clique em um botão de diâmetro
		function processarCliqueBotaoDiametro(elemento)
		{
			// Checa se não existem diâmetros selecionados
			if (diametroSelecionado >= 0)
				return false;

			// Define o diâmetro atual como selecionado
			diametroSelecionado = pegarIndexOpcao(elemento);

			// Adiciona a classe selecionado ao elemento clicado
			elemento.addClass("selecionado");

			// Posiciona os elementos de eixos na posição inicia, com animação
			posicionarElementos(opcoesDiametros, "inicial", true);

			// Oculta todos os elementos (exceto o selecionado), com animação na opacidade
			ocultarElementos(opcoesDiametros, diametroSelecionado);

			// Remove os botões existentes
			selecaoEixos.find(".caixa_opcao.base").remove();

			// Pega os eixos atrelados ao diâmetro selecionado
			var eixos = pegarEixos(elemento);

			// Constrói a seleção de eixos após um intervalo de tempo
			setTimeout(function(){
				// Checa se existe mais de um eixo disponível
				if (eixos.length > 1)
				{
					// Constrói a seleção de eixos
					construirSelecaoEixos(eixos);

					// Exibe a dica para selecionar um eixo
					exibirDica("eixo");
				}
				else
				{
					// Iniciar a Exibição do Produto
					iniciarExibicaoProduto();
				}

				// Inicia o posicionamento do botão voltar após um período de tempo
				setTimeout(function(){
					// Posiciona o botão voltar
					posicionarBotaoVoltar();
				}, 500);
			}, 500);
		}

		// Função de processamento do clique em um botão de eixo
		function processarCliqueBotaoEixo(elemento)
		{
			// Checa se não existem eixos selecionados
			if (eixoSelecionado >= 0)
				return false;

			// Define o eixo atual como selecionado
			eixoSelecionado = pegarIndexOpcao(elemento);

			// Adiciona a classe selecionado ao elemento clicado
			elemento.addClass("selecionado");

			// Posicionar os elementos de diâmetros na posição inicial, à esquerda, com animação
			posicionarElementos(opcoesDiametros, "inicial_duplo_esquerda", true);

			// Posiciona os elementos de eixos na posição inicial, à direita, com animação
			posicionarElementos(opcoesEixos, "inicial_duplo_direita", true);

			// Oculta todos os elementos (exceto o selecionado), com animação na opacidade
			ocultarElementos(opcoesEixos, eixoSelecionado);

			// Iniciar a Exibição do Produto
			iniciarExibicaoProduto();
		}

		function construirSelecaoEixos(eixos)
		{
			// Exibe o elemento que contém os botões de eixos
			selecaoEixos.show();

			// Constrói os botões de seleção de eixos
			$.each(eixos, function(index, value){
				// Clona o elemento base
				var novoElementoEixos = elementoEixos.clone();

				// Muda o texto do elemento novo
				novoElementoEixos
					.find(".btn")
					.text(value)
					.data("eixos", value)
					.click(function(){
						processarCliqueBotaoEixo($(this));
					});

				// Adiciona o elemento novo ao elemento de seleção de eixos
				selecaoEixos.append(novoElementoEixos);
			});

			// Pega os elementos de opções de eixos
			opcoesEixos = selecaoEixos.find(".opcao.eixo");

			// Posiciona todos na posição inicial, sem animação
			posicionarElementos(opcoesEixos, "inicial", false);

			// Inicia o posicionamento animado dos elementos de eixos após um tempo
			setTimeout(function(){
				// Posiciona os Elementos na posição de definição, com animação
				posicionarElementos(opcoesEixos, "definicao", true);
			}, 500);
		}

		// Função que exibe elementos
		function exibirElementos(elementos)
		{
			// Varre o array de elementos
			elementos.each(function(index, value) {
				// Define o objeto de css com a opacidade padrão em 0
				var css = {
					"opacity": 0
				};

				// Define o objeto de animação com a opacidade padrão em 1
				var animar = {
					"opacity": 1
				};

				// Aplica o objeto de CSS, exibe o elemento e depois anima
				$(this)
					.css(css)
					.show()
					.animate(animar);
			});
		}

		// Função que oculta elementos
		function ocultarElementos(elementos, indexSelecionada)
		{
			// Varre o array de elementos
			elementos.each(function(index, value){
				// Pega o zIndexBase do elemento vindo do CSS
				zIndexBase = parseInt($(this).css("z-index"));

				// Define o objeto de animação com a opacidade padrão em 0
				var animar = {
					"opacity": 0
				};

				// Define o objeto de CSS com o z-index padrão definido a
				// partir da base
				var css = {
					"z-index": zIndexBase
				};

				// Caso o índice do elemento seja igual ao index selecionado
				// altera a opacidade para 1
				// Ou seja, caso seja o elemento selecionado, mantém ele sendo exibido
				// Caso contrário, altera a opacidade do elemento
				if (index === indexSelecionada)
				{
					animar.opacity = 1;
					css["z-index"] += 1;
				}

				$(this).css(css);

				// Checa se a opacidade definida para o elemento é igual a 0
				if (animar.opacity === 0)
				{
					// Chama a função de animação da opacidade
					$(this).animate(animar, function(){
						// Oculta o elemento assim que a animação for concluída
						$(this).hide();
					});
				}
			});
		}

		// Função que recebe um elemento e retorna um array com os eixos declarados
		// no atributo data-eixos
		function pegarEixos(elemento)
		{
			// Pega o valor do atributo data-eixos e certifica que sempre vem como string
			var eixos = elemento.data("eixos").toString();

			// Caso tenha mais de um, os eixos são separados por vírgula
			// Caso exista uma vírgula no atributo data-eixos, separa os eixos em um array
			if (eixos.indexOf(",") > -1)
				eixos = elemento.data("eixos").split(",");
			// Caso contrário, armazena o eixo em um array novo, para certificar que
			// que o retorno da função seja sempre um array, mesmo que com apenas um elemento
			else
				eixos = [eixos];

			// Retorna o array construído com todos os eixos existentes no atributo data-eixos
			return eixos;
		}

		// Função que pega o index de um elemento de opção (botão)
		function pegarIndexOpcao(elemento)
		{
			// Retorna o index do elemento 'pai' com a classe '.caixa_opcao'
			return elemento.closest(".caixa_opcao").index();
		}

		// Função que inicia a exibição do produto após um tempo
		function iniciarExibicaoProduto()
		{
			// Oculta o elemento de dica
			ocultarDica();

			// Chama uma função após um tempo
			setTimeout(function(){
				// Exibir Produto
				exibirProduto();
			}, 1000);
		}

		// Posiciona o botão 'voltar'
		function posicionarBotaoVoltar()
		{
			if (diametroSelecionado === -1)
			{
				voltar.css({
					"opacity": 0
				});

				return;
			}

			var offsetTop = 0;

			offsetTop = calcularMaiorOffsetTop(offsetTop, opcoesDiametros);
			offsetTop = calcularMaiorOffsetTop(offsetTop, opcoesEixos);

			voltar.css({
				"top": offsetTop + 115
			});

			voltar.animate({
				"opacity": 1
			});
		}

		// Função que recebe alguns elementos e calcula o maior offsetTop
		function calcularMaiorOffsetTop(offsetTop, opcoes)
		{
			// Checa se o array de opçoes existe, caso não exista, retorna o
			// offsetTop padrão que foi recebido
			if (typeof(opcoes) === "undefined")
				return offsetTop;

			// Varre o array de elementos
			opcoes.each(function(index, value){
				// Checar se o elemento está visível e se o offsetTop dele é
				// maior que o offset armazenado anteriormente
				// Caso seja, atualiza o valor do offsetTop
				if ($(this).is(":visible") &&
					$(this)[0].offsetTop > offsetTop)
					offsetTop = $(this)[0].offsetTop;
			});

			// Retorna o valor do offsetTop calculado
			return offsetTop;
		}

		// Exibe o elemento de exibição do produto
		function exibirProduto()
		{
			// Definições de variáveis iniciais
			var diametroMin,
				diametroMax,
				eixo,
				findString = "";

			// Pega o elemento do diâmetro baseado no valor do diâmetro selecionado
			var diametroElemento = opcoesDiametros.eq(diametroSelecionado);

			// Pega o atributo data-min e data-max do elemento
			diametroMin = diametroElemento.data("min");
			diametroMax = diametroElemento.data("max");

			// Constrói a string de procura para buscar o elemento do produto
			findString += "[data-diametro_min='" + diametroMin + "']";
			findString += "[data-diametro_max='" + diametroMax + "']";

			// Valida se há um eixo selecionado ou não
			if (eixoSelecionado >= 0)
			{
				// Pega o elemento do eixo selecionado
				var eixoElemento = opcoesEixos.eq(eixoSelecionado);

				// Pega o atributo data-eixos e armazena na variável eixo
				// certificando que o valor é um inteiro
				eixo = parseInt(eixoElemento.data("eixos"));

				// Adiciona a informação para buscar o produto também pelo eixo
				findString += "[data-eixos='" + eixo + "']";
			}

			// Com a variável construída, busca o elemento do produto selecionado
			var produto = $(".produto" + findString);

			// Define o código exibido na parte superior da página pegando
			// o código do produto sendo exibido
			$("#codigo").text(produto.data("codigo") + " - ");

			// Exibe o produto com animação de slideDown
			produto.slideDown();
		}

		// Oculta o elemento de exibição do produto
		function ocultarProduto()
		{
			// Oculta o elemento do a animação de slideUp
			produtos.slideUp();
		}

		// Altera o conteúdo do elemento dica
		// Recebe uma string (diametro ou eixo), pega o valor armazenado
		// no atributo data e altera o texto do elemento com esse valor
		function exibirDica(data)
		{
			// Aplica um fadeOut no elemento dica
			// Quando estiver concluído, aplica um fadeIn e altera o texto
			// para o valor que está no atributo data-{data}, sendo que
			// {data} foi recebido como parâmetro na função
			dica
				.fadeOut(300, function(){
					$(this)
						.fadeIn(300)
						.text(
							$(this).data(data)
						);
				})
		}

		// Função para ocultar o elemento de dica
		function ocultarDica()
		{
			// Aplica um fadeOut no elemento dica com duração personalizada
			dica.fadeOut(300);
		}
	}

	var search = $("#search");
	search.keyup(function(){
		var valor = $(this).val();

		if (valor.length === 0)
		{
			$(".produto").show();

			return;
		}

		$.each(categorias, function(index, categoria){
			var elemento = $("[data-categoria_id='" + categoria.id + "']");

			if ((categoria.descricao.toLowerCase()).indexOf(valor) >= 0)
			{
				elemento.show();
			}
			else
			{
				elemento.hide();
			}
		});
	});

	$(".caixa_pesquisa").find("button").click(function(){
		search.keyup();
	});
});
