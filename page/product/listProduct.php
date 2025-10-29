<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>list Product</title>
</head>

<body>
    <?php include '../../include/nav.php'; ?>
    <?php
    require_once '../../connectData.php';
    // fetch product
    $sql = $pdo->prepare('select * from products');
    $sql->execute();
    $products = $sql->fetchAll(PDO::FETCH_ASSOC);

    // delete product
    if (isset($_GET['product_id'])) {
        require_once '../../connectData.php';
        $id = (int)$_GET['product_id'];
        $sql = $pdo->prepare('delete from users where id =?');
        $sql->execute([$id]);
        header('location:listProduct.php');
    }


    ?>



    <div class="container my-3 ">
        <h3> List Product</h3>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">prix</th>
                    <th scope="col">discount</th>
                    <th scope="col">category</th>
                    <th scope="col">date creation</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($products as $product) {
                ?>
                    <tr class="">
                        <th scope="row"><?= htmlspecialchars($product['id'] ?? '') ?></th>
                        <td><?= htmlspecialchars($product['name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($product['prix'] ?? '') ?></td>
                        <td><?= htmlspecialchars($product['discount'] ?? '') ?></td>
                        <td><?= htmlspecialchars($product['category_id'] ?? '') ?></td>
                        <td><?= htmlspecialchars($product['date_creation'] ?? '') ?></td>
                        <td>
                            <a class="btn btn-primary" href="">update</a>
                            <a class="btn btn-danger delete" href="listProduct.php?product_id=<?= $product['id'] ?>">delete</a>
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