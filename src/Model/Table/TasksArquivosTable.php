<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 24/11/2017
 * Time: 21:44
 */

namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

class TasksArquivosTable extends Table
{
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->belongsTo("Tasks");
		$this->belongsTo("Usuarios");

		$this->addBehavior(
			"Timestamp",
			[
				"events" => [
					"Model.beforeSave" => [
						"criado" => "new",
						"modificado" => "always"
					]
				]
			]
		);

		$this->setTable("tasks_arquivos");
	}

	public function validationDefault(Validator $validator)
	{
		$validator
			->requirePresence("arquivo", "create")
			->notEmpty("arquivo");

		$validator
			->requirePresence("usuario_id", "create")
			->notEmpty("usuario_id");

		return $validator;
	}
}
