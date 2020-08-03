<div class="col-sm-12 text-center"> 
    <h2>Admin - Menu</h2>
</div>
<div class="col-sm-4 text-right"> 
    <div class="row">
        <div class="col-sm-12">
            <h4>Uporabniški menu</h4>
        </div>
        <div class="col-sm-12">
            <?php
            foreach ($data['parentGroups'] as $singleParent) {
                echo "<hr>
                    <div>
                        <strong>" . $singleParent['title'] . " (" . $singleParent['url'] . ")</strong> | 
                        <a href='" . URL . $singleParent['url'] . "' title='Odpri povezavo' target=”_blank”>
                            <i class='fas fa-external-link-alt'></i></i>
                        </a> |  
                        <a href='" . URL . "menu/move/up/" . $singleParent['id'] . "' title='Premakni gor'>
                            <i class='fas fa-angle-double-up'></i>
                        </a>
                        <a href='" . URL . "menu/move/down/" . $singleParent['id'] . "' title='Premakni dol'>
                            <i class='fas fa-angle-double-down'></i>
                        </a> | 
                        <a href='" . URL . "menu/remove/" . $singleParent['id'] . "' title='Briši postavko iz menuja'>
                            <i class='fas fa-times'></i>
                        </a> 
                    ";
                foreach ($data['pageMenuItems'] as $singleItem) {
                    if ($singleItem['parent'] == $singleParent['id']) {
                        echo "<div>
                                " . $singleItem['title'] . " (" . $singleItem['url'] . ") | 
                                <a href='" . URL . $singleItem['url'] . "' title='Odpri povezavo' target=”_blank”>
                                    <i class='fas fa-external-link-alt'></i>
                                </a> | 
                                <a href='" . URL . "menu/move/up/" . $singleItem['id'] . "' title='Premakni gor'>
                                    <i class='fas fa-angle-double-up'></i>
                                </a>
                                <a href='" . URL . "menu/move/down/" . $singleItem['id'] . "' title='Premakni dol'>
                                    <i class='fas fa-angle-double-down'></i>
                                </a> | 
                                <a href='" . URL . "menu/remove/" . $singleItem['id'] . "' title='Briši postavko iz menuja'>
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
                <br><h4>Administratorski menu</h4>
            </div>
            <div class="col-sm-12">
                <?php
                foreach ($data['adminMenuItems'] as $singleItem) {
                    echo "<div>
                            " . $singleItem['title'] . " (" . $singleItem['url'] . ") | 
                            <a href='" . URL . $singleItem['url'] . "' title='Odpri povezavo' target=”_blank”>
                                <i class='fas fa-external-link-alt'></i>
                            </a> | 
                            <a href='" . URL . "menu/move/up/" . $singleItem['id'] . "' title='Premakni gor'>
                                <i class='fas fa-angle-double-up'></i>
                            </a>
                            <a href='" . URL . "menu/move/down/" . $singleItem['id'] . "' title='Premakni dol'>
                                <i class='fas fa-angle-double-down'></i>
                            </a> | 
                            <a href='" . URL . "menu/remove/" . $singleItem['id'] . "' title='Briši postavko iz menuja'>
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
    <h4>Dodaj element v menu</h4>
    <div class="user-settings">
        <form action="<?= URL ?>menu/index" method="post">
            <input type="hidden" name="action" value="addmenuitem">
            <div class="form-group">
                <input type="text" class="form-control" name="menu-title" placeholder="Naslov" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="menu-description" placeholder="Opis" required>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="menu-url" placeholder="URL" required>
            </div>
            <div class="form-group">
                <select name="menu-parent" class="browser-default custom-select">
                    <option value="0" selected disabled>Glava skupine</option>
                    <?php
                    foreach ($data['parentGroups'] as $parentGroupItem) {
                        echo "<option value='" . $parentGroupItem['id'] . "'>" . $parentGroupItem['title'] . "</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <select name="menu-active" class="browser-default custom-select" required>
                    <option value="0" selected disabled>Aktiven</option>
                    <option value="0" disabled>---------------------</option>
                    <option value="1">Da</option>
                    <option value="0">Ne</option>
                </select>
            </div>
            <div class="form-group">
                <select name="menu-admin" class="browser-default custom-select" required>
                    <option value="0" selected disabled>Admin</option>
                    <option value="0" disabled>---------------------</option>
                    <option value="1">Da</option>
                    <option value="0">Ne</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Potrdi</button>
            <a class='btn btn-danger' href='users.php'>Prekliči</a>
        </form>
    </div>
</div>
</div>
</div>