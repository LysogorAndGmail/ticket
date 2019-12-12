<div class="content">    
	
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid simple">
                        <div class="grid-body no-border email-body">    
                            <p>&nbsp;</p>
                            <div class="col-md-12 bod no-padding">
                                <div class="col-md-12 no-padding">
                                    <? foreach($first_metods as $class=>$med){
                                        foreach($med as $m){
                                        $full = $class."/".$m;
                                        $ac_name = DB::select()->from('group_actions_name')->where('full_link','=',$full)->execute()->current();    
                                    ?>
                                        <div class="col-md-12 no-padding">
                                            <a class="btn btn-success btn-cons"  data-toggle="modal" data-target="#myModal<?=$m?>"><?=$full?></a><span style="color: blue;"><?=$ac_name['title']?></span> 
                                            <div class="modal fade" id="myModal<?=$m?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-body">
                                                            <form action="/groups/add" method="post">
                                                                <label><?=$m?></label>
                                                                <input type="text" name="name" class="met_val form-control" data-action="<?=$m?>" data-conn="<?=$class?>"  value="<?=$ac_name['title']?>" />
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal"><?=__("Close")?></button>
                                                            <button class="btn btn-salat met_but"><?=__("Edit")?></button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?}}?>
                                    
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>          
<script type="text/javascript">

$(".met_but").click(function(e){
    e.preventDefault();
    var ValAc = $(this).parents('.modal-dialog').find('.met_val').val();
    var Act = $(this).parents('.modal-dialog').find('.met_val').data("action");
    var Cont = $(this).parents('.modal-dialog').find('.met_val').data("conn");
    //alert(ValAc);
    //exit;
    $.ajax({
        type: "POST",
        url: "/groups/ajax_update_action_name",
        data: {controller:Cont,action:Act,title:ValAc},
        success: function(data) {
            //alert(data);
            location="/groups/all_metods_names";
        },
        error:function(code, opt, err){
            alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
   });
})

$('.class_name').change(function(){
    //alert($(this).val());
    //exit;
    $.ajax({
        type: "POST",
        url: "/groups/ajax_get_class_medods",
        data: {search_class:$(this).val()},
        success: function(data) {
            $('.che_cla').html(data);
        },
        error:function(code, opt, err){
            alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
   });
})
$(".access_but").click(function(){
    var Al_chekc = [];
    var Par = $(this).prev(".che_cla");
    Par.find("input:checkbox:checked").each(function(){
        Al_chekc.push($(this).val());
    })
    alert(Al_chekc);
})
</script>













