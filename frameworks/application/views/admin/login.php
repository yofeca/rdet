<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html"; charset="UTF-8">
        <style> <?php echo '@import url("'. base_url('media/css/a/login.css').'")'; ?> </style>
        <script type="text/javascript" src="<?php echo base_url('media/js/jquery-2.0.3.js') ?>"></script>
        <title>RDET User Login</title>
    </head>
    
    <body>
        <div id="header">
            <img src="<?php echo base_url('media/image/ifsu-logo.png') ?>" />
            <div id="logo-title">
                <p id="ifsu-name">Ifugao State University</p>
                <p id="rdet-name">Research and Development, Extension and Training</p>
            </div>
        </div>
        <div id="content">
            <div id="admin-login">
            <div id="error-login">
            <?php if (isset($_GET['e'])) {
                echo "<p><strong>Login denied. Please check your username or password.</strong></p>";
            } ?>
            </div>
 
            <form action="" method="post">
                <fieldset>
                    <legend>User Login :</legend>
                    <div>
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" value="<?php if (isset($_GET['u'])) echo $_GET['u']; ?>" />
                    </div>
                    <div>
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" />
                    </div>
                    <div>
                        <input type="submit" name="submit" value="Login" id="btn-login"/>
                    </div>
                </fieldset>
            </form>

            </div>
        </div>


        <div id="footer">
            <p>&COPY; 2013 All Rights Reserved.<p>
            <p>Research and Development, Extension and Training (RDET)</p>
            <p>Ifugao State University</p>
        </div>
    </body>
</html>