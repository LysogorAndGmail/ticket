<?
  $ses_user = Session::instance()->get('ses_user');
?>
<style>
.one_scem {
}
.one_row {
    clear: both;
}
div.cc {
    width: 20px;
    height: 20px;
    outline: 1px solid black;
    float: left;
    text-align: center;
}
div.blu {
    background-color: #1da0db;
}
</style>
<div class="content">    
		
		<div class="row" id="inbox-wrapper">
			<div class="col-md-12">
				<div class="row">
					<div class="col-md-12">
						 <div class="grid simple">
                            <div class="grid-body no-border email-body" style="min-height: 850px;">
                                    <div class="large-12 medium-12  columns insert_in">
                        			    <p>&nbsp;</p>
                <? if(isset($ses_user[0]['id'])){ $al_sys_schema = DB::select()->from('system_users_scheme')->where('sysuser_id','=',$ses_user[0]['id'])->execute()->as_array(); 
                $ar_sch = array();
                foreach($al_sys_schema as $sch){
                    $ar_sch[] = $sch['chema'];
                }
                //print_r($ar_sch);
                $all_schema = DB::select()->from('bscheme')->where('schema_name','in',$ar_sch)->order_by('schema_id','ASC')->execute()->as_array();
                }
                if(!empty($all_schema)){  foreach($all_schema as $all){
                        $new_all[$all['schema_name']][$all['dx']][$all['dy']] = $all;
                    }
                    
                    foreach($new_all as $name=>$aa){ 
                        
                        ?>
                    <div class="one_scem col-md-3">
                        <h4><?=$name;?></h4>
                        <? foreach($aa as $x=>$ax){?>
                        <div class="one_row">
                            <? foreach($ax as $y=>$ay){ ?>
                                <div class="cc <? if(!empty($ay['value']) && $ay['value'] != "sw" && $ay['value'] != "pr" && $ay['value'] != "st"){ echo "blu"; }?>"><?=$ay['value'];?></div>
                            <?}?>
                        </div>
                        <?}?>
                        <div class="clearfix"></div>
                        <br />
                        <a href="/buses/del_schema?id=<?=$name;?>"><?=__("Delete")?></a>
                        <br />
                    </div>
                    <? } }?>
                                    </div>
                                </div>
                           </div>	
						</div>
					</div>
				</div>	
		</div>
 <div class="clearfix"></div>
  </div>