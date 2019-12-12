<div class="content">    
 	
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->                    
                            <h3 class="semi-bold h_ped"><?=__("Add new discount")?></h3>
                            <div class="col-md-6 no-padding" style="min-height: 850px;">
                                <form id="add_material" action="" method="post" >
                                    <div class="u-ost-colum-a ost_ru">
                                        <input type="hidden" name="fer_id" value="<?=$_GET['id'];?>" />
                                        <div class="form-group">
                                            <label><? echo __('Hours');?></label>
                                            <input name="hours" type="text"  value="" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label><? echo __('Percentage');?> (%)</label>
                                            <input name="proc" type="text"  value=""  class="form-control" />
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
</div