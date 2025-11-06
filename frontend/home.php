<?php
session_start();
require_once '../connectData.php';
//fetch product
/* $sql = $pdo->prepare('select * from products');
$sql->execute();
$products = $sql->fetchAll(PDO::FETCH_ASSOC); */

$sql = $pdo->prepare('
    SELECT p.*, c.id AS category_id, c.name AS category_name
    FROM products AS p
    JOIN categories AS c ON p.category_id = c.id
');
$sql->execute();
$products = $sql->fetchAll(PDO::FETCH_ASSOC);


//fetch category
$sql = $pdo->prepare('select name,id from categories');
$sql->execute();
$category = $sql->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- font-awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <title>Home Page</title>

</head>

<body>
    <?php include '../include/nav_front.php' ?>

    <div class="container py-5">

        <div class="row g-4">

            <!-- menu -->
            <?php include '../include/menu_front.php' ?>
            <!-- menu -->



            <div class="col-lg-9">
                <div class="row g-4">
                    <?php

                    foreach ($products as $product) {
                        $idProduct = $product['id'];
                    ?>
                        <!-- Product Card 1 -->
                        <div class="col-md-4">
                            <div class="product-card shadow-sm">
                                <div class="position-relative">

                                    <img src=" ../upload/product/<?php echo $product['image'] ?>" class="product-image w-100" alt="Product">
                                    <?php
                                    if (!empty($product['discount'])) {
                                    ?>
                                        <span class="discount-badge">-<?php echo $product['discount'] ?>%</span>
                                    <?php

                                    }
                                    ?>

                                </div>
                                <div class="p-3">


                                    <span class="category-badge mb-2 d-inline-block"><?php echo $product['category_name'] ?></span>

                                    <h6 class="mb-1">
                                        <a href="detailProduct.php?id=<?php echo $idProduct ?>&Category_id=<?= $product['category_id'] ?>" class="btn">
                                            <?php echo $product['name'] ?>
                                        </a>
                                    </h6>

                                    <div class="d-flex justify-content-between align-items-center">



                                        <span class="price"><?php echo $product['prix'] ?>DH</span>

                                        <?php include '../include/qte.php' ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    if (empty($products)) {
                    ?>
                        <div class="alert alert-danger my-3 fade-out" role="alert">
                            product not found !
                        </div>
                    <?php
                    }
                    ?>





                </div>
            </div>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateQuantity(productId, change) {
            const input = event.target.parentElement.querySelector('.quantity-input');
            let value = parseInt(input.value) + change;
            if (value >= 0) {
                input.value = value;
            }
        }
    </script>
</body>

</html>