<div class="col-sm-12"> 
    <div class="row"> 
        <div class="col-sm-2"></div>
        <div class="col-sm-8 text-center"><h2>Board</h2></div> 
        <div class="col-sm-2"></div>
        
        <div class="col-sm-2"></div>
        <div class="col-sm-8"> 
            <div class="row">
                <?php foreach ($data['items'] as $singleItem) { ?>
                    <div class="col-sm-12 board-section"> 
                        <h4><?=$singleItem['title']?></h4>
                        <span class="small"><?=$singleItem['postuser']?> (<?=$singleItem['postdate']?>)</span>
                        <hr>
                        <?=nl2br($singleItem['content']); ?><br><br>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
