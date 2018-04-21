<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Supplier $supplier
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $supplier->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $supplier->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Supplier'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Supplier Items'), ['controller' => 'SupplierItems', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Supplier Item'), ['controller' => 'SupplierItems', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="supplier form large-9 medium-8 columns content">
    <?= $this->Form->create($supplier) ?>
    <fieldset>
        <legend><?= __('Edit Supplier') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('reg_no');
            echo $this->Form->control('card_status');
            echo $this->Form->control('email');
            echo $this->Form->control('website');
            echo $this->Form->control('contact_no_1');
            echo $this->Form->control('contact_no_2');
            echo $this->Form->control('fax');
            echo $this->Form->control('address');
            echo $this->Form->control('postcode');
            echo $this->Form->control('state');
            echo $this->Form->control('city');
            echo $this->Form->control('country');
            echo $this->Form->control('contact_name');
            echo $this->Form->control('contact_address');
            echo $this->Form->control('contact_postcode');
            echo $this->Form->control('contact_state');
            echo $this->Form->control('contact_city');
            echo $this->Form->control('contact_country');
            echo $this->Form->control('contact_phone');
            echo $this->Form->control('contact_email');
            echo $this->Form->control('contact_fax');
            echo $this->Form->control('bank_name');
            echo $this->Form->control('ac_name');
            echo $this->Form->control('ac_no');
            echo $this->Form->control('bank_tel_no');
            echo $this->Form->control('bank_fax_no');
            echo $this->Form->control('payment_term');
            echo $this->Form->control('currency');
            echo $this->Form->control('tax_code');
            echo $this->Form->control('tax_id');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
