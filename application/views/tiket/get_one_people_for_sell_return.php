<style>
.modal-backdrop {
    z-index: 2 !important;
}

.ajax_people_block {
    position: absolute;
    width: 385px;
    z-index:999999;
    box-shadow:  0 2px 4px gray;
    background-color: #fff !important;
}
.ajax_people_block ul{
    padding: 0 !important;
    margin: 0 !important;
}

.ajax_people_block ul li{
    list-style: none;
    display: list-item;
    background-image: none;
    color: #6F7B8A;
    padding-left: 6px;
    line-height: 20px;
    text-align: left;
    background-color: #fff;
    padding: 3px 7px 4px;
    margin: 0;
    cursor: pointer;
    min-height: 1em;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
}

.ajax_people_block ul li:hover{
     background: #0090d9;
    border-radius: 3px;
    color:#fff;
}

.ajax_people_id_block {
    position: absolute;
    width: 500px;
    z-index:999999;
    box-shadow:  0 2px 4px gray;
    background-color: #fff !important;
}
.ajax_people_id_block ul{
    padding: 0 !important;
}

.ajax_people_id_block .on_peo {
    list-style: none;
    display: list-item;
    background-image: none;
    color: #6F7B8A;
    padding-left: 6px;
    line-height: 20px;
    text-align: left;
    background-color: #fff;
    padding: 3px 7px 4px;
    margin: 0;
    cursor: pointer;
    min-height: 1em;
    -webkit-touch-callout: none;
    -webkit-user-select: none;
}

.ajax_people_id_block .on_peo:hover {
    background: #0090d9;
    border-radius: 3px;
    color:#fff;
}
</style>
<? $lang = Session::instance()->get('leng');
     if(!$lang) {
        $lang = 'EN';
     }
 I18n::lang($lang); ?>

<? $sesuser = Session::instance()->get('ses_user');?>


<? $mil_sek = strtotime('now');// echo $mil_sek;?>


<div class="panel panel-default one_people" style="position: relative;">
    <div class="panel-heading ">
        <div class="panel-title">
            <span class="plase badge badge-info"><?=$plase;?></span>
            <span class="info_discounts" ><? if(isset($all_discount_hidden[0])){ echo $all_discount_hidden[0]['name_simple_i18n'];}else{ echo $all_discount[0]['name_simple_i18n']; }?></span>
        </div>
        <div class="panel-controls">
        <div class="btn-group">
                         
                        <!-- <button class="btn btn-success" type="button"><i class="fa fa-pencil"></i></button> -->
                        <? $random = rand(5, 15);?>
                <span style="display: none;" data-toggle="modal" data-target="#my<?=$random;?>" class="edit_cleent btn btn-success"><i title="<?=__('Edit Client')?>" class="fa fa-pencil"></i></span>
                <span class="clear_cleent  btn btn-success" style="cursor: pointer;"><i class="fa fa-undo" title="<?=__('Refresh')?>" ></i></span>
                <span style="cursor: pointer;" class="rem_plase   btn btn-success"><i class="fa fa-trash-o"></i></span>
                <!-- Modal -->
                <div class="modal fade" id="my<?=$random;?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 id="myModalLabel" class="semi-bold"><?=__('Editing of an existing customer')?></h4>
                </div>
                <div class="modal-body">
                <div class="row form-row">
                <input type="hidden" class="cleent_id" />
                <div class="col-md-8">
                <label><?=__('Last Name')?></label>
                <input type="text" class="form-control edit_soname" >
                </div>
                <div class="col-md-8">
                <label><?=__('First Name')?></label>
                <input type="text" class="form-control edit_name" >
                </div>
                <div class="col-md-8">
                <label><?=__('Birth date')?></label>
                <input type="text" class="form-control edit_date" >
                </div>
                <div class="col-md-8">
                <label><?=__('Phone')?></label>
                <input type="text" class="form-control edit_phone" >
                </div>
                <div class="col-md-8">
                <label><?=__('Phone')?></label>
                <input type="text" class="form-control edit_phone2" >
                </div>
                </div>
                </div>
                <div class="modal-footer">
               
                <button type="button" class="btn  btn-success update_cleent_but" data-dismiss="modal"><?=__('Save')?></button>
               
                <button type="button" class="btn btn-default" data-dismiss="modal"><?=__('Close')?></button>
               
                </div>
                </div>
                </div>
                </div>
                <!-- end modal -->
                        </div>
        </div>
    </div>
    <div class="panel-body" >
        <form role="form" class="p-t-10">
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group required">
                        <label><?=__('First Name')?></label>
                        <input type="text" required="" class="soname form-control ajax_tel valid upper " value="<?=$name;?>" />
                        <span class="ajax_people_block"></span>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label><?=__('Last Name')?></label>
                        <input type="text" class="name form-control valid upper" value="<?=$soname;?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="form-group">
                    <label><?=__('Birth date')?></label>
                    <span class="help">"25/12/2013"</span>
                    <input type="text" class="date form-control custom_date valid tip" id="date<?=$mil_sek;?>" title="format 99/99/9999" value="<?=$date;?>" />
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                    <label><?=__('Phone')?></label>
                    <span class="help">"097-07-07-333"</span>
                    <input type="text" class="tel form-control valid" value="<?=$tel;?>" maxlength="13"  />
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label><?=__('Tariff')?></label>
                        <select class="discount_hid form-control" style="display: none;">
                            <? if(is_array($all_discount_hidden)){foreach($all_discount_hidden as $di){?>
                                <option  value="<?=$di['main_id'];?>"><?=$di['name_simple_i18n']?></option>
                            <?}}?>
                        </select>
                        <select class="discount form-control">
                            <option value="1"> - </option>
                            <?if($ferryman_id == 68){?>
                                <option value="54">Взрослый - обратка </option>
                                <option value="19">Студ.29лет - обратка</option>
                                <option value="20">Пенс.60лет - Обратка</option>
                                <option value="23">Дети 12 лет обратка</option>
                            <?}else{ if(is_array($all_discount)){foreach($all_discount as $di){?>
                                <option  value="<?=$di['main_id'];?>"><?=$di['name_simple_i18n']?></option>
                            <?}}}?>
                        </select>                      
                    </div>
                </div>
                
                <input type="hidden" class="main_discount_id" value="1" />
                
                <div class="col-sm-3">
                    <div class="form-group">
                    <label><?=__('Price')?></label><br>
                    <span class="btn btn-default btn-cons m-r-20">
                        <span style="font-size: 18px; font-weight: bold;" class="return_dis_price" ><?=$price;?></span> <?=$valute;?>
                    </span>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>



