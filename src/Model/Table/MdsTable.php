<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Mds Model
 *
 * @property \App\Model\Table\PrItemsTable|\Cake\ORM\Association\BelongsTo $PrItems
 *
 * @method \App\Model\Entity\Md get($primaryKey, $options = [])
 * @method \App\Model\Entity\Md newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Md[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Md|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Md patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Md[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Md findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MdsTable extends Table
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

        $this->setTable('mds');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('PrItems', [
            'foreignKey' => 'pr_item_id',
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
            ->integer('no_del')
            ->requirePresence('no_del', 'create')
            ->notEmpty('no_del');

        $validator
            ->scalar('del_type')
            ->maxLength('del_type', 130)
            ->requirePresence('del_type', 'create')
            ->notEmpty('del_type');

        $validator
            ->integer('created_by')
            ->allowEmpty('created_by');

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
        $rules->add($rules->existsIn(['pr_item_id'], 'PrItems'));

        return $rules;
    }
}
