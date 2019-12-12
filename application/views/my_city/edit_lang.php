<script src="<?=Kohana::$base_url?>/js/ckeditor/ckeditor.js"></script>
<script src="//ckeditor.com/apps/ckeditor/4.3.3/samples/assets/uilanguages/languages.js"></script>
<?$lang = Session::instance()->get('leng');
 if(!$lang) {
    $lang = 'EN';
 }
// print_r($countrys);
// die;
?>

<div class="container container-fixed-lg">
  <div class="row">
      <?// print_r($edit_group);?>
                                        <form method="post" enctype="multipart/form-data">
              <!-- START PANEL -->
              <div class="col-md-12">
              
    
                <!-- START PANEL -->
                <div class="panel panel-default no-margin-b">
                  <div class="panel-heading">
                    <div class="panel-title"><?=__("Edit")?>
                    </div>
                  </div>
      
         
      
                  <div class="panel-body">
      
                 <div class="col-md-6">
                         
                                    <h3><?=__("Route settings")?></h3>
                         
                         
                              <div class="form-group">
                                                <label ><?=__("The main title of the article")?></label>
                                           
                                                <input type="text" name="title" class="form-control" value="<?=$edit['title'];?>" />
                                               
                                            </div>
                         
                         
                           <div class="form-group">
                                                <label ><?=__("Creation of URL")?></label>
                                       
                                                <input type="text" name="name" class="form-control" value="<?=$edit['name'];?>" />
                                           
                                            </div>
                    
                                            
                                            
                                            
                                            
                                  <div class="form-group" style=" display:none">
                                                <label class="form-label"><?=__("Departure city")?></label>
                                                <div class="controls">
                                                    <input type="text" name="from_search" class="form-control search_city" value="<?=$edit['from_search'];?>" />
                                                    <div class="search_city_block"></div>
                                                </div>
                                            </div>
                                            <div class="form-group" style=" display:none">
                                                <label class="form-label"><?=__("Arrival city")?></label>
                                                <div class="controls">
                                                    <input type="text" name="to_search" class="form-control search_city" value="<?=$edit['to_search'];?>" />
                                                    <div class="search_city_block"></div>
                                                </div>
                                            </div>                  
                                             
                 
                 </div>
      
             <div class="col-md-6">     
             
                         <h3><?=__("Search engine optimization section")?></h3>
                         
                         
                                          <div class="form-group">
                                                <label class="form-label"><?=__("Alt Text")?></label>
                                
                                                <input type="text" name="alt" class="form-control valid"  value="<?=$edit['alt'];?>" />
                              
                                            </div>
                         
                         
                         
                               <div class="form-group">
                                                <label  ><?=__("Meta Description")?></label>
                                              
                                                <input type="text" name="meta_description" class="form-control" value="<?=$edit['meta'];?>" />
                                            
                                            </div>  
                                            
                                            
                                                                <div class="form-group">
                                                <label class="form-label"><?=__("Title")?></label>
                                    
                                                <input type="text" name="title_browser" class="form-control valid" value="<?=$edit['title_browser'];?>"  />
                                      
                                            </div>
                                            
                                            
                                            
                                            
                                                        
                                             <div class="form-group">
                                                <label class="form-label"><?=__("Key words")?></label>
                                    
                                                <input type="text" name="keywords" class="form-control valid" value="<?=$edit['keywords'];?>" />
                                      
                                            </div>
                         
                            
                  <div class="form-group">
                                                <label class="form-label"><?=__("Design settings")?> CSS</label>
                                                <div class="controls">
                                                <input type="text" name="css" class="form-control" value="<?=$edit['css'];?>"/>
                                                </div>
                                            </div>
                         
                         
             
                </div>
                <div class="col-md-12">
             <div class="form-group">
                                                     <label class="form-label"><?=__("Full Text")?></label>
                                    
                                                     <textarea id="text-editor" name="text" placeholder="Enter text ..." class="form-control ckeditor" rows="10"><?=$edit['text'];?></textarea>
                                         
                                            </div>
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
                                                <div class="controls">
                                                <input type="text" name="intro_text_city" class="form-control valid" value="<?=$edit['intro_text_city'];?>" />
                                                </div>
                                            </div>
                 
                            <div class="form-group">
                                                <label class="form-label"><?=__("Name of the city link")?></label>
                                                <div class="controls">
                                                <input type="text" name="city_link_title" class="form-control valid"  value="<?=$edit['city_link_title'];?>" />
                                                </div>
                                            </div>
                                            
                                            
                                                     <div class="form-group">
                                                <label class="form-label"><?=__("Web address of the city article")?></label>
                                                <div class="controls">
                                                <input type="text" name="city_link_url" class="form-control valid"  value="<?=$edit['city_link_url'];?>" />
                                                </div>
                                            </div>
                     
                 
                 </div>
              
                          <div class="col-md-12">
                 
                       <div class="form-group">
                                   
                               
                                                    <button class="btn btn-success btn-cons"><?=__("Save")?></button>
                                   
                                            </div>
                 
                 </div>
              
                  </div>
                  
                 
                </div>
                   </form>  
                <!-- END PANEL -->
              </div>
  
            </div>
            
        
          
        
        
        
        
              
  </div>














 
<script type="text/javascript">
$('.search_city').keyup(function(){
     var Vall = $(this).val();
     var Block = $(this).next('.search_city_block'); 
        $.ajax({
            url: '/svitgo/ajax_city_my_city',
            type: 'POST',
            data: {val:Vall,lang:'<?=$_GET['lang'];?>'},
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