<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Add Product</title>
</head>

<body>
    <?php include '../../include/nav.php'; ?>



    <div class="container my-3 ">


        <?php
        //create product
        if (isset($_POST['addProduct'])) {
            $name = $_POST['name'];
            $prix = $_POST['prix'];
            $discount = $_POST['discount'];
            $category_id = (int) $_POST['category_id'];
            $data = date('Y-m-d');

            if (
                !empty($name) &&
                is_numeric($prix) &&
                is_numeric($discount) &&
                !empty($category_id)
            ) {
                require_once '../../connectData.php';

                $sql = $pdo->prepare('INSERT INTO products (name, prix, discount, category_id, date_creation) VALUES (?, ?, ?, ?, ?)');
                $sql->execute([$name, $prix, $discount, $category_id, $data]);


                header("Location: " . $_SERVER['PHP_SELF'] . "?success=" . urlencode($name));
                exit;
            } else {
                header("Location: " . $_SERVER['PHP_SELF'] . "?error=1");
                exit;
            }
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
            <h3>Add Product</h3>

            <div class="mb-3 my-3">
                <label for="login" class="form-label">name</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>
            <div class="mb-3 my-3">
                <label for="prix" class="form-label">Prix</label>
                <input type="text" class="form-control" id="prix" name="prix">
            </div>
            <div class="mb-3 my-3">
                <label for="discount" class="form-label">Discount</label>
                <input type="text" class="form-control" id="discount" name="discount">
            </div>


            <select class="form-select mb-3" name="category_id" aria-label="Default select example">
                <option selected> select Category</option>
                <?php if (count($categories) > 0) : ?>
                    <?php foreach ($categories as $category) : ?>

                        <option value="<?= htmlspecialchars($category['id'] ?? '') ?>"><?= htmlspecialchars($category['name'] ?? '') ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>

            </select>



            <button type="submit" class="btn btn-primary" name="addProduct">Add Product</button>

        </form>
    </div>

</body>

</html>