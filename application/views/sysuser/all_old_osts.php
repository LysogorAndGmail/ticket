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
       <div class=""><h2 class=" inline"><?=__("All Old osts")?></h2></div>
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
                                                <th scope='col'><? echo __('Weight');?></th>
                                                <th scope='col'><? echo __('Regabus');?></th>
                                                <th scope='col'><? echo __('Svitgo');?></th>
                                                <th scope='col'><? echo __('Действие');?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <? foreach($all as $ost) {?>
                                            <tr>
                                                <td class='newspaper-c'><?=$ost['reg_ost_id'];?></td>
                                                <td><?=$ost['weight'];?></td>
                                                <td><?=$ost['reg_name'];?></td>
                                                <td><? $svit_ost = DB::select()->from('regabus_join_osts')->where('reg_ost_id','=',$ost['reg_ost_id'])->execute()->current(); if(empty($svit_ost['svitgo_ost_id'])){ ?>
                                                    <input name="to" value="" class="inputString_to" style="width: 150px;"/><input type="hidden" class="svit_id" value="" />
                                                   <?  }else{  
                                                    $ost_svit = Model::factory('TiketMod')->get_ost($svit_ost['svitgo_ost_id'],$lang); echo $svit_ost['svitgo_ost_id'].' '.$ost_svit['city_i18n'].' '.$ost_svit['name_i18n'];
                                                    } ?><div class="ajax"></div></td>
                                                <td>
                                                    <a href="/sysuser/edit_old_join_ost?id=<?=$ost['id'];?>">Edit OSt</a>&nbsp;
                                                    <a href="/sysuser/del_join_ost?reg_ost_id=<?=$ost['reg_ost_id'];?>">УдалитьОстановку</a>
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


