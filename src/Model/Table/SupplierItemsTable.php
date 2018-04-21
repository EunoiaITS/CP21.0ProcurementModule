<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SupplierItems Model
 *
 * @property \App\Model\Table\SuppliersTable|\Cake\ORM\Association\BelongsTo $Suppliers
 *
 * @method \App\Model\Entity\SupplierItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\SupplierItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\SupplierItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SupplierItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SupplierItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SupplierItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\SupplierItem findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SupplierItemsTable extends Table
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

        $this->setTable('supplier_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Supplier', [
            'foreignKey' => 'supplier_id',
            'joinType' => 'INNER'
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
            ->scalar('part_no')
            ->maxLength('part_no', 130)
            ->requirePresence('part_no', 'create')
            ->notEmpty('part_no');

        $validator
            ->scalar('part_name')
            ->maxLength('part_name', 130)
            ->requirePresence('part_name', 'create')
            ->notEmpty('part_name');

        $validator
            ->scalar('uom')
            ->maxLength('uom', 130)
            ->requirePresence('uom', 'create')
            ->notEmpty('uom');

        $validator
            ->scalar('unit_price')
            ->maxLength('unit_price', 110)
            ->requirePresence('unit_price', 'create')
            ->notEmpty('unit_price');

        $validator
            ->scalar('capability_m')
            ->maxLength('capability_m', 110)
            ->requirePresence('capability_m', 'create')
            ->notEmpty('capability_m');

        $validator
            ->scalar('doc_file')
            ->maxLength('doc_file', 255)
            ->allowEmpty('doc_file');

        $validator
            ->integer('ranking')
            ->allowEmpty('ranking');

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
        $rules->add($rules->existsIn(['supplier_id'], 'Supplier'));

        return $rules;
    }
}
