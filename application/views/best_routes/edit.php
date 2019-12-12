<div class="content">    
    <div class="page-title">
    <h3><?=__("Edit")?></h3></div>
    <div class="row">
        <div class="col-md-12">
            <div class="grid simple">
                <div class="grid-body no-border"> <br>
                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-xs-8">
                            <form method="post" enctype="multipart/form-data" class="form_add" action="">
                                <div class="form-group">
                                        <label class="form-label"><? echo __('Image');?></label>
                                        <div class="controls">
                                            <?if(empty($edit['img'])){?><input name="photo" type="file"  value="Load" class="form-control"  /> <?}?><?if(!empty($edit['img'])){?> <?=$edit['img'];?><span data-toggle="modal" data-target="#info_modal_city" class="btn btn-danger" onclick="dell_bast_img(<?=$edit['id'];?>)"><?=__('Delete images')?></span><?}?>
                                        </div>
                                    </div>
                                    <?// print_r($edit);?>
                                <div class="form-group col-md-12">
                                    <label class="form-label"><?=__('Lang')?></label>
                                    <div class="controls">
                                        <select name="lang" class="lann">
                                            <? foreach($langs as $lang){?>
                                                <option value="<?=$lang['lang'];?>" <?if($edit['for_lang'] == $lang['lang']){?> selected="selected" <?}?> ><?=$lang['lang'];?></option>
                                            <?}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label"><?=__('From')?></label>
                                    <div class="controls">
                                        <input type="text" name="from" class="page_from fromm" value="<?=$edit['from'];?>" />
                                        <div class="ajax_bloc"></div>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label class="form-label"><?=__('To')?></label>
                                    <div class="controls">
                                        <input type="text" name="to" class="page_from too" value="<?=$edit['to'];?>" />
                                        <div class="ajax_bloc"></div>
                                    </div>
                                </div>
                                <div class="clearfix">&nbsp;</div>
                                <div class="alert alert-block alert-error fade in def_val_con">
                                    <div class="col-md-12">
                                         <? foreach($valutes as $v){
                                            $edit_valute = DB::select()->from('best_routes_price')->where('valute','=',$v['valute'])->and_where('best_id','=',$edit['id'])->execute()->current();
                                            ?>
                                        <div class="form-group">
                                            <label><?=$v['valute'];?></label>
                                            <div class="controls">
                                            <input type="text" name="valutes[]" class="valutes" data-val="<?=$v['valute'];?>" value="<?=$edit_valute['value'];?>" />
                                            </div>
                                        </div>
                                        <?}?>
                                    </div>
                                    <div class="clearfix">&nbsp;</div>
                               </div>
                                <div class="form-group">
                                    <div class="controls">
                                        <button class="btn btn-success btn-cons add"><?=__('Add')?></button>
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
<script type="text/javascript">
function dell_bast_img(Id){
    $.ajax({
        type: "POST",
        url: "/pages/ajax_dell_bast_img",
        data: {id:Id},
        success: function(data) {
            location="/pages/edit_best_routes?id="+Id;         
        },
        error:function(){
            alert('/pages/ajax_dell_bast_img');
        }
    });
}

$('.page_from').keyup(function(){
    var Thiss = $(this);
    $.ajax({
        type: "POST",
        url: "/pages/search_city",
        data: {val:$(this).val()},
        success: function(data) {
            Thiss.next('.ajax_bloc').html(data);         
        },
        error:function(){
            alert('ошибка записи step_2');
        }
    });
})
/*
$('.add').click(function(){
    var valutes = [];
    $('.valutes').each(function(){
        var new_arr = [$(this).data('val'),$(this).val()];
        valutes.push(new_arr);
    })
    $.ajax({
        type: "POST",
        url: "/pages/save_best_routes",
        data: {lang:$('.lann').val(),from:$('.fromm').val(),to:$('.too').val(),valutes:valutes},
        success: function(data) {
            //alert(data);   
            location="/pages/best_routes";  
        },
        error:function(){
            alert('ошибка записи step_2');
        }
    });
})
*/
</script>