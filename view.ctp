<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\HrisClient $hrisClient
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">

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
