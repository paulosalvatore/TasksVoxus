<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 30/11/2017
 * Time: 19:17
 */

namespace App\Controller;

class TasksController extends AppController
{
	public function delete($id = null)
	{
		$this->acessoRestrito();

		$this->request->allowMethod(["post", "delete"]);
		$task = $this->Tasks->get($id);
		$task->ativo = false;

		if ($this->Tasks->save($task))
		{
			$this->Flash->success(__("Task was removed successfully."));
		}
		else
		{
			$this->Flash->error(__("Task not removed. Please try again."));
		}

		return $this->redirect(
			[
				"action" => "show"
			]
		);
	}

	public function show()
	{
		$this->acessoRestrito();

		$tasks = $this->Tasks->pegar();

		$this->set("tasks", $tasks);
	}

	public function view($id = null, $visualizar = false)
	{
		$this->acessoRestrito();

		if ($id)
			$task = $this->Tasks->pegarId($id);
		else
			$task = $this->Tasks->newEntity();

		if ($this->request->is(["post", "patch", "put"]))
		{
			$data = $this->request->getData();

			if (!$id)
			{
				$data["usuario_id"] = $this->usuario["id"];
			}

			$task =
				$this
					->Tasks
					->patchEntity(
						$task,
						$data
					);

			if ($this->Tasks->save($task))
			{
				if ($id)
					$this->Flash->success(__("Task was edited successfully."));
				else
					$this->Flash->success(__("Task was added successfully."));

				return $this->redirect(
					[
						"action" => "show"
					]
				);
			}
			else
			{
				if ($id)
					$this->Flash->error(__("Task not edited. Please try again."));
				else
					$this->Flash->error(__("Task not added. Please try again."));
			}
		}

		$this->set("visualizar", $visualizar);

		$this->set(compact("task"));
		$this->set("_serialize", ["task"]);
	}
}
