<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Po $po
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $po->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $po->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Po'), ['action' => 'index']) ?></li>
    </ul>
</nav>
<div class="po form large-9 medium-8 columns content">
    <?= $this->Form->create($po) ?>
    <fieldset>
        <legend><?= __('Edit Po') ?></legend>
        <?php
            echo $this->Form->control('pr_id');
            echo $this->Form->control('status');
            echo $this->Form->control('created_by');
            echo $this->Form->control('verified_by');
            echo $this->Form->control('approve1_by');
            echo $this->Form->control('approve2_by');
            echo $this->Form->control('approve3_by');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
