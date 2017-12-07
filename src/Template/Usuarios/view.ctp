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
					$usuario,
					[
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
									<?= __("View") . " " . __("User") ?>
								<?php elseif (isset($usuario->id)): ?>
									<?= __("Edit") . " " . __("User") ?>
								<?php else: ?>
									<?= __("Add") . " " . __("User") ?>
								<?php endif; ?>
							</h2>
						</div>
					</div>
				</div>

				<div class="block-content">
					<div class="form-group">
						<div class="row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="nome">
								<?= __("Name") ?>
								<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-5 col-xs-12">
								<div class="input-group">
									<div class="input-group-addon">
										<span class="fa fa-user"></span>
									</div>
									<?=
										$this
											->Form
											->input(
												"nome",
												[
													"label" => false,
													"data-bvalidator" => "required,maxlen[150]",
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
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">
								<?= __("E-mail") ?>
								<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-5 col-xs-12">
								<div class="input-group">
									<div class="input-group-addon">
										<span class="fa fa-envelope"></span>
									</div>
									<?=
										$this
											->Form
											->input(
												"email",
												[
													"label" => false,
													"data-bvalidator" => "required,maxlen[150]",
													"autocomplete" => "off",
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
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="senha">
								<?php if (!$visualizar && isset($usuario->id)): ?>
									<?= __("Change") ?>
								<?php endif; ?>

								<?= __("Password") ?>

								<?php if (!isset($usuario->id)): ?>
									<span class="required">*</span>
								<?php endif; ?>
							</label>
							<div class="col-md-6 col-sm-5 col-xs-12">
								<div class="input-group">
									<div class="input-group-addon">
										<span class="fa fa-lock"></span>
									</div>
									<?=
										$this
											->Form
											->input(
												"senha",
												[
													"type" => "password",
													"label" => false,
													"data-bvalidator" => "minlen[8],maxlen[255]"
														.(!isset($usuario->id) ? ",required" : ""),
													"required" => false,
													"class" => "form-control",
													"value" => ""
												]
											)
									?>
								</div>
							</div>
						</div>
					</div>

					<div class="form-group">
						<div class="row">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirmar-senha">
								<?= __("Confirm Password") ?>
								<span class="required">*</span>
							</label>
							<div class="col-md-6 col-sm-5 col-xs-12">
								<div class="input-group">
									<div class="input-group-addon">
										<span class="fa fa-lock"></span>
									</div>
									<?=
										$this
											->Form
											->input(
												"confirmar_senha",
												[
													"type" => "password",
													"label" => false,
													"data-bvalidator" => "equal[senha]",
													"class" => "form-control"
												]
											)
									?>
								</div>
							</div>
						</div>
					</div>

					<?php if ($usuarioConectado["administrador"]): ?>
						<div class="form-group">
							<div class="row">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="administrador">
									<?= __("Administrator") ?>
								</label>
								<div class="col-md-6 col-sm-6 col-xs-12">
									<div class="input-group">
									<?=
										$this
											->Form
											->input(
												"administrador",
												[
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
									<?php if (isset($usuario->id)): ?>
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
			</div>
		<?=
			$this
				->Form
				->end();
		?>
	</div>
</div>
<br>
