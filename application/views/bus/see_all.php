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
                                    <div class="large-12 medium-12  columns insert_in">
                        			    <p>&nbsp;</p>
                                        <table class="table table-striped table-fixed-layout table-hover">
                                            <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th><?=__("Name")?></th>
                                                        <th><?=__("Description")?></th>
                                                        <th><?=__("Actions")?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <? foreach($buses as $b){?>
                                                        <tr class="">
                                                            <td ><?=$b['buses_id'];?></td>
                                                            <td ><?=$b['name_i18n'];?></td>
                                                            <td ><?=$b['description_i18n'];?></td>
                                                            <td><a href="/buses/update_bus?id=<?=$b['buses_id']?>"><i class="fa fa-pencil-square-o m-r-5"></i></a>&nbsp;<a href="/buses/del_bus?id=<?=$b['buses_id']?>"><i class="fa fa-times"></i></a></td>
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