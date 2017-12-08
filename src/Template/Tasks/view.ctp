<div class="row margem">
	<div class="div-col-md-12">
		<?=
			$this
				->Html
				->link(
					__("Show All"),
					[
						"action" => "show"
					],
					[
						"class" => "btn btn-clean btn-primary btn-md"
					]
				)
		?>

		<br>

		<?=
			$this
				->Form
				->create(
					$task,
					[
						"type" => "file",
						"class" => "form-horizontal",
						"data-bvalidator-validate"
					]
				)
		?>
			<br>
			<div class="block block-condensed">
				<div class="block-heading">
					<div class="app-heading app-heading-small">
						<div class="title">
							<h2>
								<?php if ($visualizar): ?>
									<?= __("View") . " " . __("Task") ?>
								<?php elseif (isset($task->id)): ?>
									<?= __("Edit") . " " . __("Task") ?>
								<?php else: ?>
									<?= __("Add") . " " . __("Task") ?>
								<?php endif; ?>
							</h2>
						</div>
					</div>
				</div>

				<div class="block-content">
					<div class="form-group">
						<div class="row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="titulo">
								<?= __("Title") ?>
								<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-5 col-xs-12">
								<div class="input-group">
									<div class="input-group-addon">
										<span class="fa fa-info-circle"></span>
									</div>
									<?=
										$this
											->Form
											->input(
												"titulo",
												[
													"label" => false,
													"data-bvalidator" => "required,maxlen[255]",
													"class" => "form-control"
												]
											)
									?>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">
								<?= __("Description") ?>
								<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-5 col-xs-12">
								<div class="input-group">
									<div class="input-group-addon">
										<span class="fa fa-info-circle"></span>
									</div>
									<?=
										$this
											->Form
											->input(
												"descricao",
												[
													"label" => false,
													"data-bvalidator" => "required,maxlen[65535]",
													"class" => "form-control"
												]
											)
									?>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="prioridade">
								<?= __("Priority") ?> (1 - 5)
								<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-5 col-xs-12">
								<div class="input-group">
									<div class="input-group-addon">
										<span class="fa fa-warning"></span>
									</div>
									<?=
										$this
											->Form
											->input(
												"prioridade",
												[
													"label" => false,
													"data-bvalidator" => "required,maxlen[1]",
													"class" => "form-control"
												]
											)
									?>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="tasks-arquivos">
								<?= __("Files") ?>
							</label>
							<div class="col-md-6 col-sm-5 col-xs-12">
								<div class="input-group">
									<div class="input-group-addon">
										<span class="fa fa-file"></span>
									</div>
									<?=
										$this
											->Form
											->input(
												"tasks_arquivos[]",
												[
													"type" => "file",
													"label" => false,
													"class" => "form-control",
													"multiple" => true,
													"accept" => Arquivos::pegarFormatosAceitos("Tasks", "tasks_arquivos", true, true)
												]
											)
									?>
								</div>
							</div>
						</div>
					</div>

					<?php if ($task->id && !$visualizar): ?>
						<div class="form-group">
							<div class="row">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="concluida">
									<?= __("Done") ?>
								</label>
								<div class="col-md-6 col-sm-5 col-xs-12">
									<div class="input-group">
										<?=
											$this
												->Form
												->input(
													"concluida",
													[
														"type" => "checkbox",
														"label" => false,
														"class" => "js-switch"
													]
												)
										?>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>
				</div>

				<?php if (!$visualizar): ?>
					<div class="block-footer">
						<br>
						<div class="form-group">
							<div class="row">
								<div class="col-md-3 col-sm-3 col-xs-0">
								</div>
								<div class="col-md-6 col-sm-5 col-xs-12">
									<?php if (isset($task->id)): ?>
										<?=
											$this
												->Form
												->button(
													__("Edit"),
													[
														"type" => "submit",
														"class" => "pull-left btn btn-primary btn-clean",
														"escape" => false
													]
												)
										?>
									<?php else: ?>
										<?=
											$this
												->Form
												->button(
													__("Add"),
													[
														"type" => "submit",
														"class" => "pull-left btn btn-success btn-clean",
														"escape" => false
													]
												)
										?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				<?php endif; ?>
			<?=
				$this
					->Form
					->end();
			?>

			<?php if (isset($task->id)): ?>
				<div class="block-heading">
					<div class="app-heading app-heading-small">
						<div class="title">
							<h2>
								<?= __("Task Files") ?>
							</h2>
						</div>
					</div>
				</div>

				<div class="block-content">
					<?php
						$controller = [
							"nome" => __("Task Files"),
							"controller" => "TasksArquivos",
							"itens" => $task->tasks_arquivos,
							"campos" => [
								[
									"campo" => "nome_original",
									"nome" =>  __("Filename"),
									"tamanho" => 30
								],
								[
									"campo" => [
										"usuario",
										"nome"
									],
									"nome" =>  __("Uploaded by"),
									"tamanho" => 30
								],
								[
									"campo" => "criado",
									"nome" =>  __("Uploaded date"),
									"tamanho" => 20
								]
							],
							"botões" => [
								"adicionar" => false,
								"editar" => false,
								"visualizar" => false
							],
							"acoes" => [
								"visualizar_arquivo" => [
									"ocultarNome" => true,
									"url" => [
										"controller" => "TasksArquivos",
										"action" => "view",
										"item_id"
									],
									"icone" => "eye",
									"atributos" => [
										"class" => "btn btn-success btn-icon btn-clean",
										"escape" => false,
										"title" => __("View File"),
										"target" => "_blank"
									]
								],
								"download_arquivo" => [
									"ocultarNome" => true,
									"url" => [
										"controller" => "TasksArquivos",
										"action" => "download",
										"item_id"
									],
									"icone" => "download",
									"atributos" => [
										"class" => "btn btn-primary btn-icon btn-clean",
										"escape" => false,
										"title" => __("Download File"),
										"target" => "_blank"
									]
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
				</div>
			<?php endif; ?>
		</div>
	</div>
</div>
<br>
