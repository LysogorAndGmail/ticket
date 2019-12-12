<div class="content">  
	<div class="row" id="inbox-wrapper">
    <div class="col-md-12">
       <div class=""><h2 class=" inline"><?=__("Api Keys")?></h2></div>
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
                                        <a class="btn btn-danger" href="/sysuser/add_api_key"><?=__("Add")?></a>
    									<div class="clearfix"></div>
    								</div>
    								<div id="email-list">
                    			    <table class="table table-hover table-condensed" id="example" cellpadding="0" cellspacing="0">
                                        <thead>
                                                <tr>
                                                    <th width="200"><?=__("ID")?></th>
                                                    <th width="200"><?=__("Company")?></th>
                                                    <th width="200"><?=__("User")?></th>
                                                    <th width="200"><?=__("Key")?></th>
                                                    <th width="200"><?=__("See plase")?></th>
                                                    <th><?=__("Count Query")?></th>
                                                    <th><?=__("Action")?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <? foreach($keys as $key){?>
                                                    <tr class="">
                                                        <td ><?=$key['id'];?></td>
                                                        <td ><?=$key['company'];?></td>
                                                        <td ><? $sys = DB::select()->from('system_users')->where('id','=',$key['sysuser_id'])->execute()->current(); echo $sys['login'];?></td>
                                                        <td ><?=$key['key'];?></td>
                                                        <td ><?=$key['see_plase'];?></td>
                                                        <td ><?=$key['count_query'];?></td>
                                                        <td >
                                                            <a href="/sysuser/edit_api_key?id=<?=$key['id'];?>"><i class="fa fa-edit"></i></a>&nbsp;
                                                            <a class="shure" href="/sysuser/delete_api_key?id=<?=$key['id'];?>"><i class="fa fa-times"></i></a>
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
    </div>
</div>