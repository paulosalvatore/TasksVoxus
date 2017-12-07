<?php
use Migrations\AbstractMigration;

class CriarTabelaUsuarios extends AbstractMigration
{
	public function change()
	{
		$table = $this->table("usuarios");
		$table->addColumn("nome", "string")
			->addColumn("email", "string")
			->addColumn("senha", "string")
			->addColumn("administrador", "boolean")
			->addColumn("ativo", "boolean", ["default" => true])
			->addColumn("criado", "datetime")
			->addColumn("modificado", "datetime")
			->save();

		$table = $this->table("usuarios_login");
		$table->addColumn("usuario_id", "integer")
			->addForeignKey("usuario_id", "usuarios", "id")
			->addColumn("data", "datetime")
			->save();
	}
}
