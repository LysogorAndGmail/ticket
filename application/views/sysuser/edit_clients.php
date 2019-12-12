<div class="content">    
	<div class="page-title">
    <h3><?=__("Edit Client")?></h3></div>
   

  <!-- BEGIN BASIC FORM ELEMENTS-->
        <div class="row">
            <div class="col-md-12">
              <div class="grid simple">
             <div class="grid-title no-border">
                   <ul class="breadcrumb">
     
        <li><a href="/sysuser/clients" class="link"><?=__("Clients")?></a> </li>
          <li><span href="#" class="active"><?=__("Edit Client")?></span> </li>
      
     
      </ul>
                </div>
                <div class="grid-body no-border"> <br>
                  <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                      <form id="add_material" action="" method="post" enctype="multipart/form-data" >
                     <input type="hidden" name="id" value="<?=$edit['id'];?>" />
                
         
            
                  <div class="form-group">
                                <label class="form-label"><? echo __('Name');?></label>
                                <div class="controls">
                                    <input name="name" type="text"  value="<?=$edit['name'];?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Last name');?></label>
                                <div class="controls">
                                    <input name="soname" type="text"  value="<?=$edit['soname'];?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Date');?></label>
                                <div class="controls">
                                    <input name="date" type="text"  value="<?=$edit['date'];?>" class="form-control" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label"><? echo __('Phone');?></label>
                                <div class="controls">
                                    <input name="phone" type="text"  value="<?=$edit['tel'];?>" class="form-control" />
                                </div>
                            </div>
                      
                   
                            
                            
                        
                            
                            
                   
                            
                            
                            
                   <div class="form-group">  
            					<div class="controls">
            					  <button type="submit" class="btn btn-success btn-cons"><i class="icon-ok"></i><?=__("Edit");?></button>
            					</div>
        					</div>
                
           </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
	<!-- END BASIC FORM ELEMENTS-->	 









</div><!--Content div-->











                                 
<script type="text/javascript">
$(".city_ajax").keyup(function(){
    $.ajax({
        type: "POST",
        url: "/ost/search_ajax_city",
        data: {ost:$(this).val(),lang:$('#cur_lan').val()},
        success: function(data) {
            $('.ajax_bl').html(data);
        },
        //error:function(code, opt, err){
        //        alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        //}
   });
    
})
$('.ajax_p').click(function(){
    alert($(this).text());
})
$('.sellect_all').click(function(){
    //alert('ok');
    $(this).parents('.alert-block').find('input').each(function(){
        $(this).attr('checked','checked');
    })
})
</script>