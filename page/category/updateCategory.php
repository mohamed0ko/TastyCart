<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Update Product</title>
</head>

<body>
    <?php include '../../include/nav.php'; ?>



    <div class="container my-3 ">


        <?php
        //edit category
        $editCategory = null;
        if (isset($_GET['category_id'])) {
            require_once '../../connectData.php';

            $id = (int)$_GET['category_id'];
            $sql = $pdo->prepare('select * from categories where id =?');
            $sql->execute([$id]);
            $editCategory = $sql->fetch(PDO::FETCH_ASSOC);
        }

        // update category 

        if (isset($_POST['updateCategory'])) {
            require_once '../../connectData.php';
            $id = (int)$_POST['id'];
            $name = trim($_POST['name']);
            $icon = $_POST['icon'];
            $description = trim($_POST['description']);

            $sql = $pdo->prepare('UPDATE categories
                                         SET name = ?,icon=?,description = ?
                                         WHERE id = ?');

            $sql->execute([$name,  $icon, $description, $id]);
            header('location:listCategory.php');
            exit;
        }


        // fetch categories
        require_once '../../connectData.php';
        $sql = $pdo->prepare('SELECT id, name FROM categories');
        $sql->execute();
        $categories = $sql->fetchAll(PDO::FETCH_ASSOC);

        ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success my-3 fade-out" role="alert">
                Create category <?php echo htmlspecialchars($_GET['success']); ?> successfully!
            </div>
        <?php elseif (isset($_GET['error'])):  ?>
            <div class="alert alert-danger my-3 fade-out" role="alert">
                Data invalid !
            </div>
        <?php endif; ?>

        <form method="post">
            <h3>Update Category</h3>

            <div class="mb-3 my-3">
                <label for="login" class="form-label">name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($editCategory['name'] ?? '') ?>">
                <input type="hidden" class="form-control" id="id" name="id" value="<?= htmlspecialchars($editCategory['id'] ?? '') ?>">

            </div>
            <div class="mb-3 my-3">
                <label for="icon" class="form-label">Icon</label>
                <input type="text" class="form-control" placeholder="Enter icon class (fa fa-solid fa-list)" id="icon" name="icon"
                    value="<?= htmlspecialchars($editCategory['icon'] ?? '') ?>">
            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control"
                    placeholder="Leave a comment here"
                    name="description"
                    id="description"><?= htmlspecialchars($editCategory['description'] ?? '') ?></textarea>
                <label for="description">Description</label>
            </div>



            <button type="submit" class="btn btn-primary" name="updateCategory">Update Product</button>

        </form>
    </div>

</body>

</html>