<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 23/11/2017
 * Time: 13:01
 */

namespace App\Model\Table;

use Cake\ORM\Table;

class UsuariosLoginTable extends Table
{
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->belongsTo("Usuarios");

		$this->addBehavior(
			"Timestamp",
			[
				"events" => [
					"Model.beforeSave" => [
						"data" => "new"
					]
				]
			]
		);

		$this->setTable("usuarios_login");
	}

	public function registrarNovoLogin($usuarioId)
	{
		$login = $this->newEntity();

		$login = $this->patchEntity(
			$login,
			[
				"usuario_id" => $usuarioId
			]
		);

		$this->save($login);
	}
}
