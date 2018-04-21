<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Supplier Entity
 *
 * @property int $id
 * @property string $name
 * @property string $reg_no
 * @property string $card_status
 * @property string $email
 * @property string $website
 * @property string $contact_no_1
 * @property string $contact_no_2
 * @property string $fax
 * @property string $address
 * @property string $postcode
 * @property string $state
 * @property string $city
 * @property string $country
 * @property string $contact_name
 * @property string $contact_address
 * @property string $contact_postcode
 * @property string $contact_state
 * @property string $contact_city
 * @property string $contact_country
 * @property string $contact_phone
 * @property string $contact_email
 * @property string $contact_fax
 * @property string $bank_name
 * @property string $ac_name
 * @property string $ac_no
 * @property string $bank_tel_no
 * @property string $bank_fax_no
 * @property string $payment_term
 * @property string $currency
 * @property string $tax_code
 * @property string $tax_id
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Tax $tax
 * @property \App\Model\Entity\SupplierItem[] $supplier_items
 */
class Supplier extends Entity
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
        'name' => true,
        'reg_no' => true,
        'card_status' => true,
        'email' => true,
        'website' => true,
        'contact_no_1' => true,
        'contact_no_2' => true,
        'fax' => true,
        'address' => true,
        'postcode' => true,
        'state' => true,
        'city' => true,
        'country' => true,
        'contact_name' => true,
        'contact_address' => true,
        'contact_postcode' => true,
        'contact_state' => true,
        'contact_city' => true,
        'contact_country' => true,
        'contact_phone' => true,
        'contact_email' => true,
        'contact_fax' => true,
        'bank_name' => true,
        'ac_name' => true,
        'ac_no' => true,
        'bank_tel_no' => true,
        'bank_fax_no' => true,
        'payment_term' => true,
        'currency' => true,
        'tax_code' => true,
        'tax_id' => true,
        'created' => true,
        'modified' => true,
        'tax' => true,
        'supplier_items' => true
    ];
}
