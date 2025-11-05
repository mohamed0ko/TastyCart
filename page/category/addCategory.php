<?php
require_once '../auth/authCheck.php';

if (!isAdmin()) {
    header('Location: /TastyCart/page/403.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Add Category</title>
</head>

<body>
    <?php include '../../include/nav.php'; ?>


    <div class="container my-3 ">


        <?php

        if (isset($_POST['addCategory'])) {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $icon = $_POST['icon'];
            $data = date('Y-m-d');
            if (!empty($name) && !empty($description)) {
                require_once '../../connectData.php';
                $sql = $pdo->prepare('INSERT INTO categories(name,icon,description,date_creation) values (?,?,?,?)');
                $sql->execute([$name, $icon, $description, $data]);
                header("Location: " . $_SERVER['PHP_SELF'] . "?success=$name");
                exit;
            } else {

                header("Location: " . $_SERVER['PHP_SELF'] . "?error=1");
                exit;
            }
        }
        ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success my-3 fade-out" role="alert">
                Create category <?php echo htmlspecialchars($_GET['success']); ?> successfully!
            </div>
        <?php elseif (isset($_GET['error'])): ?>
            <div class="alert alert-danger my-3 fade-out" role="alert">
                Please enter name and description!
            </div>
        <?php endif; ?>

        <form method="post">
            <h3>Add Category</h3>

            <div class="mb-3 my-3">
                <label for="login" class="form-label">name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3 my-3">
                <label for="icon" class="form-label">Icon</label>
                <input type="text" class="form-control" placeholder="Enter icon class (fa fa-solid fa-list)" id="icon" name="icon">
            </div>

            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Leave a comment here" name="description" id="description"></textarea>
                <label for="description">Description</label>
            </div>

            <button type="submit" class="btn btn-primary" name="addCategory">Create Category</button>
        </form>
    </div>

</body>

</html>