// Funções de Blocos Estáticos

// Função de definição de index de blocos estáticos
function atualizarIndexBlocosEstaticos()
{
	// Para cada bloco estático, atualiza o valor do index
	$(".bloco_estatico").each(function(index, value){
		$(this).find("input, textarea, select").each(function(){
			var name = $(this).attr("name");
			name = name.split("[");
			name = name[0] + "[" + index + "][" + name[2];
			$(this).attr("name", name);
		});
	});
}

// Função de validação de exclusão de blocos estáticos
// Essa função checa se existe mais do que um bloco ou se o único bloco
// existente não possui uma ID atrelada.
// O bloco que não possuir ID atrelada só pode ser excluído caso ele
// não seja obrigatório
function validarExclusaoBlocoEstatico(elemento)
{
	// Pega a quantidade de blocos estáticos no blocos_estaticos atual
	var blocosEstaticos =
		elemento
			.closest(".blocos_estaticos")
			.find(".bloco_estatico:visible");

	// Se tiver apenas um bloco disponível, precisa checar se esse campo
	// é obrigatório ou não
	if (blocosEstaticos.length === 1)
	{
		// Checa se o bloco é obrigatório
		var obrigatorio = elemento.data("obrigatorio") === 1;

		// Caso seja obrigatório, precisa checar se o registro não vem do banco
		if (obrigatorio)
		{
			// Checa se o bloco possui uma ID válida
			var idValida = elemento.find(".id").val() > 0;

			// Caso não possua, libera a exclusão do bloco retornando um true
			if (!idValida)
				return true;
		}
		// Caso não seja obrigatório, libera a exclusão
		else
			return true;
	}
	// Caso a quantidade de blocos seja maior do que 1, libera a exclusão
	else if (blocosEstaticos.length > 1)
		return true;

	// Caso não tenha retornando nenhum true anteriormente, não libera a exclusão
	return false;
}

// Função de atribuição de eventos de bloco estático, recebido
// através da variável elemento
function atribuirEventosBlocosEstaticos(elemento)
{
	// Aplica as máscaras dos inputs
	aplicarMascarasInputs();

	elemento
	// Quando o mouse entra
		.mouseenter(function(){
			// Valida se o bloco pode ser excluído ou não e exibe o botão fechar
			if (validarExclusaoBlocoEstatico($(this)))
				$(this).find(".fechar").show();
		})
		// Quando o mouse sai
		.mouseleave(function(){
			// Valida se o bloco pode ser excluído ou não e oculta o botão fechar
			if (validarExclusaoBlocoEstatico($(this)))
				$(this).find(".fechar").hide();
		});

	elemento
		.find(".fechar")
		.click(function(){
			// Se o bloco puder ser excluído e após a confirmação de exclusão
			if (validarExclusaoBlocoEstatico($(this)) &&
				confirm($(this).data("confirm")))
			{
				// Pega o bloco estático que está com o botão de fechar
				var blocoEstatico = $(this).closest(".bloco_estatico");

				// Checa se o bloco estático possui uma ID ou não
				if (blocoEstatico.find("input.id").val() > 0)
				{
					// Caso possua, marca o input ativo como 0 (false)
					blocoEstatico
						.find("input[name*='ativo']")
						.val(0);

					// Esconde o elemento
					blocoEstatico.hide();
				}
				// Caso não possua, inicia a lógica para remoção do elemento
				else
				{
					// Pega a quantidade de blocos estáticos no blocos_estaticos atual
					var blocosEstaticos =
						elemento
							.closest(".blocos_estaticos")
							.find(".bloco_estatico:visible");

					// Se houver apenas um bloco, apenas esconde
					if (blocosEstaticos.length === 1)
					{
						// Esconde o bloco
						blocoEstatico.hide();

						// Pegar todos os campos do bloco estático
						var campos =
							blocoEstatico
								.find("input, select, textarea");

						// Desativa todos os campos, para que não sejam
						// checados pela validação
						if (typeof(campos) !== "undefined")
							campos.prop("disabled", true);
					}
					// Caso contrário, remove o bloco
					else
						blocoEstatico.remove();

					// Atualiza o index de todos os blocos da página
					atualizarIndexBlocosEstaticos();
				}

				eventosCustomizados(blocoEstatico);
			}
		});
}

