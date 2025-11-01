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
            $description = trim($_POST['description']);
            $prix = $_POST['prix'];
            $discount = $_POST['discount'];
            $category_id = trim($_POST['category_id']);

            // Default image name
            $filename = '';
            if (!empty($_FILES['image']['name'])) {
                $image = $_FILES['image']['name'];
                $filename = uniqid() . '_' . basename($image);
                $destination = __DIR__ . '/../../upload/product/' . $filename;
                move_uploaded_file($_FILES['image']['tmp_name'], $destination);
            }
            if (!empty($name) && !empty($description) && !empty($prix)) {
                // Check if a new image was uploaded
                if (!empty($filename)) {
                    // Update including image
                    $sql = $pdo->prepare('UPDATE products
                              SET name = ?, description = ?, prix = ?, discount = ?, image = ?, category_id = ?
                              WHERE id = ?');
                    $sql->execute([$name, $description, $prix, $discount, $filename, $category_id, $id]);
                } else {
                    // Update without changing image
                    $sql = $pdo->prepare('UPDATE products
                              SET name = ?, description = ?, prix = ?, discount = ?, category_id = ?
                              WHERE id = ?');
                    $sql->execute([$name, $description, $prix, $discount, $category_id, $id]);
                }
            }

            header('Location: listProduct.php');
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

        <form method="post" enctype="multipart/form-data">
            <h3>Update Product</h3>

            <div class="mb-3 my-3">
                <label for="login" class="form-label">name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($editProduct['name'] ?? '') ?>">
                <input type="hidden" class="form-control" id="id" name="id" value="<?= htmlspecialchars($editProduct['id'] ?? '') ?>">

            </div>
            <div class="form-floating mb-3">
                <textarea class="form-control" placeholder="Leave a comment here" name="description" id="description"><?= htmlspecialchars($editProduct['description'] ?? '') ?></textarea>
                <label for="description">Description</label>
            </div>
            <div class="mb-3 my-3">
                <label for="prix" class="form-label">Prix</label>
                <input type="text" class="form-control" id="prix" name="prix" value="<?= htmlspecialchars($editProduct['prix'] ?? '') ?>">
            </div>
            <label class="form-label">Discount:
                <span id="discountValue">
                    <?= isset($editProduct['discount']) ? $editProduct['discount'] : 0 ?>%
                </span>
            </label>


            <div class="mb-3 my-3">
                <input
                    type="range"
                    class="form-range"
                    name="discount"
                    id="discount"
                    min="0"
                    max="90"
                    value="<?= isset($editProduct['discount']) ? $editProduct['discount'] : 0 ?>"
                    oninput="document.getElementById('discountValue').textContent = this.value + '%';">

            </div>
            <div class="mb-3 my-3">
                <label for="image" class="form-label">Image</label>
                <input class="form-control" type="file" id="image" name="image" value="<?= htmlspecialchars($editProduct['image'] ?? '') ?>">
            </div>
            <img
                src="../../upload/product/<?php echo htmlspecialchars($editProduct['image']); ?>"
                class="card-img-top"
                alt="<?php echo htmlspecialchars($editProduct['name']); ?>"
                style="width: 300px; height: 200px; object-fit: cover;">




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




            <button type="submit" class="btn btn-primary" name="updateProduct">update Product</button>

        </form>
    </div>

</body>

</html>