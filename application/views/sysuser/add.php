<style>
.noValid {
    outline: 1px solid red !important;
}
.noValid_empty {
    outline: 1px solid red !important;
}
</style>
<div class="container container-fixed-lg">
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("Add new agent")?>
                    </div>
                  </div>
                  <div class="panel-body">
                   <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                  
                    
                        <form id="my_validation" method="post" enctype="multipart/form-data" >
                        <!--<form  method="post" enctype="multipart/form-data" >-->
                            <div class="form-group">
                                <label ><? echo __('Login');?></label>
                                <div class="input-with-icon  right">
                        
                                    <input name="login" type="text" value="" class="form-control valid" />
                                </div>
                            </div>
                            <div class="form-group" style="position: relative;">
                                <label class="form-label"><? echo __('Password');?></label>
                                <div class="input-with-icon  right">
                                    <input name="pass" type="text"  value="" class="form-control pass_val valid" />
                                </div>
                                <span class="btn btn-warning btn-cons pass_genarator" style="float: right; position: absolute; top:35px; left: 700px; cursor: pointer;"><?=__("generate")?></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Email');?></label>
                                <div class="input-with-icon  right">
                                    <input name="email" type="text"  value="" class="form-control valid" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('First Name');?></label>
                                
                                <div class="input-with-icon  right">
                                    <input name="f_name" type="text"  value="" class="form-control valid" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Last Name');?></label>
                              
                                <div class="input-with-icon  right">
                                    <input name="l_name" type="text"  value="" class="form-control valid" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Phone');?></label>
                               
                                <div class="input-with-icon  right">
                                    <input name="tel" type="text"  value="" class="form-control valid" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Address');?></label>
                            
                                <div class="input-with-icon  right">
                                    <input name="adress" type="text"  value="" class="form-control valid" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Skype');?></label>
                                <div class="input-with-icon  right">
                                    <input name="skype" type="text"  value="" class="form-control valid" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Company');?></label>
                                <div class="input-with-icon  right">
                                    <input name="company" type="text"  value="" class="form-control valid" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Identificational the number of company');?></label>
                                <div class="input-with-icon  right">
                                    <input name="id_company" type="text"  value="" class="form-control valid" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Number MPE');?></label>
                                <div class="input-with-icon  right">
                                    <input name="vat" type="text"  value="" class="form-control valid" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Company Address');?></label>
                                <div class="input-with-icon  right">
                                    <input name="company_adress" type="text"  value="" class="form-control valid" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Bank Account Number');?></label>
                                <div class="input-with-icon  right">
                                    <input name="bank" type="text"  value="" class="form-control valid" />
                                </div>
                            </div>
                            
                            
                            <div class="form-group">
                                <label class="form-label"><? echo __('Address of the Bank');?></label>
                                <div class="controls">
                                    <input name="adres_bank" type="text"  value="" class="form-control valid" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label"><? echo __('IBAN');?></label>
                                <div class="controls">
                                    <input name="iban" type="text"  value="" class="form-control valid" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label"><? echo __('SWIFT');?></label>
                                <div class="controls">
                                    <input name="swift" type="text"  value="" class="form-control valid" />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label"><? echo __('Photo');?></label>
                               
                                <div class="controls">
                                    <input name="photo" type="file"  value="Load" class="form-control"  />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Date Сreate');?></label>
                                
                                <div class="controls">
                                    <input name="date_create" type="text"  value="<?=Date('Y-m-d')?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Active');?></label>
                                <div class="radio">
                                    <input name="activ" type="radio" id="male" value="1" checked="checked"  />
                                    <label for="male"><? echo __('Yes');?></label>
                                    <input id="female" name="activ" type="radio"  value="0"  />
                                    <label for="female"><? echo __('No');?></label>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="form-label"><? echo __('Turn on administration menu for this user');?></label>
                                <div class="radio">
                                    <input name="see_main_menu" type="radio"  id="see_main_menu" value="1" checked="checked"  />
                                    <label for="see_main_menu"><? echo __('Yes');?></label>
                                    <input id="see_main_menu2" name="see_main_menu" type="radio"  value="0"   />
                                    <label for="see_main_menu2"><? echo __('No');?></label>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label"><? echo __('Commission');?> (%)</label>
                                <span class="help"></span>
                                <div class="controls">
                                    <input name="procent" type="text"  value="" class="form-control"  />
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label"><? echo __('Country Сode');?></label>
                                <div class="controls">
                                    <input name="phone_kod" type="text"  value="" class="form-control"  />
                                </div>
                            </div>
                         
                         <div class="alert alert-block alert-error fade in def_val_con">
                            <div class="form-group">
                              <label class="form-label"><? echo __('Language Interface by Default');?></label>
                              <hr />
                         
                             
                                    <?$i=1; foreach($valutes as $v){?>
                                        <div>
                                            <div class="radio">
                                                <input name="default_valute" type="radio" id="male<?=$v['valute'];?>" class="def_valute"  value="<?=$v['valute'];?>"  />
                                                <label for="male<?=$v['valute'];?>"><?=$v['valute'];?></label>
                                            </div>
                                        </div><?if($i == 3 || $i == 6 || $i == 9){ echo ''; }?>
                                    <? $i++;}?>
                       
                            </div>
                            </div>
                         
                         
                         
                         
                         
                         
                         
                         
                         
                         
                         
                         
                         
                         
                 
                            <div class="clearfix"></div>
                      
                            
                            <div class="alert alert-block alert-error fade in def_val_con">
                            <div class="form-group">
                              <label class="form-label"><? echo __('Language Interface by Default');?></label>
                    
                             
                          
                             
                                            <div class="radio">
                                                <input name="default_lang" type="radio" id="maleRU"  class="def_lang"  value="RU"  />
                                                <label for="maleRU">RU</label>
                                            </div>
                                   
                                       
                                    
                                            <div class="radio">
                                                <input name="default_lang" type="radio" id="maleEN"  class="def_lang"  value="EN"  />
                                                <label for="maleEN">EN</label>
                                            </div>
                                  
                                       
                                      
                                            <div class="radio">
                                                <input name="default_lang" type="radio" id="maleCS"  class="def_lang"  value="CS"  />
                                                <label for="maleCS">CS</label>
                                            </div>
                                
                                
                                  
                                            <div class="radio">
                                                <input name="default_lang" type="radio" id="maleUK"  class="def_lang"  value="UK"  />
                                                <label for="maleUK">Uk</label>
                                            </div>
                                   
                                
                    
                            </div></div>
                     
                            
                            <div class="alert  fade in val_con">
                            <div class="form-group">
                                <label class="form-label"><? echo __('Additional Languages');?>   <span class="btn sellect_all"><? echo __('Select All');?></span></label>
                                <hr />
                                <span class="help"></span>
                                <div class="controls">
                                    <?$i=1; foreach($langs as $l){?>
                                    
                                        <div class="row-fluid">
                                            <div class="checkbox check-default">
                                                <input id="checkboxlang<?=$l['culture'];?>" name="langs[]" type="checkbox" class="valut"  value="<?=$l['culture'];?>">
                                                <label for="checkboxlang<?=$l['culture'];?>"><?=$l['name'];?></label>
                                            </div>
                                        </div> 
                                        <?//=$v['valute'];?>
                                   
                                        <?if($i == 3 || $i == 6 || $i == 9){ echo '<div class="clearfix"></div>'; }?>
                                    <? $i++;}?>
                                </div>
                            </div>
                            </div>
                            
                            
                            <div class="alert alert-block  fade in val_con">
                            <div class="form-group">
                                <label class="form-label"><? echo __('Additional Currency');?><span class="btn sellect_all"><? echo __('Select All');?></span></label>
                
                       
                           
                                    <?$i=1; foreach($valutes as $v){?>
                                 
                                        <!--<input  type="checkbox"   value="<?=$v['valute'];?>"  />-->
                                        <div class="row-fluid">
                                            <div class="checkbox check-default">
                                                <input id="checkbox<?=$v['valute'];?>" name="valute[]" type="checkbox" class="valut"  value="<?=$v['valute'];?>">
                                                <label for="checkbox<?=$v['valute'];?>"><?=$v['valute'];?></label>
                                            </div>
                                        </div> 
                                        <?//=$v['valute'];?>
                               
                                        <?if($i == 3 || $i == 6 || $i == 9){ echo '<div class="clearfix"></div>'; }?>
                                    <? $i++;}?>
                            </div>
                            </div>
                            
                             
                      
       
                            <input name="city" type="hidden" class="city_ajax"  value=""  />
                           <div class="alert alert-block  fade in fer_con">
                            <div class="form-group">
                                <label class="form-label"><? echo __('A list of carriers available to user');?><span class="btn sellect_all"><? echo __('Select All');?></span></label>
                                <hr />
                      
                         
                            
                                       <?foreach($ferrymans as $f){?>
                                       <!--<input  type="checkbox"   value="<?=$f['ferryman_id'];?>"  /> <?=$f['name'];?><br />-->
                                       <div class="row-fluid">
                                            <div class="checkbox check-default">
                                                <input id="checkbox<?=$f['ferryman_id'];?>" name="ferrymans[]" class="ferry" type="checkbox" value="<?=$f['ferryman_id'];?>">
                                                <label for="checkbox<?=$f['ferryman_id'];?>"><?=$f['name'];?></label>
                                            </div>
                                        </div> 
                                       <?}?>
                                
                          
                            </div>
                            </div>
                            <div class="alert alert-block  fade in rou_con">
                            <div class="form-group">
                                <label class="form-label"><? echo __('A list of routes available to user');?> <span class="btn sellect_all"><? echo __('Select All');?></span></label>
                                <hr />
                        
                                
                                
                                       <?foreach($routes as $r){?>
                                       <!--<input name="routes[]" type="checkbox" class="rou" value="<?=$r['route_name_id'];?>"  /> <?=$r['name_i18n'];?><br />-->
                                       <div class="row-fluid">
                                            <div class="checkbox check-default">
                                                <input id="checkbox<?=$r['route_name_id'];?>" name="routes[]" class="rou" type="checkbox" value="<?=$r['route_name_id'];?>">
                                                <label for="checkbox<?=$r['route_name_id'];?>"><?=$r['name_i18n'];?></label>
                                            </div>
                                        </div> 
                                       <?}?>
                            
                            </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Select Group');?></label>
                                <hr />
                                <span class="help"></span>
                                <div class="controls">
                                    <select name="group" class="group form-control">
                                        <? foreach($groups as $g){?>
                                        <option value="<?=$g['id']?>"><?=$g['name']?></option>
                                        <?}?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label"><? echo __('Time Zone');?></label>
                                <hr />
                                <span class="help"></span>
                                <div class="controls">
                                    <select name="zone" class="form-control">
                                        <?php if (($handle = fopen("zone.csv", "r")) !== FALSE) { // перебор временных зон
                                        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                                        $num = count($data); ?>
                                        <option  value="<?=$data[2]?>"><?=$data[2]?></option>
                                        <? }
                                        fclose($handle);
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
   
   
                                <span class="chch">
                                <div class="controls">
               
                                        <div class="checkbox check-success" style="margin-top: 9px;">
                                            <input id="checkboxsend" name="send_mail" class="ferry" type="checkbox" value="send_mail">
                                            <label for="checkboxsend"><?=__('Send E-mail');?></label>
                                        </div>
                              
                                </div>
                                </span>
   
   
                            <div class="form-actions">  
   
   
   
            					<div class="pull-right">
            					  <button type="submit" class="btn btn-success btn-cons send_form"><i class="icon-ok"></i><?=__("Save");?></button>
            					  <button type="button" class="btn btn-white btn-cons"><?=__("Close");?></button>
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
$(".pass_genarator").click(function(){
    $.ajax({
        type: "POST",
        url: "/sysuser/ajax_pass_generate",
        data: {ost:$(this).val(),lang:$('#cur_lan').val()},
        success: function(data) {
            //$('.ajax_bl').html(data);
            $('.pass_val').val(data);
        },
        error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
   });
    
})
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

$('#my_validation').submit(function(){    
    $('.def_val_con').removeClass('noValid');
    $('.val_con').removeClass('noValid');
    $('.fer_con').removeClass('noValid');
     $('.rou_con').removeClass('noValid');
     
    if($('.def_valute:checked').val() == undefined){
        $('.def_val_con').addClass('noValid');
        //alert('Select default valute');
        return false;
    }
    if($('.valut:checked').val() == undefined){
        $('.val_con').addClass('noValid');
        return false;
    }
    
    if($('.ferry:checked').val() == undefined){
        $('.fer_con').addClass('noValid');
        return false;
    }
    
    if($('.rou:checked').val() == undefined){
        $('.rou_con').addClass('noValid');
        return false;
    }
    

})
$('.sellect_all').click(function(){
    //alert('ok');
    $(this).parents('.alert-block').find('input').each(function(){
        $(this).attr('checked','checked');
    })
})
</script>