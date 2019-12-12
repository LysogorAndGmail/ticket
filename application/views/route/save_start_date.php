<style>
#ui-datepicker-div {
    padding: 0px;
    background: #fff;
    border: 1px solid #ddd;
    width: 300px !important;
}
</style>
<div class="content">    
  
    <div class="row" id="inbox-wrapper">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid simple">
                        <div class="grid-body no-border email-body" style="min-height: 850px;">
                            <form action="" id="add_route_form for" method="post" >
                                <p>&nbsp;</p>
                                <div class="form-group">
                                    <label><? echo __('Route Date');?>:</label>
                                    <div class="time_time">
                                        <input type="text" name="time_end" id="time_end" value="" />
                                    </div>
                                </div>
                                <div class="update-ost-btm">
                                    <input type="submit" class="btm-edit btn btn-success btn-cons" id="edit_ost_button" value="<? echo __('Save');?>"/>  
                                </div>
                                
                            </form>
                        </div>
                    </div>	
                </div>
            </div>
        </div>	
    </div>
    <div class="clearfix"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    $("#time_end").datepicker({
        monthNamesShort: [ "Янв", "Фев", "Мар", "Апр", "Май", "Июнь", "Июль", "Авгу", "Сент", "Окт", "Ноя", "Дек" ],
        monthNames:[ "Январь", "Февраль", "Март", "Апрель", "Май", "Июнь", "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь" ],
        gotoCurrent: true,
        dayNamesMin: [ "Вос" , "Пон", "Вто", "Сре", "Чет", "Пят", "Суб",  ],
        minDate:new Date(),
        dateFormat: "dd/mm/y",
        altField: "#actualDate",
        numberOfMonths: 1,
        firstDay:1,
        //showOtherMonths: true,
        selectOtherMonths: true
    });
/////////////
})
</script>

