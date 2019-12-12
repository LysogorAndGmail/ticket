<?

$lang = Session::instance()->get('leng');
        if(!$lang) {
            $lang = 'EN';
        } 
 ?>
<div class="content">    
		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <div class="grid-body no-border email-body" style="min-height: 850px;">
                            <div class="large-12 medium-12  columns insert_in">
                                      <br />
                                      <h3 class="semi-bold h_ped"><?=__("Ekipajs")?></h3>
                                            <a href="/buses/add_new_ekipaj" class="btn btn-success btn-cons"><?=__("Add")?></a>
                                           <div class="grid simple ">
                                                <div class="grid-title">
                                                  <h4><?=__("List")?></h4>
                                                  <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="#grid-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
                                                </div>
                                                <div class="grid-body ">
                                                  <table class="table table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>ID</th>
                                                        <th><?=__("Name")?></th>
                                                        <th><?=__("Bus")?></th>
                                                        <th><?=__("Action")?></th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                      <? foreach($all as $dis){?>
                                                        <tr class="">
                                                            <td><?=$dis['id'];?></td>
                                                            <td><?=$dis['name'];?></td>
                                                            <td><? $bus = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('buses.buses_id','=',$dis['bus_id'])->and_where('culture','=',$lang)->execute()->current(); echo $bus['name_i18n'];?></td>
                                                            <td><a href="/buses/dell_ekipaj?id=<?=$dis['id'];?>"><?=__('Delete');?></a></td>
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
 <div class="clearfix"></div>
  </div>
  
<script type="text/javascript">
$('.save_ferrss').click(function(){
    var Ferss = [];
    $(this).parents('.modal').find('.ferryss:checked').each(function(){
        Ferss.push($(this).val());
    })
    $.ajax({
        type: "POST",
        url: "/discounts/ajax_add_fers_discouns",
        data: {id:$(this).parents('.modal').find('.main_id').val(),old_fer_id:$(this).parents('.modal').find('.dis_fer_old').val(),fers:Ferss},
        success: function(data) {
            //alert(data);
            location="/discounts";
        },
        error:function(code, opt, err){
                alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
   });
})


/* Formating function for row details */
function fnFormatDetails ( oTable, nTr ){
    var aData = oTable.fnGetData( nTr );
    var sOut = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;" class="inner-table">';
    sOut += '<tr><td>Language:</td><td>'+aData[9]+' '+aData[10]+' '+aData[11]+' '+aData[12]+'</td></tr>';
    sOut += '</table>';
     
    return sOut;
}

</script> 

<? include_once('js/mytables_i18n.php');?>
