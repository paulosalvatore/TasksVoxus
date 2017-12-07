<?php
	$controller = [
		"nome" => __("Tasks"),
		"itens" => $tasks,
		"campos" => [
			[
				"campo" => "titulo",
				"nome" =>  __("Title"),
				"tamanho" => 30
			],
			[
				"campo" => "descricao",
				"nome" =>  __("Description"),
				"tamanho" => 50
			]
		]
	];
?>

<?=
	$this->element(
		"show",
		[
			"controller" => $controller
		]
	)
?>
