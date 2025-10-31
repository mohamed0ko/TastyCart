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
        //edit product
        $editProduct = null;
        if (isset($_GET['product_id'])) {
            require_once '../../connectData.php';

            $id = (int)$_GET['product_id'];
            $sql = $pdo->prepare('select * from products where id =?');
            $sql->execute([$id]);
            $editProduct = $sql->fetch(PDO::FETCH_ASSOC);
        }

        // update product 

        if (isset($_POST['updateProduct'])) {
            require_once '../../connectData.php';
            $id = (int)$_POST['id'];
            $name = trim($_POST['name']);
            $prix = $_POST['prix'];
            $discount = $_POST['discount'];
            $category_id = trim($_POST['category_id']);
            $sql = $pdo->prepare('UPDATE products
                                         SET name = ?, prix = ?, discount = ?, category_id = ? 
                                         WHERE id = ?');

            $sql->execute([$name, $prix, $discount, $category_id, $id]);
            header('location:listProduct.php');
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
            <h3>Update Product</h3>

            <div class="mb-3 my-3">
                <label for="login" class="form-label">name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($editProduct['name'] ?? '') ?>">
                <input type="hidden" class="form-control" id="id" name="id" value="<?= htmlspecialchars($editProduct['id'] ?? '') ?>">

            </div>
            <div class="mb-3 my-3">
                <label for="prix" class="form-label">Prix</label>
                <input type="text" class="form-control" id="prix" name="prix" value="<?= htmlspecialchars($editProduct['prix'] ?? '') ?>">
            </div>
            <div class="mb-3 my-3">
                <label for="discount" class="form-label">Discount</label>
                <input type="text" class="form-control" id="discount" name="discount" value="<?= htmlspecialchars($editProduct['discount'] ?? '') ?>">
            </div>


            <select class="form-select mb-3" name="category_id" aria-label="Default select example">
                <option value="">Select Category</option>
                <?php if (!empty($categories)) : ?>
                    <?php foreach ($categories as $category) : ?>
                        <option
                            value="<?= htmlspecialchars($category['id']) ?>"
                            <?= (isset($editProduct['category_id']) && $editProduct['category_id'] == $category['id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['name']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>




            <button type="submit" class="btn btn-primary" name="updateProduct">Add Product</button>

        </form>
    </div>

</body>

</html>