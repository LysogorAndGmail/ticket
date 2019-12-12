<div class="content">    
		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <div class="grid-body no-border email-body" style="min-height: 850px;">
                            <div class="large-12 medium-12  columns insert_in">
                                      <br />
                                      <h3 class="semi-bold h_ped"><?=__("Ekipajs Persons")?></h3>
                                            <a href="/buses/add_ekipaj_persone" class="btn btn-success btn-cons"><?=__("Add Persone")?></a>
                                           <div class="grid simple ">
                                                <div class="grid-title">
                                                  <h4><?=__("List")?></h4>
                                                  <div class="tools"> <a href="javascript:;" class="collapse"></a> <a href="#grid-config" data-toggle="modal" class="config"></a> <a href="javascript:;" class="reload"></a> <a href="javascript:;" class="remove"></a> </div>
                                                </div>
                                                <div class="grid-body ">
                                                  <form method="POST">
                                                    <label>Name</label>
                                                    <input type="text" name="name" /><br /><br />
                                                    <label>Ekipaj</label>
                                                    <? $ekip = DB::select()->from('ekipaj')->execute()->as_array(); ?>
                                                    <select name="ekipaj">
                                                    <? foreach($ekip as $ek){?>
                                                    <option value="<?=$ek['id'];?>"><?=$ek['name'];?></option>
                                                    <?}?>
                                                    </select>
                                                    <br />
                                                    <br />
                                                    <label>Type</label>
                                                    <select name="type">
                                                        <option value="driver">Driver</option>
                                                        <option value="stuardessa">Stuardessa</option>
                                                    </select>
                                                    <br />
                                                    <br />
                                                    <button>Save</button>
                                                  </form>
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