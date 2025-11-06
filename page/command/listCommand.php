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
    $sql = $pdo->prepare('SELECT command.*,users.first_name from command inner join users on command.user_id = users.id order by command.date_creation desc');
    $sql->execute();
    $commands = $sql->fetchAll(PDO::FETCH_ASSOC);

    // delete product
    if (isset($_GET['id'])) {
        require_once '../../connectData.php';
        $id = (int)$_GET['id'];
        $sql = $pdo->prepare('delete from command where id =?');
        $sql->execute([$id]);
        header('location:listCommand.php');
    }


    ?>



    <div class="container my-3 ">
        <h3> List Command </i></h3>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">user Name</th>
                    <th scope="col">Total</th>
                    <th scope="col">Valid</th>
                    <th scope="col">date creation</th>

                    <th> </th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($commands as $command) {

                ?>
                    <tr class="">
                        <th scope="row"><?= htmlspecialchars($command['id'] ?? '') ?></th>
                        <td><?= htmlspecialchars($command['first_name'] ?? '') ?></td>
                        <td>
                            <?= htmlspecialchars($command['total'] ?? '') ?>


                        </td>
                        <td>
                            <!-- valid -->
                            <?php if ($command['valid'] == 0) : ?>

                                <a class="btn btn-success"
                                    href="update_valid.php?id=<?= htmlspecialchars($command['id'] ?? '') ?>&success=1">
                                    Command valid
                                </a>
                            <?php else: ?>
                                <a class="btn btn-danger"
                                    href="update_valid.php?id=<?= htmlspecialchars($command['id'] ?? '') ?>&success=0">
                                    Command invalid
                                </a>
                            <?php endif; ?>


                        </td>
                        <td><?= htmlspecialchars($command['date_creation'] ?? '') ?></td>

                        <td>

                            <a class="btn btn-success show"
                                href="listCommand_line.php?id=<?= $command['id'] ?>">
                                Show Detail
                            </a>
                            <!--  <a class="btn btn-success show"
                                href="listCommand.php?id=<?= $command['id'] ?>">
                                Delete
                            </a> -->
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