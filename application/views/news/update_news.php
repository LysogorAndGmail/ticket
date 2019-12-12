<script src="<?=Kohana::$base_url?>/js/ckeditor/ckeditor.js"></script>
<script src="//ckeditor.com/apps/ckeditor/4.3.3/samples/assets/uilanguages/languages.js"></script>


<div class="large-9 medium-9 columns main-content">
    <div class="padding_center">
        <div class="row">
            <div class="large-12 columns">
                <form method="POST" style="margin: auto; width: 80%;">
                
                    <input type="hidden" name="id" value="<?=$_GET['id'];?>"/>
                    <input type="hidden" name="lang" value="<?=$_GET['lang'];?>"/>
                    
                    <label>Иконка:</label>
                    <input type="text" name="icon" value="<?=$news['icon'];?>" />
                    <label>Большая картинка:</label>
                    <input type="text" name="big" value="<?=$news['big'];?>" />
                    <label>
                        Alt:
                    </label>
                    <input type="text" name="alt" value="<?=$news['alt'];?>"/>
                    <label>Категория:</label>
                    <select name="cat_id">
                        <? foreach($news_cats as $cat){?>
                        <option value="<?=$cat['cat_id'];?>" <? if($news['cat_id'] == $cat['cat_id']){ echo 'selected="selected"'; }?> ><?=$cat['title'];?></option>
                        <?}?>
                    </select>
                    <label>
                        Заголовок:
                    </label>
                    <input type="text" name="title" value="<?=$news['title'];?>" />
                    <label>
                        Intro:
                    </label>
                    <textarea name="intro" ><?=$news['intro'];?></textarea>
                    <label>
                        Текст:
                    </label>
                    <textarea name="text" class="ckeditor" id="editor1" name="editor1" cols="100" rows="10"><?=$news['text'];?></textarea>
                    <label>
                        Дата:
                    </label>
                    <input type="text" name="news_date" value="<?=$news['news_date'];?>" />
                    
                    <button>Обновить</button>
                </form>
            </div>    
        </div>
    </div>
</div>