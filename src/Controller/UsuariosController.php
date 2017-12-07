<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 23/11/2017
 * Time: 13:24
 */

namespace App\Controller;

use Cake\Event\Event;

class UsuariosController extends AppController
{
	public function delete($id = null)
	{
		$this->request->allowMethod(["post", "delete"]);
		$usuario = $this->Usuarios->get($id);
		$usuario->ativo = false;

		if ($this->Usuarios->save($usuario))
		{
			$this->Flash->success(__("User was removed successfully."));
		}
		else
		{
			$this->Flash->error(__("User not removed. Please try again."));
		}

		return $this->redirect(
			[
				"action" => "show"
			]
		);
	}

	public function login()
	{
		if (isset($this->usuario["id"]))
			return $this->redirect(["action" => "index"]);

		if ($this->request->is("post"))
		{
			$usuario = $this->Auth->identify();

			if ($usuario)
			{
				$this->Auth->setUser($usuario);
				$this->Usuarios->UsuariosLogin->registrarNovoLogin($usuario["id"]);

				return $this->redirect(
					isset($this->request->getQuery()["redirect"])
						? $this->request->getQuery()["redirect"]
						: "/"
				);
			}
			else
			{
				$this->Flash->error(__("The user name or password is incorrect"));
			}
		}
	}

	public function logout()
	{
		$this->Flash->success(__("You have logged out."));

		return $this->redirect($this->Auth->logout());
	}

	public function show()
	{
		$usuarios = $this->Usuarios->pegar();

		$this->set("usuarios", $usuarios);
	}

	public function view($id = null, $visualizar = false)
	{
		if ($id)
			$usuario = $this->Usuarios->pegarId($id);
		else
			$usuario = $this->Usuarios->newEntity();

		if ($this->request->is(["post", "patch", "put"]))
		{
			$data = $this->request->getData();

			if (empty($data["senha"]))
			{
				unset($data["senha"]);
				unset($data["confirmar_senha"]);
			}

			$usuario =
				$this
					->Usuarios
					->patchEntity(
						$usuario,
						$data
					);

			if ($this->Usuarios->save($usuario))
			{
				if ($id)
					$this->Flash->success(__("User was edited successfully."));
				else
					$this->Flash->success(__("User was added successfully."));

				if (!$this->usuario)
				{
					$this->Auth->setUser($usuario);
					$this->Usuarios->UsuariosLogin->registrarNovoLogin($usuario["id"]);

					return $this->redirect(
						[
							"controller" => "Tasks",
							"action" => "show"
						]
					);
				}

				return $this->redirect(
					[
						"action" => "show"
					]
				);
			}
			else
			{
				if ($id)
					$this->Flash->error(__("User not edited. Please try again."));
				else
					$this->Flash->error(__("User not added. Please try again."));
			}
		}

		$this->set("visualizar", $visualizar);

		$this->set(compact("usuario"));
		$this->set("_serialize", ["usuario"]);
	}

	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);

		$this->Auth->allow(
			[
				"view",
				"teste"
			]
		);
	}

	public function teste()
	{
	}
}
