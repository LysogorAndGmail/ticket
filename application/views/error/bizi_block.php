<style>
.activ_day {
    background-color: #1EA7E7 !important;
}

</style>

<? $lang = Session::instance()->get('leng');
     if(!$lang) {
        $lang = 'EN';
     }
 I18n::lang($lang); 
$sesuser = Session::instance()->get('ses_user');
if(isset($sesuser[0])){
    $user_id = $sesuser[0]['id'];
    $ses_valute = $sesuser[0]['default_valute'];
}else{
    $user_id = 0;
    $ses_valute = 'EUR';
}

 $group_see_tik = DB::select()->from('groups')->where('id','=',$sesuser['group_id'])->execute()->current(); //print_r($group_see_tik);

?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.10.1/jquery-ui.js" type="text/javascript"></script>
<script type="text/javascript" src="/tgl_callendar/js/tgl.1.1.js"></script>


<!-- start modal -->       
<div class="main_parr">
    <br />
    <br />
    <button class="butt_call">Call</button>
</div>
<div class="row form-row" style="">
    <div class="col-md-12 print_ticket_block" id="print_ticket_block">
        <img src="<?=Kohana::$base_url?>img/big_loader.gif" width="24" height="24" style="margin: auto; display: block;" />
    </div>
</div>

<form method='get'>
			<input type='text' id='tes1' value='' name='tes1'>
		</form>

<script>
	tgl({
		input : 'tes1',
		clasStyle : 'theme4-pack1-blue',
		shortDay : '3',
        format : 'dd/mm/yy'
	});
</script>
          <!-- end modal -->
<script type="text/javascript">
$('#tes1').focus(function(){
    setTimeout(getDateModal,500);
})


$('.butt_call').click(function(){
    var SchemaHTml = '';
    $.ajax({
        type: "POST",
        url: "/errors/ajax_get_bizi_call",
        data: {id:1},
        async: false,
        success: function(data) {
            SchemaHTml = data
            $('.print_ticket_block').html(SchemaHTml);
        },
        error:function(code, opt, err){
            alert("Состояние : " + opt + "\nКод ошибки : " + code.status + "\nОшибка : " + err);
        }
    });
})
function getDateModal(){
     var RouteNameID = 1590;
     var Artex = ''; 
     $.ajax({
            type: "POST",
            url: "/route/ajax_fer_dates_only",
            data: {route_name_id:RouteNameID},
            async: false,
            success: function(data) {
                
                Artex = data;
            },
            error:function(){
                //alert('ошибка записи step_3');
            }
            
       });
       
       var arr = Artex.split(',');
    $('.date').each(function(){
        var Htmll = $(this);
        var Full = $(this).data('day_full');
        for(var st = 0; st<=arr.length; st++){
            if(arr[st] == Full){
                Htmll.addClass('activ_day');
            }
        }
    })
    
    //$('.animation_ajax').hide();
}  
</script>                 