<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- font-awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" />
    <title>Food Shop</title>
</head>

<body>




    <div class="container my-3 ">
        <?php
        require_once '../connectData.php';
        $sql = $pdo->prepare('select * from categories');
        $sql->execute();
        $categories = $sql->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <div class="list-group">
            <?php
            foreach ($categories as $category) {

            ?>




                <a href="categories.php?id=<?= htmlspecialchars($category['id'] ?? '') ?>" class="list-group-item list-group-item-action"> <i class="<?= htmlspecialchars($category['icon'] ?? '') ?>"></i>&nbsp;&nbsp;<?= htmlspecialchars($category['name'] ?? '') ?></a>
            <?php
            }
            ?>
        </div>

</body>

</html>