<style>
.error {
    outline: 1px solid red;
}
</style>
<div class="content">    
   	
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->                    
                            <h3 class="semi-bold h_ped"><?=__("edit")?></h3>
                            <div class="col-md-6 no-padding" style="min-height: 850px;">
                                <form method="POST" id="my_validation_discount">
                                    <input type="hidden" name="main_id" value="<?=$main_id;?>" />
                                    <br />
                                    <div class="hide_div">
                                        <ul class="nav nav-tabs" id="tab-01">
                                            <? $i=0; foreach($langs as $lang){?>
                                                <li <? if($i==0){?>class="active" <?}?> ><a href="#panel2-<?=$i;?>"><?=$lang['lang'];?></a></li>
                                            <? $i++;}?>
                                        </ul>
                                        <div class="tab-content">
                                            <? $i=0; foreach($langs as $lang){?>
                                                <div class="tab-pane  <? if($i==0){?>active<?}?>" id="panel2-<?=$i;?>">
                                                   <? $edit = DB::select()->from('seo')->where('main_id','=',$main_id)->and_where('culture','=',$lang['lang'])->execute()->current();?>
                                                   <div class="form-group">
                                                        <label><?=__("URL")?> - <span style="color: red;"><?=$lang['lang'];?></span></label>
                                                        <div class="input-with-icon  right">
                                                            <input name="url[]" type="text" class="form-control" value="<?=$edit['url'];?>"  />
                                                        </div>
                                                    </div>
                                                   <div class="form-group">
                                                        <label><?=__("Title")?></label>
                                                        <div class="input-with-icon  right">
                                                            <input name="title[]" type="text" class="form-control" value="<?=$edit['title'];?>" />
                                                        </div>
                                                   </div>
                                                   <div class="form-group">
                                                        <label><?=__("Description")?></label>
                                                        <div class="input-with-icon  right">
                                                            <input name="desc[]" type="text" class="form-control" value="<?=$edit['desc'];?>" />
                                                        </div>
                                                   </div>
                                                   <div class="form-group">
                                                        <label><?=__("Key")?></label>
                                                        <div class="input-with-icon  right">
                                                            <input name="key[]" type="text" class="form-control" value="<?=$edit['key'];?>"  />
                                                        </div>
                                                   </div>
                                                </div>
                                            <? $i++;}?>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button class="btn btn-success btn-cons"><?=__("Edit")?></button>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end new layaut -->
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
$('.submit_valid').click(function(){
    var chek = 0;
    $('input:text').each(function(){
        if($(this).val().length == 0){
            chek++;
        }
    })
    if(chek != 0){
        $('.tab-content').addClass('error');
        return false;
    }
    //alert(chek);
    
})
</script>

