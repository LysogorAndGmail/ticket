<?$lang = Session::instance()->get('leng');
 if(!$lang) {
    $lang = 'EN';
 }
// print_r($countrys);
// die;
?>
<style>
.no_valid {
    outline: 1px solid red !important;
}
</style>
<div class="content">    
		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <div class="grid-body no-border email-body col-md-12">
                                    <div class="col-md-6 no-padding">
                                        <br />
                                        <?// print_r($edit_group);?>
                                        <form method="post" enctype="multipart/form-data" class="form_add">
                                             <?$contrys = DB::select()->from('language')->execute()->as_array();?>
                                            
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Weight")?></label>
                                                <div class="controls">
                                                <input type="text" name="weight" class="form-control" value="<?=$edit_weight['weight'];?>" />
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Questions")?></label>
                                                <div class="controls">
                                                     <textarea name="text"  class="form-control" rows="10"><?=$edit['text'];?></textarea>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Answer")?></label>
                                                <div class="controls">
                                                     <textarea name="text2"  class="form-control" rows="10"><?=$edit['text2'];?></textarea>
                                                </div>
                                            </div> 
                                                                                                                                                   
                                            <div class="form-group">
                                                <label class="form-label"></label>
                                                <div class="controls">
                                                    <button class="btn btn-primary btn-cons add_button"><?=__("Add")?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                           </div>	
						</div>
					</div>
				</div>	
		</div>
 <div class="clearfix"></div>
  </div>
 
<script type="text/javascript">

</script>