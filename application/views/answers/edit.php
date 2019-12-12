<?$lang = Session::instance()->get('leng');
 if(!$lang) {
    $lang = 'EN';
 }
// print_r($countrys);
// die;
?>
<style>
.no_valid {
    outline: 1px solid red !important;
}
</style>
<div class="content">    
		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <div class="grid-body no-border email-body col-md-12">
                                    <div class="col-md-6 no-padding">
                                        <br />
                                        <?// print_r($edit_group);?>
                                        <form method="post" enctype="multipart/form-data" class="form_add">
                                            <input type="hidden" name="id" value="<?=$edit['id'];?>" />
                                            <div class="form-group">
                                                <label class="form-label"><? echo __('Image');?></label>
                                                <div class="controls">
                                                    <?if(empty($edit['img'])){?><input name="photo" type="file"  value="Load" class="form-control"  /> <?}?><?if(!empty($edit['img'])){?> <?=$edit['img'];?><span data-toggle="modal" data-target="#info_modal_city" class="btn btn-danger"><?=__('Delete images')?></span><?}?>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Weight")?></label>
                                                <div class="controls">
                                                <input type="text" name="weight" class="form-control" value="<?=$edit['weight'];?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><?=__("CSS Class")?></label>
                                                <div class="controls">
                                                <input type="text" name="css" class="form-control" value="<?=$edit['css'];?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Image Alt")?></label>
                                                <div class="controls">
                                                <input type="text" name="alt" class="form-control" value="<?=$edit['alt'];?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><?=__("City Name fot URL")?></label>
                                                <div class="controls">
                                                <input type="text" name="name" class="form-control" value="<?=$edit['name'];?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Title")?></label>
                                                <div class="controls">
                                                <input type="text" name="title" class="form-control" value="<?=$edit['title'];?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Meta description")?></label>
                                                <div class="controls">
                                                <input type="text" name="meta_description" class="form-control" value="<?=$edit['meta'];?>" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Country")?></label>
                                                <div class="controls">
                                                    <select name="country_id">
                                                        <? foreach($countrys as $c){?>
                                                            <option value="<?=$c['country_id'];?>" <?if($c['country_id'] == $edit['country_id']){?> selected="selected"<?}?>><?=$c['name_i18n'];?></option>
                                                        <?}?>
                                                    </select>
                                                </div>
                                            </div>  
                                            
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Text")?></label>
                                                <div class="controls">
                                                     <textarea id="text-editor" name="text" placeholder="Enter text ..." class="form-control" rows="10"><?=$edit['text'];?></textarea>
                                                </div>
                                            </div> 
                                            <div class="alert alert-block alert-error fade in def_return_discount">
                                                <div class="form-group">
                                                    <label class="form-label"><? echo __('Route citys');?>  <span class="btn sellect_all"><? echo __('Select all');?></span></label>
                                                    <hr />
                                                    <span class="help"></span>
                                                    <div class="controls">
                                                        <?$i=1; foreach($route_citys as $rs){?>
                                                            <div style="float: left; padding: 5px; width: 100px;">
                                                                <div class="row-fluid">
                                                                    <div class="checkbox check-default">
                                                                        <input id="checkbox<?=$rs['route_city_id'];?>" name="route_citys[]" type="checkbox" class="route_citys" value="<?=$rs['route_city_id'];?>" <? foreach($edit_route_citys as $ed){ if($ed['route_city_id'] == $rs['route_city_id']){ echo 'checked="checked"'; } }?>>
                                                                        <label for="checkbox<?=$rs['route_city_id'];?>"><?=$rs['city_i18n']." ".$rs['name_i18n'];?></label>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                            <?if($i == 3 || $i == 6 || $i == 9){ echo '<div class="clearfix"></div>'; }?>
                                                        <? $i++;}?>
                                                    </div>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                            <div class="add_input">
                                                <span class="btn btn-danger" onclick="add_fild(<?=$_GET['id'];?>)"><?=__('add fild')?></span>
                                                <?foreach($filds as $in){?>
                                                    <div class="alert alert-block alert-error fade in ">
                                                        <div class="form-group col-md-3">
                                                            <label><?=__("Icon")?></label>
                                                            <div class="controls">
                                                                <input type="text" name="fild_icon[]" value="<?=$in['icon'];?>"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label><?=__("Title")?></label>
                                                            <div class="controls">
                                                                <input type="text" name="fild_title[]" value="<?=$in['title'];?>"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label><?=__("Link")?></label>
                                                            <div class="controls">
                                                                <input type="text" name="fild_link[]" value="<?=$in['link'];?>"/>
                                                            </div>
                                                        </div>
                                                        <div class="form-group col-md-3">
                                                            <label>&nbsp;</label>
                                                            <div class="controls">
                                                                <span class="btn btn-success" onclick="dell_fild('<?=$in['id'];?>')"><?=__("Delete fild")?></span>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix">&nbsp;</div>
                                                    </div>
                                                <?}?>
                                            </div>                                                                           
                                            <div class="form-group">
                                                <label class="form-label"></label>
                                                <div class="controls">
                                                    <span class="btn btn-primary btn-cons add_button"><?=__("Edit")?></span>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                           </div>	
						</div>
					</div>
				</div>	
		</div>
 <div class="clearfix"></div>
  </div>
                                          
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
                <h3>Are you sure you want to delete a picture?</h3>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default info_close" data-dismiss="modal">No</button><button type="button" class="btn btn-default" onclick="dell_city_img('<?=$_GET['id'];?>')">Confirm</button>
        </div>
      </div>
    </div>
</div>

  
<script type="text/javascript">
$('.add_button').click(function(){ 
    $('.no_valid').each(function(){
        $(this).removeClass('no_valid');
    })
    var cou_chek = 0;
    if($('#text-editor').val().length == 0){
        $('iframe').addClass('no_valid');
        cou_chek++;
    }
    $('input:text,input:file').each(function(){
        if($(this).val().length == 0){
            $(this).addClass('no_valid');
            cou_chek++;
        }
    })
    if(cou_chek == 0){
        $('.form_add').submit();
    }else{
        modal_info_open('<?=__("Validation error")?>');
    }
    //return false;
})



function add_fild(id){
    $.ajax({
        type: "POST",
        url: "/svitgo/ajax_add_filds",
        data: {id:id},
        success: function(data) {
            //alert(data);
            //exit();
            location="/svitgo/edit_my_city?id=<?=$_GET['id'];?>&lang=<?=$_GET['lang'];?>";
            //$('.alert').show();
            
        },
        error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
    });
}
function dell_fild(id){
    $.ajax({
        type: "POST",
        url: "/svitgo/ajax_dell_filds",
        data: {id:id},
        success: function(data) {
            //alert(data);
            //exit();
            location="/svitgo/edit_my_city?id=<?=$_GET['id'];?>&lang=<?=$_GET['lang'];?>";
            //$('.alert').show();
            
        },
        error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
    });
}       
function dell_city_img(id){
    $.ajax({
        type: "POST",
        url: "/svitgo/ajax_dell_city_img",
        data: {id:id},
        success: function(data) {
            //alert(data);
            //exit();
            location="/svitgo/edit_my_city?id=<?=$_GET['id'];?>&lang=<?=$_GET['lang'];?>";
            //$('.alert').show();
            
        },
        error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
    });
}
    
$('.sellect_all').click(function(){
    //alert('ok');
    $(this).parents('.alert-block').find('input').each(function(){
        $(this).attr('checked','checked');
    })
})
</script>