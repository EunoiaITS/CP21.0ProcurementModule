<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * MdsDetail Entity
 *
 * @property int $id
 * @property int $mds_id
 * @property \Cake\I18n\FrozenTime $del_date
 * @property int $del_qty
 *
 * @property \App\Model\Entity\Md $md
 */
class MdsDetail extends Entity
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
        'mds_id' => true,
        'del_date' => true,
        'del_qty' => true,
        'md' => true
    ];
}
