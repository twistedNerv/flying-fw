<div class="container">
    <div class="row">
        <div class="col-sm-12" style="text-align: center;">
            <h4>Password change for: <br><?= $data['selected_user']->name . " " . $data['selected_user']->surname ?></h4><hr>
        </div>
        <div class="col-sm-12 alert alert-danger text-center">
            <?= $data['notification'] ?>
        </div>
        <div class="col-sm-4"></div>
        <div class="col-sm-4">
            <div class="login-wrapper" style="text-align: center;">
                <div class="login">
                    <form action="<?= URL ?>user/chpass/<?= $data['selected_user']->id ?>" method="post">
                        <input type="hidden" name="action" value="handlepass"><br>
                        <div class="form-group">
                            <input type="password" class="form-control" name="old-pass" placeholder="Old password" required><br>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="new-pass" placeholder="New password" required><br>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" name="confirm-new-pass" placeholder="Confirm new password" required><br>
                        </div>
                        <button type="submit" class="btn btn-primary">Update password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>