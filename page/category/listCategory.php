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
    <!-- font-awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />


    <title>list Category</title>
</head>

<body>
    <?php include '../../include/nav.php'; ?>
    <?php
    require_once '../../connectData.php';
    // fetch category
    $sql = $pdo->prepare('SELECT * from categories');
    $sql->execute();
    $categories = $sql->fetchAll(PDO::FETCH_ASSOC);


    // delete category
    if (isset($_GET['category_id'])) {
        require_once '../../connectData.php';
        $id = (int)$_GET['category_id'];
        $sql = $pdo->prepare('delete from categories where id =?');
        $sql->execute([$id]);
        header('location:listCategory.php');
    }

    ?>



    <div class="container my-3 ">
        <h3> List Product </i></h3>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Icon</th>
                    <th scope="col">Description</th>
                    <th scope="col">date creation</th>

                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($categories as $category) {
                ?>
                    <tr class="">
                        <th scope="row"><?= htmlspecialchars($category['id'] ?? '') ?></th>
                        <td><?= htmlspecialchars($category['name'] ?? '') ?></td>
                        <td>
                            <i class="<?= htmlspecialchars($category['icon'] ?? '') ?>"></i>

                        </td>
                        <td><?= htmlspecialchars($category['description'] ?? '') ?></td>
                        <td><?= htmlspecialchars($category['date_creation'] ?? '') ?></td>

                        <td>
                            <a class="btn btn-primary" href="updateCategory.php?category_id=<?= $category['id'] ?>">update</a>
                            <a class="btn btn-danger delete"
                                href="listCategory.php?category_id=<?= $category['id'] ?>"
                                onclick="return confirm('Are you sure you want to delete this category?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php
                }
                ?>


            </tbody>
        </table>


    </div>

</body>

</html>