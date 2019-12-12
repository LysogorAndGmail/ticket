<style>
.write div.cc {
    width: 20px;
    height: 20px;
    outline: 1px solid black;
    float: left;
}
.write div.rr {
    width: 100%;
    clear: both;
}
.write div.blu {
    background-color: #1da0db;
}
.one_scem {
}
.one_row {
    clear: both;
}
div.cc {
    width: 20px;
    height: 20px;
    outline: 1px solid black;
    float: left;
    text-align: center;
}
div.blu {
    background-color: #1da0db;
}
</style>
<div class="content">    
  	
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white --> 
                        <h3 class="semi-bold h_ped"><?=__("Create Transport")?></h3>
                        <div class="padding_center">
                                <div class="col-md-6">
                                    <div class="row">
                                    
    <form id="add_material" action="" method="post" >
    <ul class="nav nav-tabs" id="tab-01">
        <li class="active" ><a href="#panel2-1">RU</a></li>
        <li><a href="#panel2-2">UA</a></li>
        <li><a href="#panel2-3">EN</a></li>
        <li><a href="#panel2-4">CS</a></li>
    </ul>
    <br />
    <div class="tab-content">
        <div class="form-group">
            <label><? echo __('Ferryman');?></label>
            <select name="ferryman" class="ferreman form-control">
                <? foreach($all_ferrymans as $f){?>
                    <option value="<?=$f['ferryman_id'];?>"><?=$f['name'];?></option>
                <?}?>
            </select>
        </div>
        <div class="tab-pane active" id="panel2-1">
                <div class="form-group">
                    <label><? echo __('Name');?></label>
                    <input name="name_i18n" type="text" class="filds-ost-name name form-control"  value="" placeholder="ru" />
                </div>
                <div class="form-group">
                    <label><? echo __('Description');?></label>
                    <input name="desc_i18n" type="text" class="filds-ost-desc form-control"   value="" />
                </div>         
            </div>
            <div class="tab-pane" id="panel2-2">
                <div class="form-group">
                    <label><? echo __('Name');?></label>
                    <input name="name_i18n_ua" type="text" class="filds-ost-name name form-control"  value=""  placeholder="ua"/>
                    
                </div>
                <div class="form-group">
                    <label><? echo __('Description');?></label>
                    <input name="desc_i18n_ua" type="text" class="filds-ost-desc form-control"   value="" />
                    
                </div>       
            </div>
            <div class="tab-pane" id="panel2-3">
                <div class="form-group">
                    <label><? echo __('Name');?></label>
                    <input name="name_i18n_en" type="text" class="filds-ost-name name form-control"  value="" placeholder="en" />
                    
                </div>
                <div class="form-group">
                    <label><? echo __('Description');?></label>
                    <input name="desc_i18n_en" type="text" class="filds-ost-desc form-control"   value="" />
                    
                </div>             
            </div>
            <div class="tab-pane" id="panel2-4">
                <div class="form-group">
                    <label><? echo __('Name');?></label>
                    <input name="name_i18n_cs" type="text" class="filds-ost-name name form-control"  value="" placeholder="cs" />
                    
                </div>
                <div class="form-group">
                    <label><? echo __('Description');?></label>
                    <input name="desc_i18n_cs" type="text" class="filds-ost-desc form-control"   value="" />
                    
                </div>           
            </div>
            <div class="form-group">
                <label><?=__("Type")?></label>
                <select name="buses_type_id" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>
            <div class="form-group">
                <label><?=__("Scheme")?></label>
                <select name="schema_name" class="schema_name form-control">
                    <? foreach($all_schema as $name=>$n){?>
                    <option value="<?=$name;?>"><?=$name;?></option>
                    <?}?>
                </select>
            </div>
            <div class="col-md-12 no-padding">   
                <button id="admin_login_submit" type="submit" class="btm-edit btn btn-success btn-cons"><?=__("Add")?></button>  
            </div>
        </div>
    </form>
</div>
    </div>  
    <div class="col-md-6">
        <div class="col-md-6">
        <div class="see">
            <? foreach($start_schema as $name=>$aa){ ?>
            <div class="one_scem medium-2 columns">
                <h4><?=$name;?></h4>
                <? foreach($aa as $x=>$ax){?>
                <div class="one_row">
                    <? foreach($ax as $y=>$ay){ ?>
                        <div class="cc <? if(!empty($ay['value']) && $ay['value'] != "sw" && $ay['value'] != "pr" && $ay['value'] != "st"){ echo "blu"; }?>"><?=$ay['value'];?></div>
                    <?}?>
                </div>
                <?}?>
                <div class="clearfix"></div>
                <br />
            </div>
            <? } ?>
         </div>
         </div>
    </div>
    </div>
                        </div> <!-- end new layaut -->
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
$('.schema_name').change(function(){
    //alert($(this).val());
    //exit;
    $.ajax({
        type: "POST",
        url: "/buses/ajax_see_schema",
        data: {name:$(this).val()},
        success: function(data) {
            $('.see').html(data);
        },
        error:function(){
            alert('ошибка записи step_3');
        }
   });
})
</script>













