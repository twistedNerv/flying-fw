<!doctype html>
<html>
    <head>
        <title>Installer</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <link rel='stylesheet' href='../public/default/css/jquery-ui.css'>
        <link rel='stylesheet' href='../public/default/custom/bootstrap-4.3.1/css/bootstrap.min.css'>
        <link rel='stylesheet' href='../public/default/custom/fontawesome-free-5.12.0-web/css/all.css'>
        <link rel='stylesheet' href='../public/default/css/fonts/fonts.css'>
        <link rel='stylesheet' href='../public/default/css/default.css'>
        <link rel="shortcut icon" href="../public/default/images/faviconukc.ico" type="image/x-icon" />
    </head>
    <body>
        <div class="col-sm-2"></div>
        <div class="container col-sm-8">
            <div id="content" class="content row text-center">
                <div class="col-sm-12"> 
                    <div class="col-sm-12"> 
                        <div class="row"> 
                            <div class="col-sm-2"><a href="../" title="Go home"><i class="fas fa-home settings-home"></i></a></div>
                            <div class="col-sm-8 text-center"><h2>Settings</h2></div>
                            <div class="col-sm-2"></div>
                        </div>
                    </div>
                    <form action="" method="post">
                        <input type="hidden" name="action" value="install_start"><br>
                        <div class="row text-left"> 
                            <div class="col-sm-12 filter-bg">
                                <div class="row"> 
                                    <div class="col-sm-6 text-center">
                                        <div class="row"> 
                                            <h4>What to (re)create</h4>
                                            <div class="col-sm-2">
                                                <div class="form-group text-center">
                                                    Create Config File <br>
                                                    <input type="hidden" name="create_config" value="false">
                                                    <input type="checkbox" class="form-control" name="create_config" value="true" checked>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group text-center">
                                                    Create Database <br>
                                                    <input type="hidden" name="create_db" value="false">
                                                    <input type="checkbox" class="form-control" name="create_db" value="true">
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group text-center">
                                                    Create Tables <br>
                                                    <input type="hidden" name="create_tables" value="false">
                                                    <input type="checkbox" class="form-control" name="create_tables" value="true">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 text-center border-left">
                                        <div class="row">
                                            <h4>Flags</h4>
                                            <div class="col-sm-2">
                                                <div class="form-group text-center ">
                                                    Display errors: <br>
                                                    <input type="hidden" name="display_errors" value="false">
                                                    <input type="checkbox" class="form-control" name="display_errors" value="true" <?= ($mainSettings['DISPLAY_ERRORS']) ? "checked" : "" ?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <div class="form-group text-center">
                                                    Display header <br>
                                                    <input type="hidden" name="display_page_header" value="false">
                                                    <input type="checkbox" class="form-control" name="display_page_header" value="true" <?= ($mainSettings['DISPLAY_PAGE_HEADER']) ? "checked" : "" ?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-2 text-right">
                                                <div class="form-group text-center">
                                                    Limit login attempts <br>
                                                    <input type="hidden" name="limit_login_attempts" value="false">
                                                    <input type="checkbox" class="form-control" name="limit_login_attempts" value="true" <?= ($mainSettings['LIMIT_LOGIN_ATTEMPTS']) ? "checked" : "" ?>>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 text-right <?= ($mainSettings['PUBLIC_SETTINGS']) ? 'alert-podium' : '' ?>">
                                                <div class="form-group text-center">
                                                    Public access to settings<br>
                                                    <input type="hidden" name="public_settings" value="false">
                                                    <input type="checkbox" class="form-control" name="public_settings" value="true" <?= ($mainSettings['PUBLIC_SETTINGS']) ? "checked" : "" ?>>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6"> 
                                <h4>General</h4>
                                <div class="form-group">
                                    <label>Local Root URL</label>
                                    <input type="text" class="form-control" name="url_root_local" value="<?= $mainSettings['URL_ROOT_LOCAL'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Public Root URL</label>
                                    <input type="text" class="form-control" name="url_root_public" value="<?= $mainSettings['URL_ROOT_PUBLIC'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Application Name</label>
                                    <input type="text" class="form-control" name="app_name" value="<?= $mainSettings['APP_NAME'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Template</label>
                                    <input type="text" class="form-control" name="template" value="<?= $mainSettings['TEMPLATE'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Organization</label>
                                    <input type="text" class="form-control" name="organization" value="<?= $mainSettings['ORGANIZATION'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title" value="<?= $mainSettings['TITLE'] ?>" required>
                                </div> 
                                <div class="form-group">
                                    <label>Header Title</label>
                                    <input type="text" class="form-control" name="header_title" value="<?= $mainSettings['HEADER_TITLE'] ?>" required>
                                </div>
                            </div>
                            <div class="col-sm-6"> 
                                <h4>Database (MySql)</h4>
                                <div class="form-group">
                                    <label>DB Host</label>
                                    <input type="text" class="form-control" name="db_host" value="<?= $mainSettings['DB_HOST'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>DB Username</label>
                                    <input type="text" class="form-control" name="db_username" value="<?= $mainSettings['DB_USERNAME'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>DB Password</label>
                                    <input type="text" class="form-control" name="db_password" value="<?= $mainSettings['DB_PASSWORD'] ?>">
                                </div>
                                <div class="form-group">
                                    <label>DB Name</label>
                                    <input type="text" class="form-control" name="db_database" value="<?= $mainSettings['DB_DATABASE'] ?>" required>
                                </div>
                                <h4>Login attempts</h4>
                                <div class="form-group">
                                    <label>Max failed login attempts</label>
                                    <input type="text" class="form-control" name="max_login_attempts" value="<?= $mainSettings['MAX_LOGIN_ATTEMPTS'] ?>" required>
                                </div>
                                <div class="form-group">
                                    <label>Login penalty duration (seconds)</label>
                                    <input type="text" class="form-control" name="login_penalty_duration" value="<?= $mainSettings['LOGIN_PENALTY_DURATION'] ?>" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="../" class="btn btn-danger">Cancel</a>
                        <br><br>
                    </form>
                </div>
            </div>