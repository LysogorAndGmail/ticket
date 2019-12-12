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
                            <h3 class="semi-bold h_ped"><?=__("Add news lang")?></h3>
                            <div class="col-md-6 no-padding">
                                <form method="POST" >
                                    <div class="form-group">
                                        <label><?=__("News")?></label>
                                        <select name="news_id" class="form-control">
                                            <? foreach($news as $n){?>
                                            <option value="<?=$n['news_id'];?>"><?=$n['title'];?></option>
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
                                        <label><?=__("Intro")?></label>
                                        <textarea name="intro" class="form-control" ></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label><?=__("Text")?></label>
                                        <textarea name="text" class="ckeditor form-control" id="editor1" name="editor1" cols="100" rows="10"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-salat btn-cons"><?=__("Add")?></button>
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