<div class="large-3 medium-3 columns rig_bor">
    <div class="bag_gray">
        <img src="<?=Kohana::$base_url;?>img/menu_left/menu_icon.jpg" width="20" height="16" />
    </div>
    <div class="bag_blugray">
        <a href="/route/see_all" class="radius button <?if($_SERVER['REQUEST_URI'] == '/route/see_all'){ echo 'activs';}?>">all routes</a>
        <a href="/route" class="radius button <?if($_SERVER['REQUEST_URI'] == '/route'){ echo 'activs';}?>">filter</a>
    </div>
</div>