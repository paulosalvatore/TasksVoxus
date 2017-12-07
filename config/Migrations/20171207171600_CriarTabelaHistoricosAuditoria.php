<?php
use Migrations\AbstractMigration;

class CriarTabelaHistoricosAuditoria extends AbstractMigration
{
	public function change()
	{
		$table = $this->table("historicos_auditoria");
		$table->addColumn("model", "string")
			->addColumn("foreign_key", "integer")
			->addColumn("campo", "string")
			->addColumn("anterior", "text", ["null" => true])
			->addColumn("novo", "text", ["null" => true])
			->addColumn("usuario_id", "integer")
			->addForeignKey("usuario_id", "usuarios", "id")
			->addColumn("criado", "datetime")
			->save();
	}
}
