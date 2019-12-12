<div class="content">  
	<div class="row" id="inbox-wrapper">
    <div class="col-md-12">
       <div class=""><h2 class=" inline"><?=__("Edit Api Key")?></h2></div>
    </div>
    </div>
</div>
<div class="content"> 
	<div class="row" id="inbox-wrapper">
		<div class="col-md-12">
			<div class="row">
				<div class="col-md-12">
					 <div class="">
						<div class="grid-body no-border email-body col-md-6" style="min-height: 850px;">
    						<form method="POST">
                                <div class="form-group">
                                    <label class="form-label"><? echo __('Compamy');?></label>
                                    <div class="controls">
                                        <input name="company" type="text"  value="<?=$edit['company'];?>" class="form-control" />
                                    </div>
                                </div>
                                <div class="form-group">
                                <label class="form-label"><? echo __('See plase');?></label>
                                <div class="radio">
                                    <input name="see_plase" type="radio"  id="male" value="1" <? if($edit['see_plase'] == 1){ echo 'checked="checked"'; }?>  />
                                    <label for="male"><? echo __('Yes');?></label>
                                    <input id="female" name="see_plase" type="radio"  value="0" <? if($edit['see_plase'] == 0){ echo 'checked="checked"'; }?>  />
                                    <label for="female"><? echo __('No');?></label>
                                </div>
                            </div>
                            
                                <div class="controls">
                                    <select name="group" class="group form-control">
                                        <? foreach($groups as $g){?>
                                        <option value="<?=$g['id']?>" <?if($g['id'] == $edit['group_id']){?>selected="selected"<?}?>><?=$g['name']?></option>
                                        <?}?>
                                    </select>
                                </div>
                                <br />
                                <div class="controls">
                                    <select name="sysuser" class="group form-control">
                                        <? foreach($sysusers as $s){?>
                                        <option value="<?=$s['id']?>" <?if($s['id'] == $edit['sysuser_id']){?>selected="selected"<?}?> ><?=$s['login']?></option>
                                        <?}?>
                                    </select>
                                </div>
                                <br />
                                <button class="btn btn-default"><?=__("Edit")?></button>
                            </form>
                        </div>
                     </div>
                </div>
            </div>
       </div>
    </div>
</div>