<div class="col-sm-12 text-center"> 
    <h2>[f[tablename_capital]f]</h2>
</div>
<div class="col-sm-12 text-center board-section"> 
    <?php foreach ($data['items'] as $singleItem) { ?>
        <div>
            <hr> 
            <?php
            foreach ($data['vars'] as $key => $value) {
                echo $singleItem[$key] . " | ";
            }
            ?>
        </div>
    <?php } ?>
    <hr>
</div>