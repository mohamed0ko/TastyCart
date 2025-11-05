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


    <title>list Command</title>
</head>

<body>
    <?php include '../../include/nav.php'; ?>
    <?php
    require_once '../../connectData.php';
    // fetch command
    $id = $_GET['id'];
    $sql = $pdo->prepare('SELECT command_line.*,products.name,products.image 
                                 from command_line inner join products 
                                 on command_line.product_id = products.id 
                                 where command_id=? ');
    $sql->execute([$id]);
    $command_line = $sql->fetchAll(PDO::FETCH_ASSOC);




    ?>



    <div class="container my-3 ">
        <h3> List Product </i></h3>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name Product</th>
                    <th scope="col">Product Image</th>
                    <th scope="col">Command id</th>
                    <th scope="col">Prix</th>
                    <th scope="col">Quantity</th>
                    <th scope="col">Total</th>

                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($command_line as $line) {

                ?>
                    <tr class="">
                        <th scope="row"><?= htmlspecialchars($line['id'] ?? '') ?></th>
                        <td><?= htmlspecialchars($line['name'] ?? '') ?></td>
                        <td> <img
                                src="../../upload/product/<?= htmlspecialchars($line['image'] ?? '') ?>"
                                class="card-img-top"
                                alt="<?php echo htmlspecialchars($line['name']); ?>"
                                style="width: 150px; height: 85px; object-fit: cover;">
                        </td>
                        <td>
                            <?= htmlspecialchars($line['command_id'] ?? '') ?>

                        </td>
                        <td><?= htmlspecialchars($line['prix'] ?? '') ?></td>
                        <td><?= htmlspecialchars($line['quantity'] ?? '') ?></td>
                        <td><?= htmlspecialchars($line['total'] ?? '') ?></td>
                        <td> <a class="btn btn-success show"
                                href="listCommand.php?>">
                                Show Detail
                            </a></td>


                    </tr>
                <?php
                }
                ?>


            </tbody>
        </table>


    </div>

</body>

</html>