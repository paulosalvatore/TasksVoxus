<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Task Entity
 *
 * @property int $id
 * @property string $titulo
 * @property string $descricao
 * @property int $prioridade
 * @property string $user_id
 * @property int $status
 * @property string $user_concluido_id
 * @property bool $ativo
 * @property \Cake\I18n\FrozenTime $criado
 * @property \Cake\I18n\FrozenTime $modificado
 *
 * @property \CakeDC\Users\Model\Entity\User $user
 */
class Task extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'titulo' => true,
        'descricao' => true,
        'prioridade' => true,
        'user_id' => true,
        'status' => true,
        'user_concluido_id' => true,
        'ativo' => true,
        'criado' => true,
        'modificado' => true,
        'user' => true
    ];
}
