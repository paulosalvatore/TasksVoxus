<?php
	$controller = [
		"nome" => __("Users"),
		"itens" => $usuarios,
		"campos" => [
			[
				"campo" => "nome",
				"nome" =>  __("Name"),
				"tamanho" => 40
			],
			[
				"campo" => "email",
				"nome" =>  __("E-mail"),
				"tamanho" => 35
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
