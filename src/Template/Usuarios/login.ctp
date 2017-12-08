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
				<div class="col-md-2 col-sm-3 col-xs-3">
				</div>
				<div class="col-md-2 col-sm-6 col-xs-6">
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
				<div class="col-md-2 col-sm-1 col-xs-1">
				</div>
				<div class="col-md-2 col-sm-6 col-xs-6">
					<?=
						$this
							->Html
							->Link(
								__("Register"),
								[
									"controller" => "Usuarios",
									"action" => "view"
								],
								[
									"class" => "btn btn-primary submit"
								]
							);
					?>
				</div>
			</div>

			<br>
			<br>

			<?=
				$this
					->Html
					->link(
						'
							<div class="form-group">
								<div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark" data-width="370" data-height="50" data-longtitle="true" data-lang="pt-BR" data-gapiscan="true" data-onload="true"><div style="height:50px;width:370px;" class="abcRioButton abcRioButtonBlue"><div class="abcRioButtonContentWrapper"><div class="abcRioButtonIcon" style="padding:15px"><div style="width:18px;height:18px;" class="abcRioButtonSvgImageWithFallback abcRioButtonIconImage abcRioButtonIconImage18"><svg version="1.1" xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" viewBox="0 0 48 48" class="abcRioButtonSvg"><g><path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"></path><path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"></path><path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"></path><path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"></path><path fill="none" d="M0 0h48v48H0z"></path></g></svg></div></div><span style="font-size:16px;line-height:48px;" class="abcRioButtonContents"><span id="not_signed_inu5xcwkuarwbk">Sign in with Google</span><span id="connectedu5xcwkuarwbk" style="display:none">Signed in with Google</span></span></div></div></div>
							</div>
						',
						[
							"controller" => "Usuarios",
							"action" => "autenticar"
						],
						[
							"escape" => false
						]
					)
			?>
		<?=
			$this
				->Form
				->end();
		?>
	</div>
</div>
<br>
