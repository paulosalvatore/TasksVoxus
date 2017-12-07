<?php
use Migrations\AbstractMigration;

class CriarTabelaTasks extends AbstractMigration
{
    public function change()
    {
		$table = $this->table("tasks");
		$table->addColumn("titulo", "string")
			->addColumn("descricao", "text")
			->addColumn("prioridade", "integer")
			->addColumn("user_id", "char", ["limit" => 36])
			->addForeignKey("user_id", "users", "id")
			->addColumn("status", "integer")
			->addColumn("user_concluido_id", "char", ["limit" => 36])
			->addForeignKey("user_concluido_id", "users", "id")
			->addColumn("ativo", "boolean", ["default" => true])
			->addColumn("criado", "datetime")
			->addColumn("modificado", "datetime")
			->save();
    }
}
