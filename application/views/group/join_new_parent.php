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
                                <h4><?=__("Join groups and functions")?></h4>
                                <div class="tabs-content large-12 columns bod">
                                    <br />
                                    <div class="large-6 columns">
                                        <label>Group:</label>
                                        <select name="group" class="group">
                                            <? foreach($groups as $g){?>
                                            <option value="<?=$g['id']?>"><?=$g['name']?></option>
                                            <?}?>
                                        </select>
                                    </div>
                                    <br />
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
                                        <? foreach($all_parent_function as $m){
                                            $full = $m['full_link'];
                                            $ac_name = DB::select()->from('group_actions_name')->where('full_link','=',$full)->execute()->current();    
                                        ?>
                                            <div>
                                                    <input type="checkbox"  name="met[]" value="<?=$m['action']?>" data-link="<?=$full;?>" /> <span data-reveal-id="group_mod_<?=$m['action']?>" style="cursor: pointer;"><?=$full?></span> <span style="color: blue;"><?=$ac_name['title']?></span>
                                            </div>
                                        <?}?>
                                        
                                    </div>
                                    <div class="clearfix"></div>
                                    <br />
                                    <button class="green access_but btn btn-salat btn-cons access_but"><?=__("Save")?></button>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    </div>
<script type="text/javascript">
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
    var Par = $(this).parents(".bod");
    Par.find("input:checkbox:checked").each(function(){
        Al_chekc.push($(this).data('link'));
    })
    //var Par2 = $(this).prev().prev().prev(".che_group");
    //Par2.find("input:checkbox:checked").each(function(){
    //    Al_chekc.push($(this).data('link'));
    //})
    //alert(Al_chekc);
    //exit;
    $.ajax({
        type: "POST",
        url: "/groups/ajax_save_medods_parent",
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













