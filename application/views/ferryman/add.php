<div class="content">    
 	
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->                    
                            <h3 class="semi-bold h_ped"><?=__("Add Ferryman")?></h3>
                            <div class="col-md-6 no-padding" style="min-height: 850px;">
                                <form id="add_material" action="" method="post" >
                                    <div class="u-ost-colum-a ost_ru">
                                        <div class="form-group">
                                            <label><? echo __('Name');?>:</label>
                                            <input name="name" type="text"  value="" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label><? echo __('Company');?>:</label>
                                            <input name="company" type="text"  value=""  class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label><? echo __('Tel');?></label>
                                            <input name="tel" type="text"  value="" class="form-control"  />
                                        </div>
                                        <div class="form-group">
                                            <label><? echo __('Tel');?> (2)</label>
                                            <input name="tel2" type="text"  value="" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label><? echo __('Fax');?></label>
                                            <input name="fax" type="text"  value="" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label><? echo __('Address');?></label>
                                            <input name="adress" type="text"  value="" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label><? echo __('Address');?> (2)</label>
                                            <input name="adress2" type="text"  value="" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-success btn-cons"><?=__("Add")?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end new layaut -->
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
$('.schema_name').change(function(){
    //alert($(this).val());
    //exit;
    $.ajax({
        type: "POST",
        url: "/buses/ajax_see_schema",
        data: {name:$(this).val()},
        success: function(data) {
            $('.see').html(data);
        },
        error:function(){
            alert('ошибка записи step_3');
        }
   });
})
</script>