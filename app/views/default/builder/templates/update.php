<div class="col-sm-12 text-center"> 
    <h2>[f[tablename_capital]f]</h2>
</div>
<div class="col-sm-4 text-right"> 
    <div class="row">
        <div class="col-sm-12">
            <h4>[f[tablename_capital]f]</h4>
        </div>
        <div class="col-sm-12">
            <?php
            foreach ($data['items'] as $singleItem) {
                $selected[f[tablename_capital]f]Class = ($data['selected[f[tablename_capital]f]']->id == $singleItem['id']) ? "font-weight-bold" : "";
                echo "<div>
                        <span class='" . $selected[f[tablename_capital]f]Class . "'>" . $singleItem[$data['columns'][1]] . " " . $singleItem[$data['columns'][1]] . "</span> | 
                        <a href='" . URL . "[f[tablename]f]/update/" . $singleItem['id'] . "' title='Uredi [f[tablename]f]'><i class='far fa-edit'></i></a> |
                        <a href='" . URL . "[f[tablename]f]/remove/" . $singleItem['id'] . "' title='Briši [f[tablename]f]' onclick='return confirm(&#34;Res želiš brisat?&#34;);'><i class='fas fa-times' title='Briši [f[tablename]f]'></i></a>
                      </div>";
            }
            ?>
        </div>
    </div>
</div>
<div class="col-sm-8">
    <?php if ($data['selected[f[tablename_capital]f]']->id) { ?>
        <a href="<?= URL ?>[f[tablename]f]/update">Dodaj [f[tablename]f]</a>
        <h4>Uredi [f[tablename]f]</h4>
    <?php } else { ?>
        <h4>Dodaj [f[tablename]f]</h4>
    <?php } ?>
    <div class="[f[tablename]f]-settings">
        <form action="<?= URL ?>[f[tablename]f]/update<?php echo ($data['selected[f[tablename_capital]f]']->id) ? "/" . $data['selected[f[tablename_capital]f]']->id : "" ?>" method="post">
            <input type="hidden" name="action" value="handle[f[tablename]f]">
            <?php foreach ($data['columns'] as $singleColumn) { 
                if ($singleColumn != 'id') {?>
                <div class="form-group">
                    <input type="text" class="form-control" name="[f[tablename]f]-<?=$singleColumn?>" placeholder="<?=$singleColumn?>" value="<?php echo ($data['selected[f[tablename_capital]f]']->$singleColumn) ? $data['selected[f[tablename_capital]f]']->$singleColumn : ""; ?>">
                </div>
            <?php } 
            } ?>
            <button type="submit" class="btn btn-primary">Potrdi</button>
            <a class='btn btn-danger' href="<?= URL ?>[f[tablename]f]/update">Prekliči</a>
        </form>
    </div>
</div>