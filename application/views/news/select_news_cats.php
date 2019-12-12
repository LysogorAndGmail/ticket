<div class="content">    
    <div class="page-title" > <a href="/" id="btn-back"><i class="icon-custom-left"></i></a>
       <h3><?=__("Back")?> - <span class="semi-bold"><?=__("Index")?></span></h3>
    </div>		
    
    <div class="row" id="inbox-wrapper">
        
        <a href="/news/add_news_cat" class="btn btn-success btn-cons"><?=__("Create News category")?></a>
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12 pad_con">
                    <div class="grid simple">
                        <div class="col-md-12 white-content"><!-- starp white -->      
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th><?=__("Title")?></th>
                                    <th><i class="fa fa-globe"></i></th>
                                    <th><?=__("Actions")?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <? foreach($news_cats as $n){?>
                                    <tr class="">
                                        <td><?=$n['cat_id'];?></td>
                                        <td><?=$n['title'];?></td>
                                        <td><?=__("Langs")?></td>
                                        <td><a class="shure" href="/news/del_news_cat?id=<?=$n['cat_id'];?>"><i class="fa fa-times"></i></a></td>
                                    </tr>
                                <?}?>
                            </tbody>
                        </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.shure').click(function(e){
        if (!confirm("Подтвердить удаление?")) {
            e.preventDefault();
        }
    }) 
</script>