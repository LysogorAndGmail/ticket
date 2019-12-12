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
                    <div class="panel-title"><?=__("Edit discount")?>
                    </div>
                  </div>
                  <div class="panel-body">
            
            <div class="row">
              <form method="POST">
                                      <div class="col-md-12">
                <div class="alert alert-info visible-xs m-r-5 m-l-5" role="alert">
                  <button class="close" data-dismiss="alert"></button>
                 
                </div>
                <div class="panel">
                  <ul class="nav nav-tabs nav-tabs-simple" role="tablist" data-init-reponsive-tabs="collapse">
                    <li class="active"><a href="#tab2hellowWorld" data-toggle="tab" role="tab">RU</a>
                    </li>
                    <li><a href="#tab2FollowUs" data-toggle="tab" role="tab">UK</a>
                    </li>
            
                  </ul>
                  <div class="tab-content">
                    <div class="tab-pane active" id="tab2hellowWorld">
                      <div class="row column-seperation">
                        <div class="col-md-12">
                                  <div class="form-group">
                                                    <label><?=__("Full description of discount")?></label>
                                                    <div class="input-with-icon  right">
                                                   <input name="name_i18n" type="text" class="form-control" value="<?=$edit_ru['name_i18n'];?>"  />
                                                    </div>
                                               </div>
                                               
                                                     <div class="form-group">
                                                    <label><?=__("Brief description of discount")?></label>
                                                    <div class="input-with-icon  right">
                                                          <input name="name_simple_i18n" type="text" class="form-control" value="<?=$edit_ru['name_simple_i18n'];?>"  />
                                                    </div>
                                               </div>
                        </div>
                 
                      </div>
                    </div>
                    <div class="tab-pane " id="tab2FollowUs">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                                                    <label><?=__("Full description of discount")?></label>
                                                    <div class="input-with-icon  right">
                                           <input name="name_i18n_ua" type="text" class="form-control" value="<?=$edit_ua['name_i18n'];?>"  />
                                                    </div>
                                               </div>
                                               
                                                     <div class="form-group">
                                                    <label><?=__("Brief description of discount")?></label>
                                                    <div class="input-with-icon  right">
                                                   <input name="name_simple_i18n_ua" type="text" class="form-control" value="<?=$edit_ua['name_simple_i18n'];?>" />
                                                    </div>
                                               </div>
                        </div>
                      </div>
                    </div>
     
                  </div>
                </div>
              </div>
            
            
            
            <div class="col-md-12">
            
            <div class="panel panel-transparent">
                      <!-- Nav tabs -->
                      <ul data-init-reponsive-tabs="dropdownfx" class="nav nav-tabs nav-tabs-linetriangle hidden-sm hidden-xs">
                        <li class="active">
                          <a href="#home" data-toggle="tab" aria-expanded="true"><span><?=__("Settings")?></span></a>
                        </li>
                        <li class="">
                          <a href="#profile" data-toggle="tab" aria-expanded="false"><span><?=__("Activate the discount for the route")?></span></a>
                        </li>
                        
                                  <li class="">
                          <a href="#other" data-toggle="tab" aria-expanded="false"><span><?=__("Other settings")?></span></a>
                        </li>
                        
                        <li>
                          <a href="#messages" data-toggle="tab"><span><?=__("Fixed discounts")?></span></a>
                        </li>
                      </ul><div class="nav-tab-dropdown cs-wrapper full-width p-t-10 visible-xs visible-sm"><div class="cs-select cs-skin-slide full-width" tabindex="0"><span class="cs-placeholder">Hello World</span><div class="cs-options"><ul><li data-value="#home" data-option=""><span>Hello World</span></li><li data-value="#profile" data-option=""><span>Hello Two</span></li><li data-value="#messages" data-option=""><span>Hello Three</span></li></ul></div><select data-init-plugin="cs-select" class="cs-select cs-skin-slide full-width"><option selected="" value="#home">Hello World</option><option value="#profile">Hello Two</option><option value="#messages">Hello Three</option></select><div class="cs-backdrop"></div></div></div>
                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div id="home" class="tab-pane active">
                          <div class="row column-seperation">
                    <div class="col-md-6">
                                      <div class="form-group">
                                        <label><?=__("System number")?></label>
                                        <select name="main_id" class="form-control">
                                            <? foreach($discounts as $dis){
                                                $dis_name = Model::factory('DiscountMod')->get_disc_name($dis,$lang);
                                                ?>
                                            <option value="<?=$dis;?>" <? if($edit['main_id'] == $dis){ echo 'selected="selected"'; }?> ><?=$dis.' '.$dis_name['name_i18n'];?></option>
                                            <?}?>
                                        </select>
                                    </div>
                    
                    
                    
                                <div class="form-group">
                                        <label><?=__("Carrier")?></label>
                                        <select name="fer_id" class="form-control">
                                            <? foreach($all_fers as $fer){?>
                                            <option value="<?=$fer['ferryman_id'];?>" <? if($edit['ferryman_id'] == $fer['ferryman_id']){ echo 'selected="selected"'; }?>><?=$fer['name'];?></option>
                                            <?}?>
                                        </select>
                                    </div>
                    
                                  <div class="form-group">
                                        <label><?=__("Group")?></label>
                                        <select name="group_id" class="form-control">
                                            <option value=""></option>
                                            <? foreach($all_groups as $gr){?>
                                            <option value="<?=$gr['id'];?>" <? if($edit['group_id'] == $gr['id']){ echo 'selected="selected"'; }?>><?=$gr['name'];?></option>
                                            <?}?>
                                        </select>
                                    </div>
                    
                    </div>
                    
                    
                    <div class="col-md-6">
                    
                          <div class="form-group">
                                        <label>%</label>
                                        <input type="text" name="value" class="form-control" value="<?=$edit['value'];?>" />
                                    </div>
                                    
                                    
                                         <div class="form-group">
                                        <label><?=__("Age of passanger")?></label>
                                        <input type="text" name="age" class="form-control" value="<?=$edit['age'];?>" />
                                    </div>
                                    
                                    
                                            <div class="form-group">
                                        <label><?=__("Порядок размещения скидок в списке")?></label>
                                        <input type="text" name="weight" class="form-control" value="<?=$edit['weight'];?>" />
                                    </div>
                    
                    </div>
                    
                    
                    
                    <div class="col-md-6">
                    
                                    <div class="form-group">
                                        <label class="form-label"><? echo __('Display on the web page');?></label>
                                        <div class="radio radio-success">
                                            <input name="site_only" type="radio" id="male" value="1"  <? if($edit['site_only'] == 1){ echo 'checked="checked"'; }?>  />
                                            <label for="male"><? echo __('Yes');?></label>
                                            <input id="female" name="site_only" type="radio"  value="0" <? if($edit['site_only'] == 0){ echo 'checked="checked"'; }?> />
                                            <label for="female"><? echo __('No');?></label>
                                        </div>
                                    </div>
                    
                                <div class="form-group">
                                        <label class="form-label"><? echo __('Display of dispatcher system');?></label>
                                      <div class="radio radio-success">
                                            <input name="see_sell" type="radio" id="male2" value="1" <? if($edit['see_sell'] == 1){ echo 'checked="checked"'; }?>  />
                                            <label for="male2"><? echo __('Yes');?></label>
                                            <input id="female2" name="see_sell" type="radio"  value="0" <? if($edit['see_sell'] == 0){ echo 'checked="checked"'; }?> />
                                            <label for="female2"><? echo __('No');?></label>
                                        </div>
                                    </div>
                                    </div>
                                     <div class="col-md-6">
                                    
                                                 <div class="form-group">
                                        <label class="form-label"><? echo __('Automatic discount');?></label>
                                             <div class="radio radio-success">
                                            <input name="hidden" type="radio" id="male222" value="1" <? if($edit['hidden'] == 1){ echo 'checked="checked"'; }?>  />
                                            <label for="male222"><? echo __('Yes');?></label>
                                            <input id="female222" name="hidden" type="radio"  value="0" <? if($edit['hidden'] == 0){ echo 'checked="checked"'; }?> />
                                            <label for="female222"><? echo __('No');?></label>
                                        </div>
                                    </div>
                                    
                                    
                                    
                                    <div class="form-group">
                                        <label class="form-label"><? echo __('Discount for ticket with open date');?></label>
                                        <div class="radio radio-success">
                                            <input name="open" type="radio" id="open1" value="1"  <? if($edit['open'] == 1){ echo 'checked="checked"'; }?>  />
                                            <label for="open1"><? echo __('Yes');?></label>
                                            <input id="open0" name="open" type="radio"  value="0" <? if($edit['open'] == 0){ echo 'checked="checked"'; }?> />
                                            <label for="open0"><? echo __('No');?></label>
                                        </div>
                                    </div>
                                    
                                    
                    
                    
                    </div>
                    
                    
                          </div>
                        </div>
                   
                    <div id="other" class="tab-pane">
                          <div class="row column-seperation">
                    
                    
                    
                    
                    
                    
                    
                    <div class="col-md-6">
                    
                   
                    
 
                                                <div class="form-group">
                                        <label class="form-label"><? echo __('Fifth ticket');?></label>
                                        <div class="radio radio-success">
                                            <input name="5_tik" type="radio" id="male2223" value="1" <? if($edit['5_tik'] == 1){ echo 'checked="checked"'; }?>  />
                                            <label for="male2223"><? echo __('Yes');?></label>
                                            <input id="female2223" name="5_tik" type="radio"  value="0" <? if($edit['5_tik'] == 0){ echo 'checked="checked"'; }?> />
                                            <label for="female2223"><? echo __('No');?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label"><? echo __('Tenth ticket');?></label>
                                        <div class="radio radio-success">
                                            <input name="10_tik" type="radio" id="male22233" value="1" <? if($edit['10_tik'] == 1){ echo 'checked="checked"'; }?>  />
                                            <label for="male22233"><? echo __('Yes');?></label>
                                            <input id="female22233" name="10_tik" type="radio"  value="0" <? if($edit['10_tik'] == 0){ echo 'checked="checked"'; }?> />
                                            <label for="female22233"><? echo __('No');?></label>
                                        </div>
                                    </div>               
                                    
                                    
                     
                                    
                                    
                                    
                                    
                                    
                    
                    
                    </div>
                    
                    
                          </div>
                        </div>
                   
                   
                   
                   
                   
                   
                   
                   
                        <div id="profile" class="tab-pane">
                          <div class="row">
                        <div class="col-md-12">
                                   <div class="form-group">
                                        <label> <span class="btn btn-default btn-cons sellect_all m-l-10"><? echo __('Select All');?></span></label>
                                        <div class="checkbox check-success  ">
                                            <? foreach($all_routes as $rou_fix){ 
                                                $routt = DB::select()->from('routename')->where('route_name_id','=',$rou_fix['route_name_id'])->execute()->current();
                                                $chek_fixet = explode(',',$edit['routes']);
                                                ?>
                                                <br> 
                                                <input name="fix_route[]" type="checkbox" id="fix_<?=$rou_fix['route_name_id']?>" value="<?=$rou_fix['route_name_id']?>" <? foreach($chek_fixet as $f_chek){ if($rou_fix['route_name_id'] == $f_chek){ echo 'checked="checked"'; }}?> />
                                               
                                                <label for="fix_<?=$rou_fix['route_name_id']?>"><?=$rou_fix['route_name_id'].' / '.$routt['name'];?></label>
                                               
                                            <? }?>
                                        </div>
                                    </div>
                            </div>
                          </div>
                        </div>
                        <div id="messages" class="tab-pane">
                          <div class="row">
                            <div class="col-md-2">
                                        
                                        <h3><? echo __('Price');?></h3>
                                        
                                                  
                                        
                                        
                                            
                                            
                                            <? foreach($all_valutes as $val){ 
                                                $chek_fixet = DB::select()->from('discount_fixet_price')->where('discount_id','=',$_GET['id'])->and_where('valute','=',$val['valute'])->execute()->current();
                                                ?>
                                      
                                      
                                      <div class="form-group">
                        <label><?=$val['valute'];?></label>
                       <!-- <span class="help">e.g. "Mona Lisa Portrait"</span>-->
                     <input type="text" name="<?=$val['valute'];?>" value="<?if(!empty($chek_fixet)){ echo $chek_fixet['value'];}?>" class="form-control"/>
                      </div>
                                      
                                      
                                      
                                      
                                      
                                      
                                      
                                            
                                            <? }?>
                                            
                                     
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
            
            
            
            
            
            
            
            
            
            
            
               
            
            
            
            </div>
            <div class="col-md-12">       <div class="form-group">
                                        <button class="btn btn-success btn-cons"><?=__("Save")?></button>
                                    </div></div>
            
            </form>
            </div>
            
            
            
            
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>





















<script type="text/javascript">
$('.sellect_all').click(function(){
    //alert('ok');
    $(this).parents('.alert-block').find('input').each(function(){
        $(this).attr('checked','checked');
    })
})
</script>