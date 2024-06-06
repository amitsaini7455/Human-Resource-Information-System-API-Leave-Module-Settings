<div class="row margin-bottom-md"></div>
<div class="row margin-bottom-md ">
<div class="col-md-12">
  <h3 style="color:#2d6f96;line-height:0px;"><?= __('Leave Master') ?></h3>
</div>
</div>
<div class="separator-breadcrumb border-top"></div><br/>
<div class="row">
    <div class="col-md-12 boxs-header"> 
        <div class="col-sm-2" style="float:right;"> 
            <?php echo $this->Html->link(__('+ Add', true), array('action' => 'add'), array('class' => 'pull-right btn btn-raised btn-block btn-primary btn-xs')); ?> 
        </div>
    </div><br><br>
</div>
<div class="well">
   
<div class="padding-md bg-white" style="border-top:3px solid #d2d6de;">
<div class="table-responsive" id="dep_master">
    <table class="table table-bordered table-striped results">
        <thead>
            <tr>
                <th scope="col">Name</th>
                <th scope="col" class="actions"><?= __('Actions') ?></th>
               
               
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $k => $v): ?>
            <tr>
                <td><?= h($v['clientName']) ?></td>
                <td class="actions">
                    <?php echo $this->Html->link(
                        '<i class="fa fa-edit icon-blue"></i>',
                        array(

                            'action' => 'edit',$v['id']
                        ), array('escape' => false)
                    ); ?>
                    <?php                     
                    echo $this->Form->postLink(
                        '<i class="fa fa-trash icon-red"></i>',
                        [
                            'action' => 'delete',
                            $v['id']
                        ],
                        [
                            'block' => false, // disable inline form creation

                            'confirm' => __('Are you sure you want to delete')
                            ,'escape' => false
                        ]
                    );
                    ?>
                     <?php echo $this->Html->link(
                        '<i class="fa fa-eye icon-blue"></i>',
                        array(

                            'action' => 'view',$v['id']
                        ), array('escape' => false)
                    ); ?>
                    
                </td>
               
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>
</div>
<script>
$(document).ready(function() {
    $('tab').DataTable( {
        "processing": true,
        "serverSide": false,
          dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns:  ':visible'
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
                extend: 'csvHtml5',
                exportOptions: {
                    columns: ':visible'
                }
            },
            {
            extend: 'pdfHtml5',
            orientation: 'landscape',
            pageSize:'A4',
            exportOptions: {
            columns: ':visible',

            format: {
            body: function ( data, row, column, node ) {
            
                                                                                data = '<span>'+data+'</span>'
                    if($(data).find('option:selected').text() != ""){

                                return $(data).find('option:selected').text();
                    } else if($(data).is("input")) {
                                return $(data).val();
                    }else if($(data).is("textarea")) {
                                return $(data).val();
                    }else{


                                return data.replace(/(&nbsp;|<([^>]+)>)/ig, "").trim();
                    }
                    
                    }
                    }

                }

            },
            'colvis'
        ]
    } );
} );
</script>

<?php

 

?>