<script src="<?=Kohana::$base_url?>js/mask.js" type="text/javascript"></script>

<script type="text/javascript">
$('.conform_dis_no').click(function(){
    var Par = $(this).parents('.one_people');
    Par.find('.dis_5_of_10').hide();
})



$('.conform_dis').click(function(){
    /////
    var Par = $(this).parents('.one_people');
    var CurDis = Par.find('.info_discounts_5_10_val').val();
    
    
    var Prise = parseFloat('<?=$price?>');
    
    var PlaseVal = $(this).parents('.one_people').find('.plase').text();
    
    Par.find('.discount_hid option').each(function(){
        $(this).attr('selected',false);
    });
    
    Par.find('.discount_hid option').each(function(){
        if($(this).val() == CurDis){
        
            $(this).attr('selected','selected');
            //alert($(this).val());
            Par.find('.discount_hid').select();
            /////
            var Proc = 0;
            $.ajax({
                type: "POST",
                url: "/discounts/ajax_get_discount",
                data: {dis_id:$(this).val()},
                async: false,
                success: function(data) {
                    //alert(data);
                    Proc = parseFloat(data);
                },
                error:function(code, opt, err){
                    alert("Состояние custom_date length");
                }
            });                
            
            //alert(Par.find('.discount_hid option:selected').text());
            Par.find('.info_discounts').text(Par.find('.discount_hid option:selected').text());
            
            //var PRI = parseFloat($('.al').text());
            var PRiDIS = Prise/100*Proc;
            var NewPriceDIS = Prise - PRiDIS;
            
            $('.return_people .plase').each(function(){
                if($(this).text() == PlaseVal){
                    $(this).next('.dis_price').text(NewPriceDIS.toFixed(2));
                    $(this).parents('.one_people').find('.dis_price_inf').text(NewPriceDIS.toFixed(2));
                }
            })
            //$('.al').text(NewPriceDIS.toFixed(2));
            //alert(NewPriceDIS);
            //RETURNCURPRICEDISC();
            RETURNCURPRICEDISC();
            //exit;
            /////
        }
        
    });
    
    
    Par.find('.dis_5_of_10').hide();
    /////////////////////////////
  
})


$('.update_cleent_but').click(function(){
    var ID = $(this).parents('.modal-content').find('.cleent_id').val();
    var Name = $(this).parents('.modal-content').find('.edit_name').val();
    var Soname = $(this).parents('.modal-content').find('.edit_soname').val();
    var Date = $(this).parents('.modal-content').find('.edit_date').val();
    var Phone = $(this).parents('.modal-content').find('.edit_phone').val();
    var Phone2 = $(this).parents('.modal-content').find('.edit_phone2').val();
    $.ajax({
            type: "POST",
            url: "/sysuser/ajax_update_cleent",
            data: {id:ID,name:Name,soname:Soname,date:Date,phone:Phone,phone2:Phone2},
            async: false,
            success: function(data) {
                //alert(data);
                //Proc = parseFloat(data);
            },
            error:function(code, opt, err){
                alert("Состояние : .discount");
            }
        });    
})
    

