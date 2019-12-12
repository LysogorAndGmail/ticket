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
                    <div class="panel-title"><?=__("Edit User")?>
                    </div>
                  </div>
                  <div class="panel-body">
            <form id="add_material" action="" method="post" enctype="multipart/form-data" >  
            <div class="col-md-12">
            
          
                            <input type="hidden" name="id" value="<?=$edit_sys['id'];?>" />
                            <div class="form-group">
                                <label class="form-label"><? echo __('Login');?></label>
                               
                                <div class="controls">
                                    <input name="login" type="text"  value="<?=$edit_sys['login'];?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Email');?></label>
                                <div class="controls">
                                    <input name="email" type="text"  value="<?=$edit_sys['email'];?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('First Name');?>:</label>
                            
                                <div class="controls">
                                    <input name="f_name" type="text"  value="<?=$edit_sys['first_name'];?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Last Name');?></label>
                               
                                <div class="controls">
                                    <input name="l_name" type="text"  value="<?=$edit_sys['last_name'];?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Phone');?></label>
                          
                                <div class="controls">
                                    <input name="tel" type="text"  value="<?=$edit_sys['tel'];?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Address');?>:</label>
                                
                                <div class="controls">
                                    <input name="adress" type="text"  value="<?=$edit_sys['adress'];?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Skype');?>:</label>
                                <div class="controls">
                                    <input name="skype" type="text"  value="<?=$edit_sys['skype'];?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Company');?></label>
                                <div class="controls">
                                    <input name="company" type="text"  value="<?=$edit_sys['company'];?>" class="form-control valid" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Identificational the number of company');?></label>
                                <div class="controls">
                                    <input name="id_company" type="text"  value="<?=$edit_sys['id_company'];?>" class="form-control valid" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Number MPE');?></label>
                                <div class="controls">
                                    <input name="vat" type="text"  value="<?=$edit_sys['vat'];?>" class="form-control valid" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Company Address');?></label>
                                <div class="controls">
                                    <input name="company_adress" type="text"  value="<?=$edit_sys['company_adress'];?>" class="form-control valid" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Bank Account Number');?></label>
                                <div class="controls">
                                    <input name="bank" type="text"  value="<?=$edit_sys['bank'];?>" class="form-control valid" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label"><? echo __('Address of the Bank');?></label>
                                <div class="controls">
                                    <input name="adres_bank" type="text"  value="<?=$edit_sys['adres_bank'];?>" class="form-control valid" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label"><? echo __('IBAN');?></label>
                                <div class="controls">
                                    <input name="iban" type="text"  value="<?=$edit_sys['iban'];?>" class="form-control valid" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label"><? echo __('SWIFT');?></label>
                                <div class="controls">
                                    <input name="swift" type="text"  value="<?=$edit_sys['swift'];?>" class="form-control valid" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label"><? echo __('Active');?></label>
                                <div class="radio">
                                    <input name="activ" type="radio"  id="male" value="1" <? if($edit_sys['activ'] == 1){ echo 'checked="checked"'; }?>  />
                                    <label for="male"><? echo __('Yes');?></label>
                                    <input id="female" name="activ" type="radio"  value="0" <? if($edit_sys['activ'] == 0){ echo 'checked="checked"'; }?>  />
                                    <label for="female"><? echo __('No');?></label>
                                </div>
                            </div>
                            
                             <div class="form-group">
                                <label class="form-label"><? echo __('Turn on administration menu for this user');?></label>
                                <div class="radio">
                                    <input name="see_main_menu" type="radio"  id="see_main_menu" value="1" <? if($edit_sys['see_main_menu'] == 1){ echo 'checked="checked"'; }?>  />
                                    <label for="see_main_menu"><? echo __('Yes');?></label>
                                    <input id="see_main_menu2" name="see_main_menu" type="radio"  value="0" <? if($edit_sys['see_main_menu'] == 0){ echo 'checked="checked"'; }?>  />
                                    <label for="see_main_menu2"><? echo __('No');?></label>
                                </div>
                            </div>


                            
                            <div class="form-group">
                                <label class="form-label"><? echo __('Commission');?> (%)</label>
                                <span class="help"></span>
                                <div class="controls">
                                    <input name="procent" type="text"  value="<?=$edit_sys['procent'];?>" class="form-control"  />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label"><? echo __('Country Сode');?></label>
                                <div class="controls">
                                    <input name="phone_kod" type="text"  value="<?=$edit_sys['phone_kod'];?>" class="form-control"  />
                                </div>
                            </div>
                            
                            <div class="alert alert-block alert-error fade in def_val_con">
                            <div class="form-group">
                              <label class="form-label"><? echo __('Language Interface by Default');?></label>
                              <hr />
                         
                                <div class="controls">
                                    
                                      
                                            <div class="radio">
                                                <input name="default_lang" type="radio" id="maleRU" <? if($edit_sys['default_lang'] == 'RU'){ echo 'checked="checked"'; }?> class="def_lang"  value="RU"  />
                                                <label for="maleRU">RU</label>
                                            </div>
                                        
                                   
                                     
                                            <div class="radio">
                                                <input name="default_lang" type="radio" id="maleEN" <? if($edit_sys['default_lang'] == 'EN'){ echo 'checked="checked"'; }?> class="def_lang"  value="EN"  />
                                                <label for="maleEN">EN</label>
                                            </div>
                                       
                                  
                                        
                                            <div class="radio">
                                                <input name="default_lang" type="radio" id="maleCS" <? if($edit_sys['default_lang'] == 'CS'){ echo 'checked="checked"'; }?> class="def_lang"  value="CS"  />
                                                <label for="maleCS">CS</label>
                                            </div>
                                      
                                      
                                  
                                            <div class="radio">
                                                <input name="default_lang" type="radio" id="maleUK" <? if($edit_sys['default_lang'] == 'UK'){ echo 'checked="checked"'; }?> class="def_lang"  value="UK"  />
                                                <label for="maleUK">Uk</label>
                                            </div>
                                       
                                   
                                </div>
                            </div>
                            </div>
                          
                            <br />
                            
                            
                             <div class="alert alert-block fade in val_con">
                            <div class="form-group">
                                <label class="form-label"><? echo __('Additional Languages');?>  <span class="btn sellect_all"><? echo __('Select All');?></span> </label>
                                <hr />
                                <span class="help"></span>
                                <div class="controls">
                                    <?$i=1; foreach($langs as $l){?>
                                     
                                        <div class="row-fluid">
                                            <div class="checkbox check-default">
                                                <input id="checkboxlang<?=$l['culture'];?>" name="langs[]" type="checkbox" class="valut" <? foreach($edit_langs as $ed_lang){ if($ed_lang['lang'] == $l['culture']){ echo 'checked="checked"'; } }?>  value="<?=$l['culture'];?>">
                                                <label for="checkboxlang<?=$l['culture'];?>"><?=$l['name'];?></label>
                                            </div>
                                        </div> 
                                        <?//=$v['valute'];?>
                                   
                                        <?if($i == 3 || $i == 6 || $i == 9){ echo '<div class="clearfix"></div>'; }?>
                                    <? $i++;}?>
                                </div>
                            </div>
                            </div>
                            
                            <div class="alert alert-block alert-error fade in def_val_con">
                            <div class="form-group">
                              <label class="form-label"><? echo __('Currency by Default');?></label>
                              <hr />
                                <span class="help"></span>
                                <div class="controls">
                                    <?$i=1; foreach($valutes as $v){?>
                                    
                                            <div class="radio">
                                                <input name="default_valute" type="radio" id="male<?=$v['valute'];?>" <? if($edit_sys['default_valute'] == $v['valute']){ echo 'checked="checked"'; }?> class="def_valute"  value="<?=$v['valute'];?>"  />
                                                <label for="male<?=$v['valute'];?>"><?=$v['valute'];?></label>
                                            </div>
                                      <?if($i == 3 || $i == 6 || $i == 9){ echo '<div class="clearfix"></div>'; }?>
                                    <? $i++;}?>
                                </div>
                            </div>
                            </div>
                            <div class="clearfix"></div>
                            <br />
                            <div class="alert alert-block alert-info fade in val_con">
                            <div class="form-group">
                                <label class="form-label"><? echo __('Additional Currency');?>  <span class="btn sellect_all"><? echo __('Select All');?></span></label>
                                <hr />
                                <span class="help"></span>
                                <div class="controls">
                                    <?$i=1; foreach($valutes as $v){?>
                                     
                                        <!--<input  type="checkbox"   value="<?=$v['valute'];?>"  />-->
                                        <div class="row-fluid">
                                            <div class="checkbox check-default">
                                                <input id="checkbox<?=$v['valute'];?>" name="valute[]" type="checkbox" class="valut" <? foreach($edit_value as $ed_val){ if($ed_val['valute'] == $v['valute']){ echo 'checked="checked"'; } }?>  value="<?=$v['valute'];?>">
                                                <label for="checkbox<?=$v['valute'];?>"><?=$v['valute'];?></label>
                                            </div>
                                        </div> 
                                        <?//=$v['valute'];?>
                                   
                                        <?if($i == 3 || $i == 6 || $i == 9){ echo '<div class="clearfix"></div>'; }?>
                                    <? $i++;}?>
                                </div>
                            </div>
                            </div>
                            <div class="clearfix"></div>
                    
                            <input name="city" type="hidden" class="city_ajax"  value=""  />
                            
                            <div class="alert alert-block  fade in fer_con">
                            <div class="form-group">
                                <label class="form-label"><? echo __('A list of carriers available to user');?> <span class="btn sellect_all"><? echo __('Select All');?></span></label>
                                <hr />
                           
                         
                                    <div style="">
                                       <?foreach($ferrymans as $f){?>
                                       <!--<input  type="checkbox"   value="<?=$f['ferryman_id'];?>"  /> <?=$f['name'];?><br />-->
                                       <div class="row-fluid">
                                            <div class="checkbox check-default">
                                                <input id="checkbox<?=$f['ferryman_id'];?>" name="ferrymans[]" class="ferry" type="checkbox" <? foreach($edit_fer as $ed_fer){ if($ed_fer['fer_id'] == $f['ferryman_id']){ echo 'checked="checked"'; } }?> value="<?=$f['ferryman_id'];?>">
                                                <label for="checkbox<?=$f['ferryman_id'];?>"><?=$f['name'];?></label>
                                            </div>
                                        </div> 
                                       <?}?>
                                   </div>
                           
                            </div>
                            </div>
                            
                            
                            <div class="alert alert-block  fade in fer_con">
                            <div class="form-group">
                                <label class="form-label"><? echo __('A list of bus schemes available to user');?> <span class="btn sellect_all"><? echo __('Select All');?></span></label>
                                <hr />
                                <span class="help"></span>
                                <div class="controls">
                                  
                                       <?foreach($schemes as $sch=>$sch_full){?>
                                       <div class="row-fluid">
                                            <div class="checkbox check-default">
                                                <input id="checkbox<?=$sch;?>" name="schemes[]" class="schemes" type="checkbox" <? foreach($edit_scheme as $ed_schm){ if($ed_schm['chema'] == $sch){ echo 'checked="checked"'; } }?> value="<?=$sch;?>">
                                                <label for="checkbox<?=$sch;?>"><?=$sch;?></label>
                                            </div>
                                        </div> 
                                       <?}?>
                              
                                </div>
                            </div>
                            </div>
                            
                            <div class="alert alert-block alert-info fade in rou_con">
                            <div class="form-group">
                                <label class="form-label"><? echo __('A list of routes available to user');?> <span class="btn sellect_all"><? echo __('Select All');?></span></label>
                                <hr />
                                <span class="help"></span>
                                <div class="controls">
                                    <div style="max-height: 500px; overflow: auto;">
                                       <?foreach($routes as $r){?>
                                       <!--<input name="routes[]" type="checkbox" class="rou" value="<?=$r['route_name_id'];?>"  /> <?=$r['name_i18n'];?><br />-->
                                       <div class="row-fluid">
                                            <div class="checkbox check-default">
                                                <input id="checkbox<?=$r['route_name_id'];?>" name="routes[]" class="rou" type="checkbox" <? foreach($edit_rou as $ed_rou){ if($ed_rou['route_name_id'] == $r['route_name_id']){ echo 'checked="checked"'; } }?> value="<?=$r['route_name_id'];?>">
                                                <label for="checkbox<?=$r['route_name_id'];?>"><?=$r['route_name_id'].' '.$r['name'].' '.$r['name_i18n'];?></label>
                                            </div>
                                        </div> 
                                       <?}?>
                                   </div>
                                </div>
                            </div>
                            </div>
                            
                            
                            <div class="alert alert-block alert-info fade in rou_con">
                            <div class="form-group">
                                <label class="form-label"><? echo __('Allow the Cash');?> <span class="btn sellect_all"><? echo __('Select All');?></span></label>
                                <hr />
                                <span class="help"></span>
                                <div class="controls">
                                    <div style="max-height: 500px; overflow: auto;">
                                       <?foreach($routes as $r){?>
                                       <!--<input name="routes[]" type="checkbox" class="rou" value="<?=$r['route_name_id'];?>"  /> <?=$r['name_i18n'];?><br />-->
                                       <div class="row-fluid">
                                            <div class="checkbox check-default">
                                                <input id="checkbox_see<?=$r['route_name_id'];?>" name="see_cassa[]" class="see_cassa" type="checkbox" <? foreach($edit_see as $ed_rou){ if($ed_rou['route_name_id'] == $r['route_name_id']){ echo 'checked="checked"'; } }?> value="<?=$r['route_name_id'];?>">
                                                <label for="checkbox_see<?=$r['route_name_id'];?>"><?=$r['route_name_id'].' '.$r['name'].' '.$r['name_i18n'];?></label>
                                            </div>
                                        </div> 
                                       <?}?>
                                   </div>
                                </div>
                            </div>
                            </div>
                            
                            
                             <div class="alert alert-block alert-info fade in rou_con">
                            <div class="form-group">
                                <label class="form-label"><? echo __('Available routes for editing');?> <span class="btn sellect_all"><? echo __('Select All');?></span></label>
                                <hr />
                                <span class="help"></span>
                                <div class="controls">
                                    <div style="max-height: 500px; overflow: auto;">
                                       <?foreach($routes as $r){?>
                                       <!--<input name="routes[]" type="checkbox" class="rou" value="<?=$r['route_name_id'];?>"  /> <?=$r['name_i18n'];?><br />-->
                                       <div class="row-fluid">
                                            <div class="checkbox check-default">
                                                <input id="checkbox_see_edit<?=$r['route_name_id'];?>" name="edit_route[]" class="edit_route" type="checkbox" <? foreach($edit_route as $ed_rou){ if($ed_rou['route_name_id'] == $r['route_name_id']){ echo 'checked="checked"'; } }?> value="<?=$r['route_name_id'];?>">
                                                <label for="checkbox_see_edit<?=$r['route_name_id'];?>"><?=$r['route_name_id'].' '.$r['name'].' '.$r['name_i18n'];?></label>
                                            </div>
                                        </div> 
                                       <?}?>
                                   </div>
                                </div>
                            </div>
                            </div>
                            
                             <div class="alert alert-block alert-info fade in dis_con">
                                <div class="form-group">
                                    <label class="form-label"><? echo __('Available Discounts');?> <span class="btn sellect_all"><? echo __('Select All');?></span></label>
                                    <hr />
                                    <span class="help"></span>
                                    <div class="controls">
                                        <div style="max-height: 500px; overflow: auto;">
                                           <? $i=0; foreach($discounts as $dis){
                                                //print_r($dis['ferryman_id']);
                                                $dis_name = Model::factory('DiscountMod')->get_disc_name($dis['main_id'],$lang);
                                                $fer_name = Model::factory('FerrymanMod')->get_ferryman($dis['ferryman_id']);
                                                ?>
                                           <div class="row-fluid">
                                                <div class="checkbox check-default">
                                                    <input id="checkbox__<?=$i;?>" name="discounts[]" class="discounts" type="checkbox" <? foreach($edit_discounts as $ed_dis){ if($ed_dis['dis_id'] == $dis['ticker_discount_id']){ echo 'checked="checked"'; } }?> value="<?=$dis['ticker_discount_id'];?>">
                                                    <label for="checkbox__<?=$i;?>"><?=$dis['main_id'].' &nbsp;&nbsp; '.$fer_name['name'].' &nbsp;&nbsp; '.$dis_name['name_i18n'].' &nbsp;&nbsp; '.$dis['value'].'%';?></label>
                                                </div>
                                            </div> 
                                           <? $i++;}?>
                                       </div>
                                    </div>
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label class="form-label"><? echo __('Select Group');?></label>
                                <span class="help"></span>
                                <div class="controls">
                                    <select name="group" class="group form-control">
                                        <? foreach($groups as $g){?>
                                        <option  value="<?=$g['id']?>" <? if($edit_sys['group_id'] == $g['id']){ echo 'selected="selected"'; }?>><?=$g['name']?></option>
                                        <?}?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label"><? echo __('Time Zone');?></label>
                                <span class="help"></span>
                                <div class="controls">
                                    <select name="zone" class="form-control">
                                        <?php if (($handle = fopen("zone.csv", "r")) !== FALSE) { // перебор временных зон
                                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                        $num = count($data); ?>
                                        <option <? if($edit_sys['time_zone'] == $data[2]){ echo 'selected="selected"'; }?>  value="<?=$data[2]?>"><?=$data[2]?></option>
                                        <? }
                                        fclose($handle);
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="alert alert-block alert-error fade in def_return_discount">
                            <div class="form-group">
                              <label class="form-label"><? echo __('Enable promo for return journey');?></label>
                              <hr />
                                <div class="row-fluid">
                                    <div class="checkbox check-default">
                                        <input id="checkbox_return_discount" name="return_discount" class="return_discount" type="checkbox" <? if($edit_sys['return_discount'] == 1){ echo 'checked="checked"'; } ?> value="1">
                                        <label for="checkbox_return_discount"><?=__("On")?></label>
                                    </div>
                                </div>
                            </div>
                            </div>
                            <div class="clearfix"></div>
                            <br />
                             
                            <div class="form-actions">  
            					<div class="pull-right">
            					  <button type="submit" class="btn btn-success btn-cons"><i class="icon-ok"></i><?=__("Edit");?></button>
            					  <button type="button" class="btn btn-white btn-cons"><?=__("Close");?></button>
            					</div>
        					</div>
                        
            </div>
            </form>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>










              
                    
                                 
<script type="text/javascript">
$(".city_ajax").keyup(function(){
    $.ajax({
        type: "POST",
        url: "/ost/search_ajax_city",
        data: {ost:$(this).val(),lang:$('#cur_lan').val()},
        success: function(data) {
            $('.ajax_bl').html(data);
        },
        //error:function(code, opt, err){
        //        alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        //}
   });
    
})
$('.ajax_p').click(function(){
    alert($(this).text());
})
$('.sellect_all').click(function(){
    //alert('ok');
    $(this).parents('.alert-block').find('input').each(function(){
        $(this).attr('checked','checked');
    })
})
</script>