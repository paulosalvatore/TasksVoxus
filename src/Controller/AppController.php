<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Network\Exception\MethodNotAllowedException;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
	public $usuario;

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent("Security");`
     *
     * @return void
     */
	public function initialize()
	{
		parent::initialize();

		$this->loadComponent("RequestHandler");
		$this->loadComponent("Flash");
		$this->loadComponent("Cookie");
		$this->loadComponent("Auth",
			[
				"authenticate" => [
					"Form" => [
						"userModel" => "Users",
						"fields" => [
							"username" => "email",
							"password" => "senha"
						]
					]
				],
				"loginAction" => [
					"controller" => "users",
					"action" => "login"
				],
				"authError" => __("Access denied: You are not authorized to access this page.")
			]
		);

		$this->loadModel("Usuarios");
		$this->usuario = $this->atualizarUsuario();
		$this->set("usuario", $this->usuario);

		/*
		 * Enable the following components for recommended CakePHP security settings.
		 * see https://book.cakephp.org/3.0/en/controllers/components/security.html
		 */
		// $this->loadComponent("Security");
		// $this->loadComponent("Csrf");
	}

	protected function writeOnSession($field, $data = "")
	{
		$this->request->session()->write($field, $data);
	}

	protected function readFromSession($field)
	{
		return $this->request->session()->read($field);
	}

	protected function atualizarUsuario()
	{
		$usuarioSession = $this->readFromSession("Auth.User");

		if (is_array($usuarioSession))
		{
			$usuario =
				$this
					->Usuarios
					->pegarId($usuarioSession["id"]);

			$usuario = json_encode($usuario);
			$usuario = json_decode($usuario, true);

			$novaUsuarioSession =
				array_merge(
					$usuarioSession,
					$usuario
				);

			$this->writeOnSession("Auth.User", $novaUsuarioSession);

			return $novaUsuarioSession;
		}

		return false;
	}

	public function formatarRequestData($acao)
	{
		switch ($acao)
		{
			case "inserirCriador":
				$this->request->data["criador_id"] = $this->usuario["id"];
				break;
			case "inserirUsuario":
				$this->request->data["usuario_id"] = $this->usuario["id"];
				break;
		}
	}

	public function acessoRestrito()
	{
		if (!$this->usuario ||
			($this->usuario && !$this->usuario["administrador"]))
			throw new MethodNotAllowedException();
	}

	/**
	 * Before render callback.
	 *
	 * @param \Cake\Event\Event $event The beforeRender event.
	 * @return \Cake\Network\Response|null|void
	 */
	public function beforeRender(Event $event)
	{
		if (!array_key_exists("_serialize", $this->viewVars) &&
			in_array($this->response->type(), ["application/json", "application/xml"])
		)
			$this->set("_serialize", true);
	}
}