$('.discount').change(function(){
        //alert('ok');
        //exit;
        
         
        
        if($(this).val() != ''){
        var Prise = parseFloat('<?=$price?>');
        var PlaseVal = $(this).parents('.one_people').find('.plase').text();
        var Proc = 0;
        var Par = $(this).parents('.one_people');
        $(this).attr('selected','selected');
        
         var Chek_fix = '';
        
        $.ajax({
            type: "POST",
            url: "/discounts/ajax_chek_fixet",
            data: {dis_id:$(this).val(),route_name_id:'<?=$route_name_id;?>'},
            async: false,
            success: function(data) {
                //alert(data);
                //Proc = parseFloat(data);
                //exit;
                Chek_fix = data;
            },
            error:function(code, opt, err){
                alert("Состояние : .discount");
            }
        }); 
        var vall = $(this).val();
        
        if(Chek_fix == 'fix'){
        var fix_price = 0;    
            $.ajax({
                type: "POST",
                url: "/discounts/ajax_get_discount_fix",
                data: {dis_id:$(this).val(),route_name_id:'<?=$route_name_id;?>',valute:'<?=$valute;?>'},
                async: false,
                success: function(data) {
                    //alert(data);
                    //exit;
                    //Proc = parseFloat(data);
                    fix_price = parseFloat(data);
                },
                error:function(code, opt, err){
                    alert("Состояние : ajax_get_discount_fix");
                }
            });     
            
        var NewPriceDIS = fix_price;
        $('.return_people').find('.plase').each(function(){
            if($(this).text() == PlaseVal){
                $(this).next('.return_dis_price').text(NewPriceDIS.toFixed(2));
                $(this).parents('.one_people').find('.return_dis_price').text(NewPriceDIS.toFixed(2));
            }
        })    
            
        }else{
        
        
        
        $.ajax({
            type: "POST",
            url: "/discounts/ajax_get_discount",
            data: {dis_id:$(this).val(),lang:$("#cur_lan").val()},
            async: false,
            success: function(data) {
                var newdate = data.split('#');
                //exit;
                Proc = parseFloat(newdate[0]);
                Par.find('.info_discounts').text(newdate[1]);
                Par.find('.main_discount_id').val(vall);
            },
            error:function(code, opt, err){
                alert("Состояние : .discount");
            }
        });                
        
        //var PRI = parseFloat($('.al').text());
        var PRiDIS = Prise/100*Proc;
        var NewPriceDIS = Prise - PRiDIS;
        $('.return_people').find('.plase').each(function(){
            if($(this).text() == PlaseVal){
                $(this).next('.return_dis_price').text(NewPriceDIS.toFixed(2));
                $(this).parents('.one_people').find('.return_dis_price').text(NewPriceDIS.toFixed(2));
            }
        })
        //$('.al').text(NewPriceDIS.toFixed(2));
        }
        //Par.find('.info_discounts').text($(this).text());
        //Par.find('.info_discounts').text(Par.find('.discount option:selected').text());
        Par.find('.main_discount_id').val(vall);
        //CURPRICEDISC();
        RETURNCURPRICEDISC();
        //alert(NewPrice);
        //RETURNCURPRICEDISC();
        //exit;
        }
    })



$(function($){
   $("#date<?=$mil_sek;?>").mask("99/99/9999");
   $("#phone").mask("(999) 999-99-99");
   $("#phone2").mask("(999) 999-99-99");
   
   $('.valid').focus(function(){
      $(this).removeClass('noValid_empty');
    })

});

$('.clear_cleent').click(function(){
    
    var Parent = $(this).parents('.one_people');
    Parent.find('.soname').val('');
    Parent.find('.name').val('');
    Parent.find('.tel').val('');
    Parent.find('.date').val('');
})


$('.rem_plase_return').click(function(){
    
    var Plase = $(this).parents('.one_people').find('.plase').text();

    //alert($(this).parents('.one_par').find('.return_salon').html());
    //exit;
    
    $(this).parents('.one_par').find('.return_salon').find('.return_choise').each(function(){
        
        //alert($(this).html());
        //exit;
        if($(this).text() == Plase){
            $(this).removeClass('selected_plase');
        }
    });
    $(this).parents('.one_people').remove();
    //RETURNCURPRICEDISC();
    //CURPRICEDISC();
    RETURNCURPRICEDISC();
})
/*
function PeopleCURPRICEDISC(){
    $('.return_al').text(0);
    var Start = 0;
    $('.return_dis_price').each(function(){
        Start += parseFloat($(this).text());
    })
    $('.retun_al').text(Start.toFixed(2));
    $('.top_val').text('<?=$valute;?>');
    
    al_busket();
    //alert('ok');
}
*/
function al_busket(){
    
    $('.al_bascet').text(0);
    var Start = 0;
    //$('.return_dis_price').each(function(){
    Start = parseFloat($('.return_al').html());
    var Start2 = 0;
    //$('.return_dis_price').each(function(){
    Start2 = parseFloat($('.al').html());
    
    var Sums = Start + Start2;
    //alert(Sums);
    $('.al_bascet').text(Math.round(Sums));
}

$('.upper').keyup(function(){
   var Vall = $(this).val();
   if(Vall.length == 1){
    var predlojenie = Vall; 
   var pervayabukva =predlojenie.charAt(0).toLowerCase(); 
   var novaya = predlojenie.charAt(0).toUpperCase(); 
   var predlojenie_new = predlojenie.replace(pervayabukva, novaya); 
   //alert(predlojenie_new);
   $(this).val(''+predlojenie_new);
   }
   
})

</script>
