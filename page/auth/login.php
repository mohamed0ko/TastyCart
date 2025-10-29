<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Login</title>
</head>

<body>
    <?php include '../../include/nav.php'; ?>



    <div class="container my-3 ">

        <?php
        if (isset($_POST['Login'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            if (!empty($email) && !empty($password)) {
                require_once '../../connectData.php';
                //
                $sql = $pdo->prepare('SELECT * from users where email =? and password =?');
                $sql->execute([$email, $password]);

                if ($sql->rowCount() >= 1) {
                    $_SESSION['users'] = $sql->fetch();
                    header('location:../admin.php');
                } else {
        ?>
                    <div class="alert alert-danger my-3" role="alert">
                        Email or password invalid !
                    </div>
                <?php
                }
            } else {
                ?>
                <div class="alert alert-danger my-3" role="alert">
                    Please entre your Email or password !
                </div>
        <?php
            }
        }


        ?>
        <form method="post">
            <h3>Login</h3>
            <div class="mb-3 my-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>

            <button type="submit" class="btn btn-primary" name="Login">Login</button>
        </form>
    </div>

</body>

</html>