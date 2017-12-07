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
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">
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
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="descricao">
								<?= __("Priority") ?> (1 - 5)
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
			</div>
		<?=
			$this
				->Form
				->end();
		?>
	</div>
</div>
<br>
