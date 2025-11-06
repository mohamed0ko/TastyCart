<?php
session_start();
require_once '../connectData.php';
$id = $_GET['id'];
$sql = $pdo->prepare('select * from products where id =?');
$sql->execute([$id]);
$products = $sql->fetch(PDO::FETCH_ASSOC);


//fetch product mightLikes

/* var_dump($category_idLike);
die(); */
$category_idLike = $_GET['Category_id'];

// Join categories to get category name
$sql = $pdo->prepare('
    SELECT p.*, c.name AS category_name
    FROM products AS p
    JOIN categories AS c ON p.category_id = c.id
    WHERE p.category_id = ?
');
$sql->execute([$category_idLike]);
$mightLikes = $sql->fetchAll(PDO::FETCH_ASSOC);




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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <title>product | <?php echo $products['name'] ?></title>

</head>

<body>
    <?php include '../include/nav_front.php' ?>





    <div class="container mt-5">
        <div class="row">
            <!-- Product Images -->
            <div class="col-md-6 mb-4">
                <img src=" ../upload/product/<?php echo $products['image'] ?>" alt="Product" class="img-fluid rounded mb-3 product-image" id="mainImage">

            </div>

            <!-- Product Details -->
            <div class="col-md-6">
                <h2 class="mb-3"><?php echo $products['name'] ?></h2>

                <div class="mb-3">
                    <?php
                    if (!empty($products['discount'])) {
                        $prix = $products['prix'];
                        $discount = $products['discount'];
                        $total = $prix - (($prix * $discount) / 100);
                    ?>
                        <span class="h4 me-2"><?php echo $total ?>DH</span>
                        <span class="text-muted"><s>DH<?php echo $products['prix'] ?></s></span>
                    <?php
                    } else {
                    ?>
                        <span class="h4 me-2"><?php echo $products['prix'] ?>DH</span>
                    <?php

                    }
                    ?>

                </div>

                <p class="mb-4"><?php echo $products['description'] ?></p>

                <?php
                $idProduct = $products['id'];
                include '../include/qte.php'
                ?>

            </div>
        </div>
        <div class="col-lg-9 my-3">
            <div class="row g-4">
                <h3>Might Likes</h3>

                <?php

                foreach ($mightLikes as $mightLike) {
                    $idProduct = $mightLike['id'];

                ?>
                    <!-- Product Card 1 -->
                    <div class="col-md-4">
                        <div class="product-card shadow-sm">
                            <div class="position-relative">

                                <img src=" ../upload/product/<?php echo $mightLike['image'] ?>" class="product-image w-100" alt="Product">
                                <?php
                                if (!empty($mightLike['discount'])) {
                                ?>
                                    <span class="discount-badge">-<?php echo $mightLike['discount'] ?>%</span>
                                <?php

                                }
                                ?>

                            </div>
                            <div class="p-3">

                                <span class="category-badge mb-2 d-inline-block"><?php echo $mightLike['name'] ?></span>
                                <h6 class="mb-1"><a href="detailProduct.php?id=<?php echo $idProduct ?>" class="btn  "><?php echo $mightLike['name'] ?></a></h6>

                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="price"><?php echo $mightLike['prix'] ?>DH</span>

                                    <?php include '../include/qte.php' ?>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php
                }
                if (empty($mightLike)) {
                ?>
                    <div class="alert alert-danger my-3 fade-out" role="alert">
                        product not found !
                    </div>
                <?php
                }
                ?>



                <!-- More product cards can be added here -->

            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function changeImage(event, src) {
            document.getElementById('mainImage').src = src;
            document.querySelectorAll('.thumbnail').forEach(thumb => thumb.classList.remove('active'));
            event.target.classList.add('active');
        }

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