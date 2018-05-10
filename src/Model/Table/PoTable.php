<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Po Model
 *
 * @property \App\Model\Table\PrsTable|\Cake\ORM\Association\BelongsTo $Prs
 *
 * @method \App\Model\Entity\Po get($primaryKey, $options = [])
 * @method \App\Model\Entity\Po newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Po[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Po|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Po patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Po[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Po findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PoTable extends Table
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

        $this->setTable('po');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
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
            ->scalar('status')
            ->maxLength('status', 255)
            ->allowEmpty('status');

        $validator
            ->scalar('created_by')
            ->maxLength('created_by', 255)
            ->allowEmpty('created_by');

        $validator
            ->scalar('verified_by')
            ->maxLength('verified_by', 255)
            ->allowEmpty('verified_by');

        $validator
            ->scalar('approve1_by')
            ->maxLength('approve1_by', 255)
            ->allowEmpty('approve1_by');

        $validator
            ->scalar('approve2_by')
            ->maxLength('approve2_by', 255)
            ->allowEmpty('approve2_by');

        $validator
            ->scalar('approve3_by')
            ->maxLength('approve3_by', 255)
            ->allowEmpty('approve3_by');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
}
