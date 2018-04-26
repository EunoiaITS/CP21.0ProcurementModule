<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Pi Model
 *
 * @method \App\Model\Entity\Pi get($primaryKey, $options = [])
 * @method \App\Model\Entity\Pi newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Pi[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Pi|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Pi patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Pi[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Pi findOrCreate($search, callable $callback = null, $options = [])
 */
class PiTable extends Table
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

        $this->setTable('pi');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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

        return $validator;
    }
}
