<div class="col-sm-12 text-center"> 
    <h2>Action groups</h2>
</div>
<div class="col-sm-4 text-right"> 
    <div class="row">
        <div class="col-sm-12">
            <h4>Action groups</h4>
        </div>
        <div class="col-sm-12">
            <?php
            foreach ($data['items'] as $singleItem) {
                $selectedActiongroupClass = ($data['selectedActiongroup']->id == $singleItem['id']) ? "font-weight-bold" : "";
                echo "<div>
                        <span class='" . $selectedActiongroupClass . "'>" . $singleItem['name'] . "</span> | 
                        <a href='" . URL . "actiongroup/update/" . $singleItem['id'] . "' title='Edit actiongroup'><i class='far fa-edit'></i></a> |
                        <a href='" . URL . "actiongroup/remove/" . $singleItem['id'] . "' title='Remove actiongroup' onclick='return confirm(&#34;You really want to remove?&#34;);'><i class='fas fa-times' title='Remove actiongroup'></i></a>
                      </div>";
            }
            ?>
        </div>
    </div>
</div>
<div class="col-sm-8">
    <?php if ($data['selectedActiongroup']->id) { ?>
        <a href="<?= URL ?>actiongroup/update">Add action group</a>
        <h4>Edit action group</h4>
    <?php } else { ?>
        <h4>Add action group</h4>
    <?php } ?>
    <div class="actiongroup-settings">
        <form action="<?= URL ?>actiongroup/update<?php echo ($data['selectedActiongroup']->id) ? "/" . $data['selectedActiongroup']->id : "" ?>" method="post">
            <input type="hidden" name="action" value="handleactiongroup">
            <input type="hidden" name="action" value="handleactiongroup">
            <div class="form-group">
                <input type="text" class="form-control" name="actiongroup-name" placeholder="name" value="<?php echo ($data['selectedActiongroup']->id) ? $data['selectedActiongroup']->name : ""; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="actiongroup-description" placeholder="description" value="<?php echo ($data['selectedActiongroup']->id) ? $data['selectedActiongroup']->description : ""; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="actiongroup-action" placeholder="page (i.e. home/index)" value="<?php echo ($data['selectedActiongroup']->id) ? $data['selectedActiongroup']->action : ""; ?>">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="actiongroup-section" placeholder="section term" value="<?php echo ($data['selectedActiongroup']->id) ? $data['selectedActiongroup']->section : ""; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a class='btn btn-danger' href="<?= URL ?>actiongroup/update">Cancel</a>
        </form>
    </div>
    <?php if ($data['selectedActiongroup']->id) { ?>
        <div class="col-sm-12">
            <h4>Action group users</h4>
            
        </div>
        <div class="col-sm-12">
            <?php foreach ($data['actiongroupUsers'] as $singleActiongroupUsers) { 
                echo "<a href='" . URL . "user/update/" . $singleActiongroupUsers['id'] . "'>" .  $singleActiongroupUsers['name'] . " " . $singleActiongroupUsers['surname'] . "</a><br>";
            } ?>
        </div>
    <?php } ?>
</div>