<script src="<?=Kohana::$base_url?>/js/ckeditor/ckeditor.js"></script>
<script src="//ckeditor.com/apps/ckeditor/4.3.3/samples/assets/uilanguages/languages.js"></script>
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


<div class="container container-fixed-lg">
  <div class="row">
              <!-- START PANEL -->
              <div class="col-md-12">
                <!-- START PANEL -->
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__('Edit')?>
                    </div>
                  </div>
                  <div class="panel-body">
            
            
            <div class="row">
                                                
                                                <div class="col-md-6">
                                                              <h3><?=__("Route settings")?></h3>
                                                    <?// print_r($edit_group);?>
                                        <form method="post" enctype="multipart/form-data" class="form_add">
                                            <input type="hidden" name="id" value="<?=$edit['id'];?>" />
                                            <div class="form-group">
                                                <label class="form-label"><? echo __('Image');?></label>
                                                <div class="controls">
                                                    <?if(empty($edit['img'])){?><input name="photo" type="file"  value="Load" class="form-control"  /> <?}?><?if(!empty($edit['img'])){?> <?=$edit['img'];?><span data-toggle="modal" data-target="#info_modal_city" class="btn btn-danger"><?=__('Delete Image')?></span><?}?>
                                                </div>
                                            </div>


                 
                 
                 
                           
                                            <!--Title-->                          
                                            
                                                 <div class="form-group">
                                              <label ><?=__("The main title of the article")?></label>
                                        
                                                <input type="text" name="title" class="form-control valid" value="<?=$edit['title'];?>" />
                                      
                                            </div>
                 
                                            
                                            
                 <!--URL--> 
                 
                 
                            <div class="form-group">
                                                 <label class="form-label"><?=__("Creation of URL")?></label>
                                          
                                                <input type="text" name="name" class="form-control valid" value="<?=$edit['name'];?>" />
                                    
                                            </div>
                                            
                                            
                                            
                                  



                                            
                                            
                                            
                                            
                                            
                                            
                                            

          <div class="form-group">
                                                <label ><?=__("Country")?></label>
                                
                                                    <select name="country_id" class="form-control">
                                                        <? foreach($countrys as $c){?>
                                                            <option value="<?=$c['country_id'];?>" <?if($c['country_id'] == $edit['country_id']){?> selected="selected"<?}?>><?=$c['name_i18n'];?></option>
                                                        <?}?>
                                                    </select>
                                         
                                            </div>  





</div>

<div class="col-md-6">

   <h3><?=__("Search engine optimization section")?></h3>

                    <div class="form-group">
                                                <label class="form-label"><?=__("Alt Text")?></label>
                                
                                                <input type="text" name="alt" class="form-control valid"  value="<?=$edit['alt'];?>" />
                              
                                            </div>
                         

<!--Disc-->

     <div class="form-group">
                                           
                                           
                                           
                                                <label ><?=__("Meta Description")?></label>
                                      
                                                <input type="text" name="meta_description" class="form-control valid" value="<?=$edit['meta'];?>" />
                                      
                                            </div>
                                            
                                            
                                            
                                                     <div class="form-group">
                                                <label ><?=__("Title")?></label>
                                    
                                                <input type="text" name="title_browser" class="form-control valid" value="<?=$edit['title_browser'];?>"  />
                                      
                                            </div>
                                            
                                            
                                            
                                            
                                                        
                                             <div class="form-group">
                                              <label ><?=__("Key words")?></label>
                                    
                                                <input type="text" name="keywords" class="form-control valid" value="<?=$edit['keywords'];?>" />
                                      
                                            </div>
                                            

                     
                            
                  <div class="form-group">
                                                 <label ><?=__("Design settings")?> CSS</label>
                                                <div class="controls">
                                                <input type="text" name="css" class="form-control" value="<?=$edit['css'];?>"/>
                                                </div>
                                            </div>



</div>

     <!--Text editor-->

 <div class="col-md-12">            <div class="form-group">
                                                <label ><?=__("Full Text")?></label>
                                                <div class="controls">
                                                     <textarea id="text-editor" id="editor1" name="text" placeholder="Enter text ..." class="form-control ckeditor" rows="10"><?=$edit['text'];?></textarea>
                                                </div>
                                            </div> 
                                            




<?php /*?><div class="add_input">
                                                <span class="btn btn-danger" onclick="add_fild(<?=$_GET['id'];?>)"><?=__('add fild')?></span>
                                                <?foreach($filds as $in){
                                                    $fild = DB::select()->from('my_city_filds_i18n')->where('fild_id','=',$in['id'])->and_where('culture','=',$_GET['lang'])->execute()->current();
                                                    ?>
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
                                                                <input type="text" name="fild_title[]" value="<?=$fild['title'];?>"/>
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
                                            </div>      <?php */?>        

 

            </div>
            
            
            
            <div class="col-md-12">
                       <h3><?=__("Section of the brief description of  the city")?></h3>
                 
                     <div class="form-group">
                                           <label ><?=__("City name")?></label>
                                                <div class="controls">
                                                <input type="text" name="title_city" class="form-control valid" value="<?=$edit['title_city'];?>" />
                                                </div>
                                            </div>
                                            
                                            
                                            
                                                   <div class="form-group">
                                                <label ><?=__("Brief description of  the city")?></label>
                                        
                                                <input type="text" name="intro_text_city" class="form-control valid" value="<?=$edit['intro_text_city'];?>" />
                                         
                                            </div>
                 
                            <div class="form-group">
                                <label ><?=__("Name of the city link")?></label>
                                     
                                                <input type="text" name="city_link_title" class="form-control valid"  value="<?=$edit['city_link_title'];?>" />
                        
                                            </div>
                                            
                                            
                                                     <div class="form-group">
                                                  <label ><?=__("Web address of the city article")?></label>
                                     
                                                <input type="text" name="city_link_url" class="form-control valid"  value="<?=$edit['city_link_url'];?>" />
                                     
                                            </div>
                     
                 
                 </div>
            
            
            
            <div class="col-md-12">
            
            
            <div class="form-group">
                                                   
                                                   
                                                    <label class=""><? echo __('Stops');?> 
                                                        <input class="search_ost form-control" type="text"/>  
                                                        <span class="btn sellect_all m-t-10"><? echo __('Select All');?></span>
                                                    </label>
                                                    <hr />
                                                    <span class="help"></span>
                                                    <div class="controls">
                                                        <div class="search_ost"></div>
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
            </div>
            
            
            
            
            
            
            
                   <div class="col-md-12">
                                          
                                      
                                                
                                                    
                                                    <button class="btn btn-success btn-cons add_button"><?=__("Save")?></button>
                                  
                           


                                            </div>
            
                  </div>
                </div>
                <!-- END PANEL -->
              </div>
              
              
              
      
              </form>
              
              
              
              
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
    if($('#editor1').val().length == 0){
        $('iframe').addClass('no_valid');
        cou_chek++;
    }
    $('.valid,input:file').each(function(){
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