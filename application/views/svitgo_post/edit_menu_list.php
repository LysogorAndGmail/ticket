

<div class="content">    
	<div class="page-title">
    <h3><?=__("Menu Items")?></h3></div>
    
 
 
   <!-- BEGIN BASIC FORM ELEMENTS-->
        <div class="row">
            <div class="col-md-6">
              <div class="grid simple">
              <form method="POST" action="/post/edit_menu_list_send?id=<?=$_GET['id'];?>" class="form">
             <div class="grid-title no-border">
                <ul class="breadcrumb">
                
                <li><a href="/post/post_menu" class="link"><?=__("Menu Manager")?></a> </li>
                <li><span href="#" class="active"><?=__("Menu Items")?></span> </li>
                
                
                </ul>
                </div>
                <div class="grid-body no-border"> <br>
                  <div class="row">
                    
                    
                    <div class="col-md-4 col-sm-6 col-xs-6">
                            
                      
                        <div class="form-group">
                        <label class="form-label"><?=__("Title")?> RU</label>
                  
                        <div class="controls">
                        <? $edit = DB::select()->from('svitgomenu_list_i18n')->where('list_id','=',$_GET['id'])->and_where('culture','=','ru')->execute()->current();?>
                <input type="text"  value="<?=$edit['title'];?>" class="list_title form-control" />
                        </div>
                      </div>
                      
                      
                                 <div class="form-group">
                        <label class="form-label"><?=__("Title")?> EN</label>
                  
                        <div class="controls">
                         <? $edit = DB::select()->from('svitgomenu_list_i18n')->where('list_id','=',$_GET['id'])->and_where('culture','=','en')->execute()->current();?>
                <input type="text"  value="<?=$edit['title'];?>" class="list_title_en form-control"/>
                        </div>
                      </div>
                      
                              <div class="form-group">
                        <label class="form-label"><?=__("Title")?> UK</label>
                  
                        <div class="controls">
                         <? $edit = DB::select()->from('svitgomenu_list_i18n')->where('list_id','=',$_GET['id'])->and_where('culture','=','uk')->execute()->current();?>
                <input type="text"  value="<?=$edit['title'];?>" class="list_title_ua form-control"/>
                        </div>
                      </div>


   <div class="form-group">
                        <label class="form-label"><?=__("Title")?> CS</label>
                  
                        <div class="controls">
                         <? $edit = DB::select()->from('svitgomenu_list_i18n')->where('list_id','=',$_GET['id'])->and_where('culture','=','cs')->execute()->current();?>
                <input type="text"  value="<?=$edit['title'];?>" class="list_title_cs form-control"/>
                        </div>
                      </div>
                      
                      
                      
            
                      
                      
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-6">
            
                         
                         
                         
                         
                         
                         <div class="form-group">
                        
                  
                        <div class="controls">
                  <button type="button" class="btn btn-success send_butt"><?=__('edit')?></button>
                        </div>
                      </div>
                      
                      
                      
                      
            
            
                    
                    </div>
                    
                    
                       
                    
                  </div>
                </div>
                </form>
              </div>
            </div>
          </div>
	<!-- END BASIC FORM ELEMENTS-->	 
 
 
 
  
 
 
 
    </div>

<script type="text/javascript">
$('.send_butt').click(function(){
     $.ajax({
        type: "POST",
        url: "/post/ajax_edit_menu_list",
        async: false,
        data: {title:$('.list_title').val(),title_en:$('.list_title_en').val(),title_uk:$('.list_title_ua').val(),title_cs:$('.list_title_cs').val(),id:'<?=$_GET['id'];?>'},
        success: function(data) {
            //alert(data);
            //exit;
            location="/post/post_menu";
        },
        error:function(){
            alert('ошибка #sell_tik прямой');
        }
    });
})

</script>