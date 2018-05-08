<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Po $po
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Po'), ['action' => 'edit', $po->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Po'), ['action' => 'delete', $po->id], ['confirm' => __('Are you sure you want to delete # {0}?', $po->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Po'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Po'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="po view large-9 medium-8 columns content">
    <h3><?= h($po->id) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Pr Id') ?></th>
            <td><?= h($po->pr_id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Status') ?></th>
            <td><?= h($po->status) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= h($po->created_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Verified By') ?></th>
            <td><?= h($po->verified_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Approve1 By') ?></th>
            <td><?= h($po->approve1_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Approve2 By') ?></th>
            <td><?= h($po->approve2_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Approve3 By') ?></th>
            <td><?= h($po->approve3_by) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Id') ?></th>
            <td><?= $this->Number->format($po->id) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created') ?></th>
            <td><?= h($po->created) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified') ?></th>
            <td><?= h($po->modified) ?></td>
        </tr>
    </table>
</div>
