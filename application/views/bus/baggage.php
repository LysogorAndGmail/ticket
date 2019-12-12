<div class="content">    
	
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid simple">
                        <div class="grid-body no-border email-body" style="min-height: 850px;"> 
                            <p>&nbsp;</p>
                            <div class="clearfix"></div>
                            <div class="search">
                               <div class="large-12 medium-12  columns insert_in">
                                    <p>&nbsp;</p>
                                    <a href="/buses/add_baggage" class="btn btn-success btn-cons"><?=__("Create Baggage")?></a>
                                
                                    <table class="table table-striped table-hover" id="emails">
                                        <thead>
                                            <tr>
                                                <th><?=__("ID")?></th>
                                                <th><?=__("Name")?></th>
                                                <th><?=__("Price")?></th>
                                                <th><?=__("EN")?></th>
                                                <th><?=__("UA")?></th>
                                                <th><?=__("RU")?></th>
                                                <th><?=__("CS")?></th>
                                                <th><?=__("Actions")?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <? foreach($bagaj as $n){?>
                                                <tr class="">
                                                    <td><?=$n['id'];?></td>
                                                    <td><?=$n['name_i18n'];?></td>
                                                    <td><?=$n['price'];?></td>
                                                    <td><a href="/buses/update_bagaj?id=<?=$n['id'];?>&lang=en"><i class="fa fa-edit"></i></a></td>
                                                    <td><? $chek_lang = Model::factory('BusesMod')->get_bagaj($n['id'],'ua'); if(!empty($chek_lang)){ ?> <a href="/buses/update_bagaj?id=<?=$n['id'];?>&lang=ua"><i class="fa fa-edit"></i></a> <?}else{ ?> <a href="/buses/update_bagaj?id=<?=$n['id'];?>&lang=ua"><?=__("Add")?></a> <?}?></td>
                                                    <td><? $chek_lang = Model::factory('BusesMod')->get_bagaj($n['id'],'ru'); if(!empty($chek_lang)){ ?> <a href="/buses/update_bagaj?id=<?=$n['id'];?>&lang=en"><i class="fa fa-edit"></i></a> <?}else{ ?> <a href="/buses/update_bagaj?id=<?=$n['id'];?>&lang=en"><?=__("Add")?></a> <?}?></td>
                                                    <td><? $chek_lang = Model::factory('BusesMod')->get_bagaj($n['id'],'cs'); if(!empty($chek_lang)){ ?> <a href="/buses/update_bagaj?id=<?=$n['id'];?>&lang=cs"><i class="fa fa-edit"></i></a> <?}else{ ?> <a href="/buses/update_bagaj?id=<?=$n['id'];?>&lang=cs"><?=__("Add")?></a> <?}?></td>
                                                    <td>
                                                        <a class="shure" href="/buses/dell_bagaj?id=<?=$n['id'];?>"><i class="fa fa-times"></i></a>
                                                    </td>
                                                </tr>
                                            <?}?>
                                        </tbody>
                                    </table>
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
    $('.limit').change(function(){
        $('.lim_form').submit();
    })
    $('.ser_bus').keyup(function(){
        var Input = $(this).attr('name');
        $.ajax({
            type: "POST",
            url: "/buses/ajax_seach_buses",
            data: {search:$(this).val(),input:Input,lang:$('#cur_lan').val()},
            success: function(data) {
                //alert(data);
                //$('.warning').show();
                $(".search").html(data);
                
            },
            error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
            }
        });
    })
</script>
        