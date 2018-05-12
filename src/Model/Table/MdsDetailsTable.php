<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MdsDetails Model
 *
 * @property \App\Model\Table\MdsTable|\Cake\ORM\Association\BelongsTo $Mds
 *
 * @method \App\Model\Entity\MdsDetail get($primaryKey, $options = [])
 * @method \App\Model\Entity\MdsDetail newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\MdsDetail[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MdsDetail|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MdsDetail patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MdsDetail[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\MdsDetail findOrCreate($search, callable $callback = null, $options = [])
 */
class MdsDetailsTable extends Table
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

        $this->setTable('mds_details');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Mds', [
            'foreignKey' => 'mds_id',
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
            ->dateTime('del_date')
            ->requirePresence('del_date', 'create')
            ->notEmpty('del_date');

        $validator
            ->integer('del_qty')
            ->allowEmpty('del_qty');

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
        $rules->add($rules->existsIn(['mds_id'], 'Mds'));

        return $rules;
    }
}
