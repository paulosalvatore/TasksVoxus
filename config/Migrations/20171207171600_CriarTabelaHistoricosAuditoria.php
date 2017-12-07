<?php
use Migrations\AbstractMigration;

class CriarTabelaHistoricosAuditoria extends AbstractMigration
{
	public function change()
	{
		$table = $this->table("historicos_auditoria");
		$table->addColumn("model", "string")
			->addColumn("foreign_key", "integer", ["null" => true])
			->addColumn("campo", "string")
			->addColumn("anterior", "text", ["null" => true])
			->addColumn("novo", "text", ["null" => true])
			->addColumn("user_id", "char", ["limit" => 36, "null" => true])
			->addForeignKey("user_id", "users", "id")
			->addColumn("criado", "datetime")
			->save();
	}
}
