<?php
session_start();
require_once '../connectData.php';
$id = $_GET['id'];
$sql = $pdo->prepare('select * from products where id =?');
$sql->execute([$id]);
$products = $sql->fetch(PDO::FETCH_ASSOC);



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
                        <span class="h4 me-2">$<?php echo $total ?></span>
                        <span class="text-muted"><s>$<?php echo $products['prix'] ?></s></span>
                    <?php
                    } else {
                    ?>
                        <span class="h4 me-2">$<?php echo $products['prix'] ?></span>
                    <?php

                    }
                    ?>

                </div>

                <p class="mb-4"><?php echo $products['description'] ?></p>
                <div class="mb-4">
                    <h5>Color:</h5>
                    <div class="btn-group" role="group" aria-label="Color selection">
                        <input type="radio" class="btn-check" name="color" id="black" autocomplete="off" checked>
                        <label class="btn btn-outline-dark" for="black">Black</label>
                        <input type="radio" class="btn-check" name="color" id="silver" autocomplete="off">
                        <label class="btn btn-outline-secondary" for="silver">Silver</label>
                        <input type="radio" class="btn-check" name="color" id="blue" autocomplete="off">
                        <label class="btn btn-outline-primary" for="blue">Blue</label>
                    </div>
                </div>
                <?php
                $idProduct = $products['id'];
                include '../include/qte.php'
                ?>

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
            const input = document.getElementById('qte');
            let value = parseInt(input.value) + change;


            if (value < 0) value = 0;
            if (value > 99) value = 99;

            input.value = value;
        }
    </script>






</body>

</html>