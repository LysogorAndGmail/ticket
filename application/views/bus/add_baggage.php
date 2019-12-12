<script src="<?=Kohana::$base_url?>/js/ckeditor/ckeditor.js"></script>
<script src="//ckeditor.com/apps/ckeditor/4.3.3/samples/assets/uilanguages/languages.js"></script>


<div class="large-9 medium-9 columns main-content">
    <br />
    <br />
    <div class="padding_center">
        <div class="row">
            <div class="large-12 columns">
                <form method="POST" style="margin: auto; width: 80%;">
                    <input type="text" value="en" />
                    
                    <label><?=__('Title')?></label>
                    <input type="text" name="title" value="" />
                    
                    <label><?=__('Price')?></label>
                    <input type="text" name="price" value="" />
                    <br />
                    <br />
                    <button><?=__('Add')?></button>
                </form>
            </div>    
        </div>
    </div>
</div>