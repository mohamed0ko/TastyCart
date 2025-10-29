<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>admin</title>
</head>

<body>
    <?php include '../include/nav.php'; ?>



    <div class="container my-3 ">

        <?php

        if (!isset($_SESSION['users'])) {

            header('Location: login.php');
            exit;
        }
        ?>
        <h3>Hello <?php echo $_SESSION['users']['first_name'] . $_SESSION['users']['last_name'] ?></h3>

    </div>

</body>

</html>