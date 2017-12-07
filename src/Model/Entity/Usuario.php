<?php
/**
 * Created by PhpStorm.
 * User: paulo
 * Date: 23/11/2017
 * Time: 13:01
 */

namespace App\Model\Entity;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

class Usuario extends Entity
{
	protected $_accessible = [
		"*" => true,
		"id" => false
	];

	protected $_hidden = [
		"senha"
	];

	protected function _setSenha($senha)
	{
		return (new DefaultPasswordHasher)->hash($senha);
	}
}
