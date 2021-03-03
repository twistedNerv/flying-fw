<div class="col-sm-12 text-center">
    <h2>Users</h2><br>
</div>
<div class="col-sm-4 text-right">
    <div class="row">
        <div class="col-sm-12">
            <h4>Users list</h4>
        </div>
        <div class="col-sm-12">
            <?php
            foreach ($data['allUsers'] as $singleItem) {
                $selectedUserClass = ($data['selectedUser']->id == $singleItem['id']) ? "font-weight-bold" : "";
                echo "<div>
                        <span class='" . $selectedUserClass . "'>" . $singleItem['name'] . " " . $singleItem['surname'] . " (" . $singleItem['level'] . ")</span> | 
                        <a href='" . URL . "user/update/" . $singleItem['id'] . "' title='Edit user'><i class='far fa-edit'></i></a> | 
                        <a href='" . URL . "user/remove/" . $singleItem['id'] . "' title='Remove user'><i class='fas fa-times'></i></a>
                      </div>";
            }
            ?>
        </div>
    </div>
</div>
<?php if ($data['selectedUser']) { ?>
    <div class="col-sm-8"> 
        <?php if ($data['selectedUser']->id) { ?>
            <a href="<?= URL ?>user/update">Add user</a>
            <h4>Edit user</h4>
        <?php } else { ?>
            <h4>Add user</h4>
        <?php } ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="user-settings">
                    <form action="<?= URL ?>user/update/<?= $data['selectedUser']->id ?>" method="post">
                        <input type="hidden" name="action" value="handleuser">
                        <div class="form-group">
                            <input type="text" class="form-control" name="user-name" placeholder="Name" required value="<?php echo $data['selectedUser']->name; ?>">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control" name="user-surname" placeholder="Surname" required value="<?php echo $data['selectedUser']->surname; ?>">
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control" name="user-email" placeholder="E-mail" required value="<?php echo $data['selectedUser']->email; ?>">
                        </div>
                        <?php if (!$data['selectedUser']->id) { ?>
                            <div class="form-group">
                                <input type="password" class="form-control" name="user-password" placeholder="Password" required value="">
                            </div>
                        <?php } ?>
                        <div class="form-group">
                            <select name="user-level" class="browser-default custom-select" required>
                                <option value="1" <?php echo ($data['selectedUser']->level == 1) ? "selected" : "" ?>>User</option>
                                <option value="2" <?php echo ($data['selectedUser']->level == 2) ? "selected" : "" ?>>Submoderator</option>
                                <option value="3" <?php echo ($data['selectedUser']->level == 3) ? "selected" : "" ?>>Moderator</option>
                                <option value="4" <?php echo ($data['selectedUser']->level == 4) ? "selected" : "" ?>>Admin</option>
                                <option value="5" <?php echo ($data['selectedUser']->level == 5) ? "selected" : "" ?>>Super admin</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <select name="user-active" class="browser-default custom-select" required>
                                <option value="0" <?php echo ($data['selectedUser']->active == 0) ? "selected" : "" ?>>Not active</option>
                                <option value="1" <?php echo ($data['selectedUser']->active == 1) ? "selected" : "" ?>>Active</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a class='btn btn-danger ' href='<?= URL ?>user/update'>Cancel</a>
                    </form>
                </div>
            </div>
            <?php if ($data['selectedUser']->id) { ?>
                <div class="col-sm-12">
                    <div>
                        <br><hr>
                        <h4>
                            Group memberships
                        </h4>
                    </div>
                    <form action="<?= URL ?>membership/update/<?= $data['selectedUser']->id ?>" method="post">
                        <input type="hidden" name="action" value="handleactiongroup">
                        <div class="row">
                            <div class="col-sm-8 form-group">
                                <select name="membership-group_id" class="browser-default custom-select">
                                    <?php foreach ($data['allActiongroups'] as $singleActiongroup) { ?>
                                        <?php
                                        $singleActions = ($singleActiongroup['action'] != null) ? "action: " . $singleActiongroup['action'] . " " : "";
                                        $singleActions .= ($singleActiongroup['section'] != null) ? "section: " . $singleActiongroup['section'] . " " : "";
                                        ?>
                                        <option value="<?= $singleActiongroup['id'] ?>"><?= $singleActiongroup['name'] ?> (<?= $singleActions ?>)</option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="col-sm-4 form-group">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-3">Group</div>
                        <div class="col-sm-3">Site</div>
                        <div class="col-sm-3">Section</div>
                        <div class="col-sm-2">Function</div>
                    </div>
                </div>
                <div class="col-sm-12"><hr></div>
                <div class="col-sm-12">
                    <div class="row">
                        <?php foreach ($data['userMemberships'] as $singleUserMembership) { ?>
                            <div class="col-sm-12">
                                <div class="row">
                                    <div class="col-sm-3"><?= $singleUserMembership['name'] ?></div>
                                    <div class="col-sm-3"><?= $singleUserMembership['action'] ?></div>
                                    <div class="col-sm-3"><?= $singleUserMembership['section'] ?></div>
                                    <div class="col-sm-2">
                                        <a href='<?= URL ?>membership/remove/<?= $singleUserMembership["mid"] ?>/<?= $data["selectedUser"]->id ?>' onclick='return confirm("You really want to remove?");'>
                                            <i class='fas fa-times' title='Remove membership'></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    </div>
<?php } ?>