<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * SupplierItem Entity
 *
 * @property int $id
 * @property int $supplier_id
 * @property string $part_no
 * @property string $part_name
 * @property string $uom
 * @property string $unit_price
 * @property string $capability_m
 * @property string $doc_file
 * @property int $ranking
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Supplier $supplier
 */
class SupplierItem extends Entity
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
        'supplier_id' => true,
        'part_no' => true,
        'part_name' => true,
        'uom' => true,
        'unit_price' => true,
        'capability_m' => true,
        'doc_file' => true,
        'ranking' => true,
        'created' => true,
        'modified' => true,
        'supplier' => true
    ];
}
