<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta description="
            *--TITLE--* is the perfect place to create, share and remix!
            Then browse the all the content made by others!
        ">
        <title>*--TITLE--*</title>
    </head>
    <body>
        <a href="login">Login</a>
        <a href="register">Register</a>
    </body>

    <?php
        try {
            include("config.php");

            $cookie_username = $_COOKIE["login_username"];
            $cookie_password = $_COOKIE["login_password"];

            $dbh = new PDO($dsn, $db_username, $db_password, $options);
            $sql = "SELECT count(*) FROM users WHERE username = '$cookie_username' AND password = '$cookie_password'";
            $sth = $dbh->query($sql);
            $output = $sth->fetchColumn();

            if ($output == 1) {
                header("Location: home/");
                die();
            }
        } catch (PDOException $e) {
            die();
        }
    ?>
</html>