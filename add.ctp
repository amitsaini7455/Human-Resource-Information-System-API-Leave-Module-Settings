<h3 style="color:#2d6f54;line-height:0px;"><?= __('Add Profile Fields') ?></h3>
<div class="separator-breadcrumb border-top"></div></br>
<div class="well">
    <div class="padding-md bg-white" style="border-top:3px solid #d2djhhe;">
        <div class="table-responsive1" id="add_clients">
        <?=  $this->Form->create($hrisClients) ?>
            <fieldset>
              
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php 
                               
                                echo $this->Form->input('client_ids', array('type'=>'select', 'onclick'=>'get_leaves()', 'options'=> $clients, 'label'=>'Clients', 'empty'=>'--Select--','class'=>'form-control clientID','required'=>'required')); 
                           ?>
                        </div>
                    </div>
                    
                    <div class="col-md-7">
                        <div class="form-group personal_info_div" style="display:none">

                            <div class="input select required">
                                <label for="">Leaves Type</label><br>
                                <select name="leave_ids[]" id="mySelect" class="form-control" required multiple></select>
                            </div>
                            
                        </div>
                    </div>
                  
                </div>

                <div class="row ordering">
                
                    
                    
                  
                </div>
                
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group" style="float:left;">
                            <?php 
                                echo $this->Form->button(__('Save'),['class'=>'btn btn-primary']); 
                            ?>
                        </div>
                    </div>
                </div>
                
            </fieldset>
        <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#mySelects').multiselect();
</script>
<script>

    function get_leave(){

        var client_ids = $('.clientID').val();
        

        var id=$('.sectionID').val();
        var targeturl = '/hris-api-leave/leaveType';

        
        $.ajax({
            type:'post',
            url: targeturl,                  
            data:'client_id='+client_id,
            dataType: 'json',
            success:function(result){
               
                var html = '';
                $("#mySelect").html('');
            
                    $.each(result.fields, function(k, v) {
                       // html += '<option value="'+k+'">'+v+'</option>';
                        $("#mySelect").append('<option value="' + k+ '">' + v + '</option>');
                    });
                
               // html += '</select><div>';
               
               //$("#mySelect").append(html);
                    $("#mySelect").multiselect('rebuild');
                    $("#mySelect").multiselect('refresh');

                
             //  $("#mySelect").multiselect('rebuild');

               // $('.personal_info_div').html(html);
                $('.personal_info_div').show();
            
            
                }
        });	
        
                
               
    }

    $('#mySelect').change(function(){
        var orderHtml='<div class="col-md-12"><div class="form-group"><div class="input select required"><label for="">Ordering</label></div></div></div>';

        $("#mySelect option:selected").each(function () {
            var $this = $(this);
            if ($this.length) {
                
                orderHtml += '<div class="col-md-3"><div class="col-md-12"><div class="form-group"><div class="input select required"><label for>'+$this.text()+'</label><br><input type="number" class="form-control" name="ordering[]" min="1" placeholder="Order for '+$this.text()+'" data-title="'+$this.val()+'" value="1" required></div></div></div><div class="col-md-12"><div class="form-group"><div class="input select required"><label for>'+$this.text()+' Color</label><br><input type="text" class="form-control" name="color[]"  placeholder="Order for '+$this.text()+' Color"  required></div></div></div></div>';
            }
        });
        $('.ordering').html(orderHtml);
    });

   
</script>

