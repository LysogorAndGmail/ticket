<div class="large-9 medium-9 columns main-content">
    <div class="padding_center">
        <div class="row">
            <div class="large-12 columns">
                
                <form method="POST" style="margin: auto; width: 80%;">
                    <p><?=$rou['name_i18n'];?></p>
                    <input type="hidden" name="id" value="<?=$_GET['id'];?>" />
                    <label>Язык:</label>
                    <select name="culture">
                        <? foreach($langvige as $l){?>
                        <option value="<?=$l['culture'];?>"><?=$l['name'];?></option>
                        <?}?>
                    </select>
                    <label>
                        Название:
                    </label>
                    <input type="text" name="name_i18n" />
                    <button>Добавить</button>
                </form>
            </div>    
        </div>
    </div>
</div>