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
			->addColumn("usuario_id", "integer")
			->addForeignKey("usuario_id", "usuarios", "id")
			->addColumn("status", "integer")
			->addColumn("usuario_concluido_id", "integer", ["null" => true])
			->addForeignKey("usuario_concluido_id", "usuarios", "id")
			->addColumn("ativo", "boolean", ["default" => true])
			->addColumn("criado", "datetime")
			->addColumn("modificado", "datetime")
			->save();
    }
}
