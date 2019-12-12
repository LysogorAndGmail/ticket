<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js" type="text/javascript"></script>

<div class="col-md-12 no-padding">
    <div class="form-group col-md-1">
        <label><?=__('People:');?></label>
        <select class="ferrymans_open" style="width: 50px !important;">
            <option value=""> - </option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
        </select>
    </div>
</div>
<script type="text/javascript">
$('.ferrymans_open').change(function(){     
        
        var Parr = $(this).parents('.one_par');
        
        //alert(Parr.html());
        //exit;
        ShowAnim();
        //exit;
        var Cou = $(this).val();
        //exit;
        Parr.find('.one_people').each(function(){
            $(this).remove();
        });
        var HTmm = '';//$(this).parents('.parr').find('.peo_after');
        var From = '<?=$from;?>';
        var To = '<?=$to;?>';
        var route = '<?=$route_name_id;?>';
        for(var i=1; i<=Cou; i++){
            $.ajax({
                    type: "POST",
                    url: "/sysuser/ajax_get_one_people_open",
                    data: {route_name_id:route,from:From,to:To,plase:' - ',valute:$('.sell_vall').val(),prior:1},
                    //async: false,
                    success: function(data) {
                        //alert(data);
                        //exit;
                        HTmm = data;
                        $(HTmm).insertAfter(Parr.find('.peo_after'));
                    },
                    error:function(code, opt, err){
                        alert("Состояние ferrymans_open");
                    }
                });
        }
        //$('.animation_ajax').hide();
        //$('.body').show(1000);
        newnew(Cou);
        //exit;
        setTimeout(HideAnimm,500);
        
})
function PeopleCURPRICEDISC(){
    $('.al').html(0);
    var Start = 0;
    $('.people').find('.dis_price').each(function(){
        Start += parseFloat($(this).html());
    })
    //Sums)
    $('.al').text(Math.round(Start));
    $('.top_val').text($('.sell_vall').val());
    
    al_busket();
    //alert(Start);
}

function al_busket(){
    
    $('.al_bascet').text(0);
    var Start = 0;
    //$('.return_dis_price').each(function(){
    Start = parseFloat($('.return_al').text());
    var Start2 = 0;
    //$('.return_dis_price').each(function(){
    Start2 = parseFloat($('.al').text());
    
    var Sums = Start + Start2;
    //alert(Sums);
    $('.al_bascet').text(Math.round(Sums));
}
function ShowAnim(){
    $('.ajax_load').show();
    //$('body').hide(10);
}
function HideAnim(){
    $('.ajax_load').hide();
    //$('body').show(10);
}
function newnew(cou){
    var Couuu = 0;
    $('.people').find('.one_people').each(function(){
        Couuu++;
    })
    if(cou == Couuu){
        HideAnim();
    }
}
setInterval(CheAA,1000);

function CheAA(){
    var Couuu = 0;
    $('.people').find('.one_people').each(function(){
        Couuu++;
    })
    if($('.ferrymans_open').val() == Couuu){
        HideAnim();
        PeopleCURPRICEDISC();
    }
}
</script>