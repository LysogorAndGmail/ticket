<script src="<?=Kohana::$base_url?>/js/ckeditor/ckeditor.js"></script>
<script src="//ckeditor.com/apps/ckeditor/4.3.3/samples/assets/uilanguages/languages.js"></script>

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
                            <h3 class="semi-bold h_ped"><?=__("Add news")?></h3>
                            <div class="col-md-6 no-padding" style="min-height: 850px;">
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label><?=__("Icon")?></label>
                                        <input type="file" name="icon" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label><?=__("Big Icon")?></label>
                                        <input type="file" name="big" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label><?=__("Alt")?></label>
                                        <input type="text" name="alt" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label><?=__("Category")?></label>
                                        <select name="cat_id" class="form-control">
                                            <? foreach($news_cats as $cat){?>
                                            <option value="<?=$cat['cat_id'];?>"><?=$cat['title'];?></option>
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
                                        <label><?=__("Date")?></label>
                                        <div class="time_time input-append success date no-padding" style="width: 95%;">
                                            <input type="text" name="news_date" id="time_end" class="form-control" value="" />
                                            <span class="add-on"><span class="arrow"></span><i class="fa fa-th"></i></span>
                                        </div>
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