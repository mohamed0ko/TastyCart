<?php
require_once '../connectData.php';
$id = $_GET['id'];
$sql = $pdo->prepare('select * from categories where id =?');
$sql->execute([$id]);
$categories = $sql->fetch(PDO::FETCH_ASSOC);

//fetch product

$sql = $pdo->prepare('select * from products where category_id = ?');
$sql->execute([$id]);
$products = $sql->fetchAll(PDO::FETCH_ASSOC);
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
    <title>categories | <?php echo $categories['name'] ?></title>
</head>

<body>
    <?php include '../include/nav_front.php' ?>
    <div class="container my-3 md-3 ">
        <h3><i class="<?= htmlspecialchars($categories['icon'] ?? '') ?>"></i>&nbsp;&nbsp;<?php echo $categories['name'] ?></h3>
        <div class="row">
            <?php
            foreach ($products as $product) {
            ?>
                <div class="card mb-3 col-md-4">
                    <img src="../upload/product/<?php echo $product['image'] ?>" class="card-img-top" alt="..." width="300%" height="200px">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $product['name'] ?></h5>
                        <p class="card-text"><?php echo $product['description'] ?></p>
                        <p class="card-text"><small class="text-muted"><?= date_format(date_create($product['date_creation']), 'Y/m/d') ?>
                            </small></p>
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

</body>

</html>