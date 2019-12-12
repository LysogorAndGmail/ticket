<style>
.write {
    padding-top: 20px;
    padding-left: 20px;
}
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
    background-color: #b6c5c6;
}
a.select {
    background-attachment: scroll;
    background-clip: border-box;
    background-color: #1EA7E7;
    background-image: -moz-linear-gradient(center top , #1EA7E7, #159AE2) !important;
    background-origin: padding-box;
    background-position: 0 0;
    background-repeat: repeat;
    background-size: auto auto;
    border: 1px solid #19668C !important;
    border-radius: 3px;
    box-shadow: 0 1px 0 0 #ddd inset !important;
    color: #FFFFFF !important;
    font-size: 13px;
    height: 27px !important;
    padding: 3px 2px 5px 2px;
    text-shadow: 0 -1px #065D75;
    width: 29px;
}
</style>
<div class="content">    

		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <div class="grid-body no-border email-body" style="min-height: 850px;">
                            
                                    <div class="col-md-12 no-padding insert_in">
                                        <p>&nbsp;</p>
                                         <h3 class="semi-bold h_ped"><?=__("Create Scheme")?></h3>	
                                        <div class="col-md-6 no-padding par">
                                        
                                        
                                            <div class="col-md-12 no-padding">
                                                <div class="form-group">
                                                    <label><?=__("Name")?></label>
                                                    <input type="text" class="name form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label><?=__("Description")?></label>
                                                    <input type="text" class="desc form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label><?=__("Rows")?></label>
                                                    <input type="text" class="rows form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <label><?=__("Columns")?></label>
                                                    <input type="text" class="cols form-control" />
                                                </div>
                                                <div class="form-group">
                                                    <button class="wr_but btn btn-salat btn-cons"><?=__("Create")?></button>
                                                </div>
                                            </div>
                                            <div class="col-md-12 no-padding">
                                                <div class="radio">
                                                    <input type="radio" id="male" name="do" value="clean" /> 
                                                    <label for="male"><?=__("Clean")?></label>
                                                    
                                                    <input type="radio" id="male2" name="do" value="1" checked="checked" /> 
                                                    <label for="male2"><?=__("Design")?></label>
                                                    
                                                    <input type="radio" id="male3" name="do" value="0" /> 
                                                    <label for="male3"><?=__("Numbers")?></label>
                                                </div>
                                            </div>
                                            <p>&nbsp;</p>
                                            <div class="col-md-12 no-padding">
                                                <div class="radio">
                                                    <img src="<?=Kohana::$base_url?>img/menu_left/schema_icon_1.jpg" width="32" height="32" />&nbsp; <input type="radio" id="male4" name="do" value="2" />
                                                    <label for="male4"><?=__("WC")?></label>
                                                    <img src="<?=Kohana::$base_url?>img/menu_left/schema_icon_3.jpg" width="32" height="32" />&nbsp; <input type="radio" id="male5" name="do" value="3" />  
                                                    <label for="male5"><?=__("Stewardess")?></label>  
                                                    <img src="<?=Kohana::$base_url?>img/menu_left/schema_icon_4.jpg" width="32" height="32" />&nbsp; <input type="radio" id="male6" name="do" value="4" /> 
                                                    <label for="male6"><?=__("Сonductor")?></label>  
                                                </div>
                                            </div>
                                            <p>&nbsp;</p>
                                            <div class="col-md-12 no-padding">
                                                <button class="save_sch btn btn-success btn-cons"><?=__("Add");?></button>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 no-padding">
                                            <div class="write"></div>
                                        </div>
                                    </div>      
                                </div>
                            </div> 
                        </div>
                    </div>	
                </div>
        <div class="clearfix"></div>
    </div>    
</div>
<script type="text/javascript">
$('.save_sch').click(function(){
    var fff = [];
    var i = 0;
    $(this).parents('.par').next().find(".write").find(".rr").each(function(){
        //alert($(this).html());
        var Nee = [];
        $(this).find(".cc").each(function(){
            Nee.push($(this).html());
        })
        //.push();
        fff[i] = Nee;
        i++;
    });
    
    //alert(fff);
    //exit;
    
    $.ajax({
        type: "POST",
        url: "/buses/ajax_save_schema",
        data: {name:$(".name").val(),desc:$(".desc").val(),rows:$(".rows").val(),cols:$(".cols").val(),html:fff},
        success: function(data) {
            //$('.bus_chek').html(data);
            //alert(data);
            location="/buses/all_schema";
        },
        error:function(){
            alert('ошибка записи step_3');
        }
   });
})
//$(function() {

function hhh(divv){
    var Par = divv.parents('.write');
    //exit;
    var ATR = divv.attr('class');
    var SEL_T = $("input:radio:checked").val();
    //alert(SEL_T);
    //exit;
    if(SEL_T == 'clean'){
        divv.addClass('blu');
        divv.text("");        
    }
    if(SEL_T == 1){
        if(ATR == "cc blu"){
            divv.removeClass('blu');
        }else{
            divv.addClass('blu');
        }
    }
    if(SEL_T == 0){
        var i = 1;
        Par.find('.cc').each(function(){
            if($(this).text().length > 0 && $(this).text() != "WC" && $(this).text() != "st" && $(this).text() != "pr"){
                i++;
            }
        })
        if(divv.text() != "WC" && divv.text() != "st" && divv.text() != "pr" && ATR == "cc blu" && divv.text() == ""){
            divv.text(i);
        }
        
    }
    if(SEL_T == 2){
        if(ATR == "cc blu"){
            divv.removeClass('blu');
            divv.text("WC");
        }else{
            divv.text("WC");
        }
        
    }
    if(SEL_T == 3){
        if(ATR == "cc blu"){
            divv.removeClass('blu');
            divv.text("st");
        }else{
            divv.text("st");
        }
        
    }
    if(SEL_T == 4){
        if(ATR == "cc blu"){
            divv.removeClass('blu');
            divv.text("pr");
        }else{
            divv.text("pr");
        }
        
    }
    
    
}


$('.cc').click(function(){
    //$(this).removeClass('blu');
    alert('ok');
})

$('.wr_but').click(function(){
    var ROW = $('.rows').val();
    var COLS = $('.cols').val();
    var STR = "";
    var COST = "";
    //alert(ROW);
    //exit;
    for(var i=1;i<=ROW;i++){
        STR += "<div class='rr'>";
        for(var ii=1;ii<=COLS;ii++){
            STR += "<div class=\"cc blu\" onclick='hhh($(this))'></div>";
        }
        STR +="</div>";
    }
    $('.write').html(STR);
})


//}) 
</script>
















