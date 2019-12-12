<div class="content">    
	
		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <div class="grid-body no-border email-body" style="min-height: 850px;">
                                    <div class="large-12 medium-12  columns insert_in">
                                        <p>&nbsp;</p>
                        			    <a class="btn btn-success" href="/ferryman/add_disck?id=<?=$_GET['id'];?>"><?=__("Add")?></a>
                                        <p>&nbsp;</p>
                                        <table class="table table-striped table-fixed-layout table-hover">
                                            <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th><?=__("Hours")?></th>
                                                        <th><?=__("Percentage")?> (%) </th>
                                                        <th><?=__("Actions")?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <? foreach($dis as $d){?>
                                                        <tr class="">
                                                            <td ><?=$d['id'];?></td>
                                                            <td ><?=$d['hours'];?></td>
                                                            <td ><?=$d['procents'];?></td>
                                                            <td >
                                                                <a href="/ferryman/update_disck?id=<?=$d['id']?>"><i class="fa fa-pencil-square-o m-r-5"></i></a></a>
                                                                &nbsp;<a href="/ferryman/del_disc?id=<?=$d['id']?>"><i class="fa fa-times"></i></a>
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