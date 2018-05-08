<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Po Entity
 *
 * @property int $id
 * @property string $pr_id
 * @property string $status
 * @property string $created_by
 * @property string $verified_by
 * @property string $approve1_by
 * @property string $approve2_by
 * @property string $approve3_by
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Pr $pr
 */
class Po extends Entity
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
        'pr_id' => true,
        'status' => true,
        'created_by' => true,
        'verified_by' => true,
        'approve1_by' => true,
        'approve2_by' => true,
        'approve3_by' => true,
        'created' => true,
        'modified' => true,
        'pr' => true
    ];
}
