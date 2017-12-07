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
			->addColumn("nome_original", "string")
			->addColumn("usuario_id", "integer")
			->addForeignKey("usuario_id", "usuarios", "id")
			->addColumn("ativo", "boolean", ["default" => true])
			->addColumn("criado", "datetime")
			->addColumn("modificado", "datetime")
			->save();
    }
}
