<style>
.one_image {
    float: left; 
    width: 150px; 
    margin-left: 20px;
    text-align: center;
}
.one_image img{
    width: 100px;
    height: 100px;  
}
</style>
<div class="large-9 medium-9 columns main-content">
    <div class="padding_center">
        <div class="row">
            <div class="large-12 columns">
                <a href="#" class="small radius button" data-reveal-id="group_mod">просмореть картинки</a>
                <div id="group_mod" class="reveal-modal" data-reveal>
                    <?php
                        $server = '/var/www/vhosts/svitgo.com/data.svitgo.com';
                        $dir = $server."/img/news_img";
                        $easy_path = 'http://data.svitgo.com/img/news_img';
                        $dh  = opendir($dir);
                        while (false !== ($filename = readdir($dh))) { if(strlen($filename) > 2){?>
                        <div class="one_image" style="float: left; width: 150px; margin-left: 20px;">
                            <img src="<? echo $easy_path.'/'.$filename;?>" />
                            <span><?echo $filename?></span><br />
                            <a href="/news/del_file?name=<?echo $filename?>">Delete</a>
                        </div>
                    <?}}?>
                </div>
                <form method="POST" style="margin: auto; width: 80%;" enctype="multipart/form-data">
                    <label>Иконка:</label>
                    <input type="file" name="icon" />                    
                    <button>Добавить</button>
                </form>
            </div>    
        </div>
    </div>
</div>