<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HrisClient $hrisClient
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('Edit Leaves'), ['action' => 'edit', $hrisClient->id]) ?> </li>
        <li><?= $this->Form->postLink(__('Delete Leaves'), ['action' => 'delete', $hrisClient->id], ['confirm' => __('Are you sure you want to delete # {0}?', $hrisClient->id)]) ?> </li>
        <li><?= $this->Html->link(__('List Leaves'), ['action' => 'index']) ?> </li>
        <li><?= $this->Html->link(__('New Leaves'), ['action' => 'add']) ?> </li>
    </ul>
</nav>
<div class="hrisClient view large-9 medium-8 columns content">
    <h3><?= h($hrisClient->name) ?></h3>
    <table class="vertical-table">
        <tr>
            <th scope="row"><?= __('Name') ?></th>
            <td><?= h($hrisClient->clientName) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Created By') ?></th>
            <td><?= h($hrisClient->created_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Modified By') ?></th>
            <td><?= h($hrisClient->updated_at) ?></td>
        </tr>
        <tr>
            <th scope="row"><?= __('Fields') ?></th>
            <td><?php
            
            $clr = explode(',',$color);
            $clrHtml = array();
            $i=0;
            foreach($leavs as $v){ 
                $clrHtml[] = '<span class="btn " style="background-color:'.$clr[$i].'">'.$v['name'].'</span>';
                $i++;
             }; echo implode(' ', $clrHtml); ?></td>
        </tr>
    </table>
</div>
