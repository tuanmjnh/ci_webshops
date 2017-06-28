<!DOCTYPE HTML>
<html>
    <head>
        <title><?= $heading_title ?></title>
        <link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- icon page -->
        <?= isset($icon) ? $icon : '' ?>
        <!-- Core CSS - Include with every page -->
        <?= isset($css) ? implode($css) : '' ?>
        <!-- Core Scripts - Include with every page -->
        <?= isset($js) ? implode($js) : '' ?>
    </head>

    <?php
    //print_r(TMINI::get_be_ini('login/login', 'vi-vn'));
    ?>
    <!-- contact-form -->	
    <div class="message warning">
        <div class="inset">
            <div class="login-head">
                <h1><?= $text_heading ?></h1>
            </div>
            <form action="<?= $router_login ?>" method="POST" id="login-form" enctype="multipart/form-data">
                <div class="TMAlert">
                    <?php if ($success) { ?>
                        <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?= $success; ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php } ?>
                    <?php if ($error_warning) { ?>
                        <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?= $error_warning; ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php } ?>
                </div>
                <div id="p-account">
                    <li>
                        <label for="username" class="glyphicon glyphicon-user"></label>
                        <input type="text" id="username" name="username" class="text" placeholder="<?= $entry_username ?>">
                    </li>
                    <label id="account-error" class="error" for="username"></label>
                </div>
                <div class="clear"></div>
                <div id="p-password">
                    <li>
                        <label for="password" class="glyphicon glyphicon-lock"></label>
                        <input type="password" id="password" name="password" placeholder="<?= $entry_password ?>">
                    </li>
                    <label id="password-error" class="error" for="password"></label>
                </div>
                <div class="clear"></div>
                <div class="remember">
                    <label><input type="checkbox" name="remember"><?= $checkbox_remember ?></label>
                    <a href="#"><?= $text_forgot ?></a>
                </div>
                <div class="clear"></div>
                <button id="login-submit" class="submit btn"><?= $button_login ?></button>
            </form>
        </div>
    </div>
    <div class="clear"></div>
    <!--- footer --->
    <div class="footer">
        <p> <a href="<?= TM_BASE_URL . 'cms' ?>">Webshop</a></p>
    </div>

</html>