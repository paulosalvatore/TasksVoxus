<div class="row">
	<div class="col-md-12 col-sm-12 col-xs-12">
		<?php if ((!isset($controller["botões"]["adicionar"]) || $controller["botões"]["adicionar"]) &&
				(!isset($permissoes) || $permissoes["adicionar"])): ?>
			<div class="row margem">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<?=
						$this
							->Html
							->link(
								__("Add"),
								[
									"controller" =>
										isset($controller["controller"])
											? $controller["controller"]
											: $this->request->controller,
									"action" => "view"
								],
								[
									"class" => "btn btn-md btn-success btn-clean",
									"escape" => false
								]
							)
					?>
				</div>
			</div>

			<br>
			<br>
		<?php endif; ?>

		<div class="block block-condensed">
			<div class="block-heading">
				<div class="app-heading app-heading-small">
					<div class="title">
						<h5><?= __("Showing:") ?> <?= $controller["nome"] ?></h5>
					</div>
				</div>
			</div>
			<div class="block-content">
				<table class="table table-striped table-bordered table-head-custom datatable">
					<thead>
						<tr>
							<?php $tamanhoTotal = 0; ?>

							<?php foreach ($controller["campos"] as $campo): ?>
								<?php
									$tamanhoTotal += $campo["tamanho"];

									$sort = "";
									if (isset($campo["sort"]) && !$campo["sort"])
										$sort = "no-sort";
								?>

								<th width="<?= $campo["tamanho"] ?>%" class="<?= $sort ?>">
									<?= $campo["nome"] ?>
								</th>
							<?php endforeach; ?>

							<th width="<?= 100 - $tamanhoTotal ?>%" class="no-sort">Ações</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($controller["itens"] as $item): ?>
							<tr>
								<?php foreach ($controller["campos"] as $campo): ?>
									<td>
										<?php
											if (is_array($campo["campo"]))
											{
												$valor = $item;

												foreach ($campo["campo"] as $chave)
													$valor = $valor[$chave];

												echo h($valor);
											}
											elseif (!isset($campo["tipo"]))
												echo h($item[$campo["campo"]]);
											elseif ($campo["tipo"] == "count")
												echo count($item[$campo["campo"]]);

											if (isset($campo["adicionais"]))
												echo $campo["adicionais"];
										?>
									</td>
								<?php endforeach; ?>

								<td align="center">
									<?php if (isset($controller["acoes"])): ?>
										<?php foreach ($controller["acoes"] as $nome => $acao): ?>
											<?php
												if (in_array("item_id", $acao["url"]))
												{
													$key = array_search("item_id", $acao["url"]);

													$acao["url"][$key] = $item->id;
												}
											?>

											<?=
												$this
													->Html
													->link(
														(isset($acao["icone"])
															? '<span class="fa fa-' . $acao["icone"] . '" aria-hidden="true"></span> '
															: "")
														.$nome,
														$acao["url"],
														$acao["atributos"]
													)
											?>
										<?php endforeach; ?>
									<?php endif; ?>

									<?php if ((!isset($controller["botões"]["visualizar"]) || $controller["botões"]["visualizar"]) &&
										(!isset($permissoes) || $permissoes["visualizar"])): ?>
										<?=
											$this
												->Html
												->link(
													'<span class="fa fa-eye" aria-hidden="true"></span>',
													[
														"controller" =>
															isset($controller["controller"])
																? $controller["controller"]
																: $this->request->controller,
														"action" => "view",
														$item->id,
														true
													],
													[
														"class" => "btn btn-success btn-icon btn-clean",
														"escape" => false,
														"title" => __("View")
													]
												)
										?>
									<?php endif; ?>

									<?php if ((!isset($controller["botões"]["editar"]) || $controller["botões"]["editar"]) &&
										(!isset($permissoes) || $permissoes["editar"])): ?>
										<?=
											$this
												->Html
												->link(
													'<span class="fa fa-edit" aria-hidden="true"></span>',
													[
														"controller" =>
															isset($controller["controller"])
																? $controller["controller"]
																: $this->request->controller,
														"action" => "view",
														$item->id
													],
													[
														"class" => "btn btn-primary btn-icon btn-clean",
														"escape" => false,
														"title" => __("Edit")
													]
												)
										?>
									<?php endif; ?>

									<?php if ((!isset($controller["botões"]["remover"]) || $controller["botões"]["remover"]) &&
										(!isset($permissoes) || $permissoes["remover"])): ?>
										<?=
											$this
												->Form
												->postButton(
													'<span class="fa fa-remove" aria-hidden="true"></span>',
													[
														"controller" =>
															isset($controller["controller"])
																? $controller["controller"]
																: $this->request->controller,
														"action" => "delete",
														$item->id
													],
													[
														"class" => "btn btn-danger btn-icon btn-clean",
														"confirm" => __("Are you shure you want to delete this item?"),
														"escape" => false,
														"title" => __("Delete")
													]
												)
										?>
									<?php endif; ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<br>
