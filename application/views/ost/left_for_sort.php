<div class="large-3 medium-3 columns rig_bor">
    <div class="bag_gray">
        <img src="<?=Kohana::$base_url;?>img/menu_left/menu_icon.jpg" width="20" height="16" />
    </div>
    <div class="bag_blugray">
        <a href="/ost" class="radius button <?if($_SERVER['REQUEST_URI'] == '/ost'){ echo 'activs';}?>"><?=__("filter");?></a>
        <a href="/ost/see_all" class="radius button <?if($_SERVER['REQUEST_URI'] == '/ost/see_all'){ echo 'activs';}?>"><?=__("Все");?></a>
        <a href="/ost/add_ost" class="radius button <?if($_SERVER['REQUEST_URI'] == '/ost/add_ost'){ echo 'activs';}?>"><?=__("Добавить остановку");?></a>
    </div>
</div>

<!--
<div class="large-3 medium-3 columns left-bar">
    <div class="row collapse l-smal">
        <label></label>
        <a href="/ost/see_all" class="small radius button">все</a>
    </div>
    <div class="row collapse l-smal">
        <label></label>
        <a href="/ost/add_ost" class="small radius button">Добавить остановку</a>
    </div>
    <div class="row collapse l-smal">
        <label>ID</label>
        <div class="small-9 columns">
            <input type="text" class="ost_id" />
        </div>
    </div>
    <div class="row collapse l-smal">
        <label>Name_i18n</label>
        <div class="small-9 columns">
        <input type="text" class="ost_name" />
        </div>
    </div>
    <div class="row collapse l-smal">
        <label>City_i18n</label>
        <div class="small-9 columns">
        <input type="text" class="ost_city" />
        </div>
    </div>
    <div class="row collapse l-smal">
        <label>Село</label>
        <div class="small-9 columns">
        <input type="text" class="ost_vill" />
        </div>
    </div>
</div>-->