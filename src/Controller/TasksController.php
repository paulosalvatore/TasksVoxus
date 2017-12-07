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
		$tasks = $this->Tasks->pegar();

		$this->set("tasks", $tasks);
	}

	public function view($id = null, $visualizar = false)
	{
		if ($id)
			$task = $this->Tasks->pegarId($id);
		else
			$task = $this->Tasks->newEntity();

		if ($this->request->is(["post", "patch", "put"]))
		{
			$data = $this->request->getData();

			// Mantém a prioridade entre 1 e 5
			$data["prioridade"] = max(1, min(5, $data["prioridade"]));

			// Checa se o registro não possui uma ID
			if (!$id)
			{
				// Define o usuário que criou o registro
				$data["usuario_id"] = $this->usuario["id"];
			}

			// Loop para realizar o upload dos arquivos
			foreach ($data["tasks_arquivos"] as $chave => $arquivo)
			{
				if ($arquivo["size"] > 0)
				{
					$data["tasks_arquivos_upload"][$chave] =
						\Arquivos::upload(
							"Tasks",
							"tasks_arquivos",
							$arquivo
						);

					// Checa se o upload deu certo
					if (!$data["tasks_arquivos_upload"][$chave]["erro"])
					{
						$data["tasks_arquivos"][$chave]["nome_original"] = $data["tasks_arquivos_upload"][$chave]["nomeOriginal"];
						$data["tasks_arquivos"][$chave]["arquivo"] = $data["tasks_arquivos_upload"][$chave]["arquivoNome"];
						$data["tasks_arquivos"][$chave]["usuario_id"] = $this->usuario["id"];
					}
				}
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
				foreach ($data["tasks_arquivos_upload"] as $chave => $arquivo)
					\Arquivos::deletar("Tasks", "tasks_arquivos", $arquivo["arquivoNome"]);
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
