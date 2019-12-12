<div class="content">    
	<div class="page-title" > <a href="/" id="btn-back"><i class="icon-custom-left"></i></a>
        <h3><?=__("Back")?> - <span class="semi-bold"><?=__("Index")?></span></h3>
    </div>		
	<div class="row" id="inbox-wrapper">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					 <div class="grid simple">
                        <div class="grid-body no-border email-body" style="min-height: 850px;">
                            
                            <div>
                                <label><?=__("Title")?></label>
                                <input type="text" class="list_title" />
                                <br />
                                <label><?=__("link")?></label>
                                <input type="text" class="list_link" />
                                <br /><br />
                                <button class="add_list_item"><?=__('Add')?></button>
                                
                            </div>
                            <hr />
                            <ul>
                                <? foreach($list as $l){?>
                                    <li><?=$l['title'].' - '.$l['link'];?> <span class="btn btn-danger" onclick="del_link_item('<?=$l['list_id'];?>')"><?=__('Delete')?></span></li>
                                <?}?>
                            </ul>      
                        </div>
                   </div>	
				</div>
			</div>
		</div>	
	</div>
 <div class="clearfix"></div>
  </div>
  <script type="text/javascript">
  $('.add_list_item').click(function(){
    $.ajax({
        type: "POST",
        url: "/post/ajax_add_menu_list_item",
        async: false,
        data: {title:$('.list_title').val(),link:$('.list_link').val(),id:'<?=$_GET['id'];?>'},
        success: function(data) {
            //alert(data);
            //exit;
            location="http://disp_svitgo/post/menu_list?id=<?=$_GET['id'];?>";
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
            location="http://disp_svitgo/post/menu_list?id=<?=$_GET['id'];?>";
        },
        error:function(){
            alert('ошибка #sell_tik прямой');
        }
    }); 
  }
  
  </script>