<style>
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
    background-color: #1da0db;
}
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
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white --> 
                            <h3 class="semi-bold h_ped"><?=__("Edit Ferryman")?></h3>
                            <div class="padding_center">
                                <form id="add_material" action="" method="post" >
                                    <div class="col-md-6 no-padding">
                                        <div class="form-group">
                                            <label><? echo __('Name');?></label>
                                            <input name="name" type="text"  value="<?=$edit['name'];?>" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label><? echo __('Company');?></label>
                                            <input name="company" type="text"  value="<?=$edit['firmaname'];?>"  class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label><? echo __('Tel');?></label>
                                            <input name="tel" type="text"  value="<?=$edit['tel1'];?>" class="form-control"  />
                                        </div>
                                        <div class="form-group">
                                            <label><? echo __('Tel');?> (2)</label>
                                            <input name="tel2" type="text"  value="<?=$edit['tel2'];?>" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label><? echo __('Fax');?></label>
                                            <input name="fax" type="text"  value="<?=$edit['fax'];?>" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label><? echo __('Address');?></label>
                                            <input name="adress" type="text"  value="<?=$edit['address'];?>" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label><? echo __('Address');?> (2)</label>
                                            <input name="adress2" type="text"  value="<?=$edit['address2'];?>" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <label><? echo __('Delete Reservation tickets');?></label>
                                            <input name="reserv_anule" type="text"  value="<?=$edit['reserv_anule'];?>" class="form-control" />
                                        </div>
                                        <div class="form-group">
                                            <button class="btn btn-salat btn-cons"><?=__("Save")?></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div> <!-- end new layaut -->
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>













