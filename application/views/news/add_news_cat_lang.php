<div class="content">    
    <div class="page-title" > <a href="/" id="btn-back"><i class="icon-custom-left"></i></a>
       <h3><?=__("Back")?> - <span class="semi-bold"><?=__("Index")?></span></h3>
    </div>		
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->                    
                            <h3 class="semi-bold h_ped"><?=__("Add news cat lang")?></h3>
                            <div class="col-md-6 no-padding" style="min-height: 850px;">
                                <div class="form-group">
                                    <label><?=__("Category")?></label>
                                    <select name="cat_id" class="form-control">
                                        <? foreach($news_cats as $cat){?>
                                        <option value="<?=$cat['cat_id'];?>"><?=$cat['title'];?></option>
                                        <?}?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?=__("Lang")?></label>
                                    <select name="culture" class="form-control">
                                        <? foreach($langvige as $l){?>
                                        <option value="<?=$l['culture'];?>"><?=$l['name'];?></option>
                                        <?}?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label><?=__("Title")?></label>
                                    <input type="text" name="title" class="form-control" />
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success btn-cons"><?=__("Add")?></button>
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