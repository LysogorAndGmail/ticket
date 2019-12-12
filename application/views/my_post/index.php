
<div class="container container-fixed-lg">
 
 
 
 
 
 
 
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("Posts")?>
                    </div>
                  </div>
                  <div class="panel-body">
            
            
            
            <div class="row">
            
            <div class="section grey">
            <div class="section grey col-md-12 p-t-10 p-b-10">
            
            <div class="btn-group">
            
            <a href="/svitgo/add_my_post" class="btn btn-success"><?=__("Add new")?></a>
            
                    
                       
                        </div>
            
            </div>
            </div>
                
                     <table class="table table-hover" id="emails">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><?=__("Title")?></th>
                            <th><?=__("Language")?></th>
                            
                            <th><?=__("Country")?></th>
                      
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($all as $a){?>
                            <tr class="">
                                <td><?=$a['id'];?></td>
                                <td><?=$a['name'];?></td>
                                <td>
                                
                                                <div class="btn-group sm-m-t-10">
                                                
                            <button class="btn btn-default" type="button" onclick="add_text_lang('<?=$a['id'];?>')"title="<?=__('Add')?>"><i class="fa fa-plus-circle"></i>
</i>
                            </button>
                            <?
                            switch($a['sys_user_id']){
                                case 1:
                                $url = 'https://svitgo.com.ua/';
                                break;
                                case 13:
                                $url = 'https://www.regabus.cz/';
                                break;
                                case 24:
                                $url = 'https://choplines.com.ua/';
                                break;
                            }
                            
                            ?>
                            
                            <a href="<?=$url;?>articles/<?=$a['name'];?>/<?=$a['culture'];?>">
                            <span class="input-group-addon primary">
                                <?=$a['culture'];?>     
                            </span>
                            </a>
                            
                          </div>
                                
                                
                                </td>
                                
                            
                           
                          
                                <td><? $country = DB::select()->from('country_i18n')->where('country_id','=',$a['country_id'])->and_where('culture','=',$lang)->execute()->current(); echo $country['name_i18n'];?></td>
                                
                                <td>
                                
                                <div class="btn-group dropdown-default"> <a href="#" data-toggle="dropdown" class="btn dropdown-toggle" style="width: 141px;"> <?=__("Operation")?><span class="caret"></span> </a>
                          <ul class="dropdown-menu " style="width: 141px;">
                            <li>   <a href="/svitgo/edit_my_post_lang?id=<?=$a['id'];?>&lang=<?=$a['culture'];?>"><?=__("Edit language")?></a>
                            </li>
                            <li> <a class="shure" href="/svitgo/dell_my_post_lang?id=<?=$a['id'];?>&lang=<?=$a['culture'];?>"><?=__("Delete language")?></a>
                            </li>
                            <li><a href="/svitgo/edit_my_post?id=<?=$a['id'];?>&lang=<?=$a['culture'];?>"><?=__("Edit")?></a>
                            </li>
                          </ul>
                        </div>
                                
                                
                                </td>
                            </tr>
                        <?}?>
                    </tbody>
                </table>
            
            </div>
            
            
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
            </div>
  </div>

<span data-toggle="modal" data-target="#info_modal_city" class="btn btn-danger see_modal" style="display: none;"><?=__('Delete images')?></span>
<div class="modal fade" id="info_modal_city" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content tab-content">
        <div class="modal-header">
          <button type="button" class="close info_close" data-dismiss="modal" aria-hidden="true">×</button>
          <br />
        </div>
        <div class="modal-body">
          <div class="row form-row">
            <div class="col-md-12 info_body">
                <input type="text" class="parent_id" />
                <input type="text" class="bloc" />
                <input type="text" class="children_id" />
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default info_close" data-dismiss="modal">No</button><button type="button" class="btn btn-default" onclick="join_my_city()">Confirm</button>
        </div>
      </div>
    </div>
</div>
<span data-toggle="modal" data-target="#info_modal_city_lang" class="btn btn-danger see_modal_lang" style="display: none;"><?=__('Delete images')?></span>
<div class="modal fade" id="info_modal_city_lang" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content tab-content">
        <div class="modal-header">
          <button type="button" class="close info_close" data-dismiss="modal" aria-hidden="true">×</button>
          <br />
        </div>
        <div class="modal-body">
          <div class="row form-row">
            <div class="col-md-12 info_body">
                <input type="text" class="parent_id" />
                <?$contrys = DB::select()->from('language')->execute()->as_array();?>
                <select name="lang" class="lang_city">
                    <?foreach($contrys as $con){?>
                        <option value="<?=$con['culture'];?>"><?=$con['name'];?></option>
                    <?}?>
                </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default info_close" data-dismiss="modal">No</button><button type="button" class="btn btn-default" onclick="my_city_add_lang()">Confirm</button>
        </div>
      </div>
    </div>
</div>










<script type="text/javascript">
function add_text_lang(ID){
    //alert(block);
    
    $('.parent_id').val(ID);
    //$('.bloc').val(block);
    //alert($('.children_id').val());
    $('.see_modal_lang').click();
}
function add_text(block,ID){
    //alert(block);
    
    $('.parent_id').val(ID);
    $('.bloc').val(block);
    //alert($('.children_id').val());
    $('.see_modal').click();
}

function my_city_add_lang(){
    var Parent = $('.parent_id').val();
    var Lang = $('.lang_city').val();
    location="/svitgo/add_my_post_lang?id="+Parent+"&lang="+Lang+"";
}
function join_my_city(){
    var Parent = $('.parent_id').val();
    var Child = $('.children_id').val();
    var Block = $('.bloc').val();
    
    $.ajax({
        type: "POST",
        url: "/svitgo/ajax_join_my_city",
        data: {id:Parent,child:Child,block:Block},
        success: function(data) {
            //alert(data);
            //exit;
            location="/svitgo/my_city";
            //$('.alert').show();
            
        },
        error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
    });
    //alert(Child);
}
function dell_text(id){    
    $.ajax({
        type: "POST",
        url: "/svitgo/ajax_dell_join_my_post",
        data: {id:id},
        success: function(data) {
            //alert(data);
            //exit;
            location="/svitgo/my_city";
            //$('.alert').show();
            
        },
        error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
    });
    //alert(Child);
}
</script>