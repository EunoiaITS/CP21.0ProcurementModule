<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Supplier Model
 *
 * @property \App\Model\Table\TaxesTable|\Cake\ORM\Association\BelongsTo $Taxes
 * @property \App\Model\Table\SupplierItemsTable|\Cake\ORM\Association\HasMany $SupplierItems
 *
 * @method \App\Model\Entity\Supplier get($primaryKey, $options = [])
 * @method \App\Model\Entity\Supplier newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Supplier[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Supplier|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Supplier patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Supplier[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Supplier findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SupplierTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('supplier');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('SupplierItems', [
            'foreignKey' => 'supplier_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 130)
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('reg_no')
            ->maxLength('reg_no', 130)
            ->requirePresence('reg_no', 'create')
            ->notEmpty('reg_no');

        $validator
            ->scalar('card_status')
            ->requirePresence('card_status', 'create')
            ->notEmpty('card_status');

        $validator
            ->email('email')
            ->requirePresence('email', 'create')
            ->notEmpty('email');

        $validator
            ->scalar('website')
            ->maxLength('website', 130)
            ->requirePresence('website', 'create')
            ->notEmpty('website');

        $validator
            ->scalar('contact_no_1')
            ->maxLength('contact_no_1', 50)
            ->requirePresence('contact_no_1', 'create')
            ->notEmpty('contact_no_1');

        $validator
            ->scalar('contact_no_2')
            ->maxLength('contact_no_2', 50)
            ->allowEmpty('contact_no_2');

        $validator
            ->scalar('fax')
            ->maxLength('fax', 50)
            ->allowEmpty('fax');

        $validator
            ->scalar('address')
            ->maxLength('address', 250)
            ->requirePresence('address', 'create')
            ->notEmpty('address');

        $validator
            ->scalar('postcode')
            ->maxLength('postcode', 50)
            ->requirePresence('postcode', 'create')
            ->notEmpty('postcode');

        $validator
            ->scalar('state')
            ->maxLength('state', 50)
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        $validator
            ->scalar('city')
            ->maxLength('city', 50)
            ->requirePresence('city', 'create')
            ->notEmpty('city');

        $validator
            ->scalar('country')
            ->maxLength('country', 50)
            ->requirePresence('country', 'create')
            ->notEmpty('country');

        $validator
            ->scalar('contact_name')
            ->maxLength('contact_name', 50)
            ->requirePresence('contact_name', 'create')
            ->notEmpty('contact_name');

        $validator
            ->scalar('contact_address')
            ->maxLength('contact_address', 250)
            ->requirePresence('contact_address', 'create')
            ->notEmpty('contact_address');

        $validator
            ->scalar('contact_postcode')
            ->maxLength('contact_postcode', 50)
            ->requirePresence('contact_postcode', 'create')
            ->notEmpty('contact_postcode');

        $validator
            ->scalar('contact_state')
            ->maxLength('contact_state', 50)
            ->requirePresence('contact_state', 'create')
            ->notEmpty('contact_state');

        $validator
            ->scalar('contact_city')
            ->maxLength('contact_city', 50)
            ->requirePresence('contact_city', 'create')
            ->notEmpty('contact_city');

        $validator
            ->scalar('contact_country')
            ->maxLength('contact_country', 50)
            ->requirePresence('contact_country', 'create')
            ->notEmpty('contact_country');

        $validator
            ->scalar('contact_phone')
            ->maxLength('contact_phone', 50)
            ->requirePresence('contact_phone', 'create')
            ->notEmpty('contact_phone');

        $validator
            ->scalar('contact_email')
            ->maxLength('contact_email', 50)
            ->requirePresence('contact_email', 'create')
            ->notEmpty('contact_email');

        $validator
            ->scalar('contact_fax')
            ->maxLength('contact_fax', 50)
            ->allowEmpty('contact_fax');

        $validator
            ->scalar('bank_name')
            ->maxLength('bank_name', 50)
            ->requirePresence('bank_name', 'create')
            ->notEmpty('bank_name');

        $validator
            ->scalar('ac_name')
            ->maxLength('ac_name', 50)
            ->requirePresence('ac_name', 'create')
            ->notEmpty('ac_name');

        $validator
            ->scalar('ac_no')
            ->maxLength('ac_no', 50)
            ->requirePresence('ac_no', 'create')
            ->notEmpty('ac_no');

        $validator
            ->scalar('bank_tel_no')
            ->maxLength('bank_tel_no', 50)
            ->allowEmpty('bank_tel_no');

        $validator
            ->scalar('bank_fax_no')
            ->maxLength('bank_fax_no', 50)
            ->allowEmpty('bank_fax_no');

        $validator
            ->scalar('payment_term')
            ->maxLength('payment_term', 50)
            ->requirePresence('payment_term', 'create')
            ->notEmpty('payment_term');

        $validator
            ->scalar('currency')
            ->maxLength('currency', 50)
            ->requirePresence('currency', 'create')
            ->notEmpty('currency');

        $validator
            ->scalar('tax_code')
            ->maxLength('tax_code', 50)
            ->requirePresence('tax_code', 'create')
            ->notEmpty('tax_code');

        $validator
            ->scalar('tax_id')
            ->maxLength('tax_code', 50)
            ->requirePresence('tax_id', 'create')
            ->notEmpty('tax_id');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->isUnique(['email']));

        return $rules;
    }
}
