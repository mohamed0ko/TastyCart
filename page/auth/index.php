<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Food Shop</title>
</head>

<body>
    <?php include '../../include/nav.php'; ?>



    <div class="container my-3 ">

        <?php

        if (isset($_POST['add'])) {
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $email = $_POST['email'];
            $password = $_POST['password'];

            if (!empty($first_name) && !empty($password) && !empty($last_name) && !empty($email)) {

                require_once '../../connectData.php';
                $check = $pdo->prepare('select * from users where email =?');
                $check->execute([$email]);

                if ($check->rowCount() > 0) {
        ?>
                    <div class="alert alert-danger my-3" role="alert">
                        Email already exists! !
                    </div>
                <?php


                } else {
                    $data = date('Y-m-d');
                    //create user
                    $sql = $pdo->prepare('INSERT INTO users VALUES (null,?,?,?,?,?)');
                    $sql->execute([$first_name, $last_name, $email, $password, $data]);
                    header('location:login.php');
                }
            } else {


                ?>
                <div class="alert alert-danger my-3" role="alert">
                    Email or password invalid !
                </div>
        <?php
            }
        }
        ?>
        <form method="post">
            <h3>Sign up</h3>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" name="first_name" id="first_name">
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" name="last_name" id="last_name">
            </div>
            <div class="mb-3 my-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email" class="form-control" id="email" name="email">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>

            <button type="submit" class="btn btn-primary" name="add">Sign up</button>
        </form>
    </div>

</body>

</html>