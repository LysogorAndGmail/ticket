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
                                      <h3 class="semi-bold h_ped"><?=__("Add Ekipajs")?></h3>
                                           <div class="grid simple ">
                                                <div class="grid-body ">
                                                  <form method="POST">
                                                    <label>Name</label>
                                                    <input type="text" name="name" /><br /><br />
                                                    <label>Ekipaj</label>
                                                    <? $all = DB::select()->from('buses')->join('buses_i18n')->on('buses.buses_id','=','buses_i18n.buses_id')->where('culture','=',$lang)->execute()->as_array(); ?>
                                                    <select name="bus">
                                                    <? foreach($all as $a){?>
                                                    <option value="<?=$a['buses_id'];?>"><?=$a['name_i18n'];?></option>
                                                    <?}?>
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