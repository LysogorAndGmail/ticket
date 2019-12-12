<style>
.ajax {
    position: absolute;
    background-color: #e5e5e5;
    
}
.ajax ul{
    padding: 10px;
}
.ajax ul li{
    cursor: pointer;
}
</style>
<?
    $lang = Session::instance()->get('leng');
    if(!$lang) {
        $lang = 'EN';
    } 
    
    //echo '<pre>';
    //print_r($keys);
    //echo '</pre>';
    
    
?>
<div class="content">  
	<div class="row" id="inbox-wrapper">
    <div class="col-md-12">
       <div class=""><h2 class=" inline"><?=__("all Join Osts")?></h2></div>
    </div>
    </div>
</div>
<div class="content"> 
		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="">
							<div class="grid-body no-border email-body" style="min-height: 850px;">
    							     <br/>
    							 <div class="row-fluid">
    							 <div class="row-fluid dataTables_wrapper">
                                       
    									<div class="clearfix"></div>
							     </div>
    								<div id="email-list">
                    			    <table class="table table-hover table-condensed" >
                                        <thead>
                                            <tr class='nohover'>
                                                <th scope='col' class="first"><?=__("ID")?></th>
                                                <th scope='col' class="first"><?=__("Join ost ID")?></th>
                                                <th scope='col' class="first"><?=__("OST name")?></th>
                                                <th scope='col' class="first"><?=__("Svitgo OST name")?></th>
                                                <th><?=__('Join Route')?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <? foreach($keys as $ost) {?>
                                            <tr>
                                                <td class='newspaper-c'><?=$ost['id'];?></td>
                                                <td class='newspaper-c'><?=$ost['reg_ost_id'];?></td>
                                                <td class='newspaper-c'><?=$ost['reg_name'];?></td>
                                                <td class='newspaper-c'><? $svitgo_ost = DB::select()->from('regabus_join_osts')->where('reg_ost_id','=',$ost['reg_ost_id'])->execute()->current(); echo $svitgo_ost['svitgo_ost_id'];?></td>
                                                <td class='newspaper-c'><?=$ost['join_route'];?></td>
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
    </div>
</div>
<script type="text/javascript">
$('.ajax_join_but').click(function(){
    $.ajax({
        type: "POST",
        url: "/sysuser/add_join_route_ost",
        data: {id:$(this).data('id'),val:$(this).prev('.ajax_join_route').val()},
        success: function( data ) {
            //alert(data);
            //exit;
            //if(data == 'ok'){
                //location="/adminRoute/regabus_osts";
                
                location="/sysuser/see_all_join_osts";
            //}
        },
        error:function(code, opt, err){
            alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
    });
    //alert();
})



function join_rega(regaID){
    
    $('<div style="padding:20px;" class="pr"></div>').dialog({
            modal: true,
			resizable: false,
            open: function () {
                $(this).html('<div class="gh" style="padding-bottom:20px;"></div><div><span class="reg_id">'+regaID+'</span><input name="to" value="<? echo __('Куда');?>" class="inputString_to"  class="route_input_to from-to extrafild"/><input type="text" class="svitgo_id" value="" /><button onclick="save_reg_join('+regaID+',$(this).prev(\'.svitgo_id\').val())">Связать</button><div><div class="clearfix"></div>');
            },
            close: function(event, ui) {
                    $(this).remove();
                    $('.m-r-a-p, .m-t-price').show();
                },
          //  height: 500,
            width: 990,
            title: '<? echo __('Отправить');?>'
        });
}

function save_reg_join(reg_id,svitgo_id) {
    //alert(reg_id);
    //exit;
    $.ajax({
        type: "POST",
        url: "/sysuser/join_reg_ost",
        data: {reg_id:reg_id,svitgo_id:svitgo_id},
        success: function( data ) {
            //alert(data);
            //exit;
            //if(data == 'ok'){
                //location="/adminRoute/regabus_osts";
                
                //location="/sysuser/see_join_route?join_id=";
            //}
        },
        error:function(code, opt, err){
            alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
    });
}
$( ".inputString_to" ).keyup(function(){
    var IMP = $(this).parent('td');
    $.ajax({
        type: "POST",
        url: "/sysuser/auto_new_POST",
        data: {val:$(this).val(),lang:"RU"},
        success: function(data) {
            //if(data == 'ok'){
            //    location='/pay/see_bus_schema';
            //}
            //alert(data);
            IMP.find('.ajax').html(data);
        },
        error:function(){
            alert('ошибка bus_step');
        }
    });
})
</script>


