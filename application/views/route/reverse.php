<div class="content">    
    <div class="page-title" > <a href="/" id="btn-back"><i class="icon-custom-left"></i></a>
        <h3><?=__("Back")?> - <span class="semi-bold"><?=__("Index")?></span></h3>
    </div>		
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid simple">
                        <div class="grid-body no-border email-body" style="min-height: 850px;">
                        
                 <p>&nbsp;</p>     
                <div class="alert-box success radius" style="display: none;">
                <? echo __('Save stations');?>
                 <a href="#" class="close" onclick="$(this).parent().hide()">&times;</a>
                </div>
                <div class="panel  radius panel-t-t col-md-6 no-padding">
                    <p> <? echo __('Main');?></p>
                    <div class="left">
                        <div class="input-ost">
                        <input type="hidden" class="fields route_name" name="route_main" id="route_main" width="50" value="<?=$_GET['id'];?>" />
                        <input type="hidden" class="rid" value="<?=$_GET['id'];?>"  />
                        <div class="show_route"></div>
                        </div>
                        <div class="input-ost">
                        <input type="text" class="fields route_name form-control" name="route_back" id="route_back" value="" width="50" />
                        <input type="hidden" class="rid" />
                        <div class="show_route"></div>
                        </div>
                    </div>
                    <div class="clearfix">&nbsp;</div>
                    <div class="left"> <button class="add_to_roz tiny btm-edit btn btn-success btn-cons" ><? echo __('Join');?></button></div>
                </div>
                
                </div>
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>
            
<script type="text/javascript">
     $('.route_name').keyup(function(){
         var Vall = $(this).val();
         var Par = $(this).parent('.input-ost').find('.show_route');
         //if(Vall.length > 1){
            var Sort = $(this).attr('class');
            //alert(Vall);
            //exit;
            $.ajax({
            url: '/route/search_join',
            type: 'POST',
            data: {val:Vall,lang:$('#cur_lan').val()},
            error: function(){
                alert('errror');
            },
            success: function(data) {
                Par.html(data);
                //$('.insert_in').html(data);
                //alert(data);
            }  
            });
        //}
     })
     $('.tiny').click(function(){
        var Fir = $('.rid').first().val();
        var last = $('.rid').last().val();
        $.ajax({
            url: '/route/save_reverse_routes',
            type: 'POST',
            data: {main:Fir,rev:last},
            error: function(){
                alert('errror');
            },
            success: function(data) {
                //$('.success').show();
                //Par.html(data);
                //$('.insert_in').html(data);
                //alert(data);
                location="/route";
            }  
            });
        $('.rid').first().val("");
        $('.rid').last().val("");
        
     })
</script>