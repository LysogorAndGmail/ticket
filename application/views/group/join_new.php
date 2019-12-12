<div class="content">    
  	
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid simple">
                        <div class="col-md-12 grey">           
                            <form method="POST">
                                <div class="col-md-6">
                                    <div class="col-md-12 no-padding">
                                        <label><?=__("Groups")?></label>
                                        <select name="group" class="group form-control">
                                            <? foreach($groups as $g){?>
                                            <option value="<?=$g['id']?>"><?=$g['name']?></option>
                                            <?}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12 no-padding">
                                        <div class="show_hide_">
                                            <label><?=__("Access")?></label>
                                            <select name="class_name" class="class_name form-control">
                                                <? foreach($all_clases as $cl){?>
                                                <option value="<?=$cl?>"><?=$cl?></option>
                                                <?}?>
                                            </select>
                                        </div>
                                    </div>
                                </div>               
                            </form>
                        </div> 
                        <div class="grid-body no-border email-body" style="min-height: 850px;">    
                            <p>&nbsp;</p>
                            <div class="tabs-content large-12 columns bod">
                                <div class="che_group large-12 columns">
                                    <? foreach($all_first_save as $m){
                                        $full = $m['full_link'];
                                        $ac_name = DB::select()->from('group_actions_name')->where('full_link','=',$full)->execute()->current();    
                                    ?>
                                        <div class="green">
                                                <input type="checkbox"  name="met[]" value="<?=$m['action']?>" data-link="<?=$full;?>" checked="checked" /> <span data-reveal-id="group_mod_<?=$m['action']?>" style="cursor: pointer;"><?=$full?></span> <span style="color: blue;"><?=$ac_name['title']?></span>
                                        </div>
                                    <?}?>
                                </div>
                                <div class="che_cla large-12 columns">
                                    <? foreach($first_metods as $m){
                                        $class = "Controller_Adminmess";
                                        $full = $class."/".$m;
                                        $ac_name = DB::select()->from('group_actions_name')->where('full_link','=',$full)->execute()->current();    
                                    ?>
                                        <div>
                                                <input type="checkbox"  name="met[]" value="<?=$m?>" data-link="<?=$full;?>" /> <span data-reveal-id="group_mod_<?=$m?>" style="cursor: pointer;"><?=$full?></span> <span style="color: blue;"><?=$ac_name['title']?></span>
                                        </div>
                                    <?}?>
                                </div>
                                <p>&nbsp;</p>
                                <button class="btn btn-salat btn-cons access_but"><?=__("Save")?></button>
                            </div>
                        </div>
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>          
    
<script type="text/javascript">
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
$('.group').change(function(){
    //alert($(this).val());
    //exit;
    $.ajax({
        type: "POST",
        url: "/groups/ajax_get_group_medods",
        data: {group:$(this).val()},
        success: function(data) {
            $('.che_group').html(data);
        },
        error:function(code, opt, err){
            alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
   });
})
$(".access_but").click(function(){
    
    var CurGroup = $('.group').val();
    var Al_chekc = [];
    var Par = $(this).prev().prev(".che_cla");
    Par.find("input:checkbox:checked").each(function(){
        Al_chekc.push($(this).data('link'));
    })
    var Par2 = $(this).prev().prev().prev(".che_group");
    Par2.find("input:checkbox:checked").each(function(){
        Al_chekc.push($(this).data('link'));
    })
    //alert(Al_chekc);
    //exit;
    $.ajax({
        type: "POST",
        url: "/groups/ajax_save_medods",
        data: {metods:Al_chekc,group:CurGroup},
        success: function(data) {
            //$('.che_cla').html(data);
            //alert(data);
            location="/groups/group_join";
        },
        error:function(code, opt, err){
            alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
            //location="/groups/group_join";
        }
   });
   //alert(Al_chekc);
})
</script>













