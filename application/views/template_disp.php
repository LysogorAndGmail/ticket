<? $lang = Session::instance()->get('leng');
     if(!$lang) {
        $lang = 'EN';
     }
 I18n::lang($lang); ?>
<!doctype html>
<html>
    <?=$top_head_admin;?>
    <body>
        <div class="ajax_load">
            <div class="ajax_load_bagraunt">    
            </div>
            <div class="ajax_load_info">
                <div class="load-container load8" style="border: none !important;"><div class="loader">Loading...</div></div>
            </div>
        </div>
        <div class="container">
            <?=$header_admin;?>
        </div>
    
        <div class="section first">
                <?=$content_admin;?> 
       </div>
     
        <?=$footer;?> 
    </body>
</html>