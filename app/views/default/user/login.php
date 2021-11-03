<div class="container">
    <div class="row">
        <div class="col-sm-12" style="text-align: center;">
            <h4>LOGIN</h4><hr>
        </div>
        <div class="col-sm-4"></div>
        <?php if (($this->session->get('lg_f') != MAX_LOGIN_ATTEMPTS) || $data['time_over']) { ?>
            <div class="col-sm-4">
                <div class="login-wrapper" style="text-align: center;">
                    <div class="login">
                        <form action="login" method="post">
                            <input type="hidden" name="login-action" value="login"><br>
                            <div class="form-group">
                                <input type="text" class="form-control" name="login-email" placeholder="e-mail" required value="<?php echo $this->tools->getPost('login-email') ?>"><br>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" name="login-password" placeholder="password" required><br>
                            </div>
                            <button type="submit" class="btn btn-primary">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div class="col-sm-4 text-center">
                <h5>Sorry, you have failed <?=MAX_LOGIN_ATTEMPTS?> attempt(s). <br><br>Please, try again later.</h5>
            </div>
        <?php } ?>
    </div>
</div>