


<div class="content">    
	<div class="page-title">
    <h3><?=__("Black list phones")?></h3>
    
    <h4 class=" inline"><?=__("You can add phone numbers to blacklist")?></h4>
    </div>
   
<a href="" data-toggle="modal" data-target="#my" class="btn btn-success"><?=__("Add new")?></a>
<div class="modal fade" id="my" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                    <h4 id="myModalLabel" class="semi-bold"><?=__('Add phone')?></h4>
                                                </div>
                                                <form method="POST" class="formm">
                                                    <div class="modal-body">
                                                        <div class="row form-row">
                                                            <div class="col-md-12">
                                                                <label><?=__('Number')?></label>
                                                                <input type="text" class="form-control edit_soname" name="tel" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal"><?=__('Close')?></button>
                                                        <button type="button" class="btn btn-primary update_cleent_but" data-dismiss="modal"><?=__('Add')?></button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
  <!-- BEGIN BASIC FORM ELEMENTS-->
        <div class="row">
            <div class="col-md-12">
              <div class="grid simple">
       
                <div class="grid-body no-border"> <br>
                  <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-8">
           
                                        <? foreach($all as $a){?>
                                           
                                           <button type="button" class="btn btn-block btn-white"><?=$a['tel']?></button>
                                           
                                     
                                        <?}?>
                                   
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
	<!-- END BASIC FORM ELEMENTS-->	 









</div><!--Content div-->





















<script type="text/javascript">
    $('.update_cleent_but').click(function(){
        $('.formm').submit();
    })

</script>