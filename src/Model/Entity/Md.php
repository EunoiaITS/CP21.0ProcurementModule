<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Md Entity
 *
 * @property int $id
 * @property int $pr_item_id
 * @property int $no_del
 * @property int $created_by
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\PrItem $pr_item
 */
class Md extends Entity
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
        'pr_item_id' => true,
        'no_del' => true,
        'created_by' => true,
        'created' => true,
        'modified' => true,
        'pr_item' => true
    ];
}
