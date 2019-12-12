<? $ses_user = Session::instance()->get('ses_user');
$lang = Session::instance()->get('leng');
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
                    <div class="panel-title"><?=__("List of discounts")?>
                    </div>
                  </div>
                  <div class="panel-body">
                <div class="row">     
                          <div class="section grey col-md-12 p-t-10 p-b-10">
               
                            
                                  <div class="btn-group">
            
           <a href="/discounts/add_new" class="btn btn-success btn-cons"><?=__("Add discount")?></a>
            
                    
                       
                        </div></div>
                        
                        <div class="col-md-12">
                        
                        <table class="table table-striped" id="example2" >
                                                    <thead>
                                                      <tr>
                                                          <th><?=__("Weight")?></th>
                                                        <th>ID</th>
                                                        <th><?=__("System number")?></th>
                                                        <th><?=__("Title of discount")?></th>
                                                        <th><?=__("Carrier")?></th>
                                                        <th><?=__("Web page")?></th>
                                                      
                                                       
                                                        <th>(%)</th>
                                                  
                                                      
                                                        <th><?=__("Options")?></th>
                                                        <th style="display: none;"><?=__("Actions")?></th>
                                                        <th style="display: none;"><?=__("Actions")?></th>
                                                        <th style="display: none;"><?=__("Actions")?></th>
                                                        <th style="display: none;"><?=__("Actions")?></th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <? foreach($discounts as $dis){?>
                                                        <tr class="">
                                                        <td><?=$dis['weight'];?></td>
                                                            <td><?=$dis['ticker_discount_id'];?></td>
                                                            <td><?=$dis['main_id'];?></td>
                                                            
                                                            <td><? $dis_name = Model::factory('DiscountMod')->get_disc_name($dis['main_id'],$lang); echo $dis_name['name_i18n'];?></td>
                                                            <td>
                                                               
                                                                   <?     $fer = Model::factory('FerrymanMod')->get_ferryman($dis['ferryman_id']); echo $fer['name']."<br />";
                                                                
                                                                ?>
                                                                <? /* 
                                                                <button class="btn btn-danger" data-toggle="modal" data-target="#myModal<?=$dis['main_id'];?>"><?=__('Add Ferrymans')?></button>
                                                                
                                                                <div class="modal fade" id="myModal<?=$dis['main_id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                                <h4 id="myModalLabel" class="semi-bold"><?=__('Ferrymans')?></h4>
                                                                            </div>
                                                                            <input type="hidden" name="main_id" class="main_id" value="<?=$dis['main_id'];?>" />
                                                                            <input type="hidden" name="dis_fer_old" class="dis_fer_old" value="<?=$dis['ferryman_id'];?>" />
                                                                            <div class="modal-body">
                                                                                <div class="form-group">
                                                                                    <label class="form-label"><? echo __('Ferryman');?> <span class="btn sellect_all"><? echo __('Select all');?></span></label>
                                                                                    <hr />
                                                                                    <span class="help"></span>
                                                                                    <div class="controls">
                                                                                        <div style="max-height: 500px; overflow: auto;">
                                                                                            <?foreach($ferrymans as $f){?>
                                                                                                <!--<input  type="checkbox"   value="<?=$f['ferryman_id'];?>"  /> <?=$f['name'];?><br />-->
                                                                                                <div class="row-fluid">
                                                                                                    <div class="checkbox">
                                                                                                        <? $gek_ferr = DB::select()->from('tickerdiscount')->where('main_id','=',$dis['main_id'])->and_where('ferryman_id','=',$f['ferryman_id'])->execute()->current();?>
                                                                                                        <input id="checkbox<?=$dis['main_id'];?><?=$f['ferryman_id'];?>" name="ferrymans[]" class="ferryss" type="checkbox" <? if(!empty($gek_ferr)){ echo 'checked="checked"'; }?>  value="<?=$f['ferryman_id'];?>">
                                                                                                        <label for="checkbox<?=$dis['main_id'];?><?=$f['ferryman_id'];?>"><?=$f['name'];?></label>
                                                                                                    </div>
                                                                                                </div> 
                                                                                            <?}?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="modal-footer">
                                                                                <button type="button" class="btn btn-default" data-dismiss="modal"><?=__('Close')?></button>
                                                                                <button type="button" class="btn btn-primary save_ferrss"><?=__('Save')?></button>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div> 
                                                                */?>                                                               
                                                            </td>
                                                            <td><?=$dis['site_only'];?></td>
                                                          
                                                            <td><?=$dis['value'];?></td>
                                                      
                                                            
                                                            <td>
                                                           
                                                                                                                                                 <div class="btn-group">
                          <a href="/discounts/edit?id=<?=$dis['ticker_discount_id'];?>" title="<?=__("Edit")?>" class="btn btn-default" ><i class="fa fa-pencil"></i></a>
                          <a class="shure btn btn-default" href="/discounts/del_discount?id=<?=$dis['ticker_discount_id'];?>" title="<?=__("Delete")?>" class="btn btn-default" ><i class="fa fa-trash-o"></i></a>
                         
                       
                        </div>
                                            
                                                           
                                                           
                                                        
                                                           
                                                           
                                                            </td>
                                                            <td style="display: none;">
                                                                <? $langs = DB::select()->from('tickerdiscount_i18n')
                                                                ->where('ticker_discount_id','=',$dis['main_id'])->where('culture','=','ru')->execute()->current(); if(!empty($langs)){echo 'RU';}?>
                                                            </td>
                                                            <td style="display: none;">
                                                                <? $langs = DB::select()->from('tickerdiscount_i18n')
                                                                ->where('ticker_discount_id','=',$dis['main_id'])->where('culture','=','ua')->execute()->current(); if(!empty($langs)){echo 'UA';}?>
                                                            </td>
                                                            <td style="display: none;">
                                                                <? $langs = DB::select()->from('tickerdiscount_i18n')
                                                                ->where('ticker_discount_id','=',$dis['main_id'])->where('culture','=','en')->execute()->current(); if(!empty($langs)){echo 'EN';}?>
                                                            </td>
                                                            <td style="display: none;">
                                                                <? $langs = DB::select()->from('tickerdiscount_i18n')
                                                                ->where('ticker_discount_id','=',$dis['main_id'])->where('culture','=','cs')->execute()->current(); if(!empty($langs)){echo 'CS';}?>
                                                            </td>
                                                        </tr>
                                                    <?}?>
                                                    </tbody>
                                                  </table>
                        
                        </div>
                        
                        
                </div>
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>







  
<script type="text/javascript">
$('.save_ferrss').click(function(){
    var Ferss = [];
    $(this).parents('.modal').find('.ferryss:checked').each(function(){
        Ferss.push($(this).val());
    })
    $.ajax({
        type: "POST",
        url: "/discounts/ajax_add_fers_discouns",
        data: {id:$(this).parents('.modal').find('.main_id').val(),old_fer_id:$(this).parents('.modal').find('.dis_fer_old').val(),fers:Ferss},
        success: function(data) {
            //alert(data);
            location="/discounts";
        },
        error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
   });
})


/* Formating function for row details */
function fnFormatDetails ( oTable, nTr ){
    var aData = oTable.fnGetData( nTr );
    var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;" class="inner-table">';
    sOut += '<tr><td>Language:</td><td>'+aData[9]+' '+aData[10]+' '+aData[11]+' '+aData[12]+'</td></tr>';
    sOut += '</table>';
     
    return sOut;
}

</script> 

<? include_once('js/mytables_i18n.php');?>
