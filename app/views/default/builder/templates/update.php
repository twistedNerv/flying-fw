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
                $selected[f[tablename_capital]f]Class = ($data['selected[f[tablename_capital]f]']->id == $singleItem['id']) ? "font-weight-bold" : ""; ?>
                <div>
                    <span class='<?=$selected[f[tablename_capital]f]Class?>'><?=$singleItem['id']?></span> | 
                    <a href='<?=URL?>[f[tablename]f]/update/<?=$singleItem['id']?>' title='Edit [f[tablename]f]'><i class='far fa-edit'></i></a> |
                    <a href='<?=URL?>[f[tablename]f]/remove/<?=$singleItem['id']?>' title='Delete [f[tablename]f]' onclick='return confirm("Really want to delete?");'><i class='fas fa-times'></i></a>
                </div>
            <?php }
            ?>
        </div>
    </div>
</div>
<div class="col-sm-8">
    <?php if ($data['selected[f[tablename_capital]f]']->id) { ?>
        <a href="<?= URL ?>[f[tablename]f]/update">Add [f[tablename]f]</a>
        <h4>Edit [f[tablename]f]</h4>
    <?php } else { ?>
        <h4>Add [f[tablename]f]</h4>
    <?php } ?>
    <div class="[f[tablename]f]-settings">
        <form action="<?= URL ?>[f[tablename]f]/update<?php echo ($data['selected[f[tablename_capital]f]']->id) ? "/" . $data['selected[f[tablename_capital]f]']->id : "" ?>" method="post">
            <input type="hidden" name="action" value="handle[f[tablename]f]">[f[inputs]f]
            <button type="submit" class="btn btn-primary">Submit</button>
            <a class='btn btn-danger' href="<?= URL ?>[f[tablename]f]/update">Cancel</a>
        </form>
    </div>
    [f[js_editor]f]
</div>