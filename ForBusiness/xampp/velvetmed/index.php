<!DOCTYPE html>
<html lang="pt">
    <head>
        <?php include("header.php"); ?>
    </head>
    <?php
    if (!empty($_SESSION['user'])) {
        header("Location: home.php");
        die("Redirecting to home.php");
    }
    ?>
    <style>
        body {
            <?php if ($glob_IndexBG <> "") { ?>
                background-image: url(<?php echo $glob_IndexBG; ?>);
                background-position: center center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-size: cover;
                background-color: #464646;
                background-size: cover;
            <?php } ?>
        }
        .Absolute-Center {
            margin: auto;
            position: absolute;
            top: 0; left: 0; bottom: 0; right: 0;
        }

        .Absolute-Center.is-Responsive {
            width: 50%; 
            height: 50%;
            min-width: 200px;
            max-width: 400px;
            padding: 40px;
        }
    </style>
    <body>
        <div class="Absolute-Center is-Responsive">
            <div class="col-sm-12 col-md-10 col-md-offset-1">
                <form action="login.php" method="post">
                    <center>
                        <?php if ($show_NomeApp_index) { ?>
                            <h1 class="form-signin-heading" style='color:white'><?php echo $glob_NomeApp; ?></h1><br>
                        <?php } ?>
                        <?php if ($show_LogoApp_index) { ?>
                            <img src="<?php echo $glob_LogoApp; ?>" /><br><br>
                        <?php } ?>
                        <div class="form-group input-group">
                            <input type="text" name="username" class="form-control" style="width:100%; padding-right:0; padding-left:0;" placeholder="UTILIZADOR" required="" autofocus="" value="<?php echo isset($submitted_username) ? $submitted_username : ''; ?>" /><br>
                        </div>
                        <input type="password" name="password" value="" class="form-control" style="width:100%; padding-right:0; padding-left:0;" placeholder="SENHA" required="" /><br>
                        <div class="form-group">
                            <button class="btn btn-lg btn-primary btn-block" style="width:100%;" type="submit">ENTRAR</button>
                        </div>
                    </center>
                </form>
            </div>
        </div>
        <div class="clearfix"></div>

        <!-- start: JavaScript-->
        <?php include("footer_code.php"); ?>
        <!-- end: JavaScript-->
    </body>
</html>
