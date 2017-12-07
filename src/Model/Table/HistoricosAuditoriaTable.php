<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 07/07/2017
 * Time: 12:43
 */

namespace App\Model\Table;

use Cake\ORM\Table;

class HistoricosAuditoriaTable extends Table
{
	public function initialize(array $config)
	{
		$this->addBehavior(
			"Timestamp",
			[
				"events" => [
					"Model.beforeSave" => [
						"criado" => "new"
					]
				]
			]
		);

		$this->setTable("historicos_auditoria");
	}

	public function gravar($modificacoes)
	{
		if (count($modificacoes) == 0)
			return;

		$entidades = $this->newEntities($modificacoes);

		foreach ($entidades as $entidade)
			$this->save($entidade);
	}
}
