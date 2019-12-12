<div class="large-9 medium-9 columns main-content">
    <div class="padding_center">
        <div class="row">
            <div class="large-12 columns">
                <form method="POST" style="margin: auto; width: 80%;">
                    <input type="hidden" name="id" value="<?=$_GET['id'];?>" />
                    <input type="hidden" name="culture" value="<?=$_GET['lang'];?>" />
                    <label>
                        Название: - <?=$_GET['lang'];?>
                    </label>
                    <input type="text" name="name_i18n" value="<?=$rou['name_i18n'];?>" />
                    <button>Редактировать</button>
                </form>
            </div>    
        </div>
    </div>
</div>