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
                    <div class="panel-title"><?=__("New article")?> 
                    </div>
                  </div>
                  <div class="panel-body">

            <div class="row">
               <form method="post" enctype="multipart/form-data" class="form_add">
        
        
        <div class="col-md-6">                                  <div class="form-group">
                                                <label class="form-label"><?=__("The main title of the article")?></label>
                                       
                                                <input type="text" name="title" class="form-control valid" value="<?=$edit['title'];?>" />
                              
                                            </div>       </div>
        
             <div class="col-md-4">
                        <div class="form-group">
                                                <label class="form-label"><?=__("Creation of URL")?></label>
                                 
                                                <input type="text" name="name" class="form-control valid" value="<?=$edit['name'];?>" />
                                              
                                            </div>
             
             </div>
             
             
               
             
             
       </div>

            <div class="row">
               
        

       
            <div class="panel panel-transparent">
                      <!-- Nav tabs -->
                      <ul data-init-reponsive-tabs="dropdownfx" class="nav nav-tabs nav-tabs-linetriangle hidden-sm hidden-xs">
                        <li class="active">
                          <a href="#content" data-toggle="tab"><span><?=__("Content")?> </span></a>
                        </li>
                        <li>
                          <a href="#settings" data-toggle="tab"><span><?=__("Settings")?></span></a>
                        </li>
                        <li>
                          <a href="#images" data-toggle="tab"><span><?=__("Images")?></span></a>
                        </li>
                      </ul><div class="nav-tab-dropdown cs-wrapper full-width p-t-10 visible-xs visible-sm"><div class="cs-select cs-skin-slide full-width" tabindex="0"><span class="cs-placeholder">Hello World</span><div class="cs-options"><ul><li data-value="#content" data-option=""><span>Hello World</span></li><li data-value="#settings" data-option=""><span>Hello Two</span></li><li data-value="#images" data-option=""><span>Hello Three</span></li></ul></div><select data-init-plugin="cs-select" class="cs-select cs-skin-slide full-width"><option selected="" value="#content">Hello World</option><option value="#settings">Hello Two</option><option value="#images">Hello Three</option></select><div class="cs-backdrop"></div></div></div>
                      <!-- Tab panes -->
                      <div class="tab-content">
                        <div id="content" class="tab-pane active">
                          <div class="row column-seperation">
                     
   
                  
       
                     
                     
                      <div class="col-md-12">       
                      
                      
                      
                      
                      
                      
                      
                      
                        <div class="form-group">
                                                <label class="form-label"><?=__("Full Text")?></label>
                                                <div class="controls">
                                                     <textarea name="text" placeholder="Enter text ..." class="form-control moxiecut" rows="10"><?=$edit['text'];?></textarea>
                                                     
                                                </div>
                                            </div>                                                                                                       
              
                               
                               
                               
                                     </div>
                                     
                                     
                                     <div class="col-md-12">
                    <h3><?=__("Section of the brief description of  the article")?></h3>
                 
                     <div class="form-group">
                                                <label class="form-label"><?=__("Name")?></label>
                                                                                               <div class="controls">
                                                <input type="text" name="short_title" class="form-control" value="<?=$edit['short_title'];?>" />
                                                </div>
                                            </div>
                                            
                                            
                                            
                                                   <div class="form-group">
                                                <label class="form-label"><?=__("Brief description of  the article")?></label>
                                                <div class="controls">
                                                <input type="text" name="short_text" class="form-control" value="<?=$edit['short_text'];?>" />
                                                </div>
                                            </div>
                 
                    
                                            
                                            
                                     
                     
                 
                 </div>
                                     
                          </div>
                        </div>
                        <div id="settings" class="tab-pane">
                          <div class="row">
                                        <div class="col-md-4">       
                                          <h3><?=__("Other settings")?></h3>
                                        
                                        
                                             <?// print_r($edit_group);?>
                                
                                             <?$contrys = DB::select()->from('language')->execute()->as_array();?>
                                            
                                        
                                            
                                            
                                           
                  
                                                 
               
               
               
               
                  </div>
                  
                  
                  <div class="col-md-8">
                
                        <h3><?=__("Search engine optimization section")?></h3>

                
          
                                            
                                     
                                            
                                            
                                            
                                             <div class="form-group">
                                                <label class="form-label"><?=__("Meta Description")?></label>
                                    
                                                <input type="text" name="meta_description" class="form-control " value="<?=$edit['meta']?>" />
                                      
                                            </div>
                                            
                                           
                                                        
                                             <div class="form-group">
                                                <label class="form-label"><?=__("Key words")?></label>
                                    
                                                <input type="text" name="keywords" class="form-control " value="<?=$edit['keywords']?>" />
                                      
                                            </div>
                
                
                
                
                
               
                                            
                 
              
                </div>
                  
                  
                  
                  
                  
                  
                  
                          </div>
                        </div>
                        <div id="images" class="tab-pane">
                          <div class="row">
                           
                                            
                                            
                                            
                                            <div class="col-md-12">
                                            
                                       <!--   
                                                            <div class="alert alert-success margin-bottom-10">
                                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                                                                <i class="fa fa-warning fa-lg"></i><?=__("Alt Text")?></div>-->
                          
                                                            <div class="row">
                                                                <div id="tab_images_uploader_filelist" class="col-md-6 col-sm-12"></div>
                                                            </div>
                                                            <table class="table table-bordered table-hover">
                                                                <thead>
                                                                    <tr role="row" class="heading">
                                                                        <th width="8%"><?=__("Image")?></th>
                                                                        <th width="25%"><?=__("Alt Text")?></th>
                                                                        <th width="8%"> <?=__("Sort Order")?></th>
                                                                          <th width="10%"> <?=__("Base Image")?></th>
                                                                        <th width="10%"><?=__(" Small Image ")?></th>
                                                                        <th width="10%"> <?=__("Thumbnail")?> </th>
                                                                        <th width="10%"> </th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <a href="../assets/pages/media/works/img1.jpg" class="fancybox-button" data-rel="fancybox-button">
                                                                                <img class="img-responsive" src="../assets/pages/media/works/img1.jpg" alt=""> </a>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" class="form-control" name="product[images][1][label]" value=" <?=__("Thumbnail image")?>"> </td>
                                                                        <td>
                                                                            <input type="text" class="form-control" name="product[images][1][sort_order]" value="1"> </td>
                                                                        <td>
                                                                            <label>
                                                                                <div class="radio"><span><input type="radio" name="product[images][1][image_type]" value="1"></span></div> </label>
                                                                        </td>
                                                                        <td>
                                                                            <label>
                                                                                <div class="radio"><span><input type="radio" name="product[images][1][image_type]" value="2"></span></div> </label>
                                                                        </td>
                                                                        <td>
                                                                            <label>
                                                                                <div class="radio"><span class="checked"><input type="radio" name="product[images][1][image_type]" value="3" checked=""></span></div> </label>
                                                                        </td>
                                                                        <td>
                                                                            <a href="javascript:;" class="btn btn-default btn-sm">
                                                                                <i class="fa fa-times"></i> <?=__("Delete")?> </a>
                                                                        </td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            
                                            </div>
                                            
                                            
                            
                            
                            
                          </div>
                        </div>
                      </div>
                    </div>
            
            
            
            
            
            
            
                
                
                
                
    
                
                    
                
                 
           
                 
                 
                 
                 
                 
                 
                 
     
                 
                 
                 
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