<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 23/11/2017
 * Time: 13:01
 */

namespace App\Model\Table;

use Cake\Core\Exception\Exception;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class UsuariosTable extends Table
{
	public function initialize(array $config)
	{
		parent::initialize($config);

		$this->belongsTo("HistoricosAuditoria");

		$this->hasMany("UsuariosLogin");

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

		$this->setTable("usuarios");
		$this->setDisplayField("nome");
	}

	public function validationDefault(Validator $validator)
	{
		$validator
			->requirePresence("nome", "create")
			->notEmpty("nome");

		$validator
			->email("email")
			->requirePresence("email", "create")
			->notEmpty("email");

		$validator
			->requirePresence("senha", "create")
			->notEmpty("senha")
			->minLength("senha", 8, __("Your password must contains at least 8 characters."));

		$validator
			->add(
				"senha", "confirmar_senha",
				[
					"rule" => function ($value, $context) {
						return
							isset($context["data"]["confirmar_senha"]) &&
							$context["data"]["confirmar_senha"] === $value;
					},
					"message" => __("Please confirm your password correctly.")
				]
			);

		return $validator;
	}

	public function buildRules(RulesChecker $rules)
	{
		$rules
			->add(
				$rules->
				isUnique(
					["email"],
					__("There's already a user with this email. Please try another.")
				)
			);

		return $rules;
	}

	public function pegarLista()
	{
		return
			$this
				->find("list")
				->where(
					[
						"Usuarios.ativo" => true
					]
				)
				->orderAsc("Usuarios.nome")
				->toArray();
	}

	public function pegar()
	{
		return
			$this
				->find()
				->where(
					[
						"Usuarios.ativo" => true
					]
				)
				->orderAsc("Usuarios.nome")
				->toArray();
	}

	public function pegarId($id)
	{
		$query =
			$this
				->find()
				->where(
					[
						"Usuarios.id" => $id,
						"Usuarios.ativo" => true
					]
				)
				->first();

		if (count($query) == 0)
			throw new Exception(__("There's no register recorded with this ID."));

		return $query;
	}
}
