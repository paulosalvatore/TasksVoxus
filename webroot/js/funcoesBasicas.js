
// JS Switch

function desativarJsSwitch()
{
	$(".js-switch")
		.each(function(){
			$(this)
				.closest("div")
				.find(".switchery")
				.attr("disabled", true);
		});
}

function atribuirJsSwitch()
{
	$(".js-switch")
		.each(function(){
			$(this)
				.closest(".input")
				.find(".switchery")
				.remove();

			new Switchery($(this)[0], {
				color: "#26B99A"
			});
		});
}

// DataTable

function definirDataTable()
{
	var dataTable = $(".datatable");
	var dataTableOrder = [];

	dataTable
		.find("thead")
		.find("tr")
		.find("th")
		.each(function(){
			var defaultSort = $(this).hasClass("default_sort");

			if (defaultSort)
			{
				var index = $(this).index();

				var defaultSortType = $(this).hasClass("desc") ? "desc" : "asc";

				dataTableOrder.push([index, defaultSortType]);
			}
		});

	if (dataTableOrder.length === 0)
		dataTableOrder.push([0, "asc"]);

	dataTable.dataTable({
		/*"language": {
			"url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/Portuguese-Brasil.json"
		},*/
		"responsive": true,
		"columnDefs": [
			{
				targets: "no-sort",
				orderable: false
			}
		],
		"order": dataTableOrder
	});
}

// Eventos Customizados

function eventosCustomizados(elemento)
{
	// Atribui o bootstrap tooltip aos elementos marcados
	// $("[data-toggle='tooltip']").tooltip();

	// Máscaras de Inputs
	aplicarMascarasInputs();

	// DataTable
	definirDataTable();

	// Checa se a página é apenas de visualização
	checarPaginaApenasVisualizacao();

	// Atribui os JsSwitch na página
	atribuirJsSwitch();
}

function checarPaginaApenasVisualizacao()
{
	// Desativa os inputs das página de visualização
	if (typeof(visualizar) !== "undefined" && visualizar === 1)
	{
		$("input, select, textarea")
			.not("[forceenabled='1']")
			.prop("disabled", true);

		desativarJsSwitch();
	}
}

// Função para aplicar máscaras nos inputs da página
function aplicarMascarasInputs()
{
	$("input[name*='telefone'], input[name*='celular']").inputmask("(99) 9999-9999[9]", {clearIncomplete: true});

	$("#cpf").inputmask("999.999.999-99", {clearIncomplete: true});

	$("#cep").inputmask("99999-999", {clearIncomplete: true});

	$("#cnpj").inputmask("99.999.999/9999-99", {clearIncomplete: true});

	$(".valor")
		.maskMoney({
			thousands: ".",
			decimal: ","
		});
}

$(function(){
	// Chama os Eventos Customizados
	eventosCustomizados();

	// Limpar inputs com o atributo "autocomplete" off
	$(":input").change(function(){
		if ($(this).attr("autocomplete") === "off")
		{
			$(this)
				.val("")
				.attr("autocomplete", "on");
		}
	});

	setTimeout(function(){
		$(":input").each(function(){
			if ($(this).attr("autocomplete") === "off")
				$(this).attr("autocomplete", "on");
		});
	}, 500);

	// Validação de Formulários com o bValidator

	$("form[data-bvalidator-validate]")
		.bValidator();

	$("form").submit(function(){
		if (typeof($(this).data("bvalidator-validate")) === "undefined" ||
			$(this).data("bValidator").isValid())
		{
			var botao = $(this).find("[type='submit']");
			var confirmarMensagem = botao.attr("confirm");

			if (!confirmarMensagem || confirm(confirmarMensagem))
			{
				var cnpjElemento = $("#cnpj");
				if (cnpjElemento.length > 0 && !validarCNPJ(cnpjElemento.val()))
				{
					alert("CNPJ inválido!");
					return false;
				}

				var validarCheckboxes = true;
				$(this).find(".js-switch").each(function(){
					if ($(this).attr("data-bvalidator") && $(this).attr("data-bvalidator").indexOf("required") !== -1 && !$(this).is(":checked"))
						validarCheckboxes = false;
				});

				if (validarCheckboxes)
				{
					if (!botao.hasClass("habilitado_fixo"))
						botao.prop("disabled", true);

					return true;
				}
				else
					return validarCheckboxes;
			}
		}

		return false;
	});
});
