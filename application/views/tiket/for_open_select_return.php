<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js" type="text/javascript"></script>

<div class="col-md-12 no-padding">
    <div class="form-group col-md-1">
        <label><?=__('People:');?></label>
        <select class="ferrymans_open_return" style="width: 50px !important;">
            <option value=""> </option>
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
var Prise = parseFloat('<?=$price?>');
            
//       Prise = Math.round(Prise);
       
     ///  alert(Prise);



//PeopleCURPRICEDISCRet();
//Insert_FIARST_people();

$('.ferrymans_open_return').change(function(){      
        
        $('.f_but').css('visibility','hidden');
        
        ShowAnim();
        
        var Parr = $(this).parents('.one_par');
        //alert(Parr.html());
        
        //exit;
        var Cou = $(this).val();
        //exit;
        $('.return_people').find('.one_people').each(function(){
            $(this).remove();
        });
        
        
        var HTmm = '';
        var From = $('.return_from_sel').val();
        var To = $('.return_to_sel').val();
        var route = $('.return_route_name_main').val();        
        for(var i=1; i<=Cou; i++){
            $.ajax({
                    type: "POST",
                    url: "/tiket/ajax_get_one_people_open_return",
                    data: {route_name_id:route,from:From,to:To,plase:' - ',valute:$('.sell_vall').val(),prior:1,open:1},
                    async: false,
                    success: function(data) {
                        //alert(data);
                        //exit;
                        HTmm = data;
                        $(HTmm).insertAfter('.return_peo_after');
                    },
                    error:function(code, opt, err){
                        alert("Состояние ferrymans_open_return/ajax_get_one_people_open_return");
                    }
                });
        }
        //$('.animation_ajax').hide();
        //$('.body').show(1000);
        PeopleCURPRICEDISCRet();
        Insert_FIARST_people();
        //InsertPriamoyPeople(Cou);
        //newnewRet(Cou);
        //exit;
        
})
function Insert_FIARST_people(){
       
       
            
       //Prise = Math.round(Prise);
       
       //alert(Prise);
       
       
       $('.people').find('.one_people').find('.pad_top').each(function(){
            $(this).remove();
        })
        
        
        var FiarstPeople = [];
        $('.people').find('.one_people').each(function(){
            var Inpu = [];
            $(this).find('input').each(function(){
                Inpu.push($(this).val());
                
            })
            FiarstPeople.push(Inpu);
        })
        
        
        var return_one_peop = [];
            $('.return_people .one_people').each(function(){
                return_one_peop.push(1);
            })
        
         var FirstPeopleDiscount = [];
            
        var FirstPeopleDiscount_date = [];
        
        var FirstPeopleDiscount_count = [];
        //if(choise_priamoy.length >= (choise_return.length+1)){
            $('.people .one_people').each(function(){
            //alert(FiarstPeople);
                var SelectedDiscount = $(this).find('.discount_hid').val();
                //if(SelectedDiscount == 1){
                //    
                //}
                FirstPeopleDiscount_count.push(1);
                
                FirstPeopleDiscount.push(SelectedDiscount);
                FirstPeopleDiscount_date.push($(this).find('.custom_date').val());
                //alert(SelectedDiscount);
            })//if()    
        //}
        
        //alert(FirstPeopleDiscount);
        //alert(return_one_peop.length);
        var iii = 0;
        $('.return_people .one_people').each(function(){
            var curr_forst_people_discount = FirstPeopleDiscount[iii];
            var Parent = $(this);
            //alert();//return_one_peop.push(1);
            if(curr_forst_people_discount == 1){
                var Prise = parseFloat('<?=$price?>');
                //var pricess =  $(this).find('.dis_price_inf').text();
                //var pricess_fir =  ;
                Prise = Prise - Prise/100*10;
                Prise = Prise.toFixed(2);
                
                //alert(Prise);
                //alert(pricess);
                //var pricess =  $(this).find('.dis_price_inf').text(Prise);
                Parent.find('.dis_price_inf').text(Prise);
                //alert(pricess);
                Parent.find('.dis_price').text(Prise);
                
                var Texr = '';
                            ///*
                Parent.find('.discount_hid option').each(function(){
                    //$(this).removeAttr("selected");
                    if($(this).val() == 33){
                        Texr = $(this).text();
                        $(this).attr('selected','selected');
                        
                    }else{
                        $(this).remove();
                    }
                });
                //*/
              
               
               
                Parent.find('.info_discounts').text(Texr);
                //exit;
            }//else{
             //   Parent.find('.date').blur();
            //}
            iii++;
        })
        
        
        /*
        if(FirstPeopleDiscount[return_one_peop.length-1] == 1){ 
                alert(Prise);
                var CurDat = FirstPeopleDiscount_date[return_one_peop.length-1];
                
                if(CurDat.length > 1){
                    Prise = Prise - Prise/100*10;
                    Prise = Prise.toFixed(2);
                }
                alert(Prise);
                var ii = 0;
                $('.return_people .one_people').each(function(){
                    if(FirstPeopleDiscount_count.length == return_one_peop.length){
                        $(this).find('.dis_price_inf').text(Prise);
                        alert(Prise);
                    }
                    ii++;
                })
                
                
            }
        */
        if(FiarstPeople.length > 0){
            var ff = 0;
            $('.return_people').find('.one_people').each(function(){
                //alert(ff);
               // /*
                var dd = 0;
                $(this).find('input').each(function(){
                    if(FiarstPeople[ff][dd]){
                        $(this).val(FiarstPeople[ff][dd]); 
                        $(this).attr('disabled',true);
                    }
                    
                    dd++;
                })
                ff++;
                //*/
                
            })
        }
        var yu = 0;
        $('.return_people').find('.one_people').each(function(){
            var curr_forst_people_discount = FirstPeopleDiscount[yu];
            var Parent = $(this);
            //alert();//return_one_peop.push(1);
            if(curr_forst_people_discount != 1){
                Parent.find('.date').blur();
            }
            yu++;
            
        })
}


function PeopleCURPRICEDISCRet(){
    $('.return_al').text(0);
    var Start = 0;
    $('.return_people').find('.dis_price').each(function(){
        Start += parseFloat($(this).text());
    })
    //Sums)
    $('.return_al').text(Math.round(Start));
    $('.top_val').text($('.sell_vall').val());
    
    //al_busket_open();
    //alert('ok');
    al_busket_open();
}

function al_busket_open(){
    
    $('.al_bascet').text(0);
    var Start = 0;
    //$('.return_dis_price').each(function(){
    Start = parseFloat($('.return_al').html());
    var Start2 = 0;
    
    //$('.return_dis_price').each(function(){
    Start2 = parseFloat($('.al').html());
    //}
    var Sums = Start + Start2;
    //alert(Start2);
    $('.al_bascet').text(Math.round(Sums));

}
function ShowAnim(){
    $('.ajax_load').show();
    //setTimeout(function(){alert("Hello")}, 3000);
    
    //HideAnim();
    //$('body').hide(10);
}
function HideAnim(){
    $('.ajax_load').hide();
    //$('body').show(10);
}

setInterval(CheAA,1000);

function CheAA(){
    var Couuu = 0;
    $('.return_people').find('.one_people').each(function(){
        Couuu++;
    })
    if($('.ferrymans_open_return').val() == Couuu){
        HideAnim();
        PeopleCURPRICEDISCRet();
    }
}
</script>