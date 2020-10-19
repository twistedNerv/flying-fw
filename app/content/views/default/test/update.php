<div class="col-sm-12 text-center"> 
    <h2>Test</h2>
</div>
<div class="col-sm-4 text-right"> 
    <div class="row">
        <div class="col-sm-12">
            <h4>Test</h4>
        </div>
        <div class="col-sm-12">
            <?php
            foreach ($data['items'] as $singleItem) {
                $selectedTestClass = ($data['selectedTest']->id == $singleItem['id']) ? "font-weight-bold" : "";
                echo "<div>
                        <span class='" . $selectedTestClass . "'>" . $singleItem[$data['columns'][1]] . " " . $singleItem[$data['columns'][1]] . "</span> | 
                        <a href='" . URL . "test/update/" . $singleItem['id'] . "' title='Uredi test'><i class='far fa-edit'></i></a> |
                        <a href='" . URL . "test/remove/" . $singleItem['id'] . "' title='Briši test' onclick='return confirm(&#34;Res želiš brisat?&#34;);'><i class='fas fa-times' title='Briši test'></i></a>
                      </div>";
            }
            ?>
        </div>
    </div>
</div>
<div class="col-sm-8">
    <?php if ($data['selectedTest']->id) { ?>
        <a href="<?= URL ?>test/update">Dodaj test</a>
        <h4>Uredi test</h4>
    <?php } else { ?>
        <h4>Dodaj test</h4>
    <?php } ?>
    <div class="test-settings">
        <form action="<?= URL ?>test/update<?php echo ($data['selectedTest']->id) ? "/" . $data['selectedTest']->id : "" ?>" method="post">
            <input type="hidden" name="action" value="handletest">
            <?php foreach ($data['columns'] as $singleColumn) { 
                if ($singleColumn != 'id') {?>
                <div class="form-group">
                    <input type="text" class="form-control" name="test-<?=$singleColumn?>" placeholder="<?=$singleColumn?>" value="<?php echo ($data['selectedTest']->$singleColumn) ? $data['selectedTest']->$singleColumn : ""; ?>">
                </div>
            <?php } 
            } ?>
            <button type="submit" class="btn btn-primary">Potrdi</button>
            <a class='btn btn-danger' href="<?= URL ?>test/update">Prekliči</a>
        </form>
    </div>
</div>