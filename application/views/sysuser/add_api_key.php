<div class="content">  
	<div class="row" id="inbox-wrapper">
    <div class="col-md-12">
       <div class=""><h2 class=" inline"><?=__("Add Api Key")?></h2></div>
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
                                        <input name="company" type="text"  value="" class="form-control" />
                                    </div>
                                </div>
                                <div class="controls">
                                    <select name="group" class="group form-control">
                                        <? foreach($groups as $g){?>
                                        <option value="<?=$g['id']?>"><?=$g['name']?></option>
                                        <?}?>
                                    </select>
                                </div>
                                <br />
                                <div class="controls">
                                    <select name="sysuser" class="group form-control">
                                        <? foreach($sysusers as $s){?>
                                        <option value="<?=$s['id']?>"><?=$s['login']?></option>
                                        <?}?>
                                    </select>
                                </div>
                                <br />
                                <button class="btn btn-default"><?=__("Add")?></button>
                            </form>
                        </div>
                     </div>
                </div>
            </div>
       </div>
    </div>
</div>