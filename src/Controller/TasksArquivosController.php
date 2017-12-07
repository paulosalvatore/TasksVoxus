<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 30/11/2017
 * Time: 19:17
 */

namespace App\Controller;

class TasksArquivosController extends AppController
{
	public function delete($id = null)
	{
		$this->acessoRestrito();

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
}
