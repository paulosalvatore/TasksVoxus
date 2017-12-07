<?php
use Migrations\AbstractMigration;

class CriarTabelaTasksArquivos extends AbstractMigration
{
    public function change()
    {
		$table = $this->table("tasks_arquivos");
		$table->addColumn("task_id", "integer")
			->addForeignKey("task_id", "tasks", "id")
			->addColumn("arquivo", "string")
			->addColumn("ativo", "boolean", ["default" => true])
			->addColumn("criado", "datetime")
			->addColumn("modificado", "datetime")
			->save();
    }
}
