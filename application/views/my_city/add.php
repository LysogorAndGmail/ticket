<script src="<?=Kohana::$base_url?>ckeditor/ckeditor.js"></script>

<script>
CKEDITOR.config.extraPlugins = 'uploadimage';

</script>
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
                    <div class="panel-title"><?=__("New destination")?>
                    </div>
                  </div>
                  <div class="panel-body">
            <div class="row">
            <div class="col-md-6">   
            
           <h3><?=__("Route settings")?></h3>

            
            
              <?// print_r($edit_group);?>
                                   <form method="post" enctype="multipart/form-data" class="form_add">
                                             <?$contrys = DB::select()->from('language')->execute()->as_array();?>
                                            <div class="form-group">
                                   
                                   
                                   
                                                <label class=""><? echo __('Language');?></label>
                                            
                                                    <select name="lang" class="lang_city form-control">
                                                        <?foreach($contrys as $con){?>
                                                            <option value="<?=$con['culture'];?>"><?=$con['name'];?></option>
                                                        <?}?>
                                                    </select>
            
                  </div>
                  
                  
                         <div class="form-group">
                                                <label class="form-label"><? echo __('Image');?></label>
                                                <div class="controls">
                                                    <?if(empty($edit['img'])){?><input name="photo" type="file"  value="Load" class="form-control"  /> <?}?><?if(!empty($edit['img'])){?> <?=$edit['img'];?><span data-toggle="modal" data-target="#info_modal_city" class="btn btn-danger"><?=__('Delete images')?></span><?}?>
                                                </div>
                                            </div>
                                            
                                            
                                                                   <div class="form-group">
                                                <label class="form-label"><?=__("The main title of the article")?></label>
                                       
                                                <input type="text" name="title" class="form-control valid" value="" />
                              
                                            </div>       
                                            
                                                   
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Creation of URL")?></label>
                                 
                                                <input type="text" name="name" class="form-control valid" value="" />
                                              
                                            </div>
                                            
                                               <div class="form-group">
                                                <label class=""><?=__("Country")?></label>
                                                <div class="controls">
                                                    <select name="country_id" class="form-control">
                                                        <? foreach($countrys as $c){?>
                                                            <option value="<?=$c['country_id'];?>" ><?=$c['name_i18n'];?></option>
                                                        <?}?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            
                             <div class="form-group">
                                                <label class="form-label"><?=__("Departure city")?></label>
                                                <div class="controls">
                                                    <input type="text" name="from_search" class="form-control search_city valid" value="" />
                                                    <div class="search_city_block"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Arrival city")?></label>
                                                <div class="controls">
                                                    <input type="text" name="to_search" class="form-control search_city valid" value="" />
                                                    <div class="search_city_block"></div>
                                                </div>
                                            </div>  
                                          
                                            
                                            
                                           
                                         
                                   
                                   
                  
                </div>
                
                
                <div class="col-md-6">
                
                        <h3><?=__("Search engine optimization section")?></h3>

                
                  <div class="form-group">
                                                <label class="form-label"><?=__("Alt Text")?></label>
                                
                                                <input type="text" name="alt" class="form-control valid" value="" />
                              
                                            </div>
                                            
                                     
                                            
                                            
                                            
                                             <div class="form-group">
                                                <label class="form-label"><?=__("Meta Description")?></label>
                                    
                                                <input type="text" name="meta_description" class="form-control valid" value="" />
                                      
                                            </div>
                                            
                                            
                                            
                                                        
                                             <div class="form-group">
                                                <label class="form-label"><?=__("Title")?></label>
                                    
                                                <input type="text" name="title_browser" class="form-control valid" value="" />
                                      
                                            </div>
                                            
                                            
                                            
                                            
                                                        
                                             <div class="form-group">
                                                <label class="form-label"><?=__("Key words")?></label>
                                    
                                                <input type="text" name="keywords" class="form-control valid" value="" />
                                      
                                            </div>
                
                
                
                
                
               
                                            
                 
                  <div class="form-group">
                                                <label class="form-label"><?=__("Design settings")?> CSS</label>
                                              
                                                <input type="text" name="css" class="form-control" value="" />
                                          
                                            </div>
                </div>
                
    
                
                           <div class="col-md-12">         <div class="form-group">
                                                <label class="form-label"><?=__("Full Text")?></label>
                                                <div class="controls">
                                                     <textarea id="editor1" name="text" placeholder="Enter text ..." class="form-control ckeditor" rows="10"></textarea>
                                                </div>
                                            </div>                                                                                                       
                                     </div>
                
                 
           
                 
                 
                 
                 <div class="col-md-12">
                    <h3><?=__("Section of the brief description of  the city")?></h3>
                 
                     <div class="form-group">
                                                <label class="form-label"><?=__("City name")?></label>
                                                                                               <div class="controls">
                                                <input type="text" name="title_city" class="form-control valid" value="" />
                                                </div>
                                            </div>
                                            
                                            
                                            
                                                   <div class="form-group">
                                                <label class="form-label"><?=__("Brief description of  the city")?></label>
                                                <div class="controls">
                                                <input type="text" name="intro_text_city" class="form-control valid" value="" />
                                                </div>
                                            </div>
                 
                            <div class="form-group">
                                                <label class="form-label"><?=__("Name of the city link")?></label>
                                                <div class="controls">
                                                <input type="text" name="city_link_title" class="form-control valid" value="" />
                                                </div>
                                            </div>
                                            
                                            
                                                     <div class="form-group">
                                                <label class="form-label"><?=__("Web address of the city article")?></label>
                                                <div class="controls">
                                                <input type="text" name="city_link_url" class="form-control valid" value="" />
                                                </div>
                                            </div>
                     
                 
                 </div>
                 
                 
                 
                 <div class="col-md-12"><div class="form-group">
                                                   
                                                 
                                                    <label class=""><? echo __('Stops');?> 
                                                        <input class="search_ost form-control " type="text"/>  
                                                        
                                                        <span class="btn sellect_all m-t-10"><? echo __('Select All');?></span>
                                                    
                                                    </label>
                                                    <hr />
                                                    <span class="help"></span>
                                                    <div class="controls">
                                                        <div class="search_ost_block"></div>
                                                    </div>
                                                </div></div>
                 
                 
                 
                 <div class="col-md-12">       <div class="form-group">
                                                <label class="form-label"></label>
                                                <div class="controls">
                                                    <span class="btn btn-primary btn-cons add_button"><?=__("Add")?></span>
                                                </div>
                                            </div></div>
                 
                 
                 
                 
                 
                     </form>
                
     
                
                <!-- END PANEL -->
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

 $('.search_ost').keyup(function(){
     var Vall = $(this).val();
    
        $.ajax({
            url: '/svitgo/ajax_ost_my_city',
            type: 'POST',
            data: {val:Vall,lang:'ru'},
            error: function(){
                alert('errror');
            },
            success: function(data) {
              $('.search_ost_block').html(data);
            }  
        });
    //}
 })
 
 $('.search_city').keyup(function(){
     var Vall = $(this).val();
     var Block = $(this).next('.search_city_block'); 
        $.ajax({
            url: '/svitgo/ajax_city_my_city',
            type: 'POST',
            data: {val:Vall,lang:$('.lang_city').val()},
            error: function(){
                alert('errror');
            },
            success: function(data) {
              Block.html(data);
            }  
        });
    //}
 })

</script>