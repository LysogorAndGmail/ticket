<div class="content">    
    <div class="row">
        <div class="col-md-12">
            <a href="/svitgo/add_answers" class="btn btn-danger"><?=__("Add new")?></a>
            <div class="grid simple no-border">
                <table class="table table-hover" id="emails">
                    <thead>
                        <tr>
                            <th>ID</th>
                           
                            <th><?=__("Weight")?></th>
                            <th><?=__("Language")?></th>
                            <th><?=__("Questions")?></th>
                           
                            <th><?=__("Actions")?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($all as $a){?>
                            <tr class="">
                                <td><?=$a['id'];?></td>
                                
                                <td><?=$a['weight'];?></td>
                                <td><button class="btn btn-success" onclick="add_text_lang('<?=$a['id'];?>')"><?=__('Add')?></button><?=$a['culture'];?></td>
                                <td><?=$a['text'];?></td>
                               
                                <td>
                                    <a href="/svitgo/edit_answers_lang?id=<?=$a['id'];?>&lang=<?=$a['culture'];?>"><?=__("Edit")?></a>&nbsp;&nbsp;<a class="shure" href="/svitgo/dell_answers?id=<?=$a['id'];?>"><?=__("Delete")?></a>
                                </td>
                            </tr>
                        <?}?>
                    </tbody>
                </table>
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
                <input type="hidden" class="parent_id" />
                <? $contrys = DB::select()->from('language')->execute()->as_array();?>
                <select name="lang" class="lang_city">
                    <? foreach($contrys as $con){?>
                        <option value="<?=$con['culture'];?>"><?=$con['name'];?></option>
                    <?}?>
                </select>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default info_close" data-dismiss="modal"><?=__("No")?></button><button type="button" class="btn btn-default" onclick="my_city_add_lang()"><?=__("Confirm")?></button>
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
    location="/svitgo/add_answer_lang?id="+Parent+"&lang="+Lang+"";
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
        url: "/svitgo/ajax_dell_join_my_city",
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