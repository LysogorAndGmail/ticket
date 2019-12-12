<div class="content">  
	<div class="row" id="inbox-wrapper">
    <div class="col-md-12">
       <div class=""><h2 class=" inline"><?=__("Join Routes")?></h2></div>
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
                                    <a href="/sysuser/all_orl_osts" class="btn"><?=__("All old osts");?></a>
    									<div class="clearfix"></div>
    								</div>
    								<div id="email-list">
                    			    <table class="table table-hover table-condensed" id="example" cellpadding="0" cellspacing="0">
                                        <thead>
                                                <tr>
                                                    <th width="200"><?=__("ID")?></th>
                                                    <th width="200"><?=__("Company")?></th>
                                                    <th width="200"><?=__("Svitgo Route ID")?></th>
                                                    <th width="200"><?=__("Other Route ID")?></th>
                                                    <th width="200"><?=__("Link")?></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <? foreach($keys as $key){?>
                                                    <tr class="">
                                                        <td ><?=$key['id'];?></td>
                                                        <td ><?=$key['company'];?></td>
                                                        <td ><?=$key['svitgo_route_name_id'];?></td>
                                                        <td ><?=$key['reg_route_id'];?></td>
                                                        <td ><a href="/sysuser/see_join_route?join_id=<?=$key['svitgo_route_name_id'];?>"><?=__("See Route Osts")?></a></td>
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