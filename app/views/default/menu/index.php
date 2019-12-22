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
            foreach ($data['pageMenuItems'] as $singleItem) {
                $mgTitleText = ($singleItem['parenttitle']) ? " - " . $singleItem['parenttitle'] : "<i> - brez menu skupine</i>";
                echo "<div><a href='" . URL . "menu/delete/" . $singleItem['id'] . "'><img src='" . URL . "public/default/images/del.png' width='20px' title='Briši postavko iz menuja'></a> " . $singleItem['title'] . "(<a href='" . URL . $singleItem['url'] . "'>" . $singleItem['url'] . "</a>) " . $mgTitleText . "</div>";
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
                    $mgTitleText = ($singleItem['parenttitle']) ? " - " . $singleItem['parenttitle'] : "<i> - brez menu skupine</i>";
                    echo "<div><a href='" . URL . "menu/delete/" . $singleItem['id'] . "'><img src='" . URL . "public/default/images/del.png' width='20px' title='Briši postavko iz menuja'></a> " . $singleItem['title'] . "(<a href='" . URL . $singleItem['url'] . "'>" . $singleItem['url'] . "</a>) " . $mgTitleText . "</div>";
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
            <!--                    <div class="form-group">
                                    <select name="menu-parent" class="browser-default custom-select" required>
                                        <option value="0" selected disabled>Določi starša</option>
                                        <option value="0" disabled>---------------------</option>
                                        <option value="0">Parent</option>
            <?php
//            foreach ($data['pageMenuItems'] as $singleParent) {
//                echo "<option value='" . $singleParent['id'] . "'>" . $singleParent['title'] . "</option>";
//            }
            ?>
                                    </select>
                                </div>-->
            <div class="form-group">
                <select name="menu-group" class="browser-default custom-select">
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