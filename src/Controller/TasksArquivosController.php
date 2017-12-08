<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 30/11/2017
 * Time: 19:17
 */

namespace App\Controller;

use Arquivos;

class TasksArquivosController extends AppController
{
	public function delete($id = null)
	{
		$this->request->allowMethod(["post", "delete"]);
		$taskArquivo = $this->TasksArquivos->get($id);
		$taskArquivo->ativo = false;

		if ($this->TasksArquivos->save($taskArquivo))
		{
			$this->Flash->success(__("Task File was removed successfully."));
		}
		else
		{
			$this->Flash->error(__("Task File not removed. Please try again."));
		}

		return $this->redirect(
			[
				"controller" => "Tasks",
				"action" => "view",
				$taskArquivo->task_id
			]
		);
	}

	public function view($id = null)
	{
		$taskArquivo = $this->TasksArquivos->pegarId($id);

		if (Arquivos::visualizar("Tasks", "tasks_arquivos", $taskArquivo->arquivo))
		{
			return $this->redirect(
				[
					"controller" => "Arquivos",
					"action" => "visualizar",
					"Tasks",
					"tasks_arquivos",
					$taskArquivo->arquivo
				]
			);
		}
		else
		{
			echo "
				<script>
					alert('This file cannot be visualized.');
					window.close();
				</script>
			";
		}

		die();
	}

	public function download($id = null)
	{
		$taskArquivo = $this->TasksArquivos->pegarId($id);

		if (Arquivos::download("Tasks", "tasks_arquivos", $taskArquivo->arquivo))
		{
			return $this->redirect(
				[
					"controller" => "Arquivos",
					"action" => "download",
					"Tasks",
					"tasks_arquivos",
					$taskArquivo->arquivo,
					base64_encode($taskArquivo->nome_original),
					0
				]
			);
		}
		else
		{
			echo "
				<script>
					alert('This file cannot be downloaded.');
					window.close();
				</script>
			";
		}

		die();
	}
}
