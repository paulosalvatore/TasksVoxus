<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 24/11/2017
 * Time: 21:44
 */

namespace App\Model\Table;

use Aura\Intl\Exception;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class TasksTable extends Table
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
						"criado" => "new",
						"modificado" => "always"
					]
				]
			]
		);

		$this->setTable("tasks");
		$this->setDisplayField("titulo");
	}

	public function validationDefault(Validator $validator)
	{
		$validator
			->requirePresence("titulo", "create")
			->notEmpty("titulo");

		$validator
			->requirePresence("descricao", "create")
			->notEmpty("descricao");

		return $validator;
	}

	public function pegarLista()
	{
		return
			$this
				->find("list")
				->where(
					[
						"Tasks.ativo" => true
					]
				)
				->orderAsc("Tasks.titulo")
				->toArray();
	}

	public function pegar()
	{
		return
			$this
				->find()
				->where(
					[
						"Tasks.ativo" => true
					]
				)
				->contain(
					[
						"Usuarios"
					]
				)
				->orderAsc("Tasks.titulo")
				->toArray();
	}

	public function pegarId($id)
	{
		$query =
			$this
				->find()
				->where(
					[
						"Tasks.id" => $id,
						"Tasks.ativo" => true
					]
				)
				->contain(
					[
						"Usuarios"
					]
				)
				->first();

		if (count($query) == 0)
			throw new Exception(__("There's no register recorded with this ID."));

		return $query;
	}
}
