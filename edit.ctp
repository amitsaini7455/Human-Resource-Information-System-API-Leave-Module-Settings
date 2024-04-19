<h3 style="color:#2d6f96;line-height:0px;"><?= __('Edit Profile Fields') ?></h3>
<div class="separator-breadcrumb border-top"></div></br>
<div class="well">

<?php
//print_r($clients);
?>
    <div class="padding-md bg-white" style="border-top:3px solid #d2d6de;">
        <div class="table-responsive1" id="add_client">
        <?=  $this->Form->create($hrisClient) ?>
            <fieldset>
              
                <div class="row">
                    
                    <div class="col-md-6">
                        <div class="form-group">
                            <div class="input select required">
                                <label for="">Section</label>
                                <select name="client_id" class="form-control clientID"  required>
                                    <option >Client</option>
                                    <?php

                                        foreach($clients as  $v){
                                            echo "<option value='".$v['id']."'";
                                            if($v['id'] == $hrisClient->client_id){
                                                echo "selected";
                                            }
                                            echo ">".$v['name']."</option>";
                                        }

                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="form-group personal_info_div" style="display:none">

                            <div class="input select required">
                                <label for="">Leave Type</label><br>
                                <select name="leave_id[]" id="mySelect" class="form-control" required multiple></select>
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
    $('#mySelect').multiselect();
</script>
<script>
    $(document).ready(function(){
        get_leave();
        get_ordering();
    });

    $('.clientID').change(function(){
        get_leave()
    });
    function get_leave(){

        var client_id = $('.clientID').val();
        

      
        var targeturl = '/hris-api-leave/leaveType';
        var selected_fields = '<?=  $hrisClient->leaveID; ?>';
        var selected_fields = selected_fields.split(",");
        
        
        $.ajax({
            type:'post',
            url: targeturl,                  
            data:'client_id='+client_id,
            dataType: 'json',
            success:function(result){
              
                var html = "";
                $("#mySelect").html(html);

                $.each(result.fields, function(k, v) {
                       // html += '<option value="'+k+'">'+v+'</option>';
                         html +='<option value="' + k+ '"';
                        
                        if(jQuery.inArray(k, selected_fields) !== -1){
                            
                            html += ' selected';
                        }

                        
                        html +='>' + v + '</option>';
                });
                    $("#mySelect").append(html);
                    $("#mySelect").multiselect('rebuild');
                    $("#mySelect").multiselect('refresh');
                    get_ordering();

                //$('.personal_info_div').html(html);
                $('.personal_info_div').show();
            
            
                }
        });	
        
                
               
    }

    $('#mySelect').change(function(){

        get_ordering();

    });

    function get_ordering(){
        var orderHtml='<div class="col-md-12"><div class="form-group"><div class="input select required"><label for="">Ordering</label></div></div></div>';
        var ordering = '<?=  $hrisClient->order; ?>';
        var ordering = ordering.split(",");
        var color = '<?=  $hrisClient->color; ?>';
         color = color.split(",");

        var i = 0;

        $("#mySelect option:selected").each(function () {
            var $this = $(this);
            if ($this.length) {
                
                orderHtml += '<div class="col-md-3"><div class="col-md-12"><div class="form-group"><div class="input select required"><label for>'+$this.text()+'</label><br><input type="number" class="form-control" name="ordering[]" min="1" placeholder="Order for '+$this.text()+'" data-title="'+$this.val()+'" value="'+ordering[i]+'" required></div></div></div><div class="col-md-12"><div class="form-group"><div class="input select required"><label for>'+$this.text()+' color</label><br><input type="text" class="form-control" name="color[]"  placeholder="Color for '+$this.text()+'"  value="'+color[i]+'" required></div></div></div></div>';
                i++;
            }
        });
        $('.ordering').html(orderHtml);
    }
</script>
