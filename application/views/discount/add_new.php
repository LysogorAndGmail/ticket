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
                    <div class="panel-title"><?=__("Add discount")?>
                    </div>
                  </div>
            
                  <div class="panel-body">
                  <div class="row">
                  <div class="col-md-12">
            <form method="POST" id="my_validation_discount">
                         <?php /*?>           <div class="form-group">
                                        <label><?=__("ID")?></label>
                                        <select name="main_id" class="form-control main_id">
                                            <option value="new"><?=__("New")?></option>
                                            <? foreach($discounts as $dis){
                                                $dis_name = Model::factory('DiscountMod')->get_disc_name($dis,$lang);
                                                ?>
                                            <option value="<?=$dis;?>"><?=$dis.' '.$dis_name['name_i18n'];?></option>
                                            <?}?>
                                        </select>
                                    </div><?php */?>
                                 <?php /*?>   <div class="form-group">
                                        <label><?=__("Carrier")?></label>
                                        <select name="fer_id" class="form-control">
                                            <? foreach($all_fers as $fer){?>
                                            <option value="<?=$fer['ferryman_id'];?>"><?=$fer['name'];?></option>
                                            <?}?>
                                        </select>
                                    </div><?php */?>
                                   
                                   
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
                                                        <input name="name_i18n" type="text" class="form-control"  />
                                                    </div>
                                               </div>
                                               
                                                     <div class="form-group">
                                                    <label><?=__("Brief description of discount")?></label>
                                                    <div class="input-with-icon  right">
                                                        <input name="name_simple_i18n" type="text" class="form-control"  />
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
                                                        <input name="name_i18n" type="text" class="form-control"  />
                                                    </div>
                                               </div>
                                               
                                                     <div class="form-group">
                                                    <label><?=__("Brief description of discount")?></label>
                                                    <div class="input-with-icon  right">
                                                        <input name="name_simple_i18n" type="text" class="form-control"  />
                                                    </div>
                                               </div>
                        </div>
                      </div>
                    </div>
     
                  </div>
                </div>
              </div>
                                   
                                 <?php /*?>  <div class="row">
                                   
                                   <div class="col-md-6">
                                   
                                    
                                    <div class="form-group">
                                        <label>%</label>
                                        <div class="input-with-icon  right">
                                            <input type="text" name="value" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><?=__("Age of passanger")?></label>
                                        <div class="input-with-icon  right">
                                            <input type="text" name="age" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><?=__("The order of arrangement of the discounts in the list")?></label>
                                        <div class="input-with-icon  right">
                                            <input type="text" name="weight" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label"><? echo __('Display on the web page');?></label>
                                        <div class="radio radio-success">
                                            <input name="site_only" type="radio" id="male" value="1" checked="checked"  />
                                            <label for="male"><? echo __('Yes');?></label>
                                            <input id="female" name="site_only" type="radio"  value="0"  />
                                            <label for="female"><? echo __('No');?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label"><? echo __('Display of dispatcher system');?></label>
                                        <div class="radio radio-success">
                                            <input name="see_sell" type="radio" id="male2" value="1" checked="checked"  />
                                            <label for="male2"><? echo __('Yes');?></label>
                                            <input id="female2" name="see_sell" type="radio"  value="0"  />
                                            <label for="female2"><? echo __('No');?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label"><? echo __('Automatic discount');?></label>
                                        <div class="radio radio-success">
                                            <input name="hidden" type="radio" id="male222" value="1" checked="checked"  />
                                            <label for="male222"><? echo __('Yes');?></label>
                                            <input id="female222" name="hidden" type="radio"  value="0"  />
                                            <label for="female222"><? echo __('No');?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label"><? echo __('Fifth ticket');?></label>
                                        <div class="radio radio-success">
                                            <input name="5_tik" type="radio" id="male2223" value="1"  />
                                            <label for="male2223"><? echo __('Yes');?></label>
                                            <input id="female2223" name="5_tik" type="radio"  value="0" />
                                            <label for="female2223"><? echo __('No');?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label"><? echo __('Tenth ticket');?></label>
                                        <div class="radio radio-success">
                                            <input name="10_tik" type="radio" id="male22233" value="1"  />
                                            <label for="male22233"><? echo __('Yes');?></label>
                                            <input id="female22233" name="10_tik" type="radio"  value="0" />
                                            <label for="female22233"><? echo __('No');?></label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label"><? echo __('Discount for ticket with open date');?></label>
                                        <div class="radio radio-success">
                                            <input name="open" type="radio" id="open1" value="1"/>
                                            <label for="open1"><? echo __('Yes');?></label>
                                            <input id="open0" name="open" type="radio"  value="0" />
                                            <label for="open0"><? echo __('No');?></label>
                                        </div>
                                    </div>
                                    
                                    </div>
                                    
                                    
                                    <div class="col-md-12">
                                    
                                    <div class="form-group">
                                        <button class="btn btn-complete btn-cons"><?=__("Add")?></button>
                                    </div>
                                    </div>
                               
                               </div><?php */?>
                               
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
$('.main_id').change(function(){
    var vall = $(this).val();
    if(vall != 'new'){
        $('.hide_div').hide();
    }else{
        $('.hide_div').show();
    }
})
</script>

