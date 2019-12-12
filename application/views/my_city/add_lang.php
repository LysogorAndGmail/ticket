<script src="<?=Kohana::$base_url?>/js/ckeditor/ckeditor.js"></script>
<script src="//ckeditor.com/apps/ckeditor/4.3.3/samples/assets/uilanguages/languages.js"></script>
<?$lang = Session::instance()->get('leng');
 if(!$lang) {
    $lang = 'EN';
 }
// print_r($countrys);
// die;
?>
<div class="content">    
		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <h3><?=__("Add lang")?></h3>
                            <div class="grid-body no-border email-body col-md-12">
                                    <div class="col-md-6 no-padding">
                                        <br />
                                        <?// print_r($edit_group);?>
                                        <form method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                <label class="form-label"><?=__("City Name fot URL")?></label>
                                                <div class="controls">
                                                <input type="text" name="name" class="form-control" value="" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Title")?></label>
                                                <div class="controls">
                                                <input type="text" name="title" class="form-control" value="" />
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Meta description")?></label>
                                                <div class="controls">
                                                <input type="text" name="meta_description" class="form-control" value="" />
                                                </div>
                                            </div>                                           
                                            <div class="form-group">
                                                <label class="form-label"><?=__("Text")?></label>
                                                <div class="controls">
                                                     <textarea id="text-editor" name="text" placeholder="Enter text ..." class="form-control ckeditor" rows="10"></textarea>
                                                </div>
                                            </div>
                                            
                                            
                                            <div class="form-group">
                                                <label class="form-label"><?=__("City for search-form FROM")?></label>
                                                <div class="controls">
                                                    <input type="text" name="from_search" class="form-control search_city" value="" />
                                                    <div class="search_city_block"></div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><?=__("City for search-form TO")?></label>
                                                <div class="controls">
                                                    <input type="text" name="to_search" class="form-control search_city" value="" />
                                                    <div class="search_city_block"></div>
                                                </div>
                                            </div>  
                                            
                                            
                                             <div class="add_input">
                                                <?foreach($filds as $in){
                                                    $fild_lang = DB::select()->from('my_city_filds_i18n')->where('my_city_filds_i18n.fild_id','=',$in['id'])->and_where('culture','=',$_GET['lang'])->execute()->current();
                                                    ?>
                                                    <div class="alert alert-block alert-error fade in ">
                                                        <div class="col-md-3">                               
                                                            <label><?=__("Title")?></label>
                                                            <div class="controls">
                                                                <input type="text" name="fild_title[]" value="<?=$fild_lang['title'];?>"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2">
                                                        </div>  
                                                        <div class="col-md-7">
                                                            <label>&nbsp;</label>
                                                            <div class="controls">
                                                                <?=$in['icon'].''.$in['title'].''.$in['link'];?>
                                                            </div>
                                                        </div>
                                                        <div class="clearfix">&nbsp;</div>
                                                    </div>
                                                <?}?>
                                            </div>                                                                                                         
                                            <div class="form-group">
                                                <label class="form-label"></label>
                                                <div class="controls">
                                                    <button class="btn btn-primary btn-cons"><?=__("Add Lang")?></button>
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
$('.search_city').keyup(function(){
     var Vall = $(this).val();
     var Block = $(this).next('.search_city_block'); 
        $.ajax({
            url: '/svitgo/ajax_city_my_city',
            type: 'POST',
            data: {val:Vall,lang:'<?=$_GET['lang'];?>'},
            error: function(){
                alert('errror');
            },
            success: function(data) {
              Block.html(data);
            }  
        });
    //}
 })
</script>