$(function(){
	// Adição/Remoção de Bloco Estático

	$(".adicionar").click(function(){
		// Pega o último bloco estático (visível) do blocos_estaticos onde está o botão
		var blocoEstatico =
			$(this)
				.closest(".blocos_estaticos")
				.find(".bloco_estatico:visible")
				.last();

		// Define a variável clonarBlocoEstatico como verdadeira
		var clonarBlocoEstatico = true;

		// Se não encontrou nenhum bloco estático, é porque o primeiro bloco
		// carregado pelo PHP foi ocultado, por se tratar de um bloco não
		// obrigatório. Isso é feito para evitar a obrigatoriedade inicial
		// dos campos
		if (blocoEstatico.length === 0)
		{
			// Pega o primeiro e único bloco estático que está escondido e
			// armazena na variável blocoEstatico
			blocoEstatico =
				$(this)
					.closest(".blocos_estaticos")
					.find(".bloco_estatico:hidden")
					.first();

			// Define o clone do bloco estático como falso, para que a lógica
			// abaixo apenas exiba o bloco pego anteriormente
			clonarBlocoEstatico = false;
		}

		// Caso a variável clonarBlocoEstatico seja verdadeira
		if (clonarBlocoEstatico)
		{
			// Clona o elemento inteiro do bloco estático
			var blocoEstaticoClone = blocoEstatico.clone();

			// Limpa todos os valores de inputs, selects e textareas
			blocoEstaticoClone
				.find("input, select, textarea")
				.val("");

			// Altera o valor do input ativo para 1
			blocoEstaticoClone
				.find("input[name*='ativo']")
				.val(1);

			// Insere o bloco clonado e limpo após o último bloco que foi pego anteriormente
			blocoEstaticoClone =
				$(blocoEstaticoClone)
					.insertAfter(blocoEstatico);

			// Atribui os eventos do botão fechar no bloco estático novo
			atribuirEventosBlocosEstaticos(blocoEstaticoClone);

			// Atualiza a Index dos Blocos Estáticos
			atualizarIndexBlocosEstaticos();

			// Chama todos os eventos customizados da aplicação
			eventosCustomizados(blocoEstaticoClone);
		}
		else
		{
			// Pega todos os campos dentro do bloco, ativa eles e limpa
			blocoEstatico
				.find("input, select, textarea")
				.prop("disabled", false)
				.val("");

			// Altera o valor do input ativo para 1
			blocoEstatico
				.find("input[name*='ativo']")
				.val(1);

			// Exibe o bloco
			blocoEstatico.css("display", "inline-block");

			// Chama todos os eventos customizados da aplicação
			eventosCustomizados(blocoEstatico);
		}
	});

	// Para cada blocos_estaticos da tela procura os respectivos blocos estáticos
	$(".blocos_estaticos")
		.each(function(){
			// Pega todos os blocos estáticos na tela e esconde-os caso o valor do campo ativo seja falso
			$(this)
				.find(".bloco_estatico")
				.each(function(index){
					// Checa se o bloco estático é obrigatório ou não
					var obrigatorio = $(this).data("obrigatorio") === 1;

					// Checa se o registro vem do banco ou não
					var idValida = $(this).find(".id").val() > 0;

					// Se o registro não vier do banco e não for obrigatório,
					// marca o campo ativo como 0 (falso)
					if (!idValida && !obrigatorio)
						$(this).find("input[name*='ativo']").val(0);

					// Pega o valor do campo ativo
					var ativo = $(this).find("input[name*='ativo']").val() === "1";

					var ocultarBloco = !ativo;

					// Pega apenas o primeiro bloco estático caso ele não seja obrigatório
					if (index === 0 && !obrigatorio)
					{
						// Pega todos os campos dentro do bloco
						var campos =
							$(this)
								.find("input, select, textarea");

						// Pega todos os campos vazios
						var camposVazios = [];
						campos.each(function(){
							if ($(this).val() === "")
								camposVazios.push($(this));
						});

						// Se a quantidade de campos for a mesma que de campos vazios,
						// ou seja, se todos os campos encontrados estiverem vazios,
						// marca a variável ocultarBloco como 'true' para que
						// o bloco seja ocultado posteriormente
						if (campos.length === camposVazios.length)
							ocultarBloco = true;
					}

					// Para cada elemento, aplica os eventos
					atribuirEventosBlocosEstaticos($(this));

					// Checa se a variável ocultarBloco está como 'true'
					if (ocultarBloco)
					{
						// Esconde o bloco estático, pois ele é o inicial
						$(this).hide();

						// Desativa todos os campos, para que não sejam
						// checados pela validação
						campos.prop("disabled", true);
					}
				});
		});
});
