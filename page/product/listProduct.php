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
    <title>list Product</title>
</head>

<body>
    <?php include '../../include/nav.php'; ?>
    <?php
    require_once '../../connectData.php';
    // fetch product
    $sql = $pdo->prepare('
    SELECT 
        p.id, 
        p.name, 
        p.image,
        p.prix, 
        p.discount, 
        p.date_creation, 
        c.name AS category_name
    FROM products AS p
    JOIN categories AS c ON p.category_id = c.id
');
    $sql->execute();
    $products = $sql->fetchAll(PDO::FETCH_ASSOC);


    // delete product
    if (isset($_GET['product_id'])) {
        require_once '../../connectData.php';
        $id = (int)$_GET['product_id'];
        $sql = $pdo->prepare('delete from products where id =?');
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
                    <th scope="col">image</th>
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
                        <td>
                            <img
                                src="../../upload/product/<?php echo $product['image']  ?>"
                                class="card-img-top"
                                alt="<?php htmlspecialchars($product['name']) ?>"
                                style="width: 150px; height: 85px; object-fit: cover;">
                        </td>
                        <td><?= htmlspecialchars($product['prix'] ?? '') ?></td>
                        <td><?= htmlspecialchars($product['discount'] ?? '') ?></td>
                        <td><?= htmlspecialchars($product['category_name'] ?? '') ?></td>
                        <td><?= htmlspecialchars($product['date_creation'] ?? '') ?></td>
                        <td>
                            <a class="btn btn-primary" href="updateProduct.php?product_id=<?= $product['id'] ?>">update</a>
                            <a class="btn btn-danger delete"
                                href="listProduct.php?product_id=<?= $product['id'] ?>"
                                onclick="return confirm('Are you sure you want to delete this product?');">
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