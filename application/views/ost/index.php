<div class="content">    
		
		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <div class="col-md-12 grey main-filter-stop">       
                                <form method="POST">
                                    <div class="col-md-3">
                                        <div class="col-md-12 no-padding">
                                            <label>ID</label>
                                            <input type="text" name="ost_id" placeholder="" class="ost_id form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="col-md-12 no-padding">
                                            <label><? echo __('Name');?></label>
                                            <input type="text" name="ost_name" placeholder="" class="ost_name form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="col-md-12 no-padding">
                                            <label><? echo __('City');?></label>
                                            <input type="text" name="ost_city" placeholder="" class="ost_city form-control">
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="col-md-12 no-padding">
                                            <label><? echo __('Village');?></label>
                                            <input type="text" name="ost_vill" placeholder="" class="ost_vill form-control">
                                        </div>
                                    </div>
                                </form>
                            </div> 
                            <div class="grid-body no-border email-body" style="min-height: 850px;">
                                <div class="large-12 medium-12  columns insert_in">
                                    <? echo $content;?>
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
     $('.ost_id,.ost_city,.ost_name,.ost_vill').keyup(function(){
         var Vall = $(this).val();
         //if(Vall.length > 1){
            var Sort = $(this).attr('name');
            $.ajax({
                url: '/ost/ajax_ost',
                type: 'POST',
                data: {sort: Sort,val:Vall,lang:$('#cur_lan').val()},
                error: function(){
                    alert('errror');
                },
                success: function(data) {
                    //if(data != 1){
                        $('.insert_in').html(data);
                    //}
                    
                }  
            });
        //}
     })
</script>