<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PrManualItem Entity
 *
 * @property int $id
 * @property int $pr_manual_id
 * @property int $bom_part_id
 * @property int $order_qty
 * @property string $supplier
 * @property int $sub_total
 * @property int $gst
 * @property int $total
 * @property string $docs
 * @property string $remark
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\PrManual $pr_manual
 * @property \App\Model\Entity\BomPart $bom_part
 */
class PrManualItem extends Entity
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
        'pr_manual_id' => true,
        'bom_part_id' => true,
        'order_qty' => true,
        'supplier' => true,
        'sub_total' => true,
        'gst' => true,
        'total' => true,
        'docs' => true,
        'remark' => true,
        'created' => true,
        'modified' => true,
        'pr_manual' => true,
        'bom_part' => true
    ];
}
