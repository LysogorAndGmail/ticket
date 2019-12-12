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
    
    
    
    
?>
<div class="content">  
	<div class="row" id="inbox-wrapper">
    <div class="col-md-12">
       <div class=""><h2 class=" inline"><?=__("Orders")?></h2></div>
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
                                                <th scope='col'><?=__("tikets")?></th>
                                                <th scope='col'><?=__("status")?></th>
                                                <th scope='col'><? echo __('name');?></th>
                                                <th scope='col'><? echo __('soname');?></th>
                                                <th scope='col'><? echo __('email');?></th>
                                                <th scope='col'><? echo __('date');?></th>
                                                <th scope='col'><? echo __('valute');?></th>
                                                <th scope='col'><? echo __('pincod');?></th>
                                                <th scope='col'><? echo __('full_price');?></th>
                                                <th scope='col'><? echo __('sysuser_id');?></th>
                                                <th scope='col'><? echo __('pay_id');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <? foreach($orders as $ost) {?>
                                            <tr>
                                                <td class='newspaper-c'><?=$ost['id'];?></td>
                                                <td class='newspaper-c'><?=$ost['tikets'];?></td>
                                                <td class='newspaper-c'><?=$ost['status'];?></td>
                                                <td class='newspaper-c'><?=$ost['name'];?></td>
                                                <td class='newspaper-c'><?=$ost['soname'];?></td>
                                                <td class='newspaper-c'><input type="text" class="svit_id" value="<?=$ost['email'];?>" /><button onclick="send_retry('<?=$ost['id'];?>',$(this).prev('.svit_id').val())" class="btn btn-danger"><?=__('Send retry')?></button></td>
                                                <td class='newspaper-c'><?=$ost['date'];?></td>
                                                <td class='newspaper-c'><?=$ost['valute'];?></td>
                                                <td class='newspaper-c'><?=$ost['pincod'];?></td>
                                                <td class='newspaper-c'><?=$ost['full_price'];?></td>
                                                <td class='newspaper-c'><?=$ost['sysuser_id'];?></td>
                                                <td class='newspaper-c'><?=$ost['pay_id'];?></td>
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

function send_retry(order_id,email) {
    //alert(reg_id);
    //exit;
    $.ajax({
        type: "POST",
        url: "/sysuser/ajax_send_retry_order",
        data: {id:order_id,email:email},
        success: function( data ) {
            alert(data);
            exit;
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
</script>


