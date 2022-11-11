<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta description="The homepage of *--TITLE--*">
        <title>*--TITLE--* - Home</title>
    </head>
    <body>
        <!-- TEMPORARY FOR LOGIN VERIFICATION AND LOGOUT -->
        <h1>Home</h1>
        <h2>Logged in</h2>
        <h3>Username: <?php echo $_COOKIE["login_username"]; ?></h3>
        <h3>Password: <?php echo $_COOKIE["login_password"]; ?></h3>
        <form action="logout/" method="post">
            <button method="logout/" type="submit" name="submit">Logout</button>
        </form>

        <?php
        try {
            include("../config.php");

            $cookie_username = $_COOKIE["login_username"];
            $cookie_password = $_COOKIE["login_password"];

            $dbh = new PDO($dsn, $db_username, $db_password, $options);
            $sql = "SELECT count(*) FROM users WHERE username = '$cookie_username' AND password = '$cookie_password'";
            $sth = $dbh->query($sql);
            $output = $sth->fetchColumn();

            if (!$output == 1) {
                header("Location: ../");
                die();
            }
        } catch (PDOException $e) {
            die();
        }
        ?>
    </body>
</html>