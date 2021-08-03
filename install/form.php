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
                    <h2>Installation</h2>
                    <form action="" method="post">
                        <input type="hidden" name="action" value="install_start"><br>
                        <div class="row text-left"> 
                            <div class="col-sm-12">
                                <div class="row"> 
                                    <div class="col-sm-2">
                                        <div class="form-group text-center">
                                            Create Config File: <br>
                                            <input type="hidden" name="create_config" value="false">
                                            <input type="checkbox" class="form-control" name="create_config" value="true">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group text-center">
                                            Create Database: <br>
                                            <input type="hidden" name="create_db" value="false">
                                            <input type="checkbox" class="form-control" name="create_db" value="true">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group text-center">
                                            Create Tables: <br>
                                            <input type="hidden" name="create_tables" value="false">
                                            <input type="checkbox" class="form-control" name="create_tables" value="true">
                                        </div>
                                    </div>
                                    <div class="col-sm-2 text-right border-left">
                                        <strong style="font-size: 18px;">Settings:</strong>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group text-center">
                                            Display Errors: <br>
                                            <input type="hidden" name="display_errors" value="false">
                                            <input type="checkbox" class="form-control" name="display_errors" value="true">
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group text-center">
                                            Display Page Header: <br>
                                            <input type="hidden" name="display_page_header" value="false">
                                            <input type="checkbox" class="form-control" name="display_page_header" value="true">
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </div>
                            <div class="col-sm-6"> 
                                <h4>General</h4>
                                <div class="form-group">
                                    <label>Local Root URL</label>
                                    <input type="text" class="form-control" name="url_root_local" value="http://localhost/" required>
                                </div>
                                <div class="form-group">
                                    <label>Public Root URL</label>
                                    <input type="text" class="form-control" name="url_root_public" value="http://add.some.public.address/" required>
                                </div>
                                <div class="form-group">
                                    <label>Application Name</label>
                                    <input type="text" class="form-control" name="app_name" value="mvc" required>
                                </div>
                                <div class="form-group">
                                    <label>Template</label>
                                    <input type="text" class="form-control" name="template" value="default" required>
                                </div>
                                <div class="form-group">
                                    <label>Organization</label>
                                    <input type="text" class="form-control" name="organization" value="demo" required>
                                </div>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" class="form-control" name="title" value="mvc" required>
                                </div> 
                               <div class="form-group">
                                    <label>Header Title</label>
                                    <input type="text" class="form-control" name="header_title" value="MVC - DEMO" required>
                                </div>
                            </div>
                            <div class="col-sm-6"> 
                                <h4>Database (MySql)</h4>
                                <div class="form-group">
                                    <label>DB Host</label>
                                    <input type="text" class="form-control" name="db_host" value="localhost" required>
                                </div>
                                <div class="form-group">
                                    <label>DB Username</label>
                                    <input type="text" class="form-control" name="db_username" value="root" required>
                                </div>
                                <div class="form-group">
                                    <label>DB Password</label>
                                    <input type="text" class="form-control" name="db_password" value="">
                                </div>
                                <div class="form-group">
                                    <label>DB Name</label>
                                    <input type="text" class="form-control" name="db_database" value="mvc" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Install</button>
                    </form>
                </div>
            </div>