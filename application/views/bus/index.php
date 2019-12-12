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
                                        <label>ID</label>
                                        <input type="text" name="buses_id" class="form-control ser_bus" placeholder="">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="col-md-12 no-padding">
                                        <label><?=__("Name");?></label>
                                        <input type="text" name="buses_i18n" class="form-control ser_bus" placeholder="">
                                    </div>
                                </div>             
                            </form>
                        </div>
                        <div class="grid-body no-border email-body" style="min-height: 850px;"> 
                            <p>&nbsp;</p>
                            <form class="lim_form">
                                <div class="col-md-12">
                                    <!--<div class="col-md-1 no-padding">
                                        <label>Limit</label>
                                        <select name="limit" class="form-control limit">
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                            <option value="200">200</option>
                                            <option value="10000">all</option>
                                        </select>
                                    </div>-->
                                    <div class="col-md-11 insert_in">
                                        <label>&nbsp;</label>
                                        <a href="/buses/see_all" class="btn btn-success btn-cons"><?=__("List");?></a>
                                        <a href="/buses/all_schema" class="btn btn-success btn-cons"><?=__("List Scheme");?></a>
                                        <a href="/buses/add" class="btn btn-success btn-cons"><?=__("Create Transport");?></a>
                                        <a href="/buses/save_bus_schema" class="btn btn-success btn-cons"><?=__("Create Scheme");?></a>                
                                    </div>
                                </div>     
                            </form>
                            <p>&nbsp;</p>
                            <div class="clearfix"></div>
                            <div class="search">
                                <table class="table table-striped table-fixed-layout table-hover" id="emails">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th><?=__("Title")?></th>
                                            <th><?=__("Scheme")?></th>
                                            <th><?=__("Description")?></th>
                                            <th><?=__("Actions")?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <? foreach($fiarst as $b){?>
                                            <tr class="">
                                                <td><?=$b['buses_id'];?></td>
                                                <td><?=$b['name_i18n'];?></td>
                                                <td><?=$b['schema_name'];?></td>
                                                <td ><?=$b['description_i18n'];?></td>
                                                <td ><a href="/buses/update_bus?id=<?=$b['buses_id']?>"><i class="fa fa-pencil-square-o m-r-5"></i></a>&nbsp;<a href="/buses/del_bus?id=<?=$b['buses_id']?>"><i class="fa fa-times"></i></a></td>
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
        