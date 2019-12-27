<div class="col-sm-12 text-center">
    <h2>Urejanje skrbnikov</h2><br>
</div>
<div class="col-sm-4 text-right">
    <div class="row">
        <div class="col-sm-12">
            <h4>Izberi skrbnika</h4>
        </div>
        <div class="col-sm-12">
            <?php
            foreach ($data['allUsers'] as $singleItem) {
                echo "<div>
                        <a href='" . URL . "user/update/" . $singleItem['id'] . "'>" . $singleItem['email'] . "</a>
                        <a href='" . URL . "user/remove/" . $singleItem['id'] . "'><img src='" . URL . "public/default/images/del.png' width='20px' title='Briši skrbnika'></a>
                      </div>";
            }
            ?>
        </div>
    </div>
</div>
<?php if ($data['selectedUser']) { ?>
<div class="col-sm-8"> 
    <?php if ($data['selectedUser']->id) { ?>
        <a href="<?= URL ?>user/update">Dodaj uporabnika</a>
        <h4>Uredi uporabnika</h4>
    <?php } else { ?>
        <h4>Dodaj uporabnika</h4>
    <?php } ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="user-settings">
                <form action="<?= URL ?>user/update/<?= $data['selectedUser']->id ?>" method="post">
                    <input type="hidden" name="action" value="handleuser">
                    <?php 
                        $this->template->elements->formInputText('text', 'user-name', $data['selectedUser']->name, 'ime', 'required');
                        $this->template->elements->formInputText('text', 'user-surname', $data['selectedUser']->surname, 'priimek', 'required');
                        $this->template->elements->formInputText('email', 'user-email', $data['selectedUser']->email, 'elektronski naslov', 'required');
                        if(!$data['selectedUser']->id) { 
                            $this->template->elements->formInputText('password', 'user-password', '', 'geslo', 'required');
                        }
                    ?>
                    <div class="form-group">
                        <select name="user-level" class="browser-default custom-select" required>
                            <option value="1" <?php echo ($data['selectedUser']->level == 1) ? "selected" : "" ?>>Uporabnik</option>
                            <option value="2" <?php echo ($data['selectedUser']->level == 2) ? "selected" : "" ?>>Skrbnik</option>
                            <option value="3" <?php echo ($data['selectedUser']->level == 3) ? "selected" : "" ?>>Moderator</option>
                            <option value="4" <?php echo ($data['selectedUser']->level == 4) ? "selected" : "" ?>>Admin</option>
                            <option value="5" <?php echo ($data['selectedUser']->level == 5) ? "selected" : "" ?>>Super admin</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <select name="user-active" class="browser-default custom-select" required>
                            <option value="0" <?php echo ($data['selectedUser']->active == 0) ? "selected" : "" ?>>Neaktiven</option>
                            <option value="1" <?php echo ($data['selectedUser']->active == 1) ? "selected" : "" ?>>Aktiven</option>
                        </select>
                    </div>
                    <?php 
                        $this->template->elements->submitButton('', 'primary', 'Potrdi');
                    ?>
                    <a class='btn btn-danger' href='<?= URL ?>user/update'>Prekliči</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php } ?>