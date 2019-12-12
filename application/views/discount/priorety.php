<? $sesuser = Session::instance()->get('ses_user');?>
<div class="content">    
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->                    
                            <h3 class="semi-bold h_ped"><?=__("Discount Priorety")?></h3>
                            <div class="col-md-6 no-padding" style="min-height: 850px;">
                                <form method="POST">
                                    <div class="form-group">
                                        <label><?=__("Choise return discount")?></label>
                                        <div class="checkbox">
                                            <? foreach($all_discounts as $main_id){ 
                                                $name = DB::select()->from('tickerdiscount_i18n')->where('ticker_discount_id','=',$main_id)->and_where('culture','=',$lang)->execute()->current();
                                                $chek  = DB::select()->from('system_users_priorety_discounts')->where('main_id','=',$main_id)->and_where('sysuser_id','=',$sesuser[0]['id'])->execute()->current();
                                                 ?>
                                                
                                                <input name="fix_route[]" type="checkbox" id="fix_<?=$main_id;?>" value="<?=$main_id;?>" <? if($chek['priory'] == 1){ echo 'checked="checked"'; }?> />
                                                <label for="fix_<?=$main_id;?>"><?=$main_id.' / '.$name['name_i18n'];?></label>
                                                <br />
                                            <? }?>
                                            </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-success btn-cons"><?=__("Edit")?></button>
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