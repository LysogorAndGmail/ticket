<script src="<?=Kohana::$base_url?>/js/ckeditor/ckeditor.js"></script>
<script src="//ckeditor.com/apps/ckeditor/4.3.3/samples/assets/uilanguages/languages.js"></script>
<div class="content">    
    <div class="page-title">
        <h3><?=__("Add Article")?></h3>
    </div>
    <!-- BEGIN BASIC FORM ELEMENTS-->
    <div class="row">
        <div class="col-md-12">
            <div class="grid simple">
                <div class="grid-title no-border">
                    <ul class="breadcrumb">
                        <li><a href="/post" class="link"><?=__("Articles")?></a> </li>
                        <li><span href="#" class="active"><?=__("Add Article")?></span> </li>
                    </ul>
                </div>
                <div class="grid-body no-border"> <br />
                    <div class="row">
                        <div class="col-md-8 col-sm-8 col-xs-8">
                            <form method="POST" >
                                <div class="form-group">
                                    <label class="form-label"><?=__('Paretn Sysuser')?></label>
                                    <div class="controls">
                                        <select name="sys_id">
                                            <? foreach($all_parents as $sys){?>
                                                <option value="<?=$sys['id'];?>"><?=$sys['login'];?></option>
                                            <?}?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label"><?=__('Title')?></label>
                                    <div class="controls">
                                        <input type="text" name="article_title" value=""  class="form-control"/>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label><?=__('Text')?></label>
                                    <div class="controls">
                                        <textarea name="article_text" class="ckeditor" id="editor1" name="editor1" cols="100" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="controls">
                                        <input type="submit" class="btn btn-success btn-cons" value="<?=__('Add')?>" />
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END BASIC FORM ELEMENTS-->	 
</div><!--Content div-->