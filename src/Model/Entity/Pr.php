<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Pr Entity
 *
 * @property int $id
 * @property \Cake\I18n\FrozenTime $date
 * @property string $section
 * @property string $so_no
 * @property string $purchase_type
 * @property string $status
 * @property int $created_by
 * @property int $verified_by
 * @property int $approved_by
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Po[] $po
 * @property \App\Model\Entity\PrItem[] $pr_items
 */
class Pr extends Entity
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
        'date' => true,
        'section' => true,
        'so_no' => true,
        'purchase_type' => true,
        'status' => true,
        'created_by' => true,
        'verified_by' => true,
        'approved_by' => true,
        'created' => true,
        'modified' => true,
        'po' => true,
        'pr_items' => true
    ];
}
