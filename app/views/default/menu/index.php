<div class="col-sm-12 text-center"> 
    <h2>Menu</h2>
</div>
<div class="col-sm-4 text-right"> 
    <div class="row">
        <div class="col-sm-12">
            <h4>User menu</h4>
        </div>
        <div class="col-sm-12">
            <?php
            foreach ($data['parentGroups'] as $singleParent) {
                $notActive = ($singleParent['active']) ? "" : "<span style='color:red'>NA</span>";
                echo "<hr>
                    <div>
                        $notActive
                        <strong>" . $singleParent['title'] . " (" . $singleParent['level'] . ")</strong> | 
                        <a href='" . URL . "menu/index/" . $singleParent['id'] . "' title='Edit element'>
                            <i class='far fa-edit'></i>
                        </a> | 
                        <a href='" . URL . $singleParent['url'] . "' title='Open link' target=”_blank”>
                            <i class='fas fa-external-link-alt'></i></i>
                        </a> |  
                        <a href='" . URL . "menu/move/up/" . $singleParent['id'] . "' title='Move up'>
                            <i class='fas fa-angle-double-up'></i>
                        </a>
                        <a href='" . URL . "menu/move/down/" . $singleParent['id'] . "' title='Move down'>
                            <i class='fas fa-angle-double-down'></i>
                        </a> | 
                        <a href='" . URL . "menu/remove/" . $singleParent['id'] . "' title='Remove element from menu'>
                            <i class='fas fa-times'></i>
                        </a> 
                    ";
                foreach ($data['pageMenuItems'] as $singleItem) {
                    if ($singleItem['parent'] == $singleParent['id']) {
                        $notActive = ($singleItem['active']) ? "" : "<span style='color:red'>NA</span>";
                        echo "<div>
                                $notActive
                                " . $singleItem['title'] . " (" . $singleItem['level'] . ") | 
                                <a href='" . URL . "menu/index/" . $singleItem['id'] . "' title='Edit element'>
                                    <i class='far fa-edit'></i>
                                </a> |
                                <a href='" . URL . $singleItem['url'] . "' title='Open link' target=”_blank”>
                                    <i class='fas fa-external-link-alt'></i>
                                </a> | 
                                <a href='" . URL . "menu/move/up/" . $singleItem['id'] . "' title='Move up'>
                                    <i class='fas fa-angle-double-up'></i>
                                </a>
                                <a href='" . URL . "menu/move/down/" . $singleItem['id'] . "' title='Move down'>
                                    <i class='fas fa-angle-double-down'></i>
                                </a> | 
                                <a href='" . URL . "menu/remove/" . $singleItem['id'] . "' title='Remove element from menu'>
                                    <i class='fas fa-times'></i>
                                </a> 
                            </div>";
                    }
                }
                echo "</div>";
            }
           ?>
        </div>
        <hr>
        <div class="row">
            <div class="col-sm-12">
                <br><h4>Admin menu</h4>
            </div>
            <div class="col-sm-12">
                <?php
                foreach ($data['adminMenuItems'] as $singleItem) {
                    $notActive = ($singleItem['active']) ? "" : "<span style='color:red'>NA</span>";
                    echo "<div>
                            $notActive
                            " . $singleItem['title'] . " (" . $singleItem['level'] . ") | 
                            <a href='" . URL . "menu/index/" . $singleItem['id'] . "' title='Edit element'>
                                <i class='far fa-edit'></i>
                            </a> |
                            <a href='" . URL . $singleItem['url'] . "' title='Open link' target=”_blank”>
                                <i class='fas fa-external-link-alt'></i>
                            </a> | 
                            <a href='" . URL . "menu/move/up/" . $singleItem['id'] . "' title='Move up'>
                                <i class='fas fa-angle-double-up'></i>
                            </a>
                            <a href='" . URL . "menu/move/down/" . $singleItem['id'] . "' title='Move down'>
                                <i class='fas fa-angle-double-down'></i>
                            </a> | 
                            <a href='" . URL . "menu/remove/" . $singleItem['id'] . "' title='Remove element from menu'>
                                <i class='fas fa-times'></i>
                            </a> 
                        </div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-8">
    <?php if ($data['selectedItem']->id) { ?>
        <a href="<?= URL ?>menu">Add element</a>
        <h4>Edit element</h4>
    <?php } else { ?>
        <h4>Add element in menu</h4>
    <?php } ?>
    <div class="user-settings">
        <form action="<?= URL ?>menu/index/<?=$data['selectedItem']->id ?>" method="post">
            <input type="hidden" name="action" value="addmenuitem">
            <div class="form-group">
                <input type="text" class="form-control" name="menu-title" placeholder="Title" required <?=$this->template->setUpdateTextValue($data['selectedItem']->title)?>>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="menu-description" placeholder="Description" required <?=$this->template->setUpdateTextValue($data['selectedItem']->description)?>>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="menu-url" placeholder="URL" required <?=$this->template->setUpdateTextValue($data['selectedItem']->url)?>>
            </div>
            <div class="form-group">
                <select name="menu-parent" class="browser-default custom-select">
                    <option value="0">Head menu group</option>
                    <?php
                    foreach ($data['parentGroups'] as $parentGroupItem) {
                        echo "<option " . $this->template->setUpdateSelectValue($parentGroupItem['id'], $parentGroupItem['id'], $data['selectedItem']->parent) . ">" . $parentGroupItem['title'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <select name="menu-admin" class="browser-default custom-select" required>
                    <option <?=$this->template->setUpdateSelectValue(1, $data['selectedItem']->admin, 1)?>>Admin menu</option>
                    <option <?=$this->template->setUpdateSelectValue(0, $data['selectedItem']->admin, 0)?>>User menu</option>
                </select>
            </div>
            <div class="form-group">
                <select name="menu-level" class="browser-default custom-select" required>
                    <option <?=$this->template->setUpdateSelectValue(1, $data['selectedItem']->level, 1)?>>Users available</option>
                    <option <?=$this->template->setUpdateSelectValue(2, $data['selectedItem']->level, 2)?>>Submoderators available</option>
                    <option <?=$this->template->setUpdateSelectValue(3, $data['selectedItem']->level, 3)?>>Moderators available</option>
                    <option <?=$this->template->setUpdateSelectValue(4, $data['selectedItem']->level, 4)?>>Admin available</option>
                    <option <?=$this->template->setUpdateSelectValue(5, $data['selectedItem']->level, 5)?>>Super admin available</option>
                </select>
            </div>
            <div class="form-group">
                <select name="menu-active" class="browser-default custom-select" required>
                    <option <?=$this->template->setUpdateSelectValue(1, $data['selectedItem']->active, 1)?>>Active</option>
                    <option <?=$this->template->setUpdateSelectValue(0, $data['selectedItem']->active, 0)?>>Not active</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <a class='btn btn-danger' href='users.php'>Cancel</a>
        </form>
    </div>
</div>
</div>
</div>