<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta description="The login page for *--TITLE--*.">
        <title>*--TITLE--* - Login</title>
    </head>
    <body>
        <div id="title-container">
            <h1 id="title">*--TITLE--*</h1>
        </div>
        <div id="login">
            <div id="login-title-container">
                <h2 id="login-title">Login</h2>
            </div>
            <div id="login-container">
                <form method="post" id="login">
                    <div id="form-inside">
                        <input type="text" placeholder="Username" name="username" id="username">
                        <br>
                        <input type="text" placeholder="Password" name="password" id="password">
                        <br>
                        <label id="remember-label">Remember login for 30 days?</label>
                        <input type="checkbox" name="remember" id="remember">
                        <br>
                        <button type="submit" name="submit" id="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
        try {
            include("../config.php");

            $cookie_username = $_COOKIE["login_username"];
            $cookie_password = $_COOKIE["login_password"];

            $dbh = new PDO($dsn, $db_username, $db_password, $options);
            $sql = "SELECT count(*) FROM users WHERE username = '$cookie_username' AND password = '$cookie_password'";
            $sth = $dbh->query($sql);
            $output = $sth->fetchColumn();

            if ($output == 1) {
                header("Location: ../home/");
                die();
            }

            if ($_POST) {
                $username = $_POST["username"];
                $password = $_POST["password"];

                $dbh = new PDO($dsn, $db_username, $db_password, $options);
                $sql = "SELECT count(*) FROM users WHERE username = '$username' AND password = '$password'";
                $sth = $dbh->query($sql);
                $output = $sth->fetchColumn();

                if ($output == 1) {
                    if ($_POST['remember']) {
                        setcookie("login_username", $username, time() + (60 * 60 * 24 * 30), "/");
                        setcookie("login_password", $password, time() + (60 * 60 * 24 * 30), "/");
                        header("Location: ../home/");
                    } else {
                        setcookie("login_username", $username, time() + 60, "/");
                        setcookie("login_password", $password, time() + 60, "/");
                        header("Location: ../home/");
                    }
                }

                $sth = null;
                $dbh = null;
            }
        } catch (PDOException $e) {
            die();
        }
        ?>
    </body>
</html>