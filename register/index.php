<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta description="The register page for *--TITLE--*.">
        <title>*--TITLE--* - Register</title>
    </head>
    <body>
        <div id="title-container">
            <h1 id="title">*--TITLE--*</h1>
        </div>
        <div id="register">
            <div id="register-title-container">
                <h2 id="register-title">Register</h2>
            </div>
            <div id="register-container">
                <form method="post" id="register">
                    <div id="form-inside">
                        <input type="text" placeholder="Username" name="username" id="username">
                        <br>
                        <input type="text" placeholder="Password" name="password" id="password">
                        <br>
                        <input type="text" placeholder="Re-Enter Password" name="redo_password" id="redo_password">
                        <br>
                        <input type="text" placeholder="Display Name" name="display_name" id="display_name">
                        <br>
                        <label id="remember-label">Remember login for 30 days?</label>
                        <input type="checkbox" name="remember" id="remember">
                        <br>
                        <button type="submit" name="submit">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        <?php
            try {
                if ($_POST) {
                    include('../config.php');

                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    $redo_password = $_POST['redo_password'];
                    $display_name = $_POST['display_name'];

                    if ($password != $redo_password) {
                        die("Passwords do not match");
                    }

                    $dbh = new PDO($dsn, $db_username, $db_password, $options);
                    $sql = "INSERT INTO users(username, password, display_name) VALUES (:username, :password, :display_name)";
                    $sth = $dbh->prepare($sql);
                    $sth->execute([
                        ':username' => $username,
                        ':password' => $password,
                        ':display_name' => $display_name
                    ]);

                    if ($_POST['remember']) {
                        setcookie("login_username", $username, time() + (60 * 60 * 24 * 30), "/");
                        setcookie("login_password", $password, time() + (60 * 60 * 24 * 30), "/");
                        header("Location: ../home/");
                    } else {
                        setcookie("login_username", $username, time() + 60, "/");
                        setcookie("login_password", $password, time() + 60, "/");
                        header("Location: ../home/");
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