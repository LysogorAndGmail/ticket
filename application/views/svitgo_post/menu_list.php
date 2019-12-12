

<div class="content">    
	<div class="page-title">
    <h3><?=__("Menu Items")?></h3></div>
    
 
 
   <!-- BEGIN BASIC FORM ELEMENTS-->
        <div class="row">
            <div class="col-md-6">
              <div class="grid simple">
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
                        <label class="form-label"><?=__("URL")?></label>
                  
                        <div class="controls">
                <input type="text"  value="" class="list_link form-control" />
                        </div>
                      </div>
                      
                        <div class="form-group">
                        <label class="form-label"><?=__("Title")?> RU</label>
                  
                        <div class="controls">
                <input type="text"  value="" class="list_title form-control" />
                        </div>
                      </div>
                      
                      
                                 <div class="form-group">
                        <label class="form-label"><?=__("Title")?> EN</label>
                  
                        <div class="controls">
                <input type="text"  value="" class="list_title_en form-control"/>
                        </div>
                      </div>
                      
                              <div class="form-group">
                        <label class="form-label"><?=__("Title")?> UK</label>
                  
                        <div class="controls">
                <input type="text"  value="" class="list_title_ua form-control"/>
                        </div>
                      </div>


   <div class="form-group">
                        <label class="form-label"><?=__("Title")?> CZ</label>
                  
                        <div class="controls">
                <input type="text"  value="" class="list_title_cs form-control"/>
                        </div>
                      </div>
                      
                      
                      
            
                      
                      
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-6">
            
                           <div class="form-group">
                        <label class="form-label"><?=__("Submenu")?></label>
                  
                        <div class="controls">
                <input type="text"  value="" class="list_title_cs form-control"/>
                        </div>
                      </div>
                         
                         
                         
                         
                         <div class="form-group">
                        
                  
                        <div class="controls">
                  <button type="button" class="btn btn-success btn-cons add_list_item"><?=__('Add')?></button>
                        </div>
                      </div>
                      
                      
                      
                      
            
            
                    
                    </div>
                    
                    
                       
                    
                  </div>
                </div>
              </div>
            </div>
          </div>
	<!-- END BASIC FORM ELEMENTS-->	 
 
 
 
 
 
 
 
 
 
 <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="grid simple ">
                       
                                    <div class="grid-body no-border">
                                           <h3>List  <span class="semi-bold">Menu</span></h3>
                                        
                                            <br>
                                           
                                          <table class="table table-hover no-more-tables">
                                                <thead>
                                                    <tr>
                                                    <th><?=__('#')?></th>
                                                        <th><?=__('Name')?></th>
                                                        <th><?=__('URL')?></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                     <? $i=1; foreach($list as $l){?>
                                                    <tr>
                                                    <td><?=$i;?></td>
                                                        <td><?=$l['title'];?> </td>
                                                        <td><?=$l['link'];?> </td>
                                                        <td><a href="/post/edit_menu_list?id=<?=$l['list_id'];?>"><span class="" ><?=__('Edit')?></span></a></td>
                                                        <td><a href=""><span class="" onclick="del_link_item('<?=$l['list_id'];?>')"><?=__('Delete')?></span></a></td>
                                                    </tr>
                                                     <? $i++; }?>
                                             
                                                </tbody>
                                            </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
 
 
 
 
 
    </div>













  <script type="text/javascript">
  $('.add_list_item').click(function(){
    $.ajax({
        type: "POST",
        url: "/post/ajax_add_menu_list_item",
        async: false,
        data: {title:$('.list_title').val(),title_en:$('.list_title_en').val(),title_ua:$('.list_title_ua').val(),title_cs:$('.list_title_cs').val(),link:$('.list_link').val(),id:'<?=$_GET['id'];?>'},
        success: function(data) {
            //alert(data);
            //exit;
            location="/post/menu_list?id=<?=$_GET['id'];?>";
        },
        error:function(){
            alert('ошибка #sell_tik прямой');
        }
    });
  })
  
  function del_link_item(item){
       $.ajax({
        type: "POST",
        url: "/post/ajax_dell_menu_list_item",
        async: false,
        data: {id:item},
        success: function(data) {
            //alert(data);
            //exit;
            location="/post/menu_list?id=<?=$_GET['id'];?>";
        },
        error:function(){
            alert('ошибка #sell_tik прямой');
        }
    }); 
  }
  
  </script>