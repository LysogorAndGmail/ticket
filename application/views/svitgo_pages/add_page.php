<script src="<?=Kohana::$base_url?>/js/ckeditor/ckeditor.js"></script>
<script src="//ckeditor.com/apps/ckeditor/4.3.3/samples/assets/uilanguages/languages.js"></script>



<div class="content">    
	<div class="page-title">
    <h3><?=__("Create Page")?></h3></div>
   

  <!-- BEGIN BASIC FORM ELEMENTS-->
        <div class="row">
            <div class="col-md-12">
              <div class="grid simple">
             <div class="grid-title no-border">
                   <ul class="breadcrumb">
     
        <li><a href="/pages" class="link"><?=__("Pages")?></a> </li>
          <li><span href="#" class="active"><?=__("Create Page")?></span> </li>
      
     
      </ul>
                </div>
                <div class="grid-body no-border"> <br>
                  <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                       <form method="POST" style="margin: auto; width: 80%;">
                      <div class="form-group">
                        <label class="form-label"><?=__('Language')?></label>
                          <div class="controls">
                          <input type="text" value="ru" />
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label"><?=__('Title')?></label>
                 
                        <div class="controls">
                        <input type="text" name="title" value="" />
                        </div>
                      </div>
                      <div class="form-group">
                         <label><?=__('Alias')?></label>
                       
                        <div class="controls">
                        <input type="text" name="alias" value="" />
                        </div>
                      </div>
                      
                               <div class="form-group">
                       
                       
                        <div class="controls">
                      <button class="btn btn-success btn-cons"><?=__('Add')?></button>
                        </div>
                      </div>
                
           </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
	<!-- END BASIC FORM ELEMENTS-->	 









</div><!--Content div-->



















