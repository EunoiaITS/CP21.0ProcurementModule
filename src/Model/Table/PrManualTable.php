<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PrManual Model
 *
 * @property \App\Model\Table\PrManualItemsTable|\Cake\ORM\Association\HasMany $PrManualItems
 *
 * @method \App\Model\Entity\PrManual get($primaryKey, $options = [])
 * @method \App\Model\Entity\PrManual newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PrManual[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PrManual|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PrManual patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PrManual[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PrManual findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PrManualTable extends Table
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

        $this->setTable('pr_manual');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('PrManualItems', [
            'foreignKey' => 'pr_manual_id'
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
            ->dateTime('date')
            ->requirePresence('date', 'create')
            ->notEmpty('date');

        $validator
            ->scalar('so_no')
            ->maxLength('so_no', 130)
            ->requirePresence('so_no', 'create')
            ->notEmpty('so_no');

        $validator
            ->scalar('purchase_type')
            ->maxLength('purchase_type', 130)
            ->requirePresence('purchase_type', 'create')
            ->notEmpty('purchase_type');

        $validator
            ->scalar('status')
            ->maxLength('status', 130)
            ->allowEmpty('status');

        $validator
            ->integer('created_by')
            ->allowEmpty('created_by');

        $validator
            ->integer('verified_by')
            ->allowEmpty('verified_by');

        $validator
            ->integer('approved_by')
            ->allowEmpty('approved_by');

        return $validator;
    }
}
