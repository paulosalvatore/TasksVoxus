<div class="row">
	<div class="col-md-4 col-sm-1 col-xs-0">
	</div>
	<div class="col-md-4 col-sm-8 col-xs-12">
		<?=
			$this
				->Form
				->create(
				);
		?>
			<div class="form-group">
				<?=
					$this
						->Form
						->input(
							"email",
							[
								"class" => "form-control input-login-size",
								"placeholder" => __("E-mail")
							]
						);
				?>
			</div>

			<div class="form-group">
				<?=
					$this
						->Form
						->input(
							"senha",
							[
								"type" => "password",
								"class" => "form-control input-login-size",
								"placeholder" => __("Password")
							]
						);
				?>
			</div>

			<div class="form-group">
				<div class="col-md-4 col-sm-3 col-xs-3">
				</div>
				<div class="col-md-6 col-sm-6 col-xs-6">
					<?=
						$this
							->Form
							->submit(
								__("Login"),
								[
									"class" => "btn btn-success submit"
								]
							);
					?>
				</div>
			</div>
		<?=
			$this
				->Form
				->end();
		?>
	</div>
</div>
<br>
