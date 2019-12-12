<div class="content">    
        <div class="row">
            <div class="col-md-12">
              <div class="grid simple">
                <div class="grid-body no-border"> <br>
                  <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                       <h2 class=" inline"><?=__("Enter Sysuser")?></h2>
                       <br />
                        <form id="add_material" action="" method="post" >
                            <div class="form-group">
                                <label class="form-label"><? echo __('Sysuser ID');?></label>
                                <div class="controls">
                                    <input name="id" type="text"  value="" class="form-control" />
                                </div>
                            </div>
                            <div class="form-actions">  
            					<div class="pull-right">
            					  <button type="submit" class="btn btn-success btn-cons"><i class="icon-ok"></i><?=__("Enter");?></button>
            					</div>
        					</div>
                        </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>                        
                                 
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