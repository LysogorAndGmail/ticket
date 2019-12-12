<script type="text/javascript" src="<?php echo Kohana::$base_url?>js/tinymce/tinymce.js"></script>
<script type="text/javascript">
tinymce.PluginManager.load('moxiecut', '<?php echo Kohana::$base_url?>js/tinymce/plugins/moxiecut/plugin.min.js');
tinymce.init({
    selector: ".moxiecut",
    theme: "modern",
    language: "ru",
    plugins: [
	    "advlist autolink lists link image charmap print preview anchor",
		"searchreplace visualblocks code fullscreen",
		"insertdatetime media table contextmenu paste moxiecut"
	],
	toolbar: "undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link insertfile image media",
	autosave_ask_before_unload: false,
    height: 500,
    relative_urls: false
});
</script>



<?$lang = Session::instance()->get('leng');
 if(!$lang) {
    $lang = 'EN';
 }
// echo '<pre>';
//print_r($edit);
//echo '<pre>';
// die;
?>
<style>
.no_valid {
    outline: 1px solid red !important;
}
.mce-window.mce-in {
    width: 500px !important;
}
</style>

<div class="container container-fixed-lg">
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("New article")?> 
                    </div>
                  </div>
                  <div class="panel-body">

                    <div class="row">
                        <form method="post" enctype="multipart/form-data" class="form_add">
                            <div class="col-md-12">                                  
                                <div class="form-group">
                                <label class="form-label"><?=__("Category")?></label>
                                <select class="table-group-action-input form-control input-medium" name="cat">
                                <? foreach($cat as $c){?>
                                <option value="<?=$c['my_post_cat_id'];?>" <?if($c['my_post_cat_id'] == $edit['cat']){?>selected="selected"<?}?> ><?=$c['name_i18n'];?></option>
                                <?}?>
                                </select>
                                </div> 
                                
                                
                                <div class="form-group">
                                <label class="form-label"><?=__("Template")?></label>
                                <select class="table-group-action-input form-control input-medium" name="template">
                                    <option value="article" <?if('article' == $edit['template']){?>selected="selected"<?}?> >article</option>
                                    <option value="news" <?if('news' == $edit['template']){?>selected="selected"<?}?> >news</option>
                                    <option value="cities" <?if('cities' == $edit['template']){?>selected="selected"<?}?>>cities</option>
                                    <option value="secure" <?if('secure' == $edit['template']){?>selected="selected"<?}?>>secure</option>
                                    
                                </select>
                                </div> 
                                
                                
                                
                                 <div class="form-group">
                                    <label class="form-label"><?=__("Design settings")?> CSS</label>
                                  
                                    <input type="text" name="css" class="form-control" value="<?=$edit['css'];?>" />
                              
                                </div>      
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="form-label"><? echo __('Image');?></label>
                                <div class="controls">
                                <?if(empty($edit['img'])){?><input name="photo" type="file"  value="Load" class="form-control"  /> <?}?><?if(!empty($edit['img'])){?> <?=$edit['img'];?><span data-toggle="modal" data-target="#info_modal_city" class="btn btn-danger"><?=__('Delete images')?></span><?}?>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                <label class="form-label"><?=__("Alt Text")?></label>
                                <input type="text" name="alt" class="form-control " value="<?=$edit['alt'];?>" />
                                </div>
                            </div>
                            <div class="col-md-12">       
                                <div class="form-group">
                                    <label class="form-label"></label>
                                    <div class="controls">
                                        <span class="btn btn-primary btn-cons add_button"><?=__("Edit")?></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
    </div>
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
    
    $('.valid').each(function(){
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
function dell_city_img(id){
    $.ajax({
        type: "POST",
        url: "/svitgo/ajax_dell_post_img",
        data: {id:id},
        success: function(data) {
            //alert(data);
            //exit();
            location="/svitgo/edit_my_post?id=<?=$_GET['id'];?>&lang=<?=$_GET['lang'];?>";
            //$('.alert').show();
            
        },
        error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
    });
}
</script>