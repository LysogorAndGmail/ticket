<div class="content">    
  	
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid simple">
                        <div class="alert alert-success" style="display: none;">
                              <button class="close" data-dismiss="alert"></button>
                              <?=__("Success!")?>
                        </div>
                        <div class="col-md-12 grey main-filter">           
                            <form method="POST">
                                <div class="col-md-6">
                                    <div class="col-md-12 no-padding">
                                        <label><?=__("Search ferryman")?></label>
                                        <input type="text" name="id" class="search_fer form-control" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12 no-padding">
                                        <div class="show_hide">
                                            <label><?=__("Search Bus")?></label>
                                            <input type="text" name="id" class="search_bus form-control" placeholder="">
                                        </div>
                                    </div>
                                </div>               
                            </form>
                        </div> 
                        <div class="grid-body no-border email-body" style="min-height: 850px;">     
                        <p>&nbsp;</p>
                        <a href="/ferryman/see_all" class="btn btn-success btn-cons"><?=__("List ferryman");?></a>
                        <a href="/ferryman/add" class="btn btn-success btn-cons"><?=__("Add ferryman");?></a>
                        <div class="clearfix">&nbsp;</div>
                        <div class="bor_bot">&nbsp;</div>
                        <div class="col-md-12 insert_in">
                            <div class="col-md-6 search_fe par"></div>
                            <div class="col-md-6 search_bu"></div>
                        </div>
                        <p>&nbsp;</p>
                        <div class="clearfix"></div>
                        <button class="save_pr btn btn-salat btn-cons"><?=__("Save")?></button>
                        </div>
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>        
<script type="text/javascript">
$(".search_fer").keyup(function(){
    $.ajax({
        type: "POST",
        url: "/ferryman/ajax_ferryman_seach",
        data: {search:$(this).val()},
        success: function(data) {
            //alert(data);
            //$('.warning').show();
            $(".search_fe").html(data);
            
        },
        error:function(code, opt, err){
            alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
   });
});
$(".search_bus").keyup(function(){
    //var ferID = $(this).parent().find(".search_fe").find("input:checked").val();
    var ferID = $(this).parents('.row').find(".search_fe").find("input:checked").val();
    //alert(ferID);
    //exit;
    $.ajax({
        type: "POST",
        url: "/buses/ajax_search_buses",
        data: {name:$(this).val(),lang:$("#cur_lan").val(),fer_id:ferID},
        success: function(data) {
            //alert(data);
            //$('.warning').show();
            $(".search_bu").html(data);
            
        },
        error:function(code, opt, err){
            alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
   });
});
$('.save_pr').click(function(){
    //$('.alert-success').show();
    var ferID = $(this).parent().find(".search_fe").find("input:checked").val();
    var al_bus = [];
    $(this).parent().find(".search_bu").find("input:checked").each(function(){
        al_bus.push($(this).val());
    });
    $.ajax({
        type: "POST",
        url: "/ferryman/ajax_ferryman_buses_save",
        data: {fer_id:ferID,buses:al_bus},
        success: function(data) {
            //alert(data);
            //$(".search_bu").html('');
            //$(".search_fe").html('');
            $('.alert-success').show();
            //$(".search_bu").html(data);
            //location="/ferryman";
            
        },
        error:function(code, opt, err){
            alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
   });
   //*/
})
</script>














