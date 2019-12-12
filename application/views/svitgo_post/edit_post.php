<script src="<?=Kohana::$base_url?>/js/ckeditor/ckeditor.js"></script>
<script src="//ckeditor.com/apps/ckeditor/4.3.3/samples/assets/uilanguages/languages.js"></script>

<div class="content">    
	<div class="page-title">
    <h3><?=__("Edit Article")?></h3></div>
   

  <!-- BEGIN BASIC FORM ELEMENTS-->
        <div class="row">
            <div class="col-md-12">
              <div class="grid simple">
             <div class="grid-title no-border">
                   <ul class="breadcrumb">
     
        <li><a href="/post" class="link"><?=__("Articles")?></a> </li>
          <li><span href="#" class="active"><?=__("Edit Article")?></span> </li>
      
     
      </ul>
                </div>
                <div class="grid-body no-border"> <br>
                  <div class="row">
                    <div class="col-md-8 col-sm-8 col-xs-8">
                   <form method="POST" >
                     <input type="hidden" name="id" value="<?=$_GET['id'];?>"/>
                      <div class="form-group">
                        <label class="form-label"><?=__('Language')?></label>
                          <div class="controls">
                         <input type="text"  name="lang" value="<?=$_GET['lang'];?>"/>
                      
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="form-label"><?=__('Title')?></label>
                 
                        <div class="controls">
                               <input type="text"  name="article_title" value="<?=$edit['article_title'];?>" />
                        </div>
                      </div>
                      <div class="form-group">
                         <label><?=__('Text')?></label>
                       
                        <div class="controls">
             <textarea name="article_text" class="ckeditor" id="editor1" name="editor1" cols="100" rows="10"><?=$edit['article_text'];?></textarea>
                        </div>
                      </div>
                      
                               <div class="form-group">
                       
                       
                        <div class="controls">
                    <input type="submit" class="btn btn-primary btn-cons" value="<?=__('Edit')?>" />
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




























