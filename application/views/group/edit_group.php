<?$lang = Session::instance()->get('leng');
         if(!$lang) {
            $lang = 'EN';
         }
?>


<div class="container container-fixed-lg">
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("Add new group")?>
                    </div>
                  </div>
                  <div class="panel-body">
            <div class="row">
            <div class="col-md-6 no-padding">
                                        <br />
                                        <?// print_r($edit_group);?>
                                        <form method="post">
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Group name")?></label>
                                                <div class="controls">
                                                <input type="text" name="group_name" class="form-control" value="<?=$edit_group['name'];?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Presale")?></label>
                                                  <span class="help">"<?=__("Indicate the number of days")?>"</span>
                                         
                                                <input type="text" name="count_day_sell" class="form-control" value="<?=$edit_group['count_day_sell'];?>" />
                                             
                                            </div>
                                            
                                            
                                            <div class="alert alert-block fade in val_con">
                                            <div class="form-group">
                                                <label class="form-label"><? echo __('menus');?>  <span class="btn sellect_all"><? echo __('Select All');?></span> </label>
                                                <hr />
                                                <span class="help"></span>
                                                <div class="controls">
                                                    <? for ($b = 1; $b <= 8; $b++) { ?>
                                                        <? foreach($parent_menus as $par_menu){
                                                            if($par_menu == $b){
                                                            ?>
                                                            <div class="row-fluid col-md-3">
                                                                <div class="checkbox check-default">
                                                                    <input id="checkboxmenu<?=$b;?>" name="menus[]" type="checkbox" class="menuss" <? foreach($edit_menus as $ed_men){ if($ed_men == $b){ echo 'checked="checked"'; } }?>  value="<?=$b;?>">
                                                                    <label for="checkboxmenu<?=$b;?>"><? echo 'menu - '.$b;?></label>
                                                                </div>
                                                            </div> 
                                                            <?if($b == 3 || $b == 6 || $b == 9){ echo '<div class="clearfix"></div>'; }?>
                                                        <?}}?>
                                                    <?}?>
                                                </div>
                                            </div>
                                            </div>
                                            
                                            
                                            
                                            
                                            <div class="form-group">
                                            <label><?=__('Access to the passenger data')?></label>
                                 <span class="help">"<?=__("Display page band")?>"</span>
                                          </div>
                                          
                                          
                                          
                                            <div class="row-fluid">
                                                <div class="checkbox check-success">
                                                    <input id="checkbox1" name="see_id" type="checkbox" <?if($edit_group['tik_see_id'] == 1){?> checked="checked" <?}?> value="1">
                                                    <label for="checkbox1"><?=__('Route number')?></label>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="checkbox check-success">
                                                    <input id="checkbox2" name="see_ferryman" type="checkbox" <?if($edit_group['tik_see_ferryman'] == 1){?> checked="checked" <?}?> value="1">
                                                    <label for="checkbox2"><?=__('Carrier')?></label>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="checkbox check-success">
                                                    <input id="checkbox3" name="see_price" type="checkbox" <?if($edit_group['tik_see_price'] == 1){?> checked="checked" <?}?> value="1">
                                                    <label for="checkbox3"><?=__('Price')?></label>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="checkbox check-success">
                                                    <input id="checkbox4" name="see_client" type="checkbox" <?if($edit_group['tik_see_client'] == 1){?> checked="checked" <?}?> value="1">
                                                    <label for="checkbox4"><?=__('Passenger')?></label>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="checkbox check-success">
                                                    <input id="checkbox5" name="see_sysuser" type="checkbox" <?if($edit_group['tik_see_sysuser'] == 1){?> checked="checked" <?}?> value="1">
                                                    <label for="checkbox5"><?=__('Agent')?></label>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="checkbox check-success">
                                                    <input id="checkbox6" name="see_directions" type="checkbox" <?if($edit_group['tik_see_directions'] == 1){?> checked="checked" <?}?> value="1">
                                                    <label for="checkbox6"><?=__('Direction')?></label>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="checkbox check-success">
                                                    <input id="checkbox7" name="see_date" type="checkbox" <?if($edit_group['tik_see_date'] == 1){?> checked="checked" <?}?> value="1">
                                                    <label for="checkbox7"><?=__('Date')?></label>
                                                </div>
                                            </div>
                                            
                                                       <div class="form-group">
                                            <label><?=__('Group opportunities')?></label>
                             
                                          </div>
                                            
                                            
                                            
                                            
                                            <div class="row-fluid">
                                                <div class="checkbox check-success">
                                                    <input id="checkbox8" name="see_clients_phone" type="checkbox" <?if($edit_group['see_clients_phone'] == 1){?> checked="checked" <?}?> value="1">
                                                    <label for="checkbox8"><?=__('Passenger’s telephone number')?></label>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="checkbox check-success">
                                                    <input id="checkbox9" name="show_block_blocket" type="checkbox" <?if($edit_group['show_block_blocket'] == 1){?> checked="checked" <?}?> value="1">
                                                    <label for="checkbox9"><?=__('Block the seats in the bus')?></label>
                                                </div>
                                            </div>
                                            <div class="row-fluid">
                                                <div class="checkbox check-success">
                                                    <input id="checkbox10" name="show_tik_vedomost" type="checkbox" <?if($edit_group['show_tik_vedomost'] == 1){?> checked="checked" <?}?> value="1">
                                                    <label for="checkbox10"><?=__('Add tickets into the check list')?></label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Cancel the booking")?></label>
                                                <span class="help">"<?=__("Автоматическое удаление брони, укажите время в секундах")?>"</span>
                                                <div class="controls">
                                                <input type="text" name="reserv_anule" class="form-control" value="<?=$edit_group['reserv_anule'];?>" />
                                                </div>
                                            </div>
                                                                                       
                                            <div class="form-group">
                                                <label class="form-label"></label>
                                                <div class="controls">
                                                    <button class="btn btn-success btn-cons"><?=__("Save")?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
            </div>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>









  <script type="text/javascript">
  $('.sellect_all').click(function(){
        $('.fer_con').find('.discounts').attr('checked',true);
  })
  
  </script>