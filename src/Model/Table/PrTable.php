<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pr Model
 *
 * @property \App\Model\Table\PoTable|\Cake\ORM\Association\HasMany $Po
 * @property \App\Model\Table\PrItemsTable|\Cake\ORM\Association\HasMany $PrItems
 *
 * @method \App\Model\Entity\Pr get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pr newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Pr[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pr|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pr patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pr[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pr findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PrTable extends Table
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

        $this->setTable('pr');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Po', [
            'foreignKey' => 'pr_id'
        ]);
        $this->hasMany('PrItems', [
            'foreignKey' => 'pr_id'
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
            ->scalar('section')
            ->maxLength('section', 30)
            ->requirePresence('section', 'create')
            ->notEmpty('section');

        $validator
            ->scalar('so_no')
            ->maxLength('so_no', 130)
            ->requirePresence('so_no', 'create')
            ->notEmpty('so_no');

        $validator
            ->scalar('purchase_type')
            ->maxLength('purchase_type', 130)
            ->allowEmpty('purchase_type');

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
