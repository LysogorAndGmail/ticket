<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js" type="text/javascript"></script>
<style>
#ui-datepicker-div {
top:338px !important;
left:432px!important;
z-index: 99999;
width: 290px !important;
}
.ui-datepicker-group {
    width: 250px !important;
    float: left;
    margin: 10px 15px;
}
.dis {
    top:24px;
    left: -65px;
}

.ajax_people_block .on_peo {
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

.ajax_people_block .on_peo:hover {
    background: #0090d9;
    border-radius: 3px;
    color:#fff;
}

.ajax_people_block {
    position: absolute;
    width: 500px;
    z-index:999999;
    left:-35px;
    box-shadow:  0 2px 4px gray;
    background-color: #fff !important;
}
.ajax_people_block ul{
    padding: 0 !important;
}
</style>
<?
$sesuser = Session::instance()->get('ses_user');
if(isset($sesuser[0])){
    $user_id = $sesuser[0]['id'];
    $ses_valute = $sesuser[0]['default_valute'];
}else{
    $user_id = 0;
    $ses_valute = 'EUR';
}
//$price = DB::select()->from('routeprice')->where('route_name_id','=',$_POST['route_name_id'])->and_where('route_city_from_id','=',$_POST['from'])->and_where('route_city_to_id','=',$_POST['to'])->execute()->current();
///$price = $price['price'];
//print_r($price);
?>
<div class="col-md-12 no-padding">
    <div class="form-group col-md-1">
        <label><?=__('Ferrymans:');?></label>
        <select class="ferrymans_open">
            <option value=""> - </option>
            <?foreach($new_f as $f=>$n){?>
            <option value="<?=$f;?>"><?=$n;?></option>
            <?}?>
        </select>
    </div>
    <div class="form-group col-md-2 dis" style="position: relative;">
        <input name="desc_i18n" id="datepicker_open" type="text" class="filds-ost-desc form-control"   value="<?=__("Date Depart")?>" />
    </div>
</div>
<script type="text/javascript">
$('.ferrymans_open').change(function(){     
        
        $('.one_people').each(function(){
            $(this).remove();
        });
        var HTmm = '';
        var From = $('.from_sel').val();
        var To = $('.to_sel').val();
        var route = $('.route_name_main').val();
        $.ajax({
                type: "POST",
                url: "/tiket/ajax_get_one_people_open",
                data: {route_name_id:route,from:From,to:To,plase:' - ',ferryman_id:$(this).val(),valute:'<?=$ses_valute?>'},
                async: false,
                success: function(data) {
                    //alert(data);
                    HTmm = data;
                    $(HTmm).insertAfter('.peo_after');
                },
                error:function(code, opt, err){
                    alert("Состояние choise 2");
                }
            });
        
        //$('#datepicker_open').focus();
        //$(this).focus();
        GetFerDat($(this).val());
        $('#open_tik').show();
        $('.bottom_block_sell').show();
        
        
        $('.ajax_tel').keyup(function(){
            //alert('oj');
            var Blo = $(this);
            $.ajax({
                type: "POST",
                url: "/tiket/ajax_get_people",
                data: {tel:$(this).val()},
                async: false,
                success: function(data) {
                    //alert(data);
                    //Proc = parseFloat(data);
                    Blo.next('.ajax_people_block').html(data);
                },
                error:function(code, opt, err){
                    //alert("Состояние ajax_tel");
                }
            });
        })
        
        $('.ajax_cl_id').keyup(function(){
            //alert('oj');
            var Blo = $(this);
            $.ajax({
                type: "POST",
                url: "/tiket/ajax_get_cl_id",
                data: {id:$(this).val(),fer:$('.ferryman').val()},
                async: false,
                success: function(data) {
                    //alert(data);
                    //Proc = parseFloat(data);
                    Blo.next('.ajax_people_id_block').html(data);
                },
                error:function(code, opt, err){
                    //alert("Состояние ajax_cl_id");
                }
            });
        })
        
})
$("#datepicker_open").datepicker({
    <? Model::factory('TiketMod')->dataciper(I18n::lang());?>
    minDate:new Date(),
    dateFormat: "dd/mm/y",
    altField: "#actualDate",
    numberOfMonths: 3,
    firstDay:1,
    //showOtherMonths: true,
    selectOtherMonths: true,
    onSelect: function (dateText, inst) {        
     ///////////  depart 
    },
    }); 
    
    
    
    
     
function GetFerDat(fer){
    $('.ui-datepicker-group a').removeClass('ui-state-active');
    var RouteNameID = $('.route_name_main').val();
    var Artex = ''; 
     $.ajax({
            type: "POST",
            url: "/route/ajax_fer_dates_only_open",
            data: {route_name_id:RouteNameID,fer:fer},
            async: false,
            success: function(data) {
                
                Artex = data;
            },
            error:function(){
                //alert('ошибка записи step_3');
            }
            
       });
       
       var arr = Artex.split(',');
    $('.ui-datepicker-group a').each(function(){
        var textT = $(this).text();
        if(textT.length == 1){
            textT = '0'+textT;
        }
        var HTMLL = $(this);
        var mons = $(this).parent().data('month');
            mons += 1;
            mons = '0'+mons;
        if(mons == '010'){
            mons = '10';
        }
        if(mons == '011'){
            mons = '11';
        }
        if(mons == '012'){
            mons = '12';
        } 
        var earT = $(this).parent().data('year');
        var Full = earT+'-'+mons+'-'+textT;
        //alert(Full);
        //alert(arr[0]);
        //exit;
        for(var st = 0; st<=arr.length; st++){
            if(arr[st] == Full){
                HTMLL.addClass('ui-state-active');
            }
        }
        //alert(Full);
        //exit;
    })
}  





</script>