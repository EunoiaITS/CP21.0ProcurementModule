<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PrItems Model
 *
 * @property \App\Model\Table\PrsTable|\Cake\ORM\Association\BelongsTo $Prs
 * @property \App\Model\Table\BomPartsTable|\Cake\ORM\Association\BelongsTo $BomParts
 * @property \App\Model\Table\SuppliersTable|\Cake\ORM\Association\BelongsTo $Suppliers
 * @property \App\Model\Table\SupplierItemsTable|\Cake\ORM\Association\BelongsTo $SupplierItems
 *
 * @method \App\Model\Entity\PrItem get($primaryKey, $options = [])
 * @method \App\Model\Entity\PrItem newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\PrItem[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PrItem|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PrItem patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PrItem[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\PrItem findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PrItemsTable extends Table
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

        $this->setTable('pr_items');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Pr', [
            'foreignKey' => 'pr_id',
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
            ->integer('order_qty')
            ->requirePresence('order_qty', 'create')
            ->notEmpty('order_qty');

        $validator
            ->integer('sub_total')
            ->requirePresence('sub_total', 'create')
            ->notEmpty('sub_total');

        $validator
            ->integer('gst')
            ->allowEmpty('gst');

        $validator
            ->integer('total')
            ->requirePresence('total', 'create')
            ->notEmpty('total');

        $validator
            ->scalar('docs')
            ->maxLength('docs', 255)
            ->allowEmpty('docs');

        $validator
            ->scalar('remark')
            ->maxLength('remark', 255)
            ->allowEmpty('remark');

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
        $rules->add($rules->existsIn(['pr_id'], 'Pr'));

        return $rules;
    }
}